<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">--}}
    <script type="text/javascript" src="{{asset('js/viewport.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin.css')}}">
    <title>管理后台</title>
</head>
<body class="layui-layout-body">


<div class="layui-layout layui-layout-admin">
    <div class="layui-header custom-header">

        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item slide-sidebar" lay-unselect>
                <a href="javascript:;" class="icon-font"><i class="ai ai-menufold"></i></a>
            </li>
        </ul>

        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a style="display: inline;" href="/news" target="_blank">公告</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">{{$user->active ? '已验证' : '等待验证'}}</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">{{$user->name}}</a>
                <dl class="layui-nav-child">
                    <dd><a href="/">官网首页</a></dd>
                    <dd><a href="" class="resetpassword">修改密码</a></dd>
                    <dd><a href="/user/logout">登出</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">中文</a>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">English</a>
            </li>
        </ul>
    </div>

    <div class="layui-side custom-admin">
        <div class="layui-side-scroll">

            <div class="custom-logo">
                <img src="{{asset('/images/logo-admin.png')}}" alt=""/>
                <h1>Wedepot</h1>
            </div>
            <ul id="Nav" class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <i class="layui-icon">&#xe609;</i>
                        <em>主页</em>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="/master/depot">仓库管理</a></dd>
                        <dd><a href="/master/addon" >附加服务管理</a></dd>
                        <dd><a href="/master/list/0" >运单管理</a></dd>
                        <dd><a href="/master/user" >用户管理</a></dd>
                        <dd><a href="/master/product" >产品管理</a></dd>
                        <dd><a href="/master/line" >线路管理</a></dd> 
                        <dd><a href="/master/linetwo" >二级线路管理</a></dd>
                        <dd><a href="/master/center/1" >扣款管理</a></dd>
                        <dd><a href="/master/deduct" >手动扣款管理</a></dd>
                        <dd><a href="/master/print" >打印模板管理</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">
                        <i class="layui-icon">&#xe609;</i>
                        <em>前台页面管理</em>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="/master/content/1">产品服务</a></dd>
                        <dd><a href="/master/content/2">收费说明</a></dd>
                        <dd><a href="/master/content/3">首页banner</a></dd>
                        <dd><a href="/master/content/4">合作伙伴</a></dd>
                        <dd><a href="/master/content/5">公告</a></dd>
                    </dl>
                </li>
            </ul>

        </div>
    </div>

    <div class="layui-body">
        <div class="layui-tab app-container" lay-allowClose="true" lay-filter="tabs">
            <ul id="appTabs" class="layui-tab-title custom-tab"></ul>
            <div id="appTabPage" class="layui-tab-content"></div>
        </div>
    </div>

    <div class="layui-footer">
        <p>© 2018 POWER BY 小Y</p>
    </div>

    <div class="mobile-mask"></div>
</div>
<script src="{{asset('js/layui.js')}}"></script>
<script src="{{asset('js/admin/index.js')}}" data-main="home"></script>
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index'], function(){
        var $ = layui.$;

        $('.resetpassword').on('click', function(){
            layer.open({
                type: 2
                ,title: '修改密码'
                ,content: 'user/reset'
                ,maxmin: true
                ,area: ['450px', '400px']
                ,btn: ['确定', '取消']
                ,yes: function(index, layero){
                    //点击确认触发 iframe 内容中的按钮提交
                    var submit = layero.find('iframe').contents().find("#layuiadmin-app-form-submit");
                    submit.click();
                }
            });
            return false;
        });
    });
</script>
</body>
</html>
