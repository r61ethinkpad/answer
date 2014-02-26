<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
import($GLOBALS['sysparams']['files']['phpexcelpath'] . 'PHPExcel.php');
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
            'exam_point' => $exam_point,
            'alternative_a'=>trim($exam["alternative_a"]),
            'alternative_b'=>trim($exam["alternative_b"]),
            'alternative_c' => trim($exam["alternative_c"]),
            'alternative_d' => trim($exam["alternative_d"]),
            'correct_answer'=>trim($exam["correct_answer"]),
            'creator'=>$this->operator_id,
        );
        //var_dump($this->args);
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
            'exam_point' => $exam_point,
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
    
    
    //批次添加
    public function batch() {

        $file = $_FILES['batch_file']; //dump($file);

        $this->maxfsize = $GLOBALS['sysparams']['files']['filesize'];

        $_SESSION['exam_tid'] = $this->spArgs("tid");
        $_SESSION['exam_sid'] = $this->spArgs("sid");
        $this->tid = $_SESSION['exam_tid'];
        $this->sid = $_SESSION['exam_sid'];


        if ($file) {
            $this->batchCreate($file);
        } else {
            $this->display("answer/batch_add.html");
        }
    }

    //批次添加保存
    public function batchCreate($file) {


        //$file = $_FILES['batch_file'];
        $file = $file == null ? $_FILES['batch_file'] : $file;


        if ($file) {   //批次添加成功
            $this->opt_msg = "批量导入题库成功。";

            $maxfsize = $GLOBALS['sysparams']['files']['filesize'];

            $file_msg = array();

            $this->file_status = '-1';   //默认无上传文件
            dump($file['name']);dump($file['size']);
            //检查上传文件
            if ($file['name'] == '' || $file['name'] == null)
                $this->opt_msg = "未上传批量文件,请上传文件。";
            else if ($file['size'] == 0)
                $this->opt_msg = "上传文件为空,请重新上传。";
            else if ($file['size'] > $maxfsize * 1024 * 1024)
                $this->opt_msg = "文件超过" . $maxfsize . "M,请重新上传。";
            else {

                $file_msg = $this->openDetailCreate($file);   //开户添加详细
            }

            if ($file_msg['upload_msg']) { //文件上传失败
                $this->opt_msg = $file_msg['upload_msg'];
            } else {

                //$this->opt_msg .=$file_msg['opt_msg'];
                $log_args = array(
                    'opt_field' => "批量导入题库",
                    'opt_desc' => "批量导入题库.",
                    'opt_result' => 0,
                    'result_desc' => "操作成功",
                    'module_id' => $this->moduleId,
                );

                $rs_log = optlog($log_args);

                $this->opt_msg = $file_msg['opt_msg'];
            }
            //dump($file_msg);
        } else {
            $this->opt_msg = "文件上传失败，请重新尝试";
        }


        $this->display("answer/batch_add.html");
    }
    
    //用户开卡批量上传
    public function openDetailCreate($file) {

        $tmp_name = $file ['tmp_name'];
        //dump($file['error']);
        if ($file["error"] == 0) {

            import(APP_PATH . '/../libs/PHPExcel/PHPExcel/IOFactory.php');
            $inputFileType = PHPExcel_IOFactory::identify($tmp_name); //文件名自动判断文件类型Excel5,Excel2007
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setReadDataOnly(true);
            $objPHPExcel = $objReader->load($tmp_name);

            $currentSheet = $objPHPExcel->getSheet(0); //第一个工作簿
            $allRow = $currentSheet->getHighestRow(); //行数
           
            $list = array();
            $err_msg = array();
            $succ_num = 0;
            
            //按照文件格式从第7行开始循环读取数据
            for($currentRow = 3;$currentRow<=$allRow;$currentRow++){ 
                //判断每一行的B列是否为有效的序号，如果为空或者小于之前的序号则结束
                $type_name = trim($currentSheet->getCell('A'.$currentRow)->getValue());
                $exam_point = trim($currentSheet->getCell('B'.$currentRow)->getValue());
                $content = trim($currentSheet->getCell('C'.$currentRow)->getValue());
                $alternative_a = trim($currentSheet->getCell('D'.$currentRow)->getValue());
                
                $alternative_b = trim($currentSheet->getCell('E'.$currentRow)->getValue());
                $alternative_c = trim($currentSheet->getCell('F'.$currentRow)->getValue());
                $alternative_d = trim($currentSheet->getCell('G'.$currentRow)->getValue());
                $correct_answer = trim($currentSheet->getCell('H'.$currentRow)->getValue());
                  
                if($type_name == ""||$exam_point==""||$content==""||$correct_answer=="")
                {
                    continue;
                }
                $list = array(
                    'row_no' => $i,
                    'type_name' => $type_name,
                    'exam_point' => $exam_point,
                    'content' => $content,
                    'a' => $alternative_a,
                    'b' => $alternative_b,
                    'c' => $alternative_c,
                    'd'=>$alternative_d,
                    'answer'=>$correct_answer,
                );
                //dump($list);
                $msg = $this->insertData($list);
                if ($msg == "") {
                    $succ_num++;
                } else {
                    $err_msg[] = $msg;
                }
            }
          
            $err_str = "";
            if (@count($err_msg)) {
                foreach ($err_msg as $k => $v) {
                    if ($k % 4 == 0) {
                        $err_str.="<br/>";
                    }
                    $err_str .= $v;
                }
            }
            if ($succ_num == 0) {
                $upload_msg = "批量导入题库数据失败。" . $err_str;
            } else {
                $opt_msg = "批量导入题库数据成功。" . $err_str;
            }
        } else {
            $upload_msg = "文件上传失败。";
        }
        

        $return = array('upload_msg' => $upload_msg, 'opt_msg' => $opt_msg);

        return $return;
    }

    //用户开卡批量上传
    public function openDetailCreate2($file) {

        $tmp_name = $file ['tmp_name'];
        dump($file['error']);
        if ($file["error"] == 0) {

            import(APP_PATH . '/extension/phpexcelreader/' . "JPhpExcelReader.php");
            $data = new JPhpExcelReader($tmp_name);
            $count = $data->rowcount(0);
            $list = array();
            $err_msg = array();
            $succ_num = 0;
            dump($count);dump($file['size']);
            for ($i = 3; $i <= $count; $i++) {
                $type_name = trim($data->val($i, 1, 0));
                $exam_point = trim($data->val($i, 2, 0));
                $content = trim($data->val($i, 3, 0));
                $alternative_a = trim($data->val($i, 4, 0));
                
                $alternative_b = trim($data->val($i,5,0));
                $alternative_c = trim($data->val($i, 6, 0));
                $alternative_d = trim($data->val($i, 7, 0));
                $correct_answer = trim($data->val($i, 8, 0));
                
                if($type_name == ""||$exam_point==""||$content==""||$correct_answer=="")
                {
                    continue;
                }
                $list = array(
                    'row_no' => $i,
                    'type_name' => $type_name,
                    'exam_point' => $exam_point,
                    'content' => $content,
                    'a' => $alternative_a,
                    'b' => $alternative_b,
                    'c' => $alternative_c,
                    'd'=>$alternative_d,
                    'answer'=>$correct_answer,
                );
                //dump($list);
                $msg = $this->insertData($list);
                if ($msg == "") {
                    $succ_num++;
                } else {
                    $err_msg[] = $msg;
                }
            }
            $err_str = "";
            if (@count($err_msg)) {
                foreach ($err_msg as $k => $v) {
                    if ($k % 4 == 0) {
                        $err_str.="<br/>";
                    }
                    $err_str .= $v;
                }
            }
            if ($succ_num == 0) {
                $upload_msg = "批量导入题库数据失败。" . $err_str;
            } else {
                $opt_msg = "批量导入题库数据成功。" . $err_str;
            }
        } else {
            $upload_msg = "文件上传失败。";
        }
        

        $return = array('upload_msg' => $upload_msg, 'opt_msg' => $opt_msg);

        return $return;
    }

    private function insertData($args) {
        //dump($args);
        $operator_type = $_SESSION['operator']['type'];
        $type_id = '0';
        if($operator_type == '02')//建行题库管理员
        {
            $type_id = $GLOBALS['sysparams']['bank_type_id'];
        }else
        {
            if ($args['type_name'] == null || $args['type_name'] == "") {
                return "第" . $args['row_no'] . "行的题库分类为空；";
            }else
            {
                //检测题库分类是否存在
                $info = spClass("examTypeModel")->find(array('type_name'=>$args['type_name']));
                if($info == null || $info['type_id'] == null)
                {
                    return "第" . $args['row_no'] . "行的题库分类不存在；";
                }
                $type_id = $info['type_id'];
            }
        }
        
        if ($args['exam_point'] == null || $args['exam_point'] == "") {
            return "第" . $args['row_no'] . "行的关卡为空；";
        } else {
            //检测手机号唯一性
            $points = array('1','2','3','4','5','6','7','8','9','10');
            if (!in_array($args['exam_point'],$points)) {
                return "第" . $args['row_no'] . "行的关卡号不存在；";
            }
        }
        
        if($args['content'] == null || $args['content'] == "")
        {
            return "第" . $args['row_no'] . "行的题目内容为空；";
        }else
        {

            //判断题目内容是否已存在
            $cnt = spClass("examModel")->findCount(array('question_content'=>$args['content']));
            if($cnt != 0)
            {
                return "第" . $args['row_no'] . "行的题目内容已存在；";
            }
        }
        
        
        if($args['a'] == null || $args['a'] == "")
        {
            return "第" . $args['row_no'] . "行的备选答案A为空；";
        }
        
        if($args['b'] == null || $args['b'] == "")
        {
            return "第" . $args['row_no'] . "行的备选答案B为空；";
        }
        
        
        if($args['answer'] == null || $args['answer'] == "")
        {
            return "第" . $args['row_no'] . "行的正确答案为空；";
        }else
        {
            $answeres = array('A','B','C','D');
            if(!in_array(strtoupper($args['answer']),$answeres))
            {
                return "第" . $args['row_no'] . "行的正确答案格式填写错误；";
            }
            $args['answer'] = strtoupper($args['answer']);
        }
        

        //insert data
        $params = array(
            'creator' => $this->operator_id,
            'exam_type' => $type_id,
            'exam_point' => $args['exam_point'],
            'question_content' => $args['content'],
            'alternative_a' => $args['a'],
            'alternative_b' => $args['b'],
            'alternative_c' => $args['c'],
            'alternative_d' => $args['d'],
            'correct_answer' => $args['answer'],
        );
        $model = spClass("examModel");
        $check_rs = $model->verifierModel($params);
        //var_dump($check_rs);
        if (false == $check_rs) {
            $question_id = $model->create($params);
            if (!$question_id) {
                return "第" . $args['row_no'] . "行的题目添加失败；";
            }

        }else
        {
            return "第" . $args['row_no'] . "行的题目添加失败；";
        }
        return "";
    }
    
    
    //模板导出
    public function openTmpDown() {

        $must_cnt = 8;

        $type_cell = "A3";
        $point_cell = "B3";
        $answer_cell = "H3";
        $title = array(
            "题库分类",
            "所属关卡（共10关,用数字标识）",
            "题目内容",
            "备选答案A",        
            "备选答案B",
            "备选答案C",        
            "备选答案D",
            "正确答案",
        );

        $exam_types = spClass("examTypeModel")->queryArray();
        $exam_points = array(
            '1'=>'1',
            '2'=>'2',
            '3'=>'3',
            '4'=>'4',
            '5'=>'5',
            '6'=>'6',
            '7'=>'7',
            '8'=>'8',
            '9'=>'9',
            '10'=>'10',
        );

        $default_type = "";
        $default_point = "";
        //部门
        
        $type_list = "";
        if ($exam_types) {
            $k = 0;
            foreach ($exam_types as $k => $v) {
                if($k == 0) $default_type = $v;
                $type_list .="," . $v;
                $k++;
            }
        }
        $type_list = substr($type_list, 1);  // dump($dept_list);exit;
        //
      
        
        $point_list = "";
        if($exam_points)
        {
            $po_i = 0;
            foreach($exam_points as $k=>$v)
            {
                if($po_i == 0) $default_point = $v;
                $po_i++;
                $point_list .= "," . $v;
            }
        }
        $point_list = substr($point_list, 1);
        
        $exam_answer = spClass("examModel")->queryCorrectAnswer();
        $answer_list = "";
        $default_answer = "";
        if($exam_answer)
        {
            $po_i = 0;
            foreach($exam_answer as $k=>$v)
            {
                if($po_i == 0) $default_answer = $v;
                $po_i++;
                $answer_list .= "," . $v;
            }
        }
        $answer_list = substr($answer_list, 1);
        
        
        
        
        
        
        $value = array(
            $default_type,
            "1",
            "1+1=?",
            "1",
            "2",
            "3",
            "4",
            "B",
        );

        //PHPExcel

        $objPHPExcel = new PHPExcel ();

        $objPHPExcel->getProperties()->setCreator("GUOHAO")
                ->setLastModifiedBy("GUOHAO")
                ->setTitle("Office 2003 XLS Document")
                ->setSubject("Office 2003 XLS Document")
                ->setDescription("GUOHAO")
                ->setKeywords("GUOHAO")
                ->setCategory("GUOHAO");

        $objPHPExcel->setActiveSheetIndex(0);

        //必填提示
        $t = ord('A');
        for ($i = 0; $i < $must_cnt; $i++) {
            $txt = in_array($i,array(5,6)) ? '' :'必填';
            $objPHPExcel->getActiveSheet()->setCellValue(chr($t) . '1', $txt);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t) . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($t))->setWidth(20);
            $t++;
        }
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
        
        //表头
        $t = ord('A');
        foreach ($title as $one) {
            $objPHPExcel->getActiveSheet()->setCellValue(chr($t) . '2', $one);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t) . '2')->getFont()->setBold(true);
            $t++;
        }


        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setTitle('sheet1');



        //分类
        //解决分类字串长度过大：将每个分类字串分解到一个单元格中
        $type_len = strlen($type_list);
        if ($type_len >= 255) {
            $type_list_arr = explode(',', $type_list);
            if ($type_list_arr)
                foreach ($type_list_arr as $i => $d) {
                    $c = "P" . ($i + 1);
                    $activeSheet->setCellValue($c, $d);
                }
            $endcell = $c;
            $activeSheet->getColumnDimension('P')->setVisible(true);
        }

        $objValidation2 = $activeSheet->getCell($type_cell)->getDataValidation();
        $objValidation2->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                ->setAllowBlank(true)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('输入的值有误')
                ->setError('您输入的值不在下拉框列表内.')
                ->setPromptTitle('下拉选择框')
                ->setPrompt('请从下拉框中选择您需要的值！');
        if ($type_len < 255)
            $objValidation2->setFormula1('"' . $type_list . '"');
        else
            $objValidation2->setFormula1("sheet1!P1:{$endcell}");


        //关卡
        $objValidation3 = $activeSheet->getCell($point_cell)->getDataValidation();
        $objValidation3->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
        ->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
        ->setAllowBlank(true)
        ->setShowInputMessage(true)
        ->setShowErrorMessage(true)
        ->setShowDropDown(true)
        ->setErrorTitle('输入的值有误')
        ->setError('您输入的值不在下拉框列表内.')
        ->setPromptTitle('下拉选择框')
        ->setPrompt('请从下拉框中选择您需要的值！')
        ->setFormula1('"' . $point_list . '"');
        
        //性别
        $objValidation4 = $activeSheet->getCell($answer_cell)->getDataValidation();
        $objValidation4->setType(PHPExcel_Cell_DataValidation::TYPE_LIST)
                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION)
                ->setAllowBlank(true)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                ->setErrorTitle('输入的值有误')
                ->setError('您输入的值不在下拉框列表内.')
                ->setPromptTitle('下拉选择框')
                ->setPrompt('请从下拉框中选择您需要的值！')
                ->setFormula1('"' . $answer_list . '"');



        //样例
        $t = ord('A');
        foreach ($value as $one) {
            $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($t) . '3', $one, PHPExcel_Cell_DataType::TYPE_STRING);
            $t++;
        }



        $filename = "batch_import_question_template.xls";
        //$filename = iconv("utf-8", 'gbk', $filename);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit(0);
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