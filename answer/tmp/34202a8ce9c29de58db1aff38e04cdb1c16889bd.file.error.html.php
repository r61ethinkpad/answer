<?php /* Smarty version Smarty-3.0.8, created on 2014-02-19 16:33:26
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/error.html" */ ?>
<?php /*%%SmartyHeaderCode:109811541853046c566ca390-38570462%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '34202a8ce9c29de58db1aff38e04cdb1c16889bd' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/error.html',
      1 => 1392789666,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109811541853046c566ca390-38570462',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<style>
.error { margin:100px 0 100px 300px; background:url(view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/error.gif) no-repeat #fff; width:400px; height:50px; padding:55px 10px 20px 150px;}
.error p { color:#666; font-size:14px;}
</style>

<div id="content">
<div class="error">
	<p><?php echo $_smarty_tpl->getVariable('errorinfo')->value;?>
</p>
</div>
</div>