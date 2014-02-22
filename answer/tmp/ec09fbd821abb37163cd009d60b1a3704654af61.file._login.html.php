<?php /* Smarty version Smarty-3.0.8, created on 2014-02-22 10:08:47
         compiled from "/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/_login.html" */ ?>
<?php /*%%SmartyHeaderCode:1914754005530806af07ac47-64073493%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ec09fbd821abb37163cd009d60b1a3704654af61' => 
    array (
      0 => '/Applications/XAMPP/xamppfiles/htdocs/answer/answer/view/default/admin/../inc/_login.html',
      1 => 1393032225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1914754005530806af07ac47-64073493',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/jquery.md5.js"></script>

<form action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'index','a'=>'doLogin'),$_smarty_tpl);?>
" method="post" id="loginForm" name="loginForm" onsubmit="return aclcode();" >
    <!--<input type="submit" value="提交">-->
	<ul id="tab_1_main" class="login_box">
       	<li id="showUdError" class="error_msg"><?php echo $_smarty_tpl->getVariable('ud_error')->value;?>
</li>
       	<li>
            <span class="name">用户名</span>
            <input id="username" name="username" value="<?php echo $_smarty_tpl->getVariable('user_name')->value;?>
" maxlength="20" type="text" class="input_text" />
        </li>
      	<li>
            <span class="name">密&nbsp;&nbsp;&nbsp;码</span>
			<input id="password" name="password" maxlength="20" type="password" class="input_text" />
        </li>
        <li>
			<span class="name">验证码</span>
            <input id="verifycode" name="verifycode" maxlength="4" type="text" class="input_text" style="width:80px;" />
            <img id="code" src="" style="vertical-align:middle;" />
            <a href="#" onclick="loadimg()">换一张</a>
		</li>
        <li style="display:none;" id="msg_code">
            <span class="name">短信码</span>
            <input type="text" class="input_text" style="width:80px;" />
            <a href="#">重新发送短信码</a>
        </li>
        <li class="btnBox">
            <span class="sBtn" onclick="loginSubmit();">
                <a class="left" >登录</a><a class="right"></a>
             </span>
        </li>
    </ul>
</form>

<script type="text/javascript">
$(document).ready(function(){
	
	loadimg();
	
	$('input:text:first').focus();
	keypress();

function keypress(){
    $('input').live("keypress", function(e) {
		/* ENTER PRESSED*/
        if (e.keyCode == 13) {
        /* FOCUS ELEMENT */
				
			if($(this).attr("name")=='verifycode') {
                loginSubmit();
                return true;
            } 
			else if($(this).attr("name")=='username') {
				document.getElementById("password").focus();
                document.getElementById("password").select();
            }
			else if($(this).attr("name")=='password') {
                document.getElementById("verifycode").focus();
                document.getElementById("verifycode").select();
            }
            return false;
        }
    });
}
});


function loadimg(){ 
	document.getElementById("code").src="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'index','a'=>'verifyCode'),$_smarty_tpl);?>
#"+ new Date().getTime();
}

function loginSubmit(){		
	var username = $("#username").val();
	var password = $.md5($("#password").val());
	var verifycode = $("#verifycode").val();
	
	jQuery.ajax({
		dataType:'json',
		type: 'post',
		url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'index','a'=>'doLogin'),$_smarty_tpl);?>
",
		data: "username="+username+"&password="+password+"&verifycode="+verifycode,
		beforeSubmit:function(){
			$('#showUdError').hide();
			if( username == ''){
				$('#showUdError').html('用户名不能为空').show();
				return false;
			}
			if( password == ''){
				$('#showUdError').html('密码不能为空').show();
				return false;
			}
			if( verifycode == ''){
				$('#showUdError').html('验证码不能为空').show();
				return false;
			}
		},
		success:function(data){
			//$('#showUdError').hide();
			if (data.status == '0'){
				window.location.href='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'main','a'=>'index','tid'=>1,'sid'=>1),$_smarty_tpl);?>
';
			}
			else{
				$('#showUdError').html(data.msg).show();
				document.getElementById("verifycode").value = '';
				loadimg();
			}
		},
		error:function(data,textStatus){
                        //alert(textStatus);
			$('#showUdError').html('请求失败').show();
			loadimg();
		}
	});
}
</script>