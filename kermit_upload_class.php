<?php
/*******************
���ܣ��ļ��ϴ����ļ�
��ϵ��kermit
���ڣ�2012-01-09
���䣺956952515@qq.com
*******************/

class Upload_Image{
	
	    private $formimg_name;             //�ϴ��ļ����������
		
		private $allow_size;               //�����ϴ��ļ��Ĵ�С
		
		private $allow_type;               //�����ϴ�ͼƬ��������
		
		private $to_dir;                   //�ϴ�����·��
		
		private $up_name;                  //�ϴ���ͼƬ��
		
		private $up_type;                  //�ϴ���ͼƬ����
		
		private $up_tmpname;               //�ϴ���ͼƬ��ʱ�ļ���
		
		private $up_size;                  //�ϴ���ͼƬ��С
		
		public $yes;                      //��ʽ��С���жϽ��
		
		public $newname;                  //ͼƬ���ļ���
		
		public $dir_img;                  //����Ӧ��ͼƬĿ¼
		
		
		
public function getfile($formimg_name,$allow_size,$allow_type,$class){      //�ж��ļ���С/����
	
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
		
		else $this->yes='�ļ���С��������';
		
	                                  }
									  
	else $this->yes='��֧�ִ������ļ��ϴ���';
	
}		
		
private function gettodir($class){//ȡ���ļ�·��
	
	$class_array=array('��ʳ','�Ƶ�','����','����','�˶�','����','����','���');
	
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
