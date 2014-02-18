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
class index extends tbController {

    public $moduleId = '0';//登陆模块

    public function __construct() {
        parent::__construct();
    }

    function verifyCode() {
        $vcode = spClass('spVerifyCode');
        $vcode->display();
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
        $password = trim($this->spArgs('password'));
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
                    
                    $this->sessionOperator($rs['data']);
                    
                    
                    
                    $logargs = array(
                        'operator_id' => $rs['data']['operator_id'],
                        'operator_name' => $rs['data']['name'],
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
           
            $_SESSION['operator']["login_time"] = date('H:i:s');
           
            //超级管理员 or 校企级管理员
            $_SESSION['operator']['admin'] = 1;
            
        }
        return true;
    }


    //无权限时跳转
    function noPerm() {
        $this->errorinfo = '您没有权限使用这个功能！';
        $this->display("../inc/error.html");
    }

}
