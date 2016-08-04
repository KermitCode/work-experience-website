<?php

/*
 *ͼƬ�ϴ���-��ִ�а�λ�ü�ͼƬˮӡ
 *kermit 2012-6-12
 */


class upimg_water{
	
	public $imgpath;								//�õ���ͼƬ��Ŀ��洢·��
	
	private $maxsize=512000;						//�ϴ��ļ���С����, Ĭ��Ϊ500KB
	
	private $watermark=1;      						//�Ƿ��ˮӡ(1Ϊ��ˮӡ,����Ϊ����)
	
	private $waterpos=4;   			    			//ˮӡλ��(1Ϊ���½�,2Ϊ���½�,3Ϊ���Ͻ�,4Ϊ���Ͻ�,5Ϊ����);
	
	private $wateralpha=60;   			    		//ˮӡλ��(1Ϊ���½�,2Ϊ���½�,3Ϊ���Ͻ�,4Ϊ���Ͻ�,5Ϊ����);

	private $waterimg="2.gif";  				    //ˮӡͼƬ
		
	private $uptypes=array('image/jpg', 'image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
	
	//�ϴ�ͼƬ������

public function __construct($watermark='',$waterimg='',$waterpos='',$maxsize='',$wateralpha='',$uptypes=''){
	
	$args_arr=func_get_args();
	
	$args_array=array('watermark','waterimg','waterpos','maxsize','wateralpha','uptypes');
	
	foreach($args_arr as $key=>$value){
		
		if($value!='') $this->$args_array[$key]=$value;
	
		}//end foreach
		
	unset($args_arr,$args_array,$key,$value);
	
}//end function--1


public function getimg_savepath(){
	
	$monthnum=date("n")>6?'02':'01';

	$this->imgpath=ROOT_PATH."upload_img/".date("Y").$monthnum.'/';
	
	if(!file_exists($this->imgpath)) mkdir($this->imgpath);

	return $this->imgpath;
		
}//end function--2


public function upload_imgfile($name){
	
	//����(�������,ͼƬ��name)-�ϴ�ͼƬ-����ͼƬ·��
	
	if($name=='' || !is_uploaded_file($_FILES[$name]['tmp_name'])) return;
		
	//$_SERVER['REQUEST_METHOD']!='POST' && exit('hack!');

	$imagefile=$_FILES[$name];
	
	if($this->maxsize<$imagefile["size"]) exit("�ļ���С��������!");

  	if(!in_array($imagefile["type"],$this->uptypes)) exit("�ļ�����{$imagefile['type']}����!");
        
	$img_path=$this->getimg_savepath();

	$file_name=$imagefile["name"];
	
	if(file_exists($img_path.$file_name)){//�ļ���������Ҫ����
		
		$return_back=$img_path.date("mdHis").rand(1,99).substr($file_name,strrpos($file_name,'.'));
		
	}else $return_back=$img_path.$file_name;
	
	//ִ��ͼƬ�ϴ�����
	
	if(!move_uploaded_file($imagefile["tmp_name"],$return_back)) exit("ͼƬ�ϴ�����");
	
	if($this->watermark && is_file($this->waterimg)){//���ϴ���ͼƬ��ˮӡ

		$this->make_water($return_back);
			
		}
		
	return $return_back;

}//end function--3


public function create_imgfile($imgname,$imgtype,$class=1,$imgfile=''){
	
	//��$classֵ��1������imgname����������ͼ�� 0��imgfileͼ��������������
	
	switch($imgtype){
		
		case 1:if($class) return imagecreatefromgif($imgname);
			   else imagejpeg($imgfile,$imgname);break;
			   
		case 2:if($class) return imagecreatefromjpeg($imgname);
			   else imagejpeg($imgfile,$imgname);break;
			   
		case 3:if($class) return imagecreatefrompng($imgname);
			   else imagepng($imgfile,$imgname);break;
			   
		case 6:if($class) return imagecreatefromwbmp($imgname);
			   else imagewbmp($imgfile,$imgname);break;
			   
		default:exit("��֧�ֵ��ļ�����");

		}

}//end function 4
	
	
public function make_water($img){

	list($width,$height,$type, $attr)=getimagesize($img);
	
	$nimage=imagecreatetruecolor($width,$height);
    
	$white=imagecolorallocate($nimage,255,255,255);
    
	$black=imagecolorallocate($nimage,0,0,0);
    
	$red=imagecolorallocate($nimage,255,0,0);
    
	imagefill($nimage,0,0,$white);
	
	$simage=$this->create_imgfile($img,$type,1);

    imagecopy($nimage,$simage,0,0,0,0,$width,$height);
	
    imagefilledrectangle($nimage,1,$width-15,80,$height,$white);

    $simage1=imagecreatefromgif($this->waterimg);
	
	list($width_sy,$height_sy,$type_sy,$attr)=getimagesize($this->waterimg);
	
	$waterxy=$this->getPosxy($width,$height,$width_sy,$height_sy);
    
	//imagecopy($nimage,$simage1,$waterxy['x'],$waterxy['y'],0,0,$width_sy,$height_sy);
	imagecopymerge($nimage,$simage1,$waterxy['x'],$waterxy['y'],0,0,$width_sy,$height_sy,$this->wateralpha);
    
	imagedestroy($simage1);

    $this->create_imgfile($img,$type,0,$nimage);
      
    imagedestroy($nimage);
    
	imagedestroy($simage);
	
}//end function--4 


public function getPosxy($wd1,$hd1,$wd2,$hd2){
	
	$this->waterpos==5 && $this->waterpos=rand(1,4);
	
	//����ˮӡ�ĳ�ʼXY����ֵ
	
	 switch($this->waterpos){
		  
			case 1://1Ϊ���Ͻ� 
				$pos['x']=0;$pos['y']=0;break; 
				
			case 2://2Ϊ���Ͻ� 
				$pos['x']=$wd1-$wd2;$pos['y']=0;break; 
				
			case 3://3Ϊ���½� 
				$pos['x']=0; $pos['y']=$hd1-$hd2;break;
				 
			case 4://4Ϊ���½� 
				$pos['x']=$wd1-$wd2;$pos['y']=$hd1-$hd2;break;
				
			case 6://���λ�� 
				$pos['x']= rand(0,($wd1-$wd2));$pos['y']=rand(0,($hd1-$hd2));break;
				
			default:$pos['x']=0;$pos['y']=0;break;
    	
		}
	
	return $pos;
		
}//end function--5


public function create_slt($img,$maxwidth=200,$maxheight=150,$ratio=0){
	
		list($width,$height,$type,$attr)=getimagesize($img);

		$im=$this->create_imgfile($img,$type,1);
		
		$newpic=$this->getslv_name($img);
	
		if($ratio!=0){//���ʲ�Ϊ0�򰴱�����СͼƬ
		
			$newwidth=$width*$ratio;
			
			$newheight=$height*$ratio;
			
		}else{//�����ʸ߿�ѡȡ
				
				if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight)){
				
						if($maxwidth && $width>$maxwidth){$widthratio=round(($maxwidth/$width),3);$RESIZEWIDTH=true;}
						
						if($maxheight && $height>$maxheight){$heightratio=round(($maxheight/$height),3);$RESIZEHEIGHT=true;}

						if($RESIZEWIDTH && $RESIZEHEIGHT){
							
							if($widthratio<$heightratio) $ratio = $widthratio;
							
							else $ratio=$heightratio;
							
						}elseif($RESIZEWIDTH){$ratio = $widthratio;
					
						}elseif($RESIZEHEIGHT){$ratio = $heightratio;
						
						}
				
				}else{//��С�ޱ仯
	
						$ratio=1;
						
				}
				
		}//�ó���ͼƬ��/�����С����
		
		$newwidth=$width*$ratio; $newheight=$height*$ratio;
				
	   if(function_exists("imagecopyresampled")){
	
	  		   $newim = imagecreatetruecolor($newwidth,$newheight);
	  
	  		   imagecopyresampled($newim,$im, 0, 0, 0, 0,$newwidth,$newheight,$width,$height);
  
	   }else{

			   $newim = imagecreate($newwidth,$newheight);
		
			   imagecopyresized($newim,$im, 0, 0, 0, 0,$newwidth,$newheight,$width,$height);

	   }
						
		ImageJpeg($newim,$newpic);

		ImageDestroy($newim);

	return $newpic;
	
}//end function--6


//��ȡ����ͼ����

public function getslv_name($imgname){
	
	$pos=strrpos($imgname,'.');
	
	return substr($imgname,0,$pos).'_slt'.substr($imgname,$pos);
	
	}//end function--7


//��ͼƬ��Сȫ������400*300px��С,����ͼƬ������	
	
public function change_size($img,$maxwidth=400,$maxheight=300,$rgb=array(150,220,180)){

		list($width,$height,$type,$attr)=getimagesize($img);
		
		list($red,$green,$blue)=$rgb;
	
		$widthratio=$heightratio=1;
		
		if($width>$maxwidth){$widthratio=($maxwidth/$width);}
				
		if($height>$maxheight){$heightratio=($maxheight/$height);}
	
		$ratio=$widthratio<$heightratio?$widthratio:$heightratio;
		
		$newwidth=$width*$ratio; $newheight=$height*$ratio;
		
		$dst_x=($maxwidth-$newwidth)/2;
		
		$dst_y=($maxheight-$newheight)/2;
		
		$im=$this->create_imgfile($img,$type,1);
				
	    if(function_exists("imagecopyresampled")){
	
	  		   $newim=imagecreatetruecolor($maxwidth,$maxheight);
			   
			   $color=imagecolorallocate($newim,$red,$green,$blue);
			   
			   imagefill($newim,0,0,$color);
	  
	  		   imagecopyresampled($newim,$im,$dst_x,$dst_y,0,0,$newwidth,$newheight,$width,$height);
  
	    }else{

			   $newim = imagecreate($maxwidth,$maxheight);
			   
			   $color=imagecolorallocate($newim,$red,$green,$blue);

			   imagefill($newim,0,0,$color);
		
			   imagecopyresized($newim,$im,$dst_x,$dst_y,0,0,$newwidth,$newheight,$width,$height);

	    }
						
		ImageJpeg($newim,$img);

		ImageDestroy($newim);

	return $img;
	
}	

	
}//end class


/*/����
$action=isset($_GET['action'])?$_GET['action']:'';
if($action=='upimg'){//�ϴ�	
$upimg_water=new upimg_water();
$newimg=$upimg_water->upload_imgfile("upfile");
echo "<img src='{$newimg}'>";

<form enctype="multipart/form-data" method="post" name="upform" action="kermit_image_water.php?action=upimg">
  �ϴ��ļ�:
  <input name="upfile" type="file">
  <input type="submit" value="�ϴ�">
</form>
}
*/


?>