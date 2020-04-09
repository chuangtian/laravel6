<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script>
        window.Laravel = {!! json_encode([
        'user' => auth()->check() ? auth()->user()->id : null,
    ]) !!};

    </script>



    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">


</head>
<body>
    <div id="app">


@guest
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">

                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
{{--                            @guest--}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('app.Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('app.Register') }}</a>
                                    </li>
                                @endif

                        </ul>
                    </div>
                </div>
            </nav>
@else
        <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    <h3 class="widget-user-username">{{ Auth::user()->name }}</h3>
                    <h5 class="widget-user-desc"></h5>
                </div>
                <div class="widget-user-image"  data-toggle="modal" data-target="#modal-info">
                    <img class="img-circle elevation-2" src="{{asset('manager/'.Auth::user()->image)}}" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$meCount}}</h5>
                                <span class="description-text">朋友圈总数</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{$coCount}}</h5>
                                <span class="description-text">给我评论总数</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{$liCount}}</h5>
                                <span class="description-text">给我点赞总数</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
            <div class="modal fade" id="modal-info">
                <div class="modal-dialog">
                    <div class="modal-content bg-info">
                        <div class="modal-header">
                            <h4 class="modal-title">添加状态</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <form  name="form" id="messdata" enctype="multipart/form-data"  onsubmit="return admess()" >
                                        @csrf

                                                <div class="row">
                                                    <div class="col-md-6 col-lg-12" >

                                                        <div class="form-group">
                                                            <label for="comment">内容</label>
                                                            <textarea class="form-control" name="message" id="message4" rows="5">

                                                    </textarea>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exampleFormControlFile1">上传文件</label>
                                                            <input type="file" class="form-control-file" id="exampleFormControlFile1"  onchange="imagesubmit2()">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">图片编辑</label>
                                                            <div class="card">
                                                                <div class="row" id="addimage">

                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            <div class="card-action">
                                                <button class="btn btn-outline-light">Submit</button>
                                                {{--                                    <button class="btn btn-danger">Cancel</button>--}}
                                            </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Close</button>
                            <a href="{{url('/admin')}}" target="_blank" rel="noopener norefferrer" > <button type="submit" class="btn btn-outline-light">前往后台</button></a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                                                                            @csrf
                                <button type="submit" class="btn btn-outline-light">退出</button>
                            </form>

                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
@endguest

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script>
        function imagesubmit2() {
            var formData = new FormData();
            var file = document.getElementById("exampleFormControlFile1").files[0];
            formData.append("image", file);
            $.ajax({
                url:"{{ url('api/update/updateImage') }}",
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
                        image=result.image;
                        adddiv='<div class="col-6 col-sm-4">\n' +
                            '                                                    <label class="imagecheck mb-4">\n' +
                            '                                                        <input name="imagecheck[]" type="checkbox" value="'+image+'" class="imagecheck-input"  checked="checked">\n' +
                            '                                                        <figure class="imagecheck-figure">\n' +
                            '                                                            <img src="'+image+'" alt="title" class="imagecheck-image img-thumbnail">\n' +
                            '                                                        </figure>\n' +
                            '                                                    </label>\n' +
                            '                                                </div>';
                        $("#addimage").append(adddiv);
                    }else{
                        swal("服务器问题", "允许说着脏话联系我", {
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

        function admess() {
            comment=$('#message4').val();
            var formData = new FormData();
            formData.append("_token", "{{csrf_token()}}");
            formData.append("message", comment);
            $('input[name="imagecheck[]"]').each(function(i){
                formData.append("imagecheck[]", this.value);

            });

            formData.append("user", 1);
            $.ajax({
                url:"{{ route('addMessage') }}",
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
                        window.location.reload();
                        // $('#modal-info').modal('hide');
                        // window.location.reload();
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

        $(function () { $('#modal-info').on('show.bs.modal', function () {
            a=$('#pid').val();
            console.log(a);
            var modalHeight=$(window).height() / 3;
            console.log(modalHeight);
            $(this).find('.modal-dialog').css({
                'margin-top': modalHeight
            });
        })
        });

    </script>
    <script src="{{ asset('js/private.js') }}" defer></script>
    <script src="{{ asset('js/broadcasting.js') }}" defer></script>
</body>
</html>
