<?php

require_once("code_excute/front_all_excute.php");

$dc_array=$db_do->db_getone("select * from mq_vote order by vt_id desc limit 0,1");

$ques_answ=explode('==',$dc_array['vt_ques_answ']);

$vt_votes=rtrim($dc_array['vt_votes'],'==');

$vt_votes=explode('==',$vt_votes);

if($vt_votes[0]=='') $vt_votes=array();

$allnum=count($vt_votes);

?><!DOCTYPE HTML><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title><?php echo $dc_array['vt_title'];?>-调查结果</title>
<LINK href="images/diaocha.css" type="text/css" rel="stylesheet">
</head>
<body><div id="all">
<div class="vttitle"><?php echo $dc_array['vt_title'];?>-调查项目的调查结果</div> 
<?php

if($allnum>0){//有人参与投票

//读取问题答案

echo "<div class='nual'>共有<b>{$allnum}</b>人参与此次调查！结果报告如下：</div>";

$num_ques=count($ques_answ);

//取出每个问题答案数组

$answers=array();

for($k=1;$k<=count($vt_votes);$k++){

	for($m=1;$m<=$num_ques;$m++){
	
	$visit_answer=explode('|',$vt_votes[$k-1]);
	
	$answers[$m][]=$visit_answer[$m-1];
	
	}
	
}

//取出问题并输出比例

for($i=1;$i<=$num_ques;$i++){
	
	$ques_answ_xx=explode('|',$ques_answ[$i-1]);
	
	echo "<div class='vt_all'><div class='vt_ti'>{$i}.{$ques_answ_xx[0]}</div>\n<div class='vt_xx'><ul>"; 
	
	$answer_array=array_count_values($answers[$i]);
	
	$array_sums=array_sum($answer_array);
	
	for($j=1;$j<count($ques_answ_xx);$j++){
		
		$answer_array[$j]=='' && $answer_array[$j]=0;
		
		$answ_pecent=(round($answer_array[$j]/$array_sums,4)*100);
		
		$img_width=intval($answ_pecent)*2;
		
		echo "<li><span class='r1'>{$ques_answ_xx[$j]}</span>\n
		<span class='r2'><img src='/images/diaocha.gif' width='{$img_width}'></span>
		<span class='r3'>占比<b>{$answ_pecent}%</b></span>
		<span class='r4'>共获<b>{$answer_array[$j]}</b>票</span></li>
		\n";
		
		}
		
	echo "</ul></div></div>";
	
}

}else echo "<div style='margin:180px 0 300px 0;text-align:center;'>暂时无人参与此项调查</div>";

?>

<div id="banquan">
this is a free ticket php source by kermit:2012<br>
www.88mq.net * 2011~2013
</div>

</div>
</body>
</html>


