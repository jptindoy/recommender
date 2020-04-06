<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });
Auth::routes(['register' => false,
                'reset' => false,
                'verify' => false,]);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/users', 'UserController@index')->name('users');
// Route::get('/profile/{id}', 'UserController@show')->name('users');

// Pages Controller
Route::get('/accountant', 'PagesController@accountant')->name('accountant');
Route::get('/merchant', 'PagesController@merchandizer')->name('merchant');
Route::get('/profile', 'PagesController@profile')->name('profile');
Route::get('/users', 'PagesController@users')->name('users');
Route::get('/import-data', 'PagesController@importData')->name('import-data');
Route::get('/sales-report', 'PagesController@salesReport')->name('sales-report');
Route::get('/documentation', 'PagesController@documentation')->name('documentation');
Route::get('/under-dev', 'PagesController@underDev')->name('under-dev');
Route::get('/recommended', 'PagesController@recommendedProduct')->name('recommended');
Route::get('/request', 'PagesController@productRequest')->name('request');