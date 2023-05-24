<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\DBadminlogin;
use App\CmsHelper as CmsHelper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */


    // protected $redirectTo = RouteServiceProvider::HR;

    public function login (Request $request)
    {
        $input = $request->all();
        // dd($request->getClientIp());
        // dd(Get_Roles_TH2());
        $username = $request->username;
        $ip = $request->getClientIp();

        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // dd(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'], 'confirm' => 1)));

        if(auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'], 'confirm'=>1)))
        {
            $status = 'Login Success';
            //$users_roles = CmsHelper::Get_Current_Role_Group(Auth::user()->id);

            $data_login = new DBadminlogin;

            $data_login->username   = $username;
            $data_login->ip         = $ip;
            $data_login->status     = $status;
            $data_login->save();
            // if($users_roles == 12 || $users_roles == 1) {
            //     return redirect('/hr/ManageUsers');
            // } else {
            //     return redirect('/task');
            // }
            // if($users_roles == 12) {
            //     return redirect('/hr/ManageUsers');
            // } else {
            //     return redirect('/ddcdrive/Myfiles');
            // }
            return redirect('/commandic');
        } elseif (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'], 'confirm'=>0))) {
            Auth::logout();
            return redirect()->route('login.ecosystem')
                ->with('error','กรุณารอการยืนยันข้อมูลผ่านทาง Email ที่ทำการลงทะเบียน');
        } elseif (auth()->attempt(array($fieldType => $input['username'], 'password' => $input['password'], 'confirm'=>2))) {
            Auth::logout();
            return redirect()->route('login.ecosystem')
                ->with('error','ไม่มีรายชื่ออยู่ในกลุ่มภาระกิจ');
        } else {
            // dd(Auth::user());
            $status = 'Login Fail';

            $data_login = new DBadminlogin;

            $data_login->username   = $username;
            $data_login->ip         = $ip;
            $data_login->status     = $status;
            $data_login->save();

            return redirect()->route('login.ecosystem')
                ->with('error','ผู้ใช้งานหรือรหัสผ่านไม่ถูกต้อง');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
