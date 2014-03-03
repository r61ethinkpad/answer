<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题游戏的控制器
 * @author: guohao
 */
class game extends tbController {
    public $c=10;
    public $records=array();
    public $time_out=100;

    public function __construct() {
        parent::__construct();
        $term=date("Ymd");
        $model=spClass("customerStatusModel")->GetOneByUserIdAndTerm($_SESSION['so_login']['user_id'],$term);
        if($model){
            $this->customer_status=json_decode($model['status']);
            $this->total_count=$model['total_count'];
            $this->draw_count=$model['draw_count'];
            $this->records=explode("|",$this->customer_status->records);
            if($this->customer_status->round>3){
                if($this->is_ajax()){
                    $this->displayPartial("game/_finish.html");
                }else{
                    $this->displayPartial("game/finish.html");
                }
                exit;
            }
        }
        if(!isset($_SESSION['current_question_id'])){

            if($this->customer_status){
                $left_c=($this->c-$this->customer_status->wrong-$this->customer_status->right);
                if($left_c<$this->c){
                    $first_get=false;
                }else{
                    $first_get=true;
                    $left_c=$this->c;
                }
                $_SESSION['type']=$this->customer_status->type;
                if($_SESSION['type']>0){
                    $randExamIds=spClass("examModel")->GetRandExamIdsByTypeAndPoint($_SESSION['type'],$this->customer_status->point,$left_c,$first_get);
                    if(!$randExamIds){
                        if($this->is_ajax()){
                            $this->displayPartial("game/_error.html");
                        }else{
                            $this->displayPartial("game/error.html");
                        }
                        exit;
                    }
                    $_SESSION['current_question_id']=array_pop($randExamIds);
                    $_SESSION['randExamIds']=$randExamIds;
                }
            }
        }
    }
    /**
     * 选择题类型
     */
    public function index() {
        if(!$this->customer_status||intval($_SESSION['type'])<0){
            $this->exam_types = spClass("examTypeModel")->queryArray();
            $this->displayPartial("game/index.html");
        }else{
            $this->question();
        }
    }
    
    public function question()
    {
        $is_ajax=$this->is_ajax();//判断是不是ajax方式访问！

        if(isset($_REQUEST['type'])){
            $type=$_REQUEST['type'];
        }else{
            $type=$_SESSION['type'];
        }
        if(!isset($_SESSION['current_question_id'])&&$type){
            $_SESSION['type']=$type;
            $randExamIds=spClass("examModel")->GetRandExamIdsByTypeAndPoint($type,1);
            if(!$randExamIds){
                if($is_ajax){
                    $this->displayPartial("game/_error.html");
                }else{
                    $this->displayPartial("game/error.html");
                }
                exit;
            }
            $_SESSION['current_question_id']=array_pop($randExamIds);
            $_SESSION['randExamIds']=$randExamIds;
            $model=spClass("customerStatusModel")->init($_SESSION['so_login']['user_id'],date("Ymd"),$type);
            if($model){
                $this->customer_status=json_decode($model['status']);
                $this->total_count=$model['total_count'];
                $this->draw_count=$model['draw_count'];
                $this->records=explode("|",$this->customer_status->records);
            }
        }
        if(!$is_ajax){
            $this->customer_status->round++;
            $this->saveStatus();
            $this->set_time();
        }elseif(($this->customer_status->right+$this->customer_status->wrong)<1){
            $this->set_time();
        }
        $this->question=spClass("examModel")->GetOneExamById($_SESSION['current_question_id']);
        if($is_ajax){
            $this->displayPartial("game/_question.html");
        }else{
            $this->displayPartial("game/question.html");
        }
    }

