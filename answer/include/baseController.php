<?php
if (!defined('TBOWCARDUP')) { exit(1);}
/**
 * 全部控制器页面的父类
 * 不包含权限控制
 * 实现一些全局的页面显示
 * @author Harrie
 * @version 1.0
 * @created 2010-06-28
 */
class baseController extends spController
{
	public $pageSize = 10;
        public $projectName = "";
        /**
	 * 覆盖控制器构造函数，进行相关的赋值操作
	 */
	public function __construct()
	{
		parent::__construct();
		//模版
		$this->tplName = TPL_NAME;
		//控制器名称
		$this->title = "";
		//语言
		$this->setLang('cn_common');
		               
                //项目名称
                $this->projectName = "黄淮海夏玉米区玉米病害检索预警系统";
		
		//导航菜单
		$this->tNavigation = spClass("navigationModel")->navigationTree(0);	
		
                
	}
	/**
	 * 输出模板
	 *
     * @param $tplname   模板路径及名称
     * @param $output   是否直接显示模板，设置成FALSE将返回HTML而不输出
	 */
	public function display($tplname, $output = TRUE)
	{
		@ob_start();
		if(TRUE == $GLOBALS['G_SP']['view']['enabled']){
			$this->v->display('../inc/index/header.html');
			$this->v->display($tplname);
			$this->v->display('../inc/index/footer.html');
		}else{
			extract($this->__template_vals);
			require($tplname);
		}
		if( TRUE != $output )return ob_get_clean();
	}

	//只显示部分内容
	public function displayPartial($tplname, $output = TRUE)
	{
		@ob_start();
		if(TRUE == $GLOBALS['G_SP']['view']['enabled']){
			$this->v->display($tplname);
		}else{
			extract($this->__template_vals);
			require($tplname);
		}
		if( TRUE != $output )return ob_get_clean();
	}
	
	//显示
	public function displaySimple($tplname, $output = TRUE)
	{
		@ob_start();
		if(TRUE == $GLOBALS['G_SP']['view']['enabled']){
			$this->v->display('../inc/index/_header.html');
			$this->v->display($tplname);
			$this->v->display('../inc/index/_footer.html');
		}else{
			extract($this->__template_vals);
			require($tplname);
		}
		if( TRUE != $output )return ob_get_clean();
	}
	
	
	/**
	 * 错误提示程序  应用程序的控制器类可以覆盖该函数以使用自定义的错误提示
	 * @param $msg   错误提示需要的相关信息
	 * @param $url   跳转地址
	 * 
	 * @param msg
	 * @param url
	 */
	public function jsonerror($msg, $url='')
	{
		exit("{'status': 0, 'data': {".$msg."},'url': '".$url."'}");
	}

	/**
	 * 成功提示程序  应用程序的控制器类可以覆盖该函数以使用自定义的成功提示
	 * @param $msg   成功提示需要的相关信息
	 * @param $url   跳转地址
	 * 
	 * @param msg
	 * @param url
	 */
	public function jsonsuccess($msg, $url)
	{
		exit("{'status': 1, 'msg': '".$msg."', 'url':'".$url."'}");
	}
	
	public function jsonreturn($status, $msg, $data)
	{
		exit("{'status': ".$status.", 'msg': '".$msg."', 'data': ".$data."}");
	}
	/**
     *
     * 跳转程序
     *
     * 应用程序的控制器类可以覆盖该函数以使用自定义的跳转程序
     *
     * @param $url  需要前往的地址
     * @param $delay   延迟时间
     */
    public function jump($url, $delay = 0){
		parent::jump($url, $delay);
    }
    
    
	
}
?>