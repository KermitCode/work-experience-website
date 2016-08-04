<?php
/*******************
功能：文件上传类文件
联系：kermit
日期：2012-01-09
邮箱：956952515@qq.com
*******************/

class Upload_Image{
	
	    private $formimg_name;             //上传文件表单项的名称
		
		private $allow_size;               //允许上传文件的大小
		
		private $allow_type;               //允许上传图片的类型总
		
		private $to_dir;                   //上传至的路径
		
		private $up_name;                  //上传的图片名
		
		private $up_type;                  //上传的图片类型
		
		private $up_tmpname;               //上传的图片临时文件名
		
		private $up_size;                  //上传的图片大小
		
		public $yes;                      //格式大小等判断结果
		
		public $newname;                  //图片新文件名
		
		public $dir_img;                  //类别对应的图片目录
		
		
		
public function getfile($formimg_name,$allow_size,$allow_type,$class){      //判断文件大小/类型
	
	$this->up_name=$_FILES[$formimg_name]["name"];
	
	$this->up_type=$_FILES[$formimg_name]["type"];
	
	$this->up_size=$_FILES[$formimg_name]["size"];
	
	$this->up_tmpname=$_FILES[$formimg_name]["tmp_name"];
	
	$this->gettodir($class);
	
	if(in_array($this->up_type,$allow_type)){
		
		if($this->up_size<=$allow_size){ 
		
		    $this->yes='yes';
		
			if(!is_dir($this->to_dir)) mkdir($this->to_dir);
	                            
								 }
		
		else $this->yes='文件大小超过限制';
		
	                                  }
									  
	else $this->yes='不支持此类型文件上传！';
	
}		
		
private function gettodir($class){//取得文件路径
	
	$class_array=array('美食','酒店','生活','购物','运动','休闲','丽人','婚嫁');
	
	$dirs_array=array('img_foods','img_hotel','img_life','img_shopping','img_sports','img_leisure','img_beauty','img_marry');
	 		
    $this->dir_img=$dirs_array[array_search($class,$class_array)];
 
	$this->to_dir="../image/".$this->dir_img.'/'.date("Y").'/';	
		
}

public function imgupload(){
	
	$newname=explode(".",$this->up_name);
	
	$newname=date("mdHis").rand(1,99).'.'.$newname[count($newname)-1];
	
    if(move_uploaded_file($this->up_tmpname,($this->to_dir).$newname)){return $this->dir_img.'/'.date("Y").'/'.$newname;}
	
	else return "wrong";
	
	}
	

		
		
		
		
}

?>
