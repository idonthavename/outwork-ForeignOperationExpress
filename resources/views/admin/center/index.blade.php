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
    @include('admin.center.header')

    <div class="layui-fluid" style="margin-top: 1rem;">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <form class="layui-form">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">订单号</label>
                            <div class="layui-input-inline">
                                <input type="text" name="charge_order_no" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">下单时间</label>
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
                                    <option value="alipay">支付宝</option>
                                    <option value="wechatpay">微信</option>
                                    <option value="unionpay">银联</option>
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
                    <a href="/user/center/1" class="layui-btn layui-btn-{{$type == 1 ? 'danger' : 'normal'}} layui-btn-sm">充值记录</a>
                    <a href="/user/center/2" class="layui-btn layui-btn-{{$type == 2 ? 'danger' : 'normal'}} layui-btn-sm">消费记录</a>
                </script>
                <script type="text/html" id="typeTpl">
                    @verbatim
                    {{#  if(d.type == 'alipay'){ }}
                    支付宝
                    {{#  }else if  (d.type == 'wechatpay'){ }}
                    微信
                    {{#  }else if  (d.type == 'unionpay'){ }}
                    银联
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="statusTpl">
                    @verbatim
                    {{#  if(d.status == 0){ }}
                    待支付
                    {{#  }else{ }}
                    支付成功
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
                {field: 'charge_order_no', title: '订单号', fixed:'left', width:300}
                ,{field: 'type', title: '支付方式',templet:'#typeTpl'}
                ,{field: 'money', title: '金额'}
                ,{field: 'status', title: '状态',templet:'#statusTpl'}
                ,{field: 'created_at', title: '充值时间'}
            ]]
            ,toolbar: '#list-header-a'
            ,defaultToolbar:[]
        });

        $(".changeMoney").on('click',function () {
            $(this).siblings().removeClass("layui-btn-normal").addClass("layui-btn-primary");
            $(this).removeClass("layui-btn-primary").addClass("layui-btn-normal");
            var amount = $(this).data('val');
            $("#amount").val(amount);
            $("#money").text("$"+amount);
        });

        $("#amount").on('keyup',function () {
            var amount = $(this).val() > 0 ? parseInt($(this).val()) : 0;

            var regu = "^[1-9]{1}[0-9]{0,5}$";
            var re = new RegExp(regu);
            if (!re.test(amount)) {
                amount = 0;
            }

            $("#amount").val(amount);
            $("#money").text("$"+amount);
        });

        /*form.on('submit(pay)', function(data){
            var field = data.field; //获取提交的字段

            if (!field.vendor){
                layer.msg('请选择支付方式');
                return false;
            }

            //提交 Ajax 成功后，关闭当前弹层
            $.ajax({
                type : "POST",
                url : "{{url('user/center/securepay')}}",
                data : data.field,
                dataType: 'json',
                beforeSend: function(){
                    layer.load(1, {
                        shade: [0.1,'#000'], //0.1透明度的白色背景
                        offset: '450px',
                    });
                },
                success : function(result) {
                    //layer.alert(result.msg);
                    if (result.status == 200){
                        window.open("{{url('user/center/showPay')}}");
                        table.reload('list-index'); //重载表格
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
                },
                complete: function () {
                    layer.closeAll('loading');
                }
            });
            return false;
        });*/

        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;
            //执行重载
            table.reload('list-index', {
                where: field
            });
            return false;
        });

    });
</script>
</body>
</html>