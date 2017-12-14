@extends('admin.layouts.iframe_app')
<style>
    .layui-upload-img{
        width: 92px;
        height: 92px;
        margin: 0 10px 10px 0;
    }
</style>
@section('content')
    <fieldset class="layui-elem-field" id="app">
        <legend>添加图文</legend>
        <form class="layui-form" action="">
            <div class="layui-form-item">
                <label class="layui-form-label">标题</label>
                <div class="layui-input-block" style="width: 500px">
                    <input type="text" name="title" required lay-verify="required" placeholder="请输入标题"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">封面</label>
                <div class="layui-input-inline" style="width: 100px">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="demo1">
                    </div>
                </div>
                <div class="layui-input-inline" style="margin-top:10px">
                    <button class="layui-btn">上传封面</button>
                    <input class="layui-upload-file" type="file" name="file">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">摘要</label>
                <div class="layui-input-block" style="width: 500px">
                    <textarea name="digest" placeholder="请输入摘要" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">正文</label>
                <div class="layui-input-block" style="width: 70%">
                    <textarea name="content" id="content" placeholder="请输入正文" class="layui-textarea"></textarea>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">作者</label>
                <div class="layui-input-block" style="width: 500px">
                    <input type="text" name="author" required lay-verify="required" placeholder="请输入作者"
                           autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">原文链接</label>
                <div class="layui-input-block">
                    <input type="checkbox" lay-skin="switch" lay-text="开启|关闭">
                </div>
                <div class="layui-input-block" style="width: 500px">
                    <input type="text" id="content_source_url" name="content_source_url" placeholder="请输入原文链接"
                           autocomplete="off" class="layui-input" style="display: none">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a class="layui-btn">添加</a>
                    <a class="layui-btn" onclick="history.go(-1)">返回</a>
                </div>
            </div>
        </form>
    </fieldset>
@endsection
@section('script')
    <script>
        layui.use('layedit', function () {
            var layedit = layui.layedit;
            layedit.build('content'); //建立编辑器
        });

        layui.use('form', function () {
            var form = layui.form;

            form.on('switch', function (data) {
                if (data.elem.checked === true) {
                    $('#content_source_url').show();
                } else {
                    $('#content_source_url').hide();
                }
            });

            //监听提交
            form.on('submit(formDemo)', function (data) {
                layer.msg(JSON.stringify(data.field));
                return false;
            });
        });

        /*
        - title 标题
        - author 作者
        - content 具体内容
        - thumb_media_id 图文消息的封面图片素材id（必须是永久mediaID）
        - digest 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空
        - source_url 来源 URL
        - show_cover 是否显示封面，0 为 false，即不显示，1 为 true，即显示
        */
    </script>
@endsection