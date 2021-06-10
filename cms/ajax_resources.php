<?php
session_start();
error_reporting(E_ALL);
include "ajax_include.php";

include "../library_insol/class.imageresizer.php";
define("PAGE_MAIN", "resources.php");
define("PAGE_AJAX", "ajax_resources.php");
define("PAGE_LIST", "resources_list.php");

define("SET1_ENABLE", true);
if (SET1_ENABLE == true) {

    define("SET1_TYPE", "IMAGE");
    if (SET1_TYPE == "FILE") {
        define("SET1_IMAGE_MULTIPLE", true);
        define("SET1_IMAGE_CROPPING", false);
        define("SET1_IMAGE_CAPTION", false);

        define("SET1_UPLOAD_FILE_SIZE", $_SESSION['RESOURCES_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS", $_SESSION['RESOURCES_IMG_ALLOWED_FORMATS']);

        define("SET1_MINIMUM_RESOLUTION", "");

    } else if (SET1_TYPE == "IMAGE") {
        define("SET1_IMAGE_MULTIPLE", true);
        define("SET1_IMAGE_CROPPING", false);
        define("SET1_IMAGE_CAPTION", true);

        define("SET1_UPLOAD_FILE_SIZE", $_SESSION['RESOURCES_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS", $_SESSION['RESOURCES_IMG_ALLOWED_FORMATS']);

        define("SET1_MINIMUM_RESOLUTION", "Min. size required 245px x 160px");

    }

    define("SET1_FOR", "RESOURCES-GALLERY");
    define("SET1_MANDATORY", false);

    define("SET1_FOLDER", FLD_RESOURCES . "/" . FLD_RESOURCES_IMG);
    define("SET1_FOLDER_PATH", CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);

    define("SET1_DBTABLE", RESOURCES_IMAGES_TBL);

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

    case "removeFile":
        removeFile();
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

    case "removeFypeFILE":
        removeFypeFILE();
        break;
    case "removeVTypeFILE":
        removeVTypeFILE();
        break;
}

function removeFypeFILE()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);

    if (intval($ID) == intval(0)) {
        //delete image
        if (unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/" . $image_name)) {
            echo "1~~~Deleted";
        } else {
            echo "0~~~Sorry Cannot Delete Image";
        }
    } else {
        $IMG = getDetails(RESOURCES_TBL, 'file_name', "resources_id", "$ID", '=', '', '', "");

        unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/" . $IMG);

        $stk_del = $dCON->prepare("update " . RESOURCES_TBL . " set file_name ='' WHERE resources_id = :resources_id ");
        $stk_del->bindParam(":resources_id", $ID);
        $stk_del->execute();
        $stk_del->closeCursor();

        echo "1~~~Deleted";

    }

}

function removeVTypeFILE()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);

    if (intval($ID) > intval(0)) {
        $VDO = getDetails(RESOURCES_TBL, 'video_file', "resources_id", "$ID", '=', '', '', "");

        unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_VDO . "/" . $VDO);

        $stk_del = $dCON->prepare("update " . RESOURCES_TBL . " set video_file ='' WHERE resources_id = :resources_id ");
        $stk_del->bindParam(":resources_id", $ID);
        $stk_del->execute();
        $stk_del->closeCursor();

        echo "1~~~Deleted";

    }

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

    $publication_month = "";
    $publication_year = "";
    $resources_from_date = "";

    $category_id = intval($_REQUEST['category_id']);
    $resources_name = trustme($_REQUEST['resources_name']);
    $resources_publisher = trustme($_REQUEST['resources_publisher']);

    $resources_from_date = trustme($_REQUEST['resources_from_date']);
    $publication_month = trustme($_REQUEST['publication_month']);
    $publication_year = trustme($_REQUEST['publication_year']);

    $resources_from_date_array = explode("-", $resources_from_date);
    $resources_from_date = $resources_from_date_array[2] . "-" . $resources_from_date_array[1] . "-" . $resources_from_date_array[0];

    $ftype_url = "";
    $ftype_file_path = "";
    $resources_short_description = "";
    $resources_description = "";
    $video_title = "";
    $video_type = "";
    $embed_code = "";

    $video_file_path = "";
    $old_video = "";
    $old_ftype_file = trustme($_REQUEST['old_ftype_file']);

    $resources_type = trustme($_REQUEST['resources_type']);

    $resources_short_description = trustyou($_REQUEST['resources_short_description']);

    if (trim($resources_type) == "URL") {
        $ftype_url = trustme($_REQUEST['ftype_url']);
    } elseif (trim($resources_type) == "FILE") {

        $ftype_file_path = trustme($_REQUEST['ftype_file_path']);
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

        }

    } elseif (trim($resources_type) == "CONTENT") {

        $resources_description = trustyou($_REQUEST['dcontent']);

        $video_title = trustme($_REQUEST['video_title']);

        $video_type = trustme($_REQUEST['video_type']);
        $embed_code = $_REQUEST['embed_code'];

        $video_file_path = trustme($_REQUEST['video_file_path']);
        $old_video = trustme($_REQUEST['old_video_file']);

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

        }

    }

    $VIDEO_TEMP_FOLDER = "";
    $VIDEO_TEMP_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_VDO . "/";
    $VIDEO_FILE_FOLDER = "";
    $VIDEO_FILE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_VDO . "/";

    $FTYPE_TEMP_FOLDER = "";
    $FTYPE_TEMP_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/";
    $FTYPE_FILE_FOLDER = "";
    $FTYPE_FILE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/";

    //echo $resources_type . "\n";
    //echo $old_ftype_file . "\n";
    //exit();

    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $status = trim($status) == '' ? "ACTIVE" : trim($status);

    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $IP = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $SESSIONID = session_id();

    $url_key = filterString($resources_name);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);

    $meta_title = trim($meta_title) == '' ? trim($resources_name) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($resources_name) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($resources_name) : trim($meta_description);

    if ($con == "add") {
        $CHK = checkDuplicate(RESOURCES_TBL, "resources_name~~~category_id~~~resources_from_date", "$resources_name~~~$category_id~~~$resources_from_date", "=~~~=~~~=", "");
        //echo $section_name;

        if (intval($CHK) == intval(0)) {

            $MAX_ID = getMaxId(RESOURCES_TBL, "resources_id");
            $MAX_POS = getMaxPosition(RESOURCES_TBL, "position", "", "", "=");
            $MY_URLKEY = getURLKEY(RESOURCES_TBL, $url_key, $resources_name, "", "", "", $MAX_ID, "");

            if ((trim($video_type) == "VIDEO_FILE") && (trim($video_file_path) != "")) {
                $f_ext = pathinfo($video_file_path);

                $vFILE = strtolower(filterString($resources_name)) . "-" . $MAX_ID . "." . $f_ext['extension'];
                rename($VIDEO_TEMP_FOLDER . $video_file_path, $VIDEO_FILE_FOLDER . $vFILE);

            } else {
                $vFILE = "";
            }

            if ((trim($resources_type) == "FILE") && (trim($ftype_file_path) != "")) {

                $ft_ext = pathinfo($ftype_file_path);

                $ftFILE = strtolower(filterString($resources_name)) . "-" . $MAX_ID . "." . $ft_ext['extension'];
                rename($FTYPE_TEMP_FOLDER . $ftype_file_path, $FTYPE_FILE_FOLDER . $ftFILE);

            } else {
                $ftFILE = "";
            }

            //echo "--->$ftFILE";
            //exit();

            $SQL = "";
            $SQL .= " INSERT INTO " . RESOURCES_TBL . " SET ";
            $SQL .= " resources_id = :resources_id, ";
            $SQL .= " category_id = :category_id, ";
            $SQL .= " resources_name = :resources_name, ";
            $SQL .= " resources_publisher = :resources_publisher, ";

            $SQL .= " resources_from_date = :resources_from_date, ";
            $SQL .= " publication_month = :publication_month, ";
            $SQL .= " publication_year = :publication_year, ";
            $SQL .= " resources_type = :resources_type, ";
            $SQL .= " resources_url = :resources_url, ";
            $SQL .= " file_name = :file_name, ";

            $SQL .= " resources_short_description = :resources_short_description, ";
            $SQL .= " resources_description = :resources_description, ";

            $SQL .= " video_title = :video_title, ";
            $SQL .= " video_type = :video_type, ";
            $SQL .= " embed_code = :embed_code, ";
            $SQL .= " video_file = :video_file, ";

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
            $sINS->bindParam(":resources_id", $MAX_ID);
            $sINS->bindParam(":category_id", $category_id);

            $sINS->bindParam(":resources_name", $resources_name);
            $sINS->bindParam(":resources_publisher", $resources_publisher);
            $sINS->bindParam(":resources_from_date", $resources_from_date);
            $sINS->bindParam(":publication_month", $publication_month);
            $sINS->bindParam(":publication_year", $publication_year);

            $sINS->bindParam(":resources_type", $resources_type);
            $sINS->bindParam(":resources_url", $ftype_url);
            $sINS->bindParam(":file_name", $ftFILE);

            $sINS->bindParam(":resources_short_description", $resources_short_description);
            $sINS->bindParam(":resources_description", $resources_description);

            $sINS->bindParam(":video_title", $video_title);
            $sINS->bindParam(":video_type", $video_type);
            $sINS->bindParam(":embed_code", $embed_code);
            $sINS->bindParam(":video_file", $vFILE);

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
                    $TITLE = $resources_name;
                    include "include_SET1_SAVE4ADD.php";

                }

            }

        } else {
            $RES = 2;
        }
    } else if ($con == "modify") {
        $CHK = checkDuplicate(RESOURCES_TBL, "category_id~~~resources_name~~~resources_from_date~~~resources_id", "$category_id~~~$resources_name~~~$resources_from_date~~~$id", "=~~~=~~~=~~~<>", "");

        if (intval($CHK) == intval(0)) {
            $MY_URLKEY = getURLKEY(RESOURCES_TBL, $url_key, $resources_name, "resources_id", $id, "<>", $id, "");

            /*
            echo $video_type . "\n";
            echo $old_video . "\n";
            echo $video_file_path . "\n";
            echo $VIDEO_FILE_FOLDER . "\n";

            exit();
             */

            $vFILE = "";
            if ((trim($video_type) == "VIDEO_FILE") && (trim($video_file_path) != "")) {

                if (trim($old_video) != "") {
                    unlink($VIDEO_FILE_FOLDER . $old_video);
                    unlink($VIDEO_FILE_FOLDER . str_replace(".mp4", "", $old_video) . ".jpg");
                }

                $vTITLE = filterString($resources_name);
                $f_ext = pathinfo($video_file_path);

                $vFILE = strtolower($vTITLE) . "-" . $id . "." . $f_ext['extension'];
                rename($VIDEO_TEMP_FOLDER . $video_file_path, $VIDEO_FILE_FOLDER . $vFILE);

                //echo "@@@$VIDEO_FILE_FOLDER\n";
                //echo "@@@$vFILE\n";
                //exit();

            } else {

                $vFILE = "";

                if (trim($video_type) == "VIDEO_EMBED" && trim($old_video) != "") {
                    unlink($VIDEO_FILE_FOLDER . $old_video);
                    unlink($VIDEO_FILE_FOLDER . str_replace(".mp4", "", $old_video) . ".jpg");
                }

            }

            $ftFILE = "";
            if ((trim($resources_type) == "FILE") && (trim($ftype_file_path) != "")) {

                if (trim($old_ftype_file) != "") {
                    unlink($FTYPE_FILE_FOLDER . $old_ftype_file);
                }

                $ft_ext = pathinfo($ftype_file_path);

                $ftFILE = strtolower(filterString($resources_name)) . "-" . $id . "." . $ft_ext['extension'];
                rename($FTYPE_TEMP_FOLDER . $ftype_file_path, $FTYPE_FILE_FOLDER . $ftFILE);

                //echo "@@@$FTYPE_FILE_FOLDER\n";
                //echo "@@@$ftFILE\n";
                //exit();

            } else {

                $ftFILE = "";

                if (trim($resources_type) != "FILE" && trim($old_ftype_file) != "") {
                    unlink($FTYPE_FILE_FOLDER . $old_ftype_file);
                } else {
                    $ftFILE = $old_ftype_file;
                }

            }

            $SQL = "";
            $SQL .= " UPDATE " . RESOURCES_TBL . " SET ";
            $SQL .= " category_id = :category_id, ";
            $SQL .= " resources_name = :resources_name, ";
            $SQL .= " resources_publisher = :resources_publisher, ";
            $SQL .= " resources_from_date = :resources_from_date, ";
            $SQL .= " publication_month = :publication_month, ";
            $SQL .= " publication_year = :publication_year, ";

            $SQL .= " resources_type = :resources_type, ";
            $SQL .= " resources_url = :resources_url, ";
            $SQL .= " file_name = :file_name, ";

            $SQL .= " resources_short_description = :resources_short_description, ";
            $SQL .= " resources_description = :resources_description, ";

            $SQL .= " video_title = :video_title, ";
            $SQL .= " video_type = :video_type, ";

            if ((trim($video_type) == "VIDEO_FILE") && (trim($vFILE) != "")) {
                $SQL .= " video_file = :video_file, ";
                $SQL .= " embed_code = '', ";
            } else if (trim($video_type) == "VIDEO_EMBED") {
                $SQL .= " video_file = '', ";
                $SQL .= " embed_code = :embed_code, ";
            }

            $SQL .= " status = :status, ";
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, ";
            $SQL .= " update_by = :update_by, ";
            $SQL .= " url_key = :url_key, ";
            $SQL .= " meta_title = :meta_title, ";
            $SQL .= " meta_keyword = :meta_keyword, ";
            $SQL .= " meta_description = :meta_description ";
            $SQL .= " WHERE resources_id = :resources_id ";

            $sUPD = $dCON->prepare($SQL);

            $sUPD->bindParam(":category_id", $category_id);

            $sUPD->bindParam(":resources_name", $resources_name);
            $sUPD->bindParam(":resources_publisher", $resources_publisher);
            $sUPD->bindParam(":resources_from_date", $resources_from_date);
            $sUPD->bindParam(":publication_month", $publication_month);
            $sUPD->bindParam(":publication_year", $publication_year);

            $sUPD->bindParam(":resources_type", $resources_type);
            $sUPD->bindParam(":resources_url", $ftype_url);
            $sUPD->bindParam(":file_name", $ftFILE);

            $sUPD->bindParam(":resources_short_description", $resources_short_description);
            $sUPD->bindParam(":resources_description", $resources_description);

            $sUPD->bindParam(":video_title", $video_title);
            $sUPD->bindParam(":video_type", $video_type);

            if ((trim($video_type) == "VIDEO_FILE") && (trim($vFILE) != "")) {
                $sUPD->bindParam(":video_file", $vFILE);
            } else if (trim($video_type) == "VIDEO_EMBED") {
                $sUPD->bindParam(":embed_code", $embed_code);
            }

            $sUPD->bindParam(":status", $status);
            $sUPD->bindParam(":update_ip", $IP);
            $sUPD->bindParam(":update_time", $TIME);
            $sUPD->bindParam(":update_by", $_SESSION['USERNAME']);
            $sUPD->bindParam(":url_key", $MY_URLKEY);
            $sUPD->bindParam(":meta_title", $meta_title);
            $sUPD->bindParam(":meta_keyword", $meta_keyword);
            $sUPD->bindParam(":meta_description", $meta_description);
            $sUPD->bindParam(":resources_id", $id);

            $RES = $sUPD->execute();
            $sUPD->closeCursor();
            if (intval($RES) == intval(1)) {

                $RTNID = $id;

                if (SET1_ENABLE == true) {

                    /////////////---------------Saved Gallery============================
                    $TITLE = $resources_name;
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

    $category_id = intval($_REQUEST['CID']);
    $resources_name = trustme($_REQUEST['search_name']);
    $search_fdate = trustme($_REQUEST['search_fdate']);
    $search_tdate = trustme($_REQUEST['search_tdate']);

    $search = "";

    if (intval($category_id) > intval(0)) {
        $search .= " and category_id ='" . $category_id . "' ";
    }

    if ($resources_name != "") {
        $search .= " and resources_name like :resources_name ";
    }

    if (trim($search_fdate) != "" && trim($search_tdate) != "") {
        $search_from_date_arr = explode("-", $search_fdate);
        $search_fdate = $search_from_date_arr[2] . "-" . $search_from_date_arr[1] . "-" . $search_from_date_arr[0];

        $search_to_date_arr = explode("-", $search_tdate);
        $search_tdate = $search_to_date_arr[2] . "-" . $search_to_date_arr[1] . "-" . $search_to_date_arr[0];

        $search .= " AND DATE(M.resources_from_date) BETWEEN :from_date AND :to_date ";
    } else if (trim($search_fdate) != "") {
        $search_from_date_arr = explode("-", $search_fdate);
        $search_fdate = $search_from_date_arr[2] . "-" . $search_from_date_arr[1] . "-" . $search_from_date_arr[0];

        $search .= " AND DATE(M.resources_from_date) = :from_date ";
    }

    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . RESOURCES_TBL . " as M WHERE status <> 'DELETE' $search ";

    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= " ,(SELECT AI.image_name FROM " . RESOURCES_IMAGES_TBL . " as AI WHERE AI.master_id = M.resources_id ORDER BY AI.default_image desc, AI.image_id ASC LIMIT 0,1 ) as image_name ";
    $SQL .= " FROM " . RESOURCES_TBL . " as M WHERE  M.status <> 'DELETE' $search ORDER BY resources_id desc ";
    //echo $SQL;

    $stmt1 = $dCON->prepare($SQL_PG);

    if (trim($resources_name) != "") {
        $stmt1->bindParam(":resources_name", $nam);
        $nam = "%{$resources_name}%";
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
    $rowsPerPage = 50;
    $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);

    if (trim($resources_name) != "") {
        $stmt2->bindParam(":resources_name", $nam);
        $nam = "%{$resources_name}%";
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



        });
        </script>

        <tr>
            <td class="list_table" valign="top">
                <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                    <tr>
                        <th width="3%" align="center"><?php if ((intval($dA) > intval(0))) {?><input type="checkbox"
                                name="chk_all" value="1" id="chk_all" /><?php }?></th>
                        <th width="3%" align="center">Status</th>
                        <th align="left">Name</th>
                        <th width="15%" align="left">Date</th>
                        <th width="8%" align="center" style="text-align: center;">Image</th>

                        <th align="center" width="8%" style="text-align: center;">Action</th>
                    </tr>
                    <?php
$CK_COUNTER = 0;
        $FOR_BG_COLOR = 0;
        $temp = '';
        $disp = 0;

        foreach ($row as $rs) {
            $resources_id = "";

            $resources_name = "";
            $publication_month = "";
            $publication_year = "";
            $resources_from_date = "";
            $status = "";

            $resources_id = intval($rs['resources_id']);

            $resources_name = stripslashes($rs['resources_name']);
            $publication_month = stripslashes($rs['publication_month']);
            $publication_year = stripslashes($rs['publication_year']);
            $resources_from_date = stripslashes($rs['resources_from_date']);

            if ($resources_from_date != "0000-00-00" && $resources_from_date != "") {
                $resources_from_date = date("d M, Y", strtotime($resources_from_date));
            }

            if ($publication_year != "") {
                $date_display = $publication_month . " " . $publication_year;
            } else {
                $date_display = $resources_from_date;
            }

            $status = stripslashes($rs['status']);
            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";

            $image_name = trim(stripslashes($rs['image_name']));

            $DISPLAY_IMG = "";
            $R50_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R50-" . $image_name);

            if (intval($R50_IMG_EXIST) == intval(1)) {
                $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R50-" . $image_name;
            }

            ?>

                    <tr class="expiredCoupons trhover">
                        <td align="center" width="3%">
                            <input type="checkbox" class="cb-element" name="chk[]"
                                value="<?php echo $resources_id; ?>" />
                        </td>

                        <td align="center">
                            <div id="INPROCESS_STATUS_1_<?php echo $resources_id; ?>" style="display: none;"></div>
                            <div id="INPROCESS_STATUS_2_<?php echo $resources_id; ?>">
                                <a href="javascript:void(0);" value="<?php echo $resources_id; ?>"
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
                            <h3 class="couponType" style="max-width: 100%;">
                                <a class="previewBookReview" href="javascript: void(0);"
                                    bid=<?php echo $resources_id; ?>><?php echo $resources_name; ?></a>
                            </h3>
                        </td>
                        <td>
                            <?php echo $date_display; ?>

                        </td>
                        <td align='center'>
                            <?php if ($DISPLAY_IMG != '') {?>
                            <img src="<?php echo $DISPLAY_IMG; ?>" alt="" width="30" height="30" />
                            <?php }?>
                        </td>

                        <td align="center">
                            <div id="INPROCESS_DELETE_1_<?php echo $resources_id; ?>" style="display: none;"></div>
                            <div id="INPROCESS_DELETE_2_<?php echo $resources_id; ?>">
                                <a href="<?php echo PAGE_MAIN; ?>?ID=<?php echo base64_encode(intval($resources_id)); ?>"
                                    class="modifyData img_btn">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0"
                                        title="Modify" alt="Modify" />
                                </a>
                                <?php
if (intval($CHK) == intval(0)) {
                ?>
                                <a href="javascript:void(0);" value="<?php echo $resources_id; ?>"
                                    class="deleteData img_btn">
                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0"
                                        title="Delete" alt="Delete" />
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

        $stmt = $dCON->prepare("Update " . RESOURCES_TBL . "  set status='DELETE' WHERE resources_id = ?");
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
    $stmt = $dCON->prepare("Update " . RESOURCES_TBL . "  set status='DELETE'  WHERE resources_id = ?");
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
    $STR .= " UPDATE  " . RESOURCES_TBL . "  SET ";
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE resources_id = :resources_id ";
    $sDEF = $dCON->prepare($STR);
    $sDEF->bindParam(":status", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":resources_id", $ID);
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