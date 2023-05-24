<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Roles;
use App\TaskOrder;
use App\TaskJob;
use App\TaskMeeting;
use App\Member;
use App\TaskDetail;
use App\Assign_meeting;
use App\CmsHelper as CmsHelper;

class TaskICController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function approved()
    {
        $TaskAssign = DB::table('task_assign')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_order_x_roles', 'task_order.id', '=', 'task_order_x_roles.order_id')
            ->join('roles', 'roles.id', '=', 'task_order_x_roles.roles_id')
            ->join('users', 'users.id', '=', 'task_assign.users_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->select(
                'task_assign.id as assign_id',
                'task_assign.start_at',
                'task_assign.end_at',
                'task_assign.score',
                'task_assign.read_status',
                'task_assign.Approved',
                'task_order.score as or_score',
                'task_order.title as order_title',
                'task_order_x_roles.order_id',
                'task_order_x_roles.roles_id',
                'users.name_th as fname',
                'users.lname_th as lname',
                'task_meeting.id as meet_id',
                'task_meeting.title as meet_title',
                'roles.name as roles_nameTH',
                'roles.name_eng as roles_nameEN'
            )
            ->where('task_assign.score',1)
            ->where('roles.id',Auth::user()->roles()->first()->id)
            ->get();
        return view('task::task_approved', [
            "TaskAssign" => $TaskAssign
        ]);
    }

    //  ------------------------------------------------------------------------------------------------------------------

    public function update(Request $request)
    {
        // dd($request);
        $update = Assign_meeting::where('id', $request->assign_id)->update(["Approved" => 1]);

        if ($update) {
            return redirect()->back()->with('swl_add', 'อนุมัติเรียบร้อยแล้ว');
        } else {
            return redirect()->back()->with('swl_add', 'บันทึกแล้ว');
        }
    }








}