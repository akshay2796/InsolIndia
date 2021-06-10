<?php  
error_reporting(E_ALL);
include( "ajax_include.php");

$type =  trustme($_REQUEST['type']);


switch($type)
{
    case "savePosition":
        savePosition();
        break;
    case "saveListPosition":
        saveListPosition();
        break;
   case "savePositionFrom1":
        savePositionFrom1();
        break;     
}


function saveListPosition()
{
    global $dCON;
    $tbl = trustme($_REQUEST['con']);
    $cname1 = trustme($_REQUEST['cname1']);
    $cname2 = trustme($_REQUEST['cname2']);
    $feature_position = trustme($_REQUEST['feature_position']);
    $condition_param = $_REQUEST['condition_param'];
    
    
    
    foreach ($_POST['listItem'] as $position => $item) 
    {
          
         
        $SQL  = "";
        $SQL .= " UPDATE " . $tbl ;
    
        if ($feature_position =='YES')
        {
            $SQL .= " SET position_feature = :position ";
        }
        else
        {
            $SQL .= " SET position = :position ";
        }
        
        $SQL .= " WHERE  $cname2 = :$cname2 ";    
        
        if(trim($condition_param)!="")
        {
            
            $condition_array = explode("~~~", $condition_param);
          
            foreach($condition_array as $col_condition)
            {
                
                $condition_value_array = explode("^^^", $col_condition);
                $column_name = trim($condition_value_array[0]);            
                $column_operator = trim($condition_value_array[1]);            
                $column_value = trim($condition_value_array[2]); 
                
                if($column_value !="")
                {
                    $SQL .= " AND " . $column_name . " " . $column_operator . " :$column_name ";
                    
                }
                 
            }       
            
        }
          
        //echo $SQL . $position;
        //exit();
        
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":position", $position);
        $stmt->bindParam(":" . $cname2, $item); 
        
        if(trim($condition_param)!="")
        {
            
            $condition_array = explode("~~~", $condition_param);
          
            foreach($condition_array as $col_condition)
            {
                
                $condition_value_array = explode("^^^", $col_condition);
                $column_name = trim($condition_value_array[0]);            
                $column_operator = trim($condition_value_array[1]);            
                $column_value = trim($condition_value_array[2]); 
                           
                if($column_value !="")
                {
                    $stmt->bindParam(":" . $column_name, $column_value); 
                }
                       
            }       
            
        }
        
        
        
        $rs = $stmt->execute(); 
    }
    
    echo "- Position successfully saved";
}
function savePositionFrom1()
{
    global $dCON;
    
    //Process queryString
    $tbl = trustme($_REQUEST['con']);
    $join = trustme($_REQUEST['join']);
    $heading = trustme($_REQUEST['heading']);
    $cname1 = trustme($_REQUEST['cname1']);
    $cname2 = trustme($_REQUEST['cname2']);
    $sticky_position = trustme($_REQUEST['sticky_position']);
    
    
    //echo $sticky_position;
    //exit();
    
    
    if(trim($join)=='')
    {

        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if( intval($CTR_REQ) > intval(7) )
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
    }
    else
    {
        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if( intval($CTR_REQ) > intval(8) )
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
        
    }
    
    $p_count = 0;
    foreach ($_POST['listItem'] as $position => $item) {
          $p_count++;
        if(trim($join)=='')
        {
            $SQL  = "";
            $SQL .= " UPDATE " . $tbl ;
        
            if ( $sticky_position != '' )
            {
                $SQL .= " SET " . $sticky_position . " = :position ";
            }
            else
            {
                $SQL .= " SET position = :position ";
            }
            
            $SQL .= " WHERE  $cname2 = :$cname2";    
            foreach($bparam as $index_qry => $bparam_val)
            {
                $SQL .= " AND " . trustme($index_qry) . " = :" . trustme($index_qry);
            }
        }
        else
        {
            $SQL  = "";
            $SQL .= " UPDATE tbl_" . $tbl ;
            $SQL .= " SET sticky_position = :position  ";
            $SQL .= " WHERE  $cname2 = :$cname2 " ;   
        }
           
        
        
          
        //echo $SQL . "\n\n";
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":position", $p_count);
        $stmt->bindParam(":" . $cname2, $item); 
        foreach($bparam as $index_qry_val => $bparam_bind_val)
        {  
            $stmt->bindValue(":" . $index_qry_val, $bparam_bind_val); 
        }
        
        $rs = $stmt->execute(); 
    }
     
    echo "- Position successfully saved";
    
     
}
function savePosition()
{
    global $dCON;
    
    //Process queryString
    $tbl = trustme($_REQUEST['con']);
    $join = trustme($_REQUEST['join']);
    $heading = trustme($_REQUEST['heading']);
    $cname1 = trustme($_REQUEST['cname1']);
    $cname2 = trustme($_REQUEST['cname2']);
    $sticky_position = trustme($_REQUEST['sticky_position']);
    
    
    //echo $sticky_position;
    //exit();
    
    
    if(trim($join)=='')
    {

        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if( intval($CTR_REQ) > intval(7) )
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
    }
    else
    {
        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if( intval($CTR_REQ) > intval(8) )
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
        
    }
    
    
    foreach ($_POST['listItem'] as $position => $item) {
          
        if(trim($join)=='')
        {
            $SQL  = "";
            $SQL .= " UPDATE " . $tbl ;
        
            if ( $sticky_position != '' )
            {
                $SQL .= " SET " . $sticky_position . " = :position ";
            }
            else
            {
                $SQL .= " SET position = :position ";
            }
            
            $SQL .= " WHERE  $cname2 = :$cname2";    
            foreach($bparam as $index_qry => $bparam_val)
            {
                $SQL .= " AND " . trustme($index_qry) . " = :" . trustme($index_qry);
            }
        }
        else
        {
            $SQL  = "";
            $SQL .= " UPDATE tbl_" . $tbl ;
            $SQL .= " SET sticky_position = :position  ";
            $SQL .= " WHERE  $cname2 = :$cname2 " ;   
        }
           
        
        
          
        //echo $SQL . "\n\n";
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":position", $position);
        $stmt->bindParam(":" . $cname2, $item); 
        foreach($bparam as $index_qry_val => $bparam_bind_val)
        {  
            $stmt->bindValue(":" . $index_qry_val, $bparam_bind_val); 
        }
        
        $rs = $stmt->execute(); 
    }
     
    echo "- Position successfully saved";
    
     
}

