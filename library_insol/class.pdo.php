<?php
session_start();
//header('Content-Type: text/html; charset=ISO-8859-1');
header('Content-Type: text/html; charset=utf-8');
$timezone = "Asia/Kolkata";
date_default_timezone_set($timezone);

define("CURRENT_TIME", date('H:i:s', time()));
define("TODAY_DATE", date('Y-m-d'));

/*============== Define Tables ===================*/

define("ADMIN_TBL", " tbl_admin ");
define("SITESETTING_TBL", " tbl_sitesetting ");
define("PRESIDENT_TBL", " tbl_president ");
define("EXECUTIVE_COMMITTEE_TBL", " tbl_executive_committee ");
define("BOARD_GOVERNORS_TBL", " tbl_board_governors ");
define("JUDGES_ADVISORY_ROUNDTABLE_TBL", " tbl_judges_advisory_roundtable ");
define("COMMITTEES_TBL", " tbl_committees ");
define("COMMITTEES_TYPE_TBL", " tbl_committee_type ");
define("MEMBER_TBL", " tbl_member ");
define("MEMBER_TYPE_TBL", " tbl_member_type ");
define("YOUNG_MEMBER_COMMITTEE_TBL", " tbl_young_member_committee ");

define("MEDIA_CATEGORY_TBL", " tbl_media_category ");
define("MEDIA_TBL", " tbl_media ");
define("MEDIA_IMAGES_TBL", " tbl_media_images ");

define("RESOURCES_CATEGORY_TBL", " tbl_resources_category ");
define("RESOURCES_TBL", " tbl_resources ");
define("RESOURCES_IMAGES_TBL", " tbl_resources_images ");

define("GALLERY_TBL", " tbl_gallery ");
define("GALLERY_IMAGES_TBL", " tbl_gallery_images ");

define("EVENT_TBL", " tbl_event ");
define("EVENT_IMAGES_TBL", " tbl_event_images ");

define("NEWS_TBL", " tbl_news ");
//define("REGISTERED_MEMBER_TBL", " tbl_registered_member ");

define("BECOME_MEMBER_TBL", " tbl_become_member ");
define("USER_TBL", " tbl_user ");

define("SIG24_TBL", " tbl_sig24 ");
define("SIG24_INTRO_TBL", " tbl_sig24_intro ");

define("NEWSLETTER_INTRO_TBL", " tbl_newsletter_intro ");
define("NEWSLETTER_EDITOR_TBL", " tbl_newsletter_editor ");
define("NEWSLETTER_PRESIDENT_TBL", " tbl_newsletter_president ");

define("NEWSLETTER_SPONSOR_TBL", " tbl_newsletter_sponsor ");

define("NEWSLETTER_TBL", " tbl_newsletter");
define("NEWSLETTER_EVENT_TBL", " tbl_newsletter_event");
define("NEWSLETTER_NEWS_TBL", " tbl_newsletter_news");
define("NEWSLETTER_RESOURCES_TBL", " tbl_newsletter_resources");

define("PROJECTS_TBL", " tbl_projects");
define("PROJECTS_LOGO_IMAGES_TBL", " tbl_projects_logo_images");

define("GOVERNANCE_TYPE_TBL", " tbl_governance_type");
define("GOVERNANCE_SUBTYPE_TBL", " tbl_governance_subtype");
define("GOVERNANCE_TBL", " tbl_governance");

define("DRAFT_BEST_PRACTICES_TBL", " tbl_draft_best_practices");
define("DRAFT_BEST_PRACTICES_INTRO_TBL", " tbl_draft_best_practices_intro");

define("GENERAL_UPLOAD_TBL", " tbl_general_newsletter");
define("SOCIALMEDIA_TBL", " tbl_socialmedia");
define("TEST_EMAIL_TBL", " tbl_test_email");
define("EVENT_JOINER_TBL", " tbl_event_joiner");

//echo trim($_SERVER['HTTP_HOST']);

$MYLINK = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$MYNAME = explode("/", $MYLINK);
$_SESSION["MYHOST"] = $MYNAME[2];
$_SESSION["MYNAME"] = $MYNAME[3];
//echo $MYLINK . "<BR>";
//echo $_SESSION["MYHOST"] . "<BR>";
//echo $_SESSION["MYNAME"] . "<BR>";

