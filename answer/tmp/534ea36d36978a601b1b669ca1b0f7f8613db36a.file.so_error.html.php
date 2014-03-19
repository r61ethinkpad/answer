<?php /* Smarty version Smarty-3.0.8, created on 2014-03-18 18:31:23
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/../inc/so_error.html" */ ?>
<?php /*%%SmartyHeaderCode:17594580265328207bf139c1-33008982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '534ea36d36978a601b1b669ca1b0f7f8613db36a' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/../inc/so_error.html',
      1 => 1395138682,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17594580265328207bf139c1-33008982',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sorry! 你访问的页出错了！</title>
    <link href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/css/game/reset.css" rel="stylesheet" type="text/css"/>
    <link href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/css/game/style.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.min.js"></script>
</head>
<body>
<div class="question_box">
<div class="question_main">
    <div class="timu wrongTxt clearfix" style=" padding-top: 0px;">
        <p style="font-size:16px;">Oh,My God！活动要开始了，你准备好了吗？</p>
        <p><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/game/laugh.png"  style="width:70px;height:70px;"/></p>
        
<!--        <p align="center" style="color:#ff0000;font-size:16px;">出错了！<?php echo $_smarty_tpl->getVariable('errorinfo')->value;?>
</p>-->
<p>&nbsp;</p>
        <p style="font-size:14px;text-align: left;">每周举办一期游戏活动，分为”资格累计期“和”游戏活动日“</p>
    </div>
    
    <ul>
            <li  style="font-size:14px;"><span style="font-weight:bolder;color: red;">资格累计期:上周五00:00:00至本周四23:59:59</span>(通过建行网上银行或者手机银行办理至少一笔金额10元以上的账务性交易,即可参加每周五的游戏活动,赢取大奖！)</li>
            <li  style="font-size:14px;"><span style="font-weight:bolder;color: red;">游戏活动日:每周五早9:00-晚21:00</span></li>
            <li style="font-size:14px;">每期获得的游戏资格只能在当周使用，未如期使用的视为作废，不累计</li>
        </ul>
    <div class="btn_box clearfix">
<!--        <A href="javascript:history.back(-1);" class="btn_red"><FONT >此处返回</FONT></A>-->
    </div>
</div>
</div>
</body>
</html>