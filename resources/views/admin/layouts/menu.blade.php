<div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
            <li class="layui-nav-item">
                <a href="javascript:;">会员管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ url('admin/user/index') }}" target="main_iframe">微信会员</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a class="" href="javascript:;">微信设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ url('admin/wechat/config') }}" target="main_iframe">接口管理</a></dd>
                    <dd><a href="{{ url('admin/wechat/menu') }}" target="main_iframe">自定义菜单</a></dd>
                    <dd><a href="javascript:void(0);">自定义回复</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:void(0);">系统设置</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:void(0);">权限管理</a></dd>
                    <dd><a href="javascript:void(0);">管理员管理</a></dd>
                    <dd><a href="javascript:void(0);">角色管理</a></dd>
                </dl>
            </li>
        </ul>
    </div>
</div>

{{--------模板，复制用--------}}
{{--
<li class="layui-nav-item">
    <a href="javascript:void(0);">解决方案</a>
    <dl class="layui-nav-child">
        <dd><a href="javascript:void(0);">列表一</a></dd>
        <dd><a href="javascript:void(0);">列表二</a></dd>
        <dd><a href="">超链接</a></dd>
    </dl>
</li>
<li class="layui-nav-item"><a href="">云市场</a></li>
<li class="layui-nav-item"><a href="">发布商品</a></li>
--}}