/*============== Define Database Connection ===================*/
if (($_SERVER["HTTP_HOST"] == "idsweb") || ($_SERVER["HTTP_HOST"] == "localhost") || ($_SERVER["HTTP_HOST"] == "localhost:82") || ($_SERVER['HTTP_HOST'] == "122.160.48.232") || (trim($_SERVER['HTTP_HOST']) == "192.168.1.111")) {
    define("FOLDERNAME", "insolindia");
    $dCON = new PDO("mysql:host=localhost;port=3306;dbname=insolindia", "root", "root");
    $dCON->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $dCON->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    //$dCON->exec('set NAMES  utf8 collate utf8_bin');
} else {
    $dCON = new PDO("mysql:host=localhost;dbname=sabsoin_insol_india","sabsoin_ins_user","Yrs[aidZ&8gA");
    $dCON->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $dCON->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
    //$dCON->exec('set NAMES  utf8 collate utf8_bin');
}
/*============== Get Site Settings ===================*/

$st_SS = $dCON->prepare(" SELECT * FROM " . SITESETTING_TBL);
$st_SS->execute();
$row_SS = $st_SS->fetchAll();

$_SESSION["COMPANY_NAME"] = htmlentities(stripslashes($row_SS[0]['company_name']));

$_SESSION["DOMAIN_NAME"] = stripslashes($row_SS[0]['domain_name']);
if (($_SERVER["HTTP_HOST"] == "idsweb") || ($_SERVER["HTTP_HOST"] == "localhost") || ($_SERVER['HTTP_HOST'] == "122.160.48.232") || ($_SERVER['HTTP_HOST'] == "144.139.211.192") || (trim($_SERVER['HTTP_HOST']) == "192.168.1.111")) {

} else {
    $DOMAIN_NAME = str_replace("http://www.", "", $_SESSION["DOMAIN_NAME"]);
    $DOMAIN_NAME = str_replace("http://www", "", $DOMAIN_NAME);
    $DOMAIN_NAME = str_replace("www.", "", $DOMAIN_NAME);
    $DOMAIN_NAME = str_replace("http://", "", $DOMAIN_NAME);
    $DOMAIN_NAME = str_replace("/", "", $DOMAIN_NAME);
    $_SESSION["DOMAIN_NAME"] = $DOMAIN_NAME;
}

$_SESSION["SMTP"] = stripslashes($row_SS[0]['smtp']); // "mail.iws.in"; // SMTP server

$_SESSION["AUTH_EMAIL_USERNAME"] = stripslashes($row_SS[0]['auth_email_username']);
$_SESSION["AUTH_EMAIL_PASSWORD"] = stripslashes($row_SS[0]['auth_email_password']);
$_SESSION["AUTH_EMAIL"] = stripslashes($row_SS[0]['auth_email']);

$_SESSION["INFO_EMAIL"] = stripslashes($row_SS[0]['info_email']);
$_SESSION["TO_EMAIL"] = stripslashes($row_SS[0]['to_email']);
$_SESSION["CC_EMAIL"] = stripslashes($row_SS[0]['cc_email']);
$_SESSION["BCC_EMAIL"] = stripslashes($row_SS[0]['bcc_email']);
$_SESSION["google_analytics"] = stripslashes($row_SS[0]['google_analytics']);

$_SESSION["url_rewrite"] = intval($row_SS[0]['url_rewrite']); //0;
//$_SESSION["url_rewrite"] = 0;

$_SESSION["COMPANY_PHONE1"] = stripslashes($row_SS[0]['company_phone1']);
$_SESSION["COMPANY_PHONE2"] = stripslashes($row_SS[0]['company_phone2']);
$_SESSION["COMPANY_WEB"] = stripslashes($row_SS[0]['company_website']);

//########## DEFAULT META TILTE & ANOTHER SEO  VARIABLES ###############
$_SESSION['DEFAULT_META_TITLE'] = stripslashes($row_SS[0]['default_meta_title']);
$_SESSION['DEFAULT_META_KEYWORD'] = stripslashes($row_SS[0]['default_meta_keyword']);
$_SESSION['DEFAULT_META_DESCRIPTION'] = stripslashes($row_SS[0]['default_meta_description']);

// GENERAL PATH SETTING ==============

