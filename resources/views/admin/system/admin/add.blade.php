@extends('admin.layouts.iframe_app')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        <form role="form" id="form" class="">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">权限名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" class="layui-input" id="name" v-model="name">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a class="layui-btn" @click="add">添加权限</a>
                    <a class="layui-btn" onclick="history.go(-1)">返回</a>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var url = {
            add: "{{ url('admin/system/permission/add') }}"
        };

        new Vue({
            el: '#app',
            data: {
                name: ''
            },
            methods: {
                add: function() {
                    axios.post(url.add, {name: this.name}).then(response => {
                        toastr.success(response.data.msg);
                    });
                }
            }

        });
    </script>
@endsection