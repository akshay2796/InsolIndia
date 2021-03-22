<?php 
error_reporting(0);
include("header.php");


define("PAGE_MAIN","become_member_edit.php"); 
define("PAGE_AJAX","ajax_become_member.php");
define("PAGE_LIST","become_member_list.php"); 


$member_id = (int)trim($_REQUEST["id"]);
 	
if (intval($member_id) > intval(0))
{
	$con = "modify";
	
	$stmt = $dCON->prepare("select * from ".BECOME_MEMBER_TBL." where member_id <> '' and member_id = ?");
	$stmt->bindParam(1,$member_id);
	$stmt->execute();
	$rsGET = $stmt->fetchAll();
    
	if(intval(count($rsGET))>intval(0))
	{
	   /*
		$member_id = stripslashes($rsGET[0]["member_id"]);
        $reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);
        $reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);
               
        $reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);
        $reg_number = stripslashes($rsGET[0]["reg_number"]);
        
        $first_name = stripslashes($rsGET[0]["first_name"]);
        $middle_name = stripslashes($rsGET[0]["middle_name"]);
        $last_name = stripslashes($rsGET[0]["last_name"]);
        
        $name = $first_name;
        if($middle_name !='')
        {
            $name = $name." ".$middle_name;
        }
        $name = $name." ".$last_name;
        
        
        $address = stripslashes($rsGET[0]["address"]);
        $city = stripslashes($rsGET[0]["city"]);
        $country = stripslashes($rsGET[0]["country"]);
        $pin = stripslashes($rsGET[0]["pin"]);
        
        $full_address = $address;
        $full_address = $full_address .", ".$city;
        $full_address = $full_address .", ".$country;
        if($pin !='')
        {
            $full_address = $full_address ." - ".$pin;
        }
        $telephone = stripslashes($rsGET[0]["telephone"]);
        if($telephone !='')
        {
            $telephone = 'T. '.$telephone;
        }
        $mobile = ' | '.stripslashes($rsGET[0]["mobile"]);
        $email = stripslashes($rsGET[0]["email"]);
        $password = stripslashes($rsGET[0]["password"]);
        
        $i_am = stripslashes($rsGET[0]["i_am"]);
        
        $other_i_am = stripslashes($rsGET[0]["other_i_am"]);
        if($other_i_am !='')
        {
            $i_am = $i_am.", ".$other_i_am;
        }
        $insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);
        $insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);
        $insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);
        $registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);
        $registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);
        $young_practitioner = stripslashes($rsGET[0]["young_practitioner"]);
        $young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);
        $interested = stripslashes($rsGET[0]["interested"]);
        $terms = stripslashes($rsGET[0]["terms"]);
        $committed = stripslashes($rsGET[0]["committed"]);
        $payment_text = stripslashes($rsGET[0]["payment_text"]);
        $payment_status = strtoupper(stripslashes($rsGET[0]["payment_status"]));
        $register_status = strtolower(stripslashes($rsGET[0]["register_status"]));
        
        */
        
        
        $member_id = stripslashes($rsGET[0]["member_id"]);
        $reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);
        $reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);
        $reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);
        $reg_number = stripslashes($rsGET[0]["reg_number"]);
        
        $first_name = stripslashes($rsGET[0]["first_name"]);
        $middle_name = stripslashes($rsGET[0]["middle_name"]);
        $last_name = stripslashes($rsGET[0]["last_name"]);
        
        
        $address = stripslashes($rsGET[0]["address"]);
        $city = stripslashes($rsGET[0]["city"]);
        $country = stripslashes($rsGET[0]["country"]);
        $pin = stripslashes($rsGET[0]["pin"]);
        
        $permanent_address = stripslashes($rsGET[0]["permanent_address"]);
        $permanent_city = stripslashes($rsGET[0]["permanent_city"]);
        $permanent_country = stripslashes($rsGET[0]["permanent_country"]);
        $permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);
       
        
        $telephone = stripslashes($rsGET[0]["telephone"]);
        
        $mobile = stripslashes($rsGET[0]["mobile"]);
        
        $email = stripslashes($rsGET[0]["email"]);
        $password = stripslashes($rsGET[0]["password"]);
        
        $i_am = stripslashes($rsGET[0]["i_am"]);
        $other_i_am = stripslashes($rsGET[0]["other_i_am"]);
        
        
                
        $insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);
        $insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);
        $insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);
        $registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);
        $registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);
        $young_practitioner = intval($rsGET[0]["young_practitioner"]);
        
        $young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);
        $interested = stripslashes($rsGET[0]["interested"]);
        $terms = stripslashes($rsGET[0]["terms"]);
        $committed = stripslashes($rsGET[0]["committed"]);
        $payment_text = stripslashes($rsGET[0]["payment_text"]);
        $payment_status = strtoupper(stripslashes($rsGET[0]["payment_status"]));
        $register_status = strtolower(stripslashes($rsGET[0]["register_status"]));
        
        
        
        
        
        
        $add_date = date('d F Y', strtotime($rowOrd[0]['add_time']));
	}
	else
	{
?>
        <table width="100%" class="tbl" border="1" align="center">
            <tr>
                <td align="center" height=100 class="txt1" valign=center>
                    <b>Invalid Access<br>Go Back to List and Try Again...</b></td>
            </tr>
        </table>
<?php	

	   exit();
	}
		
}
else
{
?>
    <table width="100%" class="tbl" border=0 align=center>
        <tr>
            <td align="center" height=100 class="txt1" valign=center>
                <b>Invalid Access<br>Go Back to List and Try Again...</b>
            </td>
        </tr>
    </table>


<?php
    exit();
}
 
