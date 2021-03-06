@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>
        .layui-card{box-shadow: 0 0 0 0 ;font-size: 1rem;color: black;margin: 0 auto;}
        .layui-form {margin-top: 1rem;}
        .layui-form-select .layui-edge{right: 15px;}
        .layui-form-select dl{top: 39px;min-width: 94.5%;}
        .layui-card-header{font-size: 1.2rem;font-weight: bolder;}
        .form{margin: 1rem auto 0 auto !important;width: 60%;}
        .form .tj-label{width: 165px;margin-left: -76px;}
        .form .tj-input{width: 92%}
        .form .tj-inline{width: 82%;margin-right: 0;}
        .form .xxdz-inline{width: 81.8%;margin-right: 0;}
        .titlecontent .bottom{margin: 1rem 0;}
    </style>

    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">{{$type == 'personal' ? '个人' : '企业'}}注册<br>欢迎您注册wedepot国际物流{{$type == 'personal' ? '个人' : '企业'}}用户</div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="content">
            <div class="content-titleimg">
                @for($i = 1;$i < 7; $i++)
                    @php
                        $imgType = $nowStep >= $i ? '1' : '0'
                    @endphp
                    <div class="step layui-inline">
                        <div><span class="title-header">{{$i}}</span><img src="{{asset('images/register-tip'.$imgType.'.png')}}"><span class="title-footer @if($nowStep >= $i) active @endif">{{$titles[$i-1]}}</span></div>
                    </div>
                @endfor
            </div>
            <div class="titlecontent">
                <h1>您的邮箱已经通过验证，为了更好地为您提供服务，请进一步完善信息</h1>
                <div class="layui-text bottom">
                    若您在填写的过程中有任何疑问，请联系我们的在线客服。
                </div>
            </div>
            @if($type == 'personal')
            <form class="layui-form" action="">
                {{csrf_field()}}
                <div class="layui-card">
                    <div class="layui-card-header">发件人信息</div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">姓<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_xing" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">名<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_ming" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">国家：</label>
                                    <div class="layui-input-inline text-left">
                                        美国/U.S
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">州<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <select name="sender_city" lay-verify="required" lay-vertype="tips">
                                            <option value=""></option>
                                            <option citys="1" value="Alaska">Alaska</option><option citys="2" value="Alabama">Alabama</option><option citys="3" value="Arkansas">Arkansas</option><option citys="4" value="Arizona">Arizona</option><option citys="5" value="California">California</option><option citys="6" value="Colorado">Colorado</option><option citys="7" value="Connecticut">Connecticut</option><option citys="8" value="District of Columbia">District of Columbia</option><option citys="9" value="Delaware">Delaware</option><option citys="10" value="Florida">Florida</option><option citys="11" value="Georgia">Georgia</option><option citys="12" value="Hawaii">Hawaii</option><option citys="13" value="Iowa">Iowa</option><option citys="14" value="Idaho">Idaho</option><option citys="15" value="Illinois">Illinois</option><option citys="16" value="Indiana">Indiana</option><option citys="17" value="Kansas">Kansas</option><option citys="18" value="Kentucky">Kentucky</option><option citys="19" value="Louisiana">Louisiana</option><option citys="20" value="Massachusetts">Massachusetts</option><option citys="21" value="Maryland">Maryland</option><option citys="22" value="Maine">Maine</option><option citys="23" value="Michigan">Michigan</option><option citys="24" value="Minnesota">Minnesota</option><option citys="25" value="Missouri">Missouri</option><option citys="26" value="Mississippi">Mississippi</option><option citys="27" value="Montana">Montana</option><option citys="28" value="North Carolina">North Carolina</option><option citys="29" value="North Dakota">North Dakota</option><option citys="30" value="Nebraska">Nebraska</option><option citys="31" value="New Hampshire">New Hampshire</option><option citys="32" value="New Jersey">New Jersey</option><option citys="33" value="New Mexico">New Mexico</option><option citys="34" value="Nevada">Nevada</option><option citys="35" value="New York">New York</option><option citys="36" value="Ohio">Ohio</option><option citys="37" value="Oklahoma">Oklahoma</option><option citys="38" value="Oregon">Oregon</option><option citys="39" value="Pennsylvania">Pennsylvania</option><option citys="40" value="Rhode Island">Rhode Island</option><option citys="41" value="South Carolina">South Carolina</option><option citys="42" value="South Dakota">South Dakota</option><option citys="43" value="Tennessee">Tennessee</option><option citys="44" value="Texas">Texas</option><option citys="45" value="Utah">Utah</option><option citys="46" value="Virginia">Virginia</option><option citys="47" value="Vermont">Vermont</option><option citys="48" value="Washington">Washington</option><option citys="49" value="Wisconsin">Wisconsin</option><option citys="50" value="West Virginia">West Virginia</option><option citys="51" value="Wyoming">Wyoming</option>
                                        </select>
                                    </div>
                                    <label class="layui-form-label">市<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_area" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">证件信息<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <select name="sender_paperType" lay-verify="required" lay-vertype="tips">
                                            <option value="">请选择证件类型</option>
                                            <option value="驾照">驾照</option>
                                            <option value="护照">护照</option>
                                        </select>
                                    </div>
                                    <label class="layui-form-label"></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_paperNo" required  lay-verify="required" lay-vertype="tips" placeholder="证件号" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">发件国退件地址(方便退件)<i>*</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        <input type="text" name="sender_quitAddress" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input tj-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退件邮编<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_quitCode" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_phone" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">固话</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="sender_fixedPhone" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="layui-card">
                    <div class="layui-card-header">联系人信息</div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">所在国家<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <select name="receive_country" lay-verify="required" lay-vertype="tips">
                                            <option value=""></option>
                                            <option value="中国">中国</option>
                                            <option value="美国">美国/U.S</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">姓名<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="receive_name" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">详细地址<i>*</i></label>
                                    <div class="layui-input-inline xxdz-inline">
                                        <input type="text" name="receive_address" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input tj-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">邮编<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="receive_code" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="receive_phone" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">固话</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="receive_fixedPhone" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">QQ/微信</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="receive_wq" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn sub-btn" lay-submit lay-filter="do">下一步</button>
                                </div>
                            </div>
                        </div>
                </div>
            </form>
            @else
                <form class="layui-form" action="">
                    {{csrf_field()}}
                    <div class="layui-card">
                        <div class="layui-card-header">发件人信息<div class="layui-text layui-inline">（请以您公司证件上的语言填写）</div></div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">国家：</label>
                                    <div class="layui-input-inline"></div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">州<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <select name="company_city" lay-verify="required" lay-vertype="tips">
                                            <option value=""></option>
                                            <option citys="1" value="Alaska">Alaska</option><option citys="2" value="Alabama">Alabama</option><option citys="3" value="Arkansas">Arkansas</option><option citys="4" value="Arizona">Arizona</option><option citys="5" value="California">California</option><option citys="6" value="Colorado">Colorado</option><option citys="7" value="Connecticut">Connecticut</option><option citys="8" value="District of Columbia">District of Columbia</option><option citys="9" value="Delaware">Delaware</option><option citys="10" value="Florida">Florida</option><option citys="11" value="Georgia">Georgia</option><option citys="12" value="Hawaii">Hawaii</option><option citys="13" value="Iowa">Iowa</option><option citys="14" value="Idaho">Idaho</option><option citys="15" value="Illinois">Illinois</option><option citys="16" value="Indiana">Indiana</option><option citys="17" value="Kansas">Kansas</option><option citys="18" value="Kentucky">Kentucky</option><option citys="19" value="Louisiana">Louisiana</option><option citys="20" value="Massachusetts">Massachusetts</option><option citys="21" value="Maryland">Maryland</option><option citys="22" value="Maine">Maine</option><option citys="23" value="Michigan">Michigan</option><option citys="24" value="Minnesota">Minnesota</option><option citys="25" value="Missouri">Missouri</option><option citys="26" value="Mississippi">Mississippi</option><option citys="27" value="Montana">Montana</option><option citys="28" value="North Carolina">North Carolina</option><option citys="29" value="North Dakota">North Dakota</option><option citys="30" value="Nebraska">Nebraska</option><option citys="31" value="New Hampshire">New Hampshire</option><option citys="32" value="New Jersey">New Jersey</option><option citys="33" value="New Mexico">New Mexico</option><option citys="34" value="Nevada">Nevada</option><option citys="35" value="New York">New York</option><option citys="36" value="Ohio">Ohio</option><option citys="37" value="Oklahoma">Oklahoma</option><option citys="38" value="Oregon">Oregon</option><option citys="39" value="Pennsylvania">Pennsylvania</option><option citys="40" value="Rhode Island">Rhode Island</option><option citys="41" value="South Carolina">South Carolina</option><option citys="42" value="South Dakota">South Dakota</option><option citys="43" value="Tennessee">Tennessee</option><option citys="44" value="Texas">Texas</option><option citys="45" value="Utah">Utah</option><option citys="46" value="Virginia">Virginia</option><option citys="47" value="Vermont">Vermont</option><option citys="48" value="Washington">Washington</option><option citys="49" value="Wisconsin">Wisconsin</option><option citys="50" value="West Virginia">West Virginia</option><option citys="51" value="Wyoming">Wyoming</option>
                                        </select>
                                    </div>
                                    <label class="layui-form-label">市<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_area" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">公司名称<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_name" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">公司注册地址<i>*</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        <input type="text" name="company_address" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input tj-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">公司代表人<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_delegate" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-card">
                        <div class="layui-card-header" style="height: 0px;"></div>
                        <div class="layui-card-body">
                            <div class="layui-text" style="margin-bottom: 2rem;">为了您的包裹能够合法、快捷的完成进出境海关申报，请进一步完善以下内容。</div>
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">营业执照编号<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_yy" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">税号（EIN No.）<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_sh" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label" style="width: 300px;margin-left: -211px;">发件因退件地址（方便邮件账单及推荐送达服务）<i>*</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        <input type="text" name="company_quitAddress" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input tj-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退件邮编<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_quitCode" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-card">
                        <div class="layui-card-header">业务联系人信息</div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">联系人<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_contact" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>*</i></label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_phone" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                    <label class="layui-form-label">固话</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_fixedPhone" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">QQ/微信</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="company_wq" lay-vertype="tips" autocomplete="off" class="layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <button class="layui-btn sub-btn" lay-submit lay-filter="do">下一步</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
    @include('common.footer')

    <script>
        layui.use(['form','element'], function(){
            var form = layui.form
                ,element = layui.element
                ,$ = layui.jquery;

//            layer.alert('请您进一步完善个人信息，以便我们更好的为您提供服务。',{title:'您已完成邮箱验证',btn:['好的']});

            form.on('submit(do)', function(data){
                $.ajax({
                    type : "POST",
                    url : "{{url()->current().'/do'}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            window.location.href='{{url('/register/four/'.$type)}}';
                        } else {
                            layer.alert(result.msg);
                        }
                    },
                    error: function (error) {
                        var errors = JSON.parse(error.responseText).errors;
                        $.each(errors, function (key, value) {
                            layer.msg(value[0]);
                            return false;
                        });
                    },
                    beforeSend: function () {
                        $(".sub-btn").addClass("layui-btn-disabled").attr("disabled",true);
                    },
                    complete: function(){
                        $(".sub-btn").removeClass("layui-btn-disabled").attr("disabled",false);
                    }
                });
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });
        });
    </script>
@endsection