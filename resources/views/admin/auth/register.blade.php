<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('css/admin/bootstrap.min.css') }}">
    <style type="text/css">
        .login-box{
            width: 360px;
            margin: 7% auto;
        }
        .login-logo, .register-logo {
            font-size: 35px;
            text-align: center;
            margin-bottom: 25px;
            font-weight: 300;
        }
        #form input{
            background-color: #ccc;
        }
    </style>
</head>
<body class="hold-transition login-page" style="background-color: #2c2e2f">
<div class="login-box" style="padding-top: 50px" id="app">
    <div class="login-box-body" style="background-color: #2c2e2f">
        <p class="register-logo" style="color: white;font-size: 20px;font-weight: 700">注&nbsp;&nbsp;&nbsp;&nbsp;册</p>

        <form id="form">
            <div class="form-group has-feedback">
                <input v-model="username" type="text" name="username" class="form-control" placeholder="用户名">
            </div>
            <div class="form-group has-feedback">
                <input v-model="password" type="password" name="password" class="form-control" placeholder="密码">
            </div>
            <div class="form-group has-feedback">
                <input v-model="password_confirmation" type="password" class="form-control" name="password_confirmation" placeholder="确认密码">
            </div>
            <div class="form-group has-feedback">
                <input v-model="captcha" type="text" class="form-control" name="captcha" placeholder="验证码" style="width:55%;float:left;">
                <img v-bind:src="captcha_src" alt="" width="" height="" ref="captcha" @click="refresh" data-captcha-config="default" style="float: right;">
            </div>
            <div class="row" style="clear:both;padding-top: 10px;">
                <div class="col-xs-12">
                    <button type="button" class="btn btn-primary btn-block btn-flat" @click="register">注&nbsp;&nbsp;册</button>
                </div>
            </div>
            <div class="row" style="clear:both;padding-top: 10px;">
                <div class="col-xs-12">
                    <span class="" style="color: red;" :style="errors.username == undefined ? {display : 'none'} : {display : 'block'}">@{{ errors.username }}</span>
                </div>
            </div>
            <div class="row" style="clear:both;padding-top: 10px;">
                <div class="col-xs-12">
                    <span class="" style="color: red;" :style="errors.password == undefined ? {display : 'none'} : {display : 'block'}">@{{ errors.password }}</span>
                </div>
            </div>
            <div class="row" style="clear:both;padding-top: 10px;">
                <div class="col-xs-12">
                    <span class="" style="color: red;clear:both;" :style="errors.captcha == undefined ? {display : 'none'} : {display : 'block'}">@{{ errors.captcha }}</span>
                </div>
            </div>
        </form>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 3 -->
<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('js/admin/bootstrap.min.js') }}"></script>
<!-- vue -->
<script src="{{ asset('js/vue.js') }}"></script>
<!-- vue.resource -->
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>
<!-- layui -->
<script src="{{ asset('plugins/layui/layui.all.js') }}"></script>
<script>
    //后台所需CSRF-TOKEN
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    var url = {
        register: "{{ url('admin/register') }}",
        redirectTo : "{{ url('admin/login') }}"
    };

    new Vue({
        el: "#app",
        data: {
            username: '',
            password: '',
            password_confirmation: '',
            captcha: '',    //验证码
            captcha_src: "{{ captcha_src() }}",
            errors: {       //数据提交返回的错误信息
                username: undefined,
                password: undefined,
                captcha: undefined,
            },
        },
        methods: {
            /*
             验证码点击刷新
             */
            refresh: function() {
                let config = this.$refs.captcha.attributes['data-captcha-config'].value;
                let url_refresh = '/captcha/' + config + '/?' + Math.random();
                this.captcha_src = url_refresh;
            },

            /*
            用户注册
            */
            register: function() {
                let data = {
                    username: this.username,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                    captcha: this.captcha
                };
                this.$http.post(url.register, data).then(response => {
                    if (response.body.status === 0) {
                        //将后台返回错误信息绑定给vue变量
                        if (response.body.msg.username !== undefined) {
                            this.errors.username = response.body.msg.username[0];
                        } else {
                            this.errors.username = undefined;
                        }

                        if (response.body.msg.password !== undefined) {
                            this.errors.password = response.body.msg.password[0];
                        } else {
                            this.errors.password = undefined;
                        }

                        if (response.body.msg.captcha !== undefined) {
                            this.errors.captcha = response.body.msg.captcha[0];
                        } else {
                            this.errors.captcha = undefined;
                        }

                        this.refresh()
                    } else {
                        layer.msg(response.body.msg, {time:1000}, function() {
                            window.location = url.redirectTo;
                        });
                    }
                });
            },
        },

    });
</script>
</body>
</html>
