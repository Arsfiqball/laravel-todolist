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

/*
|--------------------------------------------------------------------------
| TodolistAPI Routes
|--------------------------------------------------------------------------
*/
Route::get('/todo', 'Todo\TodolistAPIController@index');
Route::post('/todo', 'Todo\TodolistAPIController@store');
Route::post('/todo/{id}/update', 'Todo\TodolistAPIController@update');
Route::post('/todo/{id}/delete', 'Todo\TodolistAPIController@delete');
