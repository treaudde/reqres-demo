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

Route::group(['prefix' => 'user'], function () {
    Route::post('login', ['uses' => 'ReqResUserController@login']);
    Route::post('create-user', ['uses' => 'ReqResUserController@createUser']);
    Route::get('list-users', ['uses' => 'ReqResUserController@listUsers']);
});