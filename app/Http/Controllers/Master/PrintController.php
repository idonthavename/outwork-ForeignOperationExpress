<?php

namespace App\Http\Controllers\Master;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Milon\Barcode\DNS1D;

class PrintController extends Controller
{
    public function index(){
        $print_template = [
            1=>['name'=>'模板1'],
            2=>['name'=>'模板2'],
            3=>['name'=>'模板3'],
        ];
        return view('master.print.index',['print_template'=>$print_template]);
    }

    public function show(Request $request){
        $id = $request->get('id') > 0 ? intval($request->get('id')) : $request->post('id');
        $print = intval($request->get('print'));
        if (is_int($id)){
            $id = explode(',',$id);
        }else{
            $temp = json_decode($id,true);
            $id = [];
            if (isset($temp) && is_array($temp)){
                foreach ($temp as $tval){
                    $id[] = $tval['id'];
                }
            }
        }

        if (isset($id)){
            Order::whereIn('id',$id)->update(['print'=>1]);
            $info = Order::whereIn('id',$id)->get();
        }

        foreach ($info as $key=>$val){
            $template = $val['linetwo'] > 0 ? $val->linetwoData->print_template : die("<script>alert('请选择已关联二级线路的订单');window.close();</script>");
            $val['template'] = isset($template) ? $template : intval($request->get('template',1));

            if (isset($val)){
                $val['products'] = $val->productData;
                foreach ($val['products'] as $pkey=>$pval){
                    $pval['category_one'] = $pval->categoryOne->name;
                    $pval['category_two'] = $pval->categoryTwo->name;
                    $val['products'][$pkey] = $pval;
                }
            }else{
                $val = null;
            }
            $val['barcode'] =  DNS1D::getBarcodePNG(isset($val->system_order_no) ? $val->system_order_no : '123456', "C128",3,100);
            $val['user'] = $val->userData;
            $info[$key] = $val;
        }
        if (count($info) == 0){
            $barcode = DNS1D::getBarcodePNG('123456', "C128",3,100);
            $info = [['template'=>intval($request->get('template',1)),'nodata'=>1]];
        }
        return view('master.print.all',['data'=>$info,'print'=>$print]);
    }
}
