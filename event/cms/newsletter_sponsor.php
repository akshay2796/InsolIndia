<?php
error_reporting(1);
include("header.php");

define("PAGE_MAIN", "newsletter_sponsor.php");
define("PAGE_AJAX", "ajax_newsletter_sponsor.php"); 

if( !is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR))
{
    $mask=umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH .  FLD_NEWSLETTER_SPONSOR, 0777); 
    umask($mask);      
}



$ID = intval($_REQUEST['id']); //1003;

if( (intval($ID) > intval(0)) )
{
    $SQL  = "";
    $SQL .= " SELECT * FROM " . NEWSLETTER_SPONSOR_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND sponsor_id = :sponsor_id ";
   
    //echo "<BR>" . $SQL . "<BR>".$ID;
    $stmt = $dCON->prepare( $SQL );
    $stmt->bindParam(":sponsor_id", $ID);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
    
    //echo "<br>==".count($row_stmt);
    $sponsor_id = intval(stripslashes($row_stmt[0]['sponsor_id']));  
    $company_name = htmlentities(stripslashes($row_stmt[0]['company_name']));  
    $url = htmlentities(stripslashes($row_stmt[0]['url']));  
    $image_name = htmlentities(stripslashes($row_stmt[0]['image_name'])); 
    $con = "modify";
    $IMAGE_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR . "/";
    
    $chk_file = chkImageExists($IMAGE_PATH .$image_name);
    
?>

    <script language="javascript" type="text/javascript">
        $(document).ready(function(){
           
            $(".expendableBox").slideDown();
			$('.showHideBtn').html("(-)");
		    $(".expendBtn").addClass("collapseBtn");
            $(".expendBtn").removeClass("expendBtn");
            
            <?php 
            if(intval($chk_file) == intval(1)) 
            {
            ?>
                var image_list_html = "";
                image_list_html = image_list_html + '<div class="removeImageTR uploadIconContainer">';
                	image_list_html = image_list_html + '<div class="uploadedIcon">';
    				    image_list_html = image_list_html + '<span><input type="hidden" class="image_id" name="image_id" value="<?php echo $sponsor_id;?>" /><input type="hidden" class="cl_r_image" id="image" name="image" value="<?php echo $image_name;?>" /><img src="<?php echo $IMAGE_PATH.$image_name; ?>" /></span>';
                   image_list_html = image_list_html + '</div>';
                    image_list_html = image_list_html + '<div class="delIcon"><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'<?php echo $image_name;?>\',foldername:\'<?php echo FLD_NEWSLETTER_SPONSOR; ?>\',imageId:\'<?php echo $sponsor_id; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Icon" border="0" /></a></div>';
                image_list_html = image_list_html + '</div>';
                
                $("#image_list").hide();
                $("#iconDisplay").html(image_list_html).show();
            <?php
            }
            ?>
            
            
        });
    </script>


<?php
}
else
{
    $con = "add";
    $sponsor_id = "";
    $ID= "";
}



$TEMP_FOLDER_NAME = "";
$TEMP_FOLDER_NAME = TEMP_UPLOAD;
       
$ASPECTRATIO = "";
$ASPECTRATIO = '1:1';

$RESIZE_WIDTH = "100"; //main resize width
$RESIZE_HEIGHT = "100"; //main resize height

$RESIZE_REQUIRED = "YES";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT ; //widthXheight|weightXheight SEPRATED BY PIPE 

$SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $TEMP_FOLDER_NAME . "/R100-";

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>

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
		max_file_size : '1Mb',
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
		$('#filelist_main').addClass('iconUploading').html('Loading...');	
		
    });
    
    
	uploader_main.bind('Error', function(up, err) {
        alert("Error: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");
		up.refresh(); // Reposition Flash/Silverlight
	});
    
    uploader_main.bind('UploadComplete', function() {
        $('#checkImgUploadingProgress').val(0);
        //$('#filelist_main').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload');
		$('#filelist_main').removeClass('iconUploading').html('Upload...');
    });
    
    
    
	var images_file_name = "";
    var i=0;
        
	uploader_main.bind('FileUploaded', function(up, file) {         
        var image_list_html = "";
        var image_default  = "";
        
	  	image_list_html = image_list_html + '<div class="removeImageTR uploadIconContainer">';
            	image_list_html = image_list_html + '<div class="uploadedIcon">';
				    image_list_html = image_list_html + '<span><input type="hidden" class="image_id" name="image_id" value="0" /><input type="hidden" class="cl_r_image" id="image" name="image" value="' + file.name + '" /><img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" /></span>';
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="delIcon"><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Icon" border="0" /></a></div>';
		image_list_html = image_list_html + '</div>';

	   $("#iconDisplay").html(image_list_html).show();
        
        if( parseInt($(".removeImageTR").size()) > parseInt(0) )
        {
            $("#image_list").hide();
        }
              
	});
    
    
    $.fn.removeImage = function() {
        var args = arguments[0] || {};
        var imageId = args.imageId || 0; 
        var uFID = args.uFID || "";
        var indx = $(".removeImage").index(this);
        var cl_r_image = $(".cl_r_image:eq(" + indx + ")").val();
        
        //alert(cl_r_image+"--"+imageId);
        //return false;
        
        if( parseInt(imageId) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c)
            {
                return false;
            }
        }
       
        
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImage&image_name=" + cl_r_image + "&imageId=" + imageId,
            beforeSend: function() {
                $(".removeImage:eq(" + indx + ")").hide();
                $(".removeImageLoader:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                
                if(uFID != "")
                {
                    $("#" + uFID).remove();
                }
				$("#image_list").show();
	            
            }
        });  
          
    };
 
    
});
</script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $("#frm").validate({ 
        rules: {
            url: "required"      
        },
        messages: {
            url: "" 
        },
        submitHandler: function() {
            
            var imgCount = $(".cl_r_image").length;
            //alert(imgCount);
            if(parseInt(imgCount)==parseInt(0))
            {
                alert("Please upload Logo.")
                return false;
            }
            
            
            var value = $("#frm").serialize();
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&" + value,
			   beforeSend: function() { 
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
                            colorStyle = "successTxt";                            
                        } 
                        else
                        {
                            colorStyle = "errorTxt";
                        }
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                         setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' />&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>");
                            window.location.href = "<?php echo PAGE_MAIN; ?>";
                        
                        },1000);
                  
                                             
                    },1000); 
               }
            });
        }
    });
    
    $("#cancel").live("click", function(){    
        window.location.href='<?php echo PAGE_MAIN; ?>';  
    });
    
    
    
    $.fn.listData = function() {
        var args = arguments[0] || {}; // It's your object of arguments        
        var pageNo = args.pageNo || 1; 
        ///alert(search_val);
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=listData&page=" + pageNo,
            beforeSend: function(){  
                //$("html, body").animate({ scrollTop: 200 }, "slow");
                $('#txtHint').html("<div class='ajaxLoader'><img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif' border='0'></div>");
            },
            success: function(msg){
                $('#txtHint').html(msg);
            }
        });
    }; 
     
    $('#txtHint').listData();
     
    
    //Paging Link
    $(".paging").live("click", function(){
        var value = $(this).attr("id");
        $('#txtHint').listData({pageNo: value}); 
    });
    
    //Paging Selectbox
    
    $("#page").live("change", function(){
        var pg = $(this).val(); 
        $('#txtHint').listData({pageNo: pg});
    });
   
    
    
    $.fn.deleteSelected = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var nock = $(".cb-element:checked").size();
        
        if(nock == 0)
        {
            alert("Please check atleast one status");
        }
        else
        {
            var a = confirm("Are you sure you wish to delete?");
            if(a)
            {
                var formvalue = $("#frmDel").serialize();
                
                
                $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=deleteSelected&" + formvalue,
                   beforeSend: function(){  
                        $(".INPROCESS_DEL").html("<label class='selectAllBtn'><input type='checkbox'  disabled='disabled'/></label><div id='inprocess'><input type='button' value='Delete Selected' id='delete_all' class='process' /></div>");
                   },
				   //return false;
                   success: function(msg){
                        
                        //alert(msg);               
                        setTimeout(function(){
                                              
                            var colorStyle = "";
                            colorStyle = "success";
                            
                            $(".INPROCESS_DEL").html("<label class='selectAllBtn'><input type='checkbox'  disabled='disabled'/></label><div id='inprocess'><input type='button' value='" + msg + "' id='delete_all' class='" + colorStyle + "' />");
                        
                            setTimeout(function(){
                                $("#inprocess").fadeOut();
                                $(".INPROCESS_DEL").html("<input type='button' class='deleteSelectedBtn greyBtn' value='Delete Selected'  id='delete_all' disabled='' />");
                            },1000);  
                            
                            setTimeout(function(){
                                $('#txtHint').listData(); 
                            },1000); 
                                                 
                        },1000);
                      
                         
                   }
                });
            }
        }
    };
    
    $.fn.deleteData = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var ID = args.sponsor_id;
        
        //alert(ID);
        var c = confirm("Are you sure you wish to delete?");
        if(c)
        {                  
            $.ajax({
                type: "POST",
                url: "<?php echo PAGE_AJAX; ?>",
                data: "type=deleteData&did=" + ID,
                beforeSend: function(){
                    $("#INPROCESS_DELETE_2_" + ID).hide();
                    $("#INPROCESS_DELETE_1_" + ID).show();
                    $("#INPROCESS_DELETE_1_" + ID).html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
                },
                success: function(msg){ 
                     
                    //alert(msg);
                    
                    var spl_txt = msg.split("~~~");
                    if(spl_txt[1] == '1')
                    {
                        colorStyle = "successTxt1";                   
                    } 
                    else
                    {
                        colorStyle = "errorTxt1";
                    }
                    
                    
                    $("#INPROCESS_DELETE_1_" + ID).html("<div id='inprocess' class='del_msg'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                    
                    setTimeout(function(){
                        
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {                                
                            $("#txtHint").listData();
                            //$("#listItem_"+ID).hide();
                        }
                        else
                        {     
                            $("#INPROCESS_DELETE_2_"+ID).show();
                            $("#INPROCESS_DELETE_1_"+ID).hide();
                        }
                        
                    }, 2000);
                    
                     
                }
            });
        }
                   
    };
    
    $.fn.setStatus = function() {
        
        var args = arguments[0] || {};  // It's your object of arguments 
        var ID = args.ID;
        var VAL = args.VAL; 
        //alert(ID);
        
                         
        $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=setStatus&ID=" + ID + "&VAL="+VAL,
        	   beforeSend: function(){
                    $("#INPROCESS_STATUS_2_" + ID).hide();
                    $("#INPROCESS_STATUS_1_" + ID).show();
                    $("#INPROCESS_STATUS_1_" + ID).html("<img src='<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif' border='0' />");
      
               },
              
               success: function(msg){ 
                    
                    //alert(msg)
                    var spl_txt = msg.split("~~~");
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {
                        colorStyle = "successTxt1";                   
                    } 
                    else
                    {
                        colorStyle = "errorTxt1";
                    }
                    
                    
                    $("#INPROCESS_STATUS_1_" + ID).html("<div id='inprocess' class='del_msg'><div id='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                    
                    setTimeout(function(){
                        
                         $("#INPROCESS_STATUS_1_" + ID).hide();
                         $("#INPROCESS_STATUS_2_" + ID).html("");
                         
                         var TL = "";
                         var IM = "";
                         
                         if ( $.trim(VAL) == "INACTIVE" )
                         {
                            VL = "ACTIVE";
                            TL = "Click to Active";
                            IM = '<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" alt="' + TL + '" title="' + TL + '" >';
                         }
                         else
                         {
                            VL = "INACTIVE";
                            TL = "Click to Inactive";
                            IM = '<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" alt="' + TL + '" title="' + TL + '" >';
                            
                         }
                               
                         var dw = "";
                         dw = dw + '<a href="javascript:void(0);" value="' + ID + '" myvalue="' + VL + '" class="setStatus">';
                         dw = dw + IM;
                         dw = dw + '</a>';
                         
                         //alert(dw);
                         $("#INPROCESS_STATUS_2_" + ID).html(dw);
                         $("#INPROCESS_STATUS_2_" + ID).show(); 
                        
                    }, 2000);     
                    
               }
               
               
        }); 
    
    };
    
    
    
});
 
