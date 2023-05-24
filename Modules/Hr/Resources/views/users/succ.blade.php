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


<div class="alert alert-success">
    <h3>แก้ไขข้อมูลเสร็จสิ้น !</h>
</div>


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