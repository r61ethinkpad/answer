<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 22:15:48
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/operator/edit.html" */ ?>
<?php /*%%SmartyHeaderCode:126226403953036b14972ed4-27183151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8aa9d51818cf709d9a35381fbd8129d6da832abf' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/operator/edit.html',
      1 => 1392732945,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '126226403953036b14972ed4-27183151',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="content">
	<div class="tab">
    	<ul class="tab-label">
        	<li class="current"><a href="">基本信息</a></li>
<!--			<li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operAuth','operator_id'=>$_smarty_tpl->getVariable('args')->value['operator_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">权限信息</a></li>-->
        </ul>
		<div id="showAdviceButton"></div>
		
<style>#showtree .value a { text-decoration:none; color:#666; margin-left:0;}</style>		

<div class="tab-main">
	<p id="udError" class="dBox" style="display:none;"></p>
	<form id="_operedit_form" method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operUpdate'),$_smarty_tpl);?>
">
	<!--<input type="submit" value="提交">-->
	<table class="formList">
            <tr>
                <td class="name">管理员帐号：</td>
                <td class="value"><?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
</td>
				<input type="hidden" name="operator_id" id="operator_id" value="<?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
">
				 <td class="name">注册时间：</td>
                <td class="value"><?php echo $_smarty_tpl->getVariable('args')->value['record_time'];?>
</td>
			</tr>
			<tr  class='line'>
                 
				<td class="name">最近登录时间：</td>
                <td class="value"><?php echo $_smarty_tpl->getVariable('args')->value['last_login_time'];?>
</td>
			
                <td class="name">最近登录IP：</td>
                <td class="value"><?php echo $_smarty_tpl->getVariable('args')->value['last_login_ip'];?>
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
			<tr>
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
" <?php if ($_smarty_tpl->getVariable('args')->value['type']==$_smarty_tpl->tpl_vars['name']->value){?> selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
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
			
			
			<tr  class="line"><td colspan="4"></td></tr>
			
			<tr class="btnBox">
                <td colspan="4">
					<?php if ($_smarty_tpl->getVariable('authconfig')->value['update']==true&&$_smarty_tpl->getVariable('args')->value['operator_class']!='0'){?>
                    <span class="sBtn">
                        <a class="left" >确定</a><a class="right"></a>
                    </span>
					<?php }?>
					<span class="sBtn-cancel" id="returnButton">
                        <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value,'operator_id'=>$_smarty_tpl->getVariable('args')->value['operator_id']),$_smarty_tpl);?>
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
		$('#_operedit_form').find('.tip').hide();
		$("#_operedit_form").validate({
			rules: {
				name: { required:true, schar:true, minlength:2, maxlength:20},
				phone: { required:true, number:true, minlength:11, maxlength:11},
				qq_no: { number:true, minlength:4, maxlength:15},
				email:'email',
				type:{ required:true}
			}
			
		});
		if($("#_operedit_form").valid()){
			//$('#_operedit_form').submit();
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
						//alert('编辑操作员成功');
						$('#udError').html('编辑管理员基本信息成功').show();
						change();
					
					}
					else{
						$('#udError').html('编辑管理员失败：'+ data.msg + '(' + data.status + ')').show();
					}
				},
				error:function(){
					$('#udError').html('请求失败').show();
				}
			}
			$('#_operedit_form').ajaxSubmit(options);
			return false;
		}
	})
	
});
</script>
