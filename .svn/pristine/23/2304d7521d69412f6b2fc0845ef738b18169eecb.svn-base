@extends('common.header')

@section('content')

    <link href="{{ asset('css/register.css') }}" rel="stylesheet">
    <style>
        .form{margin: 1rem auto 0 auto;}
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
                <h1>上传您的认证信息</h1>
                <div class="main">
                    根据进出口海关申报要求，请您上传以下证件的扫描件，wedepot仅在进出口报关使用，承诺不会向第三方提供此信息。
                </div>
                <div class="layui-text bottom">
                    单个上传文件最大为2M，支持JPG，PNG，GIF，JPEG
                </div>
            </div>
            <form class="layui-form" action="{{url()->current().'/do'}}" id="form1" enctype="multipart/form-data" method="post">
                {{csrf_field()}}
                <div class="layui-row">
                    <div class="layui-col-sm12 layui-col-md4 text-center">
                        <div class="upload-img-content">上传{{$type == 'personal' ? '身份证/驾照/护照' : '营业执照'}} *</div>
                        <div class="upload-img" style="background: url({{asset('images/upload_pic_1.jpg')}})">
                            <img id="MainContent_Image1" src="">
                            <input type="file" name="sfz" class="file" atd="1" accept="image/jpg, image/jpeg, image/png, image/gif" onclick="fileOnchange(this,'#MainContent_Image1')" lay-verify="required" lay-vertype="tips">
                        </div>
                        <div class="upload-img-content">(*)为必填项</div>
                    </div>
                    <div class="layui-col-sm12 layui-col-md4 text-center">
                        <div class="upload-img-content">上传信用卡或银行账单</div>
                        <div class="upload-img"  style="background: url({{asset('images/upload_pic_2.jpg')}})">
                            <img id="MainContent_Image2" src="">
                            <input type="file" name="xyk" class="file" atd="2" accept="image/jpg, image/jpeg, image/png, image/gif" onclick="fileOnchange(this,'#MainContent_Image2')">
                        </div>
                    </div>
                    <div class="layui-col-sm12 layui-col-md4 text-center">
                        <div class="upload-img-content">上传水/电/煤气账单</div>
                        <div class="upload-img"  style="background: url({{asset('images/upload_pic_3.jpg')}})">
                            <img id="MainContent_Image3" src="">
                            <input type="file" name="sdm" class="file" atd="3" accept="image/jpg, image/jpeg, image/png, image/gif" onclick="fileOnchange(this,'#MainContent_Image3')">
                        </div>
                    </div>
                </div>
                <div class="form">
                    <div class="layui-form-item">
                        <button class="layui-btn sub-btn" id="sub-btn" lay-submit lay-filter="do">下一步</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('common.footer')

    <script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
    <script src="{{asset('js/jquery.form.js')}}"></script>
    <script>
        var layer;
        layui.use(['form'], function(){
            var form = layui.form;

            layer = layui.layer;
        });

        $(document).ready(function($){
            $('#form1').ajaxForm({
                dataType: 'json',
                success : function(result) {
                    if (result.status == 200){
                        window.location.href='{{url('/register/five/'.$type)}}';
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
                }/*,
                beforeSend: function () {
                    $(".sub-btn").addClass("layui-btn-disabled").attr("disabled",true);
                },
                complete: function(){
                    $(".sub-btn").removeClass("layui-btn-disabled").attr("disabled",false);
                }*/
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