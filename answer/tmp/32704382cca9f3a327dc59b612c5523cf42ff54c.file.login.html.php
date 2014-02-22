<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 10:08:46
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/main/login.html" */ ?>
<?php /*%%SmartyHeaderCode:27075789530806aef25bc2-27168268%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32704382cca9f3a327dc59b612c5523cf42ff54c' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/main/login.html',
      1 => 1393032225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27075789530806aef25bc2-27168268',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../inc/_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<link href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/css/admin/login.css" rel="stylesheet" type="text/css" />

<?php $_template = new Smarty_Internal_Template("../inc/_login_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<!-- content start -->
<div id="content" class="login">
	<div class="login_left">
    	<img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/login/ad_1.jpg" id="ad" />
    </div>
    <div class="login_right">
		<div class="title">
        	<a class="login_title"><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/login/ico_1.gif" /><?php echo T('title_org');?>
登录</a>
        </div>
		
		<?php $_template = new Smarty_Internal_Template("../inc/_login.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
		
    </div>
</div>
<!-- content end -->

<?php $_template = new Smarty_Internal_Template("../inc/footer.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>


