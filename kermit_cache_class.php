<?php
/*
* ������ BY kermit
* ��ϵ���䣺kermit2011@126.com
* ����ʱ�䣺2012-04-17
*/

class cache{

/***************************************************************************/

private $cacheRoot = "webcache/";				   	//���������Ŀ¼

private $cacheTime = 86400;						//������Чʱ��Ĭ��Ϊһ��,����5��

private $cacheName = "";						//�����ļ�����

private $cacheExt = "php";						//������չ��

public  $dofile='';								//��ǰִ���ļ���

//��Ҫ�����ļ��е������������Ҫ����

private $makearray=array('mq_profession',
						 'mq_industry',
						 'mq_enterprise',
						 'sec_other',
						 'pro_feeling',
						 'pro_know',
						 'work_course',
						 'work_salary',
						 'mq_working',
						 'mq_show',
						 'mq_city',
						 'mq_search',
						 'mq_register',
						 'mq_interview',
						 'life_plan',
						 'life_ceo',
						 'irt_enterprise',
						 'irt_profession',
						 'irt_industry',
						 'inter_skill',
						 'inter_course',
						 'indus_ranking',
						 'indus_news',
						 'enter_trend',
						 'enter_score',
						 'mq_analy',
						 'work_salary',
						 'irt_enterprise',
						 'irt_says');

//�����������ҳ������

private $not_cache=array('mq_image','mq_user','mq_search','irt_page','mq_register','mq_getpass');

public $cache_open=1;							//��ҳ���Ƿ������棬Ĭ�Ͽ���

/***************************************************************************/ 

public function cache($cacheTime='86400',$zifile='',$cacheRoot="webcache/"){
	
	//kermit:2012-11-2 auto clear cache files 
	
	if(rand(0,20)==1){
		
		$cachesize=intval($this->get_size($this->cacheRoot)/(1024*1024));
		
		if($cachesize>400) $this->clearCache('all');
		
		}

   intval($cacheTime) && $this->cacheTime=$cacheTime;
   
   $this->cacheRoot=$cacheRoot;
   
   $php_self=$_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
   
   $dofile=substr($php_self,strrpos($php_self,'/')+1,strpos($php_self,'.')-strrpos($php_self,'/')-1);
   
   $this->dofile=$dofile;

   if(in_array($dofile,$this->not_cache)){//������ļ����ó��˲����ɻ��棬�򷵻�
	   
	   $this->cache_open=0;
	   
	   return;
	   
	   }

   //�����ļ�������
   
   if($zifile!='') $this->cacheRoot=$this->cacheRoot.$zifile.'/';

   else if(in_array($dofile,$this->makearray) && $this->cacheRoot=="webcache/")$this->cacheRoot=$this->cacheRoot.$dofile.'/';
	 
   $url_string=$dofile.'.'.$_SERVER['QUERY_STRING'];
	 
   $delarray=array('/','.','?','=','&','*','#','~',':',';'.'<'.'>'.'��'.'��'.'@'.'$'.'%'.'^'.' ');
   
   $this->cacheName=$this->cacheRoot.str_replace($delarray,'-',$url_string).".".$this->cacheExt;

   ob_start();

}

//һЩ���ݺ�̨���õ��ļ���Ҫͨ�������ر��Ѿ������˵Ļ���

public function closecache($not_cache){
	
	if(isset($not_cache[$this->dofile]) && $not_cache[$this->dofile]!=1){//ֻ���������û��ɲ鿴״̬�ſ�������
	
			$this->cache_open=0;
	
			ob_end_flush();
			
			}
	
}
 
public function cacheCheck(){//check the cache is or not in
   
   if(file_exists($this->cacheName)){
	      
   $cTime = intval(filemtime($this->cacheName));
   
   if( $cTime + $this->cacheTime > time() ) {
	   
   echo file_get_contents( $this->cacheName );
   
   ob_end_flush();
   
   exit;}					
   
   			}
										
   return false;
   
}


public function caching($staticFileName=""){//do cache
   
   if($this->cacheName){
	   
   $cacheContent=ob_get_contents();

   ob_end_flush();

   if($staticFileName){
	   
   $this->saveFile($staticFileName,$cacheContent);
   
  					 }

   if($this->cacheTime) $this->saveFile( $this->cacheName,$cacheContent);
   
  							 }
   
}  

public function clearCache($fileName='all'){//clear cache  

   if(strtolower($fileName)=='all'){//������л��棬��������ļ���   		
   
   		$dir=@opendir($this->cacheRoot);
		
  		while($file=@readdir($dir)){
			
			if($file!='.' && $file!='..'){

   				if(is_file($this->cacheRoot.$file)) @unlink($this->cacheRoot.$file);
   
				else{
				
					$dir1=@opendir($this->cacheRoot.$file.'/');
				
				    while($file1=@readdir($dir1)){
					 
					if($file!='.' && $file!='..') @unlink($this->cacheRoot.$file.'/'.$file1);}	
						
					} 					
			
										  }
										  
									}
									
  		 @closedir( $dir );
   
   		 return true;
   
   }
	
   if(is_dir($this->cacheRoot.$fileName.'/')){//����ļ���
   
   	   $dir=@opendir($this->cacheRoot.$fileName.'/');
   
   	   while($file=@readdir($dir)){
						
			if($file!='.' && $file!='..') @unlink($this->cacheRoot.$fileName.'/'.$file);
						
			}
			
      return true;
	   
   }
	   	   
   if(file_exists($this->cacheRoot.$fileName)){//����ļ�
		
		return @unlink($this->cacheRoot.$fileName );
		
   }
	   
}

function saveFile($fileName,$text){//save file
   
   if(!$fileName || !$text)return false;

   if($this->makeDir(dirname($fileName))){

   		if($fp = fopen( $fileName, "w+" ) ) {
	   
   				if(@fwrite($fp,$text)){
	   
  					fclose($fp);
   
   					return true;
  				
				}else {
					
  				fclose($fp);
   				
				return false;
   
   				}
   
   											}
											
   										}
										
   return false;
   
}

function makeDir($dir){//create dir
  
   if(!$dir) return 0;

   $dir = str_replace( "\\", "/", $dir );
  
   $mdir = "";
   
   foreach( explode( "/", $dir ) as $val ) {
	   
   		$mdir .= $val."/";
   
   		if( $val == ".." || $val == "." || trim( $val ) == "" ) continue;
  
  		if( ! file_exists( $mdir ) ) {
	   
   			if(!@mkdir( $mdir)){
	   
   				return false;
  
  			 }
   		
		}
   }
   
   return true;
   
}

public function chan_clear($dir){
	
	$this->cacheRoot=$dir;
	
	$this->clearCache('all');
	
}

//kermit:2012-11-2 add for clear cache auto

public function get_size($dir_file){
	
	if(!file_exists($dir_file) or !is_dir($dir_file)) exit('the error file or dir');
	
	if(is_file($dir_file)) return filesize($dir_file);
	
	$handle=opendir($dir_file);
	
	$size=0;
	
	while(false!==($file=readdir($handle))){
		
			if($file=="." or $file=="..") continue;
			
			$file=$dir_file."/".$file;
			
			if(is_dir($file)){
				
				$size+=$this->get_size($file);
			
			}else{
				
				$size+=filesize($file);
			
			}

	}
	
	closedir($handle);
	
	return $size;

}


}//end the class


?>


