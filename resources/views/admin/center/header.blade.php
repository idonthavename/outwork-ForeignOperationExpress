<style>
    .my-card-header{font-size: 1.5rem;text-indent: 1rem;}
    .layui-card-body {line-height: 2rem;}
    .user {font-size: 1rem;}
    .user .danshu{border-right: 1px solid #cccccc;height: 3rem;}
    .user .chongzhi{text-indent: 0;}
    .user .header-content{height: 12rem;}
    .user .username{width: 10rem;display: inline-block;}
    #money{font-size: 1.2rem;font-weight: bold;}
    .layui-align-right{text-align: right;}
</style>
<div class="layui-fluid">
    <div class="layui-row layui-col-space20 user">
        <div class="layui-col-md6">
            <div class="layui-card header-content">
                <div class="layui-card-header my-card-header">
                    <div class="layui-row">
                        <div class="layui-col-md6">账户信息</div>
                        {{--<div class="layui-col-md6"><a class="layui-btn layui-btn-warm layui-btn-lg chongzhi">充值</a></div>--}}
                    </div>
                </div>
                <div class="layui-card-body">
                    <div class="layui-row" style="line-height: 3rem;">
                        <div class="layui-col-xs5 layui-col-md5 danshu"><span class="layui-elip layui-inline username">用户名：{{$user['name']}}</span><span><a href="{{url('/user/center/info')}}" target="_blank" class="layui-btn layui-btn-xs">账户信息</a></span></div>
                        <div class="layui-col-xs5 layui-col-md5 layui-col-xs-offset1 layui-col-md-offset1">用户代码：{{$user['user_identification']}}</div>
                        <div class="layui-col-xs5 layui-col-md5 danshu">邮箱：{{$user['email']}}</div>
                        <div class="layui-col-xs5 layui-col-md5 layui-col-xs-offset1 layui-col-md-offset1">账户余额：${{$user['money']}}</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-col-md6">
            <div class="layui-card header-content">
                <div class="layui-card-body">
                    <form class="layui-form" method="post" action="{{url('user/center/securepay')}}" target="_blank">
                        {{csrf_field()}}
                        <div class="layui-row">
                            <div class="layui-col-sm6">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">充值金额</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="amount" id="amount"  lay-verify="required" lay-verType="tips" placeholder="请输入金额(美元)" autocomplete="off" class="layui-input" maxlength="6">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-sm4 layui-align-right">
                                {{--<span class="layui-text">参考汇率：1USD=7.11CNY</span>--}}
                            </div>
                        </div>
                        <div class="layui-row">
                            <div class="layui-col-sm8">
                                <div class="layui-form-item">
                                    <label class="layui-form-label"></label>
                                    <div class="layui-input-block">
                                        <a class="layui-btn layui-btn-primary layui-btn-sm changeMoney" data-val="50.00">$50.00</a>
                                        <a class="layui-btn layui-btn-primary layui-btn-sm changeMoney" data-val="100.00">$100.00</a>
                                        <a class="layui-btn layui-btn-primary layui-btn-sm changeMoney" data-val="200.00">$200.00</a>
                                        <a class="layui-btn layui-btn-primary layui-btn-sm changeMoney" data-val="500.00">$500.00</a>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-sm2 layui-align-right">
                                <span id="money">0.00</span>
                            </div>
                        </div>
                        <div class="layui-row">
                            <div class="layui-col-sm8">
                                <div class="layui-form-item">
                                    <label class="layui-form-label">支付方式</label>
                                    <div class="layui-input-block">
                                        <input type="radio" name="vendor" value="alipay" title="支付宝" checked>
                                        <input type="radio" name="vendor" value="wechatpay" title="微信">
                                        <input type="radio" name="vendor" value="unionpay" title="银联">
                                    </div>
                                </div>
                            </div>
                            <div class="layui-col-sm2 layui-align-right">
                                <button class="layui-btn layui-btn-warm layui-btn-sm" lay-submit lay-filter="pay">立即支付</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>