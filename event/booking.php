<?php
extract($_REQUEST);
$id=$_REQUEST['id'];
$conn = mysqli_connect("localhost","root","","event_member");
$sql = "SELECT * FROM event_reg WHERE id='$id'";
$result = mysqli_query($conn, $sql);  
$row = mysqli_fetch_array($result);
 

if(isset($_POST['submit']))
	
		{
		    extract($_REQUEST);
		    $id=$_REQUEST['id'];
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

			id=$_REQUEST['id'];
		    title=$_POST['title'];
			firstname=$_POST['firstname'];
			surname=$_POST['surname'];
			yourbadge=$_POST['yourbadge'];
			firmname=$_POST['firmname'];
			address=$_POST['address'];
			tel=$_POST['tel'];
			email=$_POST['email'];
			insolmember=$_POST['insolmember'];
			signature=$_POST['signature'];
			date=$_POST['date'];
			hotel=$_POST['hotel'];
			
			";
		 	
	
		$insert_execute=mysqli_query($conn,$insert_query);
		if($insert_execute>0)
			{
			echo "Data Inserted";
			}
		else
			{
			echo "Data Not Inserted";
			}
		
			
$sql = "SELECT * FROM event_reg WHERE id='$id'";
$result = mysqli_query($conn, $sql);  
$row = mysqli_fetch_array($result);
 			
			$id=$_REQUEST['id'];
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

          
	
 $body.=

'<table cellpadding="10px" border="1"   font-family: arial, sans-serif;
    ;width: 100%;font-size: 15px;><tbody>
	<tr ><td colspan="2" bgcolor="lightgray" ><b><p align="center" >e-Tourist Visa (eTV) Application Details</p></b></td></tr>

<tr><td colspan="2"><b>Applicant</b></td></tr>
<tr><td>title</td><td width="50%">'.$title.'</td></tr>
<tr><td>first name</td><td width="50%">'.$firstname.'</td></tr>
<tr><td>Surname</td><td>'.$surname.'</td></tr>
<tr><td>your badge</td><td>'.$yourbadge.'</td></tr>
<tr><td>First Name</td><td>'.$firmname.'</td></tr>
<tr><td>Address</td><td>'.$address.'</td></tr>
<tr><td> Tel</td><td>'.$tel.'</td></tr>
<tr><td>Email</td><td>'.$email.'</td></tr>
<tr><td>InsolMember</td><td>'.$insolmember.'</td></tr>
<tr><td>signature</td><td>'.$signature.'</td></tr>
<tr><td>Date</td><td>'.$date.'</td></tr>
<tr><td>Hote</td><td>'.$hotel.'</td></tr>



		</tbody>
	</table>';
	
	



 //$to='arti.artie@gmail.com';
 $to='dev@sabsoftzone.com';
 $sub="insolindia Annual Conference Registration Form";
  
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers.= 'From:dev@gmail.com' . "\r\n";
 // $headers .= 'BCc : artilife@gmail.com'. "\r\n"; 
 // $headers .= "BCc : artie.chauhan@gmail.com";
   $headers .= 'BCc : seo@sabsoftzone.com'. "\r\n"; 
 $headers .= "BCc : dev@sabsoftzone.com";

  $send_new=mail($to, $sub, $body, $headers);
if($send_new==true)
{
     $flash='Thank you for contacting us - we will get back to you soon! ';
  }
  else{
 
      $flash= "Sorry there was an error sending your message. Please try again later";
      
      }



}

?>
		

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112312132-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112312132-1');
</script>

<!-- /main-cont -->


<!-- // scripts // -->
  <script src="pay/js/jquery.1.7.1.js"></script>
  <script src="pay/js/jqeury.appear.js"></script>  
  <script src="pay/js/jquery.ui.js"></script> 
  <script src="pay/js/script.js"></script>
  <script src="pay/js/jquery.formstyler.js"></script> 
  <script src="pay/js/custom.select.js"></script>    
  <script type="text/javascript" src="js/twitterfeed.js"></script>
  <script>

  	$(document).ready(function(){
    $('.custom-select').customSelect();

		(function($) {
  		$(function() {
  			$('.checkbox input').styler({
  				selectSearch: true
  			});
  		});
		})(jQuery);
    
  		$(function() {
    	  $(document.body).on('appear', '.fly-in', function(e, $affected) {
      		$(this).addClass("appeared");
    	  });
    	  $('.fly-in').appear({force_process: true});
  		});
  	});
  </script>
<!-- \\ scripts \\ --> 



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