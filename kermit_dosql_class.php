<?php

/*导入SQL程序类
 *kermit 2012-6-18
 */

error_reporting(7);

@set_time_limit(0);

class dosql{
	
	private $dnsarray=array();									//数据库参数变量
	
	private $sqlfile='';										//要执行的SQL文件路径

	public $conn;												//连接标识符

public function dosql($dnsarray=array()){
	
	if(empty($dnsarray)){
		
			$this->dnsarray=array(
			'host'=>'localhost',
			'username'=>'root',
			'password'=>'2630563',
			'database'=>'new88mq',
			'charset'=>'gbk');
	
	}
		
	$this->conn=mysql_connect($this->dnsarray['host'],$this->dnsarray['username'],$this->dnsarray['password']) or die('connect wrong:'.mysql_error());
	
	mysql_select_db($this->dnsarray['database']) or die('connect select the database');
	
	$mysqlV=mysql_get_server_info();

	$mysqlV>'4.1' && mysql_query("set names ".$this->dnsarray['charset']);

	mysql_get_server_info() > '5.0' && mysql_query("SET sql_mode=''");

	return $this->conn;
	
}//end function--1

//make all sqlfile to database

public function insert_sql($file,$replace=''){
	
	if(!is_file($file)) exit('sql file is invalid!');
	
	$readfiles=$this->read_file($file);
	
	$replace && $readfiles=str_replace('$timestamp',"$timestamp",$readfiles);
	
	$detail=explode("\n",$readfiles);
	
	$count=count($detail);
	
	for($j=0;$j<$count;$j++){
		
			$ck=substr($detail[$j],0,4);
			
			if(ereg("#",$ck)||ereg("--",$ck) ) continue;
	
			$array[]=$detail[$j];
	
	}

	$read=implode("\n",$array); 
	
	$sql=str_replace("\r",'',$read);

	$detail=explode(";\n",$sql);

	$count=count($detail);
	
	for($i=0;$i<$count;$i++){
		
		$sql=str_replace("\r",'',$detail[$i]);
		
		$sql=str_replace("\n",'',$sql);
		
		$sql=trim($sql);
		
		if($sql){
			
				if(eregi("CREATE TABLE",$sql)){
					
						$mysqlV=mysql_get_server_info();
						
						$sql=preg_replace("/DEFAULT CHARSET=([a-z0-9]+)/is","",$sql);
						
						$sql=preg_replace("/TYPE=MyISAM/is","ENGINE=MyISAM",$sql);
						
						if($mysqlV>'4.1'){
							
							$sql=str_replace("ENGINE=MyISAM"," ENGINE=MyISAM DEFAULT CHARSET=".$this->dnsarray['charset'],$sql);
						
						}
						
				}
			
			$query=mysql_query($sql);
			
			if (!$query) die("数据库出错:$sql");
			
			$check++;
		
		}
			
	}
	
	return $check;

}//end function 3--

//读文件程序

public function read_file($filename,$method="rb"){
	
	if($handle=@fopen($filename,$method)){
		
		@flock($handle,LOCK_SH);
		
		$filedata=@fread($handle,@filesize($filename));
		
		@fclose($handle);
	
	}
	
	return $filedata;

}//end function 4--


}
	
/*使用方法：
$dosql=new dosql();
echo $dosql->insert_sql("qb_members.sql");
*/

?>