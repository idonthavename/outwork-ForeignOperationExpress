<?php

namespace App\Http\Controllers\Index;

use App\Charge;
use App\Content;
use App\Http\Controllers\Helper\HelperController;
use App\Order;
use App\OrderLog;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Redrain\Express\LaravelExpress;
use Yuansfer\Yuansfer;

class IndexController extends Controller
{
    private $partner,$inform;

    public function __construct(){
        $this->partner = Content::where(['type'=>4,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $this->inform = Content::select('title')->where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->first();
    }

    public function index(){
        $banner = Content::where(['type'=>3,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->limit(5)->get();
        $output['banner'] = $banner;
        $output['expert'] = [1,2,3,4];
        $output['partner'] = $this->partner;
        $output['inform'] = $this->inform;
        return view('index.index',$output);
    }

    public function service(){
        $info = Content::where('type',1)->first();
        $output['partner'] = $this->partner;
        $output['inform'] = $this->inform;
        $output['content'] = $info['content'];
        return view('index.service',$output);
    }

    public function charge(){
        $info = Content::where('type',2)->first();
        $output['partner'] = $this->partner;
        $output['inform'] = $this->inform;
        $output['content'] = $info['content'];
        return view('index.charge',$output);
    }

    public function about(){
        $output['partner'] = $this->partner;
        $output['inform'] = $this->inform;
        return view('index.about',$output);
    }

    public function news(){
        $output['data'] = Content::select(['id','title','created_at'])->where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->limit(15)->get();
        $output['inform'] = $this->inform;
        return view('index.news',$output);
    }

    public function newsDetail($id){
        $output['info'] = Content::find($id);
        if (!isset($output['info']) || empty($output['info'])) return redirect()->back();
        $output['inform'] = $this->inform;
        return view('index.newsDetail',$output);
    }

    public function expressResult($no){
        $orders = [];
        $no = str_replace('，',',',strip_tags($no));
        $no = explode(',',$no);
        $limit = count($no) > 20 ? 0 : 1;
        if ($limit){
            foreach ($no as $key=>$val){
                if (!preg_match_all('/^[W][0-9]{19}$/',$val)){
                    unset($no[$key]);
                }
            }

            $no = array_values($no);
            $orders = Order::select(['id','system_order_no','express_no','status','updated_at'])->whereIn('system_order_no',$no)->get();
            $express = new LaravelExpress();
            $allstatus = ['未审核', '已审核待入库', '已拣货待打包', '已入库代付款', '已付款待出库', '已出库', '已发往起运机场', '飞往中国', '抵达海关，等候清关', '海关清关中', '已出关转国内派送', '已签收', 99 => '异常件'];
            $jumpUrl = HelperController::isMobile() ? 'https://m.kuaidi100.com/index_all.html?type={com}&postid={nu}' : 'https://www.kuaidi100.com/chaxun?com={com}&nu={nu}';
            foreach ($orders as $key=>$val){
                $orders[$key]['logs'] = OrderLog::select(['name','status','created_at'])->where('oid',$val['id'])->orderBy('created_at','DESC')->get()->toArray();
                $res = json_decode($express->getExpressInfoByNo($val['express_no']),true);
                if ($res['message'] <> 'ok' || $val['status'] < 10){
                    $orders[$key]['link'] = false;
                    continue;
                }
                $orders[$key]['link'] = str_replace(['{com}','{nu}'],[$res['com'],$res['nu']],$jumpUrl);
            }
        }
        $output['orders'] = $orders;
        $output['inform'] = $this->inform;
        $output['limit'] = $limit;
        $output['allstatus'] = $allstatus;
        return view('index.expressResult',$output);
    }

    public function identification(Request $request){
        if ($request->get('token')){
            $token = Crypt::decrypt($request->get('token'));
            if (!$token['id'] || !$token['type'] || Carbon::now()->timestamp - $token['timestamp'] > 86400) return redirect()->back();
            $output['type'] = $token['type'];
            $output['data'] = Order::find($token['id']);
        }
        $output['inform'] = $this->inform;
        $output['nowStep'] = intval($request->get('nowStep',1));
        $output['titles'] = ["快件信息","补充身份证信息及在线缴税","完成"];
        return view('index.identification',$output);
    }

    public function postIdentification(Request $request){
        if ($request->get('token')){
            $this->validate($request,[
                'id_card_front' => 'required|image',
                'id_card_back' => 'required|image',
            ]);
            $token = Crypt::decrypt($request->get('token'));
            if (!$token['id'] || !$token['type'] || Carbon::now()->timestamp - $token['timestamp'] > 86400) return redirect()->back();
            if ($token['type'] == 'goidentification'){      //上传身份证等信息
                $path = date('y').'/'.date('m').'/'.date('d');
                $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
                if ($request->hasFile('id_card_front') && $request->file('id_card_front')->isValid()){
                    if (!in_array($request->file('id_card_front')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                    if ($request->file('id_card_front')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                    $fontExt = $request->file('id_card_front')->extension();
                    $post['id_card_front'] = $request->file('id_card_front')->store($path);
                }
                if ($request->hasFile('id_card_back') && $request->file('id_card_back')->isValid()){
                    if (!in_array($request->file('id_card_back')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                    if ($request->file('id_card_back')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                    $backExt = $request->file('id_card_back')->extension();
                    $post['id_card_back'] = $request->file('id_card_back')->store($path);
                }
                Order::where('id',$token['id'])->update($post);
            }
            return response()->json(['status'=>200,'msg'=>'success']);
        }else{
            $this->validate($request,[
                'system_order_no' => 'required|min:20',
                'r_name' => 'required|string|between:1,10',
                'r_phone' => 'required|numeric|min:11',
            ]);

            $where['system_order_no'] = $request->post('system_order_no');
            $where['r_name'] = $request->post('r_name');
            $where['r_phone'] = $request->post('r_phone');
            $info = Order::select(['id','id_card_front','id_card_back','tax','status'])->where($where)->first();
            if (!isset($info->id)) return response()->json(['status'=>-100,'msg'=>'此运单不存在，请确认输入信息是否无误']);
            $type = $routename = Route::currentRouteName();
            if ($routename == 'goidentification'){
                if ($info->id_card_front || $info->id_card_back) return response()->json(['status'=>-100,'msg'=>'运单身份证信息已完善']);
            }elseif ($routename == 'gotax'){
                if ($info->status <> 99 || $info->tax <= 0) return response()->json(['status'=>-100,'msg'=>'运单无需缴纳税金']);
            }

            $token = urlencode(Crypt::encrypt([
                'id'=>$info->id,
                'type'=>$type,
                'timestamp'=>Carbon::now()->timestamp,
            ]));
            $url = ($type == 'gotax' ? url('/tax') : url('/identification')).'?nowStep=2&token='.$token;
            return response()->json(['status'=>200,'msg'=>'success','url'=>$url]);
        }
    }

    public function taxPay(Request $request){
        $token = Crypt::decrypt($request->get('token'));
        if (!$token['id'] || !$token['type'] || Carbon::now()->timestamp - $token['timestamp'] > 86400) return redirect()->back();
        $info = Order::find($token['id']);
        $allowCurrency = ['USD','CAD','CNY'];
        $allowVendor = ['alipay','wechatpay','unionpay'];
        $amount = $info['tax'];
        $currency = 'USD';
        $vendor = in_array($request->get('vendor'),$allowVendor) ? $request->get('vendor') : 'alipay';
        $reference = $info['system_order_no'];
        $terminal = HelperController::isMobile() ? 'WAP' : 'ONLINE';

        $config = $this->__YuansferConfig();
        $yuansfer = new Yuansfer($config);

        if (env('APP_DEBUG')) $yuansfer->setTestMode();

        $api = $yuansfer->createSecurePay();

        $api
            ->setAmount($amount) //The amount of the transaction.
            ->setCurrency($currency) // The currency, USD, CAD supported yet.
            ->setVendor($vendor) // The payment channel, alipay, wechatpay, unionpay, enterprisepay are supported yet.
            ->setTerminal($terminal) // ONLINE, WAP
            ->setReference($reference) //The unque ID of client’s system.
            ->setIpnUrl(route('webPayNotify')) //route('webPayNotify') // The asynchronous callback method. https only
            ->setCallbackUrl(route('payCallback') . // The Synchronous callback method.
                '?yuansferId={yuansferId}&status={status}&amount={amount}&time={time}&reference={reference}&note={note}'); // query name can change, like: id={yuansferId}&num={amount}

        //optional parameters
        $api->setDescription('description info') // it will be displayed on the card charge  没卵用
        ->setNote(md5($reference.$amount))
            ->setTimeout(120);  // units are minutes, default is 120

        try {
            // send to api get response
            // SecurePay api return html
            $data = $api->send();

            echo $data;

        } catch (YuansferException $e) {
            // required param is empty
            if ($e instanceof \Yuansfer\Exception\RequiredEmptyException) {
                echo $message = 'The param: ' . $e->getParam() . ' is empty, in API: ' . $e->getApi();
            }

            // http connect error
            if ($e instanceof \Yuansfer\Exception\HttpClientException) {
                echo $message = $e->getMessage();
            }

            // http response status code < 200 or >= 300, 301 and 302 will auto redirect
            if ($e instanceof \Yuansfer\Exception\HttpErrorException) {
                /** @var \Httpful\Response http response */
                echo $response = $e->getResponse();
            }
        }
    }

    public function payCallback(Request $request){
        $data = $request->all();
        $res = $this->__YuansferPay($data);
        $output['status'] = 'fail';
        $output['detail'] = $data;
        switch ($res){
            case 'success':
                $output['msg'] = '充值成功';
                $output['status'] = $res;
                break;
            case -100:
                $output['msg'] = 'sign认证失败';
                break;
            case -101:
                $output['msg'] = '充值失败';
                break;
        }
        return view('admin.center.payinfo',$output);
    }

    public function payNotify(Request $request){
        $config = $this->__YuansferConfig();
        $yuansfer = new Yuansfer($config);
        //验证是否ipn请求
        if (!$yuansfer->verifyIPN()) abort(404);
        Log::notice($request);
        $data = $request->post();
        $res = $this->__YuansferPay($data,true);
        echo $res == 'success' ? $res : 'fail';
    }

    public function webPayNotify(Request $request){
        $config = $this->__YuansferConfig();
        $yuansfer = new Yuansfer($config);
        //验证是否ipn请求
        if (!$yuansfer->verifyIPN()) abort(404);
        Log::notice($request);
        $data = $request->post();
        $res = $this->__YuansferPay($data,false,true);
        echo $res == 'success' ? $res : 'fail';
    }

    private function __YuansferPay($data, $isStore = false, $isOutTax = false){
        $status = $data['status'];
        $reference = $data['reference'];
        if (isset($status) && $status === 'success') {
            $amount = $data['amount'];
            $note = md5($reference.$amount);
            if ($note == $data['note']){
                //是否保存相关信息和更新用户金额
                if ($isStore){
                    $charge = Charge::where('charge_order_no',$reference);
                    $info = $charge->first();
                    if ($info->status == 0){  //检查该订单是否未成功支付过
                        $charge->update(['yuansferId'=>$data['yuansferId'],'status'=>1]);
                        $user = User::find($info->uid);
                        $userMoney = number_format($user->money + $amount,2,'.','');
                        User::where('id',$user->id)->update(['money'=>$userMoney]);
                    }
                }
                if ($isOutTax){
                    $consume = [
                        'consume_order_no'=> 'C'.date('YmdHis').mt_rand(10000,99999),
                        'system_order_no'=>$reference,
                        'money'=>$amount,
                        'remark'=>'税金',
                    ];
                    Consume::create($consume);
                    $info = Order::select(['id','status'])->where('system_order_no',$reference)->first();
                    if ($info->status == 99){
                        $update['before_status'] = 99;
                        $update['status'] = $info->before_status;
                        $orderUpdate = Order::where('id',$info->id)->update($update);
                        if (!$orderUpdate) return -102;
                    }
                }
                return 'success';
            }else{
                Log::error('Pay failed：'.$reference.'sign验证失败');
                return -100;
            }
        } else {
            Log::error('Pay failed：'.$reference.'支付失败');
            return -101;
        }
    }

    private function __YuansferConfig(){
        $isTest = env('APP_DEBUG') ? '_TEST' : '';
        return [
            Yuansfer::MERCHANT_NO => env('YUAN_MERCHANTNO'.$isTest),
            Yuansfer::STORE_NO => env('YUAN_STORENO'.$isTest),
            Yuansfer::API_TOKEN => env('YUAN_TOKEN'.$isTest),
            Yuansfer::TEST_API_TOKEN => env('YUAN_TOKEN_TEST'),
        ];
    }
}
