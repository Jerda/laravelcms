@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <blockquote class="layui-elem-quote">
            <a href="{{ url('admin/system/permission/add') }}" class="layui-btn layui-btn-sm">
                <i class="layui-icon"></i> 添加权限
            </a>
        </blockquote>
        <fieldset class="layui-elem-field">
            <legend>权限管理</legend>
            <div class="layui-field-box layui-form">
                <table class="layui-table admin-table">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="permission in permissions">
                            <td v-html="permission.name"></td>
                            <td>
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-normal">修改</a>
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-danger" @click="del(permission.id)">删除</a>
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
            getAll: "{{ url('admin/system/permission/getAll') }}",
            del: "{{ url('admin/system/permission/del') }}"
        };

        new Vue({
            el: '#app',
            data: {
                permissions: ''
            },
            methods: {
                getAll: function() {
                    axios.post(url.getAll, {}).then(response => {
                        this.permissions = response.data.data;
                    });
                },
                del: function(id) {
                    axios.post(url.del, {id:id}).then(response => {
                        if (response.data.status === 0) {
                            error(response.data.msg);
                        } else {
                            success(response.data.msg);
                            this.getAll();
                        }
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
