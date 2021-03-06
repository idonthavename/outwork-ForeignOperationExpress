<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文章列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/view.css')}}">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <style> input { height: 33px; line-height: 33px; padding: 0 7px; border: 1px solid #ccc; border-radius: 2px; margin-bottom: -2px; outline: none; } input:focus { border-color: #009E94; } </style>
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">新增一级产品</button>
                    <button class="layui-btn layuiadmin-btn-list" data-type="expand">全部展开</button>
                    <button class="layui-btn layuiadmin-btn-list" data-type="fold">全部折叠</button>
                    <input id="edt-search" type="text" placeholder="输入关键字" style="width: 120px;"/>&nbsp;&nbsp;
                    <button class="layui-btn" id="btn-search">&nbsp;&nbsp;搜索&nbsp;&nbsp;</button>
                </div>
                <table id="table1" class="layui-table" lay-filter="table1"></table>
                <script type="text/html" id="oper-col">
                    @verbatim
                    {{#  if(d.parent_id == 0){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="add">添加二级产品</a>
                    {{#  } }}
                    @endverbatim
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit">修改</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
                </script>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    var renderTable = {};
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
        ,treetable: 'treetable-lay/treetable'
    }).use(['treetable', 'index', 'table'], function(){
        var treetable = layui.treetable
                ,table = layui.table
                ,$ = layui.$;

        renderTable = function () {
            layer.load(2);
            // 渲染表格
            treetable.render({
                treeColIndex: 1,          // 树形图标显示在第几列
                treeSpid: 0,             // 最上级的父级id
                treeIdName: 'id',       // id字段的名称
                treePidName: 'parent_id',     // pid字段的名称
                treeDefaultClose: false,   // 是否默认折叠
                treeLinkage: true,        // 父级展开时是否自动展开所有子级
                elem: '#table1',
                url: '{{url()->current().'/create'}}',
                response: {
                    statusName: 'status' //数据状态的字段名称，默认：code
                    , statusCode: 200 //成功的状态码，默认：0
                },
                cols: [[
                    {type: 'numbers'},
                    {field: 'name', title: '产品名称'},
                    {field: 'order', title: '排序号'},
                    {field: 'created_at', title: '创建时间'},
                    {templet: '#oper-col', title: '操作'}
                ]],
                done: function () {
                    layer.closeAll('loading');
                }
            });
        };

        renderTable();

        var active = {
            add: function(){
                layer.open({
                    type: 2
                    ,title: '新增一级产品'
                    ,content: '{{url()->current().'/0/edit'}}'
                    ,maxmin: true
                    ,area: ['800px', '500px']
                    ,btn: ['确定', '取消']
                    ,yes: function(index, layero){
                        //点击确认触发 iframe 内容中的按钮提交
                        var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                        submit.click();
                    }
                });
            },
            expand: function () {
                treetable.expandAll('#table1');
            },
            fold: function(){
                treetable.foldAll('#table1');
            }
        };

        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });

        table.on("tool(table1)", function(t) {
            var e = t.data;
            switch (t.event){
                case "add":
                    layer.open({
                        type: 2,
                        title: "新增二级产品",
                        content: '/master/product/0/edit?parent_id='+e.id,
                        maxmin: !0,
                        area: ['800px', '500px'],
                        btn: ["确定", "取消"],
                        yes: function(e, i) {
                            var l = window["layui-layer-iframe" + e],
                                    a = i.find("iframe").contents().find("#layuiadmin-app-form-edit");
                            l.layui.form.on("submit(layuiadmin-app-form-edit)", function(i) {
                                var l = i.field;
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('master/product')}}",
                                    data : l,
                                    dataType: 'json',
                                    success : function(result) {
                                        layer.msg(result.msg);
                                        if (result.status == 200){
                                            renderTable();
                                        }else{
                                            layer.msg(result.msg);
                                        }
                                    },
                                    error: function (error) {
                                        var errors = error.responseJSON.errors;
                                        $.each(errors, function (key, value) {
                                            layer.msg(value[0]);
                                            return false;
                                        });
                                    }
                                });
                                layer.close(e)
                            }), a.trigger("click");
                        }
                    });
                    break;
                case "edit":
                    layer.open({
                        type: 2,
                        title: "编辑产品",
                        content: '/master/product/'+e.id+'/edit?parent_id='+e.parent_id,
                        maxmin: !0,
                        area: ['800px', '500px'],
                        btn: ["确定", "取消"],
                        yes: function(e, i) {
                            var l = window["layui-layer-iframe" + e],
                                    a = i.find("iframe").contents().find("#layuiadmin-app-form-edit");
                            l.layui.form.on("submit(layuiadmin-app-form-edit)", function(i) {
                                var l = i.field;
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('master/product')}}",
                                    data : l,
                                    dataType: 'json',
                                    success : function(result) {
                                        layer.msg(result.msg);
                                        if (result.status == 200){
                                            renderTable();
                                        }else{
                                            layer.msg(result.msg);
                                        }
                                    },
                                    error: function (error) {
                                        var errors = error.responseJSON.errors;
                                        $.each(errors, function (key, value) {
                                            layer.msg(value[0]);
                                            return false;
                                        });
                                    }
                                });
                                layer.close(e)
                            }), a.trigger("click");
                        }
                    });
                    break;
                case "del":
                    layer.confirm("确定是否删除此产品，若为一级产品会导致下级产品所有数据丢失！", function(e) {
                        $.ajax({
                            type : "DELETE",
                            url : "/master/product/"+t.data.id,
                            data:{_token:"{{csrf_token()}}"},
                            dataType: 'json',
                            success : function(result) {
                                layer.alert(result.msg);
                                if (result.status == 200){
                                    t.del()
                                }else{
                                    layer.msg(result.msg);
                                }
                            },
                            error: function (error) {
                                var errors = error.responseJSON.errors;
                                $.each(errors, function (key, value) {
                                    layer.msg(value[0]);
                                    return false;
                                });
                            }
                        });
                        layer.close(e);
                    })
                    break;
            }
        });

        $('#btn-search').click(function () {
            var keyword = $('#edt-search').val();
            var searchCount = 0;
            $('#table1').next('.treeTable').find('.layui-table-body tbody tr td').each(function () {
                $(this).css('background-color', 'transparent');
                var text = $(this).text();
                if (keyword != '' && text.indexOf(keyword) >= 0) {
                    $(this).css('background-color', 'rgba(250,230,160,0.5)');
                    if (searchCount == 0) {
                        treetable.expandAll('#auth-table');
                        $('html,body').stop(true);
                        $('html,body').animate({scrollTop: $(this).offset().top - 150}, 500);
                    }
                    searchCount++;
                }
            });
            if (keyword == '') {
                layer.msg("请输入搜索内容", {icon: 5});
            } else if (searchCount == 0) {
                layer.msg("没有匹配结果", {icon: 5});
            }
        });

    });
</script>
</body>
</html>