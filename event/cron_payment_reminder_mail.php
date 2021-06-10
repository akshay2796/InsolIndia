<?php
ini_set("max_execution_time", 600); 
error_reporting(E_ALL);

include("library_insol/class.pdo.php");
include("library_insol/class.inputfilter.php");
include("library_insol/class.pagination.php");
include("library_insol/function.php");
include("library_insol/class.phpmailernew.php");
include("global_functions.php");

$COMPANY_NAME = $_SESSION['COMPANY_NAME'];

$todaydate = date('Y-m-d');
$todaydate=strtotime($todaydate);
$membership_expired_date = date('Y-m-d', strtotime('+1 month',$todaydate));

$SQL2 = "";
$SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE member_id END AS ordby FROM " . BECOME_MEMBER_TBL . "";   
$SQL2 .= " WHERE status = 'ACTIVE' ";
$SQL2 .= " and register_status = 'Approved' ";
$SQL2 .= " and payment_status = 'SUCCESSFUL'";
//$SQL2 .= " and sig_member = 0 ";
$SQL2 .= " and membership_expired_date = :membership_expired_date ";
$SQL2 .= " order by ordby desc ";

$stmt2 = $dCON->prepare($SQL2); 
$stmt2->bindParam(":membership_expired_date", $membership_expired_date);
$stmt2->execute();
$row = $stmt2->fetchAll();


        
foreach($row as $rs)
{  
    
    $title = "";
    $first_name = ""; 
    $middle_name = ""; 
    $last_name = ""; 
    
    
    $title = stripslashes($rs["title"]);
    $first_name = stripslashes($rs["first_name"]);
    $middle_name = stripslashes($rs["middle_name"]);
    $last_name = stripslashes($rs["last_name"]);
    $membership_expired_date = stripslashes($rs["membership_expired_date"]);
    
    $full_name = $title." ".$first_name;
    
    if($middle_name !='')
    {
        $full_name = $full_name." ".$middle_name;
    }
    if($last_name !='')
    {
        $full_name = $full_name." ".$last_name;
    }
    
    $full_name = ucwords(strtolower($full_name));
    
    $email = stripslashes($rs['email']); 
      
    $MAIL_BODY = '';
    
    $MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
        $MAIL_BODY .= '<tbody>';
            $MAIL_BODY .= '<tr>';
                $MAIL_BODY .= '<td>';
                    $MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';
                        $MAIL_BODY .= '<tbody>';
                            $MAIL_BODY .= '<tr>';
                                $MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>';
                            $MAIL_BODY .= '</tr>';
                                            $MAIL_BODY .= '<tr>';
                                                $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$full_name.'</td>';
                                            $MAIL_BODY .= '</tr>';
                                            $MAIL_BODY .= '<tr>
                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                								<h1 style="color: #2E3192; font-size:16px;">Thank you for being part of the INSOL India network.</h1>
                                                                <p>As per our records your membership is about to expire in a month and therefore request to kindly make the necessary renewal payment.</p>
                                                                <p>In case already done, kindly ignore this mail.</p>
                                                                
                                                                <p>Warm Regards</p>
                                                                <p>Team INSOL India</p>
                                                                 Note: This is an automated email. Do not respond back. For any further queries contact: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a>
                                                        </td>
                                                    </tr>';
                            $MAIL_BODY .= '<tr>';
                                $MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';
                                    $MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744 ';
                                    $MAIL_BODY .= 'Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>';
                                $MAIL_BODY .= '</td>';
                            $MAIL_BODY .= '</tr>';
                        $MAIL_BODY .= '</tbody>';
                    $MAIL_BODY .= '</table>';
                $MAIL_BODY .= '</td>';
            $MAIL_BODY .= '</tr>';
        $MAIL_BODY .= '</tbody>';
    $MAIL_BODY .= '</table>';
    
  
    $MAIL_TO = $email;
    
   
    ///$MAIL_CC = "";
    $MAIL_CC = "contact@insolindia.com";
  
    //$MAIL_BCC = "";            
    $MAIL_BCC = "";

    $MAIL_FROM = $_SESSION['INFO_EMAIL'];
    $MAIL_FROMNAME = $_SESSION['COMPANY_NAME'];
    
    $MAIL_ATTACHMENT1 = "";
    
    $MAIL_SUBJECT = "Membership Renewal Reminder";
    
    $RES = MailObject($MAIL_TO,$MAIL_FROM,$MAIL_CC,$MAIL_BCC,$MAIL_SUBJECT,$MAIL_BODY,$MAIL_ATTACHMENT1);
    
    
        
    
}

 

?>



