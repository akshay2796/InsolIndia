<?php 
session_start();
error_reporting(0);
include("ajax_include.php");  

$type =  trustme($_REQUEST['type']);
switch($type)
{
    case "changepassword":
        changepassword();
        break;
}

//Modify Data
function changepassword()
{
    global $dCON;
    
    $newpass = trustme( $_REQUEST['newpass']);
	
    $SQL = "";
    $SQL = " UPDATE " . ADMIN_TBL . " SET password  = ? where user_id = ? ";
    
    
    $stm = $dCON->prepare($SQL);
	$stm->bindParam(1, $newpass);
	$stm->bindParam(2, $_SESSION['USERID_DPG']);
	$rs = $stm->execute();

    switch($rs)
	{
		case "1": 
            echo "~~~1~~~Password successfully changed...~~~";
            break;
            
		default:
            echo "~~~0~~~Sorry cannot process your request...~~~";
            break;
	}
}
?>


