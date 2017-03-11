<?php

Route::resource('documents', 'DocumentController');
Route::resource('sections', 'SectionController');
Route::resource('cpars', 'CparController');
Route::resource('revision-requests', 'RevisionRequestController');

// For printing revision-requests
Route::get('revision-requests/{revision_request}/print', 'RevisionRequestController@printRevisionRequest')->name('revision-requests.print');

Route::get('home', ['as' => 'pages.home', 'uses' => 'PageController@home']); //->middleware('na.authenticate')
Route::get('action-summary', 'PageController@actionSummary');

Route::get('login', 'NAController@login');
Route::get('callback', 'NAController@callback');

Route::get('/', function () {
    return view('welcome');
});
