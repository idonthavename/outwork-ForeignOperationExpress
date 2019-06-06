<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HelperController extends Controller
{
    static function get62($src, $length = 8){
        $md5 = md5($src, true);

        $pos = 0;
        $res = "";
        while(strlen($res) < $length && ($bin = substr($md5, $pos, 4)) != ""){
            $uint =  sprintf("%u" , unpack("Nint", $bin)['int']);
            $res .= self::decto62($uint);
            $pos += 4;
        }
        return substr($res, 0, $length);
    }

    static function decto62($src){
        static $table = [];
        $table = array_merge(range(0, 9), range('A', "Z"), range('a', "z"));

        $arr62 = [];
        $div = $src;
        do{
            $mod = $div % 62;
            array_unshift($arr62, $table[$mod]);
            $div = intval($div / 62);
        }while($div != 0);

        return implode("", $arr62);
    }

    static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile','MicroMessenger');
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

    /**
     * exportExcel($data,$title,$filename);
     * 导出数据为excel表格
     *@param $data    一个二维数组,结构如同从数据库查出来的数组
     *@param $title   excel的第一行标题,一个数组,如果为空则没有标题
     *@param $filename 下载的文件名
     *@examlpe
     */
    static function exportExcel($filename='report',$title=[],$data=[])
    {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=".$filename.".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        //导出xls开始
        if (!empty($title))
        {
            foreach ($title as $k => $v)
            {
                $title[$k]=iconv("UTF-8", "GB2312",$v);
            }
            $title= implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data))
        {
            foreach($data as $key=>$val)
            {
                foreach ($val as $ck => $cv)
                {
                    $data[$key][$ck]=iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key]=implode("\t", $data[$key]);
            }

            echo implode("\n",$data);
        }
    }
}
