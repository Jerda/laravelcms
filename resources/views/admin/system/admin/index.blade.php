@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <blockquote class="layui-elem-quote">
            <a href="{{ url('admin/system/admin/add') }}" class="layui-btn layui-btn-sm">
                <i class="layui-icon"></i> 添加管理员
            </a>
        </blockquote>
        <fieldset class="layui-elem-field">
            <legend>管理员管理</legend>
            <div class="layui-field-box layui-form">
                <table class="layui-table admin-table">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="admin in admins">
                            <td>@{{ admin.username }}</td>
                            <td>
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-normal">修改</a>
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-normal">权限</a>
                                <a type="button" class="layui-btn layui-btn-sm"
                                    :class="admin.username == 'Admin' ? 'layui-btn-disabled' : 'layui-btn-danger'">删除</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <blockquote class="layui-elem-quote">
            <h3>注意:</h3>
            <br>
            。。。。。
        </blockquote>
    </div>

@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var url = {
            getAll: "{{ url('admin/system/admin/getAll') }}"
        };

        new Vue({
            el: '#app',
            data: {
                admins: ''
            },
            methods: {
                getAll: function() {
                    axios.post(url.getAll, {}).then(response => {
                        this.admins = response.data.data;
                    });
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getAll();
                })
            }
        });
    </script>
@endsection
