<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 23:50:14
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/operator/new.html" */ ?>
<?php /*%%SmartyHeaderCode:117945026953038136dee474-31711699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2192e4e13d9439ec5b2ae14382d12c96d96886d4' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/operator/new.html',
      1 => 1392730756,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '117945026953038136dee474-31711699',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="content">
	<div class="tab">
    	<ul class="tab-label">
        	<li class="current"><a href="#">新建操作员</a></li>
        </ul>

		<div id="showAdviceButton"></div>
		
<style>#showstruct .value a { text-decoration:none; color:#666; margin-left:0;}</style>		

<div class="tab-main">
	<p id="udError" class="dBox" style="display:none;"></p>
	<form id="_opernew_form" method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operSave'),$_smarty_tpl);?>
">
	<!--<input type="submit" value="提交">-->
       	<table class="formList">
            <tr>
                <td class="name"><span class='colRed'>*</span>管理员帐号：</td>
                <td class="value">
					<input name="operator_id" type="text" class="input_text" maxlength="20" value="<?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
"/>
					<span class="tip">字母、数字、下划线组合</span>
					<span id="error_operator_id" class="colOrange"></span>
				</td>
                <td class="name"><span class='colRed'>*</span>初始密码：</td>
                <td class="value">
					<input name="password" type="password" class="input_text" maxlength="20" value="<?php echo $_smarty_tpl->getVariable('args')->value['password'];?>
"/>
					<span id="error_password" class="colOrange"></span>
				</td>
			</tr>
			<tr>
                <td class="name"><span class='colRed'>*</span>名称：</td>
				<td class="value">
					<input name="name" maxlength="20" type="text" class="input_text" value="<?php echo $_smarty_tpl->getVariable('args')->value['name'];?>
"/>
					<span id="error_name" class="colOrange"></span>
				</td>
                <td class="name"><span class='colRed'>*</span>手机号码：</td>
                <td class="value">
					<input name="phone" maxlength="11" type="text" class="input_text" value="<?php echo $_smarty_tpl->getVariable('args')->value['phone'];?>
"/>
					<span id="error_phone" class="colOrange"></span>
				</td>
			</tr>
			<tr  class="line">
                <td class="name">管理员类型：</td>
                <td class="value">
                    <select name="type" id="type" class="input_text">
                        <option value="">--选择--</option>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('operator_types')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
                        <?php }} ?>
                    </select>
					<span id="error_type" class="colOrange"></span>
				</td>
                <td class="name">邮箱：</td>
                <td class="value">
					<input name="email" maxlength="50"  type="text" class="input_text" value="<?php echo $_smarty_tpl->getVariable('args')->value['email'];?>
"/>
					<span id="error_email" class="colOrange"></span>
				</td>
			</tr>	
			
			<tr><td colspan='4'></td>
			</tr>
			<tr class="btnBox">
                <td colspan="4">
                    <span class="sBtn">
                        <a class="left">确定</a><a class="right"></a>
                    </span>
					<span class="sBtn-cancel" id="returnButton">
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
" class="left" >返回</a><a class="right"></a>
                    </span>
                </td>
            </tr>
			
        </table>
	</form>
	</div>
</div>
</div>

<script type="text/javascript">

$(document).ready(function(){	
	
	v_addMethod();
	$(".sBtn").click(function(){
		$('#_opernew_form').find('.tip').hide();
		$("#_opernew_form").validate({
			rules: {
				operator_id:{ required:true, minlength:4, maxlength:20, v_preg:'^[a-zA-Z0-9_]+$'},
				password: { required:true, schar:true, minlength:6, maxlength:20},
				name: { required:true, schar:true, minlength:2, maxlength:20},
				phone: { required:true, number:true, minlength:11, maxlength:11},
				type: { number:true},
				email:'email',
				type:{ required:true}
			},
			messages:{
				operator_id: {v_preg:'请输入字母、数字、下划线组合'}
			}
		});
		if($("#_opernew_form").valid()){
			//$('#_opernew_form').submit();
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
						//alert('操作员 '+data.data+' 添加成功');
                                                $('#udError').html('管理员 '+data.data+' 添加成功').show();
						//window.location.href='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operAuth','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
&operator_id='+data.data;
					}
					else{
						$('#udError').html('添加管理员失败：'+ data.msg + '(' + data.status + ')').show();
					}
				},
				error:function(){
					$('#udError').html('请求失败').show();
				}
			}
			$('#_opernew_form').ajaxSubmit(options);
			return false;
		}
	})
	
});


</script>
