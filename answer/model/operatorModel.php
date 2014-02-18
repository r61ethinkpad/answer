<?php
if (!defined('TBOWCARDUP')) { exit(1);}

class operatorModel extends spModel//UdModel
{
	
    public $pk = 'operator_id';
    public $table = 'operator';
    
        const OPER_TYPE_SYS = '00';
	const OPER_TYPE_NORMAL = '01';
        const OPER_TYPE_BANK = '02';
        
        const OPER_STATUS_NORMAL = '00';
        const OPER_STATUS_FREEZE = '01';
        
	
	
	//新建的验证规则
	var $verifier = array(
		"rules" => array( 
			'operator_id' => array(  //
				'notnull' => TRUE, // uname不能为空
				'minlength' => 4,  // uname长度不能小于3
				'maxlength' => 20  // uname长度不能大于12
			),
			/*'password' => array(
				'notnull' => TRUE,
				'minlength' => 6,
				'maxlength' => 20
			),*/
			'name' => array(
				'notnull' => TRUE,
				'minlength' => 2,
				'maxlength' => 20
			),
			'phone' => array(
				'notnull' => TRUE,
				'isPhone' => TRUE,
			),
			
		),
		"messages" => array( // 提示信息
			'operator_id' => array(
				'notnull' => "操作员ID不能为空",
				'minlength' => "用户名不能少于4个字符",
				'maxlength' => "用户名不能大于20个字符"
			),
			/*'password' => array(
				'notnull' => "初始密码不能为空",
				'minlength' => "初始密码不能少于6个字符",
				'maxlength' => "初始密码不能大于20个字符"
			),*/
			'name' => array(
				'notnull' => "姓名不能为空",
				'minlength' => "姓名不能少于2个字符",
				'maxlength' => "姓名不能大于20个字符"
			),
			'phone' => array(
				'notnull' => "手机号码不能为空",
				'isPhone' => "手机号码为11位数字",
			),
			
		)
	);
	
	//编辑的验证规则
  	var $verifier_edit = array(
		"rules" => array( 
			'name' => array(
				'notnull' => TRUE,
				'minlength' => 2,
				'maxlength' => 20
			),
			'phone' => array(
				'notnull' => TRUE,
				'isPhone' => TRUE,
			),
			
		),
		"messages" => array( // 提示信息
			'name' => array(
				'notnull' => "姓名不能为空",
				'minlength' => "姓名不能少于2个字符",
				'maxlength' => "姓名不能大于20个字符"
			),
			'phone' => array(
				'notnull' => "手机号码不能为空",
				'isPhone' => "手机号码为11位数字",
			),
			

		)
	);
	
	//密码验证规则
	var $verifier_passwd = array(
		"rules" => array( 
			'password' => array(
				'notnull' => TRUE,
				'minlength' => 6,
				//'maxlength' => 20
			),
		),
		"messages" => array( // 提示信息
			'password' => array(
				'notnull' => "旧密码不能为空",
				'minlength' => "旧密码不能少于6个字符",
				'maxlength' => "旧密码不能大于20个字符"
			),
			'newpwd' => array(
				'notnull' => "新密码不能为空",
				'minlength' => "新密码不能少于6个字符",
				'maxlength' => "新密码不能大于20个字符"
			),

		)
	);
        
        
        
        public static function queryList($args)
        {
            
            $rs = array();
            $model = spClass("operatorModel");
            
            $condition = " 1=1 ";
            
            if($args['operator_id'] != null && $args['operator_id'] != "")
            {
                $condition .= " AND  operator_id = '".$args['operator_id']."'";
            }
            
            if($args['name'] != null && $args['name'] != "")
            {
                $condition .= " AND  name like '%".$args['name']."%'";
            }
            
            if($args['type'] != null && $args['type'] != "")
            {
                $condition .= " AND  type = '".$args['type']."'";
            }
            
            if($args['status'] != null && $args['status'] != "")
            {
                $condition .= " AND  status = '".$args['status']."'";
            }
            
            $rows = $model->spPager($args['_pg_'][0],$args['_pg_'][1])->findAll($condition);
            
            $rs['rows'] = $rows;
            $rs['status'] = 0;
            $rs['desc'] = 'ok';
            $rs['_pg_'] = $model->spPager()->getPager();
            
            
            return $rs;
        }
        
	
	//根据不同平台类型，获得操作员类型
	//systype: ''(所有类型);'0'(管理平台的操作员类型);'1'(企业平台的操作员类型)
	public static function getOperType($type) {
		$rs = array(
                     self::OPER_TYPE_SYS =>'超级管理员',
                     self::OPER_TYPE_NORMAL =>'自定义题库管理员',
                    self::OPER_TYPE_BANK =>'建行题库管理员',
                );
		return $type == '_ARRAY' ? $rs : $rs[$type];
    }
	
	
	//操作员状态
	public static function getOperStatus($status) {
		$rs = array(
			self::OPER_STATUS_NORMAL => '正常',
			self::OPER_STATUS_FREEZE => '冻结',
		);
		return $status == '_ARRAY' ? $rs : $rs[$status];
        }
        
        
        
        
        //重置密码
	public static function passwdSave($args=array()){
		//$rs = $this->runUniweb('cmd_operator_passwd_set', $args);
                $rs = array(
                    'status'=>0,
                    'desc'=>'修改密码成功'
                );
                $model = spClass("operatorModel");
                $ret = $model->update(array('operator_id'=>$args['operator_id']),array('password'=>$args['password']));
                if(!$ret)
                {
                    return array(
                        'status'=>-1,
                        'desc'=>'重置失败'
                    );
                }
		return $rs;
	}
        
        
        //修改密码
	public function passwdUpdate($args=array()){
		//$rs = $this->runUniweb('cmd_operator_passwd_update', $args);
                $rs = array(
                    'status'=>0,
                    'desc'=>'密码修改成功'
                );
                
                $info = $this->findCount(array('operator_id'=>$args['operator_id'],'password'=>$args['password']));
                if($info == 0)
                {
                    return array(
                        'status'=>9999,
                        'desc'=>'密码修改失败,操作员原密码输入错误'
                    );
                }
                
                $ret = $this->update(array('operator_id'=>$args['operator_id']),array('password'=>$args['newpwd']));
		if(!$ret){
                    return array(
                        'status'=>9999,
                        'desc'=>'密码修改失败'
                    );
                }
                return $rs;
	}
		

        
     
       
	
	//冻结
	public  function freeze($args=array()){
		$rs = array(
                    'status'=>0,
                    'desc'=>'冻结成功'
                );//$this->runUniweb('cmd_operator_freeze', $args);
		$ret = $this->update(array('operator_id'=>$args['operator_id']),array('status'=>self::OPER_STATUS_FREEZE));
                if(!$ret)
                {
                    return array(
                        'status'=>-1,
                        'desc'=>'冻结失败'
                    );
                }
                return $rs;
	}
	
	//解冻
	public  function unfreeze($args=array()){
		$rs = array(
                    'status'=>0,
                    'desc'=>'解冻成功'
                );//$this->runUniweb('cmd_operator_freeze', $args);
		$ret = $this->update(array('operator_id'=>$args['operator_id']),array('status'=>self::OPER_STATUS_NORMAL));
                if(!$ret)
                {
                    return array(
                        'status'=>-1,
                        'desc'=>'解冻失败'
                    );
                }
                return $rs;
	}
	
}