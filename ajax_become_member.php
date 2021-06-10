<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);
include "library_insol/all_include.php";
include "global_functions.php";

$type = trim($_REQUEST['type']);
//exit;
switch ($type) {
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

    $permanent_address = "";
    $permanent_address_2 = "";
    $permanent_city = "";
    $permanent_state = "";
    $permanent_country = "";
    $permanent_pin = "";
    $residence_telephone = "";
    $fax = "";

    $title = trustme($_REQUEST["title"]); //new
    $first_name = trustme($_REQUEST["first_name"]);
    $gst_no = trustme($_REQUEST["gst_no"]);
    $middle_name = trustme($_REQUEST["middle_name"]);
    $last_name = trustme($_REQUEST["last_name"]);
    $suffix = trustme($_REQUEST["suffix"]);
    $firm_name = trustme($_REQUEST["firm_name"]); //new
    $address = trustme($_REQUEST["address"]);
    $correspondence_address_2 = trustme($_REQUEST["correspondence_address_2"]); // new
    $city = trustme($_REQUEST["city"]);
    $correspondence_state = trustme($_REQUEST["correspondence_state"]); //new
    $country = trustme($_REQUEST["country"]);
    $pin = trustme($_REQUEST["pin"]);
    $name = $title . " " . $first_name . " " . $middle_name . " " . $last_name;

    $permanent_address = trustme($_REQUEST["permanent_address"]);
    if ($permanent_address == "") {
        $permanent_address = $address;
    }

    $permanent_address_2 = trustme($_REQUEST["permanent_address_2"]); //new
    if ($permanent_address_2 == "") {
        $permanent_address_2 = $correspondence_address_2;
    }

    $permanent_city = trustme($_REQUEST["permanent_city"]);
    if ($permanent_city == "") {
        $permanent_city = $city;
    }

    $permanent_state = trustme($_REQUEST["permanent_state"]);
    if ($permanent_state == "") {
        $permanent_state = $correspondence_state;
    }

    $permanent_country = trustme($_REQUEST["permanent_country"]);
    if ($permanent_country == "") {
        $permanent_country = $country;
    }

    $permanent_pin = trustme($_REQUEST["permanent_pin"]);
    if ($permanent_pin == "") {
        $permanent_pin = $pin;
    }

    $telephone = trustme($_REQUEST["telephone"]);
    $residence_telephone = trustme($_REQUEST["residence_telephone"]); //new
    $email = trustme($_REQUEST["email"]);

    $mobile = trustme($_REQUEST["mobile"]);
    $fax = trustme($_REQUEST["fax"]);
    //$i_am = trustme($_REQUEST["i_am"]);

    $i_am = implode(', ', $_REQUEST['i_am']);

    $other_i_am = trustme($_REQUEST["other_i_am"]);

    $insolvency_professional = intval($_REQUEST["insolvency_professional"]);
    $insolvency_professional_agency = trustme($_REQUEST["insolvency_professional_agency"]);
    $insolvency_professional_number = trustme($_REQUEST["insolvency_professional_number"]);
    $registered_insolvency_professional = intval($_REQUEST["registered_insolvency_professional"]);
    $registered_insolvency_professional_number = trustme($_REQUEST["registered_insolvency_professional_number"]);
    $young_practitioner = intval($_REQUEST["young_practitioner"]);
    $young_practitioner_enrolment = trustme($_REQUEST["young_practitioner_enrolment"]);

    $sig_member = intval($_REQUEST["sig_member"]);
    $sig_company_id = intval($_REQUEST["sig_company_id"]);
    $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id", "$sig_company_id", '=', '', '', "");

    $interested = trustme($_REQUEST["interested"]);

    $terms = intval($_REQUEST["terms"]);
    $committed = intval($_REQUEST["committed"]);

    $password = rand(100000, 999999);

    $status = "ACTIVE";
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $TIME = date("Y-m-d H:i:s");
    $BY = "SELF";

    $CHK = checkDuplicate(BECOME_MEMBER_TBL, "status~~~email", "ACTIVE~~~" . $email, "=~~~=", "");

    if (intval($CHK) == intval(0)) {

        $MAX_ID = getMaxId(BECOME_MEMBER_TBL, "member_id");

        $SQL = "";
        $SQL .= " INSERT INTO " . BECOME_MEMBER_TBL . " SET ";
        $SQL .= " member_id = :member_id, ";
        $SQL .= " title = :title, ";
        $SQL .= " gst_no = :gst_no,";
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
        $SQL .= " terms = :terms,";
        $SQL .= " committed = :committed,";
        $SQL .= " status = :status, ";
        $SQL .= " add_ip = :add_ip, ";
        $SQL .= " add_by = :add_by, ";
        $SQL .= " add_time = :add_time ";
        //echo $SQL; exit();
        $stmt = $dCON->prepare($SQL);
        $stmt->bindParam(":member_id", $MAX_ID);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":gst_no", $gst_no);
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
        $stmt->bindParam(":terms", $terms);
        $stmt->bindParam(":committed", $committed);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":add_ip", $IP);
        $stmt->bindParam(":add_by", $BY);
        $stmt->bindParam(":add_time", $TIME);
        $dbRES = $stmt->execute();
        $stmt->closeCursor();

        if ($dbRES == 1) {
            $RTNID = $MAX_ID;

            ////////////////user Mail
            sendMailformate("member_register", $RTNID, "");

            //////////////Admin Mail

            // $MAIL_FORMAT = getMailFormat('REGISTRATION',$RTNID,"");

            $SUBJECT = $_SESSION['COMPANY_NAME'] . " : New Registration";
            // $TO_EMAIL = $_SESSION['INFO_EMAIL'];

            // MailObject("$TO_EMAIL",$email,"", "", $SUBJECT, $MAIL_FORMAT, "");
            $MAIL_FORMAT = '<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width: 100.0%">
    <tbody>
        <tr>
            <td style="padding: 0cm 0cm 0cm 0cm">
                <div align="center">
                    <table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; border: solid #EFEFEF 6.0pt">
                        <tbody>
                            <tr>
                                <td style="border: none; border-bottom: solid #ED1C24 3.0pt; padding: 15.0pt 15.0pt 15.0pt 15.0pt">
                                    <p class="MsoNormal"><span style="font-family: Helvetica; border: solid windowtext 1.0pt; padding: 0cm"><img border="0" width="32" height="32" id="_x0000_i1025" alt="mage removed by sender."></span><span style="font-family: Helvetica"></span></p>
                                </td>
                            </tr>
                            <tr>
                                <td style="border: none; background: #2E3192; padding: 9.0pt 15.0pt 9.0pt 15.0pt">
                                    <p class="MsoNormal" align="center" style="text-align: center"><b><span style="font-size: 15.0pt; font-family: Helvetica; color: white">Following user submitted the membership form</span></b>
                                    </p>
                                </td>
                            </tr>
                            <tr style="height: 187.5pt">
                                <td valign="top" style="border: none; padding: 15.0pt 15.0pt 15.0pt 15.0pt; height: 187.5pt">
                                    <h1 style="margin-bottom: 3.75pt"><span style="text-transform:uppercase;font-size: 12.0pt; font-family: Helvetica; color: #2E3192">' . $name . '</span>
                                    </h1>
                                    <p class="MsoNormal" style="margin-bottom: 12.0pt"><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333">Correspondence Address : ' . $address . ' , ' . $correspondence_address_2 . ' , ' . $city . ' , ' . $correspondence_state . ' , ' . $country . ' - ' . $pin . '<br>Permanent Address : ' . $permanent_address . ' , ' . $permanent_address_2 . ' , ' . $permanent_city . ' , ' . $permanent_state . ' , ' . $permanent_country . ' - ' . $permanent_pin . '<br><br>T. 91 ' . $telephone . ' M. ' . $mobile . ' | E. ' . $email . '</span>
                                    </p>
                                    <div style="border: none; border-top: solid #CCCCCC 1.0pt; padding: 11.0pt 0cm 0cm 0cm">
                                        <p class="MsoNormal"><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333">I am </span><strong><span style="font-size: 10.5pt; font-family: Helvetica; color: #ED1C24">' . $i_am . '</span></strong><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333"></span>
                                        </p>
                                    </div>
                                    <div style="border: none; border-top: solid #CCCCCC 1.0pt; padding: 11.0pt 0cm 0cm 0cm">
                                        <p class="MsoNormal"><strong><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333">I am interested in becoming a member of INSOL India because</span></strong><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333"> <br>' . $interested . '</span>
                                        </p>
                                    </div>
                                    <p class="MsoNormal" align="center" style="text-align: center"><span style="font-size: 10.5pt; font-family: Helvetica; color: #333333"><a href="http://insolindia.com/cms/login.php?mid=1337" target="_blank" rel="noreferrer"><span style="border: solid windowtext 1.0pt; padding: 0cm; text-decoration: none"><img border="0" width="32" height="32" id="_x0000_i1026" alt="mage removed by sender."></span></a>&nbsp;&nbsp;<a href="http://insolindia.com/cms/login.php?mid=1337" target="_blank" rel="noreferrer"><span style="border: solid windowtext 1.0pt; padding: 0cm; text-decoration: none"><img border="0" width="32" height="32" id="_x0000_i1027" alt="mage removed by sender."></span></a></span>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td bgcolor="#f5f5f5" style="color:#333;text-align:center;font-size:11px;border-top:8px solid #000">5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744 Email: <a href="mailto:contact@insolindia.com" style="color:#333;text-decoration:underline" target="_blank">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color:#333;text-decoration:underline" target="_blank" data-saferedirecturl="https://www.google.com/url?q=http://www.insolindia.com&amp;source=gmail&amp;ust=1564032114663000&amp;usg=AFQjCNED85B0QNwY8qTOZSR2KrSd81vCYg">www.insolindia.com</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </tbody>
</table>';

            $mail = new phpmailer;

            $mail->IsSMTP();
// $mail->Host     = "103.21.58.112";
// $mail->Username = "noreply@insolindia.com";
// $mail->Password = "f2B7~w)C[5d4";
// $mail->Port = 25;

            $mail->SMTPAuth = true;
            $mail->SMTPDebug = true;

            //Testing using sabsoftzone smtp
            $mail->Host = "192.185.183.86";
            $mail->Username = "info@sabsoftzone.in";
            $mail->Password = "q[BhD01vcX7&";

            // $mail->From = "contact@insolindia.com";
            $mail->From = "info@sabsoftzone.in";

            $mail->FromName = "insolindia";
            $mail->ContentType = "text/html";

            // $to = "contact@insolindia.com";
            $to = "akshay2796@gmail.com";
            $mail->Subject = $SUBJECT;

            $mail->AddAddress($to);
            $mail->Body = "$MAIL_FORMAT";
            // $mail->AddCC("contact@insolindia.com");

            $mailSent = $mail->send();
            $mail->ClearAddresses();

            if ($mailSent):

                $previousPage = $_SERVER["HTTP_REFERER"];
                header('Location: ' . $previousPage);
                echo "Mail Successfully Sent";
            else:
                echo "Sorry cannot process your request.";
            endif;
            ob_flush();
        }
    } else {
        $dbRES = 2;
    }

    switch ($dbRES) {

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

    $stmt = $dCON->prepare("SELECT * FROM " . BECOME_MEMBER_TBL . " WHERE status = 'ACTIVE' and payment_status = 'SUCCESSFUL' and email = ? and password = ?");
    $stmt->bindParam(1, $email);
    $stmt->bindParam(2, $password);
    $stmt->execute();
    $row = $stmt->fetchAll();
    $stmt->closeCursor();
    // echo $stmt;

    //echo "==".trim($row[0]['email'])."--".$email;
    //echo "==".trim($row[0]['password'])."--".$password;

    if (trim($row[0]['email']) == $email && trim($row[0]['password']) == $password && trim($row[0]['status']) == "ACTIVE") {
        $_SESSION['UID_INSOL'] = intval($row[0]['member_id']);
        $_SESSION['FNAME'] = stripslashes($row[0]['first_name']);
        $_SESSION['MNAME'] = stripslashes($row[0]['middle_name']);
        $_SESSION['LNAME'] = stripslashes($row[0]['last_name']);

        $_SESSION['FULLNAME'] = $_SESSION['FNAME'];
        if ($_SESSION['MNAME'] != '') {
            $_SESSION['FULLNAME'] = $_SESSION['FULLNAME'] . " " . $_SESSION['MNAME'];
        }
        $_SESSION['FULLNAME'] = $_SESSION['FULLNAME'] . " " . $_SESSION['LNAME'];

        $_SESSION['REG_NUMBER'] = stripslashes($row[0]['reg_number_text']);

        $_SESSION['UEMAIL'] = stripslashes($row[0]['email']);
        $_SESSION['UPASS'] = stripslashes($row[0]['password']);
        $_SESSION['UCOUNTRY'] = stripslashes($row[0]['country']);
        $_SESSION['UCITY'] = stripslashes($row[0]['city']);

        $_SESSION['MEMBERSHIP_STATUS'] = stripslashes($row[0]['register_status']);

        $_SESSION['START_DATE'] = stripslashes($row[0]['membership_start_date']);
        $_SESSION['END_DATE'] = stripslashes($row[0]['membership_expired_date']);

        $sql = "";
        $sql .= " UPDATE " . BECOME_MEMBER_TBL . " set login_ip = :login_ip, login_date = :login_date ";
        $sql .= " WHERE member_id = :member_id";

        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":login_ip", $_SERVER['REMOTE_ADDR']);
        $stmt->bindParam(":login_date", $update_time);
        $stmt->bindParam(":member_id", $_SESSION['UID_INSOL']);
        $rs = $stmt->execute();
        $stmt->closeCursor();

        echo "~~~1~~~Please wait........";
    } else if (trim($row[0]['email']) == $email && trim($row[0]['password']) == $password && trim($row[0]['status']) == "INACTIVE") {
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
    } else {
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

    $stmt = $dCON->prepare(" SELECT * FROM " . BECOME_MEMBER_TBL . " WHERE email = ? AND status <> 'DELETE'");
    $stmt->bindParam(1, $fpass_email);
    $stmt->execute();
    $row = $stmt->fetchAll();
    $stmt->closeCursor();

    if (intval(count($row)) > intval(0)) {
        $member_id = intval($row[0]['member_id']);

        $RES = sendMailformate('FORGOT_PASSWORD', $member_id, $via = "");

        if (intval($RES) == intval(1)) {
            echo "~~~1~~~Please check your mail for password";
        } else {
            echo "~~~0~~~Sorry! Please try again.";
        }
        /////////////////send mail to user END!!!!!!!!!!!!!!
    } else {
        echo "~~~0~~~Email Does Not Exists";
    }

}