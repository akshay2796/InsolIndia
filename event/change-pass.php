<?php 
ob_start();
include "header.php"; 
include("checklogin.php");

define("PAGE_MAIN","change-pass.php");
define("PAGE_AJAX", "ajax_common.php");

?>         
<script type="text/javascript" src="<?php echo SITE_JS;?>jquery.validate-latest.js"></script>

<script type="text/javascript">
	
$(document).ready(function(){
	
   
            
    //////////////////////////////
    $("#frm").validate({
        errorElement:'span',
        rules: {
            oldpass: {
                required: true,
                minlength:5 
            },
            newpass: {
                required: true,
                minlength:5 
            },
            repass: {
                required: true,
                minlength:5 
            }
            
        },
        messages: {
            oldpass: {
                required: "",
                minlength: " * Min 5 Digits Required" 				
            },
            newpass: {
                required: "",
                minlength: " * Min 5 Digits Required" 				
            },
            repass:{
                required: "",
                minlength: " * Min 5 Digits Required" 
            }
        },
        submitHandler: function() {
            
            if($("#newpass").val() != $("#repass").val()) 
            { 
                $("#login-msg").html("Confirm Password Does not Match").show();
                
                setTimeout(function(){
                    $("#login-msg").html("").hide();							
                }, 2000);
                
                return false; 
            } 
            else 
            { 
                $("#login-msg").html("").hide();
            }
             
            var formvalue = $("#frm").serialize();
            
            $.ajax({
                type: "POST",
                url: "<?php echo SITE_ROOT.PAGE_AJAX; ?>",
                data: "type=changePass&" + formvalue,
                beforeSend: function() {
                    $("#login-btn").hide();
                    $("#login-loader").show();
                    //return false;
                },
                success: function(msg) {                    
                    
                    //alert(msg)
                    var spl_txt = msg.split("~~~");
                    
                    if( parseInt(spl_txt[1]) == parseInt(1) ) 
                    {
                        $("#login-loader").hide();
                        $("#login-msg").html(spl_txt[2]).show();
                        
                        setTimeout(function(){
                            $("#oldpass").val("");
    			            $("#newpass").val("");
    			            $("#repass").val("");
                            
                            $("#login-msg").html("").hide();							
                            $("#login-btn").show();
                               
                        },2000);  
                        
                    } 
                    else 
                    {
                        $("#login-loader").hide();
                        $("#login-msg").html(spl_txt[2]).show();						
                        setTimeout(function(){
                            $("#login-msg").html("").hide();							
                            $("#login-btn").show();
				        }, 2000);
                    }
                    
                    
                }
            });
        }
    });
    
    
    	
});
</script>


<div class="clearfix banner">
	<div class="container" >
    	<h1>Change Password</h1>
    </div>
</div>        
      
<div class="container">
   
   <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'account_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
			  <div class="row">        
				<div class="col-md-6">           
					<form name="frm" id="frm" class="form-horizontal form-style login-form login-form" method="post" action="" autocomplete="off">              
						<div class="form-group">
							<label class="col-xs-1 control-label"><i class="fa fa-lock fa-fw" aria-hidden="true" style="font-size: 24px; color: #2E3391;"></i></label>
							<div class="col-xs-11">
								<input type="Password" class="form-control" placeholder="Old Password" name="oldpass" id="oldpass" value="" maxlength="20" autocomplete="off"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-1 control-label"><i class="fa fa-lock fa-fw" aria-hidden="true" style="font-size: 24px; color: #2E3391;"></i></label>
							<div class="col-xs-11">
								<input type="Password" class="form-control" placeholder="New Password" name="newpass" id="newpass" value="" maxlength="20" autocomplete="off"/>
							</div>
						</div>

						<div class="form-group">
							<label class="col-xs-1 control-label"><i class="fa fa-lock fa-fw" aria-hidden="true" style="font-size: 24px; color: #2E3391;"></i></label>
							<div class="col-xs-11">
								<input type="password" class="form-control" placeholder="Confirm Password " name="repass" value="" id="repass" maxlength="20"/>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-1">

							</div>
							<div class="col-sm-11">
								<span id="login-msg" class="loginMsg errorMsg pull-right"></span> 
								<div id="login-btn">
									<input type="submit" value="Submit" id="button-login" name="button-login"  class="btn btn-primary"/>
								</div>

								<div id="login-loader" style="display: none;">
									<button type="submit" class="btn btn-primary"><i class='icon iconloader'></i> <img src='<?php echo SITE_IMAGES; ?>loader.gif' align='absmidlle' border='0'/> Processing...</button>
								</div>

							</div>                  
						</div>            
					</form>
				 </div>


			</div>
           
           
        </div>
    </div>
   
</div><!-- inner content end -->
      
<?php include "footer.php"; ?>   
















