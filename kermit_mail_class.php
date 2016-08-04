<?php

class Send_mail{
	
	private $mail_smtp_server;
	
	private $mail_smtp_duankou;
	
	private $mail_sendmail;
	
	private $mail_password;
	
	private $title,$content,$moban,$mailto;
	

	
	
//邮箱服务器、端口、发送邮箱、密码的基本配置
	
public function set_mail_set($mail_smtp_server,$mail_smtp_duankou,$mail_sendmail,$mail_password){
	
	if($this->mail_smtp_server)  return;
	
	else{
		
		$this->mail_smtp_server=$mail_smtp_server;
		
		$this->mail_smtp_duankou=$mail_smtp_duankou;
		
		$this->mail_sendmail=$mail_sendmail;
		
		$this->mail_password=$mail_password;
		
		}

}


//发送邮件的内容设置

public function set_mail_message($title,$content,$moban,$mailto){
	
	//$content要是数组格式来替换moban内容
		
	$this->title=$title;
	
	$this->moban=$moban;
	
	$this->mailto=$mailto;
	
	$handle=fopen("../inc/".$moban,"r"); 
	
    $moban=fread($handle,filesize("../inc/".$moban)); 
	
	fclose($handle);
	
	foreach($content as $key=>$array){
		
		$moban=str_replace($key,$array,$moban);
		
		}
	
	$this->content=$moban;

	}



//发送邮件

public function send_88mq_mail(){
	
	header('Content-Type: text/html; charset=gbk');
	
	require_once("class.mail.php");
			
	$smtp = new smtp($this->mail_smtp_server,$this->mail_smtp_duankou,true,$this->mail_sendmail,$this->mail_password);
	
	$smtp->debug = false;
		
	if($smtp->sendmail($this->mailto,$this->mail_sendmail,$this->title,$this->content,"HTML")){
		
		return 1;
			
			}
		
	else return 0;

		}
	
}









?>
