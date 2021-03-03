<?php

include("image_functions.php");	

?>
<script type="text/javascript" src="js/jquery.min.js"></script>
<!--script type="text/javascript" src="js/jquery-pack.js"></script-->
<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
<script type="text/javascript" src="js/jquery.ocupload-packed.js"></script>
<script type="text/javascript">
//<![CDATA[

//create a preview of the selection
function preview(img, selection) { 
	//get width and height of the uploaded image.
	var current_width = $('#uploaded_image').find('#thumbnail').width();
	var current_height = $('#uploaded_image').find('#thumbnail').height();

	var scaleX = <?php echo $thumb_width;?> / selection.width; 
	var scaleY = <?php echo $thumb_height;?> / selection.height; 
	
	$('#uploaded_image').find('#thumbnail_preview').css({ 
		width: Math.round(scaleX * current_width) + 'px', 
		height: Math.round(scaleY * current_height) + 'px',
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

//show and hide the loading message
function loadingmessage(msg, show_hide){
	if(show_hide=="show"){
		$('#loader').show();
		$('#progress').show().text(msg);
		$('#uploaded_image').html('');
	}else if(show_hide=="hide"){
		$('#loader').hide();
		$('#progress').text('').hide();
	}else{
		$('#loader').hide();
		$('#progress').text('').hide();
		$('#uploaded_image').html('');
	}
}

//delete the image when the delete link is clicked.
function deleteimage(large_image, thumbnail_image){
	loadingmessage('Please wait, deleting images...', 'show');
	$.ajax({
		type: 'POST',
		url: '<?=$image_handling_file?>',
		data: 'a=delete&large_image='+large_image+'&thumbnail_image='+thumbnail_image,
		cache: false,
		success: function(response){
			loadingmessage('', 'hide');
			response = unescape(response);
			var response = response.split("|");
			var responseType = response[0];
			var responseMsg = response[1];
			if(responseType=="success"){
				$('#upload_status').show().html('<h1>Success</h1><p>'+responseMsg+'</p>');
				$('#uploaded_image').html('');
			}else{
				$('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
			}
		}
	});
}

</script>



<script type="text/javascript">

$(document).ready(function(){
    
    

    
    
   //alert('ddd'); 
  $('#uploaded_image').html('<img src="<?php echo $_REQUEST['img_res']; ?>" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" /><div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"><img src="<?php echo $_REQUEST['img_res']; ?>" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div>')
					//find the image inserted above, and allow it to be cropped
  $('#uploaded_image').find('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 



   //create the thumbnail
	$('#save_thumb').click(function() {
		var x1 = $('#x1').val();
		var y1 = $('#y1').val();
		var x2 = $('#x2').val();
		var y2 = $('#y2').val();
		var w = $('#w').val();
		var h = $('#h').val();
		if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){
			alert("You must make a selection first");
			return false;
		}else{
			//hide the selection and disable the imgareaselect plugin
			$('#uploaded_image').find('#thumbnail').imgAreaSelect({ disable: true, hide: true }); 
			loadingmessage('Please wait, saving thumbnail....', 'show');
			$.ajax({
				type: 'POST',
				url: '<?=$image_handling_file?>',
				data: 'save_thumb=Save Thumbnail&x1='+x1+'&y1='+y1+'&x2='+x2+'&y2='+y2+'&w='+w+'&h='+h,
				cache: false,
				success: function(response){
					loadingmessage('', 'hide');
					response = unescape(response);
					var response = response.split("|");
					var responseType = response[0];
					var responseLargeImage = response[1];
					var responseThumbImage = response[2];
					if(responseType=="success"){
						$('#upload_status').show().html('<h1>Success</h1><p>The thumbnail has been saved!</p>');
						//load the new images
						$('#uploaded_image').html('<img src="'+responseLargeImage+'" alt="Large Image"/>&nbsp;<img src="'+responseThumbImage+'" alt="Thumbnail Image"/><br /><a href="javascript:deleteimage(\''+responseLargeImage+'\', \''+responseThumbImage+'\');">Delete Images</a>');
						//hide the thumbnail form
						$('#thumbnail_form').hide();
					}else{
						$('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
						//reactivate the imgareaselect plugin to allow another attempt.
						$('#uploaded_image').find('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
						$('#thumbnail_form').show();
					}
				}
			});
			
			return false;
		}
	});



				       
    
});


</script>


	<div id="uploaded_image"></div>
	<div id="thumbnail_form" style="display:block;">
		<form name="form" action="" method="post">
		<input id="x1" type="hidden" value="" name="x1">
        <input id="y1" type="hidden" value="" name="y1">
        <input id="x2" type="hidden" value="" name="x2">
        <input id="y2" type="hidden" value="" name="y2">
        <input id="w" type="hidden" value="" name="w">
        <input id="h" type="hidden" value="" name="h">
			<input type="submit" name="save_thumb" value="Crop" id="save_thumb" />
		</form>
	</div>