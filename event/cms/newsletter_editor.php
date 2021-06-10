<?php 
ob_start();
error_reporting(E_ALL);
include("header.php");

define("PAGE_MAIN","newsletter_editor.php");	
define("PAGE_AJAX","ajax_newsletter_master.php");


if( !is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_EDITOR))
{
    $mask=umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH .  FLD_NEWSLETTER_EDITOR, 0777);
    umask($mask);
}

   
$sql = "";
$sql .= "SELECT * FROM " . NEWSLETTER_EDITOR_TBL . " where status='ACTIVE' order by editor_id desc limit 1 ";
$stmtImg = $dCON->prepare($sql);
$stmtImg->execute();
$rsGET = $stmtImg->fetchAll(); 

if(count($rsGET)> intval(0))
{
    //$ImageCt = intval(count($rsGET));
    $FOLDER_NAME = FLD_NEWSLETTER_EDITOR; 
    $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME;  
    $con = "modify"; 
    $ID = intval($rsGET[0]['editor_id']);
    $editor_name = htmlentities(stripslashes($rsGET[0]['editor_name']));  
    $editor_text = stripslashes($rsGET[0]['editor_text']);  
}
else
{
    $con = "add";
    $display_con = "add";
    $ID = "";
    $editor_name = '';  
    $editor_text ='';   
}



$TEMP_FOLDER_NAME = "";
$TEMP_FOLDER_NAME = TEMP_UPLOAD;

$ASPECTRATIO = "";
$ASPECTRATIO = '1:1';

$RESIZE_WIDTH = "130"; //main resize width
$RESIZE_HEIGHT = "130"; //main resize height

$RESIZE_REQUIRED = "YES";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT ; //widthXheight|weightXheight SEPRATED BY PIPE 

$SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/R130-";
//echo "<br>".$SAVE_RESIZE_LOCATION_RELPATH;
//echo "<br>".$RESIZE_PREFIX_RELPATH;
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


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css"/> 

