<?php
/*
maker:kermit
date:2011-11-24
notes:main function of web develop
email:kermit2011@126.com
*/

class mainfun{

/*******************************************************************************************/

	private $value;                          		  				//传递值
	
	public static $ip='';                             				//静态定义IP地址
	
/*******************************************************************************************/	
	
	/*
	 *getpost/getstring取得get或者post得来的变量并进行处理
	 *
	 *$c:传递的变量的名称
	 *$type:对变量过滤的严重级别
	 *		1，严格级过滤，不允许任何有嫌疑的字符:	适应页面传参
	 *		2，普通级过滤，过滤一些极危险字符：			适应一般的表单提交
	 *		3，简单级过滤，加转义：				适应表单内容提交
	 *$idyes：为1则进行整化；为0不操作
	 */

//1，接受/处理POST方式传递的数组

public function getpost($c,$type='0',$idyes='0'){            
	
	$value=trim(isset($_POST[$c])?$_POST[$c]:$T='');
	
	$idyes=='1' && $value=intval($value);
	
	switch($type){
		
			case '1' : $value=$this->filtrate_strict($value);break;
			
			case '2' : $value=$this->filtrate_normal($value);break;
			
			case '3' : $value=$this->filtrate_simple($value);break;
			
			default :break;
			
			}
	
	return $value;
	
}	

//2，接受/处理GET方式传递的数组
	
public function getstring($c,$type='1',$idyes='0'){
	
	$value=trim(isset($_GET[$c])?$_GET[$c]:$t='');
	
	$idyes=='1' && $value=intval($value);
	
	switch($type){
		
			case '1' : $value=$this->filtrate_strict($value);break;
			
			case '2' : $value=$this->filtrate_normal($value);break;
			
			case '3' : $value=$this->filtrate_simple($value);break;
			
			default :break;
			
			}
	
	return $value;
	
}

//3，对变量进行处理的三个等级之---1.严格级过滤

public function filtrate_strict($value){
	
		$delchar=array("'",'"','#','$','//','/*',"*",";",':','“','“','\\',' ','.','/','~','!','^','&',',','，',
		
					   '[',']','{','}','<','>','|','`','=','&quot;','&#39;','&lt;',"&gt;");	
					   
		$value=str_replace($delchar,'',$value);
		
		$value=preg_replace("/eval/i","eva l",$value);
	
		return $value;
		
}

//4，对变量进行处理的三个等级之---2.普通级过滤

public function filtrate_normal($value){
	
		$delchar=array('#','$','/*','//','\\','^','&',);
		
		$value=str_replace($delchar,'',$value);
					   
		$chanchara=array('"',"'",'&lt;',"&gt;");	
		
		$chancharb=array('&quot;','&#39;','<','>');
		
		$value=str_replace($chanchara,$chancharb,$value);
	
		return $value;
	
}


//5，对变量进行处理的三个等级之---2.简单级过滤

public function filtrate_simple($value){
	
		!get_magic_quotes_gpc() && $value=addslashes($value);
		
		return $value;
	
}

//6，对非get和post获取的变量进行处理--可对数组进行替换的函数

public function checkchar($value,$type='2'){
	
		if(!is_array($value)){
		
				switch($type){
			
						case '1' : $value=$this->filtrate_strict($value);break;
						
						case '2' : $value=$this->filtrate_normal($value);break;
						
						case '3' : $value=$this->filtrate_simple($value);break;
				
						default :break;
				
					}
			
		}else{
					
				foreach($value as $key=>$val){
					
						if(!is_array($val)){
						
								switch($type){
					
										case '1' : $value=$this->filtrate_strict($value);break;
										
										case '2' : $value=$this->filtrate_normal($value);break;
										
										case '3' : $value=$this->filtrate_simple($value);break;
								
										default :break;
						
									}
									
						$array[$key]=$value;
					
						}else{
							
								$array[$key]=$this->char_filtrate($array[$key],$type); 
				
						}
				
				}
				
		}
		
		return $value;
		
}


		/*
		 *页面信息显示函数
		 *$message:将要显示给用户的信息
		 *$url:信息显示后将要跳转的页面
		 *$refresh:如为页面刷新的方式请填此项表示信息页显示的秒数
		 *         $refresh为0则会以js弹出窗口提示；不为0则以页面显示
		 *当前显示信息的模板页面：ROOT_PATH/inc/message.html
		 *$image:信息显示时旁边显示的图片名称
		 */


//7，页面信息反馈 $refresh为0则为alert警告框

public function msg_show($message,$url='',$refresh='',$image='mes_gx.gif'){
	
		if(!$message) return "you have not set the message which you wang to show to the viewer";
		
		if($refresh){ //set time and not use alert method to show message	
				
				$content = addslashes(file_get_contents(ROOT_PATH."inc/message.html"));
				
				//require(ROOT_PATH."inc/message.html");$content=ob_get_contents();
				
				@ob_end_clean();
				
				$change_char=array('{{refresh}}','{{url}}','{{message}}','{{image}}');
				
				$changeto_char=array($refresh,$url,$message,$image);
				
				$content=str_replace($change_char,$changeto_char,$content);
				
				echo stripslashes($content);exit;
		
		}else{   
		
				if(!$url){
					
					 echo "<script language='javascript'>alert('$message');window.history.go(-1);</script>\n";
					 
					 exit();
			
				}else{
					
					 echo "<script language='javascript'>alert('$message');window.location.href='$url';</script>\n";
			
					 exit();
					 
					 }
				
		}
	
}//end show message	
	

//8，获取用户的IP地址
	
public function getuserip(){
	
			if(self::$ip!='') return self::$ip;
	
			if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
				
					$ip = getenv("HTTP_CLIENT_IP");
				
			}elseif(getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
				
					$ip = getenv("HTTP_X_FORWARDED_FOR");
				
			}elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
				
