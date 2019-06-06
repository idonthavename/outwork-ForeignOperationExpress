<?php

namespace App\Http\Controllers\Master;

use App\Linetwo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LinetwoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.linetwo.index');
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
        $data = Linetwo::offset(($page-1)*$limit)->limit($limit)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $count = Linetwo::count();
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
            'order'=>'nullable|integer',
            'name'=>'required|between:1,50',
            'money'=>'nullable|numeric',
            'print_template'=>'nullable|integer'
        ]);

        $post = $request->post();
        $post['money'] = number_format($post['money'],2,'.','');
        unset($post['_token']);
        $id = intval($post['id']);
        if ($id){
            $update = Linetwo::where('id',$id)->update($post);
            if ($update){
                return response()->json(['status'=>200,'msg'=>'保存成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }else{
            $create = Linetwo::create($post);
            if ($create->id){
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
        //
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
        $data = Linetwo::where('id',$id)->first();
        if ($request->isXmlHttpRequest()){
            return response()->json(['status'=>200,'msg'=>'Success','data'=>$data]);
        }else{
            $print_template = [
                1=>['name'=>'模板1'],
                2=>['name'=>'模板2'],
                3=>['name'=>'模板3'],
            ];
            return view('master.linetwo.edit',['data'=>$data,'print_template'=>$print_template]);
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
            $destroy = Linetwo::destroy($id);
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
