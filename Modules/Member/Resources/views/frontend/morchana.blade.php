@extends('member::layouts.master')
@section('custom-css-script')
@stop
@section('custom-css')
@stop
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>การขอใช้งานข้อมูลหมอชนะ</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
<body>
    <div id="wrapper">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col">
                    <div class="bg-white text-center p-2 rounded">
                        <h4 class="text-info">ไทยชนะ</h4>
                        <img src="{{ asset('morchana\thaichana.jpg') }}" class="img-fluid">
                    </div>
                </div>
                <div class="col">
                    <div class="bg-white text-center p-2 rounded">
                        <h4 class="text-info">หมอชนะ</h4>
                        <div id="demo" class="carousel slide" data-ride="carousel">
                            <!-- Indicators -->
                            <ul class="carousel-indicators">
                              <li data-target="#demo" data-slide-to="0" class="active"></li>
                              <li data-target="#demo" data-slide-to="1"></li>
                              <li data-target="#demo" data-slide-to="2"></li>
                              <li data-target="#demo" data-slide-to="3"></li>
                              <li data-target="#demo" data-slide-to="4"></li>
                            </ul>
                            
                            <!-- The slideshow -->
                            <div class="carousel-inner">
                              <div class="carousel-item active">
                                <img src="{{asset('morchana\line_oa_chat_210109_010938_0.jpg')}}" class="img-fluid">
                              </div>
                              <div class="carousel-item">
                                <img src="{{asset('morchana\line_oa_chat_210109_011031_1.jpg')}}" class="img-fluid">
                              </div>
                              <div class="carousel-item">
                                <img src="{{asset('morchana\line_oa_chat_210109_011034_2.jpg')}}" class="img-fluid">
                              </div>
                              <div class="carousel-item">
                                <img src="{{asset('morchana\line_oa_chat_210109_011036_3.jpg')}}" class="img-fluid">
                              </div>
                              <div class="carousel-item">
                                <img src="{{asset('morchana\line_oa_chat_210109_011039_4.jpg')}}" class="img-fluid">
                              </div>
                            </div>
                            
                            <!-- Left and right controls -->
                            <a class="carousel-control-prev" href="#demo" data-slide="prev">
                              <span class="carousel-control-prev-icon"></span>
                            </a>
                            <a class="carousel-control-next" href="#demo" data-slide="next">
                              <span class="carousel-control-next-icon"></span>
                            </a>
                          </div>
                          
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col">
                    <table class="table table-hover">
                        <tbody class="text-center">
                        <tr>
                                <td colspan="4">
                                <a href="{{ URL::to('https://drive.google.com/drive/folders/1dDCptVqH3fVDSW8bNK9w0PRPYQU59slb?usp=sharing') }}">
                                    <img src="{{asset('morchana\flowchana.jpg')}}">
                                </a>
                                </td>                                
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <img src="{{asset('morchana\center.jpg')}}">
                                </td>
                                <td colspan="2">
                                    <img src="{{asset('morchana\iudc.jpg')}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('morchana\odpc1.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc2.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc3.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc4.jpg')}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('morchana\odpc5.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc6.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc7.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc8.jpg')}}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{asset('morchana\odpc9.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc10.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc11.jpg')}}">
                                </td>
                                <td>
                                    <img src="{{asset('morchana\odpc12.jpg')}}">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- end container-fluid -->
    </div>
</body>

</section>
@endsection
@section('custom-js-script')
@stop
@section('custom-js-code')
@stop
