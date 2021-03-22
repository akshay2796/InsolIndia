<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","media.php");	
define("PAGE_AJAX","ajax_media.php");
define("PAGE_LIST","media_list.php");
define("PAGE_COMMON","ajax_common.php");

define("SET1_ENABLE",true);
if ( SET1_ENABLE == true ){
    
    define("SET1_TYPE","IMAGE");
    if ( SET1_TYPE == "FILE" ){ 
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);   
        define("SET1_IMAGE_CAPTION",false);      
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['MEDIA_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['MEDIA_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","");    
        
    }else if ( SET1_TYPE == "IMAGE" ){
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);  
        define("SET1_IMAGE_CAPTION",true);  
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['MEDIA_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['MEDIA_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","Min. size required 245px x 160px");
    
    }    
    
    define("SET1_FOR","MEDIA-GALLERY");
    define("SET1_MANDATORY",false);
    
    define("SET1_FOLDER",FLD_MEDIA . "/" . FLD_MEDIA_IMG);
    define("SET1_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);
    
    define("SET1_DBTABLE",MEDIA_IMAGES_TBL);
    
     
    
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

define("VIDEO_FOLDER",FLD_MEDIA . "/" . FLD_MEDIA_VDO);
define("VIDEO_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . VIDEO_FOLDER);
///define("VIDEO_DBTABLE",VIDEO_TBL);
 

/// TYPE FILE SETTINGS

define("FTYPE_UPLOAD_FILE_SIZE","25MB");
define("FTYPE_UPLOAD_ALLOWED_FORMATS","jpeg,jpg,gif,png,doc,docx,pdf,xls,xlsx,ppt,pptx,txt");
define("FTYPE_UPLOAD_ALLOWED_FORMATS_IMG",'<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'doc.png" border="0" alt="doc | docx"  title="doc | docx" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'txt.png" border="0" alt="txt"  title="txt" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'ppt.png" border="0" alt="ppt" title="ppt" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'pdf.png" border="0" alt="pdf" title="pdf" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'jpg.png" border="0" alt="jpg | jpeg | gif | png" title="jpg | jpeg | gif | png" >&nbsp;<img src="'.CMS_INCLUDES_ICON_RELATIVE_PATH.'xls.png" border="0" alt="xls | xlsx" title="xls | xlsx">');
    

define("FTYPE_FOLDER",FLD_MEDIA . "/" . FLD_MEDIA_FILE);
define("FTYPE_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . FTYPE_FOLDER); 


$ID = intval(base64_decode($_REQUEST['ID']));
 

if( (intval($ID) > intval(0)) )
{
    $con = "modify";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . MEDIA_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND media_id = :media_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":media_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    
    if(count($rsGET)==intval(0))
    {
        header("Location:".PAGE_MAIN);
    }
    
    $category_id = intval(stripslashes($rsGET[0]['category_id']));  
    $media_name = htmlentities(stripslashes($rsGET[0]['media_name']));  
    $media_publisher = htmlentities(stripslashes($rsGET[0]['media_publisher']));  
    
    $media_from_date = stripslashes($rsGET[0]['media_from_date']);
    
    if(trim($media_from_date) != "" && $media_from_date != "0000-00-00"){
        $media_from_date = date('d-m-Y' , strtotime($media_from_date));    
    }else{
        $media_from_date = "";
    }
    
    $media_type = stripslashes($rsGET[0]['media_type']);
    $media_url = stripslashes($rsGET[0]['media_url']);
    $file_name = stripslashes($rsGET[0]['file_name']);
    $FTYPE_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_MEDIA . "/" . FLD_MEDIA_FILE . "/";    
    $chKFTYPE = chkImageExists($FTYPE_PATH .$file_name); 
 
    
    
    
    $media_short_description = htmlentities(stripslashes($rsGET[0]['media_short_description']));  
    $media_description = stripslashes($rsGET[0]['media_description']);  
   
   
    $videoTITLE = stripslashes($rsGET[0]['video_title']);
    
    $videoTYPE = stripslashes($rsGET[0]['video_type']);
    $videoTYPE = trim($videoTYPE) == '' ? "VIDEO_EMBED" : trim($videoTYPE);
    $videoEMBEDCODE = stripslashes($rsGET[0]['embed_code']);
    $old_video_file = stripslashes($rsGET[0]['video_file']);
    $old_ftype_file = stripslashes($rsGET[0]['file_name']);
    
    $VTYPE_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_MEDIA . "/" . FLD_MEDIA_VDO . "/";    
    $chKVTYPE = chkImageExists($VTYPE_PATH .$old_video_file);    
   
    $status = htmlentities(stripslashes($rsGET[0]['status']));                        
    
    //echo "$old_video_file"; 
    $set1_uploadMORE = 0;
    if ( SET1_ENABLE == true ){
        
        
        $QRY = "";
        $QRY .= "SELECT * FROM " . MEDIA_IMAGES_TBL . " WHERE master_id = :master_id order by default_image desc, position,image_id ";
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
    
    $media_type = 'CONTENT';
    
    $videoTYPE = "VIDEO_EMBED";
    $category_id = intval(base64_decode($_REQUEST['CID']));
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

<!-- Fancy Select Box -->
<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.css" rel="stylesheet"
    type="text/css" />
<script type="text/javascript" src="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.js"></script>
<!-- Fancy Select Box Ends -->




<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>

<?php 
if ( SET1_ENABLE == true ){  
    include("include_SET1_uploader.php");
}  
?>


<script language="javascript" type="text/javascript">
//CODE FOR VIDEO UPLOAD STARTS....................

$(function() {
    var uploader = new plupload.Uploader({
        //runtimes : 'gears,flash,html5,silverlight,browserplus',
        <?php 
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
        {
        ?>
        runtimes: 'flash,html5',
        <?php 
        } 
        else
        { 
        ?>
        runtimes: 'html5,flash',
        <?php 
        } 
        ?>
        browse_button: 'videopickfiles',
        container: 'video_upload_container',
        max_file_size: '<?php echo VIDEO_UPLOAD_FILE_SIZE;?>',
        url: '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . VIDEO_FOLDER; ?>',
        unique_names: false,
        multi_selection: false,
        flash_swf_url: '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.swf',
        filters: [{
            title: "Image files",
            extensions: "<?php echo VIDEO_UPLOAD_ALLOWED_FORMATS; ?>"
        }]
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {

        $('#UPLOAD_IN_PROCESS').val(1);

        /*
        $.each(files, function(i, file) { 
			$('#videofilelist').html(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
		});
        */

        $.each(files, function(i, file) {
            $('#videofilelist').html('<div id="' + file.id + '">' + file.name + ' (' + plupload
                .formatSize(file.size) + ') <b></b>' +
                ' <span id="videofileWaiting"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>loader.gif" /></span></div>'
            );
        });

        //CODE FOR AUTO UPLOAD.....
        uploader.start();
        ////e.preventDefault();

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('UploadProgress', function(up, file) {
        $("#video_file_required_error").html("");
        //$('#' + file.id + " b").html(file.percent + "%");
    });

    uploader.bind('Error', function(up, err) {
        $('#videofilelist').html("<div style='color:red'>Error: " + err.code +
            ",  Message: " + err.message +
            (err.file ? "<br> File: " + err.file.name : "") +
            "</div>"
        );

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('UploadComplete', function() {
        $('#videofileWaiting').html(
            '<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>done.gif" />');
        $('#UPLOAD_IN_PROCESS').val(0);
    });



    var images_file_name = "";
    uploader.bind('FileUploaded', function(up, file) {
        images_file_name = file.name;
        $("#video_file_path").val(images_file_name);
        $("#video_file_validation").val(file.name);

    });
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
        runtimes: 'flash,html5',
        <?php 
        } 
        else
        { 
        ?>
        runtimes: 'html5,flash',
        <?php 
        } 
        ?>
        browse_button: 'ftypepickfiles',
        container: 'ftype_upload_container',
        max_file_size: '<?php echo FTYPE_UPLOAD_FILE_SIZE;?>',
        url: '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . FTYPE_FOLDER; ?>',
        unique_names: false,
        multi_selection: false,
        flash_swf_url: '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.swf',
        filters: [{
            title: "Image files",
            extensions: "<?php echo FTYPE_UPLOAD_ALLOWED_FORMATS; ?>"
        }]
    });

    uploader.init();

    uploader.bind('FilesAdded', function(up, files) {

        $('#FTYPE_UPLOAD_IN_PROCESS').val(1);
        /*
        $.each(files, function(i, file) { 
			$('#ftypefilelist').html(
				'<div id="' + file.id + '">' +
				file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
			'</div>');
		});
        */
        $.each(files, function(i, file) {
            $('#ftypefilelist').html('<div id="' + file.id + '">' + file.name + ' (' + plupload
                .formatSize(file.size) + ') <b></b>' +
                ' <span id="ftypeWaiting"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>loader.gif" /></span></div>'
            );
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
        $('#ftypeWaiting').html('<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>done.gif" />');
        $('#FTYPE_UPLOAD_IN_PROCESS').val(0);
    });



    var images_file_name = "";
    uploader.bind('FileUploaded', function(up, file) {
        images_file_name = file.name;
        $("#ftype_file_path").val(images_file_name);
        $("#ftype_file_validation").val(file.name);

    });
});
</script>



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
        if (parseInt(imgID) > parseInt(0)) {
            var c = confirm("Are you sure you wish to remove?");
            if (!c) {
                return false;
            } else {

            }
        } else {

        }
        //alert(imgID + "--"+cl_r_image )
        //remove only image  
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImage&image_name=" + cl_r_image + "&imgID=" + imgID + "&foldername=" +
                foldername + "&copy=" + copy,
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
                if (parseInt($(".set1_image_id").length) == parseInt(0)) {
                    // IF ZERO than display atleast one BOX to upload 
                    $("#set1_pickup").show();
                }


                <?php } ?>




                //alert("uFID=" + uFID);

                if (uFID != "") {
                    $("#" + uFID).remove();
                }

            }
        });

    };



    // call croping pop up
    $(".crop_img").live('click', function() {

        var crop_image = $(this).attr('value');
        var IMG_NO = $(this).attr('imgno');
        var selectedcoordinates = $(".sel_coordinates" + IMG_NO).val();
        var foldername = $(this).attr('foldername');
        var image_id = $(this).attr('addedimgID');

        //alert(crop_image+"\n"+IMG_NO+"\n"+selectedcoordinates)

        //return false;
        $.fancybox.open({
            href: '<?php echo PAGE_CROP_IMAGE;?>?cimage_name=' + crop_image + "&img_no=" +
                IMG_NO + "&selectedcoordinates=" + selectedcoordinates + "&foldername=" +
                foldername + "&image_id=" + image_id +
                "&CALLFROM=<?php echo SET1_FOR; ?>&ASPECTRATIO=<?php echo SET1_CROP_ASPECT_RATIO; ?>&CROPWIDTH=<?php echo SET1_CROP_IMAGE_WIDTH; ?>&CROPHEIGHT=<?php echo SET1_CROP_IMAGE_HEIGHT; ?>",
            type: 'iframe',
            padding: 5,
            width: 1200
        });
    });


    $(".setDefault").click(function() {
        var image_id = $(this).attr("valueid");
        var foldername = $(this).attr("foldername");
        //alert(foldername)
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=setDefaultImage&image_id=" + image_id + "&foldername=" + foldername +
                "&media_id=<?php echo $ID; ?>",
            beforeSend: function() {

            },
            success: function(msg) {
                //alert(msg);
            }
        });

    });

});


function checkNum1(num) {
    var w = "";
    var v = "0123456789.";
    for (i = 0; i < num.value.length; i++) {
        x = num.value.charAt(i);
        if (v.indexOf(x, 0) != -1) w += x;
    }
    num.value = w;
}

function checkNum2(num) {
    var w = "";
    var v = "0123456789";
    for (i = 0; i < num.value.length; i++) {
        x = num.value.charAt(i);
        if (v.indexOf(x, 0) != -1) w += x;
    }
    num.value = w;
}
</script>


<script src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckeditor/ckeditor.js" type="text/javascript"
    language="javascript"></script>
<script language="javascript" type="text/javascript">
CKEDITOR.config.toolbar_Basic = [
    ['Source', '-', 'Bold', 'Italic', 'Underline', 'DocProps', 'Preview', 'Print', 'Cut', 'Copy', 'Paste', 'Undo',
        'Redo'
    ],
    ['NumberedList', 'BulletedList', 'CreateDiv', 'Outdent', 'Indent'],
    ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'Link', 'Unlink'],
    ['Image', 'Table', 'HorizontalRule', 'Smiley', 'Youtube'],
    ['ComboText', 'FontSize', 'TextColor', 'BGColor']
];

CKEDITOR.config.toolbar = 'Basic';
</script>



<?php
$position_qry_string = "";
$position_qry_string .= "con=".PRODUCT_IMAGES_TBL;
$position_qry_string .= "&cname1=image_name&cname2=image_id";
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {


    $.validator.addMethod('chkDataText', function(data) {
        if ($.trim($("input[name=media_type]:checked").val()) == "CONTENT" && $.trim(CKEDITOR.instances
                .media_description.getData()) == "") {
            return 0;
        } else {

            return 1;
        }
    }, ' *Content cannot be blank.');


    $.validator.addMethod('chkDataUrl', function(data) {
        if ($.trim($("input[name=media_type]:checked").val()) == "URL" && $.trim($("#ftype_url")
                .val()) == "") {
            return 0;
        } else {

            return 1;
        }
    }, '');


    $.validator.addMethod('chkDataFile', function(data) {
        if ($.trim($("input[name=media_type]:checked").val()) == "FILE" && $.trim($(
                "#ftype_file_validation").val()) == "") {
            return 0;
        } else {
            return 1;
        }
    }, '');


    $.validator.addMethod('chkEmbedCode', function(data) {
        if ($.trim($("input[name=video_type]:checked").val()) == "VIDEO_EMBED" && $.trim($(
                "#embed_code").val()) == "") {
            return 0;
        } else {
            return 1;
        }
    }, '');

    $.validator.addMethod('chkVideo', function(data) {
        if ($.trim($("input[name=video_type]:checked").val()) == "VIDEO_FILE" && $.trim($(
                "#video_file_validation").val()) == "") {
            return 0;
        } else {
            return 1;
        }
    }, '');


    $.validator.addMethod('chkFile', function(data) {

        if ($("#document_upload").is(":checked") == true) {

            var set1_imgcount = $(".set1_icount").length;
            //alert(set1_imgcount);
            if (parseInt(set1_imgcount) == parseInt(0)) {
                $("#set1_pickup").css('border', "solid 1px red");
                return false;
            } else {
                $("#set1_pickup").css('border', "solid 0px red");
                return true;
            }
        } else {
            $("#set1_pickup").css('border', "solid 0px red");
            return true;

        }

    }, '');

    $.validator.addMethod('chkCat', function(data) {

        if ($("#validateCAT").is(":checked") == true) {
            return 1;
        } else {
            return 0;
        }


    }, '');

    $("#frm").validate({
        errorElement: 'span',
        ignore: [],
        rules: {
            validateCAT: {
                chkCat: true
            },
            media_name: "required",
            media_from_date: "required"
                //,validateUpload: {
                //   chkFile: true
                //}
                //,embed_code: {
                //    chkEmbedCode: true
                //}
                //,video_file_validation: {
                //    chkVideo: true
                //}

                ,
            ftype_file_validation: {
                chkDataFile: true
            },
            ftype_url: {
                chkDataUrl: true
            },
            media_description: {
                chkDataText: true
            }
        },
        messages: {
            validateCAT: {
                chkCat: " * Required"
            },
            media_name: "",
            media_from_date: ""
                //,validateUpload: {
                //    chkFile: " * Required"
                //}
                //,embed_code: ""
                //,video_file_validation: "*Please upload a video" 

                ,
            ftype_file_validation: "Please upload a file",
            ftype_url: "",
            media_description: " * Content cannot be blank"

        },
        submitHandler: function() {

            <?php if ( SET1_ENABLE == true ){ ?>

            <?php if ( SET1_MANDATORY == true ){ ?>
            var set1_imgcount = $(".set1_icount").length;
            //alert(imgCount);
            if (parseInt(set1_imgcount) == parseInt(0)) {
                $("#set1_pickup").css('border', "solid 1px red");
                alert("Kindly upload a file");
                return false;
            } else {
                $("#set1_pickup").css('border', "solid 0px red");
            }

            <?php } ?>

            var Set1Uploading = $('#SET1_UPLOAD_IN_PROCESS').val();
            if (parseInt(Set1Uploading) == parseInt(1)) {
                alert("Upload in progress, please wait!")
                return false;
            }
            <?php } ?>


            var ImgUploading = $('#UPLOAD_IN_PROCESS').val();
            if (parseInt(ImgUploading) == parseInt(1)) {
                alert("Image Upload in progress, please wait!")
                return false;
            }


            var dcontent = escape(CKEDITOR.instances.media_description.getData());
            var value = $("#frm").serialize();
            //alert(value);
            //return false;


            $.ajax({
                type: "POST",
                url: "<?php echo PAGE_AJAX; ?>",
                data: "type=saveData&dcontent=" + dcontent + "&" + value,
                beforeSend: function() {
                    //$("#INPROCESS").html("<div id='fInprocess'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load25.gif' align='absmidlle' border='0' />Processing...</div>");
                    $("#INPROCESS").html(
                        "<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>"
                    );
                },
                success: function(msg) {
                    //alert(msg);
                    //return false;                 
                    var cond = $("#con").val();
                    var copyEv = "<?php echo $copy;?>";

                    setTimeout(function() {
                        $("#INPROCESS").html("");
                        var spl_txt = msg.split("~~~");

                        var colorStyle = "";
                        if (parseInt(spl_txt[1]) == parseInt(1)) {
                            colorStyle = "successTxt";
                        } else {
                            colorStyle = "errorTxt";
                        }

                        $("#INPROCESS").html(
                            "<div id='inprocess'><input type='button' value='" +
                            spl_txt[2] +
                            "' name='save' id='save' class='cancelBtn " +
                            colorStyle + "' /></div>");


                        setTimeout(function() {

                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html(
                                "<input type='submit' value='Save' class='submitBtn' id='save' name='save'/>&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>"
                            );

                            //window.location.href = "<?php echo PAGE_MAIN; ?>";

                            if (parseInt(spl_txt[1]) == parseInt(1)) {
                                if (cond == "modify") {
                                    window.location.href =
                                        "<?php echo PAGE_LIST; ?>";
                                } else {
                                    window.location.href =
                                        "<?php echo PAGE_MAIN; ?>";
                                }
                            }

                        }, 2000);


                    }, 1000);


                }
            });
        }
    });

    $("#category_id").live("change", function() {

        var val = $(this).val();
        //alert(val);         

        if (($.trim(val) != "")) {
            $("label[for=validateCAT]").remove();
            $("#validateCAT").attr("checked", true);



        } else {
            $("#validateCAT").attr("checked", false);


        }


    });

    $(".video_type").click(function() {
        var value = $(this).val();
        //alert(value);
        if (value == "VIDEO_EMBED") {
            $("#divVFILE").hide();
            $("#divEMBED").show();
            $("#embed_code").focus();
            $('#UPLOAD_IN_PROCESS').val("0");

        } else if (value == "VIDEO_FILE") {
            $("#divEMBED").hide();
            $("#divVFILE").show();

        }

    });


    $(".media_type").click(function() {

        ///var media_type = $(this).val();
        var media_type = $(".media_type:checked").val()

        ///alert(media_type);
        if (media_type == "URL") {
            $(".div_content").hide();
            $(".div_file").hide();
            $(".div_url").show();
        } else if (media_type == "CONTENT") {
            $(".div_url").hide();
            $(".div_file").hide();
            $(".div_content").show();
        } else if (media_type == "FILE") {
            $(".div_url").hide();
            $(".div_content").hide();
            $(".div_file").show();
        }
    });


    $("#deleteFType").live("click", function() {

        var ID = $(this).attr("did");
        //alert(ID);

        if (parseInt(ID) > parseInt(0)) {
            var c = confirm("Are you sure you wish to remove?");
            if (!c) {
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

    $("#deleteVType").live("click", function() {

        var ID = $(this).attr("did");
        //alert(ID);

        if (parseInt(ID) > parseInt(0)) {
            var c = confirm("Are you sure you wish to remove?");
            if (!c) {
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

    $("#media_publisher").autocomplete({
        source: "<?php echo PAGE_COMMON; ?>?type=suggestAutoLoad&WCH=MediaPublisher",
        minLength: 0,
        select: function(event, ui) {

            if (ui.item.label) {
                //alert(ui.item.value2)
                //return false;
            } else {
                $(".ui-autocomplete").removeClass();
                return false;
            }

        }
    });

    $("#cancel").live("click", function() {
        //location.href='<?php echo PAGE_MAIN; ?>';  
        <?php
        if($con == "modify")
        {
        ?>
        location.href = '<?php echo PAGE_LIST; ?>';
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

    $('#media_from_date').datepick({
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

    <input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;" />
    <input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;" />


    <?php if ( SET1_ENABLE == true ){ ?>
    <input type="hidden" name="SET1_UPLOAD_IN_PROCESS" id="SET1_UPLOAD_IN_PROCESS" value="0" readonly
        style="display: none;" />
    <input type="hidden" name="SET1_BOX_COUNT" id="SET1_BOX_COUNT" value="0" readonly style="display: none;" />
    <?php } ?>

    <input type="hidden" name="UPLOAD_IN_PROCESS" id="UPLOAD_IN_PROCESS" value="0" readonly style="display: none;" />
    <input type="hidden" name="old_video_file" id="old_video_file" value="<?php echo $old_video_file;?>" />

    <input type="hidden" name="FTYPE_UPLOAD_IN_PROCESS" id="FTYPE_UPLOAD_IN_PROCESS" value="0" readonly
        style="display: none;" />
    <input type="hidden" name="old_ftype_file" id="old_ftype_file" value="<?php echo $old_ftype_file;?>" />



    <h1>
        Media
        <!--div class="addProductBox"><a href="<?php //echo PAGE_LIST;?>" class="backBtn">Go to List</a></div-->
    </h1>
    <div class="addWrapper">
        <div class="boxHeading"><?php echo ucwords($con); ?></div>
        <div class="clear"></div>
        <div class="containerPad">

            <div class="fullWidth">
                <div class="fullWidth">
                    <label class="mainLabel">Name <span>*</span></label>
                    <input type="text" class="txtBox" name="media_name" id="media_name"
                        value="<?php echo $media_name; ?>" maxlength="500" autocomplete="OFF" />
                </div>
            </div>
            <div class="fullWidth noGap">
                <div class="width4">
                    <label class="mainLabel">Published On <span>*</span> </label>
                    <div class="txt3Box">
                        <input type="text" class="titleTxt txtBox" name="media_from_date" id="media_from_date"
                            value="<?php echo $media_from_date; ?>" maxlength="12" placeholder="Date"
                            style="width: 90px;" autocomplete="OFF" />&nbsp;&nbsp;
                    </div>
                </div>
                <div class="width4">
                    <label class="mainLabel">Publisher <span></span> </label>
                    <input type="text" class="titleTxt txtBox" name="media_publisher" id="media_publisher"
                        value="<?php echo $media_publisher; ?>" maxlength="250" placeholder="Publisher" />&nbsp;&nbsp;

                </div>


            </div>
            <!--fullWidth end-->

            <div class="fullDivider">
                <div class="sml_heading">Media Type <span></span> </div>
            </div>

            <div class="fullWidth">

                <div class="">
                    <label class="radioGroup"><input type="radio" name="media_type" class="media_type" value="CONTENT"
                            <?php if( trim($media_type) == 'CONTENT') { echo " checked "; } ?> checked="checked" />
                        Content</label>
                    <label class="radioGroup"><input type="radio" name="media_type" class="media_type" value="URL"
                            <?php if( trim($media_type) == 'URL') { echo " checked "; } ?> /> Url</label>
                    <label class="radioGroup"><input type="radio" name="media_type" class="media_type" value="FILE"
                            <?php if( trim($media_type) == 'FILE') { echo " checked "; } ?> /> File</label>
                </div>
            </div>


            <div class="fullWidth div_file validateMsg"
                <?php if( trim($media_type) != 'FILE') { echo " style='display: none;' "; } ?>>

                <div class="fullWidth">
                    <div class="sml_heading" id="uploadImgPos">Upload <?php echo (FTYPE_UPLOAD_ALLOWED_FORMATS_IMG);?>
                        File
                        <span id="imagealert"><?php echo "(Size Limit " . FTYPE_UPLOAD_FILE_SIZE . ") ";?></span>
                    </div>
                </div>
                <div class="fullWidth noGap">
                    <div class="width2">
                        <div id="ftype_upload_container">
                            <input type="hidden" name="ftype_file_path" id="ftype_file_path" value="" />
                            <div id="ftypefilelist"
                                style="width: 354px; min-height: 30px;height: auto; border: 1px solid #b6b6b6; padding: 5px;float:left;">
                                <span id="ftype_file_required_error"></span><input type="hidden"
                                    name="ftype_file_validation" id="ftype_file_validation" class="txtBox"
                                    value="<?php echo $old_ftype_file; ?>" />
                            </div>
                            <input id="ftypepickfiles" value="Browse" type="button" class="browse_btn" />
                        </div>
                    </div>

                    <?php            
                if ( trim($con) == "modify" && intval($chKFTYPE) == intval(1) ){
                    
                    $myEXT = getExtensionForDisplayingIcons(strtolower($file_name)); 
                    
                    
                                           
                ?>
                    <div class="width2" id="showFTYPE">
                        <!-- <a href="<?php echo $FTYPE_PATH . "/" . $file_name; ?>" target="_blank"> -->
                        <img src="<?php echo $FTYPE_PATH . "/" . $file_name; ?>" border="0" width="80px" height="120px"
                            alt="<?php echo $file_name; ?>" title="<?php echo $file_name; ?>">
                        <!-- <?php //echo $file_name; ?> </a> -->
                        <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png"
                            did="<?php echo $ID; ?>" title="Delete File" id="deleteFType" style="cursor: pointer;"
                            border="0" />
                    </div>


                    <?php        
                }
                ?>

                </div>



            </div>

            <div class="fullWidth div_url"
                <?php if( trim($media_type) != 'URL') { echo " style='display: none;' "; } ?>>
                <label class="mainLabel">Url <span>*</span></label>
                <input type="text" class="titleTxt txtBox" name="ftype_url" id="ftype_url"
                    value="<?php echo $media_url; ?>" maxlength="1000">
                <small>ie. http://google.com</small>
            </div>


            <div class="div_content" <?php if( trim($media_type) != 'CONTENT') { echo " style='display: none;' "; } ?>>



                <div class="fullDivider">
                    <div class="sml_heading">Details <span></span> </div>
                </div>

                <div class="fullWidth validateMsg">
                    <label class="mainLabel">Intro / Brief <small></small></label>
                    <textarea class="txtBox" name="media_short_description" id="media_short_description" data-maxsize=""
                        data-output="status1" wrap="virtual"
                        style="height:100px;"><?php echo $media_short_description; ?></textarea>
                    <br><span id="status1" style="font-size:11px"></span> <span style="font-size:11px">characters
                    </span>
                </div>
                <div class="fullWidth noGap">
                    <label class="mainLabel">Full</label>
                </div>
                <div class="fullWidth validateMsg">
                    <textarea name="media_description" id="media_description"
                        style="width:90%; height:230px; float:left;"><?php echo $media_description; ?></textarea>
                    <script>
                    CKEDITOR.replace("media_description", {
                        enterMode: 2,
                        extraPlugins: 'youtube',
                        filebrowserBrowseUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html',
                        filebrowserImageBrowseUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Images',
                        filebrowserFlashBrowseUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/ckfinder.html?type=Flash',
                        filebrowserUploadUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                        filebrowserImageUploadUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                        filebrowserFlashUploadUrl: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                    });
                    </script>

                </div>
                <!--fullWidth end-->
                <div class="clr">&nbsp;</div>

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
                                <input type="checkbox" name="validateUpload" id="validateUpload"
                                    style="display: none; " />
                            </span>
                        </div>
                    </div>
                    <?php include("include_SET1_view.php"); ?>
                    <?php } ?>
                </div>

                <div class="fullDivider">
                    <div class="sml_heading">Video <span></span> </div>
                </div>

                <div class="fullWidth">

                    <div class=" validateMsg">
                        <label class="mainLabel">Title <span></span></label>
                        <input type="text" class="titleTxt txtBox" name="video_title" id="video_title"
                            value="<?php echo $videoTITLE; ?>" maxlength="100" AUTOCOMPLETE="OFF">
                    </div>
                </div>

                <div class="fullWidth noGap">
                    <label class="mainLabel">Video Type <span>*</span></label>
                    <label class="checkBoxWidth"><input type="radio" name="video_type" class="video_type"
                            value="VIDEO_EMBED" <?php if($videoTYPE == "VIDEO_EMBED") { echo " checked "; } ?> /> Embed
                        Code (Youtube)</label>
                    <label class="checkBoxWidth"><input type="radio" name="video_type" class="video_type"
                            value="VIDEO_FILE" <?php if($videoTYPE == "VIDEO_FILE") { echo " checked "; } ?> /> MP4
                        File</label>
                </div>

                <div class="fullWidth noGap" id="divEMBED"
                    <?php if($videoTYPE == "VIDEO_FILE") { echo " style='display:none;' "; } ?>>
                    <div class="width2">
                        <label class="mainLabel">Embed Code <span></span></label>
                        <textarea name="embed_code" id="embed_code" class="embedVideo"
                            style="width: 100%; min-height: 50px;"><?php echo $videoEMBEDCODE; ?></textarea>
                    </div>
                </div>
                <div class="fullWidth noGap" id="divVFILE"
                    <?php if($videoTYPE == "VIDEO_EMBED") { echo " style='display:none;' "; } ?>>
                    <div class="fullWidth">
                        <div class="sml_heading" id="uploadImgPos">Upload
                            <?php echo strtoupper(VIDEO_UPLOAD_ALLOWED_FORMATS);?> Video
                            <span id="imagealert"><?php echo "(Size Limit " . VIDEO_UPLOAD_FILE_SIZE . ") ";?></span>
                        </div>
                    </div>
                    <div class="fullWidth noGap">
                        <div class="width3">
                            <div id="video_upload_container">
                                <input type="hidden" name="video_file_path" id="video_file_path" value="" />
                                <div id="videofilelist"
                                    style="width: 100%; min-height: 30px;height: auto; border: 1px solid #b6b6b6; padding: 5px;float:left;">
                                    <span id="video_file_required_error"></span><input type="hidden"
                                        name="video_file_validation" id="video_file_validation" class="txtBox"
                                        value="<?php echo $old_video_file; ?>" />
                                </div>
                                <input id="videopickfiles" value="Browse" type="button" class="browse_btn" />
                            </div>
                        </div>

                        <?php            
                    if ( trim($con) == "modify" && intval($chKVTYPE) == intval(1) ){
                        
                        $myEXTV = getExtensionForDisplayingIcons($old_video_file);              
                        
                                               
                    ?>
                        <div class="width2" id="showVTYPE" style="margin-left: 25px;">
                            <a href="<?php echo $VTYPE_PATH . "/" . $old_video_file; ?>" target="_blank">
                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH.$myEXTV; ?>" border="0"
                                    alt="<?php echo $old_video_file; ?>" title="<?php echo $old_video_file; ?>">
                                <?php //echo $old_video_file; ?> </a>
                            <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png"
                                did="<?php echo $ID; ?>" title="Delete File" id="deleteVType" style="cursor: pointer;"
                                border="0" />
                        </div>


                        <?php        
                    }
                    ?>
                    </div>
                </div>

            </div>

            <div class="fullWidth div_content">
                <div class="sml_heading">SEO Fields [ <small class="instructions">Use Below Tags to Enhance User
                        Experience and Improve SEO</small> ] </div>
            </div>

            <div class="fullWidth">
                <div class="fullWidth">
                    <label class="mainLabel">Meta Title </label>
                    <input type="text" class="titleTxt txtBox" name="meta_title" id="meta_title"
                        value="<?php echo $METATITLE; ?>" maxlength="250" autocomplete="OFF">
                </div>
                <div class="fullWidth">
                    <label class="mainLabel">Meta Keyword </label>
                    <input type="text" class="titleTxt txtBox" name="meta_keyword" id="meta_keyword"
                        value="<?php echo $METAKEYWORD; ?>" maxlength="350" autocomplete="OFF">
                </div>
                <div class="fullWidth">
                    <label class="mainLabel">Meta Description </label>
                    <input type="text" class="titleTxt txtBox" name="meta_description" id="meta_description"
                        value="<?php echo $METADESCRIPTION; ?>" maxlength="250" autocomplete="OFF">
                </div>
            </div>

            <?php if ( trim($con) == "modify" ){ ?>
            <div class="fullDivider">
                <div class="sml_heading">Status</div>
            </div>

            <div class="fullWidth">
                <label class="radioGroup"><input type="radio" name="status" value="ACTIVE"
                        <?php if ( trim($status) == "ACTIVE" ){ echo " checked='' "; } ?> /> Active</label>
                <label class="radioGroup"><input type="radio" name="status" value="INACTIVE"
                        <?php if ( trim($status) == "INACTIVE" ){ echo " checked='' "; } ?> /> Inactive</label>
            </div>
            <?php } ?>



            <div class="fullWidth noGap">
                <div class="sbumitLoaderBox" id="INPROCESS">
                    <input type='submit' value='Save' class='submitBtn' id='save' name='save' />
                    <input type='reset' value='Cancel' class='cancelBtn' id='cancel' />
                </div>
            </div>

        </div>
        <!--containerPad end-->
    </div>
</form>

<?php include("footer.php");?>