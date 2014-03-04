<?php /* Smarty version Smarty-3.0.8, created on 2014-03-04 15:33:15
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/game/question.html" */ ?>
<?php /*%%SmartyHeaderCode:524467759531581bb8d6a17-73355292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2e6b78e6addc736114ddbe0d971d7cbab226bdb7' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/game/question.html',
      1 => 1393900922,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '524467759531581bb8d6a17-73355292',
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
<div class="question_box" id="question_box">
    <?php $_template = new Smarty_Internal_Template("game/_question.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
$_template->assign('question',$_smarty_tpl->getVariable('question')->value);$_template->assign('customer_status',$_smarty_tpl->getVariable('customer_status')->value); echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</div>
<form id="form1" method="post">
    <input type="hidden" id="answer" name="answer" value="">
</form>
<p class="info">游戏说明：在答题过程请不要刷新页面，如果刷新页面则被认为是放弃当前的答题机会，每一关的答题时间为90秒，答题错误次数达到4次，则游戏结束。当前剩余时间为<span id="timer"></span>秒</p>
</body>
</html>
<script>
    var select_answer=function(obj,answer){
        $("#answer").val(answer);
        $("#question a").removeClass('p_a_selected');
        $(obj).addClass('p_a_selected');
    }
    var cm=function(){
        var answer=$("#answer").val();
        if(!answer){alert("请选择答案！");return;}
        //document.getElementById('form1').submit();
        $.ajax({
            data:{answer:answer},
            url:"<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'game','a'=>'answer'),$_smarty_tpl);?>
",
            type:"POST",
            beforeSend:function(){
                $("#question_box").html("正在提交答案...");
            },
            success:function(data){
                $("#question_box").html(data);
            },
            complete:function(){
                $("#answer").val("");
            }
        })
    }
    $(document).ready(function(){
        interval=setInterval(timer,1000);
    });
    var t=90;
    var interval=null;
    var timer=function(){
        if(t>0){
            $("#timer").html(t);
            t--;
        }else{
            $("#answer").val("time_over");
            cm();
            clearInterval(interval);
        }
    }
    var resetTime=function(){
        clearInterval(interval);
        interval=setInterval(timer,1000);
        t=90;
    }
    var timeOver=function(){
        clearInterval(interval);
        t=0;
        $("#timer").html(t);
    }
</script>