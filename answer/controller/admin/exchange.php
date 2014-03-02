<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 用户兑换奖品的控制器
 * 奖品类型包括  
 * 0-彩票
 * 1-话费
 * 2-Q币
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
        
        
        $this->user_info = $this->getUserInfo();
        //var_dump($this->user_info);
        $this->displaySimple("exchange/index.html");
    }
    
    public function queryGoods()
    {
        $this->goods_list = $this->getGoods();
        $this->user_info = $this->getUserInfo();
        
        if($this->user_info == null)
        {
            $this->can_exchange = false;
        }else{
            $this->can_exchange = true;
        }
        
        $this->displayPartial('exchange/goods_list.html');
    }
    
    
    private function getGoods()
    {
        $a = array(
            '_pg_' => array(0, $this->pageSize),
            'from'=>'exchange'
        );
        $rs = spClass("goodsModel")->queryList($a);
        return $rs['rows'];
    }
    
    private function getUserInfo()
    {
        $info = null;
        $term = "20140301";//$_SESSION['so_login']['term'];//
        $rs = spClass("userStatusModel")->find(array('user_id'=>$_SESSION['so_login']['user_id'],'term'=>$term));
        if($rs)
        {
            $info['score'] = $rs['total_count'];
            $info['lottery'] = $rs['draw_count'];
        }
        
        return $info;
    }
    
    private function updateUserStatusInfo($args)
    {
        $term = "20140301";//$_SESSION['so_login']['term'];//
        $rs = spClass("userStatusModel")->update(array('user_id'=>$_SESSION['so_login']['user_id'],'term'=>$term),$args);
        return $rs;
    }
    /**
     * 
     * @param type $id
     * @param type $num
     * @param type $type add remove
     * @return type
     */
    private function updateGoodsInfo($id,$num,$type)
    {
        $sql = "update pc_goods set count=count";
        if($type == 'add')
        {
            $sql .= "+";
        }else{
            $sql .= " - ";
        }
        $sql .= $num." where id='".$id."'";
        $rs = spClass("goodsModel")->runSql($sql);
        return $rs;
    }
    
    /**
     * 兑换奖品
     * 包括兑换话费或者q币
     * 记录兑换记录。
     */
    public function convert()
    {
        $id = $this->spArgs("id");
        $name = $this->spArgs("name");
        $user_info = $this->getUserInfo();
        $exchange_type = $this->spArgs("goods_type_".$id);
        $exchange_sum = $this->spArgs("exchange_sum_".$id);
        $goods_score = $this->spArgs("goods_score_".$id);
        $goods_money = $this->spArgs("goods_money_".$id);
        $user_id = $_SESSION['so_login']['user_id'];
        $args = array(
            'goods_id'=>$id,
            'exchange_type'=>$exchange_type,
            'exchange_sum'=>$exchange_sum,
            'goods_score'=>$goods_score,
            'goods_money'=>$goods_money,
            'user_id'=>$user_id
        );
        
        if($user_id == null||$user_id == "")
        {
            //验证失败
            $status = 6001;
            $msg = '当前客户不存在，请重新登陆。';
            $err_rs = array(
            );
            $data = json_encode($err_rs);
            $this->jsonreturn($status, $msg, $data);
            exit;
        }
        //首先检测user_info的积分够不够
        if($user_info == null)
        {
            //验证失败
            $status = 6001;
            $msg = '积分不足。';
            $err_rs = array(
            );
            $data = json_encode($err_rs);
            $this->jsonreturn($status, $msg, $data);
            exit;
        }
        //当前积分
        $current_score = intval($user_info['score']);
        //需要的积分总数
        $need_score = intval($exchange_sum)*intval($goods_score);
        //余额
        $balance = $current_score-$need_score;
        if($balance < 0 )
        {
            //验证失败
            $status = 6001;
            $msg = '兑换失败，积分不足，请尝试兑换其他奖品。';
            $err_rs = array(
            );
            $data = json_encode($err_rs);
            $this->jsonreturn($status, $msg, $data);
            exit;
        }   
        $goods_info = spClass("goodsModel")->find(array('id'=>$id));
        $goods_cur_num = intval($goods_info['count']);
        $goods_num_balance = $goods_cur_num - $exchange_sum ;
        if($goods_cur_num <=0 || $goods_num_balance < 0 )
        {
            //验证失败
            $status = 6002;
            $msg = '兑换失败，奖品数量不足，请尝试兑换其他奖品。';
            $err_rs = array(
            );
            $data = json_encode($err_rs);
            $this->jsonreturn($status, $msg, $data);
            exit;
        }
        //先从奖品库中把奖品减出来
        $this->updateGoodsInfo($id, $exchange_sum, "remove");
        //然后对接 兑换接口
        if(!in_array($exchange_type,array('0','1','2')))
        {
            //验证失败
            $status = 6002;
            $msg = '兑换失败，不能兑换未知奖品。';
            $err_rs = array(
            );
            $data = json_encode($err_rs);
            $this->jsonreturn($status, $msg, $data);
            exit;
        }
        $rs = array(
            'status'=>9000,
            'desc'=>''
        );
        if($exchange_type == '0')
        {
            $rs = $this->exchange_caipiao($args);
        }else if($exchange_type == '1')
        {
            $rs = $this->exchange_huafei($args);
        }else if($exchange_type == '2')
        {
            $rs = $this->exchange_qb($args);
        }  
        $data = $rs['err_rs'];
        $msg = $rs['desc'];
        //兑换成功，记录日志。减掉用户的积分，返回当前奖品的数量
        if($rs['status'] == 0)
        {
            //add log
            $params = array(
                'user_id'=>$user_id,
                'goods_id'=>$id,
                'goods_name'=>$name,
                'count'=>$exchange_sum,
                'score'=>$need_score,
                'balance'=>$balance,
                'record_time'=>date('Y-m-d H:i:s'),
                'remark'=>'奖品兑换记录',
            );
            $month = date('Ym');
            $table_name = "score_spend_log_".$month;
            $ret = spClass("scoreSpendModel",array($table_name))->create($params);
            if($ret == false){
                $msg .= "记录日志失败。";
            }
            // var_dump($ret);
            //更新客户当前积分
            $ret = $this->updateUserStatusInfo(array('total_count'=>$balance));
            if($ret == false)
            {
                $msg .= "更新客户积分余额失败。";
            }
            
        }else
        {
            //兑换失败。把奖品加回库存
            $this->updateGoodsInfo($id, $exchange_sum, 'add');
            
            
        }
        //返回当前奖品的数量
        $goods_info = spClass("goodsModel")->find(array('id'=>$id));
        $data['surplus'] = intval($goods_info['count']);
        
        $data = json_encode($data);
        return $this->jsonreturn($rs['status'], $rs['desc'], $data);
    }
    
    
    private function exchange_caipiao($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换成功。',
            'err_rs'=>array(),
        );
        
        return $rs;
    }
    
    private function exchange_huafei($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换成功。',
            'err_rs'=>array(),
        );
        
        return $rs;
    }
    
    private function exchange_qb($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换成功。',
            'err_rs'=>array(),
        );
        
        return $rs;
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