<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\DBJobLevel;
use redirect;

class JobLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data_job_level = DBJobLevel::all();

        return view('hr::joblevel.index', compact('data_job_level'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hr::joblevel.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $field_JobLevel                     =   new DBJobLevel;
        $field_JobLevel->job_level_name     =   $request->job_level_name;

        if ($field_JobLevel->save()) {
            return redirect()->back()->with('success','เพิ่มระดับสำเร็จ');
        } else {
            return redirect()->back()->with('error','เพิ่มระดับไม่สำเร็จ !!!');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        // return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        $data_job_level = DBJobLevel::where('id', $request->job_level_id)->first();

        return view('hr::joblevel.edit', compact('data_job_level'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $field_JobLevel                     =   DBJobLevel::find($request->job_level_id);
        $field_JobLevel->job_level_name     =   $request->job_level_name;

        if ($field_JobLevel->save()) {
            return redirect()->route('joblevel.index')->with('success','แก้ไขระดับสำเร็จ');
        } else {
            return redirect()->route('joblevel.index')->with('error','แก้ไขระดับไม่สำเร็จ !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $delete = DBJobLevel::where('id', $request->job_level_id)->delete();

        if ($delete) {
            return redirect()->back()->with('success','ลบระดับสำเร็จ');
        } else {
            return redirect()->back()->with('error','ลบระดับไม่สำเร็จ !!!');
        }
    }
}
