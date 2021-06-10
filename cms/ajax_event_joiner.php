<?php
session_start();
error_reporting(E_ALL);

// error_reporting(E_ALL);
// ini_set('display_errors',1);

include "ajax_include.php";

define("EDIT_MAIN", "event_joiner_edit.php");
define("PAGE_AJAX", "ajax_event_joiner.php");
define("PAGE_LIST", "event_joiner_list.php");

$type = trustme($_REQUEST['type']);
switch ($type) {
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

global $dCON;

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_PAYMENT_RECIEPT;

    if ($imageId == intval(0)) {
        //delete image
        if (unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) {
            deleteIMG("PAYMENT_RECIEPT_IMG", $image_name, CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD);
            echo "1~~~Deleted";
        } else {
            echo "0~~~Sorry Cannot Delete Image";
        }
    } else {
        if (unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) {

            deleteIMG("PAYMENT_RECIEPT_IMG", $image_name, CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME);

            $SQL = "";
            $SQL .= " UPDATE tbl_event_joiner_receipt SET ";
            $SQL .= " status = 'DELETE' ";
            $SQL .= " WHERE reciept_id = :reciept_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;

            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":reciept_id", $imageId);
            $stk_upd->execute();

            $stk_upd->closeCursor();

            echo "1~~~Deleted";
        } else {
            echo "0~~~Sorry Cannot Delete Image";
        }

    }
}

function saveData()
{

    $title = ($_POST['title']) ? trustme($_POST['title']) : '';
    $fname = ($_POST['fname']) ? trustme($_POST['fname']) : '';
    $surname = ($_POST['surname']) ? trustme($_POST['surname']) : '';
    $name_on_badge = ($_POST['name_on_badge']) ? trustme($_POST['name_on_badge']) : '';
    $firmname = ($_POST['firmname']) ? trustme($_POST['firmname']) : '';
    $phone = ($_POST['phone']) ? trustme($_POST['phone']) : '';
    $email = ($_POST['email']) ? trustme($_POST['email']) : '';
    $address = ($_POST['address']) ? trustme($_POST['address']) : '';
    $membership_no = ($_POST['membership_no']) ? trustme($_POST['membership_no']) : '';
    $pay_by = ($_POST['pay_by']) ? trustme($_POST['pay_by']) : ''; //Cheque/NEFT
    $order_of = ($_POST['order_of']) ? trustme($_POST['order_of']) : ''; //Cheque/NEFT
    $cheque_utr_no = ($_POST['cheque_utr_no']) ? trustme($_POST['cheque_utr_no']) : ''; //Cheque No:UTR No. Amount:Address (if different from address on previous page)
    $is_previously_attendeds = ($_POST['is_previously_attended']) ? trustme($_POST['is_previously_attended']) : ''; //I enclose a cheque/draft/NEFT to the order of:
    $event_id = ($_POST['event']) ? intval($_POST['event']) : ''; //I enclose a cheque/draft/NEFT to the order of:

    $fullname = trim(ucfirst($title) . ' ' . ucfirst($fname) . ' ' . ucfirst($surname));
    $is_previously_attended = ($is_previously_attendeds == 1) ? 'Yes' : 'No';

    $terms = intval($_REQUEST["terms"]);

    $status = "PENDING";
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $TIME = date("Y-m-d H:i:s");
    $BY = "SELF";

    $today = date('m/d/Y h:iA');
    $middate = new DateTime('10/15/2018 11:59PM');

    if ($membership_no) {

        if ($today > $middate) {

            $registration_fees = '18800'; // After 15th Oct '18

        } else {

            $registration_fees = '16920'; // Till 15th Oct '18

        }

    } else {

        if ($today > $middate) {

            $registration_fees = '23600'; // After 15th Oct '18

        } else {

            $registration_fees = '21240'; // Till 15th Oct '18

        }

    }

    $CHK = checkDuplicate(EVENT_JOINER_TBL, "status~~~email", "PENDING~~~" . $email, "=~~~=", "");

    if (intval($CHK) == intval(0)) {

        $MAX_ID = getMaxId(EVENT_JOINER_TBL, "event_joiner_id");

        $SQL = "";
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
        $SQL .= " is_previously_attended = :is_previously_attended,";
        $SQL .= " registration_fees = :registration_fees,";
        $SQL .= " terms = :terms,";
        $SQL .= " status = :status, ";
        $SQL .= " add_ip = :add_ip, ";
        $SQL .= " add_by = :add_by, ";
        $SQL .= " add_time = :add_time ";
        //echo $SQL; exit();
        $stmt = $dCON->prepare($SQL);
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
        $stmt->bindParam(":is_previously_attended", $is_previously_attended);
        $stmt->bindParam(":registration_fees", $registration_fees);
        $stmt->bindParam(":terms", $terms);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":add_ip", $IP);
        $stmt->bindParam(":add_by", $BY);
        $stmt->bindParam(":add_time", $TIME);
        $dbRES = $stmt->execute();
        $stmt->closeCursor();

        if ($dbRES == 1) {
            $RTNID = $MAX_ID;

            ////////////////user Mail
            sendMailformate("EVENT_JOINER_REQUEST", $RTNID, "");

            //////////////Admin Mail

            $MAIL_FORMAT = getMailFormat('EVENT_JOINER_REQUEST', $RTNID, "");

            $SUBJECT = $_SESSION['COMPANY_NAME'] . " : New Event Joiner Request";
            $TO_EMAIL = $_SESSION['INFO_EMAIL'];
            $FROM_EMAIL = $_SESSION["AUTH_EMAIL_USERNAME"];
            $CC_EMAIL = 'aditikhanna@insolindia.com,seo@sabsoftzone.com,santoshbeats@gmail.com';
            $BCC_EMAIL = 'rohit@sabsoftzone.com';

            MailObject($TO_EMAIL, $FROM_EMAIL, $CC_EMAIL, $BCC_EMAIL, $SUBJECT, $MAIL_FORMAT, "");

        }

    } else {
        $dbRES = 2;
    }

    switch ($dbRES) {

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
}

