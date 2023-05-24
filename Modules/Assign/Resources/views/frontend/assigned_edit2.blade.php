@extends('assign::layouts.master')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('custom-css')
<!-- DatePicker Style -->
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<style media="screen">
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
            <li class="breadcrumb-item active"> มอบหมายไปแล้ว </li>
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
          <div class="card card-success shadow">
            <div class="card-header">
              <h5> รายละเอียดการมอบหมายงาน </h5>
            </div>
          </div>

              <div class="card-body">
                <!-- hidden id -->
                <input type="hidden" class="form-control" value="{{ $datax->id }}">



                <!-- <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="exampleInput1"> หัวข้อการประชุม </label>
                      <input type="text" class="form-control" value="{{-- $datax->meet_title --}}" disabled>
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInput1"> วันที่ประชุม </label>
                      <input type="text" class="form-control" value="{{-- CmsHelper::DateThai($datax->start_at) --}}" disabled>
                    </div>
                  </div>
                </div> -->

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ประเด็นข้อสั่งการ </label>
                        <div class="border p-3" style="background-color: #e9ecef;opacity: 1; font-size: 1rem;">
                            {!! $datax->title !!}
                        </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> รายละเอียดงาน </label>
                        <div class="border p-3" style="background-color: #e9ecef;opacity: 1; font-size: 1rem;">
                            {!! $datax->details !!}
                        </div>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> มอบหมายผู้ปฏิบัติงาน </label>
                      <input type="text" class="form-control" value="{{ $datax->name_th }} {{ $datax->lname_th }}" disabled>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> วันที่มอบหมายงาน </label>
                      <input type="text" class="form-control" value="{{ CmsHelper::DateThai($datax->start_at) }}" readonly>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleInput1"> กำหนดส่งงาน </label>
                      <input type="text" class="form-control" value=" {{ CmsHelper::DateThai($datax->end_at) }}" readonly>
                    </div>
                  </div>
                </div>

              </div>
        <br>

              <div class="card-footer">
                  <button type="button" class="btn bg-gradient-red" onclick="window.history.back();">
                    <i class="fas fa-arrow-alt-circle-left"></i>
                    ย้อนกลับ
                  </button>
              </div>

    </div>
</section>
@stop('content')



@section('custom-js-script')

<!-- START ALERT บันทึกข้อมูลสำเร็จ  -->
<script type="text/javascript">
  $(document).ready(function () {
    window.setTimeout(function() {
      $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
          $(this).remove();
      });
    }, 3000);
  });
</script>
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->



<!-- DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#datepick1').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<script>
    $('#datepick2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });
</script>

<!-- END DatePicker Style -->



<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<!-- END FILE INPUT -->

@stop('custom-js-script')



@section('custom-js-code')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- DataTables SCRIPT -->
<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
@stop('custom-js-code')
