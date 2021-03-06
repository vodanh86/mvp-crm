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

Route::get('formalityOps', 'FormalityOpsController@index');
Route::get('formalityArea', 'FormalityAreaController@index');
Route::get('unit', 'UnitController@index');

Route::post('login', 'APIController@login');
Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('logout', 'APIController@logout');
    Route::get('users', 'UserController@index');
    Route::get('customers', 'CustomerController@index');
    Route::get('plans', 'PlanController@index');
    Route::post('customer/{id}', 'CustomerController@edit');
    Route::get('customer/status', 'CustomerController@status');
    Route::post('user/{id}', 'UserController@edit');
    Route::get('customer/{id}', 'CustomerController@detail');
});