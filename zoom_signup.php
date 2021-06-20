<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
include 'header.php';?>

<script src="<?php echo SITE_ROOT; ?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT; ?>js_insol/jquery.validate-latest.js"></script>

<script type="text/javascript">
function checkNum(num)
{
    var w = "";
    var v = "0123456789";
    for (i=0; i < num.value.length; i++)
    {
    x = num.value.charAt(i);
    if (v.indexOf(x,0) != -1) w += x;
    }
    num.value = w;
}


</script>
<script>
function integerOnly(num)
{
    var w = "";
    var v = ".0123456789";
    for (i=0; i < num.value.length; i++)
    {
      x = num.value.charAt(i);
      if (v.indexOf(x,0) != -1) w += x;
    }
    num.value = w;
}

</script>



<div class="clearfix banner">
	<div class="container">
    	<h1>Webinar Registration</h1>
    </div>
</div>



<?php

include "library_insol/class.phpmailernew.php";

if (isset($_POST['submit'])) {

    $name = $_POST['title'] . ' ' . $_POST['first_name'] . ' ' . $_POST['middle_name'] . ' ' . $_POST['last_name'];
    $email = $_POST['email'];
    $mob = $_POST['mob'];
    $prof = $_POST['prof'];

    $connection = mysqli_connect("localhost", "sabsofti_user", "Yrs[aidZ&8gA", "sabsofti_insol_india") or die(mysqli_error($mysqli));
    $query = "INSERT INTO zoom(name, email, mob, profession) VALUES ('$name', '$email', '$mob', '$prof')";
    $result = mysqli_query($connection, $query);

    $query_read = "SELECT * FROM zoom order by id desc limit 1";
    $result_read = mysqli_query($connection, $query_read);

    $show = mysqli_fetch_array($result_read);

    $MAIL_BODY = '';
    $MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0" >';
    $MAIL_BODY .= '<tbody>';
    $MAIL_BODY .= '<tr>';
    $MAIL_BODY .= '<td>';
    $MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif;padding:30px;" align="center">';
    $MAIL_BODY .= '<tbody>';
    $MAIL_BODY .= '<tr>';
    $MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="http://insolindia.com/includes_insol/images/logo_index.png" alt=""/></td>';
    $MAIL_BODY .= '</tr>';

    $MAIL_BODY .= '<tr>';
    $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">New Member Signed For Meeting.</td>';
    $MAIL_BODY .= '</tr>';
    $MAIL_BODY .= '<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;padding:10px;">

                                            <h1 style="color: #2E3192; font-size:16px;">Member Details.</h1>
            								<p style="line-height: 29px;">Name:- ' . $_POST['title'] . ' ' . $_POST['first_name'] . ' ' . $_POST['middle_name'] . ' ' . $_POST['last_name'] . '</p>
            							    <p style="line-height: 29px;">Email:- ' . $_POST['email'] . '</p>
            							    <p style="line-height: 29px;">Contact No.:- ' . $_POST['mob'] . '</p>
            							    <p style="line-height: 29px;">Profession:- ' . $_POST['prof'] . '</p><br>
            							<p style="line-height: 29px;">	Do you want to approve or not:-</p>

            							<a href="http://www.insolindia.com/zoom_meeting_confirm.php?id=' . $show['id'] . '&dec=yes"  style="color: #fff;background-color: #5cb85c;border-color: #4cae4c;    display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 4px;">Approve</a>
            							<a href="http://www.insolindia.com/zoom_meeting_confirm.php?id=' . $show['id'] . '&dec=no"style="color: #fff;background-color: #d9534f;border-color: #d9534f;    display: inline-block;padding: 6px 12px;margin-bottom: 0;font-size: 14px;font-weight: 400;line-height: 1.42857143;text-align: center;white-space: nowrap;vertical-align: middle;-ms-touch-action: manipulation;touch-action: manipulation;cursor: pointer;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;background-image: none;border: 1px solid transparent;border-radius: 4px;">Decline</a>
            								                                        </td>
                                    </tr>';

    $MAIL_BODY .= '<tr>';
    $MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';
    $MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br />T: 011 49785744 M:+91-8588883534 ';
    $MAIL_BODY .= 'Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>';
    $MAIL_BODY .= '</td>';
    $MAIL_BODY .= '</tr>';
    $MAIL_BODY .= '</tbody>';
    $MAIL_BODY .= '</table>';
    $MAIL_BODY .= '</td>';
    $MAIL_BODY .= '</tr>';
    $MAIL_BODY .= '</tbody>';
    $MAIL_BODY .= '</table>';

// $email = $_REQUEST['email'];
    // $message = $_REQUEST['message'];

    $mail = new phpmailer;

    $mail->IsSMTP();
//$mail->Host     = "mail.acecabs.in.cust.a.hostedemail.com";
    //$mail->Username = "noreply@acecabs.in";
    //$mail->Password = "Newpass@0112";

    $mail->Host = "103.21.58.112";
//$mail->Username = "noreply@acecabs.in";
    //$mail->Password = "dOvb15^8";
    $mail->Username = "noreply@insolindia.com";
    $mail->Password = "f2B7~w)C[5d4";

    $mail->Port = 25;
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = false;

    $mail->From = "contact@insolindia.com";

    $mail->FromName = "insolindia";
    $mail->ContentType = "text/html";

    $to = 'contact@insolindia.com';
    $mail->Subject = "New Member Registered for Webinar";

    $mail->AddAddress("contact@insolindia.com");
    $mail->Body = "$MAIL_BODY";

    $mailSent = $mail->send();
    $mail->ClearAddresses();

    if ($mailSent):
        echo '<div class="alert alert-success" role="alert">
						   <div class="container">
						  Mail has been sent successfully
						  </div>
						</div>';
    else:
        echo "Sorry cannot process your request.";
    endif;
    ob_flush();
}

