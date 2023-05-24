<?php

namespace Modules\Assign\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Assign_List_User;
use App\Assign;
use App\NotificationAlert;
use App\Assign_meeting;
use App\Roles;
use App\Member;
use Auth;
use App\CmsHelper as CmsHelper;
use app\Exceptions\Handler;
use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;


class AssignController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


     public function __construct(){
       $this->middleware('auth');

       $this->middleware(function ($request, $next) {
           $this->user = Auth::user();
           return $next($request);
       });

    }




    //  -- ASSIGNMENT --
    public function index(Request $request){

      if(Auth::user()->emp_level == 3){

        //หัวหน้ากล่อง
        $query2 = DB::table('task_order')
            ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
            // ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
            ->leftjoin('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->select(
                      'task_order.id',
                      'task_order.meet_id',
                      'task_order.title',
                      'task_order.status',
                      'task_order.start_at',
                      'task_order_x_roles.roles_id',
                      'task_order_x_roles.order_id'
                      )
            ->where('task_order_x_roles.roles_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
            ->whereNotNull('task_order.title')    //ไม่นำ title ค่า "null" มาแสดง
            ->whereNull('task_order.status')  //หัวหน้ากล่อง จะเห็นทั้งหมด โดยดึงค่า null มาแสดง
            ->whereNull('task_order.delete_at')
            ->get();

        }else {
          //หัวหน้ากลุ่ม
            $query2 = DB::table('task_order')
                ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
                // ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
                ->leftjoin('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
                ->select(
                          'task_order.id',
                          'task_order.meet_id',
                          'task_order.title',
                          'task_order.status',
                          'task_order.start_at',
                          'task_order_x_roles.roles_id',
                          'task_order_x_roles.order_id'
                          )
                ->where('task_order_x_roles.roles_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
                ->whereNotNull('task_order.title')    //ไม่นำ title ค่า "null" มาแสดง
                ->where('task_order.status', '=' , 1)  //หัวหน้ากลุ่ม จะไม่เห็นค่า null แต่จะดึง 1 มาแสดงแทน
                ->whereNull('task_order.delete_at')
                ->get();
              }

      return view('assign::frontend.assignment',
        [
         'orders'  => $query2,
        ]);
    }
    //  -- END ASSIGNMENT --



    //  -- BYPASS --
    // public function bypass($id, $roles_id){
    //
    //     return view('assign::frontend.bypass',
    //       [
    //        'id'       => $id ,
    //        'roles_id' => $roles_id
    //       ]);
    //
    // }
    //  -- END BYPASS --



// -- organization_type = ODPC Only --  //
    //  -- EDIT for ODPC --
    public function edit_assign(Request $request){

    //เรียกชื่อบุคคลในกล่องงานภารกิจ มาแสดงผล
     if(Auth::user()->emp_level == 3){
        $users = Member::select('id', 'name_th', 'lname_th')
                        ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                        ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
                        ->where('users.id', '=', Auth::user()->id) //select โดย "ไม่เลือก (<>)" ชื่อของผู้ใช้งานมุมขวาบน มาแสดง
                        ->where('users.emp_level', 1) //เอาเฉพาะค่า emp_level= 1 เท่านั้น
                        ->orderby('id','DESC')
                        ->get();
      }else {
        $users = Member::select('id', 'name_th', 'lname_th')
                        ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                        ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
                        ->where('users.id', '=', Auth::user()->id) //select โดย "ไม่เลือก (<>)" ชื่อของผู้ใช้งานมุมขวาบน มาแสดง
                        ->orderby('id','DESC')
                        ->get();
      }

      $leader = Auth::user();
      // dd($leader);

      //แสดงข้อมูล Query
      $query3 = DB::table('task_order')
                ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
                ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
                ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
                ->select(
                        'task_order.id',
                        'task_order.meet_id',
                        'task_order.start_at',
                        'task_order.end_at',
                        'task_order.title AS issue_title',
                        'task_meeting.title AS meet_title',
                        'task_order.title',
                        'roles.id AS roles_id',
                        'roles.name',
                        'roles.name_eng',
                        )
                ->where('task_order.id', $request->id)
                ->whereNull('task_order.delete_at')
                ->first();


      //แสดงข้อมูล USER_OUT from table -> list_user
      $out_u_id = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->join('list_user', 'list_user.id', '=', 'model_has_roles.model_id')
            ->join('task_assign', 'task_assign.users_id', '=', 'list_user.id')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->select ('task_assign.order_id',
                      'list_user.id',
                      )
            ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
            ->where('task_assign.order_id', $request->id)
            ->get();
        // dd($out_u_id);

        $user_out = [];
          if(isset($out_u_id)){
              foreach ($out_u_id as $value){
                $user_out[] = $value->id;
              }
          }
      // dd($user_out);


      //USE In assign_edit.blade CALL SCRIPT url
        $out_u_id_conv = CmsHelper::add_comma($user_out);


      if(!isset($query3)) {
        return abort(404);
      }

        return view('assign::frontend.assign_edit',
       [
         'members'    => $users,
         'data3'      => $query3,
         'leader'     => $leader,
         'out_u_id_conv' => $out_u_id_conv,
       ]);
    }
   //  -- END EDIT for ODPC--



// -- organization_type = CENTRAL Only -- //
   //  -- EDIT for CENTRAL--
   public function edit_assign2(Request $request){

   //เรียกชื่อบุคคลในกล่องงานภารกิจ มาแสดงผล
    if(Auth::user()->emp_level == 3){
       $users = Member::select('id', 'name_th', 'lname_th')
                       ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                       ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
                       ->where('users.id', '=', Auth::user()->id) //select โดย "ไม่เลือก (<>)" ชื่อของผู้ใช้งานมุมขวาบน มาแสดง
                       ->where('users.emp_level', 1) //เอาเฉพาะค่า emp_level= 1 เท่านั้น
                       ->orderby('id','DESC')
                       ->get();
     }else {
       $users = Member::select('id', 'name_th', 'lname_th')
                       ->join('model_has_roles','model_has_roles.model_id','=','users.id')
                       ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
                       ->where('users.id', '=', Auth::user()->id) //select โดย "ไม่เลือก (<>)" ชื่อของผู้ใช้งานมุมขวาบน มาแสดง
                       ->orderby('id','DESC')
                       ->get();
     }

     $leader = Auth::user();
     // dd($leader);

     //แสดงข้อมูล Query
     $query3 = DB::table('task_order')
               ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
               ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
               ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
               ->select(
                       'task_order.id',
                       'task_order.meet_id',
                       'task_order.start_at',
                       'task_order.end_at',
                       'task_order.title AS issue_title',
                       'task_meeting.title AS meet_title',
                       'task_order.title',
                       'roles.id AS roles_id',
                       'roles.name',
                       'roles.name_eng',
                       )
               ->where('task_order.id', $request->id)
               ->whereNull('task_order.delete_at')
               ->first();


     //แสดงข้อมูล USER_OUT from table -> list_user
     $out_u_id = DB::table('model_has_roles')
           ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
           ->join('list_user', 'list_user.id', '=', 'model_has_roles.model_id')
           ->join('task_assign', 'task_assign.users_id', '=', 'list_user.id')
           ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
           ->select ('task_assign.order_id',
                     'list_user.id',
                     )
           ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
           ->where('task_assign.order_id', $request->id)
           ->get();
       // dd($out_u_id);

       $user_out = [];
         if(isset($out_u_id)){
             foreach ($out_u_id as $value){
               $user_out[] = $value->id;
             }
         }
     // dd($user_out);


     //USE In assign_edit.blade CALL SCRIPT url
       $out_u_id_conv = CmsHelper::add_comma($user_out);


     if(!isset($query3)) {
       return abort(404);
     }

       return view('assign::frontend.assign_edit2',
      [
        'members'    => $users,
        'data3'      => $query3,
        'leader'     => $leader,
        'out_u_id_conv' => $out_u_id_conv,
      ]);
   }
  //  -- END EDIT for CENTRAL--


   //  -- EDIT Myself --
   // public function edit_assign_myself(Request $request){
   //
   //   //เรียกชื่อบุคคลในกล่องงานภารกิจ มาแสดงผล
   //    if(Auth::user()->emp_level == 1){
   //      $users_myself = Member::select('id', 'name_th', 'lname_th')
   //                      ->join('model_has_roles','model_has_roles.model_id','=','users.id')
   //                      ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
   //                      ->where('users.id', '=', Auth::user()->id) //select โดย "ไม่เลือก (<>)" ชื่อของผู้ใช้งานมุมขวาบน มาแสดง
   //                      ->orderby('id','DESC')
   //                      ->get();
   //
   //     }
   //
   //     //แสดงข้อมูล Query
   //     $query_myself = DB::table('task_order')
   //                     ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
   //                     ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
   //                     ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
   //                     ->select(
   //                             'task_order.id',
   //                             'task_order.meet_id',
   //                             'task_order.start_at',
   //                             'task_order.end_at',
   //                             'task_order.title AS issue_title',
   //                             'task_meeting.title AS meet_title',
   //                             'task_order.title',
   //                             'roles.id AS roles_id',
   //                             'roles.name',
   //                             'roles.name_eng',
   //                             )
   //                     ->where('task_order.id', $request->id)
   //                     ->whereNull('task_order.delete_at')
   //                     ->first();
   //
   //
   //     $leader = Auth::user();
   //     // dd($leader);
   //
   //
   //     return view('assign::frontend.assign_edit_myself',
   //    [
   //      // 'users_myself' => $users_myself,
   //      'me_myself'    => $query_myself,
   //      'leader'        => $leader,
   //    ]);
   //
   //  }
   //  -- EDIT Myself --



// -- organization_type = ODPC Only -- //

    //Select2 Multiple users_id
    public function List_User_Roles_odpc(Request $request){

      //Receive from assign_edit URL
      $assign_u_out = explode(',', $request->assign_u_out);

      $result = Assign_List_User::query();

      //กรณี search users จะใช้ if
      if(isset($request->searchTerm)){
        $result = $result->select('list_user.id','list_user.user_name');
        // $result = $result->where('list_user.role_id', Auth::user()->roles()->first()->id);
        $result = $result->where('list_user.organization', Auth::user()->organization);
        $result = $result->where('list_user.id', '<>', Auth::user()->id);
        $result = $result->where('list_user.user_name', 'like', '%' . $request->searchTerm . '%');
            if(Auth::user()->emp_level == 3){
              $result = $result->where('list_user.emp_level', 1);
              $result = $result->whereNotIn('list_user.id', $assign_u_out);
            }else {
              $result = $result->where('list_user.emp_level', 2);
              $result = $result->whereNotIn('list_user.id', $assign_u_out);
            }
            // $result = $result->whereNotIn('list_user.id', $assign_u_out);

        $result = $result->orderby('list_user.id','ASC');
        $result = $result->get();
        // echo "1";
        // dd($assign_u_out);

      //กรณี เลือกจาก dropdown จะใช้ else
      }else {
        // echo "2";
        // dd($assign_u_out);
        $result = $result->select('list_user.id', 'list_user.user_name', 'organization_ref_role');
        // $result = $result->where('list_user.role_id', Auth::user()->roles()->first()->id);
        $result = $result->where('list_user.organization', Auth::user()->organization);
        $result = $result->where('list_user.id', '<>', Auth::user()->id);
            if(Auth::user()->emp_level == 3){
              $result = $result->where('list_user.emp_level', 1);
              $result = $result->whereNotIn('list_user.id', $assign_u_out);
            }else {
              $result = $result->where('list_user.emp_level', 2);
              $result = $result->whereNotIn('list_user.id', $assign_u_out);
            }
            // $result = $result->whereNotIn('list_user.id', $assign_u_out);

        $result = $result->orderby('list_user.id','ASC');
        $result = $result->get();
      }

      $datas = array();
      foreach($result as $data){
        $json_datas[] = array("id"=>$data->id, "text"=>$data->user_name);
      }

      //FIX System-Error-Logs by [if]
      if(count($result)>0){
        return response()->json($json_datas);
      }
    }
// -- END organization_type = ODPC Only -- //



// -- organization_type = CENTRAL Only -- //

    //Select2 Multiple users_id
    public function List_User_Roles_central(Request $request){

      //Receive from assign_edit URL
      $assign_u_out = explode(',', $request->assign_u_out);

      $result = Assign_List_User::query();

      //กรณี search users จะใช้ if
      if(isset($request->searchTerm)){
        $result = $result->select('list_user.id','list_user.user_name');
        $result = $result->where('list_user.role_id', Auth::user()->roles()->first()->id);
        $result = $result->where('list_user.id', '<>', Auth::user()->id);
        $result = $result->where('list_user.user_name', 'like', '%' . $request->searchTerm . '%');

            $result = $result->whereNotIn('list_user.id', $assign_u_out);

        $result = $result->orderby('list_user.id','ASC');
        $result = $result->get();

      //กรณี เลือกจาก dropdown จะใช้ else
      }else {
        $result = $result->select('list_user.id','list_user.user_name');
        $result = $result->where('list_user.role_id', Auth::user()->roles()->first()->id);
        $result = $result->where('list_user.id', '<>', Auth::user()->id);

            $result = $result->whereNotIn('list_user.id', $assign_u_out);

        $result = $result->orderby('list_user.id','ASC');
        $result = $result->get();
      }

      $datas = array();
      foreach($result as $data){
        $json_datas[] = array("id"=>$data->id, "text"=>$data->user_name);
      }

      //FIX System-Error-Logs by [if]
      if(count($result)>0){
        return response()->json($json_datas);
      }
    }
// -- END organization_type = CENTRAL Only -- //



// -- START organization_type = ODPC Only -- //

    //  -- INSERT into task_assign for ODPC --
    public function insert_assign_odpc(Request $request){
      $i=0; //index of users_id
        foreach($request->users_id as $value){

        //sender_u_id
        $sender = CmsHelper::Get_UserID(Auth::user()->id);
        //receiver_u_id
        $receiver = CmsHelper::Get_UserID($request->users_id[$i]);

            $data_post = [
              "order_id"     => $request->id,
              "meet_title"   => $request->meet_title,
              "issue_title"  => $request->issue_title,
              "start_at"     => $request->start_at,
              "details"      => $request->issue_title,
              "users_id"     => $request->users_id[$i],
              "leader"       => Auth::user()->id,
              "end_at"       => $request->end_at,
              "assign_date"  => $request->assign_date,
              "status"       => $request->status,
            ];

          if(Auth::user()->emp_level != 3){
              $insert = Assign_meeting::insertGetId($data_post);
          // dd($insert);

              $data_notify[] = [
               "sender_name"   =>  $sender['username'],
               "sender_u_id"   =>  $sender['user_id'],
               "receiver_name" =>  $receiver['username'],
               "receiver_u_id" =>  $receiver['user_id'],
               "subject"       =>  "การมอบหมายงาน",
               "detail"        =>  $request->issue_title,
               // "url_redirect"  =>  "assign/assign_edit/".$request->id."/".$request->roles_id,
               "url_redirect"  =>  "task/order/".$request->id."/assign/".$insert,
               "module_name"   =>  "assign",
              ];

          }elseif (Auth::user()->emp_level == 3){
              $insert = true;
          }

          $i = $i+1;

        }


      if($insert){
          if(Auth::user()->emp_level == 3)
            {
              //Store Procedure เพื่ออัพเดทค่าใน task_order เป็น status = 1 [หัวหน้ากล่อง ส่งไปยัง หัวหน้ากลุ่ม]
              // DB::select("CALL UPDATE_TASK_ORDER_STATUS($request->id, 1)");

                //UPDATE task_order
                DB::table('task_order')
                    ->where('id', $request->id)
                    ->update(['status' => "1"]);

            }elseif (Auth::user()->emp_level == 1) {
               //Store Procedure เพื่ออัพเดทค่าใน task_order เป็น status = 2 [หัวหน้ากลุ่ม ส่งไปยัง ลูกน้อง]
              // DB::select("CALL UPDATE_TASK_ORDER_STATUS($request->id, 2)");

              NotificationAlert::insert($data_notify);

               //UPDATE task_order
                DB::table('task_order')
                    ->where('id', $request->id)
                    ->update(['status' => "2"]);

            }

        //return Sweet Alert
          return redirect()->route('page.assign')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
      }else {
          return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
      }
    }
    //  -- END INSERT for ODPC --




// -- START organization_type = CENTRAL Only -- //

    //  -- INSERT into task_assign for CENTRAL --
    public function insert_assign_central(Request $request){
      $i=0; //index of users_id
        foreach($request->users_id as $value){

        //sender_u_id
        $sender = CmsHelper::Get_UserID(Auth::user()->id);
        //receiver_u_id
        $receiver = CmsHelper::Get_UserID($request->users_id[$i]);

            $data_post = [
              "order_id"     => $request->id,
              "meet_title"   => $request->meet_title,
              "issue_title"  => $request->issue_title,
              "start_at"     => $request->start_at,
              "details"      => $request->issue_title,
              "users_id"     => $request->users_id[$i],
              "leader"       => Auth::user()->id,
              "end_at"       => $request->end_at,
              "assign_date"  => $request->assign_date,
              "status"       => $request->status,
            ];

          if(Auth::user()->emp_level == 3){
            $insert = Assign_meeting::insertGetId($data_post);
            // dd($insert);

              $data_notify[] = [
               "sender_name"   =>  $sender['username'],
               "sender_u_id"   =>  $sender['user_id'],
               "receiver_name" =>  $receiver['username'],
               "receiver_u_id" =>  $receiver['user_id'],
               "subject"       =>  "การมอบหมายงาน",
               "detail"        =>  $request->issue_title,
               // "url_redirect"  =>  "assign/assign_edit/".$request->id."/".$request->roles_id,
               "url_redirect"  =>  "task/order/".$request->id."/assign/".$insert,
               "module_name"   =>  "assign",
              ];
            }

            $i = $i+1;

        }

      if($insert){
          if(Auth::user()->emp_level == 3) {

            NotificationAlert::insert($data_notify);

             //UPDATE task_order
              DB::table('task_order')
                  ->where('id', $request->id)
                  ->update(['status' => "2"]);
            }

        //return Sweet Alert
          return redirect()->route('page.assign')->with('swl_add', 'เพิ่มข้อมูลสำเร็จแล้ว');
      }else {
          return redirect()->back()->with('swl_err', 'บันทึกแล้ว');
      }
    }
//  -- END INSERT for CENTRAL --




    //  -- ASSIGNED --
    public function assigned(Request $request){

    // Show data ALL  EXCEPT = 2
      if(Auth::user()->emp_level != 2 ){
          $query4 = DB::table('task_assign')
              ->join('users', 'users.id', '=', 'task_assign.users_id')
              ->join('model_has_roles','model_has_roles.model_id','=','users.id')
              ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
              ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')

              ->select ('task_assign.order_id',
                        'task_assign.issue_title',
                        'task_assign.start_at',
                        'task_assign.end_at',
                        'task_assign.id AS assign_id',
                        'users.id',
                        'users.name_th',
                        'users.lname_th',
                        'task_order.title',
                        'task_order.id',
                        'task_order_x_roles.roles_id',
                        'task_order_x_roles.order_id',

                        \DB::raw('(CASE WHEN task_assign.read_status = "1" THEN "อ่านแล้ว"
                                        ELSE "ยังไม่ได้อ่าน" END) AS read_status'
                        ))
              ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
              ->groupby('task_order.title')
              ->get();

              // dd($query4);

      return view('assign::frontend.assigned',
        [
         'completed'  => $query4
        ]);
      }
    }
    //  -- END ASSIGNED --




    //  -- ASSIGNED2 --
    public function assigned2(Request $request){

    // Show data ALL  EXCEPT = 2
      if(Auth::user()->emp_level != 2 ){
          $query5 = DB::table('model_has_roles')
              ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
              ->join('users', 'users.id', '=', 'model_has_roles.model_id')
              ->join('task_assign', 'task_assign.users_id', '=', 'users.id')
              ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
              ->select ('task_assign.order_id',
                        'task_assign.issue_title',
                        'task_assign.start_at',
                        'task_assign.end_at',
                        'task_assign.id AS assign_id',
                        'users.id',
                        'users.name_th',
                        'users.lname_th',
                        'task_order.title',
                        'model_has_roles.role_id',
                        'model_has_roles.model_id',

                        \DB::raw('(CASE WHEN task_assign.read_status = "1" THEN "อ่านแล้ว"
                                        ELSE "ยังไม่ได้อ่าน" END) AS read_status'
                        ))
              ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id) //เช็คค่า role_id เฉพาะค่า พวกเดียวกันเท่านั้น จากมุมขวาบน
              ->where('task_assign.order_id', $request->order_id)
              ->get();

     // Show data = 2 ONLY
      }else {
          $query5 = DB::table('task_assign')
              ->join('users', 'users.id', '=', 'task_assign.users_id')
              ->select ('order_id',
                        'issue_title',
                        'start_at',
                        'end_at',
                        'users.name_th',
                        'users.lname_th',
                        'task_assign.id AS assign_id',
                        'users.id',

                        \DB::raw('(CASE WHEN task_assign.read_status = "1" THEN "อ่านแล้ว"
                                        ELSE "ยังไม่ได้อ่าน" END) AS read_status'
                        ))
              ->where('task_assign.users_id', Auth::user()->id)  //ดึงเอาเฉพาะค่า users_id ของตัวเองๆ ที่เข้าใช้งานโดยผ่าน Auth เท่านั้น
              ->get();
            }

      return view('assign::frontend.assigned2',
        [
         'completed2'  => $query5
        ]
      );
    }
    //  -- END ASSIGNED2 --





    //  -- ASSIGNED edit2 --
    public function edit_assigned(Request $request){
      //Select data SHOW in assigned_edit2.blade.php
      $query6 = DB::table('task_assign')
          ->join('users', 'users.id', '=', 'task_assign.users_id')
          ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
          ->select('task_assign.order_id',
                   'task_assign.id AS assign_id',
                   'task_assign.meet_title',
                   'task_assign.issue_title',
                   'task_assign.details',
                   'task_assign.assign_date',
                   'task_order.start_at',
                   'task_order.end_at',
                   'users.name_th',
                   'users.lname_th',
                   'users.id',
                   'task_order.title',
                   )
          ->where('task_assign.id', $request->id)
          ->first();

      if(Auth::user()->id == $query6->id){
           //Store Procedure เพื่ออัพเดทค่าใน task_assign เป็น read_status = 1
          // DB::select("CALL UPDATE_TASK_ASSIGN_READ_STATUS($request->order_id)");
          DB::table('task_assign')
              ->where('id', $request->id)
              ->update(['read_status' => "1"]);
      }

      return view('assign::frontend.assigned_edit2',
        [
          'datax'  => $query6
        ]
      );
    }

    //  -- END ASSIGNED edit2 --








    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('assign::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('assign::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('assign::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }


}
