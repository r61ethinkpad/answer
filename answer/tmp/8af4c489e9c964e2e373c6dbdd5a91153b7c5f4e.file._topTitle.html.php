<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 16:51:05
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/_topTitle.html" */ ?>
<?php /*%%SmartyHeaderCode:11519520153031ef9f115b6-97921223%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8af4c489e9c964e2e373c6dbdd5a91153b7c5f4e' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/_topTitle.html',
      1 => 1392713462,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11519520153031ef9f115b6-97921223',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<ul class="tab-label">
<?php if ($_smarty_tpl->getVariable('current_tab')->value=='edit'){?>
    <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>$_smarty_tpl->getVariable('current_action')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">题目列表</a></li>
    <li class="current"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'edit','id'=>$_smarty_tpl->getVariable('id')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">编辑题目</a></li>
<?php }elseif($_smarty_tpl->getVariable('current_tab')->value=='detail'){?>
    <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>$_smarty_tpl->getVariable('current_action')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">题目列表</a></li>
    <li class="current"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'detail','id'=>$_smarty_tpl->getVariable('id')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">查看详细</a></li>
<?php }else{ ?>
    <li <?php if ($_smarty_tpl->getVariable('current_tab')->value=='list'){?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>$_smarty_tpl->getVariable('current_action')->value,'tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">题目列表</a></li>

    <li <?php if ($_smarty_tpl->getVariable('current_tab')->value=='new'){?> class="current"<?php }?>><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'create','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">新增题目</a></li>
<?php }?>

</ul>