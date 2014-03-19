<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
import($GLOBALS['sysparams']['files']['phpexcelpath'] . 'PHPExcel.php');
/**
 * 我的奖品的控制器
 * @author: guohao
 */
class myPrize extends tbController {

    public $moduleId = '4'; //审批管理

    public function __construct() {
        parent::__construct();
        $this->operator_id = $_SESSION['operator']["id"];
    }

    /**
     * 病害列表
     */
    public function index() {

        $_SESSION['myPrize_tid'] = $this->spArgs("tid");
        $_SESSION['myPrize_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];

        $this->firstday = date('Y-m-d');
        $this->today = date('Y-m-d');

        //如果单点登录过来的，就会有这个值
        $this->query_user = $_SESSION['so_login']['user_id'];

        if ($this->spArgs("from") == 'bank') {
            $this->displaySimple("myPrize/index.html");
        } else {
            $this->display("myPrize/index.html");
        }
    }

    public function queryList($page = 1, $pagesize = 10) {


        $user_id = $this->spArgs("user_id") == "输入用户编号" ? "" : trim($this->spArgs("user_id"));

        $stime = $this->spArgs("stime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("stime"));
        $etime = $this->spArgs("etime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("etime"));

        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'stime' => $stime,
            'etime' => $etime,
            'user_id' => $user_id,
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $model = spClass("scoreSpendModel");
        $rs = $model->queryList($a);

        if ($rs['rows']) {
            $status_a = $model->getStatusArray();
            foreach ($rs['rows'] as $key => $row) {
                $rs['rows'][$key]['status_text'] = $status_a[$row['status']];
            }
        }



        $this->list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&user_id=' . $user_id . '&stime=' . $stime . '&etime=' . $etime;
        ;
        $this->query_url = spUrl("myPrize", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];

        $acl = spClass('aclModel');
        $this->authconfig = array(
            'audit' => $acl->checkCA('myPrize', 'audit'),
        );

        $this->displayPartial("myPrize/_list.html");
    }

    public function audit() {
        $model = spClass("scoreSpendModel");

        $log_id = $this->spArgs("id");
        $table = $this->spArgs("table");
        $result = $this->spArgs("result");

        $rs = $model->audit($log_id, $table, $result);

        $logargs = array(
            'opt_field' => '审核兑奖记录',
            'opt_desc' => '兑奖记录编号:' . $log_id . ',审核结果:' . ($result == '1' ? '审核通过' : '审核不通过'),
            'opt_result' => $rs['status'],
            'result_desc' => $rs['desc'],
            'module_id' => $this->moduleId,
        );
        $logrs = optlog($logargs);

        //更新兑换记录的remark
        $log_rs = $model->updateRemark($log_id, $table, "兑换申请已审核。");

        $this->queryList($this->spArgs("page"), $this->pageSize, $rs['desc']);
    }

    /**
     * 病害列表
     */
    public function my() {

        $_SESSION['myPrize_tid'] = $this->spArgs("tid");
        $_SESSION['myPrize_sid'] = $this->spArgs("sid");

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];

        $this->firstday = date('Y-m-d');
        $this->today = date('Y-m-d');

        //如果单点登录过来的，就会有这个值
        $this->query_user = $_SESSION['so_login']['user_id'];

        $this->displaySimple("myPrize/my_prize.html");
    }

    public function queryMy($page = 1, $pagesize = 10) {


        $user_id = $this->spArgs("user_id") == "输入用户编号" ? "" : trim($this->spArgs("user_id"));

        $stime = $this->spArgs("stime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("stime"));
        $etime = $this->spArgs("etime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("etime"));

        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'stime' => $stime,
            'etime' => $etime,
            'user_id' => $user_id,
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $model = spClass("scoreSpendModel");
        $rs = $model->queryList($a);

        if ($rs['rows']) {
            $status_a = $model->getStatusArray();
            $goods_types = spClass("goodsModel")->getGoodsForType();
            //dump($goods_types);
            foreach ($rs['rows'] as $key => $row) {
                $rs['rows'][$key]['status_text'] = $status_a[$row['status']];
                $rs['rows'][$key]['is_cp'] = $goods_types[$row['goods_id']] == '0' ? '1' : '0';
            }
        }

        //dump($rs['rows']);

        $this->list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&user_id=' . $user_id . '&stime=' . $stime . '&etime=' . $etime;
        ;
        $this->query_url = spUrl("myPrize", "queryMy") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['myPrize_tid'];
        $this->sid = $_SESSION['myPrize_sid'];


        $this->displayPartial("myPrize/_my_prize.html");
    }

    /**
     * 领取彩票
     */
    public function draw() {



        $log_id = $this->spArgs("id");
        $table = $this->spArgs("table");

        $args['exchange_sum'] = $this->spArgs("sum");
        $ret = $this->exchange_caipiao($args);
        //var_dump($ret);
        $desc = $ret['desc'];
        if ($ret['status'] == '0') {
            $model = spClass("scoreSpendModel");
            $rs = $model->updateRemark($log_id, $table, $desc, '1');
        }

        $this->queryMy($this->spArgs("page"), $this->pageSize, "领取成功");
    }

    /**
     * 彩票兑换。
     * 首先去彩票库，取出对应数量的彩票券。
     * 然后返回给前端
     * @param type $args
     * @return array
     */
    private function exchange_caipiao($args) {
        $rs = array(
            'status' => 0,
            'desc' => '',
            'err_rs' => array(),
        );
        $should_exchange_sum = intval($args['exchange_sum']);
        $model = spClass("lotteryTicketModel");
        $cnt = $model->findCount(array('status' => '0'));
        if ($cnt < $should_exchange_sum) {
            $rs['status'] = 6003;
            $rs['desc'] = "彩票券数量不足";
            return $rs;
        }
        $ret = $model->findSql("select lottery_code from pc_lottery_ticket where status = '0' limit 0," . intval($args['exchange_sum']));

        $count = @count($ret);
        if ($count < $should_exchange_sum) {
            $rs['status'] = 6003;
            $rs['desc'] = "彩票券数量不足";
            return $rs;
        }

        $tickets = "请牢记以下彩票券标识码：";
        $upd_ticket = "'";
        foreach ($ret as $row) {
            $tickets .= $row['lottery_code'] . ",";
            $upd_ticket .= $row['lottery_code'] . "','";
        }
        $rs['desc'] .= $tickets;
        $upd_ticket = substr($upd_ticket, 0, strlen($upd_ticket) - 2);
        $upd_sql = "update pc_lottery_ticket set status = '1' where lottery_code in (" . $upd_ticket . ")";
        $result = $model->runSql($upd_sql);

        return $rs;
    }

    public function openDown() {
        
        ini_set("max_execution_time", "1800"); //30分钟
        //
        //$user_id = $this->spArgs("user_id") == "输入用户编号" ? "" : trim($this->spArgs("user_id"));

        $stime = $this->spArgs("stime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("stime"));
        $etime = $this->spArgs("etime") == "" ? date('Ymd') : str_replace('-', '', $this->spArgs("etime"));

        //var_dump($stime."--".$etime);
        $args = array(
            'stime'=>$stime,
            'etime'=>$etime
        );
        // 从数据库中获取数据 
        $rows = spClass("scoreSpendModel")->queryAllData($args);

        $must_cnt = 7;

        $title = array(
            "客户编号",
            "客户手机号码",
            "奖品",
            "数量",
            "花费积分",        
            "剩余积分",
            "申请时间",        
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

        $next = 0;
        $objPHPExcel->setActiveSheetIndex($next);

        //必填提示
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(40);
 
        //表头
        $t = ord('A');
        foreach ($title as $one) {
            $objPHPExcel->getActiveSheet()->setCellValue(chr($t) . '1', $one);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t) . '1')->getFont()->setBold(true);
            $t++;
        }

        $excel_now_row = 2;
        
        foreach($rows as $key=>$row)
        {
            //样例
            $t = ord('A');
            foreach ($row as $k=>$one) {
                $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($t) . $excel_now_row, $one, PHPExcel_Cell_DataType::TYPE_STRING);
                $t++;
            }
            
            $excel_now_row++;
    				
            //指定開始下一个工作表
            if($excel_now_row>60000){
                    $next++;
                    $objPHPExcel->createSheet();
                    $objPHPExcel->setActiveSheetIndex($next);
                    $excel_now_row=1;
            }
        }



        $filename = "exchange_user_file.xls";
        //$filename = iconv("utf-8", 'gbk', $filename);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        header('Content-Type: application/vnd.ms-excel');
        header("Content-Disposition: attachment;filename=$filename");
        header('Cache-Control: max-age=0');
        $objWriter->save('php://output');
        exit(0);

    }

}