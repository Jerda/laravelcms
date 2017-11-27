<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('admin.layouts.meta')
    @stack('css')
</head>
<body>
@yield('content')
@include('admin.layouts.footer')
@yield('script')
</body>
</html>