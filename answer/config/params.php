<?php
if(!defined('TBOWCARDUP')) exit(1);


/*	province、sys_org_type请根据实际情况进行配置，
	配置完成后，请运行超级管理员的字典表配置页面，
	其他参数可由程序开发人员进行配置。
*/


$GLOBALS['sysparams'] = Array(
	
	'files'	=>	array(   //上传/下载文件参数
	
			'filesize'		=>	'5',	//上传文件大小,单位M
			
			'saveflag'		=>	0,		//文件是否保存：0不保存；1保存
				
			'savepath'	=>	APP_PATH.'/../files/',//保存路径
				
			'templatepath'	=>	APP_PATH."/filetpl/",		//文件模板路径
				
			'xls_max_rows' 	=> 	5000, //xsl文件最大行数			
				
			'phpexcelpath' => APP_PATH.'/../libs/PHPExcel/',			
	),
	
	'debug_log_file_path' => '/tmp',//"D:\\up",	//debug日志地址   
	'bank_type_id'=>'9999',//规定了银行题库分类为9999.其他都是自定义题库的分类
        'save_goods_picture_url'=>APP_PATH."/view/default/images/goods/",//规定了奖品图片存放地址
        'tmp_log'=>APP_PATH."/tmp/error.log",
);

$GLOBALS['sysparams']['lang'] = 'cn_common';

?>