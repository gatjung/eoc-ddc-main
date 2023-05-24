<?php

namespace Modules\Meeting\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Meeting\Entities\DBAnnounce;
use Auth;
use App\CmsHelper;

class AnnounceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('meeting::announce');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('meeting::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $role_group  = CmsHelper::Get_Current_Role_Group(Auth::user()->id);
        $role_th_arr = CmsHelper::Get_Roles_TH2();

        // dd($role_th_arr[$role_group]);

        // dd($request->topic);

        if($request->announce[0]!=null){
            foreach($request->announce as $value_announce){
                //$data[] = $request->comm_num[$i];

                // $data_command[] = array(
                //     //"user_id"   => $member_id->id,
                //     "user_id" => $member_id,
                //     "comm_num"  => trim($value),
                //     "comm_date" => trim($request->comm_date[$key])
                // );
                //echo $value_announce."\n";

                //dd($value_announce);
                // echo $value_announce;
                 $text_arr[] = $value_announce;
                //$text_arr = "dsdsdsdsds"."\r\n";
            }
                $text = $this->add_comma($text_arr);
                // // dd($text);
                // define("LINEAPI","https://notify-api.line.me/api/notify");
                // define("MESSAGE","ประกาศ\nเรื่อง :: ".$request->topic."\n".$text."\nผู้ประกาศ :: ".Auth::user()->name_th." ".Auth::user()->lname_th."\nหน่วยงาน :: ".$role_th_arr[$role_group]);

                // //define("TOKEN","wTDP6tmN5Ylk8U0KLELVwkDQNy9nfHo7SmsgwCnoG47");
                // //test

                // $data = array(
                //             'message' => MESSAGE,
                //             // 'stickerPackageId'=>$stickerPkg,
                //             // 'stickerId'=>$stickerId,
                //             // 'imageThumbnail' => $image_thumbnail_url,
                //             // 'imageFullsize' => $image_fullsize_url,
                //         );
                // $data = http_build_query($data,'','&');
                // $headerOptions = array(
                //     'http'=>array(
                //         'method'=>'POST',
                //         'header'=> "Content-Type: application/x-www-form-urlencoded\r\n"
                //         ."Authorization: Bearer ".env('LINE_GROUP_EOC')."\r\n"
                //         ."Content-Length: ".strlen($data)."\r\n",
                //         'content' => $data
                //     ),
                // );
                // $context = stream_context_create($headerOptions);
                // $result = file_get_contents(LINEAPI,FALSE,$context);
                // $res = json_decode($result);


                $url        = 'https://notify-api.line.me/api/notify';
                $token      = env('LINE_GROUP_EOC','wRTnADcrrnuYvYPu8eSMalDN0tvSH7EE4FoJuPiybNM');
                // dd($token);
                $headers    = [
                                'Content-Type: application/x-www-form-urlencoded',
                                'Authorization: Bearer '.$token
                            ];
                $fields     = "message=ประกาศเรื่อง :: ".$request->topic."\n".$text."\nผู้ประกาศ :: ".Auth::user()->name_th." ".Auth::user()->lname_th."\nหน่วยงาน :: ".$role_th_arr[$role_group];

                $ch = curl_init();
                curl_setopt( $ch, CURLOPT_URL, $url);
                curl_setopt( $ch, CURLOPT_POST, 1);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec( $ch );
                // dd($result);
                curl_close( $ch );
                $result = json_decode($result,TRUE);

                foreach($result as $key => $value) {
                    if ($value != 200) {
                        return redirect()->back()->with('error','ประกาศสำเร็จไม่สำเร็จ !!!');
                    } elseif ($value === 200) {
                        $data_announce              = new DBAnnounce;
                        $data_announce->user_id     = Auth::user()->id;
                        $data_announce->topic       = $request->topic;
                        $data_announce->announce    = $text;


                        if ($data_announce->save()) {
                            return redirect()->back()->with('success','ประกาศสำเร็จ');
                        } else {
                            return redirect()->back()->with('error','ประกาศสำเร็จไม่สำเร็จ !!!');
                        }
                    }
                }
        }
    }


    public function add_comma($data){
      $prefix = '';
      $split_word = "";
      foreach ($data as $val){
                $split_word .= $prefix . "" . $val . "";
                $prefix = "\r\n";
      }
      return $split_word;
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('meeting::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('meeting::edit');
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
