<?php
/*
maker:kermit
date:2011-11-24
notes:main function of web develop
email:kermit2011@126.com
*/

class otherfun{

/*********************************************************************/

	private $value;                          //定义传递值
	
	public static $ip='';                             //静态定义IP地址
	
	private $c,$delchar,$message,$url,$refresh,$type,$idyes;

    private $length,$char,$max,$min;	
	
/*********************************************************************/	
	
//转码函数

public function safeEncoding($string,$outEncoding='UTF-8'){  
    
	$encoding = "UTF-8";
    
	for ($i = 0; $i < strlen($string); $i++) {   
       
	    if(ord($string{$i}) < 128) continue;
		   
        if((ord($string{$i}) & 224)==224){
			   
            $char = $string{++$i};//第一个字节判断通过 
			   
            if ((ord($char) & 128) == 128){//第二个字节判断通过  
                  
                $char = $string{++$i};
				
                if((ord($char) & 128)==128){
					   
                    $encoding = "UTF-8";break;   
               
			    }   
            
			}   
        
		}   
       if((ord($string{$i}) & 192) == 192){//第一个字节判断通过   
               
            $char = $string{++$i};
			
            if ((ord($char) & 128) == 128){//第二个字节判断通过   
                   
                $encoding = "GB2312";   
                
				break; 
				  
            }   
        
		}   
    
	}   
  
    if(strtoupper($encoding) == strtoupper($outEncoding)) return $string;   
    
	else return iconv($encoding,$outEncoding, $string);  
	 
}//end function











	
}//end class



?>