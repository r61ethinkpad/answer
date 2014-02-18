<?php
/**
 * @author weijuan
 */

class UdModel extends spModel{
	/**
	 * 供检验值的规则与返回信息
	 */
	public $verifier = null;
	
	/**
	 * 增加的自定义验证函数
	 */
	public $addrules = array();

	private $_cmd_find;
    private $_cmd_findall;
    private $_cmd_create;
    private $_cmd_delete; 
	private $_cmd_update; 

	/**
	 * 构造函数
	 */
	public function __construct()
	{	
		//parent::__construct();
		$r = $this->commandId();
        if($r['find'] != '') $this->_cmd_find = $r['find'];
        if($r['findall'] != '') $this->_cmd_findall = $r['findall'];
        if($r['create'] != '') $this->_cmd_create = $r['create'];
		if($r['update'] != '') $this->_cmd_update = $r['update'];
        if($r['delete'] != '') $this->_cmd_delete = $r['delete'];
	}

	/**
	 * 从数据表中查找一条记录
	 *
	 */
	public function find($params=array())
	{	
		$retcode = spClass("uniwebModel")->call($this->_cmd_find, $params, $r);
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
		$rs['rows'] = uniwebModel::list2map($r);
		$rs['data'] = $r;
		return $rs;
	}
	
	/**
	 * 从数据表中查找记录
	 *
	 */
	public function findAll($params=array())
	{
		$retcode = spClass("uniwebModel")->call($this->_cmd_findall, $params, $r);
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
		if($r['_pg_']!='')
        {
        	//$page = substr($r['_pg_'], 1,strlen($r['_pg_'])-2);
			$page = str_replace('[', '', $r['_pg_']);
			$page = str_replace(']', '', $page);
            $page = explode(',',$page);
            $rs['_pg_']['page'] = $page[0];
            $rs['_pg_']['pages'] = $page[1];
            $rs['_pg_']['pagesize'] = $page[2];
            $rs['_pg_']['count'] = $page[3];
        }
        $rs['rows'] = uniwebModel::list2map($r);
		
		return $rs;
	}

	/**
	 * 在数据表中新增一行数据
	 *
	 * @param row 数组形式，数组的键是数据表中的字段名，键对应的值是需要新增的数据。
	 */
	public function create($row)
	{
		if(!is_array($row))return FALSE;
		if(empty($row))return FALSE;
		
		$retcode = spClass("uniwebModel")->call($this->_cmd_create, $row, $r);
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
        $rs['data'] = $r;
		$rs['rows'] = uniwebModel::list2map($r);
		return $rs;
	}

	/**
	 * 在数据表中新增多条记录
	 *
	 * @param rows 数组形式，每项均为create的$row的一个数组
	 */
	public function createAll($rows)
	{
		foreach($rows as $row)$this->create($row);
	}

	/**
	 * 按条件删除记录
	 *
	 */
	public function delete($params=array())
	{
		$retcode = spClass("uniwebModel")->call($this->_cmd_delete, $params, $r);
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
		$rs['rows'] = uniwebModel::list2map($r);
		return $rs;
	}
	/**
	 * 在数据表中删除多条记录
	 *
	 * @param rows 数组形式，每项均为create的$row的一个数组
	 */
	public function deleteAll($rows)
	{
		foreach($rows as $row){
			$rs[] = $this->delete($row);
		}
		return $rs;
	}
	
	/**
	 * 修改数据，该函数将根据参数中设置的条件而更新表中数据
	 * 
	 */
	public function update($params=array())
	{
		$retcode = spClass("uniwebModel")->call($this->_cmd_update, $params, $r);
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
		$rs['rows'] = uniwebModel::list2map($r);
		return $rs;
	}
	
	/**
	 * 执行SQL语句，相等于执行新增，修改，删除等操作。
	 *
	 * @param sql 字符串，需要执行的SQL语句
	 */
	public function runUniweb($cmd, $params=array())
	{
		$retcode = spClass("uniwebModel")->call($cmd, $params, $r);
		
		$rs['status'] = $retcode;
        $rs['desc'] = $r['desc'];
		if($r['_pg_']!='')
        {
			$page = str_replace('[', '', $r['_pg_']);
			$page = str_replace(']', '', $page);
            $page = explode(',',$page);
            $rs['_pg_']['page'] = $page[0];
            $rs['_pg_']['pages'] = $page[1];
            $rs['_pg_']['pagesize'] = $page[2];
            $rs['_pg_']['count'] = $page[3];
        }
		$rs['rows'] = uniwebModel::list2map($r);
		$rs['data'] = $r;
		return $rs;
	}
	
	/**
	 * 魔术函数，执行模型扩展类的自动加载及使用
	 */
	public function __call($name, $args)
	{
		//return parent::__call($name, $args);
		if(in_array($name, $GLOBALS['G_SP']["auto_load_model"])){
			return spClass($name)->__input($this, $args);
		}elseif(!method_exists( $this, $name )){
			spError("方法 {$name} 未定义");
		}
	}
	
	protected  function commandId()
    {
        //var_dump('-=========');
    }

}

