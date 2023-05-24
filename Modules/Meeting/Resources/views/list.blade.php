<?php
use App\CmsHelper as cms;
?>
@extends('meeting::layouts.master')
@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@stop
@section('custom-css')
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>รายการคำสั่ง</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <ul class="nav nav-tabs bg-white" id="custom-content-above-tab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="custom-content-above-home-tab" 
      data-toggle="pill" href="#custom-content-above-home" role="tab" 
      aria-controls="custom-content-above-home" aria-selected="true">ข้อสั่งการ</a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" id="custom-content-above-profile-tab" 
      data-toggle="pill" href="#custom-content-above-profile" role="tab" 
      aria-controls="custom-content-above-profile" aria-selected="false">ข้อสั่งการจากการประชุม</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="custom-content-above-messages-tab" 
      data-toggle="pill" href="#custom-content-above-messages" role="tab" 
      aria-controls="custom-content-above-messages" aria-selected="false">เหตุการณือื่นๆ ที่ผู้บริหารสนใจ</a>
    </li> -->
    </ul>

  <div class="text-right bg-white">
    <a href="{{route('meeting.order')}}">
      <button type="button" class="btn bg-gradient-danger btn-sm">ADD</button>
    </a>
  </div>

  <div class="tab-content bg-white p-1" id="custom-content-above-tabContent">
    <div class="tab-pane fade show active" id="custom-content-above-home" 
        role="tabpanel" aria-labelledby="custom-content-above-home-tab">

        <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>ครั้งที่</th>
                    <th>ชื่อการประชุม</th>
                    <th>วันที่</th>
                    <th>จัดการ</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($data as $key => $val)
                  <tr id="row_{{$val->id}}">
                    <td>{{$val->at_num ."/". $val->at_year}}</td>
                    <td>
                      <a href="{{route('meeting.show',['id'=>$val->id])}}" target="_blank"
                      id="name_{{$val->id}}">{!!$val->title!!}</a>
                    </td>
                    <td>{{cms::DateThai($val->at_date)}}</td>
                    <td>
                      <a href="{{route('meeting.edit',['id'=>$val->id])}}"
                      class='btn btn-warning btn-sm mr-2' title='แก้ไข'>
                      <i class='fa fa-cog'></i>
                      </a>
                      <a href='#' 
                      class='btn btn-danger btn-sm' title='ลบ' 
                      data-toggle='modal' data-target='#delModal' onclick="fn_pedel('{{$val->id}}')">
                          <i class='fas fa-trash'></i>
                      </a>
                    </td>
                  </tr>
                  @endforeach
                  
                  </tbody>
                </table>
              </div>

    </div>
    <!-- <div class="tab-pane fade" id="custom-content-above-profile" 
        role="tabpanel" aria-labelledby="custom-content-above-profile-tab">
    </div>
    <div class="tab-pane fade" id="custom-content-above-messages" 
        role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
    </div> -->
  </div>

  </div>
</section>


<!--[ยืนยันการลบ]-->
<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">ยืนยันการลบ</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body" id="del_name"></div>
        <input name="curr_id" id="curr_id" type="hidden" value="0" />
        <div class="modal-footer">
        	<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          	<button class="btn btn-danger" type="button" data-dismiss="modal"
            	onclick="deleteRow()">ลบ</button>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('custom-js-script')
<!-- Bootstrap 4 -->
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
@stop
@section('custom-js-code')
<script>
  $(function () {
    $('#example2').DataTable({
      "responsive": true,
      "autoWidth": false,
      "ordering": false
    });
  });

  function fn_pedel(id) {
    $('#del_name').html( $("#name_"+id).html() );
    $('#curr_id').val(id);
  }

  function deleteRow()  
  {   
    // var rowid = "row_" + $('#curr_id').val();
    // var row = document.getElementById(rowid);
    // row.parentNode.removeChild(row);
    var id = $('#curr_id').val();
    window.location.href = "{{url('meeting/destroy')}}" + "/" + id;
  }
</script>
@stop