?>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
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
    
    
    $("#frm").validate({
        errorElement:'label',
        errorPlacement: function( error , element ){
            if( element.attr('name') == 'i_am[]' ){
                error.appendTo("#i_am_error");
            }
            
        },
         
        ignore:[],
        rules: {
            first_name: "required",
            last_name: "required",
            address: "required",
            city: "required",
            country: "required",
            pin: "required",
            
            permanent_address: "required",
            permanent_city: "required",
            permanent_country: "required",
            permanent_pin: "required",
           
            telephone: { 
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
            insolvency_professional_agency: {
                ck_insolvency: true
            },
            insolvency_professional_number: {
                ck_insolvency_no: true
            },
            registered_insolvency_professional_number: {
                ck_registered: true
            },
            young_practitioner_enrolment: {
                ck_young: true
            },
            
            interested: "required"
           
        },
        messages: {
            first_name: "",
            last_name: "",
            address: "",
            city: "",
            country: "",
            pin: "",
            
            permanent_address: "",
            permanent_city: "",
            permanent_country: "",
            permanent_pin: "",
            
            telephone: {
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
            interested: ""
           
        },
        submitHandler: function() {

           
            var formvalue = $("#frm").serialize();
            
            $.ajax({
                type: "POST",
                url: "ajax_become_member.php",
                data: "type=editData&" + formvalue,
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
                            $("#frm")[0].reset();
                            //window.location.href = "<?php echo 'become_member.php' ?>";
                            
                            window.location.href = "<?php echo PAGE_LIST; ?>";
                            
                            
                            
                        }, 1500);   
                    }
                    else
                    {
                        
                        $("#INPROCESS").show().html(spl_txt[2]);
                        if( parseInt(spl_txt[1]) == parseInt(2) )
                        {
                            $("#email").select();
                            $("#errorNL").fadeOut(3000);
                        }
                             
                        setTimeout(function(){
                            $("#INPROCESS").html(''); 
                            $("#INPROCESS").html('Submit'); 
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
/*

$(document).ready(function(){
   
         
	 $("#backlist").click(function(){
	      location.href="<?php echo PAGE_LIST;?>";
	 });
         
     $("#frm").validate({ 
        rules: {
             
        },
        messages: {
            
        },
        submitHandler: function() {
            
            value = $("#frm").serialize();
			 
            $.ajax({
                type: "POST",
                url: "<?php echo PAGE_AJAX;?>",
                data: 'type=editData&' +value,
                beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
                    //return false;
                },
                success: function(msg)
                {
                    //alert(msg);
                    var spl_txt = msg.split("~~~"); 
                    if(spl_txt[1] == '1')
                    {
                        colorStyle = "successTxt";
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                        
                        //$("#inprocess").fadeOut(3000);
                        
                        setTimeout(function(){
                            location.href = "<?php echo PAGE_LIST;?>";
                        },3000);
                    }
                    //else if(spl_txt[1] == '2')
                    else
                    {
                    
                        colorStyle = "error";
                            
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                    
                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' />&nbsp;<input type='button' id='backlist' name='backlist' value='Back To list' class='cancelBtn' /> ");
                        
                           
                        },1500);
                    }
                
                }
            })
        }
    });
    
    
    

});
*/
</script>


<form name="frm" id="frm" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="con" value="<?php echo $con; ?>" id="con" />
<input type="hidden" name="id" value="<?php echo $member_id; ?>" id="id" />
<input type="hidden" name="old_register_status" value="<?php echo $register_status; ?>" id="old_register_status" />        
<input type="hidden" name="old_payment_status" value="<?php echo $payment_status; ?>" id="old_register_status" />        

<input type="hidden" name="reg_number_text_temp" value="<?php echo $reg_number_text_temp; ?>" id="reg_number_text_temp" />        
<input type="hidden" name="reg_number_temp" value="<?php echo $reg_number_temp; ?>" id="reg_number_temp" />        
<input type="hidden" name="reg_number_text" value="<?php echo $reg_number_text; ?>" id="reg_number_text" />        
<input type="hidden" name="reg_number" value="<?php echo $reg_number; ?>" id="reg_number" />        



<h1>
	Insol Member Details 
    <?php
    if($reg_number_text !='')
    {
    ?>
        <span class="txtColor">#<?php echo $reg_number_text; ?></span>
    <?php
    }
    ?>
    <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1> 


<div class="addWrapper">
	<div class="boxHeading">Modify</div>
    <div class="clear"></div>
    <div class="containerPad" id="editOrderSpecial">
        <div class="col-sm-4">
			<div class="form-group">
				<label>First Name <span>*</span></label>
				<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo $first_name; ?>" placeholder="" maxlength="100">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Middle Name <span></span></label>
				<input type="text" class="form-control" name="middle_name" id="middle_name" value="<?php echo $middle_name; ?>" placeholder="" maxlength="50">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Last Name <span>*</span></label>
				<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo $last_name; ?>" placeholder="" maxlength="50">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Telephone <span>*</span></label>
				<input type="text" class="form-control" name="telephone" id="telephone" placeholder="" maxlength="13" value="<?php echo $telephone; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Mobile </label>
				<input type="text" class="form-control" name="mobile" id="mobile" placeholder="" maxlength="12" value="<?php echo $mobile; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
				<input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $email; ?>">
			</div>
		</div>
        
        		
		<div class="col-md-12">
			<div class="form-group">
				<label>Correspondence address  <span>*</span></label>
				<textarea class="form-control" rows="2" name="address" id="address"><?php echo $address; ?></textarea>
			</div>					
		</div>
      	
		<div class="col-sm-4">
			<div class="form-group">
				<label>City <span>*</span></label>
				<input type="text" class="form-control" name="city" id="city" placeholder="" maxlength="50" value="<?php echo $city; ?>"> 
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Country <span>*</span></label>
				<input type="text" class="form-control" name="country" id="country" placeholder="" maxlength="50" value="<?php echo $country; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Pin <span>*</span></label>
				<input type="text" class="form-control" name="pin" id="pin" placeholder="" maxlength="10" value="<?php echo $pin; ?>">
			</div>
		</div>
	    <div class="col-md-12 fullDivider">
        	<div style="border-top: 1px solid #ccc;"></div>
        </div>
        
        <div class="col-md-12">
			<div class="form-group">
				<label>Permanent Address  <span>*</span></label>
				<textarea class="form-control" rows="2" name="permanent_address" id="permanent_address"><?php echo $permanent_address; ?></textarea>
			</div>					
		</div>
        
        <div class="col-sm-4">
			<div class="form-group">
				<label>City <span>*</span></label>
				<input type="text" class="form-control" name="permanent_city" id="permanent_city" placeholder="" maxlength="50" value="<?php echo $permanent_city; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Country <span>*</span></label>
				<input type="text" class="form-control" name="permanent_country" id="permanent_country" placeholder="" maxlength="50" value="<?php echo $permanent_country; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Pin <span>*</span></label>
				<input type="text" class="form-control" name="permanent_pin" id="permanent_pin" placeholder="" maxlength="10" value="<?php echo $permanent_pin; ?>">
			</div>
		</div>
		
		
		
		<div class="col-md-12 fullDivider">
        	<div style="border-top: 1px solid #ccc;"></div>
        </div>
		<div class="col-md-12">
			<div class="form-group">
				<label><h4 class="bluetxt">I am <span>*</span></h4></label>&nbsp;<span id="i_am_error" ></span>
				<div class="row">
					<div class="clr"></div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Chartered Accountant" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Chartered Accountant', explode(", ", $i_am))) { echo " checked "; } ?>/> Chartered Accountant
						</label>
					</div>
                    <div class="col-md-3">
						<label>
							<input type="checkbox" value="Cost Accountant" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Cost Accountant', explode(", ", $i_am))) { echo " checked "; } ?>/> Cost Accountant
						</label>
					</div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Advocate" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Advocate', explode(", ", $i_am))) { echo " checked "; } ?>/> Advocate
						</label>
					</div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Company Secretary" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Company Secretary', explode(", ", $i_am))) { echo " checked "; } ?>/> Company Secretary
						</label>
					</div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Judge" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Judge', explode(", ", $i_am))) { echo " checked "; } ?>/> Judge
						</label>
					</div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Member of NCLT" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Member of NCLT', explode(", ", $i_am))) { echo " checked "; } ?>/> Member of NCLT
						</label>
					</div>
					<div class="col-md-3">
						<label>
							<input type="checkbox" value="Acedemic" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Acedemic', explode(", ", $i_am))) { echo " checked "; } ?>/> Acedemic
						</label>
					</div>
					<div class="col-md-3">
				        <label>
							<input type="checkbox" value="Other" name="i_am[]" id="i_am[]" class='i_am' <?php if(in_array('Other', explode(", ", $i_am))) { echo " checked "; } ?>/> Other
						</label>
					  	<span  <?php if($other_i_am=='') { ?>style="display: none" <?php } ?>id="otherIm">
							<input type="text" class="form-control" name="other_i_am" id="other_i_am" placeholder="Please Specify" value="<?php echo $other_i_am;?>">
                            <input type="hidden" class="form-control" name="i_am_chkvalue" id="i_am_chkvalue" style="display: none;">
						</span>
                        
					</div>
				</div>
			</div>					
		</div>
		<div class="hrline"></div>
		<div class="clr"></div>
		<div class="col-md-12">
			<div class="form-group">
				<label><h4 class="bluetxt"><input type="checkbox" value="1" name="insolvency_professional" id="insolvency_professional" <?php if(intval($insolvency_professional) >=intval(1)){ echo "checked=''";}  ?>/> I am Insolvency Professional registered with </h4></label>
				<div class="row">
					<div class="clr"></div>
					<div class="col-md-6">
						<label>please specify the name of Insolvency Professional Agency</label>
                        <input type="text" class="form-control" name="insolvency_professional_agency" id="insolvency_professional_agency" placeholder="" value="<?php echo $insolvency_professional_agency; ?>">
					</div>
					<div class="col-md-6">
						<label>My registration number is</label><input type="text" class="form-control" name="insolvency_professional_number" id="insolvency_professional_number" placeholder="" value="<?php echo $insolvency_professional_number; ?>">
					</div>
				</div>
			</div>					
		</div>
		<div class="hrline"></div>
		<div class="clr"></div>
		<div class="col-md-12">
			<div class="form-group">
				<label><h4 class="bluetxt"><input type="checkbox" value="1" name="registered_insolvency_professional" id="registered_insolvency_professional" <?php if(intval($registered_insolvency_professional) >=intval(1)){ echo "checked=''";}  ?>> I am registered Insolvency Professional with Insolvency and Bankruptcy Board of India.</h4></label>
				<div class="row">
					<div class="clr"></div>
					<div class="col-md-12">
						<label>My registration number is</label><input type="text" class="form-control" name="registered_insolvency_professional_number" id="registered_insolvency_professional_number" value="<?php echo $registered_insolvency_professional_number; ?>" placeholder="">
					</div>
				</div>
			</div>					
		</div>
		<div class="hrline"></div>
		<div class="clr"></div>
		<div class="col-md-12">
			<div class="form-group">
				<label><h4 class="bluetxt"><input type="checkbox" value="1" name="young_practitioner" id="young_practitioner" <?php if(intval($young_practitioner) >=intval(1)){ echo "checked=''";}  ?>> I am a Young Practitioner. I confirm I have less than ten years experience in my profession mentioned above. </h4></label>
				<div class="row">
					<div class="clr"></div>
					<div class="col-md-12">
						<label>My date of enrolment with my professional body is</label><input type="text" class="form-control" name="young_practitioner_enrolment" id="young_practitioner_enrolment" placeholder="" value="<?php echo $young_practitioner_enrolment; ?>">
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
						<textarea class="form-control" rows="2" name="interested" id="interested"><?php echo $interested; ?></textarea>
					</div>
				</div>
			</div>					
		</div>
		
        <div class="hrline"></div>
		<div class="clr"></div>
        
       
        <div class="fullDivider">
        	<div class="sml_heading">Status Option <span></span> </div>
        </div>
       	<div class="fullWidth" style=" padding-bottom:0px;">
           
            
                <div class="width5">
                	<label class="mainLabel">Register Status</label>                
                    <?php
                    if ( trim($payment_status) != "SUCCESSFUL")
                    {
                    ?>
                        <select name="register_status" id="register_status" class="selectBox">
                            <option value="Pending" <?php if ( trim($register_status) == "pending" ) { echo "Selected"; } ?> >Pending</option>
                            <option value="Approved" <?php if ( trim($register_status) == "approved" ) { echo "Selected"; } ?> >Approved</option>
                            <option value="Declined" <?php if ( trim($register_status) == "declined" ) { echo "Selected"; } ?> >Declined</option>
                            <?php
                            if ( trim($register_status) == "expired") 
                            {
                            ?>
                                <option value="Expired" <?php if ( trim($register_status) == "expired" ) { echo "Selected"; } ?> >Expired</option>
                            <?php
                            }
                            ?>
                        </select>
                    <?php
                    }
                    else
                    {
                        echo "<b style='color:#18A15D;font-weight: bold;'>".ucfirst($register_status)."</b>";
                    }
                    ?>
               </div>
            <?php
            if ( trim($register_status) == "approved" )
            {
            ?>
                <div class="width5">
                	<label class="mainLabel">Payment Status</label>                
                    <select name="payment_status" id="payment_status" class="selectBox">
                        <option value="PENDING" <?php if ( trim($payment_status) == "PENDING" ) { echo "Selected"; } ?> >Pending</option>
                        <option value="SUCCESSFUL" <?php if ( trim($payment_status) == "SUCCESSFUL" ) { echo "Selected"; } ?> >Successful</option>
                        <option value="CANCELLED" <?php if ( trim($payment_status) == "CANCELLED" ) { echo "Selected"; } ?> >Cancelled</option>
                    </select> 
               </div>
               <div class="width3">
                	<label class="mainLabel">Payment Detail</label>
                    <input type="text" name="payment_text" value="<?php echo $payment_text; ?>" id="payment_text" autocomplete="OFF" class="txtBox" />
                </div>
            <?php
            }
            
           ?>
           
        </div>
           
        
       <!--div class="fullWidth" style="padding-bottom:0px;">                       
            <label class="mailStatus">Mail to Member </label><input type="checkbox"  name='sendStatus' value="YES" /> <span style="color: #ff0000;font-size: 10px;">(Check If Yes)  </span>
        </div-->
        
        <div class="fullWidth searchBtnWrap noGap" style="padding:0px;">                        
            <div class="submitWrapLoadFull" id="INPROCESS">                        
                <input type="submit" value="Save" name='save' id='save' class="submitBtn" />&nbsp;                        
                <input type="button" id="backlist" name="backlist" value="Back To list" class="cancelBtn" />        
            </div>
        </div>
       
    </div><!--containerPad end-->
</div>
</form>
<?php include("footer.php"); ?>