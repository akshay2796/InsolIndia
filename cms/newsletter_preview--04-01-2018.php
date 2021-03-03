<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","newsletter.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");
define("PAGE_PREVIEW","newsletter_preview.php");

define("PAGE_COMMON","ajax_common.php");


//$ID = intval(base64_decode($_REQUEST['ID']));

$ID = intval($_REQUEST['nid']);
 

if( (intval($ID) > intval(0)) )
{
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . NEWSLETTER_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND newsletter_id = :newsletter_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":newsletter_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    if(count($rsGET)==intval(0))
    {
        //echo "==";
        header("Location:".PAGE_MAIN);
    }
    
    $newsletter_subject = htmlentities(stripslashes($rsGET[0]['newsletter_subject'])); 
    $test_email = htmlentities(stripslashes($rsGET[0]['test_email'])); 
    $send_to_insol_member = intval($rsGET[0]['send_to_insol_member']); 
  
    
    $volume_name = htmlentities(stripslashes($rsGET[0]['volume_name'])); 
    $newsletter_issue = htmlentities(stripslashes($rsGET[0]['newsletter_issue'])); 
     
    $newsletter_date = stripslashes($rsGET[0]['newsletter_date']);
    if(trim($newsletter_date) != "" && $newsletter_date != "0000-00-00")
    {
        $newsletter_date = date('M d, Y' , strtotime($newsletter_date));    
    }
    else
    {
        $newsletter_date = "";
    }
    
    $intro_content = stripslashes($rsGET[0]["intro_content"]);
    $editor_name = stripslashes($rsGET[0]["editor_name"]);
    $editor_image = stripslashes($rsGET[0]["editor_image"]);
    $editor_text = stripslashes($rsGET[0]["editor_text"]);
  
    if($editor_image!= "")
    {
        //$ImageCt = intval(count($rsGET));
        $FOLDER_NAME_EDITOR = FLD_NEWSLETTER; 
        $FOLDER_PATH_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_EDITOR;  
        $editor_id = 0;
        
        $chk_file_editor = chkImageExists($FOLDER_PATH_EDITOR."/".$editor_image);
        
        if(intval($chk_file_editor) == intval(1))
        {
            $display_image_editor = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_EDITOR."/R70-".$editor_image;
        }
        else
        {
            $display_image_editor = SITE_IMAGES."pick.jpg";
        }
    }   
    
    $president_name = stripslashes($rsGET[0]["president_name"]);
    $president_image = stripslashes($rsGET[0]["president_image"]);
    $president_text = ucfirst(strtolower(stripslashes($rsGET[0]["president_text"])));
    
    if($president_image !="")
    {  
        $FOLDER_NAME_PRESIDENT = FLD_NEWSLETTER; 
        $FOLDER_PATH_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_PRESIDENT;  
        
        $president_id= intval(0);
        $chk_file_president = chkImageExists($FOLDER_PATH_PRESIDENT."/".$president_image);
        if(intval($chk_file_president) == intval(1))
        {
            $display_image_president = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_PRESIDENT."/R70-".$president_image;
        }
        else
        {
            $display_image_president = SITE_IMAGES."pick.jpg";
        }
    }
    
    //$newsletter_sponsor_id = stripslashes($rs[0]["newsletter_sponsor_id"]);
    //$newsletter_sig24_id = stripslashes($rs[0]["newsletter_sig24_id"]);
    $disclaimer = stripslashes($rsGET[0]["disclaimer"]);
    
    $newsletter_status = stripslashes($rsGET[0]["newsletter_status"]);
    $newsletter_send_date = stripslashes($rsGET[0]["newsletter_send_date"]);
    
    $status = htmlentities(stripslashes($rsGET[0]['status']));                        
    
}
else
{
     header("Location:".PAGE_MAIN);
}
?>

<!-- Fancy Select Box -->
<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.js"></script> 
<!-- Fancy Select Box Ends -->


