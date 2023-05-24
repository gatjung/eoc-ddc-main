<?php
use App\CmsHelper as CmsHelper;
use Carbon\Carbon as Carbon;
?>

@extends('dataprocessing::layouts.master')

<!-- CSS ------------------------------------------------------------------->
@section('custom-css')

<!-- Select2 -->
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.css') }}">
<!-- Progress Step -->
<link rel="stylesheet" href="{{ asset('Lay/css/progress_step.css') }}">

<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

@stop('custom-css')

@section('content')


<!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>แดชบอร์ด Task</h1>
          </div>
          <div class="col">
            <ol class="breadcrumb float-sm-right">

            </ol>
          </div>
        </div>
      </div>
    </div>
<!-- /.content-header -->

<section class="content">
  <div class="container-fluid">



<!-- START CONTENT  BOX ------------------------------------------------------->
        <div class="row">
          <!-- <div class="col-md-2 mx-auto">
            <div class="small-box bg-primary">
              <div class="inner"> -->
                <!-- เรียกจาก task_order (Status)---------------------------------------->
                <!-- <h3> 0 งาน </h3>
                <br>
                <p>งานสำคัญเร่งด่วน</p> <br>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation-circle"></i>
              </div>
            </div>
          </div> -->

          <div class="col-md-2 mx-auto">
            <div class="small-box bg-secondary">
              <div class="inner">
                <!-- เรียกจาก task_assign (All Record)---------------------------------------->
                <h3> {{ empty($Totaltask_order)?'0': $Totaltask_order }} งาน </h3>
                <br>
                <p>งานตามคำสั่งการ <br>(ยังไม่มอบหมายบุคคล)</p>
              </div>
              <div class="icon">
                <i class="fas fa-battery-empty"></i>
              </div>
            </div>
          </div>

          <div class="col-md-2 mx-auto">
            <div class="small-box bg-warning">
              <div class="inner">
                <!-- เรียกจาก task_assign (All Record)---------------------------------------->
                <h3> {{ empty($Totaltask_assign)?'0': $Totaltask_assign }} งาน </h3>
                <br>
                <p>งานที่มอบหมายแล้ว <br>(อยู่ในระหว่างดำเนินงาน)</p>
              </div>
              <div class="icon">
                <i class="fas fa-battery-half"></i>
              </div>
            </div>
          </div>

          <div class="col-md-2 mx-auto">
            <div class="small-box bg-danger">
              <div class="inner">
                <!-- เรียกจาก task_assign (เกินจาก end_at)---------------------------------------->
                <h3> {{ empty($Totaltask_overdue)?'0': $Totaltask_overdue }} งาน </h3>
                <br>
                <p>งานที่เกินกำหนด</p> <br>
              </div>
              <div class="icon">
                <i class="fas fa-fire"></i>
              </div>
            </div>
          </div>

          <div class="col-md-3 mx-auto">
            <div class="small-box bg-success">
              <div class="inner">
                <!-- เรียกจาก task_sub (Status)---------------------------------------->
                <h3> {{ empty($Totaltask_complete)?'0': $Totaltask_complete }} งาน </h3>
                <!-- <h3>99 !!</h3> -->
                <br>
                <p>ดำเนินงานเสร็จสิ้น</p> <br>
              </div>
              <div class="icon">
                <i class="fas fa-battery-full"></i>
              </div>
            </div>
          </div>

          <div class="col-md-3 mx-auto">
            <div class="small-box bg-info">
              <div class="inner">
                <!-- Sum ทุกกล่อง หรือ read_status ทั้งหมด ------------------------------>
                <h3> {{ empty($Totaltask_summary)?'0': $Totaltask_summary }} งาน </h3>
                <br>
                <p>งานทั้งหมด</p> <br>
              </div>
              <div class="icon">
                <i class="fas fa-cubes"></i>
              </div>
            </div>
          </div>
        </div>
<!-- END CONTENT  BOX --------------------------------------------------------->



