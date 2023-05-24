@extends('meeting::layouts.master')
@section('custom-css-script')
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/pickadate/themes/classic.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/pickadate/themes/classic.date.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/pickadate/themes/classic.time.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/pickadate/themes/my.css')}}">

<!-- summernote -->
<link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
@stop
@section('custom-css')
<style>
  .card-header {
    padding: 0px;
    font-size: 14px;
    padding-left: 4px;
  }
  .card-title {
    font-weight: bold;
    color: green;
  }
  .my-small {
    font-size: 10px;
  }
  .bar-order {
    padding: 5px;
    text-align: right;
    background-color: aliceblue;
  }
  .form-control[readonly] {
    background-color: white;
  }
  .picker__holder {
    min-width: 500px;
  }
  @media only screen and (max-width: 600px) {
    .picker__holder {
      min-width: 300px;
    }
  }

  .icheck-success label {
    font-weight: normal !important;;
  }
  p {
    margin-bottom: 0;
  }

  .picker--opened .picker__holder {
    max-height: 17em;
  }
</style> 
@stop
@section('content')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2><span class="text-primary">เพิ่ม</span> คำสั่งการ</h2>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container-fluid">
  
  <!--[START : Main input form]-->
  <form id="mem_form" action="{{Route('meeting.insert')}}" method="post">
  @csrf
  <input type="hidden" name="type" value="1"><!--[1=ข้อสั่งการ]-->
  <input type="hidden" name="old_id" value="0">

  <div class="callout callout-success">
  <div class="card-header"><h3 class="card-title">หัวข้อคำส่งการ</h3></div>

  <div class="card-body p-2">
    <span>เรื่อง</span><br>
    <textarea id="title" name="title" class="form-control txtn" placeholder="ชื่อการประชุม" require></textarea>
  </div>

  <div class="row">
    
    <div class="col-md-3">
      <div class="card-body p-2">
        <span>ครั้งที่</span><br>
        <div class="input-group">
          <input type="number" class="form-control" name="at_num" min='1' value="1" required>
          <div class="input-group-prepend">
            <span class="input-group-text">/</span>
          </div>
          <input type="number" class="form-control" name="at_year" value="{{date('Y')+543}}"
            maxlength='4' required>
        </div>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-body p-2">
        <span>วันที่</span><br>
        <input name="at_date" class="datepicker form-control" require
          type="text" placeholder="วัน/เดือน/ปี" readonly="readonly" />
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-body p-2">
        <span>เวลาเริ่ม</span><br>
        <input name="at_start" class="timepicker form-control" require autocomplete="off"
          type="text" placeholder="เริ่มประชุม" readonly="readonly" />
      </div>
    </div>

    <div class="col-md-3">
      <div class="card-body p-2">
        <span>เวลาจบ</span><br>
        <input name="at_end" class="timepicker form-control" require autocomplete="off"
          type="text" placeholder="เริ่มประชุม" readonly="readonly" />
      </div>
    </div>

  </div>


    <div class="card-body p-2">
        <span>สถานที่จัดประชุม</span><br>
        <input type="text" class="form-control" name="at_area" placeholder="ชื่อห้องประชุม"
        value="ศูนย์ปฏิบัติการภาวะฉุกเฉิน กรมควบคุมโรค" required>
    </div>

    <div class="card-body p-2">
        <span>ประธาน</span><br>
        <input type="hidden" name="president_id" value="0">
        <input type="text" class="form-control" name="president_name" placeholder="ชื่อประธาน" required>
    </div>
    
    </div>


    <div class="callout callout-info">
      <div class="card-header">
        <h3 class="card-title">รายละเอียด</h3>
      </div>
      <div class="card-body p-2">
        <span>เนื้อหาการประชุม</span><br>

          <div class="mb-3">
            <textarea class="textarea" id="detail" name="detail"
                      style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
          </div>

      <div class="card-body p-2">
        <span>สรุปประเด็นข้อสั่งการ</span><br>
        <input type="text" class="form-control" name="name_sum" placeholder="ชื่อผู้สรุปประเด็นข้อสั่งการ">
      </div>
      <div class="card-body p-2">
        <span>ตรวจประเด็นข้อสั่งการ</span><br>
        <input type="text" class="form-control" name="name_check" placeholder="ชื่อผู้ตรวจประเด็นข้อสั่งการ">
      </div>

      </div>
    </div>

    <div class="callout callout-info d-none">
      <div class="card-header">
        <h3 class="card-title">แนบเอกสาร</h3>
      </div>
      <div class="card-body p-2">
      <input type="text" class="form-control" name="link_file" placeholder="ลิงค์เอกสารแนบ">
      </div>
    </div>

    <div class="callout callout-warning">
      <div class="card-header">
        <h3 class="card-title">ประเด็นข้อสั่งการ</h3>
      </div>
      <div class="card-body p-2">
        <div id="area_order"></div>
        <div class="text-center">
        <button type="button" class="btn bg-success btn-sm pr-4 pl-4"
                data-toggle="modal" data-target="#modal_add">+ เพิ่ม</button>
        </div>
      </div>
    </div>


    <div class="callout callout-info">
      <div class="card-header">
        <h3 class="card-title">การประชุมติดตามสถานการณ์ครั้งถัดไป</h3>
      </div>
      <div class="card-body p-2 row">

        <div class="col-md-3">
        <div class="card-body p-2">
          <span>วันที่</span><br>
          <input name="book_at_date" class="datepicker form-control" require
            type="text" placeholder="วัน/เดือน/ปี" readonly="readonly" />
        </div>
      </div>

      <div class="col-md-3">
        <div class="card-body p-2">
          <span>เวลาเริ่ม</span><br>
          <input name="book_at_start" class="timepicker form-control" require autocomplete="off"
            type="text" placeholder="เริ่มประชุม" readonly="readonly" />
        </div>
      </div>
    
      </div>
    </div>

      <div class="text-center">
      <button type="submit" id="btn_submit" class="d-none"></button>
      <button type="button" class="btn btn-info btn-lg btn-block shadow-sm" onclick="pe_save()">
        <span class="far fa-save"></span> บันทึก
      </button>
      </div><br>

  </div>
 
  <input type="hidden" name="arr_orderid" id="arr_orderid" value="">
  </form>
