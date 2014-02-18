<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 14:11:08
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/operator/index.html" */ ?>
<?php /*%%SmartyHeaderCode:20386711995302f97c0bf988-68975696%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e9a63ba62684ad297e4bce30541461e85397d2a0' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/operator/index.html',
      1 => 1388367871,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20386711995302f97c0bf988-68975696',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>

<div id="content">
    <div class="tab-main">
        <div class="tool-box">
			<form id='_query_form'>
				<input type="hidden" name="orgid" value="<?php echo $_smarty_tpl->getVariable('orgid')->value;?>
">
				<input type="text" name="operator_id" value="管理员帐号" maxlength="20" class="input_text grayTips mr5" />
				<input type="text" name="operator_name" value="管理员名称" maxlength="20" class="input_text grayTips mr5" />
				
				
				<select name="status" id="operstatus">
				<option value="" selected="selected" />--管理员状态--</option>
				<?php  $_smarty_tpl->tpl_vars['desc'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['status'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('operator_status')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['desc']->key => $_smarty_tpl->tpl_vars['desc']->value){
 $_smarty_tpl->tpl_vars['status']->value = $_smarty_tpl->tpl_vars['desc']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
</option>
				<?php }} ?>
				</select>
				
				<a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');"></a>
			</form>
			
			<?php if ($_smarty_tpl->getVariable('authconfig')->value['new']==true){?>	
				<div style="position:absolute; right:15px; top:2px; z-index:999; width:100px; text-align:right;">
					<a id="url1" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operNew','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">添加操作员</a>
				</div>
			<?php }?>
			
		</div>
		

		<div id="datagrid" >
			<?php $_template = new Smarty_Internal_Template("operator/_list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
		</div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	//搜索区域回车事件
		$('input,select').live("keypress", function(e) {
		    if (e.keyCode == 13) {
	            listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');
	            return false;
		    }
		}); 
	jQuery.ajax({
		type: 'get',
		url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'queryList'),$_smarty_tpl);?>
",
		success: function(data,html){jQuery("#datagrid").html(data); },
		error: function(){}//alert('加载数据失败');}
	})
	
})
</script>