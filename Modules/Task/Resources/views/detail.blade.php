<?php

use App\CmsHelper as CmsHelper;

session_start();
session_destroy();

?>

@extends('task::layouts.master')

@section('custom-css-script')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

@stop

@section('custom-css')
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('Lay/datepicker-thai/css/datepicker.css') }}">
@stop

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h1 class="text-bold">ผลการดำเนินงาน</h1>

      </div>
      <div class="col-sm-4 text-right">

        <button type="button" class="btn bg-gradient-red btn-lg rounded-pill" onclick="window.history.back();"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ </button>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<!-- ------------------------------------------------------------------------------------ -->

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header bg-gradient-blue h4">บันทึกผลการดำเนินงาน</div>
          <div class="card-header p-0 border-bottom-0">
            <div class="card-body">

              <div class="row">
                <form action="{{ route('task_detail_insert') }}" method="post">
                  @csrf

                  <div class="col-12">
                    <dl class="row">
                      <dt class="col-sm-3">ชื่อประชุม</dt>
                      <dd class="col-sm-9">: &nbsp; {!! $TaskMeeting->title !!}</dd>
                      <dt class="col-sm-3">หัวข้อประเด็นสั่งการ</dt>
                      <dd class="col-sm-9">: &nbsp; {!! $TaskOrder->title !!} </dd>
                      <dt class="col-sm-3">มอบหมายกลุ่ม</dt>
                      <dd class="col-sm-9">: &nbsp; {{ $TaskRoles->name }} ({{ $TaskRoles->name_eng }})</dd>
                      <dt class="col-sm-3">ชื่อกิจกรรม</dt>
                      <dd class="col-sm-9">: &nbsp; {{ $TaskJob->job_title }}</dd>
                      <dt class="col-sm-3">ผู้ปฎิบัติงาน</dt>
                      <dd class="col-sm-9">: &nbsp; {{ $Member->name_th }} {{ $Member->lname_th }}</dd>
                    </dl>
                  </div>

                  <div class="col-sm-12 form-group">
                    <label for="detail">รายละเอียดการปฏิบัติงาน :</label>
                    <textarea class="textarea" name="detail" required></textarea>
                  </div>

                  <!-- <div class="col-sm-6 form-group">
                    <label for="result">เอกสารแนบ :</label>
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="customFile">
                      <label class="custom-file-label" for="customFile">เลือกเอกสารแนบ</label>
                    </div>
                  </div> -->

                  <div class="col-sm-12 form-group">
                    <label for="result">ดำเนินการแล้วเสร็จ :</label>
                    <div class="form-group clearfix">
                      <div class="icheck-warning d-inline">
                        <input type="radio" id="radioPrimary1" name="status" value="0" checked>
                        <label for="radioPrimary1">อยู๋ในระหว่างดำเนินการ</label>
                      </div>
                      <div class="icheck-success d-inline">
                        <input type="radio" id="radioPrimary2" name="status" value="1">
                        <label for="radioPrimary2">ดำเนินการแล้วเสร็จ</label>
                      </div>
                    </div>
                  </div>

              </div>

              <div class="text-right">
                <input type="hidden" name="job_id" value="{{ $TaskJob->id }}">
                @if($TaskJob->job_status==0)
                <button type="submit" class="btn bg-gradient-primary btn-lg rounded-pill"><i class="far fa-save"></i> บันทึก</button>
                </form>
                @else
                <button type="button" class="btn bg-gradient-success btn-lg rounded-pill" disabled><i class="fas fa-check-circle"></i> ดำเนินการแล้วเสร็จ</button>
                @endif

              </div>

            </div><!-- ecn col-md-4 -->
          </div><!-- end row -->
        </div>
      </div>

      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header bg-gradient-success h5">รายละเอียดผลการดำเนินงาน</div>
          <div class="card-header p-0 border-bottom-0">
            <div class="card-body">
              <p class="card-text">

                @foreach($TaskJobShow as $val)
                <div class="timeline">
                  <div class="time-label">
                    <span class="text-lg btn rounded-pill shadow">{{ CmsHelper::DateThai($val->created_at) }}</span>
                  </div>

                  <div>
                    <i class="fas fa-user-edit bg-gradient-red"></i>
                    <div class="timeline-item callout callout-info shadow-lg">
                      <span class="time text-dark"><i class="fas fa-clock"></i> {{ CmsHelper::TimeThai($val->created_at) }}</span>
                      <h3 class="timeline-header text-bold bg-light border">
                        {{ $val->fname }} {{ $val->lname }} :
                        {{ $TaskRoles->name }} ({{ $TaskRoles->name_eng }})
                      </h3>

                      <div class="timeline-body">{!! $val->detail !!}</div>
                      <div class="timeline-footer bg-light border">

                        <div class="row">
                          <div class="col-md-6 col-sm-6">
                            <span class="text-bold">ผลการดำเนินงาน :</span>
                            @if($val->status=="0") <span class="text-red text-bold"><i class="fas fa-times-circle"></i> อยู่ในระหว่างดำเนินงาน</span>
                            @else <span class="text-green text-bold"><i class="fas fa-check-circle"></i> ดำเนินการแล้วเสร็จ</span>
                            @endif
                          </div>

                          <!-- <div class="col-md-4 col-sm-4">
                            <span class="text-bold">เอกสารแนบ :</span>
                            <a href=""><?= "<span class=\"badge badge-info\"><i class=\"fas fa-paperclip\"></i> " . date('Y-d-m-His') . ".pdf</span>"; ?></a>
                          </div> -->
                          <!-- </div> -->

                          <div class="col-md-6 col-sm-6">
                            <div class="text-right">
                              <form action="{{ route('task_del_detail') }}" method="post">
                                @csrf
                                <input name="_method" type="hidden" value="DELETE">
                                <input type="hidden" name="detail_id" value="{{ $val->detail_id }}">
                                <button class="btn btn-sm btn-danger rounded-pill" onclick="return confirm('คุณต้องการลบ ?');"><i class="fas fa-trash"></i> ลบข้อมูล</button>
                              </form>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>
                
              </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ------------------------------------------------------------------------------------ -->


<!-- ------------------------------------------------------------------------------------ -->
@endsection

@section('custom-js-script')
<!-- SweetAlert2 -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
@stop

@section('custom-js-code')




@if(session()->has('swl_add'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'บันทึกข้อมูลแล้ว',
    showConfirmButton: false,
    timer: 1500
  })
</script>

@elseif(session()->has('swl_del'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'ลบข้อมูลเรียบร้อยแล้ว',
    showConfirmButton: false,
    timer: 1500
  })
</script>
@endif

<!-- Summernote -->
<script src="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.min.js') }}"></script>

<script>
  $("input[data-bootstrap-switch]").each(function() {
    $(this).bootstrapSwitch('state', $(this).prop('checked'));
  });

  $(function() {
    // Summernote
    $('.textarea').summernote({
      placeholder: 'รายละเอียดการปฏิบัติงาน',
      height: 150,
      // width: auto,
      toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']]
      ]
    })
  })
</script>
<script>
  // Add the following code if you want the name of the file appear on select
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>
@stop