<?php

// NAControllers
use App\Mail\CparCreated;

Route::get('callback', 'NAController@callback');
Route::get('login', 'NAController@login');

// Resource Controllers
Route::resource('access-requests', 'AccessRequestController', ['except' => ['create', 'edit', 'update', 'show']]);
Route::resource('revision-requests', 'RevisionRequestController');
Route::resource('attachment', 'AttachmentController');
Route::resource('revision-logs', 'RevisionLogController');
Route::resource('documents', 'DocumentController');
Route::resource('sections', 'SectionController');
Route::resource('settings', 'SettingController');
Route::resource('cpars', 'CparController');
Route::resource('logs', 'LogController');

// For printing revision-requests
Route::get('revision-requests/{revision_request}/print', 'RevisionRequestController@printRevisionRequest')->name('revision-requests.print');

// Individual Get Requests
Route::get('cpars/create-cpar-number/{cpar}', 'CparController@createCparNumber')->name('cpars.create-cpar-number');
Route::get('dashboard', 'PageController@dashboard')->name('pages.dashboard')->middleWare('na.authenticate');
Route::get('action-summary/{cpar}', 'PageController@actionSummary')->name('action-summary');
Route::get('answer-cpar/login/{cpar}', 'PageController@answerCparLogin')->name('answer-cpar-login');
Route::get('cpars/finalize-verification/{cpar}', 'CparController@finalize')->name('cpars.finalize');
Route::get('home', 'PageController@home')->name('pages.home')->middleware('na.authenticate');
Route::get('page-not-found', 'PageController@pageNotFound')->name('page-not-found');
Route::get('answer-cpar/{cpar}', 'CparController@answerCpar')->name('answer-cpar');
Route::get('cpar-closed', 'CparController@cparClosed')->name('cpars.cpar-closed');
Route::get('cpar-on-review/{cpar}', 'CparController@onReview')->name('cpars.on-review');
Route::get('cpars/verify/{cpar}', 'CparController@verify')->name('cpars.verify');
Route::get('cpars/review/{cpar}', 'CparController@review')->name('cpars.review');
Route::get('cpars/close/{cpar}', 'CparController@close')->name('cpars.close');
Route::get('user-details/{user}', 'LogController@getUser')->middleware('na.authenticate');
Route::get('revision-requests/appeal/{revision_request}', 'RevisionRequestController@appeal')->name('revision-requests.appeal');
Route::get('get-cpars-by-columns/', 'CparController@filterCpars');
Route::get('cpars-report/{cpars}', 'ReportController@cpars')->name('cpars-report');

//Route GET Closure
Route::get('unauthorize', function () { return view('errors.unauthorize'); });
Route::get('pending', function () { return view('accessrequests.pending'); });
Route::get('/', function () { return view('welcome'); })->name('/');
Route::get('eqms-user/{id}', function($id) { if(count(\App\EqmsUser::where('user_id', $id)->get()) == 1){ return 'admin'; } else { return 'not admin'; } });

// Individual POST Requests
Route::post('answer-cpar/login/{cpar}', 'PageController@answerCparLoginPost')->name('answer-cpar-login-post');
Route::post('cpars/save-as-draft/{cpar}', 'CparController@saveAsDraft')->name('cpars.save-as-draft');
Route::post('cpars/verify/{cpar}', 'CparController@postVerify')->name('cpars.verify.post');
Route::post('cpars/review/{cpar}', 'CparController@saveReview')->name('review-cpar');
Route::post('answer/{cpar}', 'CparController@answer')->name('answer');
Route::post('access-requests/{access_request}/grant', 'AccessRequestController@grant')->name('access-requests.grant');
Route::post('access-requests/{access_request}/revoke', 'AccessRequestController@revoke')->name('access-requests.revoke');
Route::post('revision-requests/appeal/{revision_request}', 'RevisionRequestController@storeAppeal')->name('revision-requests.store-appeal');
