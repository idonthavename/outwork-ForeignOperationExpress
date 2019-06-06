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
    <style>.layui-table-body .layui-table-cell{height:100px!important;line-height: 100px;}</style>
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-body">
                <div style="padding-bottom: 10px;">
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">新增{{$typeTitle}}</button>
                </div>
                <table id="list-index" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="isbanTpl">
                    @verbatim
                    {{#  if(d.isban > 0){ }}
                    是
                    {{#  }else { }}
                    否
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="thumbTpl">
                    @verbatim
                    {{#  if(d.thumb){ }}
                    <img src="/uploads/{{d.thumb}}" style="display: inline-block; width: 100px;">
                    {{# }else{ }}
                    无
                    {{#  } }}
                    @endverbatim
                </script>
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
            ,url: '/master/content/create?type={{$type}}' //数据接口
            ,page: true //开启分页
            ,response: {
                statusName: 'status' //数据状态的字段名称，默认：code
                ,statusCode: 200 //成功的状态码，默认：0
            }
            ,limits:[10,20,30]
            ,text: {none:'暂无相关数据'}
            ,cols: [[ //表头
                {field: 'order', title: '排序', sort: true, fixed: 'left'}
                ,{field: 'title', title: '标题'}
                @if($type <> 5)
                    ,{field: 'thumb', title: '图片',templet:'#thumbTpl'}
                    ,{field: 'link', title: '链接'}
                @endif
                ,{field: 'isban', title: '是否停用',templet:'#isbanTpl'}
                ,{field: '', title: '操作', toolbar: '#table-content-list'}
            ]]
        });

        table.on("tool(LAY-app-content-list)", function(t) {
            var e = t.data;
            "del" === t.event ? layer.confirm("确定删除此{{$typeTitle}}？", function(e) {
                $.ajax({
                    type : "DELETE",
                    url : "/master/content/"+t.data.id,
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
                title: "编辑{{$typeTitle}}",
                content: '/master/content/'+e.id+'/edit?type={{$type}}',
                maxmin: !0,
                area: ['800px', '500px'],
                btn: ["确定", "取消"],
                yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                    submit.click();
                }
            })
        });

        var $ = layui.$, active = {
            add: function(){
                layer.open({
                    type: 2
                    ,title: '新增{{$typeTitle}}'
                    ,content: '/master/content/0/edit?type={{$type}}'
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