    private function is_ajax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }

    private function saveStatus(){
        $this->customer_status->records=join("|",$this->records);
        $row=array(
            'status'=>json_encode($this->customer_status),
            'total_count'=>$this->total_count,
        );
        //print_r($row);
        return spClass("customerStatusModel")->upd($_SESSION['so_login']['user_id'],date("Ymd"),$row);
    }

    private function set_time(){
        $_SESSION['start_time']=time();
    }
    private function is_time_out(){
        if((time()-$_SESSION['start_time'])>$this->time_out){
            return true;
        }else{
            return false;
        }
    }

    public function normalResetStatus(){
        $_SESSION['type']=-1;
        //重新初始化用户状态
        $status=array(
            'type'=>-1,
            //'question'=>1,
            'point'=>1,
            'right'=>0,
            'wrong'=>0,
            'total_right'=>0,
            'total_wrong'=>0,
            'round'=>$this->customer_status->round,
            'records'=>"0|0|0|0|0|0|0|0|0|0",
        );
        $row=array(
            'status'=>json_encode($status),
            'total_count'=>$this->total_count,
        );
        return spClass("customerStatusModel")->upd($_SESSION['so_login']['user_id'],date("Ymd"),$row);
    }

    public function wrongCaseResetStatus(){
        //答错4道题的情况下重新初始化用户状态
        $this->records[$this->customer_status->point]=0;
        $status=array(
            'type'=>$this->customer_status->type,
            //'question'=>1,
            'point'=>$this->customer_status->point,
            'right'=>0,
            'wrong'=>0,
            'total_right'=>$this->customer_status->total_right-$this->customer_status->right,
            'total_wrong'=>$this->customer_status->total_wrong-$this->customer_status->wrong,
            'round'=>$this->customer_status->round,
            'records'=>join("|",$this->records),
        );
        $row=array(
            'status'=>json_encode($status),
            'total_count'=>$this->total_count,
        );
        return spClass("customerStatusModel")->upd($_SESSION['so_login']['user_id'],date("Ymd"),$row);
    }

    public function answer()
    {
        $type=$_SESSION['type'];
        if($_POST['answer']){

            if($this->is_time_out()){//如果服务端时间超时
                $this->timeover();
                exit;
            }
            $question=spClass("examModel")->GetOneExamById($_SESSION['current_question_id'],'correct_answer');
            //$this->customer_status->question++;
            if(trim($question['correct_answer'])==trim($_POST['answer'])){//答对了
                $this->customer_status->right++;
                $this->customer_status->total_right++;
                $this->total_count++;
                $this->records[$this->customer_status->point-1]=$this->customer_status->right;
                $go='game/_right.html';
            }elseif($_POST['answer']!='time_over'){//答错了
                $this->customer_status->wrong++;
                $this->customer_status->total_wrong++;
                $this->records[$this->customer_status->point-1]=$this->customer_status->right;
                if($this->customer_status->wrong>3){//如果错了四道题则结束本次答题
                    //$this->customer_status->round++;
                    unset($_SESSION['current_question_id']);
                    unset($_SESSION['randExamIds']);
                    //$this->records[$this->customer_status->point-1]=$this->customer_status->right;
                    spClass("recordModel")->add($_SESSION['so_login']['user_id'],$this->records,$this->customer_status->point);

                    $this->wrongCaseResetStatus();
                    $this->displayPartial("game/_over.html");
                    exit;
                }
                $go='game/_wrong.html';
            }else{//闯关超时
                $this->timeover();
                exit;
            }

            $_SESSION['current_question_id']=array_pop($_SESSION['randExamIds']);

            if($_SESSION['current_question_id']===null){//进入下一步
                $this->records[$this->customer_status->point-1]=$this->customer_status->right;

                $this->customer_status->point++;
                if($this->customer_status->point>10){//如果关口大于10则通关

                    unset($_SESSION['current_question_id']);
                    unset($_SESSION['randExamIds']);
                    //$this->customer_status->round++;
                    $this->records[9]=$this->customer_status->right;
                    spClass("recordModel")->add($_SESSION['so_login']['user_id'],$this->records,$this->customer_status->point-1);

                    $this->normalResetStatus();
                    $this->displayPartial("game/_over.html");
                    exit;
                }else{
                    $randExamIds=spClass("examModel")->GetRandExamIdsByTypeAndPoint($type,$this->customer_status->point);
                    if(!$randExamIds){
                        $this->displayPartial("game/_error.html");
                        exit;
                    }
                    $_SESSION['current_question_id']=array_pop($randExamIds);
                    $_SESSION['randExamIds']=$randExamIds;
                    $this->customer_status->right=0;
                    $this->customer_status->wrong=0;
                    $this->customer_status->question=1;
                    $go='game/_next.html';
                }
            }
            $this->saveStatus();

            $this->displayPartial($go);
        }else{
            $this->question();
        }
    }

    public function timeover(){
        $go='game/_time_over.html';
        $this->records[$this->customer_status->point-1]=$this->customer_status->right;
        spClass("recordModel")->add($_SESSION['so_login']['user_id'],$this->records,$this->customer_status->point);
        $this->saveStatus();
        $this->displayPartial($go);
    }
}