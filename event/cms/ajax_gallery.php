<?php
session_start();
error_reporting(0);
include "ajax_include.php";

include "../library_insol/class.imageresizer.php";
define("PAGE_MAIN", "gallery.php");
define("PAGE_AJAX", "ajax_gallery.php");
define("PAGE_LIST", "gallery_list.php");

define("SET1_ENABLE", true);
if (SET1_ENABLE == true) {

    define("SET1_TYPE", "IMAGE");
    if (SET1_TYPE == "FILE") {
        define("SET1_IMAGE_MULTIPLE", true);
        define("SET1_IMAGE_CROPPING", false);
        define("SET1_IMAGE_CAPTION", false);

        define("SET1_UPLOAD_FILE_SIZE", $_SESSION['GALLERY_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS", $_SESSION['GALLERY_IMG_ALLOWED_FORMATS']);

        define("SET1_MINIMUM_RESOLUTION", "");

    } else if (SET1_TYPE == "IMAGE") {
        define("SET1_IMAGE_MULTIPLE", true);
        define("SET1_IMAGE_CROPPING", false);
        define("SET1_IMAGE_CAPTION", true);

        define("SET1_UPLOAD_FILE_SIZE", $_SESSION['GALLERY_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS", $_SESSION['GALLERY_IMG_ALLOWED_FORMATS']);

        define("SET1_MINIMUM_RESOLUTION", "Min. size required 245px x 160px");

    }

    define("SET1_FOR", "GALLERY");
    define("SET1_MANDATORY", false);

    define("SET1_FOLDER", FLD_GALLERY . "/" . FLD_GALLERY_IMG);
    define("SET1_FOLDER_PATH", CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);

    define("SET1_DBTABLE", GALLERY_IMAGES_TBL);

    $SET1_RESIZE_DIMENSION = ""; //widthXheight|weightXheight SEPRATED BY PIPE
    $SET1_SAVE_RESIZE_LOCATION_RELPATH = "";
    $SET1_RESIZE_PREFIX_RELPATH = "";

    if (SET1_IMAGE_CROPPING == true) {

        define("PAGE_CROP_IMAGE", "popupCROP.php");

        define("SET1_CROP_SIZE", "");
        define("SET1_CROP_PREFIX", "C" . SET1_CROP_SIZE . "-");
        define("SET1_CROP_ASPECT_RATIO", "1:1");
        define("SET1_CROP_IMAGE_WIDTH", "500");
        define("SET1_CROP_IMAGE_HEIGHT", "500");

        define("SET1_IMAGE_RESIZE", "YES"); /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========
        define("SET1_IMAGE_RESIZE_WIDTH", 700);
        define("SET1_IMAGE_RESIZE_HEIGHT", 700);
        define("SET1_IMAGE_RESIZE_PREFIX", "R" . SET1_IMAGE_RESIZE_WIDTH . "-");

        $SET1_RESIZE_DIMENSION = SET1_IMAGE_RESIZE_WIDTH . "X" . SET1_IMAGE_RESIZE_HEIGHT;
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../" . CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;

    } else if (SET1_IMAGE_CROPPING == false) {

        define("SET1_IMAGE_RESIZE", "NO"); /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========

        define("SET1_CROP_SIZE", "");
        define("SET1_CROP_PREFIX", "");
        define("SET1_CROP_ASPECT_RATIO", "");
        define("SET1_CROP_IMAGE_WIDTH", "");
        define("SET1_CROP_IMAGE_HEIGHT", "");

        define("SET1_IMAGE_RESIZE_WIDTH", "");
        define("SET1_IMAGE_RESIZE_HEIGHT", "");
        define("SET1_IMAGE_RESIZE_PREFIX", "");

        $SET1_RESIZE_DIMENSION = "";
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../" . CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;

    }

}

$type = trustme($_REQUEST['type']);
switch ($type) {
    case "removeImage":
        removeImage();
        break;

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
    case "setHomePage":
        setHomePage();
        break;

}

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imgID = intval($_REQUEST['imgID']);
    $FOLDER_NAME = trustme($_REQUEST['foldername']);

    $copy = intval($_REQUEST['copy']);
    //exit;

    //echo "$imgID==$image_name==$FOLDER_NAME===$copy";
    //exit();

    if (intval($copy) == intval(1)) {
        echo "~~~1~~~Deleted~~~";
    } else {

        if ($imgID == intval(0)) {
            $FOLDER_NAME = TEMP_UPLOAD;

            deleteIMG("TEMP", $image_name, CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME);

            echo "~~~1~~~Deleted~~~";
            exit();

        } elseif ($imgID > intval(0)) {

            $FOLDER_NAME = $FOLDER_NAME;

            if (unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) {

                deleteIMG(SET1_FOR, $image_name, CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME);
                if (trim(SET1_IMAGE_CROPPING) == true) {
                    deleteIMG("TEMP", $image_name, CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME);
                }
                //echo "$imgID==$image_name==$FOLDER_NAME===$copy";
                //exit();
                if ($imgID > intval(0)) {

                    $sDEL = $dCON->prepare("DELETE FROM " . SET1_DBTABLE . " WHERE image_id = :image_id ");
                    $sDEL->bindParam(":image_id", $imgID);
                    $sDEL->execute();
                    $sDEL->closeCursor();

                }

                echo "~~~1~~~Deleted~~~";

            } else {
                echo "~~~0~~~Sorry Cannot Delete~~~";
            }

        }
        //echo CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name;
        //exit();

    }

}

function saveData()
{
    global $dCON;

    $gallery_name = trustme($_REQUEST['gallery_name']);

    $gallery_date = trustme($_REQUEST['gallery_date']);

    $gallery_date_array = explode("-", $gallery_date);
    $gallery_date = $gallery_date_array[2] . "-" . $gallery_date_array[1] . "-" . $gallery_date_array[0];

    //$gallery_description = trustyou($_REQUEST['dcontent']);

    if (SET1_ENABLE == true) {

        $SET1_ARR_image = $_REQUEST['set1_image'];
        $SET1_deafult = $_REQUEST['set1_default_image'];
        $SET1_ARR_imageid = $_REQUEST['set1_image_id'];
        $SET1_ARR_imagecaption = $_REQUEST['set1_image_caption'];
        $SET1_ARR_folder = $_REQUEST['set1_folder_name'];

        if (SET1_IMAGE_CROPPING == true) {
            $SET1_ARR_coordinates = $_REQUEST['set1_coordinates']; //Crop Image Coordinates
        } elseif (SET1_IMAGE_CROPPING == false) {
            $SET1_ARR_coordinates = "";
        }

        //print_r($SET1_ARR_imagecaption);
        //exit();
    }

    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $status = trim($status) == '' ? "ACTIVE" : trim($status);

    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $IP = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $SESSIONID = session_id();

    $url_key = filterString($gallery_name);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);

    $meta_title = trim($meta_title) == '' ? trim($gallery_name) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($gallery_name) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($gallery_name) : trim($meta_description);

    if ($con == "add") {
        $CHK = checkDuplicate(GALLERY_TBL, "gallery_name~~~gallery_date", "$gallery_name~~~$gallery_date", "=~~~=~~~=", "");
        //echo $section_name;

        if (intval($CHK) == intval(0)) {

            $MAX_ID = getMaxId(GALLERY_TBL, "gallery_id");
            $MAX_POS = getMaxPosition(GALLERY_TBL, "position", "", "", "=");
            $MY_URLKEY = getURLKEY(GALLERY_TBL, $url_key, $gallery_name, "", "", "", $MAX_ID, "");

            $SQL = "";
            $SQL .= " INSERT INTO " . GALLERY_TBL . " SET ";
            $SQL .= " gallery_id = :gallery_id, ";

            $SQL .= " gallery_name = :gallery_name, ";
            $SQL .= " gallery_date = :gallery_date, ";

            // $SQL .= " gallery_description = :gallery_description, ";

            $SQL .= " status = :status, ";
            $SQL .= " position = :position, ";
            $SQL .= " add_ip = :add_ip, ";
            $SQL .= " add_time = :add_time, ";
            $SQL .= " add_by = :add_by, ";
            $SQL .= " url_key = :url_key, ";
            $SQL .= " meta_title = :meta_title, ";
            $SQL .= " meta_keyword = :meta_keyword, ";
            $SQL .= " meta_description = :meta_description ";

            $sINS = $dCON->prepare($SQL);
            $sINS->bindParam(":gallery_id", $MAX_ID);

            $sINS->bindParam(":gallery_name", $gallery_name);
            $sINS->bindParam(":gallery_date", $gallery_date);
            //   $sINS->bindParam(":gallery_description", $gallery_description);

            $sINS->bindParam(":status", $status);
            $sINS->bindParam(":position", $MAX_POS);
            $sINS->bindParam(":add_ip", $IP);
            $sINS->bindParam(":add_time", $TIME);
            $sINS->bindParam(":add_by", $_SESSION['USERNAME']);
            $sINS->bindParam(":url_key", $MY_URLKEY);
            $sINS->bindParam(":meta_title", $meta_title);
            $sINS->bindParam(":meta_keyword", $meta_keyword);
            $sINS->bindParam(":meta_description", $meta_description);
            $RES = $sINS->execute();
            $sINS->closeCursor();

            if (intval($RES) == intval(1)) {
                $RTNID = $MAX_ID;

                if (SET1_ENABLE == true) {

                    /////////////---------------Saved Gallery============================
                    $TITLE = $gallery_name;
                    include "include_SET1_SAVE4ADD.php";

                }

            }

        } else {
            $RES = 2;
        }
    } else if ($con == "modify") {
        $CHK = checkDuplicate(GALLERY_TBL, "gallery_name~~~gallery_date~~~gallery_id", "$gallery_name~~~$gallery_date~~~$id", "=~~~=~~~<>", "");

        if (intval($CHK) == intval(0)) {
            $MY_URLKEY = getURLKEY(GALLERY_TBL, $url_key, $gallery_name, "gallery_id", $id, "<>", $id, "");

            $SQL = "";
            $SQL .= " UPDATE " . GALLERY_TBL . " SET ";

            $SQL .= " gallery_name = :gallery_name, ";
            $SQL .= " gallery_date = :gallery_date, ";
            // $SQL .= " gallery_description = :gallery_description, ";

            $SQL .= " status = :status, ";
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, ";
            $SQL .= " update_by = :update_by, ";
            $SQL .= " url_key = :url_key, ";
            $SQL .= " meta_title = :meta_title, ";
            $SQL .= " meta_keyword = :meta_keyword, ";
            $SQL .= " meta_description = :meta_description ";
            $SQL .= " WHERE gallery_id = :gallery_id ";

            $sUPD = $dCON->prepare($SQL);

            $sUPD->bindParam(":gallery_name", $gallery_name);
            $sUPD->bindParam(":gallery_date", $gallery_date);
            //  $sUPD->bindParam(":gallery_description", $gallery_description);

            $sUPD->bindParam(":status", $status);
            $sUPD->bindParam(":update_ip", $IP);
            $sUPD->bindParam(":update_time", $TIME);
            $sUPD->bindParam(":update_by", $_SESSION['USERNAME']);
            $sUPD->bindParam(":url_key", $MY_URLKEY);
            $sUPD->bindParam(":meta_title", $meta_title);
            $sUPD->bindParam(":meta_keyword", $meta_keyword);
            $sUPD->bindParam(":meta_description", $meta_description);
            $sUPD->bindParam(":gallery_id", $id);

            $RES = $sUPD->execute();
            $sUPD->closeCursor();
            if (intval($RES) == intval(1)) {

                $RTNID = $id;

                if (SET1_ENABLE == true) {

                    /////////////---------------Saved Gallery============================
                    $TITLE = $gallery_name;
                    include "include_SET1_SAVE4EDIT.php";

                }

            }

        } else {
            $RES = 2;
        }
    }

    switch ($RES) {
        case "1":
            echo "~~~1~~~Successfully saved~~~$RTNID~~~";
            break;
        case "2":
            echo "~~~2~~~Already exists~~~";
            break;
        default:
            echo "~~~0~~~Error occured, Try again~~~";
            break;
    }
}

function listData()
{
    global $dCON;
    global $pg;

    $gallery_name = trustme($_REQUEST['search_name']);
    $search_fdate = trustme($_REQUEST['search_fdate']);

    $search = "";

    if ($gallery_name != "") {
        $search .= " and gallery_name like :gallery_name ";
    }

    if (trim($search_fdate) != "") {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];

        $search .= " AND DATE(G.gallery_date) = :from_date ";
    }

    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . GALLERY_TBL . " as G WHERE status <> 'DELETE' $search ";

    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= " ,(SELECT AI.image_name FROM " . GALLERY_IMAGES_TBL . " as AI WHERE AI.master_id = G.gallery_id ORDER BY AI.default_image desc, AI.image_id ASC LIMIT 0,1 ) as image_name ";
    $SQL .= " FROM " . GALLERY_TBL . " as G WHERE  G.status <> 'DELETE' $search ORDER BY gallery_id desc ";
    //echo $SQL;

    $stmt1 = $dCON->prepare($SQL_PG);

    if (trim($gallery_name) != "") {
        $stmt1->bindParam(":gallery_name", $nam);
        $nam = "%{$gallery_name}%";
    }
    if (trim($search_fdate) != "") {
        $stmt1->bindParam(":from_date", $search_fdate);
    }

    $stmt1->execute();
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 50;
    $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);

    if (trim($gallery_name) != "") {
        $stmt2->bindParam(":gallery_name", $nam);
        $nam = "%{$gallery_name}%";
    }
    if (trim($search_fdate) != "") {
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
                                        <b>Total Records: <?php echo intval($dA); ?></b></td><?php }?>
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


            $(".setHomePage").live("click", function() {
                var ID = $(this).attr("value");
                var VAL = $(this).attr("myvalue");
                //alert(ID+"####"+VAL);

                $(this).setHomePage({
                    ID: ID,
                    VAL: VAL
                });
            });

        });
        </script>

        <tr>
            <td class="list_table" valign="top">
                <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                    <tr>
                        <th width="3%" align="center"><?php if ((intval($dA) > intval(0))) {?><input type="checkbox"
                                name="chk_all" value="1" id="chk_all" /><?php }?></th>
                        <th width="3%" align="center">Status</th>
                        <th width="34%" align="left">Gallery Name</th>
                        <th width="15%" align="left">Date</th>
                        <th width="8%" align="center">Image</th>
                        <!--th width="8%" align="center">Home page</th-->
                        <th align="center" width="8%">Action</th>
                    </tr>
                    <?php
