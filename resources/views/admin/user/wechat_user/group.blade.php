@extends('admin.layouts.pop')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        {{--<div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->--}}
<<<<<<< HEAD
        <button class="layui-btn layui-btn-sm" @click="synchronize">同步用户分组</button>
        <form role="form" id="form">
            <div class="box-body">
                <div class="form-group">
                </div>
            </div>
=======
        <div class="box-body">
            <div class="form-group">
                <button class="layui-btn layui-btn-sm" @click="synchronize">同步用户分组</button>
                <button class="layui-btn layui-btn-sm" @click="addGroup">添加用户分组</button>
            </div>
        </div>
        <form role="form" id="form">
>>>>>>> tsq
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

        var url = {
<<<<<<< HEAD
            synchronize: "{{ url('admin/user/user_wechat/synchronize_user_group') }}",
=======
            synchronize: "{{ url('admin/user/user_wechat/group/synchronize') }}",
>>>>>>> tsq
        };

        new Vue({
            el: "#app",
            data: {
                groups: ''
            },
            methods: {
<<<<<<< HEAD
                synchronize: function() {
                    this.$http.post(url.synchronize, {}).then(respond => {
                        parent.message.show({
                            skin: 'cyan',
                            msg: respond.body.msg
                        });
                    });
                },
=======
                synchronize: function () {
                    this.$http.post(url.synchronize, {}).then(respond => {
                        this.groups = respond.body.data;
                    });
                },
                addGroup: function () {

                },
>>>>>>> tsq
            },
        });
    </script>
@endsection