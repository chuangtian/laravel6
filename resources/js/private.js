
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
        var tid=$('#tid').val();
        console.log(tid);
        if (tid==e.uid){
            //left
            var mes='<div class="direct-chat-msg left">\n' +
                '                        <div class="direct-chat-infos clearfix">\n' +
                '                            <span class="direct-chat-name float-right">'+e.f_name+'</span>\n' +
                '                            <span class="direct-chat-timestamp float-left">'+e.created_at+'</span>\n' +
                '                        </div>\n' +
                '                        <!-- /.direct-chat-infos -->\n' +
                '                        <img class="direct-chat-img" src="'+e.f_image+'" alt="Message User Image">\n' +
                '                        <!-- /.direct-chat-img -->\n' +
                '                        <div class="direct-chat-text bg-info">\n' +
                '                            '+e.message+'\n' +
                '                        </div>\n' +
                '                        <!-- /.direct-chat-text -->\n' +
                '                    </div>';
            processProgress(mes);
        }

    });
