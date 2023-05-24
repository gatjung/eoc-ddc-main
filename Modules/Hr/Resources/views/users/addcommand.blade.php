@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
	<!-- datepicker -->
	<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">
	<!-- Select2.org-->
    <link rel="stylesheet" href="{{ asset('bower_components/select2_custom/dist/css/select2.min.css') }}">
@stop
@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>เพิ่มคำสั่งแต่งตั้ง</h1>
				</div>
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<form method="post" action="{{ route('users.insert_command') }}">
					@csrf
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header bg-gradient-green">
									<h3 class="card-title">คำสั่งการปฏิบัติงาน EOC</h3>
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
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<div class="form-group">
												<div id="Command">
													<label for="comm_num">เลขคำสั่งแต่งตั้งที่ 1</label>
					                                    {{-- <input type="text" class="form-control" name="comm_num[]" id="comm_num" autocomplete="off"> --}}

					                                    <select class="command-single form-control" name="comm_num[]">
					                                    	<option selected disabled>กรุณาเลือกคำสั่งแต่งตั้ง</option>
															@foreach($command_list as $value_list)
												            	<option value="{{ $value_list->comm_num }}">
												            	{{ $value_list->comm_num }}
												            	</option>
												        	@endforeach
														</select>

					                                    <label for="comm_date" style="padding-top: 10px;">วันที่เริ่มปฏิบัติงานตามคำสั่งที่ 1</label>
					                                    <div class="input-group date" id="datepicker2">
					                                        <input class=" form-control input-medium" name="comm_date[]" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" id="comm_date">
					                                        <div class="input-group-append">
					                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
					                                        </div>
					                                    </div>

					                                <input type="button" id="add_comm_num()_1" class="btn btn-success" style="margin-top: 10px;" onclick="addComm_num()" value="เพิ่มเลขคำสั่ง" />

					                                <hr/>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12">
		                                    <button  class="btn btn-success btn-lg float-right" id="submit">
		                                    	เพิ่มคำสั่ง
		                                    </button>
		                                </div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</section>
	</section>
@endsection
@section('custom-js-script')
	<!-- datepicker -->
	<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
	<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
	<script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>

	<!-- Select2.org -->
    <script src="{{ asset('bower_components/select2_custom/dist/js/select2.min.js') }}"></script>
@stop
@section('custom-js-code')
	<script>
		$("#comm_num").focusout(function(){
            var comm_num = $("#comm_num").val();
            if (comm_num!="") {
                document.getElementById("comm_date").required = true;
            } else {
                document.getElementById("comm_date").required = false;
            }
            
        });

        $("#datepicker2").change(function(){
            var comm_date = $("#comm_date").val();
            // alert(comm_date);
            if (comm_date!="") {
                document.getElementById("comm_num").required = true;
            } else {
                document.getElementById("comm_num").required = false;
            }
            
        });

        var i = 1;

	    function addComm_num() {
	        i++;
	        var div = document.createElement('div');

	        div.innerHTML =
	                        '<label for="comm_num">เลขคำสั่งแต่งตั้งที่ '+ i +' </label>'+
	                        // '<input type="text" class="form-control" name="comm_num[]" autocomplete="off" required>'+

	                        '<select class="command-single form-control" name="comm_num[]">'+
					                                    	'<option selected disabled>กรุณาเลือกคำสั่งแต่งตั้ง</option>'+
															'@foreach($command_list as $value_list)'+
												            	'<option value="{{ $value_list->comm_num }}">'+
												            	'{{ $value_list->comm_num }}'+
												            	'</option>'+
												        	'@endforeach'+
														'</select>'+

	                        '<label for="comm_date" style="padding-top: 10px;">วันที่เริ่มปฏิบัติงานตามคำสั่งที่ '+ i +' </label>'+
	                        '<div class="input-group date" id="datepicker2">'+
	                            '<input class=" form-control input-medium" name="comm_date[]" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" required>'+
	                            '<div class="input-group-append">'+
	                                '<div class="input-group-text">'+
	                                    '<i class="fa fa-calendar"></i>'+
	                                '</div>'+
	                            '</div>'+
	                        '</div>'+

	                        '<input type="button" id="add_comm_num()_' + i + '" style="margin-top: 10px;" class="btn btn-success" onclick="addComm_num()" value="เพิ่มเลขคำสั่ง" />' + '&nbsp;&nbsp;&nbsp;&nbsp;' +
	                        '<input type="button" id="rem_kid()_' + i + '" style="margin-top: 10px;" class="btn btn-danger" onclick="remaddComm_num(this)" value="ลบเลขคำสั่ง" /><hr/>';
	                        

	        console.log(document.getElementById('Command').appendChild(div));
	    }

	    function remaddComm_num(div) {
	        // console.log(div);
	        // var list=document.getElementById("div2");
	        // list.parentNode.removeChild(list);
	        console.log(document.getElementById('Command').removeChild(div.parentNode));
	        i--;
	    }

	$(document).ready(function() {
		$('.command-single').select2();
	});
	</script>
@stop