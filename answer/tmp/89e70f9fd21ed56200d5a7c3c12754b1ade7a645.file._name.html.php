<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 10:57:52
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/_name.html" */ ?>
<?php /*%%SmartyHeaderCode:571776959530812307c8cc0-12264486%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89e70f9fd21ed56200d5a7c3c12754b1ade7a645' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/_name.html',
      1 => 1393032225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '571776959530812307c8cc0-12264486',
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