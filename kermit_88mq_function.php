<?php
/*
maker:kermit
date:2012-4-1
notes:the class for 88mq.net
email:kermit2011@126.com
*/
	
function gbk2utf8($char){
	
	return iconv('gb2312','utf-8',$char);

	}
	
//将时间格式转化为日期
	
function getdaytime($timechar){
	
	return substr($timechar,5,5);
	
	}
	
//企业评价函数

function says_dyjb($num,$cl=0){
	
	switch(intval($num)){
		
		case 20: $dy='很好';$jb='极少';break;
		
		case 16: $dy='不错';$jb='10小时内';break;
		
		case 12: $dy='一般';$jb='10-20小时';break;
		
		case 9: $dy='不好';$jb='20-30小时';break;
		
		case 6: $dy='极差';$jb='超30小时';break;
		
		default:$dy='还行';$jb='还行';break;
		
		}
				
	if(!$cl) return $dy;
	
	else return $jb;

}

//企业评价相关

function says_other($num,$cl=0){
	
	switch(intval($num)){
	
		case $num>=15: $zw="很大";$fw='很好';$gr='有较大';$xy='很好';break;
		
		case $num>=12: $zw="不错";$fw='不错';$gr='有些';$xy='不错';break;
		
		case $num>=10: $zw="较小";$fw='平淡';$gr='有一点';$xy='一般';break;
		
		case $num>=8: $zw="困难";$fw='不好';$gr='基本无';$xy='不好';break;
		
		default: $zw="无望";$fw='极差';$gr='根本无';$xy='极差';break;
		
		}
					
	if(!$cl) return $zw?$zw:'';
	
	elseif($cl==1) return $fw?$fw:'';
	
	elseif($cl==2) return $gr?$gr:'';
	
	else return $xy?$xy:'';

}

//网站分类函数

function pageclasschar($value,$url=false){
	
	$valuechar='';
	
	switch($value){
	
	    case 1: $valuechar='名企动向';$pgurl='enter_trend';break;
		
		case 2: $valuechar='名企工作经历';$pgurl='work_course';break;
	 
	    case 3: $valuechar='面试经历';$pgurl='inter_course';break;
		  
		case 4: $valuechar='职业感悟';$pgurl='pro_feeling';break;
		   
		case 5: $valuechar='健康心态';$pgurl='sec_5';break;
			
		case 6: $valuechar='职场需知';$pgurl='pro_know';break;
			
		case 7: $valuechar='行业资迅';$pgurl='indus_news';break;
			
		case 8: $valuechar='面试技巧';$pgurl='inter_skill';break;
			
		case 9: $valuechar='职业规划';$pgurl='life_plan';break;
			
		case 10: $valuechar='职场礼仪';$pgurl='sec_10';break;
			
		case 11: $valuechar='礼仪学堂';$pgurl='sec_11';break;
			
		case 12: $valuechar='社会万象';$pgurl='sec_12';break;
			
		case 13: $valuechar='名人语录';$pgurl='life_ceo';break;					
		
		}
		
	if($url) return $pgurl;
		
	return $valuechar;
	
}

//检查用户是否存在，判断ID或者用户名

function check_exist_user($value,$type='username'){
	   
	   $sql= $type=='username' ? " username={$value} ":" id={$value} ";
	   
	   $sql="select * from mq_user where {$sql}";
	   
	   global $db_do; 
	   
	   $rs=$db_do->db_select($sql);
	   
	   if($rs) return 1;//存在
	   
	   else return 0;//不存在
	     
   }
   
function check_user($username,$password){
	   
	   $sql= $type=='id' ? " id={$value} ":" username={$value} ";
	   
	   $sql="select * from mq_user where {$sql}"; 
	   
	   if($rs) return 1;//存在
	   
	   else return 0;//不存在
	     
   }
   
//是还是没有等汉字表示

function isno($value,$type=''){
	
	if($type=='') $result=($value==0 || $value=='')?'未留':$value;
	
	elseif($type=='1') $result=($value==1)?'是':'否';
	
	elseif($type=='2') $result=($value==1)?'公开':'保密';
	
	elseif($type=='3') $result=($value==1)?'邮箱已验证':'邮箱未验证';
	
	elseif($type=='4') $result=($value=='')?'':date('Y-m-d h:i:s',$value);
	
	elseif($type=='5') $result=($value==1)?'原创':'转载';
	
	elseif($type=='6') $result=($value==1)?'正常':'<font color=red>被封</font>';
	
	elseif($type=='7') $result=($value==1)?'通过':'<font color=red>待审</font>';
	
	elseif($type=='8') $result=($value==1)?'启用':'<font color=red>停用</font>';
	
	return $result;
	
	} 
 
//企业规模字符串

function qiye_guimo($i){
	
	switch($i){
		
		case 1: $gmchar='超大型企业(10000人以上)';break;
		
		case 2: $gmchar='大型企业(1000-9999人)';break;
		
		case 3: $gmchar='中型企业(500-1000人)';break;
		
		case 4: $gmchar='中小型企业(100-500人)';break;
		
		case 5: $gmchar='小型企业(20-100人)';break;
		
		case 6: $gmchar='微型企业(20人以下)';break;
		
		default:$gmchar='none';
	
	}
	
	return $gmchar;

}
 
//待遇满意度函数

function saysmy($jibie){
	
	switch($jibie){
	
		case $jibie>=4:$jibies='很满意';break;
		
		case $jibie>=3:$jibies='满意';break;
		
		case $jibie>=2:$jibies='还行吧';break;
		
		case $jibie>=1:$jibies='不满意';break;		
		
		default:$jibies='无语';break;

		}
	
		return $jibies;
	
}

/*
 *check is or not sprider
 *kermit-2012-6-8
 */

