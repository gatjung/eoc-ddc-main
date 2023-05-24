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
Route::group(['prefix' => 'hr','middleware' => ['auth']], function() {
    // Route::get('/', 'HrController@index');

    // Route::resource('users','UserController');
    Route::any('/ManageUsers', 'UserController@index')->name('users.index');
    Route::get('/ApproveUser/{confirm}/{id}/{email}', 'UserController@approve_user')->name('users.approve');
    Route::get('/CheckUserCommand/{id}', 'UserController@check_user_command')->name('users.chkcommanduser');
    Route::get('/Profile', 'UserController@show')->name('users.show');
    Route::get('/EditUser/{id}', 'UserController@edit')->name('users.edit');
    Route::post('/UpdateUsers', 'UserController@update')->name('users.update');
    Route::delete('/DeleteUsers', 'UserController@destroy')->name('users.destroy');
    Route::get('/get-list-organization-old', 'UserController@Get_List_Organization_Old')->name('ajax.list.organization.old');
    Route::get('/get-list-organization', 'UserController@Get_List_Organization')->name('ajax.list.organization');
    Route::get('/get-list-role-group-old', 'UserController@Get_Role_Group_By_Old')->name('ajax.get_role.group_by.old');
    Route::get('/get-list-role-group', 'UserController@Get_Role_Group_By')->name('ajax.list.rolesGroup');
    Route::get('/DeleteCommand/{id}', 'UserController@destroy_command')->name('users.destroy.command');
    Route::get('/AddCommand', 'UserController@add_command')->name('users.add_command');
    Route::post('/InsertCommand', 'UserController@insert_command')->name('users.insert_command');
    Route::get('/AddCommand/{id}', 'UserController@add_command_hr')->name('users.add_command_hr');
    Route::post('/InsertCommand/{id}', 'UserController@insert_command_hr')->name('users.insert_command_hr');
    Route::get('/DeleteCommandHr/{id}', 'UserController@destroy_command_hr')->name('users.destroy.command_hr');
    Route::post('/UpdateUsersHr/{id}', 'UserController@update_hr')->name('users.update_hr');
    Route::get('/export', 'UserController@export')->name('users.export');
    // Route::get('/ManageProfile/{id}', 'UserController@manage_profile')->name('users.manage_profile');

    Route::get('/ManageRoles', 'RoleController@index')->name('roles.index');
    Route::get('/CreateRoles', 'RoleController@create')->name('roles.create'); //สร้างหน้า create.blade หรือ insert
    Route::post('/StoreRoles', 'RoleController@store')->name('roles.store'); //store คือการ insert
	Route::get('/ShowRoles/{id}', 'RoleController@show')->name('roles.show');
	Route::get('/EditRoles/{id}', 'RoleController@edit')->name('roles.edit');
	Route::patch('/UpdateRoles/{id}', 'RoleController@update')->name('roles.update');
	Route::delete('/DeleteRoles/{id}', 'RoleController@destroy')->name('roles.destroy');

    Route::get('/ManagePermission', 'PermissionController@index')->name('permission.index');
    Route::get('/CreatePermission', 'PermissionController@create')->name('permission.create');
    Route::post('/StorePermission', 'PermissionController@store')->name('permission.store');
    Route::get('/EditPermission/{id}', 'PermissionController@edit')->name('permission.edit');
    Route::patch('/UpdatePermission/{id}', 'PermissionController@update')->name('permission.update');
    Route::delete('/DeletePermission/{id}', 'PermissionController@destroy')->name('permission.destroy');

    Route::get('/ManagePrefix', 'PrefixController@index')->name('prefix.index');
    Route::get('/CreatePrefix', 'PrefixController@create')->name('prefix.create');
    Route::post('/StorePrefix', 'PrefixController@store')->name('prefix.store');
    Route::post('/EditPrefix', 'PrefixController@edit')->name('prefix.edit');
    Route::post('/UpdatePrefix', 'PrefixController@update')->name('prefix.update');
    Route::post('/DeletePrefix', 'PrefixController@destroy')->name('prefix.destroy');

    Route::get('/ManagePosition', 'PositionController@index')->name('position.index');
    Route::get('/CreatePosition', 'PositionController@create')->name('position.create');
    Route::post('/StorePosition', 'PositionController@store')->name('position.store');
    Route::post('/EditPosition', 'PositionController@edit')->name('position.edit');
    Route::post('/UpdatePosition', 'PositionController@update')->name('position.update');
    Route::post('/DeletePosition', 'PositionController@destroy')->name('position.destroy');

    Route::get('/ManageCourse', 'CourseController@index')->name('course.index');
    Route::get('/CreateCourse', 'CourseController@create')->name('course.create');
    Route::post('StoreCourse', 'CourseController@store')->name('course.store');
    Route::post('/EditCourse', 'CourseController@edit')->name('course.edit');
    Route::post('/UpdateCourse', 'CourseController@update')->name('course.update');
    Route::post('/DeleteCourse', 'CourseController@destroy')->name('course.destroy');

    Route::get('/ManageJobLevel', 'JobLevelController@index')->name('joblevel.index');
    Route::get('/CreateJobLevel', 'JobLevelController@create')->name('joblevel.create');
    Route::post('/StoreJobLevel', 'JobLevelController@store')->name('joblevel.store');
    Route::post('/EditJobLevel', 'JobLevelController@edit')->name('joblevel.edit');
    Route::post('/UpdateJobLevel', 'JobLevelController@update')->name('joblevel.update');
    Route::post('/DeleteJobLevel', 'JobLevelController@destroy')->name('joblevel.destroy');

    Route::get('/Commandlist', 'CommandlistController@index')->name('commandlist.index');
    Route::post('/UploadCommandlist', 'CommandlistController@upload_file')->name('commandlist.upload_file');
    Route::get('/DownloadFile/commandlist/{id}', 'CommandlistController@DownloadFile')->name('commandlist.DownloadFile');
    Route::post('/DeleteCommandFile', 'CommandlistController@DeleteFile')->name('commandlist.DeleteFile');
    Route::get('/ViewFile/commandlist/{id}', 'CommandlistController@ViewFile')->name('commandlist.ViewFile');
});
