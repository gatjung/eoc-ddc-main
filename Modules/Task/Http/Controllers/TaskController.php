<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Roles;
use App\TaskOrder;
use App\TaskJob;
use App\TaskMeeting;
use App\Member;
use App\TaskDetail;
use App\Assign_meeting;
use App\CmsHelper as CmsHelper;

class TaskController extends Controller
{
    public function __construct()
    {
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
        $TaskOrder = DB::table('task_order')
            ->join('task_assign', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->selectRaw(
                'task_order.title as order_title,
                task_order.id as order_id,
                task_assign.Approved,
                task_assign.created_at,
                task_assign.id as assign_id,
                task_assign.users_id,
                task_assign.start_at,
                task_assign.end_at,
                task_assign.status as assign_status,
                task_assign.read_status,
                task_assign.score,
                task_meeting.title as meet_title,
                task_order.meet_id,
                users.name_th as fname,
                users.lname_th as lname,
                users.id as users_id,
                model_has_roles.model_id,
                model_has_roles.role_id,
                roles.id as roles_id,
                roles.name_eng as roles_nameEN,
                roles.name as roles_nameTH,
                sum(task_assign.score)/count(task_assign.score)*100 AS percent'
            )
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_order.meet_id')
            ->get();

        $Count1 = DB::table('task_order')
            ->join('task_assign', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('task_meeting.id')
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_order.meet_id')
            ->get()->count();
        // dd($Count1);
        $Count2 = DB::table('task_order')
            ->join('task_assign', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->selectRaw('sum(task_assign.score)/count(task_assign.score) as total')
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)>ROUND(0.01,2)')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)<ROUND(0.99,2)')
            ->get()->count();
        // dd($Count2);
        $Count3 = DB::table('task_order')
            ->join('task_assign', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->selectRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2) as total,task_assign.score')
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)=ROUND(1,2)')
            ->get()->count();
        // dd($Count3);

        $Count4 = DB::table('task_order')
            ->join('task_assign', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->selectRaw(
                'task_meeting.id as meet_id,
                task_meeting.title,
                task_assign.start_at,
                task_assign.end_at,
                ROUND( sum( task_assign.score ) / count( task_assign.score ), 2 ) as total'
            )
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->whereDate('task_assign.end_at', '<', $this->current_date)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)!=ROUND(1,2)')
            ->get()->count();

        return view('task::task', [
            "TaskOrder" => $TaskOrder,
            "Count1" => $Count1,
            "Count2" => $Count2,
            "Count3" => $Count3,
            "Count4" => $Count4
        ]);
    }

    // ----------------------------------------------------------------------------------

    public function job(Request $request)
    {
        $TaskMeeting = TaskMeeting::where('id', $request->meet_id)->first();

        $TaskAssign = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->join('users', 'users.id', '=', 'model_has_roles.model_id')
            ->join('task_assign', 'task_assign.users_id', '=', 'users.id')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->select(
                'model_has_roles.role_id',
                'model_has_roles.model_id',
                'roles.id',
                'roles.name as roles_nameTH',
                'roles.name_eng as roles_nameEN',
                'users.lname_th as lname',
                'users.name_th as fname',
                'users.id',
                'task_assign.id as assign_id',
                'task_assign.order_id',
                'task_assign.Approved',
                'task_assign.score as assign_score',
                'task_assign.read_status',
                'task_assign.status as assign_status',
                'task_assign.end_at',
                'task_assign.start_at',
                'task_assign.score',
                'task_assign.users_id',
                'task_order.id',
                'task_order.title as order_title',
                'task_order.meet_id as meet_id',
                'task_meeting.title as meet_title'
            )
            ->where('task_order.meet_id', $request->meet_id)
            ->where('task_assign.order_id', $request->order_id)
            ->where('model_has_roles.role_id', $request->roles_id)
            ->get();

        return view('task::job', [
            "TaskMeeting" => $TaskMeeting,
            "TaskAssign" => $TaskAssign
        ]);
    }

    // ------------------------------------------------------------------------------------

    public function detail(Request $request)
    {
        // dd($request);
        $TaskMeeting = TaskMeeting::where('id', $request->meet_id)->first();
        $TaskOrder = TaskOrder::where('id', $request->order_id)->first();
        $TaskRoles = Roles::where('id', $request->roles_id)->first();
        $TaskJob = TaskJob::where('id', $request->job_id)->first();
        $Member = Member::where('id', $request->users_id)->first();

        $TaskJobShow = DB::table('task_job')
            ->join('task_job_detail', 'task_job.id', '=', 'task_job_detail.job_id')
            ->join('users', 'users.id', '=', 'task_job.users_id')
            ->select(
                'users.id as users_id',
                'users.name_th as fname',
                'users.lname_th as lname',
                'task_job_detail.detail',
                'task_job.job_status',
                'task_job_detail.created_at',
                'task_job_detail.status',
                'task_job.id as job_id',
                'task_job_detail.id as detail_id'
            )
            ->where('task_job.id', $request->job_id)
            ->orderby('task_job_detail.id', 'DESC')
            ->get();

        return view('task::detail', [
            "TaskMeeting" => $TaskMeeting,
            "TaskOrder" => $TaskOrder,
            "TaskRoles" => $TaskRoles,
            "TaskJob" => $TaskJob,
            "TaskJobShow" => $TaskJobShow,
            "Member" => $Member
        ]);
    }
}
