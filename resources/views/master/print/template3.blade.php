<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>
        body{margin: 0;padding:0;width: 1503px;}
        #content{padding: 1.5rem 5rem;font-size: 1.8rem;clear: both;height: 2080px;overflow: hidden;}
        .barcode{text-align: right;}
        .barcode .img{display: inline-block;}
        .barcode .content{text-align: right;letter-spacing: 0.2rem;font-weight: bold;}
        hr{height:2px;border:none;border-top:2px solid #000000;clear: both;}
        .express{clear: both;}
        table {font-size: 1.8rem;border: 0;width: 80%;}
        .products3{clear: both;min-height: 10rem;}
        .products3 span{display: block;line-height: 2rem;}
        .tips{clear: both;}
        .tips span{display: inline-block;width: 50%;float: left;margin: 20px 0;}
        .sign {float: right;  width: 25rem; overflow: hidden;margin-bottom: 1rem;}
    </style>
</head>
<body>
<div id="content">
    <div class="barcode">
        <span style="float: left;font-size: 5rem;">wedepot</span>
        <div class="img">
            <img src="data:image/png;base64,{{$data['barcode']}}">
            <div class="content">{{$data['system_order_no']}}</div>
        </div>
    </div>
    <div class="tips">
        <span>运单号：{{$data['system_order_no']}}</span>
        <!--
        <span>客户编号：{{$data['id']}}</span>
        -->
    </div>
    <div class="tips">
        <span>打印时间：{{date('j/n/Y H:i:s A',strtotime($data['created_at']))}}</span>
    </div>
    <hr>
    <div class="express">
        <table>
            <tr>
                <td width="607">寄件人：{{$data['s_name']}}</td><td>用户名：{{$data['user']['name']}}</td>
            </tr>
            <tr>
                <td colspan="2">地址：{{$data['s_province'].$data['s_city'].$data['s_address']}}</td>
            </tr>
            <tr>
                <td>重量（LB）：{{$data['weight']}}</td><td>邮编：{{$data['s_code']}}</td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="express">
        <table>
            <tr>
                <td>收件人：{{$data['r_name']}}</td><td>省市：{{$data['r_province']}} {{$data['r_city']}}</td>
            </tr>
            <tr>
                <td>电话：{{$data['r_phone']}}</td><td>邮编：{{$data['r_code']}}</td>
            </tr>
            <tr>
                <td colspan="2">
                    地址：
                    @if($data['r_province'] && $data['r_city'] && $data['r_town'])
                        {{$data['r_province'].$data['r_city'].$data['r_town'].$data['r_addressDetail']}}
                    @else
                        {{$data['r_addressDetail']}}
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <hr>
    <div class="tips">
        <span>内件：</span>
    </div>
    <div class="products3">
        @if(isset($data['products']))
            @foreach($data['products'] as $val)
                <span>{{$val['category_one']}}  {{$val['category_two']}} {{$val['detail']}}【{{$val['brand']}}】*{{$val['catname']}}*{{$val['amount']}}</span>
            @endforeach
        @endif
    </div>
    <div class="tips">
        <span>附加服务：{{$data['addons']}}</span>
    </div>
    <hr>
    <div class="tips">
        <div>备注：</div>
        <div>{{$data['productremark']}}</div>
    </div>

</div>
<div id="addiframe"></div>
</body>
{{--

<script type="text/javascript" src="/js/pdf/html2canvas.js"></script>
<script type="text/javascript" src="/js/pdf/jsPdf.debug.js"></script>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script>
    html2canvas($("#content"), {
        //Whether to allow cross-origin images to taint the canvas
        allowTaint: true,
        //Whether to test each image if it taints the canvas before drawing them
        taintTest: false,
        background : "#ffffff",
        onrendered: function(canvas) {
            var contentWidth = canvas.width;
            var contentHeight = canvas.height;
            //一页pdf显示html页面生成的canvas高度;
            var pageHeight = contentWidth / 592.28 * 841.89;
            //未生成pdf的html页面高度
            var leftHeight = contentHeight;
            //页面偏移
            var position = 0;
            //a4纸的尺寸[595.28,841.89]，html页面生成的canvas在pdf中图片的宽高
            var imgWidth = 595.28;
            var imgHeight = 592.28 / contentWidth * contentHeight;
            var pageData = canvas.toDataURL('image/jpeg', 1.0);
            //注①
            var pdf = new jsPDF('', 'pt', 'a4');
            //有两个高度需要区分，一个是html页面的实际高度，和生成pdf的页面高度(841.89)
            //当内容未超过pdf一页显示的范围，无需分页
            if (leftHeight < pageHeight) {
                pdf.addImage(pageData, 'JPEG', 0, 0, imgWidth, imgHeight);
            } else {
                while (leftHeight > 0) {
                    //arg3-->距离左边距;arg4-->距离上边距;arg5-->宽度;arg6-->高度
                    pdf.addImage(pageData, 'JPEG', 0, position, imgWidth, imgHeight)
                    leftHeight -= pageHeight;
                    position -= 841.89;
                    //避免添加空白页
                    if (leftHeight > 0) {
                        //注②
                        pdf.addPage();
                    }
                }
            }

            var html = pdf.output('dataurlstring');
            print2(html);
        }
    });

    function print2(html){
        //添加ifrme标签
        $("body").html("<iframe style='' width='100%' height='100%' name = 'printIframe2' id='printIframe' src='"+html+"'>");
        //打印预览
        @if($print)$("#printIframe")[0].contentWindow.print();@endif
    }

</script>
--}}

</html>