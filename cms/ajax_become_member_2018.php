<?php 
session_start();
error_reporting(0);
include("ajax_include.php");   

define("PAGE_MAIN","become_member.php"); 
define("EDIT_MAIN","become_member_edit.php"); 
define("PAGE_AJAX","ajax_become_member.php");
define("PAGE_LIST","become_member_list.php"); 

$type =  trustme($_REQUEST['type']);
switch($type)
{
    case "removeImage":
        removeImage();
    break;
    case "saveData":
        saveData();
    break;
    case "editData":
        editData();
        break;
    case "listData":
        listData();
        break;   
    case "deleteData":
        deleteData();
        break; 
    case "deleteSelected":
        deleteSelected();
        break;
    case "setStatus":
        setStatus();
        break; 
    case "registerSave":
        registerSave();
        break; 
    case "sendMail":
        sendMail();
        break; 
        
    case "sendapprovalMAIL":
        sendapprovalMAIL();
        break;
    
                 
} 

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_PAYMENT_RECIEPT;
    
    if($imageId == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
        {
            deleteIMG("PAYMENT_RECIEPT_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
    }
    else
    {
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("PAYMENT_RECIEPT_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                        
            $SQL = "";
            $SQL .= "UPDATE " . BECOME_MEMBER_TBL . " SET " ;
            $SQL .= " reciept_image_name = :image_name ";
            $SQL .= " image_id = :image_id ";
            $SQL .= " WHERE member_id = :member_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
            
            $image_name = "";
            $img_id = intval(0);            
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":image_name", $image_name);
            $stk_upd->bindParam(":image_id", $img_id);
            $stk_upd->bindParam(":member_id", $imageId);
            $stk_upd->execute();
            
            $stk_upd->closeCursor();
             
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
        
    } 
}

function saveData()
{ 
    global $dCON;
    
    $permanent_address = "";
    $permanent_address_2 = "";
    $permanent_city = "";
    $permanent_state = ""; 
    $permanent_country = ""; 
    $permanent_pin = "";
    $residence_telephone = "";
  
    $title = trustme($_REQUEST["title"]);
    $first_name = trustme($_REQUEST["first_name"]); 
    $middle_name = trustme($_REQUEST["middle_name"]); 
    $last_name = trustme($_REQUEST["last_name"]);
    $suffix = trustme($_REQUEST["suffix"]); 
    $firm_name = trustme($_REQUEST["firm_name"]);
    $address = trustme($_REQUEST["address"]); 
    $correspondence_address_2 = trustme($_REQUEST["correspondence_address_2"]); 
    $city = trustme($_REQUEST["city"]); 
    $correspondence_state = trustme($_REQUEST["correspondence_state"]);
    $country = trustme($_REQUEST["country"]); 
    $pin = trustme($_REQUEST["pin"]); 
    
    $permanent_address = trustme($_REQUEST["permanent_address"]); 
    if($permanent_address == ""){
        $permanent_address = $address;
    }
    
    $permanent_address_2 = trustme($_REQUEST["permanent_address_2"]);
    if($permanent_address_2 == ""){
        $permanent_address_2 = $correspondence_address_2;
    }
    
    $permanent_city = trustme($_REQUEST["permanent_city"]); 
    if($permanent_city == ""){
        $permanent_city = $city;
    }
    
    $permanent_state = trustme($_REQUEST["permanent_state"]);
    if($permanent_state == ""){
        $permanent_state = $correspondence_state;
    }
    
    $permanent_country = trustme($_REQUEST["permanent_country"]); 
    if($permanent_country == ""){
        $permanent_country = $country;
    }
    
    $permanent_pin = trustme($_REQUEST["permanent_pin"]); 
    if($permanent_pin == ""){
        $permanent_pin = $pin;
    }
        
    $telephone = trustme($_REQUEST["telephone"]); 
    $residence_telephone = trustme($_REQUEST["residence_telephone"]); 
    $email = trustme($_REQUEST["email"]); 
     
    $mobile = trustme($_REQUEST["mobile"]); 
    $fax = trustme($_REQUEST["fax"]);
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
    
    $membership_starts_date = trustme($_REQUEST["membership_starts_date"]); 
    
    $membership_starts_date_array = explode("-", $membership_starts_date);
    $MEMBERSHIP_STARTS_DATE = $membership_starts_date_array[2] . "-" . $membership_starts_date_array[1] . "-" . $membership_starts_date_array[0];
    
    $sig_member = intval($_REQUEST["sig_member"]);
    if($sig_member == intval(1)){ 
    $sig_company_id = intval($_REQUEST["sig_company_id"]);
    $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id","$sig_company_id",'=', '', '' , "");
    }else{
        $sig_company_id = intval(0);
        $sig_company_name ="";
    }
    
    $interested = trustme($_REQUEST["interested"]); 
    
    $terms = intval($_REQUEST["terms"]); 
    $committed = intval($_REQUEST["committed"]); 
    $password = rand(100000,999999);
    
    
    $payment_status = trustme($_REQUEST["payment_status"]);
    $payment_text = trustme($_REQUEST["payment_text"]);
    $old_register_status = trustme($_REQUEST["old_register_status"]);
    $old_payment_status = trustme($_REQUEST["old_payment_status"]);
    
    $member_id = intval($_REQUEST['id']);
    $con = trustme($_REQUEST['con']);        
   
    $status = "ACTIVE";         
    $IP = trustme($_SERVER['REMOTE_ADDR']);                  
    $TIME = date("Y-m-d H:i:s");
    $BY = 'admin';
    
    if($sig_member == intval(1))
    {
        $payment_status = 'SUCCESSFUL';
    }
    
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']);
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/"; 
    
   
    
    if($con == "add")
    {
        $CHK = checkDuplicate(BECOME_MEMBER_TBL,"status~~~email","ACTIVE~~~".$email,"=~~~=","");   
         
        if( intval($CHK) == intval(0) )
        {
            
            $MAX_ID = getMaxId(BECOME_MEMBER_TBL, "member_id");  
            $register_status = 'Approved';
             
            if($image != "")
            {
                
                $name_filter = filterString($first_name);
                $i_ext = pathinfo($image);
                
                $imgpath_name =  $name_filter ."_".$MAX_ID. ".". $i_ext['extension'];
                rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                //resizeIMG("PAYMENT_RECIEPT_IMG",trim($imgpath_name),$MAX_ID,$FOLDER_NAME);
                
                $image_id = intval(1);
            }
            else
            {
                $imgpath_name = "";
                $image_id = intval(0);
            }
           
            if(strtoupper($payment_status) =='SUCCESSFUL')
            {
                $reg_number = "";
                $reg_number_text = "";
                $membership_start_date = "0000-00-00";
                $membership_expired_date = "0000-00-00";
  
                $SQL  = "";
                $SQL .= " SELECT IFNULL(MAX(reg_number) + 1, 151) as max_reg_number FROM ".BECOME_MEMBER_TBL." where payment_status = 'SUCCESSFUL' ";
                $stmt = $dCON->prepare( $SQL );
                $stmt->execute();
                $row = $stmt->fetchAll();
                $stmt->closeCursor();
                $reg_number = intval($row[0]['max_reg_number']);
                if(intval($reg_number)<=1)
                {
                    $reg_number = 151;
                }
                $reg_number_text = 'INSOL/'.$reg_number;
                
                if($sig_member == intval(0))
                {
                    $membership_start_date = date("Y-m-d");
                    $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
                }else{
                    //$member_since_date = getDetails(SIG24_TBL, 'member_since_date', "sig24_id","$sig_company_id",'=', '', '' , "");
                    //$membership_start_date = date('Y-m-d', strtotime($member_since_date));
                    //$membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($member_since_date)));
                    $membership_start_date = $MEMBERSHIP_STARTS_DATE;
                    $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($membership_start_date)));
                }
            }
            
            $SQL  = "";
            $SQL .= " INSERT INTO " . BECOME_MEMBER_TBL . " SET ";
            $SQL .= " member_id = :member_id, "; 
            $SQL .= " reg_number_text = :reg_number_text, ";
            $SQL .= " reg_number = :reg_number, ";
            $SQL .= " title = :title,"; 
            $SQL .= " first_name = :first_name,"; 
            $SQL .= " middle_name = :middle_name,"; 
            $SQL .= " last_name = :last_name,"; 
            $SQL .= " suffix = :suffix,";
            $SQL .= " firm_name = :firm_name,"; 
            $SQL .= " address = :address,"; 
            $SQL .= " correspondence_address_2 = :correspondence_address_2,";
            $SQL .= " city = :city,"; 
            $SQL .= " correspondence_state = :correspondence_state,";
            $SQL .= " country = :country,"; 
            $SQL .= " pin = :pin,"; 
            
            $SQL .= " permanent_address = :permanent_address,"; 
            $SQL .= " permanent_address_2 = :permanent_address_2,";
            $SQL .= " permanent_city = :permanent_city,"; 
            $SQL .= " permanent_state = :permanent_state,";
            $SQL .= " permanent_country = :permanent_country,"; 
            $SQL .= " permanent_pin = :permanent_pin,"; 
            
            $SQL .= " telephone = :telephone,"; 
            $SQL .= " residence_telephone = :residence_telephone,";
            $SQL .= " email = :email,"; 
            $SQL .= " password = :password,"; 
            $SQL .= " mobile = :mobile,"; 
            $SQL .= " fax = :fax,"; 
            $SQL .= " i_am = :i_am,"; 
            $SQL .= " other_i_am = :other_i_am,"; 
            $SQL .= " insolvency_professional = :insolvency_professional,"; 
            $SQL .= " insolvency_professional_agency = :insolvency_professional_agency,"; 
            $SQL .= " insolvency_professional_number = :insolvency_professional_number,"; 
            $SQL .= " registered_insolvency_professional = :registered_insolvency_professional,"; 
            $SQL .= " registered_insolvency_professional_number = :registered_insolvency_professional_number,"; 
            $SQL .= " young_practitioner = :young_practitioner,"; 
            $SQL .= " young_practitioner_enrolment = :young_practitioner_enrolment,"; 
            $SQL .= " sig_member = :sig_member,"; 
            $SQL .= " sig_company_id = :sig_company_id,"; 
            $SQL .= " sig_company_name = :sig_company_name,"; 
            $SQL .= " interested = :interested,"; 
            $SQL .= " reciept_image_name = :image_name, ";
            $SQL .= " image_id = :image_id, ";
            $SQL .= " terms = :terms,"; 
            $SQL .= " committed = :committed,"; 
            $SQL .= " register_status = :register_status, ";
            $SQL .= " payment_status = :payment_status, ";
            $SQL .= " payment_text = :payment_text, ";
            $SQL .= " membership_start_date = :membership_start_date, ";
            $SQL .= " membership_expired_date = :membership_expired_date, ";
            
            $SQL .= " status = :status, ";
            $SQL .= " add_ip = :add_ip, ";
            $SQL .= " add_by = :add_by, ";
            $SQL .= " add_time = :add_time ";
            
            $stmt = $dCON->prepare( $SQL );
            $stmt->bindParam(":member_id", $MAX_ID);
            $stmt->bindParam(":reg_number_text", $reg_number_text); 
            $stmt->bindParam(":reg_number", $reg_number); 
            $stmt->bindParam(":title", $title);
            $stmt->bindParam(":first_name", $first_name); 
            $stmt->bindParam(":middle_name", $middle_name); 
            $stmt->bindParam(":last_name", $last_name); 
            $stmt->bindParam(":suffix", $suffix);
            $stmt->bindParam(":firm_name", $firm_name);
            $stmt->bindParam(":address", $address); 
            $stmt->bindParam(":correspondence_address_2", $correspondence_address_2);
            $stmt->bindParam(":city", $city); 
            $stmt->bindParam(":correspondence_state", $correspondence_state);
            $stmt->bindParam(":country", $country); 
            $stmt->bindParam(":pin", $pin);
            
            $stmt->bindParam(":permanent_address", $permanent_address); 
            $stmt->bindParam(":permanent_address_2", $permanent_address_2);
            $stmt->bindParam(":permanent_city", $permanent_city); 
            $stmt->bindParam(":permanent_state", $permanent_state);
            $stmt->bindParam(":permanent_country", $permanent_country); 
            $stmt->bindParam(":permanent_pin", $permanent_pin); 
           
             
            $stmt->bindParam(":telephone", $telephone); 
            $stmt->bindParam(":residence_telephone", $residence_telephone);
            $stmt->bindParam(":email", $email); 
            $stmt->bindParam(":password", $password); 
            $stmt->bindParam(":mobile", $mobile);
            $stmt->bindParam(":fax", $fax); 
            $stmt->bindParam(":i_am", $i_am); 
            $stmt->bindParam(":other_i_am", $other_i_am); 
            $stmt->bindParam(":insolvency_professional", $insolvency_professional); 
            $stmt->bindParam(":insolvency_professional_agency", $insolvency_professional_agency); 
            $stmt->bindParam(":insolvency_professional_number", $insolvency_professional_number); 
            $stmt->bindParam(":registered_insolvency_professional", $registered_insolvency_professional); 
            $stmt->bindParam(":registered_insolvency_professional_number", $registered_insolvency_professional_number); 
            $stmt->bindParam(":young_practitioner", $young_practitioner); 
            $stmt->bindParam(":young_practitioner_enrolment", $young_practitioner_enrolment);
            $stmt->bindParam(":sig_member", $sig_member); 
            $stmt->bindParam(":sig_company_id", $sig_company_id); 
            $stmt->bindParam(":sig_company_name", $sig_company_name);  
            $stmt->bindParam(":interested", $interested);
            $stmt->bindParam(":image_name", $imgpath_name);
            $stmt->bindParam(":image_id", $image_id);  
            $stmt->bindParam(":terms", $terms); 
            $stmt->bindParam(":committed", $committed); 
            $stmt->bindParam(":register_status",$register_status);
            $stmt->bindParam(":payment_status",$payment_status);
            $stmt->bindParam(":payment_text",$payment_text);
            $stmt->bindParam(":membership_start_date",$membership_start_date);
            $stmt->bindParam(":membership_expired_date",$membership_expired_date);
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":add_ip", $IP);
            $stmt->bindParam(":add_by", $BY);
            $stmt->bindParam(":add_time", $TIME);
            $dbRES = $stmt->execute();
            $stmt->closeCursor();
           
            if($dbRES == 1)
            {
                $RTNID = $MAX_ID;
                if(strtoupper($payment_status) =='SUCCESSFUL')
                {
                    sendMailformate('PAYMENT_MAIL',$RTNID,"ADMIN");
                } 
                
            }
        }
        else
        {
            $dbRES = 2;
        }
    
    }
    
    else if($con == "modify")
    {
        $CHK = checkDuplicate(BECOME_MEMBER_TBL,"status~~~email~~~member_id","ACTIVE~~~$email~~~$member_id","=~~~=~~~<>","");
        if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $name_filter = filterString($first_name);
                    $i_ext = pathinfo($image);
                    
                    $imgpath_name =  $name_filter ."_".$member_id. "." . $i_ext['extension'];
                    rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                    //resizeIMG("PAYMENT_RECIEPT_IMG",trim($imgpath_name),$id,$FOLDER_NAME);
                    
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
            else
            {
                if($image != "")
                {                   
                    $imgpath_name =  $image;             
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
  
        if( intval($CHK) == intval(0) )
        { 
            $register_status = trustme($_REQUEST["register_status"]);
           
            if($register_status =="")
            {
                $register_status = ucfirst(strtolower($old_register_status));
            }
            
            if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
            {
                
                if(trim($_REQUEST["reg_number_text"]) =='' && intval($_REQUEST["reg_number"]) <=intval(0))
                {
                    $SQL  = "";
                    $SQL .= " SELECT IFNULL(MAX(reg_number) + 1, 151) as max_reg_number FROM ".BECOME_MEMBER_TBL." where payment_status = 'SUCCESSFUL' ";
                    $stmt = $dCON->prepare( $SQL );
                    $stmt->execute();
                    $row = $stmt->fetchAll();
                    $stmt->closeCursor();
                    $reg_number = intval($row[0]['max_reg_number']);
                    if(intval($reg_number)<=1)
                    {
                        $reg_number = 151;
                    }
                    $reg_number_text = 'INSOL/'.$reg_number;
                }
                else
                {
                    $reg_number = intval($_REQUEST["reg_number"]);
                    $reg_number_text = trustme($_REQUEST["reg_number_text"]);
                }
                
               
                    $membership_start_date = date("Y-m-d");
                    $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
                
            }
            else
            {
                $reg_number = intval($_REQUEST["reg_number"]);
                $reg_number_text = trustme($_REQUEST["reg_number_text"]);
            }
            
            if($sig_member == intval(1))
            {
                //$member_since_date = getDetails(SIG24_TBL, 'member_since_date', "sig24_id","$sig_company_id",'=', '', '' , "");
                //$membership_start_date = date('Y-m-d', strtotime($member_since_date));
                //$membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($member_since_date)));
                $membership_start_date = $MEMBERSHIP_STARTS_DATE;
                $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($membership_start_date)));
            }
            
            $SQL  = "";
            $SQL .= " UPDATE " . BECOME_MEMBER_TBL . " SET ";
            $SQL .= " reg_number_text = :reg_number_text, ";
            $SQL .= " reg_number = :reg_number, ";
            $SQL .= " title = :title,"; 
            $SQL .= " first_name = :first_name,";  
            $SQL .= " middle_name = :middle_name,"; 
            $SQL .= " last_name = :last_name,"; 
            $SQL .= " suffix = :suffix,";
            $SQL .= " firm_name = :firm_name,";
            $SQL .= " address = :address,"; 
            $SQL .= " correspondence_address_2 = :correspondence_address_2,";
            $SQL .= " city = :city,"; 
            $SQL .= " correspondence_state = :correspondence_state,";
            $SQL .= " country = :country,"; 
            $SQL .= " pin = :pin,"; 
            
            $SQL .= " permanent_address = :permanent_address,"; 
            $SQL .= " permanent_address_2 = :permanent_address_2,";
            $SQL .= " permanent_city = :permanent_city,"; 
            $SQL .= " permanent_state = :permanent_state,";
            $SQL .= " permanent_country = :permanent_country,"; 
            $SQL .= " permanent_pin = :permanent_pin,"; 
            
            $SQL .= " telephone = :telephone,"; 
            $SQL .= " residence_telephone = :residence_telephone,";
            $SQL .= " email = :email,"; 
            $SQL .= " password = :password,"; 
            $SQL .= " mobile = :mobile,"; 
            $SQL .= " fax = :fax,";
            $SQL .= " i_am = :i_am,"; 
            $SQL .= " other_i_am = :other_i_am,"; 
            $SQL .= " insolvency_professional = :insolvency_professional,"; 
            $SQL .= " insolvency_professional_agency = :insolvency_professional_agency,"; 
            $SQL .= " insolvency_professional_number = :insolvency_professional_number,"; 
            $SQL .= " registered_insolvency_professional = :registered_insolvency_professional,"; 
            $SQL .= " registered_insolvency_professional_number = :registered_insolvency_professional_number,"; 
            $SQL .= " young_practitioner = :young_practitioner,"; 
            $SQL .= " young_practitioner_enrolment = :young_practitioner_enrolment,";
            $SQL .= " sig_member = :sig_member,"; 
            $SQL .= " sig_company_id = :sig_company_id,"; 
            $SQL .= " sig_company_name = :sig_company_name,";
             
            $SQL .= " interested = :interested,";
            $SQL .= " reciept_image_name = :image_name, ";
            $SQL .= " image_id = :image_id, "; 
            $SQL .= " terms = :terms,"; 
            $SQL .= " committed = :committed,"; 
            $SQL .= " register_status = :register_status,"; 
            $SQL .= " payment_status = :payment_status,"; 
            $SQL .= " payment_text = :payment_text,"; 
            $SQL .= " membership_start_date = :membership_start_date,"; 
            $SQL .= " membership_expired_date = :membership_expired_date,"; 
            
            $SQL .= " status = :status, ";
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, "; 
            $SQL .= " update_by = :update_by "; 
            $SQL .= " WHERE member_id = :member_id ";
             
            $stmt = $dCON->prepare($SQL);
            $stmt->bindParam(":reg_number_text", $reg_number_text); 
            $stmt->bindParam(":reg_number", $reg_number); 
             $stmt->bindParam(":title", $title);
            $stmt->bindParam(":first_name", $first_name); 
            $stmt->bindParam(":middle_name", $middle_name); 
            $stmt->bindParam(":last_name", $last_name); 
            $stmt->bindParam(":suffix", $suffix);
            $stmt->bindParam(":firm_name", $firm_name);
            $stmt->bindParam(":address", $address); 
            $stmt->bindParam(":correspondence_address_2", $correspondence_address_2);
            $stmt->bindParam(":city", $city); 
            $stmt->bindParam(":correspondence_state", $correspondence_state);
            $stmt->bindParam(":country", $country); 
            $stmt->bindParam(":pin", $pin); 
            
            $stmt->bindParam(":permanent_address", $permanent_address); 
            $stmt->bindParam(":permanent_address_2", $permanent_address_2);
            $stmt->bindParam(":permanent_city", $permanent_city); 
            $stmt->bindParam(":permanent_state", $permanent_state);
            $stmt->bindParam(":permanent_country", $permanent_country); 
            $stmt->bindParam(":permanent_pin", $permanent_pin); 
           
            
            $stmt->bindParam(":telephone", $telephone); 
            $stmt->bindParam(":residence_telephone", $residence_telephone);
            $stmt->bindParam(":email", $email); 
            $stmt->bindParam(":password", $password); 
            $stmt->bindParam(":mobile", $mobile); 
            $stmt->bindParam(":fax", $fax);
            $stmt->bindParam(":i_am", $i_am); 
            $stmt->bindParam(":other_i_am", $other_i_am); 
            $stmt->bindParam(":insolvency_professional", $insolvency_professional); 
            $stmt->bindParam(":insolvency_professional_agency", $insolvency_professional_agency); 
            $stmt->bindParam(":insolvency_professional_number", $insolvency_professional_number); 
            $stmt->bindParam(":registered_insolvency_professional", $registered_insolvency_professional); 
            $stmt->bindParam(":registered_insolvency_professional_number", $registered_insolvency_professional_number); 
            $stmt->bindParam(":young_practitioner", $young_practitioner); 
            $stmt->bindParam(":young_practitioner_enrolment", $young_practitioner_enrolment); 
            $stmt->bindParam(":sig_member", $sig_member); 
            $stmt->bindParam(":sig_company_id", $sig_company_id); 
            $stmt->bindParam(":sig_company_name", $sig_company_name);
            $stmt->bindParam(":interested", $interested); 
            $stmt->bindParam(":image_name", $imgpath_name);
            $stmt->bindParam(":image_id", $image_id);
            $stmt->bindParam(":terms", $terms); 
            $stmt->bindParam(":committed", $committed); 
            $stmt->bindParam(":register_status",$register_status);
            $stmt->bindParam(":payment_status",$payment_status);
            $stmt->bindParam(":payment_text",$payment_text);
            $stmt->bindParam(":membership_start_date",$membership_start_date);
            $stmt->bindParam(":membership_expired_date",$membership_expired_date);         
           
            
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":update_ip", $IP);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":member_id", $member_id); 
            $dbRES = $stmt->execute();  
            $stmt->closeCursor(); 
            if( intval($dbRES) == intval(1) )
            {
                $RTNID = $member_id;
                
                if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
                {
                    sendMailformate('PAYMENT_MAIL',$RTNID,"ADMIN");
                } 
                
            }
        }
        else
        {
            $dbRES = 2;
        }
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





