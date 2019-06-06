<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <style>#address{width:590px;}  select{  border: none;  outline: none;  width: 100%;  height: 40px;  line-height: 40px;  appearance: none;  -webkit-appearance: none;  -moz-appearance: none;  padding-left: 10px;  border-width: 1px;  border-style: solid;  background-color: #fff;  border-radius: 2px;  border-color: #e6e6e6;  cursor: pointer;  }  select:hover{  border-color: #D2D2D2 !important;  }</style>
    @if($type == 5)
        <script>window.UEDITOR_HOME_URL = "/vendor/ueditor/";</script>
        @include('vendor.ueditor.assets')
    @endif
</head>
<body>


<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$data['id']}}">
    <input type="hidden" name="type" value="{{$type}}">
    <div class="layui-form-item">
        <label class="layui-form-label">* 标题</label>
        <div class="layui-input-block">
            <input type="text" name="title" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入标题" value="{{$data['title']}}">
        </div>
    </div>
    @if($type == 3 || $type == 4)
    <div class="layui-form-item">
        <label class="layui-form-label">* 图片</label>
        <div class="layui-input-block">
            <img src="{{$data['thumb'] ? '/uploads/'.$data['thumb'] : '/images/upload_pic_3.jpg'}}" id="fileimage2" style="width: 200px;height: 200px;">
            <input type="file" name="thumb" class="uploadfile" id="thumb" accept="image/jpeg,image/jpg,image/png" atd="2" onclick="fileOnchange(this)">
        </div>
    </div>
    <div style="clear:both;"></div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 链接</label>
        <div class="layui-input-block">
            <input type="text" name="link" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入链接" value="{{$data['link']}}">
        </div>
    </div>
    @endif
    @if($type == 5)
    <div class="layui-form-item">
        <label class="layui-form-label"> 内容</label>
        <div class="layui-input-block">
            <textarea id="container" name="content" type="text/plain" style="height:300px;">
                @php
                    echo htmlspecialchars_decode($data['content']);
                @endphp
            </textarea>
        </div>
    </div>
    <script type="text/javascript">
        var ue = UE.getEditor('container');
    </script>
    @endif
    <div class="layui-form-item">
        <label class="layui-form-label">  排序</label>
        <div class="layui-input-block">
            <input type="text" name="order" lay-verify="number" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入排序号" value="{{$data['order'] ? $data['order'] : 0}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  是否停用</label>
        <div class="layui-input-block">
            <input name="isban" lay-skin="switch" lay-text="是|否" type="checkbox" {{$data['isban'] ? 'checked' : ''}}>
        </div>
    </div>
    <div class="layui-form-item layui-hide">
        <input type="button" lay-submit lay-filter="layuiadmin-app-form-submit" id="layuiadmin-app-form-submit" value="确认添加">
        <input type="button" lay-submit lay-filter="layuiadmin-app-form-edit" id="layuiadmin-app-form-edit" value="确认编辑">
    </div>
</div>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form'], function(){
        var $ = layui.$
                ,form = layui.form;

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var formData = getFormData(field);
            $.ajax({
                type : "POST",
                url : "{{url('master/content')}}",
                data : formData,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                success : function(result) {
                    if (result.status == 200){
                        parent.layui.layer.alert(result.msg);
                        parent.layui.table.reload('list-index'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    }else{
                        layer.msg(result.msg);
                    }
                },
                error: function (error) {
                    var errors = JSON.parse(error.responseText).errors;
                    $.each(errors, function (key, value) {
                        parent.layui.layer.msg(value[0]);
                        return false;
                    });
                }
            });
            return false;
        });
    })
</script>
<script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
<script>
    function fileOnchange(pid){
        var atd = pid.getAttribute("atd");
        // alert(atd);
        var input = pid;

        var res = document.getElementById("fileimage"+atd);
        if(typeof FileReader==='undefined'){
            res.innerHTML = "抱歉，你的浏览器不支持 FileReader";
            input.setAttribute('disabled','disabled');
        }else{
            input.addEventListener('change',readFile,false);
        }

        //图片文件读取
        function readFile(){
            var file = this.files[0];
            // console.log(file);
            if(!/image\/\w+/.test(file.type)){
                layer.open({
                    type: 0,
                    title: false,
                    content: "文件必须为图片！"
                });
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                res.src = this.result;  //赋值到src
            }
        }
    }

    function getFormData(original){
        var formData = new FormData();
        $.each(original,function (key, val) {
            if (key != 'thumb'){
                formData.append(key,val);
            }
        });
        @if($type == 5)
        formData.append('content',UE.getEditor('container').getContent());
        @else
        formData.append('thumb',$("#thumb")[0].files[0]);
        @endif
        return formData;
    }
</script>
</body>
</html>