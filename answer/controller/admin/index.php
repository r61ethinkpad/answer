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
                    $this->sessionFunctionAuth($rs['data']);
                    
                    
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
    
    //操作员功能权限放session
    private function sessionFunctionAuth($operator) {
        if (@count($operator) == 0 || $operator == null) {
            exit;
        }
        
        //得到当前操作员的功能权限
        $list = $this->operatorAuth($operator['type']);
        
        //$auth = spClass('operatorModel')->getAuth($operator_id, 0);
        if($_SESSION['operator']['type'] == '00'){//超级管理员包括 0
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
    
    /**
     * 
     * @param type $type
     * @return array
     * type:
     * 00-超级管理员
     * 01-自定义题库管理员
     * 02-建行题库管理员
     * 03
     * 04-银行客户
     * 05-系统客户-查询客户答题积分的
     */
    private function operatorAuth($type)
    {
        $list = array();
        switch ($type) {
            case '01'://自定义题库管理员
                $list = array(
                    'custom_exam_manage',
                );
                break;
            case '02'://建行题库管理员
                $list = array(
                    'bank_exam_manage',
                );
                break;
            case '00'://超级管理员
                $list = array(
                    'system_optlog',
                    'operator_manage',
                    'custom_exam_manage',
                    'bank_exam_manage',
                    'answer_record_view',
                    'exam_type_manage',
                    'game_manage',
                );
                break;
            case '04'://建行客户
                $list = array(
                    'game_manage',
                );
                break;
            case '05'://系统客户查询用户的答题记录
                $list = array(
                    'answer_record_view',
                );
                break;
            default:
                $list = array();
                break;
        }
        
        return $list;
    }


    //无权限时跳转
    function noPerm() {
        $this->errorinfo = '您没有权限使用这个功能！';
        $this->display("../inc/error.html");
    }
    
    
    public function jumpToError()
    {
        $no = $this->spArgs("msg_no");
        switch ($no) {
            case '1':
                $this->errorinfo = "验证码错误";
                break;
            case '2':
                $this->errorinfo = "参数格式错误";
                break;
            case '3':
                $this->errorinfo = "银行客户账户为空";
                break;
            case '4':
                $this->errorinfo = "客户的操作类型不能确定";
                break;
            case '5':
                $this->errorinfo = "验证码错误";
                break;

            default:
                $this->errorinfo = "未知错误";
                break;
        }
        //dump($this->errorinfo);
        $this->displayPartial("../inc/so_error.html");
    }
    
    /**
     * 单点登录。
     * 用途： 客户玩游戏和父平台 查询用户的得分，都通过这个链接登录
     * 
     * 格式。key=base64_encode(pwd+json_encode(data))
     * pwd = 666666
     * data = array(
     *      'user_id'=>'100001',
     *      'opt_type'=>'1',// '1'=>game '2'=> get score
     *      'game_date'=>'20140219',//查询积分时用，可以指定某一天的积分，空，则查询当前用户所有的答题记录
     * )
     */
    public function soLogin()
    {
        $sync_pwd = '666666';//单点登录协议密码
        $default_opt_type = array('1','2');
        $key = trim($this->spArgs("key"));
        if($key == null || $key == "")
        {
            $this->jump(spUrl('index', 'jumpToError'));
        }
        $key_content = base64_decode($key);
        $verdify_key = substr($key_content, 0,6);
        if($verdify_key != $sync_pwd)
        {
            $this->jump(spUrl('index', 'jumpToError',array("msg_no"=>"1")));
            
        }
        $data = (array)json_decode(substr($key_content, 6));
        if(!is_array($data))
        {
            $this->jump(spUrl('index', 'jumpToError',array('msg_no'=>'2')));
        }
        
        $user_id = $data['user_id'];
        $opt_type = $data['opt_type'];
        $game_date = $data['game_date'];
        
        if($user_id == null || $user_id == "")
        {
            $this->jump(spUrl('index', 'jumpToError',array('msg_no'=>'3')));
        }
        
        if($opt_type == null || $opt_type == "" || !in_array($opt_type, $default_opt_type))
        {
            $this->jump(spUrl('index', 'jumpToError',array('msg_no'=>'4')));
        }
        
        //把客户信息存入session中
        $_SESSION['so_login']['user_id'] = $user_id;
        $_SESSION['so_login']['name'] = "银行答题客户";
        $_SESSION['so_login']['type'] = $opt_type;
        $_SESSION['so_login']['login_time'] = date('H:i:s');
        
        $_SESSION["login"] = true; //已经登录   
        
        if($opt_type == '1')//go to game
        {
            $this->sessionFunctionAuth(array('type'=>'04'));
            
            $this->jump(spUrl('game','index'));
        }else if ($opt_type == '2')
        {
            $this->sessionFunctionAuth(array('type'=>'05'));
            $this->jump(spUrl('record','index'));
        }
       
    }
    
    
    
    

}
