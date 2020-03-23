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
Auth::routes([
                'reset' => false,
                'verify' => false,]);


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
// Route::get('/users', 'UserController@index')->name('users');
// Route::get('/profile/{id}', 'UserController@show')->name('users');

// Pages Controller
Route::get('/accountant', 'PagesController@accountant');
Route::get('/merchant', 'PagesController@merchandizer');
Route::get('/profile', 'PagesController@profile');
Route::get('/users', 'PagesController@users');
Route::get('/import-data', 'PagesController@importData');