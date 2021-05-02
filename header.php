<?php
error_reporting(0);
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
    <meta charset=" utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="theme-color" content="#0aaecd">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#0aaecd" />
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#0aaecd" />

    <title><?php echo $METATITLE; ?></title>

    <meta name="description" content="<?php echo $METADESCRIPTION; ?>" />
    <meta name="keywords" content="<?php echo $METAKEYWORD; ?>" />

    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_ROOT ?>images_insol/favicon_icon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Vendor Styles -->
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/vendor/owl-carousel/dist/assets/owl.carousel.min.css"
        type="text/css" media="all" />

    <!-- App Styles -->
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/style.css?ver=3" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/insol-v2.css?ver=1" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/formstyle.css" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/slick.css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/lightgallery.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/main.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/responsive.css" />
    <meta name="generatedon" content="2021-03-25 05:11:01">
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/lightgallery.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/lg-video.min.js"></script>
    <script type="text/javascript" async>
    jQuery(window).load(function() {
        // jQuery(".hameid-loader-overlay").fadeOut(500);
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
    <style>
    /* .hameid-loader-overlay {
        width: 100%;
        height: 100%;
        background: url('<?php echo SITE_ROOT ?>assets/images/spinner.gif') center no-repeat #FFF;
        z-index: 99999;
        position: fixed;
    } */
    </style>
    <script type="text/javascript" async>
    // Set timeout variables.
    var timoutWarning = 6600000; // Display warning in 55 Mins.
    var timoutNow = 7200000; // Timeout in 60 mins.
    var logoutUrl = '<?php echo SITE_ROOT ?>logout'; // URL to logout page.

    var warningTimer;
    var timeoutTimer;

    // Start timers.
    function StartTimers() {
        warningTimer = setTimeout("IdleWarning()", timoutWarning);
        timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
    }

    // Reset timers.
    function ResetTimers() {
        clearTimeout(warningTimer);
        clearTimeout(timeoutTimer);
        StartTimers();
        $("#timeout").hide();
    }

    // Show idle timeout warning dialog.
    function IdleWarning() {
        $("#timeout").show();
    }

    // Logout the user.
    function IdleTimeout() {
        window.location = logoutUrl;
    }
    </script>

</head>

<body>
    <!-- preloader-->
    <div class="hameid-loader-overlay"></div>

    <div id="timeout"
        style="display: none; margin: 20px; padding: 15px; border: 1px solid darkgrey; background-color: indianred;">
        <h1>Session About To Timeout</h1>
        <p>You will be automatically logged out in 5 minute.<br />
            To remain logged in move your mouse over this window.
    </div>

    <!-- App JS -->
    <div class="wrapper">

        <div class="intro">
            <ul class="arrows intro__arrows" style="display:none;">
                <li data-top="295" data-top-desktop="345"
                    style="border-color: transparent transparent transparent #e00026;"></li>

                <li data-top="362" data-top-desktop="412"
                    style="border-color: transparent transparent transparent #0e74b8;"></li>

                <li data-top="424" data-top-desktop="474"
                    style="border-color: transparent transparent transparent #7ba8d8;"></li>

                <li data-top="487" data-top-desktop="537"
                    style="border-color: transparent transparent transparent #e9ebec;"></li>
            </ul><!-- /.arrows -->

            <div class="intro__body">
                <header class="header">
                    <a href="#" class="btn-burger">
                        <span></span>

                        <span></span>

                        <span></span>
                    </a>

                    <div class="header__body">
                        <div class="shell">
                            <!-- /.header__body__inner -->
                        </div><!-- /.shell -->
                    </div><!-- /.header__body -->

                    <!-- <div class="header__bar fixed">-->
                    <div class="header__bar">
                        <div class="shell">
                            <div class="header__bar__inner">

                                <nav class="nav" style=" margin-left: 70px; z-index: 1000;">
                                    <ul id="mainMenu">
                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>">HOME</a>
                                        </li>
                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "governance.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>governance.php">GOVERNANCE</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "projects") !== false) {echo "active";}?>">
                                            <a
                                                href="<?php echo SITE_ROOT ?>projects/moot-competition-with-national-law-university-delhi">PROJECTS</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "sipi.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>sipi.php">SIPI</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "insol-international.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>insol-international.php">INSOL
                                                International</a>
                                        </li>

                                        <li class="<?php if (strpos($_SERVER['REQUEST_URI'], "SIG24") !== false) {echo "active";}?>"
                                            class="">
                                            <a href="<?php echo SITE_ROOT . urlRewrite('sig24.php'); ?>">SIG 24</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "benefits.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>benefits.php">Membership</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "resource-list.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>resource-list.php">Resources</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "gallery") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>gallery">GALLERY</a>
                                        </li>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "events") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>events">Events
                                                &amp; Webinars</a>
                                        </li>

                                    </ul>

                                    <ul>

                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "login") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>login">Login</a>
                                        </li>
                                        <li
                                            class="<?php if (strpos($_SERVER['REQUEST_URI'], "become-member.php") !== false) {echo "active";}?>">
                                            <a href="<?php echo SITE_ROOT ?>become-member.php">Register
                                            </a>
                                        </li>
                                        <!--<li>
                                                <a href="#" class="btn-search">Search</a>
                                            </li>-->
                                    </ul>
                                </nav><!-- /.nav -->

                                <div class="search search--fixed">
                                    <form action="?" method="get">
                                        <label for="f_search" class="hidden">Search</label>

                                        <input type="search" name="f_search" id="f_search" value="" placeholder="Search"
                                            class="search__field" />

                                        <input type="submit" value="GO" class="search__btn" />

                                        <i class="fa fa-search search__ico" aria-hidden="true"></i>
                                    </form>
                                </div><!-- /.search -->
                            </div><!-- /.header__bar__inner -->
                        </div><!-- /.shell -->
                    </div><!-- /.header__body -->

                    <a href="<?php echo SITE_ROOT ?>help" class="btn-help header__btn">
                        <br>Feedback<br>
                        <i class="ico-chevron-double-white"></i>
                    </a>
                </header><!-- /.header -->

                <div class="clearfix home_banner" style="padding-top: 70px; background-color: #23408C;">
                    <header class="header" style="display:none;">
                        <a href="#" class="btn-burger">
                            <span></span>

                            <span></span>

                            <span></span>
                        </a>

                        <div class="header__body">
                            <div class="shell">
                                <!-- /.header__body__inner -->
                            </div><!-- /.shell -->
                        </div><!-- /.header__body -->

                        <!-- <div class="header__bar fixed">-->
                        <div class="header__bar">
                            <div class="shell">
                                <div class="header__bar__inner">

                                    <nav class="nav" style=" margin-left: 70px; z-index: 1000;">
                                        <ul>
                                            <li class="active">
                                                <a href="<?php echo SITE_ROOT ?>">HOME</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>governance.php">GOVERNANCE</a>
                                            </li>

                                            <li>
                                                <a
                                                    href="<?php echo SITE_ROOT ?>projects/moot-competition-with-national-law-university-delhi">PROJECTS</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>sipi.php">SIPI</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>insol-international.php">INSOL
                                                    International</a>
                                            </li>

                                            <li class="">
                                                <a href="<?php echo SITE_ROOT . urlRewrite('sig24.php'); ?>">SIG 24</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>become-member.php">Membership</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>resource-list.php">Resources</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>gallery">GALLERY</a>
                                            </li>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>events">Events
                                                    &amp; Webinars</a>
                                            </li>
                                        </ul>

                                        <ul>

                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>login">Login</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo SITE_ROOT ?>become-member.php">Register
                                                </a>
                                            </li>
                                            <!--<li>
                                                <a href="#" class="btn-search">Search</a>
                                            </li>-->
                                        </ul>
                                    </nav><!-- /.nav -->

                                    <div class="search search--fixed">
                                        <form action="?" method="get">
                                            <label for="f_search" class="hidden">Search</label>

                                            <input type="search" name="f_search" id="f_search" value=""
                                                placeholder="Search" class="search__field" />

                                            <input type="submit" value="GO" class="search__btn" />

                                            <i class="fa fa-search search__ico" aria-hidden="true"></i>
                                        </form>
                                    </div><!-- /.search -->
                                </div><!-- /.header__bar__inner -->
                            </div><!-- /.shell -->
                        </div><!-- /.header__body -->

                        <a href="<?php echo SITE_ROOT ?>help" class="btn-help header__btn">
                            <br>Feedback<br>
                            <i class="ico-chevron-double-white"></i>
                        </a>
                    </header><!-- /.header -->
                </div>