<?php

use App\CmsHelper as CmsHelper;
?>

@extends('task::layouts.master')

@section('custom-css-script')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/summernote/summernote-bs4.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">

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

        @if(auth::user()->emp_level==2)
        <!-- <button type="button" class="btn bg-gradient-red btn-lg rounded-pill" onclick="window.location.replace(document.referrer);"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</button> -->
   
        <a href="{{ route('task_action') }}" class="btn bg-gradient-red btn-lg rounded-pill" onclick="window.location.replace(document.referrer);"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a>
        @else
        <button type="button" class="btn bg-gradient-red btn-lg rounded-pill" onclick="window.history.back();"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</button>
        <!-- <a href="{{ route('task_action') }}" class="btn bg-gradient-red btn-lg rounded-pill"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ</a> -->
        @endif

      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>


<!-- ------------------------------------------------------------------------------------ -->

@if(auth::user()->emp_level !='3')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header bg-gradient-blue h4">บันทึกผลการดำเนินงาน</div>
          <div class="card-header p-0 border-bottom-0">
            <div class="card-body">

              <div class="row">
                <form action="{{ route('task_action_insert') }}" method="post">
                  @csrf

                  <div class="col-12">
                    <dl class="row">
                      <dt class="col-sm-3">ชื่อประชุม</dt>
                      <dd class="col-sm-9">: &nbsp; {{ strip_tags($TaskAssign->meet_title) }}</dd>
                      <dt class="col-sm-3">หัวข้อประเด็นสั่งการ</dt>
                      <dd class="col-sm-9">: &nbsp; {{ strip_tags($TaskAssign->order_title) }}</dd>
                      <dt class="col-sm-3">มอบหมายกลุ่ม</dt>
                      <dd class="col-sm-9">: &nbsp; {{ $TaskAssign->roles_nameTH}} ({{ $TaskAssign->roles_nameEN}})</dd>
                      <dt class="col-sm-3">ผู้ปฎิบัติงาน</dt>
                      <dd class="col-sm-9">: &nbsp; {{ $TaskAssign->fname }} {{ $TaskAssign->lname}}</dd>
                    </dl>
                  </div>

                  <div class="col-sm-12 form-group">
                    <label for="detail">รายละเอียดการปฏิบัติงาน :</label>
                    <span class="text-danger text-bold">**จำเป็นต้องกรอก</span>
                    <textarea class="textarea" name="detail" required></textarea>
                  </div>

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
                <input type="hidden" name="assign_id" value="{{ $TaskAssign->assign_id }}">
                @if($TaskAssign->score=='0')
                <button type="submit" class="btn bg-gradient-primary btn-lg rounded-pill"><i class="far fa-save"></i> บันทึก</button>
                </form>
                @else
                <button type="button" class="btn bg-gradient-success btn-lg rounded-pill" disabled><i class="far fa-save"></i> ดำเนินการแล้วเสร็จ</button>
                @endif
              </div>
            </div><!-- ecn col-md-4 -->
          </div><!-- end row -->
        </div>
      </div>
      @endif

      <div class="col-md-12">
        <div class="card shadow">
          <div class="card-header bg-gradient-success h5">รายละเอียดผลการดำเนินงาน</div>
          <div class="card-header p-0 border-bottom-0">
            <div class="card-body">
              <p class="card-text">
              @if(empty($CheckDetail->assign_id))<span class="text-dange text-bold justify-content-center">ยังไม่มีผลการดำเนินงาน</span>
              @else
              @foreach($TaskJobDetail as $val)
              <div class="timeline">
                <div class="time-label">
                  <span class="text-lg bg-gradient-info rounded-pill shadow">{{ CmsHelper::DateThai($val->created_at) }}</span>
                </div>

                <div>
                  <i class="fas fa-user-edit bg-gradient-red"></i>
                  <div class="timeline-item callout callout-info shadow-lg">
                    <span class="time text-dark"><i class="fas fa-clock"></i> {{ CmsHelper::TimeThai($val->created_at) }}</span>
                    <h3 class="timeline-header text-blue text-bold bg-light">
                      {{ $TaskAssign->fname }} {{ $TaskAssign->lname}} :
                      {{ $TaskAssign->roles_nameTH}} ({{ $TaskAssign->roles_nameEN}})
                    </h3>

                    <div class="timeline-body">{!! $val->job_detail !!}</div>
                    <div class="timeline-footer bg-light border">

                      <div class="row">

                        <div class="col-md-6 col-sm-6">
                          <span class="text-bold">ผลการดำเนินงาน :</span>
                          @if($val->detail_status=="0") <span class="text-red text-bold"><i class="fas fa-times-circle"></i> อยู่ในระหว่างดำเนินงาน</span>
                          @else <span class="text-green text-bold"><i class="fas fa-check-circle"></i> ดำเนินการแล้วเสร็จ</span>
                          @endif
                        </div>

                        <div class="col-md-6 col-sm-6">
                          <div class="text-right">
                            @if(auth::user()->emp_level !='3')
                            <button class="btn btn-sm btn-danger rounded-pill del_detail" data-id="{{ $val->detail_id}}" data-assign="{{ $val->assign_id }}" data-status="{{ $val->detail_status }}" data-detail="{{ strip_tags($val->job_detail) }}">
                              <i class="fas fa-trash"></i> ลบข้อมูล
                            </button>
                            @endif
                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                </div>
                @endforeach
                <div>
                  <i class="fas fa-clock bg-gray"></i>
                </div>
                @endif

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
<!-- jquery-validation -->
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Toastr -->
<script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

@stop

@section('custom-js-code')


@if(session()->has('swl_add'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'บันทึกข้อมูลแล้ว',
    showConfirmButton: false,
    timer: 1000
  })
</script>
@endif

@if(session()->has('swl_del'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'ลบข้อมูลเรียบร้อยแล้ว',
    showConfirmButton: false,
    timer: 1000
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
  $(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });
</script>


<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(".del_detail").on("click", function() {
    var assign_id = $(this).attr('data-assign');
    var detail_id = $(this).attr('data-id');
    var detail = $(this).attr('data-detail');
    var status = $(this).attr('data-status');

    Swal.fire({
        title: 'ลบข้อมูลหรือไม่',
        text: 'รายละเอียด : ' + detail,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'ยกเลิก',
        confirmButtonText: 'ลบข้อมูล'
      })
      .then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: "{{ route('task_action_del') }}",
            type: "POST",
            data: {
              'detail_id': detail_id,
              'assign_id': assign_id,
              'status': status
            },
            success: function(data) {
              if (data.status != 'ok') {
                Swal.fire({
                  icon: 'success',
                  title: 'ลบเรียบร้อยแล้ว',
                  showConfirmButton: false,
                  timer: 1000
                }).then((result) => {
                  if (result) {
                    location.reload();
                  }
                })
              }
            }
          })
        }
      });
  });
</script>
@stop