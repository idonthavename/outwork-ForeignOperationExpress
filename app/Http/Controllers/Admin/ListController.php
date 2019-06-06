<?php

namespace App\Http\Controllers\Admin;

use App\Consume;
use App\Line;
use App\Order;
use App\OrderProduct;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Redrain\Express\LaravelExpress;

class ListController extends Controller
{

    private $userid;
    private $allstatus;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::id();
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
            return $next($request);
        });
    }

    public function index($status){
        $output['status'] = $status;
        $output['allstatus'] = $this->allstatus;
        $output['line'] = Line::select(['id','name'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        return view('admin.list.index',$output);
    }

    public function getData($status,Request $request){
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));

        $data = Order::where('uid',$this->userid);
        if ($status > 0) $data = $data->where('status',$status-1);
        $acceptParams = ['system_order_no','s_name','r_name','r_phone','user_order_no','line_id','r_cre_num_status','id_card_thumb_status','start','end','status'];
        foreach ($acceptParams as $val){
            if (!empty($request->get($val))){
                if ($val == 'start'){
                    $data = $data->where('created_at','>=',$request->get($val));
                }elseif ($val == 'end'){
                    $data = $data->where('created_at','<=',$request->get($val));
                }elseif ($val == 'r_cre_num_status'){
                    $data = $request->get($val) == 1 ? $data->whereNotNull('r_cre_num') : $data->whereNull('r_cre_num');
                }elseif ($val == 'id_card_thumb_status'){
                    $data = $request->get($val) == 1 ? $data->whereNotNull('id_card_front')->whereNotNull('id_card_back') : $data->whereNull('id_card_front')->whereNull('id_card_back');
                }elseif ($val == 'system_order_no'){
                    $system_order_no = explode("\n",$request->get($val));
                    if (count($system_order_no) == 1){
                        $data = $data->where('system_order_no','like','%'.$system_order_no[0].'%');
                    }else{
                        $data = $data->whereIn('system_order_no',$system_order_no);
                    }
                }else{
                    if (is_int($request->get($val))){
                        $data = $data->where($val,$request->get($val));
                    }else{
                        $data = $data->where($val,'like','%'.$request->get($val).'%');
                    }
                }
            }
        }
        $count = $data->count();
        $outputData = $data->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        $lineData = Line::select(['id','name'])->where('isban','0')->get()->keyBy('id')->toArray();
        foreach ($outputData as $key=>$val){
            $val['number'] = $key+1;
            $val['statustr'] = $this->allstatus[$val['status']];
            $products = OrderProduct::select(['category_one','category_two'])->where('system_order_no',$val['system_order_no'])->get();
            $productsContent = '';
            foreach ($products as $pval){
                if (isset($pval->categoryOne->name) && isset($pval->categoryTwo->name)){
                    $productsContent .= $pval->categoryOne->name.' / '.$pval->categoryTwo->name.'<br>';
                }else{
                    $productsContent .= '无';
                }
            }
            $val['productsContent'] = $productsContent;
            $val['line'] = isset($lineData[$val['line_id']]) ? $lineData[$val['line_id']]['name'] : '';
            $outputData[$key] = $val;
        }
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$outputData,'count'=>$count]);
    }

    public function userConfirmError(Request $request){
        $id = intval($request->post('id'));
        $info = Order::find($id);
        $userData = $info->userData;

        //检查用余额
        if ($userData->money < $info->tax){
            return json_encode(['status'=>-101,'msg'=>'抱歉，您的余额不足请及时充值']);
        }else{
            $consume = [
                'uid'=>$userData->id,
                'name'=>$userData->name,
                'consume_order_no'=> 'C'.date('YmdHis').mt_rand(10000,99999),
                'system_order_no'=>$info->system_order_no,
                'user_order_no'=>$info->user_order_no,
                'money'=>$info->tax,
                'remark'=>'税金',
            ];
            Consume::create($consume);
            $leftMoney = number_format(($userData->money - $info->tax),2,'.','');
            User::where('id',$info->uid)->update(['money'=>$leftMoney]);
        }

        $update['before_status'] = 99;
        $update['status'] = $info->before_status;
        $orderUpdate = Order::where('id',$id)->update($update);
        if ($orderUpdate){
            return json_encode(['status'=>200,'msg'=>'处理成功']);
        }else{
            return json_encode(['status'=>-100,'msg'=>'处理失败']);
        }
    }

    public function showExpress(Request $request){
        $express = new LaravelExpress();
        $res = json_decode($express->getExpressInfoByNo($request->get('no')),true);
        if ($res['message'] <> 'ok') die($res['message']);
        return redirect('https://www.kuaidi100.com/chaxun?com='.$res['com'].'&nu='.$res['nu']);
    }
}
