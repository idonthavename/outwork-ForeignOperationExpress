@extends('common.header')

@section('content')
    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>.charge{margin: 2rem 0;background: #fff;min-height: 40rem;}.banner-img .banner-content .little{font-size: 1.2rem;font-weight: normal;  line-height: 2.5rem;}</style>
    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    公告中心
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="charge">
            <div class="layui-row">
                <div class="layui-col-md12">
                    <table class="layui-table" lay-skin="nob" lay-size="lg">
                        <colgroup>
                            <col>
                            <col width="200">
                        </colgroup>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $val)
                                <tr>
                                    <td><a href="/newsDetail/{{$val['id']}}">{{$val['title']}}</a></td>
                                    <td>{{$val['created_at']}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('common.footer')
@endsection