function editData()
{
    global $dCON;
    
    
    $member_id = intval($_REQUEST['id']);
    
    $title = trustme($_REQUEST["title"]); 
    $first_name = trustme($_REQUEST["first_name"]); 
    $middle_name = trustme($_REQUEST["middle_name"]); 
    $last_name = trustme($_REQUEST["last_name"]); 
    $suffix = trustme($_REQUEST["suffix"]);
    $firm_name = trustme($_REQUEST["firm_name"]); 
    $address = trustme($_REQUEST["address"]); 
    $correspondence_address_2 = trustme($_REQUEST["correspondence_address_2"]);
    $city = trustme($_REQUEST["city"]); 
    $correspondence_state = trustme($_REQUEST["correspondence_state"]);
    $country = trustme($_REQUEST["country"]); 
    $pin = trustme($_REQUEST["pin"]); 
    
    $permanent_address = trustme($_REQUEST["permanent_address"]); 
    $permanent_address_2 = trustme($_REQUEST["permanent_address_2"]);
    $permanent_city = trustme($_REQUEST["permanent_city"]); 
    $permanent_state = trustme($_REQUEST["permanent_state"]);
    $permanent_country = trustme($_REQUEST["permanent_country"]); 
    $permanent_pin = trustme($_REQUEST["permanent_pin"]); 
     
    
    $telephone = trustme($_REQUEST["telephone"]); 
    $residence_telephone = trustme($_REQUEST["residence_telephone"]); 
    $email = trustme($_REQUEST["email"]); 
    $fax= trustme($_REQUEST["fax"]); 
     
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
    
    $sig_member = intval($_REQUEST["sig_member"]);
    if($sig_member == intval(1)){ 
    $sig_company_id = intval($_REQUEST["sig_company_id"]);
    $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id","$sig_company_id",'=', '', '' , "");
    }else{
        $sig_company_id = intval(0);
        $sig_company_name ="";
    }
    
    $interested = trustme($_REQUEST["interested"]); 
    
    $membership_starts_date = trustme($_REQUEST["membership_starts_date"]); 
    
    $membership_starts_date_array = explode("-", $membership_starts_date);
    $MEMBERSHIP_STARTS_DATE = $membership_starts_date_array[2] . "-" . $membership_starts_date_array[1] . "-" . $membership_starts_date_array[0];
    
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']);
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/"; 
    
    if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $name_filter = filterString($first_name);
                    $i_ext = pathinfo($image);
                    
                    $imgpath_name =  $name_filter ."_".$member_id. "." . $i_ext['extension'];
                    rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                    //resizeIMG("PAYMENT_RECIEPT_IMG",trim($imgpath_name),$id,$FOLDER_NAME);
                    
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
            else
            {
                if($image != "")
                {                   
                    $imgpath_name =  $image;             
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
    
    
    $con = trustme($_REQUEST['con']);
    $BY = 'admin';
    
    $register_status = trustme($_REQUEST["register_status"]);
    $payment_status = trustme($_REQUEST["payment_status"]);
    $payment_text = trustme($_REQUEST["payment_text"]);
    
    
    // for sig member if status is approved==========
    if($register_status == 'Approved' && $sig_member == intval(1)){
        $payment_status = 'SUCCESSFUL';
    }
   
    // for sig member if status is approved======ends
    $sendStatus = trustme($_REQUEST['sendStatus']); 
    
    $old_register_status = trustme($_REQUEST["old_register_status"]);
    $old_payment_status = trustme($_REQUEST["old_payment_status"]);
    
    
    $reg_number_temp="";
    $reg_number_text_temp="";
    
    if(strtolower($register_status) =='approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved') )
    {
        $SQL  = "";
        $SQL .= " SELECT IFNULL(MAX(reg_number_temp) + 1, 151) as max_reg_number_temp FROM ".BECOME_MEMBER_TBL." where register_status = 'approved' ";
        $stmt = $dCON->prepare( $SQL );
        $stmt->execute();
        $row = $stmt->fetchAll();
        $stmt->closeCursor();
        $reg_number_temp = intval($row[0]['max_reg_number_temp']);
        if(intval($reg_number_temp)<=1)
        {
            $reg_number_temp = 151;
        }
        $reg_number_text_temp = 'INSOL/T/'.$reg_number_temp;
        
    }
    
    //exit;
    $reg_number = "";
    $reg_number_text = "";
    $membership_start_date = "0000-00-00";
    $membership_expired_date = "0000-00-00";
        
    if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
    { 
        
        if(trim($_REQUEST["reg_number_text"]) =='' && intval($_REQUEST["reg_number"]) <=intval(0))
        {
            $SQL  = "";
            $SQL .= " SELECT IFNULL(MAX(reg_number) + 1, 151) as max_reg_number FROM ".BECOME_MEMBER_TBL." where payment_status = 'SUCCESSFUL' ";
            $stmt = $dCON->prepare( $SQL );
            $stmt->execute();
            $row = $stmt->fetchAll();
            $stmt->closeCursor();
            $reg_number = intval($row[0]['max_reg_number']);
            if(intval($reg_number)<=1)
            {
                $reg_number = 151;
            }
            $reg_number_text = 'INSOL/'.$reg_number;
        }
        else
        {
            $reg_number = intval($_REQUEST["reg_number"]);
            $reg_number_text = trustme($_REQUEST["reg_number_text"]);
        }
        
            $membership_start_date = date("Y-m-d");
            $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
        
        
    }
    
    if($sig_member == intval(1))
    {
        //$member_since_date = getDetails(SIG24_TBL, 'member_since_date', "sig24_id","$sig_company_id",'=', '', '' , "");
        //$membership_start_date = date('Y-m-d', strtotime($member_since_date));
        //$membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($member_since_date))); 
        $membership_start_date = $MEMBERSHIP_STARTS_DATE;
        $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($MEMBERSHIP_STARTS_DATE)));
        
    }
   
    $ip = trustme($_SERVER['REMOTE_ADDR']);
    $update_time = date("Y-m-d H:i:s");
    
    
    $sql  = "";
    $sql .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET ";
    $sql .= " title = :title,";
    $sql .= " first_name = :first_name,"; 
    $sql .= " middle_name = :middle_name,"; 
    $sql .= " last_name = :last_name,"; 
    $sql .= " suffix = :suffix,";
    $sql .= " firm_name = :firm_name,";
    $sql .= " address = :address,"; 
    $sql .= " correspondence_address_2 = :correspondence_address_2,";
    $sql .= " city = :city,"; 
    $sql .= " correspondence_state = :correspondence_state,";
    $sql .= " country = :country,"; 
    $sql .= " pin = :pin,"; 
    
    $sql .= " permanent_address = :permanent_address,"; 
    $sql .= " permanent_address_2 = :permanent_address_2,";
    $sql .= " permanent_city = :permanent_city,"; 
    $sql .= " permanent_state = :permanent_state,";
    $sql .= " permanent_country = :permanent_country,"; 
    $sql .= " permanent_pin = :permanent_pin,"; 
    
    $sql .= " telephone = :telephone,"; 
    $sql .= " residence_telephone = :residence_telephone,"; 
    $sql .= " email = :email,"; 
    $sql .= " fax = :fax,"; 
    //$sql .= " password = :password,"; 
    $sql .= " mobile = :mobile,"; 
    $sql .= " i_am = :i_am,"; 
    $sql .= " other_i_am = :other_i_am,"; 
    $sql .= " insolvency_professional = :insolvency_professional,"; 
    $sql .= " insolvency_professional_agency = :insolvency_professional_agency,"; 
    $sql .= " insolvency_professional_number = :insolvency_professional_number,"; 
    $sql .= " registered_insolvency_professional = :registered_insolvency_professional,"; 
    $sql .= " registered_insolvency_professional_number = :registered_insolvency_professional_number,"; 
    $sql .= " young_practitioner = :young_practitioner,"; 
    $sql .= " young_practitioner_enrolment = :young_practitioner_enrolment,"; 
    $sql .= " sig_member = :sig_member,"; 
    $sql .= " sig_company_id = :sig_company_id,"; 
    $sql .= " sig_company_name = :sig_company_name,";
    $sql .= " interested = :interested,";
    $sql .= " reciept_image_name = :image_name, ";
    $sql .= " image_id = :image_id, ";  
    
    if($payment_status !='')
    { 
        $sql .= " payment_status = :payment_status, ";
        $sql .= " payment_text = :payment_text, ";
        if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
        {
            $sql .= " reg_number_text = :reg_number_text, ";
            $sql .= " reg_number = :reg_number, ";
            
        }
    }
    
    if($register_status !='')
    {
        if(strtolower($register_status) =='approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved') )
        {
            $sql .= " reg_number_text_temp = :reg_number_text_temp, ";
            $sql .= " reg_number_temp = :reg_number_temp, ";
        }
        
        $sql .= " register_status = :register_status, ";
    }
    $sql .= " membership_start_date = :membership_start_date, ";
    $sql .= " membership_expired_date = :membership_expired_date, ";
    $sql .= " update_ip = :update_ip, "; 
    $sql .= " update_by = :update_by, "; 
    $sql .= " update_time = :update_time ";
    $sql .= " WHERE member_id = :member_id";
    //  echo $sql; exit;              
    $stmt3 = $dCON->prepare($sql);    
    $stmt3->bindParam(":title", $title);     
    $stmt3->bindParam(":first_name", $first_name); 
    $stmt3->bindParam(":middle_name", $middle_name); 
    $stmt3->bindParam(":last_name", $last_name); 
    $stmt3->bindParam(":suffix", $suffix);
    $stmt3->bindParam(":firm_name", $firm_name);
    $stmt3->bindParam(":address", $address); 
    $stmt3->bindParam(":correspondence_address_2", $correspondence_address_2); 
    $stmt3->bindParam(":city", $city); 
    $stmt3->bindParam(":correspondence_state", $correspondence_state);
    $stmt3->bindParam(":country", $country); 
    $stmt3->bindParam(":pin", $pin); 
    
    $stmt3->bindParam(":permanent_address", $permanent_address); 
    $stmt3->bindParam(":permanent_address_2", $permanent_address_2);
    $stmt3->bindParam(":permanent_city", $permanent_city); 
    $stmt3->bindParam(":permanent_state", $permanent_state);
    $stmt3->bindParam(":permanent_country", $permanent_country); 
    $stmt3->bindParam(":permanent_pin", $permanent_pin); 
    
    $stmt3->bindParam(":telephone", $telephone); 
    $stmt3->bindParam(":residence_telephone", $residence_telephone);
    $stmt3->bindParam(":email", $email); 
    $stmt3->bindParam(":fax", $fax); 
    //$stmt3->bindParam(":password", $password); 
    $stmt3->bindParam(":mobile", $mobile); 
    $stmt3->bindParam(":i_am", $i_am); 
    $stmt3->bindParam(":other_i_am", $other_i_am); 
    $stmt3->bindParam(":insolvency_professional", $insolvency_professional); 
    $stmt3->bindParam(":insolvency_professional_agency", $insolvency_professional_agency); 
    $stmt3->bindParam(":insolvency_professional_number", $insolvency_professional_number); 
    $stmt3->bindParam(":registered_insolvency_professional", $registered_insolvency_professional); 
    $stmt3->bindParam(":registered_insolvency_professional_number", $registered_insolvency_professional_number); 
    $stmt3->bindParam(":young_practitioner", $young_practitioner); 
    $stmt3->bindParam(":young_practitioner_enrolment", $young_practitioner_enrolment); 
    $stmt3->bindParam(":sig_member", $sig_member); 
    $stmt3->bindParam(":sig_company_id", $sig_company_id); 
    $stmt3->bindParam(":sig_company_name", $sig_company_name);
    $stmt3->bindParam(":interested", $interested);  
    $stmt3->bindParam(":image_name", $imgpath_name);
    $stmt3->bindParam(":image_id", $image_id);
     
    if($payment_status !='')
    { 
        $stmt3->bindParam(":payment_status",$payment_status);
        $stmt3->bindParam(":payment_text",$payment_text);
        if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
        {
            $stmt3->bindParam(":reg_number_text", $reg_number_text); 
            $stmt3->bindParam(":reg_number", $reg_number); 
            
        }
	}
    
    if($register_status !='')
    {
        if(strtolower($register_status) =='approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved') )
        {
            $stmt3->bindParam(":reg_number_text_temp", $reg_number_text_temp); 
            $stmt3->bindParam(":reg_number_temp", $reg_number_temp); 
        }
        $stmt3->bindParam(":register_status",$register_status);
  	}
    $stmt3->bindParam(":membership_start_date",$membership_start_date);
    $stmt3->bindParam(":membership_expired_date",$membership_expired_date);
	$stmt3->bindParam(":update_ip",$ip);
    $stmt3->bindParam(":update_by", $BY);
 	$stmt3->bindParam(":update_time",$update_time);
	$stmt3->bindParam(":member_id",$member_id);
    $rs = $stmt3->execute();
    if($rs == 1)
    {
        if(strtolower($register_status) =='approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved') )
        {
            if($sig_member == intval(0))
            {
                sendMailformate('approved',$member_id,"ADMIN");
            }
        }
        
        if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
        {
            sendMailformate('PAYMENT_MAIL',$member_id,"ADMIN");
        } 
    }
 
    
    switch($rs)
    {
        case "1":
            echo "~~~1~~~Successfully saved";
            break;
         default:
            echo "~~~0~~~Sorry cannot process your request";
            break;
    } 


}








