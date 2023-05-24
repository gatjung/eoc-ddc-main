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
					<h1>จัดการตำแหน่ง</h1>
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
							<h3 class="card-title">สร้างชื่อตำแหน่ง</h3>
							
						</div>
						<div class="card-body">
							<form method="post" action="{{ route('position.store') }}">
								@csrf
								<div class="col-xs-12 col-sm-12 col-md-12">
									<div class="form-group">
							            <strong>ตำแหน่ง (ภาษาไทย) : <span id="error_position_th" style="color: red;"></span></strong>
							            <input type="text" name="position_name" class="form-control" id="position_name" required>
							        </div>

								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 text-center">
							        <button type="submit" class="btn btn-primary">สร้างชื่อตำแหน่ง</button>
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
		$("#pos_name").focusout(function(){
            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/A-Za-z0-9]/gi;

            if ($(this).val().match(SpacialCharacter)) {
                $(this).css("border-color", "#FF0000");
                $("#pos_name").val("");
                $("#error_position_th").text("* กรอกได้เฉพาะภาษาไทย");
                $("#error_position_th").focus();
            } else {
                $(this).css("border-color", "#2eb82e");
                $("#error_prefix_th").text("");
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