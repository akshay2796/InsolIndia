<?php 
    error_reporting(E_ALL);

    include('header.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    include 'PHPMailer/src/Exception.php';
    include 'PHPMailer/src/PHPMailer.php';
    include 'PHPMailer/src/SMTP.php';

    if ( isset($_POST['submit_request'] ) ) {

        $title                  = ( $_POST['title'] ) ? $_POST['title'] : '';
        $fname                  = ( $_POST['fname'] ) ? $_POST['fname'] : '';
        $surname                = ( $_POST['surname'] ) ? $_POST['surname'] : '';
        $name_on_badge          = ( $_POST['name_on_badge'] ) ? $_POST['name_on_badge'] : '';
        $firmname               = ( $_POST['firmname'] ) ? $_POST['firmname'] : '';
        $phone                  = ( $_POST['phone'] ) ? $_POST['phone'] : '';
        $email                  = ( $_POST['email'] ) ? $_POST['email'] : '';
        $membership_no          = ( $_POST['membership_no'] ) ? $_POST['membership_no'] : '';
        $pay_by                 = ( $_POST['pay_by'] ) ? $_POST['pay_by'] : ''; //Cheque/NEFT
        $order_of               = ( $_POST['order_of'] ) ? $_POST['order_of'] : ''; //Cheque/NEFT
        $cheque_utr_no          = ( $_POST['cheque_utr_no'] ) ? $_POST['cheque_utr_no'] : ''; //Cheque No: UTR No. Amount: Address (if different from address on previous page)
        $is_previously_attendeds = ( $_POST['is_previously_attended'] ) ?  : ''; //I enclose a cheque/draft/NEFT to the order of:
        $terms                  = ( $_POST['terms'] ) ? $_POST['terms'] : '';

        $fullname = trim( ucfirst($title) .' '. ucfirst($fname) .' '. ucfirst($surname) );
        $is_previously_attended = ( $is_previously_attendeds == 1 ) ? 'Attended' : 'Not Attended';

        $subject  = "Annual Conference Registration";

        $message = '';
        $message .= "Name: $fullname<br />\r\n";
        $message .= "Name as you wish it to appear on your badge : $name_on_badge<br />\r\n";
        $message .= "Firm Name. : $firmname<br />\r\n";
        $message .= "Tel : $phone<br />\r\n";
        $message .= "Membership No. : $membership_no<br />\r\n";
        $message .= "Pay By : $pay_by<br />\r\n";
        $message .= "Order Of : $order_of<br />\r\n";
        $message .= "Cheque No/UTR No. : $cheque_utr_no<br />\r\n";
        $message .= "Previously Attended : $is_previously_attended<br />\r\n";
        
        $mail = new PHPMailer(true);

        try {
            
            //Server settings
            //$mail->SMTPDebug = 2;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'md-in-24.webhostbox.net';              // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'contact@insolindia.com';           // SMTP username
            $mail->Password = 'Insol@006';                        // SMTP password
            $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 465;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('contact@insolindia.com', 'INSOLINDIA');
            //$mail->addAddress('111rohittiwari@gmail.com', 'Rohit Tiwari');     // Add a recipient
            $mail->addAddress('aditikhanna@insolindia.com', 'ADITI KHANNA');     // Add a recipient
            $mail->addReplyTo('contact@insolindia.com', 'INSOLINDIA');
            $mail->addCC('seo@sabsoftzone.com', 'DEEPAK');     
            $mail->addCC('santoshbeats@gmail.com', 'SANTOSH');
            $mail->addBCC('111rohittiwari@gmail.com', 'Rohit Tiwari');
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $message;

            if ( !$mail->send() ) {
                $msg = '<div class="col-md-12 alert alert-warning">Sorry! please try again or contact service provider!</div>';
            } else {
                $msg = '<div class="col-md-12 alert alert-success">Your Request has been submitted Successfully!</div>';
            }

        } catch (Exception $e) {
            $msg = '<div class="col-md-12 alert alert-warning">'. $mail->ErrorInfo .'</div>';
        }

    }

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

                <?php echo $msgs = ( $msg ) ? $msg : ''; ?>

                <h2 class="hedinginsol"><span class="insolindias">INSOL India</span><br> Annual Conference Registration Form </h2>

                <p class="theleela">13 – 14 November 2018, The Leela Palace, New Delhi</p>
                
                <h3 class="deadline">Deadline for early registration fee: 15 October 2018</h3>

                <p class="plesemail">
                    <b>Note:</b> This delegate registration form is valid for one delegate. This registration form can only<br>
                    be accepted if accompanied by full payment, which can be made by Cheque or NEFT.
                </p>

                <hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">

                <!----------Form Section Start--------------->
                <form method="POST" name="conference_form" id="conference_form" >
                    <div style="margin-top: 69px;margin-left: -33px;">
                        
                        <div class="form-group">
                            <label class="lebtitle">Title:</label>
                            <select name="title" id="title" class="form-control tittl">
                                <option value="">Select Title</option>
                                <option value="Mr.">Mr.</option>
                                <option value="Ms.">Ms.</option>
                                <option value="Mrs.">Mrs.</option>
                                <option value="Dr.">Dr.</option>
                                <option value="Prof.">Prof.</option>
                            </select>
                        </div>
                        
                        <div class="form-group firsnames">
                            <label class="lebfirst">First Name:</label>
                            <input type="text" class="form-control firstnamee uppercase" id="fname" placeholder="" name="fname">
                        </div>

                        <div class="form-group surnames">
                            <label class="lebfsurn">Surname:</label>
                            <input type="text" class="form-control surname uppercase" id="surname" placeholder="" name="surname">
                        </div>

                        <div class="form-group">
                            <label class="asyou">Name as you wish it to appear on your badge:</label>
                            <input type="text" class="form-control nameas uppercase" id="name_on_badge" placeholder="" name="name_on_badge">
                        </div>
                        
                        <div class="form-group">
                            <label class="asyou">Firm Name:</label>
                            <input type="text" class="form-control firmname uppercase" id="firmname" placeholder="" name="firmname">
                        </div>

                        <div class="form-group">
                            <label class="asyou">Address:</label>
                            <input type="text" class="form-control firmname" id="address" placeholder="" name="address">
                        </div>

                        <div class="form-group">
                            <label class="asyou">Tel:</label>
                            <input type="tel" class="form-control tel" id="phone" placeholder="" name="phone">
                        </div>

                        <div class="form-group emailses">
                            <label class="emails">Email:</label>
                            <input type="email" class="form-control emailss" id="email" placeholder="" name="email">
                        </div>

                    </div>

                    <p class="thedele">
                        The delegate registration fee includes entry to the technical sessions on Tuesday 13<br>
                        November, and Wednesday 14 November, conference lunches on 13 November and 14<br>
                        November, the Gala dinner on Tuesday 13 November. 
                    </p>

                    <hr style="width:88%;margin-left:0px;border-top: 3px solid #da1515;">

                    <h2 class="confran">Registration Fees </h2>

                    <div style="margin-left: -23px;">
                        
                        <p class="insolnumber">&nbsp;&nbsp;</p>

                        <p class="rate">Before 15 October 2018</p>
                        <p class="rate" style="margin-left:45%!important;">After 15 October 2018</p>

                        <p class="res" style="text-align: center;">INSOL Membership no. <br><small>(where relevent)</small></p>

                        <p class="insolnumber">INSOL Member</p>

                        <p class="rate">Rs. 16,920/- <input type="checkbox" name="member_fees_before_15" id="member_fees_before_15" ></p>
                        <p class="rate" style="margin-left:45%!important;">Rs. 18,800/- <input type="checkbox" name="member_fees_before_15" id="member_fees_after_15" ></p>

                        <p class="res">&nbsp;</p>
                        <div style="margin-top: 69px;">
                            <div class="form-group">
                                <input type="text" class="form-control titt" id="membership_no" placeholder="" name="membership_no" style="margin-left: 70%;width: 20%;">
                            </div>
                        </div>

                        <p class="insolnumber">Non-Member</p>

                        <p class="rate">Rs. 21,240/- <input type="checkbox" name="non_member_fees_before_15" id="non_member_fees_before_15" ></p>
                        <p class="rate" style="margin-left:45%!important;">Rs. 23,600/- <input type="checkbox" name="non_member_fees_before_15" id="non_member_fees_after_15" ></p>

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
                            <input type="text" class="form-control ifus " id="order_of" placeholder="" name="order_of">
                        </div>

                        <div class="form-group">
                            <label class="lebtitle">Cheque No:UTR No. Amount:Address (if different from address on previous page): </label>
                            <input type="text" class="form-control ifus " id="cheque_utr_no" placeholder="" name="cheque_utr_no">
                        </div>
                    </div>

                    <p style="margin-left:-5px;">
                        Special dietary requirements:<br>
                        If you have any dietary restrictions, please remember to identify yourself to the staff at each<br>
                        event. INSOL will try their best to accommodate any special dietary requests:
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
                                    <button type="submit" class="btn btn-primary" name="submit_request">Submit</button>
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
                fname: "required",
                surname: "required",
                name_on_badge: "required",
                firmname: "required",
                address: "required",
                pay_by: "required",
                order_of: "required",
                cheque_utr_no: "required",
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
                cheque_utr_no: "",
                is_previously_attended: "",
                phone: {
                    required: "",
                    minlength: ""
                    },
                email: {
                    required: "",
                    email: "" 
                },
                terms:" Please agree to our terms",
                numsum:""
            
            },
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