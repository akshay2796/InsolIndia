<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","sig24_intro.php");	
define("PAGE_AJAX","ajax_sig24.php");


    
$SQL  = "";
$SQL .= " SELECT * FROM " . SIG24_INTRO_TBL . " as A ";
$SQL .= " WHERE status <> 'DELETE' limit 1 ";
$sGET = $dCON->prepare( $SQL );
$sGET->execute();
$rsGET = $sGET->fetchAll();
$sGET->closeCursor();

if(count($rsGET) > intval(0))
{
    $ID = intval(stripslashes($rsGET[0]['intro_id']));  
    $intro_content = htmlentities(stripslashes($rsGET[0]['intro_content']));  
    $con = "modify";
}
else
{
    $con = "add";
    $ID = "";
    $status = "ACTIVE";
}


?>

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
            
            intro_content: "required" 
        },
        messages: {
            intro_content: ""
        },
        submitHandler: function() {
            var value = $("#frm").serialize();
            var dcontent = escape(CKEDITOR.instances.intro_content.getData()); 
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveINTRO&dcontent=" + dcontent + "&" +  value,
			   beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
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
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' name='save'/>");
                            
                            
                            if( parseInt(spl_txt[1]) == parseInt(1) )
                            {
                               
                                window.location.href = "<?php echo PAGE_MAIN; ?>";
                                
                            }
                               
                        },2000);
                        
                                             
                    },1000); 
                  
					 
                }
            });
        }
    });
    
    
    
    
    $("#cancel").live("click", function(){    
        //location.href='<?php echo PAGE_MAIN; ?>';  
        
        window.location.reload('<?php echo PAGE_MAIN; ?>');
       
     });
     
       
});

    
</script>




<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;"/>
<h1>
    SIG 24 Intro
</h1>
<div class="addWrapper">
	<div class="boxHeading">Manage</div>
    <div class="clear"></div>
    <div class="containerPad">
        <div class="fullWidth validateMsg">        	
            <textarea name="intro_content" id="intro_content" style="width:90%; height:230px; float:left;"><?php echo $intro_content; ?></textarea>
            <script>
            CKEDITOR.replace("intro_content",
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
        </div>
        <div class="fullWidth noGap">
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' name='save'/>
            </div>           
        </div>
    </div><!--containerPad end-->
</div>            
</form>  
             
<?php include("footer.php");?>      
