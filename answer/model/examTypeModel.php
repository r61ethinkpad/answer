<?php
if (!defined('TBOWCARDUP')) { exit(1);}

class examTypeModel extends spModel
{
    public $pk = 'type_id';
    public $table = 'exam_type';
    
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'type_name' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 1,  // uname长度不能小于3
				'maxlength' => 20  // uname长度不能大于12
			),
			
		),
		"messages" => array( // 提示信息
			'type_name' => array(
				'notnull' => "分类名称不能为空",
				'minlength' => "分类名称不能少于1个字符",
				'maxlength' => "分类名称不能大于20个字符"
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
        
		$bank_type_id = $GLOBALS['sysparams']['bank_type_id'];
        $condition = " type_id != '".$bank_type_id."'";
        
        if($args['type_name'] !="" && $args['type_name'] != null)
        {
            $condition .= " type_name like '%".$args['type_name']."%'";
        }
        
        
        
      
        $model = spClass("examTypeModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition);
        
        
        
        $rs['rows'] = $rows;
        
        $rs['_pg_'] = $model->spPager()->getPager();
        
        
        
        
        return $rs;
    }
    
    
    
    public static function queryArray()
    {
        $model = spClass("examTypeModel");
      
		$bank_type_id = $GLOBALS['sysparams']['bank_type_id'];
        $condition = " type_id != '".$bank_type_id."'";
        $rows = $model->findAll($condition,' type_id asc');
        $data = array();
        if($rows && @count($rows) > 0)
        {
            foreach($rows as $row)
            {
                $data[$row['type_id']] = $row['type_name'];
            }
        }
        
        return $data;
    }
    
    
    
    /**
     * 验证当前名称的唯一性
     * @param type $args
     * @return boolean
     */
    public static function validateTypeName($args)
    {
        if(@count($args)!=2)
        {
            return false;
        }
       
        $cnt = spClass("examTypeModel")->findCount(array('type_name'=>$args['type_name']));
        if($cnt == 0)
        {
            return True;
        }
        return False;
    }
	
}