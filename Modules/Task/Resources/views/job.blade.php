<?php
use App\CmsHelper as CmsHelper;
?>

@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

@stop

@section('custom-css')
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('Lay/datepicker-thai/css/datepicker.css') }}">
<!-- Progress Step -->
<link rel="stylesheet" href="{{ asset('Lay/css/progress_step.css') }}">
@stop

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h3 class="text-bold">ชื่อประชุม : {!! $TaskMeeting->title !!} </h3>

      </div>
      <div class="col-sm-4 text-right">

        <button type="button" class="btn bg-gradient-red btn-lg rounded-pill" onclick="window.history.back();"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ </button>
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

              <div class="table-responsive">
                <table class="table table-striped table-sm table-bordered table-hover" id="DTTH-ASC">
                  <thead class="text-nowrap bg-gradient-primary">
                    <tr>
                      <th class="text-center">ลำดับ</th>
                      <th>ประเด็นสั่งการ</th>
                      <th>ผู้ปฏิบัติงาน</th>
                      <th>รับทราบ</th>
                      <th class="text-center">สถานะ</th>
                      <th></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    @foreach($TaskAssign as $val)
                    <tr>
                      <td class="text-nowrap text-center align-text-top">{{ $i }}</td>
                      <td class="align-text-top">{{ strip_tags($val->order_title) }}</td>
                      <td class="text-nowrap align-text-top">{{ $val->fname}} {{ $val->lname }} </td>
                      <td class="text-nowrap">
                        @if($val->read_status=='1')<p class="badge badge-pill badge-success text-sm">ทราบ</p> 
                        @else<p class="badge badge-pill badge-danger text-sm">ไม่ทราบ</p>
                        @endif 
                      </td>
                      <td class="text-center">
                        @if($val->score=='1') <p class="badge badge-pill badge-success text-sm">Success</p> 
                        @else <p class="badge badge-pill badge-warning text-sm">Pending</p>
                        @endif
                      </td>
                      <td class="text-nowrap  text-right align-text-top">
                        <a href="{{ route('task_action_detail',[
                            'assign_id'=>$val->assign_id,
                            'order_id'=>$val->order_id
                            ]) }}" class="btn bg-gradient-pink btn-sm rounded-pill">รายละเอียด
                        </a>
                      </td>
                    </tr>
                    <?php $i++; ?>
                    @endforeach

                  </tbody>
                </table>
              </div>
            </div><!-- /.card -->
          </div>
        </div>
      </div>
    </div>
</section>

<!-- ------------------------------------------------------------------------------------ -->

@endsection

@section('custom-js-script')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script>

@if(session()->has('swl_add'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'บันทึกข้อมูลแล้ว',
    showConfirmButton: false,
    timer: 1500
  })
</script>
@endif
@stop


@section('custom-js-code')
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })

  function DelID() {
    Swal.fire({
      icon: 'error',
      title: 'คุณต้องการลบข้อมูลนี้หรือไม่ ?',
      showDenyButton: true,
      showCancelButton: true,
      confirmButtonText: 'ต้องการ',
      cancelButtonText: 'ไม่ต้องการ',
      denyButtonText: 'ยกเลิก',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire('Saved!', '', 'success')
      } else if (result.isDenied) {
        Swal.fire('Changes are not saved', '', 'info')
      }
    })
  }
</script>

@stop