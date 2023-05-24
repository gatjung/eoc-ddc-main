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
Route::group(['prefix' => 'assign','middleware' => ['auth']], function() {
    // -- TABLE : ASSIGNMENT --
    Route::get('/', 'AssignController@index') -> name('page.assign');

     // -- EDIT Assign ODPC --
    Route::get('/assign_edit_odpc/order/{id}/roles/{roles_id}','AssignController@edit_assign') -> name('assign.edit.odpc');

    // -- EDIT Assign CENTRAL --
   Route::get('/assign_edit_central/order/{id}/roles/{roles_id}','AssignController@edit_assign2') -> name('assign.edit.central');

    // -- Select2 Multiple users_id for ODPC --
    Route::get('/Getuser_odpc', array(
        'as'   => 'Assign.ajax.get.user.odpc',
        'uses' => 'AssignController@List_User_Roles_odpc'
    ));

    // -- Select2 Multiple users_id for CENTRAL --
    Route::get('/Getuser_central', array(
        'as'   => 'Assign.ajax.get.user.central',
        'uses' => 'AssignController@List_User_Roles_central'
    ));


    //  -- INSERT Assign for ODPC --
    Route::post('/assign_insert_odpc','AssignController@insert_assign_odpc') -> name('assign.insert.odpc');

    //  -- INSERT Assign for CENTRAL --
    Route::post('/assign_insert_central','AssignController@insert_assign_central') -> name('assign.insert.central');


    // // -- BYPASS --
    // Route::get('/bypass/order/{id}/roles/{roles_id}','AssignController@bypass') -> name('page.bypass');

    // -- EDIT Myself Assign --
    // Route::get('/assign_edit_myself/order/{id}/roles/{roles_id}','AssignController@edit_assign_myself') -> name('assign.edit_myself');


    // -- TABLE : ASSIGNED --
    Route::get('/assigned','AssignController@assigned') -> name('page.completed');

    // -- TABLE : ASSIGNED2 --
    Route::get('/assigned2/order/{order_id}','AssignController@assigned2') -> name('page2.completed');

    // -- LOOK job at assigned --
    Route::get('/assigned_edit2/order/{order_id}/assign/{id}','AssignController@edit_assigned') -> name('assigned.edit2');


});
