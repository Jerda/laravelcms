@extends('admin.layouts.iframe_app')
@section('content')
    <div class="box box-primary" style="border-top:0" id="app">
        {{--<div class="box-header with-border">
            <h3 class="box-title">Quick Example</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->--}}
        <form role="form" id="form" class="">
            <div class="layui-form-item">
                <!-- <div v-for="level in levelOnes">
                </div> -->
                <label for="parent_id" class="layui-form-label">上级菜单</label>
                <div class="layui-input-inline">
                    <select name="parent_id" id="parent_id" v-model="parent_id">
                        <option disabled value="">请选择</option>
                        {{--<option id="levelOne" value='0' :disabled="addableLevelOne ? false : true"
                                v-text="addableLevelOne ? '1级菜单' : '1级菜单（1级菜单数量已达最大数量)'"></option>--}}
                        <option id="levelOne" value='0'>1级菜单</option>
                        <option v-for="levelOne in levelOnes" :value="levelOne.id"
                                v-text="levelOne.addable ? levelOne.name : levelOne.name + '(二级菜单已达最大数量)'"></option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item">
                <label for="name" class="layui-form-label">显示名称</label>
                <div class="layui-input-inline">
                    <input type="text" name="name" class="layui-input" id="name" :value="menu.name" v-model="name">
                </div>
            </div>
            <div class="layui-form-item">
                <label for="type" class="layui-form-label">菜单类型</label>
                <div class="layui-input-inline">
                    <select class="form-control" name="type" id="type" v-model="type">
                        <option disabled value="">请选择</option>
                        <option v-for="type in types" :value="type.value" v-text="type.text"></option>
                    </select>
                </div>
            </div>
            <div class="layui-form-item" id="div_url"
                 :style="type == 'view' ? {display : 'block'} : {display : 'none'}">
                <label for="url" class="layui-form-label">超链接</label>
                <div class="layui-input-inline">
                    <input type="text" name="url" class="layui-input" id="url" :value="menu.url" v-model="url">
                </div>
            </div>
            <div class="layui-form-item" id="div_key_word"
                 :style="type == 'click' ? {display : 'block'} : {display : 'none'}">
                <label for="key_word" class="layui-form-label">关键字</label>
                <div class="layui-input-inline">
                    <input type="text" name="key_word" class="layui-input" id="key_word" :value="menu.key_word"
                           v-model="key_word">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a class="layui-btn" @click="addMenu">添加菜单</a>
                    <a class="layui-btn" onclick="history.go(-1)">返回</a>
                </div>
            </div>
            {{--<input type="text" name="id" id="id" :value="menu.id" style="display: none">--}}
        </form>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        var url = {
            'add': "{{ url('admin/wechat/menu/add') }}",
            'modify': "{{ url('admin/wechat/menu/modify') }}",
            getLevelOnes: "{{ url('admin/wechat/menu/getLevelOnes') }}"
        };

        new Vue({
            el: '#app',
            data: {
                levelOnes: '',
                menu: '',
                id: '',
                parent_id: '',
                type: '',
                url: '',
                key_word: '',
                name: '',
                types: [
                    {value: 'button', text: '无事件的一级菜单'},
                    {value: 'view', text: '超链接'},
                    {value: 'click', text: '关键字回复'},
                ],
            },
            mounted: function () {
                this.$nextTick(function () {
                    axios.post(url.getLevelOnes, {}).then(response => {
                        this.levelOnes = response.data.data;
                    });
                    /*if (menu.length !== 0) {
                        this.parent_id = menu.parent_id;
                        this.type = menu.type;
                        this.name = menu.name;
                        this.url = menu.url;
                        this.key_word = menu.key_word;
                        this.id = menu.id;
                    }*/
                })
            },
            methods: {
                addMenu: function () {
                    let check = true;
                    if (this.parent_id === '') {
                        $('#parent_id').css('border-color', 'red');
                        check = false;
                    }
                    if (this.name === '') {
                        $('#name').css('border-color', 'red');
                        check = false;
                    }
                    if (this.type === '') {
                        $('#type').css('border-color', 'red');
                        check = false;
                    }
                    if (this.type === 'view' && this.url === '') {
                        $('#url').css('border-color', 'red');
                        check = false;
                    }
                    if (this.type === 'click' && this.key_word === '') {
                        $('#key_word').css('border-color', 'red');
                        check = false;
                    }
                    if (check) {
                        this.menu !== undefined ? url = url.add : url = url.modify;
                        let data = {
                            parent_id: this.parent_id, name: this.name, type: this.type, url: this.url,
                            key_word: this.key_word
                        };
                        axios.post(url, data).then(response => {
                            if (response.data.status === 1) {
                                success(response.data.msg,  {time:3000, go:-1});
                            } else {
                                error(response.data.msg);
                            }
                        });
                    }
                }
            },
            watch: {
                parent_id: function (value) { //上级菜单不为1级菜单时，菜单类型选择器将不在拥有'无事件的一级菜单'选项
                    value !== '' ? $('#parent_id').css('border-color', '#d2d6de') : '';
                    if (value !== '0') {
                        this.types = [
                            {value: 'view', text: '超链接'},
                            {value: 'click', text: '关键字回复'},
                        ];
                    }
                    if (value === '0') {
                        this.types = [
                            {value: 'button', text: '无事件的一级菜单'},
                            {value: 'view', text: '超链接'},
                            {value: 'click', text: '关键字回复'},
                        ];
                    }
                },
                name: function (value) {
                    value !== '' ? $('#name').css('border-color', '#d2d6de') : '';
                },
                type: function (value) {
                    value !== '' ? $('#type').css('border-color', '#d2d6de') : '';
                },
                url: function (value) {
                    value !== '' ? $('#url').css('border-color', '#d2d6de') : '';
                },
                key_word: function (value) {
                    value !== '' ? $('#key_word').css('border-color', '#d2d6de') : '';
                },
            }
        });


    </script>
@endsection