<?php error_reporting(0);
include('header.php'); ?>

<script src="<?php echo SITE_ROOT;?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.validate-latest.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    $("#frmReg").validate({
        errorElement: "span",
        rules: {
            member_name: "required",
            firm: "required",
            numsum: "required",
            email: {
                required: true,
                email: true 
            },
            telephone: { 
                  required: true,
                  minlength: 10,
                  maxlength: 10
                }
           
        },
        messages: {
            member_name: "",
            firm: "",
            numsum: "",
            email: {
                required: "",
                email: "" 
            },
            telephone:{
                  required: "",
                  minlength: "",
                  maxlength: ""
                }
           
        },
        submitHandler: function() {

            var numsum = $("#numsum").val();
            var capRES = $("#capRES").val();
            
            //alert(numsum+"  "+capRES)
            
            if(parseInt(numsum) != parseInt(capRES)) 
            { 
                $("#errorCAP").show();
                $("#errorCAP").html("Wrong value");
                $("#errorCAP").fadeOut(5000);
                setTimeout(function(){
                    
                    $("#numsum").val("");
                }, 2000);
               
                return false; 
            } 
            else 
            { 
                //alert("--");
                $("#errorCAP").html("");
                $("#errorCAP").hide();
                //return true; 
            }
                                    

            var formvalue = $("#frmReg").serialize();
            
            $.ajax({
                type: "POST",
                url: "ajax_become_member.php",
                data: "type=newREGISTRATION&" + formvalue,
                beforeSend: function() {
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<i class='icon iconloader'></i> Processing...");
                    //return false;
                },
                success: function(msg) {
                //alert(msg);
                //return false;
                    var spl_txt = msg.split("~~~");
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {
                        setTimeout(function(){
                          $("#frmReg")[0].reset();
                          $("#frm").hide();
                          window.location.href = "<?php echo SITE_ROOT.'thankyou.php?url_key=new_registration' ?>";
                         }, 2000); 
                    
                    }else{

                      //$("#INPROCESS").html(''); 
                      $("#errorNL").show().html(" Email Already Registered");
                      $("#email").select();
                      //$("#inprocess").hide();

                      $("#errorNL").fadeOut(3000);
                              
                      setTimeout(function(){
                            $("#INPROCESS").html(''); 
                            $("#INPROCESS").html('SUBMIT'); 
                        }, 2000);  



                     /*   $("#INPROCESS_POPUP_LOADER").hide();
                        $("#INPROCESS_POPUP_MSG").show();
                        $("#INPROCESS_POPUP_MSG").html(spl_txt[2]);
                        
                        setTimeout(function(){
                            $("#INPROCESS_POPUP").show(); 
                            $("#INPROCESS_POPUP_MSG").hide();
                            $("#INPROCESS_POPUP_MSG").html("");   
                        }, 2000); */
                    }
                        
                  }
            });
            
        }
    });
});
</script>
<script type="text/javascript">
function checkNum(num)
{ 
    var w = ""; 
    var v = "0123456789"; 
    for (i=0; i < num.value.length; i++) 
    { 
    x = num.value.charAt(i); 
    if (v.indexOf(x,0) != -1) w += x; 
    } 
    num.value = w; 
}

function checkMail(chkemail)
{ 
    var email = "";
    var email = chkemail.value;

    $.ajax({
        type: "POST",
        url: "ajax_become_member.php",
        data: "type=checkEMAIL&email=" + email,
      
        success: function(msg) {
            //alert(msg);
            //return false;
            var spl_txt = msg.split("~~~");
            if( parseInt(spl_txt[1]) == parseInt(1) )
            {
                $("#errorNL").show().html("Email Already Registered");                      
                $("#email").select();
                //$("#inprocess").hide();
                $("#errorNL").delay(2000).fadeOut(1000); 
            }
         }
    });
}
        
</script>
<script>
function integerOnly(num)
{ 
    var w = ""; 
    var v = ".0123456789"; 
    for (i=0; i < num.value.length; i++) 
    { 
      x = num.value.charAt(i); 
      if (v.indexOf(x,0) != -1) w += x; 
    } 
    num.value = w; 
}
</script>
<?php
  $_SESSION["NUM1"] = rand(1,4);
  $_SESSION["NUM2"] = rand(5,9);
  
  $capVAL1 = rand(1,4);
  $capVAL2 = rand(5,9);
  $capRES = intval( intval($capVAL1) + intval($capVAL2) );
