<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
/**
 * 奖品管理的控制器
 * @author: guohao
 */
class goods extends tbController {

    public $moduleId = '3';//系统配置管理

    public function __construct() {
        parent::__construct();
        $this->operator_id = $_SESSION['operator']["id"];
    }

    /**
     * 列表
     */
    public function index() {
        
        $_SESSION['goods_tid'] = $this->spArgs("tid");
        $_SESSION['goods_sid'] = $this->spArgs("sid");
        
        $this->tid = $_SESSION['goods_tid'];
        $this->sid = $_SESSION['goods_sid'];
       
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('goods', 'create'),
        );
        $this->current_tab = 'list';
       
        $this->display("goods/index.html");
    }
    
    
    
    /**
     * 题库分类的列表
     * param:
     *  题库分类名称
     * 
     */
    public function queryList($page = 1, $pagesize = 10) {
        
        
        $name = $this->spArgs('goods_name') == '输入奖品名称' ? '' : $this->spArgs('goods_name');
        
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'goods_name' => $name,             
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("goodsModel")->queryList($a);
        
        

        $this->type_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&goods_name=' . $name;
        $this->query_url = spUrl("goods", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['goods_tid'];
        $this->sid = $_SESSION['goods_sid'];
        
        
       
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('goods', 'create'),
            'del' => $acl->checkCA('goods', 'del'),
        );
        $this->displayPartial("goods/_list.html");
    }

   

    /**
     * 新增题目
     */
    public function create() {

        $this->tid = ($this->spArgs("tid") == '') ? $_SESSION['goods_tid'] : $this->spArgs("tid");
        $this->sid = ($this->spArgs("sid") == '') ? $_SESSION['goods_sid'] : $this->spArgs("sid");
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('goods', 'create'),
            'list' => $acl->checkCA('goods', 'index'),
        );
        $this->current_tab = 'new';
       
        $this->display("goods/create.html");
    }
    
    public function save()
    {
        $model = spClass("goodsModel");

        $goods = $this->spArgs("goods");
        $name = trim($goods["goods_name"]);
       
        
        $this->args = array(
            'goods_name' => $name,
        );

        $check_rs = $model->verifierModel($this->args);
        //var_dump($check_rs);
        if (false == $check_rs) {
            if (!$this->validateGoodsName($this->args)) {
                //验证失败
                $status = 6001;
                $msg = '奖品名称已存在';
                $err_rs = array(
                    'type_name' => '奖品名称已存在',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }

            $goods_id = $model->create($this->args);
            if (!$goods_id) {
                //验证失败
                $status = 6002;
                $msg = '奖品添加失败';
                $err_rs = array(
                    'goods_name' => '奖品添加失败',
                );
                $data = json_encode($err_rs);
                $this->jsonreturn($status, $msg, $data);
                exit;
            }
            

            $status = 0;
            $msg = '奖品添加成功';
            $data = json_encode(array());

            $logargs = array(
                'opt_field' => '添加奖品',
                'opt_desc' => '奖品名称:' . $name .'奖品编号:' . $type_id,
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
    private function validateGoodsName($args) 
    {
        $name = $args['goods_name'];
        if($name == null || $name == "")
        {
            return false;
        }
        $cnt = spClass("goodsModel")->findCount(array('goods_name' => $name));
        if ($cnt == 0) {
            return true;
        }
        return false;
    }
   

    /**
     * 删除
     */
    public function del($goods_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($goods_id == '')
            $id = $this->spArgs('id');
        else
            $id = $goods_id;

        $info = $this->loadRecord($id);
        if(@count($info) == 0)
        {
            echo "删除失败。当前奖品不存在。\r\n";
            exit;
        }
        $goods_name = $info['goods_name'];
        
        $rs = spClass('goodsModel')->delete(array('id' => $id));
        //dump($rs);
        if ($rs) {
            
            //添加日志
            $msg = "删除奖品，奖品ID为：" . $id.",奖品名称：".$goods_name;
            $logargs = array(
                'opt_field' => '删除奖品',
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
            'id' => $id,
        );
        $r = spClass('goodsModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }
    
    
   
    
}