<?php 

	$connect = mysqli_connect("localhost","root","","event_member");
 
if(isset($_POST['submit']))
	
		{
			$title=$_POST['title'];
			$firstname=$_POST['firstname'];
			$surname=$_POST['surname'];
			$yourbadge=$_POST['yourbadge'];
			$firmname=$_POST['firmname'];
			$address=$_POST['address'];
			$tel=$_POST['tel'];
			$email=$_POST['email'];
			$insolmember=$_POST['insolmember'];
			$signature=$_POST['signature'];
			$date=$_POST['date'];
			$hotel=$_POST['hotel'];
			
		

	$insert_query="INSERT INTO event_reg SET 
			title='$title',
			firstname='$firstname',
			surname='$surname',
			yourbadge='$yourbadge',
			firmname='$firmname',
			address='$address',
			tel='$tel',
			email='$email',
			insolmember='$insolmember',
			signature='$signature',
			date='$date',
			hotel='$hotel'";	
	
		$insert_execute=mysqli_query($connect,$insert_query);
		if($insert_execute>0)
			{
		 $URL="booking.php?no=$on1";
	     echo "<script>location.href='$URL'</script>";
	    echo "You are successfully register.";
			}
		else
			{
			 echo '<pre>';
      echo "Sorry there was an error sending your message. Please try again later";
      echo '</pre>';
			}
		


include 'mailer/PHPMailerAutoload.php';


$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'event@insolindia.com';                 // SMTP username
$mail->Password = 'DW8JT8RAh{FN';                           // SMTP password
//$mail->Username = 'contact@evisa-india.com';                 // SMTP username
//$mail->Password = 'Hello@123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('event@insolindia.com', 'e-visa');
$mail->addAddress('event@insolindia.com', ''); 
$mail->addAddress('event@insolindia.com', '');     
//$mail->addBCC('santoshbeats@gmail.com');

//    // Add a recipient
//$mail->addReplyTo('sachbhardwaj9@gmail.com', 'e-visa');
//$mail->addCC('info@evisa-india.com');



$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = ' Insol India Annual Conference Registration Form';
$mail->Body    = $body;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
//$mail->addAttachment('/uploads/image.jpg', 'new.jpg');    // Optional name
            $mail->AddAttachment($uploadfile);
if(!$mail->send()) {
     // $URL="pay.php?no='$on1'&img='.$image.'";
	echo "<script>location.href='$URL'</script>";
	
} else {
     
       echo "<script>alert('Details Sent');</script>";
      // $URL="pay.php";
	echo "<script>location.href='$URL'</script>";
       
}



}

?>