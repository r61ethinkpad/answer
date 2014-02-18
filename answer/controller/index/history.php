<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 玉米病史的控制器
 * @author weijuan
 */
class history extends baseController
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
