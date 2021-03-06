<?php

namespace App\Http\Controllers\Admin;

use App\Sender;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SenderController extends Controller
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
        return view('admin.sender.index');
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
        $data = Sender::where('uid',$this->userid)->offset(($page-1)*$limit)->limit($limit)->orderBy('created_at','DESC')->get();
        foreach ($data as $key=>$val){
            $val['number'] = $key+1;
            $val['area'] = $val['country'].'/'.$val['province'].'/'.$val['city'];
            $data[$key] = $val;
        }
        $count = Sender::where('uid',$this->userid)->count();
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
            'name'=>'required|between:1,100',
            'phone' => 'required|min:10',
            'country' => 'required',
            'province' => 'required',
            'city' => 'required',
            'address' => 'required',
            'code' => 'required',
        ]);

        $post = $request->post();
        unset($post['_token']);
        $id = intval($post['id']);
        if ($id){
            $update = Sender::where('id',$id)->update($post);
            if ($update){
                return response()->json(['status'=>200,'msg'=>'保存成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }else{
            $post['uid'] = $this->userid;
            $create = Sender::create($post);
            if ($create->id){
                unset($create->uid);
                return response()->json(['status'=>200,'msg'=>'保存成功','data'=>$create]);
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
            $data = Sender::where('uid',$this->userid)->where(function ($query) use ($param){
                $query->where('name',$param)->orWhere('phone',$param);
            })->orderBy('isdefault','DESC')->orderBy('created_at','DESC')->offset(($page-1)*5)->limit(5)->get();
            $count = Sender::where('uid',$this->userid)->where(function ($query) use ($param){
                $query->where('name',$param)->orWhere('phone',$param);
            })->count();
        }else{
            $data = Sender::where('uid',$this->userid)->orderBy('isdefault','DESC')->orderBy('created_at','DESC')->offset(($page-1)*5)->limit(5)->get();
            $count = Sender::where('uid',$this->userid)->count();
        }
        return view('admin.sender.choose',['data'=>$data,'count'=>$count,'curr'=>$page,'param'=>$param]);
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
        $data = Sender::where('id',$id)->first();
        if ($request->isXmlHttpRequest()){
            return response()->json(['status'=>200,'msg'=>'Success','data'=>$data]);
        }else{
            return view('admin.sender.edit',['data'=>$data]);
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
            Sender::where(['uid'=>$this->userid,'isdefault'=>1])->update(['isdefault'=>0]);
            Sender::where('id',$id)->update(['isdefault'=>1]);
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
            $destroy = Sender::destroy($id);
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
