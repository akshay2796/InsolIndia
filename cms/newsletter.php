<?php 
ob_start();
error_reporting(E_ALL);
include("header.php");

define("PAGE_MAIN","newsletter.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");

define("PAGE_PREVIEW","newsletter_preview.php");

define("PAGE_COMMON","ajax_common.php");

if( !is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER))
{
    $mask=umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH .  FLD_NEWSLETTER, 0777);
    umask($mask);
}


$ID = intval($_REQUEST['id']);
 

if( (intval($ID) > intval(0)) )
{
    $con = "modify";
    
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
        header("Location:".PAGE_MAIN);
    }
    
    $volume_name = htmlentities(stripslashes($rsGET[0]['volume_name'])); 
    $newsletter_issue = htmlentities(stripslashes($rsGET[0]['newsletter_issue'])); 
     
    $newsletter_date = stripslashes($rsGET[0]['newsletter_date']);
    if(trim($newsletter_date) != "" && $newsletter_date != "0000-00-00"){
        $newsletter_date = date('d-m-Y' , strtotime($newsletter_date));    
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
            $display_image_editor = $FOLDER_PATH_EDITOR."/R130-".$editor_image;
        }
        else
        {
            $display_image_editor = "";
        }
    }   
    
    $president_name = stripslashes($rsGET[0]["president_name"]);
    $president_image = stripslashes($rsGET[0]["president_image"]);
    // $president_text = stripslashes($rsGET[0]["president_text"]);
    
    if($president_image !="")
    {  
        $FOLDER_NAME_PRESIDENT = FLD_NEWSLETTER; 
        $FOLDER_PATH_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_PRESIDENT;  
        
        $president_id= intval(0);
        $chk_file_president = chkImageExists($FOLDER_PATH_PRESIDENT."/".$president_image);
        if(intval($chk_file_president) == intval(1))
        {
            $display_image_president = $FOLDER_PATH_PRESIDENT."/R130-".$president_image;
            
        }
        else
        {
            $display_image_president = "";
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
    $con = "add";
    $ID = 0;
    $status = "ACTIVE";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . NEWSLETTER_INTRO_TBL . " WHERE status <> 'DELETE' order by intro_id desc limit 1 ";
    $sGETIntro = $dCON->prepare( $SQL );
    $sGETIntro->execute();
    $rsGETIntro = $sGETIntro->fetchAll();
    $sGETIntro->closeCursor();
    if(count($rsGETIntro) > intval(0))
    {
        $intro_content = htmlentities(stripslashes($rsGETIntro[0]['intro_content']));  
        $disclaimer = (stripslashes($rsGETIntro[0]['disclaimer']));  
    }
    
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    $sql = "";
    $sql .= "SELECT * FROM " . NEWSLETTER_EDITOR_TBL . " where status='ACTIVE' order by editor_id desc limit 1 ";
    $stmtImg = $dCON->prepare($sql);
    $stmtImg->execute();
    $rsGETE = $stmtImg->fetchAll(); 
    
    if(count($rsGETE)> intval(0))
    {
        //$ImageCt = intval(count($rsGET));
        $FOLDER_NAME_EDITOR = FLD_NEWSLETTER_EDITOR; 
        $FOLDER_PATH_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_EDITOR;  
        
        $editor_id = intval($rsGETE[0]['editor_id']);
        $editor_name = stripslashes($rsGETE[0]["editor_name"]);
        $editor_image = trim(stripslashes($rsGETE[0]['editor_image']));
        
        $chk_file_editor = chkImageExists($FOLDER_PATH_EDITOR."/".$editor_image);
        
        if(intval($chk_file_editor) == intval(1))
        {
            $display_image_editor = $FOLDER_PATH_EDITOR."/R130-".$editor_image;
        }
        else
        {
            $display_image_editor = "";
        }
        
        $editor_text = htmlentities(stripslashes($rsGETE[0]['editor_text']));  
    }
    
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $sql = "";
    $sql .= "SELECT * FROM " . NEWSLETTER_PRESIDENT_TBL . " where status='ACTIVE' order by president_id desc limit 1 ";
    $stmtImg = $dCON->prepare($sql);
    $stmtImg->execute();
    $rsGETP = $stmtImg->fetchAll(); 
    
    if(count($rsGETP)> intval(0))
    {  
        $FOLDER_NAME_PRESIDENT = FLD_NEWSLETTER_PRESIDENT; 
        $FOLDER_PATH_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_PRESIDENT;  
        
        $president_id= intval($rsGETP[0]['president_id']);
        $president_image = trim(stripslashes($rsGETP[0]['president_image']));
        $chk_file_president = chkImageExists($FOLDER_PATH_PRESIDENT."/".$president_image);
        
        if(intval($chk_file_president) == intval(1))
        {
            $display_image_president = $FOLDER_PATH_PRESIDENT."/R130-".$president_image;
            
        }
        else
        {
            $display_image_president = "";
        }
        
        $president_name = stripslashes($rsGETP[0]["president_name"]);
        $president_text = htmlentities(stripslashes($rsGETP[0]['president_text']));  
    }
    
    
}

$TEMP_FOLDER_NAME = "";
$TEMP_FOLDER_NAME = TEMP_UPLOAD;


$RESIZE_WIDTH = "130"; //main resize width
$RESIZE_HEIGHT = "130"; //main resize height

$RESIZE_REQUIRED = "YES";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT ; //widthXheight|weightXheight SEPRATED BY PIPE 

$SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/R130-";

?>



<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>maxlength.js"></script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css"> 

<!-- Fancy Select Box -->
<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.js"></script> 
<!-- Fancy Select Box Ends -->

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
        uploader_main.start();
		up.refresh(); // Reposition Flash/Silverlight
	});   
   
    uploader_main.bind('UploadProgress', function(up, file) {
        var progressBarValue = up.total.percent;
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
       
	  	image_list_html = image_list_html + '<div class="removeImageTR uploadImgContainer">';
            	image_list_html = image_list_html + '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>';
				    image_list_html = image_list_html + '<input type="hidden" class="editor_id" name="editor_id" value="0" /><input type="hidden" class="cl_editor_image" id="editor_image" name="editor_image" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="folder_name_editor" name="folder_name_editor" value="<?php echo TEMP_UPLOAD; ?>" />';
                	image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg" /></a></span></div>';       
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					image_list_html = image_list_html + '<td><a href="javascript:void(0);" onclick="$(this).removeImageEditor({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImageEditor"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a></td>';
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
    
    
    $.fn.removeImageEditor = function() {
        var args = arguments[0] || {};
        var imageId = args.imageId || 0; 
        var uFID = args.uFID || "";
        var foldername = args.foldername || "";
        var copy = args.copy || "";
        
        var indx = $(".removeImageEditor").index(this);
        var cl_editor_image = $(".cl_editor_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imageId+"---"+foldername+"---"+cl_editor_image);
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
        //alert(imageId + "--"+cl_editor_image )
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImageEditor&image_name=" + cl_editor_image + "&imageId=" + imageId + "&foldername="+foldername,
            beforeSend: function() {
                $(".removeImageEditor:eq(" + indx + ")").hide();
                $(".removeImageLoader_E:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                $(".removeImageLoader_E").hide();
                
                $("#pickfiles_main").show(); //////////////
                
                
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
		browse_button : 'pickfiles_main_2',
		container : 'upload_container_main_2',
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
        uploader_main.start();
		up.refresh(); // Reposition Flash/Silverlight
	});   
   
    uploader_main.bind('UploadProgress', function(up, file) {
        var progressBarValue = up.total.percent;
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
        
        image_list_html = image_list_html + '<div class="removeImageTR_President uploadImgContainer">';
            	image_list_html = image_list_html + '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>';
				    image_list_html = image_list_html + '<input type="hidden" class="president_id" name="president_id" value="0" /><input type="hidden" class="cl_president_image" id="president_image" name="president_image" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="folder_name_president" name="folder_name_president" value="<?php echo TEMP_UPLOAD; ?>" />';
                	image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg" /></a></span></div>';       
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					image_list_html = image_list_html + '<td><a href="javascript:void(0);" onclick="$(this).removeImagePresident({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImagePresident"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete" border="0" /></a></td>';
					image_list_html = image_list_html + '</tr></table>';
				image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '</div>';
    
		i++;
	 
        $("#image_list_2").prepend(image_list_html);
        
        $("#pickfiles_main_2").hide(); //////////////////////For single image upload
                                                
        if( parseInt($(".removeImageTR_President").size()) > parseInt(0) )
        {
            $("#image_list_2").show();
        }
              
	});
    
    
    $.fn.removeImagePresident = function() {
        var args = arguments[0] || {};
        var imageId = args.imageId || 0; 
        var uFID = args.uFID || "";
        var foldername = args.foldername || "";
        var copy = args.copy || "";
        
        var indx = $(".removeImagePresident").index(this);
        var cl_president_image = $(".cl_president_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imageId+"---"+foldername+"---"+cl_president_image);
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
        //alert(imageId + "--"+cl_editor_image )
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImagePresident&image_name=" + cl_president_image + "&imageId=" + imageId + "&foldername="+foldername,
            beforeSend: function() {
                $(".removeImagePresident:eq(" + indx + ")").hide();
                $(".removeImageLoader_P:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR_President:eq(" + indx + ")").remove();
                $(".removeImageLoader_P").hide();
                
                $("#pickfiles_main_2").show(); //////////////
                
                
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
    
    $('#frm').submit(function(e){
            e.preventDefault();
            
            /*
            var ImgUploading = $('#checkImgUploadingProgress').val();
            if(parseInt(ImgUploading)==parseInt(1))
            {
                alert("Image Upload in progress, please wait!")
                return false;
            }
            */
            
            var econtent = escape(CKEDITOR.instances.editor_text.getData()); 
            var pcontent = escape(CKEDITOR.instances.president_text.getData()); 
            var dcontent = escape(CKEDITOR.instances.disclaimer.getData()); 
            
            
            var value = $("#frm").serialize();
            
            //alert(econtent);
            //alert(pcontent);
            //return false;
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&econtent=" + econtent + "&dcontent=" + dcontent + "&pcontent=" + pcontent + "&" + value,
			   beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){
                   console.log(msg);
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
                            
                            //window.location.href = "<?php echo PAGE_MAIN; ?>";
                            
                            if( parseInt(spl_txt[1]) == parseInt(1) )
                            {
                                if(cond=="modify")
                                {
                                    //window.location.href = "<?php echo PAGE_LIST; ?>";
                                    window.location.href = "<?php echo PAGE_PREVIEW; ?>?nid="+spl_txt[3];
                                }
                                else
                                {
                                    window.location.href = "<?php echo PAGE_PREVIEW; ?>?nid="+spl_txt[3];
                                }
                            }
                               
                        },2000);
                        
                                             
                    },1000); 
                  
					 
                }
            });
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
     
     
     /////////////////Event////////////////////////////////////////////////////////////////////////
    
    $("#upcoming_events_search").live("focus",function() {
         
         //alert($(".event_id_search_ar").val()+"--");
         //console.log($(".event_id_ar").serialize())
             
         $(this).autocomplete({
            source: function(request, response) {
                 $.ajax({
                    url: "<?php echo PAGE_COMMON; ?>?type=suggestEvents",
                    dataType: "json",
                    data: {
                        term : request.term
                        ,event_id_ar : $("#event_id_ar").val()
                    },
                    success: function(data){
                        //console.log(data)
                        //alert(data);
                        response(data);
                    }
                });
            },
            minLength:1,
            delay: 0,
            select: function( event, ui ){
                //alert(ui.item.cab_no_first_value +" "+ui.item.cab_no_second_value)
                if (ui.item.label) 
                {
                    //alert(ui.item.event_id)
                    //return false;
                    if( ui.item.label != "" )
                    {
                       $(this).UpcomingEvents({event_name_search: ui.item.value,event_id_search: ui.item.event_id});
                    } 
                  
                } 
                else 
                {
                    $(".ui-autocomplete").removeClass();
                    return false;
                }
                $(this).val("");
                $(this).focusout();
                return false;
             
             }
        
        }).focus(function(){            
             $(this).data("autocomplete").search("ALLDATA");
        });
      
    }); 
   
    
    $.fn.UpcomingEvents = function() {
        var args = arguments[0] || {};  
        var event_name = args.event_name_search || "";
        var event_id = args.event_id_search || "";
          
        if( $.trim(event_name) != "" )
        {
            $(".addedUpcomingEvents").append('<li class="removeUevent"><input type="hidden" class="event_id_search_ar" name="event_id_search_ar[]" id="event_id_search_ar" value="'+event_id+'" /><input type="hidden" name="event_name_search_ar[]" id="event_name_search_ar" value="'+event_name+'" /><a href="javascript:void(0)" class="remove_event">X</a><span>'+event_name+'</span></li>');
            $("#upcoming_events_search").val('');
            $(".remove_event").focus();
            
            setTimeout(function(){
               //$("#upcoming_events_search").focus();
            },200)
            
        } 
        
        var event_id_ar;
        if(parseInt(event_id) > parseInt(0) )
        {
            if($("#event_id_ar").val()=="")
            {
                event_id_ar = event_id; 
            }
            else
            {
                event_id_ar = $("#event_id_ar").val()+","+event_id; 
            }
            
            $("#event_id_ar").val(event_id_ar); 
        }
        
    };
     
    
    $(".remove_event").live('click',function(){
        var idx =  $(".remove_event").index(this);
        $(".removeUevent:eq("+idx+")").remove();
        
        var event_idar="";
        $(".event_id_search_ar").each(function() {
            
            var event_id = $(this).val();
            if(event_idar !="")
            {
                event_idar = event_idar +","+event_id; 
            }
            else
            {
                event_idar =event_id; 
            }
        });
        
        $("#event_id_ar").val(event_idar); 
        
    }); 
    
    
    ///////////News /////////////////////////////////////////////////////////////////
    
    $("#news_search").live("focus",function() {
         $(this).autocomplete({
            source: function(request, response) {
                 $.ajax({
                    url: "<?php echo PAGE_COMMON; ?>?type=suggestNews",
                    dataType: "json",
                    data: {
                        term : request.term
                        ,news_id_ar : $("#news_id_ar").val()
                    },
                    success: function(data){
                        //console.log(data)
                        //alert(data);
                        response(data);
                    }
                });
            },
            minLength:1,
            delay: 0,
            select: function( event, ui ){
                if (ui.item.label) 
                {
                    //alert(ui.item.news_id)
                    //return false;
                    if( ui.item.label != "" )
                    {
                       $(this).News({news_name_search: ui.item.value,news_id_search: ui.item.news_id});
                    } 
                } 
                else 
                {
                    $(".ui-autocomplete").removeClass();
                    return false;
                }
                $(this).val("");
                $(this).focusout();
                return false;
             
             }
        
        }).focus(function(){            
             $(this).data("autocomplete").search("ALLDATA");
        });
      
    }); 
    
    
    $.fn.News = function() {
        var args = arguments[0] || {};  
        var news_name = args.news_name_search || "";
        var news_id = args.news_id_search || "";
          
        if( $.trim(news_name) != "" )
        {
            $(".addedNews").append('<li class="removeNews"><input type="hidden" class="news_id_search_ar" name="news_id_search_ar[]" id="news_id_search_ar" value="'+news_id+'" /><input type="hidden" name="news_name_search_ar[]" id="news_name_search_ar" value="'+news_name+'" /><a href="javascript:void(0)" class="remove_news">X</a><span>'+news_name+'</span></li>');
            $("#news_search").val('');
            $(".remove_news").focus();
            
            setTimeout(function(){
               //$("#news_search").focus();
            },200)
            
        } 
        
        var news_id_ar;
        if(parseInt(news_id) > parseInt(0) )
        {
            if($("#news_id_ar").val()=="")
            {
                news_id_ar = news_id; 
            }
            else
            {
                news_id_ar = $("#news_id_ar").val()+","+news_id; 
            }
            
            $("#news_id_ar").val(news_id_ar); 
        }
        
    };
     
    
    $(".remove_news").live('click',function(){
        var idx =  $(".remove_news").index(this);
        $(".removeNews:eq("+idx+")").remove();
        
        var news_idar="";
        $(".news_id_search_ar").each(function() {
            
            var news_id = $(this).val();
            if(news_idar !="")
            {
                news_idar = news_idar +","+news_id; 
            }
            else
            {
                news_idar =news_id; 
            }
        });
        
        $("#news_id_ar").val(news_idar); 
        
    }); 
    
    
    ///////////Resources /////////////////////////////////////////////////////////////////
    
    $("#resources_search").live("focus",function() {
         $(this).autocomplete({
            source: function(request, response) {
                 $.ajax({
                    url: "<?php echo PAGE_COMMON; ?>?type=suggestResources",
                    dataType: "json",
                    data: {
                        term : request.term
                        ,resources_id_ar : $("#resources_id_ar").val()
                    },
                    success: function(data){
                        //console.log(data)
                        //alert(data);
                        response(data);
                    }
                });
            },
            minLength:1,
            delay: 0,
            select: function( event, ui ){
                if (ui.item.label) 
                {
                    //alert(ui.item.resources_id)
                    //return false;
                    if( ui.item.label != "" )
                    {
                       $(this).Resources({resources_name_search: ui.item.value,resources_id_search: ui.item.resources_id});
                    } 
                } 
                else 
                {
                    $(".ui-autocomplete").removeClass();
                    return false;
                }
                $(this).val("");
                $(this).focusout();
                return false;
             
             }
        
        }).focus(function(){            
             $(this).data("autocomplete").search("ALLDATA");
        });
      
    }); 
    
    
    $.fn.Resources = function() {
        var args = arguments[0] || {};  
        var resources_name = args.resources_name_search || "";
        var resources_id = args.resources_id_search || "";
          
        if( $.trim(resources_name) != "" )
        {
            $(".addedResources").append('<li class="removeResources"><input type="hidden" class="resources_id_search_ar" name="resources_id_search_ar[]" id="resources_id_search_ar" value="'+resources_id+'" /><input type="hidden" name="resources_name_search_ar[]" id="resources_name_search_ar" value="'+resources_name+'" /><a href="javascript:void(0)" class="remove_resources">X</a><span>'+resources_name+'</span></li>');
            $("#resources_search").val('');
            $(".remove_resources").focus();
            
            setTimeout(function(){
               //$("#resources_search").focus();
            },200)
            
        } 
        
        var resources_id_ar;
        if(parseInt(resources_id) > parseInt(0) )
        {
            if($("#resources_id_ar").val()=="")
            {
                resources_id_ar = resources_id; 
            }
            else
            {
                resources_id_ar = $("#resources_id_ar").val()+","+resources_id; 
            }
            
            $("#resources_id_ar").val(resources_id_ar); 
        }
        
    };
     
    
    $(".remove_resources").live('click',function(){
        var idx =  $(".remove_resources").index(this);
        $(".removeResources:eq("+idx+")").remove();
        
        var resources_idar="";
        $(".resources_id_search_ar").each(function() {
            
            var resources_id = $(this).val();
            if(resources_idar !="")
            {
                resources_idar = resources_idar +","+resources_id; 
            }
            else
            {
                resources_idar =resources_id; 
            }
        });
        
        $("#resources_id_ar").val(resources_idar); 
        
    }); 
    
    
       
});

    
</script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.datepick.js"></script>
<script type="text/javascript">

