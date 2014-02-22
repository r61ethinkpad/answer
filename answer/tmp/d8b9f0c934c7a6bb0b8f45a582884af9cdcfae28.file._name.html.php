<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 16:03:03
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/_name.html" */ ?>
<?php /*%%SmartyHeaderCode:934956664530070b7bcc0a2-95201318%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd8b9f0c934c7a6bb0b8f45a582884af9cdcfae28' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/_name.html',
      1 => 1387854754,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '934956664530070b7bcc0a2-95201318',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>

<?php if ($_smarty_tpl->getVariable('name')->value!=''){?>
	<span>欢迎您，<span class="username_tag"><?php echo $_smarty_tpl->getVariable('name')->value;?>
</span> ！</span>
<?php }?>

<?php if ($_smarty_tpl->getVariable('dataname')->value!=''){?>
	<span>您当前在 <?php echo $_smarty_tpl->getVariable('dataname')->value;?>
</span>
<?php }?>