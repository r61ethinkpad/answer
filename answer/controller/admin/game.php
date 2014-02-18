<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 病史管理的控制器
 * @author: guohao
 */
class record extends tbController {

    public $moduleId = '4'; //病史管理

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        $_SESSION['history_tid'] = $this->spArgs("tid");
        $_SESSION['history_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['history_tid'];
        $this->sid = $_SESSION['history_sid'];


        //$this->growth_period = spClass("growthPeriodModel")->queryArray();

        $this->province_list = $GLOBALS['dataconfig']['province_code'];

        $this->level_list = spClass("historyModel")->getLevelArray();

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('history', 'create'),
        );
        $this->display("history/index.html");
    }
	
}