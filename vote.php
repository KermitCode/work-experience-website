<?

require_once("code_excute/front_all_excute.php");

$dc_array=$db_do->db_getone("select * from mq_vote order by vt_id desc limit 0,1");

$ques_answ=explode('==',$dc_array['vt_ques_answ']);


$l1 = $mainfun->getstring('a','1','0');

$vtid=$mainfun->getpost('vtid','3','0');

$vt_jytext=$mainfun->getpost('jytext','1','0');

if($vt_jytext!='') $vt_jytext.="|".date("Y-m-d H:i:s").'||';

if($l1 == 'add'){
	
	$r4 = implode("|",array_slice($_POST,0,-2));
	
	$db_do->db_upandde("update mq_vote set vt_votes=concat(ifnull(vt_votes,''),'{$r4}=='),vt_jytext=concat(ifnull(vt_jytext,''),'{$vt_jytext}') where vt_id={$vtid}");
	
	echo "<script>alert('感谢您的投票!');window.location.href='vote.php';</script>";

}

?><!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk">
<title><?php echo $dc_array['vt_title'];?>-调查</title>
<LINK href="images/diaocha.css" type="text/css" rel="stylesheet">
</head>
<body><div id="all">
<div class="vttitle"><?php echo $dc_array['vt_title'];?></div>  
<form name="form1" method="post" action="?a=add" ;><div>
<?php

//读取问题答案

for($i=1;$i<=count($ques_answ);$i++){
	
	$ques_answ_xx=explode('|',$ques_answ[$i-1]);
	
	echo "<div class='vt_ti'>{$i}.{$ques_answ_xx[0]}</div>\n<div class='vt_xx1'><ul>"; 
	
	for($j=1;$j<count($ques_answ_xx);$j++){
		
		if($j==1)echo "<li><input type='radio'  name='a{$i}' id='a{$i}' value='{$j}' checked />{$ques_answ_xx[$j]}</li>\n";
		
		else echo "<li><input type='radio'  name='a{$i}' id='a{$i}' value='{$j}' />{$ques_answ_xx[$j]}</li>\n";
		
		}
		
	echo "</ul></div>";
	
}

if($dc_array['vt_jianyi']!=''){ echo "<div class='vt_ti'>$i.{$dc_array['vt_jianyi']}</div><textarea name='jytext'></textarea>"; }
//
?>
<div class="sub_vote">
<input type="hidden" name="vtid" value="<?php echo $dc_array['vt_id']; ?>"> 
<input type="submit" name="button" id="button" value="提交我的调查">&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" onClick="window.open('rs_vote.php');" value='查看投票结果' />
</div>
</form>
</div>
<div id="banquan">
this is a free ticket php source by kermit:2012<br>
www.88mq.net * 2011~2013
</div>
</div></body>
</html>
