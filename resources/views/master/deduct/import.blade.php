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
</head>
<body>


<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <form class="layui-form" action="">
                <div class="layui-form layui-card-header layuiadmin-card-header-auto">
                    <div class="layui-form-item">
                        <div class="layui-inline">
                            <button class="layui-btn layuiadmin-btn-list" id="upload" onclick="return false;">批量导入扣款</button>
                        </div>
                        <div class="layui-inline">
                            <a class="layui-btn layuiadmin-btn-list" href="{{asset('excel/masterDeduct.xls')}}">下载导入扣款模板</a>
                        </div>
                    </div>
            </form>

            <div class="layui-card-body">
                <table class="layui-table">
                    <colgroup>
                      <col width="150">
                      <col width="150">
                      <col width="200">
                      <col>
                    </colgroup>
                    <thead>
                      <tr>
                        <th>订单号</th>
                        <th>金额</th>
                        <th>处理信息</th>
                        <th>状态</th>
                      </tr> 
                    </thead>
                    <tbody class="tab-list">
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
    }).use(['index', 'upload'], function(){
        var form = layui.form
                ,upload = layui.upload
                ,$ = layui.$;;

        upload.render({
            elem: '#upload'
            ,url: '/master/deduct/excelDeduct'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{'_token':"{{csrf_token()}}"}
            ,before: function(){layer.load();}
            ,done: function(res){ //上传后的回调
                layer.msg(res.msg);
                createList(res.data);
                layer.closeAll('loading');
            }
            ,error: function (errors) {
                layer.closeAll('loading');
            }
        });

        function createList(data) {
            $('.tab-list').children('tr').remove();
            $.each(data,function(i,val){
                var html = $(
                    '<tr>'+
                    '<td>'+val.order_no+'</td>'+
                    '<td>'+val.money+'</td>'+
                    '<td>'+val.info+'</td>'+
                    '<td>'+val.status+'</td>'+
                    '<tr/>'
                );
            // 添加子元素
            $('.tab-list').append(html);
            });
        }

    })
</script>
</body>
</html>