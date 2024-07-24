<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function makeCurrentUserAdmin()
    {
        $user = Auth::user();

        // Check if the user is already an admin
        if ($user->is_admin) {
            return response()->json(['message' => 'User is already an admin'], 400);
        }

        // Make the user an admin
        $user->makeAdmin();
        return response()->json(['message' => 'User is now an admin'], 200);
    }



}
