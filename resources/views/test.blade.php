<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

{{--    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">--}}
{{--    <script src="https://cdn.staticfile.org/jquery/2.1.1/jquery.min.js"></script>--}}
{{--    <script src="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">






</head>

<div class="my-container container">
    <div class="col-xs-12" style="min-height: 600px;" id="hh">
        1
    </div>
</div>
<script src="{{ asset('js/broadcasting.js') }}" defer></script>
{{--<script src="{{ asset('js/private.js') }}" defer></script>--}}

</html>
