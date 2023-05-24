<?php
	use App\CmsHelper as CmsHelper;

	$org_th_arr = CmsHelper::Get_Organization_TH();
	$pos_th_arr = CmsHelper::Get_Position_TH();
	$tal_lan_arr = CmsHelper::Get_Talent_language();
	$tal_dri_arr = CmsHelper::Get_Talent_Drive();
	$tal_cou_arr = CmsHelper::Get_Talent_Course();
	$roles_en_arr = CmsHelper::Get_Roles_EN();
	$roles_th_arr = CmsHelper::Get_Roles_TH2();
	$pre_th_arr = CmsHelper::Get_Prefix_TH();
	$pre_en_arr = CmsHelper::Get_Prefix_EN();
?>
@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
	<!-- datepicker -->
	<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">

	<!-- Select2 -->
	<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.css') }}">

	<!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">

    <!-- Select2.org-->
    <link rel="stylesheet" href="{{ asset('bower_components/select2_custom/dist/css/select2.min.css') }}">
@stop
@section('content')
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>ข้อมูลของฉัน</h1>
				</div>
			</div>
		</div>
		<section class="content">
			<div class="container-fluid">
				<form method="post" action="{{ route('users.update') }}">
					@csrf
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header bg-gradient-green">
									<h3 class="card-title">ข้อมูลส่วนตัว</h3>
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
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>คำนำหน้า (ไทย)</strong>
	                                            <select name="prefix_th" class="form-control custom-select" required>
	                                            	<option value="" disabled="">กรุณาเลือก</option>
											        @foreach($ref_prefix as $value)
											            <option value="{{ $value->id }}" {{ $value->name_th == $pre_th_arr[$users->prefix_th]  ? 'selected' : '' }}>
											            	{{ $value->name_th }}
											            </option>
											        @endforeach
											    </select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ชื่อ (ไทย) <span id="error_name_th" style="color: red;"></strong>
												<input type="text" value="{{ $users->name_th }}" name="name_th" id="name_th" class="form-control" required>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>นามสกุล (ไทย) <span id="error_lname_th" style="color: red;"></strong>
												<input type="text" value="{{ $users->lname_th }}" name="lname_th" id="lname_th" class="form-control" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>คำนำหน้า (อังกฤษ)</strong>
	                                            <select name="prefix_eng" class="form-control custom-select" required>
	                                            	<option value="" disabled="">กรุณาเลือก</option>
											        @foreach($ref_prefix as $value)
											            <option value="{{ $value->id }}" {{ $value->name_en == $pre_en_arr[$users->prefix_eng]  ? 'selected' : '' }}>
											            	{{ $value->name_en }}
											            </option>
											        @endforeach
											    </select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ชื่อ (อังกฤษ) <span id="error_name_eng" style="color: red;"></strong>
												<input type="text" value="{{ $users->name_eng }}" name="name_eng" id="name_eng" class="form-control" required>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>นามสกุล (อังกฤษ) <span id="error_lname_eng" style="color: red;"></span></strong>
												<input type="text" value="{{ $users->lname_eng }}" name="lname_eng" id="lname_eng" class="form-control" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>เลขบัตรประชาชน <span id="error_cid" style="color: red;"></span></strong>
												<input type="text" value="{{ $users->cid }}" name="cid" class="form-control" id="cid" pattern="[0-9]{13}" maxlength="13" required>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>วันเกิด</strong>
												<div class="input-group date" id="datepicker1">
	                                                <input class=" form-control input-medium" value="{{ $users->birthdate }}" name="birthdate" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" required >
	                                                <div class="input-group-append">
	                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
	                                                </div>
	                                            </div>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>เพศ</strong>
	                                            <select name="gender" class="form-control custom-select" required>
	                                            	<option value="" disabled="">
	                                            		กรุณาเลือก
	                                            	</option>
										            <option value="1" {{ $users->gender == 1 ? 'selected' : '' }}>
										            	ชาย
										            </option>
	                                                <option value="2" {{ $users->gender == 2 ? 'selected' : '' }}>
	                                                	หญิง
	                                                </option>
											    </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ส่วนงานในสังกัด</strong>
												<select class="form-control custom-select" id="organization_type" name="organization_type" required>
		                                            <option value="" disabled="">กรุณาเลือก</option>
		                                            @foreach($organization_type as $key_division_part => $value_division_part)
		                                                <option value="{{ $key_division_part }}" {{ $key_division_part == $users->organization_type ? 'selected' : '' }}>
		                                                	{{ $value_division_part }}
		                                                </option>
		                                            @endforeach
	                                			</select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>หน่วยงาน</strong>
	                                            <select id="organization" class="form-control select-organization" name="organization" data-live-search="true" disabled required>
	            						            <option value="" disabled="">------ กรุณาเลือก ------</option>
	            						        </select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>กล่องภารกิจ</strong>
												<select id="roles" class="form-control select-roles" name="roles" data-live-search="true" disabled required>
	            						            <option value="" disabled="">------ กรุณาเลือก ------</option>
	            						        </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ตำแหน่ง</strong>
												<select id="position" class="form-control custom-select"  name="position" data-live-search="true" required>
		                                            <option value="">กรุณาเลือก</option>
		                                            @foreach($posit_ref as $value_posit_ref)
		                                                <option value="{{ $value_posit_ref->position_id }}" {{ $users->position == $value_posit_ref->position_id ? 'selected' : '' }}>
		                                                	{{ $value_posit_ref->position_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ระดับ</strong>
												<select id="job_level" class="form-control custom-select"  name="job_level" data-live-search="true" required>
		                                            <option value="">กรุณาเลือก</option>
		                                            @foreach($job_level as $val_job_level)
		                                                <option value="{{ $val_job_level->id }}" {{ $users->job_level == $val_job_level->id ? 'selected' : '' }}>
		                                                	{{ $val_job_level->job_level_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ระดับการปฏิบัติงาน</strong>
												<select id="emp_level" class="form-control custom-select"  name="emp_level" data-live-search="true" required>
                                                    @if ($users->emp_level == 1)
                                                        {{ $value_emp = "หัวหน้างาน" }}
                                                    @elseif ($users->emp_level == 2)
                                                        {{ $value_emp = "ผู้ปฏิบัติงาน" }}
                                                    @elseif ($users->emp_level == 3)
                                                        {{ $value_emp = "หัวหน้ากล่องภารกิจ" }}
                                                    @endif
                                                    <option value="{{ $users->emp_level }}">{{ $value_emp }}</option>
		                                        </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>โทรศัพท์ <span id="error_phone" style="color: red;"></span></strong>
												<input type="text" value="{{ $users->phone }}" name="phone" id="phone" class="form-control" pattern="[0-9]{}" maxlength="10" required>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>อีเมล <span id="error_email" style="color: red;"></strong>
												<input type="email" value="{{ $users->email }}" name="email" id="email" class="form-control" required>
											</div>
										</div>
										<div class="col-xs-4 col-sm-4 col-md-4">
											<div class="form-group">
												<strong>ไลน์ไอดี</strong>
												<input type="text" value="{{ $users->lineid }}" name="lineid" class="form-control">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12">
											<div class="form-group">
												<strong>ที่อยู่</strong>
												<textarea class="form-control" rows="3" name="address" autocomplete="off">{{ $users->address }}</textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header bg-gradient-cyan">
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
												@php
													$i=1;
												@endphp
												@foreach($command_list as $key => $value)
													<strong>เลขคำสั่งแต่งตั้งที่ {{ $value->comm_num }}</strong>
													{{-- <input type="text" class="form-control" name="comm_num[]" id="comm_num" autocomplete="off" value="{{ $value->comm_num }}"> --}}

													<select name="comm_num[]">
														<option value="{{ $value->comm_num }}" selected>{{ $value->comm_num }}</option>
													</select>

                                    				<label for="comm_date" style="padding-top: 10px;">วันที่เริ่มปฏิบัติงานตามคำสั่งที่ {{ $value->comm_num }}</label>

                                    				<div class="input-group date" id="datepicker2">
				                                        <input class="form-control" name="comm_date[]" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" id="comm_date" value="{{ $value->comm_date }}" readonly>
				                                        <div class="input-group-append">
				                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
				                                        </div>
				                                    </div>
				                                    <input type="hidden" name="status[]" value="{{ $value->status }}">
				                                    <input type="hidden" name="comm_id[]" value="{{ $value->id }}">
				                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ดาวน์โหลดไฟล์">
				                                    @if($value->file_name)
				                                    <button style="margin-top: 10px;" class="btn btn-success">
				                                    	<a href="{{ route('commandlist.DownloadFile',['file_name' => $value->file_name, 'id' => $value->id]) }}" type="button" style="color: white;"> ดาวน์โหลดไฟล์คำสั่ง </a>
				                                    </button>
				                                    @else
				                                    <button style="margin-top: 10px;" class="btn btn-secondary">
				                                    	<a href="#" type="button" style="color: white;" disabled> ไม่มีไฟล์คำสั่ง </a>
				                                    </button>
				                                    @endif
				                                	</span>

				                                    <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="ลบคำสั่ง">
				                                    <button style="margin-top: 10px;" class="btn btn-danger" type="button">
				                                    	<a href="{{ route('users.destroy.command',$value->id)}}" style="color: white;">
				                                    	ลบเลขคำสั่งแต่งตั้ง {{ $value->comm_num }}</a>
				                                    </button>
				                                	</span>
				                                    {{-- <form method="post" action="{{ route('users.destroy.command') }}">
				                                    	@csrf

					                                    <input type="submit" style="margin-top: 10px;" class="btn btn-danger" value="ลบเลขคำสั่งแต่งตั้งที่ {{ $value->comm_num }}" />
					                                </form> --}}

				                                    <hr/>
				                                    @php
				                                    	$i++;
				                                    @endphp
												@endforeach

												<button type="button"  class="btn btn-success" style="margin-top: 10px; margin-bottom: 10px; width: 110px;" >
													<a href="{{ route('users.add_command') }}" style="color: white;">
														เพิ่มเลขคำสั่ง
													</a>
												</button>

											</div>
										</div>

									</div>
									{{-- <input type="button" id="add_comm_num()_1" class="btn btn-success" style="margin-top: 10px; width: 150px;" onclick="addComm_num()" value="เพิ่มเลขคำสั่ง" /> --}}

								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header bg-gradient-warning">
									<h3 class="card-title">ความสามารถพิเศษ (ด้านภาษา)</h3>
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
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาอังกฤษ</strong>
												<select class="form-control custom-select" name="talent_lang_eng">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_eng == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาจีน</strong>
												<select class="form-control custom-select" name = "talent_lang_chn">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_chn == $value->id ? 'selected' : '' }}
		                                                	>{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาญี่ปุ่น</strong>
												<select class="form-control custom-select" name = "talent_lang_jpn">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_jpn == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาเกาหลี</strong>
												<select class="form-control custom-select" name = "talent_lang_kor">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_kor == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาพม่า</strong>
												<select class="form-control custom-select" name = "talent_lang_myn">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_myn == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษากัมพูชา</strong>
												<select class="form-control custom-select" name = "talent_lang_cam">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_cam == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาฝรั่งเศส</strong>
												<select class="form-control custom-select" name = "talent_lang_fra">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_fra == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ภาษาสเปน</strong>
												<select class="form-control custom-select" name = "talent_lang_spn">
		                                            <option value="" selected>กรุณาเลือก</option>
		                                            @foreach($talent as $value)
		                                                <option value="{{ $value->id }}" {{ $users->talent_lang_spn == $value->id ? 'selected' : '' }}>
		                                                	{{ $value->id }}. {{ $value->talent_name }}
		                                                </option>
		                                            @endforeach
		                                        </select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header bg-gradient-pink">
									<h3 class="card-title">ความสามารถพิเศษ (อื่นๆ)</h3>
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
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ความสามารถพิเศษ (ด้านการขับขี่)</strong>
												<select class="form-control custom-select" name="talent_drive">
			                                        <option value="" selected>กรุณาเลือก</option>
			                                        @foreach($talent_drive as $value)
			                                            <option value="{{ $value->id }}" {{ $users->talent_drive == $value->id ? 'selected' : '' }}>
			                                            	{{ $value->id }}. {{ $value->drive }}
			                                            </option>
			                                        @endforeach
			                                    </select>
											</div>
										</div>
										<div class="col-xs-6 col-sm-6 col-md-6">
											<div class="form-group">
												<strong>ความสามารถพิเศษ (ด้านการฝึกอบรม)</strong>
												<select class="form-control custom-select" name="talent_course">
			                                        <option value="" selected>กรุณาเลือก</option>
			                                        @foreach($talent_course as $value)
			                                            <option value="{{ $value->course_id }}" {{ $users->talent_course == $value->course_id ? 'selected' : '' }}>
			                                            	{{ $value->course }}
			                                            </option>
			                                        @endforeach
			                                    </select>
											</div>
										</div>
										<div class="col-xs-12 col-sm-12 col-md-12">
											<input type="hidden" name="id" id="id" value="{{ $users->id }}">
		                                    <button  class="btn btn-success btn-lg float-right" id="submit">
		                                    	แก้ไขข้อมูลส่วนตัว
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

	<!-- Select2 -->
	<script src="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

	<!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Toastr -->
    <script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>

    <!-- Select2.org -->
    <script src="{{ asset('bower_components/select2_custom/dist/js/select2.min.js') }}"></script>
@stop
@section('custom-js-code')
	<script>
		// $('input').addClass('form-control');
		$('select').addClass('form-control');

		$('.datepicker1').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน

        $('.datepicker2').datepicker({
            format: 'yyyy-mm-dd',
            todayBtn: true,
            language: 'th', //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
            thaiyear: true //Set เป็นปี พ.ศ.
        }).datepicker("setDate", "0"); //กำหนดเป็นวันปัจุบัน

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

        window.addEventListener('load',
			function() {
				var organization_type_old = $('#organization_type').val();
				var id = $('#id').val();
				// console.log(organization_type_old);

				$("#overlay").fadeIn(1100);
				if (organization_type_old > 0) {
	      			$('#organization').prop('disabled', false);
	      			$.ajax({
	      				method: "GET",
	      				url: "{{ route('ajax.list.organization.old') }}",
	      				dataType: 'html',
	      				data: {organization_type: organization_type_old, id:id},
	      				success: function(data) {
	      					// console.log(data);
	      					$('#organization').html(data);
	      					$('#organization').selectpicker('refresh');
	      					$("#overlay").fadeOut(1100);
	      				},
	      				error: function(data) {
	      					alert(data.status);
	      				}
	      			});
	      		} else {
	      			$('.select-organization').val('');
	      			$('.select-organization').prop('disabled', true);
	      		}
			},
		false);

		window.addEventListener('load',
			function() {
				// var organization_old = $('#organization').val();
				var id = $('#id').val();
				// alert(id);
				$("#overlay").fadeIn(1100);

      			$('#roles').prop('disabled', false);
      			$.ajax({
      				method: "GET",
      				url: "{{ route('ajax.get_role.group_by.old') }}",
      				dataType: 'html',
      				data: {id:id},
      				success: function(data) {
      					// console.log(data);
      					$('#roles').html(data);
      					$('#roles').selectpicker('refresh');
      					$("#overlay").fadeOut(1100);
      				},
      				error: function(data) {
      					alert(data.status);
      				}
      			});

      			// $('.select-organization').val('');
      			// $('.select-organization').prop('disabled', true);

			},
		false);

        $(document).ready(function() {
        	//หน่วยงาน
	        $.ajaxSetup({
	          headers: {
	            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	          }
	        });

	        $('#organization_type').change(function() {

	      		var organization_type = $('#organization_type').val();
	      		// alert(organization_type);

	      		$("#overlay").fadeIn(1100);
	      		if (organization_type > 0) {
	      			$('#organization').prop('disabled', false);
	      			$('.select-roles').val('');
	      			$('#roles').prop('disabled', true);
	      			$.ajax({
	      				method: "GET",
	      				url: "{{ route('ajax.list.organization') }}",
	      				dataType: 'html',
	      				data: {organization_type: organization_type},
	      				success: function(data) {
	      					// console.log(data);
	      					$('#organization').html(data);
	      					$('#organization').selectpicker('refresh');
	      					$('#roles').selectpicker('refresh');
	      					$("#overlay").fadeOut(1100);
	      				},
	      				error: function(data) {
	      					alert(data.status);
	      				}
	      			});
	      		} else {
	      			$('.select-roles').val('');
	      			$('.select-roles').prop('disabled', true);
	      		}
	      	});

	        $('#organization').change(function() {

	      		var organization_id = $('#organization').val();
	      		// console.log(organization_id);

	      		$("#overlay").fadeIn(1100);
	      		if (organization_id > 0) {
	      			$('#roles').prop('disabled', false);
	      			$.ajax({
	      				method: "GET",
	      				url: "{{ route('ajax.list.rolesGroup') }}",
	      				dataType: 'html',
	      				data: {organization_id: organization_id},
	      				success: function(data) {
	      					$('#roles').html(data);
	      					$('#roles').selectpicker('refresh');
	      					$("#overlay").fadeOut(1100);
	      				},
	      				error: function(data) {
	      					alert(data.status);
	      				}
	      			});
	      		} else {
	      			$('.select-roles').val('');
	      			$('.select-roles').prop('disabled', true);
	      		}
	      	});

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

	        $("#email").focusout(function(){
	            var SpacialCharacter = /[ก-๙ ]/;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#email").val("");
	                $("#error_email").text("* กรอกได้เฉพาะภาษาอังกฤษ");
	                $("#error_email").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_email").text("");

	                var email   = $("#email").val();
	                var where   = 'email';
	                // console.log(cid);

	                $.ajax({
	                    type: "GET",
	                    url : "{{ route('register.checkRepeat') }}",
	                    data:{data:email, where:where},
	                    success:function(data){
	                        // console.log(data);
	                        if (data.data_repeat!=null) {
	                            $("#email").val("");
	                            $("#error_email").text("* อีเมลนี้มีผู้ใช้งานแล้ว");
	                        } else {
	                            $("#error_email").text("");
	                        }
	                    }
	                })
	            }
	        });

	        $("#name_th").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/A-Za-z0-9]/gi;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#name_th").val("");
	                $("#error_name_th").text("* กรอกได้เฉพาะภาษาไทย");
	                $("#error_name_th").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_name_th").text("");
	            }
	        });

	        $("#lname_th").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/A-Za-z0-9]/gi;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#lname_th").val("");
	                $("#error_lname_th").text("* กรอกได้เฉพาะภาษาไทย");
	                $("#error_lname_th").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_lname_th").text("");
	            }
	        });

	        $("#name_eng").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/ก-๙0-9]/;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#name_eng").val("");
	                $("#error_name_eng").text("* กรอกได้เฉพาะภาษาอังกฤษ");
	                $("#error_name_eng").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_name_eng").text("");
	            }
	        });

	        $("#lname_eng").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/ก-๙0-9]/;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#lname_eng").val("");
	                $("#error_lname_eng").text("* กรอกได้เฉพาะภาษาอังกฤษ");
	                $("#error_lname_eng").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_lname_eng").text("");
	            }
	        });

	        $("#cid").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/ก-๙a-zA-Z ]/;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#cid").val("");
	                $("#error_cid").text("* กรอกได้เฉพาะตัวเลข");
	                $("#error_cid").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_cid").text("");

	                var cid     = $("#cid").val();
	                var where   = 'cid';
	                // console.log(cid);

	                $.ajax({
	                    type: "GET",
	                    url : "{{ route('register.checkRepeat') }}",
	                    data:{data:cid, where:where},
	                    success:function(data){
	                        // console.log(data.data_cid);
	                        if (data.data_repeat!=null) {
	                            $("#cid").val("");
	                            $("#error_cid").text("* เลขบัตรประชาชนนี้มีผู้ใช้งานแล้ว");
	                        } else {
	                            $("#error_cid").text("");
	                        }
	                    }
	                })
	            }
	        });

	        $("#phone").focusout(function(){
	            var SpacialCharacter = /[`~!@#$%^&*()_|+\-=?;:'"<>\{\}\[\]\\\/ก-๙a-zA-Z ]/;

	            if ($(this).val().match(SpacialCharacter)) {
	                $(this).css("border-color", "#FF0000");
	                $("#phone").val("");
	                $("#error_phone").text("* กรอกได้เฉพาะตัวเลข");
	                $("#error_phone").focus();
	            } else {
	                $(this).css("border-color", "#2eb82e");
	                $("#error_phone").text("");
	            }
	        });
        });

	$(document).ready(function() {
	    $('.command-single').select2();
	});

	</script>
@stop
