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
<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">
@stop
@section('content')

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <h3>{{ $message }}</h>
</div>
@endif

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>แก้ไขข้อมูลผู้ใช้งาน: {{ $users->name_th }} {{ $users->lname_th }} </h1>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Default box -->

<form method="POST" action="{{ route('users.update', $uid->id) }}" class="was-validated">
    @csrf
    @method('patch')

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-header bg-gradient-blue">
                        <h3 class="card-title">ข้อมูลส่วนตัว</h3>
                        <div class="card-tools">
                            	<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">

                                <div class="form-group">

								    <div class="row">
								        <div class="col-md-2">
								            <label>คำนำหน้า</label>
                                            <select name="prefix_th" required>
                                                <option value="{{ $users->prefix_th }}" selected>{{ $pre_th_arr[$users->prefix_th] }}</option>
                                                @foreach($ref_prefix as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name_th }} </option>
                                                @endforeach
                                            </select>
                                        </div>

								        <div class="col-md-5">
									        <label>ชื่อ(ไทย)</label>
									            <input type="text" value="{{ $users->name_th }}" name="name_th" required>
                                        </div>

								        <div class="col-md-5">
								            <label>นามสกุล(ไทย)</label>
                                                <input type="text" value="{{ $users->lname_th }}" name="lname_th" required>
								        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>คำนำหน้า</label>
                                            <select name="prefix_eng" required>
                                                <option value="{{ $users->prefix_eng }}" selected>{{ $pre_en_arr[$users->prefix_eng] }}</option>
                                                @foreach($ref_prefix as $value)
                                                    <option value="{{ $value->id }}">{{ $value->name_en }} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-5">
                                            <label>ชื่อ (อังกฤษ)</label>
                                            <input type="text" value="{{ $users->name_eng }}" name="name_eng" required="">
                                        </div>

                                        <div class="col-md-5">
                                            <label>นามสกุล (อังกฤษ)</label>
                                            <input type="text" value="{{ $users->lname_eng }}" name="lname_eng" required="">
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>เลขประชาชน</label>
                                    <input type="text" value="{{ $users->cid }}" name="cid" pattern="[0-9]{13}" maxlength="13" required>
                                </div>

                                <div class="form-group">
                                    <label>เพศ (ไทย)</label>
                                    <select class="form-control custom-select" name="gender" required>
                                            <option value="{{ $users->gender }}" selected> @if($users->gender == '1') ชาย @else หญิง @endif </option>
                                            <option value="1">ชาย</option>
                                            <option value="2">หญิง</option>
                                    </select>

                                <div class="form-group">
                                        <label>วันเกิด</label>
                                        <div class="input-group date" id="datepicker1">
                                            <input class=" form-control input-medium" value="{{ $users->birthdate }}" name="birthdate" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" required >
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label>โทรศัพท์</label>
                                        <input type="text" value="{{ $users->phone }}" name="phone" pattern="[0-9]{}" maxlength="10">
                                    </div>
                                    <div class="form-group">
                                        <label>ไลน์ไอดี</label>
                                        <input type="text" value="{{ $users->lineid }}" name="lineid">
                                    </div>
                                    <div class="form-group">
                                        <label>อีเมล</label>
                                        <input type="email" value="{{ $users->email }}" name="email">
                                    </div>
                                </div>
                            </div>


                            	<div class="col-md-4">

								<div class="form-group">
									<label>หน่วยงาน</label>
                                    <select name="organization" required>
                                            <option value="{{ $users->organization }}" selected>{{ $org_th_arr[$users->organization] }}</option>
                                            @foreach($org_ref as $value)
                                                <option value="{{ $value->organization_id }}">{{ $value->organization_name }} </option>
                                            @endforeach
                                    </select>


									</select>
                                </div>
                                	<div class="form-group">
										<label>ตำแหน่ง </label>
                                            <select name="position" required>
                                            <option value="{{ $users->position }}" selected>{{ $pos_th_arr[$users->position] }}</option>
                                            @foreach($posit_ref as $value)
                                                <option value="{{ $value->position_id }}">{{ $value->position_name }} </option>
                                            @endforeach
                                        </select>

									</div>
                                    <div class="form-group">
                                        <label>เลขคำสั่งแต่งตั้ง</label>
                                        <input type="text" value="{{ $users->comm_num }}" name="comm_num[]">
                                    </div>
                                    <div class="form-group">
                                        <label>วันที่มีคำสั่งให้ปฏิบัติงาน</label>
                                        <div class="input-group date" id="datepicker2">
                                        <input class=" form-control input-medium" value="{{ $users->comm_date }}" name="comm_date[]" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" >
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <!-- /.card-body -->
                        <!-- /.card-footer-->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</section>



