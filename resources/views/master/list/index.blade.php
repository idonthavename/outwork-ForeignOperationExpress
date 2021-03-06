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
                            <label class="layui-form-label">打印状态</label>
                            <div class="layui-input-inline">
                                <select name="print">
                                    <option value="">全部</option>
                                    <option value="1">是</option>
                                    <option value="2">否</option>
                                </select>
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">物品内容</label>
                            <div class="layui-input-inline">
                                <input type="text" name="productdetail" placeholder="" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-inline">
                            <label class="layui-form-label">二级线路</label>
                            <div class="layui-input-inline">
                                <select name="linetwo">
                                    <option value="">请选择</option>
                                    @foreach($linetwo as $val)
                                        <option value="{{$val['id']}}">{{$val['name']}}</option>
                                    @endforeach
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
                            <button class="layui-btn layuiadmin-btn-list" lay-submit lay-filter="LAY-app-contlist-search">
                                <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                            </button>
                        </div>
                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-list" id="uploadWeight" onclick="return false;">批量导入称重</button>
                        </div>
                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-list" id="upload" onclick="return false;">批量导入物流单号</button>
                        </div>
                        <div class="layui-inline">
                            <a class="layui-btn layuiadmin-btn-list" href="{{asset('excel/masterExpress.xls')}}">下载导入物流 / 称重模板</a>
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
                <script type="text/html" id="table-content-list">
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="productDetail">产品详情</a>
                    <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="orderlog">状态记录</a>
                    @verbatim
                    <a class="layui-btn layui-btn-normal layui-btn-xs" href="/user/online/edit?id={{d.id}}">编辑</a>
                    <a href="/master/print/show?id={{d.id}}&print=0" target="_blank" class="layui-btn layui-btn-normal layui-btn-xs"><i class="layui-icon layui-icon-file-b"></i>打印</a>
                    {{#  if(d.status >= 10 && d.status <= 20){ }}
                    <a class="layui-btn layui-btn-normal layui-btn-xs" href="/user/list/showExpress?no={{d.express_no}}" target="_blank">快递信息</a>
                    {{# } }}
                    @endverbatim
                </script>
                <script type="text/html" id="list-header-a">
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="audit">审核</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="pick">拣货</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="weight">称重</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="charge">扣款</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="getout">出库</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="change">更改状态</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="print">打印</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="outExcel">导出</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="downloadOrderPic">身份证图片下载</a>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="changeUser">变更制单人</a>
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
            ,limits:[10,50,100]
            ,text: {none:'暂无相关数据'}
            ,cols: [[ //表头
                {checkbox: true, fixed: true,field:'id'}
                ,{field: 'number', title: '序号', width:80, fixed: 'left'}
                ,{field: 'system_order_no', title: '运单号',width:205}
                ,{field: 'r_name', title: '收件人', width:180}
                ,{field: 's_name', title: '寄件人', width:180}
                ,{field: 'user_order_no', title: '外部订单号', width:200}
                ,{field: 'statustr', title: '当前状态',width:200}
                ,{field: 'created_at', title: '下单时间',width:165}
                ,{field: 'username', title: '用户名', width:100}
                ,{field: 'weight', title: '称重', width:100}
                ,{field: 'money', title: '运费', width:100}
                ,{field: 'deduct_money', title: '自定义运费', width:100}
                ,{field: 'lineonename', title: '一级线路', width:150}
                ,{field: 'linetwoname', title: '二级线路', width:150}
                ,{field: 'depot', title: '仓库', width:150}
                ,{field: 'addons', title: '附加服务', width:150}
                ,{field: 'thumb', title: '身份证号/相片', templet: '#idTpl',width:200}
                ,{field: 'print', title: '发货凭证打印状态', templet: '#buttonTpl',width:150}
                ,{field: '', title: '操作', toolbar: '#table-content-list',width:350}
            ]]
            ,toolbar: '#list-header-a'
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

        table.on("tool(LAY-app-content-list)", function(t) {
            var e = t.data;
            switch (t.event){
                case 'productDetail':
                    layer.open({
                        type: 2,
                        title: "产品详情",
                        content: '/master/list/productDetail/'+e.system_order_no,
                        maxmin: !0,
                        area: ['800px', '500px'],
                        btn: ["取消"]
                    });
                    break;
                case 'orderlog':
                    layer.open({
                        type: 2,
                        title: "状态记录",
                        content: '/master/list/orderlog/'+e.id,
                        maxmin: !0,
                        area: ['800px', '500px'],
                        btn: ["取消"]
                    });
                    break;
            }
        });

        //头工具栏事件
        table.on('toolbar(LAY-app-content-list)', function(obj){
            var checkStatus = table.checkStatus(obj.config.id);
            var data = checkStatus.data;
            var statusJson = [];
            $.each(data,function (k, v) {
                var json = '{"id":'+v.id+',"status":'+v.status+'}';
                statusJson.push(json);
            });
            switch(obj.event){
                case 'weight':
                    layer.open({
                        type: 2
                        ,title: '称重'
                        ,content: "/master/list/"+obj.event
                        ,area: ['800px', '400px']
                        ,btn: []
                    });
                    break;
                case 'change':
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    layer.open({
                        type: 2
                        ,title: '修改状态'
                        ,content: "/master/list/"+obj.event
                        ,area: ['800px', '480px']
                        ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
                            //点击确认触发 iframe 内容中的按钮提交
                            layero.find('iframe').contents().find("#statusJson").val("["+statusJson+"]");
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                            submit.click();
                        }
                    });
                    break;
                case 'changeUser':
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    layer.open({
                        type: 2
                        ,title: '变更制单人'
                        ,content: "/master/list/"+obj.event
                        ,area: ['800px', '480px']
                        ,btn: ['确定', '取消']
                        ,yes: function(index, layero){
                            //点击确认触发 iframe 内容中的按钮提交
                            layero.find('iframe').contents().find("#statusJson").val("["+statusJson+"]");
                            var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                            submit.click();
                        }
                    });
                    break;
                case 'audit':
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    //判断是否同一线路
                    var globalLine = data[0].line_id;
                    var goon = true;
                    $.each(data,function (k, v) {
                        if(!v.line_id || globalLine != v.line_id){
                            goon = false;
                            layer.msg("请选择同一线路运单");
                            return false;
                        }
                    });
                    if(goon){
                        layer.open({
                            type: 2
                            ,title: '审核'
                            ,content: "/master/list/"+obj.event+"?line_id="+globalLine
                            ,area: ['800px', '480px']
                            ,btn: ['确定', '取消']
                            ,yes: function(index, layero){
                                //点击确认触发 iframe 内容中的按钮提交
                                layero.find('iframe').contents().find("#statusJson").val("["+statusJson+"]");
                                var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                                submit.click();
                            }
                        });
                    }
                    break;
                case 'outExcel':
                    if (!data.length){
                        var d = {};
                        var t = $('form').serializeArray();
                        $.each(t, function() {
                            d[this.name] = this.value;
                        });
                        d["_token"] = "{{csrf_token()}}";
                        postcall('/master/list/outExcel',d,'_blank');
                        return false;
                    }
                    postcall('/master/list/outExcel',{statusJson:"["+statusJson+"]",_token:"{{csrf_token()}}"},'_blank');
                    break;
                case 'print':
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    postcall('/master/print/show?print=0',{id:"["+statusJson+"]",_token:"{{csrf_token()}}"},'_blank');
                    break;
                case 'downloadOrderPic':
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    postcall('/master/list/downloadOrderPic',{statusJson:"["+statusJson+"]",_token:"{{csrf_token()}}"},'_blank');
                    break;
                case 'LAYTABLE_EXPORT':
                    break;
                default:
                    if (!data.length){layer.msg("请选择操作行");return false;}
                    layer.confirm("是否进行操作？", function(e) {
                        $.ajax({
                            type : "POST",
                            url : "/master/list/"+obj.event,
                            data:{statusJson: statusJson, _token:"{{csrf_token()}}"},
                            dataType: 'json',
                            success : function(result) {
                                if (result.status == 200){
                                    table.reload('list-index');
                                    layer.msg(result.msg);
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
            };
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
            ,url: '/master/list/excelExpress'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{'_token':"{{csrf_token()}}"}
            ,before: function(){layer.load();}
            ,done: function(res){ //上传后的回调
                layer.msg(res.msg);
                layer.closeAll('loading');
            }
            ,error: function (errors) {
                layer.closeAll('loading');
            }
        });

        upload.render({
            elem: '#uploadWeight'
            ,url: '/master/list/excelExpress?type=1'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{'_token':"{{csrf_token()}}"}
            ,before: function(){layer.load();}
            ,done: function(res){ //上传后的回调
                layer.msg(res.msg);
                layer.closeAll('loading');
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