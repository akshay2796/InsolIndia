<?php
ob_start();
include('header.php');
if(LOGGED_IN == "NO") 
{  
    $goto_url = SITE_ROOT .urlRewrite("login.php");

    header("Location: $goto_url");
   
}
define("PAGE_AJAX", "ajax_common.php");

?>

<!--script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script--> 

<script src="<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckeditor/ckeditor.js" type="text/javascript" language="javascript"></script>
<script language="javascript" type="text/javascript">
   CKEDITOR.config.toolbar_Basic =
    [
        ['Source', '-', 'Bold', 'Italic','Underline','DocProps','Preview','Cut','Copy','Paste'], 
        ['NumberedList', 'BulletedList', 'CreateDiv', 'Outdent', 'Indent'], 
        ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'],
        ['Image', 'Table', 'HorizontalRule'],
        ['ComboText', 'FontSize', 'TextColor' ]
    ];

    CKEDITOR.config.toolbar = 'Basic';

</script>
<script type="text/javascript" src="js_insol/jquery.validate-latest.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//alert("hello");
         
            
         $.validator.addMethod('chkDataText', function (data){
                if( $.trim(CKEDITOR.instances.content.getData()) == "" )
                {
                    return 0;
                }
                else
                {
                    
                    return 1;
                }
            }, ' *Content cannot be blank.'); 
            
            
		var formdata = new FormData();
        
		var img='';
		$("#mailForm").validate({
		  
			errorElement:"span",
			ignore:[],
			rules:{
				title:"required",
				content: {
                    chkDataText: true
                } 
			},
            messages:{
                title: "",
                content: "*Content cannot be blank."
            },
			submitHandler : function() {
				var formData = new FormData();
				var title = $("#title").val();
				var desc = CKEDITOR.instances['content'].getData();
                
				//alert(formData + " ========= " + title + " ==================== " + desc);
                //return false;
				$.ajax({
					type:'POST',
					url:'ajax_mail_submit.php',
                    data:{title:title,msg:desc,file:img},
                   
                    beforeSend: function() {
                        $("#sub_mail").html("");                    
                        $("#sub_mail").html("<i class='icon iconloader'></i> Processing...");
                    },
					success:function(data)
					{
					   
					//alert("console");
						//console.log(data);
						//$("#resMsg").show();
						$("#title").val('');
						$("#file").val('');
						CKEDITOR.instances['content'].setData('');
                        $("#content").val("");
						setTimeout(function() {
							//$("#resMsg").hide();
							window.location.href = "<?php echo SITE_ROOT.'thanks-contribute.php' ?>";
						 }, 500);

					}
				})
					
			} //end of submithandler
		}) //end of validate

		 $("#file").on('change',function(){
		 	
		 var total = $(this).get(0).files.length;
         
		 //var i=0;
		 	if(total>5)
		 	{
		 	    
		 		console.log("file size");
		 		$("#errupload").append("<p style='color:red;'>File Size Exceeded From Five</p>");
		 		$("#sub_mail").prop('disabled',true);
		 		return false;
		 	}
		 	else
		 	{
		 	    for(i = 0; i < total; i++) { 
                  if( $(this).get(0).files[i].size > parseInt(5242880) )
                    {
                        alert("Maximum 5MB allowed for each files");
                        return false;
                    }
                }
                
		 	    
		 		$("#errupload").hide();
		 		$("#sub_mail").prop('disabled',false);
		 		for(var i=0;i<total;i++)
		 		{
		 			formdata.append("file"+i, document.getElementById('file').files[i]);
		 			//console.log(formdata);

		 		}
		 		$.ajax({
		 			type:'POST',
		 			url:'ajax_contribute_newsletter.php',
		 			data:formdata,
		 			dataType: 'html',
		 			async:true,
		 			processData:false,
		 			contentType:false,
		 			success: function(resp)
		 			{
		 				//alert(resp);
                        $("#getIMAGE").html(resp);
		 				//console.log(resp);
		 				img=resp;
		 			},
		 			error:function(request) {
		 				console.log(request.responseText);
		 			}
		 		})
		 	}
		 })
         /////////////////////////////////////////////////////
        $.fn.deleteFILE = function() {
        var args = arguments[0] || {};  // It's your object of arguments 
        var ID = args.ID; 
        //alert(ID);
        
        var c = confirm("Are you sure you wish to delete?");
        if(c)
        {                  
            $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX; ?>",
                   data: "type=deleteIMAGE&ID=" + ID,
            	   beforeSend: function(){
            	                           
                   },
                  
                   success: function(msg){
                      $("#getIMAGE").html(msg);
                   }
                   
                   
            });
        }
                   
    };
         /////////////////////////////////////////////////////
	}) //end of main function
