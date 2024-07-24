<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function vote(Request $request, Website $website) {
        $vote = $website->votes()->firstOrCreate(['user_id' => $request->user()->id]);

        return response()->json(['message' => 'Voted'], 201);
    }

    public function unvote(Request $request, Website $website) {
        $website->votes()->where('user_id', $request->user()->id)->delete();

        return response()->json(['message' => 'Unvoted'], 200);
    }
}
