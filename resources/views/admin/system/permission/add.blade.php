@extends('admin.layouts.iframe_app')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        <form role="form" id="form" class="">
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">选择父级</label>
                <div class="layui-input-inline">
                    <select v-model="parent_id">
                        <option value="0">一级权限</option>
                        <option v-for="levelOne in levelOnes" :value="levelOne.id" v-html="levelOne.name"></option>
                    </select>
                </div>
            </div>
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
            getAllPermission: "{{ url('admin/system/permission/getAll') }}",
            add: "{{ url('admin/system/permission/add') }}"
        };

        new Vue({
            el: '#app',
            data: {
                name: '',
                levelOnes: '',
                parent_id: 0,
            },
            methods: {
                getPermission: function() {
                    axios.post(url.getAllPermission, {parent_id:this.parent_id}).then(response => {
                        if (this.parent_id === 0) {
                            this.levelOnes = response.data.data;
                        }
                    });
                },
                add: function() {
                    axios.post(url.add, {parent_id:this.parent_id, name:this.name}).then(response => {
                        success(response.data.msg, {go:-1});
                    });
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getPermission();
                })
            }

        });
    </script>
@endsection