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

Route::prefix('exchange')->group(function() {

    Route::get('/', 'ExchangeController@index'); /*Blank Page*/
    Route::get('/meeting_upload','ExchangeController@meeting_upload') -> name('page.meeting_upload');
     // -- INSERT Meeting_Upload --
    Route::post('/com_ic_insert','ExchangeController@insert_ic') -> name('command_ic.insert');



    Route::get('/procedure_upload','ExchangeController@procedure_upload') -> name('page.procedure_upload');



});
