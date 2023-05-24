<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Member;
use App\Position;
use App\Organization;
use App\Roles;
use App\RefPrefix;
use App\Talent;
use App\TalentDrive;
use App\TalentCourse;
use App\Command;
use App\DBJobLevel;
use Illuminate\Support\Facades\Hash;
use App\DBModelHasRoles;
use App\DBModelHasRolesLog;
use Browser;
use App\CmsHelper;


class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('member::index');
    }



    public function register()
    {
        $organ = Organization::select('organization_id','organization_name')->get();
        $posit = Position::select('position_id','position_name')->get();
        $roles = Roles::select('id','name','name_eng')->where ('status',1)->get();
        $ref_prefix = RefPrefix::select('id','name_th','name_en')->get();
        $talent = Talent::select('id','talent_name')->whereNotIn('id',[99])->get();
        $talent_drive = TalentDrive::select('id','drive')->whereNotIn('id',[99])->get();
        $talent_course = TalentCourse::select('id as course_id','course')->whereNotIn('id',[99])->get();
        // $command = Command::select('comm_id','comm_num','comm_date')->get();
        $job_level = DBJobLevel::select('id', 'job_level_name')->get();
        //$emp_level = array("1" => "หัวหน้างาน", "2" => "ผู้ปฏิบัติงาน", "3" => "หัวหน้ากล่องภารกิจ");
        $emp_level = array("1" => "หัวหน้างาน", "2" => "ผู้ปฏิบัติงาน");
        $arr_division_part = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");

        return view('member::frontend.register',[
          'org_ref'=>$organ,
          'posit_ref'=>$posit,
          'roles'=>$roles,
          'ref_prefix' => $ref_prefix,
          'talent' => $talent,
          'talent_drive' => $talent_drive,
          'talent_course' => $talent_course,
          // 'command'=>$command,
          'organization_type' => $arr_division_part,
          'emp_level' => $emp_level,
          'job_level' => $job_level
        ]);

    }


    public function checkRepeat(Request $request){
        // dd($request->get('cid'));
        $check_repeat = Member::where($request->get('where'), $request->get('data'))
                            ->first();

        return response()->json(['data_repeat'=> $check_repeat]);

    }

    public function insert(Request $request){

        $check_dublicate_user = Member::where('email',strtolower(trim($request->email)))->first();
        $browserName = Browser::browserName();
        $osName = Browser::platformName();

        if (!$check_dublicate_user === null) {
            return redirect()->back()->with('error','พบชื่อผู้ใช้งาน '.strtolower(trim($request->username)).' ในระบบแล้ว');
        }

            $user_data = [
                "username"          =>  strtolower(trim($request->username)),
                "password"          =>  trim(Hash::make($request->password)),
                "prefix_th"         =>  $request->prefix_th,
                "name_th"           =>  (!empty($request->name_th)) ? trim($request->name_th) : NULL,
                "lname_th"          =>  (!empty($request->lname_th)) ? trim($request->lname_th): NULL,
                "prefix_eng"        =>  $request->prefix_eng,
                "name_eng"          =>  (!empty($request->name_th)) ? strtolower(trim($request->name_eng)) : NULL,
                "lname_eng"         =>  (!empty($request->lname_eng)) ? strtolower(trim($request->lname_eng)) : NULL,
                "cid"               =>  (!empty($request->cid)) ? trim($request->cid) : NULL,
                "birthdate"         =>  $request->birthdate,
                "gender"            =>  $request->gender,
                "position"          =>  (!empty($request->position)) ? trim($request->position) : NULL,
                "organization"      =>  $request->organization,
                "organization_type" =>  (!empty($request->organization_type)) ? $request->organization_type : NULL,
                "job_level"         =>  (!empty($request->job_level)) ? $request->job_level : NULL,
                "emp_level"         =>  (!empty($request->emp_level)) ? $request->emp_level : NULL,
                "phone"             =>  (!empty($request->phone)) ? trim($request->phone) : NULL,
                "email"             =>  (!empty($request->email)) ? strtolower(trim($request->email)) : NULL,
                "lineid"            =>  (!empty($request->lineid)) ? trim($request->lineid) : NULL,
                "address"           =>  (!empty($request->address)) ? trim($request->address) : NULL,
                "talent_lang_eng"   =>  (!empty($request->talent_lang_eng)) ? $request->talent_lang_eng : 99,
                "talent_lang_chn"   =>  (!empty($request->talent_lang_chn)) ? $request->talent_lang_chn : 99,
                "talent_lang_jpn"   =>  (!empty($request->talent_lang_jpn)) ? $request->talent_lang_jpn : 99,
                "talent_lang_kor"   =>  (!empty($request->talent_lang_kor)) ? $request->talent_lang_kor : 99,
                "talent_lang_myn"   =>  (!empty($request->talent_lang_myn)) ? $request->talent_lang_myn : 99,
                "talent_lang_cam"   =>  (!empty($request->talent_lang_cam)) ? $request->talent_lang_cam : 99,
                "talent_lang_fra"   =>  (!empty($request->talent_lang_fra)) ? $request->talent_lang_fra : 99,
                "talent_lang_spn"   =>  (!empty($request->talent_lang_spn)) ? $request->talent_lang_spn : 99,
                "talent_drive"      =>  (!empty($request->talent_drive)) ? $request->talent_drive : 99,
                "talent_course"     =>  (!empty($request->talent_course)) ? $request->talent_course : 99,
                "browserName"       =>  $browserName,
                "osName"            =>  $osName,
                "confirm"           =>  0
            ];


        try{
           $last_id = Member::create($user_data);
           // Return Last Insert ID
           //if($last_id->id){
               $member_id = $last_id->id;

               $data_model_has_roles = [
                   "model_id"      =>  $member_id,
                   "model_type"    =>  "App\User",
                   "role_id"       =>  $request->roles
               ];
        }
        catch(\Exception $e){
        // do task when error
        //echo $e->getMessage();   // insert query
        return redirect()->back()->with('error','พบข้อผิดพลาด การบันทึกข้อมูลผู้ใช้งาน :'.$e->getMessage() .' กรุณาแจ้งข้อความนี้ไปยังทีมผู้พัฒนาระบบ');
        }

        try{

          DBModelHasRoles::insert($data_model_has_roles);
          $users_value        = Member::find($last_id->id);
          $pos_th_arr         = CmsHelper::Get_Position_TH();
          $arr_division_part  = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");
          $org_th_arr         = CmsHelper::Get_Organization_TH();

          define("LINEAPI","https://notify-api.line.me/api/notify");
          define("MESSAGE","ผู้สมัครสมาชิกใหม่\nชื่อ - นามสกุล ::".$users_value->name_th." ".$users_value->lname_th.
              "\nตำแหน่ง :: ".$pos_th_arr[$users_value->position].
              "\nส่วนงานในสังกัด :: ".$arr_division_part[$users_value->organization_type].
              "\nหน่วยงาน :: ".$org_th_arr[$users_value->organization].
              "\nเบอร์โทรศัพท์ :: ".$users_value->phone
          );

          define("TOKEN","bGyH04duKGGFu7DS2xxTKDH8XENvPocvFfqeFH3Wrvw");
          //test

          $data = array(
                      'message' => MESSAGE,
                  );
          $data = http_build_query($data,'','&');
          $headerOptions = array(
              'http'=>array(
                  'method'=>'POST',
                  'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                  ."Authorization: Bearer ".TOKEN."\r\n"
                  ."Content-Length: ".strlen($data)."\r\n",
                  'content' => $data
              ),
          );
          $context = stream_context_create($headerOptions);
          $result = file_get_contents(LINEAPI,FALSE,$context);
          $res = json_decode($result);

          return redirect()->back()->with('success','สมัครสมาชิกสำเร็จ กรุณารอการยืนยันข้อมูลผ่านทาง Email ที่ลงทะเบียน');
          //return redirect()->route('login.ecosystem')->with('success','สมัครสมาชิกสำเร็จ');
          //}
       }
       catch(\Exception $e){
       // do task when error
       //echo $e->getMessage();   // insert query
       return redirect()->back()->with('error','พบข้อผิดพลาด การเพิ่มสิทธิ์ผู้ใช้งาน :'.$e->getMessage() .' กรุณาแจ้งข้อความนี้ไปยังทีมผู้พัฒนาระบบ');
       }
    }

    public function team()
    {
       return view('member::team');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('member::create');
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
        return view('member::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('member::edit');
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


    public function Get_List_Agency(Request $request){
        if(empty($request->organization_type)) return false;

        $datas = Organization::where('organization_type',$request->organization_type)->OrderBy('organization_type','asc')->get();

        $htm = "<option value=\"\">-- กรุณาเลือกหน่วยงาน --</option>\n";
        foreach($datas as $key=>$value) {
    				$htm .= "<option value=\"".$value->organization_id."\">".$value->organization_name."</option>\n";
    		}
    		return $htm;
    }

    public function Get_Role_Group_By(Request $request){
        if(empty($request->organization_id)) return false;

        $select_field = Organization::select('organization_ref_role')->where('organization_id',$request->organization_id)->first();

        $datas = Roles::where('organization_ref_role',$select_field->organization_ref_role)->where('status',"1")->get();

        $htm = "<option value=\"\">-- กรุณาเลือกกลุ่มภารกิจ --</option>\n";
        foreach($datas as $key=>$value) {
    				$htm .= "<option value=\"".$value->id."\">".$value->name."</option>\n";
    		}
    		return $htm;
    }


}
