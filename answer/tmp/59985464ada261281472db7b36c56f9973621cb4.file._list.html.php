<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 14:11:08
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/operator/_list.html" */ ?>
<?php /*%%SmartyHeaderCode:18582461775302f97c204c03-36760477%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59985464ada261281472db7b36c56f9973621cb4' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/operator/_list.html',
      1 => 1388136316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18582461775302f97c204c03-36760477',
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
            <th>操作员帐号</th><th>名称</th><th>联系电话</th><th>类型</th><th>状态</th><th>操作</th></tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['one'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('operator_list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['one']->key => $_smarty_tpl->tpl_vars['one']->value){
?>
        <tr>


            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['operator_id'];?>
</td>
            <td width="15%"><?php echo $_smarty_tpl->tpl_vars['one']->value['name'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['phone'];?>
</td>
            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['type_desc'];?>
</td>

            <td><?php echo $_smarty_tpl->tpl_vars['one']->value['status_desc'];?>
</td>
            <td>
                <?php if ($_smarty_tpl->tpl_vars['one']->value['type']!='00'){?>
                    <?php if ($_smarty_tpl->getVariable('authconfig')->value['update']==true){?>
                    <a href='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operEdit','operator_id'=>$_smarty_tpl->tpl_vars['one']->value['operator_id'],'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
' >编辑</a>
                    <?php }?>
                    <?php if ($_smarty_tpl->getVariable('authconfig')->value['passwd']==true){?>
                    <a href='#' onclick="itemWindow('重置操作员密码', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operPasswd','operator_id'=>$_smarty_tpl->tpl_vars['one']->value['operator_id']),$_smarty_tpl);?>
', '500', '200');">重置密码</a>
                    <?php }?>

                    <?php if ($_smarty_tpl->getVariable('authconfig')->value['freeze']==true){?>
                        <?php if ($_smarty_tpl->tpl_vars['one']->value['status']=='00'){?>
                        <a href='#' onclick="alertSubmit('确定冻结操作员 <?php echo $_smarty_tpl->tpl_vars['one']->value['operator_id'];?>
 吗？', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'freeze','id'=>$_smarty_tpl->tpl_vars['one']->value['operator_id']),$_smarty_tpl);?>
<?php echo $_smarty_tpl->getVariable('saveUrl')->value;?>
', 'datagrid');">冻结</a>
                        <?php }else{ ?>
                        <a href='#' onclick="alertSubmit('确定解冻操作员 <?php echo $_smarty_tpl->tpl_vars['one']->value['operator_id'];?>
 吗？', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'unfreeze','id'=>$_smarty_tpl->tpl_vars['one']->value['operator_id']),$_smarty_tpl);?>
<?php echo $_smarty_tpl->getVariable('saveUrl')->value;?>
', 'datagrid');">解冻</a>
                        <?php }?>
                    <?php }?>

                    <?php if ($_smarty_tpl->getVariable('authconfig')->value['del']==true){?>
                    <a href='#' onclick="alertSubmit('确定删除操作员 <?php echo $_smarty_tpl->tpl_vars['one']->value['operator_id'];?>
 吗？', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operDel','id'=>$_smarty_tpl->tpl_vars['one']->value['operator_id'],'page'=>$_smarty_tpl->getVariable('_pg_')->value['page']),$_smarty_tpl);?>
<?php echo $_smarty_tpl->getVariable('saveUrl')->value;?>
', 'datagrid');">删除</a>
                    <?php }?>
                
                <?php }?>
            </td>


        </tr>
        <?php }} else { ?>
        <tr><td colspan="6">无查询记录！</td></tr>
        <?php } ?>
    </tbody>
    <tfoot>
        <tr><td colspan="6">

                <?php if ($_smarty_tpl->getVariable('authconfig')->value['new']==true){?>
                <a id="url1" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'operNew','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">添加操作员</a>
                <?php }?>
            </td></tr>
    </tfoot>

</table>
<?php $_template = new Smarty_Internal_Template("../inc/page.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#checkAll").click(function(){
            $('input:checkbox').attr("checked", true);
            $('#checkAll').hide();
            $('#checkNone').show();
        })
        $("#checkNone").click(function(){
            $('input:checkbox').attr("checked", false);
            $('#checkAll').show();
            $('#checkNone').hide();
        })
        $("#delsButton").click(function(){
            if(check() == true){
                if(confirm('确定删除选中的操作员吗？')){
                    //formSubmit('_checkall_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'operator','a'=>'delAll'),$_smarty_tpl);?>
', 'datagrid');
                    var options = {
                        //dataType:'json',
                        success:function(data){
                            $('#datagrid').html(data);
                        },
                        error:function(){
                            alert('请求失败');
                        }
                    }
                    $('#_checkall_form').ajaxSubmit(options);
                    return false;
                }
            }else{
                alert("请至少勾选一项");
            }
        })
        if('<?php echo $_smarty_tpl->getVariable('optResult')->value;?>
' != ''){
            alert('<?php echo $_smarty_tpl->getVariable('optResult')->value;?>
');
        }
    })
    function check(){
        var aa = document.getElementsByName("selectdel[]");
        for (var i=0; i<aa.length; i++)
        {
            if (aa[i].checked) return true;
        }
        return false;
    }
</script>
