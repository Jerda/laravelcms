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

</script>
@yield('script')
</body>
</html>
