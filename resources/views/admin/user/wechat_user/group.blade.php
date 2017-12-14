@extends('admin.layouts.iframe_app')
<style>
    .custom_group{
        border: 1px solid #e2dfdf;
        background-color: #f2f2f2;
        height: 35px;
        width: 280px;
        text-align: left;
        line-height: 35px;
        margin-top: 5px;
    }
    .custom_group_hidden{
        display:none;
    }
    .custom_group p{
        margin-left: 10px;
        float:left;
    }
    .custom_group input{
        width: 170px;
        height: 35px;
        margin-left: 10px;
        border: 0;
        background: #f2f2f2;
    }
    .custom_group_red{
        border: 1px solid red;
    }
    .custom_group button{
        float: right;
        margin-right: 1px;
        margin-top: 2px;
    }
</style>
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        <div class="layui-form-item">
            <div class="layui-col-md6">
                <fieldset class="layui-elem-field">
                    <legend>用户分组</legend>
                    <div class="layui-field-box">
                        <div class="layui-form-item">
                            <button class="layui-btn" @click="synchronize">同步分组</button>
                        </div>
                        <div class="layui-form-item">
                            <user-groups v-for="group in groups" :group="group"></user-groups>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="layui-col-md6">
                <fieldset class="layui-elem-field">
                    <legend>添加分组</legend>
                    <div class="layui-field-box">
                        <div class="layui-form-item">
                            <input type="text" class="layui-input" v-model="group_name">
                        </div>
                        <div class="layui-form-item">
                            <div class="layui-input-block">
                                <a class="layui-btn" ref="add" @click="addGroup($event)">添加用户分组</a>
                                <a class="layui-btn" onclick="history.go(-1)">返回</a>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <script type="text/x-template" id="user-groups">
        <div class="custom_group" :class="[isReadOnly ? '' : 'custom_group_red', isShow ? '': 'custom_group_hidden']">
            <input type="text" :value="group.name" :readonly="isReadOnly" v-focus="isReadOnly" v-blur="isReadOnly"
                   v-on:input="group.name = $event.target.value">
            <button class="layui-btn layui-btn-sm layui-btn-default" @click="del(group.group_id)">删除</button>
            <button class="layui-btn layui-btn-sm" @click="edit" v-text="isReadOnly ? '编辑' : '确定'">编辑</button>
        </div>
    </script>
@endsection
@section('script')
    <script type="text/javascript">
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var url = {
            synchronize: "{{ url('admin/user/user_wechat/synchronize_user_group') }}",
            add: "{{ url('admin/user/user_wechat/add_user_group') }}",
            modify: "{{ url('admin/user/user_wechat/modify_user_group') }}",
            getGroups: "{{ url('admin/user/user_wechat/getGroups') }}",
            del: "{{ url('admin/user/user_wechat/delGroup') }}"
        };

        Vue.component('user-groups', {
            template: '#user-groups',
            props: ['group'],
            data: function () {
                return {
                    isReadOnly: true,
                    isShow: true,
                }
            },
            methods: {
                edit: function() {
                    if(this.isReadOnly === false) {
                        console.log(this.group.name);
                        var load = parent.layer.load(0, {shade: false});
                        axios.post(url.modify, {group_id:this.group.group_id, name:this.group.name}).then(response => {
                            parent.layer.close(load);
                            success(response.data.msg);
                        });
                    }

                    this.isReadOnly = !this.isReadOnly;

                },
                del: function(group_id) {
//                    console.log(this);
                    var load = parent.layer.load(0, {shade: false});
                    axios.post(url.del, {group_id:group_id}).then(response => {
                        parent.layer.close(load);
                        success(response.data.msg);
                        this.isShow = false;
                    });
                }
            },
            directives: {
                focus: {
                    update: function (el, {value}) {
                        if (!value) {
                            el.focus()
                        } else {
                            console.log(1);
                        }
                    }
                },
                blur: {
                    update: function (el, {value}) {
                           console.log(2);
                        }
                    }
            },
        });

        new Vue({
            el: "#app",
            data: {
                groups: '',
                group_name: '',
            },
            methods: {
                synchronize: function () {
                    var load = parent.layer.load(0, {shade: false});
                    axios.post(url.synchronize, {}).then(response => {
                        this.getGroups();
                        parent.layer.close(load);
                        success(response.data.msg);
                    });
                },
                addGroup: function(event) {
                    if (this.group_name === '') {
                        toastr.success('必须填写分组名称');
                    } else {
                        axios.post(url.add, {name: this.group_name}).then(response => {
                            if (response.data.status === 1) {
                                success(response.data.msg);
                                this.group_name = '';
                                this.synchronize();
                            } else {
                                error(response.data.msg);
                            }
                        });
                    }
                },
                getGroups: function() {
                    axios.post(url.getGroups, {}).then(response => {
                        this.groups = response.data.data;
                    });
                },
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getGroups();
                })
            }
        });
    </script>
@endsection