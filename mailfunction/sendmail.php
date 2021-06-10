<?php
error_reporting(E_ALL);
include("class.phpmailernew.php");

$email = $_REQUEST['email'];
$message = $_REQUEST['message'];

$mail = new phpmailer;
    


$mail->IsSMTP();
//$mail->Host     = "mail.acecabs.in.cust.a.hostedemail.com";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "Newpass@0112";

$mail->Host     = "103.21.58.112";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "dOvb15^8";
$mail->Username = "noreply@insolindia.com";
$mail->Password = "f2B7~w)C[5d4";


$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->SMTPDebug = true;



$mail->From = "contact@insolindia.com";    
    
$mail->FromName = "insolindia";			
$mail->ContentType = "text/html";

$to = $email;
$mail->Subject  = "Insol india Email Tisting by Nawal";
    
$mail->AddAddress($to);
$mail->Body = $message;

$mailSent = $mail->send();    
$mail->ClearAddresses();    

if($mailSent):    
    echo "Mail Successfully Sent";
else:
   echo "Sorry cannot process your request.";
endif;			

?>