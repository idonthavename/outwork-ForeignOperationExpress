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
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">新增线路</button>
                </div>
                <table id="list-index" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
                    <a class="layui-btn layui-btn-xs" lay-event="ordersExcel"><i class="layui-icon layui-icon-file"></i>更新模板</a>
                </script>
                <script type="text/html" id="isbanTpl">
                    @verbatim
                    {{#  if(d.isban == 1){ }}
                    <span class="isban">是</span>
                    {{#  }else{ }}
                    <span class="isban">否</span>
                    {{#  } }}
                    @endverbatim
                </script>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'form'], function(){
        var table = layui.table
                ,form = layui.form;

        table.render({
            elem: '#list-index'
            ,url: '{{url()->current().'/create'}}' //数据接口
            ,page: true //开启分页
            ,response: {
                statusName: 'status' //数据状态的字段名称，默认：code
                ,statusCode: 200 //成功的状态码，默认：0
            }
            ,limits:[10,20,30]
            ,text: {none:'暂无相关数据'}
            ,cols: [[ //表头
                {field: 'order', title: '排序', sort: true}
                ,{field: 'name', title: '线路'}
                ,{field: 'channel', title: '渠道'}
                ,{field: 'ykg', title: '首重（磅）'}
                ,{field: 'isban', title: '是否停用',templet: '#isbanTpl'}
                ,{field: 'remark', title: '备注'}
                ,{field: '', title: '操作', toolbar: '#table-content-list',width:240}
            ]]
        });

        table.on("tool(LAY-app-content-list)", function(t) {
            var e = t.data;
            switch (t.event){
                case "del":
                    layer.confirm("确定删除此线路？", function(e) {
                        $.ajax({
                            type : "DELETE",
                            url : "/master/line/"+t.data.id,
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
                case 'edit':
                    layer.open({
                        type: 2,
                        title: "编辑线路",
                        content: '/master/line/'+e.id+'/edit',
                        maxmin: !0,
                        area: ['800px', '500px'],
                        btn: ["确定", "取消"],
                        yes: function(e, i) {
                            var l = window["layui-layer-iframe" + e],
                                    a = i.find("iframe").contents().find("#layuiadmin-app-form-edit");
                            sync = i.find("iframe").contents().find("#sync");
                            sync.trigger("click");
                            l.layui.form.on("submit(layuiadmin-app-form-edit)", function(i) {
                                var l = i.field;
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('master/line')}}",
                                    data : l,
                                    dataType: 'json',
                                    success : function(result) {
                                        layer.alert(result.msg);
                                        if (result.status == 200){
                                            table.reload('list-index',{initSort: t});
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
                    })
                    break;
                case "ordersExcel":
                    $.ajax({
                        type : "GET",
                        url : "/master/line/"+t.data.id,
                        dataType: 'json',
                        success : function(result) {
                            layer.alert(result.msg);
                        },
                        error: function (error) {
                            var errors = error.responseJSON.errors;
                            $.each(errors, function (key, value) {
                                layer.msg(value[0]);
                                return false;
                            });
                        }
                    });
                    break;
            }
        });

        var $ = layui.$, active = {
            add: function(){
                layer.open({
                    type: 2
                    ,title: '新增线路'
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
            }
        };

        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });
</script>
</body>
</html>