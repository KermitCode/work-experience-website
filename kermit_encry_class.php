<?php

/*
 *Encryption and decryption function
 *kermit:2012-7-17
 */


class encry_decry{
	
	public $value;						//the value need to done
	
	public $key='';						//the encrypt key value
	

public function __construct($key=''){
		
		if($key!='') $this->key=$key;
		
		else $this->key='kermit_md5_key';
	
}


private function get_iv(){
	
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		
		return mcrypt_create_iv($iv_size, MCRYPT_RAND);
	
}


public function encry_val($value){
	
		if($value=='') exit('error:the value encrypted is null');
		
		$crypt_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_256,$this->key,$value, MCRYPT_MODE_ECB,$this->get_iv());
		
		$crypt_text=base64_encode($crypt_text);
		
		return $crypt_text;

}


public function decry_val($value,$type=0){
		
		if($value=='') exit('error:the value decrypted is null');
		
		$type && $value=$this->deliv_browser($value);
		
		$value=base64_decode($value);

		$value=mcrypt_decrypt(MCRYPT_RIJNDAEL_256,$this->key,$value, MCRYPT_MODE_ECB,$this->get_iv());
	
		return $value;

}


private function deliv_browser($value){
	
	//found by me:deliveried by browser need to add function :kermit
	
	return 	str_replace("%2B","+",$value);
	
}

	
}//end class


/*test:
$encry_decry=new encry_decry();
$text='test password';
echo $text.'<br><br>';
$value=$encry_decry->encry_val($text);
echo $value.'<br><br>';
$value=$encry_decry->decry_val($value);
echo $value.'<br><br>';
*/


?>