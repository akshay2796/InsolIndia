<?php
ob_start();
error_reporting(E_ALL);
session_start();

$PAGENAME = strtolower(basename($_SERVER['PHP_SELF']));


include("../library_insol/class.pdo.php");
include("../library_insol/class.inputfilter.php");
include("../library_insol/class.pagination.php");
include("../library_insol/function.php");
include("../global_functions.php");
include("ajax_session.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>fav-icon.png" rel="shortcut icon" type="image/png" />
<title><?php echo $_SESSION["COMPANY_NAME"]; ?></title>


<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>style.css" />
<!-- Add jQuery library -->

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-1.10.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.validate-latest.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!-- Add JQuery cookie plugin (optional) -->
<script src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.navgoco.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>script.js"></script>

<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery.selectbox.css" type="text/css" rel="stylesheet" />
<script language="javascript"  type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery.selectbox-0.2.js"></script>

<!-- Fancy Select Box -->
<link href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>fancy-select/fancy-select.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>fancy-select.js"></script> 

<script language="javascript" type="text/javascript">
$(document).ready(function(){    
    $(".chzn-select").select2();     
});

</script>

<!--[if lt IE 9]>
<script src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>html5shiv.js"></script>
<![endif]-->


<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>ipad.css" media="screen and (min-width:701px) and (max-width:1000px)" />
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>tablet.css" media="screen and (min-width:501px) and (max-width:700px)" />
<link rel="stylesheet" type="text/css" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>mobile.css" media="screen and (min-width:100px) and (max-width:500px)" />

</head>
<div id="mainWrapper" <?php if($SHOW_PREVIEW =="YES"){echo "class='editMode'";} ?>>
    <div class="topHeader">
    	<div class="logo"><a href="index.php"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>logo_index.png" class="maxImg"/></a></div>
        <a href="javascript:void(0);" class="menuBtn"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/nav.png" alt="MENU" /></a>
        
        <div id="headerRight">
            <ul class="topLink">
            	<li class="loginBoxLi"><a href="#/" class="topBtn loginBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/loginUser.png" alt="Login User"/>Admin</a></li>
            	<li><a href="change_password.php" class="topBtn iconOnly" alt="Change Password" title="Change Password"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/password.png" alt="Change Password"/></a></li>
                <li><a href="logout.php" class="topBtn iconOnly" alt="Log Out" title="Log Out"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/logout.png" alt="Log Out"/></a></li>
            </ul>
        </div><!--headerRight end--> 
    </div><!--topHeader end -->
    	
    <?php include("menu.php"); ?>  
    <div id="container" class="mainWrapper">