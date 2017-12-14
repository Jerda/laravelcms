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
        <legend>添加图片</legend>
        <form class="layui-form" id="form">
            <div class="layui-form-item">
                <label class="layui-form-label">描述</label>
                <div class="layui-input-block" style="width: 300px">
                    <input type="text" name="desc" placeholder="请输入描述"
                           autocomplete="off" class="layui-input" required>
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label">图片</label>
                <div class="layui-input-inline" style="width: 100px">
                    <div class="layui-upload-list">
                        <img class="layui-upload-img" id="img">
                    </div>
                </div>
                <div class="layui-input-inline" style="margin-top:10px">
                    <button type="button" class="layui-btn" id="upload">
                        <i class="layui-icon">&#xe67c;</i>上传图片
                    </button>
                    {{--<input class="layui-upload-file" type="file" name="file">--}}
                    <input type="text" id="path" name="path" class="layui-input" style="display: none">
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <a class="layui-btn" onclick="sub()">添加</a>
                    <a class="layui-btn" onclick="history.go(-1)">返回</a>
                </div>
            </div>
        </form>
    </fieldset>
@endsection
@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var url = {
            upload : "{{ url('admin/uploadImage') }}",
            add: "{{ url('admin/wechat/material/addImage') }}"
        };

        layui.use(['form', 'upload'], function () {
            var form = layui.form;

            form.on('switch', function (data) {
                if (data.elem.checked === true) {
                    $('#content_source_url').show();
                } else {
                    $('#content_source_url').hide();
                }
            });

            var upload = layui.upload;
            //执行实例
            var uploadInst = upload.render({
                elem: '#upload' //绑定元素
                ,url: url.upload //上传接口
                ,method : 'post'
                ,done: function(res){
                    //上传完毕回调
                    $('#img').attr('src', res.data.url);
                    $('#path').val(res.data.local);
                }
                ,error: function(){
                    //请求异常回调
                    console.log('error');
                }
            });
        });

        function sub() {
            var data = $('#form').serializeArray();

            $.post(url.add, data, function(result) {
                success(result.msg, {time:2500, go:-1});
                }, 'JSON');
        }
    </script>
@endsection