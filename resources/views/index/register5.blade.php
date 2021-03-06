@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>
        .form{margin: 1rem auto 0 auto;}
        .layui-tab-brief{height: 26rem;}
        .layui-tab-title{width: 10rem;border-bottom-style: none;height: 26rem;}
        .layui-tab-title li{float: left;margin: 0 0 20px 10px;}
        .layui-tab-title .layui-this:after{display: none;}
        .layui-tab-title .layui-this img{border: 2px solid #D2B284;}
        .layui-tab-content{height: 26rem;padding: 0;width: 84%;overflow-y: auto;}
        .layui-tab-item{min-height: 30rem;background: white;width: 94%;padding: 1rem;}
        .fc-green{color: #59B200;}
        .c-dashed {  height: 0;  font-size: 0;  border-bottom: 1px dashed #ccc;  clear: both;  margin: 0.5rem 0;}
    </style>

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

            <div class="titlecontent">
                <h1>美快会代您向海关提供进出口报关资质认证信息</h1>
                <div class="main">
                    根据进出口国家法律要求，您的包裹在通关时会向当地海关提供发件人证明信息。请确保您填写的信息真实有效。
                </div>
            </div>
            <div class="sq">
                <div class="layui-row">
                    <div class="layui-tab layui-tab-brief">
                        <ul class="layui-tab-title layui-inline">
                            <li class="layui-this"><img src="{{asset('images/sq1.jpg')}}"></li>
                            <li><img src="{{asset('images/sq2.jpg')}}"></li>
                        </ul>
                        <div class="layui-tab-content layui-inline">
                            <div class="layui-tab-item layui-show">
                                @include('index.register5_content1')
                            </div>
                            <div class="layui-tab-item">
                                @include('index.register5_content2')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form class="layui-form" action="">
                {{csrf_field()}}
                <div class="layui-row">
                    <div class="form">
                        <div class="layui-form-item">
                            <label class="layui-form-label"></label>
                            <div class="captcha">
                                <input type="checkbox" name="agree" value="1" title="我已阅读了两份授权书" lay-skin="primary">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn sub-btn" id="sub-btn" lay-submit lay-filter="do">确认授权完成注册</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('common.footer')

    <script>
        layui.use(['form','element'], function(){
            var form = layui.form
                ,element = layui.element
                ,$ = layui.jquery;

            form.on('submit(do)', function(data){
                if (!$("input[name=agree]").is(":checked")) {
                    layer.msg("请确认授权以便完成注册");
                    return false;
                }
                $.ajax({
                    type : "POST",
                    url : "{{url()->current().'/do'}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            layer.open({
                                maxWidth : '600px',
                                title: '完成注册',
                                content: '<div title="完成资料填写">\n' +
                                '                        <div style="padding:10px 36px;">\n' +
                                '                            <div class="layui-inline" style="vertical-align: top;">\n' +
                                '                                <i class="layui-icon layui-icon-ok" style="font-size: 1.5rem;color: green;font-weight: bolder;"></i>\n' +
                                '                            </div>\n' +
                                '                            <div class="layui-inline">\n' +
                                '                                <h4 class="fc-green">恭喜您，您已完成了资料填写</h4>\n' +
                                '                                <p class="fc-dim" style="color:#000">\n' +
                                '                                    我们的客服会审核确认您填写的内容，一般需1-3个工作日。<br>\n' +
                                '                                    审核结果将会以邮件的形式通知您。<br>\n' +
                                '                                    您可以先了解美快业务                                </p>\n' +
                                '                                <p><a class="fc-blue" href="/" style="text-decoration:underline; color:#F38900; font-weight: bold;">官网首页&gt;&gt;</a></p>\n' +
                                '                                <p><a class="fc-blue" href="/user" style="text-decoration:underline; color:#F38900; font-weight: bold;">进入我的wedepot&gt;&gt;</a></p>\n' +
                                '                            </div>\n' +
                                '                        </div>\n' +
                                '                        <div class="c-dashed"></div>\n' +
                                '                        <div class="bt ft-l ">\n' +
                                '                            <p class="ly-mg-b-10 fc-dim"></p>\n' +
                                '                            <p class="fc-dim">您还可以：<br>1.通过登录后页面顶部认证栏查看认证情况。<br>2.通过联系我们的客服人员与我们取得联系。</p>\n' +
                                '                        </div>\n' +
                                '                    </div>'
                                ,cancel: function(){
                                    window.location.href = '/login';
                                }
                                ,yes: function(){
                                    window.location.href = '/login';
                                }
                            });
                        } else {
                            layer.alert(result.msg);
                        }
                    },
                    error: function (error) {
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
        });
    </script>
@endsection