</script>


<h1>Newsletter Sponsor</h1>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $ID;?>" />
<input type="hidden" name="con" id="con" value="<?php echo $con;?>" />
<div class="addWrapper master">
    <div class="boxHeading expendBtn"> <span id="MOD"><?php echo ucwords($con);?></span> <a href="javascript:void(0)" class="showHideBtn">(+)</a></div>
    <div class="clear"></div>
    <div class="containerPad expendableBox">
        <div class="fullWidth noGap">
            <div class="width4 validateMsg">
    			<label class="mainLabel">Company Name </label>
    			<input type="text" class="txtBox" value="<?php echo $company_name;?>" name="company_name" id="company_name" AUTOCOMPLETE = "OFF" />
    		</div>
            <div class="width3 validateMsg">
    			<label class="mainLabel">URL<span>*</span></label>
        	   <input type="text" name="url" id="url" class="txtBox" value="<?php echo $url; ?>" autocomplete="OFF"  style="width: 300px;" maxlength="2000"/>  
    		</div>
            <div class="width4">
                <label class="mainLabel">&nbsp;&nbsp;&nbsp;Logo <small style="color:#ff0000; font-weight:normal;">Max Logo size 1 Mb.</small></label>
                <div id="image_list" class="iconContainer">            
                    <div id="pickfiles_main" class="uploadIconContainer"><a href="#/" id="filelist_main">Upload</a></div>            
                    <div id="upload_container_main" style="height:0px;"></div>
                </div>                
                <div id="iconDisplay" class="iconContainer"></div>
            </div> 
         </div><!--fullWidth end--> 
        
       
		
        
        <div class="fullWidth noGap">
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' />
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
            </div>           
        </div>
    </div><!--containerPad end-->
</div><!--addWrapper end-->
</form>

<div class="listWrapper" id="txtHint">
	
</div>



