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
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">新增寄件人</button>
                </div>
                <table id="list-index" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="edit"><i class="layui-icon layui-icon-edit"></i>编辑</a>
                    <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del"><i class="layui-icon layui-icon-delete"></i>删除</a>
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
                {field: 'number', title: '序号', width:80, sort: true, fixed: 'left'}
                ,{field: 'name', title: '寄件人'}
                ,{field: 'area', title: '国家/州/城市'}
                ,{field: 'phone', title: '手机号码'}
                ,{field: 'code', title: '邮编'}
                ,{field: 'created_at', title: '创建时间'}
                ,{field: '', title: '操作', toolbar: '#table-content-list'}
            ]]
        });

        table.on("tool(LAY-app-content-list)", function(t) {
            var e = t.data;
            "del" === t.event ? layer.confirm("确定删除此寄件人？", function(e) {
                $.ajax({
                    type : "DELETE",
                    url : "/user/sender/"+t.data.id,
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
            }) : "edit" === t.event && layer.open({
                type: 2,
                title: "编辑寄件人",
                content: '/user/sender/'+e.id+'/edit',
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
                            url : "{{url('user/sender')}}",
                            data : l,
                            dataType: 'json',
                            success : function(result) {
                                layer.alert(result.msg);
                                if (result.status == 200){
                                    t.update({
                                        name: l.name,
                                        phone: l.phone,
                                        area: l.country+"/"+l.province+'/'+l.city,
                                        code: l.code,
                                    }), form.render();
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
        });

        var $ = layui.$, active = {
            add: function(){
                layer.open({
                    type: 2
                    ,title: '新增寄件人'
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

        $("#moveDownOrder").on('click',function () {
            window.parent.document.getElementById("faterDownOrder").click();
        });
    });
</script>
</body>
</html>