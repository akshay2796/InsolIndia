<?php 
ob_start();
//error_reporting(E_ALL);
include("header.php");

define("PAGE_MAIN","projects.php");	
define("PAGE_AJAX","ajax_projects.php");
define("PAGE_LIST","projects_list.php");

define("SET1_ENABLE",true);
if ( SET1_ENABLE == true ){
    
    define("SET1_TYPE","IMAGE");
    if ( SET1_TYPE == "FILE" ){ 
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);    
        define("SET1_IMAGE_CAPTION",false);     
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['EVENT_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['EVENT_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","");    
        
    }else if ( SET1_TYPE == "IMAGE" ){
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);   
        define("SET1_IMAGE_CAPTION",true);  
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['EVENT_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['EVENT_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","Min. size required 245px x 160px");
    
    }    
    
    define("SET1_FOR","PROJECTS-LOGO");
    define("SET1_MANDATORY",false);
    
    define("SET1_FOLDER",FLD_PROJECTS . "/" . FLD_PROJECTS_LOGO_IMG);
    define("SET1_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);
    
    define("SET1_DBTABLE",PROJECTS_LOGO_IMG_TBL);
    
    //TO HIDE RADIO BUTTTON FOR DEfault Checking 
    $SET1_RADIO_DISPLAY = " style=display:none; ";
    
    
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


/// VIDEO SETTINGS

define("VIDEO_UPLOAD_FILE_SIZE","250MB");
define("VIDEO_UPLOAD_ALLOWED_FORMATS","mp4");

define("VIDEO_FOLDER",FLD_PROJECTS . "/" . FLD_PROJECTS_VDO);
define("VIDEO_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . VIDEO_FOLDER);
define("VIDEO_DBTABLE",VIDEO_TBL);
 


define("FTYPE_UPLOAD_FILE_SIZE","25MB");
define("FTYPE_UPLOAD_ALLOWED_FORMATS","doc,docx,pdf,xls,xlsx,ppt,pptx,txt");
define("FTYPE_UPLOAD_ALLOWED_FORMATS_IMG",'<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'doc.png" border="0" alt="doc | docx"  title="doc | docx" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'txt.png" border="0" alt="txt"  title="txt" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'ppt.png" border="0" alt="ppt" title="ppt" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'pdf.png" border="0" alt="pdf" title="pdf" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'xls.png" border="0" alt="xls | xlsx" title="xls | xlsx">');
    

define("FTYPE_FOLDER",FLD_PROJECTS . "/" . FLD_PROJECTS_FILE);
define("FTYPE_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . FTYPE_FOLDER); 


$ID = $_REQUEST['ID'];
 

if( (intval($ID) > intval(0)) )
{
    $con = "modify";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . PROJECTS_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND projects_id = :projects_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":projects_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    
    if(count($rsGET)==intval(0))
    {
        header("Location:".PAGE_MAIN);
    }    
     
    $projects_title = stripslashes($rsGET[0]['projects_title']); 
   
   
    $projects_from_date = stripslashes($rsGET[0]['projects_from_date']);
    
    if(trim($projects_from_date) != "" && $projects_from_date != "0000-00-00"){
        $projects_from_date = date('d-m-Y' , strtotime($projects_from_date));    
    }else{
        $projects_from_date = "";
    }
    
     $projects_to_date = stripslashes($rsGET[0]['projects_to_date']);
    
    if(stripslashes($rsGET[0]['projects_to_date']) != stripslashes($rsGET[0]['projects_from_date']) && $projects_to_date != "0000-00-00"){
        $projects_to_date = date('d-m-Y' , strtotime($projects_to_date));    
    }else{
        $projects_to_date = "";
    }
    
    $url = stripslashes($rsGET[0]['url']); 
    
    
   
    
    
    $projects_description = stripslashes($rsGET[0]['projects_description']);  
    
    $file_name = stripslashes($rsGET[0]['file_name']);
    $FTYPE_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/";    
    $chKFTYPE = chkImageExists($FTYPE_PATH .$file_name);    
    $old_ftype_file = stripslashes($rsGET[0]['file_name']);
    
 
    $VTYPE_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_VDO . "/";    
    $chKVTYPE = chkImageExists($VTYPE_PATH .$old_video_file);
   
    $status = htmlentities(stripslashes($rsGET[0]['status']));                        
    
    $editor_image = trim(stripslashes($rsGET[0]['homepage_image']));  
    $image_id = trim(stripslashes($rsGET[0]['homepage_image_id']));
    if($editor_image!= "")
    {
        //$ImageCt = intval(count($rsGET));
        $FOLDER_NAME_EDITOR = FLD_PROJECTS."/".FLD_HOMEPAGE_IMAGE; 
        $FOLDER_PATH_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_EDITOR;  
        $editor_id = 0;
        
        $chk_file_editor = chkImageExists($FOLDER_PATH_EDITOR."/".$editor_image);
        
        if(intval($chk_file_editor) == intval(1))
        {
            $display_image_editor = $FOLDER_PATH_EDITOR."/R200-".$editor_image;
        }
        else
        {
            $display_image_editor = "";
        }
    }   
    
    $set1_uploadMORE = 0;
    if ( SET1_ENABLE == true ){
        
        
        $QRY = "";
        $QRY .= "SELECT * FROM " . PROJECTS_LOGO_IMAGES_TBL . " WHERE master_id = :master_id order by default_image desc, position,image_id ";
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
    
    $show_in_current = 0;
    
    $videoTYPE = "VIDEO_EMBED";    
    $set1_uploadMORE = 1;  
    
    $METATITLE = "";
    $METAKEYWORD = "";
    $METADESCRIPTION = "";
    
}

$QRYSTR = "";
$QRYSTR .= "con=".SET1_DBTABLE;
$QRYSTR .= "&cname1=image_name&cname2=image_id";
// for home page image
$FOLDER_NAME = FLD_PROJECTS."/".FLD_HOMEPAGE_IMAGE; 
$FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME;

$RESIZE_WIDTH = "200"; //main resize width
$RESIZE_HEIGHT = "200"; //main resize height

$RESIZE_REQUIRED = "NO";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT ; //widthXheight|weightXheight SEPRATED BY PIPE 

$SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

?>



<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>maxlength.js"></script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css"> 

<!-- Fancy Select Box -->
<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.js"></script> 


<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>
<script language="javascript" type="text/javascript">
//CODE FOR homepage....................
 
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
       
	  	image_list_html = image_list_html + '<div class="removeImageTR1 uploadImgContainer">';
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
                                                
        if( parseInt($(".removeImageTR1").size()) > parseInt(0) )
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
                $(".removeImageTR1:eq(" + indx + ")").remove();
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


</script>

<script language="javascript" type="text/javascript">
//CODE FOR FTYPE UPLOAD STARTS....................
 
$(function() {
    var uploader = new plupload.Uploader({
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
    	browse_button : 'ftypepickfiles',
    	container : 'ftype_upload_container',
    	max_file_size : '<?php echo FTYPE_UPLOAD_FILE_SIZE;?>',
      	url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . FTYPE_FOLDER; ?>',
        unique_names : false,
        multi_selection: false,
    	flash_swf_url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.swf', 
    	filters : [
    		{title : "Image files", extensions : "<?php echo FTYPE_UPLOAD_ALLOWED_FORMATS; ?>"}
    	]
    });

	uploader.init();

	uploader.bind('FilesAdded', function(up, files) {
		
        $('#FTYPE_UPLOAD_IN_PROCESS').val(1);
        
        $.each(files, function(i, file) { 
			$('#ftypefilelist').html('<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' + ' <span id="ftypeWaiting"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>loader.gif" /></span></div>');
		});
        
        //CODE FOR AUTO UPLOAD.....
        uploader.start();
		////e.preventDefault();
            
		up.refresh(); // Reposition Flash/Silverlight
	});   

	uploader.bind('UploadProgress', function(up, file) {
	    $("#ftype_file_required_error").html("");
		//$('#' + file.id + " b").html(file.percent + "%");
	});

	uploader.bind('Error', function(up, err) {
		$('#ftypefilelist').html("<div style='color:red'>Error: " + err.code +
			",  Message: " + err.message +
			(err.file ? "<br> File: " + err.file.name : "") +
			"</div>"
		);

		up.refresh(); // Reposition Flash/Silverlight
	});
    
    uploader.bind('UploadComplete', function() {
        //alert("complete")
        $('#ftypeWaiting').html('<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>done.gif" />');
        $('#FTYPE_UPLOAD_IN_PROCESS').val(0);
    });
    
    
    
    var images_file_name = "";
	uploader.bind('FileUploaded', function(up, file) {
        //alert("File Uploaded 333 ");
        images_file_name = file.name;      
        $("#ftype_file_path").val(images_file_name); 
        $("#ftype_file_validation").val(file.name); 
              
	});
});
</script>

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
        //alert( imgID + "======" + indx);
        //return false;
        if( parseInt(imgID) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c)
            {
                return false;
            }else{
                
                }
        }else{
            
        }
                //alert(imgID + "--"+cl_r_image+"===="+indx );
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
                        
                    //alert(msg);
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
            data: "type=setDefaultImage&image_id="+image_id+"&foldername="+foldername+"&projects_id=<?php echo $ID; ?>",
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



<?php
$position_qry_string = "";
$position_qry_string .= "con=".PRODUCT_IMAGES_TBL;
$position_qry_string .= "&cname1=image_name&cname2=image_id";
?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $.validator.addMethod('chkFile', function (data){ 
        
        if($("#document_upload").is(":checked") == true){
            
            var set1_imgcount = $(".set1_icount").length;
            //alert(set1_imgcount);
            if(parseInt(set1_imgcount)==parseInt(0))
            {
                $("#set1_pickup").css('border', "solid 1px red");  
                return false;
            }else{
                $("#set1_pickup").css('border', "solid 0px red");
                return true;                        
            }
        }else{
            $("#set1_pickup").css('border', "solid 0px red");
            return true; 

        }
            
    }, '');  
     
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {             
            projects_title: "required"
          //  projects_from_date: "required"
            
        },
        messages: {            
            projects_title: ""
          //  projects_from_date: ""
           
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
            
            
            var dcontent = escape(CKEDITOR.instances.projects_description.getData()); 
            var value = $("#frm").serialize();
            //alert(value);
            //return false;
            
            //setTimeout(function(){
                
                $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=saveData&dcontent=" + dcontent + "&" + value,
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
                                
                                //window.location.href = "<?php echo PAGE_MAIN; ?>";
                                
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
            
            //},2000);
                            
        }
    });    
   
    
    

    $("#deleteFType").live("click", function(){    
        
        var ID = $(this).attr("did"); 
        //alert(ID);
        
        if( parseInt(ID) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c){
                return false;
            }
        }
       
        
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeFypeFILE&ID=" + ID,
            beforeSend: function() {
                //$(".deleteFType").hide(); 
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                
                $("#old_ftype_file").val("");
	            $("#ftype_file_validation").val("");
	            $("#showFTYPE").hide();
	            
            }
        }); 
        
        
    });
    
    $("#deleteVType").live("click", function(){    
        
        var ID = $(this).attr("did"); 
        //alert(ID);
        
        if( parseInt(ID) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c){
                return false;
            }
        }       
         
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeVTypeFILE&ID=" + ID,
            beforeSend: function() {
                //$(".deleteFType").hide(); 
            },
            success: function(msg) {
                //alert(msg);                
                
                $("#old_video_file").val("");
	            $("#video_file_validation").val("");
	            $("#showVTYPE").hide();
	            
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
    
       
});

