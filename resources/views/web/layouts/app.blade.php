<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- <title>Amaze UI Admin index Examples</title> -->
        <title>@yield('title')</title>
        <meta name="description" content="这是一个 index 页面">
        <meta name="keywords" content="index">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit">
        <meta http-equiv="Cache-Control" content="no-siteapp" />
        <!-- <link rel="icon" type="image/png" href="i/favicon.png"> -->
        <!-- <link rel="apple-touch-icon-precomposed" href="i/app-icon72x72@2x.png"> -->
        <meta name="apple-mobile-web-app-title" content="Amaze UI" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <link rel="stylesheet" href="css/amazeui.min.css" />
        <link rel="stylesheet" href="css/admin.css">
        <link rel="stylesheet" href="css/app.css">
    </head>
    <body>
        <div>
            <!-- @include('bw.layouts.navigation') -->
            @include('bw.layouts.topnavbar')
            @yield('content')
            @include('bw.layouts.footer')
        </div>
    </body>
</html>