<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <title>Wedepot快递官网</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">--}}
    <script type="text/javascript" src="{{asset('js/viewport.js')}}"></script>
    <link href="{{ asset('css/layui.css') }}" rel="stylesheet">
    <link href="{{ asset('css/common/header.css') }}" rel="stylesheet">
    <script src="{{ asset('js/layui.js') }}"></script>
    <script src="{{ asset('js/jquery-1.8.3.min.js') }}"></script>
    <script src="{{ asset('js/jquery.kxbdmarquee.js') }}"></script>
    <script>
        layui.use(['layer','element'] , function(){
            var layer = layui.layer
                    ,element = layui.element;
        });
    </script>
</head>
<body>
    <div class="header">
        <div class="layui-row">
            <div class="layui-col-xs12 layui-col-sm-offset7 layui-col-md3 layui-col-md-offset8" style="position: absolute;z-index: 1000;">
                <div class="login-vz">
                    <div class="an_span">
                        <i class="layui-icon layui-icon-speaker"></i>
                        <div id="inform">
                            <ul>
                                <li><a href="/news" target="_blank">{{$inform['title']}}</a></li>
                            </ul>
                        </div>
                        <a href="{{url('login')}}">登录</a>&nbsp;/&nbsp;<a href="{{url('login')}}">注册</a>
                        &nbsp;&nbsp;
                        <a href="/Index/index?l=zh-cn">中文</a>&nbsp;/&nbsp;<a href="/Index/index?l=en-us">English</a>
			        </div>
                </div>
            </div>
        </div>

        <div class="layui-container">
            <div class="layui-row">
                <div class="layui-col-sm6 layui-col-md5">
                    <div class="header-logo">
                        <a href="/"><img src="{{asset('images/logo.png')}}"></a>
                    </div>
                </div>

                <div class="layui-col-sm6 layui-col-md7">
                    <ul class="layui-nav header-nav">
                        <li class="layui-nav-item header-nav-item @if(url('/') == url()->current()) layui-this @endif"><a href="{{url('/')}}">首页</a></li>
                        <li class="layui-nav-item header-nav-item @if(url('/service') == url()->current()) layui-this @endif"><a href="/service">产品服务</a></li>
                        <li class="layui-nav-item header-nav-item @if(url('/charge') == url()->current()) layui-this @endif"><a href="/charge">收费说明</a></li>
                        <li class="layui-nav-item header-nav-item @if(url('/about') == url()->current()) layui-this @endif"><a href="/about">关于我们</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        @yield('content')
    </div>
</body>
<script type="text/javascript">
    $(function(){
        $("#inform").kxbdMarquee({hover:false});
    });
</script>
</html>