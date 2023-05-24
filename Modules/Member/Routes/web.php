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
//>>>>>>>>>>>>>>>Route by care <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
Route::prefix('member')->group(function() {
    Route::get('/', 'MemberController@index');

    Route::get('/register', 'MemberController@register')->name('register');
    //Insert Register
    Route::post('/insert', 'MemberController@insert')->name('register.insert');
    Route::get('/checkRepeat', 'MemberController@checkRepeat')->name('register.checkRepeat');



    //>>>>>>>>> Morchana<<<<<<<<<<<<//
    Route::get('/morchana', 'MorchanaController@morchana')->name('morchana');


    // Worktime & Team แสบ
    Route::get('/work-io', 'WorktimeController@work_io')->name('work_io');
    Route::post('/work-io/getdate', 'WorktimeController@getdate')->name('work_getdate');
    Route::post('/work-io/insert', 'WorktimeController@insert')->name('work_insert');
    Route::post('/work-io/update', 'WorktimeController@update')->name('update');
    Route::get('/team', 'TeamController@team')->name('team_dev');
    Route::get('/teams', 'TeamsController@teams')->name('teams_dev');
    // Route::get('/select_date', 'WorktimeController@select_date')->name('select_date');
    // Route::resource('daterange', 'DateRangeController');

    //Ajax
    Route::get('/get-list-agency', 'MemberController@Get_List_Agency')->name('ajax.get_list_agency');
    Route::get('/get-list-role-group', 'MemberController@Get_Role_Group_By')->name('ajax.get_role_group_by');
});
