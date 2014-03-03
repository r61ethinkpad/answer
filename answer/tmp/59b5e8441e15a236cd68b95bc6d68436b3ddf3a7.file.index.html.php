<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 22:38:02
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/game/index.html" */ ?>
<?php /*%%SmartyHeaderCode:64918141953047334118db0-52256435%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '59b5e8441e15a236cd68b95bc6d68436b3ddf3a7' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/game/index.html',
      1 => 1393079755,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '64918141953047334118db0-52256435',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
        <span class="floatL">选择题目类型</span>
    </div>
    <div class="question_main">
        <div class="timu clearfix" id="question_type_list">
            <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('exam_types')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
            <a class="btn_blue" onclick="question_type_select(this,'<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
')"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</a>
            <?php }} ?>
        </div>
        <div class="btn_box clearfix">
            <a class="btn_start" onclick="go_question();"></a>
        </div>
    </div>
</div>
</body>
</html>
<script>
    var question_type=null;
    var question_type_select=function(obj,type){
        $("#question_type_list a").removeClass("btn_blue_select");
        $(obj).addClass("btn_blue_select");
        question_type=type;
    }
    var go_question=function(){
        if(question_type){
            window.location.href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'game','a'=>'question'),$_smarty_tpl);?>
&type="+question_type;
        }else{
            alert("请选择题目类型！");
        }
    }
</script>