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
        $pg = (int)($_REQUEST['page']);
        
         
        $page = $pg;
        
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
        $pg = (int)($_REQUEST['page']);
        
         
        $pageNo = $pg;
          
        //$self = $_SERVER['PHP_SELF']."?page=";
        //if(URL_REWRITE_ENABLED == "NO")
        //{
            if( stristr($_SERVER['REQUEST_URI'], "?"))
            {
                if( stristr($_SERVER['REQUEST_URI'], "&page="))
                { 
                    //echo "===========";
                    $self = preg_replace("/&page=[0-9]+/", '', $_SERVER['REQUEST_URI']) . "&page=";
                }
                else if( stristr($_SERVER['REQUEST_URI'], "?page="))
                {
                    //echo "****************";
                    $self = preg_replace("/page=[0-9]+/", '', $_SERVER['REQUEST_URI']) . "&page=";
                }
                else
                {
                    //echo "+++++++++++++++";
                    $self = preg_replace("/page=[0-9]+/", '', $_SERVER['REQUEST_URI']) . "&page=";    
                }
                    
            }
            else
            {
                $self = $_SERVER['REQUEST_URI'] . "?page=";
            }
            
            
            $self = str_ireplace('?&&', '?', $self);
            $self = str_ireplace('?&', '?', $self);
            $self = str_ireplace('&&', '&', $self);
             
            
            
        //}
        //else
        //{
            //$self = "?page=";    
        //}
        
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
            if(isset($pageNo))
            {
                if($pageNo!=1 && $loop!=1 && $loop!=0)
                {
                    $page.="<li class='pagingTxt'><a href='" . $self . $one ."' id = '$one' class='pagingSquare' >&laquo; First</a></li>";
                    $page.="<li class='pagingTxt'><a href='" . $self . $prev_loop ."' id = '$prev_loop' class='pagingSquare'> &lsaquo; Prev</a></li>";                    
                }
            }
            $x=0;
            $j=1;
            
            if($pageNo == 0)
            {
                $pageNo = 1;
            }
            
            for($i=$loop; $i<=$noOfPages; $i++) 
            {
                if($i==0) { continue; }
                if($i==$pageNo)
                {
                    $page.="<li ><a class='current' >".$i."</a></li>";
                }
                else if(!isset($pageNo) && $i==1)
                {
                   $page.="<li><a class='current'>".$i."</a></li>";
                }
                else 
                {
                    $page.="<li><a href='" . $self . $i ."' id = '".$i;
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
    			$PageDropdown .= "<option value=" . $self.$g ;
    			if($pageNo==$g) 
    			{ 
    				$PageDropdown.=" selected"; 
    			}
                
    			$PageDropdown.=">".$g."</option>";
    		
    		}
    		$PageDropdown .= "</select>";
    		
    		
            if($pageNo!=$last && $noOfPages>10)
            {
                $pp = $i + 1;
                $r = ceil($noOfRecords/$rowsPerPage); 
                $ll = $r;
                if($pp < $noOfPages)
                {
                    if($ll != $loop)
                    {
                        $page.="<li class='pagingTxt'><a href='" . $self . $pp ."' id = '$pp' class='pagingSquare'>Next &rsaquo;</a></li>";
                        $page.="<li class='pagingTxt'><a href='" . $self . $ll ."' id = '$ll' class='pagingSquare'>Last &raquo; </a></li>";
                    }  
                } 
                
                        
            }
        
        $arr = array();
        $arr[0] = $page;
        $arr[1] = $PageDropdown;    
        }
    return $arr;
    }
}

$pg = new Pagination();
?>