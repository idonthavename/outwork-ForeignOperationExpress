<?php

namespace App\Http\Controllers\Admin;

use App\Addon;
use App\Depot;
use App\Line;
use App\Order;
use App\OrderProduct;
use App\Product;
use App\Receiver;
use App\Sender;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OnlineController extends Controller
{
    private $userid;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userid = Auth::id();
            return $next($request);
        });
    }

    public function index(Request $request){
        $data['line_id'] = 0;
        $data['senderDefault'] = Sender::where(['uid'=>$this->userid,'isdefault'=>1])->first();
        $data['receiverDefault'] = Receiver::where(['uid'=>$this->userid,'isdefault'=>1])->first();
        $data['depot'] = Depot::orderBy('order','DESC')->get();
        $data['lineData'] = Line::select(['id','name','content','iupid','products','onlineExcel'])->where('isban','0')->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        //组装所有产品数据
        foreach ($data['lineData'] as $val){
            $products = [];
            $daddyids = explode(',',$val['products']);
            $productsDaddy = Product::select(['id','name'])->whereIn('id',$daddyids)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
            foreach ($productsDaddy as $dkey=>$dval){
                $productsChild = Product::select(['id','name'])->where('parent_id',$dval['id'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
                if (count($productsChild) > 0){
                    $childrens = [];
                    $product= ['value'=>$dval['id'],'label'=>$dval['name']];
                    foreach ($productsChild as $ckey=>$cval){
                        $childrens[] = ['value'=>$cval['id'],'label'=>$cval['name'],'price'=>30,'spec_unit'=>'kg,g','num_unit','套,件'];
                    }
                    $product['children'] = $childrens;
                    $products[] = $product;
                }
            }
            $data['lineProduct'][$val['id']] = $products;
        }
        $data['lineProduct'] = json_encode($data['lineProduct']);
        return view('admin.online.index',['data'=>$data]);
    }

    public function edit(Request $request){
        $id = intval($request->get('id'));
        if (!$id) abort(404);
        if ($this->userid == 1){
            $order = Order::find($id);
        }else{
            $order = Order::where('id',$id)->where('uid',$this->userid)->first();
        }
        //权限判断
        if (!$order->id) abort(404);
        if ($order->status <> 0 && $this->userid <> 1) abort(404);
        $data['order'] = $order;
        $data['line_id'] = $order->line_id;
        $data['senderDefault'] = [
            'id'=>1,
            'name'=>$order->s_name,
            'phone'=>$order->s_phone,
            'country'=>$order->s_country,
            'province'=>$order->s_province,
            'city'=>$order->s_city,
            'address'=>$order->s_address,
            'code'=>$order->s_code,
        ];
        $data['receiverDefault'] = [
            'id'=>1,
            'name'=>$order->r_name,
            'phone'=>$order->r_phone,
            'cre_type'=>$order->r_cre_type,
            'cre_num'=>$order->r_cre_num,
            'province'=>$order->r_province,
            'city'=>$order->r_city,
            'town'=>$order->r_town,
            'addressDetail'=>$order->r_addressDetail,
            'code'=>$order->r_code,
        ];
        $data['changelineJson'] = json_encode([
            'system_order_no'=>$order['system_order_no'],
            'user_order_no'=>$order['user_order_no'],
            'addons'=>$order['addons'],
            'upload_type'=>$order['upload_type'],
            'status'=>$order['status'],
            'data'=>['id_card_back'=>$order['id_card_back'],'id_card_front'=>$order['id_card_front']]
        ]);
        $data['depot'] = Depot::orderBy('order','DESC')->get();
        $data['lineData'] = Line::select(['id','name','content','iupid','products','onlineExcel'])->where('isban','0')->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        //组装所有产品数据
        foreach ($data['lineData'] as $val){
            $products = [];
            $daddyids = explode(',',$val['products']);
            $productsDaddy = Product::select(['id','name'])->whereIn('id',$daddyids)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
            foreach ($productsDaddy as $dkey=>$dval){
                $productsChild = Product::select(['id','name'])->where('parent_id',$dval['id'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
                if (count($productsChild) > 0){
                    $childrens = [];
                    $product= ['value'=>$dval['id'],'label'=>$dval['name']];
                    foreach ($productsChild as $ckey=>$cval){
                        $childrens[] = ['value'=>$cval['id'],'label'=>$cval['name'],'price'=>30,'spec_unit'=>'kg,g','num_unit','套,件'];
                    }
                    $product['children'] = $childrens;
                    $products[] = $product;
                }
            }
            $data['lineProduct'][$val['id']] = $products;
        }
        $data['lineProduct'] = json_encode($data['lineProduct']);
        return view('admin.online.edit',['data'=>$data,'id'=>$id]);
    }

    public function template(Request $request){
        $data['iupid'] = $request->post('iupid',0);
        $data['excel'] = $request->post('excel');
        $data['status'] = $request->post('status',0);
        $data['id_card_front'] = $request->post('id_card_front','');
        $data['id_card_back'] = $request->post('id_card_back','');
        $data['addons'] = Addon::orderBy('order','DESC')->get();
        $data['upload_type'] = $request->post('upload_type',2);
        $data['user_order_no'] = $request->post('user_order_no','');
        $data['chooseAddons'] = $request->post('addons','');
        $data['chooseAddons'] = isset($data['chooseAddons']) && !empty($data['chooseAddons']) ? explode(',',$data['chooseAddons']) : [];
        $data['system_order_no'] = $request->post('system_order_no','');
        $data['orderProducts'] = isset($data['system_order_no']) && !empty($data['system_order_no']) ? OrderProduct::where('system_order_no',$data['system_order_no'])->get() : null;
        $data['orderProductsCount'] = isset($data['orderProducts']) ? sizeof($data['orderProducts']) : 0;
        return view('admin.online.template',['data'=>$data]);
    }

    public function show(Request $request){
        $lineid = intval($request->get('line_id'));
        //$data['lineData'] = Line::select(['id','name','content','iupid','products','onlineExcel'])->where('id',$lineid)->where('isban','0')->get();
        $data['lineData'] = Line::select(['id','name','content','iupid','products','onlineExcel'])->where('isban','0')->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        //组装所有产品数据
        foreach ($data['lineData'] as $val){
            $products = [];
            $daddyids = explode(',',$val['products']);
            $productsDaddy = Product::select(['id','name'])->whereIn('id',$daddyids)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
            foreach ($productsDaddy as $dkey=>$dval){
                $productsChild = Product::select(['id','name'])->where('parent_id',$dval['id'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
                if (count($productsChild) > 0){
                    $childrens = [];
                    $product= ['value'=>$dval['id'],'label'=>$dval['name']];
                    foreach ($productsChild as $ckey=>$cval){
                        $childrens[] = ['value'=>$cval['id'],'label'=>$cval['name'],'price'=>30,'spec_unit'=>'kg,g','num_unit','套,件'];
                    }
                    $product['children'] = $childrens;
                    $products[] = $product;
                }
            }
            $data['lineProduct'][$val['id']] = $products;
        }
        return response()->json(['status'=>200,'msg'=>'成功','data'=>$data['lineProduct']]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'id' => 'nullable|integer',
            'depot'=>'required|max:100',
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
            'r_province' => 'required',
            'r_city' => 'required',
            'r_town' => 'required',
            'r_addressDetail' => 'required',
            'r_code' => 'required',
            'front_url' => 'nullable|string|max:200',
            'back_url' => 'nullable|string|max:200',
            'line_id' => 'nullable|integer',
            'bookin' => 'nullable|integer',
            'upload_type' => 'nullable|integer',
            'max_row' => 'required|integer',
            'addons' => 'nullable|array',
        ]);

        $post = $request->post();
        $id = $request->post('id',0);
        if (!$id){
            $post['uid'] = $this->userid;
            $post['system_order_no'] = 'W'.date('YmdHis').mt_rand(10000,99999);
        }else{
            $order = Order::select(['id','uid','system_order_no'])->where('id',$id)->first();
        }
        $post['addons'] = !empty($post['addons']) && is_array($post['addons']) ? implode(',',$post['addons']) : '';
        $post['upload_type'] = !empty($post['upload_type']) && isset($post['upload_type']) ? $post['upload_type'] : 0;

        $product_ids = [];
        $product_num = 0;
        $money = 0.00;
        $product_detail = '';    //记录不同物品名称

        if ($post['max_row'] > 0){
            for ($i = 1; $i <= $post['max_row'];$i++){
                if (isset($post['category_one_'.$i]) && isset($post['category_two_'.$i])){
                    $product_num++;
                    $checkProduct[$i]['category_one'] = $post['category_one_'.$i];
                    $checkProduct[$i]['category_two'] = $post['category_two_'.$i];
                    $checkProduct[$i]['detail'] = $post['detail_'.$i];
                    if ($product_detail <> $post['detail_'.$i]) $post['productdetail'][] = $product_detail = $post['detail_'.$i];
                    $checkProduct[$i]['brand'] = $post['brand_'.$i];
                    $checkProduct[$i]['price'] = $post['price_'.$i];
                    $checkProduct[$i]['catname'] = $post['catname_'.$i];
                    $checkProduct[$i]['amount'] = $post['amount_'.$i];
                    $checkProduct[$i]['remark'] = $post['remark_'.$i];
                    $product_ids[$i] = $post['oid_'.$i];
                }
                unset($post['category_one_'.$i]);
                unset($post['category_two_'.$i]);
                unset($post['detail_'.$i]);
                unset($post['brand_'.$i]);
                unset($post['price_'.$i]);
                unset($post['catname_'.$i]);
                unset($post['spec_unit_'.$i]);
                unset($post['amount_'.$i]);
                unset($post['is_suit_'.$i]);
                unset($post['remark_'.$i]);
                unset($post['oid_'.$i]);
                unset($post['source_area_'.$i]);
                unset($post['coin_'.$i]);
            }
            if ($product_num < 1) return response(['status'=>-100,'msg'=>'请添加至少一条数据']);
            $check = $this->__checkProduct($checkProduct);
            if ($check == 'Success'){
                $system_order_no = $id ? $order['system_order_no'] : $post['system_order_no'];
                if ($id) OrderProduct::where('system_order_no',$system_order_no)->delete();
                foreach ($checkProduct as $key=>$value){
                    $money += $value['price'] * $value['amount'];
                    $value['system_order_no'] = $system_order_no;
                    OrderProduct::create($value);
                }
                $post['money'] = number_format($money,2,".","");
            }else{
                return response(['status'=>-100,'msg'=>'数据不符合要求，请重新上传！']);
            }
        }else{
            return response(['status'=>-100,'msg'=>'请添加至少一条数据']);
        }

        //判断图片保存
        if ($post['upload_type'] == 1){
            $path = date('y').'/'.date('m').'/'.date('d');
            $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
            if ($request->hasFile('id_card_front') && $request->file('id_card_front')->isValid()){
                if (!in_array($request->file('id_card_front')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($request->file('id_card_front')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                $fontExt = $request->file('id_card_front')->extension();
                $post['id_card_front'] = $request->file('id_card_front')->store($path);
            }else{
                $post['id_card_front'] = $post['front_url'] ? $post['front_url'] : null;
            }
            if ($request->hasFile('id_card_back') && $request->file('id_card_back')->isValid()){
                if (!in_array($request->file('id_card_back')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($request->file('id_card_back')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                $backExt = $request->file('id_card_back')->extension();
                $post['id_card_back'] = $request->file('id_card_back')->store($path);
            }else{
                $post['id_card_back'] = $post['back_url'] ? $post['back_url'] : null;
            }
        }else{
            if ($post['front_url'] || $post['back_url']){
                $post['id_card_front'] = $post['front_url'];
                $post['id_card_back'] = $post['back_url'];
            }else{
                $post['id_card_front'] = $post['id_card_back'] = null;
            }
        }

        //是否保存地址
        if (isset($post['bookin']) && $post['bookin'] > 0){
            $receiver['uid'] = $post['uid'];
            $receiver['name'] = $post['r_name'];
            $receiver['phone'] = $post['r_phone'];
            $receiver['cre_type'] = $post['r_cre_type'];
            $receiver['cre_num'] = $post['r_cre_num'];
            $receiver['province'] = $post['r_province'];
            $receiver['city'] = $post['r_city'] ;
            $receiver['town'] = $post['r_town'] ;
            $receiver['addressDetail'] = $post['r_addressDetail'];
            $receiver['code'] = $post['r_code'];
            $receiver['line_id'] = $post['line_id'];
            $receiver['id_card_front'] = $post['id_card_front'];
            $receiver['id_card_back'] = $post['id_card_back'];
            Receiver::create($receiver);
        }

        //删除不必要参数
        unset($post['id'],$post['_token'],$post['r_id'],$post['front_url'],$post['back_url'],$post['del_row'],$post['max_row'],$post['excel'],$post['bookin']);

        //重新组装数组物品名称
        $post['productdetail'] = implode(',',$post['productdetail']);

        //正式插入订单库
        if ($id > 0){
            if ($this->userid == 1){
                Order::where(['id'=>$id])->update($post);
            }else{
                Order::where(['id'=>$id,'uid'=>$this->userid])->update($post);
            }
        }else{
            Order::create($post);
        }
        return response()->json(['status'=>200,'msg'=>'保存成功',]);
    }

    public function payedStore(Request $request){
        $this->validate($request,[
            'id' => 'nullable|integer',
            'depot'=>'required|max:100',
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
            'r_province' => 'required',
            'r_city' => 'required',
            'r_town' => 'required',
            'r_addressDetail' => 'required',
            'r_code' => 'required',
            'front_url' => 'nullable|string|max:200',
            'back_url' => 'nullable|string|max:200',
            'upload_type' => 'nullable|integer',
        ]);

        $post = $request->post();
        $id = $request->post('id',0);
        $order = Order::select(['id','uid','system_order_no'])->where('id',$id)->first();
        $post['upload_type'] = !empty($post['upload_type']) && isset($post['upload_type']) ? $post['upload_type'] : 0;

        //判断图片保存
        if ($post['upload_type'] == 1){
            $path = date('y').'/'.date('m').'/'.date('d');
            $allowTypes = ['image/gif','image/jpg','image/jpeg','image/png'];
            if ($request->hasFile('id_card_front') && $request->file('id_card_front')->isValid()){
                if (!in_array($request->file('id_card_front')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($request->file('id_card_front')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                $fontExt = $request->file('id_card_front')->extension();
                $post['id_card_front'] = $request->file('id_card_front')->store($path);
            }else{
                $post['id_card_front'] = $post['front_url'] ? $post['front_url'] : '';
            }
            if ($request->hasFile('id_card_back') && $request->file('id_card_back')->isValid()){
                if (!in_array($request->file('id_card_back')->getMimeType(),$allowTypes)) return response()->json(['status'=>-101,'msg'=>'图片类型错误']);
                if ($request->file('id_card_back')->getSize() > 4*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于4M图片']);
                $backExt = $request->file('id_card_back')->extension();
                $post['id_card_back'] = $request->file('id_card_back')->store($path);
            }else{
                $post['id_card_back'] = $post['back_url'] ? $post['back_url'] : '';
            }
        }

        //删除不必要参数
        unset($post['id'],$post['_token'],$post['r_id'],$post['front_url'],$post['back_url'],$post['del_row'],$post['max_row'],$post['excel'],$post['bookin']);

        //正式插入订单库
        if ($id > 0){
            Order::where(['id'=>$id,'uid'=>$this->userid])->update($post);
        }else{
            Order::create($post);
        }
        return response()->json(['status'=>200,'msg'=>'保存成功',]);
    }

    private function __checkProduct($data){
        foreach ($data as $key=>$val){
            $validator = Validator::make($val,[
                'category_one'=>'required|integer',
                'category_two'=>'required|integer',
                'detail'=>'required|between:1,100',
                'brand'=>'required|between:1,100',
                'price'=>'required|numeric',
                'catname'=>'required|between:1,50',
                //'spec_unit'=>'required|between:1,20',
                'amount'=>'required|integer|min:1',
                //'is_suit'=>'nullable|integer',
                'remark'=>'nullable|max:100',
            ]);

            if ($validator->fails()) {
                return $validator;
            }
        }
        return 'Success';
    }

    public function productShow(Request $request){
        $this->validate($request,[
            'excel'=>'required|file'
        ]);

        $allowTypes = ['xls','xlsx'];
        $excel = $request->file('excel');
        if (in_array(strtolower($excel->getClientOriginalExtension()),$allowTypes)){
            if ($excel->getSize() > 2*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于2M文件']);
            require_once(base_path() . '/app/libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
            $reader = \PHPExcel_IOFactory::createReader('Excel2007');
            $PHPExcel = $reader->load($excel->path()); // 载入excel文件
            $sheet = $PHPExcel->getSheet(0);// 读取第一個工作表
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumm = $sheet->getHighestColumn(); // 取得总列数
            $product_num = 0;
            $checkProduct = [];
            for ($row = 4; $row <= $highestRow; $row++) {//行数是以第1行开始
                if ($sheet->getCell('A' . $row)->getValue() && $sheet->getCell('B' . $row)->getValue()){//判断是否存在该产品
                    $product_num++;
                    $checkProduct[$row]['category_one'] = $sheet->getCell('A' . $row)->getValue();
                    $checkProduct[$row]['category_two'] = $sheet->getCell('B' . $row)->getValue();
                    $checkProduct[$row]['detail'] = $sheet->getCell('C' . $row)->getValue();
                    $checkProduct[$row]['brand'] = $sheet->getCell('D' . $row)->getValue();
                    $checkProduct[$row]['price'] = $sheet->getCell('E' . $row)->getValue();
                    $checkProduct[$row]['catname'] = $sheet->getCell('F' . $row)->getValue();
                    //$checkProduct[$row]['spec_unit'] = $sheet->getCell('G' . $row)->getValue();
                    $checkProduct[$row]['amount'] = $sheet->getCell('G' . $row)->getValue();
                    //$checkProduct[$row]['is_suit'] = $sheet->getCell('I' . $row)->getValue() == '是' ? 1 : 0;
                    $checkProduct[$row]['remark'] = $sheet->getCell('H' . $row)->getValue();
                }
            }
            if ($product_num < 1) return response(['status'=>-100,'msg'=>'请添加至少一条数据']);
            return response()->json(['status'=>200,'msg'=>'检验成功','data'=>$checkProduct]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'请上传xls或xlsx文件']);
        }
    }

    public function productDel(Request $request){
        $id = intval($request->post('ttc',0));
        if ($id){
            $destroy = OrderProduct::destroy($id);
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
