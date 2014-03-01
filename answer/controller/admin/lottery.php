<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 抽奖的控制器
 * @author: guohao
 */
class lottery extends tbController {

    

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        
        $this->displaySimple("myPrize/index.html");
        
    }

    
    public function getUserInfo()
    {
        
    }
    
    public function save()
    {
        
    }

}