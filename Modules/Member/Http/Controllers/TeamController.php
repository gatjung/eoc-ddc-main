<?php

namespace Modules\Member\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\member;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function team()
    {
       return view('member::frontend.team');
    }

    // public function work_io()
    // {
    //     return view('member::work_io');
    // }

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


// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Controller by arm <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

//เริ่ม หน้า All_Member จัดการสมาชิก
public function All_Member(){
        $query = Member::all()->take(10);
        //dd($query);

        return view('member::frontend.all_member', [
            'KEYforPass'=> $query
        ]);
}

public function Delete_Member($id)
{
    $delete = Member::where('id', $id)->delete();

    // check data deleted or not
    if ($delete == 1) {
        $success = true;
        $message = "User deleted successfully";
    } else {
        $success = true;
        $message = "User not found";
    }

    //  Return response
    return response()->json([
        'success' => $success,
        'message' => $message,
    ]);
}
//จบ หน้า admin user ผู้ใช้งาน

// >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>> Controller by arm <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

}
