<?php

namespace App\Http\Controllers\Master;

use App\Addon;
use App\Consume;
use App\Line;
use App\Linetwo;
use App\Order;
use App\OrderLog;
use App\OrderProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ListController extends Controller
{
    private  $allstatus;

    public function __construct(){
        $this->allstatus = [
            '未审核',
            '已审核待入库',
            '已拣货待打包',
            '已入库代付款',
            '已付款待出库',
            '已出库',
            '已发往起运机场',
            '飞往中国',
            '抵达海关，等候清关',
            '海关清关中',
            '已出关转国内派送',
            '已签收',
            99=>'异常件'
        ];
    }

    public function index($status){
        $output['status'] = $status;
        $output['allstatus'] = $this->allstatus;
        $output['line'] = Line::select(['id','name'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $output['linetwo'] = Linetwo::select(['id','name'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        return view('master.list.index',$output);
    }

    public function getData($status,Request $request){
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));

        $data = Order::whereRaw('1 = 1');
        $acceptParams = ['system_order_no','s_name','r_name','r_phone','user_order_no','line_id','linetwo','r_cre_num_status','id_card_thumb_status','start','end','status','print','productdetail'];
        foreach ($acceptParams as $val){
            $param = $request->get($val);
            if (isset($param)){
                if ($val == 'start'){
                    $data = $data->where('created_at','>=',$request->get($val));
                }elseif ($val == 'end'){
                    $data = $data->where('created_at','<=',$request->get($val));
                }elseif ($val == 'r_cre_num_status'){
                    $data = $request->get($val) == 1 ? $data->whereNotNull('r_cre_num') : $data->whereNull('r_cre_num');
                }elseif ($val == 'id_card_thumb_status'){
                    $data = $request->get($val) == 1 ? $data->whereRaw('(id_card_front IS NOT NULL AND id_card_front <> "")')->whereRaw('(id_card_back IS NOT NULL AND id_card_back <> "")') : $data->whereRaw('(id_card_front IS NULL OR id_card_back = "")')->whereRaw('(id_card_back IS NULL OR id_card_back = "")');
                }elseif ($val == 'system_order_no'){
                    $system_order_no = explode("\n",$request->get($val));
                    if (count($system_order_no) == 1){
                        $data = $data->where('system_order_no','like','%'.$system_order_no[0].'%');
                    }else{
                        $data = $data->whereIn('system_order_no',$system_order_no);
                    }
                }elseif($val == 'print'){
                    $request->get($val) == 1 ? $data = $data->where('print',1) : $data = $data->where('print',0);
                }else{
                    if (is_numeric($request->get($val))){
                        $data = $data->where($val,intval($request->get($val)));
                    }else{
                        $data = $data->where($val,'like','%'.$request->get($val).'%');
                    }
                }
            }
        }
        $count = $data->count();
        $outputData = $data->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        foreach ($outputData as $key=>$val){
            $val['username'] = $val->userData->name;
            $val['lineonename'] = $val['line_id'] > 0 ? $val->lineData->name : '';
            $val['linetwoname'] = $val['linetwo'] > 0 ? $val->linetwoData->name : '';
            $val['number'] = $key+1;
            $val['statustr'] = $this->allstatus[$val['status']];
            $outputData[$key] = $val;
        }
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$outputData,'count'=>$count]);
    }

    public function showAudit(Request $request){
        $line_id = intval($request->get('line_id'));
        $line = Line::select(['linetwos'])->where('id',$line_id)->first();
        $linetwos = explode(',',$line->linetwos);
        $linetwoInfo = Linetwo::whereIn('id',$linetwos)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        return view('master.list.audit',['linetwoInfo'=>$linetwoInfo]);
    }
    public function audit(Request $request){
        $post = $request->post();
        $post['statusJson'] = json_decode($post['statusJson'],true);
        return $this->__checkStatusChange($post,1);
    }
    public function pick(Request $request){
        return $this->__checkStatusChange($request->post(),2);
    }
    public function showWeight(){ return view('master.list.weight'); }
    public function weight(Request $request){
        $post = $request->post();
        $info = Order::where('system_order_no',$post['system_order_no'])->first();
        if (!isset($info) || empty($info)) return response()->json(['status'=>-100,'msg'=>'订单不存在']);
        $post['statusJson'][] = '{"id":'.$info->id.',"status":'.$info->status.'}';
        return $this->__checkStatusChange($post,3);
    }
    public function charge(Request $request){
        return $this->__countCharge($request->post(),4);
    }
    public function getout(Request $request){
        return $this->__checkStatusChange($request->post(),5);
    }
    public function showChange(){ return view('master.list.change',['allstatus'=>$this->allstatus]); }
    public function change(Request $request){
        $post = $request->post();
        $post['statusJson'] = json_decode($post['statusJson'],true);
        return $this->__checkStatusChange($post, intval($request->post('status')));
    }
    public function showChangeUser(){return view('master.list.changeUser');}
    public function changeUser(Request $request){
        $post = $request->post();
        $post['statusJson'] = json_decode($post['statusJson'],true);
        $user = User::select(['id','user_identification'])->where(['user_identification'=>$post['user_identification']])->first();
        $temp = [];
        foreach ($post['statusJson'] as $val){
            $temp[] = $val['id'];
        }
        Order::whereIn('id',$temp)->update(['uid'=>$user->id]);
        return json_encode(['status'=>200,'msg'=>'保存成功']);
    }

    private function __checkStatusChange($request,$changeStatus){
        $validator = Validator::make($request,['statusJson' => 'required|array','weight' => 'nullable|numeric', 'tax' => 'nullable|numeric', 'fail_reason' => 'nullable|string|max:255', 'express_no'=>'nullable|string|max:50', 'linetwo'=>'nullable|integer']);
        $statusArray = ['未审核','审核','拣货','称重','扣款','出库'];
        if ($validator->fails()) return json_encode(['status'=>-100,'msg'=>'保存失败']);
        if ($changeStatus == 10 && count($request['statusJson']) > 1) return json_encode(['status'=>-101,'msg'=>'更新快递号只能单项操作']);
        $user = Auth::user();
        foreach ($request['statusJson'] as $val){
            if (!is_array($val)) $val = json_decode($val,true);
            if ($changeStatus < $val['status'] && $val['status'] <> 99) return json_encode(['status'=>-101,'msg'=>'抱歉，订单不允许回退操作']);
            if ($changeStatus <= 5 && $val['status']+1 <> $changeStatus) return json_encode(['status'=>-102,'msg'=>'抱歉，该订单还未进行'.$statusArray[$val['status']+1].'操作']);
            if (isset($request['weight']) && $request['weight'] > 0) $update['weight'] = number_format($request['weight'],2,'.','');
            if (isset($request['tax']) && $request['tax'] > 0) $update['tax'] = number_format($request['tax'],2,'.','');
            if (isset($request['fail_reason'])) $update['fail_reason'] = $request['fail_reason'];
            if (isset($request['express_no'])) $update['express_no'] = $request['express_no'];
            if (isset($request['linetwo'])) $update['linetwo'] = $request['linetwo'];
            $update['before_status'] = $val['status'];
            $update['status'] = $changeStatus;
            Order::where('id',$val['id'])->update($update);
            OrderLog::create(['oid'=>$val['id'],'name'=>$user['name'],'status'=>$changeStatus]);
        }
        return json_encode(['status'=>200,'msg'=>'保存成功']);
    }

    private function __countCharge($request,$changeStatus){
        $validator = Validator::make($request,['statusJson' => 'required|array']);
        if ($validator->fails()) return json_encode(['status'=>-100,'msg'=>'保存失败']);
        foreach ($request['statusJson'] as $val){
            $val = json_decode($val,true);
            if ($changeStatus < $val['status']) return json_encode(['status'=>-101,'msg'=>'抱歉，订单不允许回退操作']);

            $sum = 0;
            $info = Order::find($val['id']);
            $lineData = $info->lineData;
            $userData = $info->userData;
            $price = json_decode($lineData->price,true);
            $addons = Addon::whereIn('name',explode(',',$info->addons))->get();
            $overweight = json_decode($lineData->overweight,true)[$userData->rank];
            //初始价格（根据会员等级）
            $sum += $price[$userData->rank];
            //附加费用
            foreach ($addons as $addonval){
                $sum += $addonval['money'];
            }
            //超重后的额外费用（根据会员等级）
            if ($info->weight > $lineData->ykg){
                $yushu = $info->weight - $lineData->ykg;
                switch ($lineData->rule){
                    case 1:
                        $sum += ceil($yushu / $lineData->goon) * $overweight['price'];
                        break;
                    case 3:
                        $zhengshu = floor($yushu / $lineData->goon);
                        $tuiwei = number_format($yushu - $zhengshu * $lineData->goon,2,',','') >= $lineData->outon ? $overweight['price'] : 0;
                        $sum += $zhengshu * $overweight['price'] + $tuiwei;
                        break;
                    default:
                        $sum += ($yushu / $lineData->goon) * $overweight['price'];
                        break;
                }
            }
            
            $sum = number_format($sum,2,'.','');
            
            if($info->deduct_money > 0){
                $deductSum = $info->deduct_money;
            }else{
                $deductSum = $sum;
            }
            //检查用余额
            if ($userData->money < $deductSum){
                return json_encode(['status'=>-101,'msg'=>'用户余额不足']);
            }else{
                $consume = [
                    'uid'=>$userData->id,
                    'name'=>$userData->name,
                    'consume_order_no'=> 'C'.date('YmdHis').mt_rand(10000,99999),
                    'system_order_no'=>$info->system_order_no,
                    'user_order_no'=>$info->user_order_no,
                    'money'=>$deductSum,
                ];
                Consume::create($consume);
                $leftMoney = number_format(($userData->money - $deductSum),2,'.','');
                User::where('id',$info->uid)->update(['money'=>$leftMoney]);
            }

            $update['money'] = $sum;
            $update['before_status'] = $val['status'];
            $update['status'] = $changeStatus;
            Order::where('id',$val['id'])->update($update);
            OrderLog::create(['oid'=>$val['id'],'name'=>$userData->name,'status'=>$changeStatus]);
        }
        return json_encode(['status'=>200,'msg'=>'操作成功']);
    }

    public function productDetail($system_order_no){
        $system_order_no = strip_tags(trim($system_order_no));
        $data = OrderProduct::where('system_order_no',$system_order_no)->get();
        return view('master.list.productDetail',['data'=>$data]);
    }

    public function orderlog($oid){
        $system_order_no = intval($oid);
        $data = OrderLog::where('oid',$oid)->orderBy('created_at','DESC')->get();
        return view('master.list.orderlog',['data'=>$data,'allstatus'=>$this->allstatus]);
    }

    public function excelExpress(Request $request){
        $this->validate($request,[
            'excel'=>'required|file'
        ]);

        $allowTypes = ['xls','xlsx'];
        $excel = $request->file('excel');
        $type = intval($request->get('type',0));
        if (in_array(strtolower($excel->getClientOriginalExtension()),$allowTypes)){
            if ($excel->getSize() > 2*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于2M文件']);
            require_once(base_path() . '/app/libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
            if($excel->getClientOriginalExtension() == 'xlsx'){
                $reader = \PHPExcel_IOFactory::createReader('Excel2007');
            }else{
                $reader = \PHPExcel_IOFactory::createReader('Excel5');
            }
            $PHPExcel = $reader->load($excel->path()); // 载入excel文件
            $sheet = $PHPExcel->getSheet(0);// 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
            $data_num = 0;
            $oknum = 0;
            $data = [];
            switch ($type){
                case 1:
                    for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
                        $data[$row]['system_order_no'] = $sheet->getCell('A' . $row)->getValue();
                        $data[$row]['weight'] = number_format($sheet->getCell('B' . $row)->getValue(),2,'.','');
                        if ($data[$row]['system_order_no'] && $data[$row]['weight']) $data_num++;
                    }
                    break;
                default:
                    for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
                        $data[$row]['system_order_no'] = $sheet->getCell('A' . $row)->getValue();
                        $data[$row]['express_no'] = $sheet->getCell('B' . $row)->getValue();
                        if ($data[$row]['system_order_no'] && $data[$row]['express_no']) $data_num++;
                    }
                    break;
            }

            if ($data_num < 1) return response(['status'=>-100,'msg'=>'请填写至少一条数据']);


            switch ($type){
                case 1:
                    foreach ($data as $val){
                        if (Order::where('system_order_no',$val['system_order_no'])->update(['weight'=>$val['weight'],'status'=>3])){
                            $oknum++;
                        }
                    }
                    break;
                default:
                    foreach ($data as $val){
                        if (Order::where('system_order_no',$val['system_order_no'])->update(['express_no'=>$val['express_no'],'status'=>10])){
                            $oknum++;
                        }
                    }
                    break;
            }

            return response()->json(['status'=>200,'msg'=>'成功导入 '.$oknum.' 条数据！']);
        }else{
            return response()->json(['status'=>-100,'msg'=>'请上传xls或xlsx文件']);
        }
    }

    public function outExcel(Request $request){
        $title = ['运单号','外部订单号', '用户名', '寄件人', '寄件人电话', '收件人', '收件人地址', '收件人电话', '身份证号码', '编码', '货品一级分类', '货品二级分类', '物品名称', '规格/型号/材质', '品牌', '单价', '货品总数',
            '重量', '附加服务', '运费', '一级线路', '二级线路', '运单状态'];
        $jsonArray = json_decode($request->post('statusJson'),true);
        if (isset($jsonArray) && !empty($jsonArray)){
            $ids = [];
            foreach ($jsonArray as $jval){
                $ids[] = $jval['id'];
            }
            $orders = Order::whereIn('id',$ids)->orderBy('created_at','DESC')->get();
            foreach ($orders as $okey=>$oval){
                $orders[$okey]['product'] = OrderProduct::where('system_order_no',$oval['system_order_no'])->get();
            }
        }else{
            $orders = Order::whereRaw('1 = 1');
            $acceptParams = ['system_order_no','s_name','r_name','r_phone','user_order_no','line_id','linetwo','r_cre_num_status','id_card_thumb_status','start','end','status','print','productdetail'];
            foreach ($acceptParams as $val){
                $param = $request->post($val);
                if (isset($param)){
                    if ($val == 'start'){
                        $orders = $orders->where('created_at','>=',$request->get($val));
                    }elseif ($val == 'end'){
                        $orders = $orders->where('created_at','<=',$request->get($val));
                    }elseif ($val == 'r_cre_num_status'){
                        $orders = $request->get($val) == 1 ? $orders->whereNotNull('r_cre_num') : $orders->whereNull('r_cre_num');
                    }elseif ($val == 'id_card_thumb_status'){
                        $orders = $request->get($val) == 1 ? $orders->whereRaw('(id_card_front IS NOT NULL AND id_card_front <> "")')->whereRaw('(id_card_back IS NOT NULL AND id_card_back <> "")') : $orders->whereRaw('(id_card_front IS NULL OR id_card_back = "")')->whereRaw('(id_card_back IS NULL OR id_card_back = "")');
                    }elseif ($val == 'system_order_no'){
                        $system_order_no = explode("\n",$request->get($val));
                        if (count($system_order_no) == 1){
                            $orders = $orders->where('system_order_no','like','%'.$system_order_no[0].'%');
                        }else{
                            $orders = $orders->whereIn('system_order_no',$system_order_no);
                        }
                    }elseif($val == 'print'){
                        $request->get($val) == 1 ? $orders = $orders->where('print',1) : $orders = $orders->where('print',0);
                    }else{
                        if (is_numeric($request->get($val))){
                            $orders = $orders->where($val,intval($request->get($val)));
                        }else{
                            $orders = $orders->where($val,'like','%'.$request->get($val).'%');
                        }
                    }
                }
            }
            $orders = $orders->limit(10000)->orderBy('created_at','DESC')->get();
            foreach ($orders as $okey=>$oval){
                $orders[$okey]['product'] = OrderProduct::where('system_order_no',$oval['system_order_no'])->get();
            }
        }
        $data = [];
        $i = 0;
        foreach ($orders as $val){
            $categoryOneName = $categoryTwoName = $detail = $catname = $brand = $price = $amount = '';
            foreach ($val['product'] as $pval){
                $categoryOneName .= $pval->categoryOne->name.'/';
                $categoryTwoName .= $pval->categoryTwo->name.'/';
                $detail .= $pval['detail'].'/';
                $catname .= $pval['catname'].'/';
                $brand .= $pval['brand'].'/';
                $price .= $pval['price'].'/';
                $amount .= $pval['amount'].'/';
            }
            $data[] = [
                'system_order_no'=>$val['system_order_no'],
                'user_order_no'=>$val['user_order_no'],
                'username'=>$val->userData->name,
                's_name'=>$val['s_name'],
                's_phone'=>$val['s_phone'],
                'r_name'=>$val['r_name'],
                'r_ddress'=>$val['r_province'].$val['r_city'].$val['r_town'].$val['r_addressDetail'],
                'r_phone'=>$val['r_phone'],
                'r_cre_num'=>' '.$val['r_cre_num'],
                'r_code'=>$val['r_code'],
                'category_one'=>$categoryOneName,
                'category_two'=>$categoryTwoName,
                'detail'=>$detail,
                'catname'=>$catname,
                'brand'=>$brand,
                'price'=>$price,
                'amount'=>$amount,
                'weight'=>$val['weight'],
                'addons'=>$val['addons'],
                'money'=>$val['money'],
                'lineone'=>$val['line_id'] > 0 ? $val->lineData->name : '',
                'linetwo'=>$val['linetwo'] > 0 ? $val->linetwoData->name : '',
                'status'=>$this->allstatus[$val['status']],
            ];
        }
        require_once(base_path() . '/app/libs/PHPExcel-1.8/Classes/PHPExcel.php');
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setTitle('导出列表');
        $objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal("center");
        $objPHPExcel->getDefaultStyle()->getAlignment()->setVertical("center");
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode("@");
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode("@");
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode("@");
        $dataArray = [$title];
        foreach ($data as $val){
            array_push($dataArray,$val);
        }
        $objPHPExcel->getActiveSheet()->fromArray($dataArray, null, 'A1');
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.date('Y-m-d').'.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997$hourValueGMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        $objPHPExcel->disconnectWorksheets();
    }

    public function downloadOrderPic(Request $request){
        $jsonArray = json_decode($request->post('statusJson'),true);
        if (isset($jsonArray) && !empty($jsonArray)){
            $ids = [];
            foreach ($jsonArray as $jval){
                $ids[] = $jval['id'];
            }
            $orders = Order::select(['system_order_no','id_card_front','id_card_back'])->whereIn('id',$ids)->orderBy('created_at','DESC')->get();
        }else{
            abort(404);
        }

        $fileList = [];
        foreach ($orders as $val){
            if ($val['id_card_front'] && $val['id_card_back']){
                $font = [
                    'file'=>public_path()."/uploads/".$val['id_card_front'],
                    'name'=>$val['system_order_no']."-1",
                    'ext'=>$this->__getExt($val['id_card_front'])
                ];
                $back = [
                    'file'=>public_path()."/uploads/".$val['id_card_back'],
                    'name'=>$val['system_order_no']."-2",
                    'ext'=>$this->__getExt($val['id_card_back'])
                ];
                array_push($fileList,$font);
                array_push($fileList,$back);
            }
        }
        if (count($fileList) < 1) abort(404);
        $filename = public_path()."/uploads/".md5(uniqid('wedepot')).".zip";
        $zip = new \ZipArchive();
        $zip->open($filename,\ZipArchive::CREATE);   //打开压缩包
        foreach($fileList as $detail){
            $zip->addFile($detail['file'],$detail['name'].".{$detail['ext']}");   //向压缩包中添加文件
        }
        $zip->close();  //关闭压缩包

        //这里是下载zip文件
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: Binary");

        header("Content-Length: " . filesize($filename));
        header("Content-Disposition: attachment; filename=\"" . basename($filename) . "\"");

        readfile($filename);
        unlink($filename);
    }

    private function __getExt($url){
        $urlinfo =  parse_url($url);
        $file = basename($urlinfo['path']);
        if(strpos($file,'.') !== false) {
            $ext = explode('.',$file);
            return $ext[count($ext)-1];
        }
        return false;
    }

}
