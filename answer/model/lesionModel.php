<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 病斑字典model
 * @author guohao Doe <john.doe@example.com>
 */
class lesionModel extends spModel
{
    public $pk = 'lesion_id';
    public $table = 'lesion';
    
    const LESION_TYPE_NATURE = '00';
    const LESION_TYPE_SHAPE = '01';
    const LESION_TYPE_COLOR = '02';
    
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'lesion_name' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 1,  // uname长度不能小于3
				'maxlength' => 20  // uname长度不能大于12
			),
                        'lesion_type'=>array(
                            'notnull'=>TRUE,
                        )
			
			
		),
		"messages" => array( // 提示信息
			'lesion_name' => array(
				'notnull' => "病斑名称不能为空",
				'minlength' => "病斑名称不能少于1个字符",
				'maxlength' => "病斑名称不能大于20个字符"
			),
                        'lesion_type'=>array(
                            'notnull'=>'病斑类型不能为空',
                        )
			
			
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
        
        $condition = " 1=1 ";
        
        if($args['lesion_name'] !="" && $args['lesion_name'] != null)
        {
            $condition .= " AND lesion_name like '%".$args['lesion_name']."%'";
        }
        
        if($args['lesion_type'] !="" && $args['lesion_type'] != null)
        {
            $condition .= " AND lesion_type = '".$args['lesion_type']."'";
        }
        
        //dump($condition);
        
      
        $model = spClass("lesionModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition);
        
        
        
        $rs['rows'] = $rows;
        
        $rs['_pg_'] = $model->spPager()->getPager();
        
        
        
        
        return $rs;
    }
    
    
    /**
     * 获取病斑的性质,形状,颜色
     * @param type $type
     * @return type
     */
    public static function queryArray($type=null)
    {
        $model = spClass("lesionModel");
        $condition = "";
        if($type != null)
        {
            $condition .= " lesion_type='".$type."'";
        }
        
        $rows = $model->findAll($condition);
        $data = array();
        if($rows && @count($rows) > 0)
        {
            foreach($rows as $part)
            {
                $data[$part['lesion_id']] = $part['lesion_name'];
            }
        }
        
        return $data;
    }
    
    
    /**
     * 验证当前名称的唯一性
     * @param type $args
     * @return boolean
     */
    public static function validateLesionName($args)
    {
        if(@count($args)!=2)
        {
            return false;
        }
        
        $cnt = spClass("lesionModel")->findCount(array('lesion_name'=>$args['lesion_name'],'lesion_type'=>$args['lesion_type']));
        if($cnt == 0)
        {
            return True;
        }
        return False;
    }
    
    
    public static function  getLesionType()
    {
        return array(
            self::LESION_TYPE_NATURE=>'性质',
            self::LESION_TYPE_SHAPE=>'形状',
            self::LESION_TYPE_COLOR=>'颜色',
        );
    }
	
}