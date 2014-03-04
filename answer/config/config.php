<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

// 定义框架目录
define("SP_PATH", dirname(__FILE__) . "/../../libs/SpeedPHP");

// 默认时区设置
@date_default_timezone_set('PRC');

require(APP_PATH . '/config/params.php');
// 载入用户自定义的函数文件
require(APP_PATH . '/include/functions.php');
//view/default
define("TPL_NAME", 'default');

$spConfig = array(
    'mode' => 'debug', //默认的调试模式
    //'mode' => 'release' // 部署模式

    "app_path" => APP_PATH,
    'ext' => array(
        

        'spVerifyCode' => array(//验证码扩展
            'width' => 60, //验证码宽度
            'height' => 22, //验证码高度
            'length' => 4, //验证码字符长度
            'bgcolor' => '#FFFFFF', //背景色
            'noisenum' => 0, //图像噪点数量
            'fontsize' => 24, //字体大小
            'fontfile' => 'font.ttf', //字体文件
            'format' => 'gif', //验证码输出图片格式
        ),
        'spAcl' => array(
            'checker' => array("aclModel", "check"),
            'prompt' => array("aclModel", "acljump"),
        ),
    ),
    'lang' => array(
        'cn_common' => APP_PATH . '/view/lang/cn_common.php',
    ),
    'view' => array(
        'enabled' => TRUE, // 开启视图
        'config' => array(
            'template_dir' => APP_PATH . '/view/', // 模板目录
            'compile_dir' => APP_PATH . '/tmp/', // 编译目录
            'cache_dir' => APP_PATH . '/tmp/', // 缓存目录
            'left_delimiter' => '<{', // smarty左限定符
            'right_delimiter' => '}>', // smarty右限定符
        ),
        'debugging' => false,
    ),
    'model_path' => APP_PATH . '/model', // 定义model类的路径

    'url' => array(// URL设置
        'url_path_info' => FALSE, // 是否使用path_info方式的URL
    ),
    'auto_load_model' => array('verifierModel', 'spPager'),
    'include_path' => array(
        APP_PATH . '/include',
        APP_PATH . '/extension',
        APP_PATH . '/config',
    ),
    'launch' => array(
        'router_prefilter' => array(
            array('spAcl', 'maxcheck') // 开启强制的权限控制
        )
    ),
    "db" => array(
        'driver' => 'mysql',
        'host' => 'localhost',
        'login' => 'usr_answercp',
        'password' => 'db_answercp',
        'database' => 'dbanswercp',
        'prefix' => 'pc_'
    ),
);