function editData()
{
    global $dCON;

    $event_joiner_id = intval($_REQUEST['id']);

    $title = trustme($_REQUEST["title"]);
    $fname = trustme($_REQUEST["fname"]);
    $surname = trustme($_REQUEST["surname"]);
    $name_on_badge = trustme($_REQUEST["name_on_badge"]);
    $firmname = trustme($_REQUEST["firmname"]);
    $address = trustme($_REQUEST["address"]);

    $telephone = trustme($_REQUEST["phone"]);
    $registration_fees = trustme($_REQUEST["registration_fees"]);
    $pay_by = trustme($_REQUEST["pay_by"]);
    $order_of = trustme($_REQUEST["order_of"]);
    $cheque_no = trustme($_REQUEST["cheque_no"]);
    $utr_no = trustme($_REQUEST["utr_no"]);
    $enclosed_amount = trustme($_REQUEST["enclosed_amount"]);
    $draft_address = trustme($_REQUEST["draft_address"]);
    $is_previously_attended = ($_REQUEST["is_previously_attended"]) ? trustme($_REQUEST["is_previously_attended"]) : 'No';
    $registration_no = trustme($_REQUEST["registration_no"]);
    $email = trustme($_REQUEST["email"]);

    $image_array = ($_REQUEST['image']);
    $folder_name_array = $_REQUEST['folder_name'];
    $caption_array = $_REQUEST['caption'];
    $image_id_array = ($_REQUEST['image_id']);

    $con = trustme($_REQUEST['con']);
    $BY = 'admin';

    $register_status = trustme($_REQUEST["status"]);
    $membership_no = trustme($_REQUEST["membership_no"]);
    $payment_status = trustme($_REQUEST["payment_status"]);
    $payment_text = trustme($_REQUEST["payment_text"]);

    $internal_comments = trustme($_REQUEST["internal_comments"]);

    $old_register_status = trustme($_REQUEST["old_register_status"]);
    $old_payment_status = trustme($_REQUEST["old_payment_status"]);

    $reg_number_temp = "";
    $reg_number_text_temp = "";

    if (strtolower($register_status) == 'approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved')) {
        $SQL = "";
        $SQL .= " SELECT IFNULL(MAX(reg_number_temp) + 1, 151) as max_reg_number_temp FROM " . EVENT_JOINER_TBL . " where (status = 'APPROVED' || status = 'Approved') ";
        $stmt = $dCON->prepare($SQL);
        $stmt->execute();
        $row = $stmt->fetchAll();
        $stmt->closeCursor();
        $reg_number_temp = intval($row[0]['max_reg_number_temp']);
        if (intval($reg_number_temp) <= 1) {
            $reg_number_temp = 151;
        }
        $registration_no = 'IIAC/' . $reg_number_temp;

    }

    $ip = trustme($_SERVER['REMOTE_ADDR']);
    $update_time = date("Y-m-d H:i:s");

    //exit;

    $sql = "";
    $sql .= " UPDATE  " . EVENT_JOINER_TBL . "  SET ";
    $sql .= " title = :title,";
    $sql .= " fname = :fname,";
    $sql .= " surname = :surname,";
    $sql .= " membership_no = :membership_no,";
    $sql .= " firmname = :firmname,";
    $sql .= " name_on_badge = :name_on_badge,";
    $sql .= " address = :address,";
    $sql .= " phone = :telephone,";
    $sql .= " registration_fees = :registration_fees,";
    $sql .= " email = :email,";
    $sql .= " pay_by = :pay_by,";
    $sql .= " order_of = :order_of,";

    $sql .= " cheque_no = :cheque_no,";
    $sql .= " utr_no = :utr_no,";
    $sql .= " enclosed_amount = :enclosed_amount,";
    $sql .= " draft_address = :draft_address,";
    $sql .= " is_previously_attended = :is_previously_attended,";
    $sql .= " reciept_image_name = :reciept_image_name, ";
    $sql .= " image_id = :image_id, ";

    if ($payment_status != '') {
        $sql .= " payment_status = :payment_status, ";
        $sql .= " payment_text = :payment_text, ";
        /*  if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
    {
    //$sql .= " reg_number_text = :reg_number_text, ";
    $sql .= " registration_no = :registration_no, ";

    } */
    }

    if ($register_status != '') {
        if (strtolower($register_status) == 'approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved')) {
            $sql .= " reg_number_temp = :reg_number_temp, ";
            $sql .= " registration_no = :registration_no, ";
        }

        $sql .= " status = :register_status, ";
    }
    $sql .= " internal_comments = :internal_comments, ";

    $sql .= " update_ip = :update_ip, ";
    $sql .= " update_by = :update_by, ";
    $sql .= " update_time = :update_time ";
    $sql .= " WHERE event_joiner_id = :event_joiner_id";
    //  echo $sql; exit;
    $stmt3 = $dCON->prepare($sql);
    $stmt3->bindParam(":title", $title);
    $stmt3->bindParam(":fname", $fname);
    $stmt3->bindParam(":surname", $surname);
    $stmt3->bindParam(":membership_no", $membership_no);
    $stmt3->bindParam(":firmname", $firmname);
    $stmt3->bindParam(":name_on_badge", $name_on_badge);
    $stmt3->bindParam(":address", $address);
    $stmt3->bindParam(":telephone", $telephone);
    $stmt3->bindParam(":registration_fees", $registration_fees);
    $stmt3->bindParam(":email", $email);
    $stmt3->bindParam(":pay_by", $pay_by);
    $stmt3->bindParam(":order_of", $order_of);

    $stmt3->bindParam(":cheque_no", $cheque_no);
    $stmt3->bindParam(":utr_no", $utr_no);
    $stmt3->bindParam(":enclosed_amount", $enclosed_amount);
    $stmt3->bindParam(":draft_address", $draft_address);
    $stmt3->bindParam(":is_previously_attended", $is_previously_attended);
    $stmt3->bindParam(":reciept_image_name", $reciept_image_name);
    $stmt3->bindParam(":image_id", $image_id);

    if ($payment_status != '') {
        $stmt3->bindParam(":payment_status", $payment_status);
        $stmt3->bindParam(":payment_text", $payment_text);
        /* if(strtoupper($payment_status) =='SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL')
    {
    // $stmt3->bindParam(":reg_number_text", $reg_number_text);

    } */
    }

    if ($register_status != '') {
        if (strtolower($register_status) == 'approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved')) {
            $stmt3->bindParam(":reg_number_temp", $reg_number_temp);
            $stmt3->bindParam(":registration_no", $registration_no);
        }
        $stmt3->bindParam(":register_status", $register_status);
    }
    $stmt3->bindParam(":internal_comments", $internal_comments);

    $stmt3->bindParam(":update_ip", $ip);
    $stmt3->bindParam(":update_by", $BY);
    $stmt3->bindParam(":update_time", $update_time);
    $stmt3->bindParam(":event_joiner_id", $event_joiner_id);
    $rs = $stmt3->execute();
    if ($rs == 1) {

        if (intval(count($image_array)) > intval(0)) {
            foreach ($image_array as $indx => $image_result) {
                $reciept_image_name = "";
                $reciept_caption = "";
                $reciept_id = 0;

                $reciept_image_name = trustme($image_result);

                $reciept_caption = $caption_array[$indx];
                $reciept_id = intval($image_id_array[$indx]);

                $MYFOLDERNAME = "";
                $MYFOLDERNAME = $folder_name_array[$indx];

                if (intval($reciept_id) == intval(0)) {
                    $TEMP_FOLDER_NAME = "";
                    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

                    $FOLDER_NAME = "";
                    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";

                    $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);
                    $position = 0;

                    if (intval($chk_file) == intval(1)) {
                        $MAXID_IMG = getMaxId('tbl_event_joiner_receipt', "reciept_id");

                        $name_filter = filterString($fname);

                        $img_ext = pathinfo($reciept_image_name);
                        $fpath_image = strtolower($name_filter) . "-" . $event_joiner_id . "-" . $MAXID_IMG . "." . $img_ext['extension'];

                        rename($TEMP_FOLDER_NAME . $reciept_image_name, $FOLDER_NAME . $fpath_image);

                        $SQL_IMG = "";
                        $SQL_IMG .= " INSERT INTO tbl_event_joiner_receipt SET ";
                        $SQL_IMG .= " reciept_id = :reciept_id, ";
                        $SQL_IMG .= " event_joiner_id = :event_joiner_id, ";
                        $SQL_IMG .= " reciept_caption = :reciept_caption, ";
                        $SQL_IMG .= " reciept_image_name = :reciept_image_name, ";
                        $SQL_IMG .= " position = :position, ";
                        $SQL_IMG .= " add_ip = :add_ip, ";
                        $SQL_IMG .= " add_by = :add_by, ";
                        $SQL_IMG .= " add_time = :add_time ";

                        $stmtIMG = $dCON->prepare($SQL_IMG);
                        $stmtIMG->bindParam(":reciept_id", $MAXID_IMG);
                        $stmtIMG->bindParam(":event_joiner_id", $event_joiner_id);
                        $stmtIMG->bindParam(":reciept_caption", $reciept_caption);
                        $stmtIMG->bindParam(":reciept_image_name", $fpath_image);
                        $stmtIMG->bindParam(":position", $position);
                        $stmtIMG->bindParam(":add_ip", $ip);
                        $stmtIMG->bindParam(":add_by", $BY);
                        $stmtIMG->bindParam(":add_time", $update_time);
                        $rsImage = $stmtIMG->execute();
                        //print_r($stmtIMG->errorInfo());
                        //echo intval($rsImage);
                        $stmtIMG->closeCursor();
                    }

                } else {
                    $TEMP_FOLDER_NAME = "";
                    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";

                    $FOLDER_NAME = "";
                    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT . "/";

                    $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $reciept_image_name);

                    $name_filter = filterString($fname);

                    $img_ext = pathinfo($reciept_image_name);
                    $fpath_image = strtolower($name_filter) . "-" . $event_joiner_id . "-" . $reciept_id . "." . $img_ext['extension'];

                    if ($fpath_image != $reciept_image_name) {
                        rename($TEMP_FOLDER_NAME . $reciept_image_name, $FOLDER_NAME . $fpath_image);
                    } else {
                        $fpath_image = $reciept_image_name;
                    }

                    $SQL_IMG = "";
                    $SQL_IMG .= " UPDATE tbl_event_joiner_receipt SET ";
                    $SQL_IMG .= " reciept_image_name = :reciept_image_name, ";
                    $SQL_IMG .= " reciept_caption = :reciept_caption, ";
                    $SQL_IMG .= " update_ip = :update_ip, ";
                    $SQL_IMG .= " update_by = :update_by, ";
                    $SQL_IMG .= " update_time = :update_time ";
                    $SQL_IMG .= " where reciept_id = :reciept_id ";
                    $SQL_IMG .= " and event_joiner_id = :event_joiner_id ";

                    $stmtIMG = $dCON->prepare($SQL_IMG);
                    $stmtIMG->bindParam(":reciept_image_name", $fpath_image);
                    $stmtIMG->bindParam(":reciept_caption", $reciept_caption);
                    $stmtIMG->bindParam(":update_ip", $ip);
                    $stmtIMG->bindParam(":update_by", $BY);
                    $stmtIMG->bindParam(":update_time", $update_time);
                    $stmtIMG->bindParam(":reciept_id", $reciept_id);
                    $stmtIMG->bindParam(":event_joiner_id", $event_joiner_id);
                    $rsImage = $stmtIMG->execute();
                    //print_r($stmtIMG->errorInfo());
                    //echo intval($rsImage);
                    //$sth->debugDumpParams();
                    $stmtIMG->closeCursor();

                }

                $position++;
            }

        }

        if (strtolower($register_status) == 'approved' && (strtolower($old_register_status) != 'expired' && strtolower($old_register_status) != 'approved')) {
            if ($sig_member == intval(0)) {
                sendMailformate('event_joiner_request_approved', $event_joiner_id, "ADMIN");
            }
        }

        if (strtoupper($payment_status) == 'SUCCESSFUL' && strtoupper($old_payment_status) != 'SUCCESSFUL') {
            sendMailformate('EVENT_JOINER_PAYMENT_MAIL', $event_joiner_id, "ADMIN");
        }
    }

    switch ($rs) {
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

    $search_register_status = trustme($_REQUEST['search_register_status']);
    $search_payment_status = trustme($_REQUEST['search_payment_status']);

    $search_from_date = ($_REQUEST['search_from_date']);
    $search_to_date = ($_REQUEST['search_to_date']);

    if (trim($search_from_date) != "") {
        //$search_from_date_time = date('Y-d-m', strtotime($search_from_date));
        $search_from_date_arr = explode("-", $search_from_date);
        $search_from_date_time = $search_from_date_arr[2] . "-" . $search_from_date_arr[1] . "-" . $search_from_date_arr[0];

    } else {
        $search_from_date_time = "";
    }

    if ($search_to_date != "") {
        //$search_to_date_time = date('Y-d-m', strtotime($search_to_date));

        $search_to_date_arr = explode("-", $search_to_date);
        $search_to_date_time = $search_to_date_arr[2] . "-" . $search_to_date_arr[1] . "-" . $search_to_date_arr[0];
    } else {
        $search_to_date_time = "";
    }

    $search = "";

    if (trim($search_user_name) != "") {
        $search .= " and ((fname LIKE :user_name) or (surname LIKE :user_name) or (concat_ws(' ',fname,surname) LIKE :user_name ) ) ";
        //$search .= " AND O.customer_name LIKE :user_name ";
    }

    if (trim($search_email) != "") {
        $search .= " AND email = '" . $search_email . "' ";
    }

    if ((trim($search_from_date_time) != "") && (trim($search_to_date_time) != "")) {
        $search .= " AND date(add_time) between '$search_from_date_time' AND '$search_to_date_time' ";

    } else if ((trim($search_from_date_time) != "") && (trim($search_to_date_time) == "")) {
        $search .= " AND date(add_time) = '$search_from_date_time' ";
    }

    //////////////////////////////////////////////////////

    if (trim($search_register_status) != "") {
        $search .= " AND `status` = :register_status ";
    }

    if (trim($search_payment_status) != "") {
        $search .= " AND payment_status = :payment_status ";
    }

    $SQL1 = "";
    $SQL1 .= " SELECT COUNT(*) AS CT  FROM " . EVENT_JOINER_TBL . " ";
    $SQL1 .= " WHERE status <> 'DELETE' ";
    $SQL1 .= " $search  ";

    $SQL2 = "";
    $SQL2 .= " SELECT * ";
    $SQL2 .= " FROM " . EVENT_JOINER_TBL . " as u ";
    $SQL2 .= " WHERE status <> 'DELETE' ";
    $SQL2 .= " $search  ";
    $SQL2 .= " order by event_joiner_id desc ";

    // echo $SQL1 . "<BR><BR><BR>";
    // echo $SQL2 . "<BR><BR><BR>";
    // exit;

    $stmt1 = $dCON->prepare($SQL1);

    if (trim($search_user_name) != "") {
        $stmt1->bindParam(":user_name", $username);
        $username = "%{$search_user_name}%";
    }

    if (trim($search_register_status) != "") {
        $stmt1->bindParam(":register_status", $search_register_status);
    }

    if (trim($search_payment_status) != "") {
        $stmt1->bindParam(":payment_status", $search_payment_status);
    }

    $stmt1->execute();

    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];

    $rowsPerPage = 100;
    $pg_query = $pg->getPagingQuery($SQL2, $rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);

    if (trim($search_user_name) != "") {
        $stmt2->bindParam(":user_name", $username);
        $username = "%{$search_user_name}%";
    }

    if (trim($search_register_status) != "") {
        $stmt2->bindParam(":register_status", $search_register_status);
    }

    if (trim($search_payment_status) != "") {
        $stmt2->bindParam(":payment_status", $search_payment_status);
    }

    $stmt2->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt2->bindParam(":RPP", $RPP, PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
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

                                    <?php if (intval($dA) > intval(0)) {?>

                                    <td align="center" style="padding-right:10px;">
                                        <a href="javascript:void(0);" id="getExcelLatest" class=""
                                            style="color:#D9414D;font-weight: bold;">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>excel_icon.png"
                                                border="0" title="Export to Excel" alt="Export to Excel"
                                                align="absmiddle" /> Export to Excel
                                        </a>
                                    </td>

                                    <td align="right" style="padding-right:10px;">
                                        <b>Total Records: <?php echo intval($dA); ?></b>
                                    </td>
                                    <?php }?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php
if (intval($dA) > intval(0)) {
        global $PERMISSION;
        echo $_SESSION['PERMISSION'];

        ?>

        <script language="javascript" type="text/javascript">
        $(document).ready(function() {

            $(document).ready(function() {
                $("#getExcelLatest").click(function() {
                    var formvalue = $("#frm").serialize();
                    //alert(formvalue);
                    location.href = "excel_event_joiner_list.php?" + formvalue;
                });
            });

            $("#chk_all").click(function() {

                $('.cb-element').attr('checked', $(this).is(':checked') ? true : false);


                var nock = $(".cb-element:checked").size();
                if (parseInt(nock) == parseInt(0)) {
                    $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass(
                        "grey_btn");
                } else {
                    $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass(
                        "submit_btn");
                }

            });


            $(".cb-element").click(function() {

                var nock = $(".cb-element:checked").size();
                var unock = $(".cb-element:unchecked").size();
                //alert(nock);

                if (parseInt(nock) == parseInt(0)) {
                    $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass(
                        "grey_btn");
                } else {
                    $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass(
                        "submit_btn");
                }

                if (parseInt(unock) == parseInt(0)) {
                    $("#chk_all").attr("checked", true);
                } else {
                    $("#chk_all").attr("checked", false);
                }

            });


            //DELETE SELECTED
            $(".delete_all").click(function() {
                $(this).deleteSelected();
            });

            //DELETE DATA
            $(".deleteData").click(function() {
                var value = $(this).attr("value");
                //alert(value);
                $(this).deleteData({
                    ID: value
                });
            });

            $(".setStatus").live("click", function() {
                var ID = $(this).attr("value");
                var VAL = $(this).attr("myvalue");
                //alert(ID+"####"+VAL);
                $(this).setStatus({
                    ID: ID,
                    VAL: VAL
                });
            });


            $(".view_detail").click(function() {
                id = $(this).attr("id");

                $.fancybox.open({
                    href: 'event_joiner_view.php?event_joiner_id=' + id,
                    type: 'iframe',
                    padding: 5
                });

            });


            $(".send_mail").click(function() {
                id = $(this).attr("id");
                $.fancybox.open({
                    href: 'event_joiner_sendmail.php?event_joiner_id=' + id,
                    type: 'iframe',
                    padding: 5
                });


            });

            $(".send_approval_mail").click(function() {
                var ID = $(this).attr("id");
                $.ajax({
                    type: "POST",
                    url: "<?php echo PAGE_AJAX; ?>",
                    data: "type=sendapprovalMAIL&ID=" + ID,
                    beforeSend: function() {

                        $("#INPROCESS_MAIL").hide();
                        $("#INPROCESS_ERROR").show();
                        $("#INPROCESS_ERROR").html(
                            "<div style='text-align: center;'><i class='icon iconloader'></i> Processing...</div>"
                        );
                    },

                    success: function(msg) {

                        //alert(msg);

                        var spl_txt = msg.split("~~~");
                        if (spl_txt[1] == '1') {
                            colorStyle = "color:#18A15D;";
                        } else {
                            colorStyle = "errorTxt";
                        }


                        $("#INPROCESS_ERROR").html(
                            "<div style='text-align: center;' id='inprocess'><div style='" +
                            colorStyle + "' >" + spl_txt[2] + "</div></div>");

                        setTimeout(function() {

                            if (parseInt(spl_txt[1]) == parseInt(1)) {
                                //parent.$.fancybox.close();
                                parent.window.location.reload();
                            } else {
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
                <table cellpadding="0" cellspacing="0" width="100%" border='1'>

                    <tr>
                        <th width="3%" align="center"><?php if ((intval($dA) > intval(0))) {?><input type="checkbox"
                                name="chk_all" value="1" id="chk_all" /><?php }?></th>
                        <th width="12%" align="left">Name</th>
                        <th width="12%" align="left">Email</th>
                        <th width="12%" align="left">Telephone</th>
                        <!-- <th width="15%" align="left">Name On Badge</th> -->
                        <!-- <th width="15%" align="left">MemberShip No</th> -->
                        <th width="10%" align="left">Firm Name</th>
                        <th width="14%" align="center">Reg. Status</th>
                        <th width="14%" align="center">Payment Status</th>
                        <th align="center" width="10%">Action</th>
                    </tr>

                    <?php
$CK_COUNTER = 0;
        $FOR_BG_COLOR = 0;
        $disp = 0;
        foreach ($row as $rs) {
            $event_joiner_id = "";
            $event_id = "";
            $membership_no = "";
            $title = "";
            $fname = "";
            $surname = "";
            $name_on_badge = "";
            $firmname = "";
            $phone = "";
            $email = "";
            $status = "";
            $payment_status = "";
            $registration_fees = "";

            $event_joiner_id = intval($rs['event_joiner_id']);

            $event_id = intval($rs['event_id']);

            $membership_no = stripslashes($rs['membership_no']);

            $title = stripslashes($rs['title']);
            $fname = ucwords(strtolower(stripslashes($rs['fname'])));
            $surname = ucwords(strtolower(stripslashes($rs['surname'])));
            $name_on_badge = ucwords(strtolower(stripslashes($rs['name_on_badge'])));

            $fullname = "";
            if ($title != "") {
                $fullname .= $title . " ";
            }
            $fullname .= $fname . " ";
            if ($surname != "") {
                $fullname .= $surname . " ";
            }

            $email = stripslashes($rs['email']);
            $mobile = stripslashes($rs['mobile']);
            $phone = stripslashes($rs['phone']);
            $payment_status = stripslashes($rs['payment_status']);

            $firmname = stripslashes($rs['firmname']);

            $status = stripslashes($rs['status']);
            $STATUSnowaction = stripslashes($status) == 'APPROVED' ? "PENDING" : "APPROVED";

            if (trim(strtoupper($payment_status)) == 'SUCCESSFUL') {
                $CHK = 1;
            } else {
                $CHK = 0;
            }

            ?>
                    <tr class="expiredCoupons trhover">
                        <td align="center" width="3%">
                            <?php
if (intval($CHK) == intval(0)) {
                $CK_COUNTER++;
                ?>
                            <input type="checkbox" class="cb-element" name="chk[]"
                                value="<?php echo $event_joiner_id; ?>" />
                            <?php
} else {
                echo '<input type="checkbox" disabled=""/>';
            }
            ?>

                        </td>

                        <td>
                            <?php echo $fullname; //ucwords(strtolower($first_name.' '.$last_name));  ?>
                        </td>
                        <td>
                            <?php echo $email; ?>
                        </td>
                        <td>
                            <?php echo $phone; ?>
                        </td>
                        <!--  <td>
                                        <?php //echo $name_on_badge; ?>
                                    </td>  -->
                        <!-- <td>
                                        <?php //echo $membership_no; ?>
                                    </td> -->
                        <td>
                            <?php echo $firmname; ?>
                        </td>

                        <td align='center'>
                            <?php
if (strtolower($status) == "approved") {
                echo "<span style='color:#18A15D;font-weight: bold;'>" . $status . "</span>";
                if ($sig_member == intval(0)) {
                    ?>
                            <div id="INPROCESS_MAIL"><a href="javascript:void(0);" id="<?php echo $event_joiner_id; ?>"
                                    class="send_approval_mail" id="INPROCESS_MAIL"
                                    style='color:#DC493D;font-size: 10px;'>Send Mail</a></div>
                            <div id="INPROCESS_ERROR"></div>
                            <?php
}
            } else if (strtolower($status) == "declined") {
                echo "<span style='color:#C44B2A;'>" . $status . "</span>";
            } else {
                echo $status;
            }

            ?>
                        </td>

                        <td align='center'>
                            <?php
if (strtoupper($payment_status) == "SUCCESSFUL") {
                echo "<span style='color:#18A15D;font-weight: bold;'>" . ucwords(strtolower($payment_status)) . "</span>";
                ?>
                            <div><a href="javascript:void(0);" id="<?php echo $event_joiner_id; ?>" class="send_mail"
                                    style='color:#DC493D;font-size: 10px;'>Send Mail</a></div>

                            <?php
} else {
                echo ucwords(strtolower($payment_status));
            }
            ?>
                        </td>

                        <td align="center">
                            <div id="INPROCESS_DELETE_1_<?php echo $event_joiner_id; ?>" style="display: none;"></div>
                            <div id="INPROCESS_DELETE_2_<?php echo $event_joiner_id; ?>">

                                <a href="javascript:void(0);" id="<?php echo $event_joiner_id; ?>"
                                    class="img_btn view_detail" title="View Details"><img border="0"
                                        src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>view.png" class="cmsIcon"
                                        alt="View Details"></a></span>

                                <a href="<?php if (strtolower($add_by) == 'admin') {echo EDIT_MAIN;} else {echo EDIT_MAIN;}?>?con=modify&id=<?php echo $event_joiner_id; ?>"
                                    class="img_btn viewDetail" title="Modify">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0"
                                        title="Modify" alt="Modify" />
                                </a>

                                <?php
if (intval($CHK) == intval(0)) {
                ?>
                                <a href="javascript:void(0);" value="<?php echo $event_joiner_id; ?>"
                                    class="deleteData img_btn">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0"
                                        title="Delete" alt="Delete" /></a>
                                <?php
} else {
                ?>
                                <a href="javascript:void(0);" class="img_btn">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash_disable.png"
                                        border="0" title="Cannot Delete" alt="Cannot Delete" /></a>
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
            <td height="30" colspan="<?php echo $COLSPAN; ?>" class="txt1" style="padding-top:10px;" valign="top"
                id="INPROCESS_DEL">
                <input type="button" class="grey_btn delete_all" value="Delete Selected" id="delete_all" disabled="" />
            </td>
        </tr>
        <?php
if ($paging[0] != "") {
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
} else {
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

function registerSave()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");

    $ID = intval($_REQUEST['ID']);

    $register_status = trustme($_REQUEST['register_status']);

    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);

    if (strtolower($register_status) == 'approved') {
        $SQL = "";
        $SQL .= " SELECT IFNULL(MAX(reg_number_temp) + 1, 151) as max_reg_number FROM " . EVENT_JOINER_TBL . " where status = 'APPROVED' ";
        $stmt = $dCON->prepare($SQL);
        $stmt->execute();
        $row = $stmt->fetchAll();
        $stmt->closeCursor();
        $reg_number_temp = intval($row[0]['max_reg_number']);
        if (intval($reg_number_temp) <= 1) {
            $reg_number_temp = 151;
        }
        $registration_no = 'IIAC/' . $reg_number_temp;

    }

    $STR = "";
    $STR .= " UPDATE  " . EVENT_JOINER_TBL . "  SET ";
    $STR .= " status = :register_status, ";
    if (strtolower($register_status) == 'approved') {
        $STR .= " registration_no = :registration_no, ";
        $STR .= " reg_number_temp = :reg_number_temp, ";
    }

    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE event_joiner_id = :event_joiner_id ";

    //echo $STR;
    //exit();
    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":register_status", $register_status);
    if (strtolower($register_status) == 'approved') {
        $sDEF->bindParam(":registration_no", $registration_no);
        $sDEF->bindParam(":reg_number_temp", $reg_number_temp);
    }

    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":event_joiner_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();

    if (intval($RES) == intval(1)) {
        if (strtolower($register_status) == 'approved') {
            sendMailformate('event_joiner_request_approved', $ID, "ADMIN");
        }

        echo '~~~1~~~' . $register_status . '~~~' . $ID . "~~~";
    } else {
        echo '~~~0~~~ERROR~~~';
    }

}

function deleteData()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);

    $stmt_del = $dCON->prepare(" UPDATE " . EVENT_JOINER_TBL . " SET status = 'DELETE' WHERE event_joiner_id = ? ");
    $stmt_del->bindParam(1, $ID);
    $dbRES = $stmt_del->execute();
    $stmt_del->closeCursor();

    if (intval($dbRES) == intval(1)) {
        $CNT = getDetails(EVENT_JOINER_TBL, "COUNT", "status", "DELETE", "!=", "", "", "");
        echo '~~~1~~~Deleted~~~' . $CNT . "~~~";
    } else {
        echo '~~~0~~~Error occured~~~';
    }

}

function sendMail()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");

    $ID = intval($_REQUEST['ID']);
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);

    if (intval($ID) > intval(0)) {
        $send = sendMailformate('EVENT_JOINER_PAYMENT_MAIL', $ID, "ADMIN");
        if (intval($send) == intval(1)) {
            echo '~~~1~~~Mail Successfully Sent~~~' . $ID . "~~~";
        } else {
            echo '~~~0~~~ERROR~~~';
        }
    } else {
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

    if (intval($ID) > intval(0)) {
        $send = sendMailformate('event_joiner_request_approved', $ID, "ADMIN");
        if (intval($send) == intval(1)) {
            echo '~~~1~~~Sent~~~' . $ID . "~~~";
        } else {
            echo '~~~0~~~ERROR~~~';
        }
    } else {
        echo '~~~0~~~ERROR~~~';
    }

}

?>