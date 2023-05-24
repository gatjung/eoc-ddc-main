<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;
use App\Roles;
use App\Organization;
use App\TalentDrive;
use App\TalentCourse;
use App\Talent;
use App\Position;
use App\RefPrefix;
use App\Command;
use App\CommandList;
use App\UserX;
use App\Member;
use App\DBModelHasRoles;
use App\DBJobLevel;
use App\DBModelHasRolesLog;
use App\CmsHelper;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;
use Session;
use Mail;
use App\Mail\ApproveUserMail;
// use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use App\Exports\UsersExport;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index(Request $request)
    {
        // dd($request);
        // $arr_confirm = array("รอการยืนยันการสมัครสมาชิก" => 0, "สมัครสมาชิกแล้ว" => 1);

        // dd($request->confirm);
        // $roles = Roles::select('id','name')->where('status',1)->get();

        // foreach ($roles as $value_roles) {
        //     $roles_ref[$value_roles->id] = trim($value_roles->name);
        // }

        // dd($roles_ref);
        // $model_has_roles = DBModelHasRoles::select('role_id', 'model_id')->limit(10)->get();
        // dd($model_has_roles);

        Session::put('name_th', $request->name_th);
        Session::put('lname_th', $request->lname_th);
        Session::put('organization', $request->organization);
        Session::put('position', $request->position);
        Session::put('confirm', $request->confirm);
        //dd($request->roles);

        // dd(Session::get('confirm'));

        $query_user = Member::select('id','name_th','lname_th','organization' , 'model_has_roles.role_id AS roleID' ,'position','email','phone','lineid','confirm');

        if ($request->name_th) {
            $query_user->where('name_th', 'like', '%'.Session::get('name_th').'%');
        }

        if ($request->lname_th) {
            $query_user->where('lname_th', 'like', '%'.Session::get('lname_th').'%');
        }

        if ($request->organization) {
            $query_user->where('organization', Session::get('organization'));
        }

        if ($request->position) {
            $query_user->where('position', Session::get('position'));
        }

        if ($request->phone) {
            $query_user->where('phone', 'like', '%'.$request->phone.'%');
        }

        if ($request->roles) {
            //$query_user->join('model_has_roles', 'model_has_roles.model_id' ,'=', 'id');
            $query_user->where('model_has_roles.role_id', $request->roles);

        }

        if ($request->confirm == 2) {
            $query_user->where('confirm', 2);
        }

        if ($request->confirm == 1) {
            $query_user->where('confirm', Session::get('confirm'));
        }

        if ($request->confirm == '0') {
            $query_user->where('confirm', 0);
        }

        $data = $query_user
                ->join('model_has_roles', 'model_has_roles.model_id' ,'=', 'id')
                ->OrderBy('id', 'desc')
                ->get();

        $position = Member::select('position')->whereNotNull('position')->groupBy('position')->get();
        $organization = Member::select('organization')->whereNotNull('organization')->groupBy('organization')->get();
        $roles = Roles::select('id','name')->where ('status',1)->get();
        //$roles = Roles::select('id','name')->get();
        //dd($roles);

        // dd($data);
        // dd($organization);
        // dd($position_id);

        return view('hr::users.index', [
                    'data'                  => $data,
                    'position'              => $position,
                    'organization'          => $organization,
                    'roles'                 => $roles,
                    'name_th'               => $request->name_th,
                    'lname_th'              => $request->lname_th,
                    'phone'                 => $request->phone,
                    'organization_select'   => $request->organization,
                    'role_select'           => $request->roles,
                    'position_select'       => $request->position,
                    'confirm_select'        => $request->confirm
                ]);
    }



    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }


    public function show(request $request)
    {
        // $preth =
        // $preen =

        $organ = Organization::select('organization_id','organization_name')->get();
        $posit = Position::select('position_id','position_name')->get();
        $roles = Roles::select('id','name','name_eng')->where ('status',1)->get();
        $ref_prefix = RefPrefix::select('id','name_th','name_en')->get();
        $talent = Talent::select('id','talent_name')->whereNotIn('id',[99])->get();
        $talent_drive = TalentDrive::select('id','drive')->whereNotIn('id',[99])->get();
        $talent_course = TalentCourse::select('id as course_id','course')->whereNotIn('id',[99])->get();
        $command = Command::select('id','comm_num','comm_date','status')
                    ->where('status', '!=', 0)
                    ->where('user_id', Auth::user()->id)->get();
        $command_list = CommandList::join('command', 'command.comm_num', '=', 'command_list.comm_num')
                        ->select('command_list.id','command_list.organ','command_list.comm_num','command_list.comm_date','command_list.file_name','command_list.file_ori_name','command_list.status','command.id','command.user_id','command.comm_num','command.status')
                        ->where('command_list.status', '!=', 0)
                        ->where('command.status', '!=', 0)
                        ->where('command.user_id', Auth::user()->id)->get();
        $users = Member::find(Auth::user()->id);
        $arr_division_part = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");
        $job_level = DBJobLevel::select('id', 'job_level_name')->get();
        $emp_level = array("1" => "หัวหน้างาน", "2" => "ผู้ปฏิบัติงาน");

        return view('hr::users.show', [
            'ref_prefix' => $ref_prefix,
            'talent' => $talent,
            'talent_drive' => $talent_drive,
            'talent_course' => $talent_course,
            'roles'=>$roles,
            'posit_ref'=>$posit,
            'org_ref'=>$organ,
            'command'=>$command,
            'command_list'=>$command_list,
            "users" => $users,
            'organization_type' => $arr_division_part,
            'job_level' => $job_level,
            'emp_level' => $emp_level
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $organ = Organization::select('organization_id','organization_name')->get();
        $posit = Position::select('position_id','position_name')->get();
        $roles = Roles::select('id','name','name_eng')->where ('status',1)->get();
        $ref_prefix = RefPrefix::select('id','name_th','name_en')->get();
        $talent = Talent::select('id','talent_name')->whereNotIn('id',[99])->get();
        $talent_drive = TalentDrive::select('id','drive')->whereNotIn('id',[99])->get();
        $talent_course = TalentCourse::select('id as course_id','course')->whereNotIn('id',[99])->get();
        $command = Command::select('id','comm_num','comm_date','status')
                    ->where('status', '!=', 0)
                    ->where('user_id', $id)->get();
        $command_list = CommandList::join('command', 'command.comm_num', '=', 'command_list.comm_num')
                        ->select('command_list.id','command_list.organ','command_list.comm_num','command_list.comm_date','command_list.file_name','command_list.file_ori_name','command_list.status','command.id','command.user_id','command.comm_num','command.status')
                        ->where('command_list.status', '!=', 0)
                        ->where('command.status', '!=', 0)
                        ->where('command.user_id', $id)
                        ->get();
        $users = Member::find($id);
        $arr_division_part = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");
        $job_level = DBJobLevel::select('id', 'job_level_name')->get();
        $emp_level = array("1" => "หัวหน้างาน","2" => "ผู้ปฏิบัติงาน");

        return view('hr::users.edituser', [
            'ref_prefix' => $ref_prefix,
            'talent' => $talent,
            'talent_drive' => $talent_drive,
            'talent_course' => $talent_course,
            'roles'=>$roles,
            'posit_ref'=>$posit,
            'org_ref'=>$organ,
            'command'=>$command,
            'command_list'=>$command_list,
            "users" => $users,
            'organization_type' => $arr_division_part,
            'job_level' => $job_level,
            'emp_level' => $emp_level
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        // $this->validate($request, [
        //     'name' => 'required',
        //     'permission' => 'required',
        // ]);

        if($request->comm_id!=null){
            // dd("yes");

            foreach($request->comm_id as $key => $value_id){

                $command            = Command::find($value_id);
                $command->comm_num  =  $request->comm_num[$key];
                $command->comm_date =  $request->comm_date[$key];
                $command->status    =  $request->status[$key];
                // echo $command;
                // dd($command);

                $command->save();

            }
            // dd($data_value_id);
            // Command::where('comm_id', $value_id)->update($data_command);
        }

        // $user_data = Member::find(Auth::user()->id);
        // $user_data->prefix_th = $request->prefix_th;
        // $user_data->name_th = (!empty($request->name_th)) ? trim($request->name_th) : NULL;
        // $user_data->lname_th = (!empty($request->lname_th)) ? trim($request->lname_th): NULL;
        // $user_data->prefix_eng = $request->prefix_eng;
        // $user_data->name_eng = (!empty($request->name_th)) ? strtolower(trim($request->name_eng)) : NULL;
        // $user_data->lname_eng = (!empty($request->lname_eng)) ? strtolower(trim($request->lname_eng)) : NULL;
        // $user_data->cid = (!empty($request->cid)) ? trim($request->cid) : NULL;
        // $user_data->birthdate = $request->birthdate;
        // $user_data->gender = $request->gender;
        // $user_data->position = (!empty($request->position)) ? trim($request->position) : NULL;
        // $user_data->organization = $request->organization;
        // $user_data->organization_type = (!empty($request->organization_type)) ? $request->organization_type : NULL;
        // $user_data->job_level = (!empty($request->job_level)) ? $request->job_level : NULL;
        // $user_data->emp_level = (!empty($request->emp_level)) ? $request->emp_level : NULL;
        // $user_data->phone = (!empty($request->phone)) ? trim($request->phone) : NULL;
        // $user_data->email = (!empty($request->email)) ? strtolower(trim($request->email)) : NULL;
        // $user_data->lineid = (!empty($request->lineid)) ? trim($request->lineid) : NULL;
        // $user_data->address = (!empty($request->address)) ? trim($request->address) : NULL;
        // $user_data->talent_lang_eng = (!empty($request->talent_lang_eng)) ? $request->talent_lang_eng : 99;
        // $user_data->talent_lang_chn = (!empty($request->talent_lang_chn)) ? $request->talent_lang_chn : 99;
        // $user_data->talent_lang_jpn = (!empty($request->talent_lang_jpn)) ? $request->talent_lang_jpn : 99;
        // $user_data->talent_lang_kor = (!empty($request->talent_lang_kor)) ? $request->talent_lang_kor : 99;
        // $user_data->talent_lang_myn = (!empty($request->talent_lang_myn)) ? $request->talent_lang_myn : 99;
        // $user_data->talent_lang_cam = (!empty($request->talent_lang_cam)) ? $request->talent_lang_cam : 99;
        // $user_data->talent_lang_fra = (!empty($request->talent_lang_fra)) ? $request->talent_lang_fra : 99;
        // $user_data->talent_lang_spn = (!empty($request->talent_lang_spn)) ? $request->talent_lang_spn : 99;
        // $user_data->talent_drive  = (!empty($request->talent_drive)) ? $request->talent_drive : 99;
        // $user_data->talent_course = (!empty($request->talent_course)) ? $request->talent_course : 99;

        $data_user = array(
            'prefix_th'         =>  $request->prefix_th,
            'name_th'           =>  (!empty($request->name_th)) ? trim($request->name_th) : NULL,
            'lname_th'          =>  (!empty($request->lname_th)) ? trim($request->lname_th): NULL,
            'prefix_eng'        =>  $request->prefix_eng,
            'name_eng'          =>  (!empty($request->name_th)) ? strtolower(trim($request->name_eng)) : NULL,
            'lname_eng'         =>  (!empty($request->lname_eng)) ? strtolower(trim($request->lname_eng)) : NULL,
            'cid'               =>  (!empty($request->cid)) ? trim($request->cid) : NULL,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $request->gender,
            'position'          =>  (!empty($request->position)) ? trim($request->position) : NULL,
            'organization'      =>  $request->organization,
            'organization_type' =>  (!empty($request->organization_type)) ? $request->organization_type : NULL,
            'job_level'         =>  (!empty($request->job_level)) ? $request->job_level : NULL,
            'emp_level'         =>  (!empty($request->emp_level)) ? $request->emp_level : NULL,
            'phone'             =>  (!empty($request->phone)) ? trim($request->phone) : NULL,
            'email'             =>  (!empty($request->email)) ? strtolower(trim($request->email)) : NULL,
            'lineid'            =>  (!empty($request->lineid)) ? trim($request->lineid) : NULL,
            'address'           =>  (!empty($request->address)) ? trim($request->address) : NULL,
            'talent_lang_eng'   =>  (!empty($request->talent_lang_eng)) ? $request->talent_lang_eng : 99,
            'talent_lang_chn'   =>  (!empty($request->talent_lang_chn)) ? $request->talent_lang_chn : 99,
            'talent_lang_jpn'   =>  (!empty($request->talent_lang_jpn)) ? $request->talent_lang_jpn : 99,
            'talent_lang_kor'   =>  (!empty($request->talent_lang_kor)) ? $request->talent_lang_kor : 99,
            'talent_lang_myn'   =>  (!empty($request->talent_lang_myn)) ? $request->talent_lang_myn : 99,
            'talent_lang_cam'   =>  (!empty($request->talent_lang_cam)) ? $request->talent_lang_cam : 99,
            'talent_lang_fra'   =>  (!empty($request->talent_lang_fra)) ? $request->talent_lang_fra : 99,
            'talent_lang_spn'   =>  (!empty($request->talent_lang_spn)) ? $request->talent_lang_spn : 99,
            'talent_drive'      =>  (!empty($request->talent_drive)) ? $request->talent_drive : 99,
            'talent_course'     =>  (!empty($request->talent_course)) ? $request->talent_course : 99,
        );

        // dd($request->roles);
        // $user_data->save();
        $data_roles = array(
            'role_id'   => $request->roles
        );

        // $data_roles_log             =   new DBModelHasRolesLog;
        // $data_roles_log->role_id    =   $request->roles;
        // $data_roles_log->model_type =   "App\User";
        // $data_roles_log->model_id   =   Auth::user()->id;
        // $data_roles_log->save();

        DBModelHasRoles::where('model_id', Auth::user()->id)
            ->update($data_roles);

        $update_profile = Member::where('id', Auth::user()->id)
            ->update($data_user);

        if ($update_profile) {
            return redirect()->back()->with('success', 'แก้ไขข้อมูลส่วนตัวสำเร็จ');
        } else {
            return redirect()->back()->with('error', 'แก้ไขข้อมูลส่วนตัวไม่สำเร็จ');
        }

    }

    public function update_hr(Request $request, $id)
    {

        if($request->comm_id!=null){
            // dd("yes");

            foreach($request->comm_id as $key => $value_id){

                $command            = Command::find($value_id);
                $command->comm_num  =  $request->comm_num[$key];
                $command->comm_date =  $request->comm_date[$key];
                $command->status    =  $request->status[$key];
                // echo $command;
                // dd($command);

                $command->save();

            }
            // dd($data_value_id);
            // Command::where('comm_id', $value_id)->update($data_command);
        }



        $data_user = array(
            'prefix_th'         =>  $request->prefix_th,
            'name_th'           =>  (!empty($request->name_th)) ? trim($request->name_th) : NULL,
            'lname_th'          =>  (!empty($request->lname_th)) ? trim($request->lname_th): NULL,
            'prefix_eng'        =>  $request->prefix_eng,
            'name_eng'          =>  (!empty($request->name_th)) ? strtolower(trim($request->name_eng)) : NULL,
            'lname_eng'         =>  (!empty($request->lname_eng)) ? strtolower(trim($request->lname_eng)) : NULL,
            'cid'               =>  (!empty($request->cid)) ? trim($request->cid) : NULL,
            'birthdate'         =>  $request->birthdate,
            'gender'            =>  $request->gender,
            'position'          =>  (!empty($request->position)) ? trim($request->position) : NULL,
            'organization'      =>  $request->organization,
            'organization_type' =>  (!empty($request->organization_type)) ? $request->organization_type : NULL,
            'job_level'         =>  (!empty($request->job_level)) ? $request->job_level : NULL,
            'emp_level'         =>  (!empty($request->emp_level)) ? $request->emp_level : NULL,
            'phone'             =>  (!empty($request->phone)) ? trim($request->phone) : NULL,
            'email'             =>  (!empty($request->email)) ? strtolower(trim($request->email)) : NULL,
            'lineid'            =>  (!empty($request->lineid)) ? trim($request->lineid) : NULL,
            'address'           =>  (!empty($request->address)) ? trim($request->address) : NULL,
            'talent_lang_eng'   =>  (!empty($request->talent_lang_eng)) ? $request->talent_lang_eng : 99,
            'talent_lang_chn'   =>  (!empty($request->talent_lang_chn)) ? $request->talent_lang_chn : 99,
            'talent_lang_jpn'   =>  (!empty($request->talent_lang_jpn)) ? $request->talent_lang_jpn : 99,
            'talent_lang_kor'   =>  (!empty($request->talent_lang_kor)) ? $request->talent_lang_kor : 99,
            'talent_lang_myn'   =>  (!empty($request->talent_lang_myn)) ? $request->talent_lang_myn : 99,
            'talent_lang_cam'   =>  (!empty($request->talent_lang_cam)) ? $request->talent_lang_cam : 99,
            'talent_lang_fra'   =>  (!empty($request->talent_lang_fra)) ? $request->talent_lang_fra : 99,
            'talent_lang_spn'   =>  (!empty($request->talent_lang_spn)) ? $request->talent_lang_spn : 99,
            'talent_drive'      =>  (!empty($request->talent_drive)) ? $request->talent_drive : 99,
            'talent_course'     =>  (!empty($request->talent_course)) ? $request->talent_course : 99
        );

        // dd($request->roles);
        // $user_data->save();
        $data_roles = array(
            'role_id'   => $request->roles
        );

        // $data_roles_log             =   new DBModelHasRolesLog;
        // $data_roles_log->role_id    =   $request->roles;
        // $data_roles_log->model_type =   "App\User";
        // $data_roles_log->model_id   =   Auth::user()->id;
        // $data_roles_log->save();

        DBModelHasRoles::where('model_id', $id)
            ->update($data_roles);

        $update_profile = Member::where('id', $id)
            ->update($data_user);

        if ($update_profile) {
            return redirect()->route('users.edit', $id)->with('success', 'แก้ไขข้อมูลส่วนตัวสำเร็จ');
        } else {
            return redirect()->route('users.edit', $id)->with('error', 'แก้ไขข้อมูลส่วนตัวไม่สำเร็จ');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        DB::table("users")->where('id', $request->id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'Users deleted successfully');
    }

    public function Get_List_Organization_Old(Request $request)
    {
        $users = Member::find($request->id);

        if(empty($request->organization_type)) return false;

        $datas = Organization::where('organization_type',$request->organization_type)->OrderBy('organization_type','asc')->get();

        $htm = "<option value=\"\">-- กรุณาเลือกหน่วยงาน --</option>\n";
        foreach($datas as $key=>$value) {
            $htm .= "<option value='".$value->organization_id."'".($value->organization_id == $users->organization ? 'selected' : '').">".$value->organization_name."</option>\n";

        }
        return $htm;
    }

    public function Get_List_Organization(Request $request)
    {
        if(empty($request->organization_type)) return false;

        $datas = Organization::where('organization_type',$request->organization_type)->OrderBy('organization_type','asc')->get();

        $htm = "<option value=\"\">-- กรุณาเลือกหน่วยงาน --</option>\n";
        foreach($datas as $key=>$value) {
                    $htm .= "<option value=\"".$value->organization_id."\">".$value->organization_name."</option>\n";
            }
            return $htm;
    }

    public function Get_Role_Group_By_Old(Request $request)
    {
        $users = Member::find($request->id);

        $model_has_roles = DBModelHasRoles::select('role_id')->where('model_id',$request->id)->first();
        // echo $model_has_roles->model_id;
        // echo $users->organization;

        if(empty($users->organization)) return false;

        $select_field = Organization::select('organization_ref_role')->where('organization_id',$users->organization)->first();

        $datas = Roles::where('organization_ref_role',$select_field->organization_ref_role)->where('status',"1")->get();

        // echo $datas->organization_ref_role;

        $htm = "<option value=\"\">-- กรุณาเลือกกลุ่มภารกิจ --</option>\n";
        foreach($datas as $key=>$value) {
                    $htm .= "<option value='".$value->id."'".($value->id == $model_has_roles->role_id ? 'selected' : '').">".$value->name."</option>\n";
            }
        return $htm;
    }

    public function Get_Role_Group_By(Request $request)
    {
        if(empty($request->organization_id)) return false;

        $select_field = Organization::select('organization_ref_role')->where('organization_id',$request->organization_id)->first();

        $datas = Roles::where('organization_ref_role',$select_field->organization_ref_role)->where('status',"1")->get();

        $htm = "<option value=\"\">-- กรุณาเลือกกลุ่มภารกิจ --</option>\n";
        foreach($datas as $key=>$value) {
                    $htm .= "<option value=\"".$value->id."\">".$value->name."</option>\n";
            }
            return $htm;
    }

    public function destroy_command(Request $request)
    {
        // dd($request->id);
        // $data_score = [
        //     'status'    =>  0
        // ];

        // $delete = Command::where('id', $comm_id)->where('user_id', $user_id)
        //     ->update($data_score);
        // $id = Auth::user()->id;

        $delete = Command::find($request->id);
        $delete->status = '0';
        $delete->save();

        if ($delete) {
            return redirect()->route('users.show')->with('success','ลบเลขคำสั่งสำเร็จ');
        } else {
            return redirect()->route('users.show')->with('error','ลบเลขคำสั่งไม่สำเร็จ !!!');
        }
    }

    public function destroy_command_hr(Request $request, $id)
    {
        // $data_score = [
        //     'status'    =>  0
        // ];

        // $delete = Command::where('id', $comm_id)->where('user_id', $id)
        //     ->update($data_score);
        //  $id = Auth::user()->id;

        $delete = Command::find($request->id);
        $delete->status = '0';
        $delete->save();

        if ($delete) {
            return redirect()->route('users.edit', Auth::user()->id)->with('success','ลบเลขคำสั่งสำเร็จ');
        } else {
            return redirect()->route('users.edit', Auth::user()->id)->with('error','ลบเลขคำสั่งไม่สำเร็จ !!!');
        }
    }

    public function add_command()
    {
        $command_list = CommandList::select('id','comm_num','comm_date','status')->where('status', '!=', 0)->get();
        return view('hr::users.addcommand', [
            'command_list'=>$command_list
        ]);
    }

    public function add_command_hr($id)
    {
        $command_list = CommandList::select('id','comm_num','comm_date','status')->where('status', '!=', 0)->get();
        return view('hr::users.addcommand_hr', [
            'id' => $id,
            'command_list'=>$command_list
        ]);
    }

    public function insert_command(Request $request)
    {

        if($request->comm_num[0]!=null){
            foreach($request->comm_num as $key => $value){
            //$data[] = $request->comm_num[$i];
                // $data_command[] = array(
                //     //"user_id"   => $member_id->id,
                //     "user_id"   => $member_id,
                //     "comm_num"  => trim($value),
                //     "comm_date" => trim($request->comm_date[$key]),
                //     "status"    => "1"
                //     // "comm_num"  => (!empty($request->comm_num)) ? $request->comm_num : NULL,
                //     // "comm_date" => (!empty($request->comm_date)) ? $request->comm_date : Date('Y-m-d')
                // );

                $field_command              = new Command;
                $field_command->user_id     = Auth::user()->id;
                $field_command->comm_num    = trim($value);
                $field_command->comm_date   = trim($request->comm_date[$key]);
                $field_command->status      = 1;
                $field_command->save();




            }
             return redirect()->route('users.show')->with('success','เพิ่มเลขคำสั่งสำเร็จ');
            //dd($data_command);
            // Command::insert($data_command);
        }
    }

    public function insert_command_hr(Request $request, $id)
    {
        if($request->comm_num[0]!=null){
            foreach($request->comm_num as $key => $value){
            //$data[] = $request->comm_num[$i];
                // $data_command[] = array(
                //     //"user_id"   => $member_id->id,
                //     "user_id"   => $member_id,
                //     "comm_num"  => trim($value),
                //     "comm_date" => trim($request->comm_date[$key]),
                //     "status"    => "1"
                //     // "comm_num"  => (!empty($request->comm_num)) ? $request->comm_num : NULL,
                //     // "comm_date" => (!empty($request->comm_date)) ? $request->comm_date : Date('Y-m-d')
                // );

                $field_command              = new Command;
                $field_command->user_id     = $id;
                $field_command->comm_num    = trim($value);
                $field_command->comm_date   = trim($request->comm_date[$key]);
                $field_command->status      = 1;
                $field_command->save();




            }
            return redirect()->route('users.edit', $id)->with('success','เพิ่มเลขคำสั่งสำเร็จ');
            //dd($data_command);
            // Command::insert($data_command);
        }
    }


    public function export()
    {


        // if (Session::get('name_th')) {
        //     dd('yes');
        // }else{
        //     dd('no');
        // }


        // $pre_th_arr         = CmsHelper::Get_Prefix_TH();
        // $pre_end_arr        = CmsHelper::Get_Prefix_EN();
        // $pos_th_arr         = CmsHelper::Get_Position_TH();
        // $org_th_arr         = CmsHelper::Get_Organization_TH();
        // $arr_division_part  = [1 => "หน่วยงานส่วนกลาง", 2 => "หน่วยงานส่วนภูมิภาค", null => "ไม่ระบุ"];
        // $job_level_arr      = CmsHelper::Get_JobLevel();
        // $emp_level_arr      = array(1 => "หัวหน้างาน", 2 => "ผู้ปฏิบัติงาน", 3 => "หัวหน้ากล่องภารกิจ", null => "ไม่ระบุ");

        // // dd($job_level_arr);

        // $member = Member::select('prefix_th' ,'name_th','lname_th', 'prefix_eng', 'name_eng', 'lname_eng', 'position' , 'organization', 'emp_level','organization_type', 'job_level', 'phone', 'email');

        // // dd($member);
        // if (Session::get('name_th')) {
        //     $member->where('name_th', 'like', '%'.Session::get('name_th').'%');
        // }

        // if (Session::get('lname_th')) {
        //     $member->where('lname_th', 'like', '%'.Session::get('lname_th').'%');
        // }

        // if (Session::get('organization')) {
        //     $member->where('organization', Session::get('organization'));
        // }

        // if (Session::get('position')) {
        //     $member->where('position', Session::get('position'));
        // }

        // $data_member = $member->limit(10)->get();



        // foreach ($data_member as $value_member) {
        //     $data[] = array(
        //         "prefix_th"         => $pre_th_arr[$value_member->prefix_th],
        //         "name_th"           => $value_member->name_th,
        //         "lname_th"          => $value_member->lname_th,
        //         "prefix_eng"        => $pre_end_arr[$value_member->prefix_eng],
        //         "name_eng"          => $value_member->name_eng,
        //         "lname_eng"         => $value_member->lname_eng,
        //         "position"          => $pos_th_arr[$value_member->position],
        //         "job_level"         => (!empty($value_member->job_level)) ? $job_level_arr[$value_member->job_level] : "ไม่ระบุ",
        //         "organization_type" => $arr_division_part[$value_member->organization_type],
        //         "organization"      => $org_th_arr[$value_member->organization],
        //         "emp_level"         => $emp_level_arr[$value_member->emp_level],
        //         "phone"             => $value_member->phone,
        //         "email"             => $value_member->email
        //     );
        // }
        // dd($data);

        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function approve_user($confirm, $id, $email)
    {
        $member                     = Member::find($id);
        $member->confirm            = $confirm;
        $member->user_hr_confirm    = Auth::user()->id;
        $member->confirm_date       = date("Y-m-d H:i:s");

        if ($member->save() && $confirm == 0) {
            return redirect()->back()->with('error','ยกเลิกการสมัครสมาชิกสำเร็จ');
        } elseif ($member->save() && $confirm == 1) {
            $details = [
                'name'          => $member->name_th,
                'lname'         => $member->lname_th,
            ];

            \Mail::to($email)->send(new ApproveUserMail($details));

            return redirect()->back()->with('success','ยืนยันการสมัครสมาชิกสำเร็จ');
        }
    }

    public function check_user_command($id)
    {
        $member                     =   Member::find($id);
        $member->confirm            =   2;
        $member->user_hr_confirm    =   Auth::user()->id;
        $member->confirm_date       =   date("Y-m-d H:i:s");

        // dd($member);
        if ($member->save()) {
            return redirect()->route('users.index')->with('success','เปลี่ยนสถานะ ไม่มีชื่อในกล่องภาระกิจ สำเร็จ');
        }
    }
}
