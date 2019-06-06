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
        tbody tr{cursor: pointer;}
        .default a{display: none;color: #177ce3;}
    </style>
</head>
<body>

<div class="layui-container">
    <form class="layui-form sender-show-form">
        {{csrf_field()}}
        <div class="layui-row layui-col-space20">
            <div class="layui-col-xs10">
                    <div class="layui-input-block">
                        <input type="text" name="param" id="param" placeholder="输入姓名/手机号" autocomplete="on" class="layui-input" value="{{$param}}">
                    </div>
            </div>
            <div class="layui-col-xs2">
                <div class="layui-input-block">
                    <button class="layui-btn layui-btn-radius layui-btn-primary layui-bg-black" lay-filter="search" lay-submit>搜索</button>
                </div>
            </div>
        </div>
    </form>
    <form class="layui-form">
        <table class="layui-table" lay-skin="nob">
            <thead>
            <tr>
                <th width="20"></th>
                <th>姓名</th>
                <th>手机号码</th>
                <th>邮编</th>
                <th>寄件人地址</th>
                <th width="80"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $val)
            <tr>
                <td><input type="radio" name="bookin" value="{{$val['id']}}" @if($val['isdefault'] == 1) checked @endif></td>
                <td>{{$val['name']}}</td>
                <td>{{$val['phone']}}</td>
                <td>{{$val['code']}}</td>
                <td>{{$val['province']}}/{{$val['city']}}/{{$val['town']}}</td>
                <td class="default"><a tid="{{$val['default']}}" onclick="send_addrtype({{$val['id']}})">设为默认</a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div id="pages"></div>
        <center>
            <button class="layui-btn layui-btn-primary layui-btn-lg layui-bg-black" lay-filter="ok" lay-submit>确定</button>
        </center>
    </form>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'form', 'laypage'], function(){
        var $ = layui.$
                ,table = layui.table
                ,form = layui.form
                ,laypage = layui.laypage;

        $('table').on('click', 'tr', function(e){
            var trs = $(this).parent('tbody').find('tr');
            $.each(trs, function(index, item) {
                $(item).find('td:eq(0) input').prop('checked', false);
            });
            $(this).find('td:eq(0) input').prop('checked',true);
            form.render();
        });

        //回填信息
        form.on('submit(ok)', function(data){
            var radio_che     = $('input:radio:checked').val();
            var index = parent.layer.getFrameIndex(window.name);
            parent.layer.close(index);
            parent.get_addrinfo(radio_che,'');
            return false;
        });

        //搜索
        form.on('submit(search)', function(data){
            location.href = '/user/receiver/0'+(data.field.param ? '-'+data.field.param : '');
            return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
        });

        //翻页
        laypage.render({
            elem: 'pages'
            ,count: {{$count}} //数据总数，从服务端得到
            ,curr: "{{$curr}}"
            ,limit:5
            ,jump: function(obj, first){
                //首次不执行
                if(!first){
                    var param = $("#param").val();
                    location.href = '/user/receiver/'+obj.curr+(param ? '-'+param : '');
                }
            }
        });
    })
</script>
<script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
<script>
    $('tbody tr').mouseover(function(){
        if($(this).find('.default a').attr('tid') == 0){
            $(this).find('.default').children().css('display','inline-block');
        }
    });
    $('tbody tr').mouseout(function(){
        if($(this).find('.default a').attr('tid') == 0){
            $(this).find('.default').children().hide();
        }
    });
    function send_addrtype(id){
        $.ajax({
            type : "PUT",
            url : "/user/receiver/"+id,
            dataType: 'json',
            data:{_token:$("input[name=_token]").val()},
            success:function (res) {
                if (res.status == 200){
                    window.location.reload();
                }else {
                    layer.msg('保存失败');
                }
            }
        });
    }
</script>
</body>
</html>