<?php
class Pagination {
    var $sql;
    var $rowsPerPage;
    var $offset;
    var $self;
    var $total_row;
    var $noOfPages;
    var $one;
    var $last;
    var $prev;
    var $next;
    var $i;
    var $prev_loop;
    var $loop;
    var $arr;
    var $page;
    
    function getPagingQuery($sql,$rowsPerPage) 
    {
        $page = (int)($_REQUEST['page']);
        if(isset($page) && $page!=0) 
        {
            $offset=(($page-1)*$rowsPerPage);
        }
        else 
        {
            $offset=0;
        }
        //$sql=$sql." Limit $offset,$rowsPerPage";
        $sql1 = array();
        $sql1[0] = $sql." Limit :offset , :RPP";
        $sql1[1] = $offset;
        return $sql1;
    }
    
    function getAjaxPagingLink($noOfRecords,$rowsPerPage) 
    {
        $pageNo = (int)($_REQUEST['page']);
        $self = $_SERVER['PHP_SELF']."?page=";
       // $total_row=mysql_num_rows(mysql_query($this->sql));
        $total_row = $noOfRecords;
        $noOfPages=ceil($total_row/$rowsPerPage);
        $one=1;
        $last = $noOfPages;
    	$prev = $pageNo-1;
        $next = $pageNo+1;
    	
    	
    	$cycle = 0;
    	$rohit = $pageNo / 10;
       	if($rohit <= 1 )
        {
        	$cycle = 0;
    	}
    	elseif($rohit > 1 )
    	{
    		$modd = $pageNo % 10;
    		if( (integer)($modd) == (integer)(0) )
    		{
    			$rohit = $rohit - (integer)(1);
    		}
    		$cycle = (integer)($rohit);
    		$cycle = $cycle * 10;
    		$cycle = $cycle + 1;	
    	}
        if($cycle)
        {
            $loop=$cycle;
            $prev_loop = $loop-10;
        }
        else
        {
            $loop=0;
        }
    	
        $pagingCombo="<select name='page' onchange='pagination(this.value);'>"; 
        if($noOfPages>1) 
        {
            $page  = "";
            $page .= "<ul>";
            if(isset($pageNo))
            {
                if($pageNo!=1 && $loop!=1 && $loop!=0)
                {
               // $page.="<a class='paging' href='javascript:pagination($one);'>First</a>&nbsp;";
               // $page.="<a class='paging' href='javascript:pagination($prev_loop);'>Prev</a>";
                $page.="<li><a href='javascript:void(0);' id = '$one' class='paging'>First</a></li>";
                $page.="<li><a href='javascript:void(0);' id = '$prev_loop' class='paging'>Prev 10</a></li>";
                }
            }
            $x=0;
            $j=1;
            
            $pageNo = ($pageNo == 0)?1:$pageNo; 
            
            for($i=$loop; $i<=$noOfPages; $i++) 
            {
                if($i==0) { continue; }
                if($i==$pageNo)
                {
                    $page.="<li class='active' ><a href='javascript:void(0);'>".$i."</a></li>";
                }
                else if(!isset($pageNo) && $i==1)
                {
                   $page.="<li class='active' ><a href='javascript:void(0);'>".$i."</a></li>";
                }
                else 
                {
                    $page.="<li class=''><a class='paging' href='javascript: void(0);' id = '".$i;
                    $page.="'>".$i."</a></li>";
                    
                }
                $pagingCombo.="<option value=".$i;
                        if($pageNo==$i) { $pagingCombo.=" selected"; }
                        $pagingCombo.=">".$i."</option>";
                
                if($j%10==0)
                {
    				$j=1;
    				break;
                }
                else
                {
                    $j++;
                }      
            }
    		
    		$PageDropdown = "";
    		$PageDropdown .= "<select name='page' id = 'page' style='width:50px; height:19px;border:0px; height:20px; font-size:11px; color:#65665c; padding:2px'>";
    		
    		for($g=1; $g<=$noOfPages; $g++) 
            {
    			$PageDropdown .= "<option value=".$g ;
    			if($pageNo==$g) 
    			{ 
    				$PageDropdown.=" selected"; 
    			}
                
    			$PageDropdown.=">".$g."</option>";
    		
    		}
    		$PageDropdown .= "</select>";
    		
    		
            if($pageNo!=$last && $noOfPages>10)
            {
                
                $pp=$i+1;
                $r=floor($last/10);
                $ll=($r*10)+1;
                if($ll!=$loop)
                {
                    //$page.="<a class='paging' href='javascript:pagination($pp);'>Next</a>&nbsp;";
                    //$page.="<a class='paging' href='javascript:pagination($ll);'>Last</a>";
                    $page.="<li><a class='paging' href='javascript:void(0);' id = '$pp'>Next 10</a></li>";
                    $page.="<li><a class='paging' href='javascript:void(0);' id = '$ll'>Last</a></li>";
                }                
            }
        
        $page .= "</ul>";
        
        $arr=array();
        $arr[0]=$page;
        $arr[1]=$PageDropdown;    
        }
    return $arr;
    }
}
$pg = new Pagination();
?>