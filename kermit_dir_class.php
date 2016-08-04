<?php

/*kermit:maker
 *the class to do with filedir
 *2012-8-9
 */

class do_dir{
	
	public $array=array();								//the file arr value
	
	public $value;										//the all use value;
	
	private $basepath;									//the base part of all file

//1,set the base path of all doing

public function __construct($path=''){
	
	if($path) $this->basepath=$path;	
	
	else $this->basepath=dirname(__FILE__).'/';
	
}

//2,used in the proceing when needed to change dir

public function change_dir($path){
	
	if($path) $this->basepath=$path;
	
	else exit();
	
}

//3,function to read the all dirs in a array from the given dirname 

function get_dir($dir){
	  
	!is_dir($dir) && exit('the dir is not exist');

    $dirArray[]=NULL;$i=0;

    if(false!=($handle=opendir($dir))){
		  
	 		while(false!==($file=readdir($handle))){  
              
					 if($file!="." && $file!= ".." &&!strpos($file,".")){
						   
						 $dirArray[$i]=$file;
						 
						 $i++;
					 
					 }
				 
         	}  
 
         	closedir ( $handle );  

     } 

	 if($dirArray[0]=='')$dirArray=array();	 

     return $dirArray;  

}      

//4,function to read the all files in a array from the given dirname   
 
function get_file($dir){
	
     $fileArray[]=NULL;  
     
	 if(false!=($handle=opendir($dir))){
		   
        	 $i=0;  
			 
			 while(false!==($file=readdir($handle))){  
	
				 if ($file!="." && $file!=".." && strpos($file,".")){
					   
					 $fileArray[$i]=$file;  
	 
					 $i++;
					   
				 }
				 
			 }  
		  
			 closedir($handle); 
			  
     }  
	 
	 if($fileArray[0]=='')  $fileArray=array();
     
	 return $fileArray;  

} 

//5,get the allfile size in the dir

function get_size($dir_file){
	
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

//6,change the filesize char

public function format_size($size){
	
		$kb=1024;
		
		$mb=$kb*1024;
		
		$gb=$mb*1024;
		
		$tb=$gb*1024;
		
		if($size<$kb)	return $size."B";
		
		if($size>=$kb and $size<$mb)	return round($size/$kb,2)."KB";
		
		if($size>=$mb and $size<$gb)	return round($size/$mb,2)."MB";
		
		if($size>=$gb and $size<$tb)	return round($size/$gb,2)."GB";
		
		if($size>=$tb)	return round($size/$tb,2)."TB";

}

//7,create dir only for one level

public function create_dir($dirname,$mode=0777){
	
			if(is_null($dirname) || $dirname=="") return false;
			
			if(!is_dir($dirname)){
				
				return mkdir($dirname,$mode);
			
			}

}

//8,create dirs for serval levels

public function createDir($dirs){
	
		$dirs = str_replace('\\', '/',$dirs);
		
		$dir = '';
		
		$arr = explode('/', $dirs);
		
		foreach ($arr as $str){
			
			$dir .= $str . '/';
			
			if (!file_exists($dir)) mkdir($dir);
			
		}

}

//9,delete a dir with all files

public function delete_dir($dirname){
	
		if($this->check_exist($dirname) and is_dir($dirname)){
			
				if(!$dirhandle=opendir($dirname)) return false;
				
				while(($file=readdir($dirhandle))!==false){
					
					if($file=="." or $file=="..")	continue;
					
					$file=$dirname.DIRECTORY_SEPARATOR.$file;  //表示$file是$dir的子目录
					
					if(is_dir($file)) $this->delete_dir($file);
	
					else unlink($file);
	
				}
				
				closedir($dirhandle);
				
				return rmdir($dirname);
				
		}
		
		else return false;

}



}//end class

?>
