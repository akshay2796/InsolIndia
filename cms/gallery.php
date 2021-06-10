<?php 
ob_start();
error_reporting(E_ALL); 
include("header.php");

define("PAGE_MAIN","gallery.php");	
define("PAGE_AJAX","ajax_gallery.php");
define("PAGE_LIST","gallery_list.php");

define("SET1_ENABLE",true);
if ( SET1_ENABLE == true ){
    
    define("SET1_TYPE","IMAGE");
    if ( SET1_TYPE == "FILE" ){ 
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);    
        define("SET1_IMAGE_CAPTION",false);    
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['GALLERY_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['GALLERY_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","");    
        
    }else if ( SET1_TYPE == "IMAGE" ){
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);   
        define("SET1_IMAGE_CAPTION",true);    
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['GALLERY_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['GALLERY_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","Min. size required 245px x 160px");
    
    }    
    
    define("SET1_FOR","GALLERY");
    define("SET1_MANDATORY",false);
    
    define("SET1_FOLDER",FLD_GALLERY . "/" . FLD_GALLERY_IMG);
    define("SET1_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);
    
    define("SET1_DBTABLE",GALLERY_IMAGES_TBL);
    
     
    
    $SET1_RESIZE_DIMENSION = "" ; //widthXheight|weightXheight SEPRATED BY PIPE
    $SET1_SAVE_RESIZE_LOCATION_RELPATH = ""; 
    $SET1_RESIZE_PREFIX_RELPATH = "";
    
    if ( SET1_IMAGE_CROPPING  == true ){
        
        define("PAGE_CROP_IMAGE","popupCROP.php");
        
        define("SET1_CROP_SIZE","");
        define("SET1_CROP_PREFIX","C".SET1_CROP_SIZE."-"); 
        define("SET1_CROP_ASPECT_RATIO","1:1");
        define("SET1_CROP_IMAGE_WIDTH","500");
        define("SET1_CROP_IMAGE_HEIGHT","500");
        
        
        
        define("SET1_IMAGE_RESIZE","YES");  /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========    
        define("SET1_IMAGE_RESIZE_WIDTH",700);
        define("SET1_IMAGE_RESIZE_HEIGHT",700);    
        define("SET1_IMAGE_RESIZE_PREFIX","R".SET1_IMAGE_RESIZE_WIDTH."-");
        
        $SET1_RESIZE_DIMENSION = SET1_IMAGE_RESIZE_WIDTH . "X" . SET1_IMAGE_RESIZE_HEIGHT;
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
        
        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;
          
        
    }else if ( SET1_IMAGE_CROPPING  == false ){ 
        
        define("SET1_IMAGE_RESIZE","NO");   /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========
        
        define("SET1_CROP_SIZE","");
        define("SET1_CROP_PREFIX","");  
        define("SET1_CROP_ASPECT_RATIO","");
        define("SET1_CROP_IMAGE_WIDTH","");
        define("SET1_CROP_IMAGE_HEIGHT","");
          
        
        define("SET1_IMAGE_RESIZE_WIDTH","");
        define("SET1_IMAGE_RESIZE_HEIGHT","");       
        define("SET1_IMAGE_RESIZE_PREFIX",""); 
        
        $SET1_RESIZE_DIMENSION = "";    
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
        
        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;
        
    } 
    
}



$ID = intval(base64_decode($_REQUEST['ID']));
 

if( (intval($ID) > intval(0)) )
{
    $con = "modify";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . GALLERY_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND gallery_id = :gallery_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":gallery_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    
    if(count($rsGET)==intval(0))
    {
        header("Location:".PAGE_MAIN);
    }
    
      
    $gallery_name = htmlentities(stripslashes($rsGET[0]['gallery_name']));  
    $gallery_date = stripslashes($rsGET[0]['gallery_date']);
    
    if(trim($gallery_date) != "" && $gallery_date != "0000-00-00"){
        $gallery_date = date('d-m-Y' , strtotime($gallery_date));    
    }else{
        $gallery_date = "";
    }
    
    //$gallery_description = stripslashes($rsGET[0]['gallery_description']);  
    
    $status = htmlentities(stripslashes($rsGET[0]['status']));                        
    
    
    $set1_uploadMORE = 0;
    if ( SET1_ENABLE == true ){
        
        
        $QRY = "";
        $QRY .= "SELECT * FROM " . GALLERY_IMAGES_TBL . " WHERE master_id = :master_id order by default_image desc, position,image_id ";
        //echo $QRY . $ID . "<BR>";
        $sIMG = $dCON->prepare($QRY);
        $sIMG->bindParam(":master_id",$ID);
        $sIMG->execute();
        $rsIMG_set1 = $sIMG->fetchAll(); 
        $sIMG->closeCursor();
        $cntIMG_set1 = intval(count($rsIMG_set1)); 
        $set1_uploadMORE = 0;  
    
        if ( intval($cntIMG_set1) > intval(0) ){
            if ( ( SET1_IMAGE_MULTIPLE  == true )  ){
                $set1_uploadMORE = 1;
            } 
        }elseif ( intval($cntIMG_set1) == intval(0) ){
            $set1_uploadMORE = 1;             
        }
    
    }
    
    $METATITLE = htmlentities(stripslashes($rsGET[0]['meta_title'])); 
    $METAKEYWORD = htmlentities(stripslashes($rsGET[0]['meta_keyword'])); 
    $METADESCRIPTION = htmlentities(stripslashes($rsGET[0]['meta_description'])); 
    
    
}
else
{
    $con = "add";
    $ID = "";
    $status = "ACTIVE";
    
 
    $set1_uploadMORE = 1;  
    
    $METATITLE = "";
    $METAKEYWORD = "";
    $METADESCRIPTION = "";
    
}

$QRYSTR = "";
$QRYSTR .= "con=".SET1_DBTABLE;
$QRYSTR .= "&cname1=image_name&cname2=image_id";

?>



<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>maxlength.js"></script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css"> 



<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>

<?php 
if ( SET1_ENABLE == true ){  
    include("include_SET1_uploader.php");
}  
?>

 


<script language="javascript" type="text/javascript">
$(function() {
         
    $.fn.removeImage = function() {
        var args = arguments[0] || {};
        var imgID = args.imgID || 0; 
        var uFID = args.uFID || "";
        var foldername = args.foldername || "";
        var copy = args.copy || "";
        
        var indx = $(".removeImage").index(this);
        var cl_r_image = $(".cl_r_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imgID+"---"+foldername+"---"+copy);
        //return false;
        if( parseInt(imgID) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c)
            {
                return false;
            }else{
                
            }
        }
        else
        {
            
        }
        //alert(imgID + "--"+cl_r_image )
        //remove only image  
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImage&image_name=" + cl_r_image + "&imgID=" + imgID + "&foldername="+foldername+ "&copy="+copy,
            beforeSend: function() {
                $(".removeImage:eq(" + indx + ")").hide();
                $(".removeImageLoader:eq(" + indx + ")").show();
            },
            success: function(msg) {
                
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                
                <?php if ( SET1_ENABLE  == true ){ ?>
                                        
                    $("#SET1_BOX_COUNT").val($(".set1_image_id").length);
                    
                    //alert("LEN->" + parseInt($(".set1_image_id").length));
                    if ( parseInt($(".set1_image_id").length) == parseInt(0) ){
                        // IF ZERO than display atleast one BOX to upload 
                        $("#set1_pickup").show();    
                    }
                    
                         
                <?php } ?>
                
                
                
                
                //alert("uFID=" + uFID);
                
                if(uFID != "")
                {
                    $("#" + uFID).remove();
                }
                
            }
        });  
          
    };
    
   
    
    // call croping pop up
    $(".crop_img").live('click',function(){
       
        var crop_image = $(this).attr('value');
       	var IMG_NO = $(this).attr('imgno');
        var selectedcoordinates = $(".sel_coordinates"+IMG_NO).val();
        var foldername = $(this).attr('foldername');
        var image_id = $(this).attr('addedimgID');
         
        //alert(crop_image+"\n"+IMG_NO+"\n"+selectedcoordinates)
        
        //return false;
     	$.fancybox.open({
			href : '<?php echo PAGE_CROP_IMAGE;?>?cimage_name='+crop_image+"&img_no="+IMG_NO+"&selectedcoordinates="+selectedcoordinates+"&foldername="+foldername+"&image_id="+image_id+"&CALLFROM=<?php echo SET1_FOR; ?>&ASPECTRATIO=<?php echo SET1_CROP_ASPECT_RATIO; ?>&CROPWIDTH=<?php echo SET1_CROP_IMAGE_WIDTH; ?>&CROPHEIGHT=<?php echo SET1_CROP_IMAGE_HEIGHT; ?>",
			type : 'iframe',
			padding : 5,
			width: 1200
		});
    });
    
    
    $(".setDefault").click(function(){
        var image_id = $(this).attr("valueid");
        var foldername = $(this).attr("foldername");
        //alert(foldername)
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=setDefaultImage&image_id="+image_id+"&foldername="+foldername+"&gallery_id=<?php echo $ID; ?>",
            beforeSend: function(){
       
            },
            success: function(msg){
                //alert(msg);
             }
        }); 
      
    }); 
    
});


