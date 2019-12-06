@extends('layouts.admin')

@section('content')

    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <h4 class="page-title">状态</h4>
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
                            <a href="#">状态</a>
                        </li>
                        <li class="separator">
                            <i class="flaticon-right-arrow"></i>
                        </li>
                        <li class="nav-item">
                            <a href="#">发送状态</a>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('addMessage') }}">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">编辑状态</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-12" >

                                            <div class="form-group">
                                                <label for="comment">内容</label>
                                                <textarea class="form-control" name="message" id="comment" rows="5">

                                                    </textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlFile1">上传文件</label>
                                                <input type="file" class="form-control-file" id="exampleFormControlFile1"  onchange="imagesubmit()">
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">图片编辑</label>
                                                <div class="row" id="addimage">

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
{{--                                    <button class="btn btn-danger">Cancel</button>--}}
                                </div>
                            </div>
                        </form>
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
                        adddiv='<div class="col-6 col-sm-4">\n' +
                            '                                                    <label class="imagecheck mb-4">\n' +
                            '                                                        <input name="imagecheck[]" type="checkbox" value="'+image+'" class="imagecheck-input"  checked="checked">\n' +
                            '                                                        <figure class="imagecheck-figure">\n' +
                            '                                                            <img src="'+image+'" alt="title" class="imagecheck-image">\n' +
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

    </script>

@endsection