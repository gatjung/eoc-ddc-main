<?php
use App\CmsHelper as CmsHelper;
use Carbon\Carbon as Carbon;
?>

@extends('dataprocessing::layouts.master')
<!-- การเรียกวิว ต้องเป็นตัวเล็กทั้งหมด เช่น dataprocessing -->
@section('custom-css')  
<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Muli:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/elegant-icons.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/nice-select.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/jquery-ui.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/slicknav.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/style.css') }}" type="text/css">
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">



<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.css') }}">



<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">


@stop
@section('content')

<!-- หน้านี้สำหรับการเขียนข้อมูลที่ต้องการแสดงที่หน้าเว็บ -->
<div class="container-fluid">
<br>          
<!-- Content Row -->

<!-- <div class="col-sm-6">
        <h3 class="m-0 text-dark">ข้อมูลเจ้าหน้าที่ในระบบ</h3>
     </div>
<br> -->

<!-- START HR  BOX ------------------------------------------------------->  
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-md-4 col-3">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h5> บุคลากรทั้งหมด </h5>
                    <h3> {{ number_format(round($Totalhr1->total_role_id1)) }} คน</h3> 
                    <h3> {{ round(($Totalhr1->total_role_id1/$Totalhr1->total_role_id1)*100,2) }} %</h3>                    
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-user-tie"></i>
                  </div>                  
                </div>
              </div>

                <div class="col-md-4 col-3">
                  <div class="small-box bg-success">
                    <div class="inner">
                      <h5> ส่วนกลาง </h5>
                      <h3> {{ number_format(round($Totalhr2->total_role_id2)) }} คน</h3>
                      <h3> {{ round(($Totalhr2->total_role_id2/$Totalhr1->total_role_id1)*100,2) }} %</h3>                      
                    </div>
                    <div class="icon">
                      <i class="ion fas fa-user-tie"></i>
                    </div>                    
                  </div>
                </div>

              <div class="col-md-4 col-3">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h5> ส่วนภูมิภาค </h5>
                    <h3> {{ number_format(round($Totalhr3->total_role_id3)) }} คน</h3>                    
                    <h3> {{ round(($Totalhr3->total_role_id3/$Totalhr1->total_role_id1)*100,2) }} %</h3>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-user-tie"></i>
                  </div>                  
                </div>
              </div>
            </div>
            <br>
<!-- END HR  BOX --------------------------------------------------------->


<!-- START FILTER -------------------------------------------------------------->
        <!-- DATE START-END FILTER ------------------------------------------------------->
        <hr>
    <form method="post" action="{{ route('dashboard.hr') }}">
            @csrf
      
        <div class="row">
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">วันที่เริ่ม</label>
                  <input type="text" class="form-control" id="start_date" name="start_date">
                  <!-- <input type="text" class="form-control" id="start_date" name="start_date" value= "{{ Carbon::now()->toDateString() }}"> -->
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="">วันที่สิ้นสุด</label>
                  <input type="text" class="form-control" id="end_date" name="end_date">
                  <!-- <input type="text" class="form-control" id="end_date" name="end_date" value="{{ Carbon::now()->toDateString() }}"> -->
                </div>
              </div>
          <!-- END DATE START-END FILTER ------------------------------------------------>

          

          <!-- DROPDOWN FILTER --------------------------------------------------->          
          <div class="col-md-4">
              <div class="form-group">
                <label for="organization_type">ส่วนงานในสังกัด</label>
                <select class="form-control custom-select" id="organization_type" name="organization_type">
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
                <select id="organization" class="form-control select-organization" name="organization" data-live-search="true">
                   <option value="">------ กรุณาเลือก ------</option>
                </select>
              </div>
          </div>

          <!-- <div class="col-md-2">
              <div class="form-group">
                <label for="roles">กลุ่มภารกิจ </label>
                <select id="roles" class="form-control select-roles" name="roles" data-live-search="true">
                   <option value="">------ กรุณาเลือก ------</option>
                </select>
              </div>
          </div> -->
      </div>

      <div class="row">
            <div class="col-md-7">
              <div class="form-group float-right">
                <input type="submit" class="btn bg-gradient-success" value="ค้นหา">
                <a href="{{ route('dashboard.hr') }}" class="btn bg-gradient-warning">
                    Reset Filter
                <a>
              </div>
            </div>
        </div>
        <br>
      <hr>
