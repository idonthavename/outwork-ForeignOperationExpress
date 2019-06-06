<?php

namespace App\Http\Controllers\Master;

use App\Content;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        return view('master.user.index');
    }

    public function getData(Request $request){
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));
        $data = User::whereRaw('1 = 1');
        $acceptParams = ['name','email','user_identification','type','start','end'];
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

    public function showInfo(Request $request){
        $id = intval($request->get('id'));
        $user = User::find($id);
        $userinfo = $user['type'] == 'personal' ? $user->personalData : $user->companyData;
        $inform = Content::select('title')->where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->first();
        return view('admin.center.userinfo',['type'=>$user['type'],'userinfo'=>$userinfo,'inform'=>$inform]);
    }

    public function active(Request $request){
        $active = intval($request->post('active')) == 1 ? 0 : 1;
        $id = intval($request->get('id'));
        if (User::where('id',$id)->update(['active'=>$active]))
            return response()->json(['status'=>200,'msg'=>'保存成功',]);

        return response()->json(['status'=>-100,'msg'=>'保存失败',]);
    }

    public function changeRank(){
        return view('master.user.changeRank');
    }

    public function postChangeRank(Request $request){
        $this->validate($request,[
            'ids'=>'required|string',
            'rank'=>'required|integer',
        ]);

        $post = $request->post();
        $post['ids'] = explode(',',$post['ids']);
        $post['rank'] = in_array($post['rank'],[1,2,3,4,5]) ? $post['rank'] : 1;
        foreach ($post['ids'] as $val){
            User::where('id',$val)->update(['rank'=>$post['rank']]);
        }
        return response()->json(['status'=>200,'msg'=>'保存成功',]);
    }

    public function resetPassword(){
        return view('master.user.resetpassword');
    }

    public function postResetPassword(Request $request){
        $this->validate($request,[
            'newpassword' => 'required|between:6,20',
            'newpassword_confirmation' => 'required|same:newpassword',
        ]);
        $id = intval($request->post('id','0'));
        if (!$id) return response()->json(['status'=>-100,'msg'=>'请选择用户']);
        $newpassword = strip_tags(trim($request->post('newpassword','')));
        $new = Hash::make($newpassword);
        $updated = User::where('id',$id)->update(['password'=>$new]);
        if ($updated){
            return response()->json(['status'=>200,'msg'=>'保存成功']);
        }else{
            return response()->json(['status'=>-100,'msg'=>'保存失败']);
        }
    }
}
