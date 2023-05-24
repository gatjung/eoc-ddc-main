@extends('assign::layouts.master')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('custom-css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.css') }}">

<!-- DatePicker Style -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<style>
  body {
    font-family: 'Sarabun', sans-serif;
  }
</style>

<style>
   button {
    display: inline-block;
    position: relative;
    color: #1D9AF2;
    background-color: #292D3E;
    border: 1px solid #1D9AF2;
    border-radius: 4px;
    padding: 0 15px;
    cursor: pointer;
    height: 38px;
    font-size: 14px;

  }
  button:active {
    box-shadow: 0 3px 0 #1D9AF2;
    top: 3px;
  }
</style>

@stop('custom-css')


@section('content')

<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active"> รอพิจารณา </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container">

    <!-- START EDIT -------------------------------------------------->
        <div class="card">
          <div class="card card-warning shadow">
            <div class="card-header">
              <h5><b> รายละเอียดคำสั่งการ </b></h5>
            </div>
          </div>

            <!-- <form role="form"> -->
            <form action="{{ route('assign.insert') }}" method="POST">
              @csrf
              <div class="card-body">

                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="exampleInput1"> หัวข้อการประชุม </label>
                      <input type="text" class="form-control" name="meet_title" value="{{ $me_myself->meet_title }}" readonly>
                      <!-- hidden = id -->
                      <input type="hidden" class="form-control" name="id" value="{{ $me_myself->id }}">
                      <!-- hidden = start_at -->
                      <input type="hidden" class="form-control" name="start_at" value="{{ $me_myself->start_at }}">
                      <!-- hidden = end_at -->
                      <input type="hidden" class="form-control" name="end_at" value="{{ $me_myself->end_at }}">
                      <!-- hidden = issue_title -->
                      <input type="hidden" class="form-control" name="issue_title" value="{{ $me_myself->issue_title }}">
                      <!-- hidden status value = '1' -->
                      <input type="hidden" class="form-control" name="status" value="1">
                      <!-- hidden roles_id for Notify_message -->
                      <input type="hidden" class="form-control" name="roles_id" value="{{ $me_myself->roles_id }}">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInput1"> วันที่มอบหมายงาน </label>
                      <input type="text" class="form-control" value="{{ CmsHelper::DateThai($me_myself->start_at) }}" readonly>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ประเด็นข้อสั่งการ </label>
                        <div class="border p-3" style="background-color: #e9ecef;opacity: 1; font-size: 1rem;">
                            {!! $me_myself->issue_title !!}
                        </div>
                    </div>
                  </div>
                </div>


              @if(Auth::user()->emp_level == '1')
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> รายละเอียดเพิ่มเติม (อื่นๆ) </label>
                      <textarea class="form-control" rows="3" name="details" placeholder="รายละเอียดเพิ่มเติม ..."></textarea>
                    </div>
                  </div>
                </div>
              @endif

                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> ท่านเป็นผู้ปฏิบัติงานเอง </label>
                      <input type="text" class="form-control" name="leader" value="{{ $leader->name_th }} {{ $leader->lname_th }}" readonly>
                      <!-- hidden VALUE = users_id -->
                      <input type="hidden" class="form-control" name="users_id[]" value="{{ $leader->id }}">
                    </div>
                  </div>

                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> กำหนดส่งงาน </label>
                      <input type="text" class="form-control" id="datepick1" placeholder="กรุณาเลือก ปี/เดือน/วัน"
                             name="assign_date" autocomplete="off">
                    </div>
                  </div> -->

                </div>
              </div>


              <div class="card-footer">
                <a class="btn btn-danger float-left" href="{{ route('page.assign') }}">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                    ย้อนกลับ
                </a>

                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล" style="height:5%;">
                  <i class="fas fa-save"></i>
                    &nbsp;บันทึกข้อมูล
                </button>
              </div>
              <br>
            </form>


          </div>
      <!-- END EDIT  -------------------------------------------------->

    </div>
</section>
@stop('content')



@section('custom-js-script')

<!-- DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#datepick1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        'setDate': '0'
    }).datepicker("setDate", "0");
</script>

@stop('custom-js-script')
