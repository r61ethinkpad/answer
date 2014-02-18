<?php

if (!defined('TBOWCARDUP')) {
    exit(1);
}

/**
 * 企业管理员首页控制器
 * @author Harrie
 * @version 1.0
 * @created 2010-06-28
 */
class index extends baseController {

    public $moduleId = 'system';

    public function __construct() {
        parent::__construct();
    }

    function verifyCode() {
        $vcode = spClass('spVerifyCode');
        $vcode->display();
    }

    function home(){
        $this->display("../inc/index/home.html");
    }
    function index() {
        import('md5password.php');
        $this->loginMenu = spClass('navigationModel')->loginMenu();
        $this->displayPartial("main/login.html");
    }

    function login() {
        $this->index();
    }

    function appCenter() {
        $this->title = T("nav_app_center");
        $this->loginMenu = spClass('navigationModel')->loginMenu();
        $this->displayPartial("../inc/app_index.html");
    }

    function help() {
        $this->title = T("nav_sys_help");
        $this->loginMenu = spClass('navigationModel')->loginMenu();
        $this->displayPartial("../inc/help_index.html");
    }

    function contact() {
        $this->title = T("nav_sys_contact");
        $this->loginMenu = spClass('navigationModel')->loginMenu();
        $this->displayPartial("../inc/_contact.html");
    }

    //登录
    function doLogin() {
        $username = $this->spArgs('username');
        $password = strtoupper($this->spArgs('password'));
        $verifycode = $this->spArgs('verifycode');

        if ($username == '' or $password == '' or $verifycode == '') {
            $status = 9999;
            $msg = '所填项不能为空';
            $data = json_encode(array());
        } else {
            $vcode = spClass('spVerifyCode');
            if ($vcode->verify($verifycode, false)) {
                //验证码通过
                $rs = spClass('aclModel')->login($username, $password, 1);
                //var_dump($verifycode);var_dump($rs); exit;
                if (0 == $rs['status']) {
                    $_SESSION["login"] = true; //已经登录
                    $this->sessionDataAuth($rs['data']);
                    $this->sessionOperator($rs['data']);
                    //var_dump($rs['data']);exit;
                    if(!$this->sessionFunctionAuth($rs['data']['operator_id'])){
                        $status = 1004;
                        $msg = '当前操作员没有分配权限';
                        $data = json_encode(array());
                        $this->jsonreturn($status, $msg, $data);
                        //exit;
                    }
                    //$this->sessionOrgApp($rs['data']['org_id']);
                    
                    
                    $logargs = array(
                        'operator_id' => $rs['data']['operator_id'],
                        'operator_name' => $rs['data']['name'],
                        'area_code' => $rs['data']['areacode'],
                        'org_id' => $_SESSION['orgid'],
                        'org_name' => $_SESSION['org_name'],
                        'opt_field' => T('title_org') . '系统登录',
                        'opt_desc' => '操作员编号:' . $rs['data']['operator_id'] . ',操作员名称:' . $rs['data']['name'],
                        'opt_result' => $rs['status'],
                        'result_desc' => $rs['desc'],
                        'module_id' => $this->moduleId,
                    ); //dump($logargs);
                    $logrs = optlog($logargs); //dump($logrs);
                }

                

                $status = $rs['status'];
                $msg = $rs['desc'];
                $data = json_encode($rs);
            } else {
                $status = 9999;
                $msg = '验证码不正确';
                $data = json_encode(array());
            }
        }
        $this->jsonreturn($status, $msg, $data);
    }

    //操作员信息放session
    private function sessionOperator($operatorInfo) {
        if ($operatorInfo) {
            $_SESSION['operator']["id"] = $operatorInfo['operator_id'];
            $_SESSION['operator']["name"] = $operatorInfo['name'];
            $_SESSION['operator']["type"] = $operatorInfo['type'];
            $_SESSION['operator']["class"] = $operatorInfo['operator_class'];
            $_SESSION['operator']["areacode"] = $operatorInfo['area_code'];
            $_SESSION['operator']["login_time"] = date('H:i:s');
            
            $_SESSION["orgid"] = $operatorInfo['org_id'];
            $_SESSION["org_name"] = "测试企业";
            
            //数据权限-例如管理整个企业 还是 管理某几个部门

            if ($operatorInfo['type'] == 1 and $operatorInfo['operator_class'] == 0
                    or
                    $operatorInfo['type'] == 0) {
            //超级管理员 or 校企级管理员
                $_SESSION['operator']['admin'] = 1;
            }
        }
        return true;
    }
    
    private function sessionDataAuth($data){
        if($data)
        {
            $_SESSION['dataauth'] = spClass("operatorModel")->dataAuth($data['operator_id'],$data['type'],9);
            $_SESSION['datatype'] = '1';//corp
            
            //$_SESSION['dataauth_node'] = NODE list 在spClass("operatorModel")->dataAuth中设置了
        }
        
        return true;
    }

    //操作员功能权限放session
    private function sessionFunctionAuth($operator_id) {
        if ($operator_id == '') {
            exit;
        }
        $org_id = $_SESSION['orgid'];
       
        //得到当前操作员的功能权限
        $auth = spClass("operatorAuthModel")->findAll(array('operator_id' => $operator_id,'auth_type' => '2'));
        
        //var_dump($auth);
        $list = array();
        if(@count($auth) > 0)
        {
            foreach($auth as $row)
            {
                $list[] = $row['auth_id'];
            }
        }
        //$auth = spClass('operatorModel')->getAuth($operator_id, 0);
        if($_SESSION['operator']['type'] == '0'){//超级管理员包括 0
            array_push($list, '0');
        }
        
        if(@count($list) == 0)
        {
            return false;            
        }
        $_SESSION['functionauth'] = $list;

        //权限列表放session里
        $permission = spClass('permissionModel')->getCorpPermission();
        
        $authlist = array();
        foreach ($list as $id => $authid) {
            $child = $permission[$authid]['children'];
            foreach ($child as $childkey => $value) {
                $authlist[] = $value;
            }
        }
        $authlist = array_unique($authlist);
        $_SESSION['authlist'] = $authlist;
        
        return true;
    }


    //无权限时跳转
    function noPerm() {
        $this->errorinfo = '您没有权限使用这个功能！';
        $this->display("../inc/error.html");
    }

}
