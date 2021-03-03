<?php
error_reporting(1); 
session_start();
include("all_include.php");
include("../library_law/class.imageresizer.php");
define("PAGE_AJAX","ajax_crop_image.php");

$selected_coordinates = $_REQUEST['selectedcoordinates'];
$FOLDER_NAME = $_REQUEST['foldername'];
$image_id = intval($_REQUEST['image_id']);


//$FOLDER_NAME = TEMP_UPLOAD;


$selected_coordinates = explode(",",$selected_coordinates);
$x_coordinate = $selected_coordinates[0];
$y_coordinate = $selected_coordinates[1];
$x1_coordinate = $selected_coordinates[2];
$y1_coordinate = $selected_coordinates[3];
$w_coordinate = $selected_coordinates[4];
$h_coordinate = $selected_coordinates[5];


$img_no = intval($_REQUEST['img_no']);
$crop_image_name = trim($_REQUEST['cimage_name']);
//$cropped_image_name = filterIMG($_REQUEST['cimage_name']);

//$CROP_WIDTH = "600"; //main thumb width
//$CROP_HEIGHT = "402"; //main thumb height

$CROP_WIDTH = "600"; //main thumb width
$CROP_HEIGHT = "402"; //main thumb height

$ASPECTRATIO = "";
$ASPECTRATIO = '3:2';



$CROP_IMG_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/".$crop_image_name;

$DISPLAY_IMG = "";
if( $x_coordinate != "" && $y_coordinate != "" && $x1_coordinate != "" && $y1_coordinate != "" && $w_coordinate != "" && $h_coordinate != "" )
{
     $RPATH = "";
     $RPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH.$FOLDER_NAME;
     $APATH = "";
     $APATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH.$FOLDER_NAME;
    
     $IMG_ABS_PATH = $APATH .'/'.  $crop_image_name;
     $IMG_REL_PATH = $RPATH .'/'. $crop_image_name;                            
    
    $DISPLAY_IMG = "";
    
    $IMG_EXIST = chkImageExists($IMG_REL_PATH);
    if(intval($IMG_EXIST) == intval(0))
    {                                
        $DISPLAY_IMG = '';
    }
    else
    {
        $DISPLAY_IMG = $IMG_ABS_PATH;
    }
    
    
}

?>

