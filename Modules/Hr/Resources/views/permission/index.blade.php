@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
	<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop
@section('content')
	<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>จัดการสิทธิ์</h1>
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
							<h3 class="card-title"><a class="btn btn-success" href="{{ route('permission.create') }}"> สร้างสิทธิ์</a></h3>
							<div class="card-tools">
								<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                					<i class="fas fa-minus"></i>
                				</button>
                				<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
                					<i class="fas fa-times"></i>
                				</button>
							</div>
						</div>
						@if ($message = Session::get('success'))
						    <div class="alert alert-success">
						        <p>{{ $message }}</p>
						    </div>
						@endif
						<div class="card-body">
							<table class="table table-bordered table-sm table-hover table-striped " id="tbpermission">
								<thead class="text-nowrap bg-gradient-blue">
									<tr>
										<th>ลำดับ</th>
										<th>ชื่อสิทธิ์</th>
										<th width="280px">Action</th>
									</tr>
								</thead>
								<tbody class="text-nowrap">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($permissions as $key => $permission)
										<tr>
											<td>{{ $i }}</td>
											<td>{{ $permission->name }}</td>
											<td>
												{{-- @can('role-edit') --}}
													<a class="btn btn-primary" href="{{ route('permission.edit',$permission->id) }}">แก้ไขสิทธิ์</a>
												{{-- @endcan --}}
												{{-- @can('role-delete') --}}
													{!! Form::open(['method' => 'DELETE','route' => ['permission.destroy', $permission->id],'style'=>'display:inline']) !!}
													{!! Form::submit('ลบสิทธิ์', ['class' => 'btn btn-danger']) !!}
													{!! Form::close() !!}
												{{-- @endcan --}}
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
@stop
@section('custom-js-code')
	<script>
	    $('#tbpermission').DataTable({
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
	</script>
@stop
