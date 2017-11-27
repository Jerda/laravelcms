<!-- <div class="layui-side layui-bg-black">
    <div class="layui-side-scroll">
        <ul class="layui-nav layui-nav-tree"  lay-filter="test">
            <li class="layui-nav-item">
                <a href="javascript:;">会员管理</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{ url('admin/user/index') }}">微信会员</a></dd>
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
        </ul>
    </div>
</div> -->


<div class="layui-side layui-bg-black kit-side">
    <div class="layui-side-scroll">
        <div class="kit-side-fold"><i class="fa fa-navicon" aria-hidden="true"></i></div>
        <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
        <ul class="layui-nav layui-nav-tree" lay-filter="kitNavbar" kit-navbar>
            <li class="layui-nav-item">
                <a class="" href="javascript:;"><i class="fa fa-plug" aria-hidden="true"></i><span>会员管理</span></a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{ url('admin/user/index') }}" data-icon="fa-user" data-title="微信会员" kit-target data-id='1'>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>微信会员</span>
                        </a>
                    </dd>
                </dl>
            </li>
             <li class="layui-nav-item">
                <a class="" href="javascript:;"><i class="fa fa-plug" aria-hidden="true"></i><span>微信设置</span></a>
                <dl class="layui-nav-child">
                    <dd>
                        <a href="javascript:;" data-url="{{ url('admin/wechat/config') }}"" data-icon="fa-user" data-title="接口管理" kit-target data-id='2'>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>接口管理</span>
                        </a>
                    </dd>
                    <dd>
                        <a href="javascript:;" data-url="{{ url('admin/wechat/menu') }}"" data-icon="fa-user" data-title="自定义菜单" kit-target data-id='3'>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>自定义菜单</span>
                        </a>
                    </dd>
                    <dd>
                        <a href="javascript:;" data-url="javascript:;"" data-icon="fa-user" data-title="自定义回复" kit-target data-id='4'>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>自定义回复</span>
                        </a>
                    </dd>
                </dl>
            </li>
        </ul>
    </div>
</div>
