@extends('meeting::layouts.master')
@section('custom-css-script')
<!-- fullCalendar -->
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fullcalendar/main.min.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fullcalendar-daygrid/main.min.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fullcalendar-timegrid/main.min.css')}}">
<link rel="stylesheet" href="{{asset('bower_components/admin-lte/plugins/fullcalendar-bootstrap/main.min.css')}}">
@stop
@section('custom-css')
<style>
</style>
@stop
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Meeting</h1>
      </div>
      <div class="col-sm-6 text-right">
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<div class="pl-4 pr-4 pb-4">
    <section class="content bg-white">
      <div class="container-fluid">
        
      <div id="calendar"></div>

      </div>
    </section>
</div>
@endsection
@section('custom-js-script')
<!-- jQuery UI -->
<script src="{{asset('bower_components/admin-lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{asset('bower_components/admin-lte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/fullcalendar/main.min.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/fullcalendar-daygrid/main.min.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/fullcalendar-timegrid/main.min.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/fullcalendar-interaction/main.min.js')}}"></script>
<script src="{{asset('bower_components/admin-lte/plugins/fullcalendar-bootstrap/main.min.js')}}"></script>
@stop

@section('custom-js-code')
<script type="text/javascript">
$(function () {


/* initialize the calendar
 -----------------------------------------------------------------*/
var Calendar = FullCalendar.Calendar;
var Draggable = FullCalendarInteraction.Draggable;
var calendarEl = document.getElementById('calendar');

var calendar = new Calendar(calendarEl, {
  plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid' ],
  header    : {
    left  : 'prev,next today',
    center: 'title',
    right : 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  'themeSystem': 'bootstrap',
  //Random default events
  events    : [
    {
      title          : 'Click for Google',
      start          : new Date("2020-11-16"),
      end            : new Date("2020-11-16"),
      url            : 'http://google.com/',
      backgroundColor: '#3c8dbc',
      borderColor    : '#3c8dbc'
    }
  ],
  editable  : true,
  droppable : true    
});

calendar.render();
})
</script>
@stop
