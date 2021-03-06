<?php

namespace App\Http\Controllers\Admin;

use App\Receiver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReceiverController extends Controller
{
    private $userid;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::id();
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.receiver.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $page = intval($request->post('page',10));
        $limit = intval($request->post('limit',10));
        $data = Receiver::where('uid',$this->userid)->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        foreach ($data as $key=>$val){
            $val['number'] = $key+1;
            $val['id_card_front'] = '<img src="'.($val['id_card_front'] ? '/uploads/'.$val['id_card_front'] : '/images/pho_front.png').'" style="display: inline-block; width: 100px;">';
            $val['id_card_back'] = '<img src="'.($val['id_card_back'] ? '/uploads/'.$val['id_card_back'] : '/images/pho_front.png').'" style="display: inline-block; width: 100px;">';
            $data[$key] = $val;
        }
        $count = Receiver::where('uid',$this->userid)->count();
        return response()->json(['status'=>200,'msg'=>'Success','data'=>$data,'count'=>$count]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|between:1,10',
            'phone' => 'required|min:11',
            'cre_type' => 'required|integer',
            'cre_num' => 'required',
            'province' => 'required',
            'city' => 'required',
            'town' => 'required',
            'addressDetail' => 'required',
            'code' => 'required',
            'line_id' => 'nullable|integer',
        ]);

        $post = $request->post();
        $path = date('y').'/'.date('m').'/'.date('d');
        $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
        if ($request->hasFile('id_card_front') && $request->file('id_card_front')->isValid()){
            if (!in_array($request->file('id_card_front')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
            if ($request->file('id_card_front')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
            $fontExt = $request->file('id_card_front')->extension();
            $post['id_card_front'] = $request->file('id_card_front')->store($path);
        }else{
            unset($post['id_card_front']);
        }
        if ($request->hasFile('id_card_back') && $request->file('id_card_back')->isValid()){
            if (!in_array($request->file('id_card_back')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
            if ($request->file('id_card_back')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
            $backExt = $request->file('id_card_back')->extension();
            $post['id_card_back'] = $request->file('id_card_back')->store($path);
        }else{
            unset($post['id_card_back']);
        }
        unset($post['_token']);
        $id = intval($post['id']);
        if ($id){
            $update = Receiver::where('id',$id)->update($post);
            if ($update){
                return response()->json(['status'=>200,'msg'=>'保存成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }else{
            $post['uid'] = $this->userid;
            $create = Receiver::create($post);
            if ($create->id){
                return response()->json(['status'=>200,'msg'=>'保存成功','data'=>$create->id]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = explode('-',$id);
        $page = intval($id[0]);
        $param = !empty($id[1]) ? $id[1] : '';
        if ($param){
            $data = Receiver::where('uid',$this->userid)->where(function ($query) use ($param){
                $query->where('name',$param)->orWhere('phone',$param);
            })->orderBy('isdefault','DESC')->orderBy('created_at','DESC')->offset(($page-1)*5)->limit(5)->get();
            $count = Receiver::where('uid',$this->userid)->where(function ($query) use ($param){
                $query->where('name',$param)->orWhere('phone',$param);
            })->count();
        }else{
            $data = Receiver::where('uid',$this->userid)->orderBy('isdefault','DESC')->orderBy('created_at','DESC')->offset(($page-1)*5)->limit(5)->get();
            $count = Receiver::where('uid',$this->userid)->count();
        }
        return view('admin.receiver.choose',['data'=>$data,'count'=>$count,'curr'=>$page,'param'=>$param]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
        $id = intval($id);
        $data = null;
        if ($id) $data = Receiver::where('id',$id)->first();
        $line = [0=>'默认邮寄线路',19=>'优选EMS个人快件',18=>'EMS个人快件',12=>'顺丰个人快件',11=>'香港E特快'];
        if ($request->isXmlHttpRequest()){
            return response()->json(['status'=>200,'msg'=>'Success','data'=>$data]);
        }else {
            return view('admin.receiver.edit', ['data' => $data, 'line' => $line]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $id = intval($id);
        if ($id){
            Receiver::where(['uid'=>$this->userid,'isdefault'=>1])->update(['isdefault'=>0]);
            Receiver::where('id',$id)->update(['isdefault'=>1]);
            return response()->json(['status'=>200,'msg'=>'保存成功',]);
        }
        return response()->json(['status'=>-100,'msg'=>'保存失败']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = intval($id);
        if ($id){
            $destroy = Receiver::destroy($id);
            if ($destroy){
                return response()->json(['status'=>200,'msg'=>'删除成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'删除失败']);
            }
        }else{
            return response()->json(['status'=>-100,'msg'=>'抱歉，丢失参数']);
        }
    }
}
