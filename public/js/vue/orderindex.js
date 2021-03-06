

//选择收件人按钮
function infoselect(obj){
    layer.open({
        type: 2,
        title: l_cho_rec,
        skin: 'demo-class',//自定义样式demo-class
        area : ['800px' , '600px'],
        // offset: '20%',
        closeBtn: 1,
        content: selectRecipient,
    });
}
// 选择收件人数据
function get_addrinfo(addr_id,info){
    if(addr_id == undefined){
        layer.msg('请选择收件人', {icon: 5});
        return false;
    }else if(addr_id != ''){
        if(info == ''){
            $.ajax({
                url: '/user/receiver/'+addr_id+'/edit',
                type:'GET', //GET
                cache: false,
                dataType:'json', 
                beforeSend:function(){
                    showLoading();
                },   
                success:function(data){
                    Redata(data);
                },
                complete:function(){
                    closeAllLoading();
                }
            });
        }else{
            Redata(info);
        }
    }
}

// 选择线路特效
function changeline(obj,addr_id,result){
    var p = $(obj).val();
    if(addr_id==0 && typeof(window.w_id) != "undefined"){
        addr_id = window.w_id;
    }
    // 获取选中线路ID
    var t_line = $("input[name='line_id']:checked").val();
    // 调用中国地址函数
    //get_aere(t_line,1);
    window.selec_gory = {options:[category_list[t_line]]};

    //增加判断选中路线产品数据是否已经加载，若无ajax二次加载   2018-10-11 16:47:25
    if (!category_list[t_line]){
        $.ajax({
            url: showProducturl,
            type:'GET',
            cache: false,
            data:{line_id:p},
            dataType:'json',
            success:function(res){
                category_list = res.data;
                window.selec_gory = {options:[category_list[t_line]]};
            }
        });
    }

    //是否显示图片等
    var iupid = $(obj).attr('iupid');
    //切换excel下载地址
    var excel = $(obj).attr('excel');
        // console.log(selec_gory);
    $('#ordbody [id^="line_pice"]').text('');

    $.ajax({
        url: consoleurl,
        dataType:"html",
        data:{
            "line_id":p,
            "addr_id":addr_id,
            "_token":$("input[name=_token]").val(),
            'iupid':iupid,
            'excel':excel,
            'status':result ? result.status : 0,
            'upload_type':result ? result.upload_type : 2,
            'system_order_no':result ? result.system_order_no : '',
            'user_order_no':result ? result.user_order_no : '',
            'addons':result ? result.addons : '',
            id_card_back:result ? result.data.id_card_back : '',
            id_card_front:result ? result.data.id_card_front : ''
        },
        type:"POST",
        cache: false,
        beforeSend:function(){
            //showLoading();
        },
        success:function(html){
            $('#part2').html(html);
        },
        complete:function(){
            //closeAllLoading();
        }
    });
    //显示说明栏
    if(p != '' && p > 0){
        var h = $(".m"+p).html();
        if(h != '<br>'){
            $("#mimenu").html(ShowSelectlng+"："+h);
        }
    }else{
        $("#mimenu").html('');
    }
    updateLayuiForm();
}
//选择寄件人按钮
function addsern(obj){
    layer.open({
        type: 2,
        title: l_select_sender,
        skin: 'demo-class',//自定义样式demo-class
        area : ['800px' , '600px'],
        // offset: '20%',
        closeBtn: 1,
        content: getSenderInfourl,
    });
}
// 选择寄件人数据
function senderAjax(id,info){
    if(id == undefined){
        layer.msg('请选择寄件人', {icon: 5});
        return false;
    }else if(id != ''){
        if(info == ''){
            $.ajax({
                url: '/user/sender/'+id+'/edit',
                type:'GET',
                cache: false,
                dataType:'json', 
                beforeSend:function(){
                    showLoading();
                },  
                success:function(data){
                    Sendata(data);
                },
                complete:function(){
                    closeAllLoading();
                }
            });
        }else{
            Sendata(info);
        }
    }
}

