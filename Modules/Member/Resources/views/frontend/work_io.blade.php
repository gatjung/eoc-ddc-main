<?php
use App\CmsHelper as CmsHelper;
use Carbon\Carbon as Carbon;
?>
@extends('member::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@section('custom-css')
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('Lay/datepicker-thai/css/datepicker.css') }}">
@stop



@stop

@section('custom-css')
<style type="text/css">
  fieldset {
    border: 1px groove #058 !important;
    padding: 0 1.0em 1.0em 1.0em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
    width: auto;
  }
  legend {
    width: inherit;
    padding: 0 5px;
    border-bottom: none;
  }
</style>
@stop

@section('content')
  <!-- ALERT -->
@if(session()->has('Success'))
  <div class="alert alert-success alert-with-icon alert-dismissible fade show" data-notify="container">
    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
      <i class="nc-icon nc-simple-remove"></i>
    </button>
    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
    <span data-notify="message">{{ session()->get('Success')}}</span>
  </div>
@elseif(session()->has('msg_del'))
  <div class="alert alert-danger alert-with-icon alert-dismissible fade show" data-notify="container">
    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
      <i class="nc-icon nc-simple-remove"></i>
    </button>
    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
    <span data-notify="message">{{ session()->get('msg_del')}}</span>
  </div>
@endif

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ลงเวลาปฏิบัติงาน</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-outline-tabs">

  <div class="card-header bg-info">
    <h3 class="card-title">
      <i class="ion ion-clipboard mr-1"></i>ลงเวลา เข้า-ออก</h3>
  </div><!-- /.card-header -->
  <div class="card-body">


<div class="row">
    <div class="col-xl-12 p-2">
        วันที่ {{ CmsHelper::DateThai(date('Y-m-d')) }} | เวลา <span id="css_time_run"><?=date("H:i:s")?></span>
    </div>
    <div class="col-sm-12 p-2">
      <?php $datenow = date('Y-m-d'); ?>
        <!-- <label>เวลาเข้างาน :</label> -->
        <form action="{{ Route('work_insert') }}" method="post">
          @csrf
          @if($check_duplicate_check_in==0)
            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
            <button type="submit" class="btn btn-block btn-success btn-lg rounded-pill text-xl" name="chk_in" value="<?= date('Y-m-d H:i:s')?> ">
            <i class="fas fa-clock"></i> ลงเวลาเข้า</button>
          @else
            <button type="submit" class="btn btn-block btn-success btn-lg rounded-pill text-xl" disabled>
            <i class="fas fa-clock"></i> ลงเวลาเข้า</button>
          @endif
        </form>

    </div>
</div>
<!-- ./ end row -->

  </div>
  <!-- /.card-body -->

            </div>
          </div>
        </div>
      </div>
