@extends('feedback::layouts.master')
@section('custom-css-script')
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@endsection
@section('content')

    <!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12">
        <h1>ข้อเสนอแนะ</h1>
      </div>

    </div>
  </div><!-- /.container-fluid -->
</section>
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
            <form method="post" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>ระบุข้อเสนอแนะ:</label><i style="color: red"><b > *</b>จำเป็นต้องกรอก</i>
                                <textarea class="form-control" rows="5" placeholder="ข้อเสนอแนะ" name="description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="InputFile">อัพโหลดไฟล์แนบ:</label>
                                <div class="input-group">
                                  <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="InputFile" name="file_name">
                                    <label class="custom-file-label" for="InputFile">แนบไฟล์</label>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">ส่ง</button>
                </div>
            </form>
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
@endsection