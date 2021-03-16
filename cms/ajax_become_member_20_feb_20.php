<?php 
session_start();
// error_reporting(0);
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
            $SQL .= " UPDATE tbl_become_member_receipt SET " ;
            $SQL .= " status = 'DELETE' ";
            $SQL .= " WHERE reciept_id = :reciept_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":reciept_id", $imageId);
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
    if($permanent_address == "")
    {
        $permanent_address = $address;
    }
    
    $permanent_address_2 = trustme($_REQUEST["permanent_address_2"]);
    if($permanent_address_2 == ""){
        $permanent_address_2 = $correspondence_address_2;
    }
    
    $permanent_city = trustme($_REQUEST["permanent_city"]); 
    
    if($permanent_city == "")
    {
        $permanent_city = $city;
    }
    
    $permanent_state = trustme($_REQUEST["permanent_state"]);
    
    if($permanent_state == "")
    {
        $permanent_state = $correspondence_state;
    }
    
    $permanent_country = trustme($_REQUEST["permanent_country"]); 
    if($permanent_country == ""){
        $permanent_country = $country;
    }
    
    $permanent_pin = trustme($_REQUEST["permanent_pin"]); 
    if($permanent_pin == "")
    {
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
    
    if($membership_starts_date!='')
    {
        $membership_starts_date_array = explode("-", $membership_starts_date);
        $MEMBERSHIP_STARTS_DATE = $membership_starts_date_array[2] . "-" . $membership_starts_date_array[1] . "-" . $membership_starts_date_array[0];
    }
    else
    {
        $MEMBERSHIP_STARTS_DATE = "";
    }
    
    
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
    $internal_comments = trustme($_REQUEST["internal_comments"]);
    
    
    $old_register_status = trustme($_REQUEST["old_register_status"]);
    $old_payment_status = trustme($_REQUEST["old_payment_status"]);
   
    $membership_start_date_old = trustme($_REQUEST["membership_start_date_old"]);
    
    
    $membershipExpiredDate = trustme($_REQUEST["membership_expired_date"]); 
    
    if(trim($membershipExpiredDate)!='')
    {
        $membershipExpiredDate_array = explode("-", $membershipExpiredDate);
        $membership_expired_date = $membershipExpiredDate_array[2] . "-" . $membershipExpiredDate_array[1] . "-" . $membershipExpiredDate_array[0];
    }
    else
    {
        $membership_expired_date = "0000-00-00";
    }
    
    
    $image_array = ($_REQUEST['image']); 
    $folder_name_array = $_REQUEST['folder_name'];
    $caption_array = $_REQUEST['caption'];
    $image_id_array = ($_REQUEST['image_id']);
    
   
    
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
    
    /*
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']);
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/"; 
    */
    
    
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
                //$membership_expired_date = "0000-00-00";
  
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
                }
                else
                {
                    //$member_since_date = getDetails(SIG24_TBL, 'member_since_date', "sig24_id","$sig_company_id",'=', '', '' , "");
                    //$membership_start_date = date('Y-m-d', strtotime($member_since_date));
                    //$membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($member_since_date)));
                    $membership_start_date = $MEMBERSHIP_STARTS_DATE;
                    if($MEMBERSHIP_STARTS_DATE !="")
                    {
                        $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($membership_start_date)));
                    }
                    
                    
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
            $SQL .= " internal_comments = :internal_comments, ";
            
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
            $stmt->bindParam(":internal_comments",$internal_comments);
            
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":add_ip", $IP);
            $stmt->bindParam(":add_by", $BY);
            $stmt->bindParam(":add_time", $TIME);
            $dbRES = $stmt->execute();
            $stmt->closeCursor();
           
            if($dbRES == 1)
            {
                $RTNID = $MAX_ID;
                
                
                if(intval(count($image_array)) > intval(0))
                {
                    foreach($image_array as $indx => $image_result)
                    {
                        $reciept_image_name = "";  
                        $reciept_caption = "";
                        $reciept_id = 0;
                        $reciept_image_name = trustme($image_result);
                                
                        $reciept_caption = $caption_array[$indx];
                        $reciept_id = intval($image_id_array[$indx]);
                       
                        $MYFOLDERNAME = "";
                        $MYFOLDERNAME = $folder_name_array[$indx];
                        
                        $TEMP_FOLDER_NAME = "";
                        $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                        
                        $FOLDER_NAME = "";
                        $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";
                                  
                        $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                        
                        $name_filter = filterString($first_name);
                     
                        $img_ext = pathinfo($reciept_image_name);
                        $fpath_image =  strtolower($name_filter) . "-" . $member_id . "-" . $reciept_id . "." . $img_ext['extension'];
                        
                        if($fpath_image != $reciept_image_name)
                        {    
                            rename($TEMP_FOLDER_NAME.$reciept_image_name, $FOLDER_NAME.$fpath_image);
                        }
                        else
                        {
                             $fpath_image = $reciept_image_name;
                        } 
                        
                        $SQL_IMG  = "";
                        $SQL_IMG .= " UPDATE tbl_become_member_receipt SET ";
                        $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
                        $SQL_IMG .= " reciept_caption = :reciept_caption, ";          
                        $SQL_IMG .= " update_ip = :update_ip, ";         
                        $SQL_IMG .= " update_by = :update_by, ";         
                        $SQL_IMG .= " update_time = :update_time "; 
                        $SQL_IMG .= " where reciept_id = :reciept_id ";   
                        $SQL_IMG .= " and member_id = :member_id ";         
                       
                        $stmtIMG = $dCON->prepare( $SQL_IMG );
                        $stmtIMG->bindParam(":reciept_image_name", $fpath_image); 
                        $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
                        $stmtIMG->bindParam(":update_ip",$ip);
                        $stmtIMG->bindParam(":update_by",$BY);
                        $stmtIMG->bindParam(":update_time",$update_time); 
                        $stmtIMG->bindParam(":reciept_id", $reciept_id);
                        $stmtIMG->bindParam(":member_id", $member_id);
                        $rsImage = $stmtIMG->execute();
                       //print_r($stmtIMG->errorInfo());
                        //echo intval($rsImage);
                        $stmtIMG->closeCursor();
                        
                        $position++;
                    }
                
                }
                
                
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
                
                if($membership_start_date_old !="" && $membership_start_date_old !='0000-00-00')
                {
                    $membership_start_date = $membership_start_date_old;
                }
                else
                {
                    $membership_start_date = date("Y-m-d");
                }
                
                if(trim($membership_expired_date) == "0000-00-00")
                {
                    $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
                }
                
                
            }
            else
            {
                $reg_number = intval($_REQUEST["reg_number"]);
                $reg_number_text = trustme($_REQUEST["reg_number_text"]);
                $membership_start_date_old;
                if($membership_start_date_old !="" && $membership_start_date_old !='0000-00-00')
                {
                    $membership_start_date = $membership_start_date_old;
                    
                    if(trim($membership_expired_date) == "0000-00-00")
                    {
                        $membership_expired_date = date('Y-m-d', strtotime('+1 years', strtotime($membership_start_date)));
                    }
                    
                }
                
               
            }
            
            if($sig_member == intval(1))
            {
                $membership_start_date = $MEMBERSHIP_STARTS_DATE;
                
                if($MEMBERSHIP_STARTS_DATE !="")
                {
                    if(trim($membership_expired_date) == "0000-00-00")
                    {
                        $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($membership_start_date)));
                    }
                }
                
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
            $SQL .= " internal_comments = :internal_comments,"; 
            
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
            $stmt->bindParam(":internal_comments",$internal_comments);         
            
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
                
                /////////////---------------images============================ 
                
                if(intval(count($image_array)) > intval(0))
                {
                    foreach($image_array as $indx => $image_result)
                    {
                        $reciept_image_name = "";  
                        $reciept_caption = "";
                        $reciept_id = 0;
                       
                        $reciept_image_name = trustme($image_result);
                                
                        $reciept_caption = $caption_array[$indx];
                        $reciept_id = intval($image_id_array[$indx]);
                       
                        $MYFOLDERNAME = "";
                        $MYFOLDERNAME = $folder_name_array[$indx];
                        
                        if(intval($reciept_id)==intval(0))
                        {
                            $TEMP_FOLDER_NAME = "";
                            $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
                            
                            $FOLDER_NAME = "";
                            $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";
                            
                            $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                            $position = 0;
                            
                            if(intval($chk_file) == intval(1))
                            {
                                $MAXID_IMG = getMaxId('tbl_become_member_receipt',"reciept_id"); 
                                
                                $name_filter = filterString($first_name);
                                 
                                $img_ext = pathinfo($reciept_image_name);
                                $fpath_image =  strtolower($name_filter) . "-" . $member_id . "-" . $MAXID_IMG . "." . $img_ext['extension'];
                                
                                rename($TEMP_FOLDER_NAME.$reciept_image_name, $FOLDER_NAME.$fpath_image);
                                
                                
                                
                                $SQL_IMG  = "";
                                $SQL_IMG .= " INSERT INTO tbl_become_member_receipt SET ";
                                $SQL_IMG .= " reciept_id = :reciept_id, ";    
                                $SQL_IMG .= " member_id = :member_id, ";         
                                $SQL_IMG .= " reciept_caption = :reciept_caption, ";         
                                $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
                                $SQL_IMG .= " position = :position, "; 
                                $SQL_IMG .= " add_ip = :add_ip, ";         
                                $SQL_IMG .= " add_by = :add_by, ";         
                                $SQL_IMG .= " add_time = :add_time ";             
                                
                                $stmtIMG = $dCON->prepare( $SQL_IMG );
                                $stmtIMG->bindParam(":reciept_id", $MAXID_IMG);
                                $stmtIMG->bindParam(":member_id", $member_id);
                                $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
                                $stmtIMG->bindParam(":reciept_image_name", $fpath_image); 
                                $stmtIMG->bindParam(":position",$position);
                                $stmtIMG->bindParam(":add_ip",$ip);
                                $stmtIMG->bindParam(":add_by",$BY);
                                $stmtIMG->bindParam(":add_time",$update_time); 
                                $rsImage = $stmtIMG->execute();
                                //print_r($stmtIMG->errorInfo());
                                //echo intval($rsImage);
                                $stmtIMG->closeCursor();
                            }
                        
                        }
                        else
                        {
                            $TEMP_FOLDER_NAME = "";
                            $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                            
                            $FOLDER_NAME = "";
                            $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";
                                      
                            $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                            
                            $name_filter = filterString($first_name);
                         
                            $img_ext = pathinfo($reciept_image_name);
                            $fpath_image =  strtolower($name_filter) . "-" . $member_id . "-" . $reciept_id . "." . $img_ext['extension'];
                            
                            if($fpath_image != $reciept_image_name)
                            {    
                                rename($TEMP_FOLDER_NAME.$reciept_image_name, $FOLDER_NAME.$fpath_image);
                            }
                            else
                            {
                                 $fpath_image = $reciept_image_name;
                            } 
                            
                            $SQL_IMG  = "";
                            $SQL_IMG .= " UPDATE tbl_become_member_receipt SET ";
                            $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
                            $SQL_IMG .= " reciept_caption = :reciept_caption, ";          
                            $SQL_IMG .= " update_ip = :update_ip, ";         
                            $SQL_IMG .= " update_by = :update_by, ";         
                            $SQL_IMG .= " update_time = :update_time "; 
                            $SQL_IMG .= " where reciept_id = :reciept_id ";   
                            $SQL_IMG .= " and member_id = :member_id ";         
                          
                            
                            $stmtIMG = $dCON->prepare( $SQL_IMG );
                            $stmtIMG->bindParam(":reciept_image_name", $fpath_image); 
                            $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
                            $stmtIMG->bindParam(":update_ip",$ip);
                            $stmtIMG->bindParam(":update_by",$BY);
                            $stmtIMG->bindParam(":update_time",$update_time); 
                            $stmtIMG->bindParam(":reciept_id", $reciept_id);
                            $stmtIMG->bindParam(":member_id", $member_id);
                            $rsImage = $stmtIMG->execute();
                           //print_r($stmtIMG->errorInfo());
                            //echo intval($rsImage);
                            $stmtIMG->closeCursor();
                            
                        } 
                        
                        $position++;
                    }
                
                }
                
                
                
                
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
    
    $connect = mysqli_connect("localhost","root","root","insolindia");
    $sql = "SELECT * FROM tbl_become_member WHERE member_id='$member_id'";
    $result = mysqli_query($connect, $sql);
    $row2 = mysqli_fetch_array($result);
    $password = $row2['password'];
    echo $password;
    $renewal_start_date = trustme($_REQUEST["renewal_start_date"]); 
