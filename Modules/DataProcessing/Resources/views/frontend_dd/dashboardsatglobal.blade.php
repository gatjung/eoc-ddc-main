<?php
use App\CmsHelper as CmsHelper;
?>

@extends('dataprocessing::layouts.master')

<!-- CSS ------------------------------------------------------------------->
@section('custom-css')
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css') }}">
@stop('custom-css')

@section('content')

<!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">สถานการณ์โรคโควิด ทั่วโลก</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <h3 style="font-size: 28px" > ข้อมูล ณ วันที่ {{ CmsHelper::formatDateThai(date( $totalglobal->UpdateDate )) }} </h3>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->

<!-- START CONTENT  BOX ------------------------------------------------------->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-md-3 mx-auto">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3> {{ number_format(round($totalglobal->TotalCases)) }}  คน <sup style="font-size: 20px"> + {{  number_format(round($totalglobal->NewCases)) }} </sup></h3>
                    <p> Total Confirmed </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-temperature-high"></i>
                  </div>
                  <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>

                <div class="col-md-3 mx-auto">
                  <div class="small-box bg-purple">
                    <div class="inner">
                      <h3> {{  number_format(round($totalglobal->TotalDeaths)) }} คน<sup style="font-size: 20px"> + {{  number_format(round($totalglobal->NewDeaths)) }} </sup></h3>
                      <p> Total Deaths </p>
                    </div>
                    <div class="icon">
                      <i class="ion fas fa-skull-crossbones"></i>
                    </div>
                    <!-- <a class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                  </div>
                </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3> {{  number_format(round($totalglobal->TotalRecovered)) }} คน<sup style="font-size: 20px"> </sup></h3>
                    <p> Total Recovered </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-home"></i>
                  </div>
                  <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>

              <div class="col-md-3 mx-auto">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{  number_format(round($totalglobal->ActiveCase)) }} คน</h3>
                    <p> Total Active Case </p>
                  </div>
                  <div class="icon">
                    <i class="ion fas fa-bed"></i>
                  </div>
                  <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
              </div>
            </div>
            <br>
<!-- END CONTENT  BOX --------------------------------------------------------->

<!-- START AREA CHART --------------------------------------------------------->

          <!-- GRAPH 5 -------------------------------------------------------->
          <div class="row">
            <div class="col-md-12 mx-auto">
              <div class="card card-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark"> Country Status : Total Confirmed </h6>
                </div>
                <div class="card-body">
                  <div id="chartContainer5" style="height:250px; width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- END GRAPH 5 ---------------------------------------------------->

          <!-- START MAP GLOBAL ------------------------------------------------->
          <div class="row">
                <div class="col-md-8 mx-auto">
                  <div class="card card-danger">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h5 class="m-1 font-weight-bold text-dark">Global Map COVID-19</h5>
                    </div>
                    <div class="card-body" style="height: 835px; width: 100%;">

                <!-- START EMBED ARCGIS GLOBAL PUBLIC ----------------------------------------------->
                <style>
                .embed-container {position: relative; padding-bottom: 0; height: 100%; max-width: 100%;} .embed-container
                iframe, .embed-container object, .embed-container iframe{position: absolute; top: 0; left: 0; width: 100%; height: 100%;}
                small{position: absolute; z-index: 40; bottom: 0; margin-bottom: -15px;}
                </style>

                <div
                class="embed-container"><iframe width="0" height="0" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                title="nCoV-2019 (WorldOMeters)" src="//ddcportal.ddc.moph.go.th/portal/apps/Embed/index.html?webmap=89cfb3ba03fd48b1b6497580fd767df5&extent=-47.022,-38.1255,180,65.8794&home=true&zoom=true&previewImage=false&scale=false&legendlayers=true&disable_scroll=true&theme=light"></iframe>
                </div>
                <!-- END EMBED ARCGIS GLOBAL PUBLIC ----------------------------------------------->

                    </div>
                  </div>
                </div>
          <!-- END MAP GLOBAL --------------------------------------------------->

              <!-- GRAPH 1 -------------------------------------------------------->
                <div class="col-md-4 mx-auto">
                  <div class="card card-danger">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-dark"> Daily Status : NewCase </h6>
                    </div>
                    <div class="card-body">
                      <div id="chartContainer1" style="height: 350px; width: 100%;"></div>
                    </div>
                  </div>
              <!-- END GRAPH 1 ---------------------------------------------------->

              <!-- GRAPH 2 -------------------------------------------------------->
                <div class="card card-danger">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark"> Daily Status : ActiveCases </h6>
                  </div>
                  <div class="card-body">
                    <div id="chartContainer2" style="height: 350px; width: 100%;"></div>
                  </div>
                </div>
              <!-- END GRAPH 2 ---------------------------------------------------->
                </div>
          </div>

          <!-- GRAPH 3 -------------------------------------------------------->
        <div class="row">
          <div class="col-md-6 mx-auto">
            <div class="card card-danger">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark"> Compare of Patients : Total </h6>
              </div>
              <div class="card-body">
                <div class="chart">
                <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- END GRAPH 3 ---------------------------------------------------->

          <!-- GRAPH 4 -------------------------------------------------------->
            <div class="col-md-6 mx-auto">
              <div class="card card-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark"> Country Status : Total Deaths  </h6>
                </div>
                <div class="card-body">
                  <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div>
          <!-- END GRAPH 4 ---------------------------------------------------->
        </div>

          <!-- DYNAMIC GRAPH 6 ---------------------------------------------------->
          <div class="row">
              <div class="col-md-12 mx-auto">
                <div class="card card-danger">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">TimeSeries COVID-19</h3>
                  </div>
                  <div class="card-body">
                    <div class="chart">
                      <div id="chartContainer6" style="height: 350px; width: 100%;"></div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <!-- END DYNAMIC GRAPH 6 ------------------------------------------>

        </div>
      </section>
