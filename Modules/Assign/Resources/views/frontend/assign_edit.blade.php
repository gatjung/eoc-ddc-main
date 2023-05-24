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
            <form action="{{ route('assign.insert.odpc') }}" method="POST">
              @csrf
              <div class="card-body">

                <div class="row">
                  <div class="col-md-10">
                    <div class="form-group">
                      <label for="exampleInput1"> หัวข้อการประชุม </label>
                      <input type="text" class="form-control" name="meet_title" value="{{ $data3->meet_title }}" readonly>
                      <!-- hidden = id -->
                      <input type="hidden" class="form-control" name="id" value="{{ $data3->id }}">
                      <!-- hidden = start_at -->
                      <input type="hidden" class="form-control" name="start_at" value="{{ $data3->start_at }}">
                      <!-- hidden = end_at -->
                      <input type="hidden" class="form-control" name="end_at" value="{{ $data3->end_at }}">
                      <!-- hidden = issue_title -->
                      <input type="hidden" class="form-control" name="issue_title" value="{{ $data3->issue_title }}">
                      <!-- hidden status value = '1' -->
                      <input type="hidden" class="form-control" name="status" value="1">
                      <!-- hidden roles_id for Notify_message -->
                      <input type="hidden" class="form-control" name="roles_id" value="{{ $data3->roles_id }}">
                    </div>
                  </div>

                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="exampleInput1"> วันที่มอบหมายงาน </label>
                      <input type="text" class="form-control" value="{{ CmsHelper::DateThai($data3->start_at) }}" readonly>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> ประเด็นข้อสั่งการ </label>
                        <div class="border p-3" style="background-color: #e9ecef;opacity: 1; font-size: 1rem;">
                            {!! $data3->issue_title !!}
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
                      <label for="exampleInput1"> ผู้มอบหมายงาน </label>
                      <input type="text" class="form-control" name="leader" value="{{ $leader->name_th }} {{ $leader->lname_th }}" readonly>
                    </div>
                  </div>

                  <!-- <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleSelect1"> มอบหมายผู้ปฏิบัติงาน </label>
                        <select class="form-control" name="users_id" required>
                          <option value="" disabled="true" selected="true" > -- กรุณาเลือก -- </option>
                          @foreach ($members as $value)
                            <option value="{{ $value->id }}"> {{ $value->name_th }} &nbsp; {{ $value->lname_th }} </option>
                            @endforeach
                        </select>
                    </div>
                  </div> -->

                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="exampleSelect1"> มอบหมายผู้ปฏิบัติงาน </label>
                        <div class="select2-danger">
                          <select class="select2 select2-danger form-control" id="select_assigned_worker" name="users_id[]"
                                  data-dropdown-css-class="select2-danger" multiple="multiple" required>
                          </select>
                        </div>
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
        todayHighlight: true,
        'setDate': '0'
    }).datepicker("setDate", "0");
</script>

<!-- <script>
    $('#datepick2').datepicker({
        uiLibrary: 'bootstrap4',
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
      }).datepicker("setDate", "0");
</script> -->

<!-- END DatePicker Style -->



<!-- FILE INPUT -->
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
<!-- END FILE INPUT -->



<!-- Select2 -->
<script src="{{ asset('bower_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/i18n/th.js') }}"></script>
<script>
    //Initialize Select2 Elements
    $("#select_assigned_worker").select2({

      language: "th",
      placeholder: "-- เลือกชื่อ มอบหมายผู้ปฏิบัติงาน --",
      minimumResultsForSearch: 5,
      ajax: {
       url: "{{ route('Assign.ajax.get.user.odpc') }}?assign_u_out={!! $out_u_id_conv !!}",
       type: "GET",
       dataType: 'json',
       delay: 250,
       data: function (params) {
        return {
          searchTerm: params.term // search term
        };
       },
       processResults: function (response) {
         return {
            results: response
         };
       },
       cache: true
      }
    });
</script>
<!-- END Select2 -->

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