</div><br><br><br><br><br><br><br></section>



<!--[ADD : ประเด็นข้อสั่งการ form]-->
<div class="modal fade" id="modal_add">
<form id="form_add">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">ประเด็นข้อสั่งการ</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <label>ประเด็นข้อสั่งการ</label>
            <textarea class='form-control txtn' name='modal_command' id="modal_command" 
              placeholder="ประเด็นข้อสั่งการ" rows='3'></textarea>

            <label class="pt-2">กำหนดส่งงาน</label> 
            <input name="end_at" id="end_at" class="datepicker form-control" require
              type="text" placeholder="ทันที" readonly="readonly" />


                <div class="form-group pt-2">
                  <label>หน่วยงานที่ได้รับมอบหมาย</label>
                  {!!$data_add!!}
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default pl-4 pr-4" data-dismiss="modal" onclick="area_reset()">ปิด</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="keep_data()">เพิ่มประเด็น</button>
            </div>
          </div>
        </div>
<button type="reset" class="d-none" id="form_add_reset">RESET</button>
</form>
</div>

<!--[Edit]-->
<div class="modal fade" id="modal_edit">
<form id="form_edit">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">ประเด็นข้อสั่งการ</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="area_reset()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <input name="edit_curr_id" id="edit_curr_id" type="hidden" value="0" />
            <label>ประเด็นข้อสั่งการ</label>
            <textarea class='form-control txtn' name='modal_command_edit' id="modal_command_edit" 
              placeholder="ประเด็นข้อสั่งการ" rows='3'></textarea>

            <label class="pt-2">กำหนดส่งงาน</label> 
            <input name="end_at_edit" id="end_at_edit" class="datepicker form-control" require
              type="text" placeholder="วัน/เดือน/ปี" readonly="readonly" />


                <div class="form-group pt-2">
                  <label>หน่วยงานที่ได้รับมอบหมาย</label>
                  {!!$data_edit!!}
                </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default pl-4 pr-4" data-dismiss="modal" onclick="area_reset2()">ปิด</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="edit_data()">แก้ไข</button>
            </div>
          </div>
        </div>
<button type="reset" class="d-none" id="form_edit_reset">RESET</button>
</form>
</div>

<!--[Delete]-->
<div class="modal fade" id="modal_del">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">ยืนยันการลบ</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="area_reset()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            <input name="del_curr_id" id="del_curr_id" type="hidden" value="0" />
            <span id="del_text"></span>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal" >ปิด</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal" 
                onclick="fn_modal_del()">ลบ</button>
            </div>
          </div>
        </div>
</div>


@endsection
@section('custom-js-script')
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>

