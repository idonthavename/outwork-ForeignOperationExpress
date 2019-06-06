<link href="{{ asset('css/common/partner.css') }}" rel="stylesheet">
<div class="partner">
    <div class="layui-container">
        <div class="layui-row layui-col-space5 jiange3">
            <div class="layui-col-sm12 layui-col-md1 jiange1">合作伙伴：</div>
            <div class="layui-col-sm12 layui-col-md11">
                <div class="layui-row layui-col-space10">
                    @if(isset($partner))
                    @foreach($partner as $val)
                        <div class="layui-col-xs6 layui-col-md2"><a href="{{$val['link']}}" target="_blank" title="{{$val['title']}}"><div class="gezi"><img src="uploads/{{$val['thumb']}}" alt="{{$val['title']}}" width="90"></div></a></div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>