<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    private $output;

    public function index(){
        $this->output['user'] = Auth::user();
        return view('admin.index',$this->output);
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
    }

    public function reset(){
        return view('admin.resetpassword');
    }

    public function postReset(Request $request){
        $this->validate($request,[
           'oldpassword'=>'required|between:6,20',
            'newpassword' => 'required|between:6,20',
            'newpassword_confirmation' => 'required|same:newpassword',
            'verifycode' => 'required|captcha',
        ]);
        $user = Auth::user();
        $oldpassword = $request->post('oldpassword','');
        $newpassword = strip_tags(trim($request->post('newpassword','')));
        if (Hash::check($oldpassword,$user->password)){
            $new = Hash::make($newpassword);
            User::where('id',$user->id)->update(['password'=>$new]);
            return response()->json(['status'=>200,'保存成功']);
        }else{
            return response()->json(['status'=>-100,'原密码错误']);
        }
    }
}
