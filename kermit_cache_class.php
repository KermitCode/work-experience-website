<?php
/*
* 缓存类 BY kermit
* 联系邮箱：kermit2011@126.com
* 创建时间：2012-04-17
*/

class cache{

/***************************************************************************/

private $cacheRoot = "webcache/";				   	//缓存整体根目录

private $cacheTime = 86400;						//缓存有效时间默认为一天,最少5秒

private $cacheName = "";						//缓存文件名称

private $cacheExt = "php";						//缓存扩展名

public  $dofile='';								//当前执行文件名

//需要生存文件夹的在这里；此项需要配置

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

//不开启缓存的页面设置

private $not_cache=array('mq_image','mq_user','mq_search','irt_page','mq_register','mq_getpass');

public $cache_open=1;							//此页面是否开启缓存，默认开启

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

   if(in_array($dofile,$this->not_cache)){//如果此文件设置成了不生成缓存，则返回
	   
	   $this->cache_open=0;
	   
	   return;
	   
	   }

   //缓存文件夹名称
   
   if($zifile!='') $this->cacheRoot=$this->cacheRoot.$zifile.'/';

   else if(in_array($dofile,$this->makearray) && $this->cacheRoot=="webcache/")$this->cacheRoot=$this->cacheRoot.$dofile.'/';
	 
   $url_string=$dofile.'.'.$_SERVER['QUERY_STRING'];
	 
   $delarray=array('/','.','?','=','&','*','#','~',':',';'.'<'.'>'.'《'.'》'.'@'.'$'.'%'.'^'.' ');
   
   $this->cacheName=$this->cacheRoot.str_replace($delarray,'-',$url_string).".".$this->cacheExt;

   ob_start();

}

//一些根据后台设置的文件需要通过此来关闭已经启用了的缓存

public function closecache($not_cache){
	
	if(isset($not_cache[$this->dofile]) && $not_cache[$this->dofile]!=1){//只有在任意用户可查看状态才开启缓存
	
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

   if(strtolower($fileName)=='all'){//清除所有缓存，但不清除文件夹   		
   
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
	
   if(is_dir($this->cacheRoot.$fileName.'/')){//清除文件夹
   
   	   $dir=@opendir($this->cacheRoot.$fileName.'/');
   
   	   while($file=@readdir($dir)){
						
			if($file!='.' && $file!='..') @unlink($this->cacheRoot.$fileName.'/'.$file);
						
			}
			
      return true;
	   
   }
	   	   
   if(file_exists($this->cacheRoot.$fileName)){//清除文件
		
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


