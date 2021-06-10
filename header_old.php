<?php
error_reporting(E_ALL);
session_start();
include "library_insol/class.pdo.php";
include "library_insol/class.pagination_refresh_based.php";
include "library_insol/class.inputfilter.php";
include "library_insol/function.php";
include "global_functions.php";

$PAGENAME = strtolower(basename($_SERVER['PHP_SELF']));
$page_name = basename($_SERVER['PHP_SELF']);

include 'meta.php';

if ($_SESSION["url_rewrite"] == '1') {
    $_SESSION['INCLUDE_QMARK'] = "?";
} else {
    $_SESSION['INCLUDE_QMARK'] = "&";
}

if (isset($_SESSION['UID_INSOL']) && intval($_SESSION['UID_INSOL']) > intval(0)) {
    define("LOGGED_IN", "YES");
} else {
    define("LOGGED_IN", "NO");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="theme-color" content="#0aaecd">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#0aaecd" />
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#0aaecd" />

    <title><?php echo $METATITLE; ?></title>
    <meta name="description" content="<?php echo $METADESCRIPTION; ?>" />
    <meta name="keywords" content="<?php echo $METAKEYWORD; ?>" />

    <link rel="icon" type="image/png" href="<?php echo SITE_ROOT ?>images_insol/favicon_icon.png">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,400i,600,600i,700,700i,800" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/font-awesome.min.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/slick.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/lightgallery.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/main.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/responsive.css" />

    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/lightgallery.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/lg-video.min.js"></script>
    <script>
    $(document).ready(function() {
        $(".hamburger").click(function(event) {
            $(this).toggleClass('h-active');
            $(".main_menu").toggleClass('slidenav');
        });
    });
    </script>
    <script>
    (function(i, s, o, g, r, a, m) {
        i['GoogleAnalyticsObject'] = r;
        i[r] = i[r] || function() {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
        a = s.createElement(o),
            m = s.getElementsByTagName(o)[0];
        a.async = 1;
        a.src = g;
        m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');
    ga('create', 'UA-39282487-37', 'auto');
    ga('send', 'pageview');
    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-164784509-1"></script>
    <script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-164784509-1');
    </script>

</head>



<body>

    <div class="main-wrapper">
        <header class="clearfix main_header">
            <div class="sub_menu_bg">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 topBarTxt">
                            <span>TWENTY YEARS OF THOUGHT LEADERSHIP IN INSOLVENCY</span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">

                            <nav class="sub_menu">
                                <ul>
                                    <?php if (LOGGED_IN == "YES") {?>
                                    <li style="position: relative">
                                        <a href="<?php echo SITE_ROOT . urlRewrite("myaccount.php"); ?>"
                                            class="btn-myaccount myaccountButton">My Account</a>
                                    </li>

                                    <li><a href="<?php echo SITE_ROOT . "logout.php"; ?>"></i>Logout</a></li>
                                    <?php
} else {?>

                                    <li style="position: relative;">
                                        <a href="<?php echo SITE_ROOT ?>login"
                                            class="btn-myaccount myaccountLogin">Member Login</a>
                                    </li>
                                    <?php
}
?>


                                    <li>
                                        <a href="<?php echo SITE_ROOT . urlRewrite("media.php"); ?>">Media </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_ROOT . urlRewrite("gallery.php"); ?>">Gallery</a>
                                    </li>
                                    <li class="main_menu">

                                        <ul>
                                            <li class="menu_item">
                                                <a href="<?php echo SITE_ROOT . urlRewrite("events.php"); ?>"
                                                    style="color:#fff;padding: 10px 0px;font-weight: normal;font-size: 12px;">Events
                                                    & Webinar</a>
                                                <ul class="menu_dropdown">
                                                    <li>
                                                        <a href="<?php echo SITE_ROOT . urlRewrite("events.php"); ?>">All
                                                            Events</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo SITE_ROOT ?>events?event=upcoming">Upcoming
                                                            Events</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo SITE_ROOT; ?>events?event=past">Past
                                                            Events</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>

                                    </li>


                                    <li>
                                        <a href="<?php echo SITE_ROOT . urlRewrite("news.php"); ?>">News</a>
                                    </li>
                                </ul>

                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="main_menu_bg">
                <div class="container">
                    <div class="col-md-3 col-sm-4 col-xs-9 main_menu_logo">
                        <a href="<?php echo SITE_ROOT; ?>">
                            <img src="<?php echo SITE_ROOT ?>images_insol/logo.jpg" alt="" title="">
                        </a>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-3 main_menu_text">
                        <nav class="main_menu">
                            <ul>
                                <li class="menu_item">
                                    <a href="<?php echo SITE_ROOT ?>insol-india.php">INSOL India</a>
                                    <ul class="menu_dropdown">
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>history.php">History &amp; Restructuring</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>vision-mission.php">Vision &amp; Mission</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT; ?>goals.php">Goals</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT; ?>strenghts.php">Strengths</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>legal-status.php">Legal Status</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="menu_item">
                                    <a href="<?php echo SITE_ROOT ?>governance.php">Governance</a>
                                    <?php
$SQL1 = "";
$SQL1 .= " SELECT * FROM " . GOVERNANCE_TYPE_TBL . " as G ";
$SQL1 .= " WHERE status = 'ACTIVE' order by position ASC  ";
$stmt1 = $dCON->prepare($SQL1);
$stmt1->execute();
$dsTYPE = $stmt1->fetchAll();
$numTYPE = count($dsTYPE);
?>
                                    <ul class="menu_dropdown">
                                        <?php
if ($numTYPE > intval(0)) {
    foreach ($dsTYPE as $mLIST) {
        $typeID = (stripslashes($mLIST['type_id']));
        $typeURLKEY = (stripslashes($mLIST['url_key']));
        $typeNAME = (stripslashes($mLIST['type_name']));

        $rsSUBTYPE = getDetails(GOVERNANCE_SUBTYPE_TBL, '*', "status~~~type_id", "ACTIVE~~~$typeID", '=~~~=~~~=', '', '', "");
        $countSUBTYPE = "";
        $countSUBTYPE = count($rsSUBTYPE);

        if ($countSUBTYPE == intval(0)) {
            $masterURL = SITE_ROOT . urlRewrite("governance_list.php", array("url_key" => $typeURLKEY));
        }

        ?>

                                        <li <?php if ($countSUBTYPE > intval(0)) {echo 'class="menu_sub_item"';}?>>
                                            <a
                                                href="<?php if ($countSUBTYPE == intval(0)) {echo $masterURL;} else {echo '#';}?>"><?php echo $typeNAME; ?></a>
                                            <?php
if ($countSUBTYPE > intval(0)) {
            ?>
                                            <ul class="menu_sub_dropdown">
                                                <?php
foreach ($rsSUBTYPE as $sbLIST) {
                $subtypeNAME = htmlentities((stripslashes($sbLIST['subtype_name'])));
                $subURLKEY = (stripslashes($sbLIST['url_key']));
                $masterURL = SITE_ROOT . urlRewrite("governance_sub_list.php", array("master_url" => $typeURLKEY, "url_key" => $subURLKEY));
                ?>
                                                <li>
                                                    <a href="<?php echo $masterURL; ?>"><?php echo $subtypeNAME; ?></a>
                                                </li>
                                                <?php
}
            ?>
                                            </ul>
                                            <?php
}

        ?>
                                        </li>
                                        <?php
}

}

?>

                                    </ul>
                                    <!--============================old style Menu
                                    <ul class="menu_dropdown">
                                    	<li>
                                        	<a href="<?php echo SITE_ROOT . urlRewrite("executive-committee.php"); ?>">Executive Committee</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo SITE_ROOT . urlRewrite("board_governor.php"); ?>">Board of Governors</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT . urlRewrite("judges_advisory_roundtable.php"); ?>">Judges Advisory Board</a>
                                        </li>
                                        <li>

                                        	<a href="<?php echo SITE_ROOT . urlRewrite("academic_committees.php"); ?><?php //echo "#" . $masterTYPEDIV; ?>">Academics Committee</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT . urlRewrite("young-members-committee.php"); ?>">Young Practitioner's Committee</a>
                                        </li>
                                        <li class="menu_sub_item">
                                        	<a href="<?php //echo SITE_ROOT . urlRewrite("executive-committee.php"); ?>">INSOL Committees</a>

                                        	<ul class="menu_sub_dropdown">
												<li>
													<a href="<?php //echo SITE_ROOT ?>">National Committee for Regional Affairs</a>
												</li>
												<li>
													<a href="<?php //echo SITE_ROOT ?>">Finance Committee</a>
												</li>
												<li>
													<a href="<?php //echo SITE_ROOT ?>">Academics Committee</a>
												</li>
												<li>
													<a href="<?php //echo SITE_ROOT ?>">Young Practitioner's Committee</a>
												</li>
											</ul>

                                        </li>

                                    </ul> -->
                                </li>


                                <li class="menu_item">
                                    <a href="#">Projects</a>
                                    <?php
$SQLp = "";
$SQLp .= " SELECT * FROM " . PROJECTS_TBL . " as P ";
$SQLp .= " WHERE status = 'ACTIVE' and projects_title !='' order by position ASC ";

$stmt1 = $dCON->prepare($SQLp);
$stmt1->execute();
$rsLIST = $stmt1->fetchAll();
$dA = count($rsLIST);
$stmt1->closeCursor();
?>
                                    <ul class="menu_dropdown">
                                        <?php
if ($dA > intval(0)) {
    foreach ($rsLIST as $rLIST) {
        $masterID = "";
        $masterTITLE = "";
        $url_key = "";
        $masterID = intval($rLIST['projects_id']);
        $masterTITLE = htmlentities(stripslashes($rLIST['projects_title']));
        $url_key = stripslashes($rLIST['url_key']);
        $masterURL = SITE_ROOT . urlRewrite("projects_detail.php", array("url_key" => $url_key));
        ?>
                                        <li>
                                            <a href="<?php echo $masterURL; ?>"><?php echo $masterTITLE; ?></a>
                                        </li>
                                        <?php
}
}
?>
                                        <!-- <li>
                                        	<a href="<?php echo SITE_ROOT ?>IBC-implementation-report.php">IBC Implementation Report</a>
                                        </li>

                                        <li>
                                        	<a href="<?php echo SITE_ROOT ?>designing-insolvency-courses-for-law-schools.php">Seminar Course for Law Schools</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo SITE_ROOT ?>best-practices-task-force-with-sipi.php">Best Practices Task Force with SIPI</a>
                                        </li>
                                        <li>
                                        	<a href="<?php echo SITE_ROOT ?>advocacy.php">Advocacy</a>
                                        </li> -->


                                    </ul>
                                </li>
                                <li class="menu_item">
                                    <a href="<?php echo SITE_ROOT ?>sipi.php">SIPI</a>
                                </li>
                                <li class="menu_item">
                                    <a href="<?php echo SITE_ROOT ?>insol-international.php">INSOL International</a>
                                </li>
                                <li class="menu_item">
                                    <a href="<?php echo SITE_ROOT . urlRewrite('sig24.php'); ?>">SIG 24</a>
                                </li>
                                <li class="menu_item">
                                    <a href="#/">Membership</a>
                                    <ul class="menu_dropdown">
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>criteria.php">Criteria</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>benefits.php">Benefits</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>become-member.php">Become a Member</a>
                                        </li>
                                        <li>
                                            <?php
if (LOGGED_IN == "YES") {
    ?>
                                            <!--a href="<?php echo SITE_ROOT . "members.php"; ?>"-->
                                            <a href="<?php echo SITE_ROOT . urlRewrite("members.php") ?>">
                                                <?php
} else {
    ?>
                                                <a
                                                    href="<?php echo SITE_ROOT . urlRewrite("login.php") . $_SESSION['INCLUDE_QMARK'] . "ref=members"; ?>">
                                                    <?php
}
?>
                                                    Membership Directory</a>
                                        </li>
                                    </ul>
                                </li>

                                <?php
if ($PAGENAME == 'index.php') {
    ?>
                                <li class="menu_item">
                                    <a href="resource-list.php">Resources</a>
                                </li>
                                <?php
} else {

    $SQL_CAT = "";
    $SQL_CAT .= " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE `status` = 'ACTIVE' ";
    $SQL_CAT .= " ORDER BY position ASC ";
    $stmtL_Cat = $dCON->prepare($SQL_CAT);
    $stmtL_Cat->execute();
    $rowCat = $stmtL_Cat->fetchAll();
    $stmtL_Cat->closeCursor();
    //echo count($rowCat);
    if (intval(count($rowCat)) > intval(0)) {
        ?>
                                <li class="menu_item">
                                    <a href="#/">Resources</a>
                                    <ul class="menu_dropdown" style="right: 0 ">
                                        <li>
                                            <a href="https://insolindia.com/newsletter">Newsletter</a>
                                        </li>
                                        <?php
foreach ($rowCat as $rsCat) {
            $R_cat_id = "";
            $R_cat_name = "";
            $R_cat_url_key = "";

            $R_cat_id = intval($rsCat['category_id']);
            $R_cat_name = stripslashes($rsCat['category_name']);
            $R_cat_url_key = stripslashes($rsCat['url_key']);
            $R_cat_url = SITE_ROOT . urlRewrite("resources.php", array("cat_url_key" => $R_cat_url_key));
            ?>
                                        <li>
                                            <a href="<?php echo $R_cat_url; ?>"><?php echo $R_cat_name; ?></a>
                                        </li>
                                        <?php
}
        ?>
                                        <!--li>
                                                	<a href="<?php echo SITE_ROOT ?>law-regulations-and-rules.php">Law, Regulations and Rules</a>
                                                </li>
                                            	<li>
                                                	<a href="<?php echo SITE_ROOT ?>reports.php">Reports</a>
                                                </li>
                                            	<li>
                                                	<a href="<?php echo SITE_ROOT ?>articles.php">Articles</a>
                                                </li>
                                            	<li>
                                                	<a href="<?php echo SITE_ROOT ?>papers.php">Papers</a>
                                                </li>
                                            	<li>
                                                	<a href="<?php echo SITE_ROOT ?>blogs.php">Blogs</a>
                                                </li-->
                                    </ul>
                                </li>
                                <?php
}
}
?>
                            </ul>
                        </nav>
                    </div>

                    <!--==============Responsive Menu=============-->
                    <div class="hamburger">
                        <span class="h-top"></span>
                        <span class="h-middle"></span>
                        <span class="h-bottom"></span>
                    </div>
                    <!--==============END Responsive Menu=============-->

                </div>
            </div>

        </header>
    </div>