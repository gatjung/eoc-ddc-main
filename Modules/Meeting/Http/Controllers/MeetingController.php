<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Roles;
use App\TaskMeeting;
use App\TaskOrder;
use App\TaskOrderXGroup;
use App\CmsHelper;
use App\UserX;
use App\NotificationAlert;
use Throwable;
use PDF;

use function GuzzleHttp\json_decode;
use function PHPUnit\Framework\isNull;

class MeetingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('meeting::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    // public function create()
    // {
    //     return view('meeting::create');
    // }
    public function list()
    {
        $query = DB::table('task_meeting')
                ->whereNull('delete_at')
                ->orderBy('id', 'desc')
                ->orderBy('at_date', 'desc')
                ->get();

        return view('meeting::list',['data'=>$query]);
    }

    public function gen_list($roles,$ddcarea,$prefix) {
        //---------------------------[ทุกกลุ่มภารกิจ]--------------
        $data_list = "<div class='row'><div class='col-md-7'>";
        $data_list .= "<div class='icheck-success d-inline'>
        <input type='checkbox' id='".$prefix."check_central' value='all' title='ทุกกลุ่มภารกิจ'
        onClick=\"chkall('".$prefix."check_central','".$prefix."central')\">
        <label for='".$prefix."check_central'> ทุกกลุ่มภารกิจ</label></div>";
        foreach ($roles as $data) {
            $id=$data->id;
            $name=$data->nick;

            $data_list .= "<br><div class='icheck-success d-inline ml-4'>
                    <input type='checkbox' id='".$prefix."check_$id' value='$id' 
                    class='".$prefix."central' title='$name'
                    onClick=\"chkone(this,'".$prefix."check_central','".$prefix."central')\">
                    <label for='".$prefix."check_$id'> $name</label></div>";
        }
        $data_list .= "</div>"; //End col-md-6
        //---------------------------[สคร. - 12 / สปคม.]--------
        $data_list .= "<div class='col-md-5'>";
        $data_list .= "<div class='icheck-success d-inline'>
        <input type='checkbox' id='".$prefix."check_odpc' value='all' title=' สคร.๑- ๑๒ / สปคม.'
        onClick=\"chkall('".$prefix."check_odpc','".$prefix."odpc')\">
        <label for='".$prefix."check_odpc'> สคร.๑- ๑๒ / สปคม.</label></div>";
        foreach ($ddcarea as $ddc) {
            $id=$ddc->code;
            $name=$ddc->nick;

            $data_list .= "<br><div class='icheck-success d-inline ml-4'>
                    <input type='checkbox' id='".$prefix."check_$id' value='$id' 
                    class='".$prefix."odpc' title='$name'
                    onClick=\"chkone(this,'".$prefix."check_odpc','".$prefix."odpc')\">
                    <label for='".$prefix."check_$id'> $name</label></div>";
        }
        $data_list .= "<br><br>
        <div class='input-group mb-3'>
        <div class='input-group-prepend'><div class='input-group-text'>
            <input type='checkbox' id='".$prefix."check_other' value='other'>
        </div></div>
        <input type='text' class='form-control' placeholder='ชื่อผู้รับมอบอื่นๆ' id='".$prefix."check_other_txt'
            onkeydown=\"chkOther(this, '".$prefix."check_other')\">
        </div>";
        //------------------------------------------------------
        $data_list .= "</div>"; //End col-md-6
        $data_list .= "</div>"; //End row

        return $data_list;
    }

    public function order()
    {
        $roles = Roles::where("id","!=",1)->where("organization_ref_role","central")->get();
        $ddcarea = DB::table('ref_ddcarea')->get();
        $data_add = $this->gen_list($roles,$ddcarea,"add");
        $data_edit = $this->gen_list($roles,$ddcarea,"edit");
        return view('meeting::order',['data_add'=>$data_add, 'data_edit'=>$data_edit]);
    }

    public function dbdate($post_date) {
        $d = explode("/",$post_date);
        return $d[2]."-".$d[1]."-".$d[0];
    }
    public function insert(Request $request)
    {
        $id_create = Auth::user()->id;
        //---------------[ข้อมูลการประชุม]------------------
        $meeting = new TaskMeeting;
        $meeting->old_id = $request->old_id;
        $meeting->type = $request->type;
        $meeting->title = strip_tags(trim($request->title));
        $meeting->title_tag = trim($request->title);
        $meeting->at_num = $request->at_num;
        $meeting->at_year = $request->at_year;

        $meeting_at_date = date("Y-m-d");
        if (!empty($request->at_date_submit)) {
            $meeting_at_date = $request->at_date_submit;
        }
        $meeting->at_date = $meeting_at_date;

        $meeting->at_start = "08:30:00";
        if (!empty($request->at_start)) {
            $meeting->at_start = $request->at_start;
        }
        $meeting->at_end = "16:30:00";
        if (!empty($request->at_end)) {
            $meeting->at_end = $request->at_end;
        }
        //การประชุมครั้งถัดไป
        $meeting->book_at_date = date('Y-m-d', strtotime( date('Y-m-d') . " +1 days"));
        if (!empty($request->book_at_date_submit)) {
            $meeting->book_at_date = $request->book_at_date_submit;
        }
        $meeting->book_at_start = "08:30:00";
        if (!empty($request->book_at_start)) {
            $meeting->book_at_start = $request->book_at_start;
        }

        $meeting->at_area = $request->at_area;
        $meeting->detail = $request->detail;
        $meeting->name_sum = $request->name_sum; 
        $meeting->name_check = $request->name_check; 
        $meeting->link_file = $request->link_file;
        $meeting->name_president = $request->president_name;
        $meeting->id_create = $id_create;
        $meeting->save();
        //--------------[ข้อมูลคำสั่งการ]-------------------
        $curr_meeting_id = $meeting->id;  //id การประชุม
        $command = $request->command;     //ข้อสั่งการ
        $central = $request->central;     //กลุ่มที่ได้รับคำสั่ง ส่วนกลาง
        $odpc = $request->odpc;           //กลุ่มที่ได้รับคำสั่ง ภูมิภาค
        $other = $request->other;         //กลุ่มที่ได้รับคำสั่ง อื่นๆ
        $order_end = $request->order_end; //วันที่ต้องส่งงาน
        
        //[notify]
        //$keep_roles_id = [];
        $sender_name = CmsHelper::Get_UserID($id_create)['username'];
        $sender_u_id = $id_create;
        //$receiver_name = '';
        //$receiver_u_id = 0;
        $subject = "ข้อสั่งการจากการประชุม";
        //$detail = '';
        //$url_redirect = "assign/assign_edit/{order_id}/{roles_id}";
        $module_name = 'meeting';
        //-------------sub data--------------
        foreach ($command as $key => $value) {
            //[notify]
            $keep_roles_id = [];

            //post
            $arr = array();
            $arr['central'] = $central[$key];
            $arr['odpc'] = $odpc[$key];
            $arr['other'] = $other[$key];
            $encode = json_encode($arr);
            //-----------------------------------
            $order = new TaskOrder;
            $order->meet_id = $curr_meeting_id;
            $order->title = $value; //ข้อสั่งการ
            $order->encode = $encode;
            $order->start_at = $meeting_at_date; //วันที่เริ่มงาน
            $order->end_at = $order_end[$key]; //กำหนดส่งงาน
            $order->save();
            //--------------[กลุ่มที่รับคำสั่งการ]-------------
            $curr_order_id = $order->id;
            $curr_command = $value;
            $data = []; //ใช้กับ TaskOrderXGroup
            //[ส่วนกลาง]---------------------------------
            if (!empty($central[$key])) {
                $arr = explode(",", $central[$key]);
                foreach ($arr as $id) {
                    if ($id=="all") {
                        $data_role = Roles::where("organization_ref_role", "central")->select('id')->get();
                        foreach ($data_role as $value) {
                            array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'central','other'=>null]);
                            //[notify]
                            array_push($keep_roles_id, $value->id);
                        }
                    } else {
                        array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$id,'org'=>'central','other'=>null]);
                        //[notify]
                        array_push($keep_roles_id, $id);
                    }
                }
            }
            //[ส่วนภูมิภาค]---------------------------------
            if (!empty($odpc[$key])) {
                $arr = explode(",", $odpc[$key]);
                foreach ($arr as $id) {
                    if ($id=="all") {
                        //สคร 1-12
                        $data_role = Roles::where("organization_ref_role", "like", "dpc%")->select('id')->get();
                        foreach ($data_role as $value) {
                            array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>null]);
                            //[notify]
                            array_push($keep_roles_id, $value->id);
                        }
                        //สปคม.
                        $data_role = Roles::where("organization_ref_role", "iudc")->select('id')->get();
                        foreach ($data_role as $value) {
                            array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>null]);
                            //[notify]
                            array_push($keep_roles_id, $value->id);
                        }
                    } else {
                        $data_role = Roles::where("organization_ref_role", $id)->select('id')->get();
                        foreach ($data_role as $value) {
                            array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>null]);
                            //[notify]
                            array_push($keep_roles_id, $value->id);
                        }
                    }
                }
            }
            //[กลุ่มงานอื่นๆ ที่ได้รับมอบหมาย]---------------------------------
            if (!empty($other[$key])) {
                array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>0,'org'=>'other', 'other'=>$other[$key]]);
            }
            //---------------------------------
            TaskOrderXGroup::insert($data);

            //[notify]==================================================
            
            $arr_user=[];
            $arr_url=[];
            $query = DB::table('model_has_roles')->whereIn('role_id',$keep_roles_id)->get();
            
            foreach ($query as $value) {
                array_push($arr_user , $value->model_id);
                $arr_url[$value->model_id]="assign/assign_edit/order/$curr_order_id/roles/".$value->role_id;
            }
            $arr_query = [];
            // echo implode(",",$arr_user). "<br>";
            $query = UserX::whereIn('id',$arr_user)
                    ->where('emp_level',3)
                    // ->whereNull('delete_at')
                    ->select('id')
                    ->get();
                    // dd($query);
            foreach ($query as $value) {
                array_push($arr_query , [
                    'sender_name'=>$sender_name,
                    'sender_u_id'=>$sender_u_id,
                    'receiver_name'=>CmsHelper::Get_UserID($value->id)['username'],
                    'receiver_u_id'=>$value->id,
                    'subject'=>$subject,
                    'detail'=>$curr_command,
                    'url_redirect'=>$arr_url[$value->id],
                    'module_name'=>$module_name
                ]);
            }
            
            NotificationAlert::insert($arr_query);
        }
        //-----------------------------------------------
        return redirect("/meeting/list");   
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
        $meeting = TaskMeeting::where('task_meeting.id',$id)->first();

        $roles = Roles::where("id","!=",1)->where("organization_ref_role","central")->get();
        $ddcarea = DB::table('ref_ddcarea')->get();

        $arrname = array();
        $arrname['central']['all'] = "ทุกกลุ่มภารกิจ";
        foreach ($roles as $data) {
            $arrname['central'][$data->id] = $data->nick;
        }
        $arrname['odpc']['all'] = "สคร.๑- ๑๒ / สปคม.";
        foreach ($ddcarea as $data) {
            $arrname['odpc'][$data->code] = $data->nick;
        }

        $data = array();
        $order = TaskOrder::where('meet_id',$id)->whereNull('delete_at')->get();
        foreach ($order as $val) {
            $arr = array();
            $arr['order_id'] = $val->id;
            $arr['command'] = $val->title;
            $arr['start_at'] = $val->start_at;
            $arr['end_at'] = $val->end_at;
            $arr['encode'] = $val->encode;
            array_push($data, $arr);
        }


        //ด้านล่างกระดาษ
        $note = $meeting->name_sum ." สรุปประเด็นข้อสั่งการ<br>";
        if($meeting->name_check != '') {
            $note .= $meeting->name_check ." ตรวจประเด็นข้อสั่งการ<br>";
        }else{
            $note .= "ยังไม่มีผู้ตรวจประเด็นข้อสั่งการ<br>";
        }
        $note .= "<br><br><br>".$meeting->name_president;

        // $pdf = PDF::loadView('meeting::show',[
        //     'meeting'=>$meeting,
        //     'arrname'=>$arrname,
        //     'order'=>$data,  
        //     'note'=>$note
        // ]);
        // return $pdf->download('meeting.pdf');

        return view('meeting::show',[
            'meeting'=>$meeting,
            'arrname'=>$arrname,
            'order'=>$data,  
            'note'=>$note
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        //การประชุม
        $meeting = TaskMeeting::where('task_meeting.id',$id)->first();

        $roles = Roles::where("id","!=",1)->where("organization_ref_role","central")->get();
        $ddcarea = DB::table('ref_ddcarea')->get();
        $data_add = $this->gen_list($roles,$ddcarea,"add");
        $data_edit = $this->gen_list($roles,$ddcarea,"edit");


        $arrname = array();
        $arrname['central']['all'] = "ทุกกลุ่มภารกิจ";
        foreach ($roles as $data) {
            $arrname['central'][$data->id] = $data->nick;
        }
        $arrname['odpc']['all'] = "สคร.๑- ๑๒ / สปคม.";
        foreach ($ddcarea as $data) {
            $arrname['odpc'][$data->code] = $data->nick;
        }
        
        $data = array();
        $order = TaskOrder::where('meet_id',$id)->whereNull('delete_at')->get();
        foreach ($order as $val) {
            $arr = array();
            $arr['order_id'] = $val->id;
            $arr['command'] = $val->title;
            $arr['end_at'] = $val->end_at;
            $arr['encode'] = $val->encode;
            array_push($data, $arr);
        }

        return view('meeting::edit',[
            'meeting'=>$meeting, 
            'arrname'=>json_encode($arrname),
            'order'=>json_encode($data), 
            'data_add'=>$data_add, 
            'data_edit'=>$data_edit]
        );
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        try {
            //กรณีใส่ค่ามาไม่ครบ
            $at_date = date("Y-m-d");
            if (!empty($request->at_date_submit)) {
                $at_date = $request->at_date_submit;
            }
            $at_start = "08:30:00";
            if (!empty($request->at_start)) {
                $at_start = $request->at_start;
            }
            $at_end = "16:30:00";
            if (!empty($request->at_end)) {
                $at_end = $request->at_end;
            }
            //การประชุมครั้งถัดไป
            $book_at_date = date('Y-m-d', strtotime( date('Y-m-d') . " +1 days"));
            if (!empty($request->book_at_date_submit)) {
                $book_at_date = $request->book_at_date_submit;
            }
            $book_at_start = "08:30:00";
            if (!empty($request->book_at_start)) {
                $book_at_start = $request->book_at_start;
            }
            //---------------[ข้อมูลการประชุม]------------------
            $id_edit=Auth::user()->id;
            TaskMeeting::where('id',$id)->update([
                'title' => strip_tags(trim($request->title)),
                'title_tag' => trim($request->title),
                'at_num' => $request->at_num,
                'at_year' => $request->at_year,
                'at_date' => $at_date,
                'at_start' => $at_start,
                'at_end' =>  $at_end,
                'at_area' => $request->at_area,

                'book_at_date' => $book_at_date,
                'book_at_start' => $book_at_start,

                'detail' => $request->detail,
                'name_president' => $request->president_name,
                'name_sum'=>$request->name_sum,
                'name_check' => $request->name_check,
                'link_file' => $request->link_file,
                'id_edit' => $id_edit
            ]);

            //[กรณีมีการลบ Order]----------------------------
            if(!empty($request->del_orderid)) {
                $actdate =  date("Y-m-d h:i:s");
                $arr = explode(",", $request->del_orderid);
                TaskOrder::whereIn('id', $arr)->update([
                    'delete_at'=>$actdate
                ]);
            }

            //[ค่าที่ต้องเอาไว้ใช้ต่อ]-----------------------------
            $curr_meeting_id = $id; //กรณี update
            $order_chk = $request->data_id; //เอาไว้ดูว่าของเก่าหรือของใหม่ (array)
            $arr_command = $request->command; //คำสั่ง (array)
            $arr_central = $request->central; //ส่วนกลาง (array)
            $arr_odpc = $request->odpc; //ต่างจังหวัด (array)
            $arr_other = $request->other; //อื่นๆ (array)
            $arr_order_end = $request->order_end; //วันที่ต้องส่งงาน (array)

            //[notify]
            //$keep_roles_id = [];
            $sender_name = CmsHelper::Get_UserID($id_edit)['username'];
            $sender_u_id = $id_edit;
            //$receiver_name = '';
            //$receiver_u_id = 0;
            $subject = "ข้อสั่งการจากการประชุม";
            //$detail = '';
            //$url_redirect = "assign/assign_edit/{order_id}/{roles_id}";
            $module_name = 'meeting';
            //[Order]-------------------
            foreach ($order_chk as $key => $value) {
                //[notify]
                $keep_roles_id = [];
                //post
                $command = $arr_command[$key]; //คำสั่ง
                $start = $request->at_date_submit; //วันที่เริ่ม
                $end = $arr_order_end[$key]; //วันที่ต้องส่งงาน

                $arr = array();
                $arr['central'] = $arr_central[$key];
                $arr['odpc'] = $arr_odpc[$key];
                $arr['other'] = $arr_other[$key];
                $encode = json_encode($arr);
                //--------------------------------
                $curr_order_id = 0;
                //[notify]
                $old_role_id = [];

                if( $value == 0 ) {
                    //New Data
                    $order = new TaskOrder;
                    $order->meet_id = $curr_meeting_id;
                    $order->title = $command;
                    $order->encode = $encode;
                    $order->start_at = $start;
                    $order->end_at = $end;
                    $order->save();

                    $curr_order_id = $order->id;
                }else{
                    //Update Data
                    TaskOrder::where('id',$value)->update([
                        'title'=>$command,
                        'encode'=>$encode,
                        'start_at'=>$start,
                        'end_at'=>$end
                    ]);  
                    $curr_order_id = $value;

                    //[notify]
                    $query = TaskOrderXGroup::where('order_id', $curr_order_id)->select('roles_id')->get();
                    foreach ($query as $value) {
                        array_push($old_role_id , $value->roles_id);
                    }

                    //ลบของเดิมก่อน
                    TaskOrderXGroup::where('order_id', $curr_order_id)->delete();
                }  
                //--------------[กลุ่มที่รับคำสั่งการ]-------------
                //เพิ่มของใหม่
                $data = [];
                if(!empty($arr_central[$key])) {
                    $arr = explode(",", $arr_central[$key]);
                    foreach ($arr as $id) {
                        if ($id=="all") {
                            $data_role = Roles::where("organization_ref_role", "central")->select('id')->get();
                            foreach ($data_role as $value) {
                                array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'central','other'=>NULL]);
                                //[notify]
                                array_push($keep_roles_id, $value->id);
                            }
                        } else {
                            array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$id,'org'=>'central','other'=>NULL]);
                            //[notify]
                            array_push($keep_roles_id, $id);
                        }
                    }
                }
               
                //---------------------------------
                if(!empty($arr_odpc[$key])) {
                    $arr = explode(",", $arr_odpc[$key]);
                    foreach ($arr as $id) {
                        if ($id=="all") {
                            //สคร 1-12
                            $data_role = Roles::where("organization_ref_role", "like", "dpc%")->select('id')->get();
                            foreach ($data_role as $value) {
                                array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>NULL]);
                                //[notify]
                                array_push($keep_roles_id, $value->id);
                            }
                            //สปคม.
                            $data_role = Roles::where("organization_ref_role", "iudc")->select('id')->get();
                            foreach ($data_role as $value) {
                                array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>NULL]);
                                //[notify]
                                array_push($keep_roles_id, $value->id);   
                            }
                        } else {
                            $data_role = Roles::where("organization_ref_role", $id)->select('id')->get();
                            foreach ($data_role as $value) {
                                array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>$value->id,'org'=>'odpc','other'=>NULL]);
                                //[notify]
                                array_push($keep_roles_id, $value->id);
                            }
                        }
                    }
                }
                //---------------------------------
                if(!empty($arr_other[$key])) {
                    array_push($data, ['order_id'=>$curr_order_id,'roles_id'=>0,'org'=>'other', 'other'=>$arr_other[$key]]);
                }
                //---------------------------------
                TaskOrderXGroup::insert($data);
                
                //[notify]==================================================
                $arr_user=[];
                $arr_url=[];
                $arr_roles = array_unique($keep_roles_id);
                $query = DB::table('model_has_roles')
                            ->whereIn('role_id',$arr_roles)
                            ->whereNotIn('role_id',$old_role_id)
                            ->get();
                foreach ($query as $value) {
                    array_push($arr_user , $value->model_id);
                    $arr_url[$value->model_id]="assign/assign_edit/order/$curr_order_id/roles/".$value->role_id;
                }
                
                $arr_query = [];
                $query = UserX::whereIn('id',$arr_user)
                        ->where('emp_level',3)
                        // ->whereNull('delete_at')
                        ->select('id')
                        ->get(); 
                foreach ($query as $value) {
                    array_push($arr_query , [
                        'sender_name'=>$sender_name,
                        'sender_u_id'=>$sender_u_id,
                        'receiver_name'=>CmsHelper::Get_UserID($value->id)['username'],
                        'receiver_u_id'=>$value->id,
                        'subject'=>$subject,
                        'detail'=>$command,
                        'url_redirect'=>$arr_url[$value->id],
                        'module_name'=>$module_name
                    ]);
                }
                
                NotificationAlert::insert($arr_query);
            //-----------------------------------------------
            }
           return redirect("/meeting/list");
       } catch (Throwable $e) {
           echo $e;
           return false;
       }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $actdate =  date("Y-m-d h:i:s");
        TaskMeeting::where('id',$id)->update([
            'delete_at'=>$actdate
        ]);
  
        return redirect("/meeting/list");
    }
}