<!-- END DROPDOWN FILTER --------------------------------------------------->

<!-- END FILTER ---------------------------------------------------------------->





        <!-- Graph 15 กลุ่มภารกิจ (จำนวนคน) -->
         <div class="row">
          <div class="col-xl-12 col-lg-7">            
              <div class="card shadow mb-4"> 
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">กลุ่มภารกิจ</h4>                                   
                  </div> 
                </div>               
                <div class="card-body">
                  <div id="chartContainer15" style="height: 370px; width: 100%;"></div>
                </div>
              </div>              
            </div>
          </div>
        <!-- end graph 15 -->

  
        <!-- Group 1 ข้อมูลเจ้าหน้าที่ -->
          <div class="row">
            <div class="col-xl-6 col-lg-6">            
              <div class="card card-primary card-outline card-outline-tabs mb-4">
                <div class="card-header p-0 border-bottom-0">
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ข้อมูลเจ้าหน้าที่</h4>                                    
                  </div>
                </div>   
                  <ul class="nav nav-tabs" id="custom-tabs-fourone-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-fourone-home-tab" data-toggle="pill" href="#custom-tabs-fourone-home" role="tab" aria-controls="custom-tabs-fourone-home" aria-selected="true"><i ></i> เพศ</a>
                    </li> 
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-fourtwo-profile-tab" data-toggle="pill" href="#custom-tabs-fourtwo-profile" role="tab" aria-controls="custom-tabs-fourtwo-profile" aria-selected="false"><i ></i> กลุ่มงาน</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-fourthree-profile-tab" data-toggle="pill" href="#custom-tabs-fourthree-profile" role="tab" aria-controls="custom-tabs-fourthree-profile" aria-selected="false"><i></i> ตำแหน่ง</a>
                    </li>
                                       
                  </ul>
                </div>

                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-fourone-tabContent">
                  <div class="tab-pane fade active show" id="custom-tabs-fourone-home" role="tabpanel" aria-labelledby="custom-tabs-fourone-home-tab">
                      <div class="card-body">
                        <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div> 
                    <div class="tab-pane fade" id="custom-tabs-fourtwo-profile" role="tabpanel" aria-labelledby="custom-tabs-fourtwo-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>                                       
                    <div class="tab-pane fade" id="custom-tabs-fourthree-profile" role="tabpanel" aria-labelledby="custom-tabs-fourthree-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>                    
                  </div>
                </div>
              </div>
            </div>            
        <!-- end ข้อมูลเจ้าหน้าที่ -->

          <!-- Group 2 ความสามารถทางภาษา -->
            <div class="col-xl-6 col-lg-6">               
              <div class="card card-primary card-outline card-outline-tabs mb-4">
                <div class="card-header p-0 border-bottom-0">
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ความสามารถทางภาษา</h4>                                    
                  </div>
                </div>   
                  <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true"><i ></i> อังกฤษ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><i ></i> จีน</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#custom-tabs-two-profile" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false"><i></i> ญี่ปุ่น</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"><i ></i> เกาหลี</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-five-profile-tab" data-toggle="pill" href="#custom-tabs-five-profile" role="tab" aria-controls="custom-tabs-five-profile" aria-selected="false"><i ></i> พม่า</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-six-profile-tab" data-toggle="pill" href="#custom-tabs-six-profile" role="tab" aria-controls="custom-tabs-six-profile" aria-selected="false"><i ></i> กัมพูชา</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-seven-profile-tab" data-toggle="pill" href="#custom-tabs-seven-profile" role="tab" aria-controls="custom-tabs-seven-profile" aria-selected="false"><i ></i> ฝรั่งเศส</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-eight-profile-tab" data-toggle="pill" href="#custom-tabs-eight-profile" role="tab" aria-controls="custom-tabs-eight-profile" aria-selected="false"><i ></i> สเปน</a>
                    </li>
                  </ul>
                </div>
                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                      <div class="card-body">
                        <div id="chartContainer6" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer7" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-two-profile" role="tabpanel" aria-labelledby="custom-tabs-two-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer8" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer9" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-five-profile" role="tabpanel" aria-labelledby="custom-tabs-five-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer10" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-six-profile" role="tabpanel" aria-labelledby="custom-tabs-six-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer11" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-seven-profile" role="tabpanel" aria-labelledby="custom-tabs-seven-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer12" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-eight-profile" role="tabpanel" aria-labelledby="custom-tabs-eight-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer13" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          <!-- end ความสามารถทางภาษา -->

          <!-- Group 3 ความสามารถอื่นๆ -->
          <div class="row">
            <div class="col-xl-6 col-lg-7">               
              <div class="card card-primary card-outline card-outline-tabs mb-4">
                <div class="card-header p-0 border-bottom-0">
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ความสามารถอื่นๆ</h4>                                    
                  </div>
                </div>   
                  <ul class="nav nav-tabs" id="custom-tabs-fouroneone-tab" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="custom-tabs-fouroneone-home-tab" data-toggle="pill" href="#custom-tabs-fouroneone-home" role="tab" aria-controls="custom-tabs-fouroneone-home" aria-selected="true"><i ></i> ความสามารถในการขับรถ</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="custom-tabs-fourtwotwo-profile-tab" data-toggle="pill" href="#custom-tabs-fourtwotwo-profile" role="tab" aria-controls="custom-tabs-fourtwotwo-profile" aria-selected="false"><i ></i> ผ่านหลักสูตรการฝึกอบรม</a>
                    </li>                    
                  </ul>
                </div>

                <div class="card-body">
                  <div class="tab-content" id="custom-tabs-fouroneone-tabContent">
                    <div class="tab-pane fade active show" id="custom-tabs-fouroneone-home" role="tabpanel" aria-labelledby="custom-tabs-fouroneone-home-tab">
                      <div class="card-body">
                        <div id="chartContainer5" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-fourtwotwo-profile" role="tabpanel" aria-labelledby="custom-tabs-fourtwotwo-profile-tab">
                      <div class="card-body">
                        <div id="chartContainer14" style="height: 370px; width: 100%;"></div>
                      </div>
                    </div> 
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end ความสามารถอื่นๆ -->

            <!-- Graph 1 -->
            <!-- <div class="col-xl-6 col-lg-7">            
              <div class="card shadow mb-4"> 
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ข้อมูลเจ้าหน้าที่ (แยกตามเพศ)</h4>                                   
                  </div> 
                </div>               
                <div class="card-body">
                  <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                </div>
              </div>              
            </div> -->
            <!-- end graph 1 -->

            <!-- Graph 2 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ข้อมูลเจ้าหน้าที่ (แยกตามกลุ่มงาน)</h4>                                    
                  </div> 
                </div>                
                <div class="card-body">
                  <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 2 -->

            <!-- Graph 3 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ข้อมูลเจ้าหน้าที่ (แยกตามตำแหน่ง)</h4>                                    
                  </div> 
                </div>                
                <div class="card-body">
                  <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 3 -->

            <!-- Graph 4 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ข้อมูลเจ้าหน้าที่ (แยกตามกล่องงาน)</h4>                                    
                  </div> 
                </div>                
                <div class="card-body">
                  <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 4 -->

            <!-- Graph 5 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ความสามารถในการขับรถ</h4>                                    
                  </div> 
                </div>                
                <div class="card-body">
                  <div id="chartContainer5" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 5 -->            

            <!-- Graph 6 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาอังกฤษ</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer6" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 6 -->

            <!-- Graph 7 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาจีน</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer7" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 7 -->

            <!-- Graph 8 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาญี่ปุ่น</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer8" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 8 -->

            <!-- Graph 9 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาเกาหลี</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer9" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 9 -->

            <!-- Graph 10 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาพม่า</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer10" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 10 -->

            <!-- Graph 11 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษากัมพูชา</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer11" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 11 -->

            <!-- Graph 12 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาฝรั่งเศษ</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer12" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 12 -->

            <!-- Graph 13 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
              <div class="card card-primary">              
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                  <h4 class="m-0 font-weight ">ความสามารถภาษาสเปน</h4>                                    
                </div> 
              </div>                
                <div class="card-body">
                  <div id="chartContainer13" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 13 -->

            <!-- Graph 14 -->
            <!-- <div class="col-xl-6 col-lg-7">
              <div class="card shadow mb-4">                
                <div class="card card-primary">              
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">                  
                    <h4 class="m-0 font-weight ">ผ่านหลักสูตรการฝึกอบรม</h4>                                    
                  </div> 
                </div>                
                <div class="card-body">
                  <div id="chartContainer14" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div> -->
            <!-- end graph 14 -->   