<!--[calendar]-->
<script type="text/javascript" src="{{ asset('bower_components/admin-lte/plugins/pickadate/picker.js')}}"></script>
<script type="text/javascript" src="{{ asset('bower_components/admin-lte/plugins/pickadate/picker.date.js')}}"></script>
<script type="text/javascript" src="{{ asset('bower_components/admin-lte/plugins/pickadate/picker.time.js')}}"></script>
<script type="text/javascript" src="{{ asset('bower_components/admin-lte/plugins/pickadate/legacy.js')}}"></script>
<script type="text/javascript" src="{{ asset('bower_components/admin-lte/plugins/pickadate/themes.thai.js')}}"></script>

<!-- Summernote -->
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../plugins/summernote/plugin/summernote-cleaner.js"></script>
<style>
.summernote-cleanerAlert {display: none;}
.note-editor.note-frame .note-status-output, .note-editor.note-airframe .note-status-output {
    display: none;
}
</style> 
@stop
@section('custom-js-code')
<script>
  //[Set ค่าเริ่มต้น]
  $(function () {
    //[เลือกเวลา 7.00-17.00 เพิ่มที่ละ 30]
    $('.timepicker').pickatime({
      format: 'HH:i',
      min: [7,00],
      max: [17,00]
    })
    //[เรื่องการประชุม]
    $('.txtn').summernote({
    toolbar: [],
    cleaner:{
          action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
          newline: '<br>', // Summernote's default is to use '<p><br></p>'
          notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
          icon: '<i class="note-icon">[Your Button]</i>',
          keepHtml: false, // Remove all Html formats
          keepOnlyTags: ['<br>'], // If keepHtml is true, remove all tags except these
          keepClasses: false, // Remove Classes
          badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
          badAttributes: ['style', 'start'], // Remove attributes from remaining tags
          limitChars: false, // 0/false|# 0/false disables option
          limitDisplay: 'both', // text|html|both
          limitStop: false // true/false
    }
    });
    //[รายละเอียดการประชุม]
    $('#detail').summernote({
    height: 200,
    toolbar: [
      // [groupName, [list of button]]
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']]
    ],
    cleaner:{
          action: 'both', // both|button|paste 'button' only cleans via toolbar button, 'paste' only clean when pasting content, both does both options.
          newline: '<br>', // Summernote's default is to use '<p><br></p>'
          notStyle: 'position:absolute;top:0;left:0;right:0', // Position of Notification
          icon: '<i class="note-icon">[Your Button]</i>',
          keepHtml: false, // Remove all Html formats
          keepOnlyTags: ['<p>', '<br>', '<ul>', '<li>', '<b>', '<strong>','<i>', '<a>'], // If keepHtml is true, remove all tags except these
          keepClasses: false, // Remove Classes
          badTags: ['style', 'script', 'applet', 'embed', 'noframes', 'noscript', 'html'], // Remove full tags with contents
          badAttributes: ['style', 'start'], // Remove attributes from remaining tags
          limitChars: false, // 0/false|# 0/false disables option
          limitDisplay: 'both', // text|html|both
          limitStop: false // true/false
    }
    });
    //-------------------------------
  });

  //ก่อนบันทึก
  function pe_save() {
    $error = '';
    
    $title = $("#title").summernote("code");
    if( $title == "<p><br></p>"){
      $error += "ไม่มีหัวข้อคำส่งการ\n";
    }
    $detail = $("#detail").summernote("code");
    if( $detail == "<p><br></p>"){
      $error += "ไม่มีเนื้อหาการประชุม\n";
    }
    if( $("#area_order").html() == '' ) {
      $error += "ไม่มีประเด็นข้อสั่งการ\n";
    }
    //---------------------------------
    if($error == '') {
      $("#btn_submit").click();
    }else{
      alert($error);
    }
  }

  //[เอาไว้ reset ค่าใน popup check list]
  function area_reset() {
    $("#form_add_reset").click();
    $('#modal_command').summernote('reset');
  }
  function area_reset2() {
    $("#form_edit_reset").click();
    $('#modal_command_edit').summernote('reset');
  }
  //-----------------------------------

  //[เอาไว้ดึงค่าใน popup check list]
  function gen(prefix) {
    var arr = []
    arr["central"]  = []; //เก็บ id ของส่วนกลาง
    arr["odpc"]     = []; //เก็บ code ของต่างจังหวัด
    arr["name"]     = []; //เก็บชื่อเอาไว้ไปแสดงในช่อง
    arr["other"]    = ''; //เก็บชื่ออื่นๆ ที่ได้รับมอบหมาย
    //ส่วนกลาง
    var main_chk = prefix+"check_central";
    var isClass = prefix+"central";
    var chk = document.getElementById(main_chk).checked;
    if(chk) {
      arr["central"].push("all");
      arr["name"].push(document.getElementById(main_chk).getAttribute('title'));
    }else{
      $('.'+isClass).each(function(){
        if(this.checked) {
          arr["central"].push($(this).val());
          arr["name"].push($(this).attr('title'));
        }
      });
    }
    //ภูมิภาค
    main_chk = prefix+"check_odpc";
    isClass = prefix+"odpc";
    chk = document.getElementById(main_chk).checked;
    if(chk) {
      arr["odpc"].push("all");
      arr["name"].push(document.getElementById(main_chk).getAttribute('title'));
    }else{
      $('.'+isClass).each(function(){
        if(this.checked) {
          arr["odpc"].push($(this).val());
          arr["name"].push($(this).attr('title'));
        }
      });
    }
    //อื่นๆ
    main_chk = prefix+"check_other";
    var txt = document.getElementById(prefix+"check_other_txt").value;
    chk = document.getElementById(main_chk).checked;
    if (chk && (txt!='')) {
      arr["other"] = txt;
      arr["name"].push(txt);
    }
    //----
    return arr;
  }
  //-----------------------------------

