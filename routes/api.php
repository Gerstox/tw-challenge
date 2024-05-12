<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');
    Route::post('register', 'App\Http\Controllers\AuthController@register');
});

Route::group([

    'middleware' => 'api',

], function ($router) {
    Route::get('users', 'App\Http\Controllers\UserController@getAll');
    Route::get('users/{id}', 'App\Http\Controllers\UserController@getOne');
    Route::get('users/location/{id}', 'App\Http\Controllers\UserController@getLocation')->name('getLocation');
    Route::post('users/location', 'App\Http\Controllers\UserController@saveLocation');
    Route::put('users/location/{id}', 'App\Http\Controllers\UserController@updateLocation');
});