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
    <style>.layui-form-checked i, .layui-form-checked:hover i{color: #ffffff!important;}#system_order_no{position: absolute;z-index: 999;line-height: 38px;resize:none;overflow:hidden;}</style>
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">运单号</label>
                        <div class="layui-input-inline">
                            <textarea name="system_order_no" id="system_order_no" class="layui-input"></textarea>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">寄件人</label>
                        <div class="layui-input-inline">
                            <input type="text" name="s_name" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">收件人</label>
                        <div class="layui-input-inline">
                            <input type="text" name="r_name" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">收件人电话</label>
                        <div class="layui-input-inline">
                            <input type="text" name="r_phone" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-inline">
                        <label class="layui-form-label">外部订单号</label>
                        <div class="layui-input-inline">
                            <input type="text" name="user_order_no" placeholder="" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">线路</label>
                        <div class="layui-input-inline">
                            <select name="line_id">
                                <option value="">请选择</option>
                                @foreach($line as $val)
                                    <option value="{{$val['id']}}">{{$val['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">身份证号状态</label>
                        <div class="layui-input-inline">
                            <select name="r_cre_num_status">
                                <option value="">全部</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">身份证相片状态</label>
                        <div class="layui-input-inline">
                            <select name="id_card_thumb_status">
                                <option value="">全部</option>
                                <option value="1">是</option>
                                <option value="2">否</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-form-item">
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
                        <label class="layui-form-label">订单状态</label>
                        <div class="layui-input-inline">
                            <select name="status">
                                <option value="">全部</option>
                                @foreach($allstatus as $key=>$val)
                                <option value="{{$key}}">{{$val}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="layui-card-body">
                {{--<div style="padding-bottom: 10px;">
                    <form class="layui-form layui-inline">
                    <input type="radio" name="print_type" value="1" title="1.A4打印" checked>
                    <input type="radio" name="print_type" value="2" title="2.热敏打印">
                    </form>
                    <button class="layui-btn layuiadmin-btn-list" data-type="batchdel">批量打印发货凭证</button>
                    <button class="layui-btn layuiadmin-btn-list" data-type="add">批量打印发货凭证</button>
                </div>--}}
                <table id="list-index" lay-filter="LAY-app-content-list"></table>
                <script type="text/html" id="idTpl">
                    @verbatim
                    {{#  if(d.r_cre_num){ }}
                    <i class="layui-icon layui-icon-ok" style="font-size: 20px; color: green;font-weight: bold;"></i>
                    {{#  }else{ }}
                    <i class="layui-icon layui-icon-close" style="font-size: 20px; color: red;font-weight: bold;"></i>
                    {{#  } }}
                    <span style="font-size: 20px;">/</span>
                    {{#  if(d.id_card_front && d.id_card_back){ }}
                    <i class="layui-icon layui-icon-ok" style="font-size: 20px; color: green;font-weight: bold;"></i>
                    {{#  }else{ }}
                    <i class="layui-icon layui-icon-close" style="font-size: 20px; color: red;font-weight: bold;"></i>
                    {{#  } }}
                    @endverbatim
                </script>
                <script type="text/html" id="table-content-list">
                    @verbatim
                    {{#  if(d.status == 99){ }}
                    <span class="errortip" data-title="{{d.fail_reason ? '异常原因：'+d.fail_reason : ''}}</br>{{d.tax > 0 ? '税金：'+d.tax : ''}}">
                        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="confirm">处理异常</a>
                    </span>
                    {{#  }else if(d.status >= 10 && d.status <= 20){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" href="/user/list/showExpress?no={{d.express_no}}" target="_blank">快递信息</a>
                    {{#  }else if(d.status == 0){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" href="/user/online/edit?id={{d.id}}">编辑</a>
                    {{# } }}
                    @endverbatim
                </script>
                <script type="text/html" id="productsTpl">
                    @verbatim
                    <a class="layui-btn layui-btn-xs proerrortip" href="#" data-title="{{d.productsContent}}">详情</a>
                    @endverbatim
                </script>
                <script type="text/html" id="list-header-a">
                    {{--<a href="/user/list/0" class="layui-btn layui-btn-{{!$status ? 'danger' : 'normal'}} layui-btn-sm">我的订单</a>
                    <a href="/user/list/1" class="layui-btn layui-btn-{{$status == 1 ? 'danger' : 'normal'}} layui-btn-sm">运输中</a>
                    <a href="/user/list/2" class="layui-btn layui-btn-{{$status == 2 ? 'danger' : 'normal'}} layui-btn-sm">已完成</a>--}}
                    <a class="layui-btn layui-btn-normal layui-btn-sm" id="moveDownOrder">在线下单</a>
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
    }).use(['index', 'table', 'laydate'], function(){
        var table = layui.table
                ,form = layui.form
                ,laydate = layui.laydate
                ,$ = layui.$
                ,errortip = '';

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
                {checkbox: true, fixed: true,field:'id'}
                ,{field: 'number', title: '序号', width:80, fixed: 'left'}
                ,{field: 's_name', title: '寄件人'}
                ,{field: 'r_name', title: '收件人'}
                ,{field: 'created_at', title: '下单时间',width:165}
                ,{field: 'user_order_no', title: '外部订单号'}
                ,{field: 'system_order_no', title: '运单号',width:205}
                ,{field: 'products', title: '物品内容',width:90, templet: '#productsTpl',align:'center'}
                ,{field: 'line', title: '线路'}
                ,{field: 'thumb', title: '身份证号/相片', templet: '#idTpl'}
                ,{field: 'statustr', title: '当前状态'}
                ,{field: '', title: '操作', toolbar: '#table-content-list'}
            ]]
            ,toolbar: '#list-header-a'
            ,defaultToolbar:[]
            ,done: function(res, curr, count){
                $('.errortip').hover(function(){
                    var that = $(this);
                    var title = that.data("title");
                    errortip = layer.tips(title, that, {tips:1}); //在元素的事件回调体中，follow直接赋予this即可
                },function(){
                    layer.close(errortip);
                });

                $('.proerrortip').hover(function(){
                    var that = $(this);
                    var title = that.data("title");
                    errortip = layer.tips(title, that, {tips:1}); //在元素的事件回调体中，follow直接赋予this即可
                },function(){
                    layer.close(errortip);
                });

                $.each(res.data,function(k,v){
                    if(v.status == 99){
                        $("tr[data-index="+k+"]").css("background","#FFB800");
                    }
                });
            }
        });

        //监听搜索
        form.on('submit(LAY-app-contlist-search)', function(data){
            var field = data.field;
            console.log(field);
            //执行重载
            table.reload('list-index', {
                page:{ curr:1 },
                where: field
            });
        });

        table.on("tool(LAY-app-content-list)", function(t) {
            var data = t.data;
            "confirm" === t.event ? layer.confirm("确定处理异常？", function(e) {
                $.ajax({
                    type : "POST",
                    url : "/user/list/userConfirmError",
                    data:{id:data.id , _token:"{{csrf_token()}}"},
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            layer.alert(result.msg);
                            table.reload('list-index');
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
            }) : "express" === t.event && layer.open({
                type: 2,
                title: "快递信息",
                content: '/user/list/showExpress',
                maxmin: !0,
                area: ['800px', '500px'],
                btn: ["取消"]
            })
        });

        $("#moveDownOrder").on('click',function () {
            window.parent.document.getElementById("faterDownOrder").click();
        });

        $.fn.extend({
            txtaAutoHeight: function () {
                return this.each(function () {
                    var $this = $(this);
                    if (!$this.attr('initAttrH')) {
                        $this.attr('initAttrH', $this.outerHeight());
                    }
                    setAutoHeight(this).on('input', function () {
                        setAutoHeight(this);
                    });
                });
                function setAutoHeight(elem) {
                    var $obj = $(elem);
                    return $obj.css({ height: $obj.attr('initAttrH')}).height(elem.scrollHeight);
                }
            }
        });

        $("#system_order_no").on("focus",function () {
            var textarea = document.getElementById("system_order_no");
            moveEnd(textarea);
            $("#system_order_no").txtaAutoHeight();
        });
        $("#system_order_no").on("blur",function () {
            $("#system_order_no").css("height","");
        });

        function moveEnd(obj){
            var len = obj.value.length;
            if (document.selection) {
                var sel = obj.createTextRange();
                sel.moveStart('character',len);
                sel.collapse();
                sel.select();
            } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') {
                obj.selectionStart = obj.selectionEnd = len;
            }
        }
    });
</script>
</body>
</html>