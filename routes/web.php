<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\NewRevisionRequest;

// NAControllers
Route::get('login', 'NAController@login');
Route::get('callback', 'NAController@callback');

// Resource Controllers
Route::resource('documents', 'DocumentController');
Route::resource('sections', 'SectionController');
Route::resource('cpars', 'CparController');
Route::resource('revision-requests', 'RevisionRequestController');
Route::resource('access-requests', 'AccessRequestController', ['except' => ['create', 'edit']]);

// For printing revision-requests
Route::get('revision-requests/{revision_request}/print', 'RevisionRequestController@printRevisionRequest')->name('revision-requests.print');

// Individual Get Requests
Route::get('home', 'PageController@home')->name('pages.home')->middleware('na.authenticate');
Route::get('dashboard', 'PageController@dashboard')->name('pages.dashboard')->middleWare('na.authenticate');
Route::get('action-summary/{cpar}', 'PageController@actionSummary')->name('action-summary');
Route::get('answer-cpar/{cpar}', 'CparController@answerCpar')->name('answer-cpar');
Route::get('review/{cpar}', 'CparController@review')->name('review');

Route::get('unauthorize', function () {return view('errors.unauthorize');});
Route::get('pending', function () {return view('accessrequests.pending');});

Route::get('/', function () {
    return view('welcome');
});

// Individual POST Requests
Route::post('answer/{cpar}', 'CparController@answer')->name('answer');
Route::get('cpar-on-review', 'CparController@onReview')->name('on-review');
Route::post('cpars/review/{cpar}', 'CparController@saveReview')->name('review-cpar');
