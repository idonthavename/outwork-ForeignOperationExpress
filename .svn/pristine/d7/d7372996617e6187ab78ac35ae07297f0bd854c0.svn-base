<?php

namespace App\Http\Controllers\Master;

use App\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $type = intval($request->post('type',3));
        $data = Content::where('type',$type)->offset(($page-1)*$limit)->limit($limit)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $count = Content::count();
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
        $type = intval($request->post('type'));
        if ($type && $type <=2){
            $isok = Content::updateOrCreate(['type'=>$type],['content'=>$request->post('content')]);
            $isok ? $request->session()->flash('ueditor-success','保存成功') : $request->session()->flash('ueditor-error','保存失败');
            return redirect()->back();
        }else{
            $this->validate($request,[
                'title'=>'required|between:1,50',
                'type'=>'required|integer',
                'link' => 'nullable|max:200',
                'order' => 'required|integer',
                'isban' => 'nullable|string',
            ]);
            $post = $request->post();
            $post['isban'] = isset($post['isban']) && $post['isban'] == 'on' ? 1 : 0;
            $path = date('y').'/'.date('m').'/'.date('d');
            $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
            if ($request->hasFile('thumb') && $request->file('thumb')->isValid()){
                if (!in_array($request->file('thumb')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($request->file('thumb')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                $post['thumb'] = $request->file('thumb')->store($path);
            }else{
                unset($post['thumb']);
            }
            unset($post['_token']);
            $id = intval($post['id']);
            if ($id){
                $update = Content::where('id',$id)->update($post);
                if ($update){
                    return response()->json(['status'=>200,'msg'=>'保存成功',]);
                }else{
                    return response()->json(['status'=>-100,'msg'=>'保存失败']);
                }
            }else{
                $create = Content::create($post);
                if ($create->id){
                    return response()->json(['status'=>200,'msg'=>'保存成功','data'=>$create->id]);
                }else{
                    return response()->json(['status'=>-100,'msg'=>'保存失败']);
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($type)
    {
        if ($type && $type <= 2){
            $info = Content::where('type',$type)->first();
            return view('master.content.sorc',['type'=>$type,'content'=>$info['content']]);
        }else{
            $typeArray = [3=>'banner',4=>'合作伙伴',5=>'公告'];
            $output['typeTitle'] = $typeArray[$type];
            $output['type'] = $type;
            return view('master.content.list',$output);
        }
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
        $type = intval($request->get('type'));
        $data = Content::find($id);
        return view('master.content.edit',['data'=>$data,'type'=>$type]);
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
        //
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
            $destroy = Content::destroy($id);
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
