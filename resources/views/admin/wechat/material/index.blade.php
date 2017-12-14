@extends('admin.layouts.iframe_app')
<style>
    .custom_group_image{
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 188px;
        height: 120px;
        margin:10px 10px;
        float: left;
        border: 1px solid #e3e3e3;
        border-radius: 5px;
        line-height: 36px;
        overflow: hidden;
        padding: 6px 15px;
        text-align: center;
    }
    .custom_group_image img{
        display: inline;
        max-width: 100%;
        max-height: 100%;
    }
</style>
@section('content')
    <div class="layui-tab" id="app">
        <ul class="layui-tab-title">
            <li class="layui-this">图文消息</li>
            <li>图片</li>
            <li>语音</li>
            <li>视频</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <blockquote class="layui-elem-quote">
                    <a href="{{ url('admin/wechat/material/article') }}" class="layui-btn layui-btn-sm">
                        <i class="layui-icon"></i> 添加图文消息
                    </a>
                </blockquote>
            </div>
            <div class="layui-tab-item">
                <div class="layui-tab-item layui-show">
                    <blockquote class="layui-elem-quote">
                        <a href="{{ url('admin/wechat/material/image') }}" class="layui-btn layui-btn-sm">
                            <i class="layui-icon"></i> 添加图片
                        </a>
                    </blockquote>
                </div>
                <fieldset class="layui-elem-field">
                    <div class="layui-field-box">
                        <div class="layui-row">
                            <image-groups v-for="image in images" :image="image"></image-groups>
                        </div>
                    </div>
                </fieldset>
                <div id="page"></div>
            </div>
            <div class="layui-tab-item">
                <div class="layui-tab-item layui-show">
                    <blockquote class="layui-elem-quote">
                        <a href="{{ url('admin/wechat/material/voice') }}" class="layui-btn layui-btn-sm">
                            <i class="layui-icon"></i> 添加语音
                        </a>
                    </blockquote>
                </div>
            </div>
            <div class="layui-tab-item">
                <blockquote class="layui-elem-quote">
                    <a href="{{ url('admin/wechat/material/video') }}" class="layui-btn layui-btn-sm">
                        <i class="layui-icon"></i> 添加视频
                    </a>
                </blockquote>
            </div>
        </div>
    </div>
<script type="text/x-template" id="image-groups">
    <div class="custom_group_image">
        <img :src="image.path" alt="">
    </div>
</script>
@endsection
@section('script')
    <script>
        var url = {
            getImages: "{{ url('admin/wechat/material/getImages') }}"
        };

        layui.use('element', function(){
            var element = layui.element;
        });

        axios.post(url.getImages, {}).then(response => {
            console.log(response.data);
        });
    </script>
    <script>
        Vue.component('image-groups', {
            template: '#image-groups',
            props: ['image'],
        });
        new Vue({
            el: '#app',
            data: {
                images: '',
                first: 1,
                count: '',
                current_page: 1,
                limit: parent.PAGE_LIMIT,
            },
            methods: {
                getImages: function() {
                    axios.post(url.getImages,{limit:this.limit}).then(response => {
                        this.images = response.data.data.data;
                        this.count = response.data.data.total;
                        this.current_page = response.data.data.current_page;
                        pageLinks(this);
                    });
                }
            },
            mounted: function() {
                this.$nextTick(function () {
                    this.getImages();
                })
            }
        });
    </script>
@endsection