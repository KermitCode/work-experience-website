<?php

/*
 **kermit-2012-6-8
 **导出mysql数据库单一表或者全表
 include("../myself/my_dbconfig_class.php");
 *注：导入数据库时需指定编码为gbk编码,下为导出示例代码
 *$db=$db_do->db_link();
 *$copy_data=new copy_database($db);
 *$sql_file=$copy_data->write_sql("all",1);
 *echo $sql_file;
 */

class copy_database{
	
	private $tabledump='';     			      //导出的字符串
	
	public  $file_path;	 					  //定义导出的sql文件名-如不在此目录则带上路径	
	
	private $db=null;				 		  //定义数据库连接对象，需传入

	
	public function copy_database($db,$filepath=''){
		
		//传入的$file应该为path/ 样式
		
		if($db==null) exit('none pdo link!');
		
		$this->db=$db;
		
		$this->file_path=$filepath;
		
}//end construct
	
	
	private function table2sql($table){
		
         $db=$this->db;
		 
         $tabledump = "DROP TABLE IF EXISTS $table;\r\n";
         
		 $createtable = $db->query("SHOW CREATE TABLE $table");
		 
         $createtable = $createtable->fetch();

		 $tabledump .= $createtable[1].";\r\n";
         
		 return $tabledump;
	  
}//end one table only construct to sql char  
  
    private function data2sql($table){
		 
         $db=$this->db;
		 
         $tabledump = $this->table2sql($table);
  
         $rows = $db->query("SELECT * FROM {$table}");
		 
		 $numfields=$rows->columnCount();
		         
		 if($rows){//数据不为空
			 
				 $rows=$rows->fetchAll();
	
				 foreach($rows as $key=>$value){

					 $comma=''; $tabledump.= "INSERT INTO {$table} VALUES(";

					 for($i = 0; $i < $numfields; $i++){
					  
			    		 $tabledump .= $comma."'".mysql_escape_string($value[$i])."'";
					 
						 $comma = ",";
					 
					 }
				 
					 $tabledump.= ");\r\n";
          
		  		}
         
		 		$tabledump.= "\r\n\r\n";
		 
		 }//end the dothing when data in the table is not null
  
       return $tabledump;

}//end one table construct and data to sql char
	  
	
	public function write_sql($table='all',$type=1){//$table is null=make all the database    $type=1 then will with table data
		
		$char='';
		
		if($table!='all'){//do on only one table
			
			if(!$type) $char=$this->table2sql($table);
			
			else $char=$this->data2sql($table);
			
		}else{//make all the database to sql
			
			$rs_tables=$this->db->query("show tables;");
			
			$rs_tables=$rs_tables->fetchAll();
			
			for($i=0;$i<count($rs_tables);$i++){
				
				if(!$type) $char.=$this->table2sql($rs_tables[$i][0]);
				
				else $char.=$this->data2sql($rs_tables[$i][0]);
				
			}
			
		}
		
		$char=='' && exit('error:the sql char is null!');
		
		$file_write=$this->file_path.$table.date("Y-m-d").".sql";

		$fp=fopen($file_write,"wb");
		
		fwrite($fp,$char);
		
		fclose($fp);
				
		return $file_write;
	
}//end write sqlchar to sql file



 
	  


}





?>

