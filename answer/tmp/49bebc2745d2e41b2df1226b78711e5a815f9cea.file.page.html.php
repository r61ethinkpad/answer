<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 16:03:03
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/page.html" */ ?>
<?php /*%%SmartyHeaderCode:809136184530070b7de16a1-03315261%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '49bebc2745d2e41b2df1226b78711e5a815f9cea' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/page.html',
      1 => 1383030957,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '809136184530070b7de16a1-03315261',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="page">
	<?php if (($_smarty_tpl->getVariable('_pg_')->value['total_count']!=0)){?>
		<div class="floatL">共<?php echo $_smarty_tpl->getVariable('_pg_')->value['total_page'];?>
页（<?php echo $_smarty_tpl->getVariable('_pg_')->value['total_count'];?>
条）记录</div>
		<div class="pageNumber">
			<span class="floatL">
			
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']==1){?>
					<a class="pageAir">首页</a>
				<?php }else{ ?>
					<a onclick="listQuery('<?php echo $_smarty_tpl->getVariable('query_form_id')->value;?>
', '<?php echo $_smarty_tpl->getVariable('query_url')->value;?>
&page=1', 'datagrid');">首页</a>
				<?php }?>
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']>3){?>
					...
				<?php }?>
				
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']-1>1){?>
					<a onclick="listQuery('<?php echo $_smarty_tpl->getVariable('query_form_id')->value;?>
', '<?php echo $_smarty_tpl->getVariable('query_url')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('_pg_')->value['current_page']-1;?>
', 'datagrid');"><?php echo $_smarty_tpl->getVariable('_pg_')->value['current_page']-1;?>
</a>
				<?php }?>
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']>1&&$_smarty_tpl->getVariable('_pg_')->value['current_page']<$_smarty_tpl->getVariable('_pg_')->value['total_page']){?>
					<a class="pageAir"><?php echo $_smarty_tpl->getVariable('_pg_')->value['current_page'];?>
</a>
				<?php }?>
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']+1<$_smarty_tpl->getVariable('_pg_')->value['total_page']){?>
					<a  onclick="listQuery('<?php echo $_smarty_tpl->getVariable('query_form_id')->value;?>
', '<?php echo $_smarty_tpl->getVariable('query_url')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('_pg_')->value['current_page']+1;?>
', 'datagrid');"><?php echo $_smarty_tpl->getVariable('_pg_')->value['current_page']+1;?>
</a>
				<?php }?>
				
			
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']<$_smarty_tpl->getVariable('_pg_')->value['total_page']-2){?>
					...
				<?php }?>
				
				<?php if ($_smarty_tpl->getVariable('_pg_')->value['total_page']>1){?>
					<?php if ($_smarty_tpl->getVariable('_pg_')->value['current_page']==$_smarty_tpl->getVariable('_pg_')->value['total_page']){?>
						<a class="pageAir">末页</a>
					<?php }else{ ?>
						<a onclick="listQuery('<?php echo $_smarty_tpl->getVariable('query_form_id')->value;?>
', '<?php echo $_smarty_tpl->getVariable('query_url')->value;?>
&page=<?php echo $_smarty_tpl->getVariable('_pg_')->value['total_page'];?>
', 'datagrid');">末页</a>
					<?php }?>
				<?php }?>
			</span>
			<select onchange="listQuery('<?php echo $_smarty_tpl->getVariable('query_form_id')->value;?>
', '<?php echo $_smarty_tpl->getVariable('query_url')->value;?>
&page='+this.options[this.options.selectedIndex].value, 'datagrid');">
				<option>跳转至</option>
				<?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['name'] = 'pages';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('_pg_')->value['total_page']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pages']['total']);
?>
				<option><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pages']['index']+1;?>
</option>
				<?php endfor; endif; ?>
			</select>
		</div>	
	<?php }?>
</div>