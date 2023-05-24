<?php

namespace Modules\Exchange\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
// use App\research;
use File;


class ExchangeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */


    public function index()
    {
        return view('exchange::index');
    }


    public function meeting_upload()
    {
      return view('exchange::frontend.meeting_upload');

    }


    public function procedure_upload()
    {
      return view('exchange::frontend.procedure_upload');

    }


     // -- INSERT --
    public function insert_ic(Request $request){
      // dd($data_post);
      $data_post = [
        // "pro_name_th"       => $request->pro_name_th,
        // "pro_name_en"       => $request->pro_name_en,
        "files"             => $request->files,
        "created_at"        => date('Y-m-d H:i:s')
      ];
        //  --  UPLOAD FILE research_form ฟิลด์ชื่อ="Files"  --
      if ($request->file('files')->isValid()) {
            //TAG input [type=file] ดึงมาพักไว้ในตัวแปรที่ชื่อ files
          $file=$request->file('files');
            //ตั้งชื่อตัวแปร $file_name เพื่อเปลี่ยนชื่อ + นามสกุลไฟล์
          $name='file_'.date('dmY_His');
          $file_name = $name.'.'.$file->getClientOriginalExtension();
            // upload file ไปที่ PATH : public/file_upload
          $path = $file->storeAs('public/file_upload',$file_name);
          $data_post['files'] = $file_name;
      }

      $insert = research::insert($data_post);
      // $insert = DB::table('person_ddc_table')->insert($data_post);  /*person_ddc_table คือ = ชื่อ table*/

      if($insert){
        return redirect()->back()->with('success','การบันทึกข้อมูลของคุณเสร็จสิ้นแล้ว');
      } else {
        return redirect()->back()->with('failure','การบันทึกข้อมูลของคุณไม่สำเร็จ !!!');
      }
    }
     // -- END INSERT --







    public function command_meeting()
    {
      return view('exchange::frontend.command_meeting');

    }








    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('exchange::create');
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
        return view('exchange::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('exchange::edit');
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
