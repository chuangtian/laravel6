@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
{{--        <div class="col-md-8">--}}
{{--            <div class="card">--}}
{{--                <div class="card-header">Dashboard</div>--}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div id="zhuijia">
                        @foreach ($data as $value)
                            <div class="card card-widget">
                                <div class="card-header">
                                    <div class="user-block"  data-toggle="modal" data-target=".chat"  onclick="values({{$value->u_id}})">
                                        <img class="img-circle" src="{{ asset($value->u_image)}}" alt="User Image">
                                        <span class="username">{{$value->name}}</span>
                                        <span class="description">发布时间 - {{$value->creation_time}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{{$value->message}}</p>
                                    @foreach($value->image as $imagea)
                                        @if($imagea)
                                            <img class="img-fluid pad" src="{{asset($imagea)}}" alt="Photo">
                                        @endif
                                    @endforeach
                                    <p></p>
                                    {{--                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>--}}
                                    <button type="button" class="btn btn-default btn-sm"   onclick="imagesubmit({{$value->id}})"><i class="far fa-thumbs-up"></i> Like</button>
                                    <span class="float-right text-muted"><span id="l{{$value->id}}">{{$value->like}}</span> 点赞 - <span id="c{{$value->id}}">{{ count($value->comments) }}</span> 评论</span>
                                </div>
                                <div class="card-footer card-comments">
                                    <div id="addcomment{{$value->id}}">
                                        @foreach($value->comments as $comment)

                                            <div class="card-comment">
                                                <!-- User image -->
                                                <img class="img-circle img-sm" src="{{asset('manager/'.$comment->c_image)}}" alt="User Image">
                                                <div class="comment-text">
                                                    <span class="username">
                                                      {{$comment->c_name}}
                                                      <span class="text-muted float-right">{{$comment->creation_time}}</span>
                                                    </span><!-- /.username -->
                                                    {{$comment->message}}
                                                </div>
                                                <!-- /.comment-text -->
                                            </div>

                                        @endforeach
                                    </div>
                                    @guest
                                    @else
                                        <div class="card-footer">
                                            {{--                                                <form action="#" method="post">--}}
                                            <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return sub({{$value->id}})">
                                                <img class="img-fluid img-circle img-sm" src="{{ asset('manager/'.Auth::user()->image) }}" alt="Alt Text">
                                                <!-- .img-push is used to add margin to elements next to floating images -->
                                                <div class="img-push">
                                                    <input type="hidden" name="messageid" id="messageid{{$value->id}}" value="{{$value->id}}">
                                                    <input type="text" class="form-control form-control-sm" id="comment{{$value->id}}" value="" placeholder="按Enter发表评论">
                                                </div>
                                            </form>
                                        </div>
                                    @endguest


                                </div>
                            </div>
                        @endforeach
                    </div>

                        @if ($lastPage!=1)
                            <div class="card-footer" id="jiazai" style="text-align:center;">
                                <img  src="{{asset('timg.gif')}}"  alt="Photo">
                            </div>
                        @endif

{{--                        {{ $data->appends(['getTime' =>$time])->links() }}--}}
                </div>
                        <!-- /.col -->


            {{--</div>--}}
{{--        </div>--}}

    </div>
</div>

<div class="modal fade chat">
    <div class="modal-dialog">
        <div class="modal-content"  style="top: 50%;left: 50%;transform: translateX(-50%) translateY(-50%);">
            <div class="modal-header">
                <h4 class="modal-title">聊天</h4>
                <div class="card-tools">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-body" >
                <div class="direct-chat-messages pre-scrollable" id="chats">

                        <!-- /.direct-chat-text -->


                </div>
            </div>

            <div class="card-footer">
                <form   name="form"  enctype="multipart/form-data" onsubmit="return chat()">
                    <div class="input-group">
                        <input type="hidden" id="tid" value="">
                        <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                      <button type="submit" class="btn btn-success">Send</button>
                    </span>
                    </div>
                </form>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Sweet Alert -->
<script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

<script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>


<script>
    console.log(window.Laravel.user);
    function imagesubmit($this) {
        var formData = new FormData();
        formData.append("_token", "{{csrf_token()}}");
        formData.append("mid", $this);
        id=$this;
        $.ajax({
            url:"{{ url('/like') }}",
            type:"POST",
            data:formData,
            processData : false,
            contentType : false,
            dataType : 'json',
            async : false,
            success : function (result) {
                if(result.code===200){
                    swal(result.message, {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
                    like=$("#l"+id).text();
                    if(result.info===1){
                        zenglike=parseInt(like)+1;
                    }else{
                        zenglike=parseInt(like)-1;
                        if(zenglike<=0){
                            zenglike=0;
                        }
                    }
                    $("#l"+id).text(zenglike)
                }else{
                    swal("请登录", "", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }

            },
            error:function(xhr){
                swal("服务器问题", "允许说着脏话联系我", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }

        })
    }

    function sub($this) {

        mid=$this;
        console.log(mid);
        comment=$('#comment'+mid).val();
        console.log(comment);

        var formData = new FormData();
        formData.append("_token", "{{csrf_token()}}");
        formData.append("comment", comment);
        formData.append("mid", mid);
        $.ajax({
            url:"{{ url('/comment') }}",
            type:"POST",
            data:formData,
            processData : false,
            contentType : false,
            dataType : 'json',
            async : false,
            success : function (result) {
                //成功后的回调事件
                console.log(result.code);
                if(result.code===200){
                    c_image=result.c_image;
                    c_name=result.c_name;
                    creation_time=result.creation_time;
                    message=result.message;
                    adddiv='<div class="card-comment">\n' +
                        '                                                <!-- User image -->\n' +
                        '                                                <img class="img-circle img-sm" src="'+ c_image +'" alt="User Image">\n' +
                        '                                                <div class="comment-text">\n' +
                        '                                                <span class="username">\n' +
                        '                                                  '+ c_name +'\n' +
                        '                                                  <span class="text-muted float-right">'+ creation_time +'</span>\n' +
                        '                                                </span><!-- /.username -->\n' +
                        '                                                    '+ message +'\n' +
                        '                                                </div>\n' +
                        '                                                <!-- /.comment-text -->\n' +
                        '                                            </div>';
                    $("#addcomment"+mid).append(adddiv);
                    $('#comment'+mid).val('');
                    com=$("#c"+mid).text();

                    zengcom=parseInt(com)+1;

                    $("#c"+mid).text(zengcom)
                }
                if (result.cade===402){
                    swal("请登录", "", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }

                if (result.cade===401){
                    swal(result.message, {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
                }

            },
            error:function(xhr){
                swal("服务器问题", "允许说着脏话联系我", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }

        });

        return false;
    }
    var current_page=2;
    var tan=0;
    var lastPage_page={{$lastPage}};
    var gettime='{{$time}}';
    function getNext() {

        $.ajax({
            url:"{{ url('/') }}?page="+current_page+"&gettime="+gettime,
            type:"GET",
            processData : false,
            contentType : false,
            dataType : 'json',
            async : false,
            success : function (result) {
                //成功后的回调事件
                console.log(result.code);
                if(result.code===200){
                    adddiv=result.message;
                    $("#zhuijia").append(adddiv);
                    current_page++;
                }

            },
            error:function(xhr){
                swal("服务器问题", "允许说着脏话联系我", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }

        });
        //$("#jiazai").css("display","none");
    }
    $(window).scroll(function(){

        //判断是否滑动到页面底部
        if($(window).scrollTop()=== $(document).height() - $(window).height()){
            if(current_page > lastPage_page){
                $("#jiazai").css("display","none");
                if(tan===0){
                    swal("往下没有了🤗", {
                        icon : "info",
                        buttons: {
                            confirm: {
                                className : 'btn btn-info'
                            }
                        },
                    });
                    tan++;
                }
            }else{
                getNext();
            }

        }

    });
    function values(ID){
        $('#tid').val(ID);

        // var showdiv = document.getElementById("chats");
        // showdiv.scrollTop = showdiv.scrollHeight;
        // console.log(showdiv);
    }
    $(function () { $('.chat').on('show.bs.modal', function () {

            $("#chats").empty();
            var modalHeight=$(window).height() / 1.5;
            console.log(modalHeight);
            $(this).find('.modal-dialog').css({
                'margin-top': modalHeight
            });

            tid=$('#tid').val();
            var formData = new FormData();
            formData.append("_token", "{{csrf_token()}}");
            formData.append("tid", tid);
            console.log(tid);
            $.ajax({
                url:"{{ url('/getChat') }}",
                type:"POST",
                data:formData,
                processData : false,
                contentType : false,
                dataType : 'json',
                async : false,
                success : function (result) {
                    if(result.code===200){
                        console.log(result);
                        arr=result.data;
                        for(var i=0;i<arr.length;i++){
                                if(arr[i].fid==window.Laravel.user){
                                    mes='<div class="direct-chat-msg right">\n' +
                                        '                        <div class="direct-chat-infos clearfix">\n' +
                                        '                            <span class="direct-chat-name float-right">'+arr[i].f_name+'</span>\n' +
                                        '                            <span class="direct-chat-timestamp float-left">'+arr[i].created_at+'</span>\n' +
                                        '                        </div>\n' +
                                        '                        <!-- /.direct-chat-infos -->\n' +
                                        '                        <img class="direct-chat-img" src="'+arr[i].f_image+'" alt="Message User Image">\n' +
                                        '                        <!-- /.direct-chat-img -->\n' +
                                        '                        <div class="direct-chat-text bg-info">\n' +
                                        '                            '+arr[i].message+'\n' +
                                        '                        </div>\n' +
                                        '                        <!-- /.direct-chat-text -->\n' +
                                        '                    </div>';
                                    processProgress(mes);
                                }else{
                                    mes='<div class="direct-chat-msg">\n' +
                                        '                        <div class="direct-chat-infos clearfix">\n' +
                                        '                            <span class="direct-chat-name float-right">'+arr[i].f_name+'</span>\n' +
                                        '                            <span class="direct-chat-timestamp float-left">'+arr[i].created_at+'</span>\n' +
                                        '                        </div>\n' +
                                        '                        <!-- /.direct-chat-infos -->\n' +
                                        '                        <img class="direct-chat-img" src="'+arr[i].f_image+'" alt="Message User Image">\n' +
                                        '                        <!-- /.direct-chat-img -->\n' +
                                        '                        <div class="direct-chat-text bg-info">\n' +
                                        '                            '+arr[i].message+'\n' +
                                        '                        </div>\n' +
                                        '                        <!-- /.direct-chat-text -->\n' +
                                        '                    </div>';
                                    processProgress(mes);
                                }



                            // console.log(arr[i].created_at);
                        }
                    }else{
                        swal("请登录", "", {
                            icon : "error",
                            buttons: {
                                confirm: {
                                    className : 'btn btn-danger'
                                }
                            },
                        });
                    }

                },
                error:function(xhr){
                    swal("服务器问题", "允许说着脏话联系我", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }

            })
            setTimeout(function () {
                var scrollHeight = $('#chats').prop("scrollHeight");
                $('#chats').animate({scrollTop:scrollHeight}, 400);
            },300);






            // $('#chats').on('scroll',function(){
            //
            //     console.log('滚动了');
            // });

    });});
    //放下面
    function processProgress(content) {
        try {
            if (content === "") {
                return false;
            }
            var showdiv = document.getElementById("chats");
            showdiv.innerHTML += content;
            console.log('258');
            setTimeout(function () {
                var scrollHeight = $('#chats').prop("scrollHeight");
                $('#chats').animate({scrollTop:scrollHeight}, 400);
            },300)
        } catch (e) {
            console.log(e + "发生错误");
        }

    }
    //放上面
    function processProgress2(content) {
        try {
            if (content === "") {
                return false;
            }
            var showdiv = document.getElementById("chats");
            content +=showdiv.innerHTML;
            showdiv.innerHTML=content;
            console.log('258');
        } catch (e) {
            console.log(e + "发生错误");
        }

    }

    function chat() {
        tid=$('#tid').val();
        message=$('#message').val();
        var formData = new FormData();
        formData.append("_token", "{{csrf_token()}}");
        formData.append("tid", tid);
        formData.append("message", message);
        console.log(tid);

        $.ajax({
            url:"{{ url('/chat') }}",
            type:"POST",
            data:formData,
            processData : false,
            contentType : false,
            dataType : 'json',
            async : false,
            success : function (result) {
                if(result.code===200){
                    //left
                    mes='<div class="direct-chat-msg right">\n' +
                        '                        <div class="direct-chat-infos clearfix">\n' +
                        '                            <span class="direct-chat-name float-right">'+result.f_name+'</span>\n' +
                        '                            <span class="direct-chat-timestamp float-left">'+result.created_at+'</span>\n' +
                        '                        </div>\n' +
                        '                        <!-- /.direct-chat-infos -->\n' +
                        '                        <img class="direct-chat-img" src="'+result.f_image+'" alt="Message User Image">\n' +
                        '                        <!-- /.direct-chat-img -->\n' +
                        '                        <div class="direct-chat-text bg-info">\n' +
                        '                            '+result.message+'\n' +
                        '                        </div>\n' +
                        '                        <!-- /.direct-chat-text -->\n' +
                        '                    </div>';
                     processProgress(mes);
                    // console.log(result);
                   $('#message').val('');
                }else{
                    swal("请登录", "", {
                        icon : "error",
                        buttons: {
                            confirm: {
                                className : 'btn btn-danger'
                            }
                        },
                    });
                }

            },
            error:function(xhr){
                swal("服务器问题", "允许说着脏话联系我", {
                    icon : "error",
                    buttons: {
                        confirm: {
                            className : 'btn btn-danger'
                        }
                    },
                });
            }

        })
        return false;
    }

</script>

@endsection
