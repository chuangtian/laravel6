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

                    @foreach ($data as $value)
                            <div class="card card-widget">
                                <div class="card-header">
                                    <div class="user-block">
                                        <img class="img-circle" src="{{ asset($value->u_image)}}" alt="User Image">
                                        <span class="username"><a href="#">{{$value->name}}</a></span>
                                        <span class="description">发布时间 - {{$value->creation_time}}</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p>{{$value->message}}</p>
                                    @foreach($value->image as $image)
                                        <img class="img-fluid pad" src="{{asset($image)}}" alt="Photo">
                                    @endforeach
                                    <p></p>
{{--                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>--}}
                                    <button type="button" class="btn btn-default btn-sm"   onclick="imagesubmit({{$value->id}})"><i class="far fa-thumbs-up"></i> Like</button>
                                    <span class="float-right text-muted"><span id="l{{$value->id}}">{{$value->like}}</span> 点赞 - <span id="c{{$value->id}}">{{ count($value->comments) }}</span> 评论</span>
                                </div>
                                <div class="card-footer card-comments">
                                    <div id="addcomment">
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
                                                <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return sub()">
                                                    <img class="img-fluid img-circle img-sm" src="{{ asset('manager/'.Auth::user()->image) }}" alt="Alt Text">
                                                    <!-- .img-push is used to add margin to elements next to floating images -->
                                                    <div class="img-push">
                                                        <input type="hidden" name="messageid" id="messageid" value="{{$value->id}}">
                                                        <input type="text" class="form-control form-control-sm" id="comment" value="" placeholder="按Enter发表评论">
                                                    </div>
                                                </form>
                                            </div>
                                        @endguest


                                </div>
                            </div>
                    @endforeach

                        {{ $data->appends(['getTime' =>$time])->links() }}
                </div>
                        <!-- /.col -->


            {{--</div>--}}
{{--        </div>--}}

    </div>
</div>
<!-- Sweet Alert -->
<script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
<script>
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

    function sub() {
        comment=$('#comment').val();
        console.log(comment);

        mid=$('#messageid').val();
        console.log(mid);

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
                    $("#addcomment").append(adddiv);
                    $('#comment').val('');
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

</script>

@endsection
