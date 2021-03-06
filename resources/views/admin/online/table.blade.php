@if(!$data)
    @for($i = 1;$i < 5;$i++)
        <tr class="stta" cid="{{$i}}">
            <td class="seleopt goods_width">
                <div id="app_category_{{$i}}">
                    <div id="selec_box" class="block">
                        <el-cascader v-model="selectedOptions" placeholder="请选择:一级类别/二级类别" :options="options" filterable @change="goryChange"></el-cascader>
                        <input type="hidden" name="category_one_{{$i}}" id="cate_one" value="">
                        <input type="hidden" name="category_two_{{$i}}" id="cate_two" value="">
                        <input type="hidden" id="cate_pirce" value="">
                    </div>
                </div>
            </td>
            <td class="detail cnlist_width">
                <div id="app_detail_{{$i}}">
                    <el-row class="demo-autocomplete">
                        <el-col :span="20">
                            <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入内容" name="detail_{{$i}}" @select="handleSelect"></el-autocomplete>
                        </el-col>
                    </el-row>
                </div>
            </td>
            <td class="brand enlist_width">
                <div id="app_brand_{{$i}}">
                    <el-row class="demo-autocomplete">
                        <el-col :span="20">
                            <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入内容" name="brand_{{$i}}" @select="handleSelect"></el-autocomplete>
                        </el-col>
                    </el-row>
                </div>
            </td>
            <td class="price pirce_width">
                <input type="text" name="price_{{$i}}" class="layui-input" style="width: 83px;" value="" maxlength="9" onblur="priper(this)">
            </td>
            <td class="catname sunit_width">
                <!--
                <input type="text" name="catname_{{$i}}" value="" style="width: 60px;display: block;float: left; margin-right:5px;" class="layui-input">
                <div id="app_sunit_{{$i}}" style="display: inline-block; width: 106px;">
                    <el-row class="demo-autocomplete">
                       <el-col :span="50">
                           <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入单位" name="spec_unit_{{$i}}" @select=""></el-autocomplete>
                       </el-col>
                   </el-row>
                </div>
                -->
                    <input type="text" name="catname_{{$i}}" value="" class="layui-input">
            </td>
            <td class="amount amount_width">
                <input type="text" name="amount_{{$i}}" value="" class="layui-input" style="width: 60px;" maxlength="9" onblur="amper(this)">
            </td>

            <!-- 是否套装
            <td class="isall_width">
                <input type="checkbox" name="is_suit_{{$i}}" value="1" style="margin:0;vertical-align: middle;margin-top: -2px;cursor: pointer;" lay-ignore>
            </td>
            -->

            <td style="display: none">
                <input type="text" name="source_area_{{$i}}" value="美国" class="clzhong" maxlength="9">
            </td>
            <input type="hidden" name="coin_{{$i}}" value="USD">
            <td class="reamk_width">
                <input type="text" value="" name="remark_{{$i}}" style="width: 145px;" placeholder="可填写货号等信息" class="layui-input">
            </td>
            <td class="copy_r"><a onclick="del_row(this)" class="layui-btn layui-btn-xs">删除</a>
            </td>
            <input type="hidden" name="oid_{{$i}}" value="">
        </tr>
        <script>
            // 为快件信息设置默认值
            // 添加页面设置为空值
            // 修改页面设置为默认值
            $(function(){
                if("{{$type}}" == 'index'){
                    unit_element_input("{{$i}}");
                    // 添加页面
                    // 调用默认级联
                    ele_cascader("{{$i}}",[],0);
                    // 下单页需加载
                    ele_input("{{$i}}");
                    ele_brand_select("{{$i}}");
                    window.sunit["{{$i}}"].restaurants = [];
                }else if("{{$type}}" == 'edit' || "{{$type}}" == 'newOrder'){
                    unit_element_input("0","100g");
                    // 编辑页面
                    var n = 0;
                    // 装载级联选择器的默认选中项
                    var def = [];
                    // 遍历载入数据
                    def.push("576");
                    def.push("1615");
                    ele_cascader("0",def,0);
                    def = [];
                    ele_input("0","水电费");
                    ele_brand_select("0","test");
                }else{
                    unit_element_input("0","100g");
                    // 批量下单页面
                    var n = 0;
                    // 装载级联选择器的默认选中项
                    var def = [];
                    // 遍历载入数据
                    var category_one = "576";
                    var category_two = "1615";
                    var res1,res2;
                    res1 = loop_cascader(globa_selec_gory.options,category_one);
                    category_one = res1[0];
                    if(res1[1] != undefined){
                        res2 = loop_cascader(res1[1],category_two);
                        category_two = res2[0];
                    }
                    def.push(category_one);
                    def.push(category_two);
                    ele_cascader("0",def,0);
                    def = [];
                    ele_input("0","水电费");
                    ele_brand_select("0","test");
                }
            });
        </script>
    @endfor
