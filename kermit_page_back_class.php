<?php
/*
maker:kermit
date:2011-12-5
notes:the pages function
email:kermit2011@126.com
*/

class Page_do{
	
	//the setting of the pagenum and the other condition of the pages

	private  $pagenum;                     //how much nums needed in a page
	
	private  $pagetype='';                 //the page str in the pages
	
    private  $pageall;                     //all pages	
	
	private  $totalall;                    //all total record nums 

	private  $pagestr;                     //the vritable that will be returned
		
	public   $page=0;                      //the now page
			
	//end  setting of pages
	
public function get_thispage($pagetype='page'){
	
	if(!$this->pagetype) $this->pagetype=$pagetype;
	
	$pageget=isset($_GET[$pagetype])?intval($_GET[$pagetype]):1;                //this descide the method that you get page
		
	$pageget==0 && $pageget=1;
	
	$this->page=$pageget;
	
	return $pageget;
	
}
	
//1,get pageall,page and all about page nums;
	
public function setpage($totalall,$pagenum){               //to get the page num in the database
		
		if(!$this->page) $this->get_thispage();
		
		$this->pagenum=$pagenum;
		
		$this->totalall=$totalall;
		
		$this->pageall=ceil($totalall/$pagenum)>1?ceil($totalall/$pagenum):1;
		
		if($this->page>$this->pageall) $this->page=$this->pageall;
		
}
	
	
//2,show pages content and using urlrewrite method	
	
public function showpage($totalall,$pagenum,$type,$url,$url_add=''){                               //get the page users want to see
	
	$this->setpage($totalall,$pagenum);
	
	$pagetype=$this->pagetype;
	
	//the first showtype
	
		if($type==1){
			
        if($this->page>9) {$this->pagestr.="<a href=$url?$pagetype=1 ><<</a> ";
		 
		    			   $this->pagestr.="<a href=$url?$pagetype=".($this->page-1)."><</a> ";}
			  
        $uspage=$this->page-8;
              
		if($uspage>0 && ($this->pageall-$uspage)<16) $uspage=$this->pageall-15;

        if($uspage<1) $uspage=1;

        for($i=$uspage;$i<($uspage+16);$i++){

        if($i>$this->pageall) break;
			  
		if($i==$this->page)$this->pagestr.=" <b>$i</b> ";

        else $this->pagestr.="<a href=$url?$pagetype=$i >$i</a> ";}

        if($this->pageall>=($uspage+16)){$this->pagestr.="<a href=$url?$pagetype=".($this->page+1)." >></a> ";
		 
		      $this->pagestr.="<a href=$url?$pagetype=".$this->pageall.">>></a> ";}
			
		}
	
	//when set the type=2,the show style will be  (��*ҳ ��ǰ��*ҳ ��ҳ ��һҳ ��һҳ ĩҳ)  and show all
		
	if($type==2){
		
		$this->pagestr="�ϼ�<b>".$this->totalall."</b>����¼ ��<b>".$this->pageall."</b>ҳ ��ǰ��<b>".$this->page."</b>ҳ\n ";
			
		if($this->page==1) $this->pagestr.="��ҳ ��һҳ "; //in the first page
			
		else $this->pagestr.="<a href=$url?$pagetype=1".$url_add." >��ҳ</a> <a href=$url?$pagetype=".($this->page-1).$url_add." >��һҳ</a> \n";
			
	    if($this->page!=$this->pageall) $this->pagestr.="<a href=$url?$pagetype=".($this->page+1).$url_add." >��һҳ</a> <a href=$url?$pagetype=".($this->pageall).$url_add." >ĩҳ</a>\n";
			
		else $this->pagestr.="��һҳ ĩҳ";
			
		$this->pagestr.="<script language='javascript'>\nfunction gopage(pagego){
			if(pagego>=1)window.location.href='$url?$pagetype='+pagego+'".$url_add."';
		}</script>\nGO&nbsp;<input type=\"text\" style='text-align:center;width:30px;height:14px;vertical-align:middle;' id='gopages' onblur='gopage(this.value)' >&nbsp;ҳ";
	}	
	
return $this->pagestr;
		
}

//simple and short pages to show pagestr

public function showpage_short($totalall,$pagenum,$type,$url,$url_add=''){
	
	if($type==1){//only use for pages in ten pages
		
		$this->pagestr="��<b>".$this->totalall."</b>����¼ ҳ��<b>".$this->page."/".$this->pageall."</b>&nbsp;&nbsp;\n ";
		
		$str=array('��һҳ','�ڶ�ҳ','����ҳ','����ҳ','����ҳ','����ҳ','����ҳ','�ڰ�ҳ','�ھ�ҳ','��ʮҳ');
		
		for($i=1;$i<=$this->pageall;$i++){
			
			if($this->page!=$i) $this->pagestr.="<a href=\"$url-$i.html\" >".$str[$i-1]."</a>&nbsp;&nbsp;\n";
					
			else $this->pagestr.=" <b>".$str[$i-1]."</b>&nbsp;&nbsp;\n";
			
			}
		
		}
	

return $this->pagestr;

	
}





		
}//end the class




?>