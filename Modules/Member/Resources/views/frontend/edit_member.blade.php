@extends('member::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
@stop
@section('content')



<div class="content"><div class="container"><div class="row"><div class="col-md-12" >
<div class="card">
                <div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit Member</h4><br>
                  <p class="card-category">แก้ไขสมาชิก</p>
                </div>
<div class="card-body">

@if(session()->has('message'))
                <div class="alert alert-success">
                    {{session()->get('message')}}
                </div>
@endif

<form action="{{ route('edit.member.button') }}" method="post">

@csrf

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputprefixTH">คำนำหน้า (ไทย) : </label>
      <input type="text" class="form-control" name="inputprefix" id="prefix_th" value=" {{ $data_query->prefix_th }}" >
  </div>
  </div></div>

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputnameTH">ชื่อ (ไทย) : </label>
      <input type="text" class="form-control" name="inputnameTH" id="name_th" value=" {{ $data_query->name_th }}" >
  </div>
  </div></div>

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputlnameTH">นามสกุล (ไทย) : </label>
      <input type="text" class="form-control" name="inputlnameTH" id="lname_th" value=" {{ $data_query->lname_th }}" >
  </div>
  </div></div>

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputprefixEN">คำนำหน้า (อังกฤษ): </label>
      <input type="text" class="form-control" name="inputprefixEN" id="prefix_en" value=" {{ $data_query->prefix_en }}" >
  </div>
  </div></div>

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputnameEN">ชื่อ (อังกฤษ) : </label>
      <input type="text" class="form-control" name="inputnameEN" id="name_en" value=" {{ $data_query->name_en }}" >
  </div>
  </div></div>

  <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputlnameEN">นามสกุล (อังกฤษ) : </label>
      <input type="text" class="form-control" name="inputlnameEN" id="lname_en" value=" {{ $data_query->lname_en }}" >
  </div>
  </div></div>

    <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputphone">หมายเลขโทรศัพท์ : </label>
      <input type="text" class="form-control" name="inputphone" id="phone" value=" {{ $data_query->phone }}" >
  </div>
  </div></div>

    <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputemail">อีเมล : </label>
      <input type="text" class="form-control" name="inputemail" id="email" value=" {{ $data_query->email }}" >
  </div>
  </div></div>

    <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputlineid">ไลน์ไอดี : </label>
      <input type="text" class="form-control" name="inputlineid" id="lineid" value=" {{ $data_query->lineid }}" >
  </div>
  </div></div>

    <div class="row">
  <div class="col-md-4">
    <div class="form-group">
      <label for="inputaddress">ที่อยู่ : </label>
      <input type="text" class="form-control" name="inputaddress" id="address" value=" {{ $data_query->address }}" >
  </div>
  </div></div>



                    <div class="card-footer justify-content-center">
                      <button type="submit" class="btn btn-success" value="">Edit</button>
                      <button type="reset" class="btn btn-danger" value="">Reset</button>
                    </div>



</div>
</div>
</div></div></div></div>



@endsection
@section('custom-js-script')
@stop
@section('custom-js-code')
@stop
