@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>
        .banner-img .banner-content .little{font-size: 1.2rem;font-weight: normal;  line-height: 2.5rem;  }
        .charge{margin-top: 2rem;background: #fff;padding: 1.5rem;}
        .charge .part1-header{font-size: 1.2rem;}
        .charge .part1-body{font-size: 0.95rem;line-height: 1.5rem;}
        .charge-img01{background: url('/images/about01.jpg') no-repeat;max-height: 324px;background-size: 100%;}
        .charge-img02{background: url('/images/about02.jpg') no-repeat;max-height: 324px;background-size: 100%;}
        .charge-img03{background: url('/images/about03.jpg') no-repeat;max-height: 324px;background-size: 100%;}
        .charge-img04{background: url('/images/about04.jpg') no-repeat;max-height: 324px;background-size: 100%;}
        .charge .part2-title{font-size: 1.5rem;margin-top: 5.4rem;}
        .charge .part2-body{font-size: 0.8rem;    margin-top: 1.5rem;  width: 32rem;  line-height: 1.5rem;  height: 8rem;}
        .charge .text-right{text-align: right;}
        .charge .float-right{float: right;}
    </style>

    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    关于我们
                    <div class="little">您的跨境购物与国际物流方案解决专家</div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="charge">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <div class="part1-header">wedepot物流</div>
                    <hr>
                    <div class="part1-body">wedepot团队由资深物流与互联网IT人才组成，前身为“美合快递”，一直秉承着“整合、分享、简单”的服务精神，坚持“安全、快速、优质”的经营理念，为顾客提供物超所值的国际物流产品。</div>
                </div>
            </div>
        </div>
        <div class="charge charge-img01">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <div class="part2-title">广阔的海外仓储空间</div>
                    <div class="part2-body">如果您常在海外网站购物，或者您在不同的网站购物时，不想一件一件的邮寄，并支付多个的首磅运费，或者您想将货件发给不同的收件人，wedepot能为您提供广阔的海外仓储空间，为您规划最省时、最便利的发货方式。</div>
                </div>
            </div>
        </div>
        <div class="charge charge-img02">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <div class="part2-title text-right">物流状态的全程跟踪</div>
                    <div class="part2-body text-right float-right">wedepot为您提供全程跟踪货物状态的电子商务平台，不管您在身在何处，都可通过互联网随时随地查询跟踪货物的最新动态，让您收发自如。</div>
                </div>
            </div>
        </div>
        <div class="charge charge-img03">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <div class="part2-title">支持双币支付，便捷、省心</div>
                    <div class="part2-body">您可以使用美金支付运费，亦可使用人民币支付运费，wedepot支持微信、支付宝、银行转账等多种支付方式，任选一种最便利的方式充值、支付即可。系统根据您的货物的类别、重量、体积等信息，自动完成结算与扣款，您可以通过wedepot会员后台系统实时查询账户信息、运费明细，账目清晰明了，便捷又省心。</div>
                </div>
            </div>
        </div>
        <div class="charge charge-img04">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <div class="part2-title text-right">专业客服贴心服务</div>
                    <div class="part2-body text-right float-right">工作日客服人员在线服务，周末设有值班客服，您也可通过电话、在线客服等方式联系客服人员，为您的海外购物排忧解难。
                        我们还为您提供加固包装、取出发票、整合理货、拆分包裹、内件清点、
                        拍照核对、退货等附加增值服务，以满足您不同的消费需求。</div>
                </div>
            </div>
        </div>
    </div>
    @include('common.partner')
    @include('common.footer')
@endsection