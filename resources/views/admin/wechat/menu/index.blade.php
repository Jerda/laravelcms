@extends('admin.layouts.iframe_app')
@section('content')
    <div class="admin-main" id="app">
        <blockquote class="layui-elem-quote">
            <a href="{{ url('admin/wechat/menu/add') }}" class="layui-btn layui-btn-sm">
                <i class="layui-icon"></i> 添加菜单
            </a>
            <a href="#" class="layui-btn layui-btn-sm" id="import" @click="issueMenus">
                <i class="layui-icon"></i> 发布菜单
            </a>
            <a href="#" class="layui-btn layui-btn-sm" id="import">
                <i class="layui-icon"></i> 同步菜单
            </a>
        </blockquote>
        <fieldset class="layui-elem-field">
            <legend>微信按钮</legend>
            <div class="layui-field-box layui-form">
                <table class="layui-table admin-table">
                    <thead>
                    <tr>
                        <th>名称</th>
                        <th>类型</th>
                        <th>连接</th>
                        <th>关键字</th>
                        <th>关键字操作</th>
                    </tr>
                    </thead>
                    <tbody id="content">
                    <template v-for="(menu, index) in menus">
                        <tr>
                            <td>@{{ menu.name }}</td>
                            <td>@{{ menu.type }}</td>
                            <td>@{{ menu.url }}</td>
                            <td>@{{ menu.key_word }}</td>
                            <td style="width: 240px">
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-normal" @click="menuModify(menu.id)">修改</a>
                                <a type="button" class="layui-btn layui-btn-sm layui-btn-danger" @click="menuDel(menu.id)">删除</a>
                                <a type="button" class="layui-btn layui-btn-sm" :class="index == 0 ? 'layui-btn-disabled' : ''"
                                   @click="modifyIndex(menu.parent_id, menu.sort_id, 'up')">上移</a>
                                <a type="button" class="layui-btn layui-btn-sm"
                                   :class="index == menus.length - 1 ? 'layui-btn-disabled' : ''"
                                   @click="modifyIndex(menu.parent_id, menu.sort_id, 'down')">下移</a>
                            </td>
                        </tr>
                        <template v-if="menu.children !== 'undefined'">
                            <tr v-for="(child, _index) in menu.children">
                                <td v-html="child.name"></td>
                                <td>@{{ child.type }}</td>
                                <td>@{{ child.url }}</td>
                                <td>@{{ child.key_word }}</td>
                                <td>
                                    <a type="button" class="layui-btn layui-btn-sm layui-btn-normal" @click="menuModify(child.id)">修改</a>
                                    <a type="button" class="layui-btn layui-btn-sm layui-btn-danger" @click="menuDel(child.id)">删除</a>
                                    <a type="button" class="layui-btn layui-btn-sm" :class="_index == 0 ? 'layui-btn-disabled' : ''"
                                       @click="modifyIndex(child.parent_id, child.sort_id, 'up')">上移</a>
                                    <a type="button" class="layui-btn layui-btn-sm"
                                       :class="_index == menu.children.length - 1 ? 'layui-btn-disabled' : ''"
                                       @click="modifyIndex(child.parent_id, child.sort_id, 'down')">下移</a>
                                </td>
                            </tr>
                        </template>
                    </template>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <blockquote class="layui-elem-quote">
            <h3>注意:</h3>
            <br>
            1.自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单<br>
            2.一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。
        </blockquote>
    </div>

@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var url = {
            addMenu: "{{ url('admin/wechat/menu/add') }}",
            getMenus: "{{ url('admin/wechat/menu/getMenus') }}",
            modifySortId: "{{ url('admin/wechat/menu/modifySortId') }}",
            showModify: "{{ url('admin/wechat/menu/showModify') }}",
            menuDel: "{{ url('admin/wechat/menu/del') }}",
            issueMenu: "{{ url('admin/wechat/menu/issue') }}",
            getLevelOnes: "{{ url('admin/wechat/menu/getLevelOnes') }}",
        };

        new Vue({
            el: "#app",
            data: {
                menus: [],
            },
            methods: {
                addMenu: function() {
//                    cms_s_edit('添加菜单', url.addMenu, '450', '420');
                },
                getMenus: function() {
                    axios.post(url.getMenus, {}).then(response => {
                        this.menus = response.data.data;
                    });
                },
                menuModify: function (id) {
                    let _url = url.showModify + '/' + id;
                    cms_s_edit('修改菜单', _url, '400', '400');
                },
                menuDel: function (id) {
                    let _this = this;
                    parent.layer.confirm('确定要删除此按钮？', {
                        btn: ['确认','取消']
                    }, function(index){
                        parent.layer.close(index);
                        axios.post(url.menuDel, {id: id}).then(response => {
                            console.log(response.data);
                            if (response.data.status == 1) {
                                success(response.data.msg);
                                _this.getMenus();
                            } else {
                                error(response.data.msg)
                            }
                        });
                    });
                },
                modifyIndex: function (parent_id, sort_id, direction) {
                    let load = parent.layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    let data = {parent_id: parent_id, sort_id: sort_id, direction: direction};
                    axios.post(url.modifySortId, data).then(response => {
                        parent.layer.close(load);
                        this.getMenus();
                    });
                },
                issueMenus: function () {
                    let load = parent.layer.load(1, {
                        shade: [0.1,'#fff'] //0.1透明度的白色背景
                    });
                    axios.post(url.issueMenu).then(response => {
                        console.log(1);
                        console.log(response.data);
                        if (response.data.status === 1) {
                            toastr.success(response.data.msg);
                        } else {
                            toastr.error(response.data.msg);
                        }

                        parent.layer.close(load);
                    });
                },
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getMenus();
                })
            }
        });
    </script>
@endsection
