<?php

class Send_mail{
	
	private $mail_smtp_server;
	
	private $mail_smtp_duankou;
	
	private $mail_sendmail;
	
	private $mail_password;
	
	private $title,$content,$moban,$mailto;
	

	
	
//������������˿ڡ��������䡢����Ļ�������
	
public function set_mail_set($mail_smtp_server,$mail_smtp_duankou,$mail_sendmail,$mail_password){
	
	if($this->mail_smtp_server)  return;
	
	else{
		
		$this->mail_smtp_server=$mail_smtp_server;
		
		$this->mail_smtp_duankou=$mail_smtp_duankou;
		
		$this->mail_sendmail=$mail_sendmail;
		
		$this->mail_password=$mail_password;
		
		}

}


//�����ʼ�����������

public function set_mail_message($title,$content,$moban,$mailto){
	
	//$contentҪ�������ʽ���滻moban����
		
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



//�����ʼ�

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
