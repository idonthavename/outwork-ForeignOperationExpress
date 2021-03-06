<?php

namespace App\Http\Controllers\Api;

use App\Order;
use App\OrderLog;
use App\Restful;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Redrain\Express\LaravelExpress;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class IndexController extends Controller
{

    public function __construct()
    {
        // 这里额外注意了：官方文档样例中只除外了『login』
        // 这样的结果是，token 只能在有效期以内进行刷新，过期无法刷新
        // 如果把 refresh 也放进去，token 即使过期但仍在刷新期以内也可刷新
        // 不过刷新一次作废
        $this->middleware('jwt.auth', ['except' => ['accessToken']]);
        // 另外关于上面的中间件，官方文档写的是『auth:api』
        // 但是我推荐用 『jwt.auth』，效果是一样的，但是有更加丰富的报错信息返回
    }

    public function accessToken(Request $request){
        $credentials = $request->only('appKey', 'appSecret');
        try{
            //$token = auth('api')->attempt($credentials);
            $user = Restful::where($credentials)->first();
            $token = JWTAuth::fromUser($user);
            if (!$token){
                return response()->json(['error'=>'invalid_credentials'],401);
            }
        } catch(JWTException $e){
            return response()->json(['error'=>'invalid_credentials'],500);
        }
        $expires_in = 7200;
        return response()->json(compact('token','expires_in'));
    }

    public function expressInfo(Request $request){
        $orders = $data = [];
        $no = $request->post('no','');
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
            $orders = Order::select(['id','system_order_no','express_no','status','created_at'])->whereIn('system_order_no',$no)->get();
            $express = new LaravelExpress();
            $allstatus = ['未审核', '已审核待入库', '已拣货待打包', '已入库代付款', '已付款待出库', '已出库', '已发往起运机场', '飞往中国', '抵达海关，等候清关', '海关清关中', '已出关转国内派送', '已签收', 99 => '异常件'];
            foreach ($orders as $key=>$val){
                $orders[$key]['detail'] = [];
                $orderlogs = OrderLog::select(['status','created_at'])->where('oid',$val['id'])->orderBy('created_at','ASC')->get()->toArray();
                foreach ($orderlogs as $okey=>$oval){
                    $orderlogs[$okey]['status'] = $allstatus[$oval['status']];
                }
                array_unshift($orderlogs,['status'=>'运单创建','created_at'=>Carbon::parse($val['created_at'])->toDateTimeString()]);
                $orders[$key]['logs'] = $orderlogs;
                if ($val['status'] >= 10){
                    $res = json_decode($express->getExpressInfoByNo($val['express_no']),true);
                    if ($res['message'] == 'ok'){
                        $detail = $express->getExpress100Detail($res['com'],$res['nu']);
                        $orders[$key]['detail'] = $detail['data'];
                    }
                }
                unset($orders[$key]['id'],$orders[$key]['status'],$orders[$key]['created_at']);
            }
            $data['status'] = 200;
            $data['msg'] = 'Success';
            $data['orders'] = $orders;
        }else{
            $data['status'] = -200;
            $data['msg'] = '超过允许查询最大数量';
            $data['orders'] = [];
        }
        return response()->json($data);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshToken()
    {
        return $this->respondWithToken(JWTAuth::parseToken()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}
