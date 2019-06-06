@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>.step,.step img{width: 335px;}.step .title-header{left:10rem;}</style>
    <div id="banner">
        <div class="banner-img">
            <div class="layui-container">
                <div class="banner-content">
                    补充身份证信息及在线缴税
                </div>
            </div>
        </div>
    </div>
    <div class="layui-container">
        <div class="content">
            <div class="content-titleimg">
                <div class="layui-row">
                    <div class="layui-col-md12 text-center">
                    @for($i = 1;$i < 4; $i++)
                    @php
                        $imgType = $nowStep >= $i ? '1' : '0'
                    @endphp
                            <div class="step layui-inline">
                                <div><span class="title-header">{{$i}}</span><img src="{{asset('images/tax'.$imgType.'.png')}}"><span class="title-footer @if($nowStep >= $i) active @endif">{{$titles[$i-1]}}</span></div>
                            </div>
                    @endfor
                    </div>
                </div>
            </div>
            <div class="form">
                @if(isset($type) && $type == 'goidentification' && $nowStep == 2)
                    <style>.content .upload-img,.content .upload-img img,.content .upload-img .file{
                            width: 328px;
                            height: 196px;
                            border: 0px;
                        }
                        .form{width: 90%;}
                    </style>
                    <form class="layui-form" action="{{route('goidentification').'?token='.request('token')}}" id="form1" enctype="multipart/form-data" method="post">
                        {{csrf_field()}}
                        <div class="layui-row">
                            <div class="layui-col-sm12 layui-col-md6 text-center">
                                <div class="upload-img-content">身份证国徽面 *</div>
                                <div class="upload-img" style="background: url({{asset('/images/pho_front.png')}})">
                                    <img id="MainContent_Image1" src="">
                                    <input type="file" name="id_card_front" class="file" atd="1" accept="image/jpg, image/jpeg, image/png, image/gif" onclick="fileOnchange(this,'#MainContent_Image1')" lay-verify="required" lay-vertype="tips">
                                </div>
                            </div>
                            <div class="layui-col-sm12 layui-col-md6 text-center">
                                <div class="upload-img-content">身份证头像面 *</div>
                                <div class="upload-img"  style="background: url({{asset('/images/pho_back.png')}})">
                                    <img id="MainContent_Image2" src="">
                                    <input type="file" name="id_card_back" class="file" atd="2" accept="image/jpg, image/jpeg, image/png, image/gif" onclick="fileOnchange(this,'#MainContent_Image2')">
                                </div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn sub-btn layui-btn-warm">提交</button>
                        </div>
                    </form>
                @elseif(isset($type) && $type == 'gotax' && $nowStep == 2)
                    <style>.layui-form-item .layui-input-inline{text-align: left;line-height: 1.5rem;width: 300px;}</style>
                    <form class="layui-form" action="">
                        <div class="layui-form-item">
                            <label class="layui-form-label">运单号：</label>
                            <div class="layui-input-inline">
                                {{$data['system_order_no']}}
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">税金：</label>
                            <div class="layui-input-inline">
                                {{$data['tax']}}
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">支付方式：</label>
                            <div class="layui-input-inline">
                                <input type="radio" name="vendor" lay-filter="vendor" value="alipay" title="支付宝" checked>
                                <input type="radio" name="vendor" lay-filter="vendor" value="wechatpay" title="微信">
                                <input type="radio" name="vendor" lay-filter="vendor" value="unionpay" title="银联">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <a href="/tax/pay?vendor=alipay&token={{request('token')}}" id="pay" class="layui-btn sub-btn layui-btn-warm">支付</a>
                        </div>
                    </form>
                @elseif($nowStep == 1)
                    <form class="layui-form" action="">
                        {{csrf_field()}}
                        <div class="layui-form-item">
                            <label class="layui-form-label">wedepot物流<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="system_order_no" placeholder="请输入运单号" required  lay-verify="required|checkNo" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">收件人<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="r_name" placeholder="请输入收件人" required  lay-verify="required" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label class="layui-form-label">收件人电话<i>*</i></label>
                            <div class="layui-input-block">
                                <input type="text" name="r_phone" placeholder="请输入收件人电话" required  lay-verify="required|phone" lay-vertype="tips" autocomplete="off" class="layui-input">
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <button class="layui-btn sub-btn layui-btn-warm" lay-submit lay-filter="do">提交</button>
                        </div>
                    </form>
                @else
                    <i class="layui-icon layui-icon-ok" style="font-size: 4rem;color: green;font-weight: bolder;"></i>
                    <span style="font-size: 2rem;color: green;">操作成功</span>
                    <div class="layui-form-item">
                        <a href="/" id="pay" class="layui-btn sub-btn layui-btn-warm">返回首页</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @include('common.footer')

    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        layui.use(['form'], function(){
            var form = layui.form
                ,$ = layui.jquery;

            form.verify({
                checkNo: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(value.length < 21){
                        return '请填写有效的运单号';
                    }
                },
            });

            form.on('submit(do)', function(data){
                $.ajax({
                    type : "POST",
                    url : "{{url()->current().'/do'}}",
                    data : data.field,
                    dataType: 'json',
                    success : function(result) {
                        if (result.status == 200){
                            window.location.href=result.url;
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

            form.on('radio(vendor)', function(data){
                console.log(data.value); //被点击的radio的value值
                $("#pay").attr("href","/tax/pay?vendor="+data.value+"&token={{request('token')}}");
            });
        });

        $(document).ready(function($){
            $('#form1').ajaxForm({
                dataType: 'json',
                success : function(result) {
                    if (result.status == 200){
                        window.location.href='/identification?nowStep=3';
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
        });

        function fileOnchange(pid,def){
            var atd = pid.getAttribute("atd");
            var input = pid;

            var res = document.getElementById("MainContent_Image"+atd);

            if(typeof FileReader==='undefined'){
                res.innerHTML = "抱歉，你的浏览器不支持 FileReader";
                input.setAttribute('disabled','disabled');
            }else{
                input.addEventListener('change',readFile,false);
            }

            //图片文件读取
            function readFile(){
                var file = this.files[0];
                if(file){
                    if(!/image\/\w+/.test(file.type)){
                        layer.msg("文件必须为图片！");
                    }else {
                        if (file.size > 2*1024*1000){
                            layer.msg("请上传小于2M图片");
                        }else {
                            var reader = new FileReader();
                            reader.readAsDataURL(file);
                            reader.onload = function(e){
                                res.src = this.result;  //赋值到src
                                // console.log(res);
                            }
                        }
                    }
                }else{
                    $(def).attr('src','');
                }
                input.removeEventListener('change',readFile,false);
            }
        }

    </script>
@endsection