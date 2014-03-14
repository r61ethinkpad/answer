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
        //dump($rs);
        return $rs['rows'];
    }
    
    private function getUserInfo()
    {
        $info = null;
        $term = $_SESSION['so_login']['term'];//"20140301";//
        $rs = spClass("userStatusModel")->find(array('user_id'=>$_SESSION['so_login']['user_id'],'term'=>$term));
        if($rs)
        {
            $info['score'] = $rs['total_count'];
            $info['lottery'] = $rs['draw_count'];
        }
        
        return $info;
    }
    /**
     * 更新客户的本期客户信息
     * @param type $args
     * @return type
     * WARNING:正式环境下，请用$_SESSION['so_login']['term'] 代替  date('Ymd')
     */
    private function updateUserStatusInfo($args)
    {
        $term = $_SESSION['so_login']['term'];//"20140301";//date('Ymd');//
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
        $device_no = $this->spArgs("device_no_".$id);//彩票的话，就没有
        $user_id = $_SESSION['so_login']['user_id'];
        $args = array(
            'goods_id'=>$id,
            'exchange_type'=>$exchange_type,
            'exchange_sum'=>$exchange_sum,
            'goods_score'=>$goods_score,
            'goods_money'=>$goods_money,
            'user_id'=>$user_id,
            'device_no'=>$device_no
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
            'status'=>0,
            'desc'=>'兑换申请已提交。',
            'err_rs'=>array()
        );
        if($exchange_type == '1')
        {
            $rs['desc'] .= "充值号码:".$device_no.".";
        }else if($exchange_type == '2')
        {
            $rs['desc'] .= "充值QQ:".$device_no.".";
        }
//        if($exchange_type == '0')
//        {
//            $rs = $this->exchange_caipiao($args);
//        }else if($exchange_type == '1')
//        {
//            $rs = $this->exchange_huafei($args);
//        }else if($exchange_type == '2')
//        {
//            $rs = $this->exchange_qb($args);
//        }  
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
                'remark'=>$rs['desc'],
            );
            $month = date('Ym');
            $table_name = "score_spend_log_".$month;
            $ret = spClass("scoreSpendModel",array($table_name))->create($params);
            if($ret == false){
                $msg .= "记录日志失败。";
            }
            // var_dump($ret);
            //更新客户当前积分
            //var_dump($balance);
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
        return $this->jsonreturn($rs['status'], $msg, $data);
    }
    
    /**
     * 彩票兑换。
     * 首先去彩票库，取出对应数量的彩票券。
     * 然后返回给前端
     * @param type $args
     * @return array
     */
    private function exchange_caipiao($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换申请已提交成功。',
            'err_rs'=>array(),
        );
        $should_exchange_sum = intval($args['exchange_sum']);
        $model = spClass("lotteryTicketModel");
        $cnt = $model->findCount(array('status'=>'0'));
        if($cnt < $should_exchange_sum)
        {
            $rs['status'] = 6003;
            $rs['desc'] = "彩票券数量不足";
            return $rs;
        }
        $ret = $model->findSql("select lottery_code from pc_lottery_ticket where status = '0' limit 0,".intval($args['exchange_sum']));
        
        $count = @count($ret);
        if($count < $should_exchange_sum)
        {
            $rs['status'] = 6003;
            $rs['desc'] = "彩票券数量不足";
            return $rs;
        }
        
        $tickets = "请牢记以下彩票券标识码：";
        $upd_ticket = "'";
        foreach($ret as $row)
        {
            $tickets .= $row['lottery_code'].",";
            $upd_ticket .= $row['lottery_code']."','";
        }
        $rs['desc'] .= $tickets;
        $upd_ticket = substr($upd_ticket,0,  strlen($upd_ticket)-2);
        $upd_sql = "update pc_lottery_ticket set status = '1' where lottery_code in (".$upd_ticket.")";
        $result = $model->runSql($upd_sql);
        
        return $rs;
    }
    
    /**
     * 兑换话费
     * @param type $args
     * @return int
     */
    private function exchange_huafei($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换申请已提交。',
            'err_rs'=>array(),
        );
        
        $ret = $this->requestExchange($args);
        $rs['desc'] .= $ret['desc'];
        if($ret['status'] != 0)
        {
            $rs['status'] = 6004;
        }
        
        
        return $rs;
    }
    
    /**
     * Q币兑换
     * @param type $args
     * @return int
     */
    private function exchange_qb($args)
    {
        $rs = array(
            'status'=>0,
            'desc'=>'兑换申请已提交',
            'err_rs'=>array(),
        );
        $ret = $this->requestExchange($args);
        $rs['desc'] .= $ret['desc'];
        if($ret['status'] != 0)
        {
            $rs['status'] = 6005;
        }
        return $rs;
    }
    
    /***
     * http://www.371tuan.cn/api/371tuan_api_server.php
        get的方式请求
        私有KEY：6ed73c3353c3c04403e5f79210ae9016
        get参数：
        userid 标识用户ID
        payclass 标识充值类型 2种类型：qq，mobile
        orderid 标识有请求方产生15-20不重复ID
        haoma 标识号码 比如QQ号或者手机号
        money 标识充值的金额 比如10元
        sign 的算法
        sign = md5(userid.payclass.orderid.haoma.money.私有KEY) 
        32位小写
        php拼接符是.
        http://www.371tuan.cn/api/371tuan_api_server.php?userid=参数&payclass=参数&orderid=参数&haoma=参数&money=参数&sign=参数
     */
    private function requestExchange($args)
    {
        $key = '6ed73c3353c3c04403e5f79210ae9016';
        $payclass = $args['exchange_type'] == '2'? 'qq' : 'mobile';
        $userid = $args['user_id'];
        $orderid = date('YmdHis').rand(100, 99999);
        $money = intval($args['exchange_sum'])*intval($args['goods_money']);
        $haoma = $args['device_no'];
        $sign = strtolower(md5($userid.$payclass.$orderid.$haoma.$money.$key));
        
        $url = 'http://www.371tuan.cn/api/371tuan_api_server.php?userid='.$userid.'&payclass='.$payclass.'&orderid='.$orderid.'&haoma='.$haoma.'&money='.$money.'&sign='.$sign;
        //dump($url); 
        //$handler = file_get_contents($url);//返回一个字符串 ok 或者error
        //初始化
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $handler = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $rs = array(
            'status' => 0,
            'desc'=>'兑换号码：'.$haoma.',兑换金额：'.$money."。",
        );
        if($handler ==false || $handler == "")
        {
            $rs['status'] = 1001;
            $rs['desc'] .= "兑换失败。未知错误,没有返回数据.";
            return $rs;
        }
        //$handler_array = (array)json_decode($handler);
        //var_dump($handler_array);
        if($handler == 'error')
        {
            $rs['status'] = 1002;
            $rs['desc'] .= "兑换失败。充值失败.";
            return $rs;
        }
        $rs['desc'] .= "兑换成功。";
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