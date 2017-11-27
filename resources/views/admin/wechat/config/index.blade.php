@extends('admin.layouts.iframe_app')
@section('content')
    <!-- <fieldset><legend>接口管理</legend></fieldset> -->
    <fieldset class="layui-elem-field">
      <legend>接口管理</legend>
      <div class="layui-field-box">
        <form class="layui-form" id="app">
        <div class="layui-form-item">
            <label class="layui-form-label">公众号名称</label>
            <div class="layui-input-inline">
                <input v-model="name" type="text" name="name" required placeholder="请输入标题" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">微信号</label>
            <div class="layui-input-block">
                <input v-model="wechat_id" type="text" name="wechat_id" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">原始ID</label>
            <div class="layui-input-block">
                <input v-model="init_wechat_id" type="text" name="init_wechat_id" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">AppID</label>
            <div class="layui-input-block">
                <input v-model="app_id" type="text" name="app_id" required  lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">AppSecret</label>
            <div class="layui-input-block">
                <input v-model="app_secret" type="text" name="app_secret" required  lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">API地址</label>
            <div class="layui-input-block">
                <input v-model="api" type="text" name="api" required  lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">TOKEN</label>
            <div class="layui-input-block">
                <input v-model="token" type="text" name="token" required  lay-verify="required" placeholder="请输入标题" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">EncodingAESKey</label>
            <div class="layui-input-block">
                <input v-model="encoding_aes_key" type="text" name="encoding_aes_key" required  lay-verify="required" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <button type="button" class="layui-btn layui-btn-primary" @click="set">设置</button>
        </div>
    </form>
      </div>
    </fieldset>

@endsection
@section('script')
    <script>
        Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

        var url = {
            'set': "{{ url('admin/wechat/config/set') }}",
            'get': "{{ url('admin/wechat/config/get') }}"
        };

        new Vue({
            el: "#app",
            data: {
                name: '',
                wechat_id: '',
                init_wechat_id: '',
                app_id: '',
                app_secret: '',
                api: '',
                token: '',
                encoding_aes_key: ''
            },
            methods: {
                /*
                表单提交
                 */
                set: function() {
                    let data = {
                        name: this.name,
                        wechat_id: this.wechat_id,
                        init_wechat_id: this.init_wechat_id,
                        app_id: this.app_id,
                        app_secret: this.app_secret,
                        api: this.api,
                        token: this.token,
                        encoding_aes_key: this.encoding_aes_key
                    };
                    this.$http.post(url.set, data).then(respond => {
                        layer.msg(respond.body.msg);
                    });
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    /*
                    加载读取数据
                     */
                    let data = {};
                    this.$http.post(url.get, data).then(respond => {
                        let data = respond.body.data;
                        this.name = data.name;
                        this.wechat_id = data.wechat_id;
                        this.init_wechat_id = data.init_wechat_id;
                        this.app_id = data.app_id;
                        this.app_secret = data.app_secret;
                        this.api = data.api;
                        this.token = data.token;
                        this.encoding_aes_key = data.encoding_aes_key;
                    });
                })
            }
        });
    </script>

@endsection
