<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/pollings')->group(function (){
    Route::get('/', 'Api\PollingController@index');
    Route::post('/create', 'Api\PollingController@create');
    Route::put('/update', 'Api\PollingController@update');
});

Route::prefix('/guests')->group(function (){
    Route::get('/', 'Api\GuestController@index');
    Route::post('/create', 'Api\GuestController@create');
    Route::put('/update', 'Api\GuestController@update');
});

Route::prefix('/messages')->group(function (){
    Route::get('/', 'Api\MessageController@index');
    Route::post('/create', 'Api\MessageController@create');
    Route::put('/update', 'Api\MessageController@update');
});


Route::post('/login', 'Auth\LoginController@login');
