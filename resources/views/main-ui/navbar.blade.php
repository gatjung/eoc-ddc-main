<?php
if (!Auth::user()) {
  return redirect('login.ecosystem');
 }
use App\CmsHelper as CmsHelper;
use App\NotificationAlert;
use Carbon\Carbon;
$position_th_arr = CmsHelper::Get_Position_TH();
$role_th_arr = CmsHelper::Get_Roles_TH2();

if(Auth::user()->id){
  $role_group = CmsHelper::Get_Current_Role_Group(Auth::user()->id);
  $CountNewMessage  = count(NotificationAlert::CountNewMessage(Auth::user()->id));
  $ListNewMessage = NotificationAlert::ListNewMessage(Auth::user()->id);
}
$mytime = Carbon::now();
$current_date = $mytime->toDateString();

//dd(CmsHelper::Get_UserID(8));
?>
<audio id="notif_audio"><source src="{!! asset('sounds/line-notify.mp3') !!}" type="audio/ogg"></audio>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge" id="new_count_message">@if(isset($CountNewMessage)) {{ $CountNewMessage }} @endif</span>
      </a>

      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <a href="{{ route('all_notify') }}" class="dropdown-item dropdown-footer">ดูการแจ้งเตือนทั้งหมดของฉัน</a>
      </div>

    </li>

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="{{ asset('img/login-icon-28.png') }}" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline">@if(Auth::user()) {{ Auth::user()->name_th }} {{ Auth::user()->lname_th }} @else Anonymous @endif</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
          <!-- User image -->
          <li class="user-header">
            <img src="{{ asset('img/login-icon-28.png') }}" class="img-circle elevation-2" alt="User Image">
            <p style="font-size: 1em;">@if(Auth::user()) {{ Auth::user()->name_th }} {{ Auth::user()->lname_th }} @else Anonymous @endif</p>
            <p style="font-size: 1em;">@if(Auth::user()->position) {{ $position_th_arr[Auth::user()->position] }} @else โปรดแก้ไขข้อมูล @endif</p>
            <p class="text-info" style="font-size: 0.8em;">@if($role_th_arr[$role_group]) {{ $role_th_arr[$role_group] }} @else โปรดแก้ไขข้อมูล @endif</p>
          </li>
          <!-- Menu Footer-->

          <li class="user-footer" style="margin-top:1.5em;;">

            <a href="{{ route('users.show') }}" type="button" class="btn btn-info text-white" title="ข้อมูลของฉัน">ข้อมูลของฉัน</a>

            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-danger float-right">ออกจากระบบ</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </li>
        </ul>
      </li>
  </ul>
</nav>
