@extends('commandic::layouts.master')

@section('custom-css-script')
    <!-- datepicker -->
    <link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@endsection

@section('custom-css')
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>คำสั่งการ</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">เพิ่มคำสั่งการ</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('commandIC.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">ชื่อคำสั่งการ</label>
                                    <div class="col-sm-10">
                                        <input type="text" autocomplete="off" maxlength="150" class="form-control" name="command_name" placeholder="ระบุชื่อคำสั่งการ" required/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">วันที่ออกคำสั่งการ</label>
                                    <div class="col-sm-10 input-group date" id="datepicker">
                                        <input class=" form-control input-medium" name="command_date" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" id="comm_date" required>
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">กรุณาเลือกไฟล์</label>
                                    <div class="col-sm-10">
                                        <input type="file" id="customFile" name="customFile" class="mr-2" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-success"><i class="fas fa-cloud-upload-alt"></i> เพิ่มข้อมูลคำสั่งการ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('custom-js-script')
    <!-- datepicker -->
    <script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
    <script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
@endsection

@section('custom-js-code')
    <script>
        $("#datepicker").change(function(){
            var comm_date = $("#comm_date").val();
            // alert(comm_date);
            if (comm_date!="") {
                document.getElementById("comm_num").required = true;
            } else {
                document.getElementById("comm_num").required = false;
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
