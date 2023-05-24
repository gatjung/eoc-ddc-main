<?php

namespace Modules\CommandIC\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\CmsHelper;
use App\DBCommandListIC;
use App\DBDownloadCommandListIC;
use Validator;
use File;
use Illuminate\Support\Facades\Auth;
use Storage;
use DB;
use Mail;
class CommandICController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
        $this->datethai = CmsHelper::DateThai(date('Y-m-d'));
    }

    public function index()
    {
        $data_command_list_ic = DBCommandListIC::select('id', 'command_name', 'file_name', 'file_ori_name', 'command_date', 'count_view', 'count_download')
                                ->where('status', '1')
                                ->orderBy('command_date', 'desc')
                                ->get();

        // dd($data_command_list_ic);

        return view('commandic::index', compact('data_command_list_ic'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('commandic::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        // dd($request);

        if ($request->hasFile('customFile')) {
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

            $file = $request->file('customFile');
            $filename = date('Ymd').'-commandlistIC-'.CmsHelper::generateRandomString(10).'.'. $file->getClientOriginalExtension();
            $path_file_upload = $file->storeAs('commandlistIC/', $filename);
            $ori_file_name = $file->getClientOriginalName();
        } else {
            $filename = NULL;
        }

        try {
            $commandListIC_data = [
                "command_name"      =>  $request->command_name,
                "file_name"         =>  $filename,
                "file_ori_name"     =>  $ori_file_name,
                "command_date"      =>  $request->command_date,
                "user_id_upload"    =>  Auth::user()->id,
                "status"            =>  1
            ];

            $createCommandListIC = DBCommandListIC::create($commandListIC_data);

            if(!empty($createCommandListIC)){
                //Get Last Insert ID For Filename
                $query_file_name = DBCommandListIC::find($createCommandListIC->id);
                if($query_file_name){
                    $file_location = storage_path('app/commandlistIC/'.$query_file_name->file_name);
                    //Send Email To ListEmail
                    $query = DB::table('email_list_sent_command_ic')->where('status','1')->get()->toArray();
                    $resultArray = json_decode(json_encode($query), true);
                    //Add Random Password To File
                    //PdfPasswordProtect::encrypt(storage_path('app/commandlistIC/'.$query_file_name->file_name),storage_path('app/commandlistIC-encrypted/'.$query_file_name->file_name),'123456');
                    //$file_location = storage_path('app/commandlistIC-encrypted/'.$query_file_name->file_name);
                        foreach ($resultArray as $value) {
                            $data = array('datethai'=> $this->datethai);
                            $to_name = trim($value['email']);
                            $arr_email_to =  trim($value['email']);
                            $thaidate_display = $this->datethai;
                            try{
                                $send = Mail::send(['html' => "commandic::sendingmail"], $data, function($message) use ($to_name, $arr_email_to, $thaidate_display, $file_location) {
                                $message->to($arr_email_to, $to_name)
                                ->subject("ข้อสั่งการศูนย์ปฏิบัติการภาวะฉุกเฉินทางสาธารณสุข ประจำวันที่ ".$thaidate_display);
                                // $message->from("ddc.devteams@gmail.com","DDC-ECOSYSTEMS");
                                $message->from("thaiddc.itc@ddc.mail.go.th","DDC-ECOSYSTEMS");
                                $message->attach($file_location);
                                });
                            }catch(\Exception $e){
                                // Get error here
                                echo $e;
                            }
                        }
                }
            }


            if($createCommandListIC) {
                return back()->with('success','อัพโหลดไฟล์คำสั่งการสำเร็จ');
            } else {
                return back()->with('error','อัพโหลดไฟล์คำสั่งการไม่สำเร็จ');
            }

        } catch (\Illuminate\Database\QueryException $exception) {
            // You can check get the details of the error using `errorInfo`:
            $status_error = $exception->errorInfo;
            // Return the response to the client..
            $status = $status_error['2'] .'   ,กรุณาบันทึกหน้าจอนี้แล้วแจ้งทีมผู้พัฒนาระบบ !!';
            return back()->with('error',$status);
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('commandic::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('commandic::edit');
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
    public function destroy($commandListIC_id)
    {
        $update_status                  =   DBCommandListIC::find($commandListIC_id);
        $update_status->user_id_delete  =   Auth::user()->id;
        $update_status->status          =   0;

        if ($update_status->save()) {
            return back()->with('success','ลบคำสั่งการสำเร็จ');
        } else {
            return back()->with('error','ลบคำสั่งการไม่สำเร็จ');
        }
    }

    public function viewFileCommandListIC($commandListIC_id)
    {
        $query_file = DBCommandListIC::select('id' ,'file_name', 'file_ori_name', 'count_view')->where('id', $commandListIC_id)->first();

        //update count_view
        $query_file->count_view = $query_file->count_view+1;
        $query_file->save();

        if(!$query_file) return abort(404);

        $path = $query_file->file_name;
        $name = $query_file->file_ori_name;

        return Storage::disk('commandlistIC')->response($path, $name);
    }

    public function downloadFileCommandListIC($commandListIC_id)
    {
        $query_file = DBCommandListIC::select('id', 'file_name', 'file_ori_name', 'count_download')->where('id', $commandListIC_id)->first();

        //update count_download
        $query_file->count_download = $query_file->count_download+1;
        $query_file->save();

        $insert_download_command_list_ic                        =   new DBDownloadCommandListIC;
        $insert_download_command_list_ic->users_id              =   Auth::user()->id;
        $insert_download_command_list_ic->command_list_ic_id    =   $query_file->id;

        $insert_download_command_list_ic->save();

        if(!$query_file) return abort(404);

        $path = $query_file->file_name;
        $name = $query_file->file_ori_name;

        return Storage::disk('commandlistIC')->download($path, $name);
    }
}
