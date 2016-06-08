<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::resource('/tos', '\Alientronics\FleetanyWebPages\Controllers\PageController@tos');
Route::resource('/privacy', '\Alientronics\FleetanyWebPages\Controllers\PageController@privacy');
Route::resource('/home', '\Alientronics\FleetanyWebPages\Controllers\PageController@home');
Route::resource('/about', '\Alientronics\FleetanyWebPages\Controllers\PageController@about');
Route::resource('/pricing', '\Alientronics\FleetanyWebPages\Controllers\PageController@pricing');

Route::get('/web-pages/lang/{lang?}', '\Alientronics\FleetanyWebPages\Controllers\PageController@setLang');
