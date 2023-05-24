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
            <li class="breadcrumb-item active"> รายการประเด็นข้อสั่งการ </li>
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
                <h5><b> รายการประเด็นข้อสั่งการ </b></h5>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover" id="DTTH">
                  <thead>
                      <tr>
                        <th> เลขงาน </th>
                        <th> หัวข้อประเด็นข้อสั่งการ </th>
                        <th> วันที่มอบหมาย </th>
                        <th class="text-right"> Actions </th>
                      </tr>
                  </thead>

                  <tbody>
                    @foreach ($completed as $value)
                    <tr>
                      <td> {{ $value->order_id }} </td>
                      <td> {!! $value->title !!} </td>
                      <td> {{ CmsHelper::DateThai($value->start_at) }} </td>

                      <td class="td-actions text-right text-nowrap">
                        <a href=" {{ route('page2.completed', ['order_id' => $value->order_id]) }} ">
                          <button type="button" class="btn btn-warning btn-md" data-toggle="tooltip" title="มอบหมายไปแล้ว">
                            <i class="fas fa-user-check"></i>
                          </button>
                        </a>

                        @if(Auth::user()->organization_type == '2')
                        <a href=" {{ route('assign.edit.odpc', ['id' => $value->id , 'roles_id' => $value->roles_id]) }} " target="_blank">
                          <!-- <a href="#"> -->
                            <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="เพิ่มผู้ปฏิบัติงาน">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </a>
                        @endif

                        @if(Auth::user()->organization_type == '1')
                         <a href=" {{ route('assign.edit.central', ['id' => $value->id , 'roles_id' => $value->roles_id]) }} " target="_blank">
                          <!-- <a href="#"> -->
                            <button type="button" class="btn btn-danger btn-md" data-toggle="tooltip" title="เพิ่มผู้ปฏิบัติงาน">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </a>
                        @endif

                      </td>

                    </tr>
                    @endforeach
                  </tbody>

                </table>
              </div>
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
