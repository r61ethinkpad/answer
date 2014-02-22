<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 17:13:07
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:136977066530324231bd691-73905168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c3726fcee8c05eace18bcf9e92e86288494930cf' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/edit.html',
      1 => 1392714781,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '136977066530324231bd691-73905168',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div id="content">
    <div class="tab">
        <?php $_template = new Smarty_Internal_Template("answer/_topTitle.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        <div class="tab-main">
            <p id="udError" class="dBox" style="display:none;"></p>
            <form id="_create_form" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'update','id'=>$_smarty_tpl->getVariable('id')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
" method="post">
                <table class="formList">
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>所属分类：</td>
                        <td class="value">
                            <input type="hidden" name="exam[question_id]" value="<?php echo $_smarty_tpl->getVariable('args')->value['question_id'];?>
"/>
                            <select name="exam[exam_type]" class="input_text" id="exam_type">
                                <option value="">--<?php echo T('any_exam_type');?>
--</option>
                                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_types')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" <?php if ($_smarty_tpl->getVariable('args')->value['exam_type']==$_smarty_tpl->tpl_vars['name']->value){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>

                                <?php }} ?>
                            </select>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['exam_type'];?>
</span>
                        </td>

                    </tr>

                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>所属关卡：</td>
                        <td class="value">
                            <select name="exam[exam_point]" class="input_text" id="exam_point">

                                <option value="">--<?php echo T('any_exam_point');?>
--</option>
                                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_points')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" <?php if ($_smarty_tpl->getVariable('args')->value['exam_point']==$_smarty_tpl->tpl_vars['name']->value){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>

                                <?php }} ?>
                            </select>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['exam_point'];?>
</span>
                        </td>
                    </tr>
                    
                    <tr id="words"><td>&nbsp;</td><td><span id="words_left">&nbsp;</span></td></tr>
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>题目内容：</td>
                        <td class="value">
                            <textarea id="question_content" name="exam[question_content]"  maxlength="500" style="width:500px;height:50px;"><?php echo $_smarty_tpl->getVariable('args')->value['question_content'];?>
</textarea>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['question_content'];?>
</span>
                        </td>
                    <tr><td>&nbsp;</td><td>（题目内容不多于500个字符）</td></tr>
                    
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>备选答案A：</td>
                        <td class="value">
                            <textarea id="alternative_a" name="exam[alternative_a]"  maxlength="300" style="width:500px;height:30px;"><?php echo $_smarty_tpl->getVariable('args')->value['alternative_a'];?>
</textarea>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['alternative_a'];?>
</span>
                        </td>
                    <tr><td>&nbsp;</td><td>（备选答案不多于300个字符）</td></tr>
                    
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>备选答案B：</td>
                        <td class="value">
                            <textarea id="alternative_b" name="exam[alternative_b]"  maxlength="300" style="width:500px;height:30px;"><?php echo $_smarty_tpl->getVariable('args')->value['alternative_b'];?>
</textarea>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['alternative_b'];?>
</span>
                        </td>
                    <tr><td>&nbsp;</td><td>（备选答案不多于300个字符）</td></tr>
                    
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>备选答案C：</td>
                        <td class="value">
                            <textarea id="alternative_c" name="exam[alternative_c]"  maxlength="300" style="width:500px;height:30px;"><?php echo $_smarty_tpl->getVariable('args')->value['alternative_c'];?>
</textarea>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['alternative_c'];?>
</span>
                        </td>
                    <tr><td>&nbsp;</td><td>（备选答案不多于300个字符）</td></tr>
                    
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>备选答案D：</td>
                        <td class="value">
                            <textarea id="alternative_d" name="exam[alternative_d]"  maxlength="300" style="width:500px;height:30px;"><?php echo $_smarty_tpl->getVariable('args')->value['alternative_d'];?>
</textarea>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['alternative_d'];?>
</span>
                        </td>
                    <tr><td>&nbsp;</td><td>（备选答案不多于300个字符）</td></tr>

                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>正确答案：</td>
                        <td class="value">
                            <select name="exam[correct_answer]" class="input_text" id="correct_answer">
                                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('correct_answeres')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" <?php if ($_smarty_tpl->getVariable('args')->value['correct_answer']==$_smarty_tpl->tpl_vars['name']->value){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>

                                <?php }} ?>
                            </select>
                            <span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['correct_answer'];?>
