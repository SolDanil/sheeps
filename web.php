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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/git_user/{name}', 'MyControler@show');

Route::get('/get_users/{ask}', 'MyControler@get_users');
Route::post('/oven_day', 'OvenController@oven_day');
Route::get('/oven', 'OvenController@show');
Route::get('/history', 'OvenController@oven_history');
// Route::post('/oven_day', 'OvenController@oven_day');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
