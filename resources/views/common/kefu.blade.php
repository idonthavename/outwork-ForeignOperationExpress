<style>
    .k_service{position: fixed;  top: 10rem;  right: 1rem;  width: 7rem;  height: 17rem;}
    .k_service .p1 {  padding: 10px 0 3px 0;  }
    .k_service p {  text-align: center;  line-height: 24px;  color: #fff;  font-size: 12px;  }
    .k_service .kefu-totop{z-index:100000; opacity: 1;  cursor: pointer;  background-position: center;position: absolute;  left: 0; width: 100%;  bottom: 0px; text-align:center;font-size: 30px; color: white;}
    .k_service .zixun{width: 40%;margin-top: 0.5rem;height: 1.3rem;}
</style>
<div class="k_service ui-draggable" style="z-index:1000000000; opacity: 1;    background: none;">
    <div class="k_services" style="z-index:1000000000; opacity: 1;    background: none;position: absolute;  left: 0;  top: 0; width:100%; height:240px;">
        <p class="p1"><img src="{{asset('images/index-content-white3.png')}}" width="70"></p>
        <p class="p22">周一至周五<br>09:00-18:00</p>
        <p class="p2">客服热线：</p>
        <p class="p3">4008802969</p>
        <p class="p4">在线客服：</p>
        <p class="p5"><a href="https://webchat.7moor.com/wapchat.html?accessId=0fcfddd0-84b8-11e8-9e40-2b39a9550803&amp;fromUrl=meiquick-web" target="_blank" class="layui-btn layui-btn-xs layui-btn-warm zixun">咨询</a></p>
    </div>
    <i class="layui-icon layui-icon-up kefu-totop"></i>
    <div class="k_services" style="z-index:100000;  background-color: rgba(75,117,191,0.8); width:100%; height:100%;"></div>
</div>
<script>
    layui.use(['form'], function(){
        var $ = layui.jquery;
        $(".kefu-totop").on('click',function () {
            $('html, body').stop().animate({
                scrollTop: 0
            }, 'slow');
        });
    });

</script>