@extends('admin.layouts.iframe_app')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


    </script>
@endsection
