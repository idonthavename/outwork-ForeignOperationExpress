<?php

namespace App\Http\Controllers\Index;

use App\CompanyInformation;
use App\Content;
use App\Http\Controllers\Helper\HelperController;
use App\PersonalInformation;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    private $output,$trans,$user;

    public function __construct(){
        $pathArray = explode('/',url()->current());
        $step =  strtolower($pathArray[4]);
        $this->trans = ['one'=>1,'two'=>2,'three'=>3,'four'=>4,'five'=>5,'six'=>6];
        $this->output['nowStep'] = $this->trans[$step];
        $this->output['type'] = $pathArray[5];
        $this->output['titles'] = ["填写注册信息","验证注册邮箱","完善".($pathArray[5] == 'personal' ? '个人' : '企业')."信息","上传证件","签署授权","等待确认"];
        $this->output['inform'] = Content::select('title')->where(['type'=>5,'isban'=>'0'])->orderBy('order','DESC')->orderBy('created_at','DESC')->first();
    }

    public function stepOne(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register1',$this->output);
    }

    public function postStepOne(Request $request){
        $this->validate($request,[
            'name' => 'bail|required||max:20|unique:users',
            'password' => 'bail|required|between:6,20',
            'password_confirmation' => 'bail|required|same:password',
            'email' => 'bail|required|email|unique:users',
            'xing' => 'bail|required|max:100',
            'ming' => 'bail|required|max:100',
            'verifycode' => 'bail|required|captcha',
        ]);

        $insert['name'] = strip_tags(trim($request->post('name','')));
        $insert['type'] = $this->output['type'];
        $insert['password'] = Hash::make(strip_tags(trim($request->post('password',''))));
        $insert['email'] = strip_tags(trim($request->post('email','')));
        $insert['xing'] = strip_tags(trim($request->post('xing','')));
        $insert['ming'] = strip_tags(trim($request->post('ming','')));
        $insert['user_identification'] = HelperController::get62($insert['email']);

        $user = User::create($insert);
        if ($user){
            Auth::login($user,true);
            return response()->json(['status'=>200,'msg'=>'注册成功']);
        }else{
            return response()->json(['status'=>-100,'msg'=>'注册失败，请联系管理员']);
        }
    }

    public function stepTwo(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register2',$this->output);
    }

    public function postStepTwo(Request $request){
        $this->validate($request,[
            'emailverifycode'=>'required||max:10'
        ]);
        $emailverifycode = strip_tags(trim($request->post('emailverifycode','')));
        $sessionCode = $request->session()->get('email-verifycode','');
        if ($emailverifycode == $sessionCode){
            User::where('id',Auth::id())->update(['step'=>$this->output['nowStep']+1]);
            return response()->json(['status'=>200,'msg'=>'验证成功']);
        }else{
            return response()->json(['status'=>-100,'msg'=>'邮箱验证码错误或者失效，请重新获取']);
        }
    }

    public function stepThree(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register3',$this->output);
    }

    public function postStepThree(Request $request){
        if ($this->output['type'] == 'personal'){
            $this->validate($request,[
                'sender_xing' => 'required|between:1,100',
                'sender_ming' => 'required|between:1,100',
                'sender_city' => 'required',
                'sender_area' => 'required',
                'sender_paperType' => 'required',
                'sender_paperNo' => 'required|between:1,200',
                'sender_quitAddress' => 'required|between:1,200',
                'sender_quitCode' => 'required|between:1,100',
                'sender_phone' => 'required|numeric|min:10',

                'receive_country' => 'required|string',
                'receive_name' => 'required|string|between:1,10',
                'receive_address' => 'required|string|between:1,200',
                'receive_code' => 'required|string',
                'receive_phone' => 'required|numeric|min:10',
            ]);
        }else{
            $this->validate($request,[
                'company_city' => 'required',
                'company_area' => 'required',
                'company_name' => 'required',
                'company_address' => 'required|between:1,200',
                'company_delegate' => 'required',
                'company_yy' => 'required|min:6|string',
                'company_sh' => 'required|min:6|string',
                'company_quitAddress' => 'required|between:1,200',
                'company_quitCode' => 'required',
                'company_phone' => 'required|numeric|min:10',
                'company_contact' => 'required|string',
            ]);
        }

        $post = $request->post();
        unset($post['_token']);

        $request->session()->put('registerData',$post);

        return response()->json(['status'=>200,'msg'=>'验证成功']);
    }

    public function stepFour(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register4',$this->output);
    }

    public function postStepFour(Request $request){
        $this->validate($request,[
            'sfz' => 'required|image',
        ]);
        $files = ['sfz','xyk','sdm'];
        $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
        $path = date('y').'/'.date('m').'/'.date('d');
        foreach ($files as $val){
            if ($request->hasFile($val) && $request->file($val)->isValid()){
                $file = $request->file($val);
                if (!in_array($file->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($file->getSize() > 2*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于2M图片']);
                $uploading[$val] = $request->file($val)->store($path);
            }
        }
        if (is_array($uploading) && $uploading && isset($uploading)){
            $session = $request->session()->get('registerData');
            $session = array_merge($session,$uploading);
            $session['uid'] = Auth::id();
            if ($this->output['type'] == 'personal'){
                PersonalInformation::create($session);
            }else{
                CompanyInformation::create($session);
            }
            User::where('id',Auth::id())->update(['step'=>$this->output['nowStep']+1]);
            $request->session()->forget('registerData');
            //$session['uploading'] = $uploading;
            //$request->session()->flash('registerData',$session);
            return response()->json(['status'=>200,'msg'=>'上传成功']);
        }
        return response()->json(['status'=>-100,'msg'=>'上传失败']);
    }

    public function stepFive(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register5',$this->output);
    }

    public function postStepFive(){
        User::where('id',Auth::id())->update(['step'=>$this->output['nowStep']+1]);
        return response()->json(['status'=>200,'msg'=>'完成注册']);
    }

    public function stepSix(){
        if ($jump = $this->__checkStep()) return redirect($jump);
        return view('index.register6',$this->output);
    }

    public function sendEmail(Request $request){
        $this->user = Auth::user();
        if($this->user->step == 2){
            $sessionCodeTime = $request->session()->get('email-verifycode-time','');
            if ($sessionCodeTime && time() - $sessionCodeTime < 60) return response()->json(['status'=>-100,'msg'=>'亲，间隔60秒才能发送哦']);
            $rand = mt_rand(10000,99999);
            $request->session()->flash('email-verifycode', $rand);
            $request->session()->flash('email-verifycode-time', time());

            /*Mail::raw('恭喜您注册成功，验证码：'.$rand , function ($message){
                $user = Auth::user();
                $message->subject('Wedepot国际物流');
                $message->to($this->user->email);
                $message->cc('13719686813@163.com');
            });*/

            Mail::send('index.verifyEmail',['user'=>$this->user,'rand'=>$rand],function($message){
                $message->to($this->user->email)->cc('13719686813@163.com')->subject('Wedepot国际物流');
            });
            //return view('index.verifyEmail',['user'=>$this->user,'rand'=>$rand]);
        }
        return response()->json(['status'=>200,'msg'=>'发送成功']);
    }

    public function __checkStep(){
        if (Auth::check()){
            $user = Auth::user();
            $toStep = array_search($user->step,$this->trans);
            if ($user->step > $this->output['nowStep']) return '/register/'.$toStep.'/'.$this->output['type'];
        }
    }
}
