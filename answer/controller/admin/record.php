<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题记录的控制器
 * @author: guohao
 */
class record extends tbController {

    

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        $_SESSION['record_tid'] = $this->spArgs("tid");
        $_SESSION['record_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['record_tid'];
        $this->sid = $_SESSION['record_sid'];
        
        $this->firstday = date('Y-m-01');
	$this->today = date('Y-m-d');
        
        $this->exam_points = spClass("examModel")->queryExamPoints();
        $this->display("record/index.html");
    }

    
    public function queryList($page = 1, $pagesize = 10) {


        
        $over_point = $this->spArgs("over_point");
        $stime = $this->spArgs("stime")==""?date('Ym01'):str_replace('-', '', $this->spArgs("stime"));
	$etime = $this->spArgs("etime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("etime"));
		
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'over_point' => $over_point,
            'stime'		=>	$stime,
            'etime'		=>	$etime,
            
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("recordModel")->queryList($a);

        //dump($rs);
        if ($rs['rows']) {
            
            $exam_points = spClass("examModel")->queryExamPoints();
            foreach ($rs['rows'] as $key => $row) {
              
                $rs['rows'][$key]['over_point_text'] = $exam_points[$row['over_point']];
            }
        }

        $this->record_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&over_point=' . $over_point .'&stime='.$stime.'&etime='.$etime;;
        $this->query_url = spUrl("record", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['record_tid'];
        $this->sid = $_SESSION['record_sid'];
        
        $this->displayPartial("record/_list.html");
    }

}