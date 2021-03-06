@extends('common.header')

@section('content')
    <style>
        body{font-size: 12px;}
        #banner{max-height: 420px;min-height: 335px;position: relative;top: -6rem;z-index: 1;overflow: hidden;}
        .banner-img{background-image: url("{{asset('images/banner.jpg')}}"); background-position: center center; width: 100%;height: 100%;min-height: 336px;display: block;}
        /*.now-reg{position: relative;top: 30rem;  left: 3rem;  width: 11rem;  border-radius: 0.5rem;}*/
        .now-reg{position: relative;top: 22rem;  left: 3rem;  width: 11rem;  border-radius: 0.5rem;}
        /*.banner-right{position: absolute;top: 4rem;  right: 12%;  width: 22rem;  height: 26rem;background-color: rgba(239,239,241,0.8);z-index: 3;}*/
        .banner-right{position: absolute;top: 0.5rem;  right: 12%;  width: 22rem;  height: 19rem;background-color: rgba(239,239,241,0.8);z-index: 3;}
        .index-search{background: white;height: 5rem;border-bottom: 1px dashed #ccc;}
        .index-search .search-input{width: 70%;margin: 1rem 0 0 1rem;float: left;}
        .index-search .search-btn{margin-top: 1rem;float: left;}
        /*.banner-right .zmns{height: 5rem;padding: 1rem;}*/
        .banner-right .zmns{height: 2rem;}
        .zmns .gezi{/*border: 1px solid blue;*/  padding: 1rem;  word-wrap: break-word;  overflow: hidden;  margin-left: 1rem;cursor: pointer;color: #5b7bb5;}
        .zmns .gezi img{float: left;}
        .banner-right .gg{padding: 2rem;}
        /*.gg h2{font-size: 1rem;font-weight: bolder;}*/
        .gg h2{font-size: 16px;font-weight: bolder;}
        /*.gg span{word-wrap: break-word;font-size: 0.9rem;overflow: hidden;}*/
        .gg span{word-wrap: break-word;font-size: 12px;overflow: hidden;}
        .content{margin-top: -3rem;text-align: center;}
        .content-title h1{font-size: 2rem;font-weight: bolder;text-align: center;color: #626262;}
        .content .gjps{margin-top: 2rem;}
        .content .gezi{background: white;height: 8rem;}
        .content .gezi h5{color: #165eca;text-align: left;}
        .content .gezi img{float: left;}
        .content .gezi .half{height: 10rem;  display: inline-block;  vertical-align: middle;  padding: 2rem 1rem 0 0.5rem;}
        .content li{list-style-type: disc;margin-left: 0.8rem;}
    </style>

    <div class="layui-row layui-container">
        <div class="layui-col-sm12 layui-col-md12">
            <div class="banner-right">
                <div class="layui-row">
                    <form class="layui-form index-search" action="" method="get">
                        <input type="text" name="no" required lay-verify="checkNo" lay-vertype="tips" placeholder="请输入您要查询的运单号" autocomplete="off" class="layui-input search-input">
                        <button class="layui-btn layui-btn-warm search-btn" lay-submit lay-filter="formExpress">查询</button>
                    </form>
                </div>
                <div class="layui-row zmns">
                    <div class="layui-col-xs5 layui-col-md5 gezi" onclick="window.open('/identification')"><img src="{{asset('images/zmns-1.png')}}"> 提交<br>身份证明</div>
                    <div class="layui-col-xs5 layui-col-md5 gezi" onclick="window.open('/tax')"><img src="{{asset('images/zmns-2.png')}}">在线<br>纳税</div>
                </div>
                <div class="layui-row gg">
                    <h2>Wedeport快递公告</h2>
                    <span>
                        wedepot国际官方微信上线通知<br>
                        为了提升用户体验，让大家享受更轻松更便捷的服务，wedepot国际速递开通微信服务号啦！<br>查找方法：打开微信在查找公众号中搜索“wedepot国际速递”或者“WEDEPOT”。<br>
                        全心全意！只为您放心满意！
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="layui-carousel" id="banner">
        <div carousel-item>
            @if(isset($banner))
            @foreach($banner as $val)
            <div class="banner-img" style="background-image: url('uploads/{{$val['thumb']}}'); background-size:100% 100%;">
                <div class="layui-container">
                    <div class="layui-row">
                        <div class="layui-col-sm12 layui-col-md6"><a href="{{$val['link']}}" class="layui-btn layui-btn-warm now-reg" target="_blank">{{$val['title']}}</a></div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="layui-container content">
        <div class="layui-row content-title">
            <h1>跨境电商供应链及国际物流方案解决专家</h1>
        </div>
        <div class="layui-row layui-col-space10 gjps">
            @foreach($expert as $key=>$val)
                <div class="layui-col-xs12 layui-col-md3">
                    <div class="gezi">
                        <div class="half"><img src="{{asset('images/index-content-'.$key.'.png')}}"></div>
                        <div class="half">
                        <h5>国际配送</h5>
                        <ul>
                            <li>丰富的全球航空路线</li>
                            <li>稳定的国际配送服务</li>
                            <li>本地化客户服务团队</li>
                        </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @include('common.kefu')
    @include('common.partner',['partner',$partner])
    @include('common.footer')

    <script>
        layui.use(['carousel','form'], function(){
            var carousel = layui.carousel
                    ,form = layui.form;
            //建造实例
            carousel.render({
                elem: '#banner'
                ,width: '100%' //设置容器宽度
                ,height: '420px'
                ,arrow: 'none' //始终显示箭头
                //,anim: 'updown' //切换动画方式
            });

            form.verify({
                checkNo: function(value, item){ //value：表单的值、item：表单的DOM对象
                    if(!value){
                        //return '请填写运单号（可用逗号隔开）';
                        return '请填写运单号';
                    }
                },
            });

            form.on('submit(formExpress)', function(data){
                window.open('/expressResult/'+data.field.no);
                return false; //阻止表单跳转。如果需要表单跳转，去掉这段即可。
            });
        });
    </script>
@endsection