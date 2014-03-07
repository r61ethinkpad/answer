<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
import($GLOBALS['sysparams']['files']['phpexcelpath'] . 'PHPExcel.php');
/**
 * 彩票券管理的控制器
 * @author: guohao
 */
class lotteryTicket extends tbController {

    public $moduleId = '3';//系统配置管理
    

    public function __construct() {
        parent::__construct();
        $this->operator_id = $_SESSION['operator']["id"];
        $this->pageSize = 20;
    }

    /**
     * 列表
     */
    public function index() {
        
        $_SESSION['lotteryTicket_tid'] = $this->spArgs("tid");
        $_SESSION['lotteryTicket_sid'] = $this->spArgs("sid");
        
        $this->tid = $_SESSION['lotteryTicket_tid'];
        $this->sid = $_SESSION['lotteryTicket_sid'];
        
        $this->status = spClass("lotteryTicketModel")->getStatusArray();
       
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('lotteryTicket', 'batch'),
        );
        $this->current_tab = 'list';
       
        $this->display("lotteryTicket/index.html");
    }
    
    
    
    /**
     * 题库分类的列表
     * param:
     *  题库分类名称
     * 
     */
    public function queryList($page = 1, $pagesize = 10) {
        
        
        $status = $this->spArgs('status');
        
        $page = $this->spArgs('page') == '' ? $page : $this->spArgs('page');

        $a = array(
            '_pg_' => array($page, $this->pageSize),
            'status' => $status,             
        );
        //echo json_encode($a);
        //dump($_SESSION);
        $rs = spClass("lotteryTicketModel")->queryList($a);
        
        if($rs['rows'])
        {
            $status_array = spClass("lotteryTicketModel")->getStatusArray();
            foreach($rs['rows'] as $key=>$row)
            {
                $rs['rows'][$key]['status_text'] = $row['status'] == '0'?$status_array['0'] : '<span style="color:red;">'.$status_array['1'].'</span>';
            }
        }

        $this->list = $rs['rows'];
        $this->_pg_ = $rs['_pg_'];
        $url = '&status=' . $status;
        $this->query_url = spUrl("lotteryTicket", "queryList") . $url;
        $_SESSION['saveUrl'] = $url . '&page=' . $page;
        $this->saveUrl = $_SESSION['saveUrl'];

        $this->tid = $_SESSION['lotteryTicket_tid'];
        $this->sid = $_SESSION['lotteryTicket_sid'];
        
        
       
        
        $acl = spClass('aclModel');
        $this->authconfig = array(
            'create' => $acl->checkCA('lotteryTicket', 'batch'),
            'del' => $acl->checkCA('lotteryTicket', 'del'),
        );
        $this->displayPartial("lotteryTicket/_list.html");
    }

    
    /**
     * 判断问题内容是否重复
     * @param type $content
     * @return boolean
     */
    private function validateLotteryCode($args) 
    {
        $code = $args['lottery_code'];
        $cnt = spClass("lotteryTicketModel")->findCount(array('lottery_code' => $code));
        if ($cnt == 0) {
            return true;
        }
        return false;
    }
   

    /**
     * 删除
     */
    public function del($lotteryTicket_id = '') {
        $this->saveUrl = $_SESSION['saveUrl'];

        if ($lotteryTicket_id == '')
            $id = $this->spArgs('id');
        else
            $id = $lotteryTicket_id;

        

        $rs = spClass('lotteryTicketModel')->delete(array('lottery_code' => $id));
        //dump($rs);
        if ($rs) {
            
            //添加日志
            $msg = "删除彩票券标识码为：" . $id;
            $logargs = array(
                'opt_field' => '删除彩票券标识码',
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
    
    
    
    //批次添加
    public function batch() {

        $file = $_FILES['batch_file']; //dump($file);

        $this->maxfsize = $GLOBALS['sysparams']['files']['filesize'];

        $_SESSION['lotteryTicket_tid'] = $this->spArgs("tid");
        $_SESSION['lotteryTicket_sid'] = $this->spArgs("sid");
        $this->tid = $_SESSION['lotteryTicket_tid'];
        $this->sid = $_SESSION['lotteryTicket_sid'];
        $this->current_tab = 'new';

        if ($file) {
            $this->batchCreate($file);
        } else {
            $this->display("lotteryTicket/create.html");
        }
    }

    //批次添加保存
    public function batchCreate($file) {


        //$file = $_FILES['batch_file'];
        $file = $file == null ? $_FILES['batch_file'] : $file;


        if ($file) {   //批次添加成功
            $this->opt_msg = "批量导入彩票券成功。";

            $maxfsize = $GLOBALS['sysparams']['files']['filesize'];

            $file_msg = array();

            $this->file_status = '-1';   //默认无上传文件
            //dump($file['name']);dump($file['size']);
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
                    'opt_field' => "批量导入彩票券",
                    'opt_desc' => "批量导入彩票券.",
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


        $this->display("lotteryTicket/create.html");
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
                $code = trim($currentSheet->getCell('A'.$currentRow)->getValue());
               
                  
                if($code == "")
                {
                    continue;
                }
                $list = array(
                    'row_no' => $currentRow,
                    'lottery_code'=>$code
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
                $upload_msg = "批量彩票券失败。" . $err_str;
            } else {
                $opt_msg = "批量导入彩票券成功。成功数量为".$succ_num."。" . $err_str;
            }
        } else {
            $upload_msg = "文件上传失败。";
        }
        

        $return = array('upload_msg' => $upload_msg, 'opt_msg' => $opt_msg);

        return $return;
    }

    

    private function insertData($args) {
        //dump($args);     
        
        if($args['lottery_code'] == null || $args['lottery_code'] == "")
        {
            return "第" . $args['row_no'] . "行的标识码为空；";
        }else
        {
            if(!$this->validateLotteryCode($args))
            {
                return "第" . $args['row_no'] . "行的标识码已存在；";
            }
        }
        $params = array(
            'lottery_code'=>$args['lottery_code'],
            'status'=>'0',
            'record_time'=>date('Y-m-d H:i:s')
        );
        $model = spClass("lotteryTicketModel");
        $check_rs = $model->verifierModel($params);
        //var_dump($check_rs);
        if (false == $check_rs) {
            $code = $model->create($params);
            if (!$code) {
                return "第" . $args['row_no'] . "行的标识码添加失败；";
            }

        }else
        {
            $error = "";
            if(@count($check_rs) > 0)
            {
                foreach($check_rs as $k=>$v)
                {
                    $error.=$v.",";
                }
            }
            return "第" . $args['row_no'] . "行的标识码添加失败,".$error."；";
        }
        return "";
    }
    
    
    //模板导出
    public function openTmpDown() {

        $must_cnt = 1;

        
        $title = array(
            "彩票券标识码",
        );
        
        
        $value = array(
            '11111111111111111',
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
            $txt = '必填';
            $objPHPExcel->getActiveSheet()->setCellValue(chr($t) . '1', $txt);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t) . '1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_RED);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t))->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $objPHPExcel->getActiveSheet()->getColumnDimension(chr($t))->setWidth(20);
            $t++;
        }
        
        //表头
        $t = ord('A');
        foreach ($title as $one) {
            $objPHPExcel->getActiveSheet()->setCellValue(chr($t) . '2', $one);
            $objPHPExcel->getActiveSheet()->getStyle(chr($t) . '2')->getFont()->setBold(true);
            $t++;
        }


        $activeSheet = $objPHPExcel->getActiveSheet();
        $activeSheet->setTitle('sheet1');
        

        //样例
        $t = ord('A');
        foreach ($value as $one) {
            $objPHPExcel->getActiveSheet()->setCellValueExplicit(chr($t) . '3', $one, PHPExcel_Cell_DataType::TYPE_STRING);
            $t++;
        }



        $filename = "lottery_ticket_template.xls";
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
            'lottery_code' => $id,
        );
        $r = spClass('lotteryTicketModel')->find($findrow);
        if ($r) {
            return $r;
        }
        $this->opt_msg = "没有找到该记录:";
        return $rec;
    }
    
    
    
    
    
   
    
}