<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>
<script language="javascript" type="text/javascript">
//CODE FOR FILE UPLOAD STARTS....................
 
 /*
 $(function() {
    var uploader_main = new plupload.Uploader({
        //runtimes : 'gears,flash,html5,silverlight,browserplus',
        <?php 
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
        {
        ?>
                runtimes : 'flash,html5',
        <?php 
        } 
        else
        { 
        ?>
            runtimes : 'html5,flash',
        <?php 
        } 
        ?>
		browse_button : 'pickfiles_main',
		container : 'upload_container_main',
		max_file_size : '1mb',
      	url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/ADV_upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . TEMP_UPLOAD; ?>',
        
        multipart_params: { 
            "resize_image": "<?php echo $RESIZE_REQUIRED; ?>",
            "save_resized_images_to": "<?php echo $SAVE_RESIZE_LOCATION_RELPATH; ?>",
            "resize_size": "<?php echo $RESIZE_DIMENSION; ?>",
            "resize_image_name": "<?php echo $RESIZE_DIMENSION; ?>",
        },
        
        unique_names : false,
        multi_selection: false,
        
		flash_swf_url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.swf', 
		filters : [
			{title : "Image files", extensions : "jpg,jpeg,pjpeg,gif,png"}
		]
	});

	uploader_main.init();

	uploader_main.bind('FilesAdded', function(up, files) {
        
        $('#checkImgUploadingProgress').val(1);
        //CODE FOR AUTO UPLOAD.....
        uploader_main.start();
		////e.prarticleDefault();
		up.refresh(); // Reposition Flash/Silverlight
	});   
   
    uploader_main.bind('UploadProgress', function(up, file) {
        var progressBarValue = up.total.percent;
        //$('#progressbar').fadeIn().progressbar({
        //    value: progressBarValue
        //});
        $('#filelist_main').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif" />');
    });
    
    
	uploader_main.bind('Error', function(up, err) {
		
        alert("Error: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");
        
		up.refresh(); // Reposition Flash/Silverlight
	});
    
    uploader_main.bind('UploadComplete', function() {
        //alert("1")
        $('#checkImgUploadingProgress').val(0);
        $('#filelist_main').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload');
    });
    
    
    
	var images_file_name = "";
    var i=0;
        
	uploader_main.bind('FileUploaded', function(up, file) {         
        var image_list_html = "";
        var image_default  = "";
        if(i==0)
        {
           //image_default = "checked"; 
           image_default = ""; 
        }
        else
        {
            image_default  = "";
        }
        
       var removeImageTR_CT = parseInt($(".removeImageTR").size());
       
        var fixedImgCT = $("#img_box_count").val();
        
        if( parseInt(fixedImgCT) == parseInt(0) )
        {
            var fixedImg_CT = parseInt(1); 
            $("#img_box_count").val(1);
        }
        else
        {
            var fixedImg_CT = parseInt(fixedImgCT) + parseInt(1); 
            $("#img_box_count").val(fixedImg_CT);
        }
       
	  	image_list_html = image_list_html + '<div class="removeImageTR uploadImgContainer">';
            	image_list_html = image_list_html + '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>';
				    image_list_html = image_list_html + '<input type="hidden" class="editor_id" name="editor_id[]" value="0" /><input type="hidden" class="cl_r_image" id="image[]" name="image[]" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="folder_name" name="folder_name[]" value="<?php echo TEMP_UPLOAD; ?>" />';
                	image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg imgno'+fixedImg_CT+'" /></a></span></div>';       
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					image_list_html = image_list_html + '<td><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a></td>';
					image_list_html = image_list_html + '</tr></table>';
				image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '</div>';

		i++;
		
        
        $("#image_list").prepend(image_list_html);
        
        $("#pickfiles_main").hide(); //////////////////////For single image upload
        
        
                                                
        if( parseInt($(".removeImageTR").size()) > parseInt(0) )
        {
            $("#image_list").show();
        }
              
	});
    
    
    $.fn.removeImage = function() {
        var args = arguments[0] || {};
        var imageId = args.imageId || 0; 
        var uFID = args.uFID || "";
        var foldername = args.foldername || "";
        var indx = $(".removeImage").index(this);
        var cl_r_image = $(".cl_r_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imageId+"---"+foldername+"---"+cl_r_image);
        //return false;
        if( parseInt(imageId) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c)
            {
                return false;
            }
        }
        else
        {
            
        }
        //alert(imageId + "--"+cl_r_image )
        //remove only image  
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImageEditor&image_name=" + cl_r_image + "&imageId=" + imageId + "&foldername="+foldername,
            beforeSend: function() {
                $(".removeImage:eq(" + indx + ")").hide();
                $(".removeImageLoader:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                $(".cl_r_image:eq(" + indx + ")").val("");
                
                $("#pickfiles_main").show();
                
                
                if(uFID != "")
                {
                    $("#" + uFID).remove();
                }
                
            }
        });  
          
    };
  
    
    
});
*/
</script>


<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    
    $.validator.addMethod('chkDataText', function (data){
        if( $.trim(CKEDITOR.instances.editor_text.getData()) == "" )
        {
            return 0;
        }
        else
        {
            
            return 1;
        }
    }, ' * Message cannot be blank.'); 
    
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            editor_name : "required",
            editor_text: {
                chkDataText: true
            } 
        },
        messages: {
          editor_name : ""
          ,editor_text: " * Message cannot be blank"
        },
        submitHandler: function() {
            
            /*
            
            var imgCount = $(".cl_r_image").length;
            var ImgUploading = $('#checkImgUploadingProgress').val();
            //alert(imgCount);
            if(parseInt(imgCount)==parseInt(0))
            {
                alert("Please select image.")
                return false;
            }
            if(parseInt(ImgUploading)==parseInt(1))
            {
                alert("Image Upload in progress, please wait!")
                return false;
            }
            */
           
            var value = $("#frm").serialize();
            
            var econtent = escape(CKEDITOR.instances.editor_text.getData()); 
            
            //alert(value);
            //return false;
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveEditor&econtent=" + econtent + "&" +  value,
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
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                        
                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' name='save'/>");
                            
                            window.location.href = "<?php echo PAGE_MAIN; ?>";
                            
                            
                            
                        },1000);
                        
                                             
                    },1000); 
                  
					 
                }
            });
        }
    });
 
       
});