<!-- Default box -->


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-gradient-green">
                        <h3 class="card-title">ความสามารถด้านภาษา</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <div class="row">

								        <div class="col-md-4">
                                        <label>ภาษาอังกฤษ</label>
                                            <select name="talent_lang_eng">
											<option value="{{ $users->talent_lang_eng }}" selected>{{ $tal_lan_arr[$users->talent_lang_eng] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

								        <div class="col-md-4">
                                        <label>ภาษาจีน</label>
                                            <select name = "talent_lang_chn">
											<option value="{{ $users->talent_lang_chn }}" selected>{{ $tal_lan_arr[$users->talent_lang_chn] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาญี่ปุ่น</label>
                                            <select name = "talent_lang_jpn">
											<option value="{{ $users->talent_lang_jpn }}" selected>{{ $tal_lan_arr[$users->talent_lang_jpn] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาเกาหลี</label>
                                            <select name = "talent_lang_kor">
											<option value="{{ $users->talent_lang_kor }}" selected>{{ $tal_lan_arr[$users->talent_lang_kor] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาพม่า</label>
                                            <select name = "talent_lang_myn">
											<option value="{{ $users->talent_lang_myn }}" selected>{{ $tal_lan_arr[$users->talent_lang_myn] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษากัมพูชา</label>
                                            <select name="talent_lang_cam">
											<option value="{{ $users->talent_lang_cam }}" selected>{{ $tal_lan_arr[$users->talent_lang_cam] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาฝรั่งเศษ</label>
                                            <select name="talent_lang_fra">
											<option value="{{ $users->talent_lang_fra }}" selected >{{ $tal_lan_arr[$users->talent_lang_fra] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาสเปน</label>
                                            <select name="talent_lang_spn">
											<option value="{{ $users->talent_lang_spn }}" selected>{{ $tal_lan_arr[$users->talent_lang_spn] }}</option>
                                            <option value="99">ไม่ระบุ</option>
											@foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->talent_name }}</option>
                                            @endforeach
											</select>
                                        </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>



<!-- Default box -->

            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-gradient-orange">
                        <h3 class="card-title">ความสามารถด้านการขับขี่</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>



                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">

                                        <div class="col-md-12">
                                        <label>ประเภท</label>
                                            <select name="talent_drive">
											<option value="{{ $users->talent_drive }}" selected>{{ $tal_dri_arr[$users->talent_drive] }}</option>
                                            <option value="99">ไม่ระบุ</option>
    											@foreach($talent_drive as $value)
                                                    <option value="{{ $value->id }}">{{ $value->drive }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
							</div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>



<!-- Default box -->

            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-gradient-pink">
                        <h3 class="card-title">ความสามารถด้านการฝึกอบรม</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="row">

                                    <div class="col-md-12">
                                        <label>ประเภทหลักสูตร</label>
                                            <select name="talent_course">
											<option value="{{ $users->talent_course }}" selected>{{ $tal_cou_arr[$users->talent_course] }}</option>
											@foreach($talent_course as $value)
                                                <option value="{{ $value->course_id }}">{{ $value->course }}</option>
                                            @endforeach
											</select>
                                        </div>
                                    </div>
                                </div>
							</div>
                        </div>
                    </div>

                    </div>
                    <!-- /.card-body -->
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <button  class="btn btn-success btn-lg float-right" value="ยืนยันแก้ไขข้อมูล" id="submit"> ยืนยันแก้ไขข้อมูล </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


			</div>
        </div>
	</div>

</section>
</form>

@endsection
@section('custom-js-script')
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
@stop
@section('custom-js-code')
<script>
$('input').addClass('form-control');
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

</script>

@stop
