<?php /* Smarty version Smarty-3.0.8, created on 2014-02-18 22:36:30
         compiled from "/Users/apple/web/root/answer/answer/view/default/admin/answerType/index.html" */ ?>
<?php /*%%SmartyHeaderCode:51205118253036feef34673-51288196%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72c8c59158134b4d93cf723b3c6fa7d308f6fe66' => 
    array (
      0 => '/Users/apple/web/root/answer/answer/view/default/admin/answerType/index.html',
      1 => 1392734185,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '51205118253036feef34673-51288196',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/DatePicker/WdatePicker.js"></script><link rel="stylesheet" type="text/css" href="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowCSS.css" />
<script type="text/javascript" src="view/<?php echo $_smarty_tpl->getVariable('tplName')->value;?>
/js/JQwindow/windowJS.js"></script>

<div id="content">
    <div class="tab">
        <?php $_template = new Smarty_Internal_Template("answerType/_topTitle.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
        <div class="tab-main">
            <form id='_query_form'>
                <div class="tool-box">
                    

                    <input type="text" value="输入分类名称" name="type_name" class="grayTips input_text" maxlength="128" style="width:400px;"/>
                    <a class="search_btn" onclick="listQuery('_query_form', '<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'queryList'),$_smarty_tpl);?>
', 'datagrid');;"></a>

                </div>
            </form>

            <div id="datagrid">
                <?php $_template = new Smarty_Internal_Template("answerType/_list.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
            </div>
        </div>

    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function(){
	
		
        //加载列表
        jQuery.ajax({
            type: 'get',
            url: "<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['spUrl'][0][0]->__template_spUrl(array('c'=>'answerType','a'=>'queryList'),$_smarty_tpl);?>
",
            data: jQuery('#_query_form').serialize(),
            beforeSend: function(XMLHttpRequest){
                $("#no_record").html("<img src='view/default/js/JQwindow/loading.gif' class='loading' />数据加载中...");
            },
            success: function(data,html){jQuery("#datagrid").html(data); $("#datagrid").show(); },
            error: function(){alert('加载数据失败');}
        });
		
        //搜索区域回车事件
        $('input,select').live("keypress", function(e) {
            if (e.keyCode == 13) {
                noticeQuery();
                return false;
            }
        }); 
    });
	
	
</script>