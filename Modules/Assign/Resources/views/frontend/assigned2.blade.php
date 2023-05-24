@extends('assign::layouts.master')

<?php
  use App\CmsHelper as CmsHelper;
?>

@section('custom-css')
<!-- DATA TABLE CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

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
            <li class="breadcrumb-item active"> มอบหมายไปแล้ว (รายบุคคล) </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container-fluid">


    <!--- START TABLE from ORDER -------------------------------------------------->
        <section class="content">
          <div class="card">
            <div class="card card-success shadow">
              <div class="card-header">
                <h5> รายการมอบหมายไปแล้ว (รายบุคคล) </h5>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">


                <table class="table table-hover" id="DTTH">
                  <thead>
                      <tr>
                        <th> เลขงาน </th>
                        <th> หัวข้อประเด็นข้อสั่งการ </th>
                        <th> ผู้รับผิดชอบ </th>
                        <th> สถานะ </th>
                        <th> มุมมอง </th>
                        <th class="text-right"> Actions </th>
                      </tr>
                  </thead>

                  <tbody>
                    @foreach ($completed2 as $value)
                    <tr>
                      <td> {{ $value->order_id }} </td>
                      <td> {!! $value->title !!} </td>
                      <td> {{ $value->name_th }} {{ $value->lname_th }} </td>
                      <td><span class="badge bg-success"> Assigned </span></td>

                      <td> @if($value->read_status == "ยังไม่ได้อ่าน")
                          <span class="badge bg-danger"> {{ $value->read_status }} </span>
                        @else
                          <span class="badge bg-secondary"> {{ $value->read_status }} </span>
                        @endif
                      </td>

                      <td class="td-actions text-right text-nowrap">
                        <a href=" {{ route('assigned.edit2', ['id' => $value->assign_id, 'order_id' => $value->order_id]) }} ">
                          <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" title="รายละเอียด">
                            <i class="fas fa-info-circle"></i>
                            รายละเอียด
                          </button>
                        </a>
                      </td>

                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>

            <div class="card-footer">
                <button type="button" class="btn bg-gradient-red" onclick="window.history.back();">
                  <i class="fas fa-arrow-alt-circle-left"></i>
                  ย้อนกลับ
                </button>
            </div>

          </div>
        </section>
        <br>
    <!--- END TABLE from ORDER -------------------------------------------------->

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
    }, 2800);
  });
</script>
<!-- END ALERT บันทึกข้อมูลสำเร็จ  -->



<!-- DatePicker Style -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script>
    $('#datepicker8').datepicker({
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


<!-- DATA TABLES -->
<!-- <script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#datatablex').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'excel', 'print'
      ]
    });
  });
</script> -->
<!-- END DATA TABLES -->

@stop('custom-js-script')



@section('custom-js-code')
<!-- bs-custom-file-input -->
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<!-- DataTables SCRIPT -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<!-- DataTables THAI .js -->
<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script> <!-- DatatableTH  -->
@stop('custom-js-code')
