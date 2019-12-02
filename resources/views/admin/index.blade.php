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
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">编辑状态</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-lg-12" >


                                        <div class="form-group">
                                            <label for="comment">内容</label>
                                            <textarea class="form-control" id="comment" rows="5">

												</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlFile1">上传文件</label>
                                            <input type="file" class="form-control-file" id="exampleFormControlFile1">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">图片编辑</label>
                                            <div class="row">
                                                <div class="col-6 col-sm-4">
                                                    <label class="imagecheck mb-4">
                                                        <input name="imagecheck" type="checkbox" value="1" class="imagecheck-input">
                                                        <figure class="imagecheck-figure">
                                                            <img src="{{asset('assets/img/examples/product1.jpg')}}" alt="title" class="imagecheck-image">
                                                        </figure>
                                                    </label>
                                                </div>
                                                <div class="col-6 col-sm-4">
                                                    <label class="imagecheck mb-4">
                                                        <input name="imagecheck" type="checkbox" value="2" class="imagecheck-input" checked="">
                                                        <figure class="imagecheck-figure">
                                                            <img src="{{asset('assets/img/examples/product4.jpg')}}" alt="title" class="imagecheck-image">
                                                        </figure>
                                                    </label>
                                                </div>
                                                <div class="col-6 col-sm-4">
                                                    <label class="imagecheck mb-4">
                                                        <input name="imagecheck" type="checkbox" value="3" class="imagecheck-input">
                                                        <figure class="imagecheck-figure">
                                                            <img src="{{asset('assets/img/examples/product3.jpg')}}" alt="title" class="imagecheck-image">
                                                        </figure>
                                                    </label>
                                                </div>
                                                <div class="col-6 col-sm-4">
                                                    <label class="imagecheck mb-4">
                                                        <input name="imagecheck" type="checkbox" value="3" class="imagecheck-input">
                                                        <figure class="imagecheck-figure">
                                                            <img src="{{asset('assets/img/examples/product3.jpg')}}" alt="title" class="imagecheck-image">
                                                        </figure>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="card-action">
                                <button class="btn btn-success">Submit</button>
                                <button class="btn btn-danger">Cancel</button>
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


@endsection