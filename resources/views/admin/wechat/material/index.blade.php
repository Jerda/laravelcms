@extends('admin.layouts.iframe_app')
<style>
    .custom_group_image {
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        width: 188px;
        height: 120px;
        margin: 10px 10px;
        float: left;
        border: 1px solid #e3e3e3;
        border-radius: 5px;
        line-height: 36px;
        overflow: hidden;
        padding: 6px 15px;
        text-align: center;
    }

    .custom_group_image img {
        display: inline;
        max-width: 100%;
        max-height: 100%;
    }

    .custom_group_image div {
        position: relative;
        bottom: 30px;
        z-index: 999;
        height: 30px;
        background-color: rgba(0, 0, 0, 0.3)
    }
    .custom_group_image div a {
        color:#fff;
        line-height: 30px;
        display: block;
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
        <div class="custom_group_image" v-on:mouseover="mouseover" v-on:mouseleave="mouseleave">
            <img :src="image.path" alt="">
            <div v-show="show">
                <a>删除</a>
            </div>
        </div>
    </script>
@endsection
@section('script')
    <script>
        var url = {
            getImages: "{{ url('admin/wechat/material/getImages') }}"
        };

        layui.use('element', function () {
            var element = layui.element;
        });
    </script>
    <script>
        Vue.component('image-groups', {
            template: '#image-groups',
            props: ['image'],
            data: function() {
                return {
                    show: false,
                    mouse_style: false
                }
            },
            methods: {
                mouseover: function() {
                    this.show = true;
                    this.mouse_style = true;
                },
                mouseleave: function() {
                    this.show = false;
                    this.mouse_style = false;
                }
            },
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
                getImages: function () {
                    axios.post(url.getImages, {limit: this.limit}).then(response => {
                        this.images = response.data.data.data;
                        this.count = response.data.data.total;
                        this.current_page = response.data.data.current_page;
                        pageLinks(this);
                    });
                }
            },
            mounted: function () {
                this.$nextTick(function () {
                    this.getImages();
                })
            }
        });
    </script>
@endsection