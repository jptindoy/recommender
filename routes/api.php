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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Login 
Route::get('email/{id}', 'API\LoginController@show');
// Auth::routes();
Route::group(['middleware' => ['auth']], function () {
    Route::post('/login', 'Auth\LoginController@login');
});

// User Info
Route::get('users', 'API\UserController@index');
Route::post('/user', 'API\UserController@store');
Route::put('/user', 'API\UserController@store');
Route::get('/user/{id}', 'API\UserController@show');
Route::post('/profile', 'API\UserController@updateProfile');
Route::put('/password', 'API\UserController@updatePassword');
Route::delete('user/{id}', 'API\UserController@destroy');
Route::put('/user/{id}', 'API\UserController@update');

// User Log
Route::post('/log', 'API\UserLogController@store');
Route::get('/log/{id}', 'API\UserLogController@show');

// Modules routes 
Route::get('modules', 'API\ModuleController@index');
Route::get('module/{id}', 'API\ModuleController@show');
Route::post('module', 'API\ModuleController@store');
Route::put('module', 'API\ModuleController@store');
Route::delete('module/{id}', 'API\ModuleController@destroy');

// Modules Rights routes
Route::get('module-rights', 'API\ModuleRightController@index');
Route::get('module-right/{id}', 'API\ModuleRightController@show');
Route::post('module-right', 'API\ModuleRightController@store');
Route::put('module-right', 'API\ModuleRightController@store');
Route::delete('module-right/{id}', 'API\ModuleRightController@destroy');

// Roles routes
Route::get('roles', 'API\RoleController@index');
Route::get('role/{id}', 'API\RoleController@show');
Route::post('role', 'API\RoleController@store');
Route::put('role', 'API\RoleController@store');
Route::delete('role/{id}', 'API\RoleController@destroy');
Route::get('getrole', 'API\RoleController@getrole');

// Importing Data
Route::post('import', 'API\PosDataController@store');
Route::get('imported', 'API\PosDataController@index');

// Chart Routes
Route::get('month-sales', 'API\ChartController@getSalesPerMonth');
Route::get('top-sales', 'API\ChartController@getTopSales');
Route::get('total-sales', 'API\ChartController@getTotalSales');
Route::get('percentage', 'API\ChartController@getTotalSales');
Route::post('sales', 'API\ChartController@getMonthlySales');
Route::post('requested', 'API\ChartController@getMostRequest');
Route::post('item-chart', 'API\ChartController@getItemGraph');
Route::get('export-sales', 'API\ChartController@eportSales');
Route::get('export-request', 'API\ChartController@exportRequest');

// Recommendation Routes
Route::get('item-sets', 'API\RecommendationController@index');
Route::post('item-set-search/', 'API\RecommendationController@searchItemSet');
Route::get('salable-item/{id}', 'API\RecommendationController@salableForToday');
Route::get('item-list', 'API\RecommendationController@itemList');
Route::get('item-list/{id}', 'API\RecommendationController@itemListSearch');
Route::post('predict-item', 'API\RecommendationController@predictItem');


// Request Routes
Route::post('request-draft', 'API\RequestController@draft');
Route::post('edit-request-draft', 'API\RequestController@editAddItem');
Route::get('draft-item', 'API\RequestController@draftItem');
Route::get('delete-draft', 'API\RequestController@deleteDraft');
Route::patch('qty/{id}', 'API\RequestController@updateQty');
Route::patch('variant/{id}', 'API\RequestController@updateVariant');
Route::delete('delete-item-list/{id}', 'API\RequestController@destroy');
Route::post('save-request/', 'API\RequestController@saveRequest'); 
Route::get('request-widget/', 'API\RequestController@requestWidget');
Route::get('edit-request/{id}', 'API\RequestController@editRequest');
Route::post('update-request/', 'API\RequestController@updateRequest');
Route::get('search-request/{id}', 'API\RequestController@searchRequest');

// Notification
Route::get('notification/{id}', 'API\NotificationController@getNotification');

// Sales Report Route
Route::get('test', 'API\ChartController@getMostRequest');