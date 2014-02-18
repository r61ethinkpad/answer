<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 20:46:43
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/_login_header.html" */ ?>
<?php /*%%SmartyHeaderCode:17764447545300b333910d34-42302068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c40893d41d72656fcee6214d929b7cbccd69572f' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/_login_header.html',
      1 => 1392554801,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17764447545300b333910d34-42302068',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="header">
    <div id="header-top">
        <div class="floatL">
            <!--img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/login/logo.gif"/-->
            答题有奖系统
        </div>
    </div>

    
    <div id="nav" class="nav nav-nosub">
        <div class="nav-cnt">
            <ul>
			
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('loginMenu')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
			<li <?php if ($_smarty_tpl->tpl_vars['item']->value['tid']==$_GET['tid']){?> class="master current" <?php }else{ ?> class="master" <?php }?>>
				<a class="name" href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</strong></a>
			<?php }} ?>
					
            </ul>
        </div>
    </div>

</div>