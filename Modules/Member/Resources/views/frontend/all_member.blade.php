@extends('member::layouts.master')


@section('css-custom-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap5.min.css">
<!-- csrf-token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection


@section('custom-css')
@stop


@section('content')
<!-- Content Header (Page header) -->


<!-- Content admin -->
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">ALL Member Management</h4><br>
                  <p class="card-category">จัดการสมาชิก</p>
                </div>
                <div class="card-body">

                  <div class="table-responsive">
                  
                    <table id="datatables" class="table table-striped table-bordered" style="width:100%">

                      <thead class="text-primary text-center">
                        <th> ชื่อผู้ใช้งาน </th>
                        <th> คำนำหน้า </th>
                        <th> ชื่อ </th>
                        <th> นามสกุล </th>
                        <th> เบอร์ติดต่อ </th>
                        <th> อีเมลล์ </th>
                        <th> ไลน์ </th>
                        <th> สถานะ </th>
                        <th> ชื่อผู้อนุมัติ </th>
                        <th class="text-center"> Action </th>
                      </thead>

                      <tbody>
                        @foreach($KEYforPass as $val)
                        <tr>

                          <td> {{  $val->username  }} </td>
                          <td> {{  $val->prefix_th  }} </td>
                          <td> {{  $val->name_th  }} </td>
                          <td> {{  $val->lname_th  }} </td>
                          <td> {{  $val->phone  }} </td>
                          <td> {{  $val->email  }} </td>
                          <td> {{  $val->lineid  }} </td>
                          <td> {{  $val->approveStatus  }} </td>
                          <td> {{  $val->approveBy  }} </td>                                                    

                          <td class="td-actions text-right">


                            <form method="post" action="{{ route('all.member') }}" style="display: inline;">
                              @csrf
                              <input type="hidden" name="id" value="{{ $val->id }}">
                              <button type="submit" title="EDIT" class="btn btn-success ">
                                <i class="material-icons"></i>แก้ไข
                              </button>
                            </form>

                            
                            <button type="button" class="btn btn-danger" onclick="AskDelete({{$val->id}})">
                                <i class="material-icons"></i>ลบ
                            </button>


                          </td>

                        </tr>
                        @endforeach
                      </tbody>

                    </table>
                  <!-- </div> -->

                </div>
                </div>
        </div>
      </div>
    </div>
  </div>
</div>
      <!-- END Content EventBase ฟอร์มหน้าแจ้งเหตุการณ์ -->
@endsection



@section('custom-js-script')
<script>
  $(document).ready(function() {
    $('#datatables').DataTable();
} );
@stop



@section('custom-js-code')
@stop