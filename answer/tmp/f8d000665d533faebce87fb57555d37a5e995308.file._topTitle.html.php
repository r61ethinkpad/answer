<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 22:41:20
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answerType/_topTitle.html" */ ?>
<?php /*%%SmartyHeaderCode:108199064453037110e88955-86253952%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f8d000665d533faebce87fb57555d37a5e995308' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answerType/_topTitle.html',
      1 => 1392734477,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '108199064453037110e88955-86253952',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul class="tab-label">
    <li <?php if ($_smarty_tpl->getVariable('current_tab')->value=='list'){?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">题库分类列表</a></li>
    <li <?php if ($_smarty_tpl->getVariable('current_tab')->value=='new'){?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增题库分类</a></li>
</ul>