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
        <h1>ทีมผู้พัฒนาระบบ DDC-ECOSYSTEM</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<section class="content">
<body>
  <div id="wrapper">
            <div class="container-fluid">
                 <!-- <div class="page-title-box">
                    <div class="row align-items-center"> -->

              <div class="col-sm-6"><p><br>
						        <h5 class="text-success font-18 mt-0 mb-1">
                    <i class="mdi mdi-account-card-details text-success mdi-24px align-middle"></i>  Project Manager</h5>
              </div>

                      <!-- ***  เมนู Action *** -->
                      <!--<div class="col-sm-6">
                            <div class="float-right d-none d-md-block">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-settings mr-2"></i> Settings
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#">Separated link</a>
                                    </div>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>-->
                <!-- end row -->

                <!-- ***  start Project Manager *** -->
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/phat.jpg') }}"  width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i>  ว่าที่ ร.ต.สถาปัตย์ เด่นดวง</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success">Project Manager</i></p>
                                <!-- <div class="clearfix"></div> -->
                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/vit.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายวรวิทย์ พยุงเกียรติบวร</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ปฏิบัติการ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Co Project Manager</i></p>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                  </div>
                <!-- ***  End Project Manager *** -->

                <div class="col-sm-6"><p><br>
                      <h5 class="text-success font-18 mt-0 mb-1">
                      <i class="mdi mdi-account-card-details text-success mdi-24px align-middle"></i>  Data Visualization </h5>
                </div>

                <!-- ***  Start Data Visualization *** -->
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/por.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายศุภเสกย์ ทิพยาวงษ์</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Data Visualization</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/ae.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นางสาวคุณกัญญ์ศศิ พิมพขันธ์</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการสาธารณสุขปฏิบัติการ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> กองโรคไม่ติดต่อ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Data Visualization</i></p>

                            </div>

                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/new.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายธนดน พัฒนะโภไคย</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Data Visualization</i></p>
                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/kwang.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นางสาวศุภาพิชญ์ แคหอม</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Data Visualization</i></p>
                            </div>

                        </div>
                    </div>
                    <!-- end col -->


                    <div class="col-xl-4 col-md-6">
                         <div class="card directory-card">
                             <div class="card-body">
                                 <div class="float-left mr-3">
                                     <img src="{{ asset('team/jo.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                 </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายเสด็จ เบ้าทุมมา</h6>
                                     <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> เจ้าพนักงานคอมพิวเตอร์ <br>
                                     <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                     <i class="mdi mdi-briefcase-edit-outline text-success"> Data Visualization</i></p>

                             </div>

                         </div>
                     </div>
                     <!-- end col -->

                </div>
                <!-- ***  End Data Visualization *** -->

                <div class="col-sm-6"><p><br>
                      <h5 class="text-success font-18 mt-0 mb-1">
                      <i class="mdi mdi-account-card-details text-success mdi-24px align-middle"></i>  Programer </h5>
                </div>

                <!-- ***  Start Programer *** -->
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/lay.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายพุทธพงศ์ พุทธนาวงศ์</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/mod.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายสันทัด กงแก้ว</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>
                            </div>

                        </div>
                    </div>
                    <!-- end col -->

					         <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/nack.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายประพันธ์ ชูชะรา</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->


                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/naung.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นางสาวจันทร์เพ็ญ เอกมอญ</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/arm.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายเอกชาติ ทองเปลี่ยน</h6>
                                    <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                    <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                    <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

					         <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/sab.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายชาญวิทย์ อมรสุรินทวงศ์</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>
                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/care.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นางสาวรุ้งลาวัลย์ ตรงกะพงศ์</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>
                            </div>

                        </div>
                    </div>
                    <!-- end col -->


					          <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                    <img src="{{ asset('team/aon.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>

                                <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายนันทพล พุ่มไสว</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ปฏิบัติการ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                   <img src="{{ asset('team/goft.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>
                                <ul class="list-unstyled social-links float-right">

                                </ul>
                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายธนาธิป ดังพิมาย</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->

					          <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                   <img src="{{ asset('team/aum.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>
                                <ul class="list-unstyled social-links float-right">

                                </ul>
                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายสุทธา วัติรางกูล</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end col -->


                    <div class="col-xl-4 col-md-6">
                        <div class="card directory-card">
                            <div class="card-body">
                                <div class="float-left mr-3">
                                   <img src="{{ asset('team/keng.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                                </div>
                                <ul class="list-unstyled social-links float-right">

                                </ul>
                                 <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายสิริวัฒ แสงวรรณลอย</h6>
                                      <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> โปรแกรมเมอร์ <br>
                                      <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                      <i class="mdi mdi-briefcase-edit-outline text-success"> Programer</i></p>

                            </div>

                        </div>
                    </div>
                    <!-- end row -->
                </div>
                <!-- ***  Start Programer *** -->


                <div class="col-sm-6"><p><br>
                      <h5 class="text-success font-18 mt-0 mb-1">
                      <i class="mdi mdi-account-card-details text-success mdi-24px align-middle"></i>  System Admin </h5>
                </div>

                <!-- ***  System Admin *** -->
                <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="card directory-card">
                        <div class="card-body">
                            <div class="float-left mr-3">
                               <img src="{{ asset('team/plam.jpg') }}" width="100" alt="" class="img-fluid img-thumbnail rounded-circle thumb-lg">
                            </div>
                            <ul class="list-unstyled social-links float-right">

                            </ul>
                             <h6 class="text-primary font-12 mt-0 mb-1"><i class="mdi mdi-account"></i> นายอัษฎางค์ โชติมัย</h6>
                                  <p class="font-12 mb-2"><i class="mdi mdi-bulletin-board text-primary"></i> นักวิชาการคอมพิวเตอร์ <br>
                                  <i class="mdi mdi-map-marker-radius text-success"></i> ศูนย์สารสนเทศ <br>
                                  <i class="mdi mdi-briefcase-edit-outline text-success"> System Admin</i></p>

                        </div>

                    </div>
                </div>
                <!-- end row -->

                </div>
                <!-- ***  End System Admin *** -->

            </div>
            <!-- end container-fluid -->
</div>
</body>

</section>
@endsection
@section('custom-js-script')
@stop
@section('custom-js-code')
@stop
