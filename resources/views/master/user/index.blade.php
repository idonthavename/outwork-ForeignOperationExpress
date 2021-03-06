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
    <style>.layui-form-checked i, .layui-form-checked:hover i{color: #ffffff!important;}</style>
</head>

<body>

<div class="layui-content">
    <div class="layui-fluid" style="margin-top: 1rem;">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <form class="layui-form">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">用户名</label>
                            <div class="layui-input-inline">
                                <input type="text" name="name" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">邮箱</label>
                            <div class="layui-input-inline">
                                <input type="text" name="email" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">用户代码</label>
                            <div class="layui-input-inline">
                                <input type="text" name="user_identification" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">用户类型</label>
                            <div class="layui-input-inline">
                                <select name="type">
                                    <option value="">全部</option>
                                    <option value="personal">个人用户</option>
                                    <option value="company">企业用户</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">注册时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="start" id="start" placeholder="开始时间" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline">
                                <input type="text" name="end" id="end" placeholder="结束时间" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                                <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="layui-card-body">
                <table id="list-index" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="typeTpl">
                    @verbatim
                    {{#  if(d.type == 'personal'){ }}
                    个人用户
                    {{#  }else if  (d.type == 'company'){ }}
                    企业用户
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="table-content-list">
                    @verbatim
                    {{#  if(d.active > 0){ }}
                    <a class="layui-btn layui-btn-danger layui-btn-xs active" lay-event="active">已激活</a>
                    {{#  }else { }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs active" lay-event="active">未激活</a>
                    {{#  } }}
                    <a href="/master/user/info?id={{ d.id }}" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">查看</a>
                    <a class="layui-btn layui-btn-normal layui-btn-xs active" lay-event="resetPassword">修改密码</a>
                    @endverbatim
                </script>
                <script type="text/html" id="rankTpl">
                    @verbatim
                    {{#  if(d.rank == '1'){ }}
                    等级一
                    {{#  }else if  (d.rank == '2'){ }}
                    等级二
                    {{#  }else if  (d.rank == '3'){ }}
                    等级三
                    {{#  }else if  (d.rank == '4'){ }}
                    等级四
                    {{#  }else if  (d.rank == '5'){ }}
                    等级五
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="table-control">
                    <div class="layui-btn-container">
                        <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="rank">用户等级</a>
                    </div>
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
    }).use(['index', 'table', 'laydate', 'form', 'layer'], function(){
        var table = layui.table
                ,form = layui.form
                ,$ = layui.$
                ,laydate = layui.laydate;

        laydate.render({
            elem: '#start',
            type:'datetime',
            format: 'yyyy-MM-dd HH:mm',
            max: '{{date('Y-m-d H:i:s',time())}}'
        });

        laydate.render({
            elem: '#end',
            type:'datetime',
            format: 'yyyy-MM-dd HH:mm',
            max: '{{date('Y-m-d H:i:s',time())}}'
        });

        table.render({
            elem: '#list-index'
            ,url: '{{url()->current().'/get'}}' //数据接口
            ,page: true //开启分页
            ,response: {
                statusName: 'status' //数据状态的字段名称，默认：code
                ,statusCode: 200 //成功的状态码，默认：0
            }
            ,limits:[10,20,30]
            ,text: {none:'暂无相关数据'}
            ,cols: [[ //表头
                {type: 'checkbox', fixed: 'left'}
                ,{field: 'type', title: '用户类型',templet:'#typeTpl'}
                ,{field: 'name', title: '用户名'}
                ,{field: 'email', title: '邮箱'}
                ,{field: 'xing', title: '姓'}
                ,{field: 'ming', title: '名'}
                ,{field: 'user_identification', title: '用户代码'}
                ,{field: 'money', title: '金额'}
                ,{field: 'rank', title: '用户等级',templet:'#rankTpl'}
                ,{field: 'created_at', title: '注册时间'}
                ,{field: '',width:200, title: '操作', toolbar: '#table-content-list'}
            ]]
            ,toolbar:"#table-control"
            ,defaultToolbar:[]
        });

        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;
            //执行重载
            table.reload('list-index', {
                where: field
            });
            return false;
        });

        table.on("tool(LAY-app-content-list)", function(t) {
            switch (t.event){
                case "active":
                    layer.confirm("是否改变激活状态？", function(e) {
                        $.ajax({
                            type : "POST",
                            url : "/master/user/active",
                            data:{id:t.data.id, active:t.data.active, _token:"{{csrf_token()}}"},
                            dataType: 'json',
                            success : function(result) {
                                layer.msg(result.msg);
                                if (result.status == 200){
                                    var active = t.tr.find(".active");
                                    if (active.hasClass("layui-btn-danger")){
                                        active.removeClass("layui-btn-danger").addClass("layui-btn-normal").text("未激活");
                                    }else {
                                        active.removeClass("layui-btn-normal").addClass("layui-btn-danger").text("已激活");
                                    }
                                    t.update({active : t.data.active > 0 ? 0 : 1});
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
                    });
                    break;
                case 'resetPassword':
                    var id = t.data.id;
                    layer.open({
                        type: 2
                        ,title: '修改用户等级'
                        ,content: '/master/user/resetPassword'
                        ,maxmin: true
                        ,area: ['800px', '400px']
                        ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
                            //点击确认触发 iframe 内容中的按钮提交
                            layero.find('iframe').contents().find("#id").val(id);
                            var l = window["layui-layer-iframe" + index],
                                    a = layero.find("iframe").contents().find("#layuiadmin-app-form-edit");
                            l.layui.form.on("submit(layuiadmin-app-form-edit)", function(i) {
                                var l = i.field;
                                $.ajax({
                                    type : "POST",
                                    url : "{{url('master/user/resetPassword')}}",
                                    data : l,
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
                                layer.close(index)
                            }), a.trigger("click");
                        }
                    });
                    break;
            }
        });

        //头工具栏事件
        table.on('toolbar(LAY-app-content-list)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            switch(obj.event){
                case 'rank':
                    var data = checkStatus.data;
                    var ids = '';
                    $.each(data,function (k, v) {
                        ids += (k > 0 ? ',' : '')+v.id;
                    });
                    layer.open({
                        type: 2
                        ,title: '修改用户等级'
                        ,content: '{{url()->current().'/changeRank'}}'
                        ,maxmin: true
                        ,area: ['800px', '400px']
                        ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
                            //点击确认触发 iframe 内容中的按钮提交
                            layero.find('iframe').contents().find("#ids").val(ids);
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                            submit.click();
                        }
                    });
                    break;
            };
        });
    });
</script>
</body>
</html>