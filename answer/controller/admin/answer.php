<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
/**
 * 题库管理的控制器
 * @author: guohao
 */
class answer extends tbController {

    public $moduleId = '2';//题库管理

    public function __construct() {
        parent::__construct();
        $this->operator_id = $_SESSION['operator']["id"];
    }

    /**
     * 列表
     */
    public function index() {
        
        $_SESSION['exam_tid'] = $this->spArgs("tid");
        $_SESSION['exam_sid'] = $this->spArgs("sid");
        
        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];
        
        $this->exam_types = spClass("examTypeModel")->queryArray();
        $this->exam_points = spClass("examModel")->queryExamPoints();
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
        );
        $this->current_tab = 'list';
        $_SESSION['opt_current_exam_action'] = 'index';
        $this->current_action = $_SESSION['opt_current_exam_action'];
        $this->display("answer/index.html");
    }
    
    /**
     * 列表
     */
    public function bank() {
        
        $_SESSION['exam_tid'] = $this->spArgs("tid");
        $_SESSION['exam_sid'] = $this->spArgs("sid");
        
        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];
        
        $this->exam_points = spClass("examModel")->queryExamPoints();
        $this->exam_type = $GLOBALS['sysparams']['bank_type_id'];
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
        );
        $this->current_tab = 'list';
        $_SESSION['opt_current_exam_action'] = 'bank';
        $this->current_action = $_SESSION['opt_current_exam_action'];
        $this->display("answer/bank.html");
    }
    
    /**
     * 题目的列表
     * param:
     *  题库分类
     *  题库关卡
     *  题目的内容
     */
    public function queryList($page = 1, $pagesize = 10) {
        
        
        $question_content = $this->spArgs('question_content') == '输入题目内容' ? '' : $this->spArgs('question_content');
        $exam_type = $this->spArgs("exam_type");
        $exam_point = $this->spArgs("exam_point");
        $exam_flag = $this->spArgs("exam_flag");
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'question_content' => $question_content,             
            'exam_type' => $exam_type,
            'exam_point' => $exam_point,
            'exam_flag'=>$exam_flag,//标识题库是自定义还是建行的
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("examModel")->queryList($a);
        
        if($rs['rows'])
        {
            $exam_type_list = spClass("examTypeModel")->queryArray();
            $exam_point_list = spClass("examModel")->queryExamPoints();
            foreach($rs['rows'] as $key=>$row)
            {
                $rs['rows'][$key]['exam_type_text'] = $exam_type_list[$row['exam_type']]==""?"银行知识":$exam_type_list[$row['exam_type']];
                $rs['rows'][$key]['exam_point_text'] = $exam_point_list[$row['exam_point']];
                
                
                $content = $row['question_content'];
                $content_len = mb_strlen($content,'utf-8');
                $content_text = '<span title="'.  htmlspecialchars($content).'">';
                $content_text .= $content_len > 20 ? mb_substr($content,0,20,'utf-8')."..." : $content;
                $content_text .= '</span>';
                $rs['rows'][$key]['question_content_text'] = $content_text;
                
                $a = $row['alternative_a'];
                $a_len = mb_strlen($a,'utf-8');
                $a_text = '<span title="'.  htmlspecialchars($a).'" style="cursor:pointer;">';
                $a_text .= $a_len > 10 ? mb_substr($a,0,10,'utf-8')."..." : $a;
                $a_text .= '</span>';
                $rs['rows'][$key]['alternative_a_text'] = $a_text;
                $b = $row['alternative_b'];
                $b_len = mb_strlen($b,'utf-8');
                $b_text = '<span title="'.  htmlspecialchars($b).'" style="cursor:pointer;">';
                $b_text .= $b_len > 10 ? mb_substr($b,0,10,'utf-8')."..." : $b;
                $b_text .= '</span>';
                $rs['rows'][$key]['alternative_b_text'] = $a_text;
                $c = $row['alternative_c'];
                $c_len = mb_strlen($c,'utf-8');
                $c_text = '<span title="'.  htmlspecialchars($c).'" style="cursor:pointer;">';
                $c_text .= $c_len > 10 ? mb_substr($c,0,10,'utf-8')."..." : $c;
                $c_text .= '</span>';
                $rs['rows'][$key]['alternative_c_text'] = $c_text;
                $d = $row['alternative_d'];
                $d_len = mb_strlen($d,'utf-8');
                $d_text = '<span title="'.  htmlspecialchars($d).'" style="cursor:pointer;">';
                $d_text .= $d_len > 10 ? mb_substr($d,0,10,'utf-8')."..." : $d;
                $d_text .= '</span>';
                $rs['rows'][$key]['alternative_d_text'] = $d_text;
                
                
            }
        }
        //dump($rs);

        $this->exam_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&question_content=' . $question_content . '&exam_type=' . $exam_type . '&exam_point=' . $exam_point;
        $this->query_url = spUrl("answer", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];
        
        
       
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
            'edit' => $acl->checkCA('answer', 'edit'),
            'del' => $acl->checkCA('answer', 'del'),
        );
        $this->displayPartial("answer/_list.html");
    }

   

    /**
     * 新增题目
     */
    public function create() {

        $this->tid = ($this->spArgs("tid") == '') ? $_SESSION['exam_tid'] : $this->spArgs("tid");
        $this->sid = ($this->spArgs("sid") == '') ? $_SESSION['exam_sid'] : $this->spArgs("sid");
        
        
        $this->exam_types = spClass("examTypeModel")->queryArray();
        $this->exam_points = spClass("examModel")->queryExamPoints();
        $this->correct_answeres = spClass("examModel")->queryCorrectAnswer();
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
            'list' => $acl->checkCA('answer', $_SESSION['opt_current_exam_action']),
        );
        $this->current_tab = 'new';
        $this->current_action = $_SESSION['opt_current_exam_action'];
        //当为建行管理员是有用
        $this->bank_exam_type = $GLOBALS['sysparams']['bank_type_id'];
        $this->display("answer/create.html");
    }
    
    public function save()
    {
        $model = spClass("examModel");

        $exam = $this->spArgs("exam");
        $content = trim($exam["question_content"]);
        $exam_type = trim($exam["exam_type"]);
        $exam_point = trim($exam["exam_point"]);
        
        
        $this->args = array(
            'question_content' => $content,
            'exam_type' => $exam_type,
            'exam_point' => $exam_type,
            'alternative_a'=>trim($exam["alternative_a"]),
            'alternative_b'=>trim($exam["alternative_b"]),
            'alternative_c' => trim($exam["alternative_c"]),
            'alternative_d' => trim($exam["alternative_d"]),
            'correct_answer'=>trim($exam["correct_answer"]),
            'creator'=>$this->operator_id,
        );

        $check_rs = $model->verifierModel($this->args);
        //var_dump($check_rs);
        if (false == $check_rs) {
            if (!$this->validateNewQuestion($this->args)) {
                //验证失败
                $status = 6001;
                $msg = '题目内容已存在';
                $err_rs = array(
                    'question_content' => '题目内容已存在',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }

            $question_id = $model->create($this->args);
            if (!$question_id) {
                //验证失败
                $status = 6002;
                $msg = '题目添加失败';
                $err_rs = array(
                    'question_content' => '题目添加失败',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }
            

            $status = 0;
            $msg = '题目添加成功';
            $data = json_encode(array());

            $logargs = array(
                'opt_field' => '添加题目',
                'opt_desc' => '题目分类:' . $exam_type .'题目所属关卡:' . $exam_point . ',题目编号:' . $question_id,
                'opt_result' => $status,
                'result_desc' => $msg,
                'module_id' => $this->moduleId,
            ); //dump($logargs);
            $logrs = optlog($logargs); //dump($logrs);
        } else {
            //验证失败
            $status = 9999;
            $msg = '';
            $data = json_encode($check_rs);
        }

        return $this->jsonreturn($status, $msg, $data);
    }
    
    /**
     * 判断问题内容是否重复
     * @param type $content
     * @return boolean
     */
    private function validateNewQuestion($args) 
    {
        $content = $args['question_content'];
        $cnt = spClass("examModel")->findCount(array('question_content' => $content));
        if ($cnt == 0) {
            return true;
        }
        return false;
    }
    /**
     * 判断问题内容不重复
     * @param type $id
     * @param type $args
     * @return boolean
     */
    private function validateEditQuestion($id,$args) 
    {
        $content = $args['question_content'];
        $condition = "question_id != '".$id."' ";
        $condition .= " and question_content = '".$content."'";
        $cnt = spClass("examModel")->findCount($condition);
        if ($cnt == 0) {
            return true;
        }
        return false;
    }
    
    public function detail(){
        
        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];
        
        $id = trim($this->spArgs("id"));
        $info = array();
        if($id)
        {
            $info = $this->loadRecord($id);
        }     
        if($info['exam_type'])
        {
            $exam_types = spClass("examTypeModel")->queryArray();
            $info['exam_type_text'] = $exam_types[$info['exam_type']];
        }
        if($info['exam_point'])
        {
            $exam_points = spClass("examModel")->queryExamPoints();
            $info['exam_point_text'] = $exam_points[$info['exam_point']];
        }
        
        $this->args = $info;
        $this->current_tab = 'detail';
        $this->current_action = $_SESSION['opt_current_exam_action'];
        
        $this->display('answer/detail.html');
        
    }

    /**
     * 编辑
     */
    public function edit() {

        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];

        $this->id = $this->spArgs('id');

        $this->exam_types = spClass("examTypeModel")->queryArray();
        $this->exam_points = spClass("examModel")->queryExamPoints();
        $this->correct_answeres = spClass("examModel")->queryCorrectAnswer();
        
        $this->args = $this->loadRecord($this->id);
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'list' => $acl->checkCA('answer', $_SESSION['opt_current_exam_action']),
            'edit' => $acl->checkCA('answer', 'edit'),
        );
        $this->current_tab = 'edit';
        $this->current_action = $_SESSION['opt_current_exam_action'];
        //当为建行管理员是有用
        $this->bank_exam_type = $GLOBALS['sysparams']['bank_type_id'];
        
        $this->display("answer/edit.html");
    }
    
    public function update()
    {
        $model = spClass("examModel");

        $exam = $this->spArgs("exam");
        $content = trim($exam["question_content"]);
        $exam_type = trim($exam["exam_type"]);
        $exam_point = trim($exam["exam_point"]);
        
        $question_id = $exam['question_id'];
        $this->args = array(
            'question_content' => $content,
            'exam_type' => $exam_type,
            'exam_point' => $exam_type,
            'alternative_a'=>trim($exam["alternative_a"]),
            'alternative_b'=>trim($exam["alternative_b"]),
            'alternative_c' => trim($exam["alternative_c"]),
            'alternative_d' => trim($exam["alternative_d"]),
            'correct_answer'=>trim($exam["correct_answer"]),
        );
        //dump($this->args);dump($question_id);
        $check_rs = $model->verifierModel($this->args);
        //var_dump($check_rs);
        if (false == $check_rs) {
            if (!$this->validateEditQuestion($question_id,$this->args)) {
                //验证失败
                $status = 6001;
                $msg = '题目内容已存在';
                $err_rs = array(
                    'question_content' => '题目内容已存在',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }

            $rs = $model->update(array('question_id'=>$question_id),$this->args);
            if (!$rs) {
                //验证失败
                $status = 6002;
                $msg = '题目编辑失败';
                $err_rs = array(
                    'question_content' => '题目编辑失败',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }
            

            $status = 0;
            $msg = '题目编辑成功';
            $data = json_encode(array());

            $logargs = array(
                'opt_field' => '编辑题目',
                'opt_desc' => '题目分类:' . $exam_type .'题目所属关卡:' . $exam_point . ',题目编号:' . $question_id,
                'opt_result' => $status,
                'result_desc' => $msg,
                'module_id' => $this->moduleId,
            ); //dump($logargs);
            $logrs = optlog($logargs); //dump($logrs);
        } else {
            //验证失败
            $status = 9999;
            $msg = '';
            $data = json_encode($check_rs);
        }

        return $this->jsonreturn($status, $msg, $data);
    }

    /**
     * 删除
     */
    public function del($exam_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($exam_id == '')
            $id = $this->spArgs('id');
        else
            $id = $exam_id;

        //load info
        $info = $this->loadRecord($id);

        $rs = spClass('examModel')->delete(array('question_id' => $id));
        //dump($rs);
        if ($rs) {
            
            //添加日志
            $msg = "删除题目，题目ID为：" . $id;
            $logargs = array(
                'opt_field' => '删除题目',
                'opt_desc' => $msg,
                'opt_result' => $rs == true ? 0 : -1,
                'result_desc' => $rs == true ? "操作成功" : "操作失败",
                'module_id' => $this->moduleId,
            );
            //dump($logargs);
            $logrs = optlog($logargs);
            //dump($logrs);	

            echo "删除成功.\r\n";
        }
        else
            echo "删除失败：" . $rs['desc'] . "\r\n";
    }
    
    
    
    /**
     * 找单条记录
     */
    private function loadRecord($id) {
        $rec = array();
        $findrow = array(
            'question_id' => $id,
        );
        $r = spClass('examModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }
    
    
   
    
}