<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 玉米病害的控制器
 * @author guohao
 */
class crop extends baseController {

    public function __construct() {
        parent::__construct();
    }

    function index() {
        
        $this->demo = "HelloWorld";
        
        
        $this->display("crop/index.html");
    }

    function home() {
        $this->displayPartial("../inc/index/home.html");
    }

}
