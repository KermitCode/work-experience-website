<?php
/*
maker:kermit
date:2011-11-24
notes:main function of web develop
email:kermit2011@126.com
*/

class otherfun{

/*********************************************************************/

	private $value;                          //���崫��ֵ
	
	public static $ip='';                             //��̬����IP��ַ
	
	private $c,$delchar,$message,$url,$refresh,$type,$idyes;

    private $length,$char,$max,$min;	
	
/*********************************************************************/	
	
//ת�뺯��

public function safeEncoding($string,$outEncoding='UTF-8'){  
    
	$encoding = "UTF-8";
    
	for ($i = 0; $i < strlen($string); $i++) {   
       
	    if(ord($string{$i}) < 128) continue;
		   
        if((ord($string{$i}) & 224)==224){
			   
            $char = $string{++$i};//��һ���ֽ��ж�ͨ�� 
			   
            if ((ord($char) & 128) == 128){//�ڶ����ֽ��ж�ͨ��  
                  
                $char = $string{++$i};
				
                if((ord($char) & 128)==128){
					   
                    $encoding = "UTF-8";break;   
               
			    }   
            
			}   
        
		}   
       if((ord($string{$i}) & 192) == 192){//��һ���ֽ��ж�ͨ��   
               
            $char = $string{++$i};
			
            if ((ord($char) & 128) == 128){//�ڶ����ֽ��ж�ͨ��   
                   
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