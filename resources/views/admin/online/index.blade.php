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
        h4{font-size: 1.2rem;font-weight: 700;margin-bottom: 2rem;}
        .layui-card-header{font-size: 1.5rem;text-indent: 1rem;}
        .layui-card .content{margin-left: 2rem;}
        .ordtop {margin-top: 2rem;}
        .ordtop .ordsender {  position: relative;  }
        .ordtop .ordsender {  float: left;  width: 500px;  border: 1px solid #ccc;  padding: 30px 25px;  margin-right: 55px;  height: 610px;  padding-top: 10px;  }
        .ordtop .layui-form-label{font-weight: bold;}
        .ordtop .city-inline{width: 185px;}
        .ordtop .cre_num{margin-left: 10px; width: 270px;margin-right: 0;}
        .ordtop textarea{height: 120px;}
        .ordtop .area-text{font-size: 0.9rem;margin: 1rem 0;}
        .ordtop .contact{font-size: 1rem; color: #1E9FFF;cursor: pointer;}
        .ordtop .name{width: 300px;}
        #mimenu{color: grey;  font-size: 17px;  text-align: left;  margin: 1rem 0;  padding-left: 1.8rem;}
        .depot_select .content{max-width: 80%;}
        .depot_select .on{max-height: 2rem;  overflow: hidden;}
        #depot_more{line-height: 2.5rem;color: #177ce3;font-size: 1rem;}
    </style>
</head>

<body>
<form class="layui-form" lay-filter="form">
    {{csrf_field()}}
<div class="layui-content">
    <div class="layui-fluid">
        <div class="layui-card">
            <div class="layui-card-header">仓库选择</div>
            <div class="layui-card-body">
                <div class="layui-form-item layui-row depot_select">
                    <div class="layui-col-md12 content on">
                        @foreach($data['depot'] as $val)
                        <input type="radio" name="depot" value="{{$val['name']}}" title="{{$val['name']}}">
                        @endforeach
                    </div>
                    @if(count($data['depot']) >= 8)<a href="#" id="depot_more">更多</a>@endif
                </div>
            </div>
        </div>
        <div class="layui-card">
            <div class="layui-card-header">邮寄线路选择</div>
            <div class="layui-card-body">
                <div class="layui-form-item layui-row">
                    <div class="layui-col-md12 content">
                        @foreach($data['lineData'] as $val)
                            <input type="radio" name="line_id" value="{{$val['id']}}" title="{{$val['name']}}" lay-filter="mimenu" iupid="{{$val['iupid']}}" excel="{{$val['onlineExcel']}}">
                        @endforeach
                    </div>
                </div>
                <ul style="display:none;">
                    @foreach($data['lineData'] as $val)
                        <li class="m{{$val['id']}}">@php echo htmlspecialchars_decode($val['content']); @endphp</li>
                    @endforeach
                </ul>
                <div class="layui-row">
                    <div class="layui-col-md12 content" id="mimenu"></div>
                </div>
            </div>
        </div>
        <div class="layui-card">
            <div class="layui-card-header">寄/收件人信息</div>
            <div class="layui-card-body">
                <div class="layui-row">
                    <div class="layui-col-xs12 layui-col-md12 layui-col-lg5 content ordtop">
                        <div class="ordsender">
                            <h4>寄件人信息</h4>
                            <div class="layui-form-item">
                                <label class="layui-form-label">姓名：</label>
                                <div class="layui-input-inline name">
                                    <input type="text" name="s_name" required  lay-verify="required" placeholder="请输入寄件人姓名" autocomplete="on" class="layui-input" id="postname">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><i class="layui-icon layui-icon-link contact" data-action="sender">通信簿</i></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">手机号码：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="s_phone" required  lay-verify="required" placeholder="请输入寄件人手机号码" autocomplete="on" class="layui-input" id="postphone">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">邮编：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="s_code" required  lay-verify="required" placeholder="请输入寄件人邮编" autocomplete="on" class="layui-input" id="postcode">
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">街道地址：</label>
                                <div class="layui-input-block">
                                    <textarea name="s_address" placeholder="请如实填写详细寄件人地址，例如街道名称、门牌号码、楼层和房间号等信息" class="layui-textarea" lay-verify="required" id="poststreet"></textarea>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">所在区域：</label>
                                <div class="layui-input-inline city-inline">
                                    <select name="s_country" id="postcountry" class="layui-disabled" disabled="disabled">
                                        <option value="U.S.A">U.S.A</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"></label>
                                <div class="layui-input-inline city-inline">
                                    <select name="s_province" lay-verify="required" lay-verType="tips" id="postprovince">
                                        <option value="">请选择</option>
                                        <option citys="1" value="Alaska">Alaska</option><option citys="2" value="Alabama">Alabama</option><option citys="3" value="Arkansas">Arkansas</option><option citys="4" value="Arizona">Arizona</option><option citys="5" value="California">California</option><option citys="6" value="Colorado">Colorado</option><option citys="7" value="Connecticut">Connecticut</option><option citys="8" value="District of Columbia">District of Columbia</option><option citys="9" value="Delaware">Delaware</option><option citys="10" value="Florida">Florida</option><option citys="11" value="Georgia">Georgia</option><option citys="12" value="Hawaii">Hawaii</option><option citys="13" value="Iowa">Iowa</option><option citys="14" value="Idaho">Idaho</option><option citys="15" value="Illinois">Illinois</option><option citys="16" value="Indiana">Indiana</option><option citys="17" value="Kansas">Kansas</option><option citys="18" value="Kentucky">Kentucky</option><option citys="19" value="Louisiana">Louisiana</option><option citys="20" value="Massachusetts">Massachusetts</option><option citys="21" value="Maryland">Maryland</option><option citys="22" value="Maine">Maine</option><option citys="23" value="Michigan">Michigan</option><option citys="24" value="Minnesota">Minnesota</option><option citys="25" value="Missouri">Missouri</option><option citys="26" value="Mississippi">Mississippi</option><option citys="27" value="Montana">Montana</option><option citys="28" value="North Carolina">North Carolina</option><option citys="29" value="North Dakota">North Dakota</option><option citys="30" value="Nebraska">Nebraska</option><option citys="31" value="New Hampshire">New Hampshire</option><option citys="32" value="New Jersey">New Jersey</option><option citys="33" value="New Mexico">New Mexico</option><option citys="34" value="Nevada">Nevada</option><option citys="35" value="New York">New York</option><option citys="36" value="Ohio">Ohio</option><option citys="37" value="Oklahoma">Oklahoma</option><option citys="38" value="Oregon">Oregon</option><option citys="39" value="Pennsylvania">Pennsylvania</option><option citys="40" value="Rhode Island">Rhode Island</option><option citys="41" value="South Carolina">South Carolina</option><option citys="42" value="South Dakota">South Dakota</option><option citys="43" value="Tennessee">Tennessee</option><option citys="44" value="Texas">Texas</option><option citys="45" value="Utah">Utah</option><option citys="46" value="Virginia">Virginia</option><option citys="47" value="Vermont">Vermont</option><option citys="48" value="Washington">Washington</option><option citys="49" value="Wisconsin">Wisconsin</option><option citys="50" value="West Virginia">West Virginia</option><option citys="51" value="Wyoming">Wyoming</option>
                                    </select>
                                </div>
                                <div class="layui-input-inline city-inline">
                                    <input type="text" name="s_city" lay-verify="required" lay-verType="tips" autocomplete="on" class="layui-input" value="" placeholder="请填写城市" id="postcity">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label"></label>
                                <div class="layui-input-block">
                                    <a class="layui-btn layui-btn-radius layui-btn-primary layui-bg-black" id="clearSender">清空寄件人信息</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-col-xs12 layui-col-md12 layui-col-lg5 content ordtop">
                        <div class="ordsender">
                            <h4>收件人信息</h4>
                            <div class="layui-form-item">
                                <label class="layui-form-label">姓名：</label>
                                <div class="layui-input-inline name">
                                    <input type="text" name="r_name" required  lay-verify="chinese" placeholder="收件人姓名必须与身份证号保持一致" autocomplete="on" class="layui-input" id="fullName">
                                </div>
                                <div class="layui-form-mid layui-word-aux"><i class="layui-icon layui-icon-link contact" data-action="receiver">通信簿</i></div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">手机号码：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="r_phone" required  lay-verify="required|phone" placeholder="请输入收件人电话" autocomplete="on" class="layui-input" id="phone">
                                </div>
                            </div>
                            <div class="layui-form-item" id="id_card">
                                <label class="layui-form-label">证件号码：</label>
                                <div class="layui-input-inline" style="width: 100px;">
                                    <select name="r_cre_type" id="Id_tpye">
                                        <option value="1">身份证</option>
                                    </select>
                                </div>
                                <div class="layui-input-inline cre_num">
                                    <input type="text" name="r_cre_num" lay-verify="required" lay-verType="tips" autocomplete="on" class="layui-input" value="" placeholder="请填写收件人身份证号码" id="cre_num">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">邮编：</label>
                                <div class="layui-input-block">
                                    <input type="text" name="r_code" required  lay-verify="required" placeholder="请输入收件人邮编" autocomplete="on" class="layui-input" id="zipcode">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">所在区域：</label>
                                <div class="layui-input-block">
                                    <div id="re_area" style="display: inline-block;">
                                        <div class="block">
                                            <el-cascader clearable v-model="selectedOptions" placeholder="搜索：省份/地级市/市、县、区" :options="options" filterable @change="handleChange"></el-cascader>
                                        </div>
                                        <div class="layui-text area-text">
                                            *若没有所住的区/镇/县，请选择邻近的区/镇/县，并填写正确的详细地址
                                        </div>
                                    </div>
                                    <input id="province" name="r_province" value="" style="display: none"/>
                                    <input id="city" name="r_city" value="" style="display: none" />
                                    <input id="town" name="r_town" value="" style="display: none" />
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label class="layui-form-label">详细地址：</label>
                                <div class="layui-input-block">
                                    <textarea name="r_addressDetail" placeholder="请如实填写详细寄件人地址，例如街道名称、门牌号码、楼层和房间号等信息" class="layui-textarea" lay-verify="required" id="detaileaddress"></textarea>
                                </div>
                            </div>
                            {{--<div class="layui-form-item">
                                <label class="layui-form-label"></label>
                                <div class="layui-input-block">
                                    <a class="layui-btn layui-btn-radius layui-btn-primary layui-bg-black">智能地址提交</a>
                                </div>
                            </div>--}}
                            <div class="layui-form-item">
                                <label class="layui-form-label"></label>
                                <div class="layui-input-block">
                                    <input type="radio" name="bookin" value="1" title="保存到地址薄">
                                    <input type="hidden" name="r_id" value="" id="hidaddr_id">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="part2">

        </div>
    </div>
</div>
</form>

<script src="{{asset('js/layui.js')}}"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'table', 'form'], function(){
        var table = layui.table
            ,form = layui.form;

        form.verify({
            chinese: function(value){ //value：表单的值、item：表单的DOM对象
                var re = /^[\u4E00-\u9FA5·]{1,10}$/;
                if(!re.test(value)) {
                    return '请输入1-10个中文字符';
                }
            },
        });

        $(".contact").on("click",function () {
            var action = $(this).data("action");
            layer.open({
                type: 2,
                title: "寄/收件人信息",
                content: '/user/'+action+'/0',
                maxmin: !0,
                area: ['800px', '600px'],
                btn: [],
                yes: function(e, i) {
                    var l = window["layui-layer-iframe" + e],
                            a = i.find("iframe").contents().find("#layuiadmin-app-form-edit");
                    l.layui.form.on("submit(layuiadmin-app-form-edit)", function(i) {
                        var l = i.field;

                        layer.close(e)
                    }), a.trigger("click");
                }
            });
        });

        form.on('radio(mimenu)', function(data){
            changeline(data.elem,'');
        });

        $("#depot_more").on('click',function () {
            var isOn = $(".depot_select").children().hasClass("on");
            if (isOn){
                $(".depot_select").children().removeClass("on");
            }else {
                $(".depot_select").children().addClass("on");
            }
        });

        $("#clearSender").on('click', function () {
            form.val("form", {
                "s_name": "",
                "s_phone": "",
                "s_code": "",
                "s_address": "",
                "s_province": "",
                "s_city": ""
            })
        });

        //监听提交
        form.on('submit(layuiadmin-app-form-submit)', function(data){
            var field = data.field; //获取提交的字段
            var formData = getFormData(field);
            $.ajax({
                type : "POST",
                url : "{{url('user/online/store')}}",
                data: formData,
                contentType: false,
                processData: false,
                cache: false,
                dataType: 'json',
                success : function(result) {
                    if (result.status == 200){
                        layer.alert(result.msg, function(index){
                            layer.close(index);
                            //location.reload();
                            location.href = '/user/online';
                            //window.parent.document.getElementById("faterListOrder").click();
                        });
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
    });
</script>
<script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/Vue.js')}}"></script>
<link rel="stylesheet" href="{{asset('js/vue/index.css')}}">
<script src="{{asset('js/vue/index.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/search_area.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/area.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/location.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/select2.js')}}"></script>
<script type="text/javascript" src="{{asset('js/vue/select2_locale_zh-CN.js')}}"></script>
<script src="{{asset('js/vue/cityselectedtwo.js')}}"></script>
<script src="{{asset('js/vue/element_cascader.js')}}"></script>
<script src="{{asset('js/vue/orderindex.js')}}"></script>
<script>
    var Placeholder_IdNo = "身份证号必须与收件人姓名保持一致";
    window.re_area = search_area;
    window.w_id = "{{$data['line_id']}}";
    var ShowSelectlng = "说明";
    var consoleurl = "{{url('user/online/template')}}";
    var showProducturl = "{{url('user/online/show')}}";
    // 获取货品声明货品分类数据
    window.category_list = @php echo htmlspecialchars_decode($data['lineProduct']); @endphp;

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
    });

    function getFormData(original){
        var formData = new FormData();
        $.each(original,function (key, val) {
            if (key != 'id_card_front' && key != 'id_card_back'){
                formData.append(key,val);
            }
        });
        if ($("input[name='line_id']:checked").attr('iupid') == 1){
            formData.append('id_card_front',$("#front")[0].files[0]);
            formData.append('id_card_back',$("#back")[0].files[0]);
        }
        return formData;
    }
    @if ($data['senderDefault'])
    var senderjson = @json(['data'=>$data['senderDefault']]);
    senderAjax({{$data['senderDefault']->id}},senderjson);
    @endif
    @if ($data['receiverDefault'])
    var receiverjson = @json(['status'=>200,'data'=>$data['receiverDefault']]);
    get_addrinfo({{$data['receiverDefault']->id}},receiverjson);
    @endif
</script>
</body>
</html>