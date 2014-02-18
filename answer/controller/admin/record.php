<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 病史管理的控制器
 * @author: guohao
 */
class record extends tbController {

    public $moduleId = '4'; //病史管理

    public function __construct() {
        parent::__construct();
    }

    /**
     * 病害列表
     */
    public function index() {

        $_SESSION['history_tid'] = $this->spArgs("tid");
        $_SESSION['history_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['history_tid'];
        $this->sid = $_SESSION['history_sid'];


        //$this->growth_period = spClass("growthPeriodModel")->queryArray();

        $this->province_list = $GLOBALS['dataconfig']['province_code'];

        $this->level_list = spClass("historyModel")->getLevelArray();

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('history', 'create'),
        );
        $this->display("history/index.html");
    }

    /**
     * 病害的列表
     * param:
     *  发病时期
     *  发病部位
     *  病害名称
     */
    public function queryList($page = 1, $pagesize = 10) {


        $history_title = $this->spArgs('pest_title') == '输入病害名称' ? '' : $this->spArgs('pest_title');
        $year = $this->spArgs("year") == '所属年份' ? '' : $this->spArgs('history_title');
        $province_code = $this->spArgs("province_code");
        $area_code = $this->spArgs("area_code");
        $level_code = $this->spArgs("level_code");

        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'pest_name' => $history_title,
            'year' => $year,
            'province_code' => $province_code,
            'area_code' => $area_code,
            'level_code' => $level_code
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("historyModel")->queryList($a);

        //dump($rs);
        if ($rs['rows']) {
            $province_code_list = $GLOBALS['dataconfig']['province_code'];
            $area_code_list = $GLOBALS['dataconfig']['area_code'];
            $level_code_list = spClass("historyModel")->getLevelArray();
            foreach ($rs['rows'] as $key => $row) {
                $tmp_p_code = $row['province_code'];
                $tmp_a_code = $row['area_code'];
                $tmp_l_code = $row['level_code'];

                $rs['rows'][$key]['area_text'] = $province_code_list[$tmp_p_code];
                if ($tmp_a_code) {
                    $rs['rows'][$key]['area_text'] .= "-" . $area_code_list[$tmp_p_code][$tmp_a_code];
                }

                $rs['rows'][$key]['level_text'] = $level_code_list[$tmp_l_code];
            }
        }

        $this->history_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&history_title=' . $history_title . '&province_code=' . $province_code . '&area_code=' . $area_code;
        $url .= '&year=' . $year . '&level_code=' . $level_code;
        $this->query_url = spUrl("history", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['history_tid'];
        $this->sid = $_SESSION['history_sid'];



        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('history', 'create'),
            'edit' => $acl->checkCA('history', 'edit'),
            'del' => $acl->checkCA('history', 'del'),
        );
        $this->displayPartial("history/_list.html");
    }

    public function getAreaCode() {
        $code = trim($this->spArgs("id"));
        $selected_area = trim($this->spArgs("selected"));
        echo '<option value="">--所属地市--</option>';
        $area_code_list = $GLOBALS['dataconfig']['area_code'][$code];
        if (@count($area_code_list) == 0)
            exit;

        foreach ($area_code_list as $key => $value) {
            echo '<option value="', $key, '" ';
            if ($selected_area && $selected_area == $key) {
                echo ' selected ';
            }
            echo ' >', $value, '</option>';
        }
        exit;
    }

    public function getPestDetail() {
        echo '<option value="">--' . T('any') . '--</option>';
        $pid = trim($this->spArgs("pid")); //生长期
        $cid = trim($this->spArgs("cid")); //植株部位
        $selected_pest = trim($this->spArgs("selected")); //选中的病害名称
        if ($pid == null || $cid == null || $pid == "" || $cid == "") {
            exit;
        }

        $rs = spClass("pestModel")->queryArray($pid, $cid);
        if (@count($rs) == 0)
            exit;
        foreach ($rs as $key => $value) {
            echo '<option value="', $key, '" ';
            if ($selected_pest && $selected_pest == $key) {
                echo ' selected ';
            }
            echo ' >', $value, '</option>';
        }
        exit;
    }