function listData()
{        
    global $dCON;
    global $pg;
        
    
    $search_user_name = trustme($_REQUEST['search_user_name']);
    $search_email = trustme($_REQUEST['search_email']);
    $search_reg_number = trustme($_REQUEST['search_reg_number']);
    $search_sig_member = trustme($_REQUEST['search_sig_member']);
    
    
    $search_register_status = trustme($_REQUEST['search_register_status']);   
    $search_payment_status = trustme($_REQUEST['search_payment_status']);   

    $search_from_date = trustme($_REQUEST['search_from_date']);
    $search_to_date = trustme($_REQUEST['search_to_date']);
  
    if ( trim($search_from_date) != "" )
    {
	    $search_from_date_time = date('Y-m-d', strtotime($search_from_date));	 
    }
    else
    {
        $search_from_date_time = "";    
    }
    
    if ( trim($search_to_date) != "" )
    {
        $search_to_date_time = date('Y-m-d', strtotime($search_to_date));	 
    }
    else
    {
        $search_to_date_time = "";    
    }
    
    
    $search = "";
              
   
    if( trim($search_user_name) != "")
    {
        $search .= " and (first_name LIKE :user_name) or (last_name LIKE :user_name) or (concat_ws(' ',first_name,last_name) LIKE :user_name ) ";
        //$search .= " AND O.customer_name LIKE :user_name ";
    }
    
    if( trim($search_email) != "")
    {
        $search .= " AND email = '".$search_email."' ";
    }
    
    if( trim($search_reg_number) != "")
    {
        $search .= " AND (reg_number_text LIKE :reg_number or reg_number= '".$search_reg_number."')";
    }
      
    if( (trim($search_from_date_time) != "") && (trim($search_to_date_time) != "") )
    {
        $search .= " AND date(add_time) between '$search_from_date_time' AND '$search_to_date_time' ";
        
    } 
	else if( (trim($search_from_date_time) != "") && (trim($search_to_date_time) == "") )
    {
        $search .= " AND date(add_time) = '$search_from_date_time' ";
    }  
     
  
    if( trim($search_register_status) != "")
    {
        $search .= " AND register_status = :register_status ";
    }  
    
    if( trim($search_sig_member) != "")
    {
        $search .= " AND sig_member = :sig_member ";
    } 
    
    if( trim($search_payment_status) != "")
    {
        $search .= " AND payment_status = :payment_status ";
    }   
    
    
    $SQL1 = "";
    $SQL1 .= " SELECT COUNT(*) AS CT  FROM " .  BECOME_MEMBER_TBL . " ";   
    $SQL1 .= " WHERE status <> 'DELETE' ";
    $SQL1 .= " $search  ";    
     
    $SQL2 = "";
    $SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE member_id END AS ordby ";
    $SQL2 .= " FROM " .  BECOME_MEMBER_TBL . " as u ";
    $SQL2 .= " WHERE status <> 'DELETE' ";
    $SQL2 .= " $search  ";    
    $SQL2 .= " order by ordby desc ";    
    
    //echo $SQL1 . "<BR><BR><BR>";
    //echo $SQL2 . "<BR><BR><BR>";
    //exit;
    
    $stmt1 = $dCON->prepare($SQL1); 
    
    if(trim($search_user_name) != "")
    { 
        $stmt1->bindParam(":user_name", $username);
        $username = "%{$search_user_name}%";
    }
    
    if(trim($search_reg_number) != "")
    { 
        $stmt1->bindParam(":reg_number", $reg_number);
        $reg_number = "%{$search_reg_number}%";
    }
    
    if( trim($search_register_status) != "")
    {
        $stmt1->bindParam(":register_status",$search_register_status); 
    }
    
    if( trim($search_sig_member) != "")
    {
        $stmt1->bindParam(":sig_member",$search_sig_member); 
    }
    
    if( trim($search_payment_status) != "")
    {
        $stmt1->bindParam(":payment_status",$search_payment_status); 
    }
    
    $stmt1->execute();
    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    
    $rowsPerPage = 100;
    $pg_query = $pg->getPagingQuery($SQL2,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]); 
    
    if(trim($search_user_name) != "")
    { 
        $stmt2->bindParam(":user_name", $username);
        $username = "%{$search_user_name}%";
    }
    
    if(trim($search_reg_number) != "")
    { 
        $stmt2->bindParam(":reg_number", $reg_number);
        $reg_number = "%{$search_reg_number}%";
    }
    
    if( trim($search_register_status) != "")
    {
        $stmt2->bindParam(":register_status",$search_register_status); 
    }
    
    if( trim($search_sig_member) != "")
    {
        $stmt2->bindParam(":sig_member",$search_sig_member); 
    }
    
    if( trim($search_payment_status) != "")
    {
        $stmt2->bindParam(":payment_status",$search_payment_status); 
    }
     
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();
    //print_r($row);
    //exit;     
    //echo "==". intval($paging);
    
    $COLSPAN = 9;
   
    ?>
    <form name="frmDel" id="frmDel" method="post" action="">
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
            <td valign="top" align="left">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="main_heading">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th align="left">Existing</th>
                                     
                                    <?php if( intval($dA) > intval(0)) { ?>
                                        
                                        <!--td align="center" style="padding-right:10px;">
                                            <a href="javascript:void(0);" id="getExcel" class="">
                                               <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png" border="0" title="Export to Excel" alt="Export to Excel" align="absmiddle" /> Export to Excel 
                                            </a>
                                        </td>
                                        
                                        <td align="center" style="padding-right:10px;">
                                            <a href="javascript:void(0);" id="getExcelNew" class="" style="color:#D9414D;font-weight: bold;">
                                               <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png" border="0" title="Export to Excel" alt="Export to Excel" align="absmiddle" /> Export to Excel (New Format)
                                            </a>
                                        </td-->
                                        
                                        <td align="center" style="padding-right:10px;">
                                            <a href="javascript:void(0);" id="getExcelLatest" class="" style="color:#D9414D;font-weight: bold;">
                                               <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png" border="0" title="Export to Excel" alt="Export to Excel" align="absmiddle" /> Export to Excel
                                            </a>
                                        </td>
                                        
                                        
                                        <td align="right" style="padding-right:10px;">
                                            <b>Total Records: <?php echo intval($dA);?></b></td>
                                    <?php }?>
                                 </tr>
                            </table>
                        </td>
                    </tr> 
                </table>
            </td>
        </tr>
        <?php 
        if( intval($dA) > intval(0) )
        {
            global $PERMISSION;                                   
            //echo $_SESSION['PERMISSION'];                       
             
        ?>
        
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    
                    $(document).ready(function(){            
        				$("#getExcel").click(function(){
        					var formvalue = $("#frm").serialize();  
        					//alert(formvalue);
        					location.href = "excel_member_list.php?" + formvalue;
        				});
        			});
                    
                     $(document).ready(function(){            
        				$("#getExcelNew").click(function(){
        					var formvalue = $("#frm").serialize();  
        					//alert(formvalue);
        					location.href = "excel_member_insol-OLD.php?" + formvalue;
        				});
        			});
                    
                    $(document).ready(function(){            
        				$("#getExcelLatest").click(function(){
        					var formvalue = $("#frm").serialize();  
        					//alert(formvalue);
        					location.href = "excel_member_insol.php?" + formvalue;
        				});
        			});
                    
                    
                    
                    $("#chk_all").click(function(){
                            
                        $( '.cb-element' ).attr( 'checked', $( this ).is( ':checked' ) ? true : false );              
                        
                       
                        var nock = $(".cb-element:checked").size();
                        if( parseInt(nock) == parseInt(0) )
                        {
                             $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn");                                   
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass("submit_btn");  
                        }
                        
                    }); 
                    
                        
                    $(".cb-element").click(function(){
                            
                        var nock = $(".cb-element:checked").size();
                        var unock = $(".cb-element:unchecked").size();
                        //alert(nock);
                        
                        if( parseInt(nock) == parseInt(0) )
                        {
                             $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn");                                   
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass("submit_btn");  
                        }
                        
                        if( parseInt(unock) == parseInt(0))
                        {
                             $("#chk_all").attr("checked", true);      
                        }
                        else
                        {
                             $("#chk_all").attr("checked", false);  
                        }
                        
                        
                            
                    });
                    
                    
                    //DELETE SELECTED
                    $(".delete_all").click(function(){
                        $(this).deleteSelected();
                    });
                
                    //DELETE DATA
                    $(".deleteData").click(function(){
                        var value = $(this).attr("value");
                        //alert(value);
                        $(this).deleteData({ID: value});  
                    });  
                     
                     
                    
                    $(".setStatus").live("click", function() {
                        var ID = $(this).attr("value");
                        var VAL = $(this).attr("myvalue");
                        //alert(ID+"####"+VAL);
                        $(this).setStatus({ID: ID,VAL:VAL});  
                    });
                     
                    
                    $(".view_detail").click(function(){
                        id = $(this).attr("id");
        				/*
                        //alert(id);
        			    var strFeatures="toolbar=no,status=yes,menubar=no,location=no"
        				strFeatures=strFeatures+",scrollbars=yes,resizable=yes,height=800,width=830"		
        				url = "";
        				url = "become_member_view.php?member_id=" + id+"&ty=view";
        				window.open(url,id,strFeatures);
                        */
                        
                        $.fancybox.open({
                			href : 'become_member_view.php?member_id='+id,
                			type : 'iframe',
                			padding : 5
                		});
                        
        				
                    });
                    
                    
                    $(".send_mail").click(function(){
                        id = $(this).attr("id");
        		       $.fancybox.open({
                			href : 'become_member_sendmail.php?member_id='+id,
                			type : 'iframe',
                			padding : 5
                		});
                        
        				
                    });
                    
                     $(".send_approval_mail").click(function(){
                        var ID = $(this).attr("id");
                        $.ajax({
                           type: "POST",
                           url: "<?php echo PAGE_AJAX; ?>",
                           data: "type=sendapprovalMAIL&ID=" + ID,
                    	   beforeSend: function(){
                    	       
                               $("#INPROCESS_MAIL").hide();
                               $("#INPROCESS_ERROR").show(); 
                               $("#INPROCESS_ERROR").html("<div style='text-align: center;'><i class='icon iconloader'></i> Processing...</div>"); 
                            },
                          
                           success: function(msg){ 
                                
                                //alert(msg); 
                               
                                var spl_txt = msg.split("~~~");
                                if(spl_txt[1] == '1')
                                {
                                    colorStyle = "color:#18A15D;";                   
                                } 
                                else
                                {
                                    colorStyle = "errorTxt";
                                }
                                
                                
                                $("#INPROCESS_ERROR").html("<div style='text-align: center;' id='inprocess'><div style='" + colorStyle + "' >"+spl_txt[2]+"</div></div>");
                                
                                setTimeout(function(){
                                    
                                    if( parseInt(spl_txt[1]) == parseInt(1) )
                                    {                                
                                        //parent.$.fancybox.close();
                                        parent.window.location.reload();
                                    }
                                    else
                                    {     
                                        $("#INPROCESS_MAIL").show();
                                        $("#INPROCESS_ERROR").hide();
                                    }
                                    
                                }, 2000);   
                                
                           }
                           
                           
                        });
        				
                    });
                    
                });
            </script>
            
            <tr>
                <td class="list_table" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                       
                        <tr>
                            <th width="3%" align="center"><?php if( ( intval($dA) > intval(0) ) ) { ?><input type="checkbox" name="chk_all" value="1" id="chk_all" /><?php } ?></th>                     
                            <th width="12%" align="left">Name</th>
                            <th width="15%" align="left">Email/Password</th>
                            <th width="10%" align="left">Telephone</th>
                            <th width="12%" align="left">Reg. No.</th>
                            <th width="10%" align="left">SIG Member</th>
                            <th width="12%" align="center">Payment Status</th>
                            <th width="10%" align="center">Reg. Status</th>
                            <th align="center" width="10%">Action</th>                      
                        </tr>   
                        <?php
                        $CK_COUNTER = 0;
                        $FOR_BG_COLOR = 0; 
                        $disp = 0;
                        foreach($row as $rs)
                        {
                            $member_id = "";
                            $first_name = ""; 
                            $last_name = ""; 
                            $reg_number = ""; 
                            $mobile = ""; 
                            $city = ""; 
                            $telephone = ""; 
                            $status = ""; 
                            $payment_status = "";
                            $register_status = "";
                            $paid_amount = "";
                            
                            $member_id = intval($rs['member_id']);
                            //$reg_number_text_temp = stripslashes($rs['reg_number_text_temp']);                                             
                            //$reg_number_temp = stripslashes($rs['reg_number_temp']);
                            
                            $sig_member = intval($rs['sig_member']);   
                            
                            $reg_number_text = stripslashes($rs['reg_number_text']);                                             
                            $reg_number = stripslashes($rs['reg_number']);   
                            
                            $title = stripslashes($rs['title']);                                          
                            $first_name = ucwords(strtolower(stripslashes($rs['first_name'])));
                            $middle_name = ucwords(strtolower(stripslashes($rs['middle_name'])));                                             
                            $last_name = ucwords(strtolower(stripslashes($rs['last_name'])));
                            
                            $fullname = "";
                            if($title != ""){
                                $fullname .= $title." ";
                            }
                            $fullname .= $first_name . " ";
                            if($middle_name != ""){
                                $fullname .= $middle_name." ";
                            }
                            $fullname .= $last_name;
                            
                            $email = stripslashes($rs['email']); 
                            $password = stripslashes($rs['password']); 
                            $mobile = stripslashes($rs['mobile']);
                            $telephone= stripslashes($rs['telephone']);
                            $payment_status = stripslashes($rs['payment_status']);
                            $register_status = stripslashes($rs['register_status']);
                            $city = stripslashes($rs['city']);
                            $add_by = stripslashes($rs['add_by']);
                            
                            $status = stripslashes($rs['status']);
                            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";                
                            
                            if(trim(strtoupper($payment_status))=='SUCCESSFUL')
                            {
                                $CHK = 1;  
                            }
                            else
                            {
                                $CHK = 0;  
                            }
                             
                            
                            ?>
                            <tr class="expiredCoupons trhover" >
                                <td align="center" width="3%"> 
                                    <?php
                                    if( intval($CHK) == intval(0) )
                                    {
                                        $CK_COUNTER++;
                                    ?>
                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $member_id; ?>" />
                                    <?php
                                    }
                                    else
                                    {
                                        echo '<input type="checkbox" disabled=""/>';
                                    }
                                    ?>
                                    
                                </td>
                               	    
                                <td>
                                	<?php echo $fullname; //ucwords(strtolower($first_name.' '.$last_name)); ?> 
                                </td> 
                                <td>
                                	<?php echo $email; ?> 
                                    <?php
                                    if(strtoupper($payment_status) == "SUCCESSFUL")
                                    {
                                    ?>
                                        <div style='color:#18A15D;font-size: 11px;'> <i class="fa fa-key" aria-hidden="true"></i> <?php echo $password; ?> </div>
                                    <?php
                                    }
                                    ?>
                                </td> 
                                <td>
                                	<?php echo $telephone; ?>   
                                </td> 
                                <td>
                                	<?php 
                                    echo $reg_number_text; 
                                    ?>   
                                </td> 
                               <td align="center">
                                	<?php 
                                    if($sig_member == intval(1)){
                                        ?>
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" title="SIG Member" alt="SIG Member"/></a>
                                        <?php
                                    }else{
                                        echo "&nbsp";
                                    }
                                    ?>   
                                </td> 
                                
                               
                                <td align='center'>
                                	<?php
                                    if(strtoupper($payment_status) == "SUCCESSFUL")
                                    {
                                        echo "<span style='color:#18A15D;font-weight: bold;'>".ucwords(strtolower($payment_status))."</span>"; 
                                    ?>    
                                        <div ><a href="javascript:void(0);" id="<?php echo $member_id; ?>" class="send_mail" style='color:#DC493D;font-size: 10px;'>Send Mail</a></div> 
                                    
                                    <?php  
                                    }
                                    else
                                    {
                                        echo ucwords(strtolower($payment_status)); 
                                    } 
                                        
                                    ?>   
                                </td>
                                                                 
                                <td align='center'>
                                	<?php 
                                    if(strtolower($register_status) == "approved")
                                    {
                                        echo "<span style='color:#18A15D;font-weight: bold;'>".$register_status."</span>"; 
                                        if($sig_member == intval(0))
                                        {
                                        ?>
                                        <div id="INPROCESS_MAIL" ><a href="javascript:void(0);" id="<?php echo $member_id; ?>" class="send_approval_mail" id="INPROCESS_MAIL" style='color:#DC493D;font-size: 10px;'>Send Mail</a></div>
                                        <div id="INPROCESS_ERROR"></div>
                                        <?php
                                        }
                                    }
                                    else if(strtolower($register_status) == "declined")
                                    {
                                        echo "<span style='color:#C44B2A;'>".$register_status."</span>"; 
                                    }
                                    else
                                    {
                                        echo $register_status;     
                                    }
                                    
                                    ?>   
                                </td> 
                                                                
                                <td align="center" >                           
                                    <div id="INPROCESS_DELETE_1_<?php echo $member_id; ?>" style="display: none;"></div>
                                   <div id="INPROCESS_DELETE_2_<?php echo $member_id; ?>"  >
                                        
                                        <a href="javascript:void(0);" id="<?php echo $member_id; ?>" class="img_btn view_detail" title="View Details"><img border="0" src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>view.png" class="cmsIcon" alt="View Details" ></a></span>
                                        
                                        <!--a href="<?php if(strtolower($add_by)=='admin') { echo PAGE_MAIN; } else { echo EDIT_MAIN; } ?>?con=modify&id=<?php echo $member_id; ?>" class="img_btn viewDetail" title="Modify">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" />
                                        </a-->
                                        
                                        
                                        <a href="<?php if(strtolower($add_by)=='admin') { echo PAGE_MAIN; } else { echo EDIT_MAIN; } ?>?con=modify&id=<?php echo $member_id; ?>" class="img_btn viewDetail" title="Modify">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" />
                                        </a>
                                        
                                        <?php
                                        if( intval($CHK) == intval(0) )
                                        {
                                        ?>
                                            <a href="javascript:void(0);" value="<?php  echo $member_id; ?>" class="deleteData img_btn">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Delete" alt="Delete"/></a>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                             <a href="javascript:void(0);" class="img_btn">
                                             <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash_disable.png" border="0" title="Cannot Delete" alt="Cannot Delete"/></a>                                                             
                                        <?php
                                        }
                                        ?>
                                        
                                        
                                        
                                     </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>   
                </td>
            </tr>
            
            <tr>
                <td height="30" colspan="<?php echo $COLSPAN; ?>" class="txt1" style="padding-top:10px;" valign="top" id="INPROCESS_DEL">
                    <input type="button"  class="grey_btn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                 </td>
            </tr>                                                           
            <?php 
			if($paging[0]!="")
			{
			?>
                <tr>
                    <td style="padding: 10px;" align="right" colspan="<?php echo $COLSPAN; ?>">
                        <div id="pagingWrap">
                    	   <?php echo $paging[0]; ?>
                        </div>             
                     </td>
                 </tr>
            <?php 
			}
			?>  
            </form>     
        <?php
        }        
        else
        {
        ?>
            <tr>
               <td align="center" height="100"><strong>Not Found</strong></td>
           </tr>
         <?php
        } 
        ?>
    </table>
  
