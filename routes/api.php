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

// Users routes
Route::get('users', 'API\APIUserController@index');
Route::get('user/{id}', 'API\APIUserController@show');
Route::post('user', 'API\APIUserController@store');
Route::put('user', 'API\APIUserController@store');
Route::delete('user/{id}', 'API\APIUserController@destroy');

// Modules routes
Route::get('modules', 'API\APIModuleController@index');
Route::get('module/{id}', 'API\APIModuleController@show');
Route::post('module', 'API\APIModuleController@store');
Route::put('module', 'API\APIModuleController@store');
Route::delete('module/{id}', 'API\APIModuleController@destroy');

// Roles routes
Route::get('roles', 'API\APIRoleController@index');
Route::get('role/{id}', 'API\APIRoleController@show');
Route::post('role', 'API\APIRoleController@store');
Route::put('role', 'API\APIRoleController@store');
Route::delete('role/{id}', 'API\APIRoleController@destroy');

