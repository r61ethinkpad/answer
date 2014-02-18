listQuery = function(formid, queryurl, labelname){
	if (formid != ''){
		var objs = document.getElementById(formid).elements;
		var i = 0;
		var cnt = objs.length;
		var obj;
		
		for(i=0;i<cnt;i++){
			obj = objs.item(i);
			if($(obj).attr('type')!='checkbox'&&$(obj).attr('type')!='radio')
				queryurl+= '&'+obj.name+'='+obj.value;
			else if($(obj).attr('type')=='checkbox'&&obj.checked)
				queryurl+= '&'+obj.name+'='+obj.value;
			else if($(obj).attr('type')=='radio'&&obj.checked)
				queryurl+= '&'+obj.name+'='+obj.value;
			
		}
	}
    queryurl = encodeURI(queryurl);
    
    jQuery.ajax({
		type: 'get',
		url: queryurl,
		
		beforeSend: function(XMLHttpRequest){
			$('#loading_msg').html("<img src='view/default/js/JQwindow/loading.gif' class='loading' />");
		},
		complete: function(XMLHttpRequest, textStatus){$('#loading_msg').html('');},
		success: function(data,html){jQuery("#"+labelname).html(data);},
		//complete: function(XMLHttpRequest, textStatus){hideLoadingLayer();},
		error: function(){alert('请求失败');}
	})
    
	
}

formSubmit = function(formid, submiturl, refreshid){
	var objs = document.getElementById(formid).elements;
	var i = 0;
	var cnt = objs.length;
	var obj;
	
	for(i=0;i<cnt;i++){
		obj = objs.item(i);
		submiturl += '&'+obj.name+'='+obj.value;
	}

    submiturl = encodeURI(submiturl);
	jQuery.ajax({
		type: 'get',
		url: submiturl,
		success: function(data,html){
			jQuery("#"+refreshid).html(data);
		},
		complete: function(XMLHttpRequest, textStatus){ 
			var spanText = $('#'+formid).find('table').find('tr').find('.value').find('.tip');
			spanText.remove();
		},
		error: function(){alert('请求失败');}
	}
	)
}

alertSubmit = function(desc, submiturl, refreshid){
	if(!confirm(desc)) return false;

	jQuery.ajax({
		type: "get",
		url: submiturl,
		success: function(data, html){
			jQuery("#"+refreshid).html(data);
		},
		error: function(){
		    alert('请求失败');
		}
	});
}

itemWindow=function(wintitle, itemurl, winwidth, winheight){
	itemurl = encodeURI(itemurl);
	tipsWindown(
		wintitle,	// title：窗口标题
		"url:get?"+itemurl,	// Url：弹窗所加截的页面路径
		winwidth,	// width：窗体宽度
		winheight,	// height：窗体高度
		"true",	// drag：是否可以拖动（ture为是,false为否）
		"",	// time：自动关闭等待的时间，为空代表不会自动关闭
		"true",	// showbg：设置是否显示遮罩层（false为不显示,true为显示）
		"text"	// cssName：附加class名称
	);		
}

///---------------添加JQ验证规则------------------ytl-----------------------------------------
v_addMethod =  function() {
	 $.validator.addMethod("isPhone",      //电话号码检查
			 function(value, element) {
		 		var tel = /^(0\d{2,3}[-\s])?\d{7,8}$|^[0]?\d{11}$/; 
		 		return this.optional(element) || (tel.test(value));
			 },'电话格式不正确');
	 $.validator.addMethod("ip",      //IP检查
			 function(value, element) {
		 		var preg = /^(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.)(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5]))|0)\.){2}([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))$/; 
		 		return this.optional(element) || (preg.test(value));
			 },'IP格式不正确');
	 $.validator.addMethod("port",      //port检查
			 function(value, element) {
		 		var preg = /^([0-9]|[1-9]\d|[1-9]\d{2}|[1-9]\d{3}|[1-5]\d{4}|6[0-4]\d{3}|65[0-4]\d{2}|655[0-2]\d|6553[0-5])$/; 
		 		return this.optional(element) || (preg.test(value));
			 },'端口格式不正确');
	 $.validator.addMethod("v_preg",      //自定义正则
			 function(value, element,param) {
		 		var preg = new RegExp(param); 
		 		return this.optional(element) || (preg.test(value));
			 },'格式不正确');
	 $.validator.addMethod("mobile",      //手机号码
			 function(value, element) {
		 		var tel = /^[1-9][0-9]{10}$/; 
		 		return this.optional(element) || (tel.test(value));
			 },'请输入11位手机号码');
	 $.validator.addMethod("schar",      //特殊字符
			 function(value, element) {
		 		var reg = /[\\><&]/; 
		 		return this.optional(element) || !reg.test(value);
			 },'此项含有非法字符（<>&\\）');
	 
	 $.validator.addMethod("smallto",      //开始时间不能大于结束时间   格式：20120601
			 function(value, element, param) {
				return Number(value) <= Number($(param).val());
			 },'开始时间不能大于结束时间');
	 
	 $.validator.addMethod("idcard",      //身份证
			 function(value, element) {
		 		var preg = /^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/; 
		 		return this.optional(element) || (preg.test(value));
			 },'身份证格式不正确');
	 $.validator.addMethod("charMax",      //按utf8统计汉字占三个字符
			function(value, element,param) {
		 		var len = 0;
		 		for(i=0;i<value.length;i++)
		 		{
		 			if(value.charCodeAt(i)>256)
		 			{
		 				len += 3;
		 			}
		 			else
		 			{
		 				len++;
		 			}
		 		}
		 	return this.optional(element) || len <= param;
		 },'最多输入{0}个字符(一个汉字按三个字符统计)');
	 
	 $.validator.addMethod("notEqualto", 
			function(value, element, param) {
				return this.optional(element)||value!=$(param).val();
		},'信息重复');
}