function savePosition1111()
{
    global $dCON;
    
    //Process queryString
    $tbl = trustme($_REQUEST['con']);
    $join = trustme($_REQUEST['join']);
    $heading = trustme($_REQUEST['heading']);
    $cname1 = trustme($_REQUEST['cname1']);
    $cname2 = trustme($_REQUEST['cname2']);
    $sticky_position = trustme($_REQUEST['sticky_position']);
    //[state_id] => 1001
    if(trim($join)=='')
    {

        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if($CTR_REQ > 7)
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
    }
    else
    {
        $CTR_REQ = 0;
        $bparam = array();
        foreach($_POST as $indx => $req_value)
        {
            if($indx == "stop")
            {
                break;
            }
            
            if($CTR_REQ > 8)
            { 
                $bparam[$indx] = $req_value;    
            }
    
            $CTR_REQ++;
        } 
        
    }
    
    
    foreach ($_POST['listItem'] as $position => $item) {
          
        if(trim($join)=='')
        {
            $SQL  = "";
            $SQL .= " UPDATE tbl_" . $tbl ;
        
            if ($sticky_position =='YES')
            {
                $SQL .= " SET sticky_position = :position ";
            }
            else
            {
                $SQL .= " SET position = :position ";
            }
            
            $SQL .= " WHERE  $cname2 = :$cname2";    
            foreach($bparam as $index_qry => $bparam_val)
            {
                $SQL .= " AND " . trustme($index_qry) . " = :" . trustme($index_qry);
            }
        }
        else
        {
            $SQL  = "";
            $SQL .= " UPDATE tbl_" . $tbl ;
            $SQL .= " SET sticky_position = :position  ";
            $SQL .= " WHERE  $cname2 = :$cname2 " ;   
        }
           
        
        
          
        //echo $SQL;
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":position", $position);
        $stmt->bindParam(":" . $cname2, $item); 
        foreach($bparam as $index_qry_val => $bparam_bind_val)
        {  
            $stmt->bindValue(":" . $index_qry_val, $bparam_bind_val); 
        }
        
        $rs = $stmt->execute(); 
    }
     
    echo "- Position successfully saved";
    
     
}