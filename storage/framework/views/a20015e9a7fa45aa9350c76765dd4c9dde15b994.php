<!-- <audio id="notif_audio_line_notify"><source src="<?php echo asset('sounds/msn_mail_alert.mp3'); ?>" type="audio/mpeg"></audio> -->
<!-- Socket.IO -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>

<script type="text/javascript">

$(function(){

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
    });

    const socket = io.connect( 'http://'+window.location.hostname+':3000' );
    const my_user_id = <?php echo e(Auth::user()->id); ?>;
    const my_user_name = '<?php echo e(Auth::user()->username); ?>';

            socket.emit('send-notify', { my_user_id:my_user_id,my_user_name:my_user_name} );
            // append the chat text message
            socket.on('notify', function(data){
                var count_notify = data.data_notify.length;
                //console.log('Message Count:'+count_notify);
                if(count_notify>0){
                  //$('#notif_audio_line_notify')[0].play();
                }
                $('#new_count_message').html(count_notify);
            });
});
</script><?php /**PATH /var/www/resources/views/socketio-notify.blade.php ENDPATH**/ ?>