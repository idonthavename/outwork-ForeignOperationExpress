<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <link rel="stylesheet" href="{{asset('css/view.css')}}">
    <style>
        .sender-show-form .layui-input-block{margin: 1rem 0;}
        .default a{display: none;color: #177ce3;}
        .layui-table, .layui-table-view{margin : 0;}
    </style>
</head>
<body>


    <form class="layui-form">
        <table class="layui-table" lay-skin="nob">
            <thead>
            <tr>
                <th width="50">序号</th>
                <th>货品类别</th>
                <th>货品名称</th>
                <th>英文品牌</th>
                <th>单价(美元)</th>
                <th>规格/型号/材质</th>
                <th>数量</th>
                <th>备注</th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $key=>$val)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$val->categoryOne->name}} / {{$val->categoryTwo->name}}</td>
                    <td>{{$val['detail']}}</td>
                    <td>{{$val['brand']}}</td>
                    <td>{{$val['price']}}</td>
                    <td>{{$val['catname']}}</td>
                    <td>{{$val['amount']}}</td>
                    <td>{{$val['remark']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </form>


<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'form', 'laypage'], function(){
        var $ = layui.$
            ,table = layui.table
            ,form = layui.form;

    })
</script>
</body>
</html>