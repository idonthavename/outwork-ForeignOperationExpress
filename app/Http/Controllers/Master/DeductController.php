<?php

namespace App\Http\Controllers\master;

use App\Consume;
use App\DeductLog;
use App\Order;
use App\OrderLog;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.deduct.index');
    }

    public function getData(Request $request){
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));

        $data = DeductLog::whereRaw('1 = 1');
        // $acceptParams = ['system_order_no','s_name','r_name','r_phone','user_order_no','line_id','linetwo','r_cre_num_status','id_card_thumb_status','start','end','status','print','productdetail'];
        
        $count = $data->count();
        $outputData = $data->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$outputData,'count'=>$count]);
    }

    public function import(){ 
        return view('master.deduct.import'); 
    }

    public function excelDeduct(Request $request){
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
            for ($row = 2; $row <= $highestRow; $row++) {//行数是以第1行开始
                $data[$row]['system_order_no'] = $sheet->getCell('A' . $row)->getValue();
                $data[$row]['deduct_money'] = number_format($sheet->getCell('B' . $row)->getValue(),2,'.','');
                if ($data[$row]['system_order_no'] && $data[$row]['deduct_money']) $data_num++;
            }
            if ($data_num < 1) return response(['status'=>-100,'msg'=>'请填写至少一条数据']);
            $list = [];

            foreach ($data as $val){
                $res = $this->__orderDeduct($val['system_order_no'],$val['deduct_money']);
                if($res[0] == 1){
                    $list[] = array('order_no'=>$val['system_order_no'],'money'=>$val['deduct_money'],'info'=>$res[1],'status'=>'成功');
                    $oknum++;
                }else{
                    $list[] = array('order_no'=>$val['system_order_no'],'money'=>$val['deduct_money'],'info'=>$res[1],'status'=>'失败');
                }
            }

            return response()->json(['status'=>200,'msg'=>'成功导入 '.$oknum.' 条数据！','data'=>$list]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'请上传xls或xlsx文件']);
        }
    }

    public function __orderDeduct($ordor_no,$price){
        $info = Order::where('system_order_no',$ordor_no)->first();  
        if(!$info){
            return [0,'订单不存在'];
        }
        if ($info->status >= 4) {
            return [0,'已扣款，不能重复扣款'];
        }elseif($info->status < 3){
            return [0,'请先进行入库操作'];
        }
        $lineData = $info->lineData;
        $userData = $info->userData;
        $price = number_format($price,2,'.','');
        //检查用余额
        if ($userData->money < $price){
            return [0,'用户余额不足'];
        }else{
            $consume = [
                'uid'=>$userData->id,
                'name'=>$userData->name,
                'consume_order_no'=> 'C'.date('YmdHis').mt_rand(10000,99999),
                'system_order_no'=>$info->system_order_no,
                'user_order_no'=>$info->user_order_no,
                'money'=>$price,
            ];
            Consume::create($consume);
            $leftMoney = number_format(($userData->money - $price),2,'.','');
            User::where('id',$info->uid)->update(['money'=>$leftMoney]);
        }

        $update['deduct_money'] = $price;
        $update['before_status'] = $info['status'];
        $update['status'] = 4;
        Order::where('id',$info->id)->update($update);
        OrderLog::create(['oid'=>$info->id,'name'=>$userData->name,'status'=>4]);

        DeductLog::create(['order_no'=>$ordor_no,'money'=>$price]);
        return [1,'导入成功'];
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeductLog  $deductLog
     * @return \Illuminate\Http\Response
     */
    public function show(DeductLog $deductLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeductLog  $deductLog
     * @return \Illuminate\Http\Response
     */
    public function edit(DeductLog $deductLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeductLog  $deductLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeductLog $deductLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DeductLog  $deductLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeductLog $deductLog)
    {
        //
    }
}
