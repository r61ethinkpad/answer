<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 23:14:34
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/main/passwd.html" */ ?>
<?php /*%%SmartyHeaderCode:1464423158530378da990961-96763110%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '716917dc5cb166f4c815e83801c60c28e33f17f2' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/main/passwd.html',
      1 => 1387854425,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1464423158530378da990961-96763110',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="tab-main">
	<span class="colOrange" style="line-height:14px;"><?php echo $_smarty_tpl->getVariable('error_array')->value['ud_error'];?>
</span>
	<form id="_operpasswd_form" method="post" action="<?php ob_start();?><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'passwdSave'),$_smarty_tpl);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
">
       	<table class="formList">
            <tr>
                <td class="name"  style="width:40%">操作员帐号：</td>
                <td class="value"><span style="margin-top:-4px\9; display:inline-block\9;"><?php echo $_smarty_tpl->getVariable('args')->value['operator_id'];?>
</span></td>
			</tr>
			<tr>
                <td class="name"><span class='colRed'>*</span>原密码：</td>
				<td class="value">
					<input name="oldpasswd" id="oldpasswd" type="password" class="input_text" maxlength="20" value=""/>
					<span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['oldpasswd'];?>
</span>
				</td>
			</tr>
			<tr>
                <td class="name"><span class='colRed'>*</span>新密码：</td>
				<td class="value">
					<input name="passwd" id="passwd" type="password" class="input_text" maxlength="20" value=""/>
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
				oldpasswd: { required:true, schar:true, minlength:6, maxlength:20},
				passwd: { required:true, schar:true, minlength:6, maxlength:20},
				passwd2: { required:true, equalTo:"#passwd", minlength:6, maxlength:20}
			},
			messages:{
				passwd2: {equalTo:'两次输入不一致'}
			}
		});
		if($("#_operpasswd_form").valid()){
			//$('#_operpasswd_form').submit();
			formSubmit('_operpasswd_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'passwdSave'),$_smarty_tpl);?>
', 'windown-content');
		}
	})
	if ('<?php echo $_smarty_tpl->getVariable('success_flag')->value;?>
' == '1'){
		alert('修改密码成功');
		closeWindown();
	}
});
</script>
