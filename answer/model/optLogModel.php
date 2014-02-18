<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}
import('operatorModel.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * @desc:model -- 操作日志
 */

class optLogModel extends spModel {

    public $pk = 'log_sn';
    public $table = 'operator_log';
    
    /**
     * 所属模块ID
     *  0-登陆模块
        1-操作员管理
        2-系统参数设置
        3-虫害管理
     *  4-病史管理
     * 
     */

    public function __construct($table) {
        $this->table = $table ? $table : "operator_log";
        parent::__construct();
    }

    public static function getOptModule() {
        return $rs = $GLOBALS['dataconfig']['sys_module'];
    }

    
    public static function queryList($args)
    {
        $condition = "";
        
        if($args['module_id'] != null && $args['module_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  module_id='".$args['module_id']."'";
        }
        
        if($args['opt_desc'] != null && $args['opt_desc'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  opt_field like '%".$args['opt_desc']."%'";
        }
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  record_time >= '".$args['stime']."' AND record_time < date_add(str_to_date('".$args['etime']."','%Y%m%d'), interval 1 DAY) ";
        }
        
        
        
        $model = spClass("optLogModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition,"record_time desc");
            
        $rs['rows'] = $rows;
        $rs['status'] = 0;
        $rs['desc'] = 'ok';
        $rs['_pg_'] = $model->spPager()->getPager();


        return $rs;
        
    }
    
    
    
    
    
}