</script>

<style>
  .editor *{
    -webkit-box-sizing: unset;
    -ms-box-sizing: unset;
    -moz-box-sizing: unset;
    box-sizing: unset;
  }
</style>






<div class="clearfix banner">
	<div class="container">
		<h1>Contribute</h1>
	</div>
</div>

<div class="container">
	<div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'account_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
		  <h2>Contribute To Our Newsletter</h2>
          <div class="row">
            <div class="col-md-10" style="padding-right: 0px;">
                 <b>Dear Members,</b><br />
                 We are looking for active participation and engagement from you.<br />
                 If you would like to contribute with any inputs of news, articles etc please do so before the 20<sup>th</sup> of every month by filling up the following form.<br />
                 For any other queries regarding the newsletter as well, we would be happy to hear from you on <a href="mailto:newsletter@insolindia.com">newsletter@insolindia.com</a>
                 <br /><br />
            </div>
          </div>
            <div class="row">
                <div class="col-md-10" style="padding-right: 0px;">
                		<form method="post" name="mailForm" id="mailForm" enctype="multipart/form-data">
                			<div id="resMsg" class="alert alert-success" style="display: none;">Thank You For Contributing!</div>
                			<div class="form-group">
                				<label class="">Title<strong style="color: red;"> *</strong></label>
                				<input type="text" class="form-control"  name="title" id="title">
                			</div>
                
                			<div class="form-group">
                				
                				<label>Upload <img src="<?php echo MODULE_INCLUDES_ICON_RELATIVE_PATH?>doc.png" border="0" alt="doc | docx"  title="doc | docx" >&nbsp;<img src="<?php echo MODULE_INCLUDES_ICON_RELATIVE_PATH?>pdf.png" border="0" alt="pdf"  title="pdf" >&nbsp;<img src="<?php echo MODULE_INCLUDES_ICON_RELATIVE_PATH?>ImageIcon.png" border="0" alt="jpg | jpeg | png | gif"  title="jpg | jpeg | png | gif" > Files </label>
                                <div class="pull-right" style="font-size: 12px;"><strong>(Upto 5 files - Max size 5MB each)</strong></div>
                				<div id="errupload"></div>
                				<input type="file" class="form-control" name="file" id="file" accept=".jpg,.jpeg,.png,.gif,.pdf,.doc,.docx" multiple >
                			</div>
                            <div id="getIMAGE"></div>
                      
                			<div class="form-group">
                				<label>Content<strong style="color: red;"> *</strong></label>
                			<!-- 	<textarea class="ckeditor" name="content" id="content"></textarea> -->
                			<div class="editor">
                            <textarea name="content" id="content" style="width:90%; height:230px; float:left;"></textarea>
                            <script>
                                CKEDITOR.replace("content",
                                    {
                                        enterMode: 2,
                                        //extraPlugins: 'youtube',
                                        filebrowserBrowseUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/ckfinder.html',
                                        filebrowserImageBrowseUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/ckfinder.html?type=Images',
                                        filebrowserFlashBrowseUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/ckfinder.html?type=Flash',
                                        filebrowserUploadUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                        filebrowserImageUploadUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                        filebrowserFlashUploadUrl : '<?php echo SITE_ROOT.MODULE_CMS_INCLUDE; ?>ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                    } 
                                );
                            </script>
                        </div><!--fullWidth end-->
                                    
                			</div>
                			<br/>
                			<div class="form-group">
                				<button class="btn btn-warning" id="sub_mail">Send</button>
                			</div>
                		</form>
                        <div id="imgshow"></div>
                    
                </div>
            </div>

        </div>
	</div>
</div>



<?php include('footer.php'); ?>