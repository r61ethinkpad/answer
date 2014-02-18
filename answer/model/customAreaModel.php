<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class customAreaModel extends spModel
{
    public $pk = 'id';
    public $table = 'custom_area';
    
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			
			'name' => array(
				'notnull' => TRUE,
				'minlength' => 2,
				'maxlength' => 20
			),
			
			
		),
		"messages" => array( // 提示信息
			
			'name' => array(
				'notnull' => "行政区名称不能为空",
				'minlength' => "行政区名称不能少于2个字符",
				'maxlength' => "行政区名称不能大于20个字符"
			),
			
			
		)
	);
    
    
    public static function queryList($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'ok',
            '_pg_'=>array(),
            'rows'=>array()
        );
        
        
        $page = $args['_pg_'][0];
        $pageSize = $args['_pg_'][1];
        unset($args['_pg_']);
        foreach($args as $key=>$value)
        {
            if($value == null || $value == "")
            {
                unset($args[$key]);
            }
        }
        
        $model = spClass("customAreaModel");
        $rows = array();
        if(@count($args) == 0)
        {
            $rows = $model->spPager($page,$pageSize)->findAll();
        }  else 
            
        {
            $rows = $model->spPager($page,$pageSize)->findAll($args);
        }
        
        
        
        
        
        
        
        $rs['rows'] = $rows;
        $rs['_pg_'] = $model->spPager()->getPager();
        
        return $rs;
    }
    
    
    public function deleteAll($args)
    {
        $rs = array();
        $rs_k = array(
            'status'=>0,
            'desc'=>'删除成功'
        );
        foreach($args as $key=>$value)
        {
            //先判断是否有成员在用这个区域
            $user_cnt = spClass("userRegionModel")->findCount(array('area_type'=>'4','area_code'=>$value['id']));
            if($user_cnt > 0)
            {
                $rs[] = array(
                    'status'=>-1,
                    'desc'=>'删除失败.有企业成员在此行政区内。'
                );
                continue;
            }
            $ret = $this->delete($value);
            if($ret)
            {
                $rs[] = $rs_k;
            }  else                    
            {
                $rs[] = array(
                    'status'=>-1,
                    'desc'=>'删除失败'
                );
            }
        }


        return $rs;
    }
    
    
    public static function getCustomAreaList()
    {
        $model = spClass("customAreaModel");
        
        $rs = $model->findAll();
        $list = array();
        if(@count($rs) > 0)
        {
            foreach($rs as $row)
            {
                $list[$row['id']] = $row['name'];
            }
        }
        return $list;
    }
    
    
}
?>