//[เมื่อมีการกด ยืนยันการเพิ่มคำสั่ง]
function keep_data() {
  var command = $('#modal_command').val(); //ข้อสั่งการ
  var temp = gen('add');
  var central = temp['central'];
  var odpc = temp['odpc'];
  var other = temp['other'];
  var arr_name = temp['name'];
  var end_at = document.getElementsByName('end_at_submit')[0].value;
  add_node(command, end_at, arr_name, central, odpc, other)
  area_reset();
}
//--------------------------

//[ทำงานเมื่อกด edit ในส่วนของคำสั่ง]
function fn_edit(id) {
  area_reset2();
  var Command = $("#Command"+id).val();    
  var Central = $("#Central"+id).val(); 
  var Odpc = $("#Odpc"+id).val();     
  var Other = $("#Other"+id).val();  
  var End = $("#End"+id).val();  

  //คำสั่งการ
  $("#modal_command_edit").summernote("code", Command);
  //วันที่ต้องส่งงาน
  var date = new Date(End);
  var picker = $('#end_at_edit').pickadate('picker');
  picker.set('select', date);
  //id ที่ทำงานอยู่
  $("#edit_curr_id").val(id);
  //checkbox กลุ่มที่ได้รับมอบหมาย
  setchk(Central, Odpc, Other);
}
//----------------------------

//[function for edit - ไว้ติ๊ก checkbox]
function setchk(Central, Odpc, Other) {
  var prefix = "edit";
  var central = prefix+"central";
  var odpc = prefix+"odpc";

  if (Central == 'all') {
    $("#"+prefix+"check_central").click();
  }
  else if(Central != ''){
    var Central = Central.split(",");
    Central.forEach(function(id) {
      document.getElementById(prefix+"check_"+id).checked = true;
    })
  }
  //-----------------------------------
  if (Odpc == 'all') {
    $("#"+prefix+"check_odpc").click();
  }
  else if(Odpc != ''){
    var Odpc = Odpc.split(",");
    Odpc.forEach(function(id) {
      document.getElementById(prefix+"check_"+id).checked = true;
    })
  }
  //-----------------------------------
  if (Other) {
    document.getElementById("editcheck_other").checked = true;
    document.getElementById("editcheck_other_txt").value = Other;
  }
}
//----------------------------------

//[เมื่อมีการกด ยืนยันการแก้ไขคำสั่ง]
function edit_data() {
  var command = $('#modal_command_edit').val(); //ข้อสั่งการ
  var temp = gen('edit');
  var central = temp['central'];
  var odpc = temp['odpc'];
  var other = temp['other'];
  var arr_name = temp['name'];
  var end_at = document.getElementsByName('end_at_edit_submit')[0].value;
  //.................................
  var txtName = '';
  for(x in arr_name) {
    txtName += "<li>"+arr_name[x]+"</li>";
  }
  //.................................
  var id = $("#edit_curr_id").val();
  $("#Command"+id).val(command);
  $("#Command_txt"+id).html(command);
  $("#Central"+id).val(central);
  $("#Odpc"+id).val(odpc);
  $("#Other"+id).val(other);
  $("#txtEnd"+id).html(end_at);
  $("#End"+id).val(end_at);
  $("#Name"+id).html(txtName);
  area_reset2();
}
//----------------------------------------------

