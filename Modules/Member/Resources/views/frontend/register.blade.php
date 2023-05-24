@extends('member::layouts.blank')

@section('custom-css-script')

@stop

@section('custom-css')
<!-- Datepicker Thai -->
<link rel="stylesheet" href="{{ asset('bower_components/datepicker-thai/css/datepicker.css') }}">
<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<!-- Select2.org-->
<link rel="stylesheet" href="{{ asset('bower_components/select2_custom/dist/css/select2.min.css') }}">
@stop
@section('content')
<section class="content">
    <div class="container">
        <div class ="text-center">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('img/Logo_ddc.png') }}" width="130"  alt="Logo_ddc.png">
            </a><br>
            <h4><b>ระบบ DDC-ECOSYSTEMS</b></h4>
        </div>

        <!-- ปุ่ม home ย้อนกลับ -->
        <div class ="text-right">
            <a href="{{ route('login.ecosystem') }}" type="button" class="btn btn-info"><i class="fa fa-home"></i> กลับหน้าหลัก</a>
        </div><br>
        <!-- end ปุ่ม home ย้อนกลับ -->

        <form method="POST" action="{{ route('register.insert') }}" class="was-validated">
            @csrf
            <!-- ส่วนที่ 1 User-->
            <div class="row">
                <div class="col-md-12 form-group">
                    <div class="card card-danger shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title"> ส่วนที่ 1 : กำหนดชื่อผู้ใช้งานและรหัสผ่าน</h3>
                        </div>

                        <div class="card-body ">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6 form-group">
                                        <label for="username">ชื่อผู้ใช้ <span id="error_username" style="color: red;"></span></label>
                                        <input type="text" id="username" class="form-control" name="username" id="username" autocomplete="off" maxlength="50" required>
                                    </div>
                                    <div class="col-md-6 form-group" >
                                        <label for="password">รหัสผ่าน </label>
                                        <input type="password" id="password" class="form-control" name="password" maxlength="10" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row ">
                <div class="col-md-12">
                    <div class="card card-success shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title"> ส่วนที่ 2 : ข้อมูลสมาชิก </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prefix_th">คำนำหน้า(ไทย)</label>
                                        <select class="form-control custom-select" name="prefix_th" required>
                                            <option value="" selected disabled>กรุณาเลือก</option>
                                            @foreach($ref_prefix as $value)
                                                <option value="{{ $value->id }}">{{ $value->name_th }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name_th">ชื่อ (ไทย) <span id="error_name_th" style="color: red;"></span></label>
                                        <input type="text" class="form-control" name="name_th" id="name_th" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lname_th">นามสกุล(ไทย) <span id="error_lname_th" style="color: red;"></span></label>
                                        <input type="text" class="form-control" name="lname_th" id="lname_th" required autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prefix_eng">คำนำหน้า(อังกฤษ)</label>
                                        <select class="form-control custom-select" name="prefix_eng" required>
                                            <option value="" selected disabled>กรุณาเลือก</option>
                                            @foreach($ref_prefix as $value)
                                                <option value="{{ $value->id }}">{{ $value->name_en }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name_eng">ชื่อ (อังกฤษ) <span id="error_name_eng" style="color: red;"></span></label>
                                        <input type="text" class="form-control" name="name_eng" id="name_eng" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lname_eng">นามสกุล(อังกฤษ) <span id="error_lname_eng" style="color: red;"></span></label>
                                        <input type="text" class="form-control" name="lname_eng" id="lname_eng" required autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cid">เลขบัตรประชาชน <span id="error_cid" style="color: red;"></span></label>
                                        <input type="text" class="form-control" name="cid" id="cid" pattern="[0-9]{13}" maxlength="13" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>วันเกิด</label>
                                        <div class="input-group date" id="datepicker1">
                                            <input class=" form-control input-medium" name="birthdate" type="text" data-provide="datepicker" data-date-language="th" data-date-format="yyyy-mm-dd" placeholder="ปี/เดือน/วัน" autocomplete="off" required >
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="gender">เพศ</label>
                                        <select class="form-control custom-select" name="gender" required>
                                            <option value="" selected disabled>กรุณาเลือก</option>
                                            <option value="1">ชาย</option>
                                            <option value="2">หญิง</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organization_type">ส่วนงานในสังกัด</label>
                                        <select class="form-control custom-select" id="organization_type" name="organization_type" required>
                                            <option value="">กรุณาเลือก</option>
                                            @foreach($organization_type as $key_division_part => $value_division_part)
                                                <option value="{{ $key_division_part }}">{{ $value_division_part }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="organization">หน่วยงาน</label>
                                        <select id="organization" class="form-control select-organization" name="organization" data-live-search="true" disabled required>
                                            <option value="">------ กรุณาเลือก ------</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="roles">กล่องภารกิจ </label>
                                        <select id="roles" class="form-control select-roles" name="roles" data-live-search="true" disabled required>
                                            <option value="">------ กรุณาเลือก ------</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="position">ตำแหน่ง</label>
                                        <select id="position" class="form-control custom-select"  name="position" data-live-search="true" required>
                                            <option value="">กรุณาเลือก</option>
                                            @foreach($posit_ref as $value_posit_ref)
                                                <option value="{{ $value_posit_ref->position_id }}">{{ $value_posit_ref->position_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="job_level">ระดับ</label>
                                        <select id="job_level" class="form-control custom-select"  name="job_level" data-live-search="true" required>
                                            <option value="">กรุณาเลือก</option>
                                            @foreach($job_level as $val_job_level)
                                                <option value="{{ $val_job_level->id }}">{{ $val_job_level->job_level_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="emp_level">ระดับการปฏิบัติงาน</label>
                                        <select id="emp_level" class="form-control custom-select"  name="emp_level" data-live-search="true" required>
                                            <option value="">กรุณาเลือก</option>
                                            @foreach($emp_level as $key_emp_level => $val_emp_level)
                                                <option value="{{ $key_emp_level }}">{{ $val_emp_level }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="phone">โทรศัพท์ <span id="error_phone" style="color: red;"></span></label>
                                        <input type="text" class="form-control " name="phone" id="phone" pattern="[0-9]{10}" maxlength="10"required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="email">อีเมล์ <span id="error_email" style="color: red;"></label>
                                        <input type="email" class="form-control" name="email" id="email" required autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="lineid">ไอดีไลน์</label>
                                        <input type="text" class="form-control" name="lineid" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="address">ที่อยู่</label>
                                <textarea class="form-control" rows="3" name="address" autocomplete="off"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- ภาษา-->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-warning shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title"> ส่วนที่ 3 : ความสามารถพิเศษ (ด้านภาษา)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_eng">ภาษาอังกฤษ</label>
                                        <select class="form-control custom-select" name="talent_lang_eng">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_chn">ภาษาจีน</label>
                                        <select class="form-control custom-select" name = "talent_lang_chn">
                                            <option value="" selected >กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_jpn">ภาษาญี่ปุ่น</label>
                                        <select class="form-control custom-select" name = "talent_lang_jpn">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_kor">ภาษาเกาหลี</label>
                                        <select class="form-control custom-select" name = "talent_lang_kor">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_myn">ภาษาพม่า</label>
                                        <select class="form-control custom-select" name = "talent_lang_myn">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_cam">ภาษากัมพูชา</label>
                                        <select class="form-control custom-select" name = "talent_lang_cam">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_fra">ภาษาฝรั่งเศส</label>
                                        <select class="form-control custom-select" name = "talent_lang_fra">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="talent_lang_spn">ภาษาสเปน</label>
                                        <select class="form-control custom-select" name = "talent_lang_spn">
                                            <option value="" selected>กรุณาเลือก</option>
                                            @foreach($talent as $value)
                                                <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->talent_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <!-- ขับขี่ -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-pink shadow-lg">
                        <div class="card-header">
                            <h3 class="card-title">ส่วนที่ 4 : ความสามารถพิเศษ (อื่นๆ)</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <label for="talent_drive">ความสามารถพิเศษ (ด้านการขับขี่)</label>
                                    <select class="form-control custom-select" name="talent_drive">
                                        <option value="" selected>กรุณาเลือก</option>
                                        @foreach($talent_drive as $value)
                                            <option value="{{ $value->id }}">{{ $value->id }}.{{ $value->drive }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label for="talent_course">ความสามารถพิเศษ (ด้านการฝึกอบรม)</label>
                                    <select class="form-control custom-select" name="talent_course">
                                        <option value="" selected>กรุณาเลือก</option>
                                        @foreach($talent_course as $value)
                                            <option value="{{ $value->course_id }}">{{ $value->course }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="checkbox" id="checkpolicy">
                                    <a href="" data-toggle="modal" data-target="#exampleModal">ฉันได้อ่านเงื่อนไขการให้บริการเป็นที่เรียบร้อยแล้ว</a>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <button  class="btn btn-success btn-lg float-right" value="ยืนยันสมัครสมาชิก" id="submit" disabled="disabled">ยืนยันสมัครสมาชิก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- card-body -->
            </div><!-- card -->
        </div><!-- col-md-12 -->
    </div> <!-- row -->
</section>

<!-- modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-pink">
                <h5 class="modal-title" id="exampleModalLabel"><b>ระบบ DDC-ECOSYSTEM</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class ="text-center">
                    <h5><b>เงื่อนไขและข้อจำกัดในการให้บริการ</b></h5><br>
                </div>

                <div align="justify">
                    <p>1. ผู้ให้บริการจะเก็บรักษาข้อมูลของผู้ใช้บริการเป็นอย่างดี ตามข้อกำหนดและเงื่อนไขการให้บริการ รวมถึงนโยบายคุ้มครองความเป็นส่วนตัว (Privacy Policy) และจะไม่ทำการเปิดเผยต่อบุคคลใด เว้นแต่ข้อมูลดังกล่าวเป็นข้อมูลที่กำหนดให้ต้องเปิดเผยโดยกฎหมายหรือโดยคำสั่งศาล<br></p>
                    <p>2. การให้บริการนี้ ผู้ให้บริการได้ปฏิบัติตามพระราชบัญญัติว่าด้วยการกระทำความผิดเกี่ยวกับคอมพิวเตอร์ พ.ศ. 2550 และที่แก้ไขเพิ่มเติม ดังนั้น ผู้ให้บริการจะไม่รับผิดชอบต่อความเสียหายหรือความเสียหายของข้อมูลหรือแฟ้มข้อมูลของผู้ใช้บริการ กรณีเกิดความเสียหายอันเนื่องมาจากผู้ใช้บริการ หรือความเสียหายที่เกิดจากเหตุสุดวิสัย<br></p>
                    <p>3. ภายหลังจากที่ผู้ให้บริการออกใบแจ้งชื่อบัญชีและรหัสผ่านของผู้ดูและระบบแล้ว สิทธิการบริหารจัดการทรัพยากรจัดสรรให้ จะเป็นของผู้ใช้บริการ<br></p>
                    <p>4. การให้บริการจะไม่ครอบคลุมปัญหาที่เกิดขึนจากการใช้งานอุปกรณ์ที่ผู้ใช้บริการจัดหามาเพื่อใช้บริการระบบ DDC-ECOSYSTEM ด้วยตนเอง<br></p>
                    <p>5. ผู้ให้บริการขอสงวนสิทธิ์ระงับการให้บริการบางบัญชีหรือทุกบัญชีผู้ใช้งาน หากตรวจพบในกรณีดังต่อไปนี้<br>
                        <ul>
                            <li>การใช้งานระบบของผู้ใช้บริการก่อให้เกิดผลกระทบต่อภาพรวมการให้บริการของผู้ให้บริการหรือมีปัญหาทางการความมั่นคงปลอดภัย</li>
                            <li>ผู้ใช้บริการกระทำการฝ่าฝืนกฎหมายที่เกี่ยวข้องกับการให้บริการหรือละเมิดต่อข้อกำหนดและเงื่อนไขการให้บริการ</li>
                            <li>ในกรณีที่มีเหตุจำเป็นต้องบำรุงรักษาหรือแก้ไขระบบที่ใช้ในการให้บริการ</li>
                            <li>ผู้ใช้บริการไม่มีการเข้าใช้งานระบบเกิน 6 เดือน หรือ ตามที่ผู้ให้บริการพิจารณาเห็นสมควร</li>
                        </ul>

                    <p>6. หน่วยงานผู้ใช้บริการสามารถกำหนดให้เจ้าหน้าที่ พนักงาน หรือลูกจ้างของผู้ใช้บริการเป็นผู้ประสานงานกับผู้ให้บริการได้ไม่เกิน 2 คน หากมีการเปลี่ยนแปลงผู้ประสานงาน ดังกล่าว ผู้ใช้บริการต้องแจ้งให้ผู้ให้บริการทราบเป็นลายลักษณ์อักษรในทันที ทั้งนี้ ผู้ให้บริการจะไม่รับผิดชอบรรดาความเสียหายที่อาจเกิดขึ้นจากการแจ้งเปลี่ยนผู้ประสานงานล่าช้าหรือไม่ดำเนินการแจ้งให้ผู้ให้บริการทราบ<br></p>
                    <p>7.การที่ผู้ใช้บริการยินยอมให้รหัสข้อมูลซึ่งอาจเข้าถึงข้อมูลส่วนบุคคล ข้อมูลองค์กร และข้อมูลใดๆ ของผู้ใช้บริการแก่ผู้ให้บริการ เพื่อประโยชน์ในการเข้าตรวจสอบปัญหา ให้คำปรึกษา หรือแก้ไขปัญหา สำหรับการใช้งานต่างๆ จะถือว่าผู้ให้บริการได้รับรหัสข้อมูลซึ่งอาจเข้าถึงข้อมูลต่างๆ ภายใต้การอนุญาตเพื่อขอรับริการตวรวจสอบปัญหาให้คำปรึกษา หรือแก้ไขปัญหาโดยผู้ใช้บริการ <br></p>
                    <p>จึงไม่ถือเป็นการเข้าถึงข้อมูลของผู้ให้บริการอันเป็นความผิดต่อกฎหมายและไม่ถือเป็นการละเมิดสิทธิอื่นใดของผู้ใช้บริการภายหลังจากที่ผู้ใช้บริการได้รับบริการจากผู้ให้บริการ ในการดำเนินการต่างๆ ดังกล่าวเสร็จเรียบร้อยแล้ว เพื่อเป็นการรักษาความปลอดภัยในข้อมูลของผู้ใช้บริการ ผู้ใช้บริการหรือเจ้าหน้าที่ของหน่วยงานผู้ใช้บริการมีหน้าที่ต้องรับผิดชอบในการดำเนินการเปลี่ยนแปลงรหัสข้อมูลดังกล่าวใหม่โดยทันที<br></p>
     	    โดยผู้ให้บริการขอสงวนสิทธิ์ไม่รับผิดชอบในความสูญหายหรือเสียหายใดๆ จากการดำเนินการตามวรรคหนึ่งไม่ว่าเป็นความเสียหายโดยตรง ความเสียหายโดยอ้อม ความเสียหายพิเศษ ความเสียหายต่อเนื่อง หรือค่าเสียหายใดๆ ที่เกิดขึ้นกับข้อมูล โปรแกรมคอมพิวเตอร์ สิทธิในทรัพย์สินทางปัญญา สิทธิอื่นใด ผลประโยชน์ทางธุรกิจ หรือการหยุดชะงักทางธุรกิจของผู้ใช้บริการหรือของบุคคลใด ในทุกกรณี<br></p>
                    <p>8. สงวนสิทธิ์ในการเปลี่ยนแปลง<br>
                        <ul>
                            <li>ผู้ให้บริการขอสงวนสิทธิ์เด็ดขาดในการเปลี่ยนแปลง แก้ไขเพิ่มเติมหรือตัดออก ซึ่งส่วนใดส่วนหนึ่งของข้อกำหนดและเงื่อนไขการให้บริการนี้ได้ตลอดเวลา และถือว่าผู้ใช้บริการได้ยอมรับข้อกำหนดและเงื่อนไขการให้บริการใหม่โดยปริยาย ตลอดระยะเวลาที่ผู้ใช้บริการยังคงใช้บริการและรับบริการของผู้ให้บริการ</li>
                            <li>ผู้ให้บริการขอสงวนสิทธิ์เด็ดขาดในการเปลี่ยนแปลง การวางเงื่อนไขข้อกำหนด การจำกัดขอบเขตการระงับชั่วคราว การบอกเลิก หรือการยกเลิกรูปแบบการให้บริการ หรือการให้บริการได้ตลอดเวลา โดยไม่จำเป็นต้องบอกกล่าวล่วงหน้า และไม่ก่อให้เกิดความรับผิดชอบใดๆ แก่ผู้ให้บริการ</li>
                        </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ตกลง</button>
                <!-- <input type="submit" value="ตกลง" onclick="alert('Welcome to website devtai.com')"> -->
                <!--  <button type="submit" class="btn btn-primary">Send message</button> -->
            </div>
        </form>
        </div>
    </div>
</div>

<!-- end modal -->

@endsection('content')

@section('custom-js-script')
<!-- datepicker -->
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/bootstrap-datepicker-thai.js') }}"></script>
<script src="{{ asset('bower_components/datepicker-thai/js/locales/bootstrap-datepicker.th.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Select2.org -->
<script src="{{ asset('bower_components/select2_custom/dist/js/select2.min.js') }}"></script>
<script>

    $(document).ready(function() {

      @if ($message = Session::get('success'))
          Swal.fire({
              title: 'การลงทะเบียนสำเร็จ ',
              text: 'กรุณารอการยืนยันข้อมูลผ่านทาง Email ที่ทำการลงทะเบียน',
              confirmButtonText: 'Click เพื่อเข้าสู่ระบบ !!',
              icon: 'success',

          }).then(function (result) {
              if (result.value) {
                  window.location = "{{ env('APP_URL') }}";
              }
          })
      @endif
        //หน่วยงาน
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $('#organization,#roles,#position').selectpicker();

        $('#organization_type').change(function() {

      		var organization_type = $('#organization_type').val();

      		$("#overlay").fadeIn(1100);
      		if (organization_type > 0) {
      			$('#organization').prop('disabled', false);
      			$.ajax({
      				method: "GET",
      				url: "{{ route('ajax.get_list_agency') }}",
      				dataType: 'html',
      				data: {organization_type: organization_type},
      				success: function(data) {
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
      	});

        $('#organization').change(function() {

      		var organization_id = $('#organization').val();

      		$("#overlay").fadeIn(1100);
      		if (organization_id > 0) {
      			$('#roles').prop('disabled', false);
      			$.ajax({
      				method: "GET",
      				url: "{{ route('ajax.get_role_group_by') }}",
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

        //หน่วยงาน
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

        $("#username").focusout(function(){
            var SpacialCharacter = /[ก-๙ ]/;

            if ($(this).val().match(SpacialCharacter)) {
                $(this).css("border-color", "#FF0000");
                $("#username").val("");
                $("#error_username").text("* กรอกได้เฉพาะภาษาอังกฤษ");
                $("#error_username").focus();
            } else {
                $(this).css("border-color", "#2eb82e");
                $("#error_username").text("");

                var username    = $("#username").val();
                var where       = 'username';
                // console.log(cid);

                $.ajax({
                    type: "GET",
                    url : "{{ route('register.checkRepeat') }}",
                    data:{data:username, where:where},
                    success:function(data){
                        // console.log(data);
                        if (data.data_repeat!=null) {
                            $("#username").val("");
                            $("#error_username").text("* ชื่อผู้ใช้นี้มีผู้ใช้งานแล้ว");
                        } else {
                            $("#error_username").text("");
                        }
                    }
                })
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

        const checkbox = document.getElementById('checkpolicy')

        checkbox.addEventListener('change', (event) => {
            if (event.target.checked) {
                document.getElementById("submit").disabled=false;
            } else {
                document.getElementById("submit").disabled=true;
            }
        })
    });


    $(document).ready(function() {
        $('.command-single').select2();
    });
</script>
@stop