<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $.validator.addMethod('ck_testemail', function (data)
    {
       if ( $('#send_to_insol_member').prop("checked")==false  && $.trim($("#test_email").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 
    
    
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            newsletter_subject: "required",
            test_email: {
                ck_testemail: true
            }
        },
        messages: {
            newsletter_subject: "",
            test_email: ""
        },
        submitHandler: function() {
            
            var value = $("#frm").serialize();
            //alert(value);
            //return false;
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=sendNewsletter&" + value,
			   beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Processing' class='process' /></div>");
               },
               success: function(msg){
                   //alert(msg);
				   //return false;                 
                   var cond = $("#con").val();
                    
                   setTimeout(function(){
                        $("#INPROCESS").html("");                        
                        var spl_txt = msg.split("~~~"); 
                        
                        var colorStyle = "";
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            colorStyle = "successTxt";                            
                        } 
                        else
                        {
                            colorStyle = "errorTxt";
                        }
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='cancelBtn " + colorStyle + "' /></div>");
                        
                        
                        setTimeout(function(){
                            
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' name='save'/>&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>");
                            
                            
                            if( parseInt(spl_txt[1]) == parseInt(1) )
                            {
                                window.location.href = "<?php echo "send-newsletter.php"; ?>?nid=<?php echo $ID;?>&testmail="+spl_txt[3]+"&mct="+spl_txt[4];
                                
                            }
                               
                        },2500);
                        
                                             
                    },1000); 
                  
					 
                }
            });
        }
    });
    
    
    $("#cancel").live("click", function(){    
       
        window.location.href = '<?php echo PAGE_MAIN; ?>?id=<?php echo $ID; ?>';
       
     });
       
});

    
</script>




<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
     
<h1>
    Newsletter Preview <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1>
<div class="addWrapper">
    <div class="containerPad">
        <div class="fullWidth noGap">
            <div class="width2">
            	<label class="mainLabel">Subject <span>*</span> </label>
                <input type="text" class="txtBox" name="newsletter_subject" id="newsletter_subject" value="<?php echo $newsletter_subject; ?>" maxlength="100" autocomplete="OFF" />
            </div> 
            <div class="width2">
            	<label class="mainLabel">Send To Test Mail <span>*</span> <small>[ Multiple email separated by comma ]</small></label>
                <input type="text" class="txtBox" name="test_email" id="test_email" value="<?php echo $test_email; ?>" maxlength="400" autocomplete="OFF" />
            </div>  
        </div>    
        <div class="fullWidth noGap"> 
            <div class="width5">
            	<label class="mainLabel">Send To Insol Member </label>
                <label class="checkBoxWidth"><input type="checkbox" name="send_to_insol_member" id="send_to_insol_member" value="1" <?php if($send_to_insol_member ==1 ) { echo "checked"; }?> />Check if yes </label> 
            </div> 
         
            <div class="width4 noGap">
                <label class="mainLabel">&nbsp;</label>
                <div class="sbumitLoaderBox" id="INPROCESS">                        
                    <input type='submit' value='Send' class='submitBtn' id='save' name='save'/>
                    <input type='reset' value='Redesign' class='cancelBtn' id='cancel'/>
                </div>           
            </div>
        </div><!--fullWidth end-->                        
    </div><!--containerPad end-->
</div>            
</form>  