<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>style.css" />
<!-- Add jQuery library -->
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.validate-latest.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.js?v=2.1.4"></script>
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fancybox/jquery.fancybox.css?v=2.1.4" media="screen" />
<script>
	$(document).ready(function() {
		$('.fancybox').fancybox({'width' : '95%', 'maxWidth':800});			
	});
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function(){ 
      
        var x1 = $('#x1').val();
        var y1 = $('#y1').val();
        var x2 = $('#x2').val();
        var y2 = $('#y2').val();
        var w = $('#w').val();
        var h = $('#h').val();
         
        if( $.trim(x1) == "" && $.trim(y1) == "" && $.trim(x2) == "" && $.trim(y2) == "" && $.trim(w) == "" && $.trim(h) == "" )
        {
              
                $("#uploaded_image").attr("src", "<?php echo $CROP_IMG_RELPATH; ?>");  
                $('#uploaded_image').imgAreaSelect({ aspectRatio: '<?php echo $ASPECTRATIO; ?>', onSelectChange: preview}); //, maxWidth: <?php //echo $CROP_WIDTH; ?>, maxHeight: <?php //echo $CROP_HEIGHT; ?> });
                $('#uploaded_image').imgAreaSelect({enable: true});
                $("#image_selection_area").hide(); 
                
                setTimeout(function(){
                    $("#thumbnail").attr("src", "<?php echo $CROP_IMG_RELPATH; ?>" );
                    
                  
                        $('#uploaded_image').imgAreaSelect({show: true, x1: 0, y1: 0, x2: 120, y2: 80});
                        $('#x1').val(0);
                    	$('#y1').val(0);
                    	$('#x2').val(100);
                    	$('#y2').val(100);
                    	$('#w').val(100);
                    	$('#h').val(100);
                        
                        var scaleX = <?php echo $CROP_WIDTH;?> / 100; 
                    	var scaleY = <?php echo $CROP_HEIGHT;?> / 100; 
                    	
                    	$('#thumbnail').css({ 
                    		width: Math.round(scaleX * $("#uploaded_image").width()) + 'px', 
                    		height: Math.round(scaleY * $("#uploaded_image").height()) + 'px',
                    		marginLeft: '-' + Math.round(scaleX * 0) + 'px', 
                    		marginTop: '-' + Math.round(scaleY * 0) + 'px' 
                    	});
                    
                    
                    
                }, 500);
              
         
        }
        
     
       
       $("#frmProductCropImage").validate({
        
          submitHandler: function() {
               frmvalue = $("#frmProductCropImage").serialize();
                var x1 = $('#x1').val();
        		var y1 = $('#y1').val();
        		var x2 = $('#x2').val();
        		var y2 = $('#y2').val();
        		var w = $('#w').val();
        		var h = $('#h').val();
                
                if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h=="")
                {
        			alert("You must make a selection first");
        			return false;
        		} 
              
                 $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=saveCropImage&"+frmvalue,
                   beforeSend: function(){
                        //$("#INPROCESS").html("<div id='inprocess'><div id='inprocessimg'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif' align='absmidlle' border='0' ></div> <div id='inprocesstxt'>Processing...</div></div>");	               
                   		$("#INPROCESS").html("");                    
                    	$("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
				   },
                   success: function(msg){
                         
                        //alert(msg);
                        setTimeout(function(){
                        
                            $("#INPROCESS").html("");
                             
                            var spl_txt = msg.split("~~~"); 
                            
                            //alert(spl_txt[0])
                            
                            var colorStyle = "";
                            if(spl_txt[1] == '1')
                            {
                                colorStyle = "success";
                            }
                            else
                            {
                                colorStyle = "error";
                            }
                            
                            ///alert(colorStyle);
                            
                            //$("#INPROCESS").html("<div id='inprocess'><div id='inprocessimg'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif' align='absmidlle' border='0' ></div> <div id='" + colorStyle + "' >" + spl_txt[2] + "</div></div>");
                            $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                            $("#inprocess").fadeOut(4500);
                   
                            if(spl_txt[1] == '1')
                            {
                                setTimeout(function(){
                                    
                                    $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' >");
                                    
                                    //alert(spl_txt[3]+" "+<?php echo $img_no; ?>)
                                    parent.$(".imgno<?php echo $img_no; ?>").attr('src',"");
                                    
                                    parent.$(".imgno<?php echo $img_no; ?>").attr('src',spl_txt[3]+"?"+Math.random());
                                    parent.$(".sel_coordinates<?php echo $img_no; ?>").val(spl_txt[4]);
                                   
                                    
                                    parent.$.fancybox.close();
                                     
                                },1000);
                            }
                            else
                            {
                                 setTimeout(function(){
                                    $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' >");
                                    
                                },2000);
                            }
                        
                         },2000);
                        
                   }
             });
            
            
          }
        
    });
 
    
});

function preview(img, selection) {  
	var scaleX = <?php echo $CROP_WIDTH;?> / selection.width; 
	var scaleY = <?php echo $CROP_HEIGHT;?> / selection.height; 
	
	$('#thumbnail').css({ 
		width: Math.round(scaleX * $("#uploaded_image").width()) + 'px', 
		height: Math.round(scaleY * $("#uploaded_image").height()) + 'px',
		marginLeft: '-' + Math.round(scaleX * selection.x1) + 'px', 
		marginTop: '-' + Math.round(scaleY * selection.y1) + 'px' 
	});
    
	$('#x1').val(selection.x1);
	$('#y1').val(selection.y1);
	$('#x2').val(selection.x2);
	$('#y2').val(selection.y2);
	$('#w').val(selection.width);
	$('#h').val(selection.height);
}


