<?php

/**
 * @author weijuan
 * spVerifier
 * 数据验证程序
 */
class verifierModel extends spVerifier {

	/** 
	 * 附加的检验规则函数
	 */
	private $add_rules = null;
	
	/** 
	 * 验证规则
	 */
	private $verifier = null;
	
	/** 
	 * 验证时返回的提示信息
	 */
	private $messages = null;
	
	/** 
	 * 待验证字段
	 */
	private $checkvalues = null;
	/** 
	 * 函数式使用模型辅助类的输入函数
	 */
    public function __input(& $obj, $args){
		$check_rs = parent::__input($obj, $args);
		
		if(FALSE == $check_rs){//验证通过
			return $check_rs;
		}else{
			foreach($check_rs as $key => $error){
				$error_arr[$key] = $error[0];
			}
			return $error_arr;
		}
	}

	/** 
	 * 内置验证器，检查字符串非空
	 * @param val    待验证字符串
	 * @param right    正确值
	 */
	private function notnull($val, $right){return $right === ( strlen($val) > 0 );}
	/** 
	 * 内置验证器，检查字符串是否小于指定长度
	 * @param val    待验证字符串
	 * @param right    正确值
	 */
	private function minlength($val, $right){return $this->cn_strlen($val) >= $right;}
	/** 
	 * 内置验证器，检查字符串是否大于指定长度
	 * @param val    待验证字符串
	 * @param right    正确值
	 */
	private function maxlength($val, $right){return $this->cn_strlen($val) <= $right;}
	/** 
	 * 内置验证器，检查字符串是否等于另一个验证字段的值
	 * @param val    待验证字符串
	 * @param right    正确值
	 */
	private function equalto($val, $right){return $val == $this->checkvalues[$right];}
	/** 
	 * 内置验证器，检查字符串是否正确的时间格式
	 * @param val    待验证字符串
	 * @param right    正确值
	 */
	private function istime($val, $right){$test = @strtotime($val);return $right == ( $test !== -1 && $test !== false );}
	/** 
	 * 内置验证器，检查字符串是否正确的电子邮件格式
	 * @param val    待验证字符串
	 * @param right    正确值
	 */	
	private function email($val, $right){
		return $right == ( preg_match('/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9-]+\.)+[A-Za-z0-9]+$/', $val) != 0 );
	}
	/** 
	 * 计算字符串长度，支持包括汉字在内的字符串
	 * @param val    待计算的字符串
	 */
	public function cn_strlen($val){$i=0;$n=0;
		while($i<strlen($val)){$clen = ( strlen("快速") == 4 ) ? 2 : 3;
			if(preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$val[$i])){$i+=$clen;}else{$i+=1;}$n+=1;}
		return $n;
	}
	
	/**
	 * 验证手机号码
	 * @author weijuan
	 */
	function check_phone($val, $right){
        if( is_numeric($val) && strlen($val) == 11 ){
            return TRUE; // $right是等于TRUE的
        }else{
            return FALSE; // 也就是 !$right
        }
    }
    //如果存在验证是否数字
    function isNumber($val,$right){
    	if($val==''||is_numeric($val))
    		return true;
    	else
    		return false;
    
    }
    //如果存在验证电话(宽松验证)
    function isPhone1($val,$right){
    	$val = str_replace(' ', '', $val);  
    	$preg = "/^[+0-9][0-9]*(-)?[0-9]+$/";
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else
    		return false;
    }
    //匹配区号3位，则本地号8位，区号4位，则本地号7位的号码。或者11位手机号
    function isPhone($val,$right){
    	$val = str_replace(' ', '', $val);
    	$preg = "/^(0\d{2,3}[-\s])?\d{7,8}$|^[0]?\d{11}$/";
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else
    		return false;
    }
    
    //固定的字符长度
    function length($val,$right){
    	if($val==''||strlen($val)==$right)
    		return true;
    	else 
    		return false;
    }
    //匹配给定正则 
    function preg($val,$right){
    	if($val==''||preg_match($right, $val))
    		return true;
    	else 
    		return false;
    	
    }
    //ip地址
    function ip($val,$right){
    	$preg = "/^(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))\.)(([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5]))|0)\.){2}([1-9]|([1-9]\d)|(1\d\d)|(2([0-4]\d|5[0-5])))$/";
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else 
    		return false;
    }
    
    //端口
    function port($val,$right){
    	$preg = "/^([0-9]|[1-9]\d|[1-9]\d{2}|[1-9]\d{3}|[1-5]\d{4}|6[0-4]\d{3}|65[0-4]\d{2}|655[0-2]\d|6553[0-5])$/";
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else
    		return false;
    }
    //邮箱验证
    function email2($val,$right){
    	$preg = '/^[A-Za-z0-9]+([._\-\+]*[A-Za-z0-9]+)*@([A-Za-z0-9-]+\.)+[A-Za-z0-9]+$/';
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else 
    		return false;
    }
    
    //身份证号码验证
    function idcard($val,$right){
    	$preg = '/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/';
    	if($val==''||preg_match($preg, $val))
    		return true;
    	else
    		return false;
    }
    
    //不能含有特殊字符
    function schar($val,$right){
    	$preg = '/[\\><&]/';
    	if($val==''||!preg_match($preg, $val))
    		return true;
    	else
    		return false;
    }
    
    /**
     * @author yangtl
     * 只在非空时才做最小长度的检查
     */
   function minlength_notnull($val, $right){
    	return $val==''||$this->cn_strlen($val) >= $right;
    }
    

}