<?php /* Smarty version Smarty-3.0.8, created on 2014-02-19 18:19:49
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/record/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:181071914653048545403dd8-50462153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '710c9a21632a1af7bbda605b5879d2ff853d9564' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/record/_list.html',
      1 => 1392805183,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '181071914653048545403dd8-50462153',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.overall.js"></script>
<style>
    .towfocus {
    color: #FF0000;
    background-color:#fbf9e6;
}
.towfocus tr td span{
     margin-right:20px;
}
</style>
<table class="dbTable">
    <thead>
        <tr>
            <th style="width:20%">答题客户</th>
            <th style="width:20%">答题时间</th>
            <th style="width:20%">获得积分</th>
            <th style="width:20%">截至关卡</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k_id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('record_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
 $_smarty_tpl->tpl_vars['k_id']->value = $_smarty_tpl->tpl_vars['one']->key;
?>
        <tr>

            <td>

                    <?php echo $_smarty_tpl->tpl_vars['one']->value['user_id'];?>

            </td>
            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['answer_time'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['get_scores'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['over_point_text'];?>
</td>
            <td>
               <a href="javascript:void(0);" onclick="showDetail('<?php echo $_smarty_tpl->tpl_vars['k_id']->value;?>
');">查看详细</a>
            </td>
        </tr>
        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['k_id']->value;?>
"  class="towfocus" style="display: none;">
            <td colspan="5">
                <?php echo $_smarty_tpl->tpl_vars['one']->value['point_desc'];?>

            </td>
        </tr>
        
        <?php }} else { ?>
        <tr><td colspan="5"><span id="no_record">无查询记录！</span></td></tr>
        <?php } ?>
    </tbody>
   
</table>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript">
function showDetail(id)
{
    jQuery("#tr_"+id).toggle();
}
</script>