</script>


<div class="responsiveBox "> 
    <form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly="" style="display: none1;"/>
    <input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly="" style="display: none1;"/> 
    <input type="hidden" name="img_box_count" id="img_box_count" value="0" readonly="" style="display: none1;"/>
    <input type="hidden" name="checkImgUploadingProgress" id="checkImgUploadingProgress" value="0" readonly="" style="display: none1;"/> 
         
    <h1>Newsletter - Editor Message</h1>
    <div class="addWrapper">
    	<div class="boxHeading">Manage </div>
        <div class="clear"></div>
        <div class="containerPad">
            <!--div class="fullWidth noGap" id="image_list">
            	<?php
                /*
                if(count($rsGET) > intval(0))
                {
                
                    $editor_image = trim(stripslashes($rsGET[0]['editor_image']));
                    $editor_id = trim(stripslashes($rsGET[0]['editor_id']));
                    $chk_file = chkImageExists($FOLDER_PATH."/".$editor_image);
                    if(intval($chk_file) == intval(1))
                    {
                        $display_image = $FOLDER_PATH."/".$editor_image;
                    }
                    else
                    {
                        $display_image ="";
                    }
                    if($display_image !="")
                    {
            ?>
                        <div class="removeImageTR uploadImgContainer" id="listItem_<?php echo $editor_id; ?>">
                            <div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                                <input type="hidden" class="editor_id" name="editor_id[]" value="<?php echo $editor_id;?>" />
                                <input type="hidden" class="folder_name" name="folder_name[]" value="<?php echo $FOLDER_NAME; ?>" />
                                <input type="hidden" class="cl_r_image" id="image[]" name="image[]" value="<?php echo $editor_image;?>" />
                            	<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $display_image; ?>" class="fixedImg imgno<?php echo $editor_id;?>" /></a></span></div>       
                            </div>
                            <div class="uploadImgBtn">
                            	<table>
                                    <tr>
                                    	<td><a href="javascript:void(0);" onclick="$(this).removeImage({imageId:<?php echo $editor_id;?>,foldername:'<?php echo $FOLDER_NAME; ?>'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif" class="removeImageLoader" style="display:none;" /> </td>
                                	</tr>
                                </table>
                            </div>
                        </div>      
                <?php  
                       
                    }      
                   
                }*/
                ?>
                
                
                <div id="pickfiles_main" class="uploadImgContainer" <?php if (intval($chk_file) == intval(1) ){ echo "style='display:none'";}?> >
                	<div class="uploadImgBox">
                    	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                        <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                    </div>
                    <div class="uploadImgBtn"></div>
                </div>
                <div id="upload_container_main"></div>
            </div-->
            
            <div class="fullWidth noGap">
                <div class="width2">
                	<label class="mainLabel">Name <span>* </span></label>
                    <input type="text" class="txtBox" name="editor_name" id="editor_name" value="<?php echo $editor_name; ?>" maxlength="70" autocomplete="OFF" />
                </div> 
            </div>
            <div class="clear"style="padding-top: 10px;" ></div>   
            <div class="fullWidth validateMsg">   
                <label class="mainLabel">Message <span>* </span></label>
                <div class="clear" ></div>
                <textarea class="txtBox" name="editor_text" style="width:90%; height:230px; float:left;"><?php echo $editor_text; ?></textarea>  
                <script>
                CKEDITOR.replace("editor_text",
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
            <div class="clear"style="padding-top: 10px;" ></div>   
            <div class="fullWidth noGap">
                <div class="sbumitLoaderBox" id="INPROCESS">                        
                    <input type='submit' value='Save' class='submitBtn' id='save' name='save'/>
                </div>           
            </div>
        </div><!--containerPad end-->
    </div>            
    </form>  
</div>             
<?php include("footer_the-piano-man.php");?>      
