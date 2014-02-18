<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 23:41:13
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/record/index.html" */ ?>
<?php /*%%SmartyHeaderCode:58439450253037f1963ae68-45295330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fc68f959c20c47cb357b2c8ef9da3ad4a4f880f8' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/record/index.html',
      1 => 1392738070,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '58439450253037f1963ae68-45295330',
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
    <div class="tab">
        <ul class="tab-label">

            <li  class="current"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'record','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">答题记录</a></li>

        </ul>
        <div class="tab-main">
            <form id='_query_form'>
                <div class="tool-box">
                    <select name="over_point" id="over_point">
                        <option value="" selected="selected" />--截至关卡--</option>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_points')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
                        <?php }} ?>
                    </select>

                    <input class="Wdate" maxlength="10" type="text" id="date1" name='stime' value="<?php echo $_smarty_tpl->getVariable('firstday')->value;?>
" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" style=""/>
		        <span>到</span>
				<input class="Wdate" maxlength="10" type="text" id="date1" name='etime' value="<?php echo $_smarty_tpl->getVariable('today')->value;?>
" onFocus="WdatePicker({dateFmt:'yyyy-MM-dd'})" style=""/>
				

                    <a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'record','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');"></a>

                </div>
            </form>

            <div id="datagrid">
                <?php $_template = new Smarty_Internal_Template("record/_list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
		
		
		
        //加载列表
        jQuery.ajax({
            type: 'get',
            url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'record','a'=>'queryList'),$_smarty_tpl);?>
",
            data: jQuery('#_query_form').serialize(),
            beforeSend: function(XMLHttpRequest){
                $("#no_record").html("<img src='view/default/js/JQwindow/loading.gif' class='loading' />数据加载中...");
            },
            success: function(data,html){jQuery("#datagrid").html(data); $("#datagrid").show(); },
            error: function(){alert('加载数据失败');}
        });
		
        //搜索区域回车事件
        $('input,select').live("keypress", function(e) {
            if (e.keyCode == 13) {
                listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'record','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');
                return false;
            }
        }); 
    });
	
	
</script>