@extends('commandic::layouts.master')
<?php
    use App\CmsHelper as CmsHelper;
?>
@section('custom-css-script')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@endsection

@section('custom-css')
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>คำสั่งการ</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                @can('create-command-ic')
                                    <a class="btn btn-success" href="{{ route('commandIC.create') }}"> เพิ่มคำสั่งการ</a>
                                @endcan
                            </h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                					<i class="fas fa-minus"></i>
                				</button>
                				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                					<i class="fas fa-times"></i>
                				</button>
							</div>
                        </div>
                        <div class="card-body">
                            <table id="command_list" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ลำดับ</th>
                                        <th>ชื่อคำสั่งการ</th>
                                        <th>วันที่ลงคำสั่งการ</th>
                                        <th>จัดการคำสั่งการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data_command_list_ic as $value_command_list_ic)
                                        <tr>
                                            <td>
                                                {{ $i }}
                                            </td>
                                            <td>
                                                {{ $value_command_list_ic->command_name }}
                                            </td>
                                            <td>
                                                {{ CmsHelper::DateThai($value_command_list_ic->command_date) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('commandIC.viewFileCommandListIC', [$value_command_list_ic->id, $value_command_list_ic->file_name]) }}" type="button" title="View"  class="my_link btn btn-success my-1" target="_blank">
                                                    View <i class="fas fa-eye"></i> {{ $value_command_list_ic->count_view }}
                                                </a>
                                                <a href="{{ route('commandIC.downloadFileCommandListIC', [$value_command_list_ic->id, $value_command_list_ic->file_name]) }}" type="button" title="Download"  class="my_link btn btn-primary my-1">
                                                    Download <i class="fas fa-download"></i> {{ $value_command_list_ic->count_download }}
                                                </a>
                                                @can('delete-command-ic')
                                                    <a href="{{ route('commandIC.destroyCommandListIC', [$value_command_list_ic->id, $value_command_list_ic->file_name]) }}" type="button" title="Delete"  class="my_link btn btn-danger my-1"><i class="fas fa-trash-alt"></i></a>
                                                @endcan
                                            </td>
                                        </tr>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js-script')
    <!-- DataTables -->
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
@endsection

@section('custom-js-code')
    <script>
        $('#command_list').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
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

        // SweetAlert2, Toastr
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
@endsection