    /**
     * 查看公告详情
     */
    public function detail() {
        $_SESSION['history_tid'] = $this->spArgs("tid");
        $_SESSION['history_sid'] = $this->spArgs("sid");
        $this->tid = $_SESSION['history_tid'];
        $this->sid = $_SESSION['history_sid'];
        $id = $this->spArgs('id');
        $history = $this->loadRecord($id);

        $province_code_list = $GLOBALS['dataconfig']['province_code'];
        $area_code_list = $GLOBALS['dataconfig']['area_code'];
        $level_code_list = spClass("historyModel")->getLevelArray();

        if ($history['province_code']) {
            $history['province_text'] = $province_code_list[$history['province_code']];
        }
        if ($history['area_code']) {
            $history['area_text'] = $area_code_list[$history['province_code']][$history['area_code']];
        }

        if ($history['level_code']) {
            $history['level_text'] = $level_code_list[$history['level_code']];
        }
        $this->args = $history;
        $this->remark = nl2br($this->args['remark']);
        //dump($this->history);

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'view' => $acl->checkCA('history', 'index'),
        );
        $this->display("history/detail.html");
    }

    /**
     * 发布公告
     */
    public function create() {

        $this->tid = ($this->spArgs("tid") == '') ? $_SESSION['history_tid'] : $this->spArgs("tid");
        $this->sid = ($this->spArgs("sid") == '') ? $_SESSION['history_sid'] : $this->spArgs("sid");


        $n = $this->spArgs('history');
        $this->args = $n;
        if (isset($n)) {

            //dump($n);


            $params = array(
                'pest_id' => $n['pest_id'],
                'pest_name' => $n['pest_name'],
                'remark' => $n['remark'],
                'year' => $n['year'],
                'province_code' => $n['province_code'],
                'area_code' => $n['area_code'],
                'level_code' => $n['level_code'],
            );

            //$opt_msg = "";
            //dump($params);exit;
            $model = spClass("historyModel");

            $unique_rs = $model->checkHistoryUnique($params);
            if ($unique_rs == False) {//说明不唯一
                $this->opt_msg = "新增病史失败.内容重复,请重新填写";
            } else {

                $check_rs = $model->verifierModel($params);
                //dump($check_rs);
                if ($check_rs == false) {
                    //echo json_encode($params);
                    $rs = spClass('historyModel')->create($params);
                    //dump($rs);
                    if ($rs) {
                        //添加日志
                        $msg = "新增病史，病害名称为：" . $n['pest_name'] . ",年份:" . $n['year'];
                        $logargs = array(
                            'opt_field' => '新增病史',
                            'opt_desc' => $msg,
                            'opt_result' => 0,
                            'result_desc' => '新增成功',
                            'module_id' => $this->moduleId,
                        );
                        //dump($logargs);
                        $logrs = optlog($logargs);
                        //dump($logrs);

                        $this->opt_msg = "新增成功";
                    }
                    else
                        $this->opt_msg = "新增失败,请重新尝试";
                }else {
                    $msg = "";
                    foreach ($check_rs as $error) {
                        $msg .= $error . ",";
                    }
                    $this->opt_msg = $msg;
                }
            }
        }

        $this->growth_period = spClass("growthPeriodModel")->queryArray();
        $this->province_list = $GLOBALS['dataconfig']['province_code'];
        $this->level_list = spClass("historyModel")->getLevelArray();

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('history', 'create'),
            'view' => $acl->checkCA('history', 'index'),
        );
        $this->display("history/create.html");
    }

    /**
     * 公告编辑
     */
    public function edit() {

        $this->tid = $_SESSION['history_tid'];
        $this->sid = $_SESSION['history_sid'];

        $this->id = $this->spArgs('id');
        $history = $this->loadRecord($this->id);
        
        //$this->history = $history;


        $n = $this->spArgs('history');
        if (isset($n)) {


            $params = array(
                'pest_id' => $n['pest_id'],
                'pest_name' => $n['pest_name'],
                'remark' => $n['remark'],
                'year' => $n['year'],
                'province_code' => $n['province_code'],
                'area_code' => $n['area_code'],
                'level_code' => $n['level_code'],
            );
            //dump($params);var_dump($this->id);exit;
            $model = spClass("historyModel");

            $unique_rs = $model->checkHistoryUnique($params,$this->id);
            if ($unique_rs == False) {//说明不唯一
                $this->opt_msg = "编辑病史失败.内容重复,请重新填写";
            } else {

                $check_rs = $model->verifierModel($params);
                //dump($check_rs);
                if ($check_rs == false) {

                    //echo json_encode($params);
                    $rs = spClass('historyModel')->update(array('history_id' => $this->id), $params);
                    //dump($rs);
                    if ($rs) {

                        //添加日志
                        $msg = "编辑病史，病史编号为：" . $n['history_id'] . ",病史年份:" . $n['year'];
                        $logargs = array(
                            'opt_field' => '编辑病史',
                            'opt_desc' => $msg,
                            'opt_result' => 0,
                            'result_desc' => '编辑成功',
                            'module_id' => $this->moduleId,
                        );
                        //dump($logargs);
                        $logrs = optlog($logargs);
                        //dump($logrs);

                        $this->opt_msg = "编辑成功";
                        $history = $this->loadRecord($this->id);
                    }
                    else
                        $this->opt_msg = "编辑失败：";
                }
            }
        }

        $pest_id = $history['pest_id'];
        $pest_info = spClass("pestModel")->find(array('detail_id'=>$pest_id));
        $history['period_id'] = $pest_info['period_id'];
        $history['part_id'] = $pest_info['part_id'];
        $this->history = $history;

        $this->growth_period = spClass("growthPeriodModel")->queryArray();
        $this->province_list = $GLOBALS['dataconfig']['province_code'];
        $this->level_list = spClass("historyModel")->getLevelArray();

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'edit' => $acl->checkCA('history', 'edit'),
            'view' => $acl->checkCA('history', 'index'),
        );
        $this->display("history/edit.html");
    }

    /**
     * 删除
     */
    public function del($history_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($history_id == '')
            $id = $this->spArgs('id');
        else
            $id = $history_id;



        $rs = spClass('historyModel')->delete(array('history_id' => $id));
        //dump($rs);
        if ($rs) {
            //添加日志
            $msg = "删除病史，病史ID为：" . $id;
            $logargs = array(
                'opt_field' => '删除病史',
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
            'history_id' => $id,
        );
        $r = spClass('historyModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }

}