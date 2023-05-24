<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\TalentCourse;
use redirect;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data_course = TalentCourse::all();
        return view('hr::course.index', compact('data_course'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hr::course.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $field_course           =   new TalentCourse;
        $field_course->course   =   $request->course;

        if ($field_course->save()) {
            return redirect()->back()->with('success','เพิ่มหลักสูตรสำเร็จ');
        } else {
            return redirect()->back()->with('error','เพิ่มหลักสูตรไม่สำเร็จ !!!');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('hr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Request $request)
    {
        $data_course = TalentCourse::where('id', $request->course_id)->first();

        return view('hr::course.edit', compact('data_course'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $field_course           =   TalentCourse::find($request->course_id);
        $field_course->course   =   $request->course;

        if ($field_course->save()) {
            return redirect()->route('course.index')->with('success','แก้ไขหลักสูตรสำเร็จ');
        } else {
            return redirect()->route('course.index')->with('error','แก้ไขหลักสูตรไม่สำเร็จ !!!');
        } 
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $delete = TalentCourse::where('id', $request->course_id)->delete();

        if ($delete) {
            return redirect()->back()->with('success','ลบหลักสูตรสำเร็จ');
        } else {
            return redirect()->back()->with('error','ลบหลักสูตรไม่สำเร็จ !!!');
        }
    }
}
