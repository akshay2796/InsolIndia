<?php 

  extract($_REQUEST);
  if($submit=='submit')
  {
     $msg='';
    $msg.="Name: $name<br />\r\n";
    $msg.="Email Id : $email<br />\r\n";
    $msg.="Phone. : $phone<br />\r\n";
    $msg.="Subject : $subject<br />\r\n";
    $msg.="Message : $message<br />\r\n";
    
    $to='seo@sabsoftzone.com,santoshbeats@gmail.com';
     //$to='dev@sabsoftzone.com';
    $sub="Your Enquiry from SABsoftzone Contact Page";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: SABsoftzone <info@sabsoftzone.com>' . "\r\n"; 
    $send=mail($to, $sub, $msg, $headers);
    if($send)
    {
     $msg='Your Query has been Send Successfully !';
    }
    else
    {
      $msg='Sorry! please try again or contact service provider.';
    }



}
 ?>


<!DOCTYPE html>
<html class="no-js">

<head>
  <title>Contact and Coffee - Online Marketing Company, Social Media Marketing, Digital Marketing Agency In Delhi (India), Logo Design company in Delhi-NCR</title>  
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="affordable website design, web development solutions, web hosting, domain registration, seo company, custom webs design, seo marketing, web hosting and maintenance, graphic design" />
  <meta name="description" content="Call us  +91 9811886234 for affordable website design, web development solutions, web hosting. We also provide a full competitor analysis to determine the best ways to improve your website SEO Rankings." />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="viewport" content="width=device-width" />

<!--*************************
*							*
*         CSS FILES			*
*							*
************************* -->

<!--imports Google Maps API key-->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyB4_O6h-ezvPegVi23ZzEJV9FPuNeHOWXA&amp;sensor=true" ></script>

<!-- Google Fonts -->
<link rel="css/font_style.css" rel="stylesheet" type="text/css">
<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700,800&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>	-->

<!-- Due to IE8 inabillity to load multiple font weights from Google Fonts, we need to import them separately -->
<!--[if lte IE 8]>
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:300" /> 
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:700" /> 
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:800" />
<![endif]-->

<!-- Font Awesome -->
<link href="css/font-awesome.min.css" rel="stylesheet">

<!--imports the main css file-->
<link rel="stylesheet" href="css/skins/tangerine.css" />
<!-- used for animation effects on elements -->
<link rel="stylesheet" href="css/animate.min.css" />
<!-- styling for Nivo Lightbox gallery -->
<link rel="stylesheet" href="css/nivo-lightbox.css" />
<link rel="stylesheet" href="css/default.css" />
<!-- styles for the Revolution Slider -->
<link rel="stylesheet" href="plugins/rs-plugin/css/settings.css" media="screen" />
<!--imports the media queries css file-->
<link rel="stylesheet" href="css/responsive.css" />
<link rel="stylesheet" href="css/layout.css" />




<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >

<!--*************************
*							*
*      JAVASCRIPT FILES	 	*
*							*
************************* -->

<!-- imports modernizr plugin for detecting browser features -->
<script src="js/modernizr.custom.js"></script>

<!--[if IE 8]>
	<link href="css/ie8.css" rel="stylesheet" />
	<script src="js/respond.js"></script>	
<![endif]-->

<style type="text/css">
	
.textbox{width: 100% !important;
}


ul li { list-style: none; }



.faq li { padding: 20px; padding-left: 3px;padding-right: 5px}

.faq li.q {
  background: #4FC2E;
  font-weight: bold;
  font-size: 120%;
  border-bottom: 1px #ddd solid;
  cursor: pointer;
}

.faq li.a {
  background:white;
  display: none;
  color:black;
  line-height: 26px;
}

.rotate {
  -moz-transform: rotate(90deg);
  -webkit-transform: rotate(90deg);
  transform: rotate(90deg);
}
@media (max-width:800px) {

#container { width: 90%; }
}



</style>

</head>

<body>

<!-- Preloader -->
	<div id="preloader">
	    <div id="status"></div>
	</div>



<?php
 include('includes/header.php'); ?>

<section class="page-title section-bg-1">
	<div class="page-title-inner container-center cf">
	
		<div class="page-title-icon"><i class="fa fa-envelope"></i></div>
	
		<h1>Contact and Coffee</h1>		
		
		<div class="breadcrumbs">
			<span>// You Are Here:</span> <a href="index.php">Home</a> / Contact Page	
		</div><!-- end breadcrumbs -->
		
	</div><!-- end container-center -->