?>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-12 col-sm-12 inner_page_right">

          	<div class="row">
				<div class="col-md-10" style="padding-right: 0px;">
				    <br>
					<div class="row">
    					<form action="" method="POST" name="frmReg" id="frmReg">
                        <div class="col-md-12">
                            <h4>Name</h4>
                        </div>
                        <div class="col-md-4">
    						<div class="form-group">
    							<label>Title  <span>*</span></label>
    							<select class="form-control" name="title" id="title">
    								<option value="">Select Title</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Prof.">Prof.</option>
                                     <option value="Hon'ble Mr. Justice.">Hon'ble Mr. Justice.</option>
                                     <option value="Hon'ble Ms. Justice.">Hon'ble Ms. Justice.</option>
                                </select>
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>First Name <span>*</span></label>
    							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="" maxlength="100" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Middle Name <span></span></label>
    							<input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="" maxlength="50" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Last Name <span>*</span></label>
    							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="" maxlength="50" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Mobile <span>*</span></label>
    							<input type="text" class="form-control" name="mob" id="mobile" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
    							<input type="text" class="form-control" name="email" id="email" placeholder="">
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Profession <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
    							<input type="text" class="form-control" name="prof" placeholder="">
    						</div>
    					</div>



    					<div class="col-xs-6"></div>
    					<div class="clr height15"></div>
    					<div class="col-md-12">
                            <div style="color:#23408C">Please fill the form as per requirements and irrelevant sections may be filled as not applicable or N/A. </div>
                        </div>
                        <div class="clr height15"></div>
                        <div class="col-md-6">
    						<div class="form-group">
    						  <button type="submit" class="btn btn-primary" name="submit" id="INPROCESS">Submit</button>
    						</div>
    					</div>
    					<div class="col-md-6"></div>
    				    </form>
				    </div>

				</div>
			</div>
        </div>
    </div>
</div>



<?php include 'footer.php';?>