<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\RefPrefix;
use redirect;

class PrefixController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data_prefix = RefPrefix::all();
        // dd($query_prefix);

        // return view('hr::prefix.index');
        return view('hr::prefix.index',compact('data_prefix'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hr::prefix.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $field_RefPrefix            =   new RefPrefix;
        $field_RefPrefix->name_th   =   $request->prefix_th;
        $field_RefPrefix->name_en   =   $request->prefix_en;

        if ($field_RefPrefix->save()) {
            return redirect()->back()->with('success','เพิ่มคำนำหน้าสำเร็จ');
        } else {
            return redirect()->back()->with('error','เพิ่มคำนำหน้าไม่สำเร็จ !!!');
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
        $data_prefix = RefPrefix::where('id', $request->prefix_id)->first();

        return view('hr::prefix.edit', compact('data_prefix'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $field_RefPrefix            =   RefPrefix::find($request->prefix_id);
        $field_RefPrefix->name_th   =   $request->prefix_th;
        $field_RefPrefix->name_en   =   $request->prefix_en;

        if ($field_RefPrefix->save()) {
            return redirect()->route('prefix.index')->with('success','แก้ไขคำนำหน้าสำเร็จ');
        } else {
            return redirect()->route('prefix.index')->with('error','แก้ไขคำนำหน้าไม่สำเร็จ !!!');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {
        $delete = RefPrefix::where('id', $request->prefix_id)->delete();

        if ($delete) {
            return redirect()->back()->with('success','ลบคำนำหน้าชื่อสำเร็จ');
        } else {
            return redirect()->back()->with('error','ลบคำนำหน้าชื่อไม่สำเร็จ !!!');
        }
    
    }
}