//[เอาไว้สร้าง node คำสั่งการ]
var curr_num = 0;
function add_node(command, end_at, name, central, odpc, other) {
  if(command != "") {
  curr_num++;
  var node = document.createElement("div");
  $(node).addClass("row border p-2");
  $(node).attr('id', "node_"+curr_num); //เอาไว้ใช้อ้างอิงตอนลบ
  document.getElementById("area_order").appendChild(node);
  var start_at = document.getElementsByName('at_date_submit')[0].value;
  if(!start_at) {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    start_at = yyyy + '-' + mm + '-' + dd;
  }
  if(end_at=='') {
    end_at = start_at;
  }
  //------------------------------------------------------
  var data ="<div class='col-md-5'>"
            
            +"<div class='row'>"
              +"<div class='col-1 text-center'>"+curr_num+"</div>"
              +"<div class='col-11'>"
                +"<input type='hidden' value='"+command+"' name='command[]' id='Command"+curr_num+"'>"
                +"<input type='hidden' value='"+central+"' name='central[]' id='Central"+curr_num+"'>"
                +"<input type='hidden' value='"+odpc+"' name='odpc[]' id='Odpc"+curr_num+"'>"
                +"<input type='hidden' value='"+other+"' name='other[]' id='Other"+curr_num+"'>"
                +"<input type='hidden' value='"+end_at+"' name='order_end[]' id='End"+curr_num+"' />"
                +"<div id='Command_txt"+curr_num+"'>"+command+"</div>"
                
              +"</div>"
            +"</div>"
            +"</div>"
            +"<div class='col-md-7'>"
            +"<ul id='Name"+curr_num+"'>";
            for(x in name) {
              data += "<li>"+name[x]+"</li>";
            }
      data +="</ul>"
            +"</div>"
            +"<div class='bar-order col-md-6'>"
            +"<div class='text-left small'>เริ่ม : "+start_at+", กำหนดส่งงาน : <span id='txtEnd"+curr_num+"'>"+end_at+"</span></div>"
            +"</div>"
            +"<div class='bar-order col-md-6'>"

            +"<button type='button' class='btn bg-warning btn-xs mr-1' "
            +"onclick=\"fn_edit("+curr_num+")\" "
            +"data-toggle='modal' data-target='#modal_edit'>แก้ไข</button>"

            +"<button type='button' class='btn bg-danger btn-xs' "
            +"onclick=\"fn_del(this, "+curr_num+")\" "
            +"data-detail='"+command+"' "
            +"data-toggle='modal' data-target='#modal_del'>ลบ</button>"

            +"</div>";

  $(node).html(data);
  //-------------------------------------------
  }
}


//ใส่ค่าใน popup ก่อนลบ
function fn_del(at, node) {
  var command = $(at).attr('data-detail');
  $("#del_text").html(command);
  $("#del_curr_id").val(node);
}
//เมือกดยืนยันการลบ
function fn_modal_del() {
  removeElement( "node_" + $("#del_curr_id").val() );
}
//เอาไว้ลบ node
function removeElement(id) {
    var elem = document.getElementById(id);
    elem.parentElement.removeChild(elem);
}


//กรณีกดติ๊กชื่อหลักให้ติ๊กทุกช่องที่อยู่ในกลุ่ม
function chkall(node, isClass) {
  var chk_all = document.getElementById(node).checked;
	if(chk_all) {
		$('.'+isClass).each(function(){
			this.checked = true;
		});
	}else{
		$('.'+isClass).each(function(){
			this.checked = false;
		});
	}
}
//กรณีเลือกด้านในกลุ่มออก 1 อันให้ติ๊กชื่อหลักออก
function chkone(node, chkall, isClass) {
  var chk = true;
  $('.'+isClass).each(function(){
			if(this.checked == false) {
        chk = false;
      }
	});
  document.getElementById(chkall).checked = chk;
}
//กรณีมีการพิมพ์ข้อความในกลุ่มอื่นๆ
function chkOther(node, chk) {
  var key = $(node).val();
  if( key.length > 1 ) {
    document.getElementById(chk).checked = true;
  }else{
    document.getElementById(chk).checked = false;
  }
}

</script>
@stop
