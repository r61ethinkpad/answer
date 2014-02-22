<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class examModel extends spModel {

    public $pk = 'question_id';
    public $table = 'exam';
    //新建的验证规则
    var $verifier = array(
        "rules" => array(
            'question_content' => array(
                'notnull' => TRUE,
                'minlength' => 2,
                'maxlength' => 500
            ),
            'alternative_a' => array(
                'notnull' => TRUE,
                'minlength' => 2,
                'maxlength' => 300
            ),
            'alternative_b' => array(
                'notnull' => TRUE,
                'minlength' => 2,
                'maxlength' => 300
            ),
            'alternative_c' => array(
                'notnull' => TRUE,
                'minlength' => 2,
                'maxlength' => 300
            ),
            'alternative_d' => array(
                'notnull' => TRUE,
                'minlength' => 2,
                'maxlength' => 300
            ),
            'exam_type' => array(
                'notnull' => true,
            ),
            'exam_point' => array(
                'notnull' => true,
            ),
            'correct_answer' => array(
                'notnull' => true,
            ),
        ),
        "messages" => array(// 提示信息

            'question_content' => array(
                'notnull' => "题目内容不能为空",
                'minlength' => "题目内容不能少于2个字符",
                'maxlength' => "题目内容不能大于500个字符"
            ),
            'alternative_a' => array(
                'notnull' => "备选答案不能为空",
                'minlength' => "备选答案不能少于2个字符",
                'maxlength' => "备选答案不能大于300个字符"
            ),
            'alternative_b' => array(
                'notnull' => "备选答案不能为空",
                'minlength' => "备选答案不能少于2个字符",
                'maxlength' => "备选答案不能大于300个字符"
            ),
            'alternative_c' => array(
                'notnull' => "备选答案不能为空",
                'minlength' => "备选答案不能少于2个字符",
                'maxlength' => "备选答案不能大于300个字符"
            ),
            'alternative_d' => array(
                'notnull' => "备选答案不能为空",
                'minlength' => "备选答案不能少于2个字符",
                'maxlength' => "备选答案不能大于300个字符"
            ),
            'exam_type' => array(
                'notnull' => '题目所属分类不能为空',
            ),
            'exam_point' => array(
                'notnull' => '题目所属关卡不能为空',
            ),
            'correct_answer' => array(
                'notnull' => '正确答案不能为空',
            ),
        )
    );

    public static function queryList($args = array()) {
        //dump($args);exit;
        $rs = array(
            'rows' => array(),
            '_pg_' => array()
        );
        $rs['status'] = 0;
        $rs['desc'] = "ok";

        if (@count($args) == 0) {
            return $rs;
        }
        $params = array();



        $condition = "";

        if ($args['question_content'] != "" && $args['question_content'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  question_content like '%" . $args['question_content'] . "%'";
        }

        if ($args['exam_type'] != "" && $args['exam_type'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  exam_type = '" . $args['exam_type'] . "'";
        }else {
            if ($condition != "")
                $condition .= " AND ";
            if ($args['exam_flag'] == 'bank') {
                $condition .= " exam_type == '9999'";
            } else {
                $condition .= " exam_type != '9999'";
            }
        }

        if ($args['exam_point'] != "" && $args['exam_point'] != null) {
            if ($condition != "")
                $condition .= " AND ";
            $condition .= "  exam_point = '" . $args['exam_point'] . "'";
        }

        //dump($condition);
        $model = spClass("examModel");

        $rows = $model->spPager($args['_pg_'][0], $args['_pg_'][1])->findAll($condition);



        $rs['rows'] = $rows;

        $rs['_pg_'] = $model->spPager()->getPager();


        return $rs;
    }

    public static function GetOneExamById($question_id,$files=null){
        $model = spClass("examModel");
        return $model->find("question_id=$question_id",null,$files);
    }

    public static function GetRandExamIdsByTypeAndPoint($type,$point,$c=10){
        $model = spClass("examModel");
        $rows=$model->findAll("exam_type=$type and exam_point=$point",null,"question_id");
        $total_count=count($rows);
        if($total_count<$c-1){return false;}//如果小于10道题则返回失败；
        $randExamIds=false;
        for($i=0;$i<$c-1;$i++){
            $r=rand(0,$total_count-1);
            //echo "$r|";
            if(!$randExamIds||array_search($rows[$r]['question_id'],$randExamIds)===false){
                $randExamIds[]=$rows[$r]['question_id'];
            }else{
                $i--;continue;
            }//如果得到重复的题号则重新生成随机；
        }
        //获取建行题
        $rows=$model->findAll("exam_type='9999' and exam_point=$point",null,"question_id");
        $total_count=count($rows);
        if($total_count<1){return false;}//如果小于10道题则返回失败；
        $r=rand(0,$total_count-1);
        $randExamIds[]=$rows[$r]['question_id'];
        //print_r($randExamIds);
        return $randExamIds;
    }

    /**
     * 关卡字典函数
     * @return type
     */
    public static function queryExamPoints() {
        return array(
            '1' => '第1关',
            '2' => '第2关',
            '3' => '第3关',
            '4' => '第4关',
            '5' => '第5关',
            '6' => '第6关',
            '7' => '第7关',
            '8' => '第8关',
            '9' => '第9关',
            '10' => '第10关',
        );
    }

    /**
     * 正确答案字典函数
     * @return type
     */
    public static function queryCorrectAnswer() {
        return array(
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
        );
    }



}