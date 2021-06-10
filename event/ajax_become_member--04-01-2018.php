<?php
error_reporting(E_ALL);
session_start();
include("library_insol/all_include.php");
include("global_functions.php"); 

$type =  trim($_REQUEST['type']);
//exit;
switch($type)
{
    case "saveData":
        saveData();
    break;
    case "login":
        login();
    break;
    case "forgot_password":
        forgot_password();
    break;
  
}


function saveData()
{ 
    global $dCON;
  
    $first_name = trustme($_REQUEST["first_name"]); 
    $middle_name = trustme($_REQUEST["middle_name"]); 
    $last_name = trustme($_REQUEST["last_name"]); 
    $address = trustme($_REQUEST["address"]); 
    $city = trustme($_REQUEST["city"]); 
    $country = trustme($_REQUEST["country"]); 
    $pin = trustme($_REQUEST["pin"]); 
   
    
    $permanent_address = trustme($_REQUEST["permanent_address"]); 
    $permanent_city = trustme($_REQUEST["permanent_city"]); 
    $permanent_country = trustme($_REQUEST["permanent_country"]); 
    $permanent_pin = trustme($_REQUEST["permanent_pin"]); 
    
    
    $telephone = trustme($_REQUEST["telephone"]); 
    $email = trustme($_REQUEST["email"]); 
    
    
    $mobile = trustme($_REQUEST["mobile"]); 
    //$i_am = trustme($_REQUEST["i_am"]); 
    
    $i_am = implode(', ',$_REQUEST['i_am']);
    
    $other_i_am = trustme($_REQUEST["other_i_am"]); 
    
    $insolvency_professional = intval($_REQUEST["insolvency_professional"]); 
    $insolvency_professional_agency = trustme($_REQUEST["insolvency_professional_agency"]); 
    $insolvency_professional_number = trustme($_REQUEST["insolvency_professional_number"]); 
    $registered_insolvency_professional = intval($_REQUEST["registered_insolvency_professional"]); 
    $registered_insolvency_professional_number = trustme($_REQUEST["registered_insolvency_professional_number"]); 
    $young_practitioner = intval($_REQUEST["young_practitioner"]); 
    $young_practitioner_enrolment = trustme($_REQUEST["young_practitioner_enrolment"]); 
    $interested = trustme($_REQUEST["interested"]); 
    
    $terms = intval($_REQUEST["terms"]); 
    $committed = intval($_REQUEST["committed"]); 
    
    $password = rand(100000,999999);
             

    $status = "ACTIVE";         
    $IP = trustme($_SERVER['REMOTE_ADDR']);                  
    $TIME = date("Y-m-d H:i:s");
    $BY = "SELF";
    
    $CHK = checkDuplicate(BECOME_MEMBER_TBL,"status~~~email","ACTIVE~~~".$email,"=~~~=","");   
    
    if( intval($CHK) == intval(0) )
    {
        
        $MAX_ID = getMaxId(BECOME_MEMBER_TBL, "member_id");  
        
        $SQL  = "";
        $SQL .= " INSERT INTO " . BECOME_MEMBER_TBL . " SET ";
        $SQL .= " member_id = :member_id, "; 
        $SQL .= " first_name = :first_name,"; 
        $SQL .= " middle_name = :middle_name,"; 
        $SQL .= " last_name = :last_name,"; 
        $SQL .= " address = :address,"; 
        $SQL .= " city = :city,"; 
        $SQL .= " country = :country,"; 
        $SQL .= " pin = :pin,"; 
        $SQL .= " permanent_address = :permanent_address,"; 
        $SQL .= " permanent_city = :permanent_city,"; 
        $SQL .= " permanent_country = :permanent_country,"; 
        $SQL .= " permanent_pin = :permanent_pin,"; 
       
        $SQL .= " telephone = :telephone,"; 
        $SQL .= " email = :email,"; 
        $SQL .= " password = :password,"; 
        $SQL .= " mobile = :mobile,"; 
        $SQL .= " i_am = :i_am,"; 
        $SQL .= " other_i_am = :other_i_am,"; 
        $SQL .= " insolvency_professional = :insolvency_professional,"; 
        $SQL .= " insolvency_professional_agency = :insolvency_professional_agency,"; 
        $SQL .= " insolvency_professional_number = :insolvency_professional_number,"; 
        $SQL .= " registered_insolvency_professional = :registered_insolvency_professional,"; 
        $SQL .= " registered_insolvency_professional_number = :registered_insolvency_professional_number,"; 
        $SQL .= " young_practitioner = :young_practitioner,"; 
        $SQL .= " young_practitioner_enrolment = :young_practitioner_enrolment,"; 
        $SQL .= " interested = :interested,"; 
        $SQL .= " terms = :terms,"; 
        $SQL .= " committed = :committed,"; 
        $SQL .= " status = :status, ";
        $SQL .= " add_ip = :add_ip, ";
        $SQL .= " add_by = :add_by, ";
        $SQL .= " add_time = :add_time ";
        
        $stmt = $dCON->prepare( $SQL );
        $stmt->bindParam(":member_id", $MAX_ID);
        $stmt->bindParam(":first_name", $first_name); 
        $stmt->bindParam(":middle_name", $middle_name); 
        $stmt->bindParam(":last_name", $last_name); 
        $stmt->bindParam(":address", $address); 
        $stmt->bindParam(":city", $city); 
        $stmt->bindParam(":country", $country); 
        $stmt->bindParam(":pin", $pin); 
        $stmt->bindParam(":permanent_address", $permanent_address); 
        $stmt->bindParam(":permanent_city", $permanent_city); 
        $stmt->bindParam(":permanent_country", $permanent_country); 
        $stmt->bindParam(":permanent_pin", $permanent_pin); 
        $stmt->bindParam(":telephone", $telephone); 
        $stmt->bindParam(":email", $email); 
        $stmt->bindParam(":password", $password); 
        $stmt->bindParam(":mobile", $mobile); 
        $stmt->bindParam(":i_am", $i_am); 
        $stmt->bindParam(":other_i_am", $other_i_am); 
        $stmt->bindParam(":insolvency_professional", $insolvency_professional); 
        $stmt->bindParam(":insolvency_professional_agency", $insolvency_professional_agency); 
        $stmt->bindParam(":insolvency_professional_number", $insolvency_professional_number); 
        $stmt->bindParam(":registered_insolvency_professional", $registered_insolvency_professional); 
        $stmt->bindParam(":registered_insolvency_professional_number", $registered_insolvency_professional_number); 
        $stmt->bindParam(":young_practitioner", $young_practitioner); 
        $stmt->bindParam(":young_practitioner_enrolment", $young_practitioner_enrolment); 
        $stmt->bindParam(":interested", $interested); 
        $stmt->bindParam(":terms", $terms); 
        $stmt->bindParam(":committed", $committed); 
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":add_ip", $IP);
        $stmt->bindParam(":add_by", $BY);
        $stmt->bindParam(":add_time", $TIME);
        $dbRES = $stmt->execute();
        $stmt->closeCursor();
       
        if($dbRES == 1)
        {
            $RTNID = $MAX_ID;
            
            ////////////////user Mail
            sendMailformate("member_register",$RTNID,"");
            
            //////////////Admin Mail
            
            $MAIL_FORMAT = getMailFormat('REGISTRATION',$RTNID,"");
          
            $SUBJECT = $_SESSION['COMPANY_NAME']." : New Registration";
            $TO_EMAIL = $_SESSION['INFO_EMAIL']; 
            
            MailObject($TO_EMAIL,$email,"", "", $SUBJECT, $MAIL_FORMAT, "");
            
            
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
             echo "~~~2~~~You are already registered~~~0~~~";
              break;
        default:
            echo "~~~0~~~Error occured, try again~~~0~~~";
            break;
       
    }
}


