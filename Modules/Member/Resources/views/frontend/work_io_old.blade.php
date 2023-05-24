
@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<!-- daterange picker -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/daterangepicker/daterangepicker.css') }}">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<!-- Tempusdominus Bbootstrap 4 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<!-- Bootstrap4 Duallistbox -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">
@stop

@section('custom-css')
<style type="text/css">
  fieldset {
    border: 1px groove #058 !important;
    padding: 0 1.0em 1.0em 1.0em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
    width: auto;
  }
  legend {
    width: inherit;
    padding: 0 5px;
    border-bottom: none;
  }
  .select2-container--default .select2-pink .select2-selection--multiple .select2-selection__choice,
  .select2-pink .select2-container--default .select2-selection--multiple .select2-selection__choice {
    min-width: 100%;
  }
</style>
@stop
<!----------------------------------------------------------------------------------------->
@section('content')
  <!-- ALERT -->
@if(session()->has('Success'))
  <div class="alert alert-success alert-with-icon alert-dismissible fade show" data-notify="container">
    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
      <i class="nc-icon nc-simple-remove"></i>
    </button>
    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
    <span data-notify="message">{{ session()->get('Success')}}</span>
  </div>
@elseif(session()->has('msg_del'))
  <div class="alert alert-danger alert-with-icon alert-dismissible fade show" data-notify="container">
    <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
      <i class="nc-icon nc-simple-remove"></i>
    </button>
    <span data-notify="icon" class="nc-icon nc-bell-55"></span>
    <span data-notify="message">{{ session()->get('msg_del')}}</span>
  </div>
@endif
<!----------------------------------------------------------------------------------------->


<?php
date_default_timezone_set('Asia/Bangkok');
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ลงเวลาปฏิบัติงาน</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-outline-tabs">

  <div class="card-header bg-info">
    <h3 class="card-title">
      <i class="ion ion-clipboard mr-1"></i>ลงเวลา เข้า-ออก</h3>
  </div><!-- /.card-header -->
  <div class="card-body">

<div class="row">
    <div class="col-sm-6 p-2">
      <?php
      $CheckTime = date('H:i:s');
      $DateNow = date('Y-m-d');

      // echo $CheckOut;
      // echo $DateNow;
      ?>
        <!-- <label>เวลาเข้างาน :</label> -->
        <form action="{{ Route('work_insert') }}" method="post">
          @csrf
          @if(empty($his_work->created_at))
            <input type="hidden" name="users_id" value="{{ Auth::user()->id }}">
            <button type="submit" class="btn btn-block btn-success btn-lg rounded-pill text-xl" name="chk_in" value="<?=$CheckTime?> ">
            <i class="fas fa-clock"></i> Check in</button>
          @else
            <button type="submit" class="btn btn-block btn-success btn-lg rounded-pill text-xl">
            <i class="fas fa-clock"></i> Check in</button>
          @endif

        </form>
    </div>

    <div class="col-sm-6 p-2">
        <!-- <label>เวลาออกงาน :</label> -->
        <form action="{{ Route('update') }}" method="post">
          @csrf
          @if(isset($his_work2->updated_at))
            <!-- <input type="hidden" name="id" value=""> -->
            <button type="submit" class="btn btn-block btn-danger btn-lg rounded-pill text-xl" name="chk_out" value="<?=$CheckTime?> ">
            <i class="fas fa-clock"></i> Check out</button>
          @else
            <button type="submit" class="btn btn-block btn-danger btn-lg rounded-pill text-xl">
            <i class="fas fa-clock"></i> Check out</button>
          @endif

        </form>
    </div>
</div>
<!-- ./ end row -->

  </div>
  <!-- /.card-body -->

            </div>
          </div>
        </div>
      </div>
</section>


