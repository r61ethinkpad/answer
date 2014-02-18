<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 17:30:49
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answer/detail.html" */ ?>
<?php /*%%SmartyHeaderCode:1235637531530328494cd221-17831643%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'add2ed12e7c50fbe42a6d3fa93d5cf97b928bdc4' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answer/detail.html',
      1 => 1392715846,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1235637531530328494cd221-17831643',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>
<style>
	.formList tr td a { color:#666;}
	.formList tr td a:hover {text-decoration:underline; color:#F60;}
</style>
<div id="content">
	<div class="tab">
    	<?php $_template = new Smarty_Internal_Template("answer/_topTitle.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
	
        <div class="tab-main">
        	<table class="formList">
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">所属分类：</td>
                        <td class="value">
                            <input type="hidden" name="exam[question_id]" value="<?php echo $_smarty_tpl->getVariable('args')->value['question_id'];?>
"/>
                            <?php echo $_smarty_tpl->getVariable('args')->value['exam_type_text'];?>

                        </td>

                    </tr>

                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">所属关卡：</td>
                        <td class="value">
                            <?php echo $_smarty_tpl->getVariable('args')->value['exam_point_text'];?>

                        </td>
                    </tr>
                    <tr>
                        <td class="name" style="vertical-align:top;font-weight: bolder;">题目内容：</td>
                        <td class="value">
                             <?php echo $_smarty_tpl->getVariable('args')->value['question_content'];?>

                        </td>
                    </tr>
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">正确答案：</td>
                        <td class="value">
                            <?php echo $_smarty_tpl->getVariable('args')->value['correct_answer'];?>

                        </td>
                    </tr>
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">备选答案A：</td>
                        <td class="value">
                            <?php echo $_smarty_tpl->getVariable('args')->value['alternative_a'];?>

                        </td>
                    </tr>
                    
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">备选答案B：</td>
                        <td class="value">
                            <?php echo $_smarty_tpl->getVariable('args')->value['alternative_b'];?>

                        </td>
                    </tr>
                    
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">备选答案C：</td>
                        <td class="value">
                           <?php echo $_smarty_tpl->getVariable('args')->value['alternative_c'];?>

                        </td>
                    </tr>
                    
                    <tr class="line">
                        <td class="name" style="vertical-align:top;font-weight: bolder;">备选答案D：</td>
                        <td class="value">
                           <?php echo $_smarty_tpl->getVariable('args')->value['alternative_d'];?>

                        </td>
                    </tr>                   
                    
                </table>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery("#showBigPic").click(function(){
        //alert("click");
        itemWindow('查看病害的图片', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'pest','a'=>'showBigPic','file_name'=>$_smarty_tpl->getVariable('args')->value['pic_path']),$_smarty_tpl);?>
', '950', '500');
    });
});
</script>
