
// 引入该引入的包
import Echo from 'laravel-echo';
window.io = require('socket.io-client');
window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001'
});
window.Echo.private('user.' + window.Laravel.user)
    .listen('PrivateEvent', (e) => {
        console.log(e);
    });
