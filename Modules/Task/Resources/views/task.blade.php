<?php

use App\CmsHelper as CmsHelper;

$name_arr = CmsHelper::Get_UserID(8);
?>
@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@section('custom-css')
<!-- Progress Step -->
<link rel="stylesheet" href="{{ asset('Lay/css/progress_step.css') }}">
@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="text-bold">ติดตามงาน </h1>
        <!-- {{ $name_arr['username'] }} {{ $name_arr['user_id'] }} -->
      </div>
      <div class="col-sm-6 text-right">
        <!-- <a href="" class="btn btn-success">เพิ่มงาน</a> -->
        <!-- <button type="button" class="btn bg-gradient-primary btn-lg" data-toggle="modal" data-target="#modal-lg"><i class="fas fa-plus"></i> เพิ่มงาน</button> -->
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

@include('task::task_dash')

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline shadow">
          <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
              <!-- <li class="nav-item">
                <a class="nav-link active" id="tabs-job-tab" data-toggle="pill" href="#tabs-job" role="tab" aria-controls="tabs-job" aria-selected="false">งานทั้งหมด</a>
              </li> -->
            </ul>
          </div>
          <div class="card-body">
          
                <div class=" table-responsive">
                  <table class="table table-striped table-sm table-bordered table-hover" id="DTTH">
                    <thead class="text-nowrap bg-gradient-primary">
                      <tr>
                        <th class="text-center">ลำดับ</th>
                        <th>หัวข้อการประชุม</th>
                        <th>วันที่เริ่ม</th>
                        <th>วันที่สิ้นสุด</th>
                        <th>ความก้าวหน้า</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1; ?>
                      @foreach($TaskOrder as $val)
                      <tr>
                        <td class="text-nowrap text-center">{{ $val->meet_id }}</td>
                        <td class="align-text-top">{!! strip_tags($val->meet_title) !!}</td>
                        <td class="text-nowrap text-right text-bold text-green">{{ CmsHelper::DateThai($val->start_at) }}</td>
                        <td class="text-nowrap text-right text-bold text-red">{{ CmsHelper::DateThai($val->end_at) }}</td>
                        <td class="text-nowrap text-center">
                          <?php
                          if ($val->percent <= 49) {$color = "bg-danger";} 
                          elseif ($val->percent <= 99) {$color = "bg-primary";} 
                          elseif ($val->percent == 100) {$color = "bg-success";}
                          ?>
                          <div class="progress" style="height: 30px">
                            <div class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated" role="progressbar" aria-volumenow="{{ number_format($val->percent) }}" aria-volumemin="0" aria-volumemax="100" style="width: {{ number_format($val->percent) }}%">
                              @if($val->percent=='100') เสร็จสิ้น
                              @else {{ number_format($val->percent) }}%
                              @endif
                            </div>
                          </div>
                        </td>
                        <td class="text-nowrap text-right">

                          <!-- <a href="{{ route('meeting.show',['id'=>$val->meet_id]) }}" 
                          class="btn bg-gradient-info btn-sm rounded-pill" target="_blank">คำสั่งการ</a> -->

                          <a href="{{ route('task_job',[
                            'meet_id'=>$val->meet_id,
                            'order_id'=>$val->order_id,
                            'roles_id'=>$val->roles_id
                          ]) }}" class="btn bg-gradient-pink btn-sm rounded-pill">รายละเอียด</a></td>
                      </tr>
                      <?php $i++; ?>
                      @endforeach
                    </tbody>
                  </table>
                </div>

              </div>
          <!-- /.card -->
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
<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script>
@stop

@section('custom-js-code')
<script>
  $(function() {
    $('[data-toggle="tooltip"]').tooltip()
  })
</script>
@stop