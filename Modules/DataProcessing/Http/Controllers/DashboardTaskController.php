<?php

namespace Modules\DataProcessing\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use DB;
use Auth;
use Session;
use App\Organization;
use App\Roles;
use App\CmsHelper;


class DashboardTaskController extends Controller
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
            $this->year = $mytime->format('Y');
            $this->month = $mytime->format('m');

            $this->middleware(function ($request, $next) {
                $this->user = Auth::user();
                return $next($request);
     });

     }


    public function dashboardtask(Request $request)
    {

        // หน่วยงาน
        $organ = Organization::select('organization_id','organization_name')->get();
        // กล่องภารกิจ
        $roles = Roles::select('id','name','name_eng')->where ('status',1)->get();
        // ส่วนงานในสังกัด
        $arr_division_part = array("1" => "หน่วยงานส่วนกลาง","2" => "หน่วยงานส่วนภูมิภาค");

        // END FILTER --------------------------------------------------------->


        // TASK SUM BOX --------------------------------------------------------->

        // งานสำคัญเร่งด่วน !!
        // $Totaltask_urgen = DB::table('task_order')
        //                 -> selectRaw ('count(id) AS total_count')
        //                 ->first();

        // งานตามคำสั่งการ (มอบกลุ่มแล้ว ยังไม่มอบหมายบุคคล read_status = 0)
        $Totaltask_order = DB::table('task_assign')
                        -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                        -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        -> whereNull ('task_assign.read_status')
                        -> GROUPBY ('task_assign.order_id')
                        ->get()->count();
// dd($Totaltask_order);


        // งานที่มอบหมายคนแล้ว (อยู่ในระหว่างดำเนินงาน havingRaw score < 0.99)
        $Totaltask_assign = DB::table('task_assign')
                        -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                        -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)<ROUND(0.99,2)')
                        -> GROUPBY ('task_assign.order_id')
                        ->get()->count();
// dd($Totaltask_assign);


        // งานที่เกินกำหนด !!
        $Totaltask_overdue = DB::table('task_assign')
                        -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                        -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        -> whereDate ('task_assign.end_at', '<', $this->current_date)
                        -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)!=ROUND(1,2)')
                        -> GROUPBY ('task_assign.order_id')
                        ->get()->count();
// dd($Totaltask_overdue);


        // ดำเนินงานเสร็จสิ้น (                  havingRaw score = 1)
        $Totaltask_complete = DB::table('task_assign')
                        -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                        -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)=ROUND(1,2)')
                        -> GROUPBY ('task_assign.order_id')
                        ->get()->count();
// dd($Totaltask_complete);


        // งานทั้งหมด
        $Totaltask_summary = DB::table('task_assign')
                        -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                        -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                        -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                        -> where ('task_assign.status', 1)
                        -> GROUPBY ('task_assign.order_id')
                        ->get()->count();
