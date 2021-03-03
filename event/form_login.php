

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
<style>
    .centered-div {
    width: 440px;
    height: auto;
    margin: 10px;
    padding: 5px;
    /* background: blue; */
    color: white;
    margin: 0 auto;
    margin-bottom: 60px;
}
.form-box {
    margin-top: 70px;
}

.form-top {
    overflow: hidden;
    padding: 0 25px 15px 25px;
    background: #f3f3f3;
    -moz-border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0;
    text-align: left;
}
.form-top-left {
    float: left;
    width: 75%;
    padding-top: 25px;
}
.form-top-right {
    float: left;
    width: 25%;
    padding-top: 5px;
    font-size: 66px;
    color: #ddd;
    line-height: 100px;
    text-align: right;
}
.form-bottom {
    padding: 25px 25px 30px 25px;
    background: #eee;
    -moz-border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
    border-radius: 0 0 4px 4px;
    text-align: left;
}
input[type="text"], input[type="password"], input[type="date"], input[type="number"], textarea, select, textarea.form-control {
    height: 40px;
    margin: 0;
    padding: 0 14px;
    vertical-align: middle;
    background: #f2f2f2;
    border: 1px solid #ddd;
    font-family: 'Gotham', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 40px;
    color: #888;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}
.form-bottom form button.btn {
    width: 100%;
}

button.btn, button {
    height: 40px;
    margin: 0;
    padding: 0 10px;
    vertical-align: middle;
    background: #1d2644;
    border: 0;
    font-family: 'Gotham', sans-serif;
    font-size: 16px;
    font-weight: normal;
    line-height: 40px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 3px;
    text-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}
.btn {
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    cursor: pointer;
    color: #fff;
    font-family: 'Proxima Nova', sans-serif;
    font-size: 13px;
    text-transform: uppercase;
    padding: 11px 10px 7px;
    letter-spacing: 0.02em;
    transition: background .4s;
    text-decoration: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.section p a {
    text-decoration: none;
    color: #0e74b8;
    font-weight: 700!important;
    transition: opacity .4s;
}
</style>
<div class="centered-div">
                    <div class="form-box">
                        <div class="form-top" style="background-color: #23408f">
                            <div class="form-top-left">
                                <h3 style="color: white">Login</h3>
                                <!--<p style="color: #E0E0E0">Log in to your INSOL account:</p>-->
                            </div>
                            <div class="form-top-right">
                                <img src="./images/key.png">
                            </div>
                        </div>
                        <div class="form-bottom">
                            <form name="form" novalidate="" action="events.php" method="get">
                                <div class="form-group">
                                    <input type="text" name="username" placeholder="Email address" class="form-username form-control" id="username" style="width: 100%; margin-bottom: 30px" required="">

                                </div>
                                <div class="form-group">
                                    <!--<label class="sr-only" for="form-password">Password</label>-->
                                    <input type="password" name="password" placeholder="Password" class="form-password form-control" id="password" style="width: 100%; margin-bottom: 30px" required="">

                                </div>
                                <input type="submit" name="login" id="submit">
                                <br>
                                <span id="error" style="text-align: center; font-size: large; color: red"></span>
                                <p style="font-size: 15px;font-weight: bold;"><a href="#">Forgot Password?</a></p>

                                

                                <p style="font-size: 12px; line-height: 18px; margin-top: 10px; color: #939393">Not yet a member? <a href="register.php" style="font-weight: bold;">Register now</a>  to find out more about the benefits of joining us</p>
                            </form>
                        </div>
                    </div>

                </div>		
			
        
    </div>
</div>
<?php include('footer.php'); ?>