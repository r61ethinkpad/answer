<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 17:37:14
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/index.html" */ ?>
<?php /*%%SmartyHeaderCode:1502709892530329ca156062-84376231%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c9e9443b82c8d359d6ee699cd05d92208f9c6cd' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/index.html',
      1 => 1392716151,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1502709892530329ca156062-84376231',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/DatePicker/WdatePicker.js"></script><link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>

<div id="content">
    <div class="tab">
        <?php $_template = new Smarty_Internal_Template("answer/_topTitle.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        <div class="tab-main">
            <form id='_query_form'>
                <div class="tool-box">
                    <select name="exam_type" id="exam_type">
                        <option value="" selected="">--<?php echo T('any_exam_type');?>
--</option>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_types')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
                        <?php }} ?>
                    </select>
					
                    <select name="exam_point" id="exam_point">
                        <option value="" selected="">--<?php echo T('any_exam_point');?>
--</option>
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

                    <input type="text" value="输入题目内容" name="question_content" class="grayTips input_text" maxlength="128" style="width:400px;"/>

                    <input type="hidden" name="exam_flag" value="custom"/>
                    <a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');;"></a>

                </div>
            </form>

            <div id="datagrid">
                <?php $_template = new Smarty_Internal_Template("answer/_list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
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
            url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'queryList'),$_smarty_tpl);?>
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
                noticeQuery();
                return false;
            }
        }); 
    });
	
	
</script>