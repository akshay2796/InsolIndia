<?php include('header.php'); 

define("PAGE_MAIN","become_member.php");
define("PAGE_AJAX","ajax_become_member.php");

//echo $_SERVER["HTTP_REFERER"];

$ref = trustme($_REQUEST['ref']);
$ckey = trustme($_REQUEST['ckey']);


if(intval($_SESSION['UID_INSOL']) > intval(0))
{
    if(trim($ref)!="")
    {
        header("location: " . SITE_ROOT .$ref.".php");
    }
    else
    {
        header("location: " . SITE_ROOT . "myaccount.php");
    }
    
}

?>

<script type="text/javascript" src="<?php echo SITE_JS;?>jquery.validate-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	
   $("#frmlogin").validate({
        errorElement:'span',
        rules: {
            login_email: {    
                required: true,
                email: true
            },
            login_password: "required"
        },
        messages: {
            login_email: {    
                required: "",
                email: ""
            },
            login_password: ""
        },
        submitHandler: function() {
            var formvalue = $("#frmlogin").serialize();
            //alert("=="+formvalue)
            //return false;
            $.ajax({
                type: "POST",
                url: "<?php echo SITE_ROOT.PAGE_AJAX; ?>",
                data: "type=login&" + formvalue,
                beforeSend: function() {
                    $("#login-btn").hide();
					$(".forgot").hide();
                    $("#login-loader").show();
                    //return false;
                },
                success: function(msg) {                    
                    
                    //alert("=="+msg)
                    
                    var spl_txt = msg.split("~~~");
                    
                    if($.trim(spl_txt[1]) == "1") 
                    {
                        
                        var ref = "<?php echo $ref; ?>";
                        
                        if(ref !='')
                        {
                            //alert("2--");
                            //if($ckey)
                            <?php
                            if(trim($ckey) !='')
                            {
                            ?>
                                location.href = "<?php echo SITE_ROOT. urlRewrite($ref.".php", array("cat_url_key" => $ckey)); ?>";
                            <?php
                            }
                            else
                            {
                            ?>
                                //location.href = "<?php echo SITE_ROOT.$ref.".php"; ?>";
                                location.href = "<?php echo SITE_ROOT. urlRewrite($ref.".php"); ?>";
                            <?php
                            }
                            ?>
                            
                        }
                        else
                        {
                           // alert("3--");
                            location.href = "<?php echo SITE_ROOT."myaccount.php"; ?>";
                        }
                       
                        return false;
                    } 
                    else 
                    {
                        $("#login-loader").hide();
                   
                        $("#login-msg").html(spl_txt[2]).show();						
						
                        $(".forgot").hide();						
                        setTimeout(function(){
                            $("#login-msg").html("").hide();							
                            $("#login-btn").show();
							$(".forgot").show();      
                        }, 2000);
                    }
                    
                    
                }
            });
        }
    });
    
    $("#frmFPass").validate({
        errorElement:'span',
        rules: {
            fpass_email: {
                email: true,
                required: true
            }
        },
        messages: {
            fpass_email: ""
        },
        submitHandler: function() {
            var formvalue = $("#frmFPass").serialize();
            
            $.ajax({
                type: "POST",
                url: "<?php echo SITE_ROOT.PAGE_AJAX; ?>",
                data: "type=forgot_password&" + formvalue,
                beforeSend: function() {
                    $("#fpass-btn").hide();
                    $(".forgot").hide();
                    $("#fpass-loader").show();
                    //return false;
                },
                success: function(msg) {                    
                    //alert(msg)
                    var spl_txt = msg.split("~~~");
                    $("#fpass-loader").hide();
                    
                    if($.trim(spl_txt[1]) == "1") 
                    {
                        $("#fpass_email").val("");
                        $("#fpass-msg").html(spl_txt[2]).show();
				        $(".forgot").hide();
                    
                        setTimeout(function(){
                            $("#fpass-msg").html("").hide();
                            $("#fpass-btn").show();
							$(".forgot").show();
                        }, 3000);
                    } 
                    else 
                    {
                        $("#fpass-msg").html("<span>"+ spl_txt[2]+ "</span>").show();
						
                        $(".forgot").hide();
                        setTimeout(function(){
                            $("#fpass-msg").html("").hide();
                            $("#fpass-btn").show();
							$(".forgot").show();       
                        }, 2000);
                    }
                    
                }
            });
        }
    });
              
    

    
});
 
