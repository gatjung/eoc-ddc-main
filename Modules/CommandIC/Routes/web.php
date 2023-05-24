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
Route::group(['prefix' => 'commandic','middleware' => ['auth']], function() {
    Route::get('/', 'CommandICController@index')->name('commandIC.index');
    Route::get('/createCommandListIC', 'CommandICController@create')->name('commandIC.create');
    Route::post('/storeCommandListIC', 'CommandICController@store')->name('commandIC.store');
    Route::get('/Views/{commandListIC_id}/{file_name}', 'CommandICController@viewFileCommandListIC')->name('commandIC.viewFileCommandListIC');
    Route::get('/Download/{commandListIC_id}/{file_name}', 'CommandICController@downloadFileCommandListIC')->name('commandIC.downloadFileCommandListIC');
    Route::get('/Destroy/{commandListIC_id}/{file_name}', 'CommandICController@destroy')->name('commandIC.destroyCommandListIC');
});
