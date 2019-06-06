<?php

namespace App\Http\Controllers\Master;

use App\Line;
use App\Linetwo;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.line.index');
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
        $data = Line::offset(($page-1)*$limit)->limit($limit)->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $count = Line::count();
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
            'name'=>'required|between:1,50',
            'channel'=>'required|between:1,50',
            'content'=>'nullable|max:500',
            'linetwos'=>'required|array',
            'products'=>'required|array',
            'ykg'=>'nullable|numeric',
            'price'=>'required|array',
            'overweight'=>'required|array',
            'unit'=>'required|string',
            'iupid'=>'nullable|string',
            'order'=>'nullable|integer',
            'remark'=>'nullable|string',
            'isban'=>'nullable|string',
            'rule'=>'required|integer',
            'goon'=>'nullable|numeric',
            'outon'=>'nullable|numeric',
        ]);

        $post = $request->post();
        $post['isban'] = isset($post['isban']) && $post['isban'] == 'on' ? 1 : 0;
        $post['iupid'] = isset($post['iupid']) && $post['iupid'] == 'on' ? 1 : 0;
        $post['ykg'] = number_format($post['ykg'],2,'.','');
        $post['linetwos'] = implode(',',$post['linetwos']);
        $post['products'] = implode(',',$post['products']);
        $post['price'] = json_encode($post['price']);
        $post['overweight'] = json_encode($post['overweight']);
        $post['goon'] = number_format($post['goon'],2,'.','');
        $post['outon'] = number_format($post['outon'],2,'.','');
        unset($post['_token'],$post['excel']);

        $id = intval($post['id']);
        if ($id){
            $update = Line::where('id',$id)->update($post);
            if ($update){
                return response()->json(['status'=>200,'msg'=>'保存成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'保存失败']);
            }
        }else{
            $create = Line::create($post);
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
    public function show($id){
        require_once(base_path() . '/app/libs/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');
        $originFile = public_path().'/excel/pldr-yxemsgrkj.xlsx';
        $newFile = public_path().'/excel/orders-'.$id.'.xlsx';
        $newobjExcel = new \PHPExcel();
        $newobjExcel->setActiveSheetIndex(0);
        $newobjExcel->getActiveSheet()->setTitle('批量下单');
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($originFile);
        $sheet = $objPHPExcel->getSheet(0); // 读取第一個工作表
        $highestRow = $sheet->getHighestRow(); // 取得总行数
        $highestColumm = $sheet->getHighestColumn(); // 取得总列数

        /** 循环读取每个单元格的数据 */
        $styleThinBlackBorderOutline = array(
            'borders' => array(
                'allborders' => array( //设置全部边框
                    'style' => 'thin' //粗的是thick
                ),
            ),
        );
        for ($row = 1; $row <= $highestRow; $row++){//行数是以第1行开始
            for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
                $newobjExcel->getActiveSheet()->setCellValue($column.$row, $sheet->getCell($column.$row)->getValue());
            }
        }
        $newobjExcel->getActiveSheet()->setCellValue("A1", "更新日期：\n北京时间".date('Ymd',time()));
        $newobjExcel->getActiveSheet()->mergeCells("B1:Y1");
        $newobjExcel->getActiveSheet()->mergeCells("A2:A3");
        $newobjExcel->getActiveSheet()->mergeCells("B2:I2");
        $newobjExcel->getActiveSheet()->mergeCells("B2:I2");
        $newobjExcel->getActiveSheet()->mergeCells("J2:Q2");
        $newobjExcel->getActiveSheet()->mergeCells("R2:W2");
        $newobjExcel->getActiveSheet()->mergeCells("X2:Y2");
        $newobjExcel->getActiveSheet()->mergeCells("J3:K3");
        for ($column = 'A'; $column <= $highestColumm; $column++) {//列数是以A列开始
            $newobjExcel->getActiveSheet()->getColumnDimension($column)->setWidth(25);
        }
        $newobjExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);
        $newobjExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(80);
        $newobjExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(40);
        $newobjExcel->getDefaultStyle()->getAlignment()->setWrapText(true);
        $newobjExcel->getDefaultStyle()->getAlignment()->setHorizontal("center");
        $newobjExcel->getDefaultStyle()->getAlignment()->setVertical("center");
        $newobjExcel->getActiveSheet()->getStyle("B1")->getAlignment()->setHorizontal("left");
        $newobjExcel->getDefaultStyle()->getFont()->setName("微软雅黑");
        $newobjExcel->getActiveSheet()->getStyle('B2:Y2')->getFill()->setFillType("solid")->getStartColor()->setARGB('FDE9D9');
        $newobjExcel->getActiveSheet()->getStyle("B2:Y2")->getFont()->setBold(true);
        $newobjExcel->getActiveSheet()->getStyle("B2:Y2")->getFont()->setSize(14);
        $newobjExcel->getActiveSheet()->getStyle("A1:Y3")->applyFromArray($styleThinBlackBorderOutline);


        $newobjExcel->createSheet(1);
        $newobjExcel->setActiveSheetIndex(1);
        $newobjExcel->getActiveSheet()->setTitle('货品类别');
        $newobjExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(80);
        $newobjExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(30);
        $id = intval($id);
        $data = Line::find($id);
        $defaultRow = "A";
        $maxCol = 1;
        $maxRow = 1;
        $letterArray=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
        if ($data['products']) $data['products'] = explode(',',$data['products']);
        $products = [];
        $big = Product::select(['id','name'])->whereIn('id',$data['products'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $maxCol = count($big);
        foreach ($big as $key=>$val){
            $products[$key][] = $val['name'];
            $small = Product::select(['name'])->where('parent_id',$val['id'])->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
            $smallcount = count($small) + 1;
            $maxRow = $smallcount > $maxRow ? $smallcount : $maxRow;
            foreach ($small as $sval){
                $products[$key][] = $sval['name'];
            }
        }

        foreach ($products as $pkey=>$pval){
            if ($pkey != "A") $defaultRow++;
            foreach ($pval as $ppkey=>$ppval){
                $newobjExcel->getActiveSheet()->setCellValue($defaultRow.($ppkey+1), $ppval);
            }
        }

        $newobjExcel->getActiveSheet()->getStyle("A1:".$defaultRow."1")->getFont()->setBold(true);
        $newobjExcel->getActiveSheet()->getStyle("A1:".$defaultRow."1")->getFont()->setSize(12);
        for ($i = 1;$i <= $maxRow;$i++){
            $newobjExcel->getActiveSheet()->getRowDimension($i)->setRowHeight(80);
        }
        $newobjExcel->getDefaultStyle()->getFont()->setName("微软雅黑");
        $newobjExcel->getActiveSheet()->getStyle("A1:".$letterArray[$maxCol-1].$maxRow)->applyFromArray($styleThinBlackBorderOutline);

        $newobjExcel->setActiveSheetIndex(0);
        $objWriter = \PHPExcel_IOFactory::createWriter($newobjExcel, 'Excel2007');
        $objWriter->save($newFile);
        $newobjExcel->disconnectWorksheets();
        return response()->json(['status'=>200,'msg'=>'操作成功',]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = intval($id);
        $data = Line::where('id',$id)->first();
        if ($data['linetwos']) $data['linetwos'] = explode(',',$data['linetwos']);
        if ($data['products']) $data['products'] = explode(',',$data['products']);
        if ($data['price']) $data['price'] = json_decode($data['price'],true);
        if ($data['overweight']) $data['overweight'] = json_decode($data['overweight'],true);
        $linetwos = Linetwo::orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        $products = Product::where('parent_id','0')->orderBy('order','DESC')->orderBy('created_at','DESC')->get();
        return view('master.line.edit',['data'=>$data,'linetwos'=>$linetwos,'products'=>$products]);
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
            $destroy = Line::destroy($id);
            if ($destroy){
                return response()->json(['status'=>200,'msg'=>'删除成功',]);
            }else{
                return response()->json(['status'=>-100,'msg'=>'删除失败']);
            }
        }else{
            return response()->json(['status'=>-100,'msg'=>'抱歉，丢失参数']);
        }
    }

    public function excel(Request $request){
        $this->validate($request,[
            'excel'=>'required|file'
        ]);

        $allowTypes = ['xls','xlsx'];
        $excel = $request->file('excel');
        if (in_array(strtolower($excel->getClientOriginalExtension()),$allowTypes)){
            $path = date('y').'/'.date('m').'/'.date('d');
            if ($excel->getSize() > 2*1024*1000) return response()->json(['status'=>-102,'msg'=>'请上传小于2M文件']);
            $url = $excel->storeAs($path, str_random(40).'.'.$excel->getClientOriginalExtension());
            return response()->json(['status'=>200,'msg'=>'上传成功','url'=>$url]);
        }else{
            return response()->json(['status'=>-100,'msg'=>'请上传xls或xlsx文件']);
        }
    }
}
