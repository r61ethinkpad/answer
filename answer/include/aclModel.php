<?php
if (!defined('TBOWCARDUP')) { exit(1);}

define("ANONYMOUS","ANONYMOUS");

class aclModel extends spModel//udModel
{
	var $verifier = array( 
		"rules" => array( // 规则
			'uname' => array(  // 这里是对uname的验证规则
				'notnull'   => TRUE, // uname不能为空
				'minlength' => 5,    // uname长度不能小于5
				'maxlength' => 16    // uname长度不能大于16
			),
			'upass' => array(  // 这里是对upass的验证规则
				'notnull'   => TRUE, // uname不能为空
				'minlength' => 6,    // uname长度不能小于6
				'maxlength' => 16    // uname长度不能大于16
			),
		),
		"messages" => array( // 提示信息
			'uname' => array(
				'notnull'   => "用户名不能为空",
				'minlength' => "用户名不能少于5个字符",
				'maxlength' => "用户名不能大于16个字符"
			),
		)
	);
	public function __construct()
	{
		parent::__construct();	
	
		$this->roledict = array(
			'anonymous'  =>   'txt_role_anonymouse',
			'role_admin' =>   'txt_role_admin',
			'role_corp'  =>   'txt_role_corp',
			'role_card'  =>   'txt_role_card',
			'role_device'  => 'txt_role_device'
		);		
	}
	
	/**
    * 返回角色名称
    */
	public function getRoleName(){
		$w= spClass('spAcl')->get();
		return isset($this->roledict[$w]) ? T($this->roledict[$w]) : T($this->roledict['anonymous']);
	}
	
    /**
    * 检查对应的权限
    *
    * 返回1是通过检查，0是不能通过检查（控制器及动作存在但用户标识没有记录）
    * 返回-1是无该权限控制（即该控制器及动作不存在于权限表中）
    *
	* @param acl_name    用户标识：可以是组名或是用户名
    * @param controller  控制器名称
    * @param action      动作名称
    */
	public function check($acl_name, $controller, $action)
	{	
		$rs = $this->checkCA($controller, $action);
		if($rs == true)
			return 1;
		else
			return 0;
	}   

	
	/**
	 * 无权限提示及跳转
	 */
	/*public function acljump($url=''){ 
		if($url==''){
			$url = spUrl("index","index",array('tid'=>1));
		}
		echo "<script type=\"text/javascript\">alert(\"无权限操作\");</script>";
		echo "<html><head>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		echo "<meta http-equiv='refresh' content='0;url={$url}'>";
		echo "</head><body>".T('Redirect...')."</body></html>";
		exit;
	}*/
	public function acljump($url=''){ 
		if($_SESSION['login'] <> true && $_SESSION['login'] <> 1){
			//$url = spUrl("index","login");
			$url = spUrl("index","noPerm2",array('tid'=>1));
		}
		elseif($url==''){
			$url = spUrl("index","noPerm",array('tid'=>1));
		}
		echo "<html><head>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
		echo "<meta http-equiv='refresh' content='0;url={$url}'>";
		echo "</head><body>".T('Redirect...')."</body></html>";
		exit;
	}
    public function login($uname, $upass, $method=0)
    {
		$uname = str_replace(" ","",trim($uname));
		$upass = str_replace(" ","",trim($upass));
		
		$params = array(
			'id' => $uname,
			'pwd' => $upass, 
			'ip' =>	$_SERVER['REMOTE_ADDR'],
		);
                $rs = array();
                
                $info = spClass("operatorModel")->find(array('operator_id'=>$uname,'password'=>$upass));
                //var_dump($info);exit;
                if($info == false||@count($info)== 0)//不存在当前操作员
                {
                    $rs['status'] = 1001;
                    $rs['desc'] = "当前操作员账户或密码错误";
                    $rs['data'] = array();
                }else{//存在，分为冻结状态，注销
                    $status = $info['status'];
                    if($status == '00')
                    {
                        $rs['status'] = 0;
                        $rs['desc'] = "验证成功";
                        $rs['data'] = $info;
                        $result = spClass("operatorModel")->update(array('operator_id'=>$uname),array('last_login_ip'=>$_SERVER['REMOTE_ADDR'],'last_login_time'=>date('Y-m-d H:i:s')));
                    }else if($status == '01')//冻结
                    {
                        $rs['status'] = 1002;
                        $rs['desc'] = "当前操作员被冻结";
                        $rs['data'] = array();
                    }else if($status == '09')
                    {
                        $rs['status'] = 1003;
                        $rs['desc'] = "当前操作员被注销";
                        $rs['data'] = array();
                    }
                }
				
                spClass('spAcl')->set('role_admin');

		return $rs;
    }
    

