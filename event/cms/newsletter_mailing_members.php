<?php 
error_reporting(0);
include("header.php");

define("PAGE_MAIN","newsletter_mailing_members.php");	
define("PAGE_AJAX","ajax_newsletter_mailing_members.php");
define("PAGE_LIST","newsletter_mailing_members_list.php");


$upload_id = intval($_REQUEST['id']);

if( intval($upload_id) > intval(0) )
{   
    $con = "modify"; 
    $id = intval($upload_id);
    
    $stmt = $dCON->prepare(" SELECT * FROM " . TEST_EMAIL_TBL . " WHERE mail_id = ? ");
    $stmt->bindParam(1, $upload_id);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
    
    $upload_id = intval($row_stmt[0]['upload_id']);
    $test_mail_name = stripslashes($row_stmt[0]['test_mail_name']); 
    $test_email = stripslashes($row_stmt[0]['test_email']); 
    
    $upload_date = stripslashes($row_stmt[0]['upload_date']);
    
    if(trim($upload_date) != "" && $upload_date != "0000-00-00"){
        $upload_date = date('d-m-Y' , strtotime($upload_date));    
    }else{
        $upload_date = "";
    }
    
    
}
else
{
    $id = "";
    $con = "add";
    $status = "ACTIVE";
    $test_email = "";   
    
}

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css">

<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>

<style>
  .editor *{
    -webkit-box-sizing: unset;
    -ms-box-sizing: unset;
    -moz-box-sizing: unset;
    box-sizing: unset;
  }
</style>


<script src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckeditor/ckeditor.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
   CKEDITOR.config.toolbar_Basic =
    [
        ['Source', '-', 'Bold', 'Italic','Underline','DocProps','Preview','Print','Cut','Copy','Paste','Undo','Redo'], 
        ['NumberedList', 'BulletedList', 'CreateDiv', 'Outdent', 'Indent'], 
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Link', 'Unlink'],
        ['Image', 'Table', 'HorizontalRule', 'Smiley','Youtube'],
        ['ComboText', 'FontSize', 'TextColor', 'BGColor' ]
    ];

    CKEDITOR.config.toolbar = 'Basic';

</script>



<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
                test_mail_name: "required",
                test_email: "required"
               
        },
        messages: {
            test_mail_name: "",
            test_email: ""
        },
        submitHandler: function() {
            
            //var dcontent = escape(CKEDITOR.instances.brief_description.getData()); 
            
            var value = $("#frm").serialize();
            
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&" +  value,
			   beforeSend: function() { 
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){                   
                  
                   var cond = $("#con").val();
                   
                   setTimeout(function(){
                        $("#INPROCESS").html("");                        
                        var spl_txt = msg.split("~~~"); 
                        
                        var colorStyle = "";
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            colorStyle = "success"; 
                        } 
                        else
                        {
                            colorStyle = "error";
                        }
                        
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                        
                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' />&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>");
                            
                        },1000);
                         
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            if(cond =="modify")
                            {
                                window.location.href = "<?php echo PAGE_LIST; ?>"; 
                            }
                            else
                            {
                                window.location.href = "<?php echo PAGE_MAIN; ?>"; 
                            }
                        }
                                               
                    },1000); 
               }
            });
        }
    });
    
    
    $("#cancel").live("click", function(){    
        //location.href='<?php echo PAGE_MAIN; ?>';  
        <?php
        if($con == "modify")
        {
        ?>
            location.href='<?php echo PAGE_LIST; ?>';
        <?php
        }
        else
        {
        ?>
            window.location.reload('<?php echo PAGE_MAIN; ?>');
        <?php
        }
        ?>
     });
    
    
});

</script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.datepick.js"></script>
<script type="text/javascript">
$(function(){
  
    $('#upload_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+1 year')); ?>'
    });  
  
});

</script>
    
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery.datepick.css";
</style>

<h1>Mailing List<div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go To List</a></div></h1>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" />
 

<div class="addWrapper master">
    <div class="boxHeading expendBtn1"> <span id="MOD"><?php echo ucwords($con);?></span></div>
    <div class="clear"></div>
    
    <div class="containerPad expendableBox1">
    <div class="fullWidth">                    	
            <div class="width3">
                <label class="mainLabel">Name <span>*</span></label>
                <input type="text" class="txtBox" value="<?php echo $test_mail_name;?>" name="test_mail_name" id="test_mail_name" AUTOCOMPLETE = "OFF" maxlength="200"/>
            </div>
            
        </div>
    <div class="fullWidth">                    	
            <div class="width3">
                <label class="mainLabel">Email <span>*</span></label>
                <input type="email" class="txtBox" value="<?php echo $test_email;?>" name="test_email" id="test_email" AUTOCOMPLETE = "OFF" maxlength="200"/>
            </div>
            
        </div>
		

    
        <!--div class="fullDivider noGap">
            <div class="sml_heading ">Content <span style="color: #FF0000;">*</span> </div>
        </div>
       
        <div class="fullWidth div_content validateMsg editor">
            <textarea name="brief_description" id="brief_description" style="width:90%; height:230px; float:left;"><?php echo $brief_description; ?></textarea>
            <script>
            CKEDITOR.replace("brief_description",
                {
                    enterMode: 2,
                    //extraPlugins: 'youtube',
                    filebrowserBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                } 
            );
            </script>
        </div--><!--fullWidth end-->
        
        <div class="clear">&nbsp;</div>
        
        
        <div class="fullWidth noGap">           
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' />
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
        	</div>               
        </div><!--fullWidth end--> 
    </div><!--containerPad end-->
</div><!--addWrapper end-->
</form>

        


