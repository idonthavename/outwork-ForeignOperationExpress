<!DOCTYPE>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <style>body{width: 1660px;}</style>
</head>
<body>
<div id="main">
    @foreach($data as $val)
        @include('master.print.template'.$val['template'],['data'=>$val['nodata'] == 1 ? null : $val])
    @endforeach
</div>
</body>
<script type="text/javascript" src="/js/pdf/html2canvas.js"></script>
<script type="text/javascript" src="/js/pdf/jsPdf.debug.js?t={{time()}}"></script>
<script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
<script>
    html2canvas($("#main"), {
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
            //var imgWidth = 595.28;
            //var imgHeight = 592.28 / contentWidth * contentHeight;
            var imgWidth = 595.28;
            var imgHeight = 595.28 / contentWidth * contentHeight;
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
            var time = new Date().toArray();
            var html = pdf.output('dataurlstring');
            print2(html);
            pdf.output("save",time[0]+"-"+time[1]+"-"+time[2]+".pdf");
            //setTimeout(function(){window.opener=null;window.close()},5000);
        }
    });

    function print2(html){
        //添加ifrme标签
        $("body").html("<iframe style='' width='100%' height='100%' name = 'printIframe2' id='printIframe' src='"+html+"'>");
        //打印预览
        @if($print == 1)$("#printIframe")[0].contentWindow.print();@endif
    }

    Date.prototype.toArray = function()
    {
        var myDate = this;
        var myArray = Array();
        myArray[0] = myDate.getFullYear();
        myArray[1] = myDate.getMonth()+1;
        myArray[2] = myDate.getDate();
        myArray[3] = myDate.getHours();
        myArray[4] = myDate.getMinutes();
        myArray[5] = myDate.getSeconds();
        return myArray;
    }

</script>
</html>