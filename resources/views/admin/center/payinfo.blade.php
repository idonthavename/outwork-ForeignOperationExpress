<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="baidu-site-verification" content="jpBCrwX689" />
    <title>支付页面</title>
    <link rel="stylesheet" href="/css/payinfo.css" />
    <link rel="stylesheet" href="/css/layui.css" />
    <style>
        .icon-border{font-size: 2.5rem; font-weight: bolder; border: 3px solid #d7d7d7; border-radius: 4rem; padding: 4px;width: 3rem; height: 3rem; text-align: center;display: inline-block;}
        .icon-border i{vertical-align: middle;}
        .layui-icon-ok{color: #91ca00;}
        .layui-icon-close{color: red;}
    </style>
</head>
<body cz-shortcut-listen="true">
<div class="wrap1">
    <div class="wrap2">
        <header class="wrap ">
            <nav>
                <a href="{{url('/')}}"><img src="/images/logo.png" class="logo fleft" /></a>
            </nav>
        </header>
        <div class="tdou_wrap">
            <div class="messOuter">
                <div class="mess">
                    <div class="icon-border">
                        <i class="layui-icon layui-icon-ok"></i>
                    </div>
                    <span>{{$msg}}</span>
                </div>
                @if($status == 'success')
                <span class="costMoney">您已成功充值<span class="money-num-color">{{$detail['amount']}}</span>美金</span>
                @endif
                <div class="recharge-info">
                    {{--<div class="recharge-item">
                        <span class="recharge-left">充值游戏：</span>
                        <span class="game-name">三国杀Online</span>
                    </div>
                    <div class="recharge-item">
                        <span class="recharge-left">充值账号：</span>
                        <span class="game-account">雯雯= =</span>
                    </div>--}}
                    <div class="recharge-item">
                        <span class="recharge-left">充值订单：</span>
                        <span class="game-account">{{$detail['reference']}}</span>
                    </div>
                    <div class="recharge-item">
                        <span class="recharge-left">充值时间：</span>
                        <span class="game-time">{{date('Y-m-d H:i:s',strtotime($detail['time']))}}</span>
                    </div>
                    <a class="recharge" href="{{url('/')}}">返回首页</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>