// dd($Totaltask_summary);

        // END TASK SUM BOX -------------------------------------------------------->


        //QUERY STATIC TABLE -------------------------------------------------->

        // ความสำเร็จของงานที่ได้รับมอบหมาย
        $query_table1 = DB::table('roles');
        if($request->organization_type){
          $query_table1->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_table1->where('organization', $request->organization);
        }
        if($request->roles){
          $query_table1->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_table1->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $queryhr_groupteam = $query_table1
                            -> leftjoin ('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> leftjoin ('task_assign', 'model_has_roles.model_id', '=' , 'task_assign.users_id')
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> select ('users.organization_type','users.organization')
                            -> selectRaw (
                                'roles.name,
                                roles.name_eng,
                                sum(task_assign.score),
                                count(task_assign.score),
                                sum(task_assign.score)/count(task_assign.score)*100 as percent'
                            )
                            -> where ('organization_ref_role', 'central')
                            -> whereNotIn ('name', ['admin'])
                            -> GROUPBY ('roles.name','roles.name_eng')
                            ->get();
 // dd($queryhr_groupteam);

                    //  // งานตามคำสั่งการ (มอบกลุ่มแล้ว แต่ยังไม่มอบหมายคน read_status = 0)
                    //  $Totaltask_order = DB::table('task_assign')
                    //                  -> leftjoin ('task_order','task_order.id', '=', 'task_assign.order_id')
                    //                  -> leftjoin ('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
                    //                  -> leftjoin ('users', 'users.id', '=', 'task_assign.users_id')
                    //                  -> leftjoin ('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
                    //                  -> whereNull ('task_assign.read_status')
                    //                  -> GROUPBY ('task_assign.order_id')
                    //                  ->get()->count();
                    // // dd($Totaltask_order);

        //END QUERY STATIC TABLE -------------------------------------------------->


        //QUERY GRAPH 1  ------------------------------------------------------>
        // จำนวนงานทั้งหมด
        $query_g1 = DB::table('task_assign');
        if($request->organization_type){
          $query_g1->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_g1->where('organization', $request->organization);
        }
        if($request->roles){
          $query_g1->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_g1->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $query_graph1_1 = $query_g1
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> select ('roles.name', 'task_assign.status', 'task_assign.order_id')
                            -> selectRaw ('roles.name, count(DISTINCT task_assign.order_id) AS total_count')
                            -> where ('task_assign.status', 1)
                            -> GROUPBY ('roles.name', 'task_assign.status')
                            -> ORDERBY ('total_count', 'desc')
                            ->get();


        IF ($query_graph1_1->count()==0)
        {
          $querytask_graph1=null;
        }
        else {
          foreach ($query_graph1_1 as $value)
          {
              $querytask_graph1 [] = array("label" => $value->name , "y" => $value->total_count);
          }
        }
// dd($querytask_graph1);

        //END QUERY GRAPH 1  -------------------------------------------------->


        //QUERY GRAPH 2  ------------------------------------------------------>
        //งานที่เกินกำหนด -------------------------------------------------------->
        $query_g2 = DB::table('task_assign');
        if($request->organization_type){
          $query_g2->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_g2->where('organization', $request->organization);
        }
        if($request->roles){
          $query_g2->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_g2->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $query_graph2_1 = $query_g2
                            -> select ('order_id')
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)!=ROUND(1,2)')
                            -> GROUPBY ('task_assign.order_id')
                            ->get();
// dd($query_graph2__1);
        $query_graph2_2 = [];

        if(isset($query_graph2_1)){

          foreach ($query_graph2_1 as $value){
                   $query_graph2_2[] = $value->order_id;
          }

        // $query_graph2_final = $query_g2
        $query_graph2_final = DB::table('task_assign')
                                -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                                -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                -> selectRaw ('roles.name, count(DISTINCT task_assign.order_id) AS total_count')
                                -> whereDate ('task_assign.end_at','<', $this->current_date)
                                -> whereIn ('task_assign.order_id', $query_graph2_2)
                                -> GROUPBY ('roles.name')
                                -> ORDERBY ('total_count', 'desc')
                                ->get();
                              }
// dd($query_graph2_final);
        IF ($query_graph2_final->count()==0)
        {
          $query_graph2_graph=null;
        }
        else {
          foreach ($query_graph2_final as $value)
          {
              $query_graph2_graph [] = array("label" => $value->name , "y" => $value->total_count);
          }
        }
// dd($query_graph2_graph);

        //END QUERY GRAPH 2  -------------------------------------------------->


// QUERY GRAPH 3 ------------------------------------------------------>

// END QUERY GRAPH 3 -------------------------------------------------->


        // QUERY GRAPH 4 ------------------------------------------------------>
        // ประสิทธิภาพการทำงาน ----------------------------------------------------------->
        // ดำเนินงานเสร็จสิ้น ------------------------------------------------------>
        $query_g3 = DB::table('task_assign');
        if($request->organization_type){
          $query_g3->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_g3->where('organization', $request->organization);
        }
        if($request->roles){
          $query_g3->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_g3->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $complete_success_1 = $query_g3
                            -> select ('order_id')
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)=ROUND(1,2)')
                            -> GROUPBY ('task_assign.order_id')
                            ->get();
// dd($complete_success_1);
        $complete_success_2 = [];

        if(isset($complete_success_1)){

          foreach ($complete_success_1 as $value){
                   $complete_success_2[] = $value->order_id;
          }
        $complete_success_final = DB::table('task_assign')
                                -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                                -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                -> selectRaw ('roles.name, count(DISTINCT task_assign.order_id) AS total_count')
                                -> whereIn ('task_assign.order_id', $complete_success_2)
                                -> GROUPBY ('roles.name')
                                ->get();
                              }
// dd($complete_success_final);
      IF ($complete_success_final->count()==0)
      {
        $complete_success_graph=null;
      }
      else {
        foreach ($complete_success_final as $value)
        {
            $complete_success_graph [] = array("label" => $value->name , "y" => $value->total_count);
        }
      }
// dd($complete_success_graph);

        //END QUERY GRAPH 4  -------------------------------------------------->


        // QUERY GRAPH 5 ------------------------------------------------------>
        //อยู่ในระหว่างดำเนินงาน --------------------------------------------------->
        $query_g4 = DB::table('task_assign');
        if($request->organization_type){
          $query_g4->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_g4->where('organization', $request->organization);
        }
        if($request->roles){
          $query_g4->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_g4->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $complete_assign_1 = $query_g4
                            -> select ('order_id')
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)<ROUND(0.99,2)')
                            -> GROUPBY ('task_assign.order_id')
                            ->get();
// dd($complete_assign_1);
        $complete_assign_2 = [];

        if(isset($complete_assign_1)){

          foreach ($complete_assign_1 as $value){
                   $complete_assign_2[] = $value->order_id;
          }
        $complete_assign_final = DB::table('task_assign')
                                -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                                -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                -> selectRaw ('roles.name, count(DISTINCT task_assign.order_id) AS total_count')
                                -> whereIn ('task_assign.order_id', $complete_assign_2)
                                -> GROUPBY ('roles.name')
                                ->get();
                              }
// dd($complete_assign_final);
      IF ($complete_assign_final->count()==0)
      {
        $complete_assign_graph=null;
      }
      else {
        foreach ($complete_assign_final as $value)
        {
            $complete_assign_graph [] = array("label" => $value->name , "y" => $value->total_count);
        }
      }
// dd($complete_assign_graph);
        //END QUERY GRAPH 5  -------------------------------------------------->


        // QUERY GRAPH 6 ------------------------------------------------------>
        //งานที่เกินกำหนด -------------------------------------------------------->
        $query_g5 = DB::table('task_assign');
        if($request->organization_type){
          $query_g5->where('organization_type', $request->organization_type);
        }
        if($request->organization){
          $query_g5->where('organization', $request->organization);
        }
        if($request->roles){
          $query_g5->where('roles', $request->roles);
        }
        if($request->start_date AND $request->start_date){
          $query_g5->whereRaw('DATE_FORMAT(task_assign.created_at, "%M %d %Y") >=DATE_FORMAT("'.$request->start_date.'", "%M %d %Y") and DATE_FORMAT(task_assign.created_at, "%M %d %Y") <=DATE_FORMAT("'.$request->end_date.'", "%M %d %Y")');
        }
        $complete_overdue_1 = $query_g5
                            -> select ('order_id')
                            -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                            -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                            -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                            -> havingRaw ('ROUND(sum(task_assign.score)/count(task_assign.score),2)!=ROUND(1,2)')
                            -> GROUPBY ('task_assign.order_id')
                            ->get();
// dd($complete_overdue_1);
        $complete_overdue_2 = [];

        if(isset($complete_overdue_1)){

          foreach ($complete_overdue_1 as $value){
                   $complete_overdue_2[] = $value->order_id;
          }
        $complete_overdue_final = DB::table('task_assign')
                                -> leftjoin ('users','users.id', '=', 'task_assign.users_id')
                                -> leftjoin ('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                                -> leftjoin ('roles', 'roles.id', '=', 'model_has_roles.role_id')
                                -> selectRaw ('roles.name, count(DISTINCT task_assign.order_id) AS total_count')
                                -> whereDate ('task_assign.end_at','<', $this->current_date)
                                -> whereIn ('task_assign.order_id', $complete_overdue_2)
                                -> GROUPBY ('roles.name')
                                ->get();
                              }
// dd($complete_overdue_final);
      IF ($complete_overdue_final->count()==0)
      {
        $complete_overdue_graph=null;
      }
      else {
        foreach ($complete_overdue_final as $value)
        {
            $complete_overdue_graph [] = array("label" => $value->name , "y" => $value->total_count);
        }
      }
// dd($complete_overdue_graph);

        // END QUERY GRAPH 6 -------------------------------------------------->



        return view('dataprocessing::frontend_dd.dashboardtask',[
                    'org_ref' => $organ,
                    'roles' => $roles,
                    'organization_type' => $arr_division_part,

                    "start_date" => $request->start_date,
                    "end_date" => $request->end_date,

                    'Totaltask_order' => $Totaltask_order,
                    'Totaltask_assign' => $Totaltask_assign,
                    'Totaltask_complete' => $Totaltask_complete,
                    'Totaltask_overdue' => $Totaltask_overdue,
                    'Totaltask_summary' => $Totaltask_summary,

                    'hr_groupteam' => $queryhr_groupteam,

                    'querytask_graph1' => $querytask_graph1,
                    'querytask_graph2' => $query_graph2_graph,

                    // 'graph3_1' => $graph3_1,
                    // 'graph3_2' => $graph3_2,
                    // 'graph3_3' => $graph3_3,

                    'graph4_1' => $complete_success_graph,
                    'graph4_2' => $complete_assign_graph,
                    'graph4_3' => $complete_overdue_graph,

        ]);
    }




// ---------------------------------------------------------------------------->
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('dataprocessing::create');
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
        return view('dataprocessing::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('dataprocessing::edit');
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
