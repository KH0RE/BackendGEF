<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup',  [AuthController::class, 'signup']);

    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', [AuthController::class, 'logout'] );
        Route::get('user', [AuthController::class, 'user']);


        //-------------------------<>---------------------------

        /* CRUD TABLE PROFILE */
        Route::get('pro', [ProfileController::class, 'index']);
        Route::get('pros', [ProfileController::class, 'index2']);
        Route::get('pro/{id}', [ProfileController::class, 'show']);
        Route::post('pro', [ProfileController::class, 'store']);
        Route::put('pro/{id}', [ProfileController::class, 'update']);
        Route::delete('pro/{id}', [ProfileController::class, 'destroy']);
        /* CRUD TABLE PROFILE */

        //-------------------------<>---------------------------

        /* CRUD TABLE POST */

        Route::get('post', [PostController::class, 'index']);
        Route::get('posts', [PostController::class, 'index2']);
        Route::get('post/{id}', [PostController::class, 'show']);
        Route::post('post', [PostController::class, 'store']);
        Route::put('post/{id}', [PostController::class, 'update']);
        Route::delete('post/{id}',[PostController::class, 'destroy']);

        /* CRUD TABLE POST */
    });
});
