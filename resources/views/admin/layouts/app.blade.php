<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.layouts.meta')
    <title>{{ $title }}</title>
    @yield('meta')
</head>
<body class="layui-layout-bod">
<div class="layui-layout layui-layout-admin kit-layout-admin">
    @include('admin.layouts.header')
    @include('admin.layouts.menu')
    <div class="layui-body" id="container">
        <div style="padding: 15px;">
        </div>
        {{--@yield('content')--}}
    </div>
</div>
@include('admin.layouts.footer')
<script type="text/javascript">
    var message;

    var ADMIN = "{{ asset('plugins') }}";

    var MAIN = "{{ url('admin/user/index') }}";    //首页显示URL

    layui.config({
        base: "{{ asset('plugins/build/js') }}" + "/"
    }).use(['app', 'message'], function () {
        var app = layui.app,
            $ = layui.jquery,
            layer = layui.layer;
        //将message设置为全局以便子页面调用
        message = layui.message;
        //主入口
        app.set({
            type: 'iframe'
        }).init();
    });
</script>
@yield('script')
</body>
</html>
