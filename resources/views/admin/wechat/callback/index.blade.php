@extends('admin.layouts.iframe_app')
@section('content')
    <!-- <fieldset><legend>接口管理</legend></fieldset> -->
    <fieldset class="layui-elem-field">
        <legend>自定义回复</legend>
        <div class="layui-field-box">
            <form class="layui-form" id="app">
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">类型</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <select name="type" lay-verify="required">
                            <option value="0">图文消息</option>
                            <option value="1">文本消息</option>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">回复关键字</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <input v-model="wechat_id" type="text" name="key_word" required lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">标题</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <input type="text" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">内容</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <textarea name="content" class="layui-textarea" required></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">黑名单/受限用户回复内容</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <textarea name="no_normal_content" class="layui-textarea"></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">图片</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <input type="text" name="img" lay-verify="required" class="layui-input">
                    </div>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn" id="upload">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;">图文链接</label>
                    <div class="layui-input-inline" style="width: 400px;">
                        <input type="text" name="link" lay-verify="required" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label" style="width:240px;"></label>
                    <div class="layui-input-inline">
                        <button type="button" class="layui-btn layui-btn-success">添加</button>
                    </div>
                </div>
            </form>
        </div>
    </fieldset>

@endsection
@section('script')
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = {
            upload: "{{ url('admin/wechat/callback/upload') }}"
        };

        layui.use(['form', 'upload'], function() {
            var upload = layui.upload;
            //执行实例
            var uploadInst = upload.render({
                elem: '#upload' //绑定元素
                ,url: url.upload //上传接口
                ,method : 'post'
                ,done: function(res){
                    //上传完毕回调

                }
                ,error: function(){
                    //请求异常回调
                }
            });
        });


    </script>

@endsection