<!-- START FILTER -------------------------------------------------------------->
        <!-- DATE START-END FILTER ------------------------------------------------------->
    <form method="post" action="{{ route('dashboard.task') }}">
            @csrf
        <div class="row">
              <div class="col-md-2 mx-auto">
                <div class="form-group">
                  <label for="">เริ่ม</label>
                  <input type="text" class="form-control" id="start_date" name="start_date" value= "{{ Carbon::now()->toDateString() }}">
                </div>
              </div>
              <div class="col-md-2 mx-auto">
                <div class="form-group">
                  <label for="">สิ้นสุด</label>
                  <input type="text" class="form-control" id="end_date" name="end_date" value="{{ Carbon::now()->toDateString() }}">
                </div>
              </div>
          <!-- END DATE START-END FILTER ------------------------------------------------>


          <!-- DROPDOWN FILTER --------------------------------------------------->
          <div class="col-md-2 mx-auto">
              <div class="form-group">
                <label for="organization_type">ส่วนงานในสังกัด</label>
                <select class="form-control custom-select" id="organization_type" name="organization_type">
                    <option value="">กรุณาเลือก</option>
                    @foreach($organization_type as $key_division_part => $value_division_part)
                        <option value="{{ $key_division_part }}"> {{ $value_division_part }} </option>
                    @endforeach
                </select>
              </div>
          </div>

          <div class="col-md-3 mx-auto">
              <div class="form-group">
                <label for="organization">หน่วยงาน</label>
                <select id="organization" class="form-control select-organization" name="organization" data-live-search="true">
                   <option value="">กรุณาเลือก</option>
                </select>
              </div>
          </div>

          <div class="col-md-3 mx-auto">
              <div class="form-group">
                <label for="roles">กล่องภารกิจ </label>
                <select id="roles" class="form-control select-roles" name="roles" data-live-search="true">
                   <option value="">กรุณาเลือก</option>
                </select>
              </div>
          </div>
        </div>

        <div class="row">
            <div class="col-md-12">
              <div class="form-group float-right">
                <input type="submit" class="btn bg-gradient-primary" value="ค้นหา">
                <a href="{{ route('dashboard.task') }}" class="btn bg-gradient-green">
                    Reset Filter
                <a>
              </div>
            </div>
        </div>
    </form>
        <!-- END DROPDOWN FILTER --------------------------------------------------->
        <br>
<!-- END FILTER ---------------------------------------------------------------->



<!-- START AREA CHART --------------------------------------------------------->
        <!-- TABLE TASK ------------------------------------------------------->
        <!-- ความสำเร็จของงานที่ได้รับมอบหมาย -->
        <div class="row">
          <div class="col-md-6 mx-auto">
            <div class="card card-widget widget-user-2">
              <div class="widget-user-header bg-orange">
                <h5 class="m-1 font-weight-bold text-dark">ความสำเร็จของงานที่ได้รับมอบหมาย</h5>
                <h6 class="m-1 font-weight-bold text-dark">กรณีโรคติดเชื้อไวรัสโคโรนา 2019 (COVID-19)</h6>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <?php $i = 1; ?>
                  @foreach($hr_groupteam as $val)
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <div class="progress-group">
                          <span>{{ $i."."." ".$val->name.' ( '.$val->name_eng.' )' }}</span>

                          <!-- <span class="float-right"><b>180</b>/200</span> -->

                          <?php
                          if ($val->percent <= 49) {
                            $color = "bg-danger";
                          } elseif ($val->percent <= 75) {
                            $color = "bg-warning";
                          } elseif ($val->percent <= 99) {
                            $color = "bg-primary";
                          } elseif ($val->percent == 100) {
                            $color = "bg-success";
                          }
                          ?>

                          <div class="progress progress-sm">
                            <div class="progress-bar {{ $color }} progress-bar-striped progress-bar-animated" role="progressbar" aria-volumenow="{{ number_format($val->percent) }}" aria-volumemin="0" aria-volumemax="100" style="width: {{ number_format($val->percent) }}%">
                              @if($val->percent=='100') สมบูรณ์
                              @else {{ number_format($val->percent) }}%
                              @endif
                            </div>
                          </div>

                        </div>
                      </a>
                    </li>
                    <?php $i++; ?>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <!-- END TABLE TASK ------------------------------------------------->

          <!-- GRAPH 1 -------------------------------------------------------->
          <!-- จำนวนงานทั้งหมด -->
          <div class="col-md-6 mx-auto">
            <div class="card card-orange">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-1 font-weight-bold text-dark">จำนวนงานทั้งหมด</h5>
              </div>
              <div class="card-body">
                <div id="chartContainer1" style="height: 370px; width: 100%;"></div>
              </div>
            </div>
            <!-- END GRAPH 1 -------------------------------------------------->


            <!-- GRAPH 2 ------------------------------------------------------>
            <!-- งานที่เกินกำหนด -->
            <div class="card card-orange">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h5 class="m-1 font-weight-bold text-dark">งานที่เกินกำหนด</h5>
              </div>
              <div class="card-body">
                <div id="chartContainer2" style="height: 370px; width: 100%;"></div>
              </div>
            </div>
            <!-- END GRAPH 2 -------------------------------------------------->
          </div>
        </div>

        <!-- GRAPH 3 ------------------------------------------------------>
        <!-- งานสำคัญเร่งด่วน -->
        <!-- <div class="row">
          <div class="col-md-12 mx-auto">
          <div class="card card-orange">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h5 class="m-0 font-weight-bold text-dark">งานสำคัญเร่งด่วน</h5>
            </div>
            <div class="card-body">
              <div id="chartContainer3" style="height: 370px; width: 100%;"></div>
            </div>
          </div> -->
          <!-- END GRAPH 3 -------------------------------------------------->
          <!-- </div>
        </div> -->


        <!-- GRAPH 4 ------------------------------------------------------>
        <!-- ประสิทธิภาพการทำงาน -->
        <div class="row">
          <div class="col-md-12 mx-auto">
          <div class="card card-orange">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
              <h5 class="m-0 font-weight-bold text-dark">ประสิทธิภาพการทำงาน</h5>
            </div>
            <div class="card-body">
              <div id="chartContainer4" style="height: 370px; width: 100%;"></div>
            </div>
          </div>
          <!-- END GRAPH 4 -------------------------------------------------->
          </div>
        </div>

    </div>
  </section>
