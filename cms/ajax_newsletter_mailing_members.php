<?php
session_start();
error_reporting(E_ALL);
include "ajax_include.php";

define("PAGE_MAIN", "newsletter_mailing_members.php");
define("PAGE_AJAX", "ajax_newsletter_mailing_members.php");
define("PAGE_PREVIEW", "general_upload_preview.php");

$type = trustme($_REQUEST['type']);

switch ($type) {
    case "saveData":
        saveData();
        break;

    case "listData":
        listData();
        break;

    case "setStatus":
        setStatus();
        break;

    case "deleteSelected":
        deleteSelected();
        break;
    case "deleteData":
        deleteData();
        break;
    case "modifyData":
        modifyData();
        break;

    case "sendNewsletter":
        sendNewsletter();
        break;

}

function saveData()
{
    global $dCON;

    $test_mail_name = trustme($_REQUEST['test_mail_name']);
    $test_email = trustme($_REQUEST['test_email']);

    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");

    if ($con == "add") {
        $CHK = checkDuplicate(TEST_EMAIL_TBL, "test_mail_name", "$test_mail_name", "=", "");
        //echo $section_name;

        if (intval($CHK) == intval(0)) {

            $MAX_ID = getMaxId(TEST_EMAIL_TBL, "mail_id");
            // $MAX_POS = getMaxPosition(TEST_EMAIL_TBL,"position","","","=");
            //$MY_URLKEY = getURLKEY(TEST_EMAIL_TBL,$url_key,$test_mail_name,"","","",$MAX_ID,"");

            $sql = "";
            $sql .= " INSERT INTO " . TEST_EMAIL_TBL . " SET ";
            $sql .= " mail_id = :mail_id, ";
            $sql .= " test_mail_name = :test_mail_name, ";
            $sql .= " test_email = :test_email, ";
            $sql .= " add_ip = :add_ip, ";
            $sql .= " add_time = :add_time, ";
            $sql .= " add_by = :add_by ";
            //echo $sql; exit();
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":mail_id", $MAX_ID);
            $stmt->bindParam(":test_mail_name", $test_mail_name);
            $stmt->bindParam(":test_email", $test_email);
            $stmt->bindParam(":add_ip", $ip);
            $stmt->bindParam(":add_time", $TIME);
            $stmt->bindParam(":add_by", $_SESSION['USERNAME']);

            $rs = $stmt->execute();
            $stmt->closeCursor();

        } else {
            $rs = 2;
        }
    } else if ($con == "modify") {

        $CHK = checkDuplicate(TEST_EMAIL_TBL, "test_mail_name~~~mail_id", "$test_mail_name~~~$id", "=~~~<>", "");

        if (intval($CHK) == intval(0)) {
            $MY_URLKEY = getURLKEY(TEST_EMAIL_TBL, $url_key, $test_mail_name, "mail_id", $id, "<>", $id, "");

            $sql = "";
            $sql .= " UPDATE " . TEST_EMAIL_TBL . " SET ";
            $sql .= " test_mail_name = :test_mail_name, ";

            $sql .= " test_email = :test_email, ";
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, ";
            $sql .= " update_by = :update_by ";

            $sql .= " WHERE mail_id = :mail_id ";

            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":test_mail_name", $test_mail_name);
            $stmt->bindParam(":test_email", $test_email);
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME);
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);

            $stmt->bindParam(":mail_id", $id);
            $rs = $stmt->execute();
            $stmt->closeCursor();

        } else {
            $rs = 2;
        }
    }

    switch ($rs) {
        case "1":
            echo "~~~1~~~Successfully saved~~~" . $last_insert_id;
            break;
        case "2":
            echo "~~~2~~~Already exists";
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

    $test_mail_name = trustme($_REQUEST['search_test_mail_name']);
    $search_fdate = trustme($_REQUEST['search_fdate']);
    $search_tdate = trustme($_REQUEST['search_tdate']);

    $search = "";

    if ($test_mail_name != "") {
        $search .= " and test_mail_name like :test_mail_name ";
    }

    if (trim($search_fdate) != "" && trim($search_tdate) != "") {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];

        $search_tdate_arr = explode("-", $search_tdate);
        $search_tdate = $search_tdate_arr[2] . "-" . $search_tdate_arr[1] . "-" . $search_tdate_arr[0];

        $search .= " AND DATE(upload_date) BETWEEN :from_date AND :to_date ";
    } else if (trim($search_fdate) != "") {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];

        $search .= " AND DATE(upload_date) = :from_date ";
    }

    $SQL = "";
    $SQL .= " SELECT A.* ";
    $SQL .= " FROM " . TEST_EMAIL_TBL . " as A WHERE  A.status <> 'DELETE' $search ORDER BY add_time DESC ";

    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . TEST_EMAIL_TBL . " WHERE status <> 'DELETE' $search ";

    $stmt1 = $dCON->prepare($SQL_PG);
    //echo "$SQL===$search_fdate========$search_tdate";

    if ($test_mail_name != "") {
        $stmt1->bindParam(":test_mail_name", $ntitle);
        $ntitle = "%{$test_mail_name}%";
    }
    if (trim($search_fdate) != "" && trim($search_tdate) != "") {
        $stmt1->bindParam(":from_date", $search_fdate);
        $stmt1->bindParam(":to_date", $search_tdate);
    } else if (trim($search_fdate) != "") {
        $stmt1->bindParam(":from_date", $search_fdate);
    }

    $stmt1->execute();
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 100;
    $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);

    if ($test_mail_name != "") {
        $stmt2->bindParam(":test_mail_name", $ntitle);
        $ntitle = "%{$test_mail_name}%";
    }

    if (trim($search_fdate) != "" && trim($search_tdate) != "") {
        $stmt2->bindParam(":from_date", $search_fdate);
        $stmt2->bindParam(":to_date", $search_tdate);
    } else if (trim($search_fdate) != "") {
        $stmt2->bindParam(":from_date", $search_fdate);
    }

    $stmt2->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt2->bindParam(":RPP", $RPP, PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();
    //echo '<pre>'; print_r($row);
    //print_r($stmt2->errorInfo());

    $position_qry_string = "";
    $position_qry_string .= "con=" . TEST_EMAIL_TBL;
    $position_qry_string .= "&cname1=test_mail_name&cname2=mail_id";

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
                                    <?php if (intval($dA) > intval(0)) {?><td align="right" style="padding-right:10px;">
                                        <b>Total Record<?php if (intval($dA) > intval(1)) {echo "s";}?>:
                                            <?php echo intval($dA); ?></b></td><?php }?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <?php
if (intval($dA) > intval(0)) {
        ?>

        <script language="javascript" type="text/javascript">
        $(document).ready(function() {
            //CHECK ALL
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

            $("#test-list").sortable({
                handle: '.handle',
                update: function() {
                    var order = $('#test-list').sortable('serialize');
                    var qryString = $("#qryString").val();
                    //alert(order)
                    //alert(qryString)
                    $.ajax({
                        type: "POST",
                        url: "ajax_position.php",
                        data: "type=saveListPosition&" + qryString + "&" + order,
                        beforeSend: function() {

                        },
                        success: function(msg) {
                            //alert(msg)
                            $("#smessage").html(msg);
                        }
                    });

                }
            });


        });
        </script>

        <tr>
            <td class="list_table" valign="top">
                <input type="hidden" name="qryString" id="qryString" value="<?php echo $position_qry_string; ?>&stop=1"
                    style="width: 500px;" />
                <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                    <tr>
                        <th width="3%" align="center"><?php if ((intval($dA) > intval(0))) {?><input type="checkbox"
                                name="chk_all" value="1" id="chk_all" /><?php }?></th>
                        <!--th width="15%" align="left">Date</th-->
                        <th width="40%" align="left">Name</th>
                        <!--th width="8%" align="left">Issue</th-->
                        <th width="42%" align="left">Email</th>
                        <!--th width="15%" align="left">Sent date</th-->
                        <th style='text-align: center;' width="15%">Action</th>
                    </tr>
                    <?php
$CK_COUNTER = 0;
        $FOR_BG_COLOR = 0;
        $disp = 0;
        foreach ($row as $rs) {
            $mail_id = "";
            $test_mail_name = "";
            $status = "";

            $mail_id = intval($rs['mail_id']);
            $test_mail_name = stripslashes($rs['test_mail_name']);
            $upload_date = stripslashes($rs['upload_date']);

            if ($upload_date != "0000-00-00" && $upload_date != "") {
                $upload_date = date("d M, Y", strtotime($upload_date));
            }

            $newsletter_send_date = stripslashes($rs['newsletter_send_date']);
            if ($newsletter_send_date != '0000-00-00 00:00:00' && $newsletter_send_date != '') {
                $newsletter_send_date = date('d M, Y', strtotime($newsletter_send_date));
            } else {
                $newsletter_send_date = "-";
            }

            $test_email = stripslashes($rs['test_email']);
            $status = stripslashes($rs['status']);
            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";

            ?>
                    <tr class="expiredCoupons trhover">
                        <td align="center" width="3%">
                            <?php
if (intval($CHK) == intval(0)) {
                $CK_COUNTER++;
                ?>
                            <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $mail_id; ?>" />
                            <?php
} else {
                echo '<input type="checkbox" disabled=""/>';
            }
            ?>

                        </td>
                        <!--td>
                                	<?php //echo $upload_date; ?>
                                </td-->
                        <td>
                            <?php echo $test_mail_name; ?>
                        </td>
                        <!--td>
                                	<?php //echo $newsletter_issue; ?>
                                </td-->

                        <td>
                            <?php echo $test_email; ?>
                        </td>

                        <!--td>
                                	<?php //echo $newsletter_send_date; ?>
                                </td-->




                        <td align="center">
                            <div id="INPROCESS_DELETE_1_<?php echo $mail_id; ?>" style="display: none;"></div>
                            <div id="INPROCESS_DELETE_2_<?php echo $mail_id; ?>">

                                <!--a href="<?php echo PAGE_PREVIEW; ?>?pid=<?php echo $mail_id; ?>" class="img_btn view_detail" title="View Details"><img border="0" src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>view.png" class="cmsIcon" alt="View Details" ></a!--></span>

                                <a href="<?php echo PAGE_MAIN; ?>?con=modify&id=<?php echo $mail_id; ?>"
                                    class="img_btn viewDetail" title="Modify">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0"
                                        title="Modify" alt="Modify" />
                                </a>

                                <?php
if (intval($CHK) == intval(0)) {
                ?>
                                <a href="javascript:void(0);" value="<?php echo $mail_id; ?>"
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
                <?php showICONS("~~~MODIFY~~~DELETE");?>
            </td>

        </tr>
        <?php
if ($paging[0] != "") {
            ?>
        <tr>
            <td height="30" colspan="<?php echo $COLSPAN; ?>" align="right">
                <div id="pagingWrap">
                    <?php echo $paging[0]; ?>
                </div>
            </td>
        </tr>
        <?php
}
        ?>
    </table>

    <?php
} else {
        ?>
    <tr>
        <td align="center" height="100" colspan="<?php echo $COLSPAN; ?>"><strong>Not Found</strong></td>
    </tr>

    <?php
}
    ?>
    </table>
</form>
<?php
}

function deleteSelected()
{
    global $dCON;

    $arr = implode(",", $_REQUEST['chk']);
    $exp = explode(",", $arr);
    $i = 0;

    foreach ($exp as $chk) {
        $TIME = date("Y-m-d H:i:s");

        ///$stmt = $dCON->prepare("DELETE FROM " . TEST_EMAIL_TBL . "   WHERE section_id = ?");
        $stmt = $dCON->prepare("Update " . TEST_EMAIL_TBL . "  set status='DELETE' WHERE mail_id = ?");
        $stmt->bindParam(1, $chk);
        $rs = $stmt->execute();
        $stmt->closeCursor();
        if (intval($rs) == intval(1)) {
            $i++;
        }
    }

    $msg = "(" . $i . ") Successfully deleted";
    //$msg = "Done";

    echo $msg;

}

function deleteData()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);

    $TIME = date("Y-m-d H:i:s");

    //Delete Master
    //$stmt = $dCON->prepare("DELETE FROM " . SECTION_TBL . "   WHERE section_id = ?");
    $stmt = $dCON->prepare("Update " . TEST_EMAIL_TBL . "  set status='DELETE'  WHERE mail_id = ?");
    $stmt->bindParam(1, $ID);
    $rs = $stmt->execute();
    $stmt->closeCursor();
    if (intval($rs) == intval(1)) {
        echo '~~~1~~~Deleted~~~';
    } else {
        echo '~~~0~~~Error~~~';
    }
}

