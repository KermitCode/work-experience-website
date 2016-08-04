<?php
/*******************
*author:kermit
*usge:cut the keyword
*time:2012-5-8
*******************/

class cut_keyword{
	
    public  $arr_value=array();                 //the value  that will be returned
	
	public  $key_yuan;				   			//the keyword that will be cut
	
	public  $key_now;				   			//the keyword that have been made
	
	private $key_2=array();						//the keywords only two chinese chars
	
	private $key_3=array();						//the keywords only three chinese chars
	
//function to get made char	
	
private function set_keyword($keyword){//set keyword yuan and now
	
		$this->key_yuan=$keyword;
		
		$matches='';
		
		$keyword=mb_convert_encoding($keyword,'UTF-8','GB2312');
		
		preg_match_all('/[\x{4e00}-\x{9fff}]+/u',$keyword,$matches);
		
		$keyword=join('',$matches[0]);
		
		$keyword=mb_convert_encoding($keyword,'GB2312','UTF-8'); 
		
		$this->key_now=$keyword;
		
		unset($matches);
	
	}//end
	
public function get_keywords(){//get keywords from database;
	
	global $db_do;
	
	$key_row=$db_do->db_getone("select keyword_2,keyword_3 from web_data");
	
	$this->key_2=explode('|',rtrim($key_row['keyword_2'],'|'));
	
	$this->key_3=explode('|',rtrim($key_row['keyword_3'],'|'));
	
	unset($key_row);
	
	}//end
	
//the first method get the keyword by one keyword and one keyword

public function fir_keyword($keyword){
	
	$this->set_keyword($keyword);
	
    if(strlen($this->key_now)<6) return;
		
	$this->get_keywords();

	for($keychar=$this->key_now;$keychar;){
		
		$first=substr($keychar,0,6);
		
		if(!in_array($first,$this->key_3)){
			
				$second=substr($keychar,0,4);
			
				if(!in_array($second,$this->key_2)){
				
					$keychar=substr($keychar,2);
				
				}else{
				
					$keychar=substr($keychar,4);
			
					$second!=$this->key_now && $this->arr_value[]=$second; 
				
				}	
			
		}else{
			
			$keychar=substr($keychar,6);
		
			$first!=$this->key_now && $this->arr_value[]=$first; 
			  
			  }
	
		}//½áÊøfor
		
	unset($keychar,$first,$second);
		
	return array_unique($this->arr_value);
	
	}//end

//the second method get the keyword by one word and one word

public function sec_keyword($keyword){
	
	$this->set_keyword($keyword);
	
    if(strlen($this->key_now)<6) return;
		
	$this->get_keywords();
	
	$keychar=$this->key_now;
	
	$lennum=strlen($keychar);
	
		for($i=0;$i<$lennum-1;$i+=2){
		
			$first=substr($keychar,$i,4);
			
			if(in_array($first,$this->key_2)) $first!=$this->key_now && $this->arr_value[]=$first;
	
			}//¶þ×Ö·û
	
		for($i=0;$i<$lennum-1;$i+=2){
		
			$second=substr($keychar,$i,6);
			
			if(in_array($second,$this->key_3)) $second!=$this->key_now && $this->arr_value[]=$second;
		
			}//Èý×Ö·û
			
	unset($keychar,$first,$second,$i,$lennum,$this->key_3,$this->key_2);
			
	return array_unique($this->arr_value);
	
    }//end

//when use the fulltext search then find the first apprence of any one keyword in the $see_array;

public function cut_text($text,$number,$key_array){
	
	$text=trim(strip_tags($text));

	for($i=count($key_array),$key_pos='';$i>0;$i--){
		
		$key_pos=strpos($text,$key_array[$i-1]);
		
		if(!($key_pos===false)) break;
		
		}
	
	if(!$key_pos || $key_pos<$number) return $this->cn_substr($text,$number,0);
	
	else return $this->cn_substr($text,$number,$key_pos-$number+rand(4,$number));
	
	}

//the function to cut char

private function cn_substr($str,$slen,$startdd=0){
/*	 
global $cfg_soft_lang;
 
if($cfg_soft_lang=='utf-8'){
	 
return cn_substr_utf8($str,$slen,$startdd); 

} */

$restr = '';$c = ''; 

$str_len = strlen($str); 

if($str_len < $startdd+1){return '';} 

if($str_len < $startdd + $slen || $slen==0) {$slen = $str_len - $startdd;} 

$enddd = $startdd + $slen - 1;

for($i=0;$i<$str_len;$i++){ 

if($startdd==0){$restr .= $c;}
 
else if($i > $startdd){$restr .= $c;} 

if(ord($str[$i])>0x80){ 
	
	if($str_len>$i+1){$c = $str[$i].$str[$i+1];} 
	
	$i++; 
	
}else{ 

$c = $str[$i]; 

	}
	 
if($i >= $enddd){

if(strlen($restr)+strlen($c)>$slen){break;

}else{ 

$restr .= $c; 

break; 

	} 

}

} 

return $restr; 

} 


}//end class

?>