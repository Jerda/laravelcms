@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <blockquote class="layui-elem-quote">
            <input type="text" v-model="search_nickname" placeholder="请输入昵称"
                   class="layui-input-inline header-input">
            <input type="text" v-model="search_start_time" id="start_time" placeholder="yyyy-MM-dd"
                   class="layui-input-inline header-input">
            <input type="text" v-model="search_end_time" id="end_time" placeholder="yyyy-MM-dd"
                   class="layui-input-inline header-input">
            <button class="layui-btn layui-btn-sm layui-btn-primary" @click="search">
                <i class="fa fa-search" aria-hidden="true"></i>
            </button>
            <button class="layui-btn layui-btn-sm layui-btn-primary" @click="searchClear">
                清空
            </button>
            <a class="layui-btn layui-btn-sm" id="import" href="javascript:void(0)" @click="synchronize">
                <i class="layui-icon"></i> 同步微信用户
            </a>
            <a class="layui-btn layui-btn-sm" href="{{ url('admin/user/user_wechat/group') }}">
                <i class="layui-icon"></i> 用户分组
            </a>
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
                <th style="width:50px">头像</th>
                <th>昵称</th>
                <th>姓名</th>
                <th>性别</th>
                <th>城市</th>
                <th>分组</th>
                <th>关注时间</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users">
                <td style="text-align: center;">
                    <img :src="user.wechat.avatar" width="40" height="40">
                </td>
                <td>@{{ user.wechat.nickname }}</td>
                <td>@{{ user.wechat.name }}</td>
                <td>
                    <div v-if="user.wechat.sex == 1">男</div>
                    <div v-else>女</div>
                </td>
                <td>@{{ user.wechat.city }}</td>
                <td>@{{ user.wechat.group.name }}</td>
                <td style="width:170px">@{{ user.created_at }}</td>
                <td style="width:135px">
                    <a class="layui-btn layui-btn-sm" href="{{ url('admin/user/user_wechat/detail') }}">查看</a>

                    {{--<div class="custom-btn-group">
                        <button class="layui-btn layui-btn-sm dropdown-toggle" data-toggle="dropdown" type="button">按钮下拉菜单<span
                                    class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a class="layui-btn layui-btn-sm" href="##">按钮下拉菜单项</a></li>
                            <li><a class="layui-btn layui-btn-sm" href="##">按钮下拉菜单项</a></li>
                            <li><a class="layui-btn layui-btn-sm" href="##">按钮下拉菜单项</a></li>
                            <li><a class="layui-btn layui-btn-sm" href="##">按钮下拉菜单项</a></li>
                        </ul>
                    </div>--}}

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

        var vue = new Vue({
            el: "#app",
            data: {
                first: 1,
                users: '',
                count: '',
                current_page: 1,
                limit: parent.PAGE_LIMIT,
                search_nickname: '',
                search_start_time: '',
                search_end_time: '',
                _search: [],
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
                search: function () {
                    var _data = [];

                    if (this.search_nickname !== '') {
                        _data.push({nickname: this.search_nickname});
                    }

                    if (this.search_start_time !== '') {
                        _data.push({start_time: this.search_start_time});
                    }

                    if (this.search_end_time !== '') {
                        _data.push({end_time: this.search_end_time});
                    }
                    this._search = _data;
                    this.first = 1;
                    this.getUsers();
                },
                searchClear: function () {
                    this.search_nickname = '';
                    this.search_start_time = '';
                    this.search_end_time = '';
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getUsers();
                })
            }
        });



        layui.use(['form', 'layedit', 'laydate'], function() {
            var form = layui.form
                , layer = layui.layer
                , layedit = layui.layedit
                , laydate = layui.laydate;

            //日期
            laydate.render({
                elem: '#start_time'
                ,done: function(value, date){ //监听日期被切换
                    Vue.set(vue, 'search_start_time', value);
                }
            });
            laydate.render({
                elem: '#end_time'
                ,done: function(value, date){ //监听日期被切换
                    Vue.set(vue, 'search_end_time', value);
                }
            });
        });
    </script>
@endsection
