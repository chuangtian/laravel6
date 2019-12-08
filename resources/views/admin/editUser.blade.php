@extends('layouts.admin')

@section('content')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">用户</h4>
                    <ul class="breadcrumbs">
                        <li class="nav-home">
                            <a href="#">
                                <i class="flaticon-home"></i>
                            </a>
                        </li>

                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">修改用户</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <br class="card">
                            <div class="card-header">
                                <div class="card-title">注意，要一个一个的修改，而不是修改全部统一发送</div>
                            </div>
                            <div class="form-group">
                                <label for="email2">修改邮箱</label>
                                <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return email2()">
                                    <input type="email" class="form-control" id="email" value="{{ Auth::user()->email }}" placeholder="Enter 修改">
                                </form>
                                <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
                            </div>

                            <div class="form-group">
                                <label for="email2">修改名字</label>
                                <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return editName()">
                                 <input type="name" class="form-control" id="meName" value="{{ Auth::user()->name }}" placeholder="Enter 修改">
                                </form>
                                 <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">上传文件</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1"  onchange="imagesubmit()">
                            </div>
                            <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return editImage()">
                                <div class="form-group">
                                    <div class="avatar avatar-xxl">
                                        <img src="{{asset('manager/'.Auth::user()->image)}}" alt="..."  id="tou" class="avatar-img rounded-circle">
                                        <input type="hidden" name="touxing" id="touxiang" value="">
                                    </div>

                                </div>
                                <button class="btn btn-success" style="width: 100px" type="submit">图片确认</button>
                            </form>
                            </br>
                            </br>
                            <div class="form-group">
                                <form  name="form" id="fromdata" enctype="multipart/form-data" onsubmit="return editPassword()">
                                    <label for="email2">修改密码</label>
                                    <input type="email" class="form-control" id="oldPassword" value="" placeholder="旧密码">
                                    <input type="email" class="form-control" id="newPassword1" value="" placeholder="新密码">
                                    <input type="email" class="form-control" id="newPassword2" value="" placeholder="新密码确认">
                                    <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
                                </form>
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="https://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">
                    2018, made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>

    <!--   Core JS Files   -->
    <script src="{{asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
    <script src="{{asset('assets/js/core/popper.min.js')}}"></script>
    <script src="{{asset('assets/js/core/bootstrap.min.js')}}"></script>
    <!-- jQuery UI -->
    <script src="{{asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
    <!-- Atlantis JS -->
    <script src="{{asset('assets/js/atlantis.min.js')}}"></script>
    <!-- Atlantis DEMO methods, don't include it in your project! -->
    <script src="{{asset('assets/js/setting-demo2.js')}}"></script>

    <!-- Sweet Alert -->
    <script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>

    <script>
        //提交图片
        function imagesubmit() {
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
                        $('#tou').attr('src',image);
                        $('#touxiang').val(image);

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

        function email2() {
            valueName="email";
            value=$('#email').val();
            if(value!=='{{ Auth::user()->email }}' || value!==''){
                send(valueName,value);
            }
            return false;
        }

        function editName() {
            valueName="name";
            value=$('#meName').val();
            if(value!=='{{ Auth::user()->name }}' || value!==''){
                send(valueName,value);
            }
            return false;
        }

        function editImage() {
            valueName="image";
            value=$('#touxiang').val();
            if(value!=='{{asset('manager/'.Auth::user()->image)}}' || value!==''){
                send(valueName,value);
            }
            return false;
        }

        //ajax提交
        function send(valueName,value) {
            var formData = new FormData();
            formData.append("_token", "{{csrf_token()}}");
            formData.append("valueName", valueName);
            formData.append("value", value);
            $.ajax({
                url:"{{ url('user/editUser') }}",
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
                        swal(result.message, {
                            icon: "success",
                            buttons : {
                                confirm : {
                                    className: 'btn btn-success'
                                }
                            }
                        });

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

        //修改密码
        function editPassword(){
            valueName="password";
            oldValue=$('#oldPassword').val();
            newValue1=$('#newPassword1').val();
            newValue2=$('#newPassword2').val();

            var formData = new FormData();
            formData.append("_token", "{{csrf_token()}}");
            formData.append("valueName", valueName);
            formData.append("oldPassword", value);
            formData.append("newPassword1", value);
            formData.append("newPassword2", value);
            $.ajax({
                url:"{{ url('user/editUser') }}",
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
                        swal(result.message, {
                            icon: "success",
                            buttons : {
                                confirm : {
                                    className: 'btn btn-success'
                                }
                            }
                        });

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
            return false;
        }

    </script>



@endsection