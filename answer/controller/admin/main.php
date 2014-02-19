<?php
if (!defined('TBOWCARDUP')) { exit(1);}

/**
 * 企业管理员首页控制器
 * @author weijuan
 */
class main extends tbController
{
	
	public function __construct(){ 
		parent::__construct(); 
	}
	
    function index(){
		
   	 	if($_SESSION['login'] <> true){
			$this->jump(spUrl('index', 'login'));
			exit;
		}
		if($_SESSION['operator']["type"] == '02')//建行操作员
		{
			$this->jump(spUrl('answer','bank',array('tid'=>'1','sid'=>'2')));
		}
        $this->jump(spUrl('answer','index',array('tid'=>'1','sid'=>'1')));
    }
    
	
	//安全退出
    function logout(){  
				
		$_SESSION = array();
        if (isset($_COOKIE[session_name()])) {setcookie(session_name(), '', time()-42000, '/');}

		session_destroy();
		$this->jump(spUrl('index', 'login'));
    }   
	
	//显示登录者名称
	function showName(){ 
		
		$this->name = $_SESSION['operator']["name"];
		$this->dataname = $_SESSION['org_name'];
		if($_SESSION['operator']['type'] == 0 and 
		   $_SESSION['operator']['class'] == 3 and
		   count($_SESSION["dataauth"]) > 1) //系统管理员 and 校企权限
		{
			$this->switchflag = 1;
		}
		$this->displayPartial("../inc/_name.html");
    }
	
	
	
	
	//密码修改
	public function passwd()
	{   
		$operator_id = $_SESSION['operator']["id"];
		if($operator_id == ''){
			exit;
		}
		$this->args = array(
			'operator_id' => $operator_id,
		);
		$this->displayPartial("main/passwd.html");

    }
	public function passwdSave()
	{   
		$operator = spClass("operatorModel"); 
		$this->args = array(
			'operator_id' => $_SESSION['operator']['id'],
			'password'	 => encryptPasswd(trim($this->spArgs("oldpasswd"))),
			'newpwd'	 => encryptPasswd(trim($this->spArgs("passwd"))),
		);
		$operator->verifier = $operator->verifier_passwd;
		$check_rs = $operator->verifierModel($this->args);

		if(false == $check_rs){
			//通过验证
			$rs = $operator->passwdUpdate($this->args);
			
			$logargs = array(      
				'opt_field' =>	'修改密码',     
				'opt_desc'	=>	'操作员帐号:'.$_SESSION['operator']['id'].',操作员名称:'.$_SESSION['operator']['name'],
				'opt_result'=>	$rs['status'],       
				'result_desc'=>	$rs['desc'],    
				'module_id'	=>	$this->moduleId,
			);
			$logrs = optlog($logargs);
			
			if($rs['status'] == 0){
				//添加成功
				$this->success_flag = 1;			
			}else{
				//失败
				$this->error_array = array(
					'ud_error' => $rs['desc'],
				);
			}
		}else{
			//验证失败
			$this->error_array = $check_rs;
		}
		$this->displayPartial("main/passwd.html");
    }
	
	
}
