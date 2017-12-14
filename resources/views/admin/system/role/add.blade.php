@extends('admin.layouts.iframe_app')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        <div class="layui-form-item">
            <div class="layui-col-md6">
                <fieldset class="layui-elem-field">
                    <legend>选择权限</legend>
                    <div class="layui-field-box">
                        <div class="layui-collapse"></div>
                        {{--<ul id="tree"></ul>--}}
                    </div>
                </fieldset>
            </div>
            <div class="layui-col-md6">
                <fieldset class="layui-elem-field">
                    <legend>角色设置</legend>
                    <div class="layui-field-box">
                        <div class="layui-form-item">
                            <label for="name" class="layui-form-label">角色名称</label>
                            <div class="layui-input-block">
                                <input type="text" name="name" class="layui-input" id="name" v-model="name">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <div class="layui-input-inline">
                                    <a class="layui-btn" @click="add">添加角色</a>
                                    <a class="layui-btn" onclick="history.go(-1)">返回</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var data;

        var url = {permissions: "{{ url('admin/system/permission/getPermissionsByTree') }}"};

        axios.post(url.permissions, {}).then(response =>  {
            data = response.data.data;
            var html = '';

            for (value in data) {
                console.log(data[value].name);
                html += "<div class='layui-colla-item'>" + "<h2 class='layui-colla-title'>" + data[value].name + "</h2>";
                if (data[value]['children'] !== undefined) {

                    for (val in data[value].children) {
                        html += "<div class='layui-colla-content layui-show'>" + data[value].children[val].name + "</div>";
                    }
                }

                html += "</div>";
            }

            $(".layui-collapse").html(html);

            layui.use('element', function () {});
        });

    </script>
    <script>

        var url = {
            add: "{{ url('admin/system/role/add') }}"
        };

        new Vue({
            el: '#app',
            data: {
                name: ''
            },
            methods: {
                add: function () {
                    axios.post(url.add, {name: this.name}).then(response => {
                        toastr.success(response.data.msg);
                    });
                }
            },
            mounted: function () {
                this.$nextTick(function () {

                })
            }

        });
    </script>
@endsection