@stop
@section('custom-js-script')

<script src="{{ asset('js/canvasjs.min.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>


<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>




@stop('custom-js-script')
@section('custom-js-code')


<!-- เลือกวันที่ -->
<script>
          var today = new Date(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
          $('#start_date').datepicker({
          uiLibrary: 'bootstrap4',
          // modal: true,
          iconsLibrary: 'fontawesome',
          // minDate: today,
          format: 'yyyy-mm-dd',
          maxDate: function() {
          return $('#end_date').val();
          }
          });
          $('#end_date').datepicker({
          uiLibrary: 'bootstrap4',
          iconsLibrary: 'fontawesome',
          format: 'yyyy-mm-dd',
          minDate: function() {
            return $('#start_date').val();
          }
          });
          </script>



<script>

  $(function () {

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
})
});
// END DROPDOWN FILTER ------------------------------------------------------------->
</script>



                        <script>

                              window.onload = function () 
                              {



                              //FILTER DATE RANGE PICKER ---------------------------------------------------->

                                  $('#date_filter').daterangepicker();
                                  $('input[name="daterange1"]').daterangepicker();

                              //END FILTER DATE RANGE PICKER ------------------------------------------------>



                                    // graph 1 เพศ
                                    var chart1 = new CanvasJS.Chart("chartContainer1", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",                                         
                                          fontFamily: "Sarabun",
                                          fontSize: "25",      
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{
                                          minimum: 0
                                          // maximum: 90
                                        },
                                      data: [{
                                        // color: "#189AB4",                                        
                                        type: "doughnut",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                          
                                        dataPoints: <?php echo json_encode($graph1, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart1.render();
                                    // end graph 1

                                    // graph 2 กลุ่มงาน
                                    var chart2 = new CanvasJS.Chart("chartContainer2", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90
                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "doughnut",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%) ",
                                        indexLabel: "{label}: {y} คน (#percent%) ",                                                                                
                                        dataPoints: <?php echo json_encode($graph2, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart2.render();
                                    // end graph 2

                                    // graph 3 ตำแหน่ง
                                    var chart3 = new CanvasJS.Chart("chartContainer3", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90
                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "doughnut",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph3, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart3.render();
                                    // end graph 3

                                    // graph 5 ความสามารถในการขับรถ
                                    var chart5 = new CanvasJS.Chart("chartContainer5", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "doughnut",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph5, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart5.render();
                                    // end graph 5

                                    // graph 6 ความสามารถทางภาษาอังกฤษ
                                    var chart6 = new CanvasJS.Chart("chartContainer6", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph6, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart6.render();
                                    // end graph 6

                                    // graph 7 ความสามารถทางภาษาจีน
                                    var chart7 = new CanvasJS.Chart("chartContainer7", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph7, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart7.render();
                                    // end graph 7

                                    // graph 8 ความสามารถทางภาษาญี่ปุ่น
                                    var chart8 = new CanvasJS.Chart("chartContainer8", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph8, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart8.render();
                                    // end graph 8

                                    // graph 9 ความสามารถทางภาษาเกาหลี
                                    var chart9 = new CanvasJS.Chart("chartContainer9", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph9, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart9.render();
                                    // end graph 9

                                    // graph 10 ความสามารถทางภาษาพม่า
                                    var chart10 = new CanvasJS.Chart("chartContainer10", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph10, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart10.render();
                                    // end graph 10

                                    // graph 11 ความสามารถทางภาษากัมพูชา
                                    var chart11 = new CanvasJS.Chart("chartContainer11", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph11, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart11.render();
                                    // end graph 11

                                    // graph 12  ความสามารถทางภาษาฝรั่งเศส
                                    var chart12 = new CanvasJS.Chart("chartContainer12", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph12, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart12.render();
                                    // end graph 12

                                    // graph 13  ความสามารถทางภาษาสเปน
                                    var chart13 = new CanvasJS.Chart("chartContainer13", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph13, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart13.render();
                                    // end graph 13

                                    // graph 14 ผ่านหลักสูตรการฝึกอบรม
                                    var chart14 = new CanvasJS.Chart("chartContainer14", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "pie",
                                        startAngle: -90,                                         
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน (#percent%)",
                                        indexLabel: "{label}: {y} คน (#percent%)",                                                                                
                                        dataPoints: <?php echo json_encode($graph14, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart14.render();
                                    // end graph 14

                                    // graph 15 กลุ่มภารกิจ (จำนวนคน)
                                    var chart15 = new CanvasJS.Chart("chartContainer15", 
                                      {
                                        animationEnabled: true,
                                        exportEnabled: true,
                                        theme: "light1",                                         
                                        title: {
                                          text: "",
                                          fontFamily: "Sarabun",
                                          fontSize: "25", 
                                      },
                                      subtitles: [{
                                        text: "",
                                        fontFamily: "Sarabun",
                                        fontSize: "16",
                                      }],
                                        axisY:{                                          
                                          minimum: 0
                                          // maximum: 90                                          
                                        },
                                      data: [{
                                        // color: "#EF7C8E",                                        
                                        type: "bar",
                                        startAngle: -90,                  
                                        indexLabelFontColor: "#5A5757",
                                        indexLabelPlacement: "outside", 
                                        indexLabel: "{label} - #percent%",                                                                                
                                        toolTipContent: "<b>{label}</b>: {y} คน ",
                                        indexLabel: "{y} คน",                                                                               
                                        dataPoints: <?php echo json_encode($graph15, JSON_NUMERIC_CHECK); ?>
                                      }]
                                    });
                                    chart15.render();
                                    // end graph 15

                                    // graph 16 ช่วงอายุ
                                    // var chart16 = new CanvasJS.Chart("chartContainer16", 
                                    //   {
                                    //     animationEnabled: true,
                                    //     exportEnabled: true,
                                    //     theme: "light1",                                         
                                    //     title: {
                                    //       text: "",
                                    //       fontFamily: "Sarabun",
                                    //       fontSize: "25", 
                                    //   },
                                    //   subtitles: [{
                                    //     text: "",
                                    //     fontFamily: "Sarabun",
                                    //     fontSize: "16",
                                    //   }],
                                    //     axisY:{                                          
                                    //       minimum: 0
                                    //       maximum: 90                                          
                                    //     },
                                    //   data: [{
                                    //     color: "#EF7C8E",                                        
                                    //     type: "column",
                                    //     startAngle: -90,                  
                                    //     indexLabelFontColor: "#5A5757",
                                    //     indexLabelPlacement: "outside", 
                                    //     indexLabel: "{label} - #percent%",                                                                                
                                    //     toolTipContent: "<b>{label}</b>: {y} คน ",
                                    //     indexLabel: "{y} คน",                                                                               
                                    //     dataPoints: < ?php echo json_encode($graph16, JSON_NUMERIC_CHECK); ?>
                                    //   }]
                                    // });
                                    // chart16.render();
                                    // end graph 16

                                    

                                    

                                                        

                              }
                        </script>
@stop


