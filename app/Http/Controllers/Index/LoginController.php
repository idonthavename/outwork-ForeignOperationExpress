<?php

namespace App\Http\Controllers\Index;

use App\Content;
use App\Http\Requests\wedeportLogin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function show(){
        if (Auth::check()){
            return redirect('/user');
        }
        $output['partner'] = Content::where(['type'=>4,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $output['inform'] = Content::where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->first();
        return view('index.login',$output);
    }

    public function login(Request $request){
        $this->validate($request, [
            'name' => 'bail|required||max:20',
            'password' => 'bail|required|max:50',
            'verifycode' => 'bail|required|captcha',
        ]);

        $name = strip_tags(trim($request->post('name','')));
        $password = strip_tags(trim($request->post('password','')));

        $user = User::where(function ($query) use ($name){
            $query->where('name',$name)->orWhere('email',$name);
        })->first();

        if (!$user) return response()->json(['status'=>-100,'msg'=>'用户名或密码错误']);

        if (Hash::check($password,$user->password)){
            Auth::login($user,true);
            return response()->json(['status'=>200,'msg'=>'登录成功','isMaster'=>($user->id == 1 ? true : false)]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'用户名或密码错误']);
        }

    }
}
