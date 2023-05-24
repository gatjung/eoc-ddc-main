<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\NotificationAlert;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class UpdateNotifyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $mytime = Carbon::now();
        $this->current_datetime = $mytime->toDateTimeString();
        $this->current_date = $mytime->toDateString();
        $this->year = $mytime->format('Y');
        $this->month = $mytime->format('m');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update_notify(Request $req)
    {
        NotificationAlert::where('id', $req->id_notify)
        ->update([
          'seen' => 1,
          'updated_at' => $this->current_datetime,
        ]);

        return redirect($req->url_redirect);
    }

    public function AllNotification(){
      $datas = NotificationAlert::select('id','subject','url_redirect','module_name','created_at','detail','seen', DB::raw('DATE(created_at) as date'))
        ->where('receiver_u_id',$this->user->id)
        ->OrderBy('date','desc')
        ->get()
        ->groupBy('date');
        return view('all-notify',[
          "datas" => $datas
        ]);
    }
}
