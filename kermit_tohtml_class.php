<?php
/*****************
*php生成静态
*Kermit 2012-4-20
*lylboy@126.com
*************/

if(!defined("ROOT_PATH")) exit('ROOT_PATH is not defined!');

//error_reporting(0);

class tohtml{
	
/********************************************************************************///settting
	
	private $template;						                               //模板文件名及路径
	
	private $filepath;			  							  			   //静态页面主文件夹
	
	private $file_str='mq';												   //静态文件名称前缀
	
	private $file_page=1000;											   //多少字符算一篇文章

	public $html_page;													   //生成的静态页名称及地址（数据库中存放的）
		
/****************************************************************************///endsetting
	
//如要改变设置执行此函数
	
public function tohtml($template='',$filepath=''){
	
	if($template!='' && is_file($template)) $this->template=$template;
	
	else $this->template=ROOT_PATH.'inc/page_moban.html';
	
	if($filepath!='' && is_dir($filepath)) $this->filepath=$filepath;
	
	else $this->filepath=ROOT_PATH."pages/";
	
}

//分页字符串 
 
public function pagestr($all,$pg,$id){
	
	$pagechar='';$char='';$achar='';
	
	for($i=1;$i<=$all;$i++){
		
		if($i==1) $char=$this->file_str."{$id}.html";
		
		else $char=$this->file_str."{$id}-{$i}.html";
		
		if($i==$pg) $achar="<a class=\"secl\">";
		
		else $achar="<a href=\"{$char}\" >";
		
		$pagechar.=$achar.$this->pgstr($i)."</a>";
		
		}
		
	$pagechar.="<a href='/irt_page-{$id}.html' style='border:0px;'>查看全文</a>";
		
	return $pagechar;
	
	}
	

//分页显示字符
	
public function pgstr($i){
	
	switch($i){
		
		case 1:return '第一页';
		
		case 2:return '第二页';
		
		case 3:return '第三页';
		
		case 4:return '第四页';
		
		case 5:return '第五页';
		
		case 6:return '第六页';
		
		case 7:return '第七页';
		
		case 8:return '第八页';
		
		case 9:return '第九页';
		
		case 10:return '第十页';}
		
}
	
//一条结果执行生成静态文件

public function onetohtml($data){
	
	if(isset($data['pg_html']) && $data['pg_html']!=''){//不新生成静态文件

			$dbfilename=substr($data['pg_html'],0,strrpos($data['pg_html'],'/')+1);
		
	}else{
		
			$dbfilename=$data['pg_class'].'/';	
			
			if(!is_dir($this->filepath.$dbfilename)) mkdir($this->filepath.$dbfilename);
			
			$dbfilename.=date("Y").'/';
			
			if(!is_dir($this->filepath.$dbfilename)) mkdir($this->filepath.$dbfilename);
	
	}
		
	//读取模板文件
	
	$content=file_get_contents($this->template);
	
	$content=str_replace("<///textarea>","</textarea>",$content);
	
	if(strpos($data['pg_text'],'||||')){//有分页符号

		//模式匹配掉分页符号
		
		$pattern = "/<div>[\s\v]+[||||]+[\s\v]+<\/div>/i";

		$data['pg_text']=preg_replace($pattern,'||||',$data['pg_text']);

		$pattern = "/<p>[\s\v]+[||||]+[\s\v]+<\/p>/i";
		
		$data['pg_text']=preg_replace($pattern,'||||',$data['pg_text']);
		
	    //结束匹配分页符号
		
		$con_arr=explode('||||',$data['pg_text']);
		
		for($j=1;$j<=count($con_arr);$j++){
			
			$contents=$content;
			
			$data['pg_text']=$con_arr[$j-1];
			
			//原创文章进行加字显示：
			
			if($data['pg_type']){ 
			
			$data['pg_text'].="<div class='yuchuan'>本文为网友在本站原创内容，请尊重作者及本站版权，转载请注明文章来源：<a href='www.mqwork.com'>名企工作网</a>　<a href='www.mqwork.com'>http://www.mqwork.com</a></div>";}
			
			//结束原创文章操作
			
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
				
	}else{//非分页操作直接生成
	
		$data['pg_pageschar']='';
				
		$key_all=array_keys($data);	
		
		$dbfilename=$dbfilename.$this->file_str.$data['pg_id'].'.html';
		
		//原创文章进行加字显示：
			
		if($data['pg_type']){ 
			
		$data['pg_text'].="<div class='yuchuan'>本文为网友在本站原创内容，请尊重作者及本站版权，转载请注明文章来源：<a href='http://www.mqwork.com'>名企工作网</a>　<a href='http://www.mqwork.com'>http://www.mqwork.com</a></div>";}
			
		//结束原创文章操作
	
		for($i=0;$i<count($key_all);$i++){
		
			$keyname=$key_all[$i];
		
			$content=str_replace('{'.$keyname.'}',$data[$keyname],$content);
		
			}//文件写入
		
		$handle=@fopen($this->filepath.$dbfilename,'wb');

		@fwrite($handle,$content);

		@fclose($handle);
		
	}	
		
	return $dbfilename;	
		
}

 
//多页面生成静态 	

public function alltoShtml($data){
	
	foreach($data as $row) $this->onetohtml($row);		
	
}



}//结束class


?>

