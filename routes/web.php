<?php

use Illuminate\Support\Facades\Route;

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
 
Route::get('/{any}', 'TinyUrlController@index')->where('any', '.*');
Route::post('/setUrl', 'TinyUrlController@setUrl');
Route::post('/getLink', 'TinyUrlController@getLink');
Route::post('/setUserLog', 'TinyUrlController@setUserLog');
Route::post('/getStat', 'TinyUrlController@getStat');
Route::post('/getStatTotal', 'TinyUrlController@getStatTotal');
