<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 23:44:40
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/optLog/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:109823435253037fe8600e79-11776656%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '460052961b4912d25539aec6b87816f044dec37f' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/optLog/_list.html',
      1 => 1392738275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109823435253037fe8600e79-11776656',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.overall.js"></script>

<table class="dbTable">
	<thead>
        <tr><th>操作员帐号</th><th>名称</th><th>模块</th><th>操作</th><th>结果</th><th>IP地址</th><th>操作时间</th></tr>
    </thead>
    <tbody>
		<?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('optlog_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
?>
        <tr>
			<td><?php echo $_smarty_tpl->tpl_vars['one']->value['operator_id'];?>
</td>
			<td width="10%"><?php echo $_smarty_tpl->tpl_vars['one']->value['operator_name'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['one']->value['module_desc'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['one']->value['opt_field'];?>
</td>
			
                        <td><?php echo $_smarty_tpl->tpl_vars['one']->value['result_desc'];?>
<span title="<?php echo $_smarty_tpl->tpl_vars['one']->value['opt_desc'];?>
"><a href="javascript:void(0);">[详细]</a></span></td>
			<td><?php echo $_smarty_tpl->tpl_vars['one']->value['opt_host_ip'];?>
</td>
			<td width="15%"><?php echo $_smarty_tpl->tpl_vars['one']->value['opt_time'];?>
</td>
			<!--<td><a href='#' onclick="itemWindow('操作日志详细信息', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'optLog','a'=>'logInfo','log_id'=>$_smarty_tpl->tpl_vars['one']->value['log_id']),$_smarty_tpl);?>
', '500', '200');">重置密码</a>
			-->
		</tr>
		<?php }} else { ?>
		<tr><td colspan="7">无查询记录！</td></tr>
		<?php } ?>
	</tbody>
	
	
</table>
</form>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

