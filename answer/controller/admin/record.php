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
        
        $over_point = $this->spArgs("over_point");
        $stime = $this->spArgs("stime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("stime"));
	$etime = $this->spArgs("etime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("etime"));
		
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'over_point' => $over_point,
            'stime'		=>	$stime,
            'etime'		=>	$etime,
            'user_id'           =>      $user_id,
            
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("recordModel")->queryList($a);

        //dump($rs);
        if ($rs['rows']) {
            
            $exam_points = spClass("examModel")->queryExamPoints();
            $all_scores = 0;
            foreach ($rs['rows'] as $key => $row) {
              
                $rs['rows'][$key]['over_point_text'] = $exam_points[$row['over_point']];
                //得到总分，然后得到详细
                $get_scores = 0;
                $point_desc = "<p>";
                $i = 0;
                if(intval($row['first_scores']) != 0)
                {
                    $get_scores += intval($row['first_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第一关：".$row['first_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['second_scores']) != 0)
                {
                    $get_scores += intval($row['second_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第二关：".$row['second_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['third_scores']) != 0)
                {
                    $get_scores += intval($row['third_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第三关：".$row['third_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['fourth_scores']) != 0)
                {
                    $get_scores += intval($row['fourth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第四关：".$row['fourth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['fifth_scores']) != 0)
                {
                    $get_scores += intval($row['fifth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第五关：".$row['fifth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['sixth_scores']) != 0)
                {
                    $get_scores += intval($row['sixth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第六关：".$row['sixth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['seventh_scores']) != 0)
                {
                    $get_scores += intval($row['seventh_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第七关：".$row['seventh_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['eighth_scores']) != 0)
                {
                    $get_scores += intval($row['eighth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第八关：".$row['eighth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['ninth_scores']) != 0)
                {
                    $get_scores += intval($row['ninth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第九关：".$row['ninth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                if(intval($row['tenth_scores']) != 0)
                {
                    $get_scores += intval($row['tenth_scores']);
                    $point_desc .= "<span style='margin-right:20px;'>第十关：".$row['tenth_scores']."分</span>";
                    $i++;
                    if($i%5 == 0)
                    {
                        $point_desc .= "</p><p>";
                    }
                }
                $point_desc .= "</p>";
                
                
                $rs['rows'][$key]['get_scores'] = $get_scores;
                $rs['rows'][$key]['point_desc'] = $point_desc;
                $rs['rows'][$key]['show_detail'] = true;
                $all_scores += $get_scores;
            }
            if($user_id != ""){
                $all_row = array(
                    'user_id' =>$user_id,
                    'answer_time'=>"<span style='font-weight:bolder;color:blue;'>合计</span>",
                    'get_scores'=>$all_scores,
                    'over_point_text'=>'',
                    'show_detail'=>false
                );
                array_push($rs['rows'],$all_row);
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