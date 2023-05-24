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
Route::group(['prefix' => 'meeting','middleware' => ['auth']], function() {
    Route::get('/', 'MeetingController@index')->name('meeting.home');
    Route::get('/list', 'MeetingController@list')->name('meeting.list');
    Route::get('/order', 'MeetingController@order')->name('meeting.order');
    Route::get('/show/{id}', 'MeetingController@show')->name('meeting.show');
    Route::get('/edit/{id}', 'MeetingController@edit')->name('meeting.edit');

    Route::post('/insert','MeetingController@insert')->name('meeting.insert');
    Route::post('/update/{id}','MeetingController@update')->name('meeting.update');
    Route::get('/destroy/{id}','MeetingController@destroy')->name('meeting.destroy');

});
