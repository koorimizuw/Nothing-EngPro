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
Route::middleware('auth:api')->get('/me', function (Request $request) {
    return $request->user();
 });
Route::post('/login', 'Auth\LoginController@login'); //Request [name][password]
Route::post('/register', 'Auth\RegisterController@register'); //Request [name][password]

//Need authorization
Route::middleware('auth:api')->group(function() {
    Route::post('/new', 'OrderController@new'); //Request [name][link][time][number]
    Route::post('/order', 'OrderController@order'); //Request [id]
});

Route::get('/list', 'OrderController@list');
Route::post('/search', 'OrderController@search'); //Request [key]
