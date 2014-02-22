<?php /* Smarty version Smarty-3.0.8, created on 2014-02-19 09:03:26
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/header.html" */ ?>
<?php /*%%SmartyHeaderCode:1220286627530402de833be1-91938496%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6bfaff125f894fdda7165f5f66d615839895e3e3' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/header.html',
      1 => 1392771804,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1220286627530402de833be1-91938496',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("../inc/_header.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>

<body>
<!-- header start -->
<div id="header">
    <div id="header-top">
        <div class="floatL" style="font-size: 48px;font-weight: bolder;">
<!--            <img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/login/logo.gif"/>-->
            答题有奖题库管理系统
        </div>
        <?php if ($_smarty_tpl->getVariable('msgFlag')->value==true){?>
		<div class="menu">
        	<p>
                <!--<a href="#" class="msg">消息 <em>2</em></a> ｜
				<a href="#">建议</a> |-->
                <a href="#">帮助中心</a> ｜
				
				<a href='#' onclick="itemWindow('修改密码', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'passwd'),$_smarty_tpl);?>
', '500', '250');">修改密码</a> |
                <a href="#" onclick="if(confirm('确定退出登录吗？')){ location.href = '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'logout'),$_smarty_tpl);?>
';}">安全退出</a>
            </p>
			<p id="showName">
				<?php $_template = new Smarty_Internal_Template("../inc/_name.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
			</p>
        </div>
		<?php }?>
    </div>
    
    <div id="nav" class="nav">
        <div class="nav-cnt">
            <ul>
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('tNavigation')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
?>
			<li <?php if ($_smarty_tpl->tpl_vars['item']->value['tid']==$_GET['tid']){?> class="master current" <?php }else{ ?> class="master" <?php }?>>
				<a class="name" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>$_smarty_tpl->tpl_vars['item']->value['controller'],'a'=>$_smarty_tpl->tpl_vars['item']->value['action'],'tid'=>$_smarty_tpl->tpl_vars['item']->value['tid'],'sid'=>$_smarty_tpl->tpl_vars['item']->value['sid']),$_smarty_tpl);?>
"><strong><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</strong></a>

				<?php if (($_smarty_tpl->tpl_vars['item']->value['tid']==$_GET['tid']&&0<$_smarty_tpl->tpl_vars['item']->value['hassub'])){?>
					<?php if ((1==$_smarty_tpl->tpl_vars['item']->value['mainflag'])){?>
						<p class="subnav">
							<span><?php echo T('txt_common_operation');?>
</span>
							<?php  $_smarty_tpl->tpl_vars['subitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['subitem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subitem']->key => $_smarty_tpl->tpl_vars['subitem']->value){
?>				
									<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>$_smarty_tpl->tpl_vars['subitem']->value['controller'],'a'=>$_smarty_tpl->tpl_vars['subitem']->value['action'],'tid'=>$_smarty_tpl->tpl_vars['item']->value['tid']),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['subitem']->value['name'];?>
</a> |
							<?php }} ?>
						</p>
					<?php }else{ ?>
						<ul class="subnav" style="width:930px">
						<?php  $_smarty_tpl->tpl_vars['subitem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['subitem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['subitem']->key => $_smarty_tpl->tpl_vars['subitem']->value){
?>				
							<li <?php if ($_smarty_tpl->tpl_vars['subitem']->value['sid']==$_GET['sid']){?>class="current"<?php }?>>
								<a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>$_smarty_tpl->tpl_vars['subitem']->value['controller'],'a'=>$_smarty_tpl->tpl_vars['subitem']->value['action'],'tid'=>$_smarty_tpl->tpl_vars['item']->value['tid'],'sid'=>$_smarty_tpl->tpl_vars['subitem']->value['sid']),$_smarty_tpl);?>
"><span><?php echo $_smarty_tpl->tpl_vars['subitem']->value['name'];?>
</span></a>
							</li>
						<?php }} ?>
						</ul>
					<?php }?>
					
				<?php }elseif(($_smarty_tpl->tpl_vars['item']->value['tid']==$_GET['tid']&&0==$_smarty_tpl->tpl_vars['item']->value['hassub'])){?>
					<script type="text/javascript">
						$(document).ready(function(){
							$('#nav').addClass('nav-nosub');
						});
					</script> 	
				<?php }?>
			<?php }} ?>
			</li>
            </ul>
        </div>
    </div>
</div>
<!-- header end -->

<script type="text/javascript">
$(document).ready(function(){
	jQuery.ajax({
		type: 'get',
		url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'showName'),$_smarty_tpl);?>
",
		success: function(data,html){jQuery("#showName").html(data);},
		error: function(){}
	})
})
</script>
			