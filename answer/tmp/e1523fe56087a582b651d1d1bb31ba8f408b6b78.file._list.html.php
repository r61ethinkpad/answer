<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 16:03:03
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/pest/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:772741031530070b7cdcff8-95560310%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e1523fe56087a582b651d1d1bb31ba8f408b6b78' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/pest/_list.html',
      1 => 1392436099,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '772741031530070b7cdcff8-95560310',
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
            <th style="width:40%">病害名称</th><th style="width:20%">发病时期</th><th style="width:20%">发病部位</th><th>操作</th></tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['pest'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('pest_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['pest']->key => $_smarty_tpl->tpl_vars['pest']->value){
?>
        <tr>

            <td>

                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'detail','id'=>$_smarty_tpl->tpl_vars['pest']->value['detail_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
"> 
                    <?php echo $_smarty_tpl->tpl_vars['pest']->value['detail_name'];?>

                </a>
            </td>
            <td><?php echo $_smarty_tpl->tpl_vars['pest']->value['period_text'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['pest']->value['part_text'];?>
</td>
            <td>
                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'detail','id'=>$_smarty_tpl->tpl_vars['pest']->value['detail_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">查看</a>
               <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'edit','id'=>$_smarty_tpl->tpl_vars['pest']->value['detail_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">编辑</a>
                <a href="javascript:void(0);" onclick="del('<?php echo $_smarty_tpl->tpl_vars['pest']->value['detail_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['pest']->value['detail_name'];?>
');">删除</a>
                
            </td>
        </tr>
        <?php }} else { ?>
        <tr><td colspan="4"><span id="no_record">无查询记录！</span></td></tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr><td colspan="4">

                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增病害</a>
            </td></tr>
    </tfoot>
</table>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript">
	
    function del(id,title)
    {
        if(title.length>10)
            title = title.substring(0,10)+'...';
        if(!confirm("您正在删除病害【"+title+"】，继续吗？"))
            return false;
        else
            jQuery.ajax({
                type: 'get',
                url: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'del'),$_smarty_tpl);?>
' + '&id=' + id,
                success: function (data,html){
                    alert(data);
                    jQuery.ajax({
                        type: 'get',
                        url: encodeURI('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'queryList'),$_smarty_tpl);?>
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
