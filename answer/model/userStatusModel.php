<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

class userStatusModel extends spModel {

    public $pk = 'id';
    public $table = 'customer_status';
    
    

    public static function queryList($args)
    {
        $rs = array(
            'rows'=>array(),
            '_pg_'=>array()
        );
        $rs['status'] = 0;
        $rs['desc'] = "ok";
       
        if(@count($args) == 0)
        {
            return $rs;
        }
        
        $condition = "";
        if($args['user_id'] != null && $args['user_id'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= " user_id = '".$args['user_id']."'";
        }
        
        
        
        if($args['stime'] != null && $args['stime'] != "" && $args['etime'] != null && $args['etime'] != "")
        {
            if($condition!="") $condition .= " AND ";
            $condition .= "  record_time >= '".$args['stime']."' AND record_time < date_add(str_to_date('".$args['etime']."','%Y%m%d'), interval 1 DAY) ";
        }
        
        
        
        $model = spClass("userStatusModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition,'record_time desc');
        
        
        
        $rs['rows'] = $rows;
        
        $rs['_pg_'] = $model->spPager()->getPager();
        
        
        
        
        return $rs;
    }

}