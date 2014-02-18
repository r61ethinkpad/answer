<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 22:55:51
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answerType/create.html" */ ?>
<?php /*%%SmartyHeaderCode:213152297853037477330022-11646184%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '53db554b6e3f64bff6e80bb12b802541208ea55b' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answerType/create.html',
      1 => 1392735346,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '213152297853037477330022-11646184',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>

<div id="content">
    <div class="tab">
        <?php $_template = new Smarty_Internal_Template("answerType/_topTitle.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        <div class="tab-main">
            <p id="udError" class="dBox" style="display:none;"></p>
            <form id="_create_form" action="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'save','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
" method="post">
                <table class="formList">
                    
                    <tr>
                        <td class="name" style="vertical-align:top;"><font color="red">*</font>题库分类名称：</td>
                        <td class="value">
                            <input type="text" name="answerType[type_name]" id="type_name" value="" class="input_text" maxlength="32"/>
                            <span class="tip">汉字、字母、数字、下划线组合</span>
                            <span class="colOrange" id="error_type_name"><?php echo $_smarty_tpl->getVariable('error_array')->value['type_name'];?>
</span>
                        </td>
                    </tr>
                    
                    
                    <tr class="btnBox">
                        <td colspan="2">
                            <span class="sBtn">
                                <a class="left">确定</a><a class="right"></a>
                            </span>
                            <span class="sBtn-cancel">
                                <a class="left" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'index','tid'=>$_smarty_tpl->getVariable('tid')->value,'sid'=>$_smarty_tpl->getVariable('sid')->value),$_smarty_tpl);?>
">返回</a><a class="right"></a>
                            </span>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    jQuery(document).ready(function(){
	
		
        //屏蔽回车事件
        $('input,select').live("keypress", function(e) {
            if (e.keyCode == 13) {
                return false;
            }
        }); 
					
        //jQuery validate
        v_addMethod();
        $(".sBtn").click(function(){
            $('#_create_form').find('.tip').hide();
            $("#_create_form").validate({
                rules: {				
                    'answerType[type_name]': { required:true, minlength:1, maxlength:32, v_preg:'^[\u4e00-\u9fa5a-zA-Z0-9_]+$'}
                }
			
            });
            
            
            if($("#_create_form").valid()){
               
               
                var options = {
                    dataType:'json',
                    success:function(data){
                        $('#udError').hide();
                        $('.colOrange').hide();
                        if(data.status == '9999'){
                            var error = data.data;
                            for(var key in error){
                                $('#error_'+key).html(error[key]).show();
                            }
                        }
                        else if (data.status == '0'){
                            
                            $('#udError').html('题库分类添加成功').show();
                        }
                        else{
                            $('#udError').html('题库分类添加失败：'+ data.msg + '(' + data.status + ')').show();
                        }
                    },
                    error:function(){
                        $('#udError').html('请求失败').show();
                    }
                }
                $('#_create_form').ajaxSubmit(options);
                return false;
            }
        });
        
    });
</script>