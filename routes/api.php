<?php

use Illuminate\Http\Request;

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

// user routes
Route::get('users', 'API\APIUserController@index');
Route::get('user/{id}', 'API\APIUserController@show');
Route::post('user', 'API\APIUserController@store');
Route::put('user', 'API\APIUserController@store');
Route::delete('user/{id}', 'API\APIUserController@destroy');
