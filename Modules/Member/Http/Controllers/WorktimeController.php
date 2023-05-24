<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\member;
use App\ChkIO;
use Carbon\Carbon;

class WorktimeController extends Controller
{

  public function __construct(){
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

  public function work_io(Request $request)
  {

      $id = $this->user->id;
      $current_date = Carbon::now()->toDateString();
      $check_duplicate_check_in = ChkIO::whereDate('created_at',$this->current_date)->where('users_id',$id)->count();

      $his_work  = DB::table('his_work')
      ->select(
              'his_work.id as check_id',
              'his_work.users_id',
              'his_work.chk_in',
              'his_work.chk_out',
              'his_work.created_at',
              'his_work.updated_at',
              'users.name_th as fname',
              'users.lname_th',
              'users.prefix_th',
              'users.id',
              'ref_prefix.id',
              'ref_prefix.name_th')
      ->leftJoin('users','users.id','=','his_work.users_id')
      ->leftJoin('ref_prefix','ref_prefix.id','=','users.prefix_th')
      ->where('his_work.users_id',$id)
      ->whereMonth('his_work.created_at',$this->month)
      ->orderby('his_work.created_at','DESC')
      ->get();

    $his_work2  = ChkIO::select()->first();

    return view('member::frontend.work_io',
    [
      "his_work" => $his_work,
      "his_work2" => $his_work2,
      "check_duplicate_check_in" => $check_duplicate_check_in,
      "current_date" => $current_date
     ]);
  }


// -------------------------------------------------------------------------

public function getdate(Request $request)
{
    $id = $this->user->id;
    $current_date = Carbon::now()->toDateString();
    $check_duplicate_check_in = ChkIO::whereDate('created_at',$this->current_date)->where('users_id',$id)->count();
    $his_work  = DB::table('his_work')
    ->select(
            'his_work.id as check_id',
            'his_work.users_id',
            'his_work.chk_in',
            'his_work.chk_out',
            'his_work.created_at',
            'his_work.updated_at',
            'users.name_th as fname',
            'users.lname_th',
            'users.prefix_th',
            'users.id',
            'ref_prefix.id',
            'ref_prefix.name_th')
    ->leftJoin('users','users.id','=','his_work.users_id')
    ->leftJoin('ref_prefix','ref_prefix.id','=','users.prefix_th')
    ->where('his_work.users_id',$id)
    ->whereBetween('his_work.created_at',[$request->start_date." 00:00:00",$request->end_date." 23:59:00"])
    ->orderby('his_work.created_at','DESC')
    ->get();
  return view('member::frontend.work_io', [
          "his_work" => $his_work,
          "check_duplicate_check_in" => $check_duplicate_check_in,
          "current_date" => $current_date,
          "start_date" => $request->start_date,
          "end_date" => $request->end_date,
  ]);
}
// ---------------------------------------------------------------------------





  //Insert Save
  public function insert(Request $request){
    // dd($request);

      $insert = new ChkIO; //ChkIO ประกาศ object Model
      $insert->users_id = $request->users_id;
      $insert->chk_in = $request->chk_in;
      $insert->save();

      if($insert->save()){
          return redirect()->back()->with('success','บันทึกเวลาสำเร็จ');
      }else{
          return redirect()->back()->with('success','บันทึกเวลาไม่สำเร็จ');
      }
  }

  public function update(Request $request)
  {
      // dd($request);

      // $last_id = ChkIO::latest()->first()->id;
      $update = ChkIO::where('id',$request->work_id)->update(array(
          'chk_out'=>$request->chk_out

      ));

      if($update){
          return redirect()->back()->with('success', "บันทึกเวลาสำเร็จ");
      }else{
          return redirect()->back()->with('success', "บันทึกเวลาไม่สำเร็จ");
      }
  }


  // public function daily_report(Request $request)
  //     {
  //        $start_date = Carbon::parse($request->start_date)
  //                              ->toDateTimeString();
  //
  //        $end_date = Carbon::parse($request->end_date)
  //                              ->toDateTimeString();
  //
  //        return User::whereBetween('his_work',[$start_date,$end_date])->get();
  //
  //     }




}
