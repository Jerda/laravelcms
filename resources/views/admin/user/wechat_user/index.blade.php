@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <div class="">
            <a class="layui-btn layui-btn-small" id="import" href="javascript:void(0)" @click="synchronize">
                <i class="layui-icon"></i> 同步微信用户
            </a>
            <a class="layui-btn layui-btn-small" id="import" href="javascript:void(0)" @click="showGroup">
                <i class="layui-icon"></i> 用户分组
            </a>
        </div>
        <table id="table" class="layui-table">
            <thead>
                <tr>
                    <th>头像</th>
                    <th>昵称</th>
                    <th>姓名</th>
                    <th>性别</th>
                    <th>城市</th>
                    <th>关注时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users">
                    <td>
                        {{--<img src=" @{{ user.wechat.avatar }}">--}}
                    </td>
                    <td>@{{ user.wechat.nickname }}</td>
                    <td>@{{ user.wechat.name }}</td>
                    <td>
                        <div v-if="user.wechat.sex == 1">男</div>
                        <div v-else>女</div>
                    </td>
                    <td>@{{ user.wechat.city }}</td>
                    <td style="width:170px">@{{ user.wechat.subscribe_time }}</td>
                    <td  style="width:135px">
                        <button class="layui-btn layui-btn-sm">查看</button>
                        <button class="layui-btn layui-btn-sm">删除</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
@section('script')
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

        var url = {
            get_users: "{{ url('admin/user/getUsers') }}",
            synchronize_user: "{{ url('admin/user/user_wechat/synchronize_user') }}",
            group: "{{ url('admin/user/user_wechat/group') }}",
        };
        //头像、昵称 姓名 城市 关注时间
        new Vue({
            el: "#app",
            data: {
                users: '',
                current_page: '',
                limit: 15
            },
            methods: {
                synchronize: function() {
                    let load = layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    this.$http.post(url.synchronize_user, {}).then(respond => {
                       layer.close(load);
                       layer.msg(respond.body.msg);
                       this.getUsers();
                    });
                },
                getUsers: function() {
                    this.$http.post(url.get_users, {limit: this.limit}).then(respond => {
                        this.users = respond.body.data.data;
                        this.current_page = respond.body.data.current_page;
                    });
                },
                showGroup: function() {
                    cms_s_edit('用户分组', url.group, '400', '420');
                },
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getUsers();
                })
            }
        });
    </script>
@endsection