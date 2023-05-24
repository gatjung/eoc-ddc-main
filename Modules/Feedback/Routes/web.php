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
Route::group(['prefix' => 'feedback','middleware' => ['auth']], function() {
    Route::get('/', 'FeedbackController@index')->name('feedback.index');
    Route::post('/insertComment', 'FeedbackController@store')->name('feedback.store');
    Route::get('/viewfeed', 'FeedbackController@viewfeed')->name('feedback.viewfeed');
});
