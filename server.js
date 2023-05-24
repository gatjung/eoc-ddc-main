var socket  = require( './public/node_modules/socket.io' );
var express = require('./public/node_modules/express');
var cors    = require('./public/node_modules/cors');
var dotenv = require('./public/node_modules/dotenv').config();
var ip = require('./public/node_modules/ip');
var cron = require('./public/node_modules/node-cron');
var pool = require('./database')
var app     = express();
var server  = require('http').createServer(app);
//var io      = socket.listen( server );
var io = socket(server);
var port    = process.env.PORT || 3000;

app.use(cors())
var numClients = 0;
const current_ip = ip.address()

async function Notify(){

io.sockets.on('connection', function(socket) {

  numClients++;
  io.emit('stats', { numClients: numClients });

    socket.on('username', function(username) {
        socket.username = username;
        io.emit('is_online', '🔵 <i>' + socket.username + ' เข้าสู่การสนทนา..</i>');
        io.emit('is_msn_online', '<i>' + socket.username + ' เข้าสู่การสนทนา..</i>');
    });

    socket.on('disconnect', function(username) {
        numClients--;
        io.emit('stats', { numClients: numClients });
        io.emit('is_online', '🔴 <i>' + socket.username + ' ออกจากการสนทนา..</i>');
        io.emit('is_msn_offline', '<i>' + socket.username + ' ออกจากการสนทนา..</i>');
    });

    socket.on('chat_message', function(message) {
        io.emit('chat_message', '<strong>' + socket.username + '</strong>: ' + message);

        const message_ = { username: socket.username, message: message,ip:current_ip };
        pool.query('INSERT INTO chatall_log SET ?', message_, (err, res) => {
        });
    });

    socket.on('send-notify', function(data){
      socket.join(data.my_user_name)
      setInterval(() => {
        //const result = await pool.query("SELECT subject,detail,url_redirect,seen,module_name FROM notify_messages where receiver_u_id = "+data.my_user_id+" and seen = 0 ");
        var stmt_query = "SELECT subject,detail,url_redirect,seen,module_name FROM notify_messages where receiver_u_id="+data.my_user_id+" and seen = 0 "
        pool.query(stmt_query,function(err,result){
        //console.log(result);
        io.to(data.my_user_name).emit('notify', { data_notify : result });
        })
      }, 10000);
    });

    socket.on('send-notify-chatroom',function(data){
      socket.join(data.my_user_name)
      setInterval(() => {
        //const result = await pool.query("SELECT subject,detail,url_redirect,seen,module_name FROM notify_messages where receiver_u_id = "+data.my_user_id+" and seen = 0 ");
        var stmt_query = "SELECT subject,detail,url_redirect,seen,module_name FROM notify_messages where receiver_u_id="+data.my_user_id+" and seen = 0 "
        pool.query(stmt_query,function(err,result){
        console.log(result);
        io.to(data.my_user_name).emit('notify', { data_notify : result });
        })
      }, 10000);
    });
});
}


Notify();




server.listen(port, function () {
  console.log('Server listening at port %d', port);
});
