<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <style>#address{width:590px;}  select{  border: none;  outline: none;  width: 100%;  height: 40px;  line-height: 40px;  appearance: none;  -webkit-appearance: none;  -moz-appearance: none;  padding-left: 10px;  border-width: 1px;  border-style: solid;  background-color: #fff;  border-radius: 2px;  border-color: #e6e6e6;  cursor: pointer;  }  select:hover{  border-color: #D2D2D2 !important;  }</style>
</head>
<body>


<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
    {{csrf_field()}}
    <div class="layui-form-item">
        <label class="layui-form-label">* 运单号</label>
        <div class="layui-input-block">
            <input type="text" name="system_order_no" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入运单号" value="" id="system_order_no">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 称重</label>
        <div class="layui-input-block">
            <input type="text" name="weight" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入称重量" value="0.00" id="weight">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <input type="button" class="layui-btn layui-btn-normal" lay-submit lay-filter="layuiadmin-app-form-submit" id="layuiadmin-app-form-submit" value="确认">
    </div>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form'], function(){
        var $ = layui.$
                ,form = layui.form;

        $("#system_order_no").focus();

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层
            $.ajax({
                type : "POST",
                url : "{{url()->current()}}",
                data : data.field,
                dataType: 'json',
                success : function(result) {
                    layer.msg(result.msg);
                },
                error: function (error) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        layer.msg(value[0]);
                        return false;
                    });
                }
            });
            return false;
        });
    })
</script>
</body>
</html>