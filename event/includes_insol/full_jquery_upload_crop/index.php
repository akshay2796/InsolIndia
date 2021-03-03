<?php
error_reporting (E_ALL ^ E_NOTICE);
/*
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* "Jquery image upload & crop for php"
* Date: 2008-11-21
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
*/
#################################################################################################
#	Include the image functions - adjust directory as required								   	#
#	Please also adjust the directory to this file in the "image_handling.php" page				#
	include("image_functions.php");			 						#
#################################################################################################
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="generator" content="WebMotionUK" />
	<title>Jquery image upload &amp; crop with PHP</title>

    <script type="text/javascript" src="js/jquery-1.10.1.min.js"></script>
   	<!--script type="text/javascript" src="js/jquery-pack.js"></script-->
    
	<script type="text/javascript" src="js/jquery.imgareaselect.min.js"></script>
	<script type="text/javascript" src="js/jquery.ocupload-packed.js"></script>
</head>
<body>
<!-- 
* Copyright (c) 2008 http://www.webmotionuk.com / http://www.webmotionuk.co.uk
* "Jquery image upload & crop for php"
* Date: 2008-11-21
* Ver 1.0
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND 
* ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED 
* WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. 
* IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, 
* INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF 
* THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* http://www.opensource.org/licenses/bsd-license.php
-->
 <script language="javascript" type="text/javascript" src="colorbox/jquery.colorbox.js"></script>
 <link rel="stylesheet" type="text/css" media="screen" href="colorbox/colorbox.css" />

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



$(document).ready(function () {
		$('#loader').hide();
		$('#progress').hide();
		var myUpload = $('#upload_link').upload({
		   name: 'image',
		   action: '<?=$image_handling_file?>',
		   enctype: 'multipart/form-data',
		   params: {upload:'Upload'},
		   autoSubmit: true,
		   onSubmit: function() {
		   		$('#upload_status').html('').hide();
				loadingmessage('Please wait, uploading file...', 'show');
		   },
		   onComplete: function(response) {
		   		loadingmessage('', 'hide');
				response = unescape(response);
				var response = response.split("|");
				var responseType = response[0];
				var responseMsg = response[1];
				if(responseType=="success"){
				    
                    
					var current_width = response[2];
					var current_height = response[3];
                    //alert(current_width+"==="+current_height);
					//display message that the file has been uploaded
					//$('#upload_status').show().html('<h1>Success</h1><p>The image has been uploaded</p>');
					//put the image in the appropriate div
					//$('#uploaded_image').html('<img src="'+responseMsg+'" style="float: left; margin-right: 10px;" id="thumbnail" alt="Create Thumbnail" /><div style="border:1px #e5e5e5 solid; float:left; position:relative; overflow:hidden; width:<?php echo $thumb_width;?>px; height:<?php echo $thumb_height;?>px;"><img src="'+responseMsg+'" style="position: relative;" id="thumbnail_preview" alt="Thumbnail Preview" /></div>')
					//find the image inserted above, and allow it to be cropped
					//$('#uploaded_image').find('#thumbnail').imgAreaSelect({ aspectRatio: '1:<?php echo $thumb_height/$thumb_width;?>', onSelectChange: preview }); 
				       $.colorbox({ 
                         width:"80%", 
                         height:"100%", 
                         iframe:true, 
                         href: "crop_image.php?img_res="+responseMsg,
                         onClosed:function(){ 
                           
                         }  
                      });
                   
                
                
                	//display the hidden form
					$('#thumbnail_form').show();
				}else if(responseType=="error"){
					$('#upload_status').show().html('<h1>Error</h1><p>'+responseMsg+'</p>');
					$('#uploaded_image').html('');
					$('#thumbnail_form').hide();
				}else{
					$('#upload_status').show().html('<h1>Unexpected Error</h1><p>Please try again</p>'+response);
					$('#uploaded_image').html('');
					$('#thumbnail_form').hide();
				}
		   }
		});
	
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


//]]>
</script>



	<h2>Upload Photo</h2>
	<div id="upload_status" style="font-size:12px; width:80%; margin:10px; padding:5px; display:none; border:1px #999 dotted; background:#eee;"></div>
	<p><a id="upload_link"  href="#">Browse</a></p>
	<span id="loader" style="display:none;"><img src="loader.gif" alt="Loading..."/></span> <span id="progress"></span>
	<br />


<!-- Copyright (c) 2008 http://www.webmotionuk.com -->
</body>
</html>
