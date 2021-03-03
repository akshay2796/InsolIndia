<?php 
ob_start();
include("../library_insol/class.pdo.php");
include("../library_insol/class.inputfilter.php");
include("../library_insol/function.php");

$username = trustme($_REQUEST['username_insol']);
$password = trustme($_REQUEST['password_insol']);
$mid = intval($_REQUEST['mid']);
  
$SQL = "";
$SQL .= " SELECT * ";
//$SQL .= " FROM " . ADMIN_TBL . " WHERE id > 0 AND username = ? and AES_DECRYPT(password, '" . CONSTANT_PASSWORD_KEY . "' ) = ?  ";            
$SQL .= " FROM " . ADMIN_TBL . " WHERE user_id > 0 and username = ? and password = ?  ";            
//echo "==".$SQL."--$username--$password";
//exit;
$sLOG=$dCON->prepare($SQL);
$sLOG->bindParam(1,$username);
$sLOG->bindParam(2,$password);
$sLOG->execute();
$rsLOG=$sLOG->fetchAll();

//echo "==".count($rsLOG);
//exit;

if(intval(count($rsLOG)) > intval(0))
{
    //echo $rsLOG[0]['status'];
    //echo $rsLOG[0]['user_type'];
    //echo "-----------";        
    //exit();
    
    if( stripslashes(trim($rsLOG[0]['status'])) == "ACTIVE" )
    {
    	$_SESSION['USERID_DPG'] = intval($rsLOG[0]['user_id']);            
    	$_SESSION['USERNAME'] =  htmlspecialchars(stripslashes($rsLOG[0]['username']));
    	$_SESSION['USERFULLNAME'] =  htmlspecialchars(stripslashes($rsLOG[0]['user_name']));
    	$_SESSION['USERTYPE'] = htmlspecialchars(stripslashes($rsLOG[0]['user_type']));
         
        //$_SESSION['PERMISSION'] =  htmlspecialchars(stripslashes($rsLOG[0]['user_permission']));
        if(intval($mid) > intval(0))
        {
            header("Location: become_member_edit.php?con=modify&id=".$mid);
        }
        else
        {
            header("Location:index.php");    
        }
        
    	exit();
        
     }
     else
     {
        header("Location:login.php?mid=$mid&msg=".urlencode("Your Account Is Inactive / Contact site administrator..."));
        exit();
     }
}
else
{
	header("Location:login.php?mid=$mid&msg=".urlencode("Invalid Username Or Password"));
	exit();
}
    
ob_flush();
ob_end_clean();
    
?>