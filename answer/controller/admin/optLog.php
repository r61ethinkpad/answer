<?php
if (!defined('TBOWCARDUP')) { exit(1);}
/**
 * 管理员控制器
 * @author weijuan
 */
class optLog extends tbController
{
	
	
	public function __construct(){ 
		parent::__construct(); 
	}
	
	public function index(){
		$optLog = spClass("optLogModel");
		$this->opt_module = spClass("permissionModel")->getSysModule();
		
		$this->firstday = date('Y-m-01');
		$this->today = date('Y-m-d');
		
		$_SESSION['optlog_tid'] = $this->spArgs("tid");
		$_SESSION['optlog_sid'] = $this->spArgs("sid");
		$this->display("optLog/index.html");
	}
	
    public function queryList($page=1, $pageSize=10, $optResult='')
	{		
		$optLog = spClass("optLogModel");
			
		$stime = $this->spArgs("stime")==""?date('Ym01'):str_replace('-', '', $this->spArgs("stime"));
		$etime = $this->spArgs("etime")==""?date('Ymd'):str_replace('-', '', $this->spArgs("etime"));
		
		$operator_id = $this->spArgs("operator_id");
		$module_id = $this->spArgs("module_id");
		$opt_desc = $this->spArgs("opt_desc");
		$page = $this->spArgs("page")==''?$page:$this->spArgs("page");
		
		
		
		$args = array(
			'_pg_' 		=> 	array($page,$pageSize),
			
			'module_id'	=> 	$module_id==''?'':$module_id,
			'operator_id'=> in_array($operator_id,array("操作员帐号",''))?"":$operator_id,
			'opt_desc'	=>	in_array($opt_desc,array("描述关键字",''))?"":$opt_desc,
			'stime'		=>	$stime,
			'etime'		=>	$etime,
		);//dump($args);
		//dump(json_encode($args));
		
		$rs = $optLog->queryList($args);
		//dump($rs);
		$opt_module =  spClass("permissionModel")->getSysModule();

		if($rs['rows']){
			foreach($rs['rows'] as $key => $row){
				$rs['rows'][$key]['module_desc'] = $opt_module[$row['module_id']];
			}
		}
		
		$this->optlog_list = $rs['rows'];
		$this->_pg_ = $rs['_pg_'];
		
		$this->tid = $_SESSION['optlog_tid'];
		$this->sid = $_SESSION['optlog_sid'];
		
		$url = '&operator_id='.$operator_id.'&module_id='.$module_id.
			'&opt_desc='.$opt_desc.
			'&stime='.$stime.'&etime='.$etime;
		$this->query_url = spUrl("optLog","queryList").$url;
		$_SESSION['saveUrl'] = $url.'&page='.$page;
		$this->saveUrl = $_SESSION['saveUrl'];
		//dump($url);dump($this->saveUrl);
		$this->displayPartial("optLog/_list.html");
    }
	

}
