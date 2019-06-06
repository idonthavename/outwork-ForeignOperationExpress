<?php

namespace App\Http\Controllers\Admin;

use App\Line;
use App\Order;
use App\OrderProduct;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index(){
        $output['lineData'] = Line::select(['id','name','ordersExcel'])->where('isban','0')->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        return view('admin.orders.index',$output);
    }

    public function upload(Request $request){
        $this->validate($request,[
            'excel'=>'required|file'
        ]);

        $allowTypes = ['xls','xlsx'];
        $excel = $request->file('excel');
        $line_id = intval($request->post('line_id'),0);
        $existLine = Line::find($line_id);
        if (!$line_id || !isset($existLine->id)) return response(['status'=>-100,'msg'=>'请先选择路线']);
        if (in_array(strtolower($excel->getClientOriginalExtension()),$allowTypes)){
            if ($excel->getSize() > 2*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于2M文件']);
            require_once(base_path() . '/app/libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
            $reader = \PHPExcel_IOFactory::createReader('Excel2007');
            $PHPExcel = $reader->load($excel->path()); // 载入excel文件
            $sheet = $PHPExcel->getSheet(0);// 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
            $data_num = 0;
            $oknum = 0;
            $data = [];
            $outputErrors = [];
            for ($row = 4; $row <= $highestRow; $row++) {//行数是以第1行开始
                $user_order_no = $sheet->getCell('A' . $row)->getValue();
                if (isset($user_order_no) && !empty($user_order_no)){
                    $data[$user_order_no]['user_order_no'] = $sheet->getCell('A' . $row)->getValue();
                    $data[$user_order_no]['r_name'] = $sheet->getCell('B' . $row)->getValue();
                    $data[$user_order_no]['r_cre_type'] = 1;
                    $data[$user_order_no]['r_cre_num'] = $sheet->getCell('C' . $row)->getValue();
                    $data[$user_order_no]['r_code'] = $sheet->getCell('D' . $row)->getValue();
                    $data[$user_order_no]['r_province'] = $sheet->getCell('E' . $row)->getValue();
                    $data[$user_order_no]['r_city'] = $sheet->getCell('F' . $row)->getValue();
                    $data[$user_order_no]['r_town'] = $sheet->getCell('G' . $row)->getValue();
                    $data[$user_order_no]['r_addressDetail'] = $sheet->getCell('H' . $row)->getValue();
                    $data[$user_order_no]['r_phone'] = $sheet->getCell('I' . $row)->getValue();

                    $data[$user_order_no]['s_name'] = $sheet->getCell('R' . $row)->getValue();
                    $data[$user_order_no]['s_address'] = $sheet->getCell('S' . $row)->getValue();
                    $data[$user_order_no]['s_country'] = 'U.S.A';
                    $data[$user_order_no]['s_province'] = $sheet->getCell('T' . $row)->getValue();
                    $data[$user_order_no]['s_city'] = $sheet->getCell('U' . $row)->getValue();
                    $data[$user_order_no]['s_phone'] = $sheet->getCell('V' . $row)->getValue();
                    $data[$user_order_no]['s_code'] = $sheet->getCell('W' . $row)->getValue();
                    $data[$user_order_no]['depot'] = $sheet->getCell('X' . $row)->getValue();
                    $data[$user_order_no]['addons'] = $sheet->getCell('Y' . $row)->getValue();
                    $data[$user_order_no]['row'] = $row;
                    $data[$user_order_no]['products'][] = $this->__combon($sheet,$row);
                }
                $data_num++;
            }
            if ($data_num < 1) return response(['status'=>-100,'msg'=>'请填写至少一条数据']);

            foreach ($data as $key=>$val){
                $validator = Validator::make($val,[
                    'depot'=>'required|max:100',
                    'addons'=>'nullable|max:255',
                    'user_order_no'=>'required|max:50',
                    's_name'=>'required|between:1,100',
                    's_phone' => 'required|min:10',
                    's_country' => 'required',
                    's_province' => 'required',
                    's_city' => 'required',
                    's_address' => 'required',
                    's_code' => 'required',

                    'r_name'=>'required|between:1,10',
                    'r_phone' => 'required|min:11',
                    'r_cre_type' => 'required|integer',
                    'r_cre_num' => ['required','regex:/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|[xX])$/'],
                    'r_addressDetail' => 'required',
                    'r_code' => 'required',
                    'r_province' => 'required',
                    'r_city' => 'required',
                    'r_town' => 'required',
                ]);

                if ($validator->fails()){
                    $outputErrors[$key][$val['row']] = $validator->errors()->messages();
                }

                $checkProduct = $this->__checkProduct($val['products']);
                if ($checkProduct <> 'Success'){
                    if (isset($outputErrors[$key]) || !empty($outputErrors[$key])){
                        //实现数组合并，官方函数会照成行数重新排序问题，固然只有自己写
                        foreach ($checkProduct as $ck=>$cv){
                            if (isset($outputErrors[$key][$ck]) && !empty($outputErrors[$key][$ck])){
                                $outputErrors[$key][$ck] = array_merge($outputErrors[$key][$ck],$checkProduct[$ck]);
                            }else{
                                $outputErrors[$key][$ck] = $checkProduct[$ck];
                            }
                        }
                    }else{
                        $outputErrors[$key] = $checkProduct;
                    }
                }
            }

            $uid = Auth::id();
            if (!$isWrong = isset($outputErrors) && !empty($outputErrors)){
                foreach ($data as $val){
                    $oknum++;
                    $products = $val['products'];
                    unset($val['products'],$val['row']);
                    $product_detail = '';//检查不重复物品名称
                    foreach ($products as $getdetail){
                        if ($product_detail <> $getdetail['detail']) $val['productdetail'][] = $product_detail = $getdetail['detail'];
                    }
                    $val['system_order_no'] = 'W'.date('YmdHis').mt_rand(10000,99999);
                    $val['uid'] = $uid;
                    $val['line_id'] = $line_id;
                    $val['productdetail'] = implode(',',$val['productdetail']);
                    Order::create($val);
                    foreach ($products as $pval){
                        unset($pval['row']);
                        $pval['system_order_no'] = $val['system_order_no'];
                        OrderProduct::create($pval);
                    }
                }
            }

            return response()->json(['status'=>200,'msg'=>'成功导入 '.$oknum.' 条数据！','data'=>$outputErrors,'isWrong'=>$isWrong]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'请上传xls或xlsx文件']);
        }
    }

    private function __combon($sheet,$row){
        $product = [];
        $product['category_one'] = $sheet->getCell('J' . $row)->getValue();
        $product['category_two'] = $sheet->getCell('K' . $row)->getValue();
        if ($product['category_one']){
            $category_one = Product::select('id')->where('name',$product['category_one'])->where('parent_id','0')->first();
            $product['category_one'] = isset($category_one->id) ? $category_one->id : 'unknow';
        }
        if ($product['category_two']){
            $category_two = Product::select('id')->where('name',$product['category_two'])->where('parent_id','<>','0')->first();
            $product['category_two'] = isset($category_two->id) ? $category_two->id : 'unknow';
        }
        $product['detail'] = $sheet->getCell('L' . $row)->getValue();
        $product['brand'] = $sheet->getCell('M' . $row)->getValue();
        $product['catname'] = $sheet->getCell('N' . $row)->getValue();
        $product['amount'] = $sheet->getCell('O' . $row)->getValue();
        $product['price'] = $sheet->getCell('P' . $row)->getValue();
        $product['remark'] = str_replace('，',',',$sheet->getCell('Q' . $row)->getValue());
        $product['row'] = $row;
        return $product;
    }

    private function __checkProduct($data){
        $returnData = [];
        foreach ($data as $key=>$val){
            $validator = Validator::make($val,[
                'category_one'=>'required|integer',
                'category_two'=>'required|integer',
                'detail'=>'required|between:1,100',
                'brand'=>'required|between:1,100',
                'price'=>'required|numeric',
                'catname'=>'required|between:1,50',
                'amount'=>'required|integer|min:1',
                'remark'=>'nullable|max:100',
            ],[
                'category_one.integer'=>'请选择正确物品一级类别',
                'category_two.integer'=>'请选择正确物品二级类别',
            ]);

            if ($validator->fails()) {
                $returnData[$val['row']] = $validator->errors()->messages();
            }
        }
        return isset($returnData) && !empty($returnData) ? $returnData : 'Success';
    }
}
