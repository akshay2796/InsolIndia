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
    

     
     
        
<?php // include('include/footer.php'); ?>
        
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


<?php error_reporting(0);
include('header.php'); 
?>
<head>
  
<link rel="stylesheet" type="text/css" href="css_insol/main.css">
<style>
  input[type=checkbox], input[type=radio] {
    margin: 4px 7px 2px;
    margin-top: 1px\9;
    line-height: normal;
    /* padding-left: 10px; */
}
</style>

</head>

<!--<script src="<?php echo SITE_ROOT;?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.validate-latest.js"></script> -->



<div class="container">
  <div class="row" style="    padding-bottom: 26px;">
<div class="col-md-12 col-sm-12 col-xs-12 firstcont">    
<h2 class="hedinginsol"><span class="insolindias">INSOL India</span><br>
 Annual Conference Registration Form </h2>
 <p class="theleela">13 – 14 November 2018, The Leela Palace, New Delhi</p>
<h3 class="deadline">Deadline for early registration fee: 15 October 2018</h3>
<p class="plesemail">
 

<b>Note:</b> This delegate registration form is valid for one delegate. This registration form can only<br>
be accepted if accompanied by full payment, which can be made by Cheque or NEFT.
</p>
<hr style="width:88%;margin-left:3.5%;border-top: 2px solid #bbb3b3;">

<!----------Form Section Start--------------->
 <form style="margin-top: 69px;">
    <div class="form-group">
      <label class="lebtitle">Title:</label>
      <input type="text" class="form-control tittl" id="title" placeholder="" name="title">
    </div>
    
<div class="form-group firsnames">
      <label class="lebfirst">First Name:</label>
      <input type="text" class="form-control firstnamee" id="email" placeholder="" name="firstname">
    </div>

<div class="form-group surnames">
      <label class="lebfsurn">Surname:</label>
      <input type="text" class="form-control surname" id="email" placeholder="" name="surname">
    </div>


    <div class="form-group">
      <label class="asyou">Name as you wish it to appear on your badge:</label>
      <input type="text" class="form-control nameas" id="pwd" placeholder="" name="yourbadge">
    </div>
    
    <div class="form-group">
      <label class="asyou">Firm Name:</label>
      <input type="text" class="form-control firmname" id="pwd" placeholder="" name="firmname">
    </div>
     <div class="form-group">
      <label class="asyou">Address:</label>
      <input type="text" class="form-control firmname" id="pwd" placeholder="" name="address">
    </div>

 <div class="form-group">
      <label class="asyou">Tel:</label>
      <input type="text" class="form-control tel" id="pwd" placeholder="" name="tel">
    </div>

 <div class="form-group emailses">
      <label class="emails">Email:</label>
      <input type="text" class="form-control emailss" id="pwd" placeholder="" name="email">
    </div>
  </form>

<p class="thedele"> The delegate registration fee includes entry to the technical sessions on Tuesday 13<br>
November, and Wednesday 14 November, conference lunches on 13 November and 14<br>
November, the Gala dinner on Tuesday 13 November. </p>
<hr style="width:88%;margin-left:3.5%;border-top: 2px solid #bbb3b3;">
<!---------->
<form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control tittl" id="email" placeholder="Registration Fees" name="email">
    </div>

 <div class="form-group">
      <input type="email" class="form-control tittl1" id="email" placeholder="13 – 14 November 2018" name="email">
    </div>
<div class="form-group">
      <input type="email" class="form-control tittl2" id="email" placeholder="INSOL Membership no" name="email">
    </div>
<div class="form-group">
      <input type="email" class="form-control tittl3" id="email" placeholder="Amount" name="email">
    </div>
</form>
<p style="margin-left: 67px; margin-top: -10px;">Payable</p>
<!--------------->
<h2 class="confran">Conference </h2>
<div class="almn">
  <p class="insolnumber">INSOL Member</p>
  <p class="rate">Rs. 18,800/-</p>
  <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email">
    </div>
  </form>
  <p class="res">Rs.</p>
    <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email" style="    margin-left: 70%;">
    </div>
  </form>
  <!-------------->
  <p class="insolnumber">Non-Member</p>
  <p class="rate">Rs. 23,600/-</p>
  <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email">
    </div>
  </form>
  <p class="res">Rs.</p>
    <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email" style="    margin-left: 70%;">
    </div>
  </form>
</div>
<!--------------->
<h2 class="paymentsm">Payment summary</h2>
<form style="margin-top: 69px;">
    <div class="form-group">
      <label class="lebtitle">If you wish to pay by cheque or NEFT, kindly fill in the below details</label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>

<div class="form-group">
      <label class="lebtitle">I enclose a cheque/draft/NEFT to the order of:</label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>
<div class="form-group">
      <label class="lebtitle">Cheque No:UTR No. Amount:Address (if different from address on previous page): </label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>

<div class="form-group">
      <label class="lebtitl">Signature:</label>
      <input type="email" class="form-control ifusss " id="email" placeholder="" name="email">
    </div>
<div class="form-group clse">
      <label class="lebtitl"> Date:</label>
      <input type="email" class="form-control dase " id="email" placeholder="" name="email">
    </div>


</form>

<p style="margin-left: 28px;">Special dietary requirements:<br>
If you have any dietary restrictions, please remember to identify yourself to the staff at each<br>
event. INSOL will try their best to accommodate any special dietary requests:</p>
<hr style="width:88%;margin-left:3.5%;border-top: 2px solid #bbb3b3;">
<p style="    margin-left: 27px;">
  Have you attended an INSOL India Conference previously? 
</p>
<form style="    margin-left: 27px;">
  <input type="checkbox" name="vehicle1" value="Bike">Yes<br>
  <input type="checkbox" name="vehicle2" value="Car">No<br>
</form>
<hr style="width:88%;margin-left:3.5%;border-top: 2px solid #bbb3b3;">
<p style="margin-left: 27px;text-align: justify;">
  Additional requirements:<br>
The hotels selected by INSOL India are fully wheelchair accessible. If you require further<br>
information please contact us.<br>
Hotel: Please indicate for our records which hotel you will be staying at:
  </p>
  <hr style="width:88%;margin-left:3.5%;border-top: 2px solid #bbb3b3;">
  <p style="margin-left: 27px;">
Delegate name, firm and country will be listed on the delegate list. Photos & video may be<br>
taken during the Conference for publication. Please bring your confirmation and photographic<br>
identification with you in order to collect your badge and Conference papers. <br/>
<div>
<input type="submit" name="submit">
</div>

  </p>
</div>
</div>
</div>
<?php include('footer.php'); ?>