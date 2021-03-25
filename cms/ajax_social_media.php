<?php
session_start();
error_reporting(0);
include "ajax_include.php";

define("PAGE_MAIN", "social_media.php");
define("PAGE_AJAX", "ajax_social_media.php");

$type = trustme($_REQUEST['type']);
switch ($type) {

    case "saveData":
        saveData();
        break;
    case "listData":
        listData();
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
    case "setStatus":
        setStatus();
        break;
}

function saveData()
{
    global $dCON;

    $socialmedia_name = trustme($_REQUEST['socialmedia_name']);
    $socialmedia_link = trustme($_REQUEST['socialmedia_link']);
    //  $type_description = trustyou($_REQUEST['dcontent']);
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $TIME = date("Y-m-d H:i:s");
    $image_name = '';

    //$url_key = filterString($socialmedia_name);

    if ($con == "add") {
        $CHK = checkDuplicate(SOCIALMEDIA_TBL, "socialmedia_name", "$socialmedia_name", "=", "");
        //echo $socialmedia_name;

        if (intval($CHK) == intval(0)) {

            $MAX_ID = getMaxId(SOCIALMEDIA_TBL, "socialmedia_id");
            $MAX_POS = getMaxPosition(SOCIALMEDIA_TBL, "position", "", "", "=");

            // $MY_URLKEY = getURLKEY(SOCIALMEDIA_TBL,$url_key,$url_key,"","","",$MAX_ID,"");

            $sql = "";
            $sql .= " INSERT INTO " . SOCIALMEDIA_TBL . " SET ";
            $sql .= " socialmedia_id = :socialmedia_id, ";
            $sql .= " socialmedia_name = :socialmedia_name, ";
            $sql .= " socialmedia_link = :socialmedia_link, ";
            //$sql .= " type_description = :type_description, ";
            $sql .= " position = :position, ";
            $sql .= " add_ip = :add_ip, ";
            $sql .= " add_time = :add_time, ";
            $sql .= " add_by = :add_by ";
            $sql .= "  image_name = :image_name ";

            // $sql .= " url_key = :url_key, ";

            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":socialmedia_id", $MAX_ID);
            $stmt->bindParam(":socialmedia_name", $socialmedia_name);
            $stmt->bindParam(":socialmedia_link", $socialmedia_link);
            // $stmt->bindParam(":type_description", $type_description);
            $stmt->bindParam(":position", $MAX_POS);
            $stmt->bindParam(":add_ip", $ip);
            $stmt->bindParam(":add_time", $TIME);
            $stmt->bindParam(":add_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":image_name", $image_name);
            // $stmt->bindParam(":url_key", $MY_URLKEY);

            $rs = $stmt->execute();
            $stmt->closeCursor();
            if (intval($rs) == intval(1)) {

                $last_insert_id = $MAX_ID;

            }

        } else {
            $rs = 2;
        }
    } else if ($con == "modify") {
        $CHK = checkDuplicate(SOCIALMEDIA_TBL, "socialmedia_name~~~socialmedia_id", $socialmedia_name . "~~~" . $id, "=~~~<>", "");

        if (intval($CHK) == intval(0)) {
            // $MY_URLKEY = getURLKEY(SOCIALMEDIA_TBL,$url_key,$url_key,"socialmedia_id",$id,"<>",$id,"");

            $sql = "";
            $sql .= " UPDATE " . SOCIALMEDIA_TBL . " SET ";
            $sql .= " socialmedia_name = :socialmedia_name, ";
            $sql .= " socialmedia_link = :socialmedia_link, ";
            //$sql .= " type_description = :type_description, ";
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, ";
            $sql .= " update_by = :update_by ";

            $sql .= " WHERE socialmedia_id = :socialmedia_id ";

            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":socialmedia_id", $MAX_ID);
            $stmt->bindParam(":socialmedia_name", $socialmedia_name);
            $stmt->bindParam(":socialmedia_link", $socialmedia_link);
            //$stmt->bindParam(":type_description", $type_description);
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME);
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);

            $stmt->bindParam(":socialmedia_id", $id);
            $rs = $stmt->execute();
            $stmt->closeCursor();
            if (intval($rs) == intval(1)) {

                $last_insert_id = $id;

            }

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

    //$search_location = trustme($_REQUEST['search_location']);

    $SQL = "";
    $SQL .= " SELECT * FROM " . SOCIALMEDIA_TBL . " as B ";
    $SQL .= " WHERE B.status <> 'DELETE' ";
    $SQL .= " ORDER BY position, socialmedia_id ";
    //echo $SQL;

    $SQL_PG = "";
    $SQL_PG .= " SELECT COUNT(*) AS CT  FROM ( ";
    $SQL_PG .= $SQL;
    $SQL_PG .= " ) as aa ";

    $stmt1 = $dCON->prepare($SQL_PG);
    //$stmt1->bindParam(":search_location", $loc_name);
    $stmt1->execute();

    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 50;

    $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);
    //$stmt2->bindParam(":search_location", $loc_name);

    $stmt2->bindParam(":offset", $offset, PDO::PARAM_INT);
    $stmt2->bindParam(":RPP", $RPP, PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();

    $position_qry_string = "";
    $position_qry_string .= "con=" . SOCIALMEDIA_TBL;
    $position_qry_string .= "&cname1=socialmedia_name&cname2=socialmedia_id";

    ?>

<div class="boxHeading">Existing</div>
<div class="clear"></div>

<?php
if (intval($dA) > intval(0)) {
        global $PERMISSION;
        //echo $_SESSION['PERMISSION'];

        ?>
<form name="frmDel" id="frmDel" method="post" action="">
    <script language="javascript" type="text/javascript">
    $(document).ready(function() {

        //CHECK ALL
        $("#chk_all").click(function() {
            $('.cb-element').attr('checked', $(this).is(':checked') ? true : false);
            //alert ($("#chk_all").prop('checked');
            var nock = $(".cb-element:checked").size();

            if ($("#chk_all").prop('checked') == true) {
                $("#chk_all2").prop('checked', true)
            } else {
                $("#chk_all2").prop('checked', false)
            }
            if (parseInt(nock) == parseInt(0)) {
                $('.smallListBox').removeClass('selected2Del');
                $('.deleteSelectedBtn').addClass('greyBtn');
                $(".delete_all").attr("disabled", true);

            } else {
                $('.smallListBox').addClass('selected2Del');
                $('.deleteSelectedBtn').removeClass('greyBtn');
                $(".delete_all").attr("disabled", false);
            }



        });


        $("#chk_all2").click(function() {
            $('.cb-element').attr('checked', $(this).is(':checked') ? true : false);

            //alert ($("#chk_all").prop('checked');

            if ($("#chk_all2").prop('checked') == true) {
                $("#chk_all").prop('checked', true)
            } else {
                $("#chk_all").prop('checked', false)
            }


            var nock = $(".cb-element:checked").size();
            if (parseInt(nock) == parseInt(0)) {
                $('.smallListBox').removeClass('selected2Del');
                $('.deleteSelectedBtn').addClass('greyBtn');
                $(".delete_all").attr("disabled", true);

            } else {
                $('.smallListBox').addClass('selected2Del');
                $('.deleteSelectedBtn').removeClass('greyBtn');
                $(".delete_all").attr("disabled", false);
            }
        });



        $(".cb-element").click(function() {

            var checkIndx = $(".cb-element").index(this);
            var nock = $(".cb-element:checked").size();
            var unock = $(".cb-element:unchecked").size();
            //alert(nock);

            if (parseInt(nock) == parseInt(0)) {
                //$("#delete_all").attr("disabled", true).addClass("greyBtn");
                $('.smallListBox').removeClass('selected2Del');
                //$(".smallListBox:eq(" + checkIndx + ")").removeClass('selected2Del');
                $('.deleteSelectedBtn').addClass('greyBtn');
                $(".delete_all").attr("disabled", true);
                //alert(checkIndx);

            } else {
                //$("#delete_all").attr("disabled", false).removeClass("greyBtn");
                //$('.smallListBox').addClass('selected2Del');
                $(".smallListBox:eq(" + checkIndx + ")").addClass('selected2Del');
                $('.deleteSelectedBtn').removeClass('greyBtn');
                $(".delete_all").attr("disabled", false);

            }

            if (parseInt(unock) == parseInt(0)) {
                $("#chk_all").attr("checked", true);
                $("#chk_all2").attr("checked", true);
            } else {
                $("#chk_all").attr("checked", false);
                $("#chk_all2").attr("checked", false);
            }



        });

        //DELETE SELECTED
        $(".delete_all").click(function() {
            $(this).deleteSelected();
        });




        //DELETE DATA
        $(".deleteData").click(function() {
            var socialmedia_id = $(this).attr("value");
            $(this).deleteData({
                socialmedia_id: socialmedia_id
            });
        });

        $(".modifyData").click(function() {
            var socialmedia_id = $(this).attr("value");
            //alert(socialmedia_id)

            //$('.wrapper_table').show();

            $(this).modifyData({
                socialmedia_id: socialmedia_id
            });

            $(".expendableBox").slideDown();

            $('.showHideBtn').html("(-)");

            $(".expendBtn").addClass("collapseBtn");
            $(".expendBtn").removeClass("expendBtn");

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


        /*  $("#test-list").sortable({
              handle : '.handle',
              update : function () {
              	var order = $('#test-list').sortable('serialize');
                  var qryString = $("#qryString").val();
                  //alert(order);
                  $.ajax({
                      type: "POST",
                      url: "ajax_position.php",
                      data: "type=saveListPosition&" + qryString + "&" + order,
                      beforeSend: function(){

                      },
                      success: function(msg) {
                          //alert(msg)
                          $("#smessage").html(msg);
                      }
                  });


              }
          }); */



    });
    </script>


    <input type="hidden" name="qryString" id="qryString" value="<?php echo $position_qry_string; ?>&stop=1"
        style="width: 1100px;" />


    <div class="containerPad">
        <!--div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox" type="checkbox" name="chk_all" value="1" id="chk_all" /></label>
                    <input type="button" class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php //showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~"); ?>
            </div-->
        <!--hintIconWrap end-->

        <div class="clear">&nbsp;</div>
        <div id="test-list">
            <?php
$CK_COUNTER = 0;
        $FOR_BG_COLOR = 0;
        $disp = 0;
        foreach ($row as $rs) {
            $socialmedia_id = "";
            $socialmedia_name = "";
            $status = "";

            $socialmedia_id = stripslashes($rs['socialmedia_id']);
            $socialmedia_name = stripslashes($rs['socialmedia_name']);

            $position = stripslashes($rs['position']);
            $status = stripslashes($rs['status']);
            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";

            $CHK = chkFor($socialmedia_id);
            $CHK = intval(0); // by default because added elemet is not necessry here

            ?>

            <div class="smallListBox" id="listItem_<?php echo $socialmedia_id; ?>">
                <div class="sListTitle"><?php echo $socialmedia_name; ?></div>
                <div class="sListBtnWrap">
                    <table>
                        <tr>
                            <td align="left" width="20">
                                <?php
if (intval($CHK) == intval(0)) {
                $CK_COUNTER++;
                ?>
                                <input type="checkbox" class="cb-element" name="chk[]"
                                    value="<?php echo $socialmedia_id; ?>" />
                                <?php
} else {
                echo '<input type="checkbox" disabled=""/>';
            }
            ?>
                            </td>
                            <td width="30" class="statusTd">
                                <div id="INPROCESS_STATUS_1_<?php echo $socialmedia_id; ?>" style="display: none;">
                                </div>
                                <div id="INPROCESS_STATUS_2_<?php echo $socialmedia_id; ?>">
                                    <?php
if (trim($status) == 'ACTIVE') {
                ?>
                                    <a href="javascript:void(0);" value="<?php echo $socialmedia_id; ?>"
                                        myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img
                                            src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" /></a>
                                    <?php
} elseif (trim($status) == 'INACTIVE') {
                ?>
                                    <a href="javascript:void(0);" value="<?php echo $socialmedia_id; ?>"
                                        myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img
                                            src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" /></a>
                                    <?php
}
            ?>
                                </div>
                            </td>

                            <td align="right">

                                <div id="INPROCESS_DELETE_1_<?php echo $socialmedia_id; ?>" style="display: none;">
                                </div>
                                <div id="INPROCESS_DELETE_2_<?php echo $socialmedia_id; ?>">
                                    <a href="javascript:void(0);" value="<?php echo $socialmedia_id; ?>"
                                        class="modifyData cmsIcon" title="Modify">
                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png"
                                            border="0" title="Modify" alt="Modify" /></a>
                                    <?php
if (intval($CHK) == intval(0)) {
                ?>
                                    <a href="javascript:void(0);" value="<?php echo $socialmedia_id; ?>"
                                        class="deleteData cmsIcon">
                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0"
                                            title="Delete" alt="Delete" /></a>
                                    <?php
} else {
                ?>
                                    <a href="javascript:void(0);" class="cmsIcon">
                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash_disable.png"
                                            border="0" title="Cannot Delete" alt="Cannot Delete" /></a>
                                    <?php
}
            ?>
                                </div>

                            </td>
                        </tr>
                    </table>
                </div>
                <!--img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position"/ -->
            </div>
            <!--smallListBox-->

            <?php
}
        ?>
            <!--div class="smallListBox" style="display: none;"></div-->
        </div>
        <div class="clear"></div>
        <div class="hintIconWrap">
            <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                <label class="selectAllBtn"><input type="checkbox" name="chk_all2" value="1" id="chk_all2"
                        class="chk_all" /></label>
                <input type="button" class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"
                    id="delete_all" disabled="" />
            </div>
            <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE");?>

        </div>
        <!--hintIconWrap end-->
        <?php
if ($paging[0] != "") {
            ?>
        <div class="clear"></div>
        <div id="pagingWrap">
            <?php echo $paging[0]; ?>
        </div>

        <?php
}
        ?>

        <div class="clear">&nbsp;</div>
        <!--div class="notes">Note: You can only delete items which do not have any data added under them.</div-->

        <?php
if (intval($CK_COUNTER) <= intval(0)) {
            ?>
        <script language="javascript" type="text/javascript">
        $(document).ready(function() {
            $("#delete_all").hide();
            $("#chk_all").hide();
        });
        </script>
        <?php
}
        ?>
    </div>
</form>
<?php
} else {
        ?>
<div class="containerPad">
    <b>Not Found </b>
</div>
<?php
}
    ?>

<?php
}

function modifyData()
{
    global $dCON;

    $socialmedia_id = intval($_REQUEST['socialmedia_id']);

    $stmt = $dCON->prepare(" SELECT * FROM " . SOCIALMEDIA_TBL . " WHERE socialmedia_id = ? ");
    $stmt->bindParam(1, $socialmedia_id);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();

    $socialmedia_id = intval($row_stmt[0]['socialmedia_id']);
    $socialmedia_name = (stripslashes($row_stmt[0]['socialmedia_name']));
    $socialmedia_link = (stripslashes($row_stmt[0]['socialmedia_link']));

    echo "~~~$socialmedia_id~~~$socialmedia_name~~~$socialmedia_link~~~";

}

function deleteSelected()
{
    global $dCON;

    $arr = implode(",", $_REQUEST['chk']);
    $exp = explode(",", $arr);
    $i = 0;

    foreach ($exp as $chk) {
        $TIME = date("Y-m-d H:i:s");

        $stmt = $dCON->prepare("DELETE FROM " . SOCIALMEDIA_TBL . "   WHERE socialmedia_id = ?");
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
    $ID = intval($_REQUEST['did']);

    $TIME = date("Y-m-d H:i:s");
    //$socialmedia_name = getDetails(AIRPORT_CITY_TBL, 'socialmedia_name', "socialmedia_id",$ID,'=', '', '' , "" );

    //Delete Master
    $stmt = $dCON->prepare("DELETE FROM " . SOCIALMEDIA_TBL . "   WHERE socialmedia_id = ?");
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
    $STR .= " UPDATE  " . SOCIALMEDIA_TBL . "  SET ";
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE socialmedia_id = :socialmedia_id ";
    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":status", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":socialmedia_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();

    if (intval($RES) == intval(1)) {
        echo '~~~1~~~DONE~~~' . $ID . "~~~";
    } else {
        echo '~~~0~~~ERROR~~~';
    }

}

function chkFor($ID)
{
    global $dCON;
    $CT = 0;

    $SQL = "";
    $SQL = " SELECT SUM(CT) FROM ( ";
    $SQL .= " SELECT COUNT(*) AS CT FROM " . SOCIALMEDIA_TBL . " WHERE socialmedia_id = ? AND status <> 'DELETE' ";
    //$SQL .= " UNION ";
    //$SQL .= " SELECT COUNT(*) AS CT FROM " . RATE_ADDITIONAL_AIRPORT_FROM_UK_TBL . " WHERE location_id = ? AND status <> 'DELETE' ";
    $SQL .= " ) AS aa ";

    //echo $SQL . $ID;
    //exit();

    $sCHK = $dCON->prepare($SQL);
    $sCHK->bindParam(1, $ID);
    //$sCHK->bindParam(2, $ID);
    //$sCHK->bindParam(3, $ID);

    $sCHK->execute();
    $rsCHK = $sCHK->fetchAll();
    $sCHK->closeCursor();
    $CT = intval($rsCHK[0][0]);
    //echo $ID . "==" .  $CT;

    return $CT;

}

?>