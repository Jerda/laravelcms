<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.layouts.meta')
    <title>{{ $title }}</title>
    @yield('meta')
</head>
<body class="layui-layout-bod">
<div class="layui-layout layui-layout-admin">
    @include('admin.layouts.header')
    @include('admin.layouts.menu')
    <div class="layui-body">
        <div style="padding: 15px;">
            @yield('nav')
        </div>
        <iframe name="main_iframe" src="{{ url('admin/_index') }}" style="width:100%"></iframe>
        {{--@yield('content')--}}
    </div>
</div>
@include('admin.layouts.footer')
@yield('script')
</body>
</html>
