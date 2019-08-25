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

Route::get('/', 'HealthCheckController@index');
Route::get('/scores/timeline', 'ScoresController@timeline');
Route::get('/scores/{id}', 'ScoresController@show');
Route::post('/scores/create', 'ScoresController@create');
Route::get('/scores', 'ScoresController@index');
