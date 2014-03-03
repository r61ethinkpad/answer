<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 答题记录model
 * @author guohao
 */
class recordModel extends spModel {

    public $pk = 'log_sn';
    public $table = "answer_record";

    public function __construct($table) {
        $this->table = "answer_record_".date("Ym");
        parent::__construct();
    }

    public static function GetPointFieldName($point){
        $ar=array(
            '1'=>'first_scores',
            '2'=>'second_scores',
            '3'=>'third_scores',
            '4'=>'fourth_scores',
            '5'=>'fifth_scores',
            '6'=>'sixth_scores',
            '7'=>'seventh_scores',
            '8'=>'eighth_scores',
            '9'=>'ninth_scores',
            '10'=>'tenth_scores',
        );
        return $ar[$point];
    }
    

    public static function queryList($args)
    {
        $condition = "";
        if($args['user_id'] != null && $args['user_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " user_id = '".$args['user_id']."'";
        }
        
        if($args['over_point'] != null && $args['over_point'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " over_point = '".$args['over_point']."'";
        }
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  answer_time >= '".$args['stime']."' AND answer_time < date_add(str_to_date('".$args['etime']."','%Y%m%d'), interval 1 DAY) ";
        }
        
        $condition .= " order by answer_time desc";
        
        $stime = str_replace("-","",$args['stime']);
        $etime = str_replace("-","",$args['etime']);
        $ym_s = substr($stime, 0,6);
        $ym_e = substr($etime, 0, 6);
        
        $ym_s = intval($ym_s);
        $ym_e = intval($ym_e);
        $sql = "";
        $table_pre = "pc_answer_record_";
        $i = 1;
        while($ym_e >= $ym_s)
        {
            $table_name = $table_pre.$ym_e;
            //dump($table_name);
            //检测当前的数据库表存在么
            $cnt_table_sql = "select count(1) as count from `INFORMATION_SCHEMA`.`TABLES` where `TABLE_SCHEMA`='dbanswercp' and  `TABLE_NAME`='".$table_name."' ";
            $cnt_table_info = spClass("recordModel")->findSql($cnt_table_sql);
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
        $cnt_rs = spClass("recordModel")->findSql($cnt_sql);
        $total_count = intval($cnt_rs[0]['count']);
        //dump($total_count);dump($row_sql);
        $rows = spClass("recordModel")->findSql($row_sql);
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
            $total_page = $total_count%$page_size == 0 ? $total_count/$page_size : ($total_count/$page_size)+1;
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
    
    /**
     * 查看用户答题次数。
     * 一期活动就是一天，所以不存在跨表的情况。
     * 查询用户在一天内答题的次数
     * @param type $args
     * @return type
     */
    public static function caculateNum($args)
    {
        $condition = "";
        if($args['user_id'] != null && $args['user_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " user_id = '".$args['user_id']."'";
        }
        
        if($args['over_point'] != null && $args['over_point'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " over_point = '".$args['over_point']."'";
        }
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  answer_time >= '".$args['stime']."' AND answer_time <= '".$args['etime']."' ";
        }
        
        
        $etime = str_replace(array('-',':'), "", $args['etime']);
        $ym_e = substr($etime, 0, 6);
        
        $table_pre = "pc_answer_record_";
        $table_name = $table_pre.$ym_e;
        $cnt_sql = "select count(1) as count from ".$table_name." where ".$condition;
        //dump($cnt_sql);
        $cnt_rs = spClass("recordModel")->findSql($cnt_sql);
        $total_count = intval($cnt_rs[0]['count']);
        
        return $total_count;
        
    }

    public static function add($user_id,$records,$point){
        $row=array(
            'user_id'=>$user_id,
            'answer_time'=>date("Y-m-d H:i:s"),
            'record_time'=>date("Y-m-d H:i:s"),
            'over_point'=>$point,
            'first_scores'=>$records[0],
            'second_scores'=>$records[1],
            'third_scores'=>$records[2],
            'fourth_scores'=>$records[3],
            'fifth_scores'=>$records[4],
            'sixth_scores'=>$records[5],
            'seventh_scores'=>$records[6],
            'eighth_scores'=>$records[7],
            'ninth_scores'=>$records[8],
            'tenth_scores'=>$records[9],
        );
<<<<<<< HEAD
        return spClass("recordModel")->create($row);
=======
        if(count($_SESSION['records'])){
            $over_point=null;
            foreach($_SESSION['records'] as $k=>$v){
                $row[self::GetPointFieldName($k)]=$v;
                $over_point=$k;
            }
            $row['over_point']=$over_point;
            //print_r($row);
            $month = date('Ym');
            $table_name = "answer_record_".$month;
            return spClass("recordModel",array($table_name))->create($row);
        }else{
            return false;
        }
>>>>>>> 384a39f1dfb413fce0d06be1944218ff246a8b25
    }

}