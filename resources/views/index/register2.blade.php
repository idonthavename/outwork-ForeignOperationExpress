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
                    <div class="emailverify-content">
                    尊敬的会员 您好，<br>
                    邮箱验证码已发送至您的邮箱，请输入邮件中的验证码。<br>
                    如果没有收到验证邮件，请到垃圾邮箱中找找看，或者点击<a class="layui-btn layui-btn-xs email-resend">重新获取</a>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">邮箱验证码<i>*</i></label>
                        <div class="layui-input-block">
                            <input type="text" name="emailverifycode" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
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

            $(".email-resend").on('click',function () {
                layer.msg('验证码邮件已发送');
                var btn = $(this);
                $.get('{{url('/register/two/'.$type.'/sendEmail')}}',function (result) {
                    if (result.status == 200){
                        btn.addClass("layui-btn-disabled");
                        //n秒后重发
                        var s = 60;
                        btn.text(s+"后重发")
                        var time = setInterval(function() {
                            s = s-1;
                            btn.text(s+"后重发");
                            if (s <= 0) {
                                clearInterval(time);
                                btn.text("重新获取").removeClass('layui-btn-disabled');
                            }
                        }, 1000);
                    } else {
                        layer.alert(result.msg);
                    }
                })
            });

            form.on('submit(do)', function(data){
                $.ajax({
                    type : "POST",
                    url : "{{url()->current().'/do'}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            window.location.href='{{url('/register/three/'.$type)}}';
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

            $(document).ready(function(){
                $(".email-resend").click();
            });
        });
    </script>
@endsection