<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 16:03:03
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/pest/index.html" */ ?>
<?php /*%%SmartyHeaderCode:974118017530070b7c01f54-64248297%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7bef11dfd4b7d152b71cee88cb6b3c4e22dd7a57' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/pest/index.html',
      1 => 1388373303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '974118017530070b7c01f54-64248297',
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
        <ul class="tab-label">

            <li  class="current"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">病害列表</a></li>

            <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增病害</a></li>


        </ul>
        <div class="tab-main">
            <form id='_query_form'>
                <div class="tool-box">
                    <select name="growth_period" id="growth_period">
                        <option value="" selected="">--<?php echo T('any_period');?>
--</option>
                        <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['name'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('growth_period')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
 $_smarty_tpl->tpl_vars['name']->value = $_smarty_tpl->tpl_vars['value']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"/><?php echo $_smarty_tpl->tpl_vars['value']->value;?>
</option>
                        <?php }} ?>
                    </select>

                    <select name="crop_part" id="crop_part">
                        <option value="" selected="">--<?php echo T('any_part');?>
--</option>
                        
                    </select>

                    <input type="text" value="输入病害名称" name="pest_title" class="grayTips input_text" maxlength="32"/>


                    <a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');;"></a>

                </div>
            </form>

            <div id="datagrid">
                <?php $_template = new Smarty_Internal_Template("pest/_list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
	
        jQuery("#growth_period").change(function(){
            var v = jQuery(this).val();
            jQuery.post('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'getCropParts'),$_smarty_tpl);?>
&id='+v,function(data){
                jQuery("#crop_part").html(data).show();
            });
        });
		
		
        //加载列表
        jQuery.ajax({
            type: 'get',
            url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'queryList'),$_smarty_tpl);?>
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