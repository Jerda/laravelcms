@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <blockquote class="layui-elem-quote">
            <div class="layui-inline">
                <input type="text" v-model="search_nickname" placeholder="请输入昵称"
                       class="layui-input-inline header-input header-input-one">
            </div>
            <button class="layui-btn layui-btn-sm layui-btn-primary" @click="search">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            <div class="layui-inline">
                <a class="layui-btn layui-btn-sm" id="import" href="javascript:void(0)" @click="synchronize">
                    <i class="layui-icon"></i> 同步微信用户
                </a>
                <a class="layui-btn layui-btn-sm" id="import" href="javascript:void(0)" @click="showGroup">
                    <i class="layui-icon"></i> 用户分组
                </a>
            </div>


            {{--<form class="layui-form">
                <div class="layui-form-pane">
                    <input type="text" name="nickname" class="layui-input-inline">
                </div>
                <button class="layui-btn layui-btn-sm layui-btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </button>
            </form>--}}
        </blockquote>
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
                <td style="text-align: center;">
                    <img :src="user.wechat.avatar" width="50" height="50">
                </td>
                <td>@{{ user.wechat.nickname }}</td>
                <td>@{{ user.wechat.name }}</td>
                <td>
                    <div v-if="user.wechat.sex == 1">男</div>
                    <div v-else>女</div>
                </td>
                <td>@{{ user.wechat.city }}</td>
                <td style="width:170px">@{{ user.wechat.subscribe_time }}</td>
                <td style="width:135px">
                    <button class="layui-btn layui-btn-sm">查看</button>
                    <button class="layui-btn layui-btn-sm">删除</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div id="page"></div>
    </div>
@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var url = {
            get_users: "{{ url('admin/user/getUsers') }}",
            synchronize_user: "{{ url('admin/user/user_wechat/synchronize_user') }}",
            group: "{{ url('admin/user/user_wechat/group') }}",
        };
        //头像、昵称 姓名 城市 关注时间
        var vue = new Vue({
            el: "#app",
            data: {
                first: 1,
                users: '',
                count: '',
                current_page: 1,
                limit: parent.PAGE_LIMIT,
                search_nickname: '',
                _search: []
            },
            methods: {
                synchronize: function () {
                    var load = parent.layer.load(0, {shade: false});
                    axios.post(url.synchronize_user, {}).then(response => {
                        toastr.success(response.data.msg);
                        this.getUsers();
                        parent.layer.close(load);
                    });
                },
                getUsers: function () {
                    axios.post(url.get_users, {limit: this.limit, page: this.current_page, search: this._search})
                        .then(response => {
                            this.users = response.data.data.data;
                            this.count = response.data.data.total;
                            this.current_page = response.data.data.current_page;

                            if (this.first === 1) {
                                this.first = 2;
                                pageLinks(this);
                            }
                        });
                },

                showGroup: function () {
                    cms_s_edit('用户分组', url.group, '400', '420');
                },
                search: function() {
                    if (this.search_nickname !== '') {
                        this._search = [{nickname: this.search_nickname}];
                    } else {
                        this._search = [];
                    }
                    this.first = 1;
                    this.getUsers();
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getUsers();
                })
            }
        });


    </script>
@endsection
