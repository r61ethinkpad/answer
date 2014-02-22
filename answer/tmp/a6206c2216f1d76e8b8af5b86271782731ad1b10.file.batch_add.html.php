<?php /* Smarty version Smarty-3.0.8, created on 2014-02-19 10:41:53
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/batch_add.html" */ ?>
<?php /*%%SmartyHeaderCode:1530675878530419f185a9f8-61626712%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6206c2216f1d76e8b8af5b86271782731ad1b10' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/batch_add.html',
      1 => 1392776301,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1530675878530419f185a9f8-61626712',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>

<div id="content">
<?php if ($_smarty_tpl->getVariable('opt_msg')->value!=''){?>
	<p id="optMsg" class="dBox"><?php echo $_smarty_tpl->getVariable('opt_msg')->value;?>
<br/><a id='msg_close' style='margin-left:50px;' class='colOrange'>[关闭]</a></p>
<?php }?>
	<div class="tab">
    	<ul class="tab-label">
        	<li class="current"><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'batch','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">批量导入题库</a></li>	
        
		</ul>
        <div class="tab-main">
            <form id="form1" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'batch','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
" 
            method="post" enctype="multipart/form-data" name='form1'>
        	<table class="formList">
        	    
               <tr class="form-name">
                	<td colspan="4">上传题库</td>
                </tr>
                 <tr>
                    <td class="name"><span class='colRed'>*</span>选择文件：</td>
                    <td class="value" colspan='3'>
                    	<input type="file" name="batch_file" style='width:200px;'/>
                    	<span class="colOrange"><?php echo $_smarty_tpl->getVariable('error_array')->value['batch_file'];?>
</span>
                    </td>
                </tr>
                <tr><td colspan="4" class="value">
                <pre style="margin-left:80px;">
                	<br>文件导入规则：
					<br>1、文件必须为xls的excel文件，文件最大<?php echo $_smarty_tpl->getVariable('maxfsize')->value;?>
M，工作表第一页必须填写数据；
					<br>2、请从第3行开始填写数据，系统默认从第3行开始读取；
                                        <br>3、平台须首先建立题库分类。
                                        <br>4、所属关卡，请填写数字，例如 1，2，3。
					<br>5、表格中所有的数据都是必填，对于建行题库管理员，题库分类可以选填。					
					<br>6、如不确定文件格式，请下载[<a href="javascript:void(0);" onclick="tmpDown();" id='a_tmp'>批量导入企业用户文件模板</a>]。
               	</pre>
               	</td></tr>
               
                <tr class="btnBox">
                    <td colspan="4">
                        <span class="sBtn">
                            <a class="left">确定</a><a class="right"></a>
                        </span>
                          
                    </td>
                </tr>
            </table>
        </form>
            
        </div>
    </div>
</div>

<script type="text/javascript"> 
$(document).ready(function(){
	v_addMethod();
	$(".sBtn").click(function(){
	$("#form1").validate({
		rules: {
			'batch_file': {required:true,accept:'xls|xlsx'}
			
		},
		messages:{
			'batch_file': {accept:'文件格式不正确，请上传xls文件'}
		}
	});
	if($("#form1").valid()){
		$("#form1").submit();
	}
	});
	
	//关闭提示消息
	$('#msg_close').click(function(){
		$('#optMsg').hide();
	});
	
	
	
	
});

var tmpDown = function(){
	
	window.location.href='<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answer','a'=>'openTmpDown'),$_smarty_tpl);?>
';
	
}
</script>