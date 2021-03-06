<style>
    .obconts {  width: 360px;  position: relative;  margin-top: 26px;  height: 200px;  border: 2px dotted #000;  border-radius: 15px;  float: left;  }
    .obconts p {  font-size: 18px;  font-weight: 700;  color: #000;  padding-left: 15px;  padding-top: 5px;  margin: 0 0 15px;  }
    .obconts input[class=uploadfile] {  width: 106px;  height: 41px;  position: relative;  z-index: 9;  opacity: 0;  top: -37px;  margin-left: 270px;  left: -13px;  }
    .obconts label {  position: absolute;  background: #232323;  display: inline-block;  color: #ffde00;  width: 90px;  height: 41px;  line-height: 45px;  text-align: center;  top: 123px;  left: 256px;  border-radius: 5px;  }
    input[type=file] {  display: block;  }
    .addons .layui-form-checkbox[lay-skin=primary]{width: 125px;height: 2rem!important;}
    .addons .layui-form-checked i, .layui-form-checked:hover i{color: #ffffff!important;}
</style>
@if($data['iupid'] == 1)
<div class="layui-card">
    <div class="layui-card-header">证件上传</div>
    <div class="layui-card-body">
        <div class="layui-form-item layui-row">
            <div class="layui-col-md12 content">
                <p style="color:#000;font-size: 15px;">温馨提示：为清关顺利，请上传有效、清晰的身份证原件正反面照片。<br>1、身份证信息须与收件人信息一致<br>2、每张照片大小不超过4M<br>如上传不成功，请尝试：<br>1、调高照片亮度<br>2、裁剪多余背景且露出证件四角</p>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md12 content">
                <input type="radio" name="upload_type" value="1" title="1.寄件人上传" lay-filter="upload_type" @if($data['upload_type'] == 1) checked @endif>
                <input type="radio" name="upload_type" value="2" title="2.收件人上传" lay-filter="upload_type" @if($data['upload_type'] <> 1) checked @endif>
            </div>
        </div>
        <div class="layui-row">
            <div class="layui-col-md12 content">
                <div class="layui-form-item @if($data['upload_type'] <> 1) layui-hide @endif" id="uploadfiles">
                    <div class="layui-col-xs12 layui-col-md4 obconts" id="obcontid2">
                        <p>身份证国徽面</p>
                        @if($data['iupid'] == 1)
                            <img src="{{$data['id_card_front'] ? '/uploads/'.$data['id_card_front'] : '/images/pho_front.png'}}" id="fileimage2" style="width: 230px;height: 120px;margin-left: 15px;">
                            <input type="file" name="id_card_front" class="uploadfile" id="front" accept="image/jpeg,image/jpg,image/png,image/gif" atd="2" onclick="fileOnchange(this)">
                            <input type="hidden" name="front_url" value="{{$data['id_card_front']}}">
                        @else
                            <img src="/images/notupload_f.png" id="fileimage2" style="width: 230px;height: 120px;margin-left: 15px;">
                        @endif
                        <label>上传图片</label>
                    </div>
                    <div class="layui-col-xs12 layui-col-md4 layui-col-md-offset2 obconts" id="obcontid1">
                        <p>身份证头像面</p>
                        @if($data['iupid'] == 1)
                            <img src="{{$data['id_card_back'] ? '/uploads/'.$data['id_card_back'] : '/images/pho_back.png'}}" id="fileimage1" style="width: 230px;height: 120px;margin-left: 15px;">
                            <input type="file" name="id_card_back" class="uploadfile" id="back" accept="image/jpeg,image/jpg,image/png,image/gif" atd="1" onclick="fileOnchange(this)">
                            <input type="hidden" name="back_url" value="{{$data['id_card_back']}}">
                        @else
                            <img src="/images/notupload_b.png" id="fileimage2" style="width: 230px;height: 120px;margin-left: 15px;">
                        @endif
                        <label>上传图片</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
    <input type="hidden" name="front_url" value="{{$data['id_card_front']}}">
    <input type="hidden" name="back_url" value="{{$data['id_card_back']}}">
@endif
<script src="{{asset('/js/jquery-1.8.3.min.js')}}"></script>
<script>
    function fileOnchange(pid){
        var atd = pid.getAttribute("atd");
        // alert(atd);
        var input = pid;

        var res = document.getElementById("fileimage"+atd);
        if(typeof FileReader==='undefined'){
            res.innerHTML = "抱歉，你的浏览器不支持 FileReader";
            input.setAttribute('disabled','disabled');
        }else{
            input.addEventListener('change',readFile,false);
        }

        //图片文件读取
        function readFile(){
            var file = this.files[0];
            // console.log(file);
            if(!/image\/\w+/.test(file.type)){
                layer.open({
                    type: 0,
                    title: false,
                    content: "文件必须为图片！"
                });
                return false;
            }
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e){
                res.src = this.result;  //赋值到src
            }
        }
    }
</script>
<style>
    #table th{text-align: center;font-weight: bold;}
    #table .goods-word{font-size: 0.5rem;color: red;}
    #table .spec-input{width: 90px;display: inline;margin-left:10px;}
    #table .layui-input{height:40px;}
    #copy_btn{color: yellow;}
    .free{font-size: 1.2rem;color: red;}
    #BtnSave{float: right;}
    .isall_width{text-align: center;}
    .isall_width input{display: inline-block!important;}
</style>
@if($data['status'] < 4)
<div class="layui-card">
    <div class="layui-card-header">快件信息</div>
    <div class="layui-card-body">
        {{--<div class="layui-row">
            <div class="layui-col-md12">
                <a href="{{$data['excel'] ? '/uploads/'.$data['excel'] : '/excel/yxemsgrkj.xlsx'}}"  class="layui-btn layui-btn-primary layui-btn-lg layui-bg-black">模板下载</a>
                <a id="import" class="layui-btn layui-btn-primary layui-btn-lg layui-bg-black">导入</a>
            </div>
        </div>--}}
        <div class="layui-row">
            <table class="layui-table" id="table">
                <input type="hidden" id="num" value="{{isset($data['orderProducts']) && $data['orderProductsCount'] > 0 ? $data['orderProductsCount'] : 4}}">
                <input type="hidden" id="max_row" value="{{isset($data['orderProducts']) && $data['orderProductsCount'] > 0 ? $data['orderProductsCount'] : 4}}" name="max_row">
                <thead>
                <tr>
                    <th width="210px">货品列表</th>
                    <th>货品名称(中文)<br>
                        <span class="goods-word">
                        *不可写保健品等<br>
                        非具体品名，需具体到鱼油等
                        </span>
                    </th>
                    <th>英文品牌</th>
                    <th>单价(美元)</th>
                    <th width="175">规格/型号/材质</th>
                    <th>数量</th>
                    {{--<th>是否套装</th>--}}
                    <th>备注</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    @include('admin.online.table',['data'=>$data['orderProducts'],'type'=>isset($data['orderProducts']) && $data['orderProductsCount'] > 0 ? 'edit' : 'index'])
                </tbody>
            </table>
        </div>
        <div class="layui-row" style="margin-top: 1rem;">
            <div class="layui-col-md12">
                <a class="layui-btn layui-btn-primary layui-btn-sm layui-bg-black" id="copy_btn" onclick="copy_row(undefined,0)">增加</a>
                <span class="forspan">*注意：至少需要填写一条完整的货品声明</span>
                <h5 style="float: right;" id="contper">总税金（$）：<span class="free">免税</span></h5>
            </div>
        </div>
        <div class="layui-row" style="margin-top: 1rem;">
            <div class="layui-col-md12">
                <div style="float: left;width: 20%;">
                    <input type="text" name="user_order_no" required  lay-verify="required" lay-verType="tips" placeholder="运单号" autocomplete="on" class="layui-input" value="{{$data['user_order_no']}}">
                </div>
                <h5 style="float: right;">总金额（$）：<span class="free" id="money">0.00</span></h5>
            </div>
        </div>
        <div class="layui-row" style="margin-top: 1rem;">
            <div class="layui-col-md1">
                选用附加服务
            </div>
            <div class="layui-col-md5 addons">
                @foreach($data['addons'] as $val)
                    <input type="checkbox" name="addons[]" title="{{$val['name']}}" value="{{$val['name']}}" lay-skin="primary" {{in_array($val['name'],$data['chooseAddons']) ? 'checked' : ''}}>
                @endforeach
            </div>
        </div>
        <div class="layui-row" style="margin-top: 1rem;">
            <div class="layui-col-md12">
                <button  class="layui-btn layui-btn-primary layui-btn-lg layui-bg-black" id="BtnSave" lay-submit lay-filter="layuiadmin-app-form-submit">保存</button>
            </div>
        </div>
    </div>
</div>
@else
    <div class="layui-row" style="margin-top: 1rem;">
        <div class="layui-col-md12">
            <button  class="layui-btn layui-btn-primary layui-btn-lg layui-bg-black" id="BtnSave" lay-submit lay-filter="layuiadmin-app-form-submit">保存</button>
        </div>
    </div>
@endif
<script>
    layui.config({
        base: '/js/admin/' //静态资源所在路径
    }).use(['form', 'upload'], function(){
        var form = layui.form
            ,upload = layui.upload;
        form.on('radio(upload_type)', function(data){
            if (data.value == 1){
                $("#uploadfiles").removeClass("layui-hide");
                $("#uploadfiles").addClass("layui-show");
            }else{
                $("#uploadfiles").removeClass("layui-show");
                $("#uploadfiles").addClass("layui-hide");
            }
        });

        upload.render({
            elem: '#import'
            ,url: '/user/online/product-show'
            ,accept: 'file'
            ,size: 204800
            ,field:'excel'
            ,exts:'xls|XLS|xlsx|XLSX'
            ,data:{'_token':$("input[name=_token]").val()}
            ,before: function(){
                layer.load();
            }
            ,done: function(res){ //上传后的回调
                if(res.data.length != 0 && res.status == 200){
                    var tr_ = $('.stta');
                    // 倒序循环判断是否用户已填信息
                    for(var i = tr_.length-1; i >= 0 ; i--){
                        if(is_empty_line($(tr_[i]))){
                            $(tr_[i]).remove();
                        }else{
                            break;
                        }
                    }

                    $('#num').val($('.stta').length);
                    $('#max_row').val($('.stta').length);
                    var res1, res2;
                    $.each(res.data,function(k,v){
                        // 根据label的值进行分析 把对应的值进行赋值
                        res1 = loop_cascader(globa_selec_gory.options,v.category_one);
                        v.category_one = res1[0];
                        if(res1[1] != undefined){
                            res2 = loop_cascader(res1[1],v.category_two);
                            v.category_two = res2[0];
                        }

                        copy_row(v,0);
                    });
                }else {
                    layer.alert(res.msg);
                }
                layer.closeAll('loading');
            }
        });
        form.render();
    });
</script>
<script>

    var order_info_lng = "可填写货号等信息";
    var input_content_lng = "请输入内容";
    var categorys_lng = "请选择:一级类别/二级类别";
    var unit_lng = "单位";
    // 声明判断当前页面属性（index,edit,newOrder）
    window.acname = "index";
    var lay_del = "您确定要删除吗？";
    var lay_btnok ="确定";
    var lay_btncancel = "取消";
    var lay_information = "信息";
    var lay_systemmessage = "系统消息";
    var orderdel_url = "/user/online/productDel";
    var l_plan_unit = "请输入单位";
    var orderupload_url = "/orderlist/import";
    var l_del_lng= "删除";

    var unit_lng = "单位";
    var Total_Tax = "总税金";
    var Duty_Free = "免税";
    var find_indo_data = "/Order/find_indo_data";
    var member_url = "http://ores.meiquick.com/webuser/Member";

    // 获取线路ID
    var t_line = $("input[name='line_id']:checked").val();
    // 声明全局变量 装载element-ui所需的数据格式
    window.globa_selec_gory = {options:[]};
    // 数据组装
    if(category_list[t_line] != undefined) {
        $.each(category_list[t_line], function (k, v) {
            globa_selec_gory.options.push(v);
        });
    }

    // 获取英文品牌数据
    window.brand_list = [{"brand_name":"32 Cool"},{"brand_name":"365"},{"brand_name":"3M"},{"brand_name":"47 Mvp"},{"brand_name":"5.11 Tactical"},{"brand_name":"7 For All Mankind"},{"brand_name":"Ab Cuts"},{"brand_name":"Abbott"},{"brand_name":"Abbott Ensure"},{"brand_name":"Abercrombie &amp; Fitch"},{"brand_name":"Adidas"},{"brand_name":"Advanced"},{"brand_name":"Air Jordan"},{"brand_name":"Airborne"},{"brand_name":"Alba"},{"brand_name":"Align"},{"brand_name":"All Terrain"},{"brand_name":"Allegra"},{"brand_name":"Aller-Tec"},{"brand_name":"Alli"},{"brand_name":"Almond Roca"},{"brand_name":"Aloe Vera"},{"brand_name":"Always"},{"brand_name":"Amazing Grass"},{"brand_name":"Amlactin"},{"brand_name":"Annie's"},{"brand_name":"Ap24"},{"brand_name":"Applied Nutrition"},{"brand_name":"Aptamil"},{"brand_name":"Aquafresh"},{"brand_name":"Aquaphor"},{"brand_name":"Aquasana"},{"brand_name":"Armani"},{"brand_name":"Armani Exchange"},{"brand_name":"Ash"},{"brand_name":"Athon Berg"},{"brand_name":"Aveeno"},{"brand_name":"Aveeno Baby"},{"brand_name":"Avent"},{"brand_name":"Ax"},{"brand_name":"B.Pearl"},{"brand_name":"Babiators"},{"brand_name":"Baby Banana"},{"brand_name":"Baby Ddrops"},{"brand_name":"Baby Dha"},{"brand_name":"Baby Gund"},{"brand_name":"Baby's"},{"brand_name":"Babyganics"},{"brand_name":"Bad Air Sponge"},{"brand_name":"Baigie Baley"},{"brand_name":"Banana Boat"},{"brand_name":"Bartons"},{"brand_name":"Bausch Lomb"},{"brand_name":"Bayer"},{"brand_name":"Becca"},{"brand_name":"Beech-Nut"},{"brand_name":"Belvita"},{"brand_name":"Benadryl"},{"brand_name":"Benefiber"},{"brand_name":"Bengay"},{"brand_name":"Bikit"},{"brand_name":"Bioastin"},{"brand_name":"Blue Bottle"},{"brand_name":"Blue Diamond"},{"brand_name":"Blur Coffee"},{"brand_name":"Boogie Board"},{"brand_name":"Bose"},{"brand_name":"Bpearl"},{"brand_name":"Brach's"},{"brand_name":"Braun"},{"brand_name":"Breathe Right"},{"brand_name":"Bri Nutrition"},{"brand_name":"Brita"},{"brand_name":"Bronson"},{"brand_name":"Brooksbrother"},{"brand_name":"Brookside"},{"brand_name":"Buffalo"},{"brand_name":"Bulgari"},{"brand_name":"Burberry"},{"brand_name":"Burpy"},{"brand_name":"Burt's Bees"},{"brand_name":"By-Health"},{"brand_name":"Cabo Creme"},{"brand_name":"Cacafe Coconut"},{"brand_name":"Caffe D'Vita"},{"brand_name":"Calif"},{"brand_name":"California Baby"},{"brand_name":"California Gold Nutrition"},{"brand_name":"Caltrate"},{"brand_name":"Calvin Klein"},{"brand_name":"Caramel"},{"brand_name":"Carter's"},{"brand_name":"Cat"},{"brand_name":"Caudalie"},{"brand_name":"Cellular"},{"brand_name":"Centrum"},{"brand_name":"Cerave"},{"brand_name":"Cetaphil"},{"brand_name":"Champion"},{"brand_name":"Chanel"},{"brand_name":"Chantecaille"},{"brand_name":"Charlotte Tilbury"},{"brand_name":"Chbassco"},{"brand_name":"Cheeky Chompers"},{"brand_name":"Cheezit"},{"brand_name":"Childlife"},{"brand_name":"Children's"},{"brand_name":"Chocolove"},{"brand_name":"Chrome Hearts"},{"brand_name":"Cicatricure"},{"brand_name":"Citizen"},{"brand_name":"Citracal"},{"brand_name":"CK"},{"brand_name":"Clarins"},{"brand_name":"Claritin"},{"brand_name":"Clarks"},{"brand_name":"Clear Care"},{"brand_name":"Clinique"},{"brand_name":"Coach"},{"brand_name":"Coach's Oats"},{"brand_name":"Coastal Bay"},{"brand_name":"Cole Haan"},{"brand_name":"Colgate"},{"brand_name":"Colourpop"},{"brand_name":"Columbia"},{"brand_name":"Comfort Revolution"},{"brand_name":"Comotomo"},{"brand_name":"Comvita"},{"brand_name":"Contigo"},{"brand_name":"Converse"},{"brand_name":"Coppertone"},{"brand_name":"Cosamin"},{"brand_name":"Costco"},{"brand_name":"Crabtree &amp; Evelyn"},{"brand_name":"Cranberry"},{"brand_name":"Crayola"},{"brand_name":"Crescent White"},{"brand_name":"Crest"},{"brand_name":"Crispy"},{"brand_name":"Crocs"},{"brand_name":"Crystal Star"},{"brand_name":"Culturelle"},{"brand_name":"Curad"},{"brand_name":"Curcumin"},{"brand_name":"Cvs"},{"brand_name":"Dermalogica"},{"brand_name":"Desitin"},{"brand_name":"Detoxification Package Kit"},{"brand_name":"Diabetics"},{"brand_name":"Dione"},{"brand_name":"Dior"},{"brand_name":"Disney"},{"brand_name":"Dkny"},{"brand_name":"Dna Miracles"},{"brand_name":"Dosha"},{"brand_name":"Dove"},{"brand_name":"Downy"},{"brand_name":"Dr.Brown's"},{"brand_name":"Dr.Martens"},{"brand_name":"Dream"},{"brand_name":"Dscp"},{"brand_name":"Dulcolax"},{"brand_name":"Earth's Best"},{"brand_name":"Ecco"},{"brand_name":"Egyptian Magic"},{"brand_name":"Elizabetharden"},{"brand_name":"Emergen-C"},{"brand_name":"Enfagrow"},{"brand_name":"Enfamil"},{"brand_name":"Enfocus"},{"brand_name":"Eos"},{"brand_name":"Epic"},{"brand_name":"Epoch"},{"brand_name":"Erno Laszlo"},{"brand_name":"Essential Living"},{"brand_name":"Est\u00e9e Lauder"},{"brand_name":"Estroven"},{"brand_name":"Eucerin"},{"brand_name":"Exergen"},{"brand_name":"Exofficio"},{"brand_name":"Febreze"},{"brand_name":"Feelgood"},{"brand_name":"Felina"},{"brand_name":"Fergablence"},{"brand_name":"Ferrero Rocher"},{"brand_name":"Fiber Well"},{"brand_name":"Fila"},{"brand_name":"Finest"},{"brand_name":"Firly"},{"brand_name":"Fisherprice"},{"brand_name":"Fit Crunch"},{"brand_name":"Fitflop"},{"brand_name":"Fixt Pimklite"},{"brand_name":"Fjall Raven"},{"brand_name":"Fjallraven"},{"brand_name":"Flappy"},{"brand_name":"Flonase"},{"brand_name":"Focusfactor"},{"brand_name":"Foreo"},{"brand_name":"Fresh"},{"brand_name":"Frye"},{"brand_name":"Fungi Nail"},{"brand_name":"Furla"},{"brand_name":"G-Shock"},{"brand_name":"Gabor"},{"brand_name":"Gap"},{"brand_name":"Garanimals"},{"brand_name":"Garbath"},{"brand_name":"Garden Of Life"},{"brand_name":"General Mills"},{"brand_name":"Geox"},{"brand_name":"Gerber"},{"brand_name":"Ghirardelli"},{"brand_name":"Gidova"},{"brand_name":"Gillette"},{"brand_name":"Giorgio Armani"},{"brand_name":"Girls"},{"brand_name":"Givenchy"},{"brand_name":"Glucosatrin"},{"brand_name":"Gnc"},{"brand_name":"Godiva"},{"brand_name":"Grandma's Secret"},{"brand_name":"Green Food"},{"brand_name":"Greenerways Organic"},{"brand_name":"Gucci"},{"brand_name":"Gucci Bloom"},{"brand_name":"Gudrun"},{"brand_name":"Guerlain"},{"brand_name":"Guess"},{"brand_name":"Happybaby"},{"brand_name":"Happytot"},{"brand_name":"Harina Pan Blanca"},{"brand_name":"Harry Potter"},{"brand_name":"Havaianas"},{"brand_name":"Health Pro"},{"brand_name":"Healthycell"},{"brand_name":"Heart Health"},{"brand_name":"Hello Kitty"},{"brand_name":"Herbatint"},{"brand_name":"Hey's"},{"brand_name":"Hi-Chew"},{"brand_name":"Hisamitsu"},{"brand_name":"Holista Bee Propolis"},{"brand_name":"Honest"},{"brand_name":"Hong Sam Won"},{"brand_name":"Hoody's"},{"brand_name":"Hoola"},{"brand_name":"Htls"},{"brand_name":"Huda Beauty"},{"brand_name":"Hudabeauty"},{"brand_name":"Hudson &amp; Barrow"},{"brand_name":"Hugfun"},{"brand_name":"Huggies"},{"brand_name":"Hugo Boss"},{"brand_name":"Hunter For Target"},{"brand_name":"Hurley"},{"brand_name":"Hyper Biotics"},{"brand_name":"I Can Read"},{"brand_name":"Inc"},{"brand_name":"Incasa"},{"brand_name":"Infinite Aloe Skin Care"},{"brand_name":"Innofoods"},{"brand_name":"Ipanema"},{"brand_name":"Iplay"},{"brand_name":"Isotonix"},{"brand_name":"J-Bio"},{"brand_name":"Jarrow"},{"brand_name":"Jcrew"},{"brand_name":"Jockey"},{"brand_name":"Jodan"},{"brand_name":"Jollyrancher"},{"brand_name":"Joys"},{"brand_name":"Juice Couture"},{"brand_name":"Kate Perry"},{"brand_name":"Kate Spade"},{"brand_name":"Keds"},{"brand_name":"Keebler"},{"brand_name":"Kellogg's"},{"brand_name":"Kelo-Cote"},{"brand_name":"Kenneth Cole"},{"brand_name":"Khombu"},{"brand_name":"Kiehl's"},{"brand_name":"Kirkland Signature"},{"brand_name":"L'Agence"},{"brand_name":"L'Il Critters"},{"brand_name":"La Dolce Vita"},{"brand_name":"La Grande Galette"},{"brand_name":"La Tourangelle"},{"brand_name":"Lacoste"},{"brand_name":"Lamer"},{"brand_name":"Lamy"},{"brand_name":"Lanc?me"},{"brand_name":"Lansinoh"},{"brand_name":"Lapcos"},{"brand_name":"Laserx"},{"brand_name":"Laura Mercier"},{"brand_name":"Le Chef Patissier"},{"brand_name":"Lego"},{"brand_name":"Levi\u2019S"},{"brand_name":"Life Beach"},{"brand_name":"Life's Dha"},{"brand_name":"Lilys"},{"brand_name":"Lindor"},{"brand_name":"Little"},{"brand_name":"Livatone"},{"brand_name":"Lotrimin"},{"brand_name":"Lotus"},{"brand_name":"Lotus Biscoff"},{"brand_name":"Loue Crunch"},{"brand_name":"Lovaza"},{"brand_name":"Lovebaby"},{"brand_name":"Lubriderm"},{"brand_name":"Lululemon"},{"brand_name":"Luna"},{"brand_name":"Luna Mini"},{"brand_name":"Lush"},{"brand_name":"M&amp;M's"},{"brand_name":"Mac"},{"brand_name":"Macfarms"},{"brand_name":"Mageformers"},{"brand_name":"Mai2"},{"brand_name":"Maltesers"},{"brand_name":"Manhattan"},{"brand_name":"Marc Jacobs"},{"brand_name":"Mariani"},{"brand_name":"Mars"},{"brand_name":"Matty"},{"brand_name":"Maximum Prostate Care"},{"brand_name":"Maximum Strength"},{"brand_name":"Mccormick"},{"brand_name":"Mcm"},{"brand_name":"Mederma"},{"brand_name":"Meiji"},{"brand_name":"Melatonin"},{"brand_name":"Melissa"},{"brand_name":"Melora"},{"brand_name":"Melrose Market"},{"brand_name":"Memory Foam"},{"brand_name":"Merrell"},{"brand_name":"Meta Mucil"},{"brand_name":"Meta-Align"},{"brand_name":"Metamucil"},{"brand_name":"Michael Kors"},{"brand_name":"Mifold"},{"brand_name":"Milano"},{"brand_name":"Milkthistle"},{"brand_name":"Miumiu"},{"brand_name":"Mk"},{"brand_name":"Mlb"},{"brand_name":"Modern Renaissance"},{"brand_name":"Mommy's Bliss"},{"brand_name":"Moroccanoil"},{"brand_name":"Mosquito"},{"brand_name":"Mott's"},{"brand_name":"Movado"},{"brand_name":"Munchkin"},{"brand_name":"Muscletech"},{"brand_name":"Mutricentials"},{"brand_name":"Nabisco"},{"brand_name":"Nars"},{"brand_name":"Nasacort"},{"brand_name":"Natrol"},{"brand_name":"Natrol Yohimbe Bark"},{"brand_name":"Natrue Bounty"},{"brand_name":"Natural Care"},{"brand_name":"Nature Made"},{"brand_name":"Nature Spec"},{"brand_name":"Nature Valley"},{"brand_name":"Nature Well"},{"brand_name":"Nature'S Bounty"},{"brand_name":"Nature's Nutra"},{"brand_name":"Nature's Plus"},{"brand_name":"Nature's Way"},{"brand_name":"Naturespec"},{"brand_name":"Naturewell"},{"brand_name":"Nature\u2019S Bounty"},{"brand_name":"Nautica"},{"brand_name":"Neilmed"},{"brand_name":"Neocell"},{"brand_name":"Neosporin"},{"brand_name":"Neprinol"},{"brand_name":"Nescafe"},{"brand_name":"Nestea"},{"brand_name":"Neutrogena"},{"brand_name":"New Era"},{"brand_name":"Nexium"},{"brand_name":"Nickelodeon"},{"brand_name":"Nido"},{"brand_name":"Nike"},{"brand_name":"Nine West"},{"brand_name":"Nizoral"},{"brand_name":"No7"},{"brand_name":"Nordic Naturals"},{"brand_name":"North Face"},{"brand_name":"Nosefrida"},{"brand_name":"Notary File"},{"brand_name":"Now"},{"brand_name":"Now Foods"},{"brand_name":"Now Fresh"},{"brand_name":"Nu Skin"},{"brand_name":"Nuby"},{"brand_name":"Nuskin"},{"brand_name":"Nutella"},{"brand_name":"Nutriclean"},{"brand_name":"Ny"},{"brand_name":"Nyx"},{"brand_name":"Ocean Spray"},{"brand_name":"Ocuvite"},{"brand_name":"Olaplex"},{"brand_name":"Olay"},{"brand_name":"On"},{"brand_name":"One A Day"},{"brand_name":"Oral-B"},{"brand_name":"Origins"},{"brand_name":"Orlando Pita"},{"brand_name":"Osteo"},{"brand_name":"Oxo"},{"brand_name":"Palladium"},{"brand_name":"Palmer's"},{"brand_name":"Pandora"},{"brand_name":"Parakito"},{"brand_name":"Parent's Choice"},{"brand_name":"Parker"},{"brand_name":"Peanut Butter"},{"brand_name":"Peck &amp; Peck"},{"brand_name":"Pediasure"},{"brand_name":"Peeka Boo"},{"brand_name":"Penguin"},{"brand_name":"Pepperidge Farm"},{"brand_name":"Peter"},{"brand_name":"Peter Thomas Roth"},{"brand_name":"Pharmanex"},{"brand_name":"Philips"},{"brand_name":"Philips Avent"},{"brand_name":"Philosophy"},{"brand_name":"Pirouline"},{"brand_name":"Plackers"},{"brand_name":"Plum"},{"brand_name":"Polo Ralph Lauren"},{"brand_name":"Popcorners"},{"brand_name":"Post"},{"brand_name":"Prada"},{"brand_name":"Preparation H"},{"brand_name":"Preservision"},{"brand_name":"Prevent"},{"brand_name":"Prime"},{"brand_name":"Probiotic-10"},{"brand_name":"Puff"},{"brand_name":"Puma"},{"brand_name":"Pur"},{"brand_name":"Pure Alaska Omega"},{"brand_name":"Puritan's Pride"},{"brand_name":"Purity"},{"brand_name":"Quaker"},{"brand_name":"Quick Shelter"},{"brand_name":"Qunol"},{"brand_name":"Rag &amp; Bone"},{"brand_name":"Rayban"},{"brand_name":"Reese's"},{"brand_name":"Refa"},{"brand_name":"Refresh"},{"brand_name":"Remedies"},{"brand_name":"Revlon"},{"brand_name":"Ricola"},{"brand_name":"Ringoffire"},{"brand_name":"Ritz"},{"brand_name":"Rogaine"},{"brand_name":"Rubbermaid"},{"brand_name":"Russell Stover"},{"brand_name":"Rustic"},{"brand_name":"Salonpas"},{"brand_name":"Samsonite"},{"brand_name":"Savanna"},{"brand_name":"Scaraway"},{"brand_name":"Schiff Megared"},{"brand_name":"Schiff Move Free"},{"brand_name":"Scientific Explorer"},{"brand_name":"Seaweed?"},{"brand_name":"See's Candies"},{"brand_name":"Selec"},{"brand_name":"Sensodyne"},{"brand_name":"Sephora"},{"brand_name":"Sharpie"},{"brand_name":"Shiseido"},{"brand_name":"Silk'n"},{"brand_name":"Similac"},{"brand_name":"Simple"},{"brand_name":"Sk-Ii"},{"brand_name":"Skechers"},{"brand_name":"Skinny Mint"},{"brand_name":"Skippy"},{"brand_name":"Sleepsack"},{"brand_name":"Smartypants"},{"brand_name":"Snappy"},{"brand_name":"Snapware"},{"brand_name":"Solar Escape"},{"brand_name":"Speed Stick"},{"brand_name":"Speedo"},{"brand_name":"Sperry"},{"brand_name":"Stampd"},{"brand_name":"Starbucks"},{"brand_name":"Steep"},{"brand_name":"Steve Madden"},{"brand_name":"Stila"},{"brand_name":"Storck Mamba"},{"brand_name":"Stretch-Tite"},{"brand_name":"Stricectin"},{"brand_name":"Strivectin"},{"brand_name":"Suave Kids"},{"brand_name":"Sulwhasoo"},{"brand_name":"Summer's Eve"},{"brand_name":"Sun Day"},{"brand_name":"Sunchips"},{"brand_name":"Sunmaid"},{"brand_name":"Sunny Crunch"},{"brand_name":"Superdry"},{"brand_name":"Supreme"},{"brand_name":"Swarovski"},{"brand_name":"Swell"},{"brand_name":"Swiss Miss"},{"brand_name":"Swisse"},{"brand_name":"Swoosh"},{"brand_name":"T&amp;J"},{"brand_name":"T3"},{"brand_name":"Talbots"},{"brand_name":"Taste Good"},{"brand_name":"Tf Sample"},{"brand_name":"Thayers"},{"brand_name":"The Body Shoptbs"},{"brand_name":"The Flat Stanley"},{"brand_name":"The Honestco"},{"brand_name":"The Wild Mushroom"},{"brand_name":"Theo"},{"brand_name":"Thermoflask"},{"brand_name":"Thinkbaby"},{"brand_name":"Tiffany"},{"brand_name":"Timberland"},{"brand_name":"Titan"},{"brand_name":"Toblerone"},{"brand_name":"Tom Ford"},{"brand_name":"Tommee Tippee"},{"brand_name":"Tommy Hilfiger"},{"brand_name":"Toms"},{"brand_name":"Tory Burch"},{"brand_name":"Trace Minerals"},{"brand_name":"Trader Joe's"},{"brand_name":"Trader Joes"},{"brand_name":"Traditional Medicinals"},{"brand_name":"Tretorn"},{"brand_name":"Tri-Cool"},{"brand_name":"Trident"},{"brand_name":"Trim Tea"},{"brand_name":"Tropical Fields"},{"brand_name":"Trunature"},{"brand_name":"Tumi"},{"brand_name":"Tums"},{"brand_name":"Turmeric Curcumin"},{"brand_name":"Tylenol"},{"brand_name":"U.S. Polo"},{"brand_name":"Ugg"},{"brand_name":"Ultimate"},{"brand_name":"Under Armour"},{"brand_name":"Up&amp;Up"},{"brand_name":"Urban Decay"},{"brand_name":"Us Polo"},{"brand_name":"Usana"},{"brand_name":"Valentino"},{"brand_name":"Vans"},{"brand_name":"Vaseline"},{"brand_name":"Vega One"},{"brand_name":"Veja"},{"brand_name":"Venicare"},{"brand_name":"Vibram"},{"brand_name":"Victoria S Secret"},{"brand_name":"Vitafusion"},{"brand_name":"Vitamin World"},{"brand_name":"Voluspa"},{"brand_name":"Weider"},{"brand_name":"Weider Prime"},{"brand_name":"Whey"},{"brand_name":"Wildfox"},{"brand_name":"Wilson"},{"brand_name":"Wonderful"},{"brand_name":"Youtheory"},{"brand_name":"Ysl"},{"brand_name":"Yummi Bears"},{"brand_name":"Yummie"},{"brand_name":"Zarbee's"},{"brand_name":"Zarbees"},{"brand_name":"Zen"},{"brand_name":"Ziploc"},{"brand_name":"Zzzquil"}];

    // 获取货品名称（中文）
    window.user_goods_name = {};

    // 单位所需变量
    window.sunit = [];
    /**
     * 更新锁定状态
     *
     * method   update
     * param    num  增加的数值
     * time    20180202
     * author  gan
     */
    function clock_row(num) {
        var obj = $('#copy_btn');
        if (num >= 30) {
            layer.open({
                title: lay_systemmessage,
                offset: '300px',
                icon: 0,
                content: "快件信息数量到达上限",
            });
            $(obj).addClass('disabled');
            $(obj).attr('disabled', 'disabled');
            return false;
        } else {
            $(obj).removeClass('disabled');
            $(obj).removeAttr('disabled', 'disabled');
            return true;
        }
    }

    /**
     * 添加行
     *
     * method   add row
     * param   {object} info 设置默认值
     * time    20180202
     * author  gan
     */
    function copy_row(info, tax_method) {
        // 设置默认值
        if (info == undefined) {
            info = {
                category_one: '',
                category_two: '',
                brand: '',
                detail: '',
                catname: '',
                spec_unit: '',
                amount: '',
                is_suit: '',
                price: '',
                remark: ''
            };
        }
        // 控制行数的值
        var num = $("#num").val();
        // 只加的值
        var max_row = $('#max_row').val();
        if (clock_row(num)) {
            max_row++;
            $('#max_row').val(max_row);
            num++;

            var str = '';
            str += '<tr class="stta" cid="' + max_row + '">';

            // <!-- 货品列表 -->
            str += '<td class="seleopt goods_width">';
            str += '<div id="app_category_' + max_row + '">';
            str += '<div class="block" id="selec_box">';
            str += '<el-cascader v-model="selectedOptions" placeholder="' + categorys_lng + '" :options="options" filterable @change="goryChange"></el-cascader>';
            str += '<input type="hidden" name="category_one_' + max_row + '" id="cate_one" value="">';
            str += '<input type="hidden" name="category_two_' + max_row + '" id="cate_two" value="">';
            str += '<input type="hidden" id="cate_pirce" value="">';
            str += '</div';
            str += '</div>';
            str += '</td>';

            //<!-- 货品名称(中文) -->
            str += '<td class="detail cnlist_width">';
            str += '<div id="app_detail_' + max_row + '">';
            str += '<el-row class="demo-autocomplete">';
            str += '<el-col :span="20">';
            str += '<el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="' + input_content_lng + '" name="detail_' + max_row + '" @select="handleSelect"></el-autocomplete>';
            str += '</el-col>';
            str += '</el-row>';
            str += '</div>';
            str += '</td>';

            // <!-- 英文品牌 -->
            str += '<td class="brand enlist_width">';
            str += '<div id="app_brand_' + max_row + '">';
            str += '<el-row class="demo-autocomplete">';
            str += '<el-col :span="20">';
            str += '<el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="' + input_content_lng + '" name="brand_' + max_row + '" @select="handleSelect"></el-autocomplete>';
            str += '</el-col>';
            str += '</el-row>';
            str += '</div>';
            str += '</td>';


            //<!-- 单价 -->
            str += '<td class="price pirce_width">';
            str += '<input type="text" name="price_' + max_row + '" class="layui-input" style="width: 83px;" value="' + info.price + '" maxlength="9" onblur="priper(this)">';
            str += '</td>';

            //<!-- 规格/容量 -->
            str += '<td class="catname sunit_width">';
            /*str += '<input type="text" name="catname_' + max_row + '" value="' + info.catname + '" style="width: 60px;display: block;float: left; margin-right:5px;" class="layui-input">';
            str += '<div id="app_sunit_' + max_row + '" style="display: inline-block;width: 106px;">';
            str += '<el-row class="demo-autocomplete">';
            str += '<el-col :span="50">';
            str += '<el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="' + l_plan_unit + '" name="spec_unit_' + max_row + '" @select=""></el-autocomplete>';
            str += '</el-col>';
            str += '</el-row>';
            str += '</div>';*/
            str += '<input type="text" name="catname_' + max_row + '" value="' + info.catname + '" class="layui-input">';
            str += '</td>';

            //<!-- 数量 -->
            str += '<td class="amount amount_width">';
            str += '<input type="text" name="amount_' + max_row + '" value="' + info.amount + '" class="layui-input" style="width: 60px;" maxlength="9" onblur="amper(this)">';
            str += '</td>';

            //<!-- 是否套装 -->
            /*str += '<td class="isall_width">';
            str += '<input type="checkbox" name="is_suit_' + max_row + '" lay-ignore value="1" style="margin:0;vertical-align: middle;margin-top: -2px;cursor: pointer;" />';
            str += '</td>';*/

            //<!-- 税金 -->
            //str += '<td class="chuijin tax_width"><label>0.00</label></td>';

            //<!-- 产地 -->
            str += '<td style="display: none">';
            str += '<input type="text" name="source_area_' + max_row + '" value="美国" class="clzhong" maxlength="9">';
            str += '</td>';

            //<!-- 货币 -->
            str += '<input type="hidden" name="coin_' + max_row + '" value="USD">';

            //<!-- 备注 -->
            str += '<td class="reamk_width">';
            str += '<input type="text" value="' + info.remark + '" name="remark_' + max_row + '" style="width: 145px;" placeholder="' + order_info_lng + '" class="layui-input">';
            str += '</td>';

            //<!-- 删除 -->
            str += '<td class="copy_r"><a onclick="del_row(this)" class="layui-btn layui-btn-xs">' + l_del_lng + '</a></td>';
            str += '<input type="hidden" name="oid_' + max_row + '" value=""/>';

            str += '</tr>';


            $("#table").append(str);
            $("#num").val(num);
            unit_element_input(max_row, info.spec_unit);

            ele_cascader(max_row, [info.category_one, info.category_two], tax_method);
            ele_brand_select(max_row, info.brand);
            ele_input(max_row, info.detail);


            var is_suit_l = info.is_suit;
            if (is_suit_l == 1) {
                $('input[name="is_suit_' + max_row + '"]').eq(0).prop('checked', true);
            }
        }
    }

    /**
     * 删除行
     *
     * method   del
     * param   {object} obj 当前对象
     * time    20180202
     * author  gan
     */
    function del_row(obj) {
        var num = $("#num").val();
        num--;
        $("#num").val(num);
        var max_row = $("#max_row").val();
        max_row--;
        $("#max_row").val(max_row);
        // console.log(window.acname);
        if (window.acname == 'edit') {
            var ttc = $(obj).parent().parent().find('.ttc').attr('value');

            layer.confirm(lay_del, {
                icon: 3,
                offset: '300px',
                btn: [lay_btnok, lay_btncancel],
                title: lay_information
            }, function () {
                if (ttc) {
                    $.ajax({
                        url: orderdel_url,
                        type: "POST",
                        data: {
                            'ttc': ttc,
                            '_token':$("input[name=_token]").val()
                        },
                        dataType: "json",
                        success: function (result) {
                            if (result.state == 200) {
                                layer.msg(result.msg, {
                                    icon: 6,
                                    offset: '350px'
                                });
                                $(obj).parent().parent('tr').remove();
                                clock_row(num);
                            } else {
                                num++;
                                $("#num").val(num);
                                layer.open({
                                    type: 0,
                                    title: lay_systemmessage,
                                    content: result.msg,
                                    icon: 5,
                                    offset: '300px',
                                    btn: lay_btnok,
                                });
                            }
                        }
                    });
                } else {
                    $(obj).parent().parent().remove();
                    layer.msg( {
                        icon: 6,
                        offset: '350px'
                    });
                    clock_row(num);
                }
            });
        } else {
            $(obj).parent().parent('tr').remove();
            clock_row(num);
        }
        getsum();
    }
</script>
<script type="text/javascript">
    $('#download_btn').click(function(){
        var lineid = $("input[name='line_id']:checked").val();
        var linename = $("input[name='line_id']:checked").next().text();
        window.location.href="/download/download_order_goods"+'?line_id='+lineid+'&name='+linename;
    });

    /**
     * 单价计税
     *
     * @-method   tax
     * @-param   {object} obj 当前对象
     * @-time    20180202
     * @-author  gan
     */
    function priper(obj){
        var showglod = $(obj).parent('td').siblings('.chuijin').find('label');
        var thisv = $(obj).val();
        // var selpric = $(obj).parent('td').siblings('.seleopt').children().next().find("option:selected").attr("price");
        var selpric = $(obj).parent().siblings('.seleopt').find('#cate_pirce').val()
        var aminput = $(obj).parent('td').siblings('.amount').find('input').val();
        var upri =  (thisv*selpric*aminput)/100;
        var percen = upri.toFixed(2);
        if(isNaN(percen)){
            $(showglod).html('0.00');
        }else{
            $(showglod).html(percen);
        }
        getsum();
    }

    /**
     * 数量计税
     *
     * @-method   tax（计算方式：(税金*数量*单价)/100）
     * @-param   {object} obj 当前对象
     * @-time    20180202
     * @-author  gan
     */
    function amper(obj){
        var showglod = $(obj).parent('td').siblings('.chuijin').find('label');
        var thisv = $(obj).val();
        // var selpric = $(obj).parent('td').siblings('.seleopt').children().next().find("option:selected").attr("price");
        var selpric = $(obj).parent().siblings('.seleopt').find('#cate_pirce').val();
        var priinput = $(obj).parent('td').siblings('.price').find('input').val();
        var upri =  (thisv*selpric*priinput)/100;
        var percen = upri.toFixed(2);
        if(isNaN(percen)){
            $(showglod).html('0.00');
        }else{
            $(showglod).html(percen);
        }
        getsum();
    }

    //检查是否存在空行
    function is_empty_line(line){

        var inp = line.children().find('input');
        var sele = line.children().find('select');

        var stop = true;

        $.each(inp,function(k,v){
            if($(v).attr('class') != 'clzhong' && $(v).attr('type') != 'checkbox'){
                if($(v).val() != ''){
                    stop = false;
                    return false;
                }
            }

        });
        return stop;
    }

    //循环检测分类的id值
    function loop_cascader(l_val, l_find){
        var res = [];
        $.each(l_val,function(k,v){
            if(v.label == l_find){
                res = [v.value,v.children];
                return false;
            }
        });

        return res;
    }

    function getsum(){
        var totalMoney = 0;
        $('tr').each(function (index, item) {
            var price = parseFloat($(item).children(".price").children().val()) || 0;
            var amount = parseInt($(item).children(".amount").children().val()) || 0;
            totalMoney += price*amount;
        });
        console.log(totalMoney);
        $("#money").text(parseFloat(totalMoney).toFixed(2));
    }

</script>
