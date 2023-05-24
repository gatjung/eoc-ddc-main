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
Route::group(['prefix' => 'dataprocessing','middleware' => ['auth']], function() {
    Route::get('/', 'DataProcessingController@index');
    Route::any('/dashboard', 'DashboardController@dashboard')->name('dashboard.hr');
    //Route::get('/dashboard', 'DashboardController@dashboard');

    Route::get('/dashboardsat-thai', 'DashboardSatController@dashboardsatthai')->name('dashboardsat.thai');
    Route::get('/dashboardsat-global', 'DashboardSatController@dashboardsatglobal')->name('dashboardsat.global');
    Route::any('/dashboardtask', 'DashboardTaskController@dashboardtask')->name('dashboard.task');

});
