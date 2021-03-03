<?php


require 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'noreply@insolindia.com';                 // SMTP username
$mail->Password = 'f2B7~w)C[5d4';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('noreply@insolindia.com', 'test');
//$mail->addAddress('contact@insolindia.com', '');     // Add a recipient
//$mail->addAddress('bhavna@insolindia.com', '');     // Add a recipient
//$mail->addAddress('aditikhanna@insolindia.com', '');     // Add a recipient
$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Query Form';
$mail->Body    = 'InsoleIndia Test';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
   echo $urt= 'Message could not be sent.';
   $urt= 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 echo  $urt= 'Message has been sent';
}


?>
