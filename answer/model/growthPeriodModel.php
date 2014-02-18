<?php
if (!defined('TBOWCARDUP')) { exit(1);}

class growthPeriodModel extends spModel
{
    public $pk = 'period_id';
    public $table = 'growth_period';
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'period_name' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 1,  // uname长度不能小于3
				'maxlength' => 20  // uname长度不能大于12
			),
			
			
		),
		"messages" => array( // 提示信息
			'period_name' => array(
				'notnull' => "生长期名称不能为空",
				'minlength' => "生长期名称不能少于1个字符",
				'maxlength' => "生长期名称不能大于20个字符"
			),
			
			
		)
	);
    
    public static function queryList($args = array())
    {
        //dump($args);exit;
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
        $params = array();
        
        $crop_id = $GLOBALS['sysparams']['crop_id'];
        $condition = " crop_id='".$crop_id."' ";
        
        if($args['period_name'] !="" && $args['period_name'] != null)
        {
            $condition .= " AND period_name like '%".$args['period_name']."%'";
        }
        
        
        
      
        $model = spClass("growthPeriodModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition);
        
        
        
        $rs['rows'] = $rows;
        
        $rs['_pg_'] = $model->spPager()->getPager();
        
        
        
        
        return $rs;
    }
    
    
    public static function queryArray()
    {
        $model = spClass("growthPeriodModel");
        
        $rows = $model->findAll();
        $data = array();
        if($rows && @count($rows) > 0)
        {
            foreach($rows as $part)
            {
                $data[$part['period_id']] = $part['period_name'];
            }
        }
        
        return $data;
    }
    
    /**
     * 验证当前名称的唯一性
     * @param type $name
     * @return boolean
     */
    public static function validatePeriodName($name)
    {
        if($name==null||$name=="")
        {
            return false;
        }
        $crop_id = $GLOBALS['sysparams']['crop_id'];
        $cnt = spClass("growthPeriodModel")->findCount(array('period_name'=>$name,'crop_id'=>$crop_id));
        if($cnt == 0)
        {
            return True;
        }
        return False;
    }
	
}