</script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.datepick.js"></script>
<script type="text/javascript">

$(function() {
  
    $('#projects_from_date').datepick({
        dateFormat: 'dd-mm-yyyy',
    	yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+1 year')); ?>'
    });  
    
    $('#projects_to_date').datepick({
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

<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>timepicker/jquery-ui-1.10.0.custom.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>timepicker/jquery.ui.timepicker.css?v=0.3.3" type="text/css" />

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>timepicker/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>timepicker/jquery.ui.timepicker.js?v=0.3.3"></script>


<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">

    <input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
    <input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;"/>
     
    
    <?php if ( SET1_ENABLE == true ){ ?>  
        <input type="hidden" name="SET1_UPLOAD_IN_PROCESS" id="SET1_UPLOAD_IN_PROCESS" value="0" readonly style="display: none;"/>
        <input type="hidden" name="SET1_BOX_COUNT" id="SET1_BOX_COUNT" value="0" readonly style="display: none;"/>
    <?php } ?>
    
    <input type="hidden" name="UPLOAD_IN_PROCESS" id="UPLOAD_IN_PROCESS" value="0" readonly style="display: none;"/>
    <input type="hidden" name="old_video_file" id="old_video_file" value="<?php echo $old_video_file;?>" /> 
    <input type="hidden" name="old_ftype_file" id="old_ftype_file" value="<?php echo $old_ftype_file;?>" /> 
    
     
<h1>
    Projects <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1>
<div class="addWrapper">
	<div class="boxHeading"><?php echo ucwords($con); ?></div>
    <div class="clear"></div>
    <div class="containerPad">   
        
        <div class="fullWidth">
            <div class="fullWidth">
            	<label class="mainLabel">Title<span>*</span></label>
                <input type="text" class="txtBox" name="projects_title" id="projects_title" value="<?php echo $projects_title; ?>" maxlength="500" autocomplete="OFF" />
                
            </div>              
        </div>


        <div class="extraSpace">&nbsp;</div>
        <!--<div class="fullWidth noGap">
            <div class="width4">
            	<label class="mainLabel">Date <span>*</span> <small>[ From - To ]</small><span></span></label>
                <div class="txt3Box">
                    <input type="text" class="titleTxt txtBox" name="projects_from_date" id="projects_from_date" value="<?php echo $projects_from_date; ?>" maxlength="12" placeholder="From" style="width: 90px;" autocomplete="OFF" />&nbsp;&nbsp;
                    <input type="text" class="titleTxt txtBox" name="projects_to_date" id="projects_to_date" value="<?php echo $projects_to_date; ?>" maxlength="12" placeholder="To" style="width: 90px;" autocomplete="OFF" />
                </div>  
            </div>  
            
           
             
        </div>--><!--fullWidth end-->
        
        
        <div class="fullDivider">
        	<div class="sml_heading">Description <span></span> </div>
        </div>
        
        
        <div class="fullWidth">
            <textarea name="projects_description" id="projects_description" style="width:90%; height:230px; float:left;"><?php echo $projects_description; ?></textarea>
            <script>
            CKEDITOR.replace("projects_description",
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
             
            </script>
                       	
        </div><!--fullWidth end-->   
        <!--------============================Homepage image ===================================----------------->  
        <div class="clear">&nbsp;</div>
        <div class="fullDivider noGap">
            <div class="sml_heading" id="uploadImgPos">
                Upload Homepage Image (Size Limit 5MB)
                <span id="imagealert"></span>
            </div>
        </div>
        <div class="clear" style="height: 5px;"></div> 
       <div class="fullWidth noGap" >
        	<div class="width5" id="image_list">
                <?php
                if($display_image_editor !="")
                {
                ?>
                    <div class="removeImageTR1 uploadImgContainer" id="listItem_<?php echo $editor_id; ?>">
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
                <!--div for image upload button start-->
                <div id="pickfiles_main" class="uploadImgContainer" <?php if ($display_image_editor !=""){ echo "style='display:none'";}?>>
                	<div class="uploadImgBox">
                    	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                        <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                    </div>
                    <div class="uploadImgBtn"></div>
                </div>
                <div id="upload_container_main"></div>
            </div>
            
           
        </div>
        <!--------============================Homepage image End===================================-----------------> 
        
        <div class="fullWidth noGap" id="image_list">
        	<?php if ( SET1_ENABLE == true ){ ?>
                <div class="fullWidth">
                    <div class="sml_heading" id="uploadImgPos">
                        <?php 
                        echo "Sponsor " .  ucwords(strtolower(SET1_TYPE));
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
       
        <div class="fullWidth div_file validateMsg" >
            
            <div class="fullWidth">
                <div class="sml_heading" id="uploadImgPos">Upload <?php echo (FTYPE_UPLOAD_ALLOWED_FORMATS_IMG);?> File 
                    <span id="imagealert"><?php echo "(Size Limit " . FTYPE_UPLOAD_FILE_SIZE . ") ";?></span>
                </div>
            </div>
            <div class="fullWidth noGap" >
                <div class="width2">
                    <div id="ftype_upload_container" >
                        <input type="hidden" name="ftype_file_path" id="ftype_file_path" value="" /> 
                        <div id="ftypefilelist" style="width: 354px; min-height: 30px;height: auto; border: 1px solid #b6b6b6; padding: 5px;float:left;" >
                            <span id="ftype_file_required_error"></span><input type="hidden" name="ftype_file_validation" id="ftype_file_validation" class="txtBox" value="<?php echo $old_ftype_file; ?>"/>
                        </div>
                        <input id="ftypepickfiles" value="Browse" type="button" class="browse_btn" />
                    </div>
                </div>
                
                <?php            
                if ( trim($con) == "modify" && intval($chKFTYPE) == intval(1) ){
                    
                    $myEXT = getExtensionForDisplayingIcons(strtolower($file_name)); 
                    
                    
                                           
                ?>
                    <div class="width2" id="showFTYPE">
                        <a href="<?php echo $FTYPE_PATH . "/" . $file_name; ?>" target="_blank">
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH.$myEXT; ?>" border="0" alt="<?php echo $file_name; ?>"  title="<?php echo $file_name; ?>" >
                        <?php //echo $file_name; ?> </a>
                        <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" did="<?php echo $ID; ?>" title="Delete File" id="deleteFType" style="cursor: pointer;" border="0" />
                    </div>
                    
                    
                <?php        
                }
                ?>
                
            </div>     
            
            
        </div>
      
        <div class="fullWidth noGap" id="divVFILE" <?php if($videoTYPE == "VIDEO_EMBED") { echo " style='display:none;' "; } ?>>    
            <div class="fullWidth">
               
            </div>
            <div class="fullWidth noGap" >
                
                <?php            
                if ( trim($con) == "modify" && intval($chKVTYPE) == intval(1) ){
                    
                    $myEXTV = getExtensionForDisplayingIcons($old_video_file);              
                    
                                           
                ?>
                    <div class="width3" id="showVTYPE" style="margin-left: 50px;">
                        <a href="<?php echo $VTYPE_PATH . "/" . $old_video_file; ?>" target="_blank">
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH.$myEXTV; ?>" border="0" alt="<?php echo $old_video_file; ?>"  title="<?php echo $old_video_file; ?>" >
                        <?php //echo $old_video_file; ?> </a>
                        <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" did="<?php echo $ID; ?>" title="Delete File" id="deleteVType" style="cursor: pointer;" border="0" />
                    </div>
                    
                    
                <?php        
                }
                ?>
            </div>       
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
