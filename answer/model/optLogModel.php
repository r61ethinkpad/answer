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
        
        $condition .= " order by record_time desc";
        $ym_s = substr($args['stime'], 0,6);
        $ym_e = substr($args['etime'], 0, 6);
        
        $ym_s = intval($ym_s);
        $ym_e = intval($ym_e);
        
        if($ym_e == $ym_s)//单表查询
        {
            $table_name = "pc_operator_log_".$ym_e;
            $sql = "select * from ".$table_name." where ".$condition;
            $model = spClass("optLogModel");     
            $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findSql($sql);
            //dump($rows);
            return array(
                'status'=>0,
                'desc'=>'获取日志数据成功',
                'rows'=>$rows,
                '_pg_'=>$model->spPager()->getPager()
            );
        }
        
        $sql = "";
        $table_pre = "pc_operator_log_";
        $i = 1;
        while($ym_e >= $ym_s)
        {
            $table_name = $table_pre.$ym_e;
            //dump($table_name);
            //检测当前的数据库表存在么
            $cnt_table_sql = "select count(1) as count from `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA`='dbanswercp' and  `TABLE_NAME`='".$table_name."' ";
            $cnt_table_info = spClass("optLogModel")->findSql($cnt_table_sql);
            if($cnt_table_info[0]['count'] == 0)
            {
                $ym_e--;
                
                continue;
            }
            if($i != 1)
            {
                $sql .= " UNION ALL ";
            }
            $sql .= "select t.* from (select * from ".$table_name." where ".$condition.") t ";
            //dump($ym_e."-".$ym_s);
                       
            
            $ym_e--;
            $i++;
        }
        //dump($sql);//exit;
        if($sql == "")
        {
         
            return array(
                'status'=>-1,
                'desc'=>'获取数据失败',
                'rows'=>array(),
                '_pg_'=>array()
            );
        
        }
        
        $current_page = $args['_pg_'][0];
        $page_size = $args['_pg_'][1];
        $page_begin = ($current_page-1)*$page_size;
        $row_sql = "select tt.* from (".$sql.") tt  limit ".$page_begin.",".$page_size." ";
        $cnt_sql = "select count(1) as count from (".$sql.") tt";
        //dump($cnt_sql);
        $cnt_rs = spClass("optLogModel")->findSql($cnt_sql);
        $total_count = intval($cnt_rs[0]['count']);
        //dump($total_count);dump($row_sql);
        $rows = spClass("optLogModel")->findSql($row_sql);
        if(!$rows)
        {
            return array(
                'status'=>-1,
                'desc'=>'获取日志数据失败',
                'rows'=>array(),
                '_pg_'=>array()
            );
        }
        
        //dump($rows);
        $total_page = 0;
        if($total_count <=$page_size)
        {
            $total_page = 1;
        }else
        {
            $total_page = $total_count%$page_size == 0 ? $total_count/$page_size : ceil($total_count / $page_size);
        }
        
        
        $pager = array
            (
                'total_count' => $total_count , // 数据总记录
                'page_size' => $page_size  ,  // 每页多少条记录
                'total_page' => $total_page ,   // 总页数
                'current_page' => $current_page ,  // 当前页码
                'first_page' => 1  ,   // 第一页的页码
                'prev_page' => $current_page-1 > 0 ? $current_page-1 : 1   ,  // 上一页的页码
                'next_page' => $current_page+1 > $total_page ? $total_page : $current_page+1   ,  // 下一页的页码
                'last_page' => $total_page    ,  // 最后一页的页码               
                'all_pages' => Array()   // 页码数据，这里是全部的页码

            );
        
        return array(
                'status'=>0,
                'desc'=>'获取日志数据成功',
                'rows'=>$rows,
                '_pg_'=>$pager
            );
        
    }
    
    
    
    
    
}
