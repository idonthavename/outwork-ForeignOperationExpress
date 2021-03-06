<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <style>.layui-form-label{width: 105px;}#address{width:590px;}  select{  border: none;  outline: none;  width: 100%;  height: 40px;  line-height: 40px;  appearance: none;  -webkit-appearance: none;  -moz-appearance: none;  padding-left: 10px;  border-width: 1px;  border-style: solid;  background-color: #fff;  border-radius: 2px;  border-color: #e6e6e6;  cursor: pointer;  }  select:hover{  border-color: #D2D2D2 !important;  }</style>
</head>
<body>


<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 30px 0 0;">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$data['id']}}">
    <div class="layui-form-item">
        <label class="layui-form-label">* 姓名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="required" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="请输入寄件人姓名" value="{{$data['name']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 手机号码</label>
        <div class="layui-input-inline">
            <input type="text" name="phone" lay-verify="required" lay-verType="tips" autocomplete="on"class="layui-input" placeholder="寄件人电话号码" value="{{$data['phone']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 国家 / 州 / 城市</label>
        <div class="layui-input-inline">
            <select name="country" class="layui-disabled" disabled="disabled">
                <option value="U.S.A">U.S.A</option>
            </select>
        </div>
        <div class="layui-input-inline">
            <div class="layui-unselect layui-form-select">
                <div class="layui-select-title">
                    <select name="province" lay-verify="required" lay-ignore lay-verType="tips">
                        <option value="">请选择</option>
                        <option citys="1" value="Alaska">Alaska</option><option citys="2" value="Alabama">Alabama</option><option citys="3" value="Arkansas">Arkansas</option><option citys="4" value="Arizona">Arizona</option><option citys="5" value="California">California</option><option citys="6" value="Colorado">Colorado</option><option citys="7" value="Connecticut">Connecticut</option><option citys="8" value="District of Columbia">District of Columbia</option><option citys="9" value="Delaware">Delaware</option><option citys="10" value="Florida">Florida</option><option citys="11" value="Georgia">Georgia</option><option citys="12" value="Hawaii">Hawaii</option><option citys="13" value="Iowa">Iowa</option><option citys="14" value="Idaho">Idaho</option><option citys="15" value="Illinois">Illinois</option><option citys="16" value="Indiana">Indiana</option><option citys="17" value="Kansas">Kansas</option><option citys="18" value="Kentucky">Kentucky</option><option citys="19" value="Louisiana">Louisiana</option><option citys="20" value="Massachusetts">Massachusetts</option><option citys="21" value="Maryland">Maryland</option><option citys="22" value="Maine">Maine</option><option citys="23" value="Michigan">Michigan</option><option citys="24" value="Minnesota">Minnesota</option><option citys="25" value="Missouri">Missouri</option><option citys="26" value="Mississippi">Mississippi</option><option citys="27" value="Montana">Montana</option><option citys="28" value="North Carolina">North Carolina</option><option citys="29" value="North Dakota">North Dakota</option><option citys="30" value="Nebraska">Nebraska</option><option citys="31" value="New Hampshire">New Hampshire</option><option citys="32" value="New Jersey">New Jersey</option><option citys="33" value="New Mexico">New Mexico</option><option citys="34" value="Nevada">Nevada</option><option citys="35" value="New York">New York</option><option citys="36" value="Ohio">Ohio</option><option citys="37" value="Oklahoma">Oklahoma</option><option citys="38" value="Oregon">Oregon</option><option citys="39" value="Pennsylvania">Pennsylvania</option><option citys="40" value="Rhode Island">Rhode Island</option><option citys="41" value="South Carolina">South Carolina</option><option citys="42" value="South Dakota">South Dakota</option><option citys="43" value="Tennessee">Tennessee</option><option citys="44" value="Texas">Texas</option><option citys="45" value="Utah">Utah</option><option citys="46" value="Virginia">Virginia</option><option citys="47" value="Vermont">Vermont</option><option citys="48" value="Washington">Washington</option><option citys="49" value="Wisconsin">Wisconsin</option><option citys="50" value="West Virginia">West Virginia</option><option citys="51" value="Wyoming">Wyoming</option>
                    </select>
                    <i class="layui-edge"></i>
                </div>
            </div>

        </div>
        <div class="layui-input-inline">
            <input type="text" name="city" lay-verify="required" lay-verType="tips" autocomplete="on" class="layui-input" value="{{$data['city']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 街道</label>
        <div class="layui-input-block">
            <input type="text" id="address" name="address" lay-verify="required" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入寄件人地址" value="{{$data['address']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 邮编</label>
        <div class="layui-input-inline">
            <input type="text" name="code" lay-verify="required|number" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入寄件人邮编" value="{{$data['code']}}">
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

            //提交 Ajax 成功后，关闭当前弹层
            $.ajax({
                type : "POST",
                url : "{{url('user/sender')}}",
                data : data.field,
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

        $("select").on('click',function () {
            if ($(this).parent().parent().hasClass("layui-form-selected")){
                $(this).parent().parent().removeClass("layui-form-selected");
            }else{
                $(this).parent().parent().addClass("layui-form-selected");
            }
        });

        var province = '{{$data['province']}}';
        if (province){
            $("option[value='"+province+"']").attr("selected", true);
        }
    })
</script>
</body>
</html>