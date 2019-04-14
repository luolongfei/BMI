<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-transform"> {{--防止被转码--}}
    <meta http-equiv="Cache-Control" content="no-siteapp"> {{--防止被转码--}}
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>BMI测试 | 计算身体质量指数</title>
    <meta name="description" content="计算身体质量指数">
    <meta name="keywords" content="BMI">
    <link rel="icon" href="/favicon.png" type="image/x-icon">
    <!-- common css -->
    <link href="/bootstrap4/bootstrap.min.css" rel="stylesheet">
    <link href="/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/loaders/loaders.min.css" rel="stylesheet">
    <!-- end common css -->
    <!-- 当前页单独css -->
    @stack('css')
    <!-- end 当前页单独css -->
</head>
<body>
@includeIf('common.header')
@yield('content')
@includeIf('common.footer')
<!-- common js -->
<script src="/js/jquery-3.4.0.min.js"></script>
<script src="/bootstrap4/bootstrap.min.js"></script>
<script src="/js/sweetalert.min.js"></script>
<script src="/loaders/loaders.css.js"></script>
<script src="/js/common.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<!-- end common js -->
<!-- 当前页单独js -->
@stack('js')
<!-- end 当前页单独js -->
<!-- 流量统计 -->
<div style="display: none;">
    <script type="text/javascript" src="https://s5.cnzz.com/z_stat.php?id=1277108746&web_id=1277108746"></script>
</div>
<!-- end 流量统计 -->
</body>
</html>