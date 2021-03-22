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
    
  
    $("#approve").click(function(){
        var ID = $(this).attr("value");
        //alert(ID);
        
        $.ajax({
           type: "POST",
           url: "<?php echo PAGE_AJAX; ?>",
           data: "type=registerSave&register_status=Approved&ID=" + ID,
    	   beforeSend: function(){
    	       
               $("#INPROCESS").hide();
               $("#INPROCESS_1").show(); 
               $("#INPROCESS_1").html("<div style='text-align: center;'><i class='icon iconloader'></i> Processing...</div>"); 
            },
          
           success: function(msg){ 
                
                //alert(msg); 
                //return false;
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
     
    
    $("#decline").click(function(){
        var ID = $(this).attr("value");
        //alert(ID);
        
        $.ajax({
           type: "POST",
           url: "<?php echo PAGE_AJAX; ?>",
           data: "type=registerSave&register_status=Declined&ID=" + ID,
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
$membership_no = stripslashes($rsGET[0]["membership_no"]);

$title = stripslashes($rsGET[0]["title"]);
$fname = stripslashes($rsGET[0]["fname"]);
$surname = stripslashes($rsGET[0]["surname"]);
$name_on_badge = stripslashes($rsGET[0]["name_on_badge"]);

$name = $title.' '.$fname;
if($surname !='')
{
    $name = $name." ".$surname;
}

$name = ucwords(strtolower($name));

$firm_name = stripslashes($rsGET[0]["firmname"]); 
$address = stripslashes($rsGET[0]["address"]); 

$full_address = "";
$full_address .= $address;

$telephone = stripslashes($rsGET[0]["phone"]);
if($telephone !='')
{
    $telephone = 'T. '.$telephone;
}

$email = stripslashes($rsGET[0]["email"]);
$pay_by = stripslashes($rsGET[0]["pay_by"]);
$order_of = stripslashes($rsGET[0]["order_of"]);
$cheque_utr_no = stripslashes($rsGET[0]["cheque_utr_no"]);
$is_previously_attended = stripslashes($rsGET[0]["is_previously_attended"]);
$registration_fees = stripslashes($rsGET[0]["registration_fees"]);

$terms = stripslashes($rsGET[0]["terms"]);
$payment_status = stripslashes($rsGET[0]["payment_status"]);
$status = stripslashes($rsGET[0]["status"]);

$mMAIL = '';    
$mMAIL .= '
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td>
                <table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">
                  <tbody>
                        <tr>
                            <td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>
                        </tr>
                        <tr>
                            <td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Following user submitted the event joining form</td>
                        </tr>
                        <tr>
                            <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 14px;">
                            <h1 style="color: #2E3192; font-size:28px; margin-bottom: 5px;">'.$name.'</h1>';
                            
                            
                            $mMAIL .= 'Correspondence Address : '.$full_address;
                            
                            $mMAIL .= '<br><br>'.$telephone.' | E. '.$email.'<br><br>

                            <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                            Name as you wish it to appear on your badge: <strong style="color: #ED1C24;">'.$name_on_badge.'</strong>
                            </div>';
                            
                            if($membership_no !='')
                            {
                                $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                Membership No : <strong style="color: #ED1C24;">'.$membership_no.'</strong>
                                </div>';
                            }

                            $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                If you wish to pay by cheque or NEFT, kindly fill in the below details : <strong style="color: #ED1C24;">'.$pay_by.'</strong>
                                </div>
                                
                                <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                I enclose a cheque/draft/NEFT to the order of : <strong style="color: #ED1C24;">'.$order_of.'</strong>
                                </div>
                                
                                <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                Cheque No:UTR No. Amount:Address (if different from address on previous page) : <strong style="color: #ED1C24;">'.$cheque_utr_no.'</strong>
                                </div>
                                
                                <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                Have you attended an INSOL India Conference previously : <strong style="color: #ED1C24;">'.$is_previously_attended.'</strong>
                                </div>
                                    
                                <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                Registration Fees : <strong style="color: #ED1C24;">'.$registration_fees.'</strong>
                                </div>';

                                if ($status == "PENDING")
                                {
                                    $mMAIL .= '<div style="text-align: center;" id="INPROCESS">';
                                    
                                    if($status != 'APPROVED')
                                    {
                                        $mMAIL .= '<a href="'.SITE_URL.'cms/login.php?eventjoinerid='.$event_joiner_id.'"><img src="'.SITE_IMAGES.'approve.png" alt=""/></a>&nbsp;&nbsp;';
                                    }
                                    
                                    $mMAIL .= '<a href="'.SITE_URL.'cms/login.php?eventjoinerid='.$event_joiner_id.'"><img src="'.SITE_IMAGES.'decline.png" alt=""/></a>
                                    </div>
                                    <div id="INPROCESS_1" style="display: none;"></div>';
                                }
                                
                            $mMAIL .= '</td>
                        </tr>
                	   <tr>
                	       <td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">
                         5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br />Contact No. 011 49785744
                    		Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>
                	       </td>
                	   </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>';

echo $mMAIL;
  
  
 