<div style="min-height:300px;"> 
    <?php
    echo newsletterFormat($ID,$via = "NO");
     
    /*
    $mMAIL = "";    
    $mMAIL .= "

    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background: #eaeaea'>
        <tbody>
            <tr>
                <td bgcolor='#eaeaea' align='center'>
                    <table width='848' border='0' cellspacing='0' cellpadding='0' align='center' style='font-family: arial; border: 1px solid #EAEAEA;'>
                        <tbody>
                            <tr>
                                <td style='line-height:0px;'><img src='".SITE_IMAGES."header.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                            </tr>
                            <tr>
                                <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; font-size: 16px; padding: 25px;'>".$intro_content."</td>
                            </tr>
                			<tr>
                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 0 0 12px 12px;'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                				        <tbody>
                                        <tr>
                                            <td width='300px' valign='top'>					  
                                                <div style='clear: both; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
        				  	                    if($editor_text !="")
                                                {
                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor='#696969' style='background: #696969; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>Editor's Message</td>
                                                            </tr>
                                                            <tr>
                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td width='60px' valign='top' style='line-height: 0px;'><img src='".$display_image_editor."' style='width: 68px;' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                <td width='15px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."15.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                <td style='font-size: 12px; color: #333;'>
                                                                                    ".$editor_text."
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                    						        <div style='clear: both; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
                					  	        }
                                                
                                                if($president_text !="")
                                                {
                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>President's Message</td>
                                                            </tr>
                                                            <tr>
                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td width='60px' valign='top' style='line-height: 0px;'><img src='".$display_image_president."' style='width: 68px;' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                            <td width='15px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."15.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                            <td style='font-size: 12px; color: #333;'>
                                                                                ".$president_text."
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div style='clear: both; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
                					  	        }
                                                
                                                $SQL  = "";
                                                $SQL .= " SELECT * FROM " . NEWSLETTER_SPONSOR_TBL . " as A WHERE status = 'ACTIVE' ORDER BY position";
                                                $stmt = $dCON->prepare( $SQL );
                                                $stmt->execute();
                                                $rowSP = $stmt->fetchAll();
                                                $stmt->closeCursor();
                                                
                                                if(count($rowSP) > 0)
                                                {
                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor='#696969' style='background: #696969; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>Sponsors</td>
                                                            </tr>
                                                            <tr>
                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px 0 5px 20px;'>
                                                                    <ul style='list-style-type: none; margin: 0; padding: 0;'>";
                                                                        
                                                                        $s=1;
                                                                        foreach($rowSP as $rsSP)
                                                                        {
                                                                            $company_name = "";
                                                                            $url = "";
                                                                            $sponsor_url = "";
                                                                            $sponsor_url_end = "";
                                                                            $image_name = "";
                                                                            $display_image_sponsor ="";
                                                                             
                                                                            $company_name = stripslashes($rsSP['company_name']);
                                                                            $url = str_replace("http://","",stripslashes($rsSP['url'])) ;
                                                                            
                                                                            if($url !="")
                                                                            {
                                                                               $sponsor_url = "<a href='http://".$url."' target='_blank'>";
                                                                               $sponsor_url_end = "</a>";
                                                                            }
                                                                            
                                                                            $image_name = stripslashes($rsSP['image_name']);
                                                                            
                                                                            $FOLDER_NAME_SPONSOR = FLD_NEWSLETTER_SPONSOR; 
                                                                            $FOLDER_PATH_SPONSOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_SPONSOR;  
                                                                            
                                                                            $chk_file_sponsor = chkImageExists($FOLDER_PATH_SPONSOR."/R100-".$image_name);
                                                                            if(intval($chk_file_sponsor) == intval(1))
                                                                            {
                                                                                $display_image_sponsor = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_SPONSOR."/".$image_name;
                                                                                
                                                                                $mMAIL .= "<li style='float: left; line-height: 0px; margin-bottom:15px;'>".$sponsor_url."<img src='".$display_image_sponsor."' style='max-height: 48px; line-height:0px;' alt='".$company_name."'/>".$sponsor_url_end."</li>";
                                                                                if(intval($s) < count($rowSP))
                                                                                {
                                                                                    $mMAIL .= "<li style='line-height: 0px; width: 20px; float: left; margin-bottom:15px;'><img src='".SITE_IMAGES."20.jpg' style='float: left; width: 20px; line-height:0px;' alt=''/></li>";
                                                                                }
                                                                            }
                                                                            $s++;
                                                                        }     
                                                                            
                                                                        
                                                                    $mMAIL .= "</ul>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                    						
                                                    <div style='clear: both; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
                                                }
                                                
                                                $SQL  = "";
                                                $SQL .= " SELECT * FROM " . SIG24_TBL . " as A WHERE status = 'ACTIVE' ORDER BY position";
                                                $stmtSIG = $dCON->prepare( $SQL );
                                                $stmtSIG->execute();
                                                $rowSIG = $stmtSIG->fetchAll();
                                                $stmtSIG->closeCursor();
                                                
                                                if(count($rowSIG) > 0)
                                                {
                                                   
                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                        <tbody>
                                                            <tr>
                                                                <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>SIG24</td>
                                                            </tr>
                                                            <tr>
                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>
                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size:12px; color: #666;'>
                                                                        <tbody>";
                                                                        
                                                                        foreach($rowSIG as $rsSIG)
                                                                        {
                                                                            $SIGurl = "";
                                                                            $sig_url = "";
                                                                            $sig_url_end = "";
                                                                           
                                                                            $SIGurl = str_replace("http://","",stripslashes($rsSIG['url'])) ;
                                                                            if($SIGurl !="")
                                                                            {
                                                                                $sig_url = "<a href='http://".$SIGurl."' target='_blank' style='font-family: arial; font-size:12px; color: #666;'>";
                                                                                $sig_url_end = "</a>";
                                                                            }
                                                                            
                                                                            
                                                                            $mMAIL .= "<tr>
                                                                                <td width='14' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."arrow.jpg' width='14' height='9' style='display: block; line-height: 0px;' alt=''/></td>
                                                                                <td>".$sig_url.$rsSIG['company_name'].$sig_url_end."</td>
                                                                            </tr>";
                                                                        }
                                                                        $mMAIL .= "</tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>";
                                                }
                                                
                                            $mMAIL .= "</td>
                                            <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                            <td valign='top'>
                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <div style='padding: 5px 10px; float: right; background: #000; color: #ffffff; font-size: 11px; text-transform: uppercase;'>
                                                                Volume ".$volume_name.", Issue ".$newsletter_issue." | ".$newsletter_date."
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style='padding: 12px 12px 0 0;'>";
                                                            
                                                            $QRY = "";
                                                            $QRY .= " SELECT E.* FROM " . EVENT_TBL . " as E inner join " . NEWSLETTER_EVENT_TBL . " as N ";
                                                            $QRY .= " on E.event_id = N.event_id ";
                                                            $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY E.event_from_date ";
                                                            //echo $QRY;
                                                            $sEvent = $dCON->prepare( $QRY );
                                                            $sEvent->bindParam(":newsletter_id",$ID);
                                                            $sEvent->execute();
                                                            $rowEvent = $sEvent->fetchAll();
                                                            $sEvent->closeCursor();
                                                            
                                                            
                                                            if(count($rowEvent) >intval(0))
                                                            {
                                                            
                                                                $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td bgcolor='#ffffff' style='background: #ffffff; padding: 17px;'>
                                                                                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>
                                                                                    <tbody>
                                                                                    <tr>
                                                                                        <td colspan='3' style='font-weight: bold; font-size: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;'>Upcoming Events and Activities</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                    </tr>";
                                                                                    
                                                                                    foreach($rowEvent as $rEvent)
                                                                                    {
                                                                                        
                                                                                        $eventNAME = "";
                                                                                        $eventFDATE = "";
                                                                                        $eventTDATE = "";
                                                                                        $eventVenue = "";
                                                                                        $eventDetailURL = "";
                                                                                        
                                                                                        $eventNAME = htmlentities(stripslashes($rEvent['event_name']));
                                                                                        $eventFDATE = (stripslashes($rEvent['event_from_date']));
                                                                                        $eventTDATE = (stripslashes($rEvent['event_to_date']));
                                                                                        //$eventIMG = stripslashes($rEvent['image_name']);
                                                                                        //$eventSDESC = stripslashes($rEvent["event_short_description"]); 
                                                                                        $eventVenue = (stripslashes($rEvent['event_venue']));
                                                                                         
                                                                                        $eventDetailURL = SITE_URL . urlRewrite("event-detail.php", array("url_key" => stripslashes($rEvent['url_key'])));
                                                                                      
                                                                                        $mMAIL .= "<tr>
                                                                                            <td width='64' align='center';>
                                                                                                <div style='background: #696969; padding: 4px; color: #ffffff; text-align: center; font-size: 18px;'>".date("jS", strtotime($eventFDATE))."</div>
                                                                                                <div style='background: #e3e3e3; padding: 2px; color: #000; text-align: center; text-transform: uppercase; font-size: 10px;'>".date("F, Y", strtotime($eventFDATE))."</div>
                                                                                                
                                                                                                <div style='background: #ffffff; line-height: 0; text-align: center;'><img src='".SITE_IMAGES."dateimg.jpg' style='display: inline-block; line-height: 0px;' alt=''/></div>
                                                                                            </td>
                                                                                            <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                            <td valign='top' style='font-size: 12px; color: #666; padding: 8px 0 0;'>
                                                                                                <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$eventDetailURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".$eventNAME."</a></div>
                                                                                                <p style='margin: 0;'>Venue: ".$eventVenue."</p>
                                                                                                
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                        </tr>";
                                                                                    }
                                                                                    
                                                                                    
                                                                                    $mMAIL .= "<tr>
                                                                                        <td colspan='3' style='font-size: 11px; border-top: 1px solid #ccc; padding-top: 15px;'><a href='".SITE_URL . urlRewrite("events.php")."' style='color:#000; text-decoration: none;' target='_blank'>View all events</a></td>
                                                                                    </tr>
                                                                                    
                                                                                    </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>							  	
                                                                <div style='clear: both; height: 20px; line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
                                                            }
                                                            
                                                            $QRY = "";
                                                            $QRY .= " SELECT E.* FROM " . NEWS_TBL . " as E inner join " . NEWSLETTER_NEWS_TBL . " as N ";
                                                            $QRY .= " on E.news_id = N.news_id ";
                                                            $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY E.position ASC, E.news_date DESC";
                                                            //echo $QRY;
                                                            $sNews = $dCON->prepare( $QRY );
                                                            $sNews->bindParam(":newsletter_id",$ID);
                                                            $sNews->execute();
                                                            $rowNews = $sNews->fetchAll();
                                                            $sNews->closeCursor();
                                                            if (intval(count($rowNews)) > intval(0) )
                                                            {
                                                         
                                                                $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td colspan='3' style='font-weight: bold; font-size: 20px;'>Headlines</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                        </tr>";
                                                                        
                                                                        foreach($rowNews as $rsNews)
                                                                        {
                                                                            $newsURL = "";
                                                                            $newsImage = "";;   
                                                                            $news_content = "";;   
                                                                            $DISPLAY_NEWS_IMG = "";;   
                                                                            
                                                                            $newsURL = SITE_URL . urlRewrite("news-details.php", array("url_key" => stripslashes($rsNews['url_key'])));
                                                                            $newsImage = $rsNews['image_name'];   
                                                                            
                                                                            if(chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS  .'/'. $newsImage) == intval(1))
                                                                            {
                                                                                $DISPLAY_NEWS_IMG = SITE_UPLOAD_ABSOLUTE_ROOT . FLD_NEWS  .'/'. $newsImage;
                                                                            }
                                                                            else
                                                                            {
                                                                                $DISPLAY_NEWS_IMG =  SITE_IMAGES . 'no_images.jpg';
                                                                            }
                                                                            
                                                                                                                                                   
                                                                            $news_content = trustme($rsNews['news_content']);
                                                                            
                                                                            $mMAIL .= "<tr>
                                                                                
                                                                                <td width='172' valign='top' style='line-height: 0px;'>
                                                                                    <img src='".$DISPLAY_NEWS_IMG."' style='display:inline-block; width: 100%; line-height:0px;border: blue;' alt='' />
                                                                                </td>
                                                                                
                                                                                <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                <td valign='top' style='font-size: 12px; color: #666; padding: 2px 0 0;'>
                                                                                    <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$newsURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".$rsNews['news_title']."</a></div>
                                                                                    <p style='margin: 0;'>
                                                                                    ".limit_words($news_content, 50)."";
                                                                            
                                                                                    if(str_word_count($news_content) > intval(50))
                                                                                    {
                                                                                        $mMAIL . '..';
                                                                                    }
                                                                                    
                                                                                    
                                                                                $mMAIL .= "</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                            </tr>";
                                                                        }
                                                                        
                                                                        
                                                                    $mMAIL .= "</tbody>
                                                                </table>						  	
                                                                <div style='clear: both; height: 20px; line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";
                                                            }
                                                            
                                                            $QRY = "";
                                                            $QRY .= " SELECT R.*,(select url_key from " . RESOURCES_CATEGORY_TBL . " as C where R.category_id = C.category_id ) as cat_url_key FROM " . RESOURCES_TBL . " as R inner join " . NEWSLETTER_RESOURCES_TBL . " as N ";
                                                            $QRY .= " on R.resources_id = N.resources_id ";
                                                            $QRY .= " WHERE R.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY R.resources_from_date desc";
                                                            //echo $QRY;
                                                            $sResources = $dCON->prepare( $QRY );
                                                            $sResources->bindParam(":newsletter_id",$ID);
                                                            $sResources->execute();
                                                            $rowResources = $sResources->fetchAll();
                                                            $sResources->closeCursor();
                                                            if (intval(count($rowResources)) > intval(0) )
                                                            {
                                                            
                                                                $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td bgcolor='#ffffff' style='background: #ffffff; padding: 17px;'>
                                                                                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td style='font-weight: bold; font-size: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;'>Articles</td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                    </tr>";
                                                                                    foreach($rowResources as $rsResources)
                                                                                    {
                                                                                        $resourcesPUBLISHER = "";
                                                                                        $resourcesSDESC = "";
                                                                                        $cat_url_key = "";
                                                                                        $resourcesURL = "";
                                                                                        
                                                                                        $resourcesPUBLISHER = htmlentities(stripslashes($rsResources['resources_publisher']));
                                                                                        $resourcesSDESC = stripslashes($rsResources["resources_short_description"]); 
                                                                                        $cat_url_key = stripslashes($rsResources["cat_url_key"]); 
                                                                                        
                                                                                        $resourcesURL = SITE_URL .urlRewrite("login.php").$_SESSION['INCLUDE_QMARK']."ref=resources&ckey=".$cat_url_key;
                                                                                        
                                                                                        $mMAIL .= "<tr>												  
                                                                                            <td valign='top' style='font-size: 12px; color: #666; padding: 8px 0 0;'>
                                                                                                <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$resourcesURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".stripslashes($rsResources['resources_name'])."</a></div>";
                                                                                                if($resourcesPUBLISHER !='')
                                                                                                {
                                                                                                    $mMAIL .= "<p style='margin: 0; font-size: 11px; color: #000;'>By ".$resourcesPUBLISHER."</p>";
                                                                                                }
                                                                                                $mMAIL .= "<p style='margin-bottom: 0px;'>".limit_char(trustme($resourcesSDESC), 250)."</p>
                                                                                            </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>
                                                                                        </tr>";
                                                                                    }
                                                                                    
                                                                                    
                                                                                    $mMAIL .= "<tr>
                                                                                        <td style='font-size: 11px; border-top: 1px solid #ccc; padding-top: 15px;'><a href='".SITE_URL . urlRewrite("resources.php", array("cat_url_key" => $cat_url_key))."' style='color:#000; text-decoration: none;' target='_blank'>View all articles</a></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                                </table>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>";
                                                            }
                                                            
                                                         $mMAIL .= "</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                				    </tbody>
                    				</table>
                                </td>
                    		</tr>
                			<tr>
                                <td bgcolor='#d9d9d9' style='background: #d9d9d9; padding: 25px; color: #666; font-size: 11px;'>
                				    <div style='font-size: 12px; color: #000000;'>DISCLAIMER</div><br>
                				    <em>INSOL India is a society registered under the provisions of Societies Registration Act XXI of 1860. A certificate to this effect was issued by the Registrar of Societies, Government of National Capital Territory of Delhi on 11th January 2000.</em><br><br>
                                    <em>The formation of INSOL India fulfilled the long cherished desire of the members of the legal fraternity, chartered accountants, company secretaries and other persons, bodies and institutions in India, to have an association to promote closer co-operation, exchange of ideas, dissemination of information and an empathetic understanding of law of insolvency and related lawhe formation of INSOL India fulfilled the long cherished desire of the members of the legal fraternity, chartered accountants, company secretaries and other persons, bodies and institutions in India, to have an association to promote closer co-operation, exchange of ideas, dissemination of information and an empathetic understanding of law of insolvency and related laws.</em>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 25px; color: #000; font-size: 11px;'>
                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>
                                        <tbody>
                                            <tr>
                                                <td>
                                                5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744
                                                    Email: <a href='mailto:contact@insolindia.com' target='_blank' style='color: #000000; text-decoration: none;'>contact@insolindia.com</a> | Website: <a href='http://www.insolindia.com' style='color: #000000; text-decoration: none;' target='_blank'>www.insolindia.com</a>
                                                </td>
                                                <td align='right' style='text-align: right;'>
                                                    Having problems viewing this email?<br>
                                                    <a href='index1.html' style='color: #000000; text-decoration: none;' target='_blank'>View it on our website</a>
                                                </td>
                                                <td align='right' width='120' style='line-height: 0px; text-align: right;'><a href='".SITE_URL."unsubscribe.php?id=%mid%&email=%memail%' style='color: #000000; text-decoration: none;' target='_blank'><img src='".SITE_IMAGES."unsubscribe.jpg' style='display: inline-block; line-height: 0px;' width='108' border='0' height='32' alt=''/></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>";
    
    echo $mMAIL;  
    */      
?>
</div> 
<?php include("footer.php");?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                              d?????