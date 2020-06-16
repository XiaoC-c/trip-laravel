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

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1'],function(){
    Route::post('/user/login', 'UserController@login');
});



Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'middleware' => 'aaaaaa'],function(){
    Route::post('/order/create', 'OrderController@create');
});
