<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 奖品字典model
 * @author guohao Doe <john.doe@example.com>
 */
class goodsModel extends spModel
{
    public $pk = 'id';
    public $table = 'goods';
    
    
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'goods_name' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 1,  // uname长度不能小于3
				'maxlength' => 20  // uname长度不能大于12
			),
                        'pic'=>array(
                            'notnull'=>TRUE,
                        )
			
			
		),
		"messages" => array( // 提示信息
			'goods_name' => array(
				'notnull' => "奖品名称不能为空",
				'minlength' => "奖品名称不能少于1个字符",
				'maxlength' => "奖品名称不能大于20个字符"
			),
                        'pic'=>array(
                            'notnull'=>'奖品图片不能为空',
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
        
        if($args['goods_name'] !="" && $args['goods_name'] != null)
        {
            $condition .= " AND goods_name like '%".$args['goods_name']."%'";
        }
        //当用户只查询神秘大奖和其他奖品
        if($args['from'] !="" && $args['from'] != null)
        {
            if($args['from'] == 'exchange')
            {
                $condition .= " AND score != '0' ";
            }else//from lottery抽奖
            {
                $condition .= " AND score = '0' ";
            }
            
        }
        
        
        //dump($condition);
        
      
        $model = spClass("goodsModel");
        
        $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition);
        
        
        
        $rs['rows'] = $rows;
        
        $rs['_pg_'] = $model->spPager()->getPager();
        
        
        
        
        return $rs;
    }
    
    
    
    
    
    /**
     * 验证当前名称的唯一性
     * @param type $args
     * @return boolean
     */
    public static function validateGoodsName($args)
    {
        if(@count($args)!=1)
        {
            return false;
        }
        
        $cnt = spClass("goodsModel")->findCount(array('goods_name'=>$args['goods_name']));
        if($cnt == 0)
        {
            return True;
        }
        return False;
    }
    
    
    
    public static function getGoodsType()
    {
        return array(
            '0'=>'彩票',
            '1'=>'话费',
            '2'=>'Q币',
            '3'=>'话费或者Q币',
            '4'=>'神秘大礼包',
        );
    }
    
    
    
	
}