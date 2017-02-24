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

Route::get('login', 'NAController@login');
Route::get('callback', 'NAController@callback');

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', function() {
    return view('pages.home');
})->middleware('na.authenticate');

Route::get('sample' function() {
    return 'test';
});
