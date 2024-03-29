<?php 
error_reporting(0);
include("header.php");

define("PAGE_MAIN","executive_committee.php");	
define("PAGE_AJAX","ajax_executive_committee.php");
define("PAGE_LIST","executive_committee_list.php");

if( !is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_EXECUTIVE_COMMITTEE))
{
    $mask=umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH .  FLD_EXECUTIVE_COMMITTEE, 0777); 
    umask($mask);      
}


$executive_id = intval($_REQUEST['id']);
if( intval($executive_id) > intval(0) )
{   
    $con = "modify"; 
    $id = intval($executive_id);
    
    $stmt = $dCON->prepare(" SELECT * FROM " . EXECUTIVE_COMMITTEE_TBL . " WHERE executive_id = ? ");
    $stmt->bindParam(1, $executive_id);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
    
    $executive_id = intval($row_stmt[0]['executive_id']);
    $executive_type = htmlentities(stripslashes($row_stmt[0]['executive_type']));
    $executive_name = htmlentities(stripslashes($row_stmt[0]['executive_name'])); 
    $executive_email = htmlentities(stripslashes($row_stmt[0]['executive_email']));
    $executive_post = htmlentities(stripslashes($row_stmt[0]['executive_post']));
    $executive_profession = htmlentities(stripslashes($row_stmt[0]['executive_profession']));
    $executive_profile = stripslashes($row_stmt[0]['executive_profile']); 
    $image_name = trim(stripslashes($row_stmt[0]['image_name']));  
    $image_id = trim(stripslashes($row_stmt[0]['image_id']));   
    
    $FOLDER_NAME = FLD_EXECUTIVE_COMMITTEE; 
    $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME; 
    
    if($executive_type == "MEMBER")
    {
        $showPostDiv = "none;";
    }
    else
    {
        $showPostDiv = "block;";        
    }
    
}
else
{
    $id = "";
    $con = "add";
    $status = "ACTIVE";
    $executive_name = "";
    $executive_profession = "";    
    $executive_profile = "";   
    
}

$RESIZE_WIDTH = "200"; //main resize width
$RESIZE_HEIGHT = "200"; //main resize height

$RESIZE_REQUIRED = "NO";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT ; //widthXheight|weightXheight SEPRATED BY PIPE 

$SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css">

<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>
<script language="javascript" type="text/javascript">
//CODE FOR FILE UPLOAD STARTS....................
 
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
		max_file_size : '5mb',
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
		////e.preventDefault();
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
				    image_list_html = image_list_html + '<input type="hidden" class="image_id" name="image_id" value="0" /><input type="hidden" class="cl_r_image" id="image" name="image" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="folder_name" name="folder_name" value="<?php echo TEMP_UPLOAD; ?>" />';
                	image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg imgno'+fixedImg_CT+'" /></a></span></div>';       
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					//image_list_html = image_list_html + '<td><input type="radio" name="default_image" id="default_image" title="Set Default" value="' + file.name + '" '+ image_default +'/></td>';
                    //image_list_html = image_list_html + '<td><input type="hidden" name="selected_coordinates" id="selected_coordinates" class="sel_coordinates'+fixedImg_CT+'" value=""><a href="javascript:void(0);" class="crop_img" foldername=<?php echo TEMP_UPLOAD; ?> value="' + file.name + '" imgno='+fixedImg_CT+'  addedimgID="0"></a> </td>';
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
        var copy = args.copy || "";
        
        var indx = $(".removeImage").index(this);
        var cl_r_image = $(".cl_r_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imageId+"---"+foldername+"---"+copy);
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
            data: "type=removeImage&image_name=" + cl_r_image + "&imageId=" + imageId + "&foldername="+foldername+ "&copy="+copy,
            beforeSend: function() {
                $(".removeImage:eq(" + indx + ")").hide();
                $(".removeImageLoader:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                $(".removeImageLoader").hide();
                
                $("#pickfiles_main").show(); //////////////
                
                
                if(uFID != "")
                {
                    $("#" + uFID).remove();
                }
                
            }
        });  
          
    };
    
  
  
});



</script>


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
    
   /* $.validator.addMethod('chkExecutiveType', function (data){   
        if($.trim($("#executive_type").val()) == "PATRON" && $.trim($("#executive_post").val()) == "") {
            return 0;
        } else {
            return 1;
        }  
    }, ''); */
    
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            executive_type: "required",
            executive_name: "required"
            //executive_post: "required"
        },
        messages: {
            executive_type: "",
            executive_name: ""
            //executive_post: ""      
        },
        submitHandler: function() {
            
            var ImgUploading = $('#checkImgUploadingProgress').val();
            if(parseInt(ImgUploading)==parseInt(1))
            {
                alert("Image Upload in progress, please wait!")
                return false;
            }
            
            var dcontent = escape(CKEDITOR.instances.executive_profile.getData()); 
            
            var value = $("#frm").serialize();
            
            //alert(dcontent)
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&dcontent=" + dcontent + "&" +  value,
			   beforeSend: function() { 
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){                   
                   //alert(msg);
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
     
    /* $("#executive_type").live('change',function(){
        var VAL = $("#executive_type").val();
        
        if(VAL == "PATRON")
        {
            $("#postDiv").show();
        }
        else
        {
            $("#postDiv").hide();            
        }
        
     }); */
    
 
    
   
});

