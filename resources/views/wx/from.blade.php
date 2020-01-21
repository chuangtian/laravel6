<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Atlantis Lite - Bootstrap 4 Admin Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{asset('assets/img/icon.ico')}}" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="{{asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ["{{asset('assets/css/fonts.min.css')}}"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>


    <!-- CSS Files -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/atlantis.min.css')}}">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}">
</head>
<body>
<form method="POST" action="{{ route('w_sendMessage') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="me_UserName" value="{{$me_UserName}}">
    <input type="hidden" name="uid" value="{{$uid}}">

    <div class="selectgroup selectgroup-pills">
        @foreach ($data as $value)
        <label class="selectgroup-item">
            <input type="checkbox" name="user[]" value="{{$value->UserName}}" class="selectgroup-input" >
            <span class="selectgroup-button">{{$value->NickName}}</span>
        </label>
        @endforeach
    </div>
    <br/><br/>
    <div class="form-group form-floating-label">
        <input id="inputFloatingLabel" type="text" name="message" class="form-control input-border-bottom" required>
        <label for="inputFloatingLabel" class="placeholder">信息</label>
    </div>
    <div class="form-group form-floating-label">
        <label for="inputFloatingLabel">发送时间</label>
        <input id="inputFloatingLabel" type="datetime-local" name="time" class="form-control input-border-bottom" required>

    </div>
    <div class="card-action">
        <button class="btn btn-success">Submit</button>

    </div>
</form>
</body>
</html>