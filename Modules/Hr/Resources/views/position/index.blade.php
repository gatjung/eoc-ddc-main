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
					<h1>จัดการชื่อตำแหน่ง</h1>
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
							<h3 class="card-title">
								 



												<!-- เริ่มปุ่มแก้ไข Button trigger modal -->
													<input type="hidden" name="position_id" >
													<button type="button" class="btn btn-primary laycreate"
														data-id=""
														data-name=""
														data-toggle="modal" data-target="#laycreate">
														สร้างชื่อตำแหน่ง
													</button>
												<!-- จบปุ่มแก้ไข Button trigger modal -->


							</h3>
						</div>

						<div class="card-body">
							<table id="tb_position" class="table-sm table table-bordered table-hover">

								<thead class="text-nowrap">
									<tr>
			                          	<th class="text-center text-nowarp">ลำดับ</th>
			                          	<th class="text-center">ชื่อตำแหน่ง (ภาษาไทย)</th>
										  <th class="text-center">Action</th>
			                        </tr>
								</thead>

								<tbody>
									@php
										$i=1;
									@endphp
									@foreach($data_position as $value_position)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $value_position->position_name }}</td>
											<td class="text-center">
												<!-- เริ่มปุ่มแก้ไข Button trigger modal -->
												<input type="hidden" name="position_id" value="{{ $value_position->position_id }}">
													<button type="button" class="btn btn-primary layedit"
														data-id="{{ $value_position->position_id }}"
														data-name="{{ $value_position->position_name }}"
														data-toggle="modal" data-target="#layedit">
														แก้ไข
													</button>
												<!-- จบปุ่มแก้ไข Button trigger modal -->

												<!-- เริ่มปุ่มลบ Button trigger modal -->
												<input type="hidden" name="position_id" value="{{ $value_position->position_id }}">
													<button type="button" class="btn btn-danger laydelete"
														data-id="{{ $value_position->position_id }}"
														data-name="{{ $value_position->position_name }}"
														data-toggle="modal" data-target="#laydelete">
														ลบ
													</button>
												<!-- จบปุ่มลบ Button trigger modal -->

												{{-- Modal Create Start --}}
												<div class="modal fade" id="exampleModalcreate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
													<div class="modal-content">
															<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">สร้างชื่อตำแหน่ง</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>
																<form method="post" action="{{  route('position.store')  }}">
																	@csrf
																	<div class="modal-body">
																		<div class="form-group">
																		<strong>ชื่อตำแหน่ง (ภาษาไทย)<span id="error_position_th" style="color: red;"></span></strong>
																			<input type="text" name="position_name" id="laycreatename" class="form-control" required>
																			<input type="hidden" name="position_id" id="laycreateid">
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
																		<button type="submit" class="btn btn-primary">บันทึก</button>
																	</div>
																</form>
													</div>
													</div>
												</div>

												{{-- Modal Create End--}}


												{{-- Modal Edit Start --}}
												<div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
													<div class="modal-content">
															<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">แก้ไขชื่อตำแหน่ง</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>
																<form method="post" action="{{  route('position.update')  }}">
																	@csrf
																	<div class="modal-body">
																		<div class="form-group">
																			<input type="text" name="position_name" id="layeditname" class="form-control" required>
																			<input type="hidden" name="position_id" id="layeditid">
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
																		<button type="submit" class="btn btn-primary">บันทึก</button>
																	</div>
																</form>
													</div>
													</div>
												</div>
												{{-- Modal Edit End--}}



												{{-- Modal Delete Start --}}
												<div class="modal fade" id="exampleModaldelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
													<div class="modal-dialog" role="document">
													<div class="modal-content">
															<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">ลบตำแหน่ง</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
															</div>
																<form method="post" action="{{  route('position.destroy')  }}">
																	@csrf
																	<div class="modal-body">
																		<div class="form-group">
																			<input type="text" name="position_name" id="laydeletename" class="form-control" disabled="disabled">
																			<input type="hidden" name="position_id" id="laydeleteid">
																		</div>
																	</div>
																	<div class="modal-footer">
																		<button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
																		<button type="submit" class="btn btn-primary">ลบ</button>
																	</div>
																</form>
													</div>
													</div>
												</div>
												{{-- Modal Delete End--}}
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

		$("#laycreatename").focusout(function(){
            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/A-Za-z0-9]/gi;

            if ($(this).val().match(SpacialCharacter)) {
                $(this).css("border-color", "#FF0000");
                $("#laycreatename").val("");
                $("#error_position_th").text("* กรอกได้เฉพาะภาษาไทย");
                $("#error_position_th").focus();
            } else {
                $(this).css("border-color", "#2eb82e");
                $("#error_position_th").text("");
            }
        });


		$('#tb_position').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": true,
			"responsive": true,
			"pageLength": 100,
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
		            "sFirst": "เริ่มต้น",
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

	<script>

				$('.laycreate').click(function() {
					var laycreateid = $(this).attr('data-id');
					var laycreatename = $(this).attr('data-name');

					$('#laycreateid').val(laycreateid);
					$('#laycreatename').val(laycreatename);

                    $('#exampleModalcreate').modal('show');
                });


	                $('.layedit').click(function() {
					var layeditid = $(this).attr('data-id');
					var layeditname = $(this).attr('data-name');

					$('#layeditid').val(layeditid);
					$('#layeditname').val(layeditname);

                    $('#exampleModaledit').modal('show');
                });
			

                $('.laydelete').click(function() {
					var laydeleteid = $(this).attr('data-id');
					var laydeletename = $(this).attr('data-name');

					$('#laydeleteid').val(laydeleteid);
					$('#laydeletename').val(laydeletename);

                    $('#exampleModaldelete').modal('show');
                });

	</script>

@stop