<!-- END AREA CHART ----------------------------------------------------------->



<!-- START TABLE LIST --------------------------------------------------------->
        <!-- <section class="content">
          <div class="card">
              <div class="card card-gray">
              <div class="card-header">
                <h3 class="card-title"> ตารางสรุปข้อมูลนักวิจัย </h3>
              </div>
              </div>

              <div class="card-body">
              <div class="table-responsive">
                    <table  id="example1" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th style="text-align:center"> ลำดับที่ </th>
                            <th style="text-align:center"> รหัสโครงการ </th>
                            <th style="text-align:center"> ชื่อโครงการ </th>
                            <th style="text-align:center"> การนำไปใช้ประโยชน์ </th>
                            <th style="text-align:center"> สถานะการตรวจสอบ </th>
                            <th class="text-right"> จัดการข้อมูล </th>
                        </tr>
                    </thead>

                    <tbody> -->
  <!-- @*foreach( $datas as $value ) -->
                        <!-- <tr>
                            <td  style="text-align:center">
                                    1
                            </td>
                            <td  style="text-align:center">
                                    PRO_01
                            </td>
                            <td>
                                <a>
                                    โครงการ ก
                                </a>
                                <br/>
                                <small>
                                    Project A
                                </small>
                            </td>
                            <td  style="text-align:center">
                              <a>
                                    เชิงวิชาการ
                              </a>
                            </td>
                            <td class="project-state text-center">
                                <span class="badge badge-warning">รอการอนุมัติ</span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="#">
                                  <i class="fas fa-folder"></i>
                                    VIEW
                                </a>
                                <a class="btn btn-danger btn-sm" href="#">
                                  <i class="fas fa-edit"></i>
                                    EDIT
                                </a>
                                <a class="btn btn-success btn-sm" href="#">
                                  <i class="fas fa-paperclip"></i>
                                    VERIFIED
                                </a>
                            </td>
                        </tr> -->
<!-- @*endforeach -->
                    <!-- </tbody>
                </table> -->
              <!-- </div>
            </div>
            </div>
            </div>
          </section> -->

<!-- END TABLE LIST ----------------------------------------------------------->

@stop('content')


<!-- SCRIPT ------------------------------------------------------------------->
@section('custom-js-script')
@stop('custom-js-script')