$CK_COUNTER = 0;
        $FOR_BG_COLOR = 0;
        $temp = '';
        $disp = 0;

        foreach ($row as $rs) {
            $gallery_id = "";

            $gallery_name = "";
            $gallery_date = "";
            $status = "";

            $gallery_id = intval($rs['gallery_id']);

            $gallery_name = stripslashes($rs['gallery_name']);
            $gallery_date = stripslashes($rs['gallery_date']);

            if ($gallery_date != "0000-00-00" && $gallery_date != "") {
                $gallery_date = date("d M, Y", strtotime($gallery_date));
            }

            $status = stripslashes($rs['status']);
            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";

            $home_page = stripslashes($rs['home_page']);
            $HOMEPAGEnowaction = stripslashes($home_page) == intval(1) ? intval(0) : intval(1);

            $image_name = trim(stripslashes($rs['image_name']));

            $DISPLAY_IMG = "";
            $R50_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R50-" . $image_name);

            if (intval($R50_IMG_EXIST) == intval(1)) {
                $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R50-" . $image_name;
            }

            ?>

                    <tr class="expiredCoupons trhover">
                        <td align="center" width="3%">
                            <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $gallery_id; ?>" />
                        </td>

                        <td align="center">
                            <div id="INPROCESS_STATUS_1_<?php echo $gallery_id; ?>" style="display: none;"></div>
                            <div id="INPROCESS_STATUS_2_<?php echo $gallery_id; ?>">
                                <a href="javascript:void(0);" value="<?php echo $gallery_id; ?>"
                                    myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus">
                                    <img <?php
if (trim($status) == 'ACTIVE') {
                ?> src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" title="Click to Inactive"
                                        alt="Click to Inactive" />

                                    <?php
} elseif (trim($status) == 'INACTIVE') {
                ?>
                                    src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" title="Click to
                                    Active" alt="Click to Active" />
                                    <?php
}
            ?>

                                </a>
                            </div>
                        </td>
                        <td>
                            <h3 class="couponType">
                                <a class="previewBookReview" href="javascript: void(0);"
                                    bid=<?php echo $gallery_id; ?>><?php echo $gallery_name; ?></a>
                            </h3>
                        </td>
                        <td>
                            <?php echo $gallery_date; ?>
                        </td>
                        <td align='center'>
                            <?php if ($DISPLAY_IMG != '') {?>
                            <img src="<?php echo $DISPLAY_IMG; ?>" alt="" width="30" height="30" />
                            <?php }?>
                        </td>

                        <?php /*
            <td align="center">
            <div id="INPROCESS_HOME_1_<?php echo $gallery_id; ?>" style="display: none;"></div>
                        <div id="INPROCESS_HOME_2_<?php echo $gallery_id; ?>">
                            <a href="javascript:void(0);" value="<?php echo $gallery_id; ?>"
                                myvalue="<?php echo $HOMEPAGEnowaction; ?>" class="setHomePage">
                                <img <?php
            if( intval($home_page) == intval(1))
            {
            ?> src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>set.png" title="UnSet" alt="Unset" />
                                <?php
            }
            elseif( intval($home_page) == intval(0))
            {
            ?>
                                src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>unset.png" title="Set" alt="Set" />
                                <?php
            }
            ?>
                            </a>

                        </div>

            </td>
            */?>

            <td align="center">
                <div id="INPROCESS_DELETE_1_<?php echo $gallery_id; ?>" style="display: none;"></div>
                <div id="INPROCESS_DELETE_2_<?php echo $gallery_id; ?>">
                    <a href="<?php echo PAGE_MAIN; ?>?ID=<?php echo base64_encode(intval($gallery_id)); ?>"
                        class="modifyData img_btn">
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify"
                            alt="Modify" />
                    </a>
                    <?php
if (intval($CHK) == intval(0)) {
                ?>
                    <a href="javascript:void(0);" value="<?php echo $gallery_id; ?>" class="deleteData img_btn">
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Delete"
                            alt="Delete" />
                    </a>
                    <?php
} else {
                ?>
                    <a href="javascript:void(0);" class="img_btn_dis">
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0"
                            title="Cannot Delete" alt="Cannot Delete" />
                    </a>

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
            <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~");?>
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

        $stmt = $dCON->prepare("Update " . GALLERY_TBL . "  set status='DELETE' WHERE gallery_id = ?");
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
    $stmt = $dCON->prepare("Update " . GALLERY_TBL . "  set status='DELETE'  WHERE gallery_id = ?");
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
    $STR .= " UPDATE  " . GALLERY_TBL . "  SET ";
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE gallery_id = :gallery_id ";
    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":status", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":gallery_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();

    if (intval($RES) == intval(1)) {
        echo '~~~1~~~DONE~~~' . $ID . "~~~";
    } else {
        echo '~~~0~~~ERROR~~~';
    }

}

function setHomePage()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");

    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);
    $update_time = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);

    $STR = "";
    $STR .= " UPDATE  " . GALLERY_TBL . "  SET ";
    $STR .= " home_page = :home_page, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE gallery_id = :gallery_id ";
    $sDEF = $dCON->prepare($STR);

    $sDEF->bindParam(":home_page", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $update_time);
    $sDEF->bindParam(":gallery_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();

    if (intval($RES) == intval(1)) {
        //$str_no = " UPDATE ". GALLERY_TBL ." SET home_page = '0' WHERE gallery_id !=". $ID ;
        //$sDEF_NO = $dCON->prepare($str_no);
        //$sDEF_NO->execute();

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
    //$SQL .= " SELECT COUNT(*) AS CT FROM " . PRODUCT_TBL . " WHERE section_id = ? AND status <> 'DELETE' ";
    //$SQL .= " UNION ";
    //$SQL .= " SELECT COUNT(*) AS CT FROM " . RATE_ADDITIONAL_AIRPORT_FROM_UK_TBL . " WHERE location_id = ? AND status <> 'DELETE' ";
    $SQL .= " ) AS aa ";
    //echo $SQL . $ID;

    $sCHK = $dCON->prepare($SQL);
    $sCHK->bindParam(1, $ID);
    //$sCHK->bindParam(2, $ID);
    //$sCHK->bindParam(3, $ID);

    $sCHK->execute();
    $rsCHK = $sCHK->fetchAll();
    $sCHK->closeCursor();
    //$CT = intval($rsCHK[0][0]);
    //echo $ID . "==" .  $CT;

    return $CT;

}

?>