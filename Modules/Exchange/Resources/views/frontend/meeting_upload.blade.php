@extends('exchange::layouts.master')


@section('custom-css')
<!-- DATA TABLE CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


<!-- DatePicker Style -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<!-- Fonts Style : Kanit -->
<!-- <link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Kanit', sans-serif;
    }
    h1 {
      font-family: 'Kanit', sans-serif;
    }
  </style> -->
<!-- END Fonts Style : Kanit -->

<style media="screen">
body {
  font-family: 'Sarabun', sans-serif;
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
            <li class="breadcrumb-item active"> Upload File การประชุม </li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

  <section class="content">
    <div class="container-fluid">

    <!-- START From Input COMMAND from IC --------------------------------------------------------->
      <div class="row">
        <div class="col-md-12">
          <div class="card card-warning">
            <div class="card-header">
              <h5><b> บันทึกข้อสั่งการ / Upload File </b></h5>
            </div>

          <!-- FORM INPUT -->
            <form method="POST" action="#" enctype="multipart/form-data">
            <!-- <form method="POST" action="{{-- route('command_ic.insert') --}}" enctype="multipart/form-data"> -->
              @csrf

              <div class="card-body">

                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="exampleInput1"> หัวข้อการประชุม </label>
                      <input type="text" class="form-control" name="title_meeting" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="exampleDatepicker1"> ปี/เดือน/วัน Upload file</label>
                      <input type="text" class="form-control" id="datepicker8" placeholder="กรุณาเลือก ปี/เดือน/วัน" name="pro_start_date" required>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="exampleInput1"> รายละเอียด </label>
                      <input type="text" class="form-control" name="pro_name_en">
                    </div>
                  </div>
                </div>

                <div class="row" >
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expInputFile"> อัพโหลดไฟล์ : <font color="red"> การประชุม </font></label>
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="files">
                          <label class="custom-file-label" for="expInputFile"> Upload Files </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="card-footer">
                <button type="submit" class="btn btn-success float-right" value="บันทึกข้อมูล">
                  <i class="fas fa-save"></i> &nbsp;บันทึกข้อมูล </button>
              </div>

            </form>

            <!-- Alert Notification -->
              @if(session()->has('success'))
                <div class="alert alert-success" id="success-alert">
                  <strong> {{ session()->get('success') }} </strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif

              @if (Session::has('failure'))
                <div class="alert alert-danger">
                  <strong> {{ Session::get('failure') }} </strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
              @endif
            <!-- END Alert Notification -->

          </div>
        </div>
      </div>
      <br>
    <!-- END From Input COMMAND from IC ---------------------------------------------------------->




    <!-- START TABLE from above COMMAND from IC -------------------------------------------------->
      <section class="content">
        <div class="card">
          <div class="card card-secondary shadow">
            <div class="card-header">
              <h5> Upload File ทั้งหมด </h5>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-hover" id="datatablex">
                <thead>
                    <tr>
                      <th> ลำดับ </th>
                      <th> ประเด็นข้อสั่งการ </th>
                      <th> ปี/เดือน/วัน </th>
                      <th> ผู้ตรวจสอบ </th>
                      <th class="text-right"> ACTIONS </th>
                    </tr>
                </thead>

                <tbody>
                  <tr>

                    <td> 1 </td>
                    <td> 1 </td>
                    <td> 1 </td>
                    <td> 1 </td>


                    <td class="project-actions text-right" href="#">
                      <!-- <a class="btn btn-warning btn-sm" title="EDIT" href=" {{-- route('research.edit', $value->id) --}} "> -->
                      <a class="btn btn-danger btn-sm" title="DOWNLOAD" href="#">
                        <i class="fas fa-arrow-alt-circle-down"></i>
                          DOWNLOAD
                      </a>
                    </td>
                  </tr>

                </tbody>

              </table>
            </div>
          </div>
        </div>
      </section>
    <!-- END TABLE from above COMMAND from IC -------------------------------------------------->

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
<script type="text/javascript" class="init">
  $(document).ready(function() {
    $('#datatablex').DataTable({
      dom: 'Bfrtip',
      buttons: [
        'excel', 'print'
      ]
    });
  });
</script>
<!-- END DATA TABLES -->

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
