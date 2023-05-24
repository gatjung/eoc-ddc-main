@extends('hr::layouts.master')
@section('custom-css-script')
	<!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
@stop
@section('custom-css')
@stop
@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>จัดการระดับ</h1>
				</div>
			</div>
		</div><!-- /.container-fluid -->
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">สร้างระดับ</h3>
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
							<form method="post" action="{{ route('joblevel.store') }}">
								@csrf
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-group">
							            <strong>ชื่อระดับ : <span id="error_job_level_name" style="color: red;"></span></strong>
							            <input type="text" name="job_level_name" class="form-control" id="job_level_name" required>
							        </div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 text-center">
							        <button type="submit" class="btn btn-primary">สร้างระดับ</button>
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
	<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
@stop
@section('custom-js-code')
	<script type="text/javascript">
        $("#job_level_name").focusout(function(){
            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/A-Za-z0-9]/gi;

            if ($(this).val().match(SpacialCharacter)) {
                $(this).css("border-color", "#FF0000");
                $("#job_level_name").val("");
                $("#error_job_level_name").text("* กรอกได้เฉพาะภาษาไทย");
                $("#error_job_level_name").focus();
            } else {
                $(this).css("border-color", "#2eb82e");
                $("#error_job_level_name").text("");
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
@stop