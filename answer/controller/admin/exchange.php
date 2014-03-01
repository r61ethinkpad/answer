<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 用户兑换奖品的控制器
 * @author: guohao
 */
class exchange extends tbController {

    public function __construct() {
        parent::__construct();
    }
    /**
     * 进入兑奖界面。
     * 包括用户的积分总额，
     * 奖品展示
     */
    public function index() {
        
        $this->goods_list = $this->getGoods();
        $this->user_info = $this->getUserInfo();
        $this->displayPartial("exchange/index.html");
    }
    
    
    private function getGoods()
    {
        $a = array(
            '_pg_' => array(0, $this->pageSize),
        );
        $rs = spClass("goodsModel")->queryList($a);
        return $rs['rows'];
    }
    
    private function getUserInfo()
    {
        $info = null;
        $rs = spClass("userStatusModel")->find(array('user_id'=>$_SESSION['so_login']['user_id'],'term'=>$_SESSION['so_login']['term']));
        if($rs)
        {
            $info['score'] = $rs['total_count'];
            $info['lottery'] = $rs['draw_count'];
        }
        
        return $info;
    }
    
    
    public function convert()
    {
        
    }
    
    
    public function save()
    {
        
    }
    
    
    public function getUserScore(){
        $info = $this->getUserInfo();
        if($info)
        {
            return json_encode($info);
        }
        return false;
    }
    
    
	
}