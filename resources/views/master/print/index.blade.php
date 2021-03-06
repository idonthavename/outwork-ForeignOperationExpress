<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文章列表</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/view.css')}}">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <style>
        .layui-card-header{font-size: 1.2rem;text-indent: 1rem;}
        .layui-card .content{margin: 0 1rem;}
        .orders .layui-btn{width: 8rem;}
        .orders .orders-form{background: #f2f2f2;padding: 0 2rem;width: 98%;}
        .orders .my-form-item{margin: 2rem 0;}
        .text-red{color: red;}
    </style>
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid" style="margin-top: 1rem;">
        <div class="layui-card">
            <div class="layui-card-header"></div>
            <div class="layui-card-body">
                <table class="layui-table">
                    <colgroup>
                        <col width="300">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>模板名称</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($print_template as $key=>$val)
                        <tr>
                            <td>{{$val['name']}}</td>
                            <td><a href="{{url('master/print/show')}}?template={{$key}}" class="layui-btn layui-btn-normal layui-btn-xs" target="_blank">查看</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table'], function(){
        var table = layui.table;
    });
</script>
</body>
</html>