					$ip = getenv("REMOTE_ADDR");
				
			}elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
				
					$ip = $_SERVER['REMOTE_ADDR'];
					
			}else{ 
			
					$ip = "unknown";
					
			}
			
			self::$ip=$ip;
				
			return $ip; 

}//end get ip address
	

		/*
		 *中文剪切函数
		 *$string:将要剪切的变量值
		 *$length:要剪切的长度
		 *$dot:如剪切后所带的后缀
		 */


//9，中文剪切函数

public function str_cut($string,$length,$dot = '...'){
	
		$strlen=strlen($string);
		 
		if($strlen<=$length) return $string; 
		
		$delchar=array(' ','"','—','<','>','·','…','《','》',':',';');//标题中只能出现-号和,号
		
		$string=str_replace($delchar,'',$string);
		
		$yinchar=array(',','，');
		
		$string=str_replace($yinchar,'-',$string);
		 
		$strcut=''; 
		
		if(strtolower(WEB_LANG)=='utf-8'){
					/*//utf-8编码时用
					$n = $tn = $noc = 0; 
					while($n<$strlen){ 
					$t=ord($string[$n]); 
					if($t==9 || $t==10 || (32<=$t && $t<=126)){$tn=1;$n++;$noc++; 
					}elseif(194<=$t && $t<=223){ $tn=2; $n+= 2;$noc+=2; 
					}elseif(224<=$t && $t<239){	$tn = 3; $n += 3; $noc += 2;
					}elseif(240 <= $t && $t <= 247){$tn=4; $n += 4; $noc += 2;
					}elseif(248 <= $t && $t <= 251){$tn=5;$n+=5;$noc += 2;
					}elseif($t == 252 || $t == 253){$tn=6;$n += 6; $noc += 2;
					}else{$n++;}
					if($noc>=$length) break; 
					}
					if($noc>$length) $n-=$tn;
					$strcut = substr($string, 0, $n);
					*///utf-8编码时用
		}else{ 
		
					$dotlen = strlen($dot); 
					
					$maxi = $length - $dotlen - 1; 
					
					for($i=0;$i<$maxi;$i++){
						
					$strcut.=ord($string[$i])>127?$string[$i].$string[++$i]:$string[$i]; 
		
				}
		
		}
		 
		return $strcut.$dot; 

} //end


//10，取得随机字符	
	
public function get_randchar($length){

	$char = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	
	$max = strlen($char) - 1;
	
	$value='';
	
	for($i = 0; $i < $length; $i++) {
		
		$value .= $char[mt_rand(0, $max)];
	}
	
	return $value;
	
}

//11，取得到当到的时间到微秒数

public function get_microtime(){
	
	$value=explode(' ',microtime());
		
	$value=$value[0]+$value[1];
		
	return $value;
	
	}


//12，将gbk编码改为utf8

public function gb2utf8($array){
	 
        if(is_array($array)){
			 
            foreach($array as $key => $value){
				
                  $char[$this->gb2utf8($key)] = $this->gb2utf8($value); 
              
			  		}
          
		  }elseif(is_string($array)){
			  
             if(mb_detect_encoding($array)!="UTF-8") return utf8_encode($array); 
             
			 else return $array; 
        
		 }else{return $array;} 
         
		 return $char; 

} //结束编码转换


public function add_slash($array){
	
	foreach($array as $key=>$value){
		
		if(!is_array($value)){
			
			$value=str_replace("&#x","& # x",$value);
			
			$value=preg_replace("/eval/i","eva l",$value);
			
			!get_magic_quotes_gpc() && $value=addslashes($value);
			
			$array[$key]=$value;
			
		}else $array[$key]=Add_S($array[$key]); 
				
							 }
	
	return $array;

}


	/*
	 *敏感词替换函数
	 *$value:要替换的字符串变量
	 *$keyword:敏感词字符串，词间以'|'分开
	 *$type:替换方式
	 *		1，替换成***
	 *		2，去除不留下痕迹
	 *		3，返回数值1表示此变量存在非法字符
	 */

//13，敏感词处理替换

public function keyword_filtrate($value,$keyword,$type='1'){
	
	if(!$keyword) exit('the keywords is null or not array');
	
	$keyword=explode('|',$keyword);
	
	if(!is_array($keyword)) exit('keyword is not separate by | char');
	
	if($type!='3'){
		
			$goal_char='';
			
			$type=='1' && $goal_char='***';
	
			foreach($keyword as $key=>$val){
		
		  			 $value=str_replace($val,$goal_char,$value);
		
					}
					
		   return $value;
					
	}else{
		
			foreach($keyword as $key=>$val){
		
		  			if(strpos($value,$val)){return 1;}
		
					}
			
			return 0;
		
		}
	
}




	
}//end class



?>