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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'catqueues', 'namespace' => '\App\Http\Controllers'], function () {
    Route::get('/', 'CatQueuesController@allCatQueues');
    Route::get('/{id}', 'CatQueuesController@getByIdCatQueues');
    Route::post('/', 'CatQueuesController@insertCatQueues');
    Route::put('/{id}', 'CatQueuesController@updateCatQueues');
    Route::delete('/{id}', 'CatQueuesController@deleteCatQueues');
});

Route::group(['prefix' => 'turn', 'namespace' => '\App\Http\Controllers'], function () {
    Route::get('/', 'TurnController@allTurn');
    Route::get('/{id}', 'TurnController@getByIdTurn');
    Route::post('/', 'TurnController@insertTurn');
    Route::put('/{id}', 'TurnController@updateTurn');
    Route::delete('/{id}', 'TurnController@deleteTurn');
});
