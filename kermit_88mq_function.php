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
	
//��ʱ���ʽת��Ϊ����
	
function getdaytime($timechar){
	
	return substr($timechar,5,5);
	
	}
	
//��ҵ���ۺ���

function says_dyjb($num,$cl=0){
	
	switch(intval($num)){
		
		case 20: $dy='�ܺ�';$jb='����';break;
		
		case 16: $dy='����';$jb='10Сʱ��';break;
		
		case 12: $dy='һ��';$jb='10-20Сʱ';break;
		
		case 9: $dy='����';$jb='20-30Сʱ';break;
		
		case 6: $dy='����';$jb='��30Сʱ';break;
		
		default:$dy='����';$jb='����';break;
		
		}
				
	if(!$cl) return $dy;
	
	else return $jb;

}

//��ҵ�������

function says_other($num,$cl=0){
	
	switch(intval($num)){
	
		case $num>=15: $zw="�ܴ�";$fw='�ܺ�';$gr='�нϴ�';$xy='�ܺ�';break;
		
		case $num>=12: $zw="����";$fw='����';$gr='��Щ';$xy='����';break;
		
		case $num>=10: $zw="��С";$fw='ƽ��';$gr='��һ��';$xy='һ��';break;
		
		case $num>=8: $zw="����";$fw='����';$gr='������';$xy='����';break;
		
		default: $zw="����";$fw='����';$gr='������';$xy='����';break;
		
		}
					
	if(!$cl) return $zw?$zw:'';
	
	elseif($cl==1) return $fw?$fw:'';
	
	elseif($cl==2) return $gr?$gr:'';
	
	else return $xy?$xy:'';

}

//��վ���ຯ��

function pageclasschar($value,$url=false){
	
	$valuechar='';
	
	switch($value){
	
	    case 1: $valuechar='������';$pgurl='enter_trend';break;
		
		case 2: $valuechar='����������';$pgurl='work_course';break;
	 
	    case 3: $valuechar='���Ծ���';$pgurl='inter_course';break;
		  
		case 4: $valuechar='ְҵ����';$pgurl='pro_feeling';break;
		   
		case 5: $valuechar='������̬';$pgurl='sec_5';break;
			
		case 6: $valuechar='ְ����֪';$pgurl='pro_know';break;
			
		case 7: $valuechar='��ҵ��Ѹ';$pgurl='indus_news';break;
			
		case 8: $valuechar='���Լ���';$pgurl='inter_skill';break;
			
		case 9: $valuechar='ְҵ�滮';$pgurl='life_plan';break;
			
		case 10: $valuechar='ְ������';$pgurl='sec_10';break;
			
		case 11: $valuechar='����ѧ��';$pgurl='sec_11';break;
			
		case 12: $valuechar='�������';$pgurl='sec_12';break;
			
		case 13: $valuechar='������¼';$pgurl='life_ceo';break;					
		
		}
		
	if($url) return $pgurl;
		
	return $valuechar;
	
}

//����û��Ƿ���ڣ��ж�ID�����û���

function check_exist_user($value,$type='username'){
	   
	   $sql= $type=='username' ? " username={$value} ":" id={$value} ";
	   
	   $sql="select * from mq_user where {$sql}";
	   
	   global $db_do; 
	   
	   $rs=$db_do->db_select($sql);
	   
	   if($rs) return 1;//����
	   
	   else return 0;//������
	     
   }
   
function check_user($username,$password){
	   
	   $sql= $type=='id' ? " id={$value} ":" username={$value} ";
	   
	   $sql="select * from mq_user where {$sql}"; 
	   
	   if($rs) return 1;//����
	   
	   else return 0;//������
	     
   }
   
//�ǻ���û�еȺ��ֱ�ʾ

function isno($value,$type=''){
	
	if($type=='') $result=($value==0 || $value=='')?'δ��':$value;
	
	elseif($type=='1') $result=($value==1)?'��':'��';
	
	elseif($type=='2') $result=($value==1)?'����':'����';
	
	elseif($type=='3') $result=($value==1)?'��������֤':'����δ��֤';
	
	elseif($type=='4') $result=($value=='')?'':date('Y-m-d h:i:s',$value);
	
	elseif($type=='5') $result=($value==1)?'ԭ��':'ת��';
	
	elseif($type=='6') $result=($value==1)?'����':'<font color=red>����</font>';
	
	elseif($type=='7') $result=($value==1)?'ͨ��':'<font color=red>����</font>';
	
	elseif($type=='8') $result=($value==1)?'����':'<font color=red>ͣ��</font>';
	
	return $result;
	
	} 
 
