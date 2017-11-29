/**
 * 弹出层
 *
 * @param title 标题
 * @param url
 * @param w 设置宽
 * @param h 设置高
 */
function cms_s_edit(title,url,w,h)
{
    layer_show(title,url,w,h);
}

/*弹出层*/
/*
 参数解释：
 title	标题
 url		请求的url
 id		需要操作的数据id
 w		弹出层宽度（缺省调默认值）
 h		弹出层高度（缺省调默认值）
 */
function layer_show(title,url,w,h)
{
    if (title == null || title == '') {
        title=false;
    };
    if (url == null || url == '') {
        url="404.html";
    };
    if (w == null || w == '') {
        w=800;
    };
    if (h == null || h == '') {
        h=($(window).height() - 50);
    };

    layui.use('layer', function() {
        layer.open({
            type: 2,
            area: [w+'px', h +'px'],
            fix: false, //不固定
            maxmin: true,
            shade:0.4,
            title: title,
            content: url
        });
    });
}
/*关闭弹出框口*/
function layer_close()
{
    var index = parent.layer.getFrameIndex(window.name);
    parent.layer.close(index);
}

/**
 * 表格页数连接
 * @param vue
 */
function pageLinks(vue)
{
    layui.use('laypage', function(){
        var laypage = layui.laypage;
        //执行一个laypage实例
        laypage.render({
            elem: 'test' //注意，这里的 test1 是 ID，不用加 # 号
            ,count: vue._data.count //数据总数，从服务端得到
            ,limit: vue._data.limit
            ,jump: function(obj, first) {
                if (!first) {
                    vue._data.current_page = obj.curr;
                    vue.getUsers();
                }
            }
        });
    });
}

function load()
{
    var load;

    layui.use('layer', function() {
        load = layer.load(0, {shade: false});
    });

    return load;
}
