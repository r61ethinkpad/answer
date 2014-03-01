<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 彩票券库model
 * @author guohao Doe <john.doe@example.com>
 */
class lotteryTicketModel extends spModel
{
    public $pk = 'lottery_code';
    public $table = 'lottery_ticket';
    
    
    
    //新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'lottery_code' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 1,  // uname长度不能小于3
				'maxlength' => 64  // uname长度不能大于12
			),
                      
			
			
		),
		"messages" => array( // 提示信息
			'lottery_code' => array(
				'notnull' => "标识码不能为空",
				'minlength' => "标识码不能少于1个字符",
				'maxlength' => "标识码不能大于64个字符"
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
        
        $condition = " 1=1 ";
        
        
        
        if($args['lottery_code'] !="" && $args['lottery_code'] != null)
        {
            $condition .= " AND lottery_code = '".$args['lottery_code']."'";
        }
        if($args['status'] !="" && $args['status'] != null)
        {
            $condition .= " AND status = '".$args['status']."'";
        }
        
        //dump($condition);
        
      
        $model = spClass("lotteryTicketModel");
        
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
    public static function validateLotteryCode($args)
    {
        if(@count($args)!=1)
        {
            return false;
        }
        
        $cnt = spClass("lotteryTicketModel")->findCount(array('lottery_code'=>$args['lottery_code']));
        if($cnt == 0)
        {
            return True;
        }
        return False;
    }
    
    
    public static function getStatusArray()
    {
        return array(
            '0'=>'未用',
            '1'=>'已用'
        );
    }
    
	
}