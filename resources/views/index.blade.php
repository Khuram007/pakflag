<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Pak Flag</title>
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/fontawesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap-datetimepicker.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
        <link rel="stylesheet" href="{{mix('/css/app.css')}}">
    </head>
    <body>
        <div id="app">
          <app></app>
        </div>
{{--        <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>--}}
        <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
        <script src="{{asset('assets/js/popper.min.js')}}"></script>
        <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/main.js')}}"></script>
        <script src="{{asset('assets/js/feather.min.js')}}"></script>
        <script src="{{asset('assets/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
{{--        <script src="{{asset('assets/plugins/apexchart/apexcharts.min.js')}}"></script>--}}
{{--                <script src="{{asset('assets/plugins/apexchart/chart-data.js')}}"></script>--}}
{{--        <script src="{{asset('assets/plugins/select2/js/select2.min.js')}}"></script>--}}
{{--        <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>--}}
{{--        <script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}'"></script>--}}
        <script src="{{asset('assets/js/script.js')}}"></script>
        <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>

