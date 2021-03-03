<script language="javascript" type="text/javascript"> 
//CODE FOR FILE UPLOAD STARTS....................
 
 $(function() {
    var set1_uploader = new plupload.Uploader({
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
		browse_button : 'set1_pickup',
		container : 'set1_upload_container',
		max_file_size : '<?php echo SET1_UPLOAD_FILE_SIZE; ?>',
        <?php if ( SET1_IMAGE_CROPPING  == true ){ ?>
            url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/ADV_upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . TEMP_UPLOAD; ?>',
            multipart_params: { 
                "resize_image": "<?php echo SET1_IMAGE_RESIZE; ?>",
                "save_resized_images_to": "<?php echo $SET1_SAVE_RESIZE_LOCATION_RELPATH; ?>",
                "resize_size": "<?php echo $SET1_RESIZE_DIMENSION; ?>",
                "resize_image_name": "<?php echo $SET1_RESIZE_DIMENSION; ?>",
            },
        <?php }else if ( SET1_IMAGE_CROPPING  == false ){ ?>
            url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . TEMP_UPLOAD; ?>',
        <?php } ?>
      	
        
        
        unique_names : false,
        multi_selection: "<?php echo SET1_IMAGE_MULTIPLE; ?>",
        
		flash_swf_url : '<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.swf', 
		filters : [
			{title : "Image files", extensions : "<?php echo SET1_UPLOAD_ALLOWED_FORMATS; ?>"}
		]
	});

	set1_uploader.init();

	set1_uploader.bind('FilesAdded', function(up, files) {
        
        $('#SET1_UPLOAD_IN_PROCESS').val(1);
        //CODE FOR AUTO UPLOAD.....
        set1_uploader.start();
		////e.preventDefault();
		up.refresh(); // Reposition Flash/Silverlight
	});   
   
    set1_uploader.bind('UploadProgress', function(up, file) {
        var progressBarValue = up.total.percent;
        //$('#progressbar').fadeIn().progressbar({
        //    value: progressBarValue
        //});
        $('#set1_filelist').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif" />');
    });
    
    
	set1_uploader.bind('Error', function(up, err) {
		
        alert("Error: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");
        
		up.refresh(); // Reposition Flash/Silverlight
	});
    
    set1_uploader.bind('UploadComplete', function() {
        //alert("1")
        $('#SET1_UPLOAD_IN_PROCESS').val(0);
        <?php if ( SET1_TYPE  == "IMAGE" ){ ?>
            $('#set1_filelist').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload');
        <?php }else if ( SET1_TYPE  == "FILE" ){ ?>
            $('#set1_filelist').removeClass('iconUploading').html('Upload');
        <?php } ?>
    });
    
    
    
	var images_file_name = "";
    var i=0;
        
	set1_uploader.bind('FileUploaded', function(up, file) {         
        
        
        var image_default  = "";
        if(i==0){
           image_default = "checked";  
        }else{
            image_default  = "";
        }
        
        //////////////////var removeImageTR_CT = parseInt($(".removeImageTR").size());
       
        var fixedImgCT = $("#SET1_BOX_COUNT").val();
        //alert("@@@" + fixedImgCT);
        if( parseInt(fixedImgCT) == parseInt(0) ){
            var fixedImg_CT = parseInt(1); 
            $("#SET1_BOX_COUNT").val(1);
        }else{
            var fixedImg_CT = parseInt(fixedImgCT) + parseInt(1); 
            $("#SET1_BOX_COUNT").val(fixedImg_CT);
        }
        
        var image_list_html = "";
	  	image_list_html = image_list_html + '<div class="removeImageTR uploadImgContainer">';
            	image_list_html = image_list_html + '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/><BR>';
				    image_list_html = image_list_html + '<input type="hidden" class="set1_image_id" name="set1_image_id[]" value="0" />';
                    image_list_html = image_list_html + '<input type="hidden" class="cl_r_image set1_icount" id="image[]" name="set1_image[]" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="set1_folder_name" name="set1_folder_name[]" value="<?php echo TEMP_UPLOAD; ?>" />';
                	
                    image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span><a href="javascript:void(0)">';
                        <?php if ( SET1_TYPE  == "IMAGE" ){ ?>
                            image_list_html = image_list_html + '<img src="<?php echo $SET1_RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg imgno'+fixedImg_CT+'" />';
                        <?php }else if ( SET1_TYPE  == "FILE" ){ ?>
                            image_list_html = image_list_html + file.name;
                        <?php } ?>
                    image_list_html = image_list_html + '</a></span></div>'; 
                
                image_list_html = image_list_html + '</div>';
                   
             
             
                image_list_html = image_list_html + '<div class="uploadImgBox">';
                    image_list_html = image_list_html + '<input type="text" class="set1_image_caption" name="set1_image_caption[]" value="" autocomplete="OFF" />';
                image_list_html = image_list_html + '</div>';
                
                
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					<?php if ( SET1_IMAGE_MULTIPLE == true ){ ?>
                        image_list_html = image_list_html + '<td><input type="radio" name="set1_default_image" id="set1_default_image" title="Set Default" value="' + file.name + '" '+ image_default +' "<?php echo $SET1_RADIO_DISPLAY; ?>"  ></td>';
                    <?php } ?>
                    <?php if ( SET1_IMAGE_CROPPING == true ){ ?>
                        image_list_html = image_list_html + '<td><input type="hidden" name="set1_coordinates[]" id="set1_coordinates[]" class="sel_coordinates'+fixedImg_CT+'" value=""><a href="javascript:void(0);" class="crop_img" foldername=<?php echo TEMP_UPLOAD; ?> value="R<?php echo SET1_IMAGE_RESIZE_WIDTH; ?>-' + file.name + '" imgno='+fixedImg_CT+'  addedimgID="0"><img border="0" title="Adjust Thumbnail" src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/cropIcon.png"></a> </td>';
					<?php } ?>
                    image_list_html = image_list_html + '<td><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a></td>';
					image_list_html = image_list_html + '</tr></table>';
				image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '</div>';

		i++;
		
        
        $("#set1_image_list").prepend(image_list_html);
        
        
        <?php if ( SET1_IMAGE_MULTIPLE == false ){ ?>
            $("#set1_pickup").hide(); 
        <?php } ?>
        
        
                                                
        if( parseInt($(".removeImageTR").size()) > parseInt(0) )
        {
            $("#set1_image_list").show();
        }
              
	});
    
    
    
    $("#set1_image_list").sortable({
        handle : '.handle',
        update : function () {
        	var order = $('#set1_image_list').sortable('serialize');
            var qryString = $("#qryString").val();
            //alert(order)
            $.ajax({
                type: "POST",
                url: "ajax_position.php",
                data: "type=saveListPosition&" + qryString + "&" + order,
                beforeSend: function(){
                    
                },
                success: function(msg) {
                    //alert(msg)
                    $("#smessage").html(msg);        
                }
            });
            
            
        }
    });
     
    
});
</script>