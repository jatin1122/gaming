<?php

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

Route::middleware('auth:api')->namespace('API')->group(function () {
    Route::get('/user', 'UserController@getCurrentUser');
    Route::get('/users/{id}', 'UserController@getUser');

    Route::get('/games/{id}/user', 'GamesController@getCurrentUser');
    Route::get('/games/{id}/users/{userId}', 'GamesController@getUser');
    Route::get('/games/{id}', 'GamesController@getGame');
    Route::post('/games/{id}/instances', 'GamesController@createGameInstance');

    Route::post('/games/{id}/instances/{gameInstanceId}', 'GamesController@updateInstance');
});