$renewal_end_date =trustme($_REQUEST["renewal_end_date"]); 
$renewal_payment_text =trustme($_REQUEST["renewal_payment_text"]);
    $title = trustme($_REQUEST["title"]); 
    $first_name = trustme($_REQUEST["first_name"]); 
    $gst_no = trustme($_REQUEST["gst_no"]); 
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
    $name = $title." ".$first_name." ".$last_name;
    echo"$name";
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
    if($sig_member == intval(1))
    { 
        $sig_company_id = intval($_REQUEST["sig_company_id"]);
        $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id","$sig_company_id",'=', '', '' , "");
    }
    else
    {
        $sig_company_id = intval(0);
        $sig_company_name ="";
    }
    
    $interested = trustme($_REQUEST["interested"]); 
    
    $membership_starts_date = trustme($_REQUEST["membership_starts_date"]); 
    
    if($membership_starts_date !='')
    {
        $membership_starts_date_array = explode("-", $membership_starts_date);
        $MEMBERSHIP_STARTS_DATE = $membership_starts_date_array[2] . "-" . $membership_starts_date_array[1] . "-" . $membership_starts_date_array[0];
    }
    else
    {
        $MEMBERSHIP_STARTS_DATE = "";
    }
    
    
    $image_array = ($_REQUEST['image']); 
    $folder_name_array = $_REQUEST['folder_name'];
    $caption_array = $_REQUEST['caption'];
    $image_id_array = ($_REQUEST['image_id']);
    
    
    $con = trustme($_REQUEST['con']);
    $BY = 'admin';
    
    $register_status = trustme($_REQUEST["register_status"]);
    $payment_status = trustme($_REQUEST["payment_status"]);
    $payment_text = trustme($_REQUEST["payment_text"]);
    
    $internal_comments = trustme($_REQUEST["internal_comments"]);
    
    
    // for sig member if status is approved==========
    if($register_status == 'Approved' && $sig_member == intval(1)){
        $payment_status = 'SUCCESSFUL';
    }
   
    // for sig member if status is approved======ends
    $sendStatus = trustme($_REQUEST['sendStatus']); 
    
    $old_register_status = trustme($_REQUEST["old_register_status"]);
    $old_payment_status = trustme($_REQUEST["old_payment_status"]);
    
    $membership_start_date_old = trustme($_REQUEST["membership_start_date_old"]);
    
    $membershipExpiredDate = trustme($_REQUEST["membership_expired_date"]); 
    
    if(trim($membershipExpiredDate)!='')
    {
        $membershipExpiredDate_array = explode("-", $membershipExpiredDate);
        $membership_expired_date = $membershipExpiredDate_array[2] . "-" . $membershipExpiredDate_array[1] . "-" . $membershipExpiredDate_array[0];
    }
    else
    {
        $membership_expired_date = "0000-00-00";
    }
    
    
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
    //$membership_expired_date = "0000-00-00";
        
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
        
        
        if($membership_start_date_old !="" && $membership_start_date_old !='0000-00-00')
        {
            $membership_start_date = $membership_start_date_old;
        }
        else
        {
            $membership_start_date = date("Y-m-d");
        }    
            
        if(trim($membership_expired_date) == "0000-00-00")
        {
            $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
        }
        
        /*  
        $membership_start_date = date("Y-m-d");
        $membership_expired_date = date('Y-m-d', strtotime('+1 years'));
        */
    }
    else if(strtoupper($payment_status) =='SUCCESSFUL')
    {
        $reg_number = intval($_REQUEST["reg_number"]);
        $reg_number_text = trustme($_REQUEST["reg_number_text"]);
        
        if($membership_start_date_old !="" && $membership_start_date_old !='0000-00-00')
        {
            $membership_start_date = $membership_start_date_old;
            
            if(trim($membership_expired_date) == "0000-00-00")
            {
                $membership_expired_date = date('Y-m-d', strtotime('+1 years', strtotime($membership_start_date)));
            }
        }
        
     }
    else
    {
        $reg_number = intval($_REQUEST["reg_number"]);
        $reg_number_text = trustme($_REQUEST["reg_number_text"]);
        
        
        if($membership_start_date_old !="" && $membership_start_date_old !='0000-00-00')
        {
            $membership_start_date = $membership_start_date_old;
            
            if(trim($membership_expired_date) == "0000-00-00")
            {
                $membership_expired_date = date('Y-m-d', strtotime('+1 years', strtotime($membership_start_date)));
            }
            
        }
        
       
    }
    
    
    
    // if($sig_member == intval(1))
    // {
        //$member_since_date = getDetails(SIG24_TBL, 'member_since_date', "sig24_id","$sig_company_id",'=', '', '' , "");
        //$membership_start_date = date('Y-m-d', strtotime($member_since_date));
        //$membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($member_since_date))); 
        $membership_start_date = $MEMBERSHIP_STARTS_DATE;
        
        if($MEMBERSHIP_STARTS_DATE !="")
        {
            if(trim($membership_expired_date) == "0000-00-00")
            {
                $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($membership_start_date)));
            }
        }
        
        /*
        if($membership_start_date !='')
        {
            $membership_expired_date = date('Y-m-d', strtotime('+2 years', strtotime($MEMBERSHIP_STARTS_DATE)));
        }
        else
        {
            $membership_expired_date = "0000-00-00";
        }
        */
    // }
    
    //echo $membership_start_date."--".$membership_expired_date;
    
    $ip = trustme($_SERVER['REMOTE_ADDR']);
    $update_time = date("Y-m-d H:i:s");
    
    //exit;
    
    $sql  = "";
    $sql .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET ";
    $sql .= " title = :title,";
    $sql .= " first_name = :first_name,"; 
    $sql .= " gst_no = :gst_no,"; 
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
    $sql .= " internal_comments = :internal_comments, ";
    
    $sql .= " update_ip = :update_ip, "; 
    $sql .= " update_by = :update_by, "; 
    $sql .= " update_time = :update_time ";
    $sql .= " WHERE member_id = :member_id";
    //  echo $sql; exit;              
    $stmt3 = $dCON->prepare($sql);    
    $stmt3->bindParam(":title", $title);     
    $stmt3->bindParam(":first_name", $first_name); 
    $stmt3->bindParam(":gst_no", $gst_no); 
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
    $stmt3->bindParam(":internal_comments",$internal_comments);
     
	$stmt3->bindParam(":update_ip",$ip);
    $stmt3->bindParam(":update_by", $BY);
 	$stmt3->bindParam(":update_time",$update_time);
	$stmt3->bindParam(":member_id",$member_id);
    $rs = $stmt3->execute();
    if($rs == 1)
    {
        
        /////////////---------------images============================ 
        /*
        $image_array = trustme($_REQUEST['image']); 
        $folder_name_array = $_REQUEST['folder_name'];
        $caption_array = $_REQUEST['caption'];
        $image_id_array = trustme($_REQUEST['image_id']);
     
        //$TEMP_FOLDER_NAME = "";
        //$TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
        
        $FOLDER_NAME = "";
        $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/"; 
        
        
        $name_filter = filterString($first_name);
        $i_ext = pathinfo($image);
        
        $imgpath_name =  $name_filter ."_".$member_id. "." . $i_ext['extension'];
        rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
        //resizeIMG("PAYMENT_RECIEPT_IMG",trim($imgpath_name),$id,$FOLDER_NAME);
        
        $image_id = intval(1);
        */
        
        if(intval(count($image_array)) > intval(0))
        {
            foreach($image_array as $indx => $image_result)
            {
                $reciept_image_name = "";  
                $reciept_caption = "";
                $reciept_id = 0;
               
                $reciept_image_name = trustme($image_result);
                        
                $reciept_caption = $caption_array[$indx];
                $reciept_id = intval($image_id_array[$indx]);
               
                $MYFOLDERNAME = "";
                $MYFOLDERNAME = $folder_name_array[$indx];
                
                if(intval($reciept_id)==intval(0))
                {
                    $TEMP_FOLDER_NAME = "";
                    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
                    
                    $FOLDER_NAME = "";
                    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";
                    
                    $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                    $position = 0;
                    
                    if(intval($chk_file) == intval(1))
                    {
                        $MAXID_IMG = getMaxId('tbl_become_member_receipt',"reciept_id"); 
                        
                        $name_filter = filterString($first_name);
                         
                        $img_ext = pathinfo($reciept_image_name);
                        $fpath_image =  strtolower($name_filter) . "-" . $member_id . "-" . $MAXID_IMG . "." . $img_ext['extension'];
                        
                        rename($TEMP_FOLDER_NAME.$reciept_image_name, $FOLDER_NAME.$fpath_image);
                        
                        
                        
                        $SQL_IMG  = "";
                        $SQL_IMG .= " INSERT INTO tbl_become_member_receipt SET ";
                        $SQL_IMG .= " reciept_id = :reciept_id, ";    
                        $SQL_IMG .= " member_id = :member_id, ";         
                        $SQL_IMG .= " reciept_caption = :reciept_caption, ";         
                        $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
                        $SQL_IMG .= " position = :position, "; 
                        $SQL_IMG .= " add_ip = :add_ip, ";         
                        $SQL_IMG .= " add_by = :add_by, ";         
                        $SQL_IMG .= " add_time = :add_time ";             
                        
                        $stmtIMG = $dCON->prepare( $SQL_IMG );
                        $stmtIMG->bindParam(":reciept_id", $MAXID_IMG);
                        $stmtIMG->bindParam(":member_id", $member_id);
                        $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
                        $stmtIMG->bindParam(":reciept_image_name", $fpath_image); 
                        $stmtIMG->bindParam(":position",$position);
                        $stmtIMG->bindParam(":add_ip",$ip);
                        $stmtIMG->bindParam(":add_by",$BY);
                        $stmtIMG->bindParam(":add_time",$update_time); 
                        $rsImage = $stmtIMG->execute();
                        //print_r($stmtIMG->errorInfo());
                        //echo intval($rsImage);
                        $stmtIMG->closeCursor();
                    }
                
                }
                else
                {
                    $TEMP_FOLDER_NAME = "";
                    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                    
                    $FOLDER_NAME = "";
                    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";
                              
                    $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                    
                    $name_filter = filterString($first_name);
                 
                    $img_ext = pathinfo($reciept_image_name);
                    $fpath_image =  strtolower($name_filter) . "-" . $member_id . "-" . $reciept_id . "." . $img_ext['extension'];
                    
                    if($fpath_image != $reciept_image_name)
                    {    
                        rename($TEMP_FOLDER_NAME.$reciept_image_name, $FOLDER_NAME.$fpath_image);
                    }
                    else
                    {
                         $fpath_image = $reciept_image_name;
                    } 
                    
                    $SQL_IMG  = "";
                    $SQL_IMG .= " UPDATE tbl_become_member_receipt SET ";
                    $SQL_IMG .= " reciept_image_name = :reciept_image_name, "; 
                    $SQL_IMG .= " reciept_caption = :reciept_caption, ";          
                    $SQL_IMG .= " update_ip = :update_ip, ";         
                    $SQL_IMG .= " update_by = :update_by, ";         
                    $SQL_IMG .= " update_time = :update_time "; 
                    $SQL_IMG .= " where reciept_id = :reciept_id ";   
                    $SQL_IMG .= " and member_id = :member_id ";         
                  
                    
                    $stmtIMG = $dCON->prepare( $SQL_IMG );
                    $stmtIMG->bindParam(":reciept_image_name", $fpath_image); 
                    $stmtIMG->bindParam(":reciept_caption",$reciept_caption);
                    $stmtIMG->bindParam(":update_ip",$ip);
                    $stmtIMG->bindParam(":update_by",$BY);
                    $stmtIMG->bindParam(":update_time",$update_time); 
                    $stmtIMG->bindParam(":reciept_id", $reciept_id);
                    $stmtIMG->bindParam(":member_id", $member_id);
                    $rsImage = $stmtIMG->execute();
                   //print_r($stmtIMG->errorInfo());
                    //echo intval($rsImage);
                    $stmtIMG->closeCursor();
                    
                } 
                
                $position++;
            }
        
        }
        
      
        
        
        
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
        
         if(strtolower($register_status) =='renewal' && strtolower($old_register_status) != 'renewal' )
        {
            if($sig_member == intval(0))
            {
                
$MAIL_BODY = '';
$MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
    $MAIL_BODY .= '<tbody>';
        $MAIL_BODY .= '<tr>';
            $MAIL_BODY .= '<td>';
                $MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';
                    $MAIL_BODY .= '<tbody>';
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>';
                        $MAIL_BODY .= '</tr>';
                       
                            
               
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold; text-transform:capitalize;">Dear '.$name.'</td>';
                        $MAIL_BODY .= '</tr>';
                        if($sig_member == intval(0))
                        {
                        $MAIL_BODY .='<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                            <h1 style="color: #2E3192; font-size:16px;">We are delighted to renew your membership to INSOL India.</h1> 
            								<h3 style="color: #ED1C24; font-size: 16px;">Your membership number is '.$reg_number_text.'.</h3>
            								
                                            Your login details are provided below as some features on website are accessible by members only.<br><br>
            								
                                            <strong>Login ID:</strong> '.$email.' <br><br>
                                            <strong>Password:</strong> '.$password.'<br>
                                            <br><br>
                                            <div style="border-top:1px solid #ccc">&nbsp;</div>
                                            <div style="font-size:11px;">
                								<h3 style="color: #000; font-size: 13px;">INSOL India Membership Benefits</h3>
                                                <p><span style="color: #2E3192; font-weight:bold;">Conferences</span> 20% discount on registration fee for Individual Members in conferences organised by INSOL India. One annual conference and a series of workshops in different parts of the country.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">INSOL India Newsletter</span> INSOL India has a quarterly newsletter which will be sent to all the Members free of charge.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Electronic Newsletter</span> INSOL India is planning to start an electronic monthly newsletter in August 2017 which will emailed to all members.</p>
                                                </p><span style="color: #2E3192; font-weight:bold;">Membership of INSOL International</span> As a member of INSOL India, one becomes a member of INSOL International, whereby one also becomes part of a network of 10,000 members in over 80 countries around the world. This enables one, apart from getting INSOL India\'s electronic and printed newsletters, access INSOL International\'s monthly technical electronic news updates and quarterly journal INSOL World, and other resource materials at INSOL International\'s website (www.insol.org) including INSOL Technical Library containing INSOL publications, technical paper series, case studies etc. As a member, one is also able to use "search a member" tool under the Membership section to browse the database of INSOL International.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Committees</span> Members keen to actively participate in INSOL India activities can join various committees of INSOL India.</p>
                                            </div>
                                            
                                            
                                            
                                        </td>
                                    </tr>';
                        }
                        else
                        {
                            $MAIL_BODY .= '<tr>
                                                <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                        								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>
                                                        <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>
                                                        <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>
                                                        Membership Number: ' .$reg_number_text.' <br>
                                                        <strong>Login ID:</strong> '.$email.' <br>
                                                        <strong>Password:</strong> '.$password.'<br><br>
                                                        For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>
                                                </td>
                                            </tr>';
                        }
                        
                        $MAIL_BODY .= '<tr>';
                            $MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';
                                $MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br />Contact No. 011 49785744';
                                $MAIL_BODY .= 'Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>';
                            $MAIL_BODY .= '</td>';
                        $MAIL_BODY .= '</tr>';
                    $MAIL_BODY .= '</tbody>';
                $MAIL_BODY .= '</table>';
            $MAIL_BODY .= '</td>';
        $MAIL_BODY .= '</tr>';
    $MAIL_BODY .= '</tbody>';
$MAIL_BODY .= '</table>';
$MAIL_BODY .= '<div style="height:10px;"></div>';
$MAIL_BODY .= '<div style="text-align: center;" id="INPROCESS">;
    
</div>
<div id="INPROCESS_1" style="display: none;"></div>';
    $email = $_REQUEST['email'];
$message = $_REQUEST['message'];
if($register_status =='Renewal' )
        {

$mail = new phpmailer;
    


$mail->IsSMTP();
//$mail->Host     = "mail.acecabs.in.cust.a.hostedemail.com";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "Newpass@0112";

$mail->Host     = "103.21.58.112";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "dOvb15^8";
$mail->Username = "noreply@insolindia.com";
$mail->Password = "f2B7~w)C[5d4";


$mail->Port = 25;
$mail->SMTPAuth = true;
$mail->SMTPDebug = true;



$mail->From = "contact@insolindia.com";    
    
$mail->FromName = "insolindia";			
$mail->ContentType = "text/html";

$to = $email;
$mail->Subject  = "Your Insol India Membership Has Been Renew";
    
$mail->AddAddress("$email");
$mail->Body = "$MAIL_BODY";
$mail->AddCC("contact@insolindia.com");

$mailSent = $mail->send();    
$mail->ClearAddresses();    

if($mailSent): 
   
    $previousPage = $_SERVER["HTTP_REFERER"];
    header('Location: '.$previousPage);
    echo "Mail Successfully Sent";
else:
  echo "Sorry cannot process your request.";
endif;
ob_flush();
        }  
            }
        }
        
    }

