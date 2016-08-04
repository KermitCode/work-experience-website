<?php
/*****************
*php���ɾ�̬
*Kermit 2012-4-20
*lylboy@126.com
*************/

if(!defined("ROOT_PATH")) exit('ROOT_PATH is not defined!');

//error_reporting(0);

class tohtml{
	
/********************************************************************************///settting
	
	private $template;						                               //ģ���ļ�����·��
	
	private $filepath;			  							  			   //��̬ҳ�����ļ���
	
	private $file_str='mq';												   //��̬�ļ�����ǰ׺
	
	private $file_page=1000;											   //�����ַ���һƪ����

	public $html_page;													   //���ɵľ�̬ҳ���Ƽ���ַ�����ݿ��д�ŵģ�
		
/****************************************************************************///endsetting
	
//��Ҫ�ı�����ִ�д˺���
	
public function tohtml($template='',$filepath=''){
	
	if($template!='' && is_file($template)) $this->template=$template;
	
	else $this->template=ROOT_PATH.'inc/page_moban.html';
	
	if($filepath!='' && is_dir($filepath)) $this->filepath=$filepath;
	
	else $this->filepath=ROOT_PATH."pages/";
	
}

//��ҳ�ַ��� 
 
public function pagestr($all,$pg,$id){
	
	$pagechar='';$char='';$achar='';
	
	for($i=1;$i<=$all;$i++){
		
		if($i==1) $char=$this->file_str."{$id}.html";
		
		else $char=$this->file_str."{$id}-{$i}.html";
		
		if($i==$pg) $achar="<a class=\"secl\">";
		
		else $achar="<a href=\"{$char}\" >";
		
		$pagechar.=$achar.$this->pgstr($i)."</a>";
		
		}
		
	$pagechar.="<a href='/irt_page-{$id}.html' style='border:0px;'>�鿴ȫ��</a>";
		
	return $pagechar;
	
	}
	

//��ҳ��ʾ�ַ�
	
public function pgstr($i){
	
	switch($i){
		
		case 1:return '��һҳ';
		
		case 2:return '�ڶ�ҳ';
		
		case 3:return '����ҳ';
		
		case 4:return '����ҳ';
		
		case 5:return '����ҳ';
		
		case 6:return '����ҳ';
		
		case 7:return '����ҳ';
		
		case 8:return '�ڰ�ҳ';
		
		case 9:return '�ھ�ҳ';
		
		case 10:return '��ʮҳ';}
		
}
	
//һ�����ִ�����ɾ�̬�ļ�

public function onetohtml($data){
	
	if(isset($data['pg_html']) && $data['pg_html']!=''){//�������ɾ�̬�ļ�

			$dbfilename=substr($data['pg_html'],0,strrpos($data['pg_html'],'/')+1);
		
	}else{
		
			$dbfilename=$data['pg_class'].'/';	
			
			if(!is_dir($this->filepath.$dbfilename)) mkdir($this->filepath.$dbfilename);
			
			$dbfilename.=date("Y").'/';
			
			if(!is_dir($this->filepath.$dbfilename)) mkdir($this->filepath.$dbfilename);
	
	}
		
	//��ȡģ���ļ�
	
	$content=file_get_contents($this->template);
	
	$content=str_replace("<///textarea>","</textarea>",$content);
	
	if(strpos($data['pg_text'],'||||')){//�з�ҳ����

		//ģʽƥ�����ҳ����
		
		$pattern = "/<div>[\s\v]+[||||]+[\s\v]+<\/div>/i";

		$data['pg_text']=preg_replace($pattern,'||||',$data['pg_text']);

		$pattern = "/<p>[\s\v]+[||||]+[\s\v]+<\/p>/i";
		
		$data['pg_text']=preg_replace($pattern,'||||',$data['pg_text']);
		
	    //����ƥ���ҳ����
		
		$con_arr=explode('||||',$data['pg_text']);
		
		for($j=1;$j<=count($con_arr);$j++){
			
			$contents=$content;
			
			$data['pg_text']=$con_arr[$j-1];
			
			//ԭ�����½��м�����ʾ��
			
			if($data['pg_type']){ 
			
			$data['pg_text'].="<div class='yuchuan'>����Ϊ�����ڱ�վԭ�����ݣ����������߼���վ��Ȩ��ת����ע��������Դ��<a href='www.mqwork.com'>��������</a>��<a href='www.mqwork.com'>http://www.mqwork.com</a></div>";}
			
			//����ԭ�����²���
			
			$data['pg_pageschar']=$this->pagestr(count($con_arr),$j,$data['pg_id']);
			
			$key_all=array_keys($data);
			
			$file_na=($j==1)?$this->file_str."{$data['pg_id']}.html":$this->file_str."{$data['pg_id']}-{$j}.html";			
				
				for($i=0;$i<count($key_all);$i++){
		
				$keyname=$key_all[$i];
		
				$contents=str_replace('{'.$keyname.'}',stripslashes($data[$keyname]),$contents);}				
						
				$handle=fopen($this->filepath.$dbfilename.$file_na,'wb');

				fwrite($handle,$contents);

				fclose($handle);
			
			}
				
		$dbfilename=$dbfilename.$this->file_str.$data['pg_id'].'.html';	
				
	}else{//�Ƿ�ҳ����ֱ������
	
		$data['pg_pageschar']='';
				
		$key_all=array_keys($data);	
		
		$dbfilename=$dbfilename.$this->file_str.$data['pg_id'].'.html';
		
		//ԭ�����½��м�����ʾ��
			
		if($data['pg_type']){ 
			
		$data['pg_text'].="<div class='yuchuan'>����Ϊ�����ڱ�վԭ�����ݣ����������߼���վ��Ȩ��ת����ע��������Դ��<a href='http://www.mqwork.com'>��������</a>��<a href='http://www.mqwork.com'>http://www.mqwork.com</a></div>";}
			
		//����ԭ�����²���
	
		for($i=0;$i<count($key_all);$i++){
		
			$keyname=$key_all[$i];
		
			$content=str_replace('{'.$keyname.'}',$data[$keyname],$content);
		
			}//�ļ�д��
		
		$handle=@fopen($this->filepath.$dbfilename,'wb');

		@fwrite($handle,$content);

		@fclose($handle);
		
	}	
		
	return $dbfilename;	
		
}

 
//��ҳ�����ɾ�̬ 	

public function alltoShtml($data){
	
	foreach($data as $row) $this->onetohtml($row);		
	
}



}//����class


?>

