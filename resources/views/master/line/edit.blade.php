<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <style>#address{width:590px;}  select{  border: none;  outline: none;  width: 100%;  height: 40px;  line-height: 40px;  appearance: none;  -webkit-appearance: none;  -moz-appearance: none;  padding-left: 10px;  border-width: 1px;  border-style: solid;  background-color: #fff;  border-radius: 2px;  border-color: #e6e6e6;  cursor: pointer;  }  select:hover{  border-color: #D2D2D2 !important;  }.excel{width: 200px;}</style>
</head>
<body>


<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$data['id']}}">
    <button id="sync" class="layui-hide">同步</button>
    <div class="layui-form-item">
        <label class="layui-form-label">* 线路名</label>
        <div class="layui-input-block">
            <input type="text" name="name" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入路线名" value="{{$data['name']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 渠道名</label>
        <div class="layui-input-block">
            <input type="text" name="channel" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入渠道名" value="{{$data['channel']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 二级线路</label>
        <div class="layui-input-block">
            @foreach($linetwos as $val)
                <input type="checkbox" name="linetwos[]" value="{{$val['id']}}" title="{{$val['name']}}" lay-skin="primary" {{$data['linetwos'] && in_array($val['id'],$data['linetwos']) ? 'checked' : ''}}>
            @endforeach
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 产品大类</label>
        <div class="layui-input-block">
            @foreach($products as $val)
                <input type="checkbox" name="products[]" value="{{$val['id']}}" title="{{$val['name']}}" lay-skin="primary" {{$data['products'] && in_array($val['id'],$data['products']) ? 'checked' : ''}}>
            @endforeach
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">* 首重</label>
        <div class="layui-input-inline">
            <input type="text" name="ykg" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="精确到0.01磅" value="{{$data['ykg'] ? $data['ykg'] : '0.00'}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 重量单位</label>
        <div class="layui-input-inline">
            <select name="unit" lay-verify="required" lay-verType="tips">
                <option value="">请选择</option>
                <option value="磅" {{$data['unit'] == '磅' ? 'selected' : ''}}>磅</option>
                <option value="克" {{$data['unit'] == '克' ? 'selected' : ''}}>克</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 首重单价</label>
        <div class="layui-input-inline">
            <input type="text" name="price[1]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="一级会员" value="{{$data['price'][1]}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="price[2]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="二级会员" value="{{$data['price'][2]}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="price[3]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="三级会员" value="{{$data['price'][3]}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="price[4]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="四级会员" value="{{$data['price'][4]}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="price[5]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="五级会员" value="{{$data['price'][5]}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">* 续重</label>
        <div class="layui-input-inline">
            <input type="text" name="goon" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="精确到0.01" value="{{$data['goon'] ? $data['goon'] : '0.00'}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">* 续重单价</label>
        <div class="layui-input-inline">
            <input type="text" name="overweight[1][price]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="一级会员" value="{{$data['overweight'][1]['price']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="overweight[2][price]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="二级会员" value="{{$data['overweight'][2]['price']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="overweight[3][price]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="三级会员" value="{{$data['overweight'][3]['price']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="overweight[4][price]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="四级会员" value="{{$data['overweight'][4]['price']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-inline">
            <input type="text" name="overweight[5][price]" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="五级会员" value="{{$data['overweight'][5]['price']}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">* 续重规则</label>
        <div class="layui-input-inline">
            <select name="rule" lay-verify="required" lay-verType="tips">
                <option value="">请选择</option>
                <option value="1" {{$data['rule'] == '1' ? 'selected' : ''}}>取整</option>
                <option value="2" {{$data['rule'] == '2' ? 'selected' : ''}}>实重</option>
                <option value="3" {{$data['rule'] == '3' ? 'selected' : ''}}>退位</option>
            </select>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 退位刻度</label>
        <div class="layui-input-inline">
            <input type="text" name="outon" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="精确到0.01" value="{{$data['outon'] ? $data['outon'] : '0.00'}}">
        </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">  备注</label>
        <div class="layui-input-block">
            <input type="text" name="remark" class="layui-input" autocomplete="on" placeholder="备注" value="{{$data['remark']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  是否停用</label>
        <div class="layui-input-block">
            <input name="isban" lay-skin="switch" lay-text="是|否" type="checkbox" {{$data['isban'] ? 'checked' : ''}}>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  图片上传</label>
        <div class="layui-input-block">
            <input name="iupid" lay-skin="switch" lay-text="是|否" type="checkbox" {{$data['iupid'] ? 'checked' : ''}}>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  排序</label>
        <div class="layui-input-block">
            <input type="text" name="order" lay-verify="number" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入排序号" value="{{$data['order'] ? $data['order'] : 0}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  说明</label>
        <div class="layui-input-block">
            <textarea class="layui-textarea" name="content" id="content" style="display: none">{{$data['content']}}</textarea>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">  批量模板</label>
        <div class="layui-input-block">
            <p class="layui-inline layui-elip excel" id="ordersExcelP">{{$data['ordersExcel']}}</p>
            <button type="button" class="layui-btn" id="excelTemplate">
                <i class="layui-icon">&#xe67c;</i>上传文件
            </button>
            <input type="hidden" name="ordersExcel" id="ordersExcel" value="{{$data['ordersExcel']}}">
            <button type="button" class="layui-btn" id="cancelOrders">取消</button>
            <a href="/excel/pldr-yxemsgrkj.xlsx">示例模板</a>
        </div>
    </div>
    {{--<div class="layui-form-item">
        <label class="layui-form-label">  在线模板</label>
        <div class="layui-input-block">
            <p class="layui-inline layui-elip excel" id="onlineExcelP">{{$data['onlineExcel']}}</p>
            <button type="button" class="layui-btn" id="excelTemplate1">
                <i class="layui-icon">&#xe67c;</i>上传文件
            </button>
            <a href="/excel/yxemsgrkj.xlsx">示例模板</a>
            <input type="hidden" name="onlineExcel" id="onlineExcel" value="{{$data['onlineExcel']}}">
        </div>
    </div>--}}
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
    }).use(['index', 'form', 'layedit', 'upload'], function(){
        var $ = layui.$
                ,form = layui.form
                ,layedit = layui.layedit
                ,upload = layui.upload;

        var content = layedit.build('content', {
            tool: ['link', 'unlink', '|', 'left', 'center', 'right']
            ,height: 100
        });

        $("#sync").on('click',function () {
            layedit.sync(content);
            return false;
        });

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            field.content = layedit.getContent(content);
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引

            //提交 Ajax 成功后，关闭当前弹层
            $.ajax({
                type : "POST",
                url : "{{url('master/line')}}",
                data : field,
                dataType: 'json',
                success : function(result) {
                    layer.alert(result.msg);
                    if (result.status == 200){
                        parent.layui.table.reload('list-index'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    }else{
                        layer.msg(result.msg);
                    }
                },
                error: function (error) {
                    var errors = error.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        layer.msg(value[0]);
                        return false;
                    });
                }
            });
            return false;
        });

        upload.render({
            elem: "#excelTemplate"
            ,url: '/master/line/excel'
            ,method: 'put'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{
                '_token':"{{csrf_token()}}"
            }
            ,before: function(){
                layer.load();
            }
            ,done: function(res){ //上传后的回调
                if (res.status == 200){
                    $("#ordersExcelP").text(res.url);
                    $("#ordersExcel").val(res.url);
                }
                layer.closeAll('loading');
                layer.msg(res.msg);
            }
            ,error: function(){layer.closeAll('loading');}
        });
        upload.render({
            elem: "#excelTemplate1"
            ,url: '/master/line/excel'
            ,method: 'put'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{
                '_token':"{{csrf_token()}}"
            }
            ,before: function(){
                layer.load();
            }
            ,done: function(res){ //上传后的回调
                if (res.status == 200){
                    $("#onlineExcelP").text(res.url);
                    $("#onlineExcel").val(res.url);
                }
                layer.closeAll('loading');
                layer.msg(res.msg);
            }
            ,error: function(){layer.closeAll('loading');}
        });

        $("#cancelOrders").on('click',function(){
            $('#ordersExcelP').text('');
            $('#ordersExcel').val('');
        });
    })
</script>
</body>
</html>