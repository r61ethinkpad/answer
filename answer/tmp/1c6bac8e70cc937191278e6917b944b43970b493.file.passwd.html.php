<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 23:56:51
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/operator/passwd.html" */ ?>
<?php /*%%SmartyHeaderCode:139047747530382c37f3987-53255654%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1c6bac8e70cc937191278e6917b944b43970b493' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/operator/passwd.html',
      1 => 1392738764,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '139047747530382c37f3987-53255654',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div class="tab-main">
	<span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['ud_error'];?>
</span>
	<form id="_operpasswd_form" method="post" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'passwdSave'),$_smarty_tpl);?>
">
       	<table class="formList">
            <tr>
                <td class="name"  style="width:40%">操作员账号：</td>
                <td class="value"><?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
</td>
				<input type="hidden" name="operator_id" id="operator_id" value="<?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
">
			</tr>
			<tr>
                <td class="name"><span class='colRed'>*</span>新密码：</td>
				<td class="value">
					<input name="password" id="password" type="password" class="input_text" maxlength="20" value=""/>
					<span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['passwd'];?>
</span>
				</td>
			</tr>
			<tr  class="line">
                <td class="name"><span class='colRed'>*</span>重复新密码：</td>
                <td class="value">
					<input name="passwd2" type="password" class="input_text" maxlength="20" value=""/>
					<span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['passwd2'];?>
</span>
				</td>
			</tr>
			
			<tr class="btnBox">
                <td colspan="2">
                    <span class="sBtn" id="submitButton">
                        <a class="left" >确定</a><a class="right"></a>
                    </span>
                </td>
            </tr>
			
        </table>
	</form>
	</div>

<script type="text/javascript">
$(document).ready(function(){	
	$('input').bind("keypress", function(e) {
		/* ENTER PRESSED*/
        if (e.keyCode == 13) {
			return false;
		}
	});
	v_addMethod();
	$("#submitButton").click(function(){
		$('#_operpasswd_form').find('.tip').hide();
		$("#_operpasswd_form").validate({
			rules: {
				password: { required:true, schar:true, minlength:6, maxlength:20},
				passwd2: { required:true, equalTo:"#password", minlength:6, maxlength:20}
			},
			messages:{
				passwd2: {equalTo:'两次输入不一致'}
			}
		});
		if($("#_operpasswd_form").valid()){
			//$('#_operpasswd_form').submit();
			formSubmit('_operpasswd_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'passwdSave'),$_smarty_tpl);?>
', 'windown-content');
		}
	})
	if ('<?php echo $_smarty_tpl->getVariable('success_flag')->value;?>
' == '1'){
		alert('重置操作员密码成功');
		closeWindown();
		
	}
});
</script>
