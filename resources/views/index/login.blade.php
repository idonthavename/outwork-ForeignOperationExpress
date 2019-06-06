@extends('common.header')

@section('content')
    <style>
        .layui-tab-title .layui-this{color: #2062d0;background: white;}
        .layui-tab-title li{font-size: 1.2rem;width: 45%;line-height: 4rem;}
        .layui-tab-title{border: 0;height: 4rem;}
        .layui-tab{margin: 0;}
        .layui-unselect{display: none;}
        .layui-tab-title .layui-this:after{border: 0;}
        #banner{min-height: 670px;max-height: 72rem;position: relative;z-index: 1;overflow: hidden;}
        .banner-img{background-image: url("{{asset('images/login-banner.jpg')}}"); background-position: center center; width: 100%;height: 100%;display: block;}
        .partner{margin-top: 1rem !important;}
        .content{min-height: 35rem;  background-color: rgba(23,41,69,0.8);  margin: 1rem 0;color: white;padding: 2rem;}
        .content .loginandreg{font-size: 1.2rem;}
        .content hr{height: 0.2rem;margin-bottom: 2rem;}
        .content .main{height: 30rem;border: 1px solid white;border-radius: 1rem;overflow: hidden;}
        .content .register{width: 80%;margin: 0 auto;}
        .content .avatar{margin-top: 0.2rem;font-size: 1.5rem;text-align: center;}
        .content .avatar i{font-size: 4rem; color: white;}
        .content .youris{margin-bottom: 0.5rem;margin-top: 1.5rem;text-align: left;color: #d3c735;font-size: 1.2rem;}
        .content .special-hr{height: 0.1rem;margin: 0.5rem 0;}
        .content .reg-btn{margin: 1.5rem 0;width: 100%;border-radius: 0.5rem;}
        .content .login-btn{margin: 6.1rem 0 0 0;width: 100%;border-radius: 0.5rem;}
        .content .login-title{font-size: 1.5rem;margin: 1rem;}
        .content .login-input{width: 70%;margin: 6rem auto 0 auto;}
        .content .login-input input{margin-bottom: 1rem;background: transparent;border: 1px solid #d3c735;height: 2.5rem;font-size: 1rem;color: white;}
        .content .login-input input::-webkit-input-placeholder{ color:white; }
        .captcha{position: relative;}
        .captcha img{position: absolute;right: 5%;top: 0.3rem;cursor: pointer;}
    </style>

    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="layui-row">
                    <div class="layui-col-sm12 layui-col-md12">
                        <div class="content">
                            <span class="loginandreg">请登录或注册</span>
                            <hr>
                            <div class="layui-row layui-col-space20">
                                <div class="layui-col-sm12 layui-col-md6">
                                    <div class="main">
                                        <div class="layui-tab">
                                            <ul class="layui-tab-title">
                                                <li class="layui-this">个人注册</li>
                                                <li>企业注册</li>
                                            </ul>
                                            <div class="layui-tab-content">
                                                <div class="layui-tab-item layui-show">
                                                    <div class="register">
                                                        <div class="avatar">
                                                            <div><i class="layui-icon layui-icon-user"></i></div>
                                                            <div>个人发件服务</div>
                                                        </div>
                                                        <div class="youris">您是</div>
                                                        <hr class="special-hr">
                                                        <div class="message">美国 居民 留学生或从事代购海淘等<br>C2C跨境电商业务人员</div>
                                                        <div class="youris">能提供以下信息</div>
                                                        <hr class="special-hr">
                                                        <div class="message">个人身份ID、驾照或护照中的一种扫描件<br>水、电、煤气或信用卡账单的一种扫描件</div>
                                                        <a href="{{url('/register/one/personal')}}" class="layui-btn layui-btn-warm reg-btn">个人注册</a>
                                                    </div>
                                                </div>
                                                <div class="layui-tab-item">
                                                    <div class="register">
                                                        <div class="avatar">
                                                            <div><i class="layui-icon layui-icon-group"></i></div>
                                                            <div>企业发件服务</div>
                                                        </div>
                                                        <div class="youris">企业是</div>
                                                        <hr class="special-hr">
                                                        <div class="message">注册于 美国 的企业<br>从事跨境电商B2C业务</div>
                                                        <div class="youris">能提供以下信息</div>
                                                        <hr class="special-hr">
                                                        <div class="message">营业执照扫描件及编号(Business License) & 税号（EIN No.）<br>水、电、煤气账单中的一种扫描件</div>
                                                        <a href="{{url('/register/one/company')}}" class="layui-btn layui-btn-warm reg-btn">企业注册</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="layui-col-sm12 layui-col-md6">
                                    <div class="main">
                                        <div class="login-title">登陆</div>
                                        <div class="login-input">
                                            <form class="layui-form" action="">
                                                {{csrf_field()}}
                                                <div class="layui-form-item">
                                                    <input type="text" name="name" required  lay-verify="required" lay-vertype="tips" placeholder="用户名/邮箱" autocomplete="off" class="layui-input">
                                                    <input type="password" name="password" required  lay-verify="required" lay-vertype="tips" placeholder="输入密码" autocomplete="off" class="layui-input">
                                                    <div class="captcha">
                                                        <input type="text" name="verifycode" required  lay-verify="number" lay-vertype="tips" placeholder="验证码" autocomplete="off" class="layui-input">
                                                        <img id="captchaImg" src="{{captcha_src()}}" onclick="this.src='{{captcha_src()}}'+Math.random()">
                                                    </div>
                                                    <button class="layui-btn layui-btn-warm login-btn" lay-submit lay-filter="do">登陆</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.partner')
    @include('common.footer')

    <script>
        layui.use(['form'], function(){
            var form = layui.form
                    ,$ = layui.jquery;
            form.on('submit(do)', function(data){
                $.ajax({
                    type : "POST",
                    url : "{{url('/login/do')}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            layer.msg(result.msg);
                            result.isMaster == true ? setTimeout("window.location.href='/master'",500) : setTimeout("window.location.href='/user'",500);
                        }else{
                            layer.msg(result.msg);
                            $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                        }
                    },
                    error: function (error) {
                        var errors = JSON.parse(error.responseText).errors;
                        if (errors.name || errors.password){
                            layer.msg('用户名或密码错误');
                        }else if (errors.verifycode){
                            $("#captchaImg").attr('src','{{captcha_src()}}'+Math.random());
                            layer.msg('验证码错误，请重新填写');
                        }
                    }
                });
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });
        });
    </script>
@endsection