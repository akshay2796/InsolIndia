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

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
  
    $("#submit").click(function(){
        var ID = $(this).attr("value");
        //alert(ID);
        
        $.ajax({
           type: "POST",
           url: "<?php echo PAGE_AJAX; ?>",
           data: "type=sendMail&ID=" + ID,
    	   beforeSend: function(){
    	       $("#INPROCESS").hide();
               $("#INPROCESS_1").show(); 
               $("#INPROCESS_1").html("<div style='text-align: center;'><i class='icon iconloader'></i> Processing...</div>"); 
            },
          
           success: function(msg){ 
                
                //alert(msg); 
               
                var spl_txt = msg.split("~~~");
                if(spl_txt[1] == '1')
                {
                    colorStyle = "successTxt";                   
                } 
                else
                {
                    colorStyle = "errorTxt";
                }
                
                
                $("#INPROCESS_1").html("<div style='text-align: center;' id='inprocess'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                
                setTimeout(function(){
                    
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {                                
                        //parent.$.fancybox.close();
                        parent.window.location.reload();
                    }
                    else
                    {     
                        $("#INPROCESS").show();
                        $("#INPROCESS_1").hide();
                    }
                    
                }, 2000);   
                
           }
           
           
        });
        
        
    });  
     
 
});
</script>


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
                            $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.'</td>';
                        $MAIL_BODY .= '</tr>';
                        if($sig_member == intval(0))
                        {
                        $MAIL_BODY .='<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                            <h1 style="color: #2E3192; font-size:16px;">We are delighted to renew your membership to INSOL India.</h1> 
            								<h3 style="color: #ED1C24; font-size: 16px;">Your membership number is '.$reg_number_text.'.</h3>
            								
                                            Your login details are provided below as some features on website are accessible by members only.<br><br>
            								
                                            <strong>Login ID:</strong> '.$email.' <br><br>
                                            <strong>Password:</strong> '.$password.'<br>
                                            <br><br>
                                            <div style="border-top:1px solid #ccc">&nbsp;</div>
                                            <div style="font-size:11px;">
                								<h3 style="color: #000; font-size: 13px;">INSOL India Membership Benefits</h3>
                                                <p><span style="color: #2E3192; font-weight:bold;">Conferences</span> 20% discount on registration fee for Individual Members in conferences organised by INSOL India. One annual conference and a series of workshops in different parts of the country.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">INSOL India Newsletter</span> INSOL India has a quarterly newsletter which will be sent to all the Members free of charge.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Electronic Newsletter</span> INSOL India is planning to start an electronic monthly newsletter in August 2017 which will emailed to all members.</p>
                                                </p><span style="color: #2E3192; font-weight:bold;">Membership of INSOL International</span> As a member of INSOL India, one becomes a member of INSOL International, whereby one also becomes part of a network of 10,000 members in over 80 countries around the world. This enables one, apart from getting INSOL India\'s electronic and printed newsletters, access INSOL International\'s monthly technical electronic news updates and quarterly journal INSOL World, and other resource materials at INSOL International\'s website (www.insol.org) including INSOL Technical Library containing INSOL publications, technical paper series, case studies etc. As a member, one is also able to use "search a member" tool under the Membership section to browse the database of INSOL International.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Committees</span> Members keen to actively participate in INSOL India activities can join various committees of INSOL India.</p>
                                            </div>
                                            
                                            
                                            
                                        </td>
                                    </tr>';
                        }
                        else
                        {
                            $MAIL_BODY .= '<tr>
                                                <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                        								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>
                                                        <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>
                                                        <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>
                                                        Membership Number: ' .$reg_number_text.' <br>
                                                        <strong>Login ID:</strong> '.$email.' <br>
                                                        <strong>Password:</strong> '.$password.'<br><br>
                                                        For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>
                                                </td>
                                            </tr>';
                        }
                        
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';
                                $MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br />Contact No. 011 49785744';
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
    $MAIL_BODY .= '<a href="javascript:void(0);" id="submit" value="'.$member_id.'"><img src="'.SITE_IMAGES.'submit.png" alt=""/></a>&nbsp;&nbsp;
</div>
<div id="INPROCESS_1" style="display: none;"></div>';


echo $MAIL_BODY;
?>

 
<?php





if(isset($_POST['paysucessmail'])){
    

// $email = $_REQUEST['email'];
// $message = $_REQUEST['message'];

$mail = new phpmailer;
    


$mail->IsSMTP();
//$mail->Host     = "mail.acecabs.in.cust.a.hostedemail.com";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "Newpass@0112";

$mail->Host     = "103.21.58.112";
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
$mail->Subject  = "Your Insol India Membership Has Been Renew";
    
$mail->AddAddress("$email");
$mail->Body = "$MAIL_BODY";
$mail->AddCC("contact@insolindia.com");

$mailSent = $mail->send();    
$mail->ClearAddresses();    

if($mailSent): 
   
    $previousPage = $_SERVER["HTTP_REFERER"];
    header('Location: '.$previousPage);
    echo "Mail Successfully Sent";
else:
  echo "Sorry cannot process your request.";
endif;
ob_flush();
}


			

?>
 
