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
                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                                    <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                                    <span class="float-right text-muted">127 likes - 3 comments</span>
                                </div>
                            </div>
                    @endforeach

                            <!-- Box Comment -->
                            <div class="card card-widget">

                                <!-- /.card-header -->
                                <div class="card-body">
                                    <img class="img-fluid pad" src="{{asset('dist/img/photo2.png')}}" alt="Photo">
                                    <p>I took this photo this morning. What do you guys think?</p>
                                    <button type="button" class="btn btn-default btn-sm"><i class="fas fa-share"></i> Share</button>
                                    <button type="button" class="btn btn-default btn-sm"><i class="far fa-thumbs-up"></i> Like</button>
                                    <span class="float-right text-muted">127 likes - 3 comments</span>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer card-comments">
                                    <div class="card-comment">
                                        <!-- User image -->
                                        <img class="img-circle img-sm" src="{{asset('dist/img/user3-128x128.jpg')}}" alt="User Image">

                                        <div class="comment-text">
                    <span class="username">
                      Maria Gonzales
                      <span class="text-muted float-right">8:03 PM Today</span>
                    </span><!-- /.username -->
                                            It is a long established fact that a reader will be distracted
                                            by the readable content of a page when looking at its layout.
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                    <!-- /.card-comment -->
                                    <div class="card-comment">
                                        <!-- User image -->
                                        <img class="img-circle img-sm" src="{{asset('dist/img/user4-128x128.jpg')}}" alt="User Image">

                                        <div class="comment-text">
                    <span class="username">
                      Luna Stark
                      <span class="text-muted float-right">8:03 PM Today</span>
                    </span><!-- /.username -->
                                            It is a long established fact that a reader will be distracted
                                            by the readable content of a page when looking at its layout.
                                        </div>
                                        <!-- /.comment-text -->
                                    </div>
                                    <!-- /.card-comment -->
                                </div>
                                <!-- /.card-footer -->
                                <div class="card-footer">
                                    <form action="#" method="post">
                                        <img class="img-fluid img-circle img-sm" src="{{asset('dist/img/user4-128x128.jpg')}}" alt="Alt Text">
                                        <!-- .img-push is used to add margin to elements next to floating images -->
                                        <div class="img-push">
                                            <input type="text" class="form-control form-control-sm" placeholder="Press enter to post comment">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
        {{ $data->links() }}

            {{--</div>--}}
{{--        </div>--}}

    </div>
</div>
@endsection
