<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MyEventController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\JoinController;
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

// My Event Route

Route::get('/category',[CategoryController::class, "index"]);
Route::get('/category/{id}',[CategoryController::class, "show"]);
Route::post('/category',[CategoryController::class, "store"]);
Route::put('/category/{id}',[CategoryController::class, "update"]);
Route::delete('/category/{id}',[CategoryController::class, "destroy"]);
Route::get('/category/search/{name}',[CategoryController::class, "search"]);

// MYEVETN ROUTE==================================================================================================
Route::get('/myevent',[MyEventController::class, "getEvent"]);
Route::get('/myevent/{id}',[MyEventController::class, "getOneEvent"]);
Route::post('/myevent',[MyEventController::class, "createEvent"]);
Route::put('/myevent/{id}',[MyEventController::class, "updateEvent"]);
Route::delete('/myevent/{id}',[MyEventController::class, "destroyEvent"]);

Route::get('/myevent/search/{title}',[MyEventController::class, "search"]);
Route::get('/myevent/searchCity/{city}',[MyEventController::class, "searchCity"]);

  
// Get Country Route

Route::get('/countries', [CountryController::class, 'getCountries']);

Route::get('/cities', [CityController::class, 'getCities']);


// JOIN ROUTE

Route::get('/join', [JoinController::class, 'index']);
Route::post('/join', [JoinController::class, 'store']);
Route::delete('/join/{id}', [JoinController::class, 'destroy']);


