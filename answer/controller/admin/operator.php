<?php
if (!defined('TBOWCARDUP')) { exit(1);}
/**
 * 管理员控制器
 * @author weijuan
 */
class operator extends tbController
{
	public $moduleId = '1';//操作员管理
	
	public function __construct(){ 
		parent::__construct(); 
		
	}
	
	//首页
	public function index(){
		$operator = spClass("operatorModel");
                $this->operator_types = $operator->getOperType('_ARRAY');
		$this->operator_status = $operator->getOperStatus('_ARRAY');
		
		$_SESSION['operator_tid'] = $this->spArgs("tid");
		$_SESSION['operator_sid'] = $this->spArgs("sid");
		
		$this->tid = $_SESSION['operator_tid'];
		$this->sid = $_SESSION['operator_sid'];
		
		$acl = spClass('aclModel');
		$this->authconfig = array(
			'new'	=>	$acl->checkCA('operator', 'operNew'),
		);
		
		$this->display("operator/index.html");
	}
	
	//查询结果
    public function queryList($page=1, $pageSize=10, $optResult='')
	{		
		$operator = spClass("operatorModel");
		
		$operator_id = trim(urldecode($this->spArgs("operator_id")));
		$operator_name = urldecode($this->spArgs("operator_name"));
		
		$page = $this->spArgs("page")==''?$page:$this->spArgs("page");
		
		$args = array(
			'_pg_' 		=> 	"[$page, $pageSize]",
			'operator_id'=> $operator_id=="管理员帐号"?"":$operator_id,
			
			'name'		=> $operator_name=="管理员名称"?"":trim($operator_name),
			'status'	=>	$this->spArgs("status"),
                        'type'	=>	$this->spArgs("type"),
		);
		//dump(json_encode($args));
		
		$rs = $operator->queryList($args);
		
		$oper_status = $operator->getOperStatus('_ARRAY');
		$oper_type = $operator->getOperType('_ARRAY');
		//dump($oper_status);dump($oper_type);
		if($rs['rows']){
			foreach($rs['rows'] as $key => $row){
				if($row['status'] != 0)
					$rs['rows'][$key]['status_desc'] = "<span class='colOrange'>".$oper_status[$row['status']]."</span>";
				else
					$rs['rows'][$key]['status_desc'] = $oper_status[$row['status']];
				$rs['rows'][$key]['type_desc'] = $oper_type[$row['type']];
				
			}
		}
		
		$this->operator_list = $rs['rows'];
		$this->_pg_ = $rs['_pg_'];
		
		$this->tid = $_SESSION['operator_tid'];
		$this->sid = $_SESSION['operator_sid'];
		$this->current_operatorid = $_SESSION['operator']['id'];
		$this->optResult = $optResult;
		
		$url = '&operator_id='.urlencode($operator_id).
				'&operator_name='.urlencode($operator_name).
				'&type='.$this->spArgs("type");
				
		$this->query_url = spUrl("operator","queryList").$url;
		$_SESSION['saveUrl'] = $url.'&page='.$page;
		$this->saveUrl = $_SESSION['saveUrl'];
		//dump($url);dump($this->saveUrl);
		
		$acl = spClass('aclModel');
		$this->authconfig = array(
			'new'	=>	$acl->checkCA('operator', 'operNew'),
			'del'	=>	$acl->checkCA('operator', 'operDel'),
			'update'=>	$acl->checkCA('operator', 'operUpdate'),
			'freeze'=>	$acl->checkCA('operator', 'freeze'),
			'passwd'=>	$acl->checkCA('operator', 'operPasswd'),
                        'monitor'=>     $acl->checkCA('monitor','index'),
		);
                //dump($this->authconfig);
		$this->displayPartial("operator/_list.html");
    }
	
	//操作员新建页面
	public function operNew()
	{   
		$operator = spClass("operatorModel"); 
		$this->operator_types = $operator->getOperType('_ARRAY');
		$this->current_opertype = $_SESSION['operator']['type'];
		$this->tid = ($this->spArgs("tid")=='')?$_SESSION['operator_tid']:$this->spArgs("tid");
		$this->sid = ($this->spArgs("sid")=='')?$_SESSION['operator_sid']:$this->spArgs("sid");
		$this->display("operator/new.html");

    }
	