<!-- END AREA CHART ----------------------------------------------------------->

@stop('content')


<!-- SCRIPT ------------------------------------------------------------------->
@section('custom-js-script')

<!-- Select2 -->
<script src="{{ asset('bower_components/bootstrap-select/bootstrap-select.min.js') }}"></script>

<!-- JS(Lay) -->
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>


@stop('custom-js-script')


<!-- JS ----------------------------------------------------------------------->
@section('custom-js-code')

<!-- DROPDOWN FILTER ------------------------------------------------------------->

<!-- ฟิวเตอร์ เลือก วันเริ่ม, สิ้นสุด -->
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


<!-- ฟิวเตอร์ เลือก ส่วนงานในสังกัด, หน่วยงาน, กล่องภารกิจ -->
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



<!-- ส่วนแสดงกราฟ -->
<script>

  $(function () {

// GRAPH 1 -------------------------------------------------------------------->
    var graph1 = new CanvasJS.Chart("chartContainer1", {
	  animationEnabled: true,
	  exportEnabled: true,
    title:{
      text: "",
      fontSize: 16,
    },
    legend:{
      cursor: "pointer",
      itemclick: explodePie1
    },
    toolTip: {
      shared: true
    },
    data: [{
      type: "doughnut",
      startAngle: -90,
      showInLegend: "true",
      legendText: "{label}",
      indexLabelFontSize: 14,
      indexLabel: "{label} - #percent%",
      yValueFormatString:  "#,##0\" \"งาน",
      dataPoints: <?php echo json_encode($querytask_graph1, JSON_NUMERIC_CHECK); ?>
    }]
  });
  graph1.render();

  function explodePie1 (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();
  }
// END GRAPH 1 ---------------------------------------------------------------->


// GRAPH 2 -------------------------------------------------------------------->
  var graph2 = new CanvasJS.Chart("chartContainer2", {
  	animationEnabled: true,
  	exportEnabled: true,
    theme: "light2",
    title:{
      text: "",
      fontSize: 16,
    },
    legend:{
      cursor: "pointer",
      itemclick: explodePie2
    },
    toolTip: {
      shared: true
    },
  	data: [{
  		type: "doughnut",
      startAngle: -90,
      showInLegend: "true",
      legendText: "{label}",
      indexLabelFontSize: 14,
      indexLabel: "{label}: - #percent%",
      yValueFormatString:  "#,##0\" \"งาน",
      dataPoints: <?php echo json_encode($querytask_graph2, JSON_NUMERIC_CHECK); ?>
  	}]
  });
  graph2.render();

  function explodePie2 (e) {
    if(typeof (e.dataSeries.dataPoints[e.dataPointIndex].exploded) === "undefined" || !e.dataSeries.dataPoints[e.dataPointIndex].exploded) {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = true;
    } else {
      e.dataSeries.dataPoints[e.dataPointIndex].exploded = false;
    }
    e.chart.render();
  }
// END GRAPH 2 ---------------------------------------------------------------->


// GRAPH 3 -------------------------------------------------------------------->
//   var graph3 = new CanvasJS.Chart("chartContainer3", {
// 	animationEnabled: true,
//   exportEnabled: true,
//   theme: "light2",
// 	title: {
// 		text: ""
// 	},
//   legend:{
//     cursor: "pointer",
//     itemclick: toggleDataSeries3
//   },
//   toolTip: {
//     shared: true
//   },
// 	axisY: {
// 		title: "",
//     suffix: "%"
// 	},
// 	data: [{
//     type: "stackedBar100",
//     color: "#7DCEA0",
//     showInLegend: "true",
//     yValueFormatString: "#,##0\"%\"",
//     name: "งานเสร็จสิ้น",
// 		dataPoints: <?php// echo json_encode($graph3_1, JSON_NUMERIC_CHECK); ?>
// 	},{
//     type: "stackedBar100",
//     color: "#F8C471",
//     showInLegend: "true",
//     yValueFormatString: "#,##0\"%\"",
//     name: "กำลังดำเนินการ",
// 		dataPoints: <?php// echo json_encode($graph3_2, JSON_NUMERIC_CHECK); ?>
// 	},{
//     type: "stackedBar100",
//     color: "#EC7063",
//     showInLegend: "true",
//     yValueFormatString: "#,##0\"%\"",
//     name: "งานเกินกำหนด",
// 		dataPoints: <?php// echo json_encode($graph3_3, JSON_NUMERIC_CHECK); ?>
// 	}]
// });
// graph3.render();
//
// function toggleDataSeries3(e){
//   if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
//     e.dataSeries.visible = false;
//   }
//   else{
//     e.dataSeries.visible = true;
//   }
// graph3.render();
// }
// END GRAPH 3 ---------------------------------------------------------------->


// GRAPH 4 -------------------------------------------------------------------->
  var graph4 = new CanvasJS.Chart("chartContainer4", {
	animationEnabled: true,
  exportEnabled: true,
  theme: "light2",
	title: {
		text: ""
	},
  legend:{
    cursor: "pointer",
    itemclick: toggleDataSeries4
  },
  toolTip: {
    shared: true
  },
	axisY: {
		title: "",
    suffix: "%"
	},
	data: [{
    type: "stackedBar100",
    color: "#7DCEA0",
    showInLegend: "true",
    yValueFormatString: "#,##0\"%\"",
    name: "งานเสร็จสิ้น",
		dataPoints: <?php echo json_encode($graph4_1, JSON_NUMERIC_CHECK); ?>
	},{
    type: "stackedBar100",
    color: "#F8C471",
    showInLegend: "true",
    yValueFormatString: "#,##0\"%\"",
    name: "กำลังดำเนินการ",
		dataPoints: <?php echo json_encode($graph4_2, JSON_NUMERIC_CHECK); ?>
	},{
    type: "stackedBar100",
    color: "#EC7063",
    showInLegend: "true",
    yValueFormatString: "#,##0\"%\"",
    name: "งานเกินกำหนด",
		dataPoints: <?php echo json_encode($graph4_3, JSON_NUMERIC_CHECK); ?>
	}]
});
graph4.render();

function toggleDataSeries4(e){
  if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
    e.dataSeries.visible = false;
  }
  else{
    e.dataSeries.visible = true;
  }
graph4.render();
}
// END GRAPH 4 ---------------------------------------------------------------->


  })
</script>

@stop('custom-js-code')
