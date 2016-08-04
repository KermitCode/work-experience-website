<?php



function get_yearchar($year){
	
	$year=intval($year);
	
	if($year=='' || $year==0) return 'the year char is null or zero';
	
	$char=array('һ','��','��','��','��','��','��','��','��','ʮ');
	
	if($year<1 || $year>45) return '�Ƿ�����';
	
	if($year>=1 && $year<=10) return $char[$year-1];
	
	if($year>=11 && $year<=19) return $char[9].$char[$year-11];
	
	if($year%10==0) return $char[$year/10-1].$char[9];
	
	else return $char[floor($year/10)-1].$char[9].$char[$year%10-1];

}









?>