if (($_SERVER["HTTP_HOST"] == "localhost") || ($_SERVER["HTTP_HOST"] == "localhost:82") || ($_SERVER["HTTP_HOST"] == "idsweb") || ($_SERVER['HTTP_HOST'] == "122.160.48.232") || (trim($_SERVER['HTTP_HOST']) == "192.168.1.111")) {
    define("SITE_ROOT", "/" . FOLDERNAME . "/");
    define("SITE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/" . FOLDERNAME . "/");
    define("SITE_IMAGES", "http://" . $_SERVER['HTTP_HOST'] . "/" . FOLDERNAME . "/images_insol/");
    define("SITE_JS", "http://" . $_SERVER['HTTP_HOST'] . "/" . FOLDERNAME . "/js_insol/");
    define("SITE_CSS", "http://" . $_SERVER['HTTP_HOST'] . "/" . FOLDERNAME . "/css_insol/");
    define("SITE_FONT", "http://" . $_SERVER['HTTP_HOST'] . "/" . FOLDERNAME . "/fonts/");
    define("PRINT_PATH", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("CMS_UPLOAD_FOLDER_ABS", "/" . FOLDERNAME . "/uploads_insol/");
    define("CMS_UPLOAD_FOLDER_ABSOLUTE_PATH", "/" . FOLDERNAME . "/uploads_insol/");
    define("MODULE_FILE_FOLDER", "/" . FOLDERNAME . "/uploads_insol/");

} else {
    define("SITE_ROOT", "/");
    define("SITE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/");
    define("SITE_IMAGES", "http://" . $_SERVER['HTTP_HOST'] . "/images_insol/");
    define("SITE_JS", "http://" . $_SERVER['HTTP_HOST'] . "/js_insol/");
    define("SITE_CSS", "http://" . $_SERVER['HTTP_HOST'] . "/css_insol/");
    define("SITE_FONT", "http://" . $_SERVER['HTTP_HOST'] . "/fonts/");
    define("PRINT_PATH", "http://" . $_SERVER['HTTP_HOST']);
    define("CMS_UPLOAD_FOLDER_ABS", "/uploads_insol/");
    define("CMS_UPLOAD_FOLDER_ABSOLUTE_PATH", "/uploads_insol/");
    define("MODULE_FILE_FOLDER", "/uploads_insol/");

}

define("CMS_UPLOAD_FOLDER_RELATIVE_PATH", "../uploads_insol/");
define("CMS_UPLOAD_FOLDER_REL", "../uploads_insol/");
define("SITE_UPLOAD_FOLDER_RELATIVE_PATH", "uploads_insol/");
define("SITE_UPLOAD_FOLDER_ABSOLUTE_ROOT", SITE_URL . "uploads_insol/");
define("SITE_UPLOAD_RELATIVE_PATH", "uploads_insol/");
define("SITE_UPLOAD_ABSOLUTE_ROOT", SITE_URL . "uploads_insol/");
///============ FOR MODULES ==============
define("CMS_INCLUDES_RELATIVE_PATH", "../includes_insol/");
define("CMS_INCLUDES_IMAGES_RELATIVE_PATH", "../includes_insol/images/");
define("CMS_INCLUDES_ICON_RELATIVE_PATH", "../includes_insol/images/cms-icon/");
define("CMS_INCLUDES_JS_RELATIVE_PATH", "../includes_insol/js/");
define("CMS_INCLUDES_CSS_RELATIVE_PATH", "../includes_insol/css/");
define("MODULE_RELATIVE_ROOT", SITE_ROOT);
define("MODULE_CMS_INCLUDE", "includes_insol/");
define("MODULE_UPLOADIFY_ROOT", "uploads_insol/");
define("MODULE_INCLUDES_ICON_RELATIVE_PATH", "includes_insol/images/cms-icon/");
/*============== Other Constants ===================*/
$_SESSION["UNUTHORISED"] = "<span class='mainheadPink'>Unauthorised Link... Please Try Again !!!</span>";
/*============== FOLDERS SESSION LOGINS ===================*/

define("FOLDER_UPLOAD", "upload_insol");
define("TEMP_UPLOAD", "temp_upload");
define("FLD_PRESIDENT", "president");
define("FLD_EXECUTIVE_COMMITTEE", "executive_committee");
define("FLD_BOARD_GOVERNORS", "board_governors");
define("FLD_YOUNG_MEMBER_COMMITTEE", "young_member_committee");
define("FLD_JUDGES_ADVISORY_ROUNDTABLE", "judges_advisory_roundtable");
define("FLD_COMMITTEES", "committees");
define("FLD_MEMBER_DIRECTORY", "member_directory");

define("FLD_MEDIA", "media");
define("FLD_MEDIA_IMG", "images");
define("FLD_MEDIA_VDO", "videos");
define("FLD_MEDIA_FILE", "files");

define("FLD_RESOURCES", "resources");
define("FLD_RESOURCES_IMG", "images");
define("FLD_RESOURCES_VDO", "videos");
define("FLD_RESOURCES_FILE", "files");

define("FLD_GALLERY", "gallery");
define("FLD_GALLERY_IMG", "images");

define("FLD_EVENT", "event");
define("FLD_EVENT_IMG", "images");
define("FLD_EVENT_VDO", "videos");
define("FLD_EVENT_FILE", "files");

define("FLD_NEWS", "news");
define("FLD_SIG24", "sig24");
define("FLD_NEWSLETTER_SPONSOR", "newsletter_sponsor");
define("FLD_NEWSLETTER_EDITOR", "newsletter_editor");
define("FLD_NEWSLETTER_PRESIDENT", "newsletter_president");

define("FLD_NEWSLETTER", "newsletter");

define("FLD_PROJECTS", "projects");
define("FLD_PROJECTS_LOGO_IMG", "logo_images");
define("FLD_PROJECTS_FILE", "files");
define("FLD_HOMEPAGE_IMAGE", "homepage_image");

define("FLD_GOVERNANCE", "governance");
define("FLD_DRAFT_BEST_PRACTICES", "draft_best_practices");
define("FLD_DRAFT_BEST_PRACTICES_IMG", "images");
define("FLD_DRAFT_BEST_PRACTICES_FILE", "files");

define("FLD_NEWSLETTER_CONTRIBUTE", "uploads_insol/newsletter_contribute");
define("FLD_PAYMENT_RECIEPT", "payment_reciept");

if (!is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH)) {
    $mask = umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH, 0777);
    umask($mask);
}