//��ҵ��ģ�ַ���

function qiye_guimo($i){
	
	switch($i){
		
		case 1: $gmchar='��������ҵ(10000������)';break;
		
		case 2: $gmchar='������ҵ(1000-9999��)';break;
		
		case 3: $gmchar='������ҵ(500-1000��)';break;
		
		case 4: $gmchar='��С����ҵ(100-500��)';break;
		
		case 5: $gmchar='С����ҵ(20-100��)';break;
		
		case 6: $gmchar='΢����ҵ(20������)';break;
		
		default:$gmchar='none';
	
	}
	
	return $gmchar;

}
 
//��������Ⱥ���

function saysmy($jibie){
	
	switch($jibie){
	
		case $jibie>=4:$jibies='������';break;
		
		case $jibie>=3:$jibies='����';break;
		
		case $jibie>=2:$jibies='���а�';break;
		
		case $jibie>=1:$jibies='������';break;		
		
		default:$jibies='����';break;

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
        
			if (strpos($spider_agent,$value)!==false){//Ϊ����������м�¼
			   
					$spider=$key;global $db_do;
					
					//������������м�¼-1Сʱ��¼һ��
			
					$thistime=time()-3600;
					 
					$db_do->db_select("LOCK TABLES web_sprider WRITE");
			
					if(!$db_do->db_getallnum('web_sprider',"where sprider='{$spider}' and UNIX_TIMESTAMP(cometime)>$thistime ",'*'))

							$db_do->db_upandde("insert into web_sprider(sprider,cometime) values('$spider',now())");
							
					$db_do->db_select("UNLOCK TABLES");

					return $spider;
				
			}
			
    }//����forѭ��

    $spider = '';return $spider;
	
}
  
/*
 *ʹ���ֻ���
 *ͨ�����ַ���һ���ж��Ƿ������ֻ������
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

		}//�������Ƿ��ֻ���������ж�
		
}//end function


/*
 *�Ƿ�����ʱ���м�¼
 */

function bad_visit($says=''){
	
	global $db_do,$mainfun,$thisip,$jzips,$webset;
	
	if($says=='') $says='����ˢ��ҳ'.PHP_THIS; 
	
	$db_do->db_upandde("insert into jin_ips(jin_ip,jin_say,jin_time) values('$thisip','$says',now())");
	
		//ǰ̨ע��ﵽ���ٴμ����ֹIP
	
		if($db_do->db_getallnum('jin_ips'," where jin_ip='$thisip' ")==$webset['front_zhuru_times']){
						
				if(!in_array($thisip,$jzips)){//�����ֹIP���޴�IP�����
				
						$db_do->db_upandde("update web_set set ip_jinzhi=concat(ip_jinzhi,'|$thisip')");
						
						define("IS_FRONT",true);
						
						require(ROOT_PATH."/code_excute/front_set_config.php");
				
						}

				$db_do->db_upandde("insert into jin_ips(jin_ip,jin_say,jin_time) values('$thisip','�������IP�������ֹIP�б�',now())");

		exit('������IP����ע��������࣬IP�ѱ���ֹ');}
	
	$mainfun->msg_show("�����ڴ�ҳ�棬�˲���Ϊ�Ƿ�ע��","/index.html",3);	
	
	die();

}


/*
 *�����������
 */

function add_jifen_num($array){
	
	/*$array=array(
		'er_numfa'=>//����������
		'er_num_pj'=>//��ҵ������
		'er_numhui'=>//����������
		'er_num_dy'=>//������
		'er_promotion'=>//�ƹ���
		'er_promotion'=>//�ƹ���
		'er_times'=>//��¼����	
	);*/
	
	global $webset;
	
	$jifen=($array['email_is_yanz'])?$webset['email_money']:0;
	
	$jifen=$jifen + $array['er_promotion']*$webset['web_tg_jfnum'] + $array['er_numfa']*$webset['jifen_page'] 
	
		 + $array['er_num_pj']*$webset['jifen_pingjia'] + $array['er_num_dy']*$webset['jifen_daiyu'] 
		 
		 + $array['er_numhui']*$webset['jifen_pinglun'] + $array['er_times']*$webset['jifen_denglu'] + $webset['zhuci_money'];
	
	return $jifen;
	
}

/*
 *�ַ�ת��ʱ���ж���û�б�Ҫ����ת��
 *$force�Ƿ�ǿ��ת��
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