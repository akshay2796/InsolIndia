<?php ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
include 'header.php';?>

<script src="<?php echo SITE_ROOT; ?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT; ?>js_insol/jquery.validate-latest.js"></script>




<?php
$connection = mysqli_connect("localhost", "root", "root", "insolindia") or die(mysqli_error($mysqli));
$id = $_GET['id'];
$dec = $_GET['dec'];
$query_read = "SELECT * FROM zoom WHERE id='$id'";
$result = mysqli_query($connection, $query_read);

$show = mysqli_fetch_array($result);
$email = $show['email'];
if ($dec == 'yes') {

    $query_update = "UPDATE zoom SET status = 'Approved' WHERE id = '$id'";
    $result_update = mysqli_query($connection, $query_update);

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
    $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear ' . $show['name'] . '</td>';
    $MAIL_BODY .= '</tr>';
    $MAIL_BODY .= '<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;padding:10px;">
            							<p style="line-height: 29px;">Thank you for your interest in our INSOL India, forthcoming SIG24 Samvaad Webseries V.</p>
            							<p style="line-height: 29px;">We confirm your registration for webinar topic: on “Liquidation in COVID – challenges", on Thursday, 20th August 2020 at 4:00 PM.</p>
            							<p style="line-height: 29px;">Like any other Webinar, participants will need a computer and internet connection to join.<br>
The platform is entirely browser-based – no downloads will be required to enter the webinar. The total time is one hour and fifteen minutes, which will include a Q&A session also.</p>
            							<p style="line-height: 29px;">Please click the link below to join the webinar: <a href="https://bit.ly/3iM8PKO">https://bit.ly/3iM8PKO</a></p>
            							<p style="line-height: 29px;">After registering, you will receive a confirmation email containing information about joining the webinar.</p>
            							<p style="line-height: 29px;">Thank you again for your registration. If you have any questions, please do let us know.</p><br>
            							<br />
            							<p style="line-height: 29px;">Warm Regards,</p>
            							<p style="line-height: 29px;">Aditi Khanna<br>Manager</p>
            							<img src="http://insolindia.com/includes_insol/images/logo_index.png" alt=""/>
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

    include "library_insol/class.phpmailernew.php";

// $email = $_REQUEST['email'];
    // $message = $_REQUEST['message'];

    $mail = new phpmailer;
    $mail->CharSet = "UTF-8";
    $mail->Encoding = "base64";

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

    $mail->FromName = "Insol India";
    $mail->ContentType = "text/html";

    $to = $email;
    $mail->Subject = "Webinar Registration - Registration SIG24 SAMVAAD WERBSERIES V - Liquidation in COVID – challenges";

    $mail->AddAddress("$email");
    $mail->Body = "$MAIL_BODY";

    $mailSent = $mail->send();
    $mail->ClearAddresses();

    if ($mailSent):

        $previousPage = $_SERVER["HTTP_REFERER"];
        header('Location: ' . $previousPage);
    else:
        echo "Sorry cannot process your request.";
    endif;
    ob_flush();

    ?>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-12 col-sm-12 inner_page_right">
            <h2>Member has been approved</h2>
            <div class="row">
                <div class="col-md-10" style="padding-right: 0px;">
                    <h3 class="subsubHead">Mail has been sent to <?php echo $show['name']; ?></h3>
                    <br>


                    <a href="/" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
} else {
    $query_update = "UPDATE zoom SET status = 'Declained' WHERE id = '$id'";
    $result_update = mysqli_query($connection, $query_update);
    ?>
<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-12 col-sm-12 inner_page_right">
            <h2>Member has been declained</h2>
            <div class="row">
                <div class="col-md-10" style="padding-right: 0px;">
                    <br>

                    <a href="/" class="btn btn-primary">Go Home</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
}

?>

<?php include 'footer.php';?>