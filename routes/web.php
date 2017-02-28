<?php

// Route::group(['middleware' => 'na.authenticate'], function () {
Route::resource('documents', 'DocumentController');
// 	Route::resource('audit_trails', 'AuditTrailController');
// 	Route::resource('revision_logs', 'RevisionLogController');
// 	Route::resource('sections', 'SectionController');
// 	Route::resource('users', 'UserController');
// 	Route::resource('request_revision', 'RequestARevisionController');
// 	Route::resource('revision_requests', 'RevisionRequestController');
// });

Route::get('home', 'PageController@home')->middleware('na.authenticate');
Route::get('serach', 'PageController@search')->middleware('na.authenticate');

// Route::get('nomatch', 'PageController@nomatch');

// Route::post('search', ['as' => 'search', 'uses' => 'SearchController@search']);
// Route::post('show', ['as' => 'audit_trails.show', 'uses' => 'AuditTrailController@show']);

Route::get('login', 'NAController@login');
Route::get('callback', 'NAController@callback');

Route::get('/', function () {
    return view('welcome');
});
