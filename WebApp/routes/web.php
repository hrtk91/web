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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', 'ChatController@index');
Route::get('/post/{id}', 'ChatController@read');
Route::post('/post', 'ChatController@create');
Route::get('/user', 'ChatController@user');
Route::get('/channels', 'ChatController@channels');
Route::post('/channels', 'ChatController@addChannel');
Route::delete('/channels/{id}', 'ChatController@deleteChannel');
