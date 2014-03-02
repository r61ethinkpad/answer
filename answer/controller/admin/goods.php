<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 奖品管理的控制器
 * @author: guohao
 */
class goods extends tbController {

    public $moduleId = '3'; //系统配置管理

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

        if ($rs['rows']) {
            foreach ($rs['rows'] as $key => $row) {
                $rs['rows'][$key]['remark_text'] = $row['remark'];
                if (mb_strlen($row['remark'], 'UTF-8') > 10) {
                    $rs['rows'][$key]['remark_text'] = '<span title="' . $row['remark'] . '">' . mb_substr($row['remark'], 0, 10, 'UTF-8') . '...</span>';
                }
            }
        }

        $this->goods_list = $rs['rows'];
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
        
        $this->goods_types = spClass("goodsModel")->getGoodsType();
        
        $file = $_FILES['pic'];
        if($file)
        {
            $this->save($file);
        }else{
            $this->display("goods/create.html");
        }

        
    }

    public function save($file) {
        $model = spClass("goodsModel");

        $goods = $this->spArgs("goods");


        $file = $file == null ? $_FILES['pic'] : $file;

        if ($file) {   //批次添加成功
            $this->opt_msg = "";

            $maxfsize = $GLOBALS['sysparams']['files']['filesize'];

            $file_msg = array();
            $pic_path = "";
            $this->file_status = '-1';   //默认无上传文件
            //dump($file['name']);dump($file['size']);
            //检查上传文件
            if ($file['name'] == '' || $file['name'] == null)
                $this->opt_msg = "未上传奖品图片,请上传文件。";
            else if ($file['size'] == 0)
                $this->opt_msg = "上传文件为空,请重新上传。";
            else if ($file['size'] > $maxfsize * 1024 * 1024)
                $this->opt_msg = "文件超过" . $maxfsize . "M,请重新上传。";
            else {

                $file_msg = $this->savePicToPath($file);   //保存上传的图片,并返回状态和path
                if ($file_msg['status'] == '0') {
                    $pic_path = $file_msg['path'];
                } else {
                    $this->opt_msg = $file_msg['desc'];
                }
            }
 
            if ($this->opt_msg == "") {

                $params = $goods;
                $params['pic'] = $pic_path;
                $params['remark'] = $goods['desc'];
                $params['record_time'] = date('Y-m-d H:i:s');
                unset($params['desc']);
                if (!$this->validateGoodsName($params)) {
                    $this->opt_msg = "添加奖品失败。奖品名称重复";
                } else {
                    $check_rs = $model->verifierModel($params);
                 
                    if (false == $check_rs) {
                        //echo json_encode($params);
                        $rs = $model->create($params);
                     
                        if ($rs) {
                            //添加日志
                            $msg = "新增奖品，名称为：" . $params['goods_name'];
                            $logargs = array(
                                'opt_field' => '新增奖品',
                                'opt_desc' => $msg,
                                'opt_result' => 0,
                                'result_desc' => '新增成功',
                                'module_id' => $this->moduleId,
                            );
                         
                            $logrs = optlog($logargs);
                            //dump($logrs);

                            $this->opt_msg = "新增奖品成功";
                        }
                        else
                            $this->opt_msg = "新增奖品失败,请重新尝试";
                    }else {
                        $erro_str = "新增奖品失败。";

                        foreach ($check_rs as $k => $v) {
                            $erro_str .= $v . ",";
                        }
                        $this->opt_msg = $erro_str;
                    }
                }
            }
        } else {
            $this->opt_msg = "文件上传失败，请重新尝试";
        }
       // dump($this->opt_msg);
        $this->display("goods/create.html");
    }

    /**
     * 上传图片到服务器的固定位置
     * @param type $file
     * @return string
     */
    private function savePicToPath($file) {
        $result = array(
            'status' => '0',
            'desc' => 'ok',
            'path' => ''
        );
        $save_path = $GLOBALS['sysparams']['save_goods_picture_url'];
        $pic_name = $file['name'];
        $pic_array = explode(".", $pic_name);
        $pic_suffix = $pic_array[@count($pic_array) - 1];
        $save_file = date('YmdHis') . rand(1000, 9999) . "." . $pic_suffix;
        $save_path = $save_path . $save_file;
        if (move_uploaded_file($file['tmp_name'], $save_path)) {
            $result['path'] = $save_file;
        } else {
            $result = array(
                'status' => '9999',
                'desc' => '上传图片失败.',
                'path' => ''
            );
        }
        return $result;
    }

    /**
     * 判断问题内容是否重复
     * @param type $content
     * @return boolean
     */
    private function validateGoodsName($args) {
        $name = $args['goods_name'];
        if ($name == null || $name == "") {
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
        if (@count($info) == 0) {
            echo "删除失败。当前奖品不存在。\r\n";
            exit;
        }
        $goods_name = $info['goods_name'];

        $rs = spClass('goodsModel')->delete(array('id' => $id));
        //dump($rs);
        if ($rs) {

            //删掉老图片
            $info =
                    $this->delOldPic($info['pic']);

            //添加日志
            $msg = "删除奖品，奖品ID为：" . $id . ",奖品名称：" . $goods_name;
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

    /**
     * 展示图片
     */
    public function showImg() {
        $save_path = $GLOBALS['sysparams']['save_goods_picture_url'];
        $file_name = $this->spArgs("pic");
        //dump($save_path.$file_name);
        $file_array = explode(".", $file_name);
        $type = $this->getContentType($file_array[1]);
        header("Connection:close");
        header("Content-type:$type;charset=UTF-8");
        echo file_get_contents($save_path . $file_name);
        exit;
    }

    /**
     * 根据文件后缀，得到content-type
     * @param <type> $ext
     * @return <type>
     */
    private function getContentType($ext) {
        $type = "";
        $ext = strtolower($ext);
        switch ($ext) {
            case "jpg": $type = "image/jpeg";
                break;
            case "jpeg": $type = "image/jpeg";
                break;
            case "gif": $type = "image/gif";
                break;
            case "png": $type = "image/png";
                break;
            case "bmp": $type = "image/bmp";
                break;
            case "txt": $type = "text/plain";
                break;
            default:
                $type = "image/jpeg";
                break;
        }
        return $type;
    }

    private function delOldPic($file_name) {
        $save_path = $GLOBALS['sysparams']['save_pest_picture_url'];

        return @unlink($save_path . $file_name);
    }

}