<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 企业管理员首页控制器
 * @author weijuan
 */
class main extends baseController
{
	
	public function __construct(){ 
		parent::__construct(); 
	}
	
    function index(){
		$this->home();
    }
    
    function home(){
        $this->displayPartial("../inc/index/home.html");
    }
    
    
    function jumpMain()
    {
        $this->jump(spUrl('crop','index'));
    }
}
