<?php /* Smarty version Smarty-3.0.8, created on 2014-02-23 09:28:28
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/game/question.html" */ ?>
<?php /*%%SmartyHeaderCode:40695445953094ebc57c457-12916631%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e6b78e6addc736114ddbe0d971d7cbab226bdb7' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/game/question.html',
      1 => 1393080697,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '40695445953094ebc57c457-12916631',
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
    	<div class="timu clearfix" id="question">
            <p class="colRed"><?php echo $_smarty_tpl->getVariable('question')->value['question_content'];?>
</p>
            <p><a onclick="select_answer(this,'A')">A、<?php echo $_smarty_tpl->getVariable('question')->value['alternative_a'];?>
</a></p>
            <p><a onclick="select_answer(this,'B')">B、<?php echo $_smarty_tpl->getVariable('question')->value['alternative_b'];?>
</a></p>
            <p><a onclick="select_answer(this,'C')">C、<?php echo $_smarty_tpl->getVariable('question')->value['alternative_c'];?>
</a></p>
            <p><a onclick="select_answer(this,'D')">D、<?php echo $_smarty_tpl->getVariable('question')->value['alternative_d'];?>
</a></p>
        </div>
        <div class="btn_box clearfix">
        	<a class="btn_blue" onclick="cm();">提交</a>
        </div>
    </div>
</div>
<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'game','a'=>'answer','type'=>$_GET['type']),$_smarty_tpl);?>
" id="form1" method="post">
    <input type="hidden" id="answer" name="answer" value="">
</form>
<p class="info">游戏说明：同一个玩家一周有3次参与游戏的机会。在同一关卡中，答错题目的次数不得多于4次。答题错误次数达到4次，则游戏结束。</p>
</body>
</html>
<script>
    var select_answer=function(obj,answer){
        $("#answer").val(answer);
        $("#question a").removeClass('p_a_selected');
        $(obj).addClass('p_a_selected');
    }
    var cm=function(){
        var v=$("#answer").val();
        if(!v){alert("请选择答案！");return;}
        document.getElementById('form1').submit();
    }
</script>