</form> 
<?php
}

function deleteData()
{
    global $dCON;  
    $ID = intval($_REQUEST['ID']); 
    
    
    $stmt_del = $dCON->prepare(" UPDATE " . BECOME_MEMBER_TBL . " SET status = 'DELETE' WHERE member_id = ? ");
    $stmt_del->bindParam(1,$ID);
    $dbRES = $stmt_del->execute();
	$stmt_del->closeCursor();
    
    if ( intval($dbRES) == intval(1) )
    {  
        $CNT = getDetails(BECOME_MEMBER_TBL, "COUNT", "status","DELETE","!=", "", "", "" );        
        echo '~~~1~~~Deleted~~~' . $CNT . "~~~"; 
    }
    else
    {
        echo '~~~0~~~Error occured~~~';
    }
     
}

//////Delete Selected///////////////////////////////////////////////////


function deleteSelected()
{
    global $dCON;
     
    $arr = implode(",",$_REQUEST['chk']);
    $exp = explode(",",$arr);
    $i = 0;
    
    foreach($exp as $CHK)
    {
        $stmt_del = $dCON->prepare(" UPDATE " . BECOME_MEMBER_TBL . " SET status = 'DELETE' WHERE member_id = ? ");
        $stmt_del->bindParam(1,$CHK);
        $dbRES = $stmt_del->execute();
    	$stmt_del->closeCursor();
        
        if ( intval($dbRES) == intval(1) )
        { 
            $i++;
        }
    }
    
    $msg = "(".$i.") Deleted";  
    
    echo $msg;
}