</span>
                        </td>
                    </tr>
                    <tr class="btnBox">
                        <td colspan="2">
                            <span class="sBtn">
                                <a class="left">确定</a><a class="right"></a>
                            </span>
                            <span class="sBtn-cancel">
                                <a class="left" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">返回</a><a class="right"></a>
                            </span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function(){
	
		
        //屏蔽回车事件
        $('input,select').live("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        }); 
					
        //jQuery validate
        v_addMethod();
        $(".sBtn").click(function(){
            $('#_create_form').find('.tip').hide();
            $("#_create_form").validate({
                rules: {				
                    'exam[question_content]': { required:true,schar:true,minlength:2, maxlength:500},
                    'exam[exam_type]':{required:true},
                    'exam[exam_point]':{required:true},
                    'exam[correct_answer]':{required:true},
                    'exam[alternative_a]': { required:true,schar:true,minlength:2,maxlength:300},
                    'exam[alternative_b]': { required:true,schar:true,minlength:2,maxlength:300},
                    'exam[alternative_c]': { required:true,schar:true,minlength:2,maxlength:300},
                    'exam[alternative_d]': { required:true,schar:true,minlength:2,maxlength:300}
                }
			
            });
            
            
            if($("#_create_form").valid()){
               
               
                var options = {
                    dataType:'json',
                    success:function(data){
                        $('#udError').hide();
                        $('.colOrange').hide();
                        if(data.status == '9999'){
                            var error = data.data;
                            for(var key in error){
                                $('#error_'+key).html(error[key]).show();
                            }
                        }
                        else if (data.status == '0'){
                            
                            $('#udError').html('题目编辑成功').show();
                        }
                        else{
                            $('#udError').html('题目编辑失败：'+ data.msg + '(' + data.status + ')').show();
                        }
                    },
                    error:function(){
                        $('#udError').html('请求失败').show();
                    }
                }
                $('#_create_form').ajaxSubmit(options);
                return false;
            }
        });
        
    });
	
    window.onload=function(){
        var data_content = '<?php echo $_smarty_tpl->getVariable('args')->value['question_content'];?>
';
        
        jQuery("#words").hide();
        var js=document.getElementById("question_content");//获取文本域
        var info=document.getElementById('words_left');//获取要插入提示信息的元素
        //var submit=document.getElementById('btnSubmit');//获取提交按钮
        var max=js.getAttribute('maxlength');//获取限制输入的最大长度
        var tips=document.createElement('span');//新建一个提示span
        var val,cur,count,warn;
        
        //submit.disabled=true;//默认不可提交
        tips.innerHTML='（您还可以输入&nbsp;<em style="color:red;">'+max+'</em>&nbsp;&nbsp;个字符，<font size="2pt">不区分中英文字符。</font>）'; 
        if(data_content != ""){
                jQuery("#words").show();
                //submit.disabled=false;
                if(info.lastChild.nodeName!='SPAN') info.appendChild(tips);//避免每次弹起都会插入一条提示信息
                count=info.getElementsByTagName('em')[0];//根据输入数字变换区
                warn=info.getElementsByTagName('font')[0];//副标题
                val=js.value;
                cur=val.length;
                if(cur==0){ //当默认值长度为0时,可输入数为默认maxlength值,此时不可提交
                    count.innerHTML = max;
                    //submit.disabled=true;
                    warn.innerHTML='不区分中英文字符。';
                }else if (cur < max) {//当默认值小于限制数时,可输入数为max-cur
                    count.innerHTML = max - cur;
                    warn.innerHTML='不区分中英文字符。';
                }else{
                    count.innerHTML = 0;//当默认值大于等于限制数时,插入一条提示信息并截取限制数内的值
                    warn.innerHTML='不可再输入！';
                    js.value=val.substring(0,max);//此处前面的this.value不能用变量val,它们不再是同一个值
                }
        }
        
        if(max){
            js.onkeyup=js.onchange=function(){
                jQuery("#words").show();
                //submit.disabled=false;
                if(info.lastChild.nodeName!='SPAN') info.appendChild(tips);//避免每次弹起都会插入一条提示信息
                count=info.getElementsByTagName('em')[0];//根据输入数字变换区
                warn=info.getElementsByTagName('font')[0];//副标题
                val=this.value;
                cur=val.length;
                if(cur==0){ //当默认值长度为0时,可输入数为默认maxlength值,此时不可提交
                    count.innerHTML = max;
                    //submit.disabled=true;
                    warn.innerHTML='不区分中英文字符。';
                }else if (cur < max) {//当默认值小于限制数时,可输入数为max-cur
                    count.innerHTML = max - cur;
                    warn.innerHTML='不区分中英文字符。';
                }else{
                    count.innerHTML = 0;//当默认值大于等于限制数时,插入一条提示信息并截取限制数内的值
                    warn.innerHTML='不可再输入！';
                    this.value=val.substring(0,max);//此处前面的this.value不能用变量val,它们不再是同一个值
                }
            }
        }
    }
</script>