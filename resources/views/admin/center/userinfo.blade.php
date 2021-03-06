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
        .layui-input-inline{text-align: left;}
        .text-align-center{text-align: center;}
    </style>

    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">{{$type == 'personal' ? '个人' : '企业'}}用户</div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="content">
            @if($type == 'personal')
                <form class="layui-form" action="">
                    <div class="layui-card">
                        <div class="layui-card-header">发件人信息</div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">姓<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_xing']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">名<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_ming']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">国家：</label>
                                    <div class="layui-input-inline">
                                        美国/U.S
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">州<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_city']}}
                                    </div>
                                    <label class="layui-form-label">市<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_area']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">证件信息<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_paperType']}}
                                    </div>
                                    <label class="layui-form-label"></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_paperNo']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">发件国退件地址(方便退件)<i>：</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        {{$userinfo['sender_quitAddress']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退件邮编<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_quitCode']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_phone']}}
                                    </div>
                                    <label class="layui-form-label">固话：</label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['sender_fixedPhone']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="layui-card">
                        <div class="layui-card-header">收件人信息</div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">所在国家<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_country']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">姓名<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_name']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">详细地址<i>：</i></label>
                                    <div class="layui-input-inline xxdz-inline">
                                        {{$userinfo['receive_address']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">邮编<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_code']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_phone']}}
                                    </div>
                                    <label class="layui-form-label">固话：</label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_fixedPhone']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">QQ/微信：</label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['receive_wq']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <form class="layui-form" action="">
                    <div class="layui-card">
                        <div class="layui-card-header">发件人信息<div class="layui-text layui-inline">（请以您公司证件上的语言填写）</div></div>
                        <div class="layui-card-body">
                            <div class="form">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">国家：</label>
                                    <div class="layui-input-inline">美国/U.S</div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">州<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_city']}}
                                    </div>
                                    <label class="layui-form-label">市<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_area']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">公司名称<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_name']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">公司注册地址<i>：</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        {{$userinfo['company_address']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">公司代表人<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_delegate']}}
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
                                    <label class="layui-form-label">营业执照编号<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_yy']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label">税号（EIN No.）<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_sh']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label tj-label" style="width: 300px;margin-left: -211px;">发件因退件地址（方便邮件账单及推荐送达服务）<i>：</i></label>
                                    <div class="layui-input-inline tj-inline">
                                        {{$userinfo['company_quitAddress']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">退件邮编<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_quitCode']}}
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
                                    <label class="layui-form-label">联系人<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_contact']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">手机<i>：</i></label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_phone']}}
                                    </div>
                                    <label class="layui-form-label">固话：</label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_fixedPhone']}}
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label class="layui-form-label">QQ/微信：</label>
                                    <div class="layui-input-inline">
                                        {{$userinfo['company_wq']}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @endif

                <div class="layui-card">
                    <div class="layui-card-header">认证信息</div>
                    <div class="layui-card-body">
                        <div class="layui-row layui-col-space20">
                            <div class="layui-col-xs12 layui-col-md4 text-align-center"><img src="{{$userinfo['sfz'] ? '/uploads/'.$userinfo['sfz'] : asset('images/upload_pic_1.jpg')}}" width="250"></div>
                            <div class="layui-col-xs12 layui-col-md4 text-align-center"><img src="{{$userinfo['xyk'] ? '/uploads/'.$userinfo['xyk'] : asset('images/upload_pic_2.jpg')}}" width="250"></div>
                            <div class="layui-col-xs12 layui-col-md4 text-align-center"><img src="{{$userinfo['sdm'] ? '/uploads/'.$userinfo['sdm'] : asset('images/upload_pic_3.jpg')}}" width="250"></div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
    @include('common.footer')

    <script>
        layui.use(['form','element'], function(){
            var form = layui.form
                    ,element = layui.element
                    ,$ = layui.jquery;
        });
    </script>
@endsection