</section><!-- end page-title -->


<section class="content">
	<div class="container-center">	




		<div class="col-row">
			
			<div class="col-md-4">
				<div class="section-title align-left inner">
						<h2 class="heading-big" style="border-left:4px solid #3e87bf;padding-left:10px">Address</h2>
					</div>
					
					<strong><i class="fa fa-envelope"></i> &nbsp;E-mail:</strong>  <a href="mailto:info@sabsoftzone.com">info@sabsoftzone.com</a>  <br />
					<strong><i class="fa fa-phone"></i> &nbsp;Contact No:</strong><a href="tel:+91-9811886234">+91-9811886234</a><br />
					<i class="fa fa-map-marker" style="color: black"></i> &nbsp;Plot No 585, Jaypee Complex<br>
                                <sapn style="padding-left: 1em"  >Munirka, New Delhi-110067, Delhi</sapn>
                               
                                
			</div><!-- end one-half -->
			
			<div class="col-md-8">
				
				<div class="section-title align-left inner">
					<h2 class="heading-big" style="border-left:4px solid #3e87bf;padding-left:10px">How To Contact</h2>
				</div>
				
				<p style="text-align: justify;">Thank you visit SABsoftzone, When you fill out our request for a quote form, we will get back to you quickly with an estimated cost for your project based on your specific needs. Since every project is unique, we need to know exactly what you are looking to have created. The more information you provide, the more accurate our estimate will be.
				</p>
				
				<div class="contact-info col-row">
					
					<!-- end  -->
					
				</div><!-- end contact-info -->
			</div><!-- end one-half -->
		</div><!-- end col-row -->	





		<div class="col-row">
			<div class="col-md-6">
				<div class="section-title align-left inner">
						<h2 class="heading-big" style="border-left:4px solid #3e87bf;padding-left:10px;margin-bottom:-23px;" >Contact Form</h2>
                     
					</div>
                       <p style="color:#F00; font-size:10px; text-align:center;"><?php echo $msg; ?></p>
				<form action="" method="post">						
					<label for="name">Name*:</label>
					<br>
					<input  class="textbox" type="text" name="name" id="name" required /> 
					<br>
					<label for="email">E-mail*:</label>
					<br>
					<input  class="textbox" type="text" name="email" id="email" required/>
					<br>
                    <label for="name">Mobile*:</label>
                    <br>
                    <input  class="textbox" type="text" name="phone" id="phone" required/>
                    <br>
					<label for="subject">Subject: </label>
					<br>
					<input  class="textbox" type="text" name="subject" id="subject" required/> 
					<br>				
					<label for="message">Message*:</label>
					<br>
					<textarea class="textbox" name="message" id="message"></textarea> 
					<br>
					<input type="submit" name="submit" id="submit" value="submit" />
					<br />
					<p id="message-outcome"><?php //echo $msg; ?></p>
				</form>
			</div><!-- end one-half -->
			
			<div class="col-md-6">
				
				<div class="section-title align-left inner">
					<h2 class="heading-big"  style="border-left:4px solid #3e87bf;padding-left:10px">FAQ</h2>
				</div>
				
				<ul class="faq">
        <li class="q"><img src="images/arrow (2).png"> What is SEO? How does it work?</li>
        <li class="a">SEO or Search Engine Optimization is a process to optimize the visibility for both search engine users and search engines. When investing in the design and execution of your business website, you cannot forget about SEO for your site. Without this, your website will not fulfill its primary function such as sales or service - because how can it if the customer can't find you on the internet?</li>
        
        <li class="q"><img src="images/arrow (2).png"> Why do I need SEO services on my website?</li>
        <li class="a">SEO services help your site rank better in the search engines organically. Better rankings in relevant terms will drive more traffic to your site, creating the ability for better exposure and revenue stream. With the help of SEO, your website will be easily visible on search engines.</li>
         
        <li class="q"><img src="images/arrow (2).png"> Can I do SEO on my own website?</li>
        <li class="a">Inexperienced site owners may take years to get the top rankings for online success. Also remember, if you had a mistake, your website gets de-ranked or banned from search results. Your business will be damaged. You can do it only if you have enough experiences of SEO.</li>
        
        <li class="q"><img src="images/arrow (2).png"> What does SMO stand for?</li>
        <li class="a">SMO, also known as Social Media Marketing, is the process of creating and optimizing content for social media networks. Facebook, Twitter, Instagram, Google + and Linked In are some of the most popular social networks. Social media is becoming an integral part of life online as social websites and applications proliferate.</li>

        <li class="q"><img src="images/arrow (2).png"> What does PPC stand for?</li>
        <li class="a">PPC commonly referred to as Pay Per Click is used in SEM campaigns. SEM managers create ad campaigns and bid to display them on the Search Engine Results Pages. Every time a users click on an ad the client pays a fee to the search engine, thus the term "pay per click". The higher the bid the better the position.</li>
        
       </ul>
					</div>




							    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script >//Accordian Action
