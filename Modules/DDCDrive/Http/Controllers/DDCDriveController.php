<?php

namespace Modules\DDCDrive\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use App\CmsHelper;
use App\MyFilesUpload;
use App\MyFilesPrivate;
use App\MyFilesShareGroup;
use App\MyFilesSeenGroup;
use App\DBModelHasRoles;
use App\User;
use App\Roles;
use App\NotificationAlert;
use Storage;
use File;
use Auth;
use DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Validator;


class DDCDriveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct(){
       $this->middleware('auth');
       $mytime = Carbon::now();
       $this->current_datetime = $mytime->toDateTimeString();
       $this->year = $mytime->format('Y');
       $this->month = $mytime->format('m');

       $this->middleware(function ($request, $next) {
           $this->user = Auth::user();
           return $next($request);
       });
    }

    public function index()
    {
        $user_id = $this->user->id;

        $user_group =CmsHelper::Get_Current_Role_Group($user_id);

        $list_my_files_upload = MyFilesUpload::where('file_owner',$user_id)->where('file_status','N')->orderBy('created_at','desc')->get();
        $list_my_files_private = MyFilesPrivate::leftJoin('ddcdrive_myfile','ddcdrive_myfile.file_id','=','ddcdrive_sharing_specific_user.file_id')
                                  ->leftJoin('users','users.id','=','ddcdrive_sharing_specific_user.owner_user_id')
                                  ->where('ddcdrive_sharing_specific_user.user_id_sharing',$user_id)
                                  ->select('ddcdrive_myfile.file_ori_name AS file_ori_name','ddcdrive_myfile.file_name AS file_name','ddcdrive_myfile.files_description AS files_description' ,'ddcdrive_sharing_specific_user.created_at AS created_at','users.name_th AS name_th','users.lname_th AS lname_th','ddcdrive_myfile.file_folder_name AS file_folder_name','ddcdrive_sharing_specific_user.file_id AS file_id')
                                  ->where('ddcdrive_sharing_specific_user.file_status','N')
                                  ->OrderBy('ddcdrive_sharing_specific_user.created_at','desc')
                                  ->get();
        $list_my_files_share_group = MyFilesShareGroup::leftJoin('ddcdrive_myfile','ddcdrive_myfile.file_id','=','ddcdrive_sharing_group.file_id')
                                  ->leftJoin('users','users.id','=','ddcdrive_myfile.file_owner')
                                  ->select('ddcdrive_myfile.file_ori_name AS file_ori_name','ddcdrive_myfile.file_name AS file_name','ddcdrive_myfile.files_description AS files_description' ,'ddcdrive_sharing_group.created_at AS created_at','users.name_th AS name_th','users.lname_th AS lname_th','ddcdrive_myfile.file_folder_name AS file_folder_name','ddcdrive_sharing_group.file_id AS file_id','ddcdrive_sharing_group.role_or_group')
                                  ->where('ddcdrive_sharing_group.file_status','N')
                                  ->where('ddcdrive_sharing_group.role_or_group',$user_group)
                                  ->OrderBy('ddcdrive_sharing_group.created_at','desc')
                                  ->get();
        // dd($list_my_files_share_group);
        return view('ddcdrive::index',[
          'list_my_files_upload' => $list_my_files_upload,
          'list_my_files_private' => $list_my_files_private,
          'list_my_files_share_group' => $list_my_files_share_group
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('ddcdrive::create');
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
        return view('ddcdrive::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('ddcdrive::edit');
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



    public function Upload_Files(Request $request){

        //dd($request->all());
        $user_id = $this->user->id;
        //Check Folder Generate
        $before_folder_create = MyFilesUpload::select('file_folder_name')->where('file_owner',$user_id)->first();
        if($before_folder_create){
          $folder =  $before_folder_create->file_folder_name;
        }else{
          //Auto Generate FolderName Private For User
          $folder = CmsHelper::generateRandomString(10);
        }

        if($request->hasFile('customFile')){


          $rules = [
              'customFile' => 'required|max:20000|mimes:jpg,png,gif,pdf,doc,docx,xls,xlsx,csv,txt,ppt,pptx',
          ];

          $customMessages = [
            'customFile.required' => 'คุณยังไม่ได้เลือกไฟล์ที่ต้องการอัพโหลด',
            'customFile.max' => 'ระบบรองรับไฟล์ขนาดไม่เกิน 20MB',
            'customFile.mimes' => 'ระบบรองรับไฟล์นามสกุลดังต่อไปนี้ jpg,png,gif,pdf,doc,docx,xls,xlsx,csv,txt,ppt,pptx'
          ];

          $validator = Validator::make($request->all(), $rules ,$customMessages);
          if ($validator->fails()) {
              return back()->with('error',$validator->errors()->first());
          }
          // cache the file
          $file = $request->file('customFile');
          // generate a new filename. getClientOriginalExtension() for the file extension
          $filename = date('Ymd').'-ddcdrive-'.CmsHelper::generateRandomString(10).'.'. $file->getClientOriginalExtension();
          // save to storage/app/photos as the new $filename
          $path_file_upload = $file->storeAs('ddcdrive/'.$folder, $filename);
          //get original file name
          //$ori_file_name = $file->getClientOriginalName();
          $ori_file_name = $request->file('customFile')->getClientOriginalName();

          try {
              MyFilesUpload::create([
                'file_ori_name' => $ori_file_name,
                'file_name' => $filename,
                'files_description' => (isset($request->files_description)) ? $request->files_description : NULL ,
                'file_folder_name' => trim($folder),
                'file_owner' => $user_id,
                'file_status' => 'N'
              ]);
              return back()->with('success','อัพโหลดไฟล์สำเร็จ');
          } catch (\Illuminate\Database\QueryException $exception) {
              // You can check get the details of the error using `errorInfo`:
              $status_error = $exception->errorInfo;
              // Return the response to the client..
              $status = $status_error['2'] .'   ,กรุณาบันทึกหน้าจอนี้แล้วแจ้งทีมผู้พัฒนาระบบ !!';
              return back()->with('error',$status);
          }

        }else{
          //$filename = NULL;
          return back()->with('error','พบข้อผิดพลาดในการอัพโหลดไฟล์กรุณาตรวจสอบชนิดของไฟล์อีกครั้ง');
        }
    }


    public function List_User_All(Request $request){
        // dd($request);
      $out_u_id = [];
      $own_u_id = [];
      //list user id in selected out
      $list_permission_private_query = MyFilesPrivate::select('user_id_sharing', 'owner_user_id')->where('file_id',$request->file_id)->get();
      foreach($list_permission_private_query as $u_id){
        $out_u_id[] = $u_id->user_id_sharing;
        $own_u_id[] = $u_id->owner_user_id;
      }
      //add current user
      $out_u_id[] = $this->user->id;

    //   dd($out_u_id);
    //   dd($own_u_id);
    // if (!$own_u_id) {
    //     dd("yes");
    // }
      if (!$own_u_id) {
        $result = User::query();

        if(isset($request->searchTerm)){
          //   $result = $result->where('name_th', 'like', '%' . $request->searchTerm . '%');
          //   $result = $result->Orwhere('lname_th', 'like', '%' . $request->searchTerm . '%');
          //   $result = $result->whereNotIn('id',$out_u_id);
          $result = $result->WhereRaw("concat(name_th, ' ', lname_th) like '%$request->searchTerm%'");
        }
        $result = $result->whereNotIn('id',$out_u_id);

        $result = $result->whereNotIn('id',$own_u_id);

        $result = $result->select('id','name_th','lname_th');
        $result = $result->get();
      //   dd($result);
        $datas = array();
        foreach($result as $data){
          $json_datas[] = array("id"=>$data->id, "text"=>$data->name_th.' '.$data->lname_th);
        }
        if(count($result)>0){
          return response()->json($json_datas);
        }
      } else {
        $result = User::query();

        if(isset($request->searchTerm)){
          //   $result = $result->where('name_th', 'like', '%' . $request->searchTerm . '%');
          //   $result = $result->Orwhere('lname_th', 'like', '%' . $request->searchTerm . '%');
          //   $result = $result->whereNotIn('id',$out_u_id);
          $result = $result->WhereRaw("concat(name_th, ' ', lname_th) like '%$request->searchTerm%'");
        }
        $result = $result->whereNotIn('id',$out_u_id);
        if ($own_u_id[0] != null) {
          $result = $result->whereNotIn('id',$own_u_id);
        }
        $result = $result->select('id','name_th','lname_th');
        $result = $result->get();
      //   dd($result);
        $datas = array();
        foreach($result as $data){
          $json_datas[] = array("id"=>$data->id, "text"=>$data->name_th.' '.$data->lname_th);
        }
        if(count($result)>0){
          return response()->json($json_datas);
        }
      }
    }

    public function List_Group_All(Request $request){
      $out_r_id = [];
      //list role id in selected out
      $list_permission_group_query = MyFilesShareGroup::select('role_or_group')->where('file_id',$request->file_id)->get();
      foreach($list_permission_group_query as $r_id){
        $out_r_id[] = $r_id->role_or_group;
      }
      //query role name
      $result = Roles::query();

      if(isset($request->searchTerm)){
          $result = $result->where('name', 'like', '%' . $request->searchTerm . '%');
          $result = $result->whereNotIn('id',$out_r_id);
      }
      $result = $result->whereNotIn('id',$out_r_id);
      $result = $result->select('id','name');
      $result = $result->where('status',1);
      $result = $result->get();

      $datas = array();
      foreach($result as $data){
        $json_datas[] = array("id"=>$data->id, "text"=>$data->name);
      }
      if(count($result)>0){
        return response()->json($json_datas);
      }
    }


    public function Add_Private_Permission(Request $request){
        // dd($request->file_id);
        if(empty($request->file_id)) return abort(404);
        $user_id = $this->user->id;
        $check_sharing_specific = MyFilesPrivate::where('file_id',$request->file_id)->where('file_status','N')->exists();
        if ($check_sharing_specific) {
           // found
           $list_permission_private_query = MyFilesPrivate::where('file_id',$request->file_id)->where('file_status','N')->OrderBy('created_at','desc')->get();
        //    dd($list_permission_private_query);
           $list_users = CmsHelper::Get_List_User_TH();
           foreach($list_permission_private_query as $permission_private){
             $list_permission_private[] = [
                                            "share_id" => $permission_private->share_user_id,
                                            "fullname" => $list_users[$permission_private->user_id_sharing],
                                            "read_at" => $permission_private->read_at
                                          ];
           }
        }else{
            $list_permission_private = NULL;
        }
        // dd($list_permission_private);
        $show_filename_to_share = MyFilesUpload::select('file_id','file_name','file_ori_name','files_description')->where('file_id',$request->file_id)->where('file_status','N')->first();
        if(!isset($show_filename_to_share)){
          return abort(404);
        }
        return view('ddcdrive::share-direct',[
                'list_permission_private' => $list_permission_private,
                'filename_to_share' => $show_filename_to_share,
                'status' => $request->status
        ]);
    }
    public function Saved_Private_Permission(Request $request){
        // dd($request->file_id);
      if ($request->status == "shareprivate") {
        $owner_user_id = $this->user->id;
      } elseif ($request->status == "privatetoprivate") {
        $data_owner_user_id = MyFilesPrivate::select('owner_user_id')->where('file_id', '=', $request->file_id)->first();
        $owner_user_id = $data_owner_user_id->owner_user_id;
        // dd($owner_user_id);
      } elseif ($request->status == "grouptoprivate") {
        $data_owner_user_id = MyFilesShareGroup::select('owner_user_id')->where('file_id', '=', $request->file_id)->first();

        $owner_user_id = $data_owner_user_id->owner_user_id;

      }

      if(!isset($request->file_id)){
        return abort(404);
      }

      $data_file = MyFilesUpload::where('file_id',$request->file_id)->first();

      if(!$data_file){
        return view('ddcdrive::error-page.error-file-not-found');
      }
    //   dd($request->share_user);
      if(is_null($request->share_user)){
        //   dd("yes");
        if ($request->status == "shareprivate") {
          return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'shareprivate'])->with('warning','ท่านยังไม่ได้เลือกผู้ใช้งานที่ต้องการแชร์ไฟล์');
        } elseif ($request->status == "privatetoprivate") {
          return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'privatetoprivate'])->with('warning','ท่านยังไม่ได้เลือกผู้ใช้งานที่ต้องการแชร์ไฟล์');
        } elseif ($request->status == "grouptoprivate") {
          return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'grouptoprivate'])->with('warning','ท่านยังไม่ได้เลือกผู้ใช้งานที่ต้องการแชร์ไฟล์');
        }

      }else{
        // dd($owner_user_id);

        foreach($request->share_user as $value_share_user){

          $data[] = [ 'file_id' => $request->file_id,
                      'user_id_sharing' => $value_share_user,
                      'owner_user_id' => $owner_user_id,
                      'created_at' => $this->current_datetime,
                      'updated_at' => $this->current_datetime,
                      'file_status' => 'N'
                    ];
        // dd($data_owner_user_id);

        // if ($owner_user_id != null) {
        //   $sender_name = CmsHelper::Get_UserID($owner_user_id)['username'];
        //   $sender_u_id = CmsHelper::Get_UserID($owner_user_id)['user_id'];
        //   $sender_fname = CmsHelper::Get_UserID($owner_user_id)['fname'];
        //   $sender_lname = CmsHelper::Get_UserID($owner_user_id)['lname'];
        // } else {
        //     $sender_name = "";
        //     $sender_u_id = "";
        //     $sender_fname = "";
        //     $sender_lname = "";
        // }

          $user_id = $this->user->id;
        //   dd($user_id);
          $data_user = User::find($user_id);

        //   dd($data_user);

        //   $sender_name = CmsHelper::Get_UserID($owner_user_id)['username'];
          $sender_name = $data_user->username;
        //   $sender_u_id = CmsHelper::Get_UserID($owner_user_id)['user_id'];
          $sender_u_id = $data_user->id;
        //   $sender_fname = CmsHelper::Get_UserID($owner_user_id)['fname'];
          $sender_fname = $data_user->name_th;
        //   $sender_lname = CmsHelper::Get_UserID($owner_user_id)['lname'];
          $sender_lname = $data_user->lname_th;
          $receiver_name = CmsHelper::Get_UserID($value_share_user)['username'];
          $receiver_u_id = CmsHelper::Get_UserID($value_share_user)['user_id'];

          $data_notif[] = [
                      'sender_name'=> $sender_name,
                      'sender_u_id'=> $sender_u_id,
                      'receiver_name'=> $receiver_name,
                      'receiver_u_id'=> $receiver_u_id,
                      'subject'=> 'การแชร์ไฟล์',
                      'detail'=> '<p>คุณ '.$sender_fname.' '.$sender_lname.' ได้แชร์ไฟล์ '.$data_file->file_ori_name." ถึงคุณ / รายละเอียดเพิ่มเติม : ".$data_file->files_description.'</p>',
                      'url_redirect'=> "/ddcdrive/Download-Files-Update-Click/".$data_file->file_folder_name."/".$data_file->file_id."/private",
                      'module_name'=> 'ddcdrive'
                    ];
        }
      }
      // Insert sharing table
      try {
          MyFilesPrivate::insert($data);
          //Add into Notify Table
          NotificationAlert::insert($data_notif);
          if ($request->status == "shareprivate") {
              return redirect()->route('ddcdrive.form.addprivate.permission',[$request->file_id,'status'=>'shareprivate'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          } elseif ($request->status == "privatetoprivate") {
              return redirect()->route('ddcdrive.form.addprivate.permission',[$request->file_id,'status'=>'privatetoprivate'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          } elseif ($request->status == "grouptoprivate") {
              return redirect()->route('ddcdrive.form.addprivate.permission',[$request->file_id,'status'=>'grouptoprivate'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          }
      } catch (\Illuminate\Database\QueryException $exception) {
          // You can check get the details of the error using `errorInfo`:
          $status_error = $exception->errorInfo;
          // Return the response to the client..
          $status = $status_error['2'] .'   ,กรุณาบันทึกหน้าจอนี้แล้วแจ้งทีมผู้พัฒนาระบบ !!';

          if ($request->status == "shareprivate") {
            return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'shareprivate'])->with('error',$status);
          } elseif ($request->status == "privatetoprivate") {
            return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'privatetoprivate'])->with('error',$status);
          } elseif ($request->status == "grouptoprivate") {
            return redirect()->route('ddcdrive.form.addprivate.permission', [$request->file_id, 'status'=>'grouptoprivate'])->with('error',$status);
          }
        //   return redirect()->route('ddcdrive.form.addprivate.permission',$request->file_id)->with('error',$status);
      }
    }
    public function Del_Private_Permission(Request $request){
      //if($request->share_id) return abort(404);
      // $deletedRows = MyFilesPrivate::where('share_user_id', $request->share_id)
      //                               ->update([
      //                                 "file_status" => "D"
      //                               ]);
      $deletedRows = MyFilesPrivate::where('share_user_id', $request->share_id)->delete();
      if($deletedRows){
        $json_datas = array("status" => "ok");
        return response()->json($json_datas);
      }else{
        $json_datas = array("status" => "failed");
        return response()->json($json_datas);
      }
    }

    public function My_DownloadFile(Request $request){
      $query = MyFilesUpload::select('file_name','file_ori_name')->where('file_status','N')->where('file_id',$request->file_id)->first();

      if(!$query) return abort(404);

      $path = trim($request->file_folder_name).'/'.$query->file_name;

      return Storage::disk('ddcdrive')->download($path,$query->file_ori_name);
    }


    public function DownloadFile(Request $request){

      $query = MyFilesUpload::select('file_name','file_ori_name')->where('file_status','N')->where('file_id',$request->file_id)->exists();

      if(!$query){
        return view('ddcdrive::error-page.error-file-not-found');
      }

      $query = MyFilesUpload::select('file_name','file_ori_name')->where('file_status','N')->where('file_id',$request->file_id)->first();
      $user_id_seen = $this->user->id;

      if($request->st=="private"){
        //Check Permission In Share Private
        $check_permission_private =  MyFilesPrivate::where('user_id_sharing',$user_id_seen)->first();

        if ($check_permission_private) {
            $update_seen_private = MyFilesPrivate::where('user_id_sharing',$user_id_seen)
                                        ->update([
                                          "read_at" => $this->current_datetime,
                                          "read_status" => "Y"
                                        ]);
            $path = trim($request->file_folder_name).'/'.$query->file_name;
            return Storage::disk('ddcdrive')->download($path,$query->file_ori_name);
        }else{
          return view('ddcdrive::error-page.error-permission');
        }

      }elseif($request->st=="group"){

        $insert_seen_group = MyFilesSeenGroup::where('file_id', $request->file_id)->where('user_id_sharing',$user_id_seen)->first();

        //Check Permission In Roles
        $check_permission_group = DBModelHasRoles::where('model_id',$user_id_seen)->first();

        //Check Permission In Group
        $check_permission_mysharegroup = MyFilesShareGroup::select('role_or_group')->where('file_id', $request->file_id)->where('role_or_group',$check_permission_group->role_id)->first();

        if($check_permission_group != null && $check_permission_mysharegroup!= null){

          if($check_permission_group->role_id == $check_permission_mysharegroup->role_or_group){

            if ($insert_seen_group !== null) {
                $insert_seen_group->update([
                                              "read_at" => $this->current_datetime,
                                              "read_status" => "Y"
                                            ]);
            } else {
                $user = MyFilesSeenGroup::create([
                  "file_id" => $request->file_id,
                  "user_id_sharing" => $user_id_seen,
                  "role_id" => $check_permission_group->role_id,
                  "read_at" => $this->current_datetime,
                  "read_status" => "Y"
                ]);
            }

          $path = trim($request->file_folder_name).'/'.$query->file_name;
          //dd($path);

          if(Storage::exists('ddcdrive/'.$path)){
            return Storage::disk('ddcdrive')->download($path,$query->file_ori_name);
          }else{
            return view('ddcdrive::error-page.error-file-not-found');
          }

          }else{
            return view('ddcdrive::error-page.error-permission');
          }
        }else{
          return view('ddcdrive::error-page.error-file-not-found');
        }
      }
    }

    public function Add_Group_Permission(Request $request){
        // dd($request);
      if(empty($request->file_id)) return abort(404);
      $user_id = $this->user->id;
      $check_sharing_group = MyFilesShareGroup::where('file_id',$request->file_id)->where('file_status','N')->exists();
      $filename_to_share = MyFilesUpload::select('file_id','file_name','files_description','file_ori_name')->where('file_id',$request->file_id)->first();

      if (!$filename_to_share) {
        return view('ddcdrive::error-page.error-file-not-found');
      }
      if ($check_sharing_group) {
         // found
         $list_permission_share_group = MyFilesShareGroup::where('file_id',$request->file_id)->where('file_status','N')->OrderBy('created_at','desc')->get();
      }else{
          $list_permission_share_group = NULL;
      }
      //dd($list_permission_share_group);
      return view('ddcdrive::share-group',[
              'list_permission_share_group' => $list_permission_share_group,
              'filename_to_share' => $filename_to_share,
              'status' => $request->status
      ]);
    }

    public function Saved_Group_Permission(Request $request){
    //   dd($request->status);
    // if(is_null($request->share_group)){
    //     dd("yes");
    // }
      $owner_user_id = $this->user->id;
      // dd($owner_user_id);

      if(!isset($request->file_id)){
        return abort(404);
      }

    //   dd($request);

      $data_file = MyFilesUpload::where('file_id',$request->file_id)->first();

      if(is_null($request->share_group)){
        //   dd($request->status);
        if ($request->status == "grouptogroup") {
          return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'grouptogroup'])->with('warning','ท่านยังไม่ได้เลือกกลุ่มภาระกิจที่ต้องการแชร์ไฟล์');
        } elseif ($request->status == "privatetogroup") {
          return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'privatetogroup'])->with('warning','ท่านยังไม่ได้เลือกกลุ่มภาระกิจที่ต้องการแชร์ไฟล์');
        } elseif ($request->status == "sharegroup") {
          return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'sharegroup'])->with('warning','ท่านยังไม่ได้เลือกกลุ่มภาระกิจที่ต้องการแชร์ไฟล์');
        }
      }else{

        foreach($request->share_group as $value_share_group){
          $data[] = [ 'file_id' => $request->file_id,
                      'role_or_group' => $value_share_group,
                      'owner_user_id' => $owner_user_id,
                      'created_at' => $this->current_datetime,
                      'updated_at' => $this->current_datetime,
                      'file_status' => 'N'
                    ];

            $data_user_id_in_roles = DB::table('users')
                  ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                  ->select('users.id as id')
                  ->whereIn('model_has_roles.role_id',$request->share_group)
                  ->whereNotIn('model_has_roles.model_id',[$this->user->id])
                  ->get();
        }
      }
      // Insert sharing table
      try {

          $sender_name = CmsHelper::Get_UserID($this->user->id)['username'];
          $sender_u_id = CmsHelper::Get_UserID($this->user->id)['user_id'];
          $sender_fname = CmsHelper::Get_UserID($this->user->id)['fname'];
          $sender_lname = CmsHelper::Get_UserID($this->user->id)['lname'];

            foreach($data_user_id_in_roles as $data_user_id){

                $receiver_name = CmsHelper::Get_UserID($data_user_id->id)['username'];
                $receiver_u_id = CmsHelper::Get_UserID($data_user_id->id)['user_id'];

                $data_notif[] = [
                            'sender_name'=> $sender_name,
                            'sender_u_id'=> $sender_u_id,
                            'receiver_name'=> $receiver_name,
                            'receiver_u_id'=> $receiver_u_id,
                            'subject'=> 'การแชร์ไฟล์',
                            'detail'=> '<p>คุณ '.$sender_fname.' '.$sender_lname.' ได้แชร์ไฟล์แบบกลุ่มภารกิจ '.$data_file->file_ori_name." ถึงคุณ / รายละเอียดเพิ่มเติม : ".$data_file->files_description.'</p>',
                            'url_redirect'=> "/ddcdrive/Download-Files-Update-Click/".$data_file->file_folder_name."/".$data_file->file_id."/group",
                            'module_name'=> 'ddcdrive'
                          ];
            }

          MyFilesShareGroup::insert($data);
          //Add into Notify Table
          NotificationAlert::insert($data_notif);

          if ($request->status == "grouptogroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'grouptogroup'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          } elseif ($request->status == "privatetogroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'privatetogroup'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          } elseif ($request->status == "sharegroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'sharegroup'])->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
          }
        //   return redirect()->route('ddcdrive.form.addgroup.permission', $request->file_id)->with('success','เพิ่มสิทธิ์ในการเข้าถึงไฟล์สำเร็จ');
      } catch (\Illuminate\Database\QueryException $exception) {
          // You can check get the details of the error using `errorInfo`:
          $status_error = $exception->errorInfo;
          // Return the response to the client..
          $status = $status_error['2'] .'   ,กรุณาบันทึกหน้าจอนี้แล้วแจ้งทีมผู้พัฒนาระบบ !!';

          if ($request->status == "grouptogroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'grouptogroup'])->with('error',$status);
          } elseif ($request->status == "privatetogroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'privatetogroup'])->with('error',$status);
          } elseif ($request->status == "sharegroup") {
            return redirect()->route('ddcdrive.form.addgroup.permission', [$request->file_id, 'status'=>'sharegroup'])->with('error',$status);
          }
        //   return redirect()->route('ddcdrive.form.addgroup.permission',$request->file_id)->with('error',$status);
      }
    }

    public function Del_Group_Permission(Request $request){

      //if($request->share_id) return abort(404);
      // $deletedRows = MyFilesPrivate::where('share_user_id', $request->share_id)
      //                               ->update([
      //                                 "file_status" => "D"
      //                               ]);
      $deletedRows = MyFilesShareGroup::where('share_group_id', $request->share_group_id)->delete();
      if($deletedRows){
        $json_datas = array("status" => "ok");
        return response()->json($json_datas);
      }else{
        $json_datas = array("status" => "failed");
        return response()->json($json_datas);
      }
    }

    // public function EditFile(Request $request){
    //
    //   if(empty($request->file_folder_name) && empty($request->file_id)) return view('ddcdrive::error-page.error-file-not-found');
    //
    //   $user_id_owner = $this->user->id;
    //
    //   $query = MyFilesUpload::where('file_id',$request->file_id)->where('file_owner',$user_id_owner)->first();
    //
    //   if($query === null){
    //     return view('ddcdrive::error-page.error-file-not-found');
    //   }else{
    //     return view('ddcdrive::edit-form-upload',[
    //             'file_datas' => $query,
    //     ]);
    //   }
    //
    // }

    public function DeleteFile(Request $request){
      if(empty($request->file_folder_name) && empty($request->file_id)) return view('ddcdrive::error-page.error-file-not-found');

      $user_id_owner = $this->user->id;

      //$deletedRows = MyFilesUpload::where('file_id',$request->file_id)->where('file_owner',$user_id_owner)->update(['file_ori_name' => NULL,'file_name' => NULL]);
      $deletedRows = MyFilesUpload::where('file_id',$request->file_id)->delete();
      //Clear File
      MyFilesPrivate::where('file_id',$request->file_id)->delete();
      MyFilesShareGroup::where('file_id',$request->file_id)->delete();
      MyFilesSeenGroup::where('file_id',$request->file_id)->delete();

      $real_path = '/app/ddcdrive/'.trim($request->folder_name).'/'.$request->file_name_replace;
      $path_ddcdrive = storage_path().$real_path;
      $del_file = File::delete($path_ddcdrive);

      if($deletedRows){
        $json_datas = array("status" => "ok");
        return response()->json($json_datas);
      }else{
        $json_datas = array("status" => "failed");
        return response()->json($json_datas);
      }
    }

    public function ViewSeenByGroup(Request $request){

        if(empty($request->file_id)) return false;
        Carbon::setLocale('th');
        $myfile = MyFilesUpload::where('file_id',$request->file_id)->exists();

        if(!$myfile){
          return false;
        }else{
          $myfile_name = MyFilesUpload::select('file_ori_name')->where('file_id',$request->file_id)->first();
          $datas = MyFilesSeenGroup::select('users.name_th as name_th','users.lname_th as lname_th','ddcdrive_seen_group.read_at as read_at')
                  ->leftJoin('users','users.id', '=', 'ddcdrive_seen_group.user_id_sharing')
                  ->leftJoin('ddcdrive_myfile','ddcdrive_seen_group.file_id','=','ddcdrive_myfile.file_id')
                  ->where('ddcdrive_seen_group.file_id',$request->file_id)
                  ->where('ddcdrive_seen_group.role_id',$request->role_id)
                  ->get();

          echo "<p class='font-weight-bold'>ไฟล์ชื่อ : ".$myfile_name->file_ori_name."</p>";
          echo "<p class='text-info'>".$request->rolename."</p>";

          foreach($datas as $data){
            echo "<p class='text-success'> คุณ ".trim($data->name_th).' '.trim($data->lname_th).' อ่านไฟล์เมื่อ '.Carbon::parse($data->read_at)->diffForHumans()."</p>";
          }
      }
    }
}
