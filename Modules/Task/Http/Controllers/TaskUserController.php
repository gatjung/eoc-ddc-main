<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\TaskDetail;
use App\Assign_meeting;
use App\NotificationAlert;

class TaskUserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function action()
    {
        $TaskAssign = DB::table('task_assign')
            ->join('users','users.id','=','task_assign.users_id')
            ->join('task_order','task_order.id','=','task_assign.order_id')
            ->join('task_meeting','task_meeting.id','=','task_order.meet_id')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->select(
                'users.id',
                'users.name_th as fname',
                'users.lname_th as lname',
                'roles.name as roles_nameTH',
                'roles.name_eng as roles_nameEN',
                'task_assign.Approved',
                'task_assign.score',
                'task_assign.status',
                'task_assign.read_status',
                'task_assign.end_at',
                'task_assign.start_at',
                'task_assign.users_id',
                'task_assign.id as assign_id',
                'model_has_roles.role_id',
                'model_has_roles.model_id',
                'task_meeting.title as meet_title',
                'task_meeting.id as meet_id',
                'task_order.id as order_id',
                'task_order.title as order_title'
            )
            ->where('model_has_roles.role_id', Auth::user()->roles()->first()->id)
            ->where('task_assign.users_id', Auth::user()->id)
            ->get();

        return view('task::action', [
            "TaskAssign" => $TaskAssign
        ]);
    }

    // ----------------------------------------------------------------------------------

    public function action_detail(Request $request)
    {
        // dd($request);
        if (Auth::user()->emp_level == 2) {
            Assign_meeting::where('id', $request->assign_id)->update(["read_status" => 1]);

            // NotificationAlert::where('id', $request->msg_id)->update(["seen" => 1]);
        }

        $TaskAssign = DB::table('task_assign')
            ->join('users','users.id','=','task_assign.users_id')
            ->join('task_order','task_order.id','=','task_assign.order_id')
            ->join('task_meeting','task_meeting.id','=','task_order.meet_id')
            ->join('model_has_roles','users.id','=','model_has_roles.model_id')
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->select(
                'users.id',
                'users.name_th as fname',
                'users.lname_th as lname',
                'roles.name as roles_nameTH',
                'roles.name_eng as roles_nameEN',
                'task_assign.Approved',
                'task_assign.score',
                'task_assign.status',
                'task_assign.read_status',
                'task_assign.end_at',
                'task_assign.start_at',
                'task_assign.users_id',
                'task_assign.id as assign_id',
                'model_has_roles.role_id',
                'model_has_roles.model_id',
                'task_meeting.title as meet_title',
                'task_meeting.id as meet_id',
                'task_order.id as order_id',
                'task_order.title as order_title'
            )
            ->where('task_assign.id', $request->assign_id)
            ->where('task_assign.order_id', $request->order_id)
            ->first();

        $TaskJobDetail = DB::table('task_job_detail')
            ->join('task_assign', 'task_assign.id', '=', 'task_job_detail.assign_id')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->select(
                'task_assign.id AS assign_id',
                'task_assign.score',
                'task_job_detail.id as detail_id',
                'task_job_detail.detail AS job_detail',
                'task_job_detail.status AS detail_status',
                'task_job_detail.created_at'
            )
            ->where('task_assign.id', $request->assign_id)
            ->orderby('task_job_detail.id', 'DESC')
            ->get();

        $CheckDetail = DB::table('task_job_detail')->where('task_job_detail.assign_id', $request->assign_id)->first();

        return view('task::action_detail', [
            "TaskJobDetail" => $TaskJobDetail,
            "TaskAssign" => $TaskAssign,
            "CheckDetail" => $CheckDetail
        ]);
    }

    //  ------------------------------------------------------------------------------------------------------------------

    public function action_insert(Request $request)
    {
        // dd($request);
        Assign_meeting::where('id', $request->assign_id)->update(["score" => $request->status]);

        $TaskDetail = new TaskDetail;
        $TaskDetail->detail = $request->detail;
        $TaskDetail->assign_id = $request->assign_id;
        $TaskDetail->status = $request->status;
        $TaskDetail->save();

        if ($TaskDetail->save()) {
            return redirect()->back()->with('swl_add', 'เพิ่มข้อมูลสำเร็จ');
        } else {
            return redirect()->back()->with('swl_add', 'บันทึกแล้ว');
        }
    }

    //  ------------------------------------------------------------------------------------------------------------------
    public function action_del(Request $request)
    {

        $delete = TaskDetail::where('id', $request->detail_id)->delete();

        if ($delete) {
            if ($request->status == 1) {
                Assign_meeting::where('id', $request->assign_id)->update(["score" => 0]);
                return redirect()->back()->with('swl_del', 'ลบข้อมูลเรียบร้อยแล้ว');
            } else {
                return redirect()->back()->with('swl_del', 'ลบข้อมูลเรียบร้อยแล้ว');
            }
        } else {
            return redirect()->back()->with('swl_del', 'ไม่สามารถลบข้อมูลได้');
        }
    }
}
