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
        
        $this->firstday = date('Y-m-d');
	$this->today = date('Y-m-d');
        
        //如果单点登录过来的，就会有这个值
        $this->query_user = $_SESSION['so_login']['query_user'];
        
        //dump($this->query_user);
        
        $this->exam_points = spClass("examModel")->queryExamPoints();
        if($this->spArgs("from") == 'bank')
        {
            $this->displaySimple("record/index.html");
        }  else {
            $this->display("record/index.html");
        }
        
    }

    
    public function queryList($page = 1, $pagesize = 10) {


        $user_id = $this->spArgs("user_id") == "输入用户编号"?"":trim($this->spArgs("user_id"));
        
        //$over_point = $this->spArgs("over_point");
        $stime = $this->spArgs("stime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("stime"));
	$etime = $this->spArgs("etime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("etime"));
		
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'stime'		=>	$stime,
            'etime'		=>	$etime,
            'user_id'           =>      $user_id,
            
        );
        $rs = spClass("userStatusModel")->queryList($a);
        if($rs['rows'])
        {
            foreach($rs['rows'] as $key=>$row)
            {
                $user_id = $row['user_id'];
                $a['user_id'] = $user_id;
                $record_rs = spClass("recordModel")->queryList($a);
                $point_desc = "";
                $rs['rows'][$key]['show_detail'] = false;
                if ($record_rs['rows']) {
                    $rs['rows'][$key]['show_detail'] = true;
                    foreach ($record_rs['rows'] as  $r_row) {
                        //得到详细
                        
                        $point_desc .= "<p>";
                        $point_desc .= "<span style='margin-right:5px;'>答题时间：".$r_row['answer_time']."<span>";
                        
                        if(intval($r_row['first_scores']) != 0)
                        {
                            $point_desc .= "<span style='margin-right:2px;'>第一关:".$r_row['first_scores']."分</span>";
                           
                        }
                        if(intval($r_row['second_scores']) != 0)
                        {
                            
                            $point_desc .= "<span style='margin-right:2px;'>第二关:".$r_row['second_scores']."分</span>";
                            
                        }
                        if(intval($r_row['third_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第三关:".$r_row['third_scores']."分</span>";
                          
                        }
                        if(intval($r_row['fourth_scores']) != 0)
                        {
                            
                            $point_desc .= "<span style='margin-right:2px;'>第四关:".$r_row['fourth_scores']."分</span>";
                            
                        }
                        if(intval($r_row['fifth_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第五关:".$r_row['fifth_scores']."分</span>";
                         
                        }
                        if(intval($r_row['sixth_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第六关:".$r_row['sixth_scores']."分</span>";
                          
                        }
                        if(intval($r_row['seventh_scores']) != 0)
                        {
                          
                            $point_desc .= "<span style='margin-right:2px;'>第七关:".$r_row['seventh_scores']."分</span>";
                           
                        }
                        if(intval($r_row['eighth_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第八关:".$r_row['eighth_scores']."分</span>";
                           
                        }
                        if(intval($r_row['ninth_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第九关:".$r_row['ninth_scores']."分</span>";
                           
                        }
                        if(intval($r_row['tenth_scores']) != 0)
                        {
                           
                            $point_desc .= "<span style='margin-right:2px;'>第十关:".$r_row['tenth_scores']."分</span>";
                            
                        }
                        $point_desc .= "</p>";


                       
                        
                       
                    }
                 
                }
                $rs['rows'][$key]['point_desc'] = $point_desc;
                
            }
        }
       
        //dump($rs);
        

        $this->record_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&stime='.$stime.'&etime='.$etime;;
        $this->query_url = spUrl("record", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['record_tid'];
        $this->sid = $_SESSION['record_sid'];
        
        $this->displayPartial("record/_list.html");
    }
    
    
    public function myRecord()
    {
	$today = date('Y-m-d');     
        //如果单点登录过来的，就会有这个值
        $query_user = $_SESSION['so_login']['query_user'];
        //var_dump($query_user);var_dump($today);
        $this->record_list = spClass("userStatusModel")->findAll(array('user_id'=>$query_user,'term'=>$today));
        
        $this->displaySimple("record/myRecord.html");
    }
    
    

}