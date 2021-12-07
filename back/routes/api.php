<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
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

//-------------User Public Route ---------------------------
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::delete('users/{id}', [UserController::class, 'destroy']);


Route::post('logout', [UserController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/category',[CategoryController::class, "index"]);
Route::get('/category/{id}',[CategoryController::class, "show"]);
Route::post('/category',[CategoryController::class, "store"]);
Route::put('/category/{id}',[CategoryController::class, "update"]);
Route::delete('/category/{id}',[CategoryController::class, "destroy"]);
Route::get('/category/search/{name}',[CategoryController::class, "search"]);