?>
<div class="clearfix banner">
	<div class="container">
    	<h1>Membership</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'membership_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<h2>Become a Member</h2>
          	<div class="row">
				<div class="col-md-9" style="padding-right: 30px;">
					<h3 class="subsubHead">If you would like to Become a Member of INSOL India, Please send us a request by filling the following details.</h3>
					<br>
					<div class="row">
					<form action="" name="frmReg" id="frmReg">
					<div class="col-sm-4">
						<div class="form-group">
							<label>First Name <span>*</span></label>
							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Middle Name <span></span></label>
							<input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Last Name <span>*</span></label>
							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="">
						</div>
					</div>
							
					<div class="col-md-12">
						<div class="form-group">
							<label>Address<span>*</span></label>
							<textarea class="form-control" rows="2" name="address" id="address"></textarea>
						</div>					
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label>City<span>*</span></label>
							<input type="text" class="form-control" name="city" id="city" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Country<span>*</span></label>
							<input type="text" class="form-control" name="country" id="country" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Pin<span>*</span></label>
							<input type="text" class="form-control" name="pin" id="pin" placeholder="">
						</div>
					</div>
					
					<div class="col-sm-4">
						<div class="form-group">
							<label>Telephone<span>*</span></label>
							<input type="text" class="form-control" name="telephone" id="telephone" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Mobile<span>*</span></label>
							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="">
						</div>
					</div>
					<div class="col-sm-4">
						<div class="form-group">
							<label>Email<span>*</span></label>
							<input type="text" class="form-control" name="email" id="email" placeholder="">
						</div>
					</div>
					
					<div class="clr"></div>
					<div class="hrline"></div>	
					<div class="col-md-12">
						<div class="form-group">
							<label><h4 class="bluetxt">I am</h4></label>
							<div class="row">
								<div class="clr"></div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Chartered Accountant" name="i_am[]" id="i_am[]" > Chartered Accountant
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Advocate" name="i_am[]" id="i_am[]" > Advocate
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Advocate" name="i_am[]" id="i_am[]"> Company Secretary
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Judge" name="i_am[]" id="i_am[]"> Judge
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Member of NCLT" name="i_am[]" id="i_am[]"> Member of NCLT
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Acedemic" name="i_am[]" id="i_am[]"> Acedemic
									</label>
								</div>
								<div class="col-md-4">
									<label>
										<input type="checkbox" value="Other" name="i_am[]" id="i_am[]"> Other
									</label>
								</div>
								<div class="clr"></div>
								<div class="col-md-4" style="display: none1">
									<div class="form-group">
										<input type="text" class="form-control" name="member_name" id="member_name" placeholder="Please Specify">
									</div>
								</div>
								
							</div>
						</div>					
					</div>
					<div class="hrline"></div>
					<div class="clr"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label><h4 class="bluetxt"><input type="checkbox"> I am Insolvency Professional with </h4></label>
							<div class="row">
								<div class="clr"></div>
								<div class="col-md-6">
									<label>please specify the name of Insolvency Professional Agency</label><input type="text" class="form-control" name="" id="" placeholder="">
								</div>
								<div class="col-md-6">
									<label><br>On number is<br></label><input type="text" class="form-control" name="" id="" placeholder="">
								</div>
							</div>
						</div>					
					</div>
					<div class="hrline"></div>
					<div class="clr"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label><h4 class="bluetxt"><input type="checkbox"> I am Insolvency Professional with Insolvency and Bankruptcy Board of India.</h4></label>
							<div class="row">
								<div class="clr"></div>
								<div class="col-md-12">
									<label>My registration number is</label><input type="text" class="form-control" name="" id="" placeholder="">
								</div>
							</div>
						</div>					
					</div>
					<div class="hrline"></div>
					<div class="clr"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label><h4 class="bluetxt"><input type="checkbox"> I am a Young Practitioner. I confirm I have less than ten years experience in my profession mentioned in column 1. </h4></label>
							<div class="row">
								<div class="clr"></div>
								<div class="col-md-12">
									<label>My date of enrolment with my professional body is</label><input type="text" class="form-control" name="" id="" placeholder="">
								</div>
							</div>
						</div>					
					</div>
					<div class="hrline"></div>
					<div class="clr"></div>
					<div class="col-md-12">
						<div class="form-group">
							<label><h4 class="bluetxt">I am interested in becoming a member of INSOL India because </h4></label>
							<div class="row">
								<div class="clr"></div>
								<div class="col-md-12">
									<textarea class="form-control" rows="2" name="address" id="address"></textarea>
								</div>
							</div>
						</div>					
					</div>
					<div class="hrline"></div>
					<div class="clr"></div>
					
					<div class="col-md-12">
						<div class="form-group">
							<label><input type="checkbox"> I have read and understood the terms and conditions of membership, accept and undertake to abide them.</label>
						</div>					
					</div>
					
					<div class="col-md-12">
						<div class="form-group">
							<label><input type="checkbox"> I am committed to develop the reputation and stature if insolvency profession. (Applicable to Insolvency, turnaround and restructuring professionals)</label>
						</div>					
					</div>
					<div class="col-xs-12">
						<div class="form-inline">
							
							 <div class="form-group">
								  <div class="input-group">
									<div class="input-group-addon">
									  <span><?php echo $capVAL2; ?></span>
									   <span>+</span>
									   <span><?php echo $capVAL1; ?></span>
									   <span>=</span>

									</div>
									<input type="text" value="" maxlength="2" name="numsum" id="numsum" class="form-control" onblur="integerOnly(this)" autocomplete="OFF" style="width:75px;"/>
								  </div>

							 </div>
						</div>	
					</div>
					<div class="col-xs-6"><span class="" style="color: red;" id="errorCAP"></span></div>
					<div class="clr height15"></div>
					<div class="col-md-6">
						<div class="form-group">
						<button type="submit" class="btn btn-primary" id="INPROCESS">Submit</button>
						</div>
					</div>
					<div class="col-md-6"></div>
			
			
			
			
				</form>
					</div>
					
				</div>
				<div class="col-md-3 pull-right" style="border-left: 1px solid #ccc; padding-left: 30px;">
					
					<h3 class="subsubHead">You can also download the membership form and send it to INSOL India office.</h3>
					<br>
					<a href="<?php echo SITE_ROOT ?>downloads/form.pdf" target="_blank" class="btn btn-primary">Download Form</a>
					
                    
                    
				</div>          	
			</div>
           
           
           
        </div>
    </div>
</div>
<?php include('footer.php'); ?>