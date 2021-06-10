<?php 
    error_reporting(E_ALL);

    include('header.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include 'PHPMailer/src/Exception.php';
    include 'PHPMailer/src/PHPMailer.php';
    include 'PHPMailer/src/SMTP.php';

    if ( isset( $_SESSION['CURRENT_SET_EVENT_URL'] ) ) {
        unset($_SESSION['CURRENT_SET_EVENT_URL']);
    }

    $membership_no = ( $_SESSION['REG_NUMBER'] ) ? $_SESSION['REG_NUMBER'] : '';

    if ( $membership_no != '' ) {
        $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "reg_number_text",$membership_no,'=', '', '1' , "" );
    }

    /* echo '<pre>';
    print_r($rsGET);
    echo '</pre>'; */


    $title = ( $rsGET[0]["title"] ) ? stripslashes($rsGET[0]["title"]) : '';
    $fname = ( $rsGET[0]["first_name"] ) ? stripslashes($rsGET[0]["first_name"]) : '';
    $surname = ( $rsGET[0]["last_name"] ) ? stripslashes($rsGET[0]["last_name"]) : '';
    $middle_name = ( $rsGET[0]["middle_name"] ) ? stripslashes($rsGET[0]["middle_name"]) : '';
    $firmname = ( $rsGET[0]["firm_name"] ) ? stripslashes($rsGET[0]["firm_name"]) : '';
    $address = ( $rsGET[0]["permanent_address"] ) ? stripslashes($rsGET[0]["permanent_address"]) : '';
    $phone = ( $rsGET[0]["telephone"] ) ? stripslashes($rsGET[0]["telephone"]) : '';
    $email = ( $rsGET[0]["email"] ) ? stripslashes($rsGET[0]["email"]) : '';

    $name_on_badge = $title." ".$fname;
    if ( $surname != '' )
    {
        $name_on_badge = $name_on_badge." ".$surname;
    }

    $name_on_badge = ucwords(strtolower($name_on_badge));

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

    .uppercase{
        text-transform: uppercase;
    }

    p {
        text-align: justify;
        text-justify: inter-word;
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
                <div id="response_MSG"></div>
                <?php echo $msgs = ( $msg ) ? $msg : ''; ?>

                <h2 class="hedinginsol"><span class="insolindias">INSOL India</span><br> Annual Conference Registration Form </h2>

                <p class="theleela">13 – 14 November 2018, The Leela Palace, New Delhi</p>
                
                <h3 class="deadline">Deadline for early registration fee: 15 October 2018</h3>

                <p class="plesemail">
                    <b>Note:</b> This delegate registration form is valid for one delegate. This registration form can only be accepted if <br>accompanied by full payment, which can be made by Cheque or NEFT.
                </p>

                <hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">

                <!----------Form Section Start--------------->
                <form method="POST" name="conference_form" id="conference_form" >

                    <input type="hidden" name="event" value="1018" >

                    <div style="margin-top: 69px;margin-left: -33px;">
                        
                        <div class="form-group">
                            <label class="lebtitle">Title:</label>
                            <select name="title" id="title" class="form-control tittl">
                                <option value="">Select Title</option>
                                <option value="Mr." <?php if ( $title == 'Mr.' ) echo 'selected'; ?> >Mr.</option>
                                <option value="Ms." <?php if ( $title == 'Ms.' ) echo 'selected'; ?> >Ms.</option>
                                <option value="Mrs." <?php if ( $title == 'Mrs.' ) echo 'selected'; ?> >Mrs.</option>
                                <option value="Dr." <?php if ( $title == 'Dr.' ) echo 'selected'; ?> >Dr.</option>
                                <option value="Prof." <?php if ( $title == 'Prof.' ) echo 'selected'; ?> >Prof.</option>
                            </select>
                        </div>
                        
                        <div class="form-group firsnames">
                            <label class="lebfirst">First Name:</label>
                            <input type="text" class="form-control firstnamee uppercase" id="fname" placeholder="" name="fname" value="<?php echo $fname ?>" >
                        </div>

                        <div class="form-group surnames">
                            <label class="lebfsurn">Surname:</label>
                            <input type="text" class="form-control surname uppercase" id="surname" placeholder="" name="surname" value="<?php echo $surname ?>" >
                        </div>

                        <div class="form-group">
                            <label class="asyou">Name as you wish it to appear on your badge:</label>
                            <input type="text" class="form-control nameas uppercase" id="name_on_badge" placeholder="" name="name_on_badge" value="<?php echo $name_on_badge ?>" >
                        </div>
                        
                        <div class="form-group">
                            <label class="asyou">Firm Name:</label>
                            <input type="text" class="form-control firmname uppercase" id="firmname" placeholder="" name="firmname" value="<?php echo $firmname ?>" >
                        </div>

                        <div class="form-group">
                            <label class="asyou">Address:</label>
                            <input type="text" class="form-control firmname" id="address" placeholder="" name="address" value="<?php echo $address ?>" >
                        </div>

                        <div class="form-group">
                            <label class="asyou">Tel:</label>
                            <input type="tel" class="form-control tel" id="phone" placeholder="" name="phone" value="<?php echo $phone ?>" >
                        </div>

                        <div class="form-group emailses">
                            <label class="emails">Email:</label>
                            <input type="email" class="form-control emailss" id="email" placeholder="" name="email" value="<?php echo $email ?>" >
                        </div>

                    </div>

                    <p class="thedele">
                        The delegate registration fee includes entry to the technical sessions on Tuesday 13
                        November, and Wednesday <br>14 November, conference lunches on 13 November and 14
                        November, the Gala dinner on Tuesday 13 November. 
                    </p>

                    <hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">

                    <h2 class="confran">Registration Fees </h2>

                    <div style="margin-left: -225px;">
                        
                        <p class="insolnumber">&nbsp;&nbsp;</p>

                        <p class="rate">Before 15 October 2018</p>
                        <p class="rate" style="margin-left:45%!important;">After 15 October 2018</p>

                        <?php if ( $membership_no != '' ) { ?> <p class="res" style="text-align: center; margin-right: 66px;">INSOL Membership no. <br><small>(where relevent)</small></p>  <?php   }   ?>

                        <!-- <p class="insolnumber">INSOL Member</p> -->
                        <p class="insolnumber">&nbsp;&nbsp;</p>

                        <?php if ( $membership_no != '' ) { ?> 
                            <p class="rate">Rs. 16,520/- </p>
                            <p class="rate" style="margin-left:45%!important;">Rs. 18,800/- </p>
                        <?php   }   ?>


                        <?php if ( $membership_no != '' ) { ?>

                                <p class="res">&nbsp;</p>
                                <div style="margin-top: 69px;">
                                    <div class="form-group">
                                        <input type="text" class="form-control titt" id="membership_no" placeholder="" name="membership_no" value="<?php echo $membership_no; ?>" style="margin-left: 70%;width: 20%;" readonly>
                                    </div>
                                </div>

                        <?php   }   ?>

                        <!-- <p class="insolnumber">Non-Member</p> -->

                        <?php if ( $membership_no == '' ) { ?><p class="rate">Rs. 21,240/- <!-- <input type="checkbox" name="non_member_fees_before_15" id="non_member_fees_before_15" > --></p>
                        <p class="rate" style="margin-left:45%!important;">Rs. 23,600/- <!-- <input type="checkbox" name="non_member_fees_before_15" id="non_member_fees_after_15" > --></p><?php   }   ?>

                        <!-- <p class="res">&nbsp;</p>
                        <div style="margin-top: 69px;">
                            <div class="form-group">
                                <input type="text" class="form-control titt" id="non_member_fee" placeholder="" name="non_member_fee" style=" width: 20%; margin-left: 70%;">
                            </div>
                        </div> -->
                    </div>

                    <hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">
                    <!--------------->
                    <h2 class="paymentsm">Payment summary</h2>

                    <div style="margin-top: 28px;margin-left: -30px;">
                        <div class="form-group">
                            <label class="lebtitle">If you wish to pay by cheque or NEFT, kindly fill in the below details</label>
                            <input type="text" class="form-control ifus " id="pay_by" placeholder="" name="pay_by">
                        </div>

                        <div class="form-group">
                            <label class="lebtitle">I enclose a cheque/draft/NEFT to the order of:</label>
                            
                            <select name="order_of" id="order_of" class="form-control ifus">
                                <option value="">Select</option>
                                <option value="NEFT">NEFT</option>
                                <option value="CHEQUE">CHEQUE</option>
                                <option value="DRAFT">DRAFT</option>
                            </select>

                            <!-- <input type="text" class="form-control ifus " id="order_of" placeholder="" name="order_of"> -->
                        </div>

                        <div class="col-md-6" style="margin-left: -13px;">

                            <div class="form-group">
                                <label class="lebtitle">Cheque No:</label>
                                <input type="text" class="form-control ifus " id="cheque_no" placeholder="" name="cheque_no">
                                <div id="cheque_no_error"></div>
                            </div>

                            <div class="form-group">
                                <label class="lebtitle">Amount:</label>
                                <input type="text" class="form-control ifus " id="enclosed_amount" placeholder="" name="enclosed_amount">
                                <div id="enclosed_amount_error"></div>
                            </div>
                           
                        </div>

                        <div class="col-md-6" style="margin-left: -13px;">

                            <div class="form-group">
                                <label class="lebtitle">UTR No.</label>
                                <input type="text" class="form-control ifus " id="utr_no" placeholder="" name="utr_no">
                                <div id="utr_no_error"></div>
                            </div>
                            
                            <div class="form-group">
                                <label class="lebtitle">Address (if different from address on previous page): </label>
                                <input type="text" class="form-control ifus " id="draft_address" placeholder="" name="draft_address">
                            </div>

                        </div>
                        
                    </div>

                    <p style="margin-left:-5px;">
                        Special dietary requirements:<br>
                        If you have any dietary restrictions, please remember to identify yourself to the staff at each event. INSOL will try 
                        <br>their best to accommodate any special dietary requests:
                    </p>

                    <hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">

                    <p style="margin-left:-5px;">Have you attended an INSOL India Conference previously?</p>

                    <div style="margin-left: -5px;">
                        <input type="radio" name="is_previously_attended" id="is_previously_attended_1" value="1"><label for="is_previously_attended_1">Yes</label><br>
                        <input type="radio" name="is_previously_attended" id="is_previously_attended_0" value="0"><label for="is_previously_attended_0">No</label><br>
                    </div>

                    <hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">

                    <p style="margin-left: -5px;text-align: justify;">
                        Additional requirements:<br>
                        The hotels selected by INSOL India are fully wheelchair accessible. If you require further information please <br>contact us.<br>
                        Hotel: Please indicate for our records which hotel you will be staying at:
                    </p>

                    <hr style=" width: 89%; margin-left: -5px;border-top: 3px solid #da1515;">
                    
                    <p style="margin-left:-5px;">
                        Delegate name, firm and country will be listed on the delegate list. Photos & video may be taken during the <br>
                        Conference for publication. Please bring your confirmation and photographic identification with you in order to <br>collect your badge and Conference papers. 
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
                                <div class="input-group"style="margin-left: -22px;">
                                    <div class="input-group-addon">
                                        <span><?php echo $capVAL2; ?></span>
                                        <span>+</span>
                                        <span><?php echo $capVAL1; ?></span>
                                        <span>=</span>
                                    </div>
                                    
                                    <input type="text" value="" maxlength="2" name="numsum" id="numsum" class="form-control" onblur="integerOnly(this)" autocomplete="OFF" style="width:75px;"/>&nbsp;<span class="" style="color: red;" id="errorCAP"></span>
                                                        
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
                                    <button type="submit" class="btn btn-primary" name="submit_request" id="INPROCESS">Submit</button>
                                </div>
                            </div>

                            <div class="col-md-6"></div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.validate-latest.js"></script>
<script language="javascript" type="text/javascript">

    $(document).ready(function(){

        $("#conference_form").validate({
            errorElement:'span',
            errorPlacement: function( error , element ){
                if ( element.attr('name') == 'cheque_no' ) {
                    error.appendTo("#cheque_no_error");
                }
                else if ( element.attr('name') == 'utr_no' ) {
                    error.appendTo("#utr_no_error");
                }
                else if ( element.attr('name') == 'enclosed_amount' ) {
                    error.appendTo("#enclosed_amount_error");
                }
                else if ( element.attr('name') == 'terms' ) {
                    error.appendTo("#terms_error");
                }
                else if ( element.attr('name') == 'committed' )
                {
                    error.appendTo("#committed_error");
                }
            },
            
            ignore:[],
            rules: {
                title: "required",
                fname: "required",
                surname: "required",
                name_on_badge: "required",
                firmname: "required",
                address: "required",
                pay_by: "required",
                order_of: "required",
                cheque_no: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var cheque_no_val = $("#cheque_no").val();
                        if ( order_of == 'CHEQUE' && cheque_no_val == "" ) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                utr_no: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var utr_no_val = $("#utr_no").val();
                        if ( order_of == 'NEFT' && utr_no_val == "" ) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                enclosed_amount: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var enclosed_amount_val = $("#enclosed_amount").val();
                        if ( order_of == 'DRAFT' && enclosed_amount_val == '' ) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                is_previously_attended: "required",
                phone: { 
                    required: true,
                    minlength: 10
                    },
                email: {
                    required: true,
                    email: true 
                },
                terms:{
                    required:true
                },
                numsum: "required"
            
            },
            messages: {
                title: "",
                fname: "",
                surname: "",
                name_on_badge: "",
                firmname: "",
                address: "",
                pay_by: "",
                order_of: "",
                is_previously_attended: "",
                phone: {
                    required: "",
                    minlength: ""
                    },
                email: {
                    required: "",
                    email: "" 
                },
                cheque_no: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var cheque_no_val = $("#cheque_no").val();
                        if ( order_of == 'CHEQUE' && cheque_no_val == "" ) {
                            return "Please enter cheque number";
                        } else {
                            return false;
                        }
                    }
                },
                utr_no: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var utr_no_val = $("#utr_no").val();
                        if ( order_of == 'NEFT' && utr_no_val == "" ) {
                            return "Please enter utr number";
                        } else {
                            return false;
                        }
                    }
                },
                enclosed_amount: {
                    required: function (element) {
                        var order_of = $("#order_of").val();
                        var enclosed_amount_val = $("#enclosed_amount").val();
                        if ( order_of == 'DRAFT' && enclosed_amount_val == '' ) {
                            return "Please enter Amount";
                        } else {
                            return false;
                        }
                    }
                },

                terms:" Please agree to our terms",
                numsum:""
            
            },
        
            submitHandler: function() {

                var numsum = $("#numsum").val();
                var capRES = $("#capRES").val();

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
                    $("#errorCAP").html("");
                    $("#errorCAP").hide();
                }

                var formvalue = $("#conference_form").serialize();

                $.ajax({
                    type: "POST",
                    url: "ajax_event_joiner.php",
                    data: formvalue,
                    beforeSend: function() {
                        $("#INPROCESS").html("");                    
                        $("#INPROCESS").html("<i class='icon iconloader'></i> Processing...");
                    },
                    success: function(msg) {
                        // console.log('Response=> ' + msg);
                        //alert(msg);
                        //return false;
                        var spl_txt = msg.split("~~~");
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            setTimeout(function(){
                                $("#conference_form")[0].reset();
                                $("#response_MSG").html('<div class="col-md-12 alert alert-success">Your Request has been submitted Successfully!</div>');
                            }, 2000);
                            
                            $("#INPROCESS").html(''); 
                            $("#INPROCESS").html('SUBMIT'); 
                        }
                        else
                        {
                            $("#response_MSG").html('<div class="col-md-12 alert alert-warning">'+ spl_txt[2] +'</div>');
                            
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

<?php include('footer.php'); ?>