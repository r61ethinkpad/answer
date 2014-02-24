<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题游戏的控制器
 * @author: guohao
 */
class game extends tbController {

    public function __construct() {
        parent::__construct();
    }
    /**
     * 选择题类型
     */
    public function index() {
        $this->exam_types = spClass("examTypeModel")->queryArray();
        $this->displayPartial("game/index.html");
    }
    
    public function question()
    {
        $type=$_GET['type'];
        if(!isset($_SESSION['current_question_id'])&&!$_SESSION['game_over']){
            $_SESSION['point']=1;
            $randExamIds=spClass("examModel")->GetRandExamIdsByTypeAndPoint($type,$_SESSION['point']);
            $_SESSION['current_question_id']=array_pop($randExamIds);
            $_SESSION['randExamIds']=$randExamIds;
            $_SESSION['right']=0;
            $_SESSION['wrong']=0;
            $_SESSION['total_record']=0;
            $_SESSION['total_wrong']=0;
            $_SESSION['records']=array();
            $_SESSION['game_over']=false;
        }
        if($_SESSION['game_over']){
            $this->displayPartial("game/over.html");
        }else{
            $this->question=spClass("examModel")->GetOneExamById($_SESSION['current_question_id']);
            //var_dump($this->question);
            $this->displayPartial("game/question.html");
        }

    }

    public function right(){
        echo "right";
    }

    public function answer()
    {
        $type=$_GET['type'];
        if($_POST['answer']){
            $question=spClass("examModel")->GetOneExamById($_SESSION['current_question_id'],'correct_answer');

            if(trim($question['correct_answer'])==trim($_POST['answer'])){
                $_SESSION['right']++;
                $_SESSION['total_record']++;
                $go='game/right.html';
            }else{
                $_SESSION['wrong']++;
                $_SESSION['total_wrong']++;
                if($_SESSION['wrong']>3){
                    $records=$_SESSION['records'];
                    $records[$_SESSION['point']]=$_SESSION['right'];
                    $_SESSION['records']=$records;

                    $_SESSION['game_over']=true;
                    spClass("recordModel")->add($_SESSION['so_login']['user_id']);
                    $this->displayPartial("game/over.html");
                    exit;
                }
                $go='game/wrong.html';
            }

            $_SESSION['current_question_id']=array_pop($_SESSION['randExamIds']);

            if($_SESSION['current_question_id']===null){
                $records=$_SESSION['records'];
                $records[$_SESSION['point']]=$_SESSION['right'];
                $_SESSION['records']=$records;

                $_SESSION['point']++;
                if($_SESSION['point']>10){
                    $_SESSION['game_over']=true;
                    spClass("recordModel")->add($_SESSION['so_login']['user_id']);
                    $this->displayPartial("game/over.html");
                    exit;
                }else{
                    $randExamIds=spClass("examModel")->GetRandExamIdsByTypeAndPoint($type,$_SESSION['point']);
                    $_SESSION['current_question_id']=array_pop($randExamIds);
                    $_SESSION['randExamIds']=$randExamIds;
                    $_SESSION['right']=0;
                    $_SESSION['wrong']=0;
                    $go='game/next.html';
                }
            }
            $this->displayPartial($go);
        }else{
            $this->question();
        }
    }
	
}