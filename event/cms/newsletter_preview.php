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

<!----FANCY BOX SCRIPT START --->
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox({'width' : '95%', 'maxWidth':830, 'maxHeight':800});
	});
</script>
<!----FANCY BOX SCRIPT END --->


<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $.validator.addMethod('ck_testemail', function (data)
    {
        var checked_governance = [];
        $("input[name='send_to_governance[]']:checked").each(function ()
        {
            checked_governance.push(parseInt($(this).val()));
        });
        
       if ( $('#send_to_insol_member').prop("checked")==false && $('#test_group_email').prop("checked")==false && $.trim($("#test_email").val()) == "" && checked_governance.length == parseInt(0) )
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
            // for governance id array  
            var checked_governance = [];
            $("input[name='send_to_governance[]']:checked").each(function ()
            {
                checked_governance.push(parseInt($(this).val()));
            });
            
            var value = $("#frm").serialize();
           
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               //data: "type=sendNewsletter&" + value,
               data: "type=sendNewsletter&send_to_governance="+checked_governance +"&" + value,
			   beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Processing' class='process' /></div>");
               },
               success: function(msg){
                   //console.log(msg);
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
     
     //============================= PRINT ============================================
     $(".print_detail").click(function(){
            ID = $(this).attr("ID");
		
            $.fancybox.open({
    			href : 'newsletter_preview_print.php?ID='+ID,
    			type : 'iframe',
    			padding : 5
    		});
            
			
        });
       //=============================================================================
       
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
            <div class="fullWidth noGap"> 
            <label class="mainLabel">Send To (Check if yes) </label>
                <div class="width24 memberH" style="min-height:auto !important; margin-bottom:0px;">
                    <label class="checkBoxWidth" style="width:100%;"><input type="checkbox" name="send_to_insol_member" id="send_to_insol_member" value="1" <?php if($send_to_insol_member ==1 ) { echo "checked"; }?> />Insol Member </label> 
                </div> 
               <?php
                $SQL_G  = "";
                $SQL_G .= " SELECT * FROM " . GOVERNANCE_TYPE_TBL . " WHERE status = 'ACTIVE' ORDER BY type_name ";
                  
                $gGET = $dCON->prepare( $SQL_G );
                $gGET->execute();
                $gVAL = $gGET->fetchAll();
                $gGET->closeCursor();
                 if(intval(count($gVAL)) > intval(0)){
                    foreach($gVAL AS $rVAL){
                        $type_name = stripslashes($rVAL['type_name']);
                        $type_id = intval(stripcslashes($rVAL['type_id']));
                        ?>
                            <div class="width24 memberH" id="governance_id" style="min-height:auto !important; margin-bottom:0px;">
                            <!--label class="mainLabel">Send To </label-->
                            <label class="checkBoxWidth" style="width:100%;"><input type="checkbox" name="send_to_governance[]" id="send_to_governance_<?php echo $type_id; ?>" value="<?php echo $type_id; ?>" /><?php echo $type_name; ?></label>
                            </div>
                        <?php
                    }
                 } 
                ?>
                <div class="width24 memberH" style="min-height:auto !important; margin-bottom:0px;">
                    <label class="checkBoxWidth" style="width:100%;"><input type="checkbox" name="test_group_email" id="test_group_email" value="1" />Mailing List</label> 
                </div> 
         
            </div> 
         
            <div class="fullwidth noGap">
                <!--label class="mainLabel">&nbsp;</label-->
                <div class="sbumitLoaderBox" id="INPROCESS">                        
                    <input type='submit' value='Send' class='submitBtn' id='save' name='save'/>
                    <input type='reset' value='Redesign' class='cancelBtn' id='cancel'/>
                </div>           
            </div>
        </div><!--fullWidth end-->                        
    </div><!--containerPad end-->
</div>            
</form> 
<!-------to print--> 
<div align="right" style="margin-bottom: 16px;">
  <!--input type="button" value="Print" onclick="PrintDiv();" /-->
  <!--button onclick="PrintDiv();"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>print-icon.png" border="0" title="Print" alt="Print"/></button-->
  <a href="javascript:void(0);" ID="<?php echo $ID; ?>" class="print_detail" title="Print"><img border="0" src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>print-icon.png" border="0" alt="Print" ></a>
</div>
<!-------to print--> 
<div id="divToPrint" style="min-height:300px;"> 
    <?php
        echo newsletterFormat($ID,$via = "NO");
         
    ?>
</div> 

<script src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>grids.js"></script>
<script>    
    $(document).ready(function() {
        $('.memberH').responsiveEqualHeightGrid();
    });
</script>
<?php include("footer.php");?>