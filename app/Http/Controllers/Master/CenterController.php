<?php

namespace App\Http\Controllers\Master;

use App\Charge;
use App\Consume;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CenterController extends Controller
{
    public function index($type){
        return view('master.center.'.($type == 1 ? 'index' : 'consume'),['type'=>$type]);
    }

    public function getData($type,Request $request){
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));
        $data = $type == 1 ? Charge::whereRaw('1 = 1') : Consume::whereRaw('1 = 1');
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

    public function makeup(){
        return view('master.center.makeup');
    }

    public function makeupAction(Request $request){
        $this->validate($request,[
            'user_identification'=>'required|exists:users',
            'money'=>'nullable|numeric',
        ]);

        $post = $request->post();
        unset($post['_token']);
        $user = User::where('user_identification',$post['user_identification'])->first();
        $userMoney = number_format($user->money + $post['money'],2,'.','');
        if ($userMoney < 0) return response()->json(['status'=>-100,'msg'=>'该用户余额不足']);
        $consume = [
            'uid'=>$user->id,
            'name'=>$user->name,
            'consume_order_no'=> 'C'.date('YmdHis').mt_rand(10000,99999),
            'money'=>$post['money'],
            'type'=>$post['money'] > 0 ? 3 : 2,
            'unionaccount'=>$post['unionaccount'],
            'payaccount'=>$post['payaccount'],
            'remark'=>$post['remark'],
            'handle'=>1,
        ];
        $create = Consume::create($consume);
        if ($create->id){
            User::where('id',$user->id)->update(['money'=>$userMoney]);
            return response()->json(['status'=>200,'msg'=>'保存成功','data'=>$create]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'保存失败']);
        }
    }
}