function setStatus()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");

    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);

    $STR = "";
    $STR .= " UPDATE  " . TEST_EMAIL_TBL . "  SET ";
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE mail_id = :mail_id ";
    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":status", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":mail_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();

    if (intval($RES) == intval(1)) {

        echo '~~~1~~~DONE~~~' . $ID . "~~~";
    } else {
        echo '~~~0~~~ERROR~~~';
    }

}

function sendNewsletter()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $send_date = date("Y-m-d");
    $send_to_governance_json = "";

    $ID = intval($_REQUEST['id']);
    $general_newsletter_subject = trustme($_REQUEST['general_newsletter_subject']);
    $test_email = trustme($_REQUEST['test_email']);

    $exp_test_email = explode(",", $test_email);

    $send_to_insol_member = intval($_REQUEST['send_to_insol_member']);

    $governance_id_array = $_REQUEST['send_to_governance']; // gives governance id
    $send_to_governance_json = json_encode($governance_id_array);

    //exit();

    $STR = "";
    $STR .= " UPDATE  " . TEST_EMAIL_TBL . "  SET ";
    $STR .= " general_newsletter_subject = :general_newsletter_subject, ";
    //if($test_email !='')
    //{
    $STR .= " test_email = :test_email, ";
    //}
    //if(intval($send_to_insol_member) == intval(1))
    //{
    $STR .= " send_to_insol_member = :send_to_insol_member, ";
    //}
    $STR .= " send_to_governance = :send_to_governance_json, ";
    $STR .= " newsletter_send_date = :newsletter_send_date, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE mail_id = :mail_id ";

    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":general_newsletter_subject", $general_newsletter_subject);
    //if($test_email !='')
    //{
    $sDEF->bindParam(":test_email", $test_email);
    //}
    //if(intval($send_to_insol_member) == intval(1))
    //{
    $sDEF->bindParam(":send_to_insol_member", $send_to_insol_member);
    //}
    $sDEF->bindParam(":send_to_governance_json", $send_to_governance_json);
    $sDEF->bindParam(":newsletter_send_date", $send_date);

    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":mail_id", $ID);
    $rowUP = $sDEF->execute();
    $sDEF->closeCursor();

    // mail to governance checked ==============

    if (intval(count($governance_id_array)) > intval(0)) {
        //to count id and COUNT
        $gov_info = array(
            "governance_id" => array(),
            "count" => array(),
        );

        foreach ($governance_id_array as $governance_id) {
            array_push($gov_info['governance_id'], $governance_id);

            $SQL_E = "";
            $SQL_E .= " SELECT governance_email, governance_name ";
            $SQL_E .= " FROM " . GOVERNANCE_TBL . " WHERE status = 'ACTIVE' AND governance_email !='' ";
            $SQL_E .= " AND type_id = :type_id ";

            $eGET = $dCON->prepare($SQL_E);
            $eGET->bindParam(":type_id", $governance_id);
            $eGET->execute();
            $esGET = $eGET->fetchAll();

            $GOV_COUNT = intval(0);
            foreach ($esGET as $emailVAL) {

                $GOV_COUNT++;
                $EMAIL_ID = stripslashes($emailVAL['governance_email']);
                $person_name = stripslashes($emailVAL['governance_name']);

                $MAIL_FORMAT = generaluploadFormat($ID, $person_name);

                //$MAIL_FORMAT = str_ireplace("%mid%", $member_id . " " . $lastname, $MAIL_FORMAT);
                //$MAIL_FORMAT = str_ireplace("%memail%", $test_email, $MAIL_FORMAT);
                $SUBJECT = $general_newsletter_subject;
                $TO_EMAIL = $EMAIL_ID;
                $FROM_EMAIL = $_SESSION['INFO_EMAIL'];

                $RES_GOV = MailObject($TO_EMAIL, $FROM_EMAIL, "", "", $SUBJECT, $MAIL_FORMAT, "");

            }
            array_push($gov_info['count'], $GOV_COUNT);

        }
        $_SESSION['GOVT_INFO_ARRAY'] = array_combine($gov_info['governance_id'], $gov_info['count']);

    }

    // mail to governance checked ends ==============
    // mail to testmail given
    foreach ($exp_test_email as $testEmail) {
        if ($testEmail != '') {
            $MAIL_FORMAT = generaluploadFormat($ID, "");
            //$MAIL_FORMAT = str_ireplace("%mid%", $member_id . " " . $lastname, $MAIL_FORMAT);
            //$MAIL_FORMAT = str_ireplace("%memail%", $test_email, $MAIL_FORMAT);
            $SUBJECT = $general_newsletter_subject;
            $TO_EMAIL = $testEmail;
            $FROM_EMAIL = $_SESSION['INFO_EMAIL'];

            $RES_TEST = MailObject($TO_EMAIL, $FROM_EMAIL, "", "", $SUBJECT, $MAIL_FORMAT, "");

        }
    }

    // to imnsol members starts ============================================

    if (intval($send_to_insol_member) == intval(1)) {
        $SQL2 = "";
        $SQL2 .= " SELECT * ";
        $SQL2 .= " FROM " . BECOME_MEMBER_TBL . " as u WHERE status = 'ACTIVE' and subscribe ='YES' and payment_status = 'SUCCESSFUL' ";
        //$SQL2 .= " and newsletter_id !='".$ID."' and send_date !='".$send_date."'";
        $SQL2 .= " order by member_id ";

        $sGET = $dCON->prepare($SQL2);
        $sGET->execute();
        $rsGET = $sGET->fetchAll();
        $sGET->closeCursor();

        if (count($rsGET) > intval(0)) {
            $RES_MEMBER_CT = 0;
            foreach ($rsGET as $rs) {
                $middle_name = "";
                $full_name = "";
                $member_id = stripslashes($rs["member_id"]);
                $email = stripslashes($rs["email"]);
                $first_name = ucfirst(strtolower(stripslashes($rs["first_name"])));
                $middle_name = ucfirst(strtolower(stripslashes($rs["middle_name"])));
                $last_name = ucfirst(strtolower(stripslashes($rs["last_name"])));

                $full_name = "";
                $full_name .= $title . " " . $first_name;
                if ($middle_name != "") {
                    $full_name .= " " . $middle_name;
                }

                $full_name .= " " . $last_name;

                $MAIL_FORMAT = generaluploadFormat($ID, $full_name);
                $MAIL_FORMAT = str_ireplace("%mid%", $member_id, $MAIL_FORMAT);
                $MAIL_FORMAT = str_ireplace("%memail%", $email, $MAIL_FORMAT);

                $SUBJECT = $newsletter_subject;
                $TO_EMAIL = $email;
                $FROM_EMAIL = $_SESSION['INFO_EMAIL'];

                $RES_M = MailObject($TO_EMAIL, $FROM_EMAIL, "", "", $SUBJECT, $MAIL_FORMAT, "");

                if (intval($RES_M) == intval(1)) {
                    $RES_MEMBER_CT++;

                    $STR = "";
                    $STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET ";
                    $STR .= " newsletter_id = :newsletter_id, ";
                    $STR .= " send_date = :send_date, ";
                    $STR .= " update_time = :update_time ";
                    $STR .= " WHERE member_id = :member_id ";

                    $sUSER = $dCON->prepare($STR);
                    $sUSER->bindParam(":newsletter_id", $ID);
                    $sUSER->bindParam(":send_date", $send_date);
                    $sUSER->bindParam(":update_time", $TIME);
                    $sUSER->bindParam(":member_id", $member_id);
                    $rsUSER = $sUSER->execute();
                    $sUSER->closeCursor();

                }
            }

            if (intval($RES_MEMBER_CT) > 0) {
                $STR = "";
                $STR .= " UPDATE  " . TEST_EMAIL_TBL . "  SET ";
                $STR .= " newsletter_send_date = :newsletter_send_date, ";
                $STR .= " update_time = :update_time ";
                $STR .= " WHERE mail_id = :mail_id ";

                $sUSER = $dCON->prepare($STR);
                $sUSER->bindParam(":newsletter_send_date", $send_date);
                $sUSER->bindParam(":update_time", $TIME);
                $sUSER->bindParam(":mail_id", $ID);
                $rsUSER = $sUSER->execute();
                $sUSER->closeCursor();
            }

        }

    }

    //to insol member ends  ===============================================
    if (($test_email != '') || (intval($send_to_insol_member) == intval(1)) || (intval(count($governance_id_array)) > intval(0))) {
        echo "~~~1~~~Mail successfully sent~~~";
    } else {
        echo "~~~0~~~Error occured, try again";
    }

}
?>