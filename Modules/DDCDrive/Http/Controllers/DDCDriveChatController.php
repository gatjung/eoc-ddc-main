<?php
namespace Modules\DDCDrive\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use App\ChatDDCLog;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;
use Illuminate\Support\Facades\Input;
use App\CmsHelper as CmsHelper;

class DDCDriveChatController extends Controller {

  public function __construct(){
     //$this->middleware('auth');
     $mytime = Carbon::now();
     $this->current_datetime = $mytime->toDateTimeString();
     $this->year = $mytime->format('Y');
     $this->month = $mytime->format('m');

     // $this->middleware(function ($request, $next) {
     //     $this->user = Auth::user();
     //     return $next($request);
     // });
  }

  public function ShowChatLogAll(){
    $datas = ChatDDCLog::OrderBy('created_at','desc')->get();
    return view('ddcdrive::chatroom',[
      "datas" => $datas
    ]);
  }


  public function GetChatLogBtn(){
    $c_date = Carbon::now()->subDays(7);
    $datas = ChatDDCLog::whereDate('created_at','>=',$c_date)->OrderBy('created_at','desc')->get();
    $htm = "";
    foreach($datas as $data){
       $htm .='<li>'.$data->username.' : '.$data->message.' , เมื่อ'.CmsHelper::formatDateThai($data->created_at).'</li>';
    }
    return $htm;
  }



	public function InserChatLog(Request $request){

      $data = [
         "username" => $request->username,
         "message" => $request->message,
         "ip" => $request->getClientIp()
      ];

     $save = ChatDDCLog::create($data);
     if($save){
       $json_datas = array("status" => "ok");
       return response()->json($json_datas);
     }else{
       $json_datas = array("status" => "failed");
       return response()->json($json_datas);
     }
	}

}
