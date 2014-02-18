<?php
if (!defined('TBOWCARDUP')) { exit(1);}
// 用户自定义函数

/* 记录操作员日志
	operator_id    	 管理员id：必填   
	area_code      	 区号  ：必填          
	org_id         	 企业编号       
	org_name       	 企业名称       
	node_id        	 节点编号       
	user_id        	 用户编号       
	user_isdn      	 用户号码       
	card_mac       	 卡号           
	node_name      	 节点名称       
	opt_field      	 操作关键字  ：必填    
	opt_desc       	 操作描述  ：必填      
	opt_result     	 操作结果   ：必填     
	result_desc    	 结果描述     ：必填   
	opt_host_ip    	 操作主机ip   ：必填   
	module_id      	 模块id      ：必填    */
function optlog( $args=array() ){
	import('optLogModel');

	if($args){
		if($args['operator_id'] == '')
			$args['operator_id'] = $_SESSION['operator']['id'];
		
		
		
		if($args['opt_host_ip'] == '')
			$args['opt_host_ip'] = $_SERVER['REMOTE_ADDR'];
			
		if($args['operator_name'] == '')
			$args['operator_name'] = $_SESSION['operator']['name'];
		
		
		
		$args['opt_time'] = date('Y-m-d H:i:s');
                $args['record_time'] = date('Y-m-d H:i:s');
		
                $month = date('Ym');
                $table_name = "operator_log_".$month;
                $rs = spClass('optLogModel',array($table_name))->create($args);
                
		
	}
	else{
		$rs = array(
			'status' => '-9',
			'desc'	=> '传入参数为空',
		);
	}
	return $rs;
}

function getArea($areacode){
	$rs = $GLOBALS['dataconfig']['areacode'];
	if($areacode == '_ARRAY'){
		return $rs;
	}
	elseif($areacode == '0'){
		return '全省';
	}
	else{
		return $rs[$areacode];
	}
}

function encryptPasswd($passwd){
	//return strtoupper(md5($passwd));
        return md5(trim($passwd));
}



/**
* 将调试信息输出到日志文件
* @param string $var_name 自定义需要显示的变量名
* @param string or array $content 变量内容
*/
function filedump($content, $var_name='')
{
	$log_path = $GLOBALS['sysparams']['debug_log_file_path'];
	if(!file_exists($log_path))
	{
		umask(0000);
		@mkdir($log_path, 0777, true);
	}
	$filename = "php_debug.log";
	$file = $log_path.'/'.$filename;
	
	$fp = fopen($file, 'a');
	if($fp)
	{
		if($var_name == '' || $var_name == null) //如果$var_name为空，自动取名
		{
			$var_name = 'log-'.date('YmdHis');
			//print $name;
			
			if(is_string($content) || is_int($content) || is_float($content))  //字符串、整型、浮点类型
				$content = '$'.$var_name . ' = ' . $content;
			if(is_bool($content))  //布尔类型
			{
				if($content)
					$content = '$'.$var_name . ' = ' . "true";
				else
					$content = '$'.$var_name . ' = ' . "false";
			}
			if(is_array($content))  //数组类型
				$content = arrayeval($var_name, $content);
			$time = date('Y-m-d H:i:s');
			$title = "Logged at $time , content is: \n\n";
			$split = "==============================================================================================";
			fwrite($fp, $title);
			fwrite($fp, $content."\n\n");
			fwrite($fp, $split."\n\n");
		}
		else  //如果$var_name不为空
		{
			if(is_string($content) || is_int($content) || is_float($content))  //字符串、整型、浮点类型
				$content = '$'.$var_name . ' = ' . $content;
			if(is_bool($content))  //布尔类型
			{
				if($content)
					$content = '$'.$var_name . ' = ' . "true";
				else
					$content = '$'.$var_name . ' = ' . "false";
			}
			if(is_array($content))  //数组类型
				$content = arrayeval($var_name, $content);
			$time = date('Y-m-d H:i:s');
			$title = "Logged at $time , content is: \n\n";
			$split = "==============================================================================================";
			fwrite($fp, $title);
			fwrite($fp, $content."\n\n");
			fwrite($fp, $split."\n\n");
		}
			
	}
	fclose($fp);
}
	
	
//数组转换成字串
function arrayeval($name, $array, $level = 0) 
{
	$space = '';
	for($i = 0; $i <= $level; $i++) 
	{
		$space .= "\t";
	}
	if($level == 0)
		$evaluate = "'".$name."' => array\n$space(\n";
	else
		$evaluate = $name." => array\n$space(\n";
	$comma = $space;
	
	foreach($array as $key => $val) 
	{
		//$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		$key = '\''.addcslashes($key, '\'\\').'\'';
		$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		if(is_array($val)) 
			$evaluate .= $comma.arrayeval( $key, $val, $level + 1);
		else 
			$evaluate .= "$comma$key => $val";
		
		$comma = "\n$space";
	}
	$evaluate .= "\n$space),\r\n";
	return $evaluate;
}	
	
	
	
	