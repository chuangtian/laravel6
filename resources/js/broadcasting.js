// 引入该引入的包
import Echo from 'laravel-echo';
window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
window.Echo.channel('push')
    .listen('.push.msg', (e) => {
        console.log(e);  //
        $("#hh").html(e);
    });
