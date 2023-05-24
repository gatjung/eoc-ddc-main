<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('login');
})->name('login.ecosystem');

Route::get('/resetpass', function() {return view ('resetpass');})->name('resetpass.ecosystem');

// dd(Auth::check());
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::get('/Update-Notify', 'UpdateNotifyController@update_notify')->name('url.update_notify');

Route::get('/MyNotification', 'UpdateNotifyController@AllNotification')->name('all_notify');


Route::get('/announce', '\Modules\Meeting\Http\Controllers\AnnounceController@index')->name('announce.index');
Route::post('/insertAnnounce', '\Modules\Meeting\Http\Controllers\AnnounceController@store')->name('announce.store');

Route::get('/pdf', function () {
    $data = [
        'name'=>'อะไรสักอย่าง ไม่รู้นามสกุลอะไร'
    ];
    $pdf = PDF::loadView('pdf.invoice', $data);
    return @$pdf->stream();
});
