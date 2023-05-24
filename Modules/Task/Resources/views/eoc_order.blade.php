<?php

use App\CmsHelper as CmsHelper;
?>
@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@section('custom-css')
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h3 class="text-bold">ชื่อประชุม : {!! $TaskMeeting->title !!}</h3>

      </div>
      <div class="col-sm-4 text-right">
        <!-- <a href="" class="btn btn-success">เพิ่มงาน</a> -->
        <button type="button" class="btn bg-gradient-danger btn-lg rounded-pill" onclick="window.history.back();"><i class="fas fa-arrow-circle-left"></i> ย้อนกลับ </button>
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

              <!-- <div class="tab-content" id="custom-tabs-four-tabContent"> -->
                <!-- <div class="tab-pane fade show active" id="custom-tabs-four-profile" role="tabpanel" aria-labelledby="custom-tabs-four-profile-tab"> -->

                  <div class=" table-responsive">
                    <table class="table table-striped projects table-sm table-bordered table-hover" id="DTTH-ASC">
                      <thead class="bg-gradient-primary">
                        <tr class="text-nowrap">
                          <th>ลำดับ</th>
                          <th>ประเด็นข้อสั่งการ</th>
                          <!-- <th>กลุ่มงานที่รับผิดชอบ</th> -->
                          <th>สถานะ</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php $i = 1; @endphp
                        @foreach($TaskOrder as $val)
                        <tr>
                          <td class="text-center align-text-top">{{ $i }}</td>
                          <td>{{ strip_tags($val->order_title) }}</td>
                          <!-- <td>{{-- $val->roles_nameTH --}} ({{-- $val->roles_nameEN --}})</td> -->
                          <td>
                            @if($val->score==0) <span class="badge badge-warning">Pending</span>
                            @else <span class="badge badge-success">Success</span>
                            @endif
                          </td>

                          <td class="text-nowrap text-right">
                            <a href="{{ route('task_eoc_roles',[
                              'order_id'=>$val->order_id,
                              'meet_id'=>$val->meet_id
                            ]) }}" class="btn bg-gradient-pink btn-sm rounded-pill">รายละเอียด
                            </a>
                          </td>
                        </tr>
                        @php $i++ @endphp
                        @endforeach
                      </tbody>
                    </table>
                  </div>

                </div>

              <!-- </div> -->
            <!-- </div>/.card -->

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
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script> <!-- DatatableTH  -->
@stop

@section('custom-js-code')
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
@stop