$connection = mysqli_connect("localhost","root","root","insolindia");


$query_id ="SELECT * FROM renew_member_detail where p_id = $member_id";
				$result_id = mysqli_query($connection, $query_id);
				$show_id = mysqli_fetch_assoc($result_id);
            $old_renewal_start_date = $show_id['renewal_start_date'];
            $old_renewal_end_date = $show_id['renewal_end_date'];
            $old_renewal_payment_detail = $show_id['renewal_payment_detail'];
            if($renewal_start_date != $old_renewal_start_date || $renewal_end_date != $old_renewal_end_date || $renewal_payment_text != $old_renewal_payment_detail){
                 $query = "INSERT INTO renew_member_detail(renewal_start_date, renewal_end_date,renewal_payment_detail, add_date, p_id) VALUES ('$renewal_start_date', '$renewal_end_date','$renewal_payment_text', now(), '$member_id')";
			    $result = mysqli_query($connection, $query);
            }else{
               
            }

			
		

$query_up = "UPDATE tbl_become_member SET renewal_start_date = '$renewal_start_date',renewal_end_date ='$renewal_end_date', renewal_payment_detail = '$renewal_payment_text',renew_date = '$add_date1'  WHERE member_id = $member_id";
$result_up = mysqli_query($connection, $query_up);			


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
    
    $search_from_date = ($_REQUEST['search_from_date']);
    $search_to_date = ($_REQUEST['search_to_date']);
	
	$search_from_renewal = ($_REQUEST['search_from_renewal']);
    $search_to_renewal = ($_REQUEST['search_to_renewal']);
  /*
    if ( trim($search_from_date) != "" )
    {
	    $search_from_date_arr =  explode("-",$search_from_date);
        $search_from_date_time = $search_from_date_arr[2]."-".$search_from_date_arr[1]."-".$search_from_date_arr[0];
        
        //$search_from_date_time = date('Y-m-d', strtotime($search_from_date));	 
    }
    else
    {
        $search_from_date_time = "";    
    }
    
    if ( trim($search_to_date) != "" )
    {
        //$search_to_date_time = date('Y-m-d', strtotime($search_to_date));
        
        $search_to_date_time_arr =  explode("-",$search_to_date_time);
        $search_to_date_time = $search_to_date_time_arr[2]."-".$search_to_date_time_arr[1]."-".$search_to_date_time_arr[0];	 
    }
    else
    {
        $search_to_date_time = "";    
    }
    
    
    
    
    $search_from_membership_date = ($_REQUEST['search_from_membership_date']);
    $search_to_membership_date = ($_REQUEST['search_to_membership_date']);
  
    if ( trim($search_from_membership_date) != "" )
    {
	    $search_from_date_membership_time = date('Y-m-d', strtotime($search_from_membership_date));	 
    }
    else
    {
        $search_from_date_membership_time = "";    
    }
    
    if ( trim($search_to_membership_date) != "" )
    {
        $search_to_date_membership_time = date('Y-m-d', strtotime($search_to_membership_date));	 
    }
    else
    {
        $search_to_date_membership_time = "";    
    }
    
    */
    
    
    if ( trim($search_from_date) != "" )
    {
        //$search_from_date_time = date('Y-d-m', strtotime($search_from_date));
        $search_from_date_arr =  explode("-",$search_from_date);
        $search_from_date_time = $search_from_date_arr[2]."-".$search_from_date_arr[1]."-".$search_from_date_arr[0];	 
    	 
    }
    else
    {
        $search_from_date_time = "";    
    }
    
    if ( $search_to_date != "" )
    {
        //$search_to_date_time = date('Y-d-m', strtotime($search_to_date));	 
        
        $search_to_date_arr =  explode("-",$search_to_date);
        $search_to_date_time = $search_to_date_arr[2]."-".$search_to_date_arr[1]."-".$search_to_date_arr[0];
    }
    else
    {
        $search_to_date_time = "";    
    }
    
    
    $search_from_membership_date = trustme($_REQUEST['search_from_membership_date']);
    $search_to_membership_date = trustme($_REQUEST['search_to_membership_date']);
    
    if ( trim($search_from_membership_date) != "" )
    {
        //$search_from_date_membership_time = date('Y-d-m', strtotime($search_from_membership_date));	
        $search_from_membership_date_arr =  explode("-",$search_from_membership_date);
        $search_from_date_membership_time = $search_from_membership_date_arr[2]."-".$search_from_membership_date_arr[1]."-".$search_from_membership_date_arr[0];	 
    }
    else
    {
        $search_from_date_membership_time = "";    
    }
    
    if ( $search_to_membership_date != "" )
    {
        //$search_to_date_membership_time = date('Y-d-m', strtotime($search_to_membership_date));
        
        $search_to_membership_date_arr =  explode("-",$search_to_membership_date);
        $search_to_date_membership_time = $search_to_membership_date_arr[2]."-".$search_to_membership_date_arr[1]."-".$search_to_membership_date_arr[0];	 
    }
    else
    {
        $search_to_date_membership_time = "";    
    }
	
	if ( trim($search_from_renewal) != "" )
    {
        $search_from_renewal_arr =  explode("-",$search_from_renewal);
        $search_from_renewal_time = $search_from_renewal_arr[2]."-".$search_from_renewal_arr[1]."-".$search_from_renewal_arr[0];	  
    }
    else
    {
        $search_from_renewal_time = "";    
    }
	
	if ( trim($search_to_renewal) != "" )
    {
        $search_to_renewal_arr =  explode("-",$search_to_renewal);
        $search_to_renewal_time = $search_to_renewal_arr[2]."-".$search_to_renewal_arr[1]."-".$search_to_renewal_arr[0];	  
    }
    else
    {
        $search_to_renewal_time = "";    
    }
    
    
    $search = "";
              
   
    if( trim($search_user_name) != "")
    {
        $search .= " and ((first_name LIKE :user_name) or (last_name LIKE :user_name) or (concat_ws(' ',first_name,last_name) LIKE :user_name ) ) ";
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
    
    
    //////////////////////////////////////////////////////
    
    if( (trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) != "") )
    {
        $search .= " AND membership_start_date between '$search_from_date_membership_time' AND '$search_to_date_membership_time'  ";
        
    } 
	else if( (trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) == "") )
    {
        $search .= " AND membership_start_date = '$search_from_date_membership_time' ";
    }  
  
    /////////////////////////////////////////////////////
  
  
    if( trim($search_register_status) != "" && trim($search_register_status) != "Renewal")
    {
        $search .= " AND register_status = :register_status ";
    }  
    if( trim($search_register_status) != "" && trim($search_register_status) == "Renewal")
    {
        $search .= " AND register_status = 'Renewal' ";
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
	if($search_register_status == "Renewal" && $search_from_renewal && $search_to_renewal){
		$SQL1 .= " LEFT JOIN tbl_become_member_receipt ON tbl_become_member_receipt.member_id=tbl_become_member.member_id"; 
		$SQL1 .= " WHERE tbl_become_member.status <> 'DELETE' AND tbl_become_member_receipt.status='ACTIVE' 
					AND tbl_become_member_receipt.add_time >= '".$search_from_renewal_time."'
					AND tbl_become_member_receipt.add_time <= '".$search_to_renewal_time."'
		"; 	
	}else{
		$SQL1 .= " WHERE status <> 'DELETE' ";
	} 
    $SQL1 .= " $search  ";    
     
    $SQL2 = "";
    $SQL2 .= " SELECT *, (CASE WHEN reg_number !='' THEN  reg_number ELSE u.member_id END) AS ordby "; 
// 	$SQL2 .= " SELECT *, (CASE WHEN reg_number !='' THEN  reg_number  END) AS ordby ";    
    $SQL2 .= " FROM " .  BECOME_MEMBER_TBL . " as u ";
	if($search_register_status == "Renewal" && $search_from_renewal && $search_to_renewal){
		$SQL2 .= " LEFT JOIN tbl_become_member_receipt ON tbl_become_member_receipt.member_id=u.member_id"; 
		$SQL2 .= " WHERE u.status <> 'DELETE' AND tbl_become_member_receipt.status='ACTIVE' 
					AND tbl_become_member_receipt.add_time >= '".$search_from_renewal_time."'
					AND tbl_become_member_receipt.add_time <= '".$search_to_renewal_time."'
		"; 
	}else{
		$SQL2 .= " WHERE status <> 'DELETE' ";  
	} 
	$SQL2 .= " $search  ";     
    $SQL2 .= " order by ordby desc "; 
	  
	//echo  $SQL2;exit;
    
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
    
    if( trim($search_register_status) != "" && trim($search_register_status) != "Renewal")
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
	//print_r($stmt2);exit; 
    
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
    
    if( trim($search_register_status) != ""  && trim($search_register_status) != "Renewal")
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
    

    <form name="frmDel" id="frmDel" method="post" >
        <input type="submit" formaction="" style="visibility: hidden; display: none;">
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
                             $(".export_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn"); 
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").css("background-color", "#BBBBBB").addClass("submit_btn"); 
                             $(".export_all").attr("disabled", false).removeClass("grey_btn").css("background-color", "#28B463").addClass("submit_btn");
                        }
                        
                    }); 
                    
                        
                    $(".cb-element").click(function(){
                            
                        var nock = $(".cb-element:checked").size();
                        var unock = $(".cb-element:unchecked").size();
                        //alert(nock);
                        
                        if( parseInt(nock) == parseInt(0) )
                        {
                             $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn");                                   
                             $(".export_all").attr("disabled", true).removeClass("submit_btn").css("background-color", "#BBBBBB").addClass("grey_btn");                                   
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass("submit_btn");  
                             $(".export_all").attr("disabled", false).removeClass("grey_btn").css("background-color", "#28B463").addClass("submit_btn");
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
                    $(".send_expired_mail").click(function(){
                       
                        id = $(this).attr("id");
        		       $.fancybox.open({
                			href : 'become_member_expired_sendmail.php?member_id='+id,
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
                <td class="list_table" style="padding: 5px 5px !important;" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" border='1' >
                       
                        <tr >
                            <th width="3%" align="center"><?php if( ( intval($dA) > intval(0) ) ) { ?><input type="checkbox" name="chk_all" value="1" id="chk_all" /><?php } ?></th>                     
                            <th width="12%" align="left">Name</th>
                            <th width="15%" align="left">Email/Password</th>
                            <th width="10%" align="left">Telephone</th>
                            <th width="12%" align="left">Reg. No.</th>
                            <th width="5%" align="left">SIG </th>
                            <th width="14%" align="center">Payment Status</th>
                            <th width="8%" align="center">Reg. Status</th>
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
                            
                            $membership_start_date = stripslashes($rs['membership_start_date']);
                            if($membership_start_date !='' && $membership_start_date !='0000-00-00')
                            {
                                $membership_start_date = date('d-m-y', strtotime($membership_start_date));
                            }
                            else
                            {
                                $membership_start_date = "";
                            }
                            
                            $membership_expired_date = stripslashes($rs['membership_expired_date']);
                            if($membership_expired_date !='' && $membership_expired_date !='0000-00-00')
                            {
                                $membership_expired_date = date('d-m-y', strtotime($membership_expired_date));
                            }
                            else
                            {
                                $membership_expired_date = "";
                            }
                            
                            
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
                                   
                                    
                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $member_id; ?>" />
                                   
                                    
                                    
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
                                        <div style='color:#18A15D;font-size: 11px;'> <i class="fa fa-key" ></i> <?php echo $password; ?> </div>
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
                                        if($membership_start_date !="" && $membership_start_date !='0000-00-00')
                                        {
                                            echo "<div style='font-size:10px'>".$membership_start_date." To ". $membership_expired_date."</div>"; 
                                        }
                                    ?>    
                                     <!--<input name="paysucessmail" style="border: 0;background: #fff;color: #D9414D;" id="" value="send mail"  formaction="paysuccessmail.php?member_id=" type="submit" style='width: 45%;color:#DC493D;font-size: 10px;'> -->
                                        <div><a href="javascript:void(0);" id="<?php echo $member_id; ?>" class="send_mail" style='color:#DC493D;font-size: 10px;'>Send Mail</a></div> 
                                    
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
                                   else if(strtolower($register_status) == "expired")
                                    {
                                        echo "<span style='color:#18A15D;font-weight: bold;'>".$register_status."</span>"; 
                                        // if($sig_member == intval(0))
                                        // {
                                        ?>
                                        <div id="INPROCESS_MAIL" >
                                            <!--<div><a href="javascript:void(0);" id="" class="send_expired_mail" style='color:#DC493D;font-size: 10px;'>Send Mail</a></div> -->
                                            <input name="expmail" style="border: 0;background: #fff;color: #D9414D;" id="<?php  echo $member_id;  ?>" formaction="expiredmail.php?member_id=<?php  echo $member_id;  ?>"  type="submit" value="send mail"/>
                                        <div id="INPROCESS_ERROR"></div>
                                        <?php
                                        // }
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
                                        
                                        
                                        <!--a href="<?php if(strtolower($add_by)=='admin') { echo PAGE_MAIN; } else { echo EDIT_MAIN; } ?>?con=modify&id=<?php echo $member_id; ?>" class="img_btn viewDetail modi" title="Modify">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" />
                                        </a--->
                                        
                                        <a href="<?php if(strtolower($add_by)=='admin') { echo EDIT_MAIN; } else { echo EDIT_MAIN; } ?>?con=modify&id=<?php echo $member_id; ?>" class="img_btn viewDetail modi" title="Modify">
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
                    <input type="button" formaction="" style="margin-right: 39px;
"  class="grey_btn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                    <input name="frexp" formaction="main_export.php" class="grey_btn export_all" type="submit" value="Export Selected" disabled="" />
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

function sendexpiredMail()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    
    
       
    if(intval($ID) > intval(0))
    {
        $send = sendMailformate('Expired',$ID,"ADMIN");
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

<script>
    
</script>


<!--<form action="main_export.php" method="post">-->
<!--		<input name="frexp" type="submit" value="Export Selected">-->
<!--</form>-->

