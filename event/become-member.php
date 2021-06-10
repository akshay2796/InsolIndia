<?php error_reporting(E_ALL);
include('header.php'); ?>

<script src="<?php echo SITE_ROOT;?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.validate-latest.js"></script>
<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    
    $.validator.addMethod('ck_permanent_address', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_address").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_permanent_address_2', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_address_2").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_permanent_city', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_city").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_permanent_state', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_state").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_permanent_country', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_country").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_permanent_pin', function (data)
    {
       if ( $('#address_check').prop("checked")==true  && $.trim($("#permanent_pin").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    $.validator.addMethod('ck_other_i_am', function (data)
    {
       if ( $.trim($("#i_am_chkvalue").val()) == "Other" && $.trim($("#other_i_am").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 

    
    $.validator.addMethod('ck_insolvency', function (data)
    {
       if ( $('#insolvency_professional').prop("checked")==true  && $.trim($("#insolvency_professional_agency").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 
    
    $.validator.addMethod('ck_insolvency_no', function (data)
    {
       if ( $('#insolvency_professional').prop("checked")==true  && $.trim($("#insolvency_professional_number").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 
    
    
    $.validator.addMethod('ck_registered', function (data)
    {
       if ( $('#registered_insolvency_professional').prop("checked")==true  && $.trim($("#registered_insolvency_professional_number").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 
    
    $.validator.addMethod('ck_young', function (data)
    {
       if ( $('#young_practitioner').prop("checked")==true  && $.trim($("#young_practitioner_enrolment").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, ''); 
    
    $.validator.addMethod('ck_sig', function (data)
    {
       if ( $('#sig_member').prop("checked")==true  && $.trim($("#sig_company_id").val()) == "" )
       {
            return false;                    
       }
       else
       {
            return true;
       }
    }, '');
    
    
    $("#frmReg").validate({
        errorElement:'span',
        errorPlacement: function( error , element ){
            if( element.attr('name') == 'i_am[]' ){
                error.appendTo("#i_am_error");
            }
            else if( element.attr('name') == 'terms' ){
                error.appendTo("#terms_error");
            }
            else if( element.attr('name') == 'committed' )
            {
                error.appendTo("#committed_error");
            }
        },
         
        ignore:[],
        rules: {
        	title: "required",
            first_name: "required",
            last_name: "required",
            firm_name: "required",
            address: "required",
            correspondence_address_2: "required",
            city: "required",
            correspondence_state: "required",
            country: "required",
            pin: "required",
            permanent_address: {
                ck_permanent_address: true
            },
            permanent_address_2: {
                ck_permanent_address_2: true
            },
            permanent_city: {
                ck_permanent_city: true
            },
            permanent_state: {
                ck_permanent_state: true
            },
            permanent_country: {
                ck_permanent_country: true
            },
            permanent_pin: {
                ck_permanent_pin: true
            },
            mobile: { 
                  required: true,
                  minlength: 10
                },
            email: {
                required: true,
                email: true 
            },
            'i_am[]':{
                required:true,
                minlength:1
            },
            other_i_am: {
                ck_other_i_am: true
            },
            /*insolvency_professional_agency: {
                ck_insolvency: true
            },*/
            insolvency_professional_agency: "required",
            /*insolvency_professional_number: {
                ck_insolvency_no: true
            }, */
            insolvency_professional_number: "required",
            registered_insolvency_professional_number: {
                ck_registered: true
            },
            young_practitioner_enrolment: {
                ck_young: true
            },
            
            sig_company_id: {
                ck_sig: true
            },
            
            interested: "required",
            
            terms:{
                required:true
            },
            /*committed:{
                required:true
            },
            */
            numsum: "required"
           
        },
        messages: {
        	title: "",
            first_name: "",
            last_name: "",
            firm_name: "",
            address: "",
            correspondence_address_2: "",
            city: "",
            correspondence_state: "",
            country: "",
            pin: "",
            permanent_address: "",
            permanent_address_2: "",
            permanent_city: "",
            permanent_state: "",
            permanent_country: "",
            permanent_pin: "",
            mobile: {
                  required: "",
                  minlength: ""
                },
            email: {
                required: "",
                email: "" 
            },
            'i_am[]':' Please check any one',
            other_i_am: "",
            insolvency_professional_agency: "",
            insolvency_professional_number: "",
            registered_insolvency_professional_number: "",
            young_practitioner_enrolment: "",
            sig_company_id: "",
            interested: "",
            terms:" Please agree to our terms",
            //committed:" Please check",
            numsum:""
           
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
                data: "type=saveData&" + formvalue,
                beforeSend: function() {
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<i class='icon iconloader'></i> Processing...");
                },
                success: function(msg) {
                    //alert(msg);
                    //return false;
                    var spl_txt = msg.split("~~~");
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {
                        setTimeout(function(){
                            $("#frmReg")[0].reset();
                            window.location.href = "<?php echo SITE_ROOT.'thankyou.php?ty=member' ?>";
                        }, 2000);   
                    }
                    else
                    {
                        $("#register-msg").html(spl_txt[2]).show();
                        
                        $("#INPROCESS").show().html(spl_txt[2]);
                        $("#email").select();
                        $("#errorNL").fadeOut(3000);
                              
                        setTimeout(function(){
                            $("#INPROCESS").html(''); 
                            $("#INPROCESS").html('SUBMIT'); 
                        }, 2000);  


                    }
                        
                  }
            });
            
        }
    });
    
    
    
    $(".i_am").click(function(){
        
        var val = $(this).attr("value");
      
        if(val =='Other' && $(this).prop("checked")==true)
        {
            $("#otherIm").show();
            $("#i_am_chkvalue").val("Other"); 
        }
        else if(val =='Other' && $(this).prop("checked")==false)
        {
            $("#other_i_am").val(""); 
            $("#i_am_chkvalue").val(""); 
            $("#otherIm").hide(); 
        }
   });
    
   //for sig
   
   $("#sig_member").click(function(){
    var val1 = $(this).attr("value");
    if($(this).prop("checked") == true){
        $("#showSIG").show();
    }
    else if($(this).prop("checked") == false){
        $("#showSIG").hide();
    }
    
   });
   
   //for address checkbox
   
    $("#address_check").click(function(){
    var val1 = $(this).attr("value");
    if($(this).prop("checked") == true){
        $('#showAddressPermanent').show();
      
    }
    else if($(this).prop("checked") == false){
         $('#showAddressPermanent').hide();
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
<script>
$(document).ready(function(){
    $(function(){
        $("#first_name").blur(function(){

            this.value = this.value.toLowerCase();
        });

        $("#middle_name").blur(function(){

            this.value = this.value.toLowerCase();
        });
        
        $("#last_name").blur(function(){

            this.value = this.value.toLowerCase();
        });
    });
});
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
				<div class="col-md-10" style="padding-right: 0px;">
					<h3 class="subsubHead">If you would like to Become a Member of INSOL India, Please send us a request by filling the following details.</h3>
					<br>
					<div class="row">
    					<form action="" name="frmReg" id="frmReg">
                        <div class="col-md-12">
                            <h4>Basic Detail</h4>
                        </div>
                        <div class="col-md-4">
    						<div class="form-group">
    							<label>Title  <span>*</span></label>
    							<select class="form-control" name="title" id="title">
    								<option value="">Select Title</option>
                                    <option value="Mr.">Mr.</option>
                                    <option value="Ms.">Ms.</option>
                                    <option value="Mrs.">Mrs.</option>
                                    <option value="Dr.">Dr.</option>
                                    <option value="Prof.">Prof.</option>
                                                                        
                                </select>
    						</div>					
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>First Name <span>*</span></label>
    							<input type="text" class="form-control" name="first_name" id="first_name" placeholder="" maxlength="100" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Middle Name <span></span></label>
    							<input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="" maxlength="50" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Last Name <span>*</span></label>
    							<input type="text" class="form-control" name="last_name" id="last_name" placeholder="" maxlength="50" style="text-transform:capitalize" >
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Suffix</label>
    							<input type="text" class="form-control" name="suffix" id="suffix" placeholder="" maxlength="50" >
    						</div>
    					</div>
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>Firm <span>*</span></label>
    							<input type="text" class="form-control" name="firm_name" id="firm_name" placeholder="" maxlength="100" >
    						</div>
    					</div>
    					
    					<div class="clr"></div>
    					<div class="hrline"></div>	
                        <div class="col-md-12">
                            <h4>Correspondence address</h4>
                        </div>		
    					<div class="col-md-12">
    						<div class="form-group">
    							<label>Address 1  <span>*</span></label>
    							<textarea class="form-control" rows="1" name="address" id="address"></textarea>
    						</div>					
    					</div>
                        <div class="col-md-12">
    						<div class="form-group">
    							<label>Address 2  <span>*</span></label>
    							<textarea class="form-control" rows="1" name="correspondence_address_2" id="correspondence_address_2"></textarea>
    						</div>					
    					</div>
                      	
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>City <span>*</span></label>
    							<input type="text" class="form-control" name="city" id="city" placeholder="" maxlength="50">
    						</div>
    					</div>
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>State <span>*</span></label>
    							<input type="text" class="form-control" name="correspondence_state" id="correspondence_state" placeholder="" maxlength="50">
    						</div>
    					</div>
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>Pin <span>*</span></label>
    							<input type="text" class="form-control" name="pin" id="pin" placeholder="" maxlength="10" onkeyup="integerOnly(this)">
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Country <span>*</span></label>
    							<input type="text" class="form-control" name="country" id="country" placeholder="" maxlength="50">
    						</div>
    					</div>
    					
                        
    					<div class="clr"></div>
    					<div class="hrline"></div>	
                        <div class="col-md-12">
                                <h4>Permanent Address <input type="checkbox" value="1" name="address_check" id="address_check"/> <span style="color: #2B3481; font-size: 15px;">(Check if different from correspondence address)</span></h4>
                            </div>
                        <div id="showAddressPermanent" style="display: none;">
                            
                                <div class="col-md-12">
                                
            						<div class="form-group">
            							<label>Address 1  <span>*</span></label>
            							<textarea class="form-control" rows="1" name="permanent_address" id="permanent_address"></textarea>
            						</div>					
            					</div>
                                <div class="col-md-12">
            						<div class="form-group">
            							<label>Address 2  <span>*</span></label>
            							<textarea class="form-control" rows="1" name="permanent_address_2" id="permanent_address_2"></textarea>
            						</div>					
            					</div>
                                
                                <div class="col-sm-4">
            						<div class="form-group">
            							<label>City <span>*</span></label>
            							<input type="text" class="form-control" name="permanent_city" id="permanent_city" placeholder="" maxlength="50">
            						</div>
            					</div>
                                <div class="col-sm-4">
            						<div class="form-group">
            							<label>State <span>*</span></label>
            							<input type="text" class="form-control" name="permanent_state" id="permanent_state" placeholder="" maxlength="50">
            						</div>
            					</div>
                                <div class="col-sm-4">
            						<div class="form-group">
            							<label>Pin <span>*</span></label>
            							<input type="text" class="form-control" name="permanent_pin" id="permanent_pin" placeholder="" maxlength="10" onkeyup="integerOnly(this)">
            						</div>
            					</div>
            					<div class="col-sm-4">
            						<div class="form-group">
            							<label>Country <span>*</span></label>
            							<input type="text" class="form-control" name="permanent_country" id="permanent_country" placeholder="" maxlength="50">
            						</div>
            					</div>
            					
                                
                        </div>
                        <div class="clr"></div>
    					<div class="hrline"></div>	
                        <div class="col-md-12">
                            <h4>Communication Detail</h4>
                        </div>	
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>Mobile <span>*</span></label>
    							<input type="text" class="form-control" name="mobile" id="mobile" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
    						</div>
    					</div>
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
    							<input type="text" class="form-control" name="email" id="email" placeholder="">
    						</div>
    					</div>	
    					<div class="col-sm-4">
    						<div class="form-group">
    							<label>Correspondence Landline </label>
    							<input type="text" class="form-control" name="telephone" id="telephone" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
    						</div>
    					</div>
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>Residence Landline </label>
    							<input type="text" class="form-control" name="residence_telephone" id="residence_telephone" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
    						</div>
    					</div>
                        
                        <div class="col-sm-4">
    						<div class="form-group">
    							<label>Fax </label>
    							<input type="text" class="form-control" name="fax" id="fax" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
    						</div>
    					</div>
    					
                        <div class="clr"></div>
    					<div class="hrline"></div>
    					<div class="col-md-12">
                        
                            <h4>PROFESSIONAL  DETAILS</h4>
                        
    						<div class="form-group">
    							<label><h4 class="bluetxt">I am <span>*</span></h4></label>&nbsp;<span id="i_am_error" ></span>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Chartered Accountant" name="i_am[]" id="i_am[]" class='i_am'/> Chartered Accountant
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Cost Accountant" name="i_am[]" id="i_am[]" class='i_am'/> Cost Accountant
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Advocate" name="i_am[]" id="i_am[]" class='i_am'/> Advocate
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Company Secretary" name="i_am[]" id="i_am[]" class='i_am'/> Company Secretary
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Judge" name="i_am[]" id="i_am[]" class='i_am'/> Judge
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Member of NCLT" name="i_am[]" id="i_am[]" class='i_am'/> Member of NCLT
    									</label>
    								</div>
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Academic" name="i_am[]" id="i_am[]" class='i_am'/> Academic
    									</label>
    								</div> 
    								<div class="col-md-4">
    									<label>
    										<input type="checkbox" value="Other" name="i_am[]" id="i_am[]" class='i_am'/> Other
    									</label>
    								</div>
    								<div class="col-md-4" style="display: none" id="otherIm">
    									<div class="form-group">
    										<input type="text" class="form-control" name="other_i_am" id="other_i_am" placeholder="Please Specify">
                                            <input type="hidden" class="form-control" name="i_am_chkvalue" id="i_am_chkvalue" style="display: none;">
    									</div>
    								</div>
    							</div>
    						</div>					
    					</div>
    					<div class="hrline"></div>
    					<div class="clr"></div>
    					<div class="col-md-12">
    						<div class="form-group">
    							<label><h4 class="bluetxt"><!--input type="checkbox" value="1" name="insolvency_professional" id="insolvency_professional"/ --> I am Insolvency Professional registered with <span>*</span></h4></label>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-6">
    									<label>please specify the name of Insolvency Professional Agency</label><input type="text" class="form-control" name="insolvency_professional_agency" id="insolvency_professional_agency" placeholder="">
    								</div>
    								<div class="col-md-6">
    									<label><br>My registration number is<br></label><input type="text" class="form-control" name="insolvency_professional_number" id="insolvency_professional_number" placeholder="">
    								</div>
    							</div>
    						</div>					
    					</div>
    					<div class="hrline"></div>
    					<div class="clr"></div>
    					<div class="col-md-12">
    						<div class="form-group">
    							<label><h4 class="bluetxt"><input type="checkbox" value="1" name="registered_insolvency_professional" id="registered_insolvency_professional"> I am registered Insolvency Professional with Insolvency and Bankruptcy Board of India.</h4></label>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-12">
    									<label>My registration number is</label><input type="text" class="form-control" name="registered_insolvency_professional_number" id="registered_insolvency_professional_number" placeholder="">
    								</div>
    							</div>
    						</div>					
    					</div>
    					<div class="hrline"></div>
    					<div class="clr"></div>
    					<div class="col-md-12">
    						<div class="form-group">
    							<label><h4 class="bluetxt"><input type="checkbox" value="1" name="young_practitioner" id="young_practitioner"> I am a Young Practitioner. I confirm I have less than ten years experience in my profession mentioned above. </h4></label>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-12">
    									<label>My date of enrolment with my professional body is</label><input type="text" class="form-control" name="young_practitioner_enrolment" id="young_practitioner_enrolment" placeholder="">
    								</div>
    							</div>
    						</div>					
    					</div>
                        <div class="hrline"></div>
    					<div class="clr"></div>
    					<div class="col-md-12">
    						<div class="form-group">
    							<label><h4 class="bluetxt"><input type="checkbox" value="1" name="sig_member" id="sig_member"> I am an SIG 24 Member. </h4></label>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-12" id="showSIG" style="display: none;">
                                        <?php 
                                            $SQL = "SELECT sig24_id, company_name FROM ".SIG24_TBL. " WHERE status = 'ACTIVE' ";
                                            $sGET = $dCON->prepare( $SQL );
                                            $sGET->execute();
                                            $rsGET = $sGET->fetchAll();
                                            $sGET->closeCursor();
                                            if(intval(count($rsGET)) > intval(0))
                                            {
                                        ?>
            									<select name="sig_company_id" id="sig_company_id"  class="form-control" style="width: 441px;">
                                                        <option value="">Select Company</option>
                                                    <?php
                                                        foreach($rsGET as $sVAL)
                                                        {
                                                            $company_name = stripslashes($sVAL['company_name']);
                                                            $company_id = stripslashes($sVAL['sig24_id']);
                                                    ?>
                                                            <option value="<?php echo $company_id; ?>"><?php echo $company_name; ?></option>
                                                
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                        <?php
                                            }
                                        ?>
    								</div>
    							</div>
    						</div>					
    					</div>
    					<div class="hrline"></div>
    					<div class="clr"></div>
    					<div class="col-md-12">
    						<div class="form-group">
    							<label><h4 class="bluetxt">I am interested in becoming a member of INSOL India because <span>*</span></h4></label>
    							<div class="row">
    								<div class="clr"></div>
    								<div class="col-md-12">
    									<textarea class="form-control" rows="2" name="interested" id="interested"></textarea>
    								</div>
    							</div>
    						</div>					
    					</div>
    					<div class="hrline"></div>
    					<div class="clr"></div>
    					
    					<div class="col-md-12">
    						<div class="form-group">
                                <label><input type="checkbox" value="1" name="terms" id="terms"/> I confirm that the information provided in this form is true and correct.</label>
				                <div id="terms_error"></div>
                            </div>					
    					</div>
    					
    					<!--div class="col-md-12">
    						<div class="form-group">
    							<label><input type="checkbox" value="1" name="committed" id="committed"/> I am committed to develop the reputation and stature if insolvency profession. (Applicable to Insolvency, turnaround and restructuring professionals)</label>
                                <div id="committed_error"></div>
                            </div>					
    					</div-->
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
                                        
                                        &nbsp;<span class="" style="color: red;" id="errorCAP"></span>
                                        
    								    <input type="hidden" name="capRES" id="capRES" value="<?php echo $capRES; ?>" readonly='' style="display:none"/>  
                                    </div>
                                </div>
                            </div>	
                        </div>
    					<div class="col-xs-6"></div>
    					<div class="clr height15"></div>
    					<div class="col-md-12">
                            <div style="color:#B71D21">Please fill the form as per requirements and irrelevant sections may be filled as not applicable or N/A. </div>
                        </div>
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
				<!--div class="col-md-3 pull-right" style="border-left: 1px solid #ccc; padding-left: 30px;">
					<h3 class="subsubHead">You can also download the membership form and send it to INSOL India office.</h3>
					<br>
					<a href="<?php //echo SITE_ROOT ?>downloads/form.pdf" target="_blank" class="btn btn-primary">Download Form</a>
                </div-->          	
			</div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>