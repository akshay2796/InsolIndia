<?php error_reporting(0);
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
<style>
  .btn-primary {
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
    margin-left: -25px;
}
  input[type=checkbox], input[type=radio] {
    margin: 4px 7px 2px;
    margin-top: 1px\9;
    line-height: normal;
    /* padding-left: 10px; */
}
</style>
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
      
<h2 class="hedinginsol"><span class="insolindias">INSOL India</span><br>
 Annual Conference Registration Form </h2>
 <p class="theleela">13 – 14 November 2018, The Leela Palace, New Delhi</p>
<h3 class="deadline">Deadline for early registration fee: 15 October 2018</h3>
<p class="plesemail">
  <!---
Please mail this form to: Aditi Khanna, INSOL India, 5 Mathura Road, 3rd Floor, Jangpura – A,<br>
New Delhi – 110014 or email: <a href="mailto:contact@insolindia.com">contact@insolindia.com</a><br><br>------>
<b>Note:</b> This delegate registration form is valid for one delegate. This registration form can only<br>
be accepted if accompanied by full payment, which can be made by Cheque or NEFT.
</p>
<hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">

<!----------Form Section Start--------------->
 <form style="margin-top: 69px;margin-left: -33px;">
    <div class="form-group">
      <label class="lebtitle">Title:</label>
      <input type="email" class="form-control tittl" id="email" placeholder="" name="email">
    </div>
    
<div class="form-group firsnames">
      <label class="lebfirst">First Name:</label>
      <input type="email" class="form-control firstnamee" id="email" placeholder="" name="email">
    </div>

<div class="form-group surnames">
      <label class="lebfsurn">Surname:</label>
      <input type="email" class="form-control surname" id="email" placeholder="" name="email">
    </div>


    <div class="form-group">
      <label class="asyou">Name as you wish it to appear on your badge:</label>
      <input type="password" class="form-control nameas" id="pwd" placeholder="" name="pwd">
    </div>
    
    <div class="form-group">
      <label class="asyou">Firm Name:</label>
      <input type="password" class="form-control firmname" id="pwd" placeholder="" name="pwd">
    </div>
     <div class="form-group">
      <label class="asyou">Address:</label>
      <input type="password" class="form-control firmname" id="pwd" placeholder="" name="pwd">
    </div>

 <div class="form-group">
      <label class="asyou">Tel:</label>
      <input type="password" class="form-control tel" id="pwd" placeholder="" name="pwd">
    </div>

 <div class="form-group emailses">
      <label class="emails">Email:</label>
      <input type="password" class="form-control emailss" id="pwd" placeholder="" name="pwd">
    </div>
  </form>

<p class="thedele"> The delegate registration fee includes entry to the technical sessions on Tuesday 13<br>
November, and Wednesday 14 November, conference lunches on 13 November and 14<br>
November, the Gala dinner on Tuesday 13 November. </p>
<hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">
<!---------->
<form style="margin-top: 69px;margin-left: -69px;">
    <div class="form-group">
      <input type="email" class="form-control tittl" id="email" placeholder="Registration Fees" name="email">
    </div>

 <div class="form-group">
      <input type="email" class="form-control tittl1" id="email" placeholder="13 – 14 November 2018" name="email">
    </div>
<div class="form-group">
      <input type="email" class="form-control tittl2" id="email" placeholder="INSOL Membership no" name="email">
    </div>
<div class="form-group">
      <input type="email" class="form-control tittl3" id="email" placeholder="Amount" name="email">
    </div>
</form>
<p style="margin-left:0px; margin-top: -10px;">Payable</p>
<!--------------->
<h2 class="confran">Conference </h2>
<div style="margin-left: -23px;">
  <p class="insolnumber">INSOL Member</p>
  <p class="rate">Rs. 18,800/-</p>
  <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email">
    </div>
  </form>
  <p class="res">Rs.</p>
    <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email" style="    margin-left: 70%;width: 20%;">
    </div>
  </form>
  <!-------------->
  <p class="insolnumber">Non-Member</p>
  <p class="rate">Rs. 23,600/-</p>
  <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email">
    </div>
  </form>
  <p class="res">Rs.</p>
    <form style="margin-top: 69px;">
    <div class="form-group">
      <input type="email" class="form-control titt" id="email" placeholder="" name="email" style=" width: 20%;   margin-left: 70%;">
    </div>
  </form>
</div>
<!--------------->
<h2 class="paymentsm">Payment summary</h2>
<form style="margin-top: 28px;margin-left: -30px;">
    <div class="form-group">
      <label class="lebtitle">If you wish to pay by cheque or NEFT, kindly fill in the below details</label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>

<div class="form-group">
      <label class="lebtitle">I enclose a cheque/draft/NEFT to the order of:</label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>
<div class="form-group">
      <label class="lebtitle">Cheque No:UTR No. Amount:Address (if different from address on previous page): </label>
      <input type="email" class="form-control ifus " id="email" placeholder="" name="email">
    </div>




</form>

<p style="margin-left:-5px;">Special dietary requirements:<br>
If you have any dietary restrictions, please remember to identify yourself to the staff at each<br>
event. INSOL will try their best to accommodate any special dietary requests:</p>
<hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">
<p style="margin-left:-5px;">
  Have you attended an INSOL India Conference previously? 
</p>
<form style="    margin-left: -5px;">
  <input type="checkbox" name="vehicle1" value="Bike">Yes<br>
  <input type="checkbox" name="vehicle2" value="Car">No<br>
</form>
<hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">
<p style="margin-left: -5px;text-align: justify;">
  Additional requirements:<br>
The hotels selected by INSOL India are fully wheelchair accessible. If you require further<br>
information please contact us.<br>
Hotel: Please indicate for our records which hotel you will be staying at:
  </p>
 <hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">
  <p style="margin-left:-5px;">
Delegate name, firm and country will be listed on the delegate list. Photos & video may be<br>
taken during the Conference for publication. Please bring your confirmation and photographic<br>
identification with you in order to collect your badge and Conference papers. 


  </p>
 <hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">

              <div class="clr"></div>
              
              <div class="col-md-9" style="margin-left: -21px;">
                <div class="form-group">
                                <label><input type="checkbox" value="1" name="terms" id="terms"/> I confirm that the information provided in this form is true and correct.</label>
                        <div id="terms_error"></div>
                            </div>          
              </div>  					
<div class="col-xs-12">
                            <div class="form-inline">
                                <div class="form-group">
                                    <div class="input-group"style="    margin-left: -22px;">
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
                            <div style="color:#B71D21;margin-left: -22px;">Please fill the form as per requirements and irrelevant sections may be filled as not applicable or N/A. </div>
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