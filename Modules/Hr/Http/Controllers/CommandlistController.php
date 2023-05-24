<?php

namespace Modules\Hr\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Auth;
use Storage;
use File;
use Validator;
use Carbon\Carbon;
use App\CmsHelper;
use App\Roles;
use App\Command;
use App\CommandList;
use App\Member;
use App\DBModelHasRoles;
use App\DBJobLevel;
use App\DBModelHasRolesLog;

class CommandlistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data = CommandList::select('id','organ','comm_num','comm_date','file_name','file_ori_name','status')->where('status', '!=', 0)->get();

        return view('hr::commandlist.index',['data' => $data]);
    }

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    public function upload_file(Request $request){


          //Auto Generate FolderName Private For User

        if($request->hasFile('customFile')){

          $rules = [
              'customFile' => 'required|max:10000|mimes:pdf,doc,docx,xls,xlsx,csv',
          ];

          $customMessages = [
            'customFile.required' => 'คุณยังไม่ได้เลือกไฟล์ที่ต้องการอัพโหลด',
            'customFile.max' => 'ระบบรองรับไฟล์ขนาดไม่เกิน 10MB',
            'customFile.mimes' => 'ระบบรองรับไฟล์นามสกุลดังต่อไปนี้ pdf,doc,docx,xls,xlsx,csv'
          ];

          $validator = Validator::make($request->all(), $rules ,$customMessages);
          if ($validator->fails()) {
              return back()->with('error',$validator->errors()->first());
          }
          // cache the file
          $file = $request->file('customFile');
          // generate a new filename. getClientOriginalExtension() for the file extension
          $filename = date('Ymd').'-commandlist-'.CmsHelper::generateRandomString(10).'.'. $file->getClientOriginalExtension();
          // save to storage/app/photos as the new $filename
          $path_file_upload = $file->storeAs('commandlist/', $filename);
          //get original file name
          $ori_file_name = $file->getClientOriginalName();

        }else{
          $filename = NULL;
        }

        try {
            Commandlist::create([

                'organ' => $request->organ,
                'comm_num' => $request->comm_num,
                'comm_date' => $request->comm_date,
                'file_name' => $filename,
                'file_ori_name' => $ori_file_name,
                'status' => '1'

            ]);
            return back()->with('success','อัพโหลดไฟล์สำเร็จ');
        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $status_error = $exception->errorInfo;
            // Return the response to the client..
            $status = $status_error['2'] .'   ,กรุณาบันทึกหน้าจอนี้แล้วแจ้งทีมผู้พัฒนาระบบ !!';
            return back()->with('error',$status);
        }
    }

    public function DownloadFile(request $request,$id){

      $query = CommandList::select('file_name','file_ori_name')->where('status','1')->where('file_name', $request->file_name)->first();

      if(!$query) return abort(404);

      $path = $query->file_name;
      $name = $query->file_ori_name;

      return Storage::disk('commandlist')->download($path, $name);
    }

    public function ViewFile(request $request,$id){

      $query = CommandList::select('file_name','file_ori_name')->where('status','1')->where('file_name', $request->file_name)->first();

      if(!$query) return abort(404);

      $path = $query->file_name;
      $name = $query->file_ori_name;

      return Storage::disk('commandlist')->response($path, $name);
    }

    public function DeleteFile(Request $request){

        $hiderows = CommandList::find($request->id);
        $hiderows->status = '0';
        $hiderows->save();

      return redirect()->route('commandlist.index')
                        ->with('ลบไฟล์เสร็จสิ้น !','กรุณาตรวจสอบความถูกต้อง');
    }
}
