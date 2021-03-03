<!doctype html>
	

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
	    // echo "<script>location.href='$URL'</script>";
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
$mail->Username = 'dev@sabsoftzone.com';                 // SMTP username
$mail->Password = 'DW8JT8RAh{FN';                           // SMTP password
//$mail->Username = 'contact@evisa-india.com';                 // SMTP username
//$mail->Password = 'Hello@123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

//$mail->setFrom('info@evisa-india.com', 'e-visa');
//$mail->addAddress('sachbhardwaj9@gmail.com', ''); 
//$mail->addAddress('seo@sabsoftzone.com', '');     
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


<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    

     
     
        
<?php include('include/footer.php'); ?>
        
		<a data-scroll href="#header" id="scroll-to-top"><i class="arrow_up"></i></a>
	
		<!-- jQuery Lib -->
		<script src="js/vendor/jquery-1.12.4.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/vendor/bootstrap.min.js"></script>
		<!-- Tether JS -->
		<script src="js/vendor/tether.min.js"></script>
        <!-- Counterup JS -->
		<script src="js/vendor/jquery.counterup.min.js"></script>
        <!-- waypoints js -->
		<script src="js/vendor/jquery.waypoints.v2.0.3.min.js"></script>
        <!-- Imagesloaded JS -->
        <script src="js/vendor/imagesloaded.pkgd.min.js"></script>
		<!-- OWL-Carousel JS -->
		<script src="js/vendor/owl.carousel.min.js"></script>
		<!-- Nivo Slider JS -->
		<script src="js/vendor/jquery.nivo.slider.pack.js"></script>
		<!-- isotope JS -->
		<script src="js/vendor/jquery.isotope.v3.0.2.js"></script>
		<!-- Smooth Scroll JS -->
		<script src="js/vendor/smooth-scroll.min.js"></script>
		<!-- venobox JS -->
		<script src="js/vendor/venobox.min.js"></script>
        <!-- ajaxchimp JS -->
        <script src="js/vendor/jquery.ajaxchimp.min.js"></script>
        <!-- Slick Nav JS -->
        <script src="js/vendor/jquery.slicknav.min.js"></script>
        <!-- Webticker JS -->
        <script src="js/vendor/jquery.webticker.min.js"></script>
        <!-- Wow JS -->
        <script src="js/vendor/wow.min.js"></script>
		<!-- Contact JS -->
		<script src="js/contact.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>
		
		
		
		<!-- Google Code for Evisa Inida Conversion Page Start -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 979558999;
var google_conversion_label = "ZGbICPr_zIMBENfEi9MD";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/979558999/?label=ZGbICPr_zIMBENfEi9MD&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- Google Code for Evisa Inida Conversion Page End-->

    </body>


</html>