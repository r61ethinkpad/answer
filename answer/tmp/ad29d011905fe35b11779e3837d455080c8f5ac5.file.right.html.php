<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 22:38:25
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/game/right.html" */ ?>
<?php /*%%SmartyHeaderCode:20064606755308b6613f08d6-45645440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad29d011905fe35b11779e3837d455080c8f5ac5' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/game/right.html',
      1 => 1393079755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20064606755308b6613f08d6-45645440',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>答题送积分</title>
    <link href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/css/game/reset.css" rel="stylesheet" type="text/css"/>
    <link href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/css/game/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.min.js"></script>
</head>
<body>
<div class="question_box">
	<div class="question_title clearfix">
    	<span class="floatL">当前在第<?php echo $_SESSION['point'];?>
关</span>
        <span class="floatR">
        	<span class="right">对<?php echo $_SESSION['right'];?>
题</span>
            <span class="wrong">错<?php echo $_SESSION['wrong'];?>
题</span>
        </span>
    </div>
    <div class="question_main">
    	<div class="timu wrongTxt clearfix">
        	<p><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/game/love.png" /></p>
            <p>恭喜您，答对了</p>
            <p>获得1个积分</p>
        </div>
        <div class="btn_box clearfix">
        	<a class="btn_red" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'game','a'=>'question','type'=>$_GET['type']),$_smarty_tpl);?>
">下一题</a>
        </div>
    </div>
</div>
<p class="info">游戏说明：在同一局域网内多个玩家进行游戏并不等同于小号和一人多号行为，不同的玩家可以在同一局域网内进行各自的游戏的交互行为会被严格监控。</p>
</body>
</html>