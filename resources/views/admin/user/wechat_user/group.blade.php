@extends('admin.layouts.pop')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        {{--<div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->--}}
        <div class="box-body">
            <div class="form-group">
                <button class="layui-btn layui-btn-sm" @click="synchronize">同步用户分组</button>
            </div>
            <div class="form-group">
                <input type="text" class="layui-input" v-model="group_name">
                <button class="layui-btn layui-btn-sm" @click="addGroup">添加用户分组</button>
            </div>
        </div>
        <form role="form" id="form">
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

        var url = {
            synchronize: "{{ url('admin/user/user_wechat/synchronize_user_group') }}",
            add: "{{ url('admin/user/user_wechat/add_user_group') }}",
            modify: "{{ url('admin/user/user_wechat/modify_user_group') }}",
        };

        new Vue({
            el: "#app",
            data: {
                groups: '',
                group_name: ''
            },
            methods: {
                synchronize: function () {
                    var load = parent.layer.load(0, {shade: false});

                    this.$http.post(url.synchronize, {}).then(respond => {
                        parent.layer.close(load);
                        parent.message.show({
                            skin: 'cyan',
                            msg: respond.body.msg
                        });
                    });
                },
                addGroup: function() {

                    if (this.group_name === '') {
                        parent.message.show({
                            skin: 'red',
                            msg: '必须填写分组名称'
                        });
                    } else {
                        this.$http.post(url.add, {name: this.group_name}).then(respond => {
                            if (respond.body.status === 1) {
                                parent.message.show({
                                    skin: 'cyan',
                                    msg: respond.body.msg
                                });
                            } else {
                                parent.message.show({
                                    skin: 'red',
                                    msg: respond.body.msg
                                });
                            }
                        });
                    }
                }
            },
        });
    </script>
@endsection