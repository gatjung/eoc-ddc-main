<?php
namespace Modules\DataProcessing\Http\Controllers;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use DB;
use Auth;
use carbon\carbon;
use App\Organization;
use App\Roles;
use App\CmsHelper;

class DashboardController extends Controller
{
     /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct(){
        $this->middleware('auth');

        $mytime = Carbon::now();
        $this->current_datetime = $mytime->toDateTimeString();
        $this->current_date = $mytime->toDateString();

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
    });

     }
    

    public function index()
    {
        return view('dataprocessing::index');
        // <!-- การเรียกวิว ต้องเป็นตัวเล็กทั้งหมด เช่น dataprocessing -->
    }

    // Dashboard ทั้งหมด
    public function dashboard()
    {


        // FILTER --------------------------------------------------------->

        // หน่วยงาน
        $organ = Organization::select('organization_id','organization_name')->get();
        // กลุ่มงาน
        $roles = Roles::select('id','name','name_eng')->where ('status',1)->get();
        // ส่วนงานในสังกัด
        $arr_division_part = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");

        // END FILTER --------------------------------------------------------->



        // graph 1 เพศ   
        $query = DB::table('users')
                    ->selectraw('gender, count(gender) AS total_gender')                 
                    ->GROUPBY('gender')
                    ->ORDERBY('total_gender', 'desc')
                    ->get();
        $gendersex=array(""=>"ไม่ระบุ",
                    "1"=>"ชาย",
                    "2"=>"หญิง",
                    );
        foreach ($query as $value) 
        {            
            $graph1 [] = array("label" => $gendersex[$value->gender] , "y" => $value->total_gender);          
        }
        // end graph 1

        // graph 2 กลุ่มงาน    
        $query = DB::table('users')
                    ->selectraw('case when organization is null then 99 ELSE organization end organization, count(case when organization is null then 99 ELSE organization end) AS total_organization') 
                    ->GROUPBY(DB::raw('case when organization is null then 99 ELSE organization end'))
                    ->ORDERBY('total_organization', 'desc')        
                    ->get();
        // dd($query);  
        $organizationquery = DB::table('ref_organization')
                    ->select('organization_id','organization_name') 
                    ->get(); 
        foreach ($organizationquery as $value) 
        {            
            $organizationdata [$value->organization_id] =trim($value->organization_name);          
        } 
        foreach ($query as $value) 
        {            
            $graph2 [] = array("label" => $organizationdata[$value->organization] , "y" => $value->total_organization);
        }
        // end graph 2

        // graph 3 ตำแหน่ง
        $query = DB::table('users')
                    ->selectraw('case when position is null then 99 ELSE position end position, count(case when position is null then 99 ELSE position end) AS total_position') 
                    ->GROUPBY(DB::raw('case when position is null then 99 ELSE position end'))
                    ->ORDERBY('total_position', 'desc')
                    ->get();
        $positionquery = DB::table('ref_position')
                    ->select('position_id','position_name') 
                    ->get(); 
        foreach ($positionquery as $value) 
        {            
            $positiondata [$value->position_id] =trim($value->position_name);          
        } 
        foreach ($query as $value) 
        {            
            $graph3 [] = array("label" => $positiondata[$value->position] , "y" => $value->total_position);
        }
        // end graph 3

        // graph 5 ความสามารถในการขับรถ    
        $query = DB::table('users')
                    ->selectraw('case when talent_drive is null then 99 ELSE talent_drive end talent_drive, count(case when talent_drive is null then 99 ELSE talent_drive end) AS total_talent_drive') 
                    ->GROUPBY(DB::raw('case when talent_drive is null then 99 ELSE talent_drive end'))
                    ->ORDERBY('total_talent_drive', 'desc')        
                    ->get();      
        $talent_drivequery = DB::table('ref_talent_drive')
                    ->select('id','drive') 
                    ->get();
        foreach ($talent_drivequery as $value) 
        {            
            $talent_drivedata [$value->id] =trim($value->drive);          
        }
        foreach ($query as $value) 
        {         
            $graph5 [] = array("label" => $talent_drivedata[$value->talent_drive] , "y" => $value->total_talent_drive);          
        }
        // end graph 5

        // graph 6 ความสามารถทางภาษาอังกฤษ     
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_eng is null then 99 ELSE talent_lang_eng end talent_lang_eng, count(case when talent_lang_eng is null then 99 ELSE talent_lang_eng end) AS total_talent_lang_eng') 
                    ->GROUPBY(DB::raw('case when talent_lang_eng is null then 99 ELSE talent_lang_eng end'))
                    ->ORDERBY('total_talent_lang_eng', 'desc')        
                    ->get(); 
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph6 [] = array("label" => $talent_languagedata[$value->talent_lang_eng] , "y" => $value->total_talent_lang_eng);          
        }
        // end graph 6

        // graph 7 ความสามารถทางภาษาจีน   
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_chn is null then 99 ELSE talent_lang_chn end talent_lang_chn, count(case when talent_lang_chn is null then 99 ELSE talent_lang_chn end) AS total_talent_lang_chn') 
                    ->GROUPBY(DB::raw('case when talent_lang_chn is null then 99 ELSE talent_lang_chn end'))
                    ->ORDERBY('total_talent_lang_chn', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();     
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph7 [] = array("label" => $talent_languagedata[$value->talent_lang_chn] , "y" => $value->total_talent_lang_chn);          
        }
        // end graph 7

        // graph 8 ความสามารถทางภาษาญี่ปุ่น    
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_jpn is null then 99 ELSE talent_lang_jpn end talent_lang_jpn, count(case when talent_lang_jpn is null then 99 ELSE talent_lang_jpn end) AS total_talent_lang_jpn') 
                    ->GROUPBY(DB::raw('case when talent_lang_jpn is null then 99 ELSE talent_lang_jpn end'))
                    ->ORDERBY('total_talent_lang_jpn', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph8 [] = array("label" => $talent_languagedata[$value->talent_lang_jpn] , "y" => $value->total_talent_lang_jpn);          
        }
        // end graph 8

        // graph 9 ความสามารถทางภาษาเกาหลี     
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_kor is null then 99 ELSE talent_lang_kor end talent_lang_kor, count(case when talent_lang_kor is null then 99 ELSE talent_lang_kor end) AS total_talent_lang_kor') 
                    ->GROUPBY(DB::raw('case when talent_lang_kor is null then 99 ELSE talent_lang_kor end'))
                    ->ORDERBY('total_talent_lang_kor', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph9 [] = array("label" => $talent_languagedata[$value->talent_lang_kor] , "y" => $value->total_talent_lang_kor);          
        }
        // end graph 9

        // graph 10 ความสามารถทางภาษาพม่า     
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_myn is null then 99 ELSE talent_lang_myn end talent_lang_myn, count(case when talent_lang_myn is null then 99 ELSE talent_lang_myn end) AS total_talent_lang_myn') 
                    ->GROUPBY(DB::raw('case when talent_lang_myn is null then 99 ELSE talent_lang_myn end'))
                    ->ORDERBY('total_talent_lang_myn', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph10 [] = array("label" => $talent_languagedata[$value->talent_lang_myn] , "y" => $value->total_talent_lang_myn);          
        }
        // end graph 10

        // graph 11 ความสามารถทางภาษากัมพูชา    
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_cam is null then 99 ELSE talent_lang_cam end talent_lang_cam, count(case when talent_lang_cam is null then 99 ELSE talent_lang_cam end) AS total_talent_lang_cam') 
                    ->GROUPBY(DB::raw('case when talent_lang_cam is null then 99 ELSE talent_lang_cam end'))
                    ->ORDERBY('total_talent_lang_cam', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph11 [] = array("label" => $talent_languagedata[$value->talent_lang_cam] , "y" => $value->total_talent_lang_cam);          
        }
        // end graph 11

        // graph 12  ความสามารถทางภาษาฝรั่งเศส     
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_fra is null then 99 ELSE talent_lang_fra end talent_lang_fra, count(case when talent_lang_fra is null then 99 ELSE talent_lang_fra end) AS total_talent_lang_fra') 
                    ->GROUPBY(DB::raw('case when talent_lang_fra is null then 99 ELSE talent_lang_fra end'))
                    ->ORDERBY('total_talent_lang_fra', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph12 [] = array("label" => $talent_languagedata[$value->talent_lang_fra] , "y" => $value->total_talent_lang_fra);          
        }
        // end graph 12

        // graph 13  ความสามารถทางภาษาสเปน  
        $query = DB::table('users')
                    ->selectraw('case when talent_lang_spn is null then 99 ELSE talent_lang_spn end talent_lang_spn, count(case when talent_lang_spn is null then 99 ELSE talent_lang_spn end) AS total_talent_lang_spn') 
                    ->GROUPBY(DB::raw('case when talent_lang_spn is null then 99 ELSE talent_lang_spn end'))
                    ->ORDERBY('total_talent_lang_spn', 'desc')        
                    ->get();        
        $talent_languagequery = DB::table('ref_talent_language')
                    ->select('id','talent_name') 
                    ->get();      
        foreach ($talent_languagequery as $value) 
        {            
            $talent_languagedata [$value->id] =trim($value->talent_name);          
        }
        foreach ($query as $value) 
        {            
            $graph13 [] = array("label" => $talent_languagedata[$value->talent_lang_spn] , "y" => $value->total_talent_lang_spn);          
        }
        // end graph 13

        // graph 14 ผ่านหลักสูตรการฝึกอบรม    
        $query = DB::table('users')
                    ->selectraw('case when talent_course is null then 99 ELSE talent_course end talent_course, count(case when talent_course is null then 99 ELSE talent_course end) AS total_talent_course') 
                    ->GROUPBY(DB::raw('case when talent_course is null then 99 ELSE talent_course end'))
                    ->ORDERBY('total_talent_course', 'desc')        
                    ->get();        
        $talent_coursequery = DB::table('ref_talent_course')
                    ->select('id','course') 
                    ->get();     
        foreach ($talent_coursequery as $value) 
        {            
            $talent_coursedata [$value->id] =trim($value->course);          
        }
        foreach ($query as $value) 
        {            
            $graph14 [] = array("label" => $talent_coursedata[$value->talent_course] , "y" => $value->total_talent_course);          
        }
        // end graph 14

        // graph 15 กลุ่มภารกิจ (จำนวนคน)    
        $query = DB::table('users')
                    ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id') 
                    ->leftjoin('roles','roles.id', '=', 'model_has_roles.role_id')
                    ->selectraw('roles.groupteam_id,count(roles.groupteam_id) as total_group')
                    ->whereNotNull('roles.groupteam_id')
                    ->GROUPBY('roles.groupteam_id')
                    ->ORDERBY('total_group', 'asc')
                    ->get();
        // dd($query);
        $hr_groupteamquery = DB::table('hr_groupteam')
                    ->select('id','name_thai') 
                    ->get(); 
        foreach ($hr_groupteamquery as $value) 
        {            
            $hr_groupteamdata [$value->id] =trim($value->name_thai);          
        }
        foreach ($query as $value) 
        {            
            $graph15 [] = array("label" => $hr_groupteamdata[$value->groupteam_id] , "y" => $value->total_group);          
        }
        // end graph 15

        
    // HR SUM BOX --------------------------------------------------------->
        // BOX 1 บุคลากรทั้งหมด
        $Totalhr1 = DB::table('users')
                        ->selectRaw ('count(id) AS total_role_id1')
                        ->first();  
        // END BOX 1

        // BOX 2 ส่วนกลาง
        $Totalhr2 = DB::table('users')
                        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->selectRaw ('count(users.id) AS total_role_id2')
                        ->where('roles.organization_ref_role', ['central'])
                        ->first();
        //dd($Totalhr2);
        // END BOX 2

        // BOX 3 ส่วนภูมิภาค  
        $Totalhr3 = DB::table('users')
                        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        ->selectRaw ('count(users.id) AS total_role_id3')
                        ->whereNotIn('roles.organization_ref_role', ['central'])
                        ->first(); 
        // END BOX 3
    // END HR SUM BOX -------------------------------------------------------->

        
               
        // return view
        return view(
            'dataprocessing::frontend_dd.dashboard',
            [


                'org_ref' => $organ,
                'roles' => $roles,
                'organization_type' => $arr_division_part,


                // graph ที่อยู่ข้างหน้า คือ graph ที่ส่งค่าไปแสดงผล / ส่วน graph หลัง คือ ดึงค่ามาจาก query ของ foreach
                "graph1" => $graph1,
                "graph2" => $graph2,
                "graph3" => $graph3,
                "graph5" => $graph5,
                "graph6" => $graph6,
                "graph7" => $graph7,
                "graph8" => $graph8,
                "graph9" => $graph9,
                "graph10" => $graph10,
                "graph11" => $graph11,
                "graph12" => $graph12,
                "graph13" => $graph13,
                "graph14" => $graph14,
                "graph15" => $graph15,
                
                "Totalhr1" => $Totalhr1,
                "Totalhr2" => $Totalhr2,
                "Totalhr3" => $Totalhr3                
            ]);
    }
    // END Dashboard
}
