<?php
//error_reporting(E_ALL);
include("header.php");

echo '<br><br>';

//$TABLENAME = BILLING_TBL.$_SESSION['FINANCIAL_YEAR'];

//echo "---".getBookingno($TABLENAME,'booking_no');


$SQL = "";
$SQL .= " SELECT * FROM tbl_become_member WHERE reciept_image_name != ''  ";
$sLOG=$dCON->prepare($SQL);
$sLOG->execute();
$row=$sLOG->fetchAll();

echo "==".$SQL;

if( intval(count($row)) > intval(0) )
{
    $i=1;
    foreach($row as $rs)
    {
                 
        $member_id = "";
        $reciept_image_name = "";
       
        $member_id  = stripslashes($rs['member_id']);
        $reciept_image_name = stripslashes($rs['reciept_image_name']);
          
        $status = 'ACTIVE';
        $add_by = stripslashes($rs['update_by']);;
        $ip = stripslashes($rs['update_ip']);;
        $add_time = stripslashes($rs['update_time']);;
        
        $ck_duplicate = checkDuplicate('tbl_become_member_receipt',"member_id~~~reciept_image_name",$member_id."~~~".$reciept_image_name,"=~~~=",""); 
        
        if( intval($ck_duplicate) == intval(0) )
        {
            $reciept_caption = '';
            $MAXID_IMG = getMaxId('tbl_become_member_receipt',"reciept_id"); 
            $position = 1;
            
            $SQL_IMG  = "";
            $SQL_IMG .= " INSERT INTO tbl_become_member_receipt SET ";
            $SQL_IMG .= " reciept_id = :reciept_id, ";    
            $SQL_IMG .= " member_id = :member_id, ";         
            $SQL_IMG .= " reciept_caption = :reciept_caption, ";         
            $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
            $SQL_IMG .= " position = :position, "; 
            $SQL_IMG .= " add_ip = :add_ip, ";         
            $SQL_IMG .= " add_by = :add_by, ";         
            $SQL_IMG .= " add_time = :add_time ";             
            
            $stmtIMG = $dCON->prepare( $SQL_IMG );
            $stmtIMG->bindParam(":reciept_id", $MAXID_IMG);
            $stmtIMG->bindParam(":member_id", $member_id);
            $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
            $stmtIMG->bindParam(":reciept_image_name", $reciept_image_name); 
            $stmtIMG->bindParam(":position",$position);
            $stmtIMG->bindParam(":add_ip",$ip);
            $stmtIMG->bindParam(":add_by",$add_by);
            $stmtIMG->bindParam(":add_time",$add_time); 
            $rsImage = $stmtIMG->execute();
            //print_r($stmtIMG->errorInfo());
            //echo intval($rsImage);
            $stmtIMG->closeCursor();
            
            
        }
        else
        {
            echo "<br><b style='color:red'>".$i." - Already -".$member_id."</b>";
                
        }
        
       $i++; 
    }
     
}
else
{
   
      
}


exit;
















$sql_size = "";
//$sql_size .= " DESCRIBE tbl_lead ";
//$sql_size .= " DESCRIBE ".BOOKING_TBL.$_SESSION['FINANCIAL_YEAR'];
$sql_size .= " DESCRIBE ".NEWSLETTER_TBL ;
//echo $sql_size;

$stmt_size = $dCON->prepare($sql_size);            
$stmt_size->execute();
$row_size = $stmt_size->fetchAll();
$stmt_size->closeCursor();

foreach($row_size as $rs_size)
{
    //echo $rs_size['Field'].",";
    //echo 'B.'.$rs_size['Field']. ', ';
    echo '$'.$rs_size['Field']. ' = trustme($_REQUEST["'.$rs_size['Field'].'"]); <br>';
    //echo '$'.$rs_size['Field']. ' = trustme($REQData->'.$rs_size['Field'].');-- '.$rs_size['Type'].'<br>';
    
}
echo '<br><br>';


foreach($row_size as $rs_size)
{
    //echo $rs_size['Field'].",";
    //echo 'B.'.$rs_size['Field']. ', ';
    //echo '$'.$rs_size['Field']. ' = trustme($_REQUEST["'.$rs_size['Field'].'"]); <br>';
    
    
    //echo $rs_size['Field']. " - ".$rs_size['Type']. " - ".$rs_size['Null']."<br>";
    //echo '$'.$rs_size['Field']. ' = trustme($REQData->'.$rs_size['Field'].'); <br>';
    
    echo '$scope.dataFrm.'.$rs_size['Field']. ' = payload.data.data[0].'.$rs_size['Field'].'--'.$rs_size['Type'].'<br>';
    
    
}

echo '<br><br>';


foreach($row_size as $rs_size)
{
    //echo $rs_size['Field']. " - ".$rs_size['Type']. " - ".$rs_size['Null']."<br>";
    //echo '$'.$rs_size['Field']. ' = trustme($REQData->'.$rs_size['Field'].'); <br>';
    //echo '$'.$rs_size['Field']. ' = trustme($REQData->'.$rs_size['Field'].');<br>';
    //echo '$'.$rs_size['Field']. ' = "";<br>';
    //echo '$'.$rs_size['Field']. ' = stripslashes($rs["'.$rs_size['Field'].'"]);<br>';
    echo '$'.$rs_size['Field']. ' = stripslashes($rs[0]["'.$rs_size['Field'].'"]);<br>';
    

}


echo '<br><br>';



foreach($row_size as $rs_size)
{
    //echo $rs_size['Field']. " - ".$rs_size['Type']. " - ".$rs_size['Null']."<br>";
    echo '$SQL .= " '.$rs_size['Field']. ' = :'.$rs_size['Field'].',"; <br>';
}

echo '<br><br>';

foreach($row_size as $rs_size)
{
    //echo $rs_size['Field']. " - ".$rs_size['Type']. " - ".$rs_size['Null']."<br>";
    echo '$stmt->bindParam(":'.$rs_size['Field']. '", $'.$rs_size['Field'].'); <br>';
}

echo '<br><br>';

include("footer.php");
?>
