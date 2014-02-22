<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 22:41:00
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answerType/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:151222523530370fc349fe1-66538343%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d28a19f8438fa5c7cd254e02b87e90d909264f0' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answerType/_list.html',
      1 => 1392734452,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151222523530370fc349fe1-66538343',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.overall.js"></script>	
<table class="dbTable">
    <thead>
        <tr>
            <th style="width:50%">题库分类名称</th>
            <th>操作</th></tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('type_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['type']->key => $_smarty_tpl->tpl_vars['type']->value){
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['type']->value['type_name'];?>
</td>
            <td>
                <a href="javascript:void(0);" onclick="del('<?php echo $_smarty_tpl->tpl_vars['type']->value['type_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['type']->value['type_name'];?>
');">删除</a>

            </td>
        </tr>
        <?php }} else { ?>
        <tr><td colspan="2"><span id="no_record">无查询记录！</span></td></tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr><td colspan="2">

                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增题库分类</a>
            </td></tr>
    </tfoot>
</table>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript">
	
    function del(id,title)
    {
        
        if(!confirm("您正在删除["+title+"]，继续吗？"))
            return false;
        else
            jQuery.ajax({
                type: 'get',
                url: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'del'),$_smarty_tpl);?>
' + '&id=' + id,
                success: function (data,html){
                    alert(data);
                    jQuery.ajax({
                        type: 'get',
                        url: encodeURI('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'queryList'),$_smarty_tpl);?>
' + '<?php echo $_smarty_tpl->getVariable('saveUrl')->value;?>
'),
                        success: function (data, html){jQuery('#datagrid').html(data);},
                        error: function (){}
                    });
                },
            error: function (){alert('请求失败');}
        });
    }
	
</script>
