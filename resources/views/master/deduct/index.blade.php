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
            <form class="layui-form" action="">
                <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">运单号</label>
                            <div class="layui-input-inline">
                                <textarea name="system_order_no" id="system_order_no" class="layui-input"></textarea>
                            </div>
                        </div>
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <label class="layui-form-label">导入时间</label>
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
                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-list" data-type="deduct" onclick="return false;">导入扣款</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="layui-card-body">
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
                <script type="text/html" id="buttonTpl">
                    @verbatim
                    {{#  if(d.print){ }}
                    <i class="layui-icon layui-icon-ok" style="font-size: 20px; color: green;font-weight: bold;"></i>
                    {{#  }else{ }}
                    <i class="layui-icon layui-icon-close" style="font-size: 20px; color: red;font-weight: bold;"></i>
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
    }).use(['index', 'table', 'laydate','upload'], function(){
        var table = layui.table
                ,form = layui.form
                ,laydate = layui.laydate
                ,upload = layui.upload;

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
                {field: 'oid', title: '运单号',width:205}
                ,{field: 'money', title: '扣款金额'}
                ,{field: 'created_at', title: '导入时间'}
            ]]
            ,defaultToolbar:[]
            ,done: function(res, curr, count){
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
            return false;
        });

        var $ = layui.$;

        var $ = layui.$, active = {
            deduct: function(){
                layer.open({
                    type: 2
                    ,title: '批量导入扣款'
                    ,content: '/master/deduct/import'
                    ,maxmin: true
                    ,area: ['800px', '500px']
                    ,btn: ['取消']
                });
            }
        };

        $('.layui-btn.layuiadmin-btn-list').on('click', function(){
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
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

        upload.render({
            elem: '#upload'
            ,url: '/master/deduct/excelDeduct'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{'_token':"{{csrf_token()}}"}
            ,before: function(){layer.load();}
            ,done: function(res){ //上传后的回调
                layer.msg(res.msg);
                layer.closeAll('loading');
                table.reload('list-index');
            }
            ,error: function (errors) {
                layer.closeAll('loading');
            }
        });

        function postcall( url, params, target){
            var tempform = document.createElement("form");
            tempform.action = url;
            tempform.method = "post";
            tempform.style.display="none"
            if(target) {
                tempform.target = target;
            }
            for (var x in params) {
                var opt = document.createElement("input");
                opt.name = x;
                opt.value = params[x];
                tempform.appendChild(opt);
            }
            var opt = document.createElement("input");
            opt.type = "submit";
            tempform.appendChild(opt);
            document.body.appendChild(tempform);
            tempform.submit();
            document.body.removeChild(tempform);
        }
    });
</script>
</body>
</html>