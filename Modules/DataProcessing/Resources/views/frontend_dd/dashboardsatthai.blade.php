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
            <h3 class="m-0 text-dark">สถานการณ์โรคโควิด ไทย</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <h3 style="font-size: 28px" > ข้อมูล ณ วันที่ {{ CmsHelper::formatDateThai(date( $Totalthai->UpdateDate )) }} </h3>
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
                    <h3> {{ number_format(round($Totalthai->TotalCases)) }} คน<sup style="font-size: 20px"> + {{ number_format(round($Totalthai->NewCases)) }} </sup></h3>
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
                      <h3> {{ number_format(round($Totalthai->TotalDeaths)) }} คน<sup style="font-size: 20px"> + {{ number_format(round($Totalthai->NewDeaths)) }} </sup></h3>
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
                    <h3>  {{ number_format(round($Totalthai->TotalRecovered)) }} คน<sup style="font-size: 20px"> </sup></h3>
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
                    <h3> {{ number_format(round($Totalthai->ActiveCase)) }} คน </h3>
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
            <div class="col-md-12">
              <div class="card card-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark">ผู้ป่วยยืนยันจำแนกรายจังหวัด</h6>
                </div>
                <div class="card-body">
                  <div id="chartContainer5" style="height:250px; width: 100%;"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- END GRAPH 5 ---------------------------------------------------->

          <!-- START MAP THAI -------------------------------------------------------------------->
          <div class="row">
              <div class="col-md-8">
                <div class="card card-danger">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h5 class="m-1 font-weight-bold text-dark">ผู้ป่วยกำลังรักษาในประเทศไทย</h5>
                  </div>
                  <div class="card-body" style="height: 835px; width: 100%;">

              <!-- START EMBED ARCGIS THAI PUBLIC ----------------------------------------------->
              <style>
              .embed-container {position: relative; padding-bottom: 0; height: 100%; max-width: 100%;} .embed-container
              iframe, .embed-container object, .embed-container iframe{position: absolute; top: 0; left: 0; width: 100%; height: 100%;}
              small{position: absolute; z-index: 40; bottom: 0; margin-bottom: -15px;}
              </style>

              <div
              class="embed-container"><iframe width="0" height="0" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
              title="pui_nCoV-2019 (WorldOMeters)" src="//ddcportal.ddc.moph.go.th/portal/apps/Embed/index.html?webmap=4154cbf5a33b407da5c50e3a549ff5cc&extent=86.6749,4.944,115.503,20.7004&home=true&zoom=true&previewImage=false&scale=false&legendlayers=true&disable_scroll=true&theme=light"></iframe>
              </div>
              <!-- END EMBED ARCGIS THAI PUBLIC ----------------------------------------------->

                  </div>
                </div>
              </div>
          <!-- END MAP THAI ------------------------------------------------------------------------------->

              <!-- GRAPH 4 -------------------------------------------------------->
                <div class="col-md-4">
                  <div class="card card-danger">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-dark">สถานพยาบาลที่ผู้ป่วยกำลังรักษา</h6>
                    </div>
                    <div class="card-body">
                      <div id="chartContainer4" style="height: 350px; width: 100%;"></div>
                    </div>
                  </div>
              <!-- END GRAPH 4 ---------------------------------------------------->

              <!-- GRAPH 3 -------------------------------------------------------->
                  <div class="card card-danger">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                      <h6 class="m-0 font-weight-bold text-dark">สถานะผู้ป่วย</h6>
                    </div>
                    <div class="card-body">
                      <div id="chartContainer3" style="height: 350px; width: 100%;"></div>
                    </div>
                  </div>
              <!-- END GRAPH 3 ---------------------------------------------------->
                </div>
          </div>

          <!-- GRAPH 1 -------------------------------------------------------->
          <div class="row">
            <div class="col-md-6">
              <div class="card card-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-dark">ผู้ป่วยจำแนกตามเพศ</h6>
                </div>
                <div class="card-body">
                  <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
                </div>
              </div>
            </div>
          <!-- END GRAPH 1 ---------------------------------------------------->

          <!-- GRAPH 2 -------------------------------------------------------->
          <div class="col-md-6">
            <div class="card card-danger">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-dark">ผู้ป่วยจำแนกตามสัญชาติ</h6>
              </div>
              <div class="card-body">
                <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
              </div>
            </div>
          </div>
          <!-- END GRAPH 2 ---------------------------------------------------->
          </div>

          <!-- DYNAMIC GRAPH 6 ---------------------------------------------------->
          <div class="row">
              <div class="col-md-12">
                <div class="card card-danger">
                  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-dark">TimeSerie COVID-19</h3>
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