// 证件类型
$(document).ready(function(){
    var chid= $('#Id_tpye').val();
    if(chid == 'PASPORT'){
        // $('#idno').attr("placeholder",Placeholder_IdPT);
        // $('#idno').attr("maxlength","10");
        // $('#idno').attr("data-validation-engine","validate[required]");
    }else if(chid == 'ID'){
        // $('#idno').attr("placeholder",Placeholder_IdNo);
        $('#idno').attr("maxlength","18");
        // $('#idno').attr("data-validation-engine","validate[required,custom[chinaId]]");
    }       
    // 证件类型
    $("#Id_tpye").change(function(){
        var chid= $('#Id_tpye').val();
        if(chid == 'PASPORT'){
            // $('#idno').attr("placeholder",Placeholder_IdPT);
            // $('#idno').attr("maxlength","10");
            // $('#idno').attr("data-validation-engine","validate[required]");
        }else if(chid == 'ID'){
            // $('#idno').attr("placeholder",Placeholder_IdNo);
            $('#idno').attr("maxlength","18");
            // $('#idno').attr("data-validation-engine","validate[required,custom[chinaId]]");
        }
    });
});
// 通过JQform提交
function tempform(obj){
    $(window).unbind('beforeunload');
    if(!$("#tempForm").validationEngine("validate")) return ;
    $(obj).ajaxForm({
        dataType: 'json',
        beforeSend:function(){
            showLoading();
        },
        success: function(data){
            if(data.state == 'no'){
                var msg;
                if(!_empty__(data.no)){
                    msg = '<font color="red">['+l_the_lng+data.no+l_line_lng+']</font>'+data.msg;
                }else{
                    msg = data.msg;
                }
                layer.closeAll('loading'); //关闭加载层
                layer.open({
                    type: 0,
                    offset: '300px',
                    skin: 'demo-class',//自定义样式demo-class
                    shadeClose: true,
                    title: lay_ms,
                    content : msg,
                    icon : 5
                });
                return false;
            }else{
                closeAllLoading();
                window.location.href=data.url;
            }
        },
        complete:function(){
            closeAllLoading();
        }
    });
}
// 收件人返回数据
function Redata(result){
    if(result.status != 200){
        layer.msg('获取数据失败，请手动填写', {icon: 5});
        layer.closeAll('loading'); //关闭加载层
    }else{
        //console.log(data);
        $('#fullName').val(result.data.name);
        //$('#idno').val(result.data.cre_num);
        $("#cre_num").val(result.data.cre_num);
        $('#detaileaddress').val(result.data.addressDetail);
        $('#phone').val(result.data.phone);
        $('#zipcode').val(result.data.code);
        $('#province').val(result.data.province);
        $('#city').val(result.data.city);
        $('#town').val(result.data.town);
        $('#hidaddr_id').val(result.data.id);

        // 是否存在身份证库
        /*if(result.data.addr_img == 2 || result.data.addr_img == 3){
            $('#card_id').val(result.data.lib_idcard);
            $('#addr_pro_img').val('');
            $('#addr_bak_img').val('');
            $('#addr_pro_img_sm').val('');
            $('#addr_bak_img_sm').val('');
        }else if(result.data.addr_img == 1){
            $('#card_id').val('0');
            $('#addr_pro_img').val(result.data.id_card_front_old);
            $('#addr_bak_img').val(result.data.id_card_back_old);
            $('#addr_pro_img_sm').val(result.data.id_card_front_small);
            $('#addr_bak_img_sm').val(result.data.id_card_back_small);
        }*/
        // 身份证
        if(result.data.cre_type == 'PASPORT'){

        }else if(result.data.cre_type == 1){
            $("#Id_tpye").find("option[value='"+result.data.cre_type+"']").attr("selected",true);
            $('#cre_num').attr("placeholder",Placeholder_IdNo);
            $('#cre_num').attr("maxlength","18");
        }
        // 省市区
        var datap = result.data.province;
        var datac = result.data.city;
        var datat = result.data.town;
        var stop = false;
        $.each(window.re_area.options,function(k,v){
            if(v.value.indexOf(datap) != -1){
                set_aere_def([v.value]);
                $.each(v.children,function(k1,v1){
                    if(v1.value.indexOf(datac) != -1){
                        set_aere_def([v.value,v1.value]);
                        $.each(v1.children,function(k2,v2){
                            if(v2.value.indexOf(datat) != -1){
                                set_aere_def([v.value,v1.value,v2.value]);
                                //$('#zipcode').val(v2.zipcode);
                                stop = true;
                                return false;
                            }
                        });
                        if(stop){
                            return false;
                        }
                    }
                });
                if(stop){
                    return false;
                }
            }
        });
        window.setPCT = (function(datap,datac,datat){
            return function(){
                // 省市区
                var stop = false;
                $.each(window.re_area.options,function(k,v){
                    if(v.value.indexOf(datap) != -1){
                        set_aere_def([v.value]);
                        $.each(v.children,function(k1,v1){
                            if(v1.value.indexOf(datac) != -1){
                                set_aere_def([v.value,v1.value]);
                                $.each(v1.children,function(k2,v2){
                                    if(v2.value.indexOf(datat) != -1){
                                        set_aere_def([v.value,v1.value,v2.value]);
                                        //$('#zipcode').val(v2.zipcode);
                                        stop = true;
                                        return false;
                                    }
                                });
                                if(stop){
                                    return false;
                                }
                            }
                        });
                        if(stop){
                            return false;
                        }
                    }
                });
            }
        })(result.data.province,result.data.city,result.data.town);


        // 线路
        /*
        window.w_id = result.data.id;
        if(result.data.line_id == 0 ){
            $("input[name='line_id']:checked").attr('checked',false);
            $("#part2").html("");
            updateLayuiForm();
        }else{
            // 没有选中状态
            $("input[name='line_id']").each(function () {
                if ($(this).val() == result.data.line_id){
                    $(this).attr('checked',true);
                }
            });
            changeline($("input[name='line_id']:checked"),'',result);
        }
        */
        closeAllLoading();
    }
}

// 寄件人返回数据
function Sendata(data){
    var data = data.data;
    //$("#MainContent_ddProvince").find("option:selected").removeAttr("selected");
    //$("#MainContent_ddCity").find("option:selected").removeAttr("selected");
    $('#postname').val(data.name);
    $('#poststreet').val(data.address);
    $('#postcity').val(data.city);
    $('#postphone').val(data.phone);
    $('#postcode').val(data.code);
    $("#postcountry").find("option[value='"+data.country+"']").attr("selected", true);
    $("#postprovince").find("option[value='"+data.province+"']").attr("selected", true);
    closeAllLoading();
    updateLayuiForm();
}

//更新layui-form数据等
function updateLayuiForm() {
    layui.use(['form','layer'], function(){
        var form = layui.form;
        form.render();
    });
}

function closeAllLoading(){
    layui.use(['layer'], function(){
        var layer = layui.layer;
        layer.closeAll('loading'); //关闭加载层
    });
}

function showLoading() {
    layui.use(['layer'], function(){
        var layer = layui.layer;
        layer.load(1, {
            shade: [0.1,'#000'], //0.1透明度的白色背景
            offset: '450px',
        });
    });
}