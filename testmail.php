<?php

require 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->SMTPDebug = 3; // Enable verbose debug output

$mail->isSMTP(); // Set mailer to use SMTP
// $mail->Host = 'localhost'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
// $mail->Username = 'noreply@insolindia.com'; // SMTP username
// $mail->Password = 'f2B7~w)C[5d4'; // SMTP password
// $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to
$mail->Host = "mail.sabsoftzone.in";
$mail->Username = "info@sabsoftzone.in";
$mail->Password = "q[BhD01vcX7&";

$mail->setFrom('info@sabsoftzone.in', 'Testing INSOL INDIA');
$mail->addAddress('akshay2796@gmail.com', ''); // Add a recipient
//$mail->addAddress('bhavna@insolindia.com', '');     // Add a recipient
//$mail->addAddress('aditikhanna@insolindia.com', '');     // Add a recipient
// $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name
$mail->isHTML(true); // Set email format to HTML

$mail->Subject = 'Testing Insol';
$mail->Body = 'InsolIndia Test 2';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if (!$mail->send()) {
    echo $urt = 'Message could not be sent.';
    $urt = 'Mailer Error: ' . $mail->ErrorInfo;
    var_dump($mail);
} else {
    echo $urt = 'Message has been sent';
}