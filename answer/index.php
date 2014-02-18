<?php
define('TBOWCARDUP', true);

define("APP_PATH",dirname(__FILE__));

define("MAIZE_VERSION","1.0.0");

if( true != @file_exists(APP_PATH.'/config/config.php') ){ exit(1); }

// 载入配置与定义文件
require("config/config.php");

// 当前模块附加的配置
// view路径
$spConfig['view']['config']['template_dir'] = APP_PATH.'/view/'.TPL_NAME.'/index/'; // 模板目录

//控制器路径
$spConfig['controller_path'] = APP_PATH.'/controller/'.basename(__FILE__,".php");

//应用程序名称
$spConfig['sp_app_id'] = 'Maize';
//去掉权限控制
$spConfig['launch'] = array();
//session名称
session_name('Maize');


// 载入SpeedPHP框架
require(SP_PATH."/SpeedPHP.php");
import('baseController.php');
//import('udModel.php');
import('dataconfig.php');
//import('aclModel');

spRun();
