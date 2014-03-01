<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 我的奖品的控制器
 * @author: guohao
 */
class myPrize extends tbController {

    

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        $_SESSION['myPrize_tid'] = $this->spArgs("tid");
        $_SESSION['myPrize_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];
        
        $this->firstday = date('Y-m-d');
	$this->today = date('Y-m-d');
        
        //如果单点登录过来的，就会有这个值
        $this->query_user = $_SESSION['so_login']['user_id'];
        
        if($this->spArgs("from") == 'bank')
        {
            $this->displaySimple("myPrize/index.html");
        }  else {
            $this->display("myPrize/index.html");
        }
        
    }

    
    public function queryList($page = 1, $pagesize = 10) {


        $user_id = $this->spArgs("user_id") == "输入用户编号"?"":trim($this->spArgs("user_id"));
        
        $stime = $this->spArgs("stime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("stime"));
	$etime = $this->spArgs("etime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("etime"));
		
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'stime'		=>	$stime,
            'etime'		=>	$etime,
            'user_id'           =>      $user_id,
            
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("scoreSpendModel")->queryList($a);



        $this->list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&user_id=' . $user_id .'&stime='.$stime.'&etime='.$etime;;
        $this->query_url = spUrl("myPrize", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];
        
        $this->displayPartial("myPrize/_list.html");
    }

}