	public function checkNavigation($nav=array())
	{	
		if(empty($nav)){	//传入菜单为空，直接返回
			return array();
		}
		if($_SESSION['login'] <> 1){
			return $nav;
		}
                
                //return $nav;
		$auth = $_SESSION['functionauth'];//dump($auth);
		//$auth = array('0');
                //dump($auth);
		if(empty($auth)){		//权限为空，不提供菜单
			return array();
		}
		if(in_array('0', $auth)){//所有功能
			return $nav;
		}
		
		//得到权限列表
		$authlist = $_SESSION['authlist'];
		if(empty($authlist)){		//权限为空，不提供菜单
			return array();
		}

		foreach($nav as $key => $row){
			if($row["mainflag"] == 1)
			{	//首页
				continue;
			}
			if($row['hassub'] > 0){	//有二级菜单
				$n = 0;
				foreach($row['subitem'] as $subkey => $subrow){
					$c = $subrow['controller'];
					$a = $subrow['action'];
					
					if(true == $this->checkCA($c, $a)){	//有权限
						$n = $n + 1;
					}
					else{	//无权限
						//去掉该二级菜单
						unset($nav[$key]['subitem'][$subkey]);
					}
				}
				if($n == 0){
					//去掉该一级菜单
					unset($nav[$key]);
				}
				else{
					//将一级菜单的CA改成二级菜单第一个的CA
					$array = array_values($nav[$key]['subitem']);
					$nav[$key]['controller'] = $array[0]['controller']; 
					$nav[$key]['action'] = $array[0]['action'];
					$nav[$key]['sid'] = $array[0]['sid'];
					//dump($nav[$key]);
				}
			}
			else{	//无二级菜单
				$c = $row['controller'];
				$a = $row['action'];
				
				if(!$this->checkCA($c, $a)){
					//去掉该一级菜单
					unset($nav[$key]);
				}
			}
		}
		return $nav;
	}  
	
	public function checkCA($controller, $action)
	{	
		if($controller == '' or $action == ''){	
			return false;
		}
		if(in_array($controller, array('index'))){
			return true;
		}
                if($controller == 'main' && $action == 'index'){
			return true;
		}
		
		if($_SESSION['login'] <> 1){
			return false;
		}
                
                if($_SESSION['operator']['id'] == 'admin')
                {
                    return true;
                }
		
		
		$nocheck = spClass('permissionModel')->getAdminNoCheckCA();
		
		//$nocheck = spClass('permissionModel')->getNoCheckCA();
		
		if($nocheck[$controller]== 'ALL' or 
			in_array($action, $nocheck[$controller])){
			return true;
		}
		
		
		$auth = $_SESSION['functionauth'];   
		if(empty($auth)){		//权限为空
			return false;
		}
		if(in_array('0', $auth)){//超级，所有功能
			return true;
		}
		
		$authlist = $_SESSION['authlist'];   
		if(empty($authlist)){	//权限列表空
			return false;
		}
		if(in_array($controller.'/'.$action, $authlist)){
			return true;
		}else{
			return false;
		}		
	}  
}
