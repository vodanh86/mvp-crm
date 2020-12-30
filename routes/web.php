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
Route::get('locale/{locale}', function ($locale){
    Session::put('locale', $locale);
    return redirect()->back();
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('news', 'PageController@category');
Route::get('share', 'PageController@share');
Route::get('services', 'PageController@services');
Route::get('contact', 'PageController@contact');
Route::get('about', 'PageController@about');
Route::get('detail/{id}', 'PageController@detail');

Route::prefix('travel')->group(function () {
    Route::get('{category}', 'PostController@index')
    ->where('category', 'index|feeling|event|news');
    Route::get('map', 'PostController@map');
    Route::get('media', 'PostController@media');
    Route::get('location/{type}', 'PostController@location')
    ->where('type', 'sightseeing|office|hotel|restaurant|mall|relax|support');
    Route::get('news/{id}', 'PostController@news');
    Route::get('cat/{id}', 'PostController@category');
    Route::get('gallery/{id}', 'PostController@gallery');
});
Route::prefix('portal')->group(function () {
    Route::get('index', 'PageController@index');
    Route::get('services', 'PageController@services');
    Route::get('history', 'PageController@history');
    Route::get('location', 'PageController@location');
    Route::get('responsibiliy', 'PageController@responsibiliy');
    Route::get('address', 'PageController@address');
    Route::get('infor', 'PageController@infor');
    Route::get('speaker', 'PageController@speaker');
    Route::get('idea', 'PageController@idea');
    Route::get('doc', 'PageController@doc');
    Route::get('news/{id}', 'PageController@news');
    Route::get('formality', 'PageController@formality')->name('map');
    Route::get('formalityAdmin/{id}', 'PageController@formalityAdmin');
    Route::get('cat/{id}', 'PageController@category');
    Route::get('online', 'PageController@online');
});