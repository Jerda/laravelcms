<div class="layui-header">
    <div class="layui-logo">{{$title}}</div>
<!--     <ul class="layui-nav layui-layout-left kit-nav">
        <li class="layui-nav-item"><a href="javascript:;">控制台</a></li>
        <li class="layui-nav-item"><a href="javascript:;">商品管理</a></li>
        <li class="layui-nav-item"><a href="javascript:;" id="pay"><i class="fa fa-gratipay" aria-hidden="true"></i> 捐赠我</a></li>
        <li class="layui-nav-item">
            <a href="javascript:;">其它系统</a>
            <dl class="layui-nav-child">
                <dd><a href="javascript:;">邮件管理</a></dd>
                <dd><a href="javascript:;">消息管理</a></dd>
                <dd><a href="javascript:;">授权管理</a></dd>
            </dl>
        </li>
    </ul> -->
    <ul class="layui-nav layui-layout-right kit-nav">
        <li class="layui-nav-item">
            <a href="javascript:;">
                {{$username}}
            </a>
            <dl class="layui-nav-child">
                <dd><a href="javascript:;">基本资料</a></dd>
                <dd><a href="javascript:;">安全设置</a></dd>
            </dl>
        </li>
        <li class="layui-nav-item"><a href="{{url('admin/logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> 注销</a></li>
    </ul>
</div>
