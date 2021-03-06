@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">

    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">{{$type == 'personal' ? '个人' : '企业'}}注册<br>欢迎您注册wedepot国际物流{{$type == 'personal' ? '个人' : '企业'}}用户</div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="content">
            <div class="content-titleimg">
                @for($i = 1;$i < 7; $i++)
                    @php
                        $imgType = $nowStep >= $i ? '1' : '0'
                    @endphp
                    <div class="step layui-inline">
                        <div><span class="title-header">{{$i}}</span><img src="{{asset('images/register-tip'.$imgType.'.png')}}"><span class="title-footer @if($nowStep >= $i) active @endif">{{$titles[$i-1]}}</span></div>
                    </div>
                @endfor
            </div>
            <div class="form">
                <form class="layui-form" action="">
                    {{csrf_field()}}
                    <div class="layui-form-item">
                        <label class="layui-form-label">登陆用户名<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="text" name="name" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">密码<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="password" id="pwd" name="password" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <div class="pwd-default">弱</div>
                            <div class="pwd-default">中</div>
                            <div class="pwd-default">强</div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">确认密码<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="password" name="password_confirmation" required  lay-verify="required|confirm" lay-vertype="tips" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">电子邮箱<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="text" name="email" required  lay-verify="required|email" lay-vertype="tips" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    @if($type == 'company')
                        <div class="layui-form-item">
                            <label class="layui-form-label">公司名称<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="ming" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <input type="hidden" name="xing" value="企业用户">
                    @else
                        <div class="layui-form-item">
                            <label class="layui-form-label">姓<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="xing" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">名<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="ming" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    @endif
                    <div class="layui-form-item">
                        <label class="layui-form-label">验证码<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="text" name="verifycode" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="layui-input-block">
                            <div class="captcha">
                                <img id="captchaImg" src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()">
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label"></label>
                        <div class="captcha">
                            <input type="checkbox" name="agree" value="1" title="阅读并同意" lay-skin="primary" lay-verify="checkboxmustbe" lay-vertype="tips">
                            <div class="layui-inline agree-link"><a href="http://www.customs.gov.cn/publish/portal0/tab517/info10510.htm" target="_blank">《wedepot国际物流服务协议》</a></div>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn sub-btn" lay-submit lay-filter="do">下一步</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('common.footer')

    <script>
        layui.use(['form'], function(){
            var form = layui.form
                ,$ = layui.jquery;

            form.verify({
                confirm: function(value, item){ //value：表单的值、item：表单的DOM对象
                    var password = $("input[name=password]").val();
                    if(value != password){
                        return '两次密码不一致';
                    }
                },
                checkboxmustbe: function (value) {
                    if (!$("input[name=agree]").is(":checked")) {
                        return "您必须同意，谢谢";
                    }
                }
            });

            form.on('submit(do)', function(data){
                $.ajax({
                    type : "POST",
                    url : "{{url()->current().'/do'}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            window.location.href='{{url('/register/two/'.$type)}}';
                        } else {
                            $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                          layer.alert(result.msg);
                        }
                    },
                    error: function (error) {
                        $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                        var errors = JSON.parse(error.responseText).errors;
                        $.each(errors, function (key, value) {
                            layer.msg(value[0]);
                            return false;
                        });
                    },
                    beforeSend: function () {
                        $(".sub-btn").addClass("layui-btn-disabled").attr("disabled",true);
                    },
                    complete: function(){
                        $(".sub-btn").removeClass("layui-btn-disabled").attr("disabled",false);
                    }
                });
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });

            var spans = $(".pwd-default");
            $("#pwd").on('keyup',function(){
                var pwd = $(this).val();
                var result = 0;
                for(var i = 0, len = pwd.length; i < len; ++i){
                    result |= charType(pwd.charCodeAt(i));
                }

                var level = 0;
                //对result进行四次循环，计算其level
                for(var i = 0; i <= 4; i++){
                    if(result & 1){
                        level ++;
                    }
                    //右移一位
                    result = result >>> 1;
                }

                if(pwd.length >= 1){
                    switch (level) {
                        case 1:
                            spans[0].className = "weak";
                            spans[1].className = "pwd-default";
                            spans[2].className = "pwd-default";
                            break;
                        case 2:
                            spans[0].className = "medium";
                            spans[1].className = "medium";
                            spans[2].className = "pwd-default";
                            break;
                        case 3:
                        case 4:
                            spans[0].className = "strong";
                            spans[1].className = "strong";
                            spans[2].className = "strong";
                            break;
                    }
                }
            });

            function charType(num){
                if(num >= 48 && num <= 57){
                    return 1;
                }
                if (num >= 97 && num <= 122) {
                    return 2;
                }
                if (num >= 65 && num <= 90) {
                    return 4;
                }
                return 8;
            }
        });
    </script>
@endsection