</section>


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ตารางบันทึกเวลา</h1>

      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline  shadow">
          <div class="card-header p-0 border-bottom-0">
            <div class="card-body">

              <!-- Filter Date -->
                  @if(session()->has('message'))
                      <p class="btn btn-success btn-block btn-sm custom_message text-left" style="margin-top: 10px;">{{ session()->get('message') }}</p>
                  @endif

                  <legend>ค้นหาข้อมูล</legend>
                      <form action="{{ route('work_getdate') }}" method="post">
                        @csrf
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="">เริ่ม</label>
                              <input type="text" class="form-control" value="@if(isset($start_date)){{ $start_date }} @endif" id="datepicker1" name="start_date">
                            </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="">สิ้นสุด</label>
                              <input type="text" class="form-control" value="@if(isset($end_date)){{ $end_date }} @endif" id="datepicker2" name="end_date">
                            </div>
                          </div>

                          <div class="col-md-2" style="margin-top: 32px;">
                            <div class="form-group">
                              <input type="submit" class="btn btn-success" value="ค้นหา">
                              <a href="{{ route('work_io') }}" type="button" class="btn btn-danger" >ยกเลิก</a>
                            </div>
                          </div>

                          <!-- <div class="col-md-2" style="margin-top: 32px;">
                            <div class="form-group">
                              <input type="reset" class="btn btn-primary" value="Clear">
                            </div>
                          </div> -->

                        </div>
                      </form>


              <div class="tab-content" id="custom-tabs-four-tabContent">
                <div class="tab-pane fade show active" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab">
                  <div class=" table-responsive">
                    <table class="table table-striped projects table-sm table-bordered table-hover" id="DTTH">

                        <thead class="text-nowrap bg-gradient-primary">
                            <tr>
                                <!-- <th>ลำดับ</th> -->
                                <th class="text-center">วัน/เดือน/ปี</th>
                                <th>คำนำหน้าชื่อ</th>
                                <th>ชื่อ</th>
                                <th>นามสกุล</th>
                                <th class="text-center">เข้างาน</th>
                                <th class="text-center">ออกงาน</th>
                                <th class="text-center">จัดการ</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $i=1; ?>
                              @foreach($his_work as $value)
                            <tr>
                                <!-- <td class="text-center">{{ $value->check_id }}</td> -->
                                <td class="text-center">{{ CmsHelper::DateThai($value->created_at) }}</td>
                                <td>{{ $value->name_th}}</td>
                                <td>{{ $value->fname}}</td>
                                <td>{{ $value->lname_th}}</td>
                                <td class="text-center">{{ $value->chk_in }}</td>
                                <td class="text-center">{{ $value->chk_out }}</td>
                                <td class="text-center">
                                    <form action="{{ Route('update') }}" method="post">
                                        @csrf
                                        @if(empty($value->chk_out) && (Carbon::parse($value->created_at)->toDateString()==$current_date))

                                          <input type="hidden" value="{{ $value->check_id }}" name="work_id">
                                          <button type="submit" class="btn btn-block btn-danger btn-sm rounded-pill text-md" name="chk_out" value="<?= date('Y-m-d H:i:s')?> ">
                                            <i class="fas fa-clock"></i> ลงเวลาออก</button>
                                        @else
                                          <button type="submit" class="btn btn-block btn-secondary btn-sm rounded-pill text-md" disabled>
                                          <i class="fas fa-clock"></i> ลงเวลาออก</button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            <?php $i++; ?>
                              @endforeach
                        </tbody>
                  </table>
                </div>
              </div>

              </div>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</section>



@endsection

@section('custom-js-script')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<!-- JS(Lay) -->
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script> <!-- DatatableTH  -->
<script src="{{ asset('Lay/js/DanamicAddrow.js') }}"></script><!-- Dinamic Addrow -->
@stop

@section('custom-js-code')

<!-- แสดงฟิวเตอร์ในตาราง -->
<script>
  $(document).ready(function() {

    $('#datepicker1').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true //Set เป็นปี พ.ศ.
    }); //กำหนดเป็นวันปัจุบัน

    $('#datepicker2').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true //Set เป็นปี พ.ศ.
    }); //กำหนดเป็นวันปัจุบัน

    var nowDateTime = new Date("<?= date("m/d/Y H:i:s") ?>");
    var d = nowDateTime.getTime();
    var mkHour, mkMinute, mkSecond;
    setInterval(function() {
      d = parseInt(d) + 1000;
      var nowDateTime = new Date(d);
      mkHour = new String(nowDateTime.getHours());
      if (mkHour.length == 1) {
        mkHour = "0" + mkHour;
      }
      mkMinute = new String(nowDateTime.getMinutes());
      if (mkMinute.length == 1) {
        mkMinute = "0" + mkMinute;
      }
      mkSecond = new String(nowDateTime.getSeconds());
      if (mkSecond.length == 1) {
        mkSecond = "0" + mkSecond;
      }
      var runDateTime = mkHour + ":" + mkMinute + ":" + mkSecond;
      $("#css_time_run").html(runDateTime);
    }, 1000);
  });
</script>
@stop