function checkNum1(num)
{ 
	var w = ""; 
	var v = "0123456789."; 
	for (i=0; i < num.value.length; i++) 
	{	
		x = num.value.charAt(i); 
		if (v.indexOf(x,0) != -1) w += x; 
	} 
	num.value = w; 
}
function checkNum2(num)
{ 
	var w = ""; 
	var v = "0123456789"; 
	for (i=0; i < num.value.length; i++) 
	{	
		x = num.value.charAt(i); 
		if (v.indexOf(x,0) != -1) w += x; 
	} 
	num.value = w; 
}

</script>


<script src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckeditor/ckeditor.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
   /*
    CKEDITOR.config.toolbar_Basic =
    [
        ['Source', '-', 'Bold', 'Italic','Underline','DocProps','Preview','Print','Cut','Copy','Paste','Undo','Redo'], 
        ['NumberedList', 'BulletedList', 'CreateDiv', 'Outdent', 'Indent'], 
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Link', 'Unlink'],
        ['Image', 'Table', 'HorizontalRule', 'Smiley','Youtube'],
        ['ComboText', 'FontSize', 'TextColor', 'BGColor' ]
    ];

    CKEDITOR.config.toolbar = 'Basic';
    */
</script>



<?php
$position_qry_string = "";
$position_qry_string .= "con=".PRODUCT_IMAGES_TBL;
$position_qry_string .= "&cname1=image_name&cname2=image_id";
?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
     
      
     
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            gallery_name: "required"
            //,gallery_date: "required" 
        },
        messages: {
            gallery_name: ""
            //,gallery_date: "" 
        },
        submitHandler: function() {
            
            <?php if ( SET1_ENABLE == true ){ ?>  
                
                <?php if ( SET1_MANDATORY == true ){ ?> 
                    var set1_imgcount = $(".set1_icount").length;
                    //alert(imgCount);
                    if(parseInt(set1_imgcount)==parseInt(0))
                    {
                        $("#set1_pickup").css('border', "solid 1px red");  
                        alert("Kindly upload a file");                        
                        return false;
                    }else{
                        $("#set1_pickup").css('border', "solid 0px red");                        
                    }
                
                <?php } ?>
                        
                var Set1Uploading = $('#SET1_UPLOAD_IN_PROCESS').val();
                if(parseInt(Set1Uploading)==parseInt(1))
                {
                    alert("Upload in progress, please wait!")
                    return false;
                }
            <?php } ?> 
            
            
            var ImgUploading = $('#UPLOAD_IN_PROCESS').val();
            if(parseInt(ImgUploading)==parseInt(1))
            {
                alert("Image Upload in progress, please wait!")
                return false;
            }
            
            
            //var dcontent = escape(CKEDITOR.instances.gallery_description.getData()); 
            var value = $("#frm").serialize();
            //alert(value);
            //return false;
            
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&" + value,
			   beforeSend: function(){
                    //$("#INPROCESS").html("<div id='fInprocess'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load25.gif' align='absmidlle' border='0' />Processing...</div>");
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){
                   //alert(msg);
				   //return false;                 
                   var cond = $("#con").val();
                   var copyEv = "<?php echo $copy;?>";
                   
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
                                if(cond=="modify")
                                {
                                    window.location.href = "<?php echo PAGE_LIST; ?>";
                                }
                                else
                                {
                                    window.location.href = "<?php echo PAGE_MAIN; ?>";
                                }
                            }
                               
                        },2000);
                        
                                             
                    },1000); 
                  
					 
                }
            });
        }
    });
    
     
     
    
    $("#cancel").live("click", function(){    
          
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

$(function() {
  
    $('#gallery_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '<?php echo date("Y", strtotime('-3 year')); ?>:<?php echo date("Y", strtotime('+1 year')); ?>'
    });   
});


function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery.datepick.css";
</style>
 

<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">

    <input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
    <input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;"/>
     
    
    <?php if ( SET1_ENABLE == true ){ ?>  
        <input type="hidden" name="SET1_UPLOAD_IN_PROCESS" id="SET1_UPLOAD_IN_PROCESS" value="0" readonly style="display: none;"/>
        <input type="hidden" name="SET1_BOX_COUNT" id="SET1_BOX_COUNT" value="0" readonly style="display: none;"/>
    <?php } ?>
     
     
<h1>
    Gallery <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1>
<div class="addWrapper">
	<div class="boxHeading"><?php echo ucwords($con); ?></div>
    <div class="clear"></div>
    <div class="containerPad">
    	
             
        <div class="fullWidth">
            <div class="fullWidth">
            	<label class="mainLabel">Name <span>*</span></label>
                <input type="text" class="txtBox" name="gallery_name" id="gallery_name" value="<?php echo $gallery_name; ?>" maxlength="500" autocomplete="OFF" />
            </div>              
        </div>
        <div class="extraSpace">&nbsp;</div>
        <div class="fullWidth noGap">
            <div class="width4">
            	<label class="mainLabel">Date <span></span></label>
                <div class="txt3Box">
                    <input type="text" class="titleTxt txtBox" name="gallery_date" id="gallery_date" value="<?php echo $gallery_date; ?>" maxlength="12" placeholder="" style="width: 90px;" autocomplete="OFF" />&nbsp;&nbsp;
                    
                </div>  
            </div>  
             
        </div><!--fullWidth end-->        
        
       <!-- <div class="fullDivider">
        	<div class="sml_heading">Details <span></span> </div>
        </div> 
        <div class="fullWidth noGap">        	
            <label class="mainLabel">Full</label>
        </div>
        <div class="fullWidth">
            <textarea name="gallery_description" id="gallery_description" style="width:90%; height:230px; float:left;"><?php echo $gallery_description; ?></textarea>
            <script>
            /*
            CKEDITOR.replace("gallery_description",
                {
                    enterMode: 2,
                    extraPlugins: 'youtube',
                    filebrowserBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                } 
            );
             */
            </script>
                       	
        </div> --> <!--fullWidth end-->
         
        <div class="fullWidth noGap" id="image_list">
        	<?php if ( SET1_ENABLE == true ){ ?>
                <div class="fullWidth">
                    <div class="sml_heading" id="uploadImgPos">
                        <?php 
                        echo "Upload Gallery " .  ucwords(strtolower(SET1_TYPE));
                        if ( SET1_IMAGE_MULTIPLE == true ){
                             echo "s";    
                        }                            
                        echo " (Size Limit " . SET1_UPLOAD_FILE_SIZE . ") ";
                        if ( SET1_TYPE == "FILE" ){
                            echo "";
                        }else if ( SET1_TYPE == "IMAGE" ){
                            echo " - <small>" . SET1_MINIMUM_RESOLUTION . "</small>"; 
                        } 
                        ?>
                        <span id="imagealert"></span>
                        
                        <span style='float:right;color:red'>
                            <input type="checkbox" name="validateUpload" id="validateUpload" style="display: none; "  />
                        </span>
                    </div>
                </div>
                <?php include("include_SET1_view.php"); ?> 
            <?php } ?>
        </div>
        
        <div class="fullWidth div_content">
        	<div class="sml_heading">SEO Fields [ <small class="instructions">Use Below Tags to Enhance User Experience and Improve SEO</small>    ] </div>
        </div>
            
        <div class="fullWidth">
        	<div class="fullWidth">  
                <label class="mainLabel">Meta Title </label>
                <input type="text" class="titleTxt txtBox" name="meta_title" id="meta_title" value="<?php echo $METATITLE; ?>" maxlength="250" autocomplete="OFF">
            </div>
            <div class="fullWidth">  
                <label class="mainLabel">Meta Keyword </label>
                <input type="text" class="titleTxt txtBox" name="meta_keyword" id="meta_keyword" value="<?php echo $METAKEYWORD; ?>" maxlength="350" autocomplete="OFF">
            </div>
            <div class="fullWidth">  
            	<label class="mainLabel">Meta Description </label>
                <input type="text" class="titleTxt txtBox" name="meta_description" id="meta_description" value="<?php echo $METADESCRIPTION; ?>" maxlength="250" autocomplete="OFF">
            </div>
        </div> 
               
        <?php if ( trim($con) == "modify" ){ ?>
            <div class="fullDivider">
            	<div class="sml_heading">Status</div>
            </div>
            
            <div class="fullWidth">
                <label class="radioGroup"><input type="radio" name="status" value="ACTIVE" <?php if ( trim($status) == "ACTIVE" ){ echo " checked='' "; } ?> /> Active</label>
        		<label class="radioGroup"><input type="radio" name="status" value="INACTIVE" <?php if ( trim($status) == "INACTIVE" ){ echo " checked='' "; } ?> /> Inactive</label>            	
            </div>
        <?php } ?>
        
        
        <div class="fullWidth noGap">
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' name='save'/>
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
            </div>           
        </div>
                                  
    </div><!--containerPad end-->
</div>            
</form>  
             
<?php include("footer.php");?>      
