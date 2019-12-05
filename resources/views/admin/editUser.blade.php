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
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">注意，要一个一个的修改，而不是修改全部统一发送</div>
                            </div>
                            <div class="form-group">
                                <label for="email2">修改邮箱</label>
                                <input type="email" class="form-control" id="email2" value="{{ Auth::user()->email }}" placeholder="Enter 修改">
                                <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
                            </div>

                            <div class="form-group">
                                <label for="email2">修改名字</label>
                                <input type="email" class="form-control" id="email2" value="{{ Auth::user()->name }}" placeholder="Enter 修改">
                                <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlFile1">上传文件</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1"  onchange="imagesubmit()">
                            </div>

                            <div class="form-group">
                                <div class="avatar avatar-xxl">
                                    <img src="{{asset('manager/'.Auth::user()->image)}}" alt="..." class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email2">修改密码</label>
                                <input type="email" class="form-control" id="email2" value="" placeholder="旧密码">
                                <input type="email" class="form-control" id="email2" value="" placeholder="新密码">
                                <input type="email" class="form-control" id="email2" value="" placeholder="新密码确认">
                                <small id="emailHelp2" class="form-text text-muted">Enter 提交修改</small>
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



@endsection