@else
    @foreach($data as $i=>$val)
        @php
        $i++;
        @endphp
        <tr class="stta" cid="{{$i}}">
            <td class="seleopt goods_width">
                <div id="app_category_{{$i}}">
                    <div id="selec_box" class="block">
                        <el-cascader v-model="selectedOptions" placeholder="请选择:一级类别/二级类别" :options="options" filterable @change="goryChange"></el-cascader>
                        <input type="hidden" name="category_one_{{$i}}" id="cate_one_{{$i}}" value="{{$val['category_one']}}">
                        <input type="hidden" name="category_two_{{$i}}" id="cate_two_{{$i}}" value="{{$val['category_two']}}">
                        <input type="hidden" id="cate_pirce" value="">
                    </div>
                </div>
            </td>
            <td class="detail cnlist_width">
                <div id="app_detail_{{$i}}">
                    <el-row class="demo-autocomplete">
                        <el-col :span="20">
                            <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入内容" name="detail_{{$i}}" @select="handleSelect"></el-autocomplete>
                        </el-col>
                    </el-row>
                </div>
            </td>
            <td class="brand enlist_width">
                <div id="app_brand_{{$i}}">
                    <el-row class="demo-autocomplete">
                        <el-col :span="20">
                            <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入内容" name="brand_{{$i}}" @select="handleSelect"></el-autocomplete>
                        </el-col>
                    </el-row>
                </div>
            </td>
            <td class="price pirce_width">
                <input type="text" name="price_{{$i}}" class="layui-input" style="width: 83px;" value="{{$val['price']}}" maxlength="9" onblur="priper(this)">
            </td>
            <td class="catname sunit_width">
            <!--
                <input type="text" name="catname_{{$i}}" value="" style="width: 60px;display: block;float: left; margin-right:5px;" class="layui-input">
                <div id="app_sunit_{{$i}}" style="display: inline-block; width: 106px;">
                    <el-row class="demo-autocomplete">
                       <el-col :span="50">
                           <el-autocomplete class="inline-input" clearable v-model="state1" :fetch-suggestions="querySearch" placeholder="请输入单位" name="spec_unit_{{$i}}" @select=""></el-autocomplete>
                       </el-col>
                   </el-row>
                </div>
                -->
                <input type="text" name="catname_{{$i}}" value="{{$val['catname']}}" class="layui-input">
            </td>
            <td class="amount amount_width">
                <input type="text" name="amount_{{$i}}" value="{{$val['amount']}}" class="layui-input" style="width: 60px;" maxlength="9" onblur="amper(this)">
            </td>

        <!-- 是否套装
            <td class="isall_width">
                <input type="checkbox" name="is_suit_{{$i}}" value="1" style="margin:0;vertical-align: middle;margin-top: -2px;cursor: pointer;" lay-ignore>
            </td>
            -->

            <td style="display: none">
                <input type="text" name="source_area_{{$i}}" value="美国" class="clzhong" maxlength="9">
            </td>
            <input type="hidden" name="coin_{{$i}}" value="USD">
            <td class="reamk_width">
                <input type="text" value="{{$val['remark']}}" name="remark_{{$i}}" style="width: 145px;" placeholder="可填写货号等信息" class="layui-input">
            </td>
            <td class="copy_r"><a onclick="del_row(this)" class="layui-btn layui-btn-xs">删除</a>
            </td>
            <input type="hidden" name="oid_{{$i}}" value="{{$val['id']}}">
        </tr>
        <script>
            // 为快件信息设置默认值
            // 添加页面设置为空值
            // 修改页面设置为默认值
            $(function(){
                if("{{$type}}" == 'index'){
                    unit_element_input("{{$i}}");
                    // 添加页面
                    // 调用默认级联
                    ele_cascader("{{$i}}",[],0);
                    // 下单页需加载
                    ele_input("{{$i}}");
                    ele_brand_select("{{$i}}");
                    window.sunit["{{$i}}"].restaurants = [];
                }else if("{{$type}}" == 'edit' || "{{$type}}" == 'newOrder'){
                    unit_element_input("{{$i}}");
                    // 编辑页面
                    var n = 0;
                    // 装载级联选择器的默认选中项
                    var def = [];
                    // 遍历载入数据
                    def.push({{$val['category_one']}});
                    def.push({{$val['category_two']}});
                    ele_cascader("{{$i}}",def,0);
                    def = [];
                    ele_input("{{$i}}","{{$val['detail']}}");
                    ele_brand_select("{{$i}}","{{$val['brand']}}");
                }else{
                    unit_element_input("0","100g");
                    // 批量下单页面
                    var n = 0;
                    // 装载级联选择器的默认选中项
                    var def = [];
                    // 遍历载入数据
                    var category_one = "{{$val['category_one']}}";
                    var category_two = "{{$val['category_two']}}";
                    var res1,res2;
                    res1 = loop_cascader(globa_selec_gory.options,category_one);
                    category_one = res1[0];
                    if(res1[1] != undefined){
                        res2 = loop_cascader(res1[1],category_two);
                        category_two = res2[0];
                    }
                    def.push(category_one);
                    def.push(category_two);
                    ele_cascader("{{$i}}",def,0);
                    def = [];
                    ele_input("{{$i}}","{{$val['detail']}}");
                    ele_brand_select("{{$i}}","{{$val['brand']}}");
                }
            });
        </script>
    @endforeach
@endif