function IsEmail(email) 
{
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
} 
 
       
</script>

<script type="text/javascript">	
	$(document).ready(function(){
		$('.changePass').click(function(){
			$('.loginDetail').stop().slideUp();
			$('.forgetPass').stop().slideDown();										
		});
		
		$('.loginNow').click(function(){
			$('.forgetPass').stop().slideUp();
			$('.loginDetail').stop().slideDown();										
		});	     	
	});
</script>

<div class="clearfix banner">
	<div class="container" >
    	<h1>Member Login</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page login">
    	<div class="row">
    		<div class="col-md-4">
    			<div class="row loginDetail">
					<form name="frmlogin" id="frmlogin" method="post" action="" autocomplete="off"> 
						<div class="col-sm-12">
							<div class="form-group">
								<label>Email ID  <span>*</span></label>
								<input type="text" class="form-control" name="login_email" id="login_email" maxlength="150" placeholder="">
							</div>
						</div>
						<div class="clr"></div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Password <span></span></label>
								<input type="password" class="form-control" name="login_password" id="login_password" placeholder="">
							</div>
						</div>
						<div class="clr"></div>
						<div class="col-sm-12">
							<div class="form-group">
								<span id="login-btn" ><input type="submit" class="btn btn-primary" value="Login" name="button-login"></span>
								<span id="login-loader" style="display: none;"><button type="submit" class="btn btn-primary"><i class='icon iconloader'></i> Processing...</button></span>
								<a href="#/" class="pull-right changePass" href="javascript:void(0);">Forgot your password?</a>
								<span id="login-msg" class="loginLoad errorMsg"></span>	
							</div>
						</div>
					</form>
				</div>


				<div class="row forgetPass" style="display: none;">
					<form name="frmFPass" id="frmFPass" method="POST" action="" autocomplete="off">
						<div class="col-sm-12">
							<div class="form-group">
								<h4>Submit the email address associated with us. We will email your password to you.</h4>
						   </div>
						</div>
						<div class="clr"></div>
						<div class="col-sm-12">
							<div class="form-group">
								<label>Email <span>*</span></label>
								<input type="text" value="" name="fpass_email" id="fpass_email" class="form-control" />
							</div>
						</div>
						<div class="clr"></div>
						<div class="col-sm-12">
							<div class="form-group">					       	
								<span id="fpass-btn" class="loginLoad"><input type="submit" value="Submit" class="btn btn-primary" id="button-fpass" name="button-fpass"/></span>
								<span id="fpass-loader" class="loginLoad" style="display: none;"><button type="submit" class="btn btn-primary"><i class='icon iconloader'></i> Processing...</button></span>
								<a class="pull-right loginNow" href="javascript:void(0);">Click to Login</a>&nbsp;&nbsp;
								<span id="fpass-msg" class="loginLoad errorMsg"></span>
						   </div>
						</div>

					</form>
				</div>
			</div>
			<div class="col-md-2"></div>
    		<div class="col-md-4">    			
				<h2>Become a Member</h2>
				<h3 class="subsubHead">If you would like to Become a Member of INSOL India, Please click on the button below.</h3>
				<div class="clr height15"></div>
				<a class="btn btn-primary" href="become-member.php">Enroll Now</a>
			</div>
    	
		</div>
		
				   
       
        
    </div>
</div>
<?php include('footer.php'); ?>