<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
/**
 * 题库分类管理的控制器
 * @author: guohao
 */
class answerType extends tbController {

    public $moduleId = '3';//系统配置管理

    public function __construct() {
        parent::__construct();
        $this->operator_id = $_SESSION['operator']["id"];
    }

    /**
     * 列表
     */
    public function index() {
        
        $_SESSION['answerType_tid'] = $this->spArgs("tid");
        $_SESSION['answerType_sid'] = $this->spArgs("sid");
        
        $this->tid = $_SESSION['answerType_tid'];
        $this->sid = $_SESSION['answerType_sid'];
       
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answerType', 'create'),
        );
        $this->current_tab = 'list';
       
        $this->display("answerType/index.html");
    }
    
    
    
    /**
     * 题库分类的列表
     * param:
     *  题库分类名称
     * 
     */
    public function queryList($page = 1, $pagesize = 10) {
        
        
        $type_name = $this->spArgs('type_name') == '输入分类名称' ? '' : $this->spArgs('type_name');
        
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'type_name' => $type_name,             
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("examTypeModel")->queryList($a);
        
        

        $this->type_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&type_name=' . $type_name;
        $this->query_url = spUrl("answerType", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['answerType_tid'];
        $this->sid = $_SESSION['answerType_sid'];
        
        
       
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
            'del' => $acl->checkCA('answer', 'del'),
        );
        $this->displayPartial("answerType/_list.html");
    }

   

    /**
     * 新增题目
     */
    public function create() {

        $this->tid = ($this->spArgs("tid") == '') ? $_SESSION['answerType_tid'] : $this->spArgs("tid");
        $this->sid = ($this->spArgs("sid") == '') ? $_SESSION['answerType_sid'] : $this->spArgs("sid");
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('answer', 'create'),
            'list' => $acl->checkCA('answerType', 'index'),
        );
        $this->current_tab = 'new';
       
        $this->display("answerType/create.html");
    }
    
    public function save()
    {
        $model = spClass("examTypeModel");

        $answerType = $this->spArgs("answerType");
        $name = trim($answerType["type_name"]);
       
        
        $this->args = array(
            'type_name' => $name,
        );

        $check_rs = $model->verifierModel($this->args);
        //var_dump($check_rs);
        if (false == $check_rs) {
            if (!$this->validateNewTypeName($this->args)) {
                //验证失败
                $status = 6001;
                $msg = '题库分类名称已存在';
                $err_rs = array(
                    'type_name' => '分类名称已存在',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }

            $type_id = $model->create($this->args);
            if (!$type_id) {
                //验证失败
                $status = 6002;
                $msg = '题库分类添加失败';
                $err_rs = array(
                    'type_name' => '题库分类添加失败',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }
            

            $status = 0;
            $msg = '题库分类添加成功';
            $data = json_encode(array());

            $logargs = array(
                'opt_field' => '添加题库分类',
                'opt_desc' => '题库分类:' . $name .'题库分类编号:' . $type_id,
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
    private function validateNewTypeName($args) 
    {
        $name = $args['type_name'];
        $cnt = spClass("examTypeModel")->findCount(array('type_name' => $name));
        if ($cnt == 0) {
            return true;
        }
        return false;
    }
   

    /**
     * 删除
     */
    public function del($answerType_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($answerType_id == '')
            $id = $this->spArgs('id');
        else
            $id = $answerType_id;

        //判断当前typeid是否再用。
        $cnt = spClass("examModel")->findCount(array('exam_type'=>$id));
        if($cnt > 0)
        {
            echo "删除失败：当前题库分类正在使用。\r\n";
            exit;
        }

        $rs = spClass('examTypeModel')->delete(array('type_id' => $id));
        //dump($rs);
        if ($rs) {
            
            //添加日志
            $msg = "删除题库分类，分类ID为：" . $id;
            $logargs = array(
                'opt_field' => '删除题库分类',
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
            echo "删除失败.\r\n";
    }
    
    
    
    /**
     * 找单条记录
     */
    private function loadRecord($id) {
        $rec = array();
        $findrow = array(
            'type_id' => $id,
        );
        $r = spClass('examTypeModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }
    
    
   
    
}