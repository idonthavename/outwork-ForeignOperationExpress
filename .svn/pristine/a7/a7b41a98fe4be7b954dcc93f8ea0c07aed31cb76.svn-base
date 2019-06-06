@extends('common.header')

@section('content')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>.charge{margin-top: 2rem;background: #fff;}.banner-img .banner-content .little{font-size: 1.2rem;font-weight: normal;  line-height: 2.5rem;  }</style>
    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    服务中心
                    <div class="little">跨境电子商务国际物流解决方案专家</div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="charge">
            <div class="layui-row">
                <div class="layui-col-md12">
                    @php
                        echo htmlspecialchars_decode($content);
                    @endphp
                </div>
            </div>
        </div>
    </div>
    @include('common.partner')
    @include('common.footer')
@endsection