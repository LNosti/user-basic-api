<?php

use App\Infrastructure\Controllers\UserController;
use App\Infrastructure\Controllers\UsersListController;
use App\Infrastructure\Controllers\StatusController;
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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get(
    '/status',
    StatusController::class
);

Route::get('users/list', UsersListController::class);
Route::get('users/{userId}', UserController::class);

