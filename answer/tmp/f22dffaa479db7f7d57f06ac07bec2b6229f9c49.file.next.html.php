<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 21:35:59
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/game/next.html" */ ?>
<?php /*%%SmartyHeaderCode:17593845625308a7bf3d2ee8-28921574%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f22dffaa479db7f7d57f06ac07bec2b6229f9c49' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/game/next.html',
      1 => 1393075887,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17593845625308a7bf3d2ee8-28921574',
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
    </div>
    <div class="question_main">
        <div class="timu wrongTxt clearfix">
            <p><img src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/images/game/love.png" /></p>
            <p>恭喜您，通过第<?php echo $_SESSION['point']-1;?>
关</p>
            <p>已经总共获得<?php echo $_SESSION['total_record'];?>
个积分</p>
            <p>继续努力进入进入下一关</p>
        </div>
        <div class="btn_box clearfix">
            <a class="btn_red" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'game','a'=>'question','type'=>$_GET['type']),$_smarty_tpl);?>
">下一关</a>
        </div>
    </div>
</div>
<p class="info">游戏说明：在同一局域网内多个玩家进行游戏并不等同于小号和一人多号行为，不同的玩家可以在同一局域网内进行各自的游戏的交互行为会被严格监控。</p>
</body>
</html>