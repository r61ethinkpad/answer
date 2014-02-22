<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 22:00:30
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/game/over.html" */ ?>
<?php /*%%SmartyHeaderCode:6735835465308ad7e8596d4-77378598%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0736943bab102cb44d607a22523a10be79bdf287' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/game/over.html',
      1 => 1393077408,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6735835465308ad7e8596d4-77378598',
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
        <span class="floatL">您的总成绩</span>
        <span class="floatR">
        	<span class="right">对<?php echo $_SESSION['total_record'];?>
题</span>
            <span class="wrong">错<?php echo $_SESSION['total_wrong'];?>
题</span>
        </span>
    </div>
    <div class="question_main">
        <div class="timu wrongTxt clearfix">
            <?php if ($_SESSION['point']>10){?>
            <p><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/game/love.png" /></p>
            <p>恭喜您，您已经通关</p>
            <p>获得<?php echo $_SESSION['total_record'];?>
个积分</p>
            <p>感谢您的参与，欢迎下次再来答题哦~</p>
            <?php }else{ ?>
            <p><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/game/cry.png" /></p>
            <p>非常遗憾，您没有通关</p>
            <p>获得<?php echo $_SESSION['total_record'];?>
个积分</p>
            <p>感谢您的参与，欢迎下次再来答题哦~</p>
            <?php }?>
        </div>
    </div>
</div>
<p class="info">游戏说明：在同一局域网内多个玩家进行游戏并不等同于小号和一人多号行为，不同的玩家可以在同一局域网内进行各自的游戏的交互行为会被严格监控。</p>
</body>
</html>