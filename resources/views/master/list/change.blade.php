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
    <input type="hidden" name="statusJson" id="statusJson" value="">
    <div class="layui-form-item">
        <label class="layui-form-label">* 状态</label>
        <div class="layui-input-block">
            <select name="status" lay-verify="required" lay-verType="tips" lay-filter="status">
                <option value="">请选择</option>
                @foreach($allstatus as $key=>$val)
                    @if($key > 5)
                    <option value="{{$key}}">{{$val}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="fail layui-hide">
        <div class="layui-form-item">
            <label class="layui-form-label">税金</label>
            <div class="layui-input-block">
                <input type="text" name="tax" placeholder="" autocomplete="off" class="layui-input" value="0.00">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">异常原因</label>
            <div class="layui-input-block">
                <textarea name="fail_reason" placeholder="" class="layui-textarea"></textarea>
            </div>
        </div>
    </div>
    <div class="express layui-hide">
        <div class="layui-form-item">
            <label class="layui-form-label">快递单号</label>
            <div class="layui-input-block">
                <input type="text" name="express_no" placeholder="" autocomplete="on" class="layui-input" value="">
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="layuiadmin-app-form-submit" id="layuiadmin-app-form-submit" value="确认添加">
        <input type="button" lay-submit lay-filter="layuiadmin-app-form-edit" id="layuiadmin-app-form-edit" value="确认编辑">
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

        form.on('select(status)', function(data){
            if (data.value == 10){
                $(".express").removeClass("layui-hide");
            }else {
                $(".express").addClass("layui-hide");
            }
            if (data.value == 99){
                $(".fail").removeClass("layui-hide");
            }else {
                $(".fail").addClass("layui-hide");
            }
        });

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
                    if (result.status == 200){
                        parent.layui.table.reload('list-index'); //重载表格
                        parent.layer.close(index); //再执行关闭
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
            return false;
        });
    })
</script>
</body>
</html>