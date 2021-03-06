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


Auth::routes();
Route::group(['middleware' => ['auth']], function() {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('adduser/{id?}', 'UserController@create');
    Route::post('user/store', 'UserController@store');
    Route::get('userlist', 'UserController@index');
    Route::get('deleteUser/{id}', 'UserController@destroy');
    Route::post('serverUser', 'UserController@getServerUserList');
});
