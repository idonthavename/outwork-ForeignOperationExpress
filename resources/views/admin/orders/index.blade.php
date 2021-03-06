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
    <div class="layui-fluid">
        <div class="layui-row orders">
            <div class="layui-col-md12">
                <div class="layui-card">
                    <div class="layui-card-header">
                        选择路线下载/上传模板
                    </div>
                    <div class="layui-card-body">
                        <div class="layui-form-item layui-row depot_select">
                            <div class="layui-col-md12 content">
                                <a id="showUpload" class="layui-btn layui-btn-radius layui-btn-normal layui-btn-sm layui-bg-black">批量上传</a>
                            </div>
                            <div class="uploadDetail layui-hide">
                                <div class="layui-col-md12 content layui-text">
                                    *确认导入后，正确的直接生成订单，不正确的在下方列表显示；<br>
                                    取消导入后，则该次上传的均不生成订单，可在Excel更改后再次导入生成订单。
                                </div>
                                <form class="layui-form" action="">
                                    <div class="layui-col-md12 content orders-form">
                                        <div class="layui-form-item my-form-item">
                                            @foreach($lineData as $val)
                                                <input type="radio" name="line_id" value="{{$val['id']}}" title="{{$val['name']}}" lay-filter="mimenu" data-excel="{{$val['ordersExcel']}}">
                                            @endforeach
                                        </div>
                                        <div class="layui-form-item my-form-item">
                                            <a id="download" href="/excel/pldr-yxemsgrkj.xlsx" class="layui-btn layui-btn-radius layui-btn-normal layui-btn-sm layui-bg-black"><i class="layui-icon layui-icon-download-circle"></i>下载模板</a>
                                            <a id="upload" class="layui-btn layui-btn-radius layui-btn-normal layui-btn-sm layui-bg-black"><i class="layui-icon layui-icon-upload-circle"></i>上传文件</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-fluid" style="margin-top: 1rem;">
        <div class="layui-card">
            <div class="layui-card-header">
                包裹错误信息列表
            </div>
            <div class="layui-card-body">
                <table class="layui-table" lay-size="lg">
                    <colgroup>
                        <col width="300">
                        <col>
                    </colgroup>
                    <thead>
                    <tr>
                        <th>外部订单号</th>
                        <th>错误信息</th>
                    </tr>
                    </thead>
                    <tbody>
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
    }).use(['index', 'table', 'upload', 'form'], function(){
        var table = layui.table
                ,form = layui.form
                ,$ = layui.$
                ,upload = layui.upload;

        $("#showUpload").on('click',function () {
            var ishide = $(".uploadDetail").hasClass("layui-hide");
            if (ishide){
                $(".uploadDetail").removeClass("layui-hide");
                $(".uploadDetail").addClass("layui-show");
            }else {
                $(".uploadDetail").addClass("layui-hide");
                $(".uploadDetail").removeClass("layui-show");
            }
        });

        form.on('radio(mimenu)', function(data){
            var id = $(this).val();
            var excel = data.elem.getAttribute('data-excel');
            $("#download").attr('href',excel ? '/uploads/'+excel : '/excel/orders-'+id+'.xlsx');
        });

        upload.render({
            elem: '#upload'
            ,url: '/user/orders/upload'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{
                '_token':"{{csrf_token()}}"
                ,line_id: function(){
                    return $('input[name=line_id]:checked').val();
                }
            }
            ,before: function(){
                $("tbody").html("");
                layer.load();
            }
            ,done: function(res){ //上传后的回调
                if(res.status == 200){
                    if (res.isWrong == true){
                        var data = res.data;
                        var html = '';
                        $.each(data,function (order_no, oitem) {
                            html += '<tr><td>'+order_no+'</td><td><div class="layui-row">';
                            $.each(oitem,function (row, errors) {
                                html += '<div class="layui-col-md1">'+row+'行：</div><div class="layui-col-md11 text-red">';
                                $.each(errors,function (errorname,erroritem) {
                                    html += erroritem[0]+'<br>';
                                })
                                html += '</div>';
                            })
                            html += '</div></td></tr>';
                        });
                        $("tbody").html(html);
                    }else {
                        layer.alert(res.msg);
                    }
                }else {
                    layer.msg(res.msg);
                }
                layer.closeAll('loading');
            }
            ,error: function (errors) {
                layer.closeAll('loading');
            }
        });
    });
</script>
</body>
</html>