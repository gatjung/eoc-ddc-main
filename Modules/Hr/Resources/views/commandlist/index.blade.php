@extends('hr::layouts.master')
@section('custom-css-script')
<!-- datepicker -->
<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop
@section('custom-css')
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>ระบบจัดการเลขคำสั่ง</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
<div class="container-fluid">

    <div class="row">
      	<div class="col-12 col-sm-12">
        	<div class="card">
          		<div class="card-body">

            		<form class="form-group" action="{{ route('commandlist.upload_file') }}" method="post" enctype="multipart/form-data">
	              			@csrf

						<div class="form-group row">
	                		<label class="col-sm-2 col-form-label">ชื่อคำสั่ง</label>
	                		<div class="col-sm-10">
	                  			<input type="text" autocomplete="off" maxlength="150" class="form-control" name="comm_num" placeholder="ระบุชื่อคำสั่ง" />
	                		</div>
	              		</div>

	              		<div class="form-group row">
	                		<label class="col-sm-2 col-form-label">วันที่ออกเลขคำสั่ง</label>
	                		<div class="col-sm-10 input-group date" id="datepicker">
                                <input class=" form-control input-medium" name="comm_date" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" id="comm_date">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
	              		</div>

	              		<div class="form-group row">
	                		<label class="col-sm-2 col-form-label">ส่วนกลาง / ส่วนภูมิภาค</label>
	                		<div class="col-sm-10">
	                  			<select class="form-control custom-select" name="organ">
                                    <option value="" selected disabled>กรุณาเลือก</option>
                                	<option value="ส่วนกลาง">ส่วนกลาง</option>
                                	<option value="ส่วนภูมิภาค">ส่วนภูมิภาค</option>
                                </select>
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
	                  			<button type="submit" class="btn btn-success"><i class="fas fa-cloud-upload-alt"></i> เพิ่มข้อมูลคำสั่ง</button>
	                		</div>
	              		</div>
            		</form>

          		</div>
        	</div>
    	</div>
    </div>

    <div class="row">
      	<div class="col-12 col-sm-12">
        	<div class="card">
          		<div class="card-body">

          			<table id="command_list" class="table table-striped table-bordered">
		                <thead>
			                <tr>
				                <th>ชื่อคำสั่ง</th>
				                <th>ชื่อไฟล์</th>
				                <th> ส่วนกลาง / ส่วนภูมิภาค</th>
				                <th>วันที่เลขคำสั่ง</th>
				                <th>จัดการคำสั่ง</th>
			                </tr>
		                </thead>

                		<tbody>

	                @php $i=1; @endphp
					@foreach ($data as $key)
		                <tr>
		                    <td>{{ $key->comm_num }}</td>
		                    <td><a href="{{ route('commandlist.ViewFile',['file_name' => $key->file_name, 'id' => $key->id]) }}" target="_blank">{{ $key->file_ori_name }}</a></td>
		                    <td>{{ $key->organ }}</td>
		                    <td>{{ $key->comm_date }}</td>
		                    <td class="text-nowrap" style="text-align: center">
		                    	@if($key->file_name)
		                        <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
			                      <a href="{{ route('commandlist.DownloadFile',['file_name' => $key->file_name, 'id' => $key->id]) }}" type="button" class="my_link btn btn-success my-1"><i class="fas fa-download"></i></a>
			                    </span>
			                    @else @endif

			                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ลบคำสั่ง">
			                    <form action="{{  route('commandlist.DeleteFile') }}" method="post">
			                    @csrf
			                    <button class="delete-confirm my_link btn btn-danger my-1" data-tbdel="rowId{{ $i }}" data-id="{{ $key->id }}" data-file_name="{{ $key->file_name }}" data-comm_num="{{ $key->comm_num }}" type="button"><i class="fas fa-trash-alt"></i></button>
			                    <input type="hidden" name="id" value="{{ $key->id }}">
			                    </form>
			                    </span>
		                    </td>
		                </tr>
					@php $i++; @endphp
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
<!-- datepicker -->
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
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
<!-- Cilpboard -->
<script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/1.4.0/clipboard.min.js"></script>
@stop
@section('custom-js-code')
<!-- page script -->
<script>
  $(function () {

    new Clipboard('#share-button');


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

    $('[data-toggle="tooltip"]').tooltip()
    $('#command_list').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "order": [],
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



    $('.delete-confirm').click(function(event) {
      var form =  $(this).closest("form");
      var id = $(this).data("id");
      var file_name = $(this).data("file_name");
      var comm_num = $(this).data("comm_num");
      var rowId = $(this).data("tbdel");

      Swal.fire({
          title: 'ยืนยันการลบคำสั่ง'+'\n'+comm_num+' ?',
          text: "เมื่อลบแล้วข้อมูลจะหายไปไม่สามารถกู้คืนได้",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          cancelButtonText: 'ยกเลิก',
          confirmButtonText: 'ใช่, ต้องการลบ'
      })
      .then((result) => {
                if (result.isConfirmed) {
                	toastr.success('ลบไฟล์สำเร็จ')
                    form.submit();
                } else {
                  toastr.error('ยกเลิกการทำรายการ');
                }
            });
          });
  });

    $("#comm_num").focusout(function(){
		var comm_num = $("#comm_num").val();
		if (comm_num!="") {
		    document.getElementById("comm_date").required = true;
		} else {
		    document.getElementById("comm_date").required = false;
		}

	});

   $("#datepicker").change(function(){
		var comm_date = $("#comm_date").val();
	    // alert(comm_date);
	    if (comm_date!="") {
	        document.getElementById("comm_num").required = true;
	    } else {
	        document.getElementById("comm_num").required = false;
	    }
	    
	});
</script>
@stop