</script> 

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    <?php if(trim($DISPLAY_IMG) != "" && trim($x_coordinate) != "" && trim($x1_coordinate) != "" && trim($y_coordinate) != "" && trim($y1_coordinate) != "" ) { ?> 
        
        setTimeout(function(){
            $('#uploaded_image').imgAreaSelect({
                aspectRatio: '<?php echo $ASPECTRATIO; ?>',
                x1: <?php echo $x_coordinate; ?>, 
                y1: <?php echo $y_coordinate; ?>, 
                x2: <?php echo $x1_coordinate; ?>, 
                y2: <?php echo $y1_coordinate; ?>, 
                onSelectChange: preview 
            });
            
            var scaleX = <?php echo $CROP_WIDTH;?> / <?php echo $w_coordinate; ?>; 
        	var scaleY = <?php echo $CROP_HEIGHT;?> / <?php echo $h_coordinate; ?>; 
        	
        	$('#thumbnail').css({ 
        		width: Math.round(scaleX * $("#uploaded_image").width()) + 'px', 
        		height: Math.round(scaleY * $("#uploaded_image").height()) + 'px',
        		marginLeft: '-' + Math.round(scaleX * <?php echo $x_coordinate; ?>) + 'px', 
        		marginTop: '-' + Math.round(scaleY * <?php echo $y_coordinate; ?>) + 'px' 
        	});
        
        },1000); 
    <?php } ?>
});
</script>
<div id="product_crop_popup">
	<form action="" method="post" name="frmProductCropImage" id="frmProductCropImage" enctype="multipart/form-data">
        <input type="thidden" name="crop_picture" id="crop_picture" value="<?php echo $crop_image_name; ?>" />
        <input type="thidden" name="x1" value="<?php echo $x_coordinate; ?>" id="x1" />
    	<input type="thidden" name="y1" value="<?php echo $y_coordinate; ?>" id="y1" />
    	<input type="thidden" name="x2" value="<?php echo $x1_coordinate; ?>" id="x2" />
    	<input type="thidden" name="y2" value="<?php echo $y1_coordinate; ?>" id="y2" />
    	<input type="thidden" name="w" value="<?php echo $w_coordinate; ?>" id="w" />
    	<input type="thidden" name="h" value="<?php echo $h_coordinate; ?>" id="h" /> 
       	
        <input type="thidden" name="foldername" value="<?php echo $FOLDER_NAME; ?>" id="foldername" /> 
        <input type="thidden" name="image_id" value="<?php echo $image_id; ?>" id="image_id" /> 
        
        
           
        <table cellpadding="1" cellspacing="5" border="0"  align="left" width="100%"> 
            <tr>
                <td colspan="2"> 
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center" valign="middle" height="402" width="600" style="background-color: #ccc; padding:0px;">
                                <img alt="Image Preview" title="Image Preview" src="<?php echo $DISPLAY_IMG; ?>" id="uploaded_image" />
                            </td>
                            <td width="10"></td>
                            <td valign="top"> 
                                <table cellspacing="0">                                                
                                    <tr>                                                
                                        <td align="center">
                                            <?php /*?><div id="thumbmail_preview" style="width:<?php echo $CROP_WIDTH;?>px; height:<?php echo $CROP_HEIGHT;?>px;">
                                                <span style="width:<?php echo $CROP_WIDTH;?>px; height:<?php echo $CROP_HEIGHT;?>px;"><img id="thumbnail" src="<?php echo $DISPLAY_IMG; ?>" style="position: relative;vertical-align:middle;" alt="Thumbnail Preview" title="Thumbnail Preview" /></span>
                                            </div><?php */?>
                                            
                                            <div id="thumbmail_preview" style="width:600px; height:402px;">
                                                <span style="width:600px; height:402px;"><img id="thumbnail" src="<?php echo $DISPLAY_IMG; ?>" style="position: relative;vertical-align:middle;" alt="Thumbnail Preview" title="Thumbnail Preview" /></span>
                                            </div>
                                           
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left" height="40" id="INPROCESS" nowrap><input type="submit" value="Save" name='save' id='save' class="submitBtn" /> </td>
                                    </tr>                                                                                         
                                </table>                                            
                            </td>
                        </tr> 
                    </table>
                </td>
            </tr>                          
        </table>

    </form>
</div>
 