<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.stock.min.js"></script>

@stop('custom-js-script')


<!-- JS ----------------------------------------------------------------------->
@section('custom-js-code')


<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script>
              window.onload = function ()
              {

                // GRAPH 5 ---------------------------------------------------->
                var chart5 = new CanvasJS.Chart("chartContainer5",
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
                    color: "#ffc107",
                    type: "column",
                    startAngle: -90,
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph5, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart5.render();
                // END GRAPH 5 ------------------------------------------------>


                // GRAPH 1 ---------------------------------------------------->
                var chart1 = new CanvasJS.Chart("chartContainer1",
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
                    // color: "#189AB4",
                    type: "column",
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph1, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart1.render();
                // END GRAPH 1 ------------------------------------------------>


                // GRAPH 2 ---------------------------------------------------->
                var chart2 = new CanvasJS.Chart("chartContainer2",
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
                chart2.render();
                // END GRAPH 2 ------------------------------------------------>


                // GRAPH 3 ---------------------------------------------------->
                var chart3 = new CanvasJS.Chart("chartContainer3",
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
                    startAngle: -90,
                    toolTipContent: "<b>{label}</b>: {y} คน",
                    indexLabel: " {y} คน",
                    dataPoints: <?php echo json_encode($graph3, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart3.render();
                // END GRAPH 3 ------------------------------------------------>


                // GRAPH 4 ---------------------------------------------------->
                var chart4 = new CanvasJS.Chart("chartContainer4",
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
                    toolTipContent: "<b>กำลังรักษา</b>: {y} คน",
                    dataPoints: <?php echo json_encode($graph4, JSON_NUMERIC_CHECK); ?>
                  }]
                });
                chart4.render();

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
                var chart6 = new CanvasJS.Chart("chartContainer6",
                  {
                    animationEnabled: true,
                    exportEnabled: true,
                    theme: "light2",
                    title:{
                      text: "Thai Timeseries",
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
                      itemclick: toggleDataSeries
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
                    toolTipContent: "<b>กำลังรักษา</b>: {y} คน",
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

              chart6.render();

              function toggleDataSeries(e){
              	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              		e.dataSeries.visible = false;
              	}
              	else{
              		e.dataSeries.visible = true;
              	}
              chart6.render();
              }
                // END DYNAMIC GRAPH 6 ---------------------------------------->


                // START STOCKCHART GRAPH 7 ---------------------------------------------->


                  // var dataPoints1 = [], dataPoints2 = [], dataPoints3 = [];
                  // var stockChart7 = new CanvasJS.StockChart("chartContainer7",{
                  //   theme: "light2",
                  //   animationEnabled: true,
                  //   exportEnabled: true,
                  //   title:{
                  //     text:"Timeseries Range",
                  //     fontSize: 18
                  //   },
                  //   subtitles: [{
                  //     text: "",
                  //     fontSize: 14
                  //   }],
                  //   charts: [{
                  //     axisY: {
                  //       title: ""
                  //     },
                  //     toolTip: {
                  //       shared: true
                  //     },
                  //     legend: {
                  //           cursor: "pointer",
                  //           itemclick: function (e) {
                  //             if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible)
                  //               e.dataSeries.visible = false;
                  //             else
                  //               e.dataSeries.visible = true;
                  //             e.chart.render();
                  //           }
                  //         },
                  //
                  //           data: [{
                  //           color: "#f0a637",
                  //           type: "area",
                  //           name: "Confirmed",
                  //           showInLegend: "true",
                  //           toolTipContent: "<b>ผู้ป่วยยืนยัน</b>: {y} คน",
                  //           indexLabel: "",
                  //           dataPoints: <?php //echo json_encode($graph7_1, JSON_NUMERIC_CHECK); ?>
                  //         },
                  //         {
                  //           color: "#0ba2e3",
                  //           type: "area",
                  //           name: "Recovered",
                  //           showInLegend: "true",
                  //           toolTipContent: "<b>รักษาหาย</b>: {y} คน",
                  //           indexLabel: "",
                  //           dataPoints: <?php //echo json_encode($graph7_2, JSON_NUMERIC_CHECK); ?>
                  //         },
                  //         {
                  //           color: "#f76d98",
                  //           type: "area",
                  //           name: "ActiveCase",
                  //           showInLegend: "true",
                  //           toolTipContent: "<b>กำลังรักษา</b>: {y} คน",
                  //           indexLabel: "",
                  //           dataPoints: <?php //echo json_encode($graph6_3, JSON_NUMERIC_CHECK); ?>
                  //         },
                  //         {
                  //           toolTipContent: "<b>วันที่อัพเดต</b>: {y} ",
                  //           indexLabel: "",
                  //           dataPoints: <?php //echo json_encode($graph6_4, JSON_NUMERIC_CHECK); ?>
                  //         }]
                  //   }],
                  //   rangeSelector: {
                  //     enabled: false
                  //   },
                  //   navigator: {
                  //     data: [{
                  //       dataPoints: graph7_1
                  //     }
                  //   ],
                  //     // slider: {
                  //     //   minimum: new Date(2018, 02, 01),
                  //     //   maximum: new Date(2018, 03, 30)
                  //     // }
                  //   }
                  // });
                  // stockChart7.render();




                // END STOCKCHART GRAPH 7 ------------------------------------------------>


// START STOCKCHART GRAPH 7 DEMO ---------------------------------------------->

  //
  // var dataPoints1 = [], dataPoints2 = [], dataPoints3 = [];
  // var stockChart7 = new CanvasJS.StockChart("chartContainer7",{
  //   theme: "light2",
  //   animationEnabled: true,
  //   exportEnabled: true,
  //   title:{
  //     text:"Timeseries Range",
  //     fontSize: 18
  //   },
  //   subtitles: [{
  //     text: "",
  //     fontSize: 14
  //   }],
  //   charts: [{
  //     axisY: {
  //       title: ""
  //     },
  //     toolTip: {
  //       shared: true
  //     },
  //     legend: {
  //           cursor: "pointer",
  //           itemclick: function (e) {
  //             if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible)
  //               e.dataSeries.visible = false;
  //             else
  //               e.dataSeries.visible = true;
  //             e.chart.render();
  //           }
  //       },
  //     data: [{
  //       color: "#f0a637",
  //       type: "area",
  //       showInLegend: true,
  //       name: "Confirmed",
  //       yValueFormatString: "#,##0",
  //       xValueType: "dateTime",
  //       dataPoints : dataPoints1
  //     },{
  //       color: "#0ba2e3",
  //       type: "area",
  //       showInLegend: true,
  //       name: "Recovered",
  //       yValueFormatString: "#,##0",
  //       dataPoints : dataPoints2
  //     },
  //     {
  //       color: "#FF004D",
  //       type: "line",
  //       showInLegend: true,
  //       name: "ActiveCase",
  //       yValueFormatString: "#,##0",
  //       dataPoints : dataPoints3
  //     }]
  //   }],
  //   rangeSelector: {
  //     enabled: false
  //   },
  //   navigator: {
  //     data: [{
  //       dataPoints: dataPoints1
  //     }
  //   ],
  //     slider: {
  //       minimum: new Date(2018, 02, 01),
  //       maximum: new Date(2018, 03, 30)
  //     }
  //   }
  // });
  // stockChart7.render();
  //
  // $.getJSON("https://canvasjs.com/data/docs/btcvolume2018.json", function(data) {
  //   for(var i = 0; i < data.length; i++){
  //     dataPoints1.push({x: new Date(data[i].date), y: Number(data[i].volume_btc_usd)});
  //     dataPoints2.push({x: new Date(data[i].date), y: Number(data[i].volume_btc_eur)});
  //     dataPoints3.push({x: new Date(data[i].date), y: Number(data[i].volume_btc_gbp)});
  //   }
  //   stockChart7.render();
  // });


// END STOCKCHART GRAPH 7 DEMO ------------------------------------------------>









              }
        </script>

@stop('custom-js-code')