	//操作员新建提交
	public function operSave()
	{   
		$operator = spClass("operatorModel"); 
		$org_id = $_SESSION['orgid'];

		$this->args = array(
			'org_id'	=>	$org_id,
			'operator_id' => trim($this->spArgs("operator_id")),
			'password'	=> encryptPasswd(trim($this->spArgs("password"))),
			'name'	 => trim($this->spArgs("name")),
			'phone'	 => trim($this->spArgs("phone")),
			'email'	 => trim($this->spArgs("email")),
			'type'	 => trim($this->spArgs("type")),
			
			
			
		);
                //dump($this->args);exit;
		$check_rs = $operator->verifierModel($this->args);
		
		if(false == $check_rs){
			//通过验证
			$rs = $operator->create($this->args);
			$status = 0;
			$msg = '添加操作员成功';
			$data = json_encode($this->spArgs("operator_id"));
			
			$logargs = array(      
				'opt_field' =>	'添加操作员',     
				'opt_desc'	=>	'操作员帐号:'.trim($this->spArgs("operator_id")).',操作员名称:'.trim($this->spArgs("name")),       
				'opt_result'=>	$status,       
				'result_desc'=> $msg,    
				'module_id'	=>	$this->moduleId,
			);//dump($logargs);
			$logrs = optlog($logargs);//dump($logrs);
			
		}else{
			//验证失败
			$status = 9999;
			$msg = '';
			$data = json_encode($check_rs);
		}
		$this->jsonreturn($status, $msg, $data);		
    }
	
	
	
	//操作员编辑页面
	public function operEdit()
	{   
		$operator = spClass("operatorModel");
		$operator_id = $this->spArgs("operator_id");
		$rs = $operator->find(array('operator_id'=>$operator_id)); 			
		if($rs)
			$info = $rs;
		else
			$this->error_array = array(
				'ud_error'	=>	"加载管理员信息失败",
			);
			
		
		$this->args = $info;//dump($info);
		

		$this->tid = $_SESSION['operator_tid'];
		$this->sid = $_SESSION['operator_sid'];
		$this->saveUrl = $_SESSION['saveUrl'];
		$this->operator_types = $operator->getOperType('_ARRAY');
		$acl = spClass('aclModel');
		$this->authconfig = array(
			'update'=>	$acl->checkCA('operator', 'operUpdate'),
		);
		
		$this->display("operator/edit.html");

    }
	
	//操作员编辑提交
	public function operUpdate()
	{   
		$operator = spClass("operatorModel"); 
		
		
		
		$args = array(
		
			'name'	 => trim($this->spArgs("name")),
			'phone'	 => trim($this->spArgs("phone")),
			'type'	 => trim($this->spArgs("type")),
			'email'	 => trim($this->spArgs("email")),
			
		);
		$operator->verifier = $operator->verifier_edit;
		$check_rs = $operator->verifierModel($args);

		if(false == $check_rs){
			//通过验证
			$rs = $operator->update(array('operator_id' => trim($this->spArgs("operator_id"))),$args);
			$status = $rs == true ? 0 : -1;;
			$msg = $rs == true ? "操作成功" : "操作失败";
			$data = json_encode(array());
			
			$logargs = array(      
				'opt_field' =>	'编辑操作员',     
				'opt_desc'	=>	'操作员帐号:'.trim($this->spArgs("operator_id")).',操作员名称:'.trim($this->spArgs("name")),      
				'opt_result'=>	$status,       
				'result_desc'=>	$msg,    
				'module_id'	=>	$this->moduleId,
			);
			$logrs = optlog($logargs);
			
		}else{
			//验证失败
			$status = 9999;
			$msg = '';
			$data = json_encode($check_rs);
		}
		$this->jsonreturn($status, $msg, $data);
    }
	
	
	
	
	//操作员密码修改页面
	public function operPasswd()
	{   
		$operator = spClass("operatorModel");
		$this->args = array(
			'operator_id' => $this->spArgs("operator_id"),
		);
		$this->displayPartial("operator/passwd.html");

    }
	
