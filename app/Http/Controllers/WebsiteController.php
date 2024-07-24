<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Validator;
class WebsiteController extends Controller
{
    /**
     * Display a listing of the websites grouped by categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // Set the pagination limit
        $limit = $request->query('limit', 10);

        // Retrieve websites with their related categories and vote counts
        $websites = Website::with(['categories', 'votes'])->paginate($limit);

        // Group websites by category names
        $groupedWebsites = $websites->flatMap(function ($website) {
            return collect($website->category_names)->map(function ($category) use ($website) {
                return ['category' => $category, 'website' => $website];
            });
        })->groupBy('category');

        // Transform the data to the desired format
        $response = $groupedWebsites->map(function ($items, $categoryName) {
            return [
                'name' => $categoryName,
                'websites' => $items->pluck('website')->map(function ($website) {
                    return [
                        'id' => $website->id,
                        'name' => $website->name,
                        'url' => $website->url,
                        'vote_count' => $website->vote_count,
                    ];
                })->unique('id')->values()
            ];
        })->values();

        return response()->json([
            'categories' => $response,
            'pagination' => [
                'total' => $websites->total(),
                'per_page' => $websites->perPage(),
                'current_page' => $websites->currentPage(),
                'last_page' => $websites->lastPage(),
            ]
        ]);
    }

    /**
     * Search for websites by term and optionally filter by category.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'term' => 'required|string|max:255',
            'category' => 'nullable|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Set the pagination limit
        $limit = $request->query('limit', 10);

        // Start building the query for websites
        $query = Website::query();

        // Add search term condition
        $query->where('name', 'like', '%' . $request->term . '%')
              ->orWhere('url', 'like', '%' . $request->term . '%');

        // Optionally filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Retrieve the results with related categories
        $websites = $query->with('categories')->paginate($limit);

        // Check if any results were found
        if ($websites->isEmpty()) {
            return response()->json(['message' => 'No websites found for the given search term.'], 404);
        }

        return response()->json([
            'websites' => $websites->items(),
            'pagination' => [
                'total' => $websites->total(),
                'per_page' => $websites->perPage(),
                'current_page' => $websites->currentPage(),
                'last_page' => $websites->lastPage(),
            ]
        ]);
    }

    /**
     * Store a newly created website in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255|unique:websites,url',
            'categories' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the website
        $website = Website::create($request->only('name', 'url'));
        $website->categories()->attach($request->categories);
        $website->load('categories:name');

        return response()->json($website, 201);
    }

    /**
     * Remove the specified website from storage.
     *
     * @param Website $website
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Website $website)
    {
        try {
            // Detach the categories first
            $website->categories()->detach();

            // Then delete the website
            $website->delete();

            return response()->json(['message' => 'Website deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete website', 'error' => $e->getMessage()], 500);
        }
    }
}
