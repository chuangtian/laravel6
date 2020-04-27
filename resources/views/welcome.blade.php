<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="http://106.13.232.160:81/css/app.css" rel="stylesheet">
        <script src="{{asset('assets/js/plugin/sweetalert/sweetalert.min.js')}}"></script>
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">

                    <div class="card-body">
                        <form   name="form"  enctype="multipart/form-data" onsubmit="return send()">

                            <div class="form-group  text-md-center">
                               <h1>ID:{{$id}}</h1>
                            </div>
                            <input type="hidden" id="tid" value="{{$id}}">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">couid</label>

                                <div class="col-md-6">
                                    <input id="couid"  type='text' onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')" class="form-control " name="couid" value="" required="" autocomplete="name" autofocus="">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">olid</label>

                                <div class="col-md-6">
                                    <input id="olid" type='text' onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"  class="form-control " name="olid" value="" required="" autocomplete="olid">

                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">totalTime</label>

                                <div class="col-md-6">
                                    <input id="totalTime" type='text' onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"  class="form-control " name="totalTime" required="" autocomplete="new-password">

                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        提交
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

    </body>
<script>
    function send() {
        tid=$('#tid').val();
        couid=$('#couid').val();
        olid=$('#olid').val();
        totalTime=$('#totalTime').val();
        var formData = new FormData();
        formData.append("_token", "{{csrf_token()}}");
        formData.append("id", tid);
        formData.append("couid", couid);
        formData.append("olid", olid);
        formData.append("totalTime", totalTime);

        $.ajax({
            url:"{{ url('/addAixueSave') }}",
            type:"POST",
            data:formData,
            processData : false,
            contentType : false,
            dataType : 'json',
            async : false,
            success : function (result) {
                if(result===200){
                    swal('添加成功', {
                        icon: "success",
                        buttons : {
                            confirm : {
                                className: 'btn btn-success'
                            }
                        }
                    });
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
                swal("服务器问题", "hhhh", {
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
</html>