if (!is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD)) {
    $mask = umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD, 0777);
    umask($mask);
}

/*============== Define Module Name / Constants  ===================*/

$_SESSION["EMAIL_FOOTER"] = "";
$_SESSION["EMAIL_FOOTER"] .= "<BR>";
$_SESSION["EMAIL_FOOTER"] .= "xxxxxxxxx";
$_SESSION["EMAIL_FOOTER"] .= "<BR>";
$_SESSION["EMAIL_FOOTER"] .= "Tel: xxxxxxxxx";
$_SESSION["EMAIL_FOOTER"] .= "<BR>";
$_SESSION["EMAIL_FOOTER"] .= "<a href='mailto:xxxxxxxxx'>xxxxxxxxx</a>";
$_SESSION["EMAIL_FOOTER"] .= "<BR>";

/*============== Define Different Upload File Formats  ===================*/

$_SESSION['GALLERY_IMG_ALLOWED_FORMATS'] = "jpg,jpeg,pjpeg,gif,png";
$_SESSION['GALLERY_IMG_UPLOAD_FILE_SIZE'] = '5MB';

$_SESSION['EVENT_IMG_ALLOWED_FORMATS'] = "jpg,jpeg,pjpeg,gif,png";
$_SESSION['EVENT_IMG_UPLOAD_FILE_SIZE'] = '5MB';

$_SESSION['MEDIA_IMG_ALLOWED_FORMATS'] = "jpg,jpeg,pjpeg,gif,png";
$_SESSION['MEDIA_IMG_UPLOAD_FILE_SIZE'] = '5MB';

$_SESSION['RESOURCES_IMG_ALLOWED_FORMATS'] = "jpg,jpeg,pjpeg,gif,png";
$_SESSION['RESOURCES_IMG_UPLOAD_FILE_SIZE'] = '5MB';

$_SESSION['IMAGE_ALLOWED_FORMATS'] = "jpg,jpeg,pjpeg,gif,png";
$_SESSION['IMAGE_ALLOWED_FORMATS_IMG'] = '<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'jpg.gif" border="0" alt="jpg | jpeg | pjpeg"  title="jpg | jpeg | pjpeg" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'gif.gif" border="0" alt="gif"  title="gif" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'png.gif" border="0" alt="png"  title="png" >';
$_SESSION['IMAGE_UPLOAD_FILE_SIZE'] = '5MB';

$_SESSION['FILE_ALLOWED_FORMATS'] = "jpeg,jpg,gif,png,doc,docx,ppt,pptx,txt,pdf,xls,xlsx";
$_SESSION['FILE_ALLOWED_FORMATS_IMG'] = '<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'doc.gif" border="0" alt="doc | docx"  title="doc | docx" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'txt.gif" border="0" alt="txt"  title="txt" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'ppt.gif" border="0" alt="ppt" title="ppt" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'pdf.gif" border="0" alt="pdf" title="pdf" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'jpg.gif" border="0" alt="jpg | jpeg | gif | png" title="jpg | jpeg | gif | png" >&nbsp;<img src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'xls.gif" border="0" alt="xls | xlsx" title="xls | xlsx">';
$_SESSION['FILE_UPLOAD_FILE_SIZE'] = '5MB';

/*============== Constants ===================*/

$_SESSION["DELETE_NOTE"] = "<span style='color: #ff0000;' class='small'>Note: You can only delete items which do not have any data added under them.</span>";

$_SESSION["URL_KEY_TEXT"] = "<span class='instructions'>Use Below Tags to Enhance User Experience and Improve SEO</span>";
$_SESSION["SOCIALMEDIA_ICON_SIZE_TEXT"] = "<span class='instructions'>Icon sizes should be 22X22 pixels</span>";
$_SESSION["URL_EXAMPLE"] = "<span class='instructions'> ie : http://www.abc.com </span>";