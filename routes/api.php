<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\V1\ArticleController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'registerUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\API\V1',
    'middleware' => 'auth:sanctum',
], function () {
    Route::apiResource('articles', ArticleController::class)
        ->missing(function (Request $request) {
            return [
                'status' => false,
                'message' => __('errors.article_not_found'),
            ];
        });
});
