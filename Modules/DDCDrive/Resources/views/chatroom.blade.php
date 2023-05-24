<?php use App\CmsHelper as CmsHelper; ?>
@extends('ddcdrive::layouts.master')
@section('custom-css-script')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.css') }}">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
@stop
@section('custom-css')
<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
        /* body { font: 13px Helvetica, Arial; }
        form { background: #fff; padding: 3px; position: fixed; bottom: 0; width: 100%; border-color: #000; border-top-style: solid; border-top-width: 1px;}
        form input { border-style: solid; border-width: 1px; padding: 10px; width: 85%; margin-right: .5%; }
        form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; margin-left: 2%; } */
        #messages { list-style-type: none; margin: 0; padding: 0; }
        #messages li { padding: 5px 10px; }
        #messages li:nth-child(odd) { background: #aed6f1; }

        #logMessage { list-style-type: none; margin: 0; padding: 0; }
        #logMessage li { padding: 5px 10px; }
        #logMessage li:nth-child(odd) { background: #eee ; }
</style>
@stop
@section('content')
<audio id="notif_audio_user_online"><source src="{!! asset('sounds/msn_online.mp3') !!}" type="audio/mpeg"></audio>
<audio id="notif_audio_send_message"><source src="{!! asset('sounds/alert-msn.mp3') !!}" type="audio/mpeg"></audio>
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>DDC-Chat (ระบบแชทภายในกรม)</h1>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-12">
        <div class="card">
          <div class="card-body">
            <p class="text-center">ข้อมูลการสนทนาย้อนหลัง</p>
            <div class="d-md-flex">
              <div class="overflow-auto p-3 mb-3 mb-md-0 mr-md-3 bg-light w-100 h-25" style="max-width: 100%; max-height: 350px;">
                <ul id="logMessage">
                  @foreach($datas as $data)
                  <li>{{ $data->username }}: {{ $data->message }} , เมื่อ {{ CmsHelper::formatDateThai($data->created_at) }}</li>
                  @endforeach
                </ul>
              </div>
            </div>

            <p>
              <ul id="messages"></ul>
            </p>

              <p>จำนวนผู้ออนไลน์ : <span id="counter_text"></span></p>
              <form class="form-inline" action="/" method="POST" id="chatForm">
                <div class="form-group mb-2">
                  <label for="staticEmail2" class="sr-only">Email</label>
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Password</label>
                  <input id="txt" class="form-control"  autocomplete="off" autofocus="on">
                </div>
                <button class="btn btn-success mb-2"><i class="fas fa-paper-plane"></i></button>
              </form>
              </div>
          </div>
        </div>
     </div>
    </div>
</section>
@endsection
@section('custom-js-script')
<!-- DataTables -->
<script src="{{ asset('bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('bower_components/select2/dist/js/select2.full.js') }}"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Toastr -->
<script src="{{ asset('bower_components/admin-lte/plugins/toastr/toastr.min.js') }}"></script>
<!-- Socket.IO -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>
@stop
@section('custom-js-code')

<script type="text/javascript">

$(function(){
    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": false,
      "progressBar": false,
      "positionClass": "toast-bottom-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });
});
            const socket = io.connect( 'http://'+window.location.hostname+':3000' );
            let username = '{{ Auth::user()->email }}';
            const my_user_id = {{ Auth::user()->id }};
            const my_user_name = '{{ Auth::user()->username }}';

            socket.emit('send-notify-chatroom', { my_user_id:my_user_id,my_user_name:my_user_name} );
            // append the chat text message
            socket.on('notify-chatroom', function(data){
                var count_notify = data.data_notify.length;
                //console.log('Message Count:'+count_notify);
                if(count_notify>0){
                  //$('#notif_audio_line_notify')[0].play();
                }
                $('#new_count_message').html(count_notify);
            });

            // submit text message without reload/refresh the page
            $('form').submit(function(e){
                e.preventDefault(); // prevents page reloading
                var text_message = $('#txt').val();
                if(text_message){
                  socket.emit('chat_message', $('#txt').val());
                  $('#txt').val('');
                  return false;
                }else{
                  alert('กรุณาพิมพ์ข้อความ');
                  $('#txt').val('');
                  return false;
                }


            });
            // append the chat text message
            socket.on('chat_message', function(msg){
                //console.log(msg);
                $('#messages').append($('<li>').html(msg));
                $('#notif_audio_send_message')[0].play();

                  // $.ajax({
                  //     url: "{{ route('ddcdrive.chatlog.btn') }}",
                  //     type: "GET",
                  //     dataType: "html",
                  //     success: function (data) {
                  //          $('#logMessage').html('');
                  //          $('#logMessage').html(data);
                  //     },
                  //     error: function (xhr, status) {
                  //         alert("Sorry, there was a problem!");
                  //     },
                  //     complete: function (xhr, status) {
                  //         //$('#showresults').slideDown('slow')
                  //     }
                  // });

            });
            // append text if someone is online
            socket.on('is_online', function(username) {
                $('#messages').append($('<li>').html(username));
                $('#notif_audio_user_online')[0].play();

            });
            socket.on('is_msn_online', function(username) {
              toastr.success(username);
            });
            socket.on('is_msn_offline', function(username) {
              toastr.error(username);

            });
            // ask username
            //var username = prompt('Please tell me your name');
            socket.emit('username', username);

            socket.on('stats', function(data) {
                //console.log('Connected clients:', data.numClients);
                $('#counter_text').text(data.numClients);
            });
</script>
@stop
