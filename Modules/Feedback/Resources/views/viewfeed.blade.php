@extends('feedback::layouts.master')
@section('custom-css-script')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@endsection
@section('content')

    <!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>แสดงข้อเสนอแนะ</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">          
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                      <div class="col-lg-12">
                            <div class="card">

                                <table id="viewfeed_table" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                          <th>ชื่อ</th>
                                          <th>คำแนะนำ</th>
                                          <th>ไฟล์แนบ</th>
                                          <th>Created At</th>
                                          <th>Upload At</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data_feedcom as $value)
                                        <tr>
                                          <td>{{ $value->name }}</td>
                                          <td>{{ $value->description }}</td>
                                          <td>{{ $value->file_name }}</td>
                                          <td>{{ $value->created_at }}</td>
                                          <td>{{ $value->updated_at }}</td>
                                        </tr>
                                        @endforeach
                                        </tbody>
                                  </table>

                            </div>
                      </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                </div>
        </div>
    </div>
</section>
    <!-- /.content -->
@endsection

@section('custom-js-script')
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('js/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
              bsCustomFileInput.init();
            });
        </script>
@endsection
@section('custom-js-code')

    <!-- DataTables -->
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <script>
        $(function (){
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": false,
                "positionClass": "toast-top-right",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            @if ($message = Session::get('success'))
                toastr.success('{!! $message !!}')
            @endif
            @if ($message = Session::get('warning'))
                toastr.warning('{!! $message !!}')
            @endif
            @if ($message = Session::get('error'))
                toastr.error('{!! $message !!}')
            @endif
        });
    </script>


    <script>
        $(document).ready( function () {

            $('#viewfeed_table').DataTable({
              "paging": true,
              "lengthChange": true,
              "searching": true,
              "ordering": true,
              "info": true,
              "autoWidth": false,
              "responsive": true,
              "language": {
                      "sProcessing": "กำลังดำเนินการ...",
                      "sLengthMenu": "แสดง_MENU_ แถว",
                      "sZeroRecords": "ไม่พบข้อมูล",
                      "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                      "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                      "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                      "sInfoPostFix": "",
                      "sSearch": "ค้นหา:",
                      "sUrl": "",
                      "oPaginate": {
                                    "sFirst": "เิริ่มต้น",
                                    "sPrevious": "ก่อนหน้า",
                                    "sNext": "ถัดไป",
                                    "sLast": "สุดท้าย"
                      }
             }
            });
        } );
    </script>
@endsection