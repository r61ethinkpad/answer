<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题记录model
 * @author guohao
 */
class scoreSpendModel extends spModel {

    public $pk = 'id';
    public $table = 'score_spend_log';

    public function __construct($table) {
        $this->table = $table ? $table : "score_spend_log";
        parent::__construct();
    }

    public static function getStatusArray()
    {
        return array(
            '0'=>'审核中',
             '1'=>'通过',
             '2'=>'不通过',
        );
    }
    

    public static function queryList($args)
    {
        $condition = "";
        if($args['user_id'] != null && $args['user_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " s.user_id = '".$args['user_id']."'";
        }
        
        
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  s.record_time >= '".$args['stime']."' AND s.record_time < date_add(str_to_date('".$args['etime']."','%Y%m%d'), interval 1 DAY) ";
        }
        
        $condition .= " order by s.record_time desc";
        
        $ym_s = substr($args['stime'], 0,6);
        $ym_e = substr($args['etime'], 0, 6);
        
        $ym_s = intval($ym_s);
        $ym_e = intval($ym_e);
        
        if($ym_e == $ym_s)//单表查询
        {
            $table_name = "pc_score_spend_log_".$ym_e;
            $sql = "select s.*,'".$table_name."' as table_name from ".$table_name." s where ".$condition;
            $model = spClass("scoreSpendModel");     
            $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findSql($sql);
            //dump($rows);dump($model->spPager()->getPager());
            return array(
                'status'=>0,
                'desc'=>'获取日志数据成功',
                'rows'=>$rows,
                '_pg_'=>$model->spPager()->getPager()
            );
        }
        
        $sql = "";
        $table_pre = "pc_score_spend_log_";
        $i = 1;
        while($ym_e >= $ym_s)
        {
            $table_name = $table_pre.$ym_e;
            //dump($table_name);
            //检测当前的数据库表存在么
            $cnt_table_sql = "select count(1) as count from `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA`='dbanswercp' and  `TABLE_NAME`='".$table_name."' ";
            $cnt_table_info = spClass("scoreSpendModel")->findSql($cnt_table_sql);
            if($cnt_table_info[0]['count'] == 0)
            {
                $ym_e--;
                
                continue;
            }
            if($i != 1)
            {
                $sql .= " UNION ALL ";
            }
            $sql .= "select t.* from (select s.*,'".$table_name."' as table_name from ".$table_name." s where ".$condition.") t ";
            //dump($ym_e."-".$ym_s);
                       
            
            $ym_e--;
            $i++;
        }
        //var_dump($sql);//exit;
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
        $cnt_rs = spClass("scoreSpendModel")->findSql($cnt_sql);
        $total_count = intval($cnt_rs[0]['count']);
        //dump($total_count);dump($row_sql);
        $rows = spClass("scoreSpendModel")->findSql($row_sql);
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
    
    
    
    public static function queryAllData($args)
    {
        $condition = "";
        if($args['user_id'] != null && $args['user_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " s.user_id = '".$args['user_id']."'";
        }
        
        
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  s.record_time >= str_to_date('".$args['stime']."000000','%Y%m%d%H%i%s') AND s.record_time <=str_to_date('".$args['etime']."235959','%Y%m%d%H%i%s')";
        }
        
        $condition .= " order by s.record_time desc";
        
        $ym_s = substr($args['stime'], 0,6);
        $ym_e = substr($args['etime'], 0, 6);
        
        $ym_s = intval($ym_s);
        $ym_e = intval($ym_e);
        $cols = "s.user_id,s.user_isdn,s.goods_name,s.goods_type,s.count,s.score,s.balance,s.record_time";
        if($ym_e == $ym_s)//单表查询
        {
            $table_name = "pc_score_spend_log_".$ym_e;
            $sql = "select ".$cols." from ".$table_name." s where ".$condition;
            $model = spClass("scoreSpendModel");     
            $rows = $model->findSql($sql);
            //dump($rows);dump($model->spPager()->getPager());
            return $rows;
        }
        
        $sql = "";
        $table_pre = "pc_score_spend_log_";
        $i = 1;
        while($ym_e >= $ym_s)
        {
            $table_name = $table_pre.$ym_e;
            //dump($table_name);
            //检测当前的数据库表存在么
            $cnt_table_sql = "select count(1) as count from `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA`='dbanswercp' and  `TABLE_NAME`='".$table_name."' ";
            $cnt_table_info = spClass("scoreSpendModel")->findSql($cnt_table_sql);
            if($cnt_table_info[0]['count'] == 0)
            {
                $ym_e--;
                
                continue;
            }
            if($i != 1)
            {
                $sql .= " UNION ALL ";
            }
            $sql .= "select t.* from (select ".$cols." from ".$table_name." s where ".$condition.") t ";
            //dump($ym_e."-".$ym_s);
                       
            
            $ym_e--;
            $i++;
        }
        //var_dump($sql);//exit;
        if($sql == "")
        {
         
            return array();
        
        }      
        $rows = spClass("scoreSpendModel")->findSql($sql);
        return $rows;
    }
    

    public static function audit($id,$table,$result)
    {
        $sql = "update ".$table." set status='".$result."' where id='".$id."'";
        
        $rs = spClass("scoreSpendModel")->runSql($sql);
        $ret = array(
                'status'=>0,
                'desc'=>'操作成功。',
            );
        if(!$rs)
        {
            $ret['desc'] = "操作失败";
        }
        
        return $ret;
    }
    
    
    public static function updateRemark($id,$table,$desc,$flag='0')
    {
        $sql = "update ".$table." set remark=concat(remark,'".$desc."'),flag='".$flag."' where id='".$id."'";
        
        $rs = spClass("scoreSpendModel")->runSql($sql);
        $ret = array(
                'status'=>0,
                'desc'=>'操作成功。',
            );
        if(!$rs)
        {
            $ret['desc'] = "操作失败";
        }
        
        return $ret;
    }
   

}