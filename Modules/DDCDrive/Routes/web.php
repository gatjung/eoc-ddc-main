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

//Route::prefix('ddcdrive')->group(function() {
Route::group(['prefix' => 'ddcdrive','middleware' => ['auth']], function() {
    // Route::get('/', array(
    //         'as'   => 'ddcdrive.main',
    //         'uses' => 'DDCDriveController@index'
    // ));
    Route::get('/', function () {
    return redirect()->route('ddcdrive.myfiles');
    });

    Route::get('/Myfiles', array(
            'as'   => 'ddcdrive.myfiles',
            'uses' => 'DDCDriveController@index'
    ));
    Route::get('/Files-SharePrivate', array(
            'as'   => 'ddcdrive.files-shareprivate',
            'uses' => 'DDCDriveController@index'
    ));
    Route::get('/Files-ShareGroup', array(
            'as'   => 'ddcdrive.files-sharegroup',
            'uses' => 'DDCDriveController@index'
    ));

    Route::post('/Upload_Files', array(
            'as'   => 'ddcdrive.act_upload_file',
            'uses' => 'DDCDriveController@Upload_Files'
    ));
    Route::get('/GetuserAll', array(
            'as'   => 'ddcdrive.ajax.get.user.all',
            'uses' => 'DDCDriveController@List_User_All'
    ));
    Route::get('/GetgroupAll', array(
            'as'   => 'ddcdrive.ajax.get.group.all',
            'uses' => 'DDCDriveController@List_Group_All'
    ));
    //Private Share
    Route::get('/Add-Private-Permission-Form/{file_id}/{status}',array(
      'as'=>'ddcdrive.form.addprivate.permission',
      'uses'=>'DDCDriveController@Add_Private_Permission'
    ));
    Route::post('/Save-Private-Permission', array(
            'as'   => 'ddcdrive.save_private_permission',
            'uses' => 'DDCDriveController@Saved_Private_Permission'
    ));
    Route::post('/Del-Private-Permission', array(
            'as'   => 'ddcdrive.del_private_permission',
            'uses' => 'DDCDriveController@Del_Private_Permission'
    ));
    //Group Share
    Route::get('/Add-Group-Permission-Form/{file_id}/{status}',array(
      'as'=>'ddcdrive.form.addgroup.permission',
      'uses'=>'DDCDriveController@Add_Group_Permission'
    ));
    Route::post('/Save-Group-Permission', array(
            'as'   => 'ddcdrive.save_group_permission',
            'uses' => 'DDCDriveController@Saved_Group_Permission'
    ));
    Route::post('/Del-Group-Permission', array(
            'as'   => 'ddcdrive.del_group_permission',
            'uses' => 'DDCDriveController@Del_Group_Permission'
    ));

    Route::get('/Download-Files-Update-Click/{file_folder_name}/{file_id}/{st}',array(
            'as'   => 'ddcdrive.downloadfile',
            'uses' => 'DDCDriveController@DownloadFile'
    ));

    Route::get('/Download-Files/{file_folder_name}/{file_id}',array(
            'as'   => 'ddcdrive.mydownloadfile',
            'uses' => 'DDCDriveController@My_DownloadFile'
    ));

    // Route::get('/Edit-Share-File/{file_folder_name}/{file_id}',array(
    //         'as'   => 'ddcdrive.editfile',
    //         'uses' => 'DDCDriveController@EditFile'
    // ));

    Route::post('/Delete-Share-File',array(
            'as'   => 'ddcdrive.deletefile',
            'uses' => 'DDCDriveController@DeleteFile'
    ));

    Route::post('/List-Seen-file-Group',array(
            'as'   => 'ddcdrive.view_seenby_group',
            'uses' => 'DDCDriveController@ViewSeenByGroup'
    ));

    //Route::post('/send','DDCDriveSendNotifyController@postCreate')->name('post.sendmsg');

    // Route::get('/chatroom', function () {
    //     return view('ddcdrive::chatroom');
    // })->name('chatgrouproom_all');

    Route::get('/chatroom',array(
            'as'   => 'chatgrouproom_all',
            'uses' => 'DDCDriveChatController@ShowChatLogAll'
    ));

    Route::post('/InsertChatLog',array(
            'as'   => 'ddcdrive.chatlog',
            'uses' => 'DDCDriveChatController@InserChatLog'
    ));

    Route::get('/GetChatLog',array(
            'as'   => 'ddcdrive.chatlog.btn',
            'uses' => 'DDCDriveChatController@GetChatLogBtn'
    ));


});