	//操作员密码修改提交
	public function passwdSave()
	{   
		$operator = spClass("operatorModel"); 
		$this->args = array(
			'operator_id' => trim($this->spArgs("operator_id")),
			'password'	 => encryptPasswd(trim($this->spArgs("password"))),
		);
		$operator->verifier = $operator->verifier_passwd;
		$check_rs = $operator->verifierModel($this->args);

		if(false == $check_rs){
			//通过验证
			$rs = $operator->passwdSave($this->args);
			
			$logargs = array(      
				'opt_field' =>	'重置密码',     
				'opt_desc'	=>	'操作员帐号:'.$this->spArgs("operator_id"),   
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
		$this->displayPartial("operator/passwd.html");
    }
	
	//操作员冻结
	public function freeze()
	{  
		$operator = spClass("operatorModel"); 
		$args = array(
			'operator_id' => $this->spArgs("id"),
		);
		$rs = $operator->freeze($args);
		
		$logargs = array(      
			'opt_field' =>	'冻结操作员',     
			'opt_desc'	=>	'操作员帐号:'.$this->spArgs("id"),   
			'opt_result'=>	$rs['status'],       
			'result_desc'=>	$rs['desc'],    
			'module_id'	=>	$this->moduleId,
		);
		$logrs = optlog($logargs);
		
		$this->queryList($this->spArgs("page"), $this->pageSize, $rs['desc']);
    }
	
	//操作员解冻
	public function unfreeze()
	{   
		$operator = spClass("operatorModel"); 
		$args = array(
			'operator_id' => $this->spArgs("id"),
		);

		$rs = $operator->unfreeze($args);
		
		$logargs = array(      
			'opt_field' =>	'解冻操作员',     
			'opt_desc'	=>	'操作员帐号:'.$this->spArgs("id"),   
			'opt_result'=>	$rs['status'],       
			'result_desc'=>	$rs['desc'],    
			'module_id'	=>	$this->moduleId,
		);
		$logrs = optlog($logargs);
		
		$this->queryList($this->spArgs("page"), $this->pageSize, $rs['desc']);
    }
	
	//操作员单条删除
	public function operDel()
	{   
		$operator = spClass("operatorModel"); 
		$args = array(
			'operator_id' => $this->spArgs("id"),
		);

		$rs = $operator->delete($args);
		
		$logargs = array(      
			'opt_field' =>	'删除操作员',     
			'opt_desc'	=>	'操作员帐号:'.$this->spArgs("id"),   
			'opt_result'=>	$rs==true? 0 : 9999,       
			'result_desc'=>	$rs == true?"删除成功":"删除失败",    
			'module_id'	=>	$this->moduleId,
		);
		$logrs = optlog($logargs);
		
		$this->queryList($this->spArgs("page"), $this->pageSize, $rs['desc']);
    }

	

	//操作员功能权限显示
	public function operAuth()
	{   		
		$operator = spClass("operatorModel");
		$operator_id = $this->spArgs("operator_id");
		
		$args = array(
			'operator_id' => $operator_id,
		);
		$infors = $operator->find($args);
		$operator_type = $infors['type'];
		$operator_class = $infors['operator_class'];
		$this->operator_id = $operator_id;
		$this->operator_name = $infors['name'];
		
		$this->type_name = $operator->getOperType($operator_type);
		$this->class_name = $operator->getOperClass($operator_class);
		
		if($operator_type== operatorModel::OPER_TYPE_SYS)//超级管理员
		{	//超级权限
			
			$this->show_auth = 1;	//不用显示权限列表
			
			$this->authconfig = array(
				'authupdate'=>	false,
			);
		}
		else{
			$sys_auth = $operator->getSysAuth($operator_type, $operator_class);
			//dump($sys_auth);
			$module = $sys_auth['module'];
			$permission = $sys_auth['permission'];
			
			
                        $operator_auth = $operator->getAuth($operator_id, 0);
                        
                        $this->shownotice = 1;
                        //dump($permission);
			
			
			foreach($operator_auth as $key => $value){
				$permission[$value]['check'] = 1;
			}
			
			$newperm = array();
			foreach($permission as $permvalue => $permrow){
				$newperm[$permrow['module']][] = array(
					'permkey' => $permvalue,
					'description'=> $permrow['description'],
					'check'	  => $permrow['check'],
				);
			}
			//dump($newperm);
			
			$this->permission = $newperm;
		
			$this->perm_module = $module;
			$acl = spClass('aclModel');
			$this->authconfig = array(
				'authupdate'=>	$acl->checkCA('operator', 'authUpdate'),
			);
		}
		
		$this->tid = $_SESSION['operator_tid'];
		$this->sid = $_SESSION['operator_sid'];
		
		$this->display("operator/auth.html");

    }
	
	//操作员功能权限、应用权限提交
	public function authUpdate()
	{   
		$operator = spClass("operatorModel"); 
		
		$args = array(
			'operator_id'=> $this->spArgs("operator_id"),
			'auth_type'	 => 2,	//1角色权限，2操作权限
			'auth_id' 	 => $this->spArgs("perm"),
		);//dump(json_encode($args));exit;
		$rs = $operator->setAuth($args);
		$status = $rs['status'];
		$msg = $rs['desc'];
		$data = json_encode($args);
		
		$logargs = array(      
			'opt_field' =>	'权限设置',     
			'opt_desc'	=>	'操作员帐号:'.$this->spArgs("operator_id"),   
			'opt_result'=>	$status,       
			'result_desc'=>	$msg,    
			'module_id'	=>	$this->moduleId,
		);
		$logrs = optlog($logargs);
		
		$this->jsonreturn($status, $msg, $data);
    }

}
