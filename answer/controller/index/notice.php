<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class notice extends tbController {

    public $moduleId = 'system';

    public function __construct() {
        parent::__construct();
    }

    /**
     * 公告列表
     */
    public function index() {
        $this->class = $_SESSION['operator']['class'];
        $this->type = $_SESSION['operator']['type'];
        $_SESSION['notice_tid'] = $this->spArgs("tid");
        $_SESSION['notice_sid'] = $this->spArgs("sid");
        $this->operator_id = $_SESSION['operator']['id'];
        $this->tid = $_SESSION['notice_tid'];
        $this->sid = $_SESSION['notice_sid'];
        $this->today = date("Y-m-d");
        $this->first_day = date("Y-m-") . '01';
        $this->area_list = $GLOBALS['dataconfig']['areacode'];

        $this->adviceModule = $this->moduleId;
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('notice', 'create'),
        );
        $this->display("notice/index.html");
    }

    /**
     * 公告列表分页查询
     */
    public function queryList($page = 1, $pagesize = 10) {
        $this->class = $_SESSION['operator']['class'];
        $this->type = $_SESSION['operator']['type'];
        $this->operator_id = $_SESSION['operator']['id'];
        //echo $this->operator_id;

        $notice_title = $this->spArgs('notice_title') == '输入公告主题' ? '' : $this->spArgs('notice_title');
        $sdate = str_replace('-', '', $this->spArgs('date1'));
        $edate = str_replace('-', '', $this->spArgs('date2'));
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');
////		$area_code = $_SESSION['operator']['areacode'];

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'notice_title' => $notice_title,
            'org_id' => $_SESSION['orgid'],
            'stime' => $sdate,
            'etime' => $edate,
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("noticeModel")->findOrgNotice($a);

        //dump($rs);

        $this->notice_list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&notice_title=' . $notice_title . '&area_code=' . $_SESSION['operator']['areacode'] . '&date1=' . $sdate . '&date2=' . $edate;
        $this->query_url = spUrl("notice", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['notice_tid'];
        $this->sid = $_SESSION['notice_sid'];
        //dump($_SESSION);
        $this->adviceModule = $this->moduleId;
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('notice', 'create'),
        );
        $this->displayPartial("notice/_list.html");
    }

    /**
     * 查看公告详情
     */
    public function detail() {
        $_SESSION['notice_tid'] = $this->spArgs("tid");
        $_SESSION['notice_sid'] = $this->spArgs("sid");
        $this->tid = $_SESSION['notice_tid'];
        $this->sid = $_SESSION['notice_sid'];
        $id = $this->spArgs('id');
        $this->notice = $this->loadRecord($id);
        
        $this->notice_content = nl2br($this->notice['content']);
        //dump($this->notice);


        $this->adviceModule = $this->moduleId;
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('notice', 'create'),
        );
        $this->display("notice/detail.html");
    }

    /**
     * 发布公告
     */
    public function create() {

        $this->tid = ($this->spArgs("tid") == '') ? $_SESSION['notice_tid'] : $this->spArgs("tid");
        $this->sid = ($this->spArgs("sid") == '') ? $_SESSION['notice_sid'] : $this->spArgs("sid");
        //$this->area_list = $GLOBALS['dataconfig']['areacode'];
        //dump($_SESSION);

        $n = $this->spArgs('notice');
        $this->args = $n;
        if (isset($n)) {

            $params = array(
                'title' => $n['title'],
                'content' => $n['content'],
                'operator_id' => $_SESSION['operator']['id'],
                'org_id' => $_SESSION['orgid'],
                'record_time'=>date('Y-m-d H:i:s'),
            );
            //echo json_encode($params);
            $rs = spClass('noticeModel')->create($params);
            //dump($rs);
            if ($rs) {
                //添加日志
                $msg = "发布公告，主题为：" . $n['title'];
                $logargs = array(
                    'opt_field' => '发布公告',
                    'opt_desc' => $msg,
                    'opt_result' => 0,
                    'result_desc' => '发布成功',
                    'module_id' => $this->moduleId,
                );
                //dump($logargs);
                $logrs = optlog($logargs);
                //dump($logrs);

                $this->opt_msg = "发布成功";
            }
            else
                $this->opt_msg = "发布失败：数据库操作失败";
        }

        $this->adviceModule = $this->moduleId;
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('notice', 'create'),
        );
        $this->display("notice/create.html");
    }

    /**
     * 公告编辑
     */
    public function edit() {

        $this->tid = $_SESSION['notice_tid'];
        $this->sid = $_SESSION['notice_sid'];

        $this->id = $this->spArgs('id');
        $this->notice = $this->loadRecord($this->id);



        $n = $this->spArgs('notice');
        if (isset($n)) {

            $params = array(
                'title' => $n['notice_title'],
                'content' => $n['notice_content'],
                //'operator_id' => $_SESSION['operator']['id'],
                'org_id' => $_SESSION['orgid'],
                'record_time'=>  date('Y-m-d H:i:s'),
            );
            //echo json_encode($params);
            $rs = spClass('noticeModel')->update(array('announce_id' => $this->id), $params);
            //dump($rs);
            if ($rs) {
                //添加日志
                $msg = "编辑公告，公告ID为：" . $this->id;
                $logargs = array(
                    'opt_field' => '编辑公告',
                    'opt_desc' => $msg,
                    'opt_result' => $rs == true ? 0 : -1,
                    'result_desc' => $rs == true ? "操作成功" : "操作失败",
                    'module_id' => $this->moduleId,
                );
                //dump($logargs);
                $logrs = optlog($logargs);
                //dump($logrs);

                $this->opt_msg = "编辑成功";
                $this->notice = $this->loadRecord($this->id);
            }
            else
                $this->opt_msg = "编辑失败：";
        }
        $this->adviceModule = $this->moduleId;
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('notice', 'create'),
        );
        $this->display("notice/edit.html");
    }

    /**
     * 公告删除
     */
    public function delete($notice_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($notice_id == '')
            $id = $this->spArgs('id');
        else
            $id = $notice_id;



        $rs = spClass('noticeModel')->delete(array('announce_id' => $id));
        //dump($rs);
        if ($rs) {
            //添加日志
            $msg = "删除公告，公告ID为：" . $id;
            $logargs = array(
                'opt_field' => '删除公告',
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
     * 批量删除公告
     */
    public function batchDel() {
        $this->saveUrl = $_SESSION['saveUrl'];
        $ids = $this->spArgs('ids');
        $arr = explode(',', $ids);
        array_pop($arr);
        if (count($arr) >= 1) {
            $success_count = 0;
            $fail_count = 0;
            foreach ($arr as $id) {
                //有文件先删除关联文件
                $notice = $this->loadRecord($id);

                $rs = spClass('noticeModel')->delete(array('announce_id' => $id));
                //dump($rs);
                if ($rs) {
                    //添加日志
                    $msg = "删除公告，公告ID为：" . $id;
                    $logargs = array(
                        'opt_field' => '删除公告',
                        'opt_desc' => $msg,
                        'opt_result' => $rs == true ? 0 : -1,
                        'result_desc' => $rs == true ? "操作成功" : "操作失败",
                        'module_id' => $this->moduleId,
                    );
                    //dump($logargs);
                    $logrs = optlog($logargs);
                    //dump($logrs);	

                    $success_count++;
                }
                else
                    $fail_count++;
            }
            echo "成功删除公告" . $success_count . "条，失败" . $fail_count . "条";
        }
    }

    /**
     * 找单条记录
     */
    private function loadRecord($id) {
        $rec = array();
        $findrow = array(
            'announce_id' => $id,
        );
        $r = spClass('noticeModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }

}