<!-- JS ----------------------------------------------------------------------->
@section('custom-js-code')


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
              window.onload = function ()
              {

                // GRAPH 5 ---------------------------------------------------->
                var graph5 = new CanvasJS.Chart("chartContainer5",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title: {
                      text: ""
                  },
                  subtitles: [{
                    text: ""
                  }],
                    axisY:{
                      minimum: 0
                      // maximum: 90
                    },
                  data: [{
                    color: "#FFD700",
                    type: "column",
                    startAngle: -90,
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph5, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                graph5.render();
                // END GRAPH 5 ------------------------------------------------>


                // GRAPH 1 ---------------------------------------------------->
                var graph1 = new CanvasJS.Chart("chartContainer1",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title: {
                      text: ""
                  },
                  subtitles: [{
                    text: ""
                  }],
                    axisY:{
                      minimum: 0
                      // maximum: 90
                    },
                  data: [{
                    type: "line",
                    color: "#DC143C",
                    startAngle: 90,
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph1, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                graph1.render();
                // END GRAPH 1 ------------------------------------------------>


                // GRAPH 2 ---------------------------------------------------->
                var graph2 = new CanvasJS.Chart("chartContainer2",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title: {
                      text: ""
                  },
                  subtitles: [{
                    text: ""
                  }],
                    axisY:{
                      minimum: 0
                      // maximum: 90
                    },
                  data: [{
                    type: "bar",
                    color: "#189AB4",
                    startAngle: -90,
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph2, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                graph2.render();
                // END GRAPH 2 ------------------------------------------------>


                // GRAPH 3 ---------------------------------------------------->
                var graph3 = new CanvasJS.Chart("chartContainer3",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title:{
                      text: "",
                      fontSize: 18
                    },
                    subtitles: [{
                      text: "",
                      fontSize: 14
                    }],
                    axisY: {
                      prefix: ""
                    },
                    legend:{
                      cursor: "pointer",
                      itemclick: toggleDataSeries1
                    },
                    toolTip: {
                      shared: true
                    },
                  data: [{
                    color: "#0ba2e3",
                    type: "splineArea",
                    name: "Total Recovered",
                    showInLegend: "true",
                    toolTipContent: "<b>รักษาหาย</b>: {y} คน",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph3_1, JSON_NUMERIC_CHECK); ?>
                  },
                  {
                    color: "#f0a637",
                    type: "splineArea",
                    name: "Total Confirmed",
                    showInLegend: "true",
                    toolTipContent: "<b>ผู้ป่วยยืนยัน</b>: {y} คน",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph3_2, JSON_NUMERIC_CHECK); ?>
                  }
                ]
              });

              graph3.render();

              function toggleDataSeries1(e){
              	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              		e.dataSeries.visible = false;
              	}
              	else{
              		e.dataSeries.visible = true;
              	}
              graph3.render();
              }
                // END GRAPH 3 ------------------------------------------------>


                // GRAPH 4 ---------------------------------------------------->
                var graph4 = new CanvasJS.Chart("chartContainer4",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title: {
                      text: ""
                    },
                    subtitles: [{
                      text: ""
                    }],
                    legend:{
                		cursor: "pointer",
                		itemclick: explodePie
              	    },
                    data: [{
                    // color: "#59981A",
                    type: "doughnut",
                    startAngle: -90,
		                showInLegend: true,
                    legendText: "{label}",
                    indexLabelFontSize: 14,
                    indexLabel: "{label} - #percent%",
                    toolTipContent: "<b>ผู้เสียชีวิต</b>: {y} คน",
                    dataPoints: <?php echo json_encode($graph4, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                graph4.render();

                function explodePie (e) {
                	if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
                		e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
                	} else {
                		e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
                	}
                	e.chart.render();
                }
                // END GRAPH 4 ------------------------------------------------>


                // START DYNAMIC GRAPH 6 ---------------------------------------->
                var graph6 = new CanvasJS.Chart("chartContainer6",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title:{
                      text: "Global Timeseries",
                      fontSize: 16
                    },
                    subtitles: [{
                      text: "",
                      fontSize: 12
                    }],
                    axisY: {
                      prefix: ""
                    },
                    legend:{
                      cursor: "pointer",
                      itemclick: toggleDataSeries2
                    },
                    toolTip: {
                      shared: true
                    },
                  data: [{
                    color: "#f0a637",
                    type: "area",
                    name: "Confirmed",
                    showInLegend: "true",
                    toolTipContent: "<b>ผู้ป่วยยืนยัน</b>: {y} คน",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph6_1, JSON_NUMERIC_CHECK); ?>
                  },
                  {
                    color: "#0ba2e3",
                    type: "area",
                    name: "Recovered",
                    showInLegend: "true",
                    toolTipContent: "<b>รักษาหาย</b>: {y} คน",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph6_2, JSON_NUMERIC_CHECK); ?>
                  },
                  {
                    color: "#f76d98",
                    type: "area",
                    name: "ActiveCase",
                    showInLegend: "true",
                    toolTipContent: "<b>รักษาหาย</b>: {y} คน",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph6_3, JSON_NUMERIC_CHECK); ?>
                  },
                  {
                    toolTipContent: "<b>วันที่อัพเดต</b>: {y} ",
                    indexLabel: "",
                    dataPoints: <?php echo json_encode($graph6_4, JSON_NUMERIC_CHECK); ?>
                  }
                ]
              });
              graph6.render();

              function toggleDataSeries2(e){
              	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              		e.dataSeries.visible = false;
              	}
              	else{
              		e.dataSeries.visible = true;
              	}
              graph6.render();
              }
                // END DYNAMIC GRAPH 6 ---------------------------------------->


              }
        </script>

@stop('custom-js-code')
