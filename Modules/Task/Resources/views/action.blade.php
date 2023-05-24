<?php

use App\CmsHelper as Cms;

?>

@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- Datepicker Thai -->
<!-- <link rel="stylesheet" href="{{ asset('Lay/datepicker-thai/css/datepicker.css') }}"> -->
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
                <h1 class="text-bold">รายละเอียดงาน</h1>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- ------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->
<!-- ------------------------------------------------------------------------------------ -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary card-outline shadow">
                    <div class="card-header p-0 border-bottom-0">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped  table-sm table-bordered table-hover" id="DTTH-ASC">
                                    <thead class="text-nowrap bg-gradient-primary">
                                        <tr>
                                            <th class="text-center">ลำดับ</th>
                                            <th>หัวข้อคำสั่งการ</th>
                                            <th>วันที่เริ่ม</th>
                                            <th>วันที่สิ้นสุด</th>
                                            <th>ผู้รับผิดชอบ</th>
                                            <th>การอ่าน</th>
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
                                            <td class="text-nowrap text-bold text-right text-green">{{ Cms::DateThai($val->start_at) }}</td>
                                            <td class="text-nowrap text-bold text-right text-red">{{ Cms::DateThai($val->end_at) }}</td>
                                            <td class="text-nowrap align-text-top">{{ $val->fname }} {{ $val->lname }}</td>
                                            <td>
                                                @if($val->read_status=='0' || empty($val->read_status))<p class="badge badge-pill badge-danger text-sm">ยังไม่อ่าน</p>
                                                @else <p class="badge badge-pill badge-success text-sm">อ่านแล้ว</p>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if($val->score=='0')<p class="badge badge-pill badge-warning text-sm">Pending</p>
                                                @else<p class="badge badge-pill badge-success text-sm">Success</p> @endif
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

<!-- JS(Lay) -->
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script> <!-- DatatableTH  -->
<script src="{{ asset('Lay/js/DanamicAddrow.js') }}"></script><!-- Dinamic Addrow -->



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

@if(session()->has('swl_del'))
<script>
  Swal.fire({
    icon: 'success',
    title: 'ลบข้อมูลเรียบร้อยแล้ว',
    showConfirmButton: false,
    timer: 1500
  })
</script>
@endif



@stop

@section('custom-js-code')

<script>
    $(document).ready(function() {
        $('.select2').select2()
    });

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