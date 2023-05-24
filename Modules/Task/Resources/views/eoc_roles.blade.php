@extends('task::layouts.master')

@section('custom-css-script')
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

@stop

@section('custom-css')
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('Lay/datepicker-thai/css/datepicker.css') }}">
<!-- Progress Step -->
<link rel="stylesheet" href="{{ asset('Lay/css/progress_step.css') }}">

@stop

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-8">
        <h3 class="text-bold">ชื่อประชุม : {!! $TaskMeeting->title !!} </h3>

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

              <div class=" table-responsive">
                <table class="table table-striped projects table-sm table-bordered table-hover" id="DTTH-ASC">
                  <thead class="text-nowrap bg-gradient-primary">
                    <tr>
                      <th class="text-center">ลำดับ</th>
                      <th>กลุ่มงานที่รับผิดชอบ</th>
                      <!-- <th class="text-center">ผลการดำเนินงาน</th> -->
                      <th></th>
                    </tr>
                  </thead>
                  <tbody class="text-nowrap">
                    <?php $i = 1; ?>
                    @foreach($TaskOrder as $val)
                    <tr>
                      <td class="text-center">{{ $i }}</td>
                      <td>{{ $val->roles_nameTH }} ({{ $val->roles_nameEN }})</td>
                      <td class="text-right">

                        <a href="{{ route('task_job',[
                          'order_id'=>$val->order_id,
                          'meet_id'=>$val->meet_id,
                          'roles_id'=>$val->roles_id
                        ]) }}" class="btn bg-gradient-pink btn-sm rounded-pill">รายละเอียด
                        </a>

                      </td>
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
<!-- JS(Lay) -->
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('Lay/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

<script src="{{ asset('Lay/js/DatatableTH.js') }}" type="text/javascript" charset="utf-8"></script> <!-- DatatableTH  -->
<script src="{{ asset('Lay/js/DanamicAddrow.js') }}"></script><!-- Dinamic Addrow -->
@stop

@section('custom-js-code')



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

    // multiple
    $('.select2').select2()

    $(function() {
      $('[data-toggle="tooltip"]').tooltip()
    })

  });
</script>


@stop