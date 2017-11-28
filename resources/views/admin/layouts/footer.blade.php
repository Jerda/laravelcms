<script src="{{ asset('js/admin/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<!-- <script src="{{ asset('js/admin/bootstrap.min.js') }}"></script> -->

<script src="{{ asset('plugins/layui/layui.js') }}"></script>
<!-- vue -->
<script src="{{ asset('js/vue.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue-resource@1.3.4"></script>

<script src="{{ asset('js/admin/common.js') }}"></script>
<script>
    //    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    // $(window).on('resize', function () {

    //     var $content = $('.layui-body');
    //     $content.height($(this).height()-147);
    //     $content.find('iframe').each(function () {
    //         $(this).height($content.height());
    //     });
    // }).resize();
    var message;

    var ADMIN = "{{ asset('plugins') }}";

    var MAIN = "{{ url('admin/user/index') }}";    //首页显示URL

    layui.config({
        base: "{{ asset('plugins/build/js') }}" + "/"
    }).use(['app', 'message'], function () {
        var app = layui.app,
            $ = layui.jquery,
            layer = layui.layer;
        //将message设置为全局以便子页面调用
        message = layui.message;
        //主入口
        app.set({
            type: 'iframe'
        }).init();
    });
</script>

