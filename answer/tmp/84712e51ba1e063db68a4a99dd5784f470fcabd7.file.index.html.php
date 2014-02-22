<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 17:15:57
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/optLog/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1207929758530324cdb4c996-79613695%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '84712e51ba1e063db68a4a99dd5784f470fcabd7' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/optLog/index.html',
      1 => 1388368112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1207929758530324cdb4c996-79613695',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/DatePicker/WdatePicker.js"></script>
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
				<select name="module_id" id="module_id">
				<option value="" selected="selected" />--系统模块--</option>
				<?php  $_smarty_tpl->tpl_vars['desc'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['module'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('opt_module')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['desc']->key => $_smarty_tpl->tpl_vars['desc']->value){
 $_smarty_tpl->tpl_vars['module']->value = $_smarty_tpl->tpl_vars['desc']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['module']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['desc']->value;?>
</option>
				<?php }} ?>
				</select>
				<input type="text" name="operator_id" value="操作员帐号" class="input_text grayTips mr5" />
				<input type="text" name="opt_desc" value="描述关键字" class="input_text grayTips mr5" />
				
				<input class="Wdate" maxlength="10" type="text" id="date1" name='stime' value="<?php echo $_smarty_tpl->getVariable('firstday')->value;?>
" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" style=""/>
		        <span>到</span>
				<input class="Wdate" maxlength="10" type="text" id="date1" name='etime' value="<?php echo $_smarty_tpl->getVariable('today')->value;?>
" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" style=""/>
				
				<a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'optLog','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');"></a>
			</form>
			
			<div id="showAdviceButton"></div>
        </div>

		<div id="datagrid">
			
		</div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	//搜索区域回车事件
		$('input,select').live("keypress", function(e) {
		    if (e.keyCode == 13) {
	            listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'optLog','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');
	            return false;
		    }
		}); 
	jQuery.ajax({
		type: 'get',
		url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'optLog','a'=>'queryList'),$_smarty_tpl);?>
",
		success: function(data,html){jQuery("#datagrid").html(data); },
		error: function(){alert('加载数据失败');}
	})
	
})
</script>