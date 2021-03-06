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

    <div class="layui-fluid" style="margin-top: 1rem;">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <form class="layui-form">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">运单号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="system_order_no" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">外部单号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="user_order_no" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">消费时间</label>
                            <div class="layui-input-inline">
                                <input type="text" name="start" id="start" placeholder="开始时间" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">-</div>
                            <div class="layui-input-inline">
                                <input type="text" name="end" id="end" placeholder="结束时间" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">支付方式</label>
                            <div class="layui-input-inline">
                                <select name="type">
                                    <option value="">全部</option>
                                    <option value="1">支付</option>
                                    <option value="2">补扣</option>
                                    <option value="3">退款</option>
                                </select>
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
                <script type="text/html" id="list-header-a">
                    <a href="/master/center/1" class="layui-btn layui-btn-{{$type == 1 ? 'danger' : 'normal'}} layui-btn-sm">充值记录</a>
                    <a href="/master/center/2" class="layui-btn layui-btn-{{$type == 2 ? 'danger' : 'normal'}} layui-btn-sm">消费记录</a>
                    <a class="layui-btn layui-btn-normal layui-btn-sm" lay-event="makeup">扣费/补费</a>
                </script>
                <script type="text/html" id="typeTpl">
                    @verbatim
                    {{#  if(d.type == '1'){ }}
                    支付
                    {{#  }else if  (d.type == '2'){ }}
                    补扣
                    {{#  }else if  (d.type == '3'){ }}
                    退款
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="handleTpl">
                    @verbatim
                    {{#  if(d.handle == '1'){ }}
                    手工处理
                    {{#  }else { }}
                    系统处理
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
                {field: 'consume_order_no', title: '系统流水号'}
                ,{field: 'system_order_no', title: '运单号'}
                ,{field: 'user_order_no', title: '外部单号'}
                ,{field: 'unionaccount', title: '网银流水号'}
                ,{field: 'payaccount', title: '付款账号'}
                ,{field: 'type', title: '类型',templet:'#typeTpl'}
                ,{field: 'money', title: '金额'}
                ,{field: 'handle', title: '操作方式',templet:'#handleTpl'}
                ,{field: 'created_at', title: '消费时间'}
            ]]
            ,toolbar: '#list-header-a'
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

        table.on('toolbar(LAY-app-content-list)', function(obj){
            switch(obj.event){
                case 'makeup':
                    layer.open({
                        type: 2
                        ,title: '手工扣费/补费'
                        ,content: "/master/center/makeup"
                        ,area: ['800px', '480px']
                        ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
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