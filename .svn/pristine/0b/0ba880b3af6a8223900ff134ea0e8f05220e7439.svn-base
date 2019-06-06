@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>.content{margin-top2rem;padding: 2rem;} .layui-btn-disabled{pointer-events: none;}</style>
    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    运单号查询
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="content">
            @if($limit)
                @if(count($orders) >= 1)
                    @foreach($orders as $val)
                    <div class="layui-collapse">
                        <div class="layui-colla-item">
                            <h2 class="layui-colla-title">
                                {{$val['system_order_no']}}
                                <a class="layui-btn layui-btn-xs {{!$val['link'] ? 'layui-btn-disabled' : ''}}" href="{{$val['link']}}" target="_blank">点击查看国内物流信息</a>
                            </h2>
                            <div class="layui-colla-content layui-show">
                                @if(isset($val['logs']) && count($val['logs']) > 0)
                                <table class="layui-table">
                                    <colgroup>
                                        <col width="300">
                                        <col width="200">
                                        <col>
                                    </colgroup>
                                    <thead>
                                    <tr>
                                        <th>操作状态</th>
                                        <th>操作时间</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($val['logs'] as $logkey=>$log)
                                        <tr>
                                            <td>{{$allstatus[$log['status']]}}</td>
                                            <td>{{$log['created_at']}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                @else
                                    暂无信息
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <center>查询结果为0，请检查运单号输入是否正确</center>
                @endif
            @else
                <center>请输入十个以内有效的运单号</center>
            @endif
        </div>
    </div>
    @include('common.footer')

    <script>
        layui.use(['form'], function(){
            var element = layui.element,
                    $ = layui.$;
            $("a").on('click',function(event){
                event.stopPropagation();
            });
        });

    </script>
@endsection