function is_spider(){

    static $spider = 'unknown';

    if($spider!='unknown') return $spider;

    if(empty($_SERVER['HTTP_USER_AGENT'])){$spider=''; return $spider;}

    $searchs = array(
        'Google'=>'googlebot',
        'Googleadsense'=>'mediapartners-google',
        'Baidu'=>'baiduspider',
        'MSN'=>'msnbot',
        'Yodao'=>'yodaobot',
        'Yahoo'=>'slurp;',
        'Iask'=>'iaskspider',
        'Sogouweb'=>'sogou web spider',
        'Sogoupush'=>'sogou push spider',
		'Sohu'=>'sohu-search',
		'Lycos'=>'lycos',
		'Robozilla'=>'robozilla',
		'soso'=>'soso',
		'Microsoft'=>'bing' 
    );

    $spider_agent=strtolower($_SERVER['HTTP_USER_AGENT']);

    foreach($searchs as $key=>$value){
        
			if (strpos($spider_agent,$value)!==false){//为搜索引擎进行记录
			   
					$spider=$key;global $db_do;
					
					//对搜索引擎进行记录-1小时记录一次
			
					$thistime=time()-3600;
					 
					$db_do->db_select("LOCK TABLES web_sprider WRITE");
			
					if(!$db_do->db_getallnum('web_sprider',"where sprider='{$spider}' and UNIX_TIMESTAMP(cometime)>$thistime ",'*'))

							$db_do->db_upandde("insert into web_sprider(sprider,cometime) values('$spider',now())");
							
					$db_do->db_select("UNLOCK TABLES");

					return $spider;
				
			}
			
    }//结束for循环

    $spider = '';return $spider;
	
}
  
/*
 *使用手机版
 *通过几种方法一起判断是否属于手机浏览器
 */
 
function is_phone_user($filename){
	
		global $webset;global $cache;
			
		if(!isset($_SERVER['HTTP_USER_AGENT'])) return;
		
		$user_agent=strtolower(addslashes($_SERVER['HTTP_USER_AGENT']));
						
		$mobile_char="nokia|iphone|android|motorola|softbank|foma|docomo|kddi|"; 
		$mobile_char.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|coolpad|webos|techfaith|palmsource|";
		$mobile_char.="blackberry|alcatel|ktouch|nexian|samsung|ericsson|philips|sagem|wellcom|bunjalloo|maui|";
		$mobile_char.="symbian|smartphone|midp|wap|phone|iemobile|spice|bird|longcos|pantech|gionee|portalmmm|";
		$mobile_char.="hiptop|ucweb|benq|haier|320x320|240x320|176x220";
		$mobile_arr=explode('|',$mobile_char);
				
		foreach($mobile_arr as $key=>$value){
			
				if(strpos($user_agent,$value)!==false){
					
						unset($mobile_char,$mobile_arr);
			
						header("Location:http://www.88mq.net/wap/index.html");

						exit;
				
				}

		}//结束对是否手机浏览器的判断
		
}//end function


/*
 *非法操作时进行记录
 */

function bad_visit($says=''){
	
	global $db_do,$mainfun,$thisip,$jzips,$webset;
	
	if($says=='') $says='恶意刷网页'.PHP_THIS; 
	
	$db_do->db_upandde("insert into jin_ips(jin_ip,jin_say,jin_time) values('$thisip','$says',now())");
	
		//前台注入达到多少次记入禁止IP
	
		if($db_do->db_getallnum('jin_ips'," where jin_ip='$thisip' ")==$webset['front_zhuru_times']){
						
				if(!in_array($thisip,$jzips)){//如果禁止IP里无此IP则加入
				
						$db_do->db_upandde("update web_set set ip_jinzhi=concat(ip_jinzhi,'|$thisip')");
						
						define("IS_FRONT",true);
						
						require(ROOT_PATH."/code_excute/front_set_config.php");
				
						}

				$db_do->db_upandde("insert into jin_ips(jin_ip,jin_say,jin_time) values('$thisip','恶意访问IP被加入禁止IP列表',now())");

		exit('您所在IP恶意注入次数过多，IP已被禁止');}
	
	$mainfun->msg_show("不存在此页面，此操作为非法注入","/index.html",3);	
	
	die();

}


/*
 *计算积分数量
 */

function add_jifen_num($array){
	
	/*$array=array(
		'er_numfa'=>//发表文章数
		'er_num_pj'=>//企业评价数
		'er_numhui'=>//文章评论数
		'er_num_dy'=>//待遇数
		'er_promotion'=>//推广数
		'er_promotion'=>//推广数
		'er_times'=>//登录次数	
	);*/
	
	global $webset;
	
	$jifen=($array['email_is_yanz'])?$webset['email_money']:0;
	
	$jifen=$jifen + $array['er_promotion']*$webset['web_tg_jfnum'] + $array['er_numfa']*$webset['jifen_page'] 
	
		 + $array['er_num_pj']*$webset['jifen_pingjia'] + $array['er_num_dy']*$webset['jifen_daiyu'] 
		 
		 + $array['er_numhui']*$webset['jifen_pinglun'] + $array['er_times']*$webset['jifen_denglu'] + $webset['zhuci_money'];
	
	return $jifen;
	
}

/*
 *字符转义时先判断有没有必要进行转义
 *$force是否强制转义
 */
 
function addslashes_add($string,$force=0){
	
        !defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		
        if(!MAGIC_QUOTES_GPC || $force) {
			
            if (is_array($string)) {
                
				foreach ($string as $key => $val) $string[$key] = daddslashes($val, $force);
     
            }else{
				
                $string = addslashes($string);
            
			}
        
		}
		
        return $string;
    
}


?>