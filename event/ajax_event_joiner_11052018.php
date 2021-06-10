<?php
    error_reporting(E_ALL);

    session_start();
    include("library_insol/all_include.php");
    include("global_functions.php"); 

    global $dCON;
    
    $title                  = ( $_POST['title'] ) ? trustme($_POST['title']) : '';
    $fname                  = ( $_POST['fname'] ) ? trustme($_POST['fname']) : '';
    $surname                = ( $_POST['surname'] ) ? trustme($_POST['surname']) : '';
    $name_on_badge          = ( $_POST['name_on_badge'] ) ? trustme($_POST['name_on_badge']) : '';
    $firmname               = ( $_POST['firmname'] ) ? trustme($_POST['firmname']) : '';
    $phone                  = ( $_POST['phone'] ) ? trustme($_POST['phone']) : '';
    $email                  = ( $_POST['email'] ) ? trustme($_POST['email']) : '';
    $address                = ( $_POST['address'] ) ? trustme($_POST['address']) : '';
    $membership_no          = ( $_POST['membership_no'] ) ? trustme($_POST['membership_no']) : '';
    $pay_by                 = ( $_POST['pay_by'] ) ? trustme($_POST['pay_by']) : ''; //Cheque/NEFT
    $order_of               = ( $_POST['order_of'] ) ? trustme($_POST['order_of']) : ''; //Cheque/NEFT
    $cheque_utr_no          = ( $_POST['cheque_utr_no'] ) ? trustme($_POST['cheque_utr_no']) : ''; //Cheque No: UTR No. Amount: Address (if different from address on previous page)
    $cheque_no              = ( $_POST['cheque_no'] ) ? trustme($_POST['cheque_no']) : ''; //Cheque No:
    $utr_no                 = ( $_POST['utr_no'] ) ? trustme($_POST['utr_no']) : ''; //UTR No.
    $enclosed_amount        = ( $_POST['enclosed_amount'] ) ? trustme($_POST['enclosed_amount']) : ''; //Amount:
    $draft_address          = ( $_POST['draft_address'] ) ? trustme($_POST['draft_address']) : ''; //Address (if different from address on previous page)
    $is_previously_attendeds = ( $_POST['is_previously_attended'] ) ? trustme($_POST['is_previously_attended']) : ''; //I enclose a cheque/draft/NEFT to the order of:
    $event_id               = ( $_POST['event'] ) ? intval($_POST['event']) : ''; //I enclose a cheque/draft/NEFT to the order of:
    
    $fullname = trim( ucfirst($title) .' '. ucfirst($fname) .' '. ucfirst($surname) );
    $is_previously_attended = ( $is_previously_attendeds == 1 ) ? 'Yes' : 'No';
    
    $terms = intval($_REQUEST["terms"]); 

    $status = "PENDING";
    $IP = trustme($_SERVER['REMOTE_ADDR']);                  
    $TIME = date("Y-m-d H:i:s");
    $BY = "SELF";
    
    $today = date('m/d/Y h:iA');
    $middate = new DateTime('10/15/2018 11:59PM');

    if ($membership_no) {

        if ( $today > $middate ) {

            $registration_fees = '18800'; // After 15th Oct '18

        } else {

            $registration_fees = '16520';// Till 15th Oct '18

        }
        
    } else {

        if ( $today > $middate ) {

            $registration_fees = '23600'; // After 15th Oct '18

        } else {

            $registration_fees = '21240';// Till 15th Oct '18

        }

    }

    $CHK = checkDuplicate(EVENT_JOINER_TBL,"status~~~email","PENDING~~~".$email,"=~~~=","");
    
    if ( intval($CHK) == intval(0) )
    {
        
        $MAX_ID = getMaxId(EVENT_JOINER_TBL, "event_joiner_id");  
        
        $SQL  = "";
        $SQL .= " INSERT INTO " . EVENT_JOINER_TBL . " SET ";
        $SQL .= " event_joiner_id = :event_joiner_id, "; 
        $SQL .= " event_id = :event_id, "; 
        $SQL .= " title = :title, "; 
        $SQL .= " fname = :fname,"; 
        $SQL .= " surname = :surname,"; 
        $SQL .= " name_on_badge = :name_on_badge,"; 
        $SQL .= " firmname = :firmname,";
        $SQL .= " phone = :phone,"; 
        $SQL .= " email = :email,";
        $SQL .= " address = :address,";
        $SQL .= " membership_no = :membership_no,"; 
        $SQL .= " pay_by = :pay_by,";
        $SQL .= " order_of = :order_of,"; 
        $SQL .= " cheque_utr_no = :cheque_utr_no,";
        $SQL .= " cheque_no = :cheque_no,";
        $SQL .= " utr_no = :utr_no,";
        $SQL .= " enclosed_amount = :enclosed_amount,";
        $SQL .= " draft_address = :draft_address,";
        $SQL .= " is_previously_attended = :is_previously_attended,"; 
        $SQL .= " registration_fees = :registration_fees,";
        $SQL .= " terms = :terms,"; 
        $SQL .= " status = :status, ";
        $SQL .= " add_ip = :add_ip, ";
        $SQL .= " add_by = :add_by, ";
        $SQL .= " add_time = :add_time ";
        //echo $SQL; exit();
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":event_joiner_id", $MAX_ID);
        $stmt->bindParam(":event_id", $event_id); 
        $stmt->bindParam(":title", $title); 
        $stmt->bindParam(":fname", $fname); 
        $stmt->bindParam(":surname", $surname); 
        $stmt->bindParam(":name_on_badge", $name_on_badge);
        $stmt->bindParam(":firmname", $firmname); 
        $stmt->bindParam(":phone", $phone); 
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":address", $address);
        $stmt->bindParam(":membership_no", $membership_no);
        $stmt->bindParam(":pay_by", $pay_by); 
        $stmt->bindParam(":order_of", $order_of); 
        $stmt->bindParam(":cheque_utr_no", $cheque_utr_no);
        $stmt->bindParam(":cheque_no", $cheque_no);
        $stmt->bindParam(":utr_no", $utr_no);
        $stmt->bindParam(":enclosed_amount", $enclosed_amount);
        $stmt->bindParam(":draft_address", $draft_address);
        $stmt->bindParam(":is_previously_attended", $is_previously_attended); 
        $stmt->bindParam(":registration_fees", $registration_fees);
        $stmt->bindParam(":terms", $terms); 
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":add_ip", $IP);
        $stmt->bindParam(":add_by", $BY);
        $stmt->bindParam(":add_time", $TIME);
        $dbRES = $stmt->execute();
        $stmt->closeCursor();
       
        if ( $dbRES == 1 )
        {
            $RTNID = $MAX_ID;
            
            ////////////////user Mail
            sendMailformate("EVENT_JOINER_REQUEST",$RTNID,"");
            
            //////////////Admin Mail
            $MAIL_FORMAT = getMailFormat('EVENT_JOINER_REQUEST',$RTNID,"");
            
            $SUBJECT = $_SESSION['COMPANY_NAME']." : INSOL India: Delegate Registration";
            $TO_EMAIL = $_SESSION['INFO_EMAIL'];
            $FROM_EMAIL = $_SESSION["AUTH_EMAIL_USERNAME"];
            $CC_EMAIL = 'aditikhanna@insolindia.com,seo@sabsoftzone.com,santoshbeats@gmail.com';
            $BCC_EMAIL = 'rohit@sabsoftzone.com';
            
            MailObject($TO_EMAIL,$FROM_EMAIL, $CC_EMAIL, $BCC_EMAIL, $SUBJECT, $MAIL_FORMAT, "");
            
        }

    }
    else
    {
        $dbRES = 2;
    }
        
    switch($dbRES)
    {
        
        case "1": 
             echo "~~~1~~~";
              break;
         case "2": 
             echo "~~~2~~~You are already requested~~~0~~~";
              break;
        default:
            echo "~~~0~~~Error occured, try again~~~0~~~";
            break;
       
    }

?>