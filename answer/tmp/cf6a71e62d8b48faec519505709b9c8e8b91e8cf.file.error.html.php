<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 10:57:52
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/error.html" */ ?>
<?php /*%%SmartyHeaderCode:1077710835530812307de716-74216827%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf6a71e62d8b48faec519505709b9c8e8b91e8cf' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/error.html',
      1 => 1393032225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1077710835530812307de716-74216827',
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