<?php

namespace App\Http\Controllers\Master;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = Product::orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $count = Product::count();
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
            'parent_id'=>'nullable|integer',
            'name'=>'required|between:1,50',
        ]);

        $post = $request->post();
        unset($post['_token']);
        $id = intval($post['id']);
        if ($id){
            $update = Product::where('id',$id)->update($post);
            if ($update){
                return response()->json(['status'=>200,'msg'=>'保存成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }else{
            $create = Product::create($post);
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
        $data = Product::where('id',$id)->first();
        $parent_id = intval($request->get('parent_id'));
        if ($request->isXmlHttpRequest()){
            return response()->json(['status'=>200,'msg'=>'Success','data'=>$data]);
        }else{
            return view('master.product.edit',['data'=>$data,'parent_id'=>$parent_id]);
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
            $destroy = Product::destroy($id);
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
