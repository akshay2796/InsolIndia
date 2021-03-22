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

$name = $title.' '.$first_name;
if($middle_name !='')
{
    $name = $name." ".$middle_name;
}
$name = $name." ".$last_name;
$name = ucwords(strtolower($name));

$firm_name = stripslashes($rsGET[0]["firm_name"]); 

$address = stripslashes($rsGET[0]["address"]); 
$correspondence_address_2 = stripslashes($rsGET[0]["correspondence_address_2"]); 
$correspondence_state = stripslashes($rsGET[0]["correspondence_state"]);
$city = stripslashes($rsGET[0]["city"]);
$country = stripslashes($rsGET[0]["country"]);
$pin = stripslashes($rsGET[0]["pin"]);

$full_address = "";
$full_address .= $address;
    if($correspondence_address_2 != ""){
        $full_address .= ", ". $correspondence_address_2;
    }
    $full_address .= ", ".$city;
    if($correspondence_state != "")
    {
        $full_address .= ", ".$correspondence_state;
    }
    $full_address .= ", ".$country;
    if($pin !='')
    {
        $full_address .= " - ".$pin;
    }

$permanent_address = stripslashes($rsGET[0]["permanent_address"]); 
$permanent_address_2 = stripslashes($rsGET[0]["permanent_address_2"]);
$permanent_city = stripslashes($rsGET[0]["permanent_city"]); 
$permanent_state = stripslashes($rsGET[0]["permanent_state"]);
$permanent_country = stripslashes($rsGET[0]["permanent_country"]);
$permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);

$permanent_full_address = "";
    if($permanent_address != "")
    {
        $permanent_full_address .= $permanent_address;
    }
    if($permanent_address_2 != "")
    {
        $permanent_full_address .= ", ".$permanent_address_2;
    }
    if($permanent_city != "")
    {
        $permanent_full_address .= ", ".$permanent_city;
    }
    if($permanent_state != "")
    {
        $permanent_full_address .= ", ".$permanent_state;
    }
    if($permanent_country != "")
    {
        $permanent_full_address .= ", ".$permanent_country;
    }

    if($permanent_pin !='')
    {
        $permanent_full_address .= " - ".$permanent_pin;
    }


$telephone = stripslashes($rsGET[0]["telephone"]);
if($telephone !='')
{
    $telephone = 'T. '.$telephone;
}

$residence_telephone = stripslashes($rsGET[0]["residence_telephone"]);
if($residence_telephone !='')
{
    $residence_telephone = 'Residence T. '.$residence_telephone;
}

$fax = stripslashes($rsGET[0]["fax"]);
if($fax !='')
{
    $fax = 'F. '.$fax;
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
$sig_company_name = stripslashes($rsGET[0]["sig_company_name"]);



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
                            <td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Following user submitted the membership form</td>
                        </tr>
                        <tr>
                            <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 14px;">
                            <h1 style="color: #2E3192; font-size:28px; margin-bottom: 5px;">'.$name.'</h1>';
                            
                            if($reg_number_text !='')
                            {
                                $mMAIL .= '<div style="color: #79B900; font-size:16px; margin-bottom: 5px;">'.$reg_number_text.'</div>';
                            }
                            //else if($reg_number_text_temp !='')
                            //{
                             //   $mMAIL .= '<div style="color: #79B900; font-size:16px; margin-bottom: 5px;">'.$reg_number_text_temp.'</div>';
                            //}
                            
                            
                            $mMAIL .= 'Correspondence Address : '.$full_address;
                            if($permanent_full_address != '')
                            {
                                $mMAIL .= '<br>Permanent Address : '.$permanent_full_address;
                            }
                            $mMAIL .= '<br><br>'.$telephone.' '.$mobile.' '.$residence_telephone.' '.$fax.' | E. '.$email.'<br><br>';
                            
                            if($firm_name != '')
                            {
                              $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                            Firm :  <strong style="color: #ED1C24;">'.$firm_name.'</strong>
                                        </div>';
                            }
                                
                               $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                            I am <strong style="color: #ED1C24;">'.$i_am.'</strong>
                                          </div>';
                                if(intval($insolvency_professional)==1 || $insolvency_professional_agency !='')
                                {
                                    $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                    I am Insolvency Professional registered with <strong style="color: #ED1C24;">'.$insolvency_professional_agency.'</strong> My registration number is <strong style="color: #ED1C24;">'.$insolvency_professional_number.'</strong>.
                                    </div>';
                                }
                                if(intval($registered_insolvency_professional)==1 || $registered_insolvency_professional_number !='')
                                {
                                    $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                    I am registered Insolvency Professional with Insolvency and Bankruptcy Board of India : <strong style="color: #ED1C24;"> Yes </strong><br>
                                    My registration number : <strong style="color: #ED1C24;">'.$registered_insolvency_professional_number.'</strong>.
                                    </div>';
                                }
                                
                                if(intval($young_practitioner)==1 || $young_practitioner_enrolment !='')
                                {
                                    $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                    I am a Young Practitioner. I confirm I have less than ten years experience in my profession mentioned in column 1 : <strong style="color: #ED1C24;"> Yes </strong><br>
                                    My date of enrolment with my professional body : <strong style="color: #ED1C24;">'.$young_practitioner_enrolment.'</strong>.
                                    </div>';
                                }
                                
                                if(intval($sig_member)== intval(1))
                                {
                                    $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  
                                    I am an SIG 24 Member : <strong style="color: #ED1C24;"> Yes </strong><br>
                                    SIG 24 Company Name : <strong style="color: #ED1C24;">'.$sig_company_name.'</strong>.
                                    </div>';
                                }
                                
                                $mMAIL .= '<div style="padding: 15px 0 30px; border-top: 1px solid #ccc;">			  
                                <strong> I am interested in becoming a member of INSOL India because</strong> <br>
                                '.$interested.'
                                </div>';
                                
                                //if($register_status =='pending')
                                
                                if ($payment_status != "SUCCESSFUL")
                                {
                                    $mMAIL .= '<div style="text-align: center;" id="INPROCESS">';
                                    
                                    if($register_status !='approved')
                                    {
                                        $mMAIL .= '<a href="javascript:void(0);" id="approve" value="'.$member_id.'"><img src="'.SITE_IMAGES.'approve.png" alt=""/></a>&nbsp;&nbsp;';
                                    }
                                    
                                    $mMAIL .= '<a href="javascript:void(0);" id="decline" value="'.$member_id.'"><img src="'.SITE_IMAGES.'decline.png" alt=""/></a>
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
  
  
 
