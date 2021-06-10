<?php 
error_reporting(E_ALL);
include("header.php");
define("PAGE_LIST","index.php");
define("PAGE_MAIN","change_password.php");	
define("PAGE_AJAX","ajax_changepassword.php");

?>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $.validator.addMethod("confirmck", function(value, element) { 
            if($("#newpass").val() != $("#repass").val()) { return false; } else { return true; }
        }, "Confirm Password Does not Match");

    $("#frm").validate({
        rules: { 
	          
              newpass: 
                    {
                        required: true, 
                        minlength:5 
                    },
              
              repass: 
                    {
                        required: true,
                        confirmck: true,
                        minlength:5 
                    }
	        },
            messages: { 
           	   
               newpass: 
                    {
                        required: "", 
                        minlength: " * Min 5 Digits Required" 
                    },
               repass: 
                    {
                        required: "",
                        confirmck: " *Both password do not match.",
                        minlength: " * Min 5 Digits Required" 
                    }
	        },
            
            
            submitHandler: function(form) {
                var value = $("#frm").serialize();
               //alert(value);
                $.ajax({
                   type: "POST",
                   url: "<?php echo PAGE_AJAX;?>",
                   data: "type=changepassword&"+value,
				   beforeSend: function(){
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               
                   },
                   success: function(msg){
						
                        //alert(msg);
                        ///return false;
                        
                        
                        $("#newpass").val("");
						$("#repass").val("");
						
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
                            
                            ///alert(colorStyle);
                            
                            $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                         
                            $("#inprocess").fadeOut(4500);
                            
                            
                            setTimeout(function(){
                                 
                                
                                $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' />&nbsp;<input type='button' value='Cancel' name='cancel' id='cancel' class='cancelBtn' />");
                            
                            },2000);
                            
                        
                        },2000);
                        
                         
                        
                   }
                });
            }
    	});
        
	});
	
    $('#cancel').live('click', function() { 
        location.href = "<?php echo PAGE_LIST; ?>";
    });

</script>



<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> 
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" />  
   
<h1>Change Password</h1>
<div class="addWrapper">
	
    <div class="containerPad">
         
        <div class="fullWidth noGap">
        	 
            <div class="width3 validateMsg">
                <label class="mainLabel">New Password <span>*</span></label>
                <input type="password" class="txtBox" name="newpass" id="newpass" value="" maxlength="50" AUTOCOMPLETE="OFF">
            </div> 
            
        </div>  
        <div class="fullWidth noGap">
        	 
            <div class="width3 validateMsg">
                <label class="mainLabel">Confirm Password <span>*</span></label>
                <input type="password" class="txtBox" name="repass" id="repass" value="" maxlength="50" AUTOCOMPLETE="OFF">
            </div> 
            
        </div>  
         
         
        
        
        <div id="INPROCESS" class="sbumitLoaderBox" >
            <input type="submit" value="Save" class="submitBtn" id='save' name='save' />&nbsp;<input type="button" class="cancelBtn" value="Cancel" id="cancel">             
        </div>
                                     
    </div><!--containerPad end-->
</div>            
</form> 
        
  

<?php include("footer_chitrashala.php");?>