<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ตารางบันทึกเวลา</h1>

      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card card-primary card-outline card-outline-tabs">

          <div class="card-body">
            <div class="tab-content" id="custom-tabs-four-tabContent">

              <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                <div class=" table-responsive">
                  <table class="table table-striped table-sm table-bordered table-hover">
                    <thead class="text-nowrap bg-gradient-primary">
                      <tr>
                            <!-- <th>ลำดับ</th> -->
                            <th>วัน/เดือน/ปี</th>
                            <th>คำนำหน้าชื่อ</th>
                            <th>ชื่อ</th>
                            <th>นามสกุล</th>
                            <th>เข้างาน</th>
                            <th>ออกงาน</th>
                      </tr>
                    </thead>

                    <tbody>
                      <?php $i=1; ?>
                      @foreach($his_work as $value)
                      <tr>
                            <!-- <td class="text-center">{{ $i }}</td> -->
                            <td>{{ $value->created_at }}</td>
                            <td>{{ $value->name_th}}</td>
                            <td>{{ $value->fname}}</td>
                            <td>{{ $value->lname_th}}</td>
                            <td>{{ $value->chk_in }}</td>
                            <td>{{ $value->chk_out }}</td>
                      </tr>
                      <?php $i++; ?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>


            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 5555555555555555555555555555555555555555555555555555555555555 -->


@endsection

@section('custom-js-script')
<!-- Select2 -->
<script src="{{ asset('bower_components/admin-lte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('bower_components/admin-lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- bootstrap color picker -->
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('bower_components/admin-lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ asset('bower_components/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>


<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
@stop

@section('custom-js-code')
<script>
  $(document).ready(function() {
    $('input').addClass('form-control');
    $('textarea').addClass('form-control');
    $('select').addClass('form-control');
  });
</script>


<script>
  $(function() {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": true,
    });
  });
</script>


<script type="text/javascript">
  $("#addRow").click(function() {
    var html = '';
    html += '<div id="inputFormRow">';
    html += '<div class="input-group mb-3">';
    html += '<input type="text" name="task_title[]" class="form-control m-input" placeholder="ชื่องานย่อย" autocomplete="off">';
    html += '<select class="form-control">';
    html += '<option>นายวรวิทย์ พยุงเกียรติบวร</option>';
    html += '<option>นายนันทพล พุ่มไสว</option>';
    html += '<option>นางสาวจันทร์เพ็ญ เอกมอญ</option>';
    html += '<option>นายชาญวิทย์ อมรสุรินทวงศ์</option>';
    html += '<option>นายศุภเสกย์ ทิพยาวงษ์</option>';
    html += '<option>นางสาวรุ้งลาวัลย์ ตรงกะพงศ์</option>';
    html += '<option>ว่าที่ ร.ต. สถาปัตย์ เด่นดวง</option>';
    html += '<option>นางสาวศุภาพิชญ์ แคหอม</option>';
    html += '<option>นายธนดน พัฒนะโภไคย</option>';
    html += '<option>นายประพันธ์ ชูชะรา</option>';
    html += '<option>นายสันทัด กงแก้ว</option>';
    html += '<option>นายสุทธา วัติรางกูล</option>';
    html += '<option>นายเสด็จ เบ้าทุมมา</option>';
    html += '<option>นายเอกชาติ ทองเปลี่ยน</option>';
    html += '<option>นายพุทธพงศ์ พุทธนาวงศ์</option>';
    html += '<option>นางสาวระพีพรรณ เสมอใจ</option>';
    html += '<option>ประจักร์ โสภา</option>';
    html += '<option>วรพงษ์ บวงสวง</option>';
    html += '<option>สิริวัฒ แสงวรรณลอย</option>';
    html += '</select>';
    html += '<div class="input-group-append">';
    html += '<button id="removeRow" type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>';
    html += '</div>';
    html += '</div>';

    $('#newRow').append(html);
  });


  // remove row
  $(document).on('click', '#removeRow', function() {
    $(this).closest('#inputFormRow').remove();
  });
</script>

<script>
  $(document).ready(function() {

    $('.datepicker1').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true //Set เป็นปี พ.ศ.
    }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน

    $('.datepicker2').datepicker({
      format: 'yyyy-mm-dd',
      todayBtn: true,
      language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
      thaiyear: true //Set เป็นปี พ.ศ.
    }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน


  });
</script>

<!-- Page script -->
<script>
  $(function() {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', {
      'placeholder': 'dd/mm/yyyy'
    })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', {
      'placeholder': 'mm/dd/yyyy'
    })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
      format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker({
        ranges: {
          'Today': [moment(), moment()],
          'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days': [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month': [moment().startOf('month'), moment().endOf('month')],
          'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate: moment()
      },
      function(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function() {
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
@stop
