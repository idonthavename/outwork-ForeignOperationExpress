<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
</head>
<body>


<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
    {{csrf_field()}}
    <div class="layui-form-item">
        <label class="layui-form-label">当前密码</label>
        <div class="layui-input-inline">
            <input type="password" name="oldpassword" lay-verify="mypass" lay-verType="tips" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">新密码</label>
        <div class="layui-input-inline">
            <input type="password" name="newpassword" lay-verify="mypass" lay-verType="tips" autocomplete="off" id="LAY_password" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">确认新密码</label>
        <div class="layui-input-inline">
            <input type="password" name="newpassword_confirmation" lay-verify="confirm" lay-verType="tips" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-inline">
            <input type="text" name="verifycode" lay-verify="required" lay-verType="tips" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <img id="captchaImg" src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()">
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

        form.verify({
            confirm: function(value){ //value：表单的值、item：表单的DOM对象
                var password = $("input[name=newpassword]").val();
                if(value != password){
                    return '两次密码不一致';
                }
            },
            mypass: function (value) {
                var regx =/^[a-zA-Z0-9]{6,20}$/;
                if (value.match(regx) == null) {
                    return "密码必须6到20位，且不能出现空格";
                }
            }
        });

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层
            $.ajax({
                type : "POST",
                url : "{{url()->current().'/do'}}",
                data : data.field,
                dataType: 'json',
                success : function(result) {
                    layer.alert(result.msg);
                    if (result.status == 200){
                        parent.layer.close(index); //再执行关闭
                    }else {
                        $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                    }
                },
                error: function (error) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        layer.msg(value[0]);
                        return false;
                    });
                    $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                }
            });
            return false;
        });
    })
</script>
</body>
</html>