</script>
     
<h1>Executive Committee <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go To List</a></div></h1>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" />
<input type="hidden" name="checkImgUploadingProgress" id="checkImgUploadingProgress" value="0" readonly="" style="display: none;"/> 

<div class="addWrapper master">
    <div class="boxHeading expendBtn1"> <span id="MOD"><?php echo ucwords($con);?></span></div>
    <div class="clear"></div>
    <div class="containerPad expendableBox1">
        <div class="fullWidth">                    	
            <div class="width4">
                <label class="mainLabel">Type <span>*</span></label>
                <select name="executive_type" id="executive_type" class="selectBox">                    
                    <option value="PATRON" <?php if( $executive_type == "PATRON" ) { echo " selected "; } ?> >Patron</option>
                    <option value="MEMBER" <?php if( $executive_type == "MEMBER" ) { echo " selected "; } ?> >Member</option>
                </select>
                
            </div>
        </div>
        <div class="fullWidth"> 
            
            <div class="width4">
                <label class="mainLabel">Name <span>*</span></label>
                <input type="text" class="txtBox" value="<?php echo $executive_name;?>" name="executive_name" id="executive_name" AUTOCOMPLETE = "OFF" maxlength="150"/>
            </div>
            <div class="width4" id="postDiv" >
           <!-- <div class="width4" id="postDiv" style="display: <?php echo $showPostDiv; ?>;"  > -->
                <label class="mainLabel">Post </label>
                <input type="text" class="txtBox" value="<?php echo $executive_post;?>" name="executive_post" id="executive_post" AUTOCOMPLETE = "OFF" maxlength="200"/>
            </div>
            <div class="width2">
                <label class="mainLabel">Profession <span></span><span></span></label>
                <input type="text" class="txtBox" value="<?php echo $executive_profession;?>" name="executive_profession" id="executive_profession" AUTOCOMPLETE = "OFF" maxlength="300"/>
            </div>            
        </div>
        <div class="fullWidth">
            <div class="width4">
                <label class="mainLabel">Email </label>
                <input type="text" class="txtBox" value="<?php echo $executive_email;?>" name="executive_email" id="executive_email" AUTOCOMPLETE = "OFF" maxlength="150"/>
            </div>
        </div>
        <div class="fullDivider noGap">
            <div class="sml_heading">Profile <span></span> </div>
        </div>
       
        <div class="fullWidth div_content validateMsg">
            <textarea name="executive_profile" id="executive_profile" style="width:90%; height:230px; float:left;"><?php echo $executive_profile; ?></textarea>
            <script>
            CKEDITOR.replace("executive_profile",
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
        </div><!--fullWidth end-->
        <div class="clear">&nbsp;</div>
        <div class="fullDivider noGap">
            <div class="sml_heading" id="uploadImgPos">
                Upload Image (Size Limit 5MB)
                <span id="imagealert"></span>
            </div>
        </div>
        <div class="clear" style="height: 5px;"></div> 
        <div class="fullWidth noGap" id="image_list">
        	<?php
            if ($image_name != "" )
            {         
                
                    $display_image ="";                                
                    
                    $R200_image = "R200-".$image_name;
                     
                    $chk_file = chkImageExists($FOLDER_PATH."/".$R200_image);
                    
                    if(intval($chk_file) == intval(1))
                    {
                        $display_image = $FOLDER_PATH."/".$R200_image;
                    }
                    else
                    {
                        $display_image ="";
                    }
                    
                    if($display_image !="")
                    {
            ?>
                        <div class="removeImageTR uploadImgContainer" id="listItem_<?php echo $image_id; ?>">
                            <div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                                <input type="hidden" class="image_id" name="image_id" value="<?php echo $image_id;?>" />                                
                                <input type="hidden" class="cl_r_image" id="image" name="image" value="<?php echo $image_name;?>" />
                            	<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $display_image; ?>" class="fixedImg imgno<?php echo $image_id;?>" /></a></span></div>       
                            </div>
                            <div class="uploadImgBtn">
                            <!--img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position" style="display: block;"/-->
                            	<table>
                                    <tr>
                                    	<td><a href="javascript:void(0);" onclick="$(this).removeImage({imageId:<?php echo $executive_id;?>,foldername:'<?php echo $FOLDER_NAME; ?>'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif" class="removeImageLoader" style="display:none;" /> </td>
                                	</tr>
                                </table>
                            </div>
                        </div>      
            <?php  
                       
                    }      
                
            }
            ?>
            <!--div for image upload button start-->
            <div id="pickfiles_main" class="uploadImgContainer" <?php if ($image_name != "" && $display_image !=""){ echo "style='display:none'";}?>>
            	<div class="uploadImgBox">
                	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                    <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                </div>
                <div class="uploadImgBtn"></div>
            </div>
            <!--div for image upload button end-->
                      
            <div id="upload_container_main"></div>
         
        </div>
        
        
        
        <div class="fullWidth noGap">           
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' />
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
        	</div>               
        </div><!--fullWidth end--> 
    </div><!--containerPad end-->
</div><!--addWrapper end-->
</form>


<!--div class="listWrapper" id="txtHint">
	
</div--><!--addWrapper end-->     

        

        
<?php include("footer_chitrashala.php");?>   
