@extends('hr::layouts.master')
@section('custom-css-script')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
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
					<h1>จัดการหลักสูตร</h1>
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
							<h3 class="card-title"><a class="btn btn-success" href="{{ route('course.create') }}"> สร้างหลักสูตร</a></h3>
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
							<table id="tb_course" class="table table-bordered table-hover">
								<thead class="text-nowrap">
									<tr>
			                          	<th class="text-center">ลำดับ</th>
			                          	<th class="text-center">ชื่อหลักสูตร</th>
			                          	<th class="text-center">Action</th>
			                        </tr>
								</thead>
								<tbody>
									@php
										$i=1;
									@endphp
									@foreach($data_course as $value_course)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $value_course->course }}</td>
											<td class="text-center">
												<form style="display: inline;" method="post" action="{{ route('course.edit') }}">
													@csrf
													<input type="hidden" name="course_id" value="{{ $value_course->id }}">
													<button class="btn btn-primary">แก้ไขหลักสูตร</button>
												</form>
												<form style="display: inline;" method="post" action="{{ route('course.destroy') }}">
													@csrf
													<input type="hidden" name="course_id" value="{{ $value_course->id }}">
													<button class="btn btn-danger">ลบหลักสูตร</button>
												</form>
											</td>
											@php
												$i++;
											@endphp
										</tr>
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
	<script src="{{ asset('bower_components/select2/dist/js/select2.full.js') }}"></script>

	<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
@stop
@section('custom-js-code')
	<script type="text/javascript">
		$('#tb_course').DataTable({
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