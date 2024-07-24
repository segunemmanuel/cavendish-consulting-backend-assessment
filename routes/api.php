<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('websites', [WebsiteController::class, 'store']);
    Route::post('websites/{website}/vote', [VoteController::class, 'vote']);
    Route::delete('websites/{website}/vote', [VoteController::class, 'unvote']);
    Route::post('/make-admin', [AdminController::class, 'makeCurrentUserAdmin']);
    Route::delete('/websites/{website}', [WebsiteController::class, 'destroy'])->middleware('admin');
});

Route::get('websites', [WebsiteController::class, 'index']);
Route::get('websites/search', [WebsiteController::class, 'search']);
