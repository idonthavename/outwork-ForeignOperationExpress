@extends('common.header')

@section('content')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>.charge{margin: 2rem 0;background: #fff;min-height: 40rem;padding: 2rem;}.banner-img .banner-content .little{font-size: 1.2rem;font-weight: normal;  line-height: 2.5rem;}  .charge .title{font-size: .9375rem;  line-height: 1.302083rem;  margin-top: .520833rem;}  .charge .time{    font-size: 14px;  color: #999;  margin-top: 1.041667rem;  margin-bottom: 1.041667rem;}</style>
    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    wedepot物流
                    <div class="little">您的跨境购物与国际物流方案解决专家</div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="charge">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <span class="layui-breadcrumb">
                      <a href="/news">公告中心</a>
                      <a><cite>{{$info['title']}}</cite></a>
                    </span>
                    <hr>
                    <p class="title">{{$info['title']}}</p>
                    <p class="time">{{$info['created_at']}}</p>
                    @php
                        echo htmlspecialchars_decode($info['content']);
                    @endphp
                </div>
            </div>
        </div>
    </div>
    @include('common.footer')
@endsection