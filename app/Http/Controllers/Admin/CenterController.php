<?php

namespace App\Http\Controllers\Admin;

use App\Charge;
use App\Consume;
use App\Content;
use App\Http\Controllers\Helper\HelperController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yuansfer\Yuansfer;
use Yuansfer\Exception\YuansferException;

class CenterController extends Controller
{
    public function index($type){
        $user = Auth::user();
        return view('admin.center.'.($type == 1 ? 'index' : 'consume'),['user'=>$user,'type'=>$type]);
    }

    public function getData($type,Request $request){
        $userid = Auth::id();
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));
        $data = $type == 1 ? Charge::where('uid',$userid) : Consume::where('uid',$userid);
        $acceptParams = ['system_order_no','user_order_no','charge_order_no','type','start','end'];
        foreach ($acceptParams as $val){
            if (!empty($request->get($val))){
                if ($val == 'start'){
                    $data = $data->where('created_at','>=',$request->get($val));
                }elseif ($val == 'end'){
                    $data = $data->where('created_at','<=',$request->get($val));
                }else{
                    $data = $data->where($val,$request->get($val));
                }
            }
        }
        $count = $data->count();
        $outputData = $data->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$outputData,'count'=>$count]);
    }

    public function securepay(Request $request){
        $allowCurrency = ['USD','CAD','CNY'];
        $allowVendor = ['alipay','wechatpay','unionpay'];
        $amount = $request->post('amount') ? number_format($request->post('amount'),'2','.','') : '0.01';
        $currency = in_array($request->post('currency'),$allowCurrency) ? $request->post('currency') : 'USD';
        $vendor = in_array($request->post('vendor'),$allowVendor) ? $request->post('vendor') : 'alipay';
        $micro = intval(microtime(true)*1000);
        $reference = 'CH'.date('YmdH',time()).$micro.rand(100000,999999);
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
            ->setIpnUrl(route('payNotify')) //route('payNotify') // The asynchronous callback method. https only
            ->setCallbackUrl(route('payCallback') . // The Synchronous callback method.
                '?yuansferId={yuansferId}&status={status}&amount={amount}&time={time}&reference={reference}&note={note}'); // query name can change, like: id={yuansferId}&num={amount}

        //optional parameters
        $api->setDescription('description info') // it will be displayed on the card charge  没卵用
            ->setNote(md5($reference.$amount))
            ->setTimeout(120);  // units are minutes, default is 120

        try {
            // send to api get response
            // SecurePay api return html

            $create = [
                'uid'=>Auth::id(),
                'charge_order_no'=>$reference,
                'type'=>$vendor,
                'money'=>$amount,
                'currency'=>$currency,
                'terminal'=>$terminal,
            ];
            Charge::create($create);

            $data = $api->send();
            return $data;
            //$request->session()->put('payHtml',$data);
        } catch (YuansferException $e) {
            // required param is empty
            if ($e instanceof \Yuansfer\Exception\RequiredEmptyException) {
                $message = 'The param: ' . $e->getParam() . ' is empty, in API: ' . $e->getApi();
                return response()->json(['status'=>-100,'msg'=>$message]);
            }

            // http connect error
            if ($e instanceof \Yuansfer\Exception\HttpClientException) {
                $message = $e->getMessage();
                return response()->json(['status'=>-102,'msg'=>$message]);
            }

            // http response status code < 200 or >= 300, 301 and 302 will auto redirect
            if ($e instanceof \Yuansfer\Exception\HttpErrorException) {
                /** @var \Httpful\Response http response */
                $response = $e->getResponse();
                return response()->json(['status'=>-103,'response'=>$response]);
            }
        }
        abort(404);
        //return response()->json(['status'=>200,'msg'=>'Success']);
    }

    public function exchangeRate(){
        $config = $this->__YuansferConfig();
        $yuansfer = new Yuansfer($config);

        if (env('APP_DEBUG')) $yuansfer->setTestMode();

        $api = $yuansfer->createExchangeRate();
        $api->setDate(date('Ymd'))->setCurrency('USD')->setVendor('alipay');
        $exchangeRate = $api->send();
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$exchangeRate]);
    }

    public function showPay(Request $request){
        $payHtml = $request->session()->get('payHtml');
        if (!isset($payHtml) || empty($payHtml)) abort(404,'页面不存在');
        echo $payHtml;
        $request->session()->forget('payHtml');
    }

    public function showInfo(){
        $user = Auth::user();
        $userinfo = $user['type'] == 'personal' ? $user->personalData : $user->companyData;
        $inform = Content::select('title')->where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->first();
        return view('admin.center.userinfo',['type'=>$user['type'],'userinfo'=>$userinfo,'inform'=>$inform]);
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
