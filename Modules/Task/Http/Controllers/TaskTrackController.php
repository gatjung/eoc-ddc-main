<?php

namespace Modules\Task\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class TaskTrackController extends Controller
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

    public function pending()
    {
        $TaskAssign = DB::table('task_assign')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'task_assign.users_id', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->selectRaw(
                'task_meeting.id,
                task_meeting.title as meet_title,
                task_assign.score,
                task_assign.end_at,
                task_assign.start_at,
                task_order.meet_id,
                task_order.title as order_title,
                task_assign.order_id,
                model_has_roles.model_id as users_id,
                model_has_roles.role_id as roles_id,
                sum(task_assign.score)/count(task_assign.score)*100 as percent'
            )
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)>ROUND(0.01,2)')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)<ROUND(0.99,2)')
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

        return view('task::track', [
            "TaskAssign" => $TaskAssign,
            "Count1" => $Count1,
            "Count2" => $Count2,
            "Count3" => $Count3,
            "Count4" => $Count4
        ]);
    }

    // ---------------------------------------------------------------------------------
    public function success()
    {
        $TaskAssign = DB::table('task_assign')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'task_assign.users_id', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->selectRaw(
                'task_meeting.id,
                task_meeting.title as meet_title,
                task_assign.score,
                task_assign.end_at,
                task_assign.start_at,
                task_order.meet_id,
                task_order.title as order_title,
                task_assign.order_id,
                model_has_roles.model_id as users_id,
                model_has_roles.role_id as roles_id,
                sum(task_assign.score)/count(task_assign.score)*100 as percent'
            )
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)=ROUND(1,2)')
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

        return view('task::track', [
            "TaskAssign" => $TaskAssign,
            "Count1" => $Count1,
            "Count2" => $Count2,
            "Count3" => $Count3,
            "Count4" => $Count4
        ]);
    }

    // ---------------------------------------------------------------------------------
    public function overdue()
    {
        $TaskAssign = DB::table('task_assign')
            ->join('task_order', 'task_order.id', '=', 'task_assign.order_id')
            ->join('task_meeting', 'task_meeting.id', '=', 'task_order.meet_id')
            ->join('users', 'task_assign.users_id', '=', 'users.id')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->selectRaw(
                'task_meeting.id,
                task_meeting.title as meet_title,
                task_assign.score,
                task_assign.end_at,
                task_assign.start_at,
                task_order.meet_id,
                task_order.title as order_title,
                task_assign.order_id,
                model_has_roles.model_id as users_id,
                model_has_roles.role_id as roles_id,
                sum(task_assign.score)/count(task_assign.score)*100 as percent'
            )
            ->where('roles.id', Auth::user()->roles()->first()->id)
            ->whereDate('task_assign.end_at', '<', $this->current_date)
            ->groupBy('task_meeting.id')
            ->havingRaw('ROUND(sum(task_assign.score)/count(task_assign.score),2)!=ROUND(1,2)')
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

        return view('task::track', [
            "TaskAssign" => $TaskAssign,
            "Count1" => $Count1,
            "Count2" => $Count2,
            "Count3" => $Count3,
            "Count4" => $Count4
        ]);
    }

    // ---------------------------------------------------------------------------------
}
