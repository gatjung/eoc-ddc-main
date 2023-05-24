<?php

namespace Modules\Hr\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Position;
use redirect;

class PositionController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        $data_position = DB::table('ref_position')->get();
        //dd($data_position);
        return view('hr::position.index',[
            'data_position'=>$data_position
        ]);
    }

        public function create()
    {
        return view('hr::position.create');
    }

    public function store(Request $request)
    {
        $field_Position            =   new Position;
        $field_Position->position_name   =   $request->position_name;
        
        if ($field_Position->save()) {
            return redirect()->back()->with('success','เพิ่มตำแหน่งสำเร็จ');
        } else {
            return redirect()->back()->with('error','เพิ่มตำแหน่งไม่สำเร็จ !!!');
        }
    }


    public function edit(Request $request)
    {
        // dd($request->position_id);
        $edit_Position = Position::where('position_id', $request->position_id)->first();

        return view('hr::position.edit', compact('edit_Position'));
    }



    public function update(Request $request)
    {
        $data = [
            "position_name" => $request->position_name
        ];

        $update = Position::where('position_id',$request->position_id)->update($data);

        if ($data) {
            return redirect()->route('position.index')->with('success','แก้ไขตำแหน่งหน้าสำเร็จ');
        } else {
            return redirect()->route('position.index')->with('error','แก้ไขตำแหน่งไม่สำเร็จ !!!');
        }
    }



    public function destroy(Request $request)
    {
        $delete = DB::table('ref_position')->where('position_id', $request->position_id)->delete();

        if ($delete) {
            return redirect()->back()->with('success','ลบตำแหน่งสำเร็จ');
        } else {
            return redirect()->back()->with('error','ลบตำแหน่งไม่สำเร็จ !!!');
        }
    }
}



