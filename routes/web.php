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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/people', 'PersonController@index')->name('people');
Route::post('/new-person', 'PersonController@store')->name('new-person');
Route::post('/update-person/{id}', 'PersonController@update')->name('update-person');