function setStatus()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);                           
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
     
    $STR  = "";
    $STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE member_id = :member_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":member_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();         
    
        
    if ( intval($RES) == intval(1) )
    {     
        echo '~~~1~~~DONE~~~' . $ID . "~~~";     
    }
    else
    {
        echo '~~~0~~~ERROR~~~';
    }

}


function registerSave()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    
    $register_status = trustme($_REQUEST['register_status']);                           
    
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    
    $sig_member = getDetails(BECOME_MEMBER_TBL, "sig_member", "member_id","$ID","=", '', '','');
    
    
    if(strtolower($register_status)=='approved')
    {
        $SQL  = "";
        $SQL .= " SELECT IFNULL(MAX(reg_number_temp) + 1, 151) as max_reg_number FROM ".BECOME_MEMBER_TBL." where register_status = 'approved' ";
        $stmt = $dCON->prepare( $SQL );
        $stmt->execute();
        $row = $stmt->fetchAll();
        $stmt->closeCursor();
        $reg_number_temp = intval($row[0]['max_reg_number']);
        if(intval($reg_number_temp)<=1)
        {
            $reg_number_temp = 151;
        }
        $reg_number_text_temp = 'INSOL/T/'.$reg_number_temp;
        
    }
    
    if($sig_member == intval(1))
    {
        $SQL  = "";
        $SQL .= " SELECT IFNULL(MAX(reg_number) + 1, 151) as max_reg_number FROM ".BECOME_MEMBER_TBL." where payment_status = 'SUCCESSFUL' ";
        $stmt = $dCON->prepare( $SQL );
        $stmt->execute();
        $row = $stmt->fetchAll();
        $stmt->closeCursor();
        $reg_number = intval($row[0]['max_reg_number']);
        if(intval($reg_number)<=1)
        {
            $reg_number = 151;
        }
        $reg_number_text = 'INSOL/'.$reg_number;
    }
    
    
    
    $STR  = "";
    $STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET "; 
    $STR .= " register_status = :register_status, ";
    if(strtolower($register_status)=='approved')
    {
        $STR .= " reg_number_text_temp = :reg_number_text_temp, ";
        $STR .= " reg_number_temp = :reg_number_temp, ";
    }
    if($sig_member == intval(1))
    {
        $payment_status = "SUCCESSFUL";
        
        $STR .= " reg_number_text = :reg_number_text, ";
        $STR .= " reg_number = :reg_number, ";
        
        $STR .= " payment_status = :payment_status, ";
        
    }
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE member_id = :member_id ";
    
    //echo $STR;
    //exit();
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":register_status", $register_status); 
    if(strtolower($register_status)=='approved')
    {
        $sDEF->bindParam(":reg_number_text_temp", $reg_number_text_temp); 
        $sDEF->bindParam(":reg_number_temp", $reg_number_temp); 
    }
    if($sig_member == intval(1))
    {
        $sDEF->bindParam(":reg_number_text", $reg_number_text); 
        $sDEF->bindParam(":reg_number", $reg_number); 
        $sDEF->bindParam(":payment_status", $payment_status);
    }
    
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":member_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();         
        
    if ( intval($RES) == intval(1) )
    {     
        if(strtolower($register_status)=='approved')
        {
            sendMailformate('approved',$ID,"ADMIN");
        }
        
        echo '~~~1~~~'.$register_status.'~~~' . $ID . "~~~";     
    }
    else
    {
        echo '~~~0~~~ERROR~~~';
    }

}



function sendMail()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    
    
       
    if(intval($ID) > intval(0))
    {
        $send = sendMailformate('PAYMENT_MAIL',$ID,"ADMIN");
        if(intval($send) == intval(1))
        {
            echo '~~~1~~~Mail Successfully Sent~~~'. $ID . "~~~"; 
        }
        else
        {
            echo '~~~0~~~ERROR~~~';
        }
    }
    else
    {
        echo '~~~0~~~ERROR~~~';
    }

}

function sendapprovalMAIL()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    
    
       
    if(intval($ID) > intval(0))
    {
        $send = sendMailformate('approved',$ID,"ADMIN");
        if(intval($send) == intval(1))
        {
            echo '~~~1~~~Sent~~~'. $ID . "~~~"; 
        }
        else
        {
            echo '~~~0~~~ERROR~~~';
        }
    }
    else
    {
        echo '~~~0~~~ERROR~~~';
    }

}


?>