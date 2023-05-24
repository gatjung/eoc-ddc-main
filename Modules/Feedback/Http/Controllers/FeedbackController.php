<?php

namespace Modules\Feedback\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Feedback\Entities\DBFeedCom;
use Auth;
use App\CmsHelper;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('feedback::comment');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('feedback::create');
    }

    public function viewfeed()
    {
        $query = DBFeedCom::select('name','description','file_name','created_at','updated_at')
                    ->get();
        // $query =DB::table('feed_com')
        //         ->select('name','description','file_name','created_at','updated_at')
        //         ->get();
        return view('feedback::viewfeed',[
            'data_feedcom' => $query
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $name = Auth::user()->name_th." ".Auth::user()->lname_th;
        if ($request->hasFile('file_name')) {
            $file_name = $request->file('file_name');

            if (!$file_name->isValid()){
                return back()->with('error', $file->getErrorMessage());
            }

            $new_file_name = date('Ymd').'-feedback-'.CmsHelper::generateRandomString(10).'.'. $file_name->getClientOriginalExtension();
            $upload = $file_name->storeAs('feedback/img', $new_file_name);
        } else {
            $new_file_name = NULL;
        }

        $data_feedback = new DBFeedCom;

        $data_feedback->name        = $name;
        $data_feedback->description = $request->description;
        $data_feedback->file_name   = $new_file_name;


        if($data_feedback->save()){
            // $image_thumbnail_url = 'http://service.ddc.moph.go.th/storage/img/service/'.$filename_picture;
            // $image_fullsize_url = 'http://service.ddc.moph.go.th/storage/img/service/'.$filename_picture;


            define("LINEAPI","https://notify-api.line.me/api/notify");
            define("MESSAGE","\nชื่อผู้แจ้ง ::".Auth::user()->name_th." ".Auth::user()->lname_th."\nข้อเสนอแนะ :: ".$request->description);

            define("TOKEN","nOYJtLT6n9b4FEFQMDUS7VzmYXXPuNNBStyDS9AQRvw");
            //test

            $data = array(
                        'message' => MESSAGE,
                        // 'stickerPackageId'=>$stickerPkg,
                        // 'stickerId'=>$stickerId,
                        // 'imageThumbnail' => $image_thumbnail_url,
                        // 'imageFullsize' => $image_fullsize_url,
                    );
            $data = http_build_query($data,'','&');
            $headerOptions = array(
                'http'=>array(
                    'method'=>'POST',
                    'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                    ."Authorization: Bearer ".TOKEN."\r\n"
                    ."Content-Length: ".strlen($data)."\r\n",
                    'content' => $data
                ),
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINEAPI,FALSE,$context);
            $res = json_decode($result);

            return redirect()->back()->with('success','ขอบคุณสำหรับข้อเสนอแนะ');
        } else {
            return redirect()->back()->with('error','การบันทึกข้อมูลของคุณไม่สำเร็จ !!!');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('feedback::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('feedback::edit');
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