var action = 'click';
var speed = "500";


//Document.Ready
$(document).ready(function(){
  //Question handler
$('li.q').on(action, function(){
  //gets next element
  //opens .a of selected question
$(this).next().slideToggle(speed)
    //selects all other answers and slides up any open answer
    .siblings('li.a').slideUp();
  
  //Grab img from clicked question
var img = $(this).children('img');
  //Remove Rotate class from all images except the active
  $('img').not(img).removeClass('rotate');
  //toggle rotate class
  img.toggleClass('rotate');

});//End on click




});//End Ready
</script>
					
					<!-- end  -->
					
				</div><!-- end contact-info -->
			</div><!-- end one-half -->
		</div><!-- end col-row -->	
	</div><!-- end container-center -->
</section><!-- end content -->
<br>
<br>
<section>
	<div id="google-map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28035.656707484166!2d77.174037!3d28.556034!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xa274292a66ce7de3!2sSABsoftzone!5e0!3m2!1sen!2sus!4v1463123509215" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
	</div>
</section>

<?php include('includes/twitter_link.php'); ?>
<?php include('includes/footer.php'); ?>

<div class="scroll-top"><a href="#"><i class="fa fa-angle-up"></i></a></div>

<!--*************************
*							*
*      JAVASCRIPT FILES	 	*
*							*
************************* -->

<!--imports Google Maps API key-->
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=AIzaSyB4_O6h-ezvPegVi23ZzEJV9FPuNeHOWXA&amp;sensor=true" ></script>

<!--imports jquery-->
<script src="js/jquery-1.10.2.min.js"></script>
<script src="js/jquery-migrate-1.1.0.min.js"></script>	

<!-- used for the contact form -->
<script src="js/jquery.form.js"></script>
<!-- used for the the fun facts counter -->
<script src="js/jquery.countTo.js"></script>
<!-- for displaying flickr images -->
<script src="js/jflickrfeed.min.js"></script>
<!-- used to trigger the animations on elements -->
<script src="js/waypoints.min.js"></script>
<!-- used to stick the navigation menu to top of the screen on smaller displays -->
<script src="js/waypoints-sticky.min.js"></script>
<!-- used for rotating through tweets -->
<script src="js/vTicker.js"></script>
<!-- imports jQuery UI, used for toggles, accordions, tabs and tooltips -->
<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
<!-- used for smooth scrolling on local links -->
<script src="js/jquery.scrollTo-1.4.3.1-min.js"></script>
<!-- used for opening images in a Lightbox gallery -->
<script src="js/nivo-lightbox.min.js"></script>
<!-- used for displaying tweets -->
<script src="js/jquery.tweet.js"></script>
<!-- flexslider plugin, used for image galleries (blog post preview, portfolio single page) and carousels -->
<script src="js/jquery.flexslider-min.js"></script>
<!-- used for sorting portfolio items -->
<script src="js/jquery.isotope.js"></script>
<!-- for detecting Retina displays and loading images accordingly -->
<script src="js/retina-1.1.0.min.js"></script>
<!-- for dropdown menus -->
<script src="js/superfish.js"></script>
<!-- used for sharing post pages -->
<script src="js/jquery.sharrre.min.js"></script>
<!-- easing plugin for easing animation effects -->
<script src="js/jquery-easing-1.3.js"></script>
<!-- Slider Revolution plugin -->
<script src="plugins/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>			
<script src="plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>			

<!--imports custom javascript code-->
<script src="js/custom.js"></script>
<!--preview oonly option panel code -->
<script src="js/options.js"></script>

</body>

</html>