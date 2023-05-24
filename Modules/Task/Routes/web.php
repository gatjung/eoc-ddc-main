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
Route::group(['prefix' => 'task','middleware' => ['auth']], function() {
    //Task & Track - ติดตามงาน
    Route::get('/', 'TaskController@index')->name('task_index');
    Route::get('meet/{meet_id}/order', 'TaskController@order')->name('task_order');
    Route::get('meet/{meet_id}/order/{order_id}/roles/', 'TaskController@roles')->name('task_roles');
    Route::get('meet/{meet_id}/order/{order_id}/roles/{roles_id}/job','TaskController@job')->name('task_job');
    //User Action - ปฎิบัติงาน
    Route::get('/order/assign/', 'TaskUserController@action')->name('task_action');
    Route::get('/order/{order_id}/assign/{assign_id}', 'TaskUserController@action_detail')->name('task_action_detail');
    Route::post('/order/assign/insert', 'TaskUserController@action_insert')->name('task_action_insert');
    Route::post('/order/assign/delete', 'TaskUserController@action_del')->name('task_action_del');
    //IC,MRG Approve - ตรวจสอบงาน
    Route::get('supervisor/approved', 'TaskApprovedController@approved')->name('task_approved');
    Route::post('supervisor/approved/update', 'TaskApprovedController@update')->name('task_approved_update');
    //Result Task - ผลการติดตามงาน
    Route::get('/pending', 'TaskTrackController@pending')->name('task_pending');
    Route::get('/success', 'TaskTrackController@success')->name('task_success');
    Route::get('/overdue', 'TaskTrackController@overdue')->name('task_overdue');
    //Result Task EOC - ผลการติดตามงาน EOC
    Route::get('eoc/pending', 'TaskTrackEocController@pending')->name('task_eoc_pending');
    Route::get('eoc/success', 'TaskTrackEocController@success')->name('task_eoc_success');
    Route::get('eoc/overdue', 'TaskTrackEocController@overdue')->name('task_eoc_overdue');
    //EOC-MGR
    Route::get('/eoc', 'TaskEocController@index')->name('task_eoc');
    Route::get('/eoc/meet/{meet_id}', 'TaskEocController@order')->name('task_eoc_order');
    Route::get('/eoc/meet/{meet_id}/order/{order_id}', 'TaskEocController@roles')->name('task_eoc_roles');
    Route::get('/eoc/meet/{meet_id}/order/{order_id}/roles/{roles_id}/job','TaskEocController@job')->name('task_eoc_job');

    //Job Detail
    // Route::post('order/roles/job/insert', 'TaskController@insert')->name('task_insert');
    // Route::delete('order/roles/job/delete', 'TaskController@delete')->name('task_del');
    // Route::get('meet/{meet_id}/order/{order_id}/roles/{roles_id}/job/{job_id}/users/{users_id}/detail', 'TaskController@detail')->name('task_detail');
    // Route::post('order/roles/job/detail/insert', 'TaskController@detail_insert')->name('task_detail_insert');
    // Route::delete('order/roles/job/detail/delete', 'TaskController@delete_detail')->name('task_del_detail');

});