$(function() {
  
    $('#newsletter_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+1 year')); ?>'
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
<input type="hidden" name="checkImgUploadingProgress" id="checkImgUploadingProgress" value="0" readonly="" style="display: none1;"/> 
     
<h1>
    Newsletter <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1>
<div class="addWrapper">
	<div class="boxHeading"><?php echo ucwords($con); ?></div>
    <div class="clear"></div>
    <div class="containerPad">
        <div class="fullWidth noGap">
            <div class="width4">
            	<label class="mainLabel">Volume <span>* </span></label>
                <input type="text" class="txtBox" name="volume_name" id="volume_name" value="<?php echo $volume_name; ?>" maxlength="50" autocomplete="OFF" />
            </div> 
            <div class="width4">
            	<label class="mainLabel">Issue <span>* </span></label>
                <input type="text" class="txtBox" name="newsletter_issue" id="newsletter_issue" value="<?php echo $newsletter_issue; ?>" maxlength="50" autocomplete="OFF" />
            </div> 
            
            <div class="width4">
            	<label class="mainLabel">Date <span>*</span> </label>
                <input type="text" class="titleTxt txtBox" name="newsletter_date" id="newsletter_date" value="<?php echo $newsletter_date; ?>" maxlength="12" placeholder="Date"  autocomplete="OFF" />&nbsp;&nbsp;
            </div>  
        </div><!--fullWidth end-->
        
        <div class="fullDivider noGap">
            <div class="sml_heading">Intro</div>
        </div>
        
        <div class="fullWidth validateMsg">        	
            <!--label class="mainLabel">Intro <small></small></label-->
            <textarea class="txtBox" name="intro_content" id="intro_content" data-maxsize="2000" data-output="status1" wrap="virtual" style="height:100px;"><?php echo $intro_content; ?></textarea>   
            <br><span id="status1" style="font-size:11px"></span> <span style="font-size:11px">characters </span>    
        </div>
        
        
        <div class="fullDivider noGap">
            <div class="sml_heading">
               Editor Message <span id="imagealert"></span>
            </div>
        </div>
        
         <div class="fullWidth noGap">
            <div class="width2">
            	<label class="mainLabel">Name </label>
                <input type="text" class="txtBox" name="editor_name" id="editor_name" value="<?php echo $editor_name; ?>" maxlength="70" autocomplete="OFF" />
            </div> 
        </div>
        <div class="clear"></div>   
        <div class="fullWidth validateMsg">   
            <label class="mainLabel">Message </label>
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
        
        <!--div class="fullWidth noGap" >
        	<div class="width5" id="image_list">
                <?php
                if($display_image_editor !="")
                {
                ?>
                    <div class="removeImageTR uploadImgContainer" id="listItem_<?php echo $editor_id; ?>">
                        <div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                            <input type="hidden" class="editor_id" name="editor_id" value="<?php echo $editor_id;?>" />                                
                            <input type="hidden" class="cl_editor_image" id="editor_image" name="editor_image" value="<?php echo $editor_image;?>" />
                            <input type="hidden" class="folder_name_editor" name="folder_name_editor" value="<?php echo $FOLDER_NAME_EDITOR; ?>" />
                        	<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $display_image_editor; ?>" class="fixedImg" /></a></span></div>       
                        </div>
                        <div class="uploadImgBtn">
                         	<table>
                                <tr>
                                	<td><a href="javascript:void(0);" onclick="$(this).removeImageEditor({imageId:<?php echo $ID;?>,foldername:'<?php echo $FOLDER_NAME_EDITOR; ?>'});" class="removeImageEditor"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Image" border="0" /></a><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif" class="removeImageLoader_E" style="display:none;" /> </td>
                            	</tr>
                            </table>
                        </div>
                    </div>      
                <?php  
                }      
                ?>
                 <div id="pickfiles_main" class="uploadImgContainer" <?php if ($display_image_editor !=""){ echo "style='display:none'";}?>>
                	<div class="uploadImgBox">
                    	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                        <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                    </div>
                    <div class="uploadImgBtn"></div>
                </div>
                <div id="upload_container_main"></div>
            </div>
            
            <div class="width2">   
                <br />     	
                <textarea class="txtBox" name="editor_text" id="editor_text" style="height:100px;"><?php echo $editor_text; ?></textarea>   
            </div>
        </div-->
        
        
        <!--////////////////////////////////////////////////////////////////-->
         
        <div class="fullDivider noGap">
            <div class="sml_heading">
               President Message <span id="imagealert"></span>
            </div>
        </div>
        
        <div class="fullWidth noGap">
            <div class="width2">
            	<label class="mainLabel">Name </label>
                <input type="text" class="txtBox" name="president_name" id="president_name" value="<?php echo $president_name; ?>" maxlength="70" autocomplete="OFF" />
            </div> 
        </div>
        <div class="clear" ></div>   
        <div class="fullWidth validateMsg">   
            <label class="mainLabel">Message </label>
            <div class="clear" ></div>
            <textarea class="txtBox" name="president_text" style="width:90%; height:230px; float:left;"><?php echo $president_text; ?></textarea>  
            <script>
            CKEDITOR.replace("president_text",
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
        
        
        <!--div class="fullWidth noGap" >
        	<div class="width5" id="image_list_2">
                <?php
                if($display_image_president !="")
                {
                ?>
                    
                    <div class="removeImageTR_President uploadImgContainer" id="listItem_2_<?php echo $president_id; ?>">
                        <div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                            <input type="hidden" class="president_id" name="president_id" value="<?php echo $president_id;?>" />                                
                            <input type="hidden" class="cl_president_image" id="president_image" name="president_image" value="<?php echo $president_image;?>" />
                            <input type="hidden" class="folder_name_president" name="folder_name_president" value="<?php echo $FOLDER_NAME_PRESIDENT; ?>" />
                        	<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><img src="<?php echo $display_image_president; ?>" class="fixedImg" /></a></span></div>       
                        </div>
                        <div class="uploadImgBtn">
                         	<table>
                                <tr>
                                	<td><a href="javascript:void(0);" onclick="$(this).removeImagePresident({imageId:<?php echo $ID;?>,foldername:'<?php echo $FOLDER_NAME_PRESIDENT; ?>'});" class="removeImagePresident"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Image" border="0" /></a><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif" class="removeImageLoader_P" style="display:none;" /> </td>
                            	</tr>
                            </table>
                        </div>
                    </div>  
                    
                <?php  
                   
                }      
                ?>
                <div id="pickfiles_main_2" class="uploadImgContainer" <?php if ($display_image_president !=""){ echo "style='display:none'";}?>>
                	<div class="uploadImgBox">
                    	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                        <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                    </div>
                    <div class="uploadImgBtn"></div>
                </div>
                <div id="upload_container_main_2"></div>
            </div>
            
            <div class="width2">   
                <br />     	
                <textarea class="txtBox" name="president_text" id="president_text" style="height:100px;"><?php echo $president_text; ?></textarea>  
            </div>
        </div-->
        
        
        <!-- ////////////Events//////////////////////////////-->
        
        <div class="fullDivider">
            <div class="sml_heading">Upcoming Events and Activities</div>
        </div>
        
        <div class="fullWidth">
            <div class="width">         	
                <input type="text" value="" class=" txtBox" name="upcoming_events_search" id="upcoming_events_search" placeholder="-Select Events-" style="max-width: 400px;"/>
                
            </div>
            <ul class="addedSearchTxt addedUpcomingEvents" style="color:#1753E7;">
                <?php
                if( (intval($ID) > intval(0)) )
                {
                    $QRY = "";
                    $QRY .= " SELECT E.event_id, E.event_name, E.event_from_date FROM " . EVENT_TBL . " as E inner join " . NEWSLETTER_EVENT_TBL . " as N ";
                    $QRY .= " on E.event_id = N.event_id ";
                    $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ";
                    $QRY .= " ORDER BY E.event_from_date ";
                    //echo $QRY;
                    $sEvent = $dCON->prepare( $QRY );
                    $sEvent->bindParam(":newsletter_id",$ID);
                    $sEvent->execute();
                    $rowEvent = $sEvent->fetchAll();
                    $sEvent->closeCursor();
                    if (intval(count($rowEvent)) > intval(0) )
                    {
                        $event_id_ar= "";
                        foreach($rowEvent as $rsEvent)
                        {
                            $event_id ="";
                            $event_id = intval($rsEvent['event_id']);
                            $event_name ="";
                            $event_name= htmlentities(stripslashes($rsEvent['event_name']));
                            if($event_id_ar=='')
                            {
                                $event_id_ar = $event_id;
                            }
                            else
                            {
                                $event_id_ar = $event_id_ar.",".$event_id;
                            }
                ?>
                           <li class="removeUevent"><input type="hidden" class="event_id_search_ar" name="event_id_search_ar[]" id="event_id_search_ar" value="<?php echo $event_id;?>"/><input type="hidden" name="event_name_search_ar[]" id="event_name_search_ar" value="<?php echo $event_name;?>" /><a href="javascript:void(0)" class="remove_event">X</a><span><?php echo $event_name;?></span></li>
                <?php
                        }
                    } 
                }  
                ?>
                  
            </ul>
            <input type="hidden" id="event_id_ar" name="event_id_ar" value="<?php echo $event_id_ar;?>" />  
        </div>
        
        
        <!-- /////////////////NEWS/////////////////////////-->
        
        
        <div class="fullDivider">
            <div class="sml_heading">Headlines</div>
        </div>
        <div class="fullWidth">
            <div class="width">         	
                <input type="text" value="" class=" txtBox" name="news_search" id="news_search" placeholder="-Select News-" style="max-width: 400px;"/>
                
            </div>
            <ul class="addedSearchTxt addedNews" style="color:#1753E7;">
                <?php
                if( (intval($ID) > intval(0)) )
                {
                    $QRY = "";
                    $QRY .= " SELECT E.news_id, E.news_title, E.news_date FROM " . NEWS_TBL . " as E inner join " . NEWSLETTER_NEWS_TBL . " as N ";
                    $QRY .= " on E.news_id = N.news_id ";
                    $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ";
                    $QRY .= " ORDER BY E.position ASC, E.news_date DESC";
                    //echo $QRY;
                    $sNews = $dCON->prepare( $QRY );
                    $sNews->bindParam(":newsletter_id",$ID);
                    $sNews->execute();
                    $rowNews = $sNews->fetchAll();
                    $sNews->closeCursor();
                    if (intval(count($rowNews)) > intval(0) )
                    {
                        $news_id_ar= "";
                        foreach($rowNews as $rsNews)
                        {
                            $news_id ="";
                            $news_id = intval($rsNews['news_id']);
                            $news_title ="";
                            $news_title= htmlentities(stripslashes($rsNews['news_title']));
                            if($news_id_ar=='')
                            {
                                $news_id_ar = $news_id;
                            }
                            else
                            {
                                $news_id_ar = $news_id_ar.",".$news_id;
                            }
                ?>
                           <li class="removeNews"><input type="hidden" class="news_id_search_ar" name="news_id_search_ar[]" id="news_id_search_ar" value="<?php echo $news_id;?>"/><input type="hidden" name="news_name_search_ar[]" id="news_name_search_ar" value="<?php echo $news_title;?>" /><a href="javascript:void(0)" class="remove_news">X</a><span><?php echo $news_title;?></span></li>
                <?php
                        }
                    } 
                }  
                ?>
            </ul>
            <input type="hidden" id="news_id_ar" name="news_id_ar" value="<?php echo $news_id_ar;?>" />  
         </div>
        
        
        <!-- /////////////////Article/////////////////////////-->
        
        
        <div class="fullDivider">
            <div class="sml_heading">Articles</div>
        </div>
        <div class="fullWidth">
            <div class="width">         	
                <input type="text" value="" class="txtBox" name="resources_search" id="resources_search" placeholder="-Select Articles-" style="max-width: 400px;"/>
                
            </div>
            <ul class="addedSearchTxt addedResources" style="color:#1753E7;">
                
                <?php
                if( (intval($ID) > intval(0)) )
                {
                    $QRY = "";
                    $QRY .= " SELECT R.resources_id, R.resources_name, R.resources_from_date FROM " . RESOURCES_TBL . " as R inner join " . NEWSLETTER_RESOURCES_TBL . " as N ";
                    $QRY .= " on R.resources_id = N.resources_id ";
                    $QRY .= " WHERE R.status='ACTIVE' and N.newsletter_id = :newsletter_id ";
                    $QRY .= " ORDER BY R.resources_from_date desc";
                    //echo $QRY;
                    $sResources = $dCON->prepare( $QRY );
                    $sResources->bindParam(":newsletter_id",$ID);
                    $sResources->execute();
                    $rowResources = $sResources->fetchAll();
                    $sResources->closeCursor();
                    if (intval(count($rowResources)) > intval(0) )
                    {
                        $resources_id_ar= "";
                        foreach($rowResources as $rsResources)
                        {
                            $resources_id ="";
                            $resources_id = intval($rsResources['resources_id']);
                            $resources_name ="";
                            $resources_name= htmlentities(stripslashes($rsResources['resources_name']));
                            if($resources_id_ar=='')
                            {
                                $resources_id_ar = $resources_id;
                            }
                            else
                            {
                                $resources_id_ar = $resources_id_ar.",".$resources_id;
                            }
                ?>
                           <li class="removeResources" ><input type="hidden" class="resources_id_search_ar" name="resources_id_search_ar[]" id="resources_id_search_ar" value="<?php echo $resources_id;?>"/><input type="hidden" name="resources_name_search_ar[]" id="resources_name_search_ar" value="<?php echo $resources_name;?>" /><a href="javascript:void(0)" class="remove_resources">X</a><span><?php echo $resources_name;?></span></li>
                <?php
                        }
                    } 
                }  
                ?>
                
            </ul>
            <input type="hidden" id="resources_id_ar" name="resources_id_ar" value="<?php echo $resources_id_ar;?>" />  
         </div>
        
        
        
        <div class="fullDivider noGap">
            <div class="sml_heading">
               Disclaimer <span id="imagealert"></span>
            </div>
        </div>
        <div class="fullWidth validateMsg">        	
            <textarea name="disclaimer" id="disclaimer" style="width:90%; height:230px; float:left;"><?php echo $disclaimer; ?></textarea>
            <script>
            CKEDITOR.replace("disclaimer",
                {
                    enterMode: 2,
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
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
            </div>           
        </div>
                                  
    </div><!--containerPad end-->
</div>            
</form>  
             
<?php include("footer.php");?>      
