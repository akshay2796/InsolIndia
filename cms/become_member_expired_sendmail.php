<?php
session_start();
error_reporting(0);
include("ajax_include.php");

define("PAGE_AJAX","ajax_become_member.php");
define("PAGE_LIST","become_member_list.php");
  
?>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.validate-latest.js"></script>

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

$rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$member_id,'=', '', '' , "" );   
    
$member_id = stripslashes($rsGET[0]["member_id"]);
$reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);
$reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);

$reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);
$reg_number = stripslashes($rsGET[0]["reg_number"]);

$title = stripslashes($rsGET[0]["title"]);
$first_name = stripslashes($rsGET[0]["first_name"]);
$middle_name = stripslashes($rsGET[0]["middle_name"]);
$last_name = stripslashes($rsGET[0]["last_name"]);
$name="";
$name = $title." ".$first_name;
if($middle_name !='')
{
    $name = $name." ".$middle_name;
}
$name = $name." ".$last_name;
$name = ucwords(strtolower($name));

$address = stripslashes($rsGET[0]["address"]);
$city = stripslashes($rsGET[0]["city"]);
$country = stripslashes($rsGET[0]["country"]);
$pin = stripslashes($rsGET[0]["pin"]);

$full_address = $address;
$full_address = $full_address .", ".$city;
$full_address = $full_address .", ".$country;
if($pin !='')
{
    $full_address = $full_address ." - ".$pin;
}

$permanent_address = stripslashes($rsGET[0]["permanent_address"]);
$permanent_city = stripslashes($rsGET[0]["permanent_city"]);
$permanent_country = stripslashes($rsGET[0]["permanent_country"]);
$permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);

$permanent_full_address = $permanent_address;
$permanent_full_address = $permanent_full_address .", ".$permanent_city;
$permanent_full_address = $permanent_full_address .", ".$permanent_country;
if($permanent_pin !='')
{
    $permanent_full_address = $permanent_full_address ." - ".$permanent_pin;
}


$telephone = stripslashes($rsGET[0]["telephone"]);
if($telephone !='')
{
    $telephone = 'T. '.$telephone;
}


$mobile = stripslashes($rsGET[0]["mobile"]);
if($mobile !='')
{
    $mobile = ' M. '.$mobile;
}
else
{
    $mobile = '';
}



$email = stripslashes($rsGET[0]["email"]);
$password = stripslashes($rsGET[0]["password"]);

$i_am = stripslashes($rsGET[0]["i_am"]);

$other_i_am = stripslashes($rsGET[0]["other_i_am"]);
if($other_i_am !='')
{
    $i_am = $i_am.", ".$other_i_am;
}

$insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);
$insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);
$insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);
$registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);
$registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);
$young_practitioner = stripslashes($rsGET[0]["young_practitioner"]);
$young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);
$interested = stripslashes($rsGET[0]["interested"]);
$terms = stripslashes($rsGET[0]["terms"]);
$committed = stripslashes($rsGET[0]["committed"]);
$payment_text = stripslashes($rsGET[0]["payment_text"]);
$payment_status = stripslashes($rsGET[0]["payment_status"]);
$register_status = strtolower(stripslashes($rsGET[0]["register_status"]));
$sig_member = stripslashes($rsGET[0]["sig_member"]);





$MAIL_BODY = '';
$MAIL_BODY .= '<form action="expiredmail.php" method="post">';
$MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
    $MAIL_BODY .= '<tbody>';
        $MAIL_BODY .= '<tr>';
            $MAIL_BODY .= '<td>';
                $MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';
                    $MAIL_BODY .= '<tbody>';
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>';
                        $MAIL_BODY .= '</tr>';
                       
                            
               
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold; text-transform: capitalize;">Dear '.$name.'</td>';
                        $MAIL_BODY .= '</tr>';
                        // if($sig_member == intval(0))
                        // {
                        $MAIL_BODY .='<tr>
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
                        // 								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>
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
$MAIL_BODY .= '<input type="submit" value="send" name="mail">';
    $MAIL_BODY .= '<a href="javascript:void(0);" id="submit" value="'.$member_id.'"><img src="'.SITE_IMAGES.'submit.png" alt=""/></a>';
    $MAIL_BODY .= '</form>;
</div>
<div id="INPROCESS_1" style="display: none;"></div>';


echo $MAIL_BODY;
?>

  
 
