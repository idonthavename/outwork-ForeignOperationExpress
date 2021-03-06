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
    <style>
        .UEditor{width:1156px;margin: 0 auto;}
        .UEditor .save{margin-top: 1rem;float: right;}
    </style>
    <script>window.UEDITOR_HOME_URL = "/vendor/ueditor/";</script>
    @include('vendor.ueditor.assets')
</head>

<body>
<div class="layui-content">
    <div class="layui-fluid">
        <form action="/master/content" name="" method="post">
            {{csrf_field()}}
            <input type="hidden" name="type" value="{{$type}}">
            <div class="UEditor">
                <script id="container" name="content" type="text/plain" style="height:500px;">
                    @php
                        echo htmlspecialchars_decode($content);
                    @endphp
                </script>
                <button class="layui-btn layui-btn-normal save">保存</button>
            </div>
        </form>
    </div>
</div>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
    });
</script>
<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;

        @if(session()->get('ueditor-success'))
        layer.msg('保存成功', {
            time: 3000,
            icon:1
        });
        @endif

        @if(session()->get('ueditor-error'))
        layer.msg('保存失败', {
            time: 3000,
            icon:2
        });
        @endif
    })
</script>
</body>
</html>