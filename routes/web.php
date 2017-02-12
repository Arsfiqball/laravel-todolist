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
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::get('/auth/facebook', [
    'uses' => 'Auth\SocialController@redirectToFacebook',
    'as' => 'auth.facebook'
]);
Route::get('/auth/facebook/callback', [
    'uses' => 'Auth\SocialController@handleFacebookCallback',
    'as' => 'auth.facebook.callback'
]);

/*
|--------------------------------------------------------------------------
| Todolist Routes
|--------------------------------------------------------------------------
*/
Route::get('/todo', [
    'uses' => 'Todo\TodolistController@index',
    'as' => 'todo'
]);
Route::post('/todo', [
    'uses' => 'Todo\TodolistController@store',
    'as' => 'todo.store'
]);
Route::any('/todo/{id}/update', [
    'uses' => 'Todo\TodolistController@update',
    'as' => 'todo.update'
]);
Route::get('/todo/{id}/delete', [
    'uses' => 'Todo\TodolistController@delete',
    'as' => 'todo.delete'
]);