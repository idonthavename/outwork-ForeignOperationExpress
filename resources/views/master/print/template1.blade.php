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
        .express{display: inline-block;width: 50%;float: left;margin-bottom:2rem;}
        .express .title{margin-bottom: 2rem;}
        .products{min-height: 50rem;}
        .products span{display: block;line-height: 2rem;}
        .tips span{display: inline-block;width: 50%;float: left;}
    </style>
</head>
<body>

<div id="content">
    <div class="barcode">
        <div class="img">
            <img src="data:image/png;base64,{{$data['barcode']}}">
            <div class="content">{{$data['system_order_no']}}</div>
        </div>
    </div>
    <div class="tips">
        <span>扫描查单：kd.wedepot.com</span>
        <span>客户编号：{{$data['id']}}</span>
    </div>
    <hr>
    <div>
        <div class="express">
            <div class="title"> 寄件人信息：</div>
            <div>{{$data['s_province'].$data['s_city'].$data['s_address']}}</div>
            <div>{{$data['s_phone']}}</div>
            <div>{{$data['s_name']}}</div>
        </div>
        <div class="express">
            <div class="title"> 收件人信息：</div>
            @if($data['r_province'] && $data['r_city'] && $data['r_town'])
                <div>{{$data['r_province'].$data['r_city'].$data['r_town'].$data['r_addressDetail']}}</div>
            @else
                <div>{{$data['r_addressDetail']}}</div>
            @endif
            <div>{{$data['r_phone']}}</div>
            <div>{{$data['r_name']}}</div>
        </div>
    </div>
    <div class="tips">
        <span>快递物品：</span>
    </div>
    <hr>
    <div class="products">
        @if(isset($data['products']))
            @foreach($data['products'] as $val)
                <span>{{$val['category_one']}}  {{$val['category_two']}} {{$val['detail']}}【{{$val['brand']}}】*{{$val['catname']}}*{{$val['amount']}}</span>
            @endforeach
        @endif
    </div>
    <div class="tips">
        <span>重量：{{$data['weight']}}</span>
        <span>备注：{{$data['remark']}}</span>
    </div>
    <hr>
    <div class="tips">
        <span>日期：{{date('j/n/Y H:i:s A',strtotime($data['created_at']))}}</span>
    </div>
    <hr>
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