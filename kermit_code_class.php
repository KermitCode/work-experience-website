<?php

/**
 *������֤��r ���ļ�
 *kermit-2012-6-20
 */
@session_start();

class makecode{
	
	private $codetype;					//��֤����� 1����λ���� 2����ĸ  3����ĸ������ 4��������֤��
	
	private $area=array(40,18);			//��֤��ĳ�������
	
	private $codenum;					//��֤��λ��
	
public function makecode($codetype=1,$codenum=4,$area_wid=40,$area_heig=18){
	
	//if(!isset($_SESSION)) exit('session is not start!');
	
	$this->codetype=$codetype;
	
	$this->codenum=$codenum;
	
	if($area_wid && $area_heig){$this->area=array($area_wid,$area_heig);}
	
}//end function--1

public function createcode(){
	
	$codetype=$this->codetype;
	
	$codenum=$this->codenum;

	switch($codetype){
		
			case 1:$codechar=$this->makechar_num($codenum);break;
			
			case 2:$codechar=$this->makechar_letter($codenum);break;
			
			case 3:$codechar=$this->makechar_mix($codenum);break;
			
			case 4:$codechar=$this->makechar_chinese($codenum);break;
			
			default:$codechar=$this->makechar_num($codenum);break;
		
	}
	
	ob_clean(); //�ؼ����룬��ֹ����""ͼ�����䱾���д��޷���ʾ""����Ŀ
	
	header("Content-Type:image/png");
	
	$_SESSION["code"]=$codechar;
	
	$area=$this->area;
	
	$im=imagecreate($area[0],$area[1]) or die("Cannot Initialize new GD image stream");//����һ����40��18��ͼƬ
	
	$black=imagecolorallocate($im,255,255,255);
	
	$white=imagecolorallocate($im,0,0,0);
	
	$white1=imagecolorallocate($im,215,55,155);//����������ɫ
	
	if($codetype=='4'){
			
			$codechar=mb_convert_encoding($codechar,'utf-8','gbk');
	
			$font=dirname(realpath(__FILE__)).'/kermit.ttf';
	
			imagettftext($im,12,0,2,15,$white1,$font,$codechar);
	
	}else imagestring($im,5,3,2,$codechar,$white1);
	
	$white1=imagecolorallocate($im,200,55,150);//���������ɫ
	
	imageline($im,rand(0,10), rand(0,10), rand(($area[0]-10),$area[0]), rand(($area[1]-10),$area[1]),$white1);
	
	for($i=0;$i<40;$i++){ //�����������
	
			imagesetpixel($im,(rand(0,100)*$area[0])/100,(rand(0,100)*$area[1])/100,$white1); 
		
		}	
	
	imagepng($im);
	
	imagedestroy($im);	
	
}//end function--2
	
	
public function makechar_num($codenum){
		
		return substr(rand(1000000,9999999),0,$codenum);
	
}//end function--3
	
	
public function makechar_letter($codenum){
	
		$letter='abcdefghijklmnopqrstuvwxyz';
		
		$letter_char='';
		
		for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,25)];
		
		return $letter_char;
	
}//end function--4

	
public function makechar_mix($codenum){
	
		$letter='0123456789abcdefghijklmnopqrstuvwxyz';
		
		$letter_char='';
		
		for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,35)];
		
		return $letter_char;
	
}//end function--5


public function makechar_chinese($codenum){
	
	$letter=array('��','С','��','��','��','��','��','��','��','��','��','��','��','��','̫','��','��','��','��','ү','��','һ','��','��','��',
				  '��','��','��','��','��','ʮ','ţ','��','��','��','ľ','ˮ','��','��','��','ɫ','��','��','ʿ','ʧ','ĸ','��','Ц','��','��',
				  'δ','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','��','ͷ','��','��','ȥ','��','��','��',
				  '��','��','��','��','��','��','��','��','��','��','��','��','��','ʲ','ô','��','��','Ԫ','��','��','��','��','��','��','��',
				  '��','Ů','��','��','��','��','֪','��','��','ҵ','˾','ȫ','��','��','��','Ʒ','��','��','ǧ','��','��','ֻ','��','��','Ƭ');

	$letter_char='';
	
	for($i=0;$i<$codenum;$i++) $letter_char.=$letter[rand(0,count($letter))];
	
	return $letter_char;
	
}//end function--6





	
}//end class

/*
$makecodes=new makecode(2);
$makecodes->createcode();
*/

?>