function login()
{
    global $dCON;
    $update_time = date("Y-m-d H:i:s");
    
    $email = trustme($_REQUEST['login_email']);
    $password = trustme($_REQUEST['login_password']);
    
    $sessionid = session_id();
    
    $stmt = $dCON->prepare("SELECT * FROM " . BECOME_MEMBER_TBL .  " WHERE status = 'ACTIVE' and payment_status = 'SUCCESSFUL' and email = ? and password = ?");
    $stmt->bindParam(1,$email);
    $stmt->bindParam(2,$password);
    $stmt->execute();
    $row = $stmt->fetchAll();
    $stmt->closeCursor();
    
    //echo "==".trim($row[0]['email'])."--".$email;
    //echo "==".trim($row[0]['password'])."--".$password;
    
    if( trim($row[0]['email']) == $email && trim($row[0]['password']) == $password && trim($row[0]['status']) == "ACTIVE")
    {
        $_SESSION['UID_INSOL'] = intval($row[0]['member_id']);
        $_SESSION['FNAME'] = stripslashes($row[0]['first_name']);
        $_SESSION['MNAME'] = stripslashes($row[0]['middle_name']);
        $_SESSION['LNAME'] = stripslashes($row[0]['last_name']);
        
         $_SESSION['FULLNAME'] = $_SESSION['FNAME'];
        if($_SESSION['MNAME'] !='')
        {
            $_SESSION['FULLNAME'] = $_SESSION['FULLNAME']." ".$_SESSION['MNAME'];
        }
        $_SESSION['FULLNAME'] = $_SESSION['FULLNAME']." ".$_SESSION['LNAME'];
        
        $_SESSION['REG_NUMBER'] = stripslashes($row[0]['reg_number_text']);
        
        $_SESSION['UEMAIL'] = stripslashes($row[0]['email']);
        $_SESSION['UPASS'] = stripslashes($row[0]['password']);
        $_SESSION['UCOUNTRY'] = stripslashes($row[0]['country']);
        $_SESSION['UCITY'] = stripslashes($row[0]['city']);
        
        $_SESSION['MEMBERSHIP_STATUS'] = stripslashes($row[0]['register_status']);
        
        $_SESSION['START_DATE'] = stripslashes($row[0]['membership_start_date']);
        $_SESSION['END_DATE'] = stripslashes($row[0]['membership_expired_date']);
        
        
        $sql  = "";
        $sql .= " UPDATE ".BECOME_MEMBER_TBL." set login_ip = :login_ip, login_date = :login_date ";
        $sql .= " WHERE member_id = :member_id";
        
        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":login_ip", $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(":login_date", $update_time);
        $stmt->bindParam(":member_id",$_SESSION['UID_INSOL']);
        $rs = $stmt->execute();
        $stmt->closeCursor();  
       
        
        echo "~~~1~~~Please wait........";
    }
    else if( trim($row[0]['email']) == $email && trim($row[0]['password']) == $password && trim($row[0]['status']) == "INACTIVE")
    {     
        $_SESSION['UID_INSOL'] = "";
        $_SESSION['FNAME'] = "";
        $_SESSION['MNAME'] = "";
        $_SESSION['LNAME'] = "";
        $_SESSION['FULLNAME'] = "";
        
        $_SESSION['UEMAIL'] = "";
        $_SESSION['UCOUNTRY'] = "";
        $_SESSION['UPASS'] = "";
        $_SESSION['UCITY'] = "";
        
        $_SESSION['MEMBERSHIP_STATUS'] = "";
        
        $_SESSION['START_DATE'] = "";
        $_SESSION['END_DATE'] = "";
        
        
        echo "~~~0~~~Account Inactive";
    }
    else
    {
        $_SESSION['UID_INSOL'] = "";
        $_SESSION['FNAME'] = "";
        $_SESSION['MNAME'] = "";
        $_SESSION['LNAME'] = "";
        $_SESSION['FULLNAME'] = "";
        
        $_SESSION['UEMAIL'] = "";
        $_SESSION['UCOUNTRY'] = "";
        $_SESSION['UPASS'] = "";
        $_SESSION['UCITY'] = "";
        
        $_SESSION['MEMBERSHIP_STATUS'] = "";
        
        $_SESSION['START_DATE'] = "";
        $_SESSION['END_DATE'] = "";
        
        echo "~~~0~~~Invalid username or password";
    }
}

function forgot_password()
{
    global $dCON;
    $fpass_email = trustme($_REQUEST['fpass_email']);
    
    $stmt = $dCON->prepare(" SELECT * FROM " . BECOME_MEMBER_TBL .  " WHERE email = ? AND status <> 'DELETE' AND payment_status = 'SUCCESSFUL' ");
    $stmt->bindParam(1, $fpass_email); 
    $stmt->execute();
    $row = $stmt->fetchAll();
    $stmt->closeCursor();
    
    if(intval(count($row)) > intval(0))
    {
        $member_id = intval($row[0]['member_id']);
       
        $RES =  sendMailformate('FORGOT_PASSWORD',$member_id,$via="");
        
        
        if(intval($RES) == intval(1))
        {
            echo "~~~1~~~Please check your mail for password";
        }
        else
        {
            echo "~~~0~~~Sorry! Please try again.";
        }
        /////////////////send mail to user END!!!!!!!!!!!!!!
    }
    else
    {
        echo "~~~0~~~Email Does Not Exists";
    }
    
     
}


?>