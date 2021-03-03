<?php
session_start();
error_reporting(0);
include("ajax_include.php");

define("PAGE_AJAX","ajax_event_joiner.php");
define("PAGE_LIST","event_joiner_list.php");
  
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


$event_joiner_id = $_REQUEST['event_joiner_id'];

$rsGET = getDetails(EVENT_JOINER_TBL, '*', "event_joiner_id",$event_joiner_id,'=', '', '' , "" );
    
$event_joiner_id = stripslashes($rsGET[0]["event_joiner_id"]);
$registration_no = stripslashes($rsGET[0]["registration_no"]);
$title = stripslashes($rsGET[0]["title"]);
$fname = stripslashes($rsGET[0]["fname"]);
$surname = stripslashes($rsGET[0]["surname"]);
$firmname = stripslashes($rsGET[0]["firmname"]);
$name = $title." ".$fname;
if($surname !='')
{
$name = $name." ".$surname;
}
$name = ucwords(strtolower($name));
$email = stripslashes($rsGET[0]["email"]);


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
                        
                        $MAIL_BODY .= '<tr>
                            <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                <h1 style="color: #2E3192; font-size:16px;">Thank you to register for INSOL India Annual Conference 2018.</h1> 
                                <h3 style="color: #ED1C24; font-size: 16px;">Registration No. '.$registration_no.'.</h3>
                                
                                <br><br>
                                <div style="border-top:1px solid #ccc">&nbsp;</div>
                                <div style="font-size:11px;">
                                    <h3 style="color: #000; font-size: 13px;">Conference venue</h3>
                                    <p><span style="color: #2E3192;">The Leela Palace New Delhi,<br>Diplomatic Enclave, Chanakyapuri,<br>New Delhi 110 023, India<br>Conference dates<br>Tuesday 13 November 2018<br>Wednesday 14 November 2018<br>Language: The working language of the conference is English<br>Dress code: Delegates are requested to wear smart casual clothes to the conference technical sessions and social functions.</p>
                                    
                                    <br>
                                    <p><span style="color: #2E3192; font-weight:bold;">Disclaimer: </span> INSOL India cannot accept any liability for any loss, cost or expense suffered or incurred 
                                    by any person if such loss is caused or results from the act, default or omission of any person. In particular, INSOL India cannot accept any liability for losses arising 
                                    from the provision of services provided by hotel companies or transport operators. Nor can INSOL India accept liability for losses suffered by reason of war, including 
                                    threat of war, riots, and civil strife, terrorist activity, natural disaster, weather, fire, flood, drought, technical mechanical or electrical breakdown within any 
                                    premises visited by delegates or their guests in connection with the Conference, industrial disputes, government action, regulations or technical problems which may affect 
                                    the services provided in connection with the Conference.
                                    </p>

                                    <p><span style="color: #2E3192; font-weight:bold;">Cancellation of the Conference by the Organisers: </span>In the event that the Conference is cancelled
                                    by INSOL India, or by any reason of any factor outside the control of INSOL India, and cannot take place, the amount of the Registration fee shall be refunded. 
                                    The liability of INSOL India shall be limited to that refund, and INSOL India shall not be liable for any other loss, cost or expense, howsoever caused, incurred or 
                                    arising. In particular, INSOL India shall not be liable to refund any travel costs incurred by delegates or their guests or their companies. It follows that delegates 
                                    and their guests and their companies are advised to take out comprehensive insurance including travel insurance.
                                    </p>
                                   
                                    <p> In the event that the Conference is cancelled by INSOL India we will contact delegates immediately.</p>
                                    
                                    <p><span style="color: #2E3192; font-weight:bold;">Cancellations/Substitution: </span> Once registration form is received, participation can’t be cancelled, however 
                                    substitutions are welcome at any time with prior notifications and on confirmation by INSOL India. Cancellations carry a 100% liability and course materials 
                                    will still be couriered to you.
                                    </p>

                                    <p><span style="color: #2E3192; font-weight:bold;">Hotel Bookings and Cancellations:</span> All hotel bookings are the responsibility of the individual delegate to 
                                    make and cancel directly with the hotel. Credit card guarantee is required at time of reservations. Please be aware of the cancellation policy for the Conference hotel.</p>
                                    
                                    <p><span style="color: #2E3192; font-weight:bold;">Conference Registration via the web: </span> Registrations can be made via the INSOL India website at <a href="http://insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>.</p>
                                    
                                    <br>
                                    <p>Become a member of INSOL India and take advantage of all the member benefits including reduced Conference fees.To apply for membership please contact <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a>  For more details visit: <a href="http://insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>.</p>
                                    
                                    <br>
                                    <p>We look forward to welcome you at the INSOL India Conference.</p>
                                </div>
                            </td>
                        </tr>';
                       
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
    $MAIL_BODY .= '<a href="javascript:void(0);" id="submit" value="'.$event_joiner_id.'"><img src="'.SITE_IMAGES.'submit.png" alt=""/></a>&nbsp;&nbsp;
</div>
<div id="INPROCESS_1" style="display: none;"></div>';


echo $MAIL_BODY;
?>

  
 
