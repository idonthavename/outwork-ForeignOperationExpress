<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layuiAdmin 文章管理 iframe 框</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="{{asset('css/layui.css')}}" media="all">
    <style>
        .layui-form-label{width: 105px;}
        #addressDetail{width:590px;}
        .layui-input, .layui-textarea {width: 250px;}
        select{  border: none;  outline: none;  width: 100%;  height: 40px;  line-height: 40px;  appearance: none;  -webkit-appearance: none;  -moz-appearance: none;  padding-left: 10px;  border-width: 1px;  border-style: solid;  background-color: #fff;  border-radius: 2px;  border-color: #e6e6e6;  cursor: pointer;  }  select:hover{  border-color: #D2D2D2 !important;  }
        .obconts {  width: 360px;  position: relative;  margin-top: 26px;  height: 200px;  border: 2px dotted #000;  border-radius: 15px;  margin-left: 20px;  float: left;  }
        .obconts p {  font-size: 18px;  font-weight: 700;  color: #000;  padding-left: 15px;  padding-top: 5px;  margin: 0 0 15px;  }
        .obconts input[class=uploadfile] {  width: 106px;  height: 41px;  position: relative;  z-index: 9;  opacity: 0;  top: -37px;  margin-left: 270px;  left: -13px;  }
        .obconts label {  position: absolute;  background: #232323;  display: inline-block;  color: #ffde00;  width: 90px;  height: 41px;  line-height: 45px;  text-align: center;  top: 123px;  left: 256px;  border-radius: 5px;  }
        input[type=file] {  display: block;  }
    </style>
</head>
<body>

<div class="layui-form" lay-filter="layuiadmin-app-form-list" id="layuiadmin-app-form-list" style="padding: 20px 0 0 0;">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{$data['id']}}">
    <div class="layui-form-item">
        <label class="layui-form-label">* 姓名</label>
        <div class="layui-input-inline">
            <input type="text" name="name" lay-verify="chinese" lay-verType="tips" class="layui-input" autocomplete="on" placeholder="收件人姓名必须与身份证号保持一致" value="{{$data['name']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 手机号码</label>
        <div class="layui-input-inline">
            <input type="text" name="phone" lay-verify="required|phone" lay-verType="tips" autocomplete="on"class="layui-input" placeholder="请输入收件人电话" value="{{$data['phone']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 证件类型</label>
        <div class="layui-input-inline">
            <div class="layui-unselect layui-form-select">
                <div class="layui-select-title">
                    <select name="cre_type" lay-verify="required" lay-ignore lay-verType="tips">
                        <option value="1">身份证</option>
                    </select>
                    <i class="layui-edge"></i>
                </div>
            </div>
        </div>
        <div class="layui-input-inline">
            <input type="text" name="cre_num" lay-verify="required|sfz" lay-verType="tips" autocomplete="on" class="layui-input" value="{{$data['cre_num']}}" placeholder="身份证号必须与收件人姓名保持一致">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 地址</label>
        <div class="layui-input-block">
            <div id="re_area" style="display: inline-block;">
                <div class="block">
                    <el-cascader clearable v-model="selectedOptions" placeholder="搜索：省份/地级市/市、县、区" :options="options" filterable @change="handleChange"></el-cascader>
                    <input id="province" name="province" value="{{$data['province']}}" style="display: none"/>
                    <input id="city" name="city" value="{{$data['city']}}" style="display: none"/>
                    <input id="town" name="town" value="{{$data['town']}}" style="display: none"/>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 详细地址</label>
        <div class="layui-input-block">
            <input type="text" id="addressDetail" name="addressDetail" lay-verify="required" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入收件人地址" value="{{$data['addressDetail']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">* 邮编</label>
        <div class="layui-input-inline">
            <input type="text" name="code" lay-verify="required|number" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入收件人邮编" value="{{$data['code']}}">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label"> 标签<br>(可不填)</label>
        <div class="layui-input-inline">
            <input type="text" name="tag" lay-verType="tips" autocomplete="on" class="layui-input" placeholder="请输入收件人标识" value="{{$data['tag']}}">
        </div>
    </div>
    <!--
    <div class="layui-form-item">
        <label class="layui-form-label"> 默认线路<br>(可不选)</label>
        <div class="layui-input-inline">
            <div class="layui-unselect layui-form-select">
                <div class="layui-select-title">
                    <select name="line_id" lay-ignore lay-verType="tips">
                        @foreach($line as $key=>$val)
                            <option value="{{$key}}" {{$data['line_id'] == $key ? 'selected' : ''}}>{{$val}}</option>
                        @endforeach
                    </select>
                    <i class="layui-edge"></i>
                </div>
            </div>
        </div>
    </div>
    -->
    <div class="layui-form-item">
        <div class="obconts">
            <p>身份证国徽面</p>
            <img src="{{$data['id_card_front'] ? '/uploads/'.$data['id_card_front'] : '/images/pho_front.png'}}" id="fileimage2" style="width: 230px;height: 120px;margin-left: 15px;">
            <input type="file" name="id_card_front" class="uploadfile" id="front" accept="image/jpeg,image/jpg,image/png" atd="2" onclick="fileOnchange(this)">
            <label>上传图片</label>
        </div>
        <div class="obconts">
            <p>身份证头像面</p>
            <img src="{{$data['id_card_back'] ? '/uploads/'.$data['id_card_back'] : '/images/pho_back.png'}}" id="fileimage1" style="width: 230px;height: 120px;margin-left: 15px;">
            <input type="file" name="id_card_back" class="uploadfile" id="back" accept="image/jpeg,image/jpg,image/png" atd="1" onclick="fileOnchange(this)">
            <label>上传图片</label>
        </div>
    </div>
    <div style="clear:both;"></div>
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

        form.verify({
            chinese: function(value){ //value：表单的值、item：表单的DOM对象
                var re = /^[\u4E00-\u9FA5·]{1,10}$/;
                if(!re.test(value)) {
                    return '请输入1-10个中文字符';
                }
            },
            sfz: function (value) {
                var re = /^[1-9]\d{5}[1-9]\d{3}(((0[13578]|1[02])(0[1-9]|[12]\d|3[0-1]))|((0[469]|11)(0[1-9]|[12]\d|30))|(02(0[1-9]|[12]\d)))(\d{4}|\d{3}[xX])$/;
                if(!re.test(value)) {
                    return '无效的身份证号码';
                }
            }
        });

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            var index = parent.layer.getFrameIndex(window.name); //先得到当前iframe层的索引
            var formData = getFormData(field);
            $.ajax({
                type : "POST",
                url : "{{url('user/receiver')}}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                success : function(result) {
                    if (result.status == 200){
                        parent.layui.table.reload('list-index'); //重载表格
                        parent.layer.close(index); //再执行关闭
                    }else{
                        layer.msg(result.msg);
                    }
                },
                error: function (error) {
                    var errors = $.parseJSON(error.responseText).errors;
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
            if (key != 'id_card_front' && key != 'id_card_back'){
                formData.append(key,val);
            }
        });
        formData.append('id_card_front',$("#front")[0].files[0]);
        formData.append('id_card_back',$("#back")[0].files[0]);
        return formData;
    }
</script>
<script type="text/javascript" src="{{asset('js/vue/Vue.js')}}"></script>
<link rel="stylesheet" href="{{asset('js/vue/index.css')}}">
<script src="{{asset('js/vue/index.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/search_area.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/area.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/location.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/select2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/select2_locale_zh-CN.js')}}"></script>
<script src="{{asset('js/vue/cityselectedtwo.js')}}"></script>
<script>
$(document).ready(function() {
    // 生成地址
    var Main = {
        data: function data() {
            return search_area;
        },

        methods: {
            handleChange: function handleChange(val) {
                var pro_val = String(val[0]);
                var cit_val = String(val[1]);
                var tow_val = String(val[2]);

                $('#province').val(pro_val);
                $('#city').val(cit_val);
                $('#town').val(tow_val);
            }
        }
    };
    var Ctor = Vue.extend(Main);
    new Ctor().$mount('#re_area');
    var p = "{{$data['province']}}";
    var c = "{{$data['city']}}";
    var t = "{{$data['town']}}";
    search_area.selectedOptions = [p,c,t];
});
</script>
</body>
</html>