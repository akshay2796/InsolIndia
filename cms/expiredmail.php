<?php

ob_start();
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
include "../library_insol/class.phpmailernew.php";

?>



<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery.validate-latest.js"></script>

<!--<script language="javascript" type="text/javascript">-->
<!--$(document).ready(function(){-->


<!--    $("#submit").click(function(){-->
<!--        var ID = $(this).attr("value");-->


<!--        $.ajax({-->
<!--           type: "POST",-->
<!--           url: "",-->
<!--           data: "type=sendexpiredMAIL&ID=" + ID,-->
<!--    	   beforeSend: function(){-->
<!--    	       $("#INPROCESS").hide();-->
<!--               $("#INPROCESS_1").show(); -->
<!--               $("#INPROCESS_1").html("<div style='text-align: center;'><i class='icon iconloader'></i> Processing...</div>"); -->
<!--            },-->

<!--           success: function(msg){ -->



<!--                var spl_txt = msg.split("~~~");-->
<!--                if(spl_txt[1] == '1')-->
<!--                {-->
<!--                    colorStyle = "successTxt";                   -->
<!--                } -->
<!--                else-->
<!--                {-->
<!--                    colorStyle = "errorTxt";-->
<!--                }-->


<!--                $("#INPROCESS_1").html("<div style='text-align: center;' id='inprocess'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");-->

<!--                setTimeout(function(){-->

<!--                    if( parseInt(spl_txt[1]) == parseInt(1) )-->
<!--                    {                                -->

<!--                        parent.window.location.reload();-->
<!--                    }-->
<!--                    else-->
<!--                    {     -->
<!--                        $("#INPROCESS").show();-->
<!--                        $("#INPROCESS_1").hide();-->
<!--                    }-->

<!--                }, 2000);   -->

<!--           }-->


<!--        });-->


<!--    });  -->


<!--});-->
<!--</script>-->


<?php

$member_id = $_REQUEST['member_id'];
$connection = mysqli_connect("localhost", "sabsofti_user", "Yrs[aidZ&8gA", "sabsofti_insol_india") or die(mysqli_error($mysqli));
$query = "SELECT * FROM tbl_become_member WHERE member_id = $member_id";
$result = mysqli_query($connection, $query);
$show = mysqli_fetch_array($result);
echo $show['email'] . "<br>";
$title = $show['title'];
$first_name = $show['first_name'];
$middle_name = $show['middle_name'];
$last_name = $show['last_name'];
$email = $show['email'];

$MAIL_BODY = '';
$MAIL_BODY .= '<form action="expiredmail.php" method="post">';
$MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$MAIL_BODY .= '<tbody>';
$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td>';
$MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';
$MAIL_BODY .= '<tbody>';
$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="http://insolindia.com/includes_insol/images/logo_index.png" alt=""/></td>';
$MAIL_BODY .= '</tr>';

$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear ' . $title . ' ' . $first_name . ' ' . $middle_name . ' ' . $last_name . '</td>';
$MAIL_BODY .= '</tr>';
// if($sig_member == intval(0))
// {
$MAIL_BODY .= '<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                            <h1 style="color: #2E3192; font-size:16px;">Your membership has recently expired.</h1>

            							<p style="line-height: 29px;">	To retain your membership, you are requested to submit the renewal fee of Rs 7080/- (inclusive of 18% GST), through either of the following mechanism:</p>

            							<p style="line-height: 29px;">	Cheque in favour of: INSOL India(INSOL India, 5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014)<br>
            								NEFT / IMPS Axis Bank Limited, Jungpura, Delhi - 110014<br>
            								Account Number: 126010200004480<br>
            								IFSC Code: UTIB0003329<br></p>
            							<p style="line-height: 29px;">	Please note:  You are requested to send a screenshot of the proof of payment to contact@insolindia.com.
Once receipt, we will process your login credentials and issue the tax invoice. Kindly share your GST No. to enable us to raise the tax invoice.<br></p>
<p style="line-height: 29px;">In the meantime, if you have any concern, please feel free to reach out. <br>
We will be happy to assist you in any way we can.</p>

            								</p>
            								                                        </td>
                                    </tr>';
// }
// else
// {
//     $MAIL_BODY .= '<tr>
//                         <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
//                                 <h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>
//                                 <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>
//                                 <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>
//                                 Membership Number: ' .$reg_number_text.' <br>
//                                 <strong>Login ID:</strong> '.$email.' <br>
//                                 <strong>Password:</strong> '.$password.'<br><br>
//                                 For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>
//                         </td>
//                     </tr>';
// }

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
$MAIL_BODY .= '<div style="height:10px;"></div>';
$MAIL_BODY .= '<div style="text-align: center;" id="INPROCESS">';

$MAIL_BODY .= '<a href="javascript:void(0);" id="submit" value="' . $member_id . '"><img src="../includes_insol/images/.submit.png" alt=""/></a>';
$MAIL_BODY .= '</form>;
</div>
<div id="INPROCESS_1" style="display: none;"></div>';

echo $MAIL_BODY;
?>



<?php

if (isset($_POST['expmail'])) {

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
    $mail->SMTPDebug = true;

    $mail->From = "contact@insolindia.com";

    $mail->FromName = "insolindia";
    $mail->ContentType = "text/html";

    $to = $email;
    $mail->Subject = "Your Insol India Membership Has Been Expired";

    $mail->AddAddress("$email");
    $mail->Body = "$MAIL_BODY";
    $mail->AddCC("contact@insolindia.com");

    $mailSent = $mail->send();
    $mail->ClearAddresses();

    if ($mailSent):

        $previousPage = $_SERVER["HTTP_REFERER"];
        header('Location: ' . $previousPage);
        echo "Mail Successfully Sent";
    else:
        echo "Sorry cannot process your request.";
    endif;
    ob_flush();
}

?>