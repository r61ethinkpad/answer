<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 15:59:38
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:933374494530312ea127920-15261848%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d152ead39de5d2acaab45f3e3655454e158ac05' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/_list.html',
      1 => 1392710138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '933374494530312ea127920-15261848',
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
            <th style="width:10%">所属分类</th>
            <th style="width:10%">所属关卡</th>
            <th style="width:20%">题目内容</th>
            <th style="width:10%">正确答案</th>
            <th style="width:10%">备选答案A</th>
            <th style="width:10%">备选答案B</th>
            <th style="width:10%">备选答案C</th>
            <th style="width:10%">备选答案D</th>
            <th>操作</th></tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['exam'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['exam']->key => $_smarty_tpl->tpl_vars['exam']->value){
?>
        <tr>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['exam_type_text'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['exam_point_text'];?>
</td>
            <td>

                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'detail','id'=>$_smarty_tpl->tpl_vars['exam']->value['question_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
"> 
                    <?php echo $_smarty_tpl->tpl_vars['exam']->value['question_content_text'];?>

                </a>
            </td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['correct_answer'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['alternative_a_text'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['alternative_b_text'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['alternative_c_text'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['exam']->value['alternative_d_text'];?>
</td>
            <td>
                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'edit','id'=>$_smarty_tpl->tpl_vars['exam']->value['question_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">编辑</a>
                <a href="javascript:void(0);" onclick="del('<?php echo $_smarty_tpl->tpl_vars['exam']->value['question_id'];?>
');">删除</a>

            </td>
        </tr>
        <?php }} else { ?>
        <tr><td colspan="9"><span id="no_record">无查询记录！</span></td></tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr><td colspan="9">

                <a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增题目</a>
            </td></tr>
    </tfoot>
</table>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript">
	
    function del(id)
    {
        
        if(!confirm("您正在删除此题目，继续吗？"))
            return false;
        else
            jQuery.ajax({
                type: 'get',
                url: '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'del'),$_smarty_tpl);?>
' + '&id=' + id,
                success: function (data,html){
                    alert(data);
                    jQuery.ajax({
                        type: 'get',
                        url: encodeURI('<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'queryList'),$_smarty_tpl);?>
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
