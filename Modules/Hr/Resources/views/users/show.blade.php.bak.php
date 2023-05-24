<?php
use App\CmsHelper as CmsHelper;

$org_th_arr = CmsHelper::Get_Organization_TH();
$pos_th_arr = CmsHelper::Get_Position_TH();
$tal_lan_arr = CmsHelper::Get_Talent_language();
$tal_dri_arr = CmsHelper::Get_Talent_Drive();
$tal_cou_arr = CmsHelper::Get_Talent_Course();
$roles_en_arr = CmsHelper::Get_Roles_EN();
$pre_th_arr = CmsHelper::Get_Prefix_TH();
$pre_en_arr = CmsHelper::Get_Prefix_EN();
?>

@extends('hr::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
@stop
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>ข้อมูลผู้ใช้งาน</h1>

            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<!-- Default box -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card shadow">
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
                                                <input type="text" value="{{ $pre_th_arr[$users->prefix_th] }}" name="prefix_th">
                                        </div>

								        <div class="col-md-5">
									        <label>ชื่อ(ไทย)</label>
									            <input type="text" value="{{ $users->name_th }}" name="name_th">
                                        </div>
                                        
								        <div class="col-md-5">
								            <label>นามสกุล(ไทย)</label>
                                                <input type="text" value="{{ $users->lname_th }}" name="lname_th">
								        </div>
                                    </div>
                                
                                </div>

                                <div class="form-group">
                                    <label>คำนำหน้า (อังกฤษ)</label>
                                    <input type="text" value="{{ $pre_en_arr[$users->prefix_eng] }}" name="prefix_eng">
                                </div>
                                <div class="form-group">
                                    <label>ชื่อ-นามสกุล (อังกฤษ)</label>
                                    <input type="text" value="{{ $users->name_eng }}" name="name_eng">
                                    <input type="text" value="{{ $users->lname_eng }}" name="lname_eng">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>เลขประชาชน</label>
                                    <input type="text" value="{{ $users->cid }}" name="cid">
                                </div>
                                <div class="form-group">
                                    <label>เพศ (ไทย)</label>
                                    <input type="text" value="{{ $users->gender }}" name="gender">
                                    <div class="form-group">
                                        <label>วันเกิด</label>
                                        <input type="text" value="{{ $users->birthdate }}" name="birthdate">
                                    </div>
                                    <div class="form-group">
                                        <label>โทรศัพท์</label>
                                        <input type="text" value="{{ $users->phone }}" name="phone">
                                    </div>
                                    <div class="form-group">
                                        <label>ไลน์ไอดี</label>
                                        <input type="text" value="{{ $users->lineid }}" name="lineid">
                                    </div>
                                    <div class="form-group">
                                        <label>อีเมล</label>
                                        <input type="text" value="{{ $users->email }}" name="email">
                                    </div>
                                </div>
                            </div>


                            	<div class="col-md-4">
								<div class="form-group">
                                    <label>กล่องภารกิจ</label>

                                    <select name="roles_id">
									<option value="" selected disabled>-> {{ $roles_en_arr[$users->roles] }}</option>
										@foreach($role_con as $rolesen_form)
										<option value="{{ $rolesen_form->id}}" >{{ $rolesen_form->name_eng}}</option>
										@endforeach
									</select>
                                    
                                </div>
								<div class="form-group">
									<label>หน่วยงาน</label>
									<select name="organization_id">
									<option value="" selected disabled>-> {{ $org_th_arr[$users->organization] }}</option>
										@foreach($org as $org_form)
										<option value="{{ $org_form->organization_id}}" >{{ $org_form->organization_name}}</option>
										@endforeach
									</select>
                                </div>
                                	<div class="form-group">
										<label>ตำแหน่ง </label>
											<select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $pos_th_arr[$users->position] }}</option>
											@foreach($pos as $pos_form)
											<option value="{{ $pos_form->position_id}}" >{{ $pos_form->position_name}}</option>
											@endforeach
											</select>
									</div>
                                    <div class="form-group">
                                        <label>เลขคำสั่งแต่งตั้ง</label>
                                        <input type="text" value="{{ $users->comm_num }}" name="comm_num">
                                    </div>
                                    <div class="form-group">
                                        <label>วันที่มีคำสั่งให้ปฏิบัติงาน</label>
                                        <input type="text" value="{{ $users->comm_date }}" name="comm_date">
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
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_eng] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

								        <div class="col-md-4">
                                        <label>ภาษาจีน</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_chn] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาญี่ปุ่น</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_jpn] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาเกาหลี</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_kor] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาพม่า</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_myn] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษากัมพูชา</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_cam] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาฝรั่งเศษ</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_fra] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
											@endforeach
											</select>
                                        </div>

                                        <div class="col-md-4">
                                        <label>ภาษาสเปน</label>
                                            <select name="position_id" id="position">
											<option value="" selected disabled>-> {{ $tal_lan_arr[$users->talent_lang_spn] }}</option>
											@foreach($tal as $tal_form)
											<option value="{{ $tal_form->id}}" >{{ $tal_form->talent_name}}</option>
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
                                            <select name="drive_id">
											<option value="" selected disabled>-> {{ $tal_dri_arr[$users->talent_drive] }}</option>
											@foreach($dri as $dri_form)
											<option value="{{ $dri_form->id}}" >{{ $dri_form->drive}}</option>
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
                                            <select name="course_id">
											<option value="" selected disabled>-> {{ $tal_cou_arr[$users->talent_course] }}</option>
											@foreach($cou as $cou_form)
											<option value="{{ $cou_form->id}}" >{{ $cou_form->course}}</option>
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
        </div>
	</div>

</section>


@endsection
@section('custom-js-script')
@stop
@section('custom-js-code')
<script>
$('input').addClass('form-control');
$('select').addClass('form-control');
</script>

@stop