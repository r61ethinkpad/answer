<?php /* Smarty version Smarty-3.0.8, created on 2014-02-16 20:44:13
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/main/login.html" */ ?>
<?php /*%%SmartyHeaderCode:19034409455300b29d876ac2-29341743%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '787facf35d52ec0f6e3e4aed22b9bf8f4327ef8f' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/main/login.html',
      1 => 1387855714,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19034409455300b29d876ac2-29341743',
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


