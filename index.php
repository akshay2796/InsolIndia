<!-- insolindia.com Version 1.0 -->
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
<html lang="en" class=" js no-touch">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSOLINDIA</title>


    <link rel="shortcut icon" type="image/x-icon" href="<?php echo SITE_ROOT ?>images_insol/favicon_icon.png" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- Vendor Styles -->
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/vendor/owl-carousel/dist/assets/owl.carousel.min.css"
        type="text/css" media="all" />

    <!-- App Styles -->
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/style.css?ver=3" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/insol-v2.css?ver=1" type="text/css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>assets/css/formstyle.css" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css"
        type="text/css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/slick.css">
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/main.css" />
    <link rel="stylesheet" href="<?php echo SITE_ROOT ?>css_insol/responsive.css" />

    <meta name="generatedon" content="2021-03-25 05:11:01">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" type="text/javascript"></script>

    <script src="<?php echo SITE_ROOT ?>js_insol/lightgallery.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/lg-video.min.js"></script>
    <script type="text/javascript" async>
    jQuery(window).load(function() {
        jQuery(".hameid-loader-overlay").fadeOut(500);
    });
    </script>
    <style>
    .hameid-loader-overlay {
        width: 100%;
        height: 100%;
        background: url('<?php echo SITE_ROOT ?>assets/images/spinner.gif') center no-repeat #FFF;
        z-index: 99999;
        position: fixed;
    }
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
    <!-- Global Site Tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-107332215-1" type="text/javascript"></script>
    <script type="text/javascript" async>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments)
    };
    gtag('js', new Date());

    gtag('config', 'UA-107332215-1');
    </script>




</head>

<body>
    <!-- preloader-->
    <div class="hameid-loader-overlay"></div>
    <noscript>
        <style>
        .hameid-loader-overlay {
            display: none;
        }
        </style>
    </noscript>

    <div id="timeout"
        style="display: none; margin: 20px; padding: 15px; border: 1px solid darkgrey; background-color: indianred;">
        <h1>Session About To Timeout</h1>
        <p>You will be automatically logged out in 5 minute.<br />
            To remain logged in move your mouse over this window.
    </div>

    <!-- App JS -->
    <div class="wrapper">

        <div class="intro" style="display: none;">
            <ul class="arrows intro__arrows">
                <li data-top="295" data-top-desktop="345"
                    style="border-color: transparent transparent transparent #e00026;"></li>

                <li data-top="362" data-top-desktop="412"
                    style="border-color: transparent transparent transparent #0e74b8;"></li>

                <li data-top="424" data-top-desktop="474"
                    style="border-color: transparent transparent transparent #7ba8d8;"></li>

                <li data-top="487" data-top-desktop="537"
                    style="border-color: transparent transparent transparent #e9ebec;"></li>
            </ul><!-- /.arrows -->

            <div class="intro__inner">


            </div>

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
                                    <ul>
                                        <li class="active">
                                            <a href="<?php echo SITE_ROOT ?>">Home</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>about">About</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>membership">Membership</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>events">Events</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>library">Library</a>
                                        </li>

                                        <li class="">
                                            <a href="<?php echo SITE_ROOT ?>education">Education</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>fellows-home">Fellows</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>special-interest-group">Focus
                                                Groups</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>gthirtysix">G36</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>webinars-podcasts">Webinars
                                                &amp; Podcasts</a>
                                        </li>

                                    </ul>

                                    <ul>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>login">Login</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>register">Register
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



                <div class="intro__bar" style="display: none;">
                    <div class="shell">
                        <div class="intro__bar__inner">
                            <h6>Not Yet A Member? Find Out The <a href="<?php echo SITE_ROOT ?>membership/">Member
                                    Benefits <i class="ico-chevron-double-white"></i></a></h6>

                        </div><!-- /.slider__bar__inner -->
                    </div><!-- /.shell -->

                    <i class="arrow-big slider__ico"></i>
                </div><!-- /.slider__bar -->
            </div><!-- /.intro__body -->
        </div><!-- /.intro__inner -->

        <div class="intro__body">
            <header class="header" style="top:-9999px">
                <a href="#" class="btn-burger">
                    <span></span>

                    <span></span>

                    <span></span>
                </a>

                <div class="header__body">
                    <div class="shell">
                        <div class="header__body__inner">

                            <div class="search header__search">
                                <form action="?" method="get">
                                    <i class="ico-chevron-down search__ico-first"></i>

                                    <label for="f_search1" class="hidden">Search</label>

                                    <input type="search" name="f_search" id="f_search1" value="" placeholder="Search"
                                        class="search__field" />

                                    <input type="submit" value="GO" class="search__btn" />

                                    <i class="fa fa-search search__ico" aria-hidden="true"></i>
                                </form>
                            </div><!-- /.search -->

                            <aside class="header__aside">
                                <div id="google_translate_element"></div>

                                <script type="text/javascript">
                                function googleTranslateElementInit() {
                                    new google.translate.TranslateElement({
                                        pageLanguage: 'en',
                                        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
                                        autoDisplay: false
                                    }, 'google_translate_element');
                                }
                                </script>

                                <script type="text/javascript"
                                    src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
                                    async></script>

                                <ul class="header__links">
                                    <li>
                                        <a href="#" class="btn btn--red">Login <i class="ico-chevron"></i></a>
                                    </li>

                                    <li>
                                        <a href="#" class="btn btn--red">Register <i class="ico-chevron"></i></a>
                                    </li>
                                </ul><!-- /.header__links -->
                            </aside><!-- /.header__aside -->
                        </div><!-- /.header__body__inner -->
                    </div><!-- /.shell -->
                </div><!-- /.header__body -->

                <div class="header__bar extranav">
                    <div class="shell">
                        <div class="header__bar__inner">
                            <nav class="nav">
                                <ul>
                                    <li class="active">
                                        <a href="<?php echo SITE_ROOT ?>">Home</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>membership">Membership</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>events">Events</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>libraryconstruction">Library</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>special-interest-group">Focus
                                            Groups</a>
                                    </li>

                                    <li class="hidden-fixed">
                                        <a href="<?php echo SITE_ROOT ?>education">Education</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>fellows-home">Fellows</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>gthirtysix">G36</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>webinars-podcasts">Webinars
                                            &amp; Podcasts</a>
                                    </li>

                                    <li class="hidden-fixed">
                                        <a href="<?php echo SITE_ROOT ?>about">About</a>
                                    </li>
                                </ul>

                                <ul>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>login">Login</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>register">Register
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div><!-- /.header__body -->

                <!--<a href="#" class="btn-help header__btn">
                Need <br>
                <strong>Help?</strong> <br>
                <i class="ico-chevron-double-white"></i>
            </a>-->

                <div class="slider-main-nav">
                    <div class="prev">
                        <i class="ico-chevron-double-prev"></i>
                    </div><!-- /.prev -->

                    <div class="next">
                        <i class="ico-chevron-double"></i>
                    </div><!-- /.prev -->
                </div><!-- /.slider-main-nav -->
            </header><!-- /.header -->

            <!-- /.slider__bar -->
        </div>
        <div class="clearfix home_banner" style="padding-top: 70px; background-color: #23408C;">
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
                                <ul>
                                    <li class="active">
                                        <a href="<?php echo SITE_ROOT ?>">Home</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>about">About</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>membership">Membership</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>events">Events</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>library">Library</a>
                                    </li>

                                    <li class="">
                                        <a href="<?php echo SITE_ROOT ?>education">Education</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>fellows-home">Fellows</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>special-interest-group">Focus
                                            Groups</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>gthirtysix">G36</a>
                                    </li>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>webinars-podcasts">Webinars
                                            &amp; Podcasts</a>
                                    </li>

                                </ul>

                                <ul>

                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>login">Login</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo SITE_ROOT ?>register">Register
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

            <img class="homebanner" src="<?php echo SITE_ROOT ?>images_insol/banner.jpg">
            <div class="clearfix home_slider">
                <h2>News</h2>
                <div class="single-item-rtl" style="display: none;">
                    <?php
$SQL = "";
$SQL = "SELECT *, CASE WHEN display_on_top = 1 THEN position ELSE 1000 END AS ordd FROM " . NEWS_TBL . " WHERE status = 'ACTIVE' AND display_on_top = 1 ORDER BY ordd ASC, news_date DESC, news_id DESC";
$news = $dCON->prepare($SQL);
$news->execute();
$rs_news = $news->fetchAll();
$news->closeCursor();
//echo  '<pre>'; print_r($rs_news);exit();
//echo SITE_ROOT;
?>
                    <?php
if (intval(count($rs_news)) > intval(0)) {
    foreach ($rs_news as $r) {
        $news_title = htmlentities(stripslashes($r['news_title']));
        $news_date = stripslashes($r['news_date']);
        $news_url_key = stripslashes($r['url_key']);
        $newsURL = SITE_ROOT . urlRewrite("news-details.php", array("url_key" => $news_url_key));

        ?>
                    <div>
                        <h5><?php echo date('l jS F, Y', strtotime($news_date)); ?></h5>
                        <p>
                            <a href="<?php echo $newsURL; ?>"> <?php echo $news_title; ?> </a>
                        </p>
                    </div>
                    <?php }

}?>
                </div>



            </div>
            <ul class="resourcesWrap" style="right: 15px; position: absolute; top: 70px;">
                <li>
                    <a href="<?php echo SITE_ROOT ?>newsletter">Newsletter</a>
                </li>
                <?php
$SQLRCAT = "";
$SQLRCAT .= " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE `status` = 'ACTIVE' ";
$SQLRCAT .= " ORDER BY position ASC limit 7";
$stmtRCat = $dCON->prepare($SQLRCAT);
$stmtRCat->execute();
$rowRCat = $stmtRCat->fetchAll();
$stmtRCat->closeCursor();
//echo count($rowCat);
$r = 1;
foreach ($rowRCat as $rsRCat) {
    $R_cat_id = "";
    $R_cat_name = "";
    $R_cat_url_key = "";

    $R_cat_id = intval($rsRCat['category_id']);
    $R_cat_name = stripslashes($rsRCat['category_name']);
    $R_cat_url_key = stripslashes($rsRCat['url_key']);
    $R_cat_url = SITE_ROOT . urlRewrite("resources.php", array("cat_url_key" => $R_cat_url_key));
    ?>
                <li>
                    <a href="<?php echo $R_cat_url; ?>"><?php echo $R_cat_name; ?></a>
                </li>
                <?php
if ($r >= 6) {
        break;
    }
    $r++;
}
if (count($rowRCat) >= intval(7)) {
    ?>
                <li style="border-bottom: 0px;"><a href="resource-list.php">More Resources &rarr;</a></li>
                <?php
}
?>
            </ul>

            <div class="bannerTxt">
                <h4>Committed to building the stature and prestige of insolvency, restructuring and turnaround
                    profession.</h4>
            </div>
        </div><!-- /.intro -->



        <script>
        (function($) {
            $(function() {
                if ($('#application_button').length) {
                    $('#application_button button').replaceWith(
                        '<p><strong style="color: rgb(224, 0, 38)">Enrolments for the 2020/21 course have now closed. Enrolments for the 2021/22 Foundation Certificate will open on 1 May 2021 and we look forward to receiving your application then.</strong></p>'
                    );
                }
            });

        })(jQuery)
        </script>

        <full-menu></full-menu>


        <div class="main">
            <section class="section-features">
                <div class="shell">
                    <ul class="arrows arrows--right section__arrows">
                        <li style="border-color: transparent #e00026 transparent transparent;"></li>

                        <li style="border-color: transparent #1d2644 transparent transparent;"></li>

                        <li style="border-color: transparent #0e74b8 transparent transparent;"></li>

                        <li style="border-color: transparent #7ba8d8 transparent transparent;"></li>

                        <li style="border-color: transparent #e9ebec transparent transparent;"></li>
                    </ul><!-- /.arrows -->

                    <div class="cols section__cols">


                        <div class="col--size1">
                            <div class="section__content-dark">
                                <div class="section__inner">
                                    <h1>Insol India</h1>

                                    <p><strong>INDIAN ASSOCIATION OF RESTRUCTURING, INSOLVENCY & BANKRUPTCY
                                            PROFESSIONALS</strong></p>

                                    <p style="text-transform: capitalize;">INSOL India is an independent
                                        leadership body
                                        representing practitioners and
                                        other associated professionals specialising in the fields of
                                        restructuring,
                                        insolvency and turnaround. It is an association with an architecture
                                        that
                                        facilitates key stakeholders to come together and share experiences
                                        while
                                        preserving their independence.</p>

                                    <a href="<?php echo SITE_ROOT . urlRewrite("insol-india.php"); ?>"
                                        target="_blank">Read more</a><br />
                                    <!--<a href="#" class="section__link"><i class="ico-chevron-red"></i> Become A Member</a>-->
                                </div>
                                <!-- /.section__inner -->
                            </div>
                            <!-- /.section__content-dark -->

                            <div class="section__inner section__inner--first">
                                <!-- MA HERE -->
                                <!-- /.feature-members -->
                            </div>
                            <!-- /.section__inner -->
                        </div>

                        <div class="col--size2">
                            <div class="section__content">
                                <div class="feature">
                                    <div class="feature__head">
                                        <h6><strong><span style="letter-spacing: 0.01em;"><span
                                                        style="font-size:20px;"><a
                                                            href="<?php echo SITE_ROOT ?>library/opendownload/1755"
                                                            target="_blank">INSOL 2021 congress, San diego -
                                                            announcement</a><br />
                                                        <br />
                                                        INsol international world bank group global
                                                        guide</span></span></strong><br />
                                            <br />
                                            <a href="<?php echo SITE_ROOT ?>library/opendownload/1644"><i>measures
                                                    adopted to support distressed businesses through the covid-19
                                                    crisis</i></a><br />
                                            <br />
                                            <span style="font-size:16px;"><u><strong><span
                                                            style="letter-spacing: 0.01em;"><a
                                                                href="<?php echo SITE_ROOT ?>library/opendownload/1425"><span
                                                                    style="color:#c0392b;">COVID-19, UPDATE FROM THE
                                                                    PRESIDENT</span></a></span></strong></u></span><br />
                                            &nbsp;
                                        </h6>

                                        <h6><strong><span style="letter-spacing: 0.01em;"><span
                                                        style="font-size:16px;"><a
                                                            href="<?php echo SITE_ROOT ?>webinars-podcasts">Explore
                                                            our webinar programme and watch previous webinars in the
                                                            INSOL Quick Takes and INSOL Focus
                                                            Series</a></span></span></strong></h6>
                                        <strong><span style="letter-spacing: 0.01em;">&nbsp; </span></strong>

                                        <p align="center"><strong><span style="letter-spacing: 0.01em;"><a
                                                        href="<?php echo SITE_ROOT ?>foundationcertificatecourse"><img
                                                            alt=""
                                                            src="<?php echo SITE_ROOT ?>media/3acbb620-4d46-4139-a342-2c347cbb2733.png"
                                                            style="width: 259px; height: 273px;" /></a></span></strong>
                                        </p>
                                        <strong><span style="letter-spacing: 0.01em;"> &nbsp; &nbsp; &nbsp;
                                                &nbsp;&nbsp;<br />
                                                <script src="https://fast.wistia.net/assets/external/E-v1.js" async>
                                                </script>
                                            </span></strong>

                                        <div class="feature feature--blue" style="margin-top: -9px">
                                            <div class="feature__head">
                                                <h6><strong><span
                                                            style="letter-spacing: 0.01em; padding-left: 20px;">Our
                                                            Projects</span></strong></h6>

                                                <?php

$SQLp = "";
$SQLp .= " SELECT * FROM " . PROJECTS_TBL . " as P ";
$SQLp .= " WHERE status = 'ACTIVE' and projects_title !='' order by position ASC ";

$stmt1 = $dCON->prepare($SQLp);
$stmt1->execute();
$rsLIST = $stmt1->fetchAll();
$dA = count($rsLIST);
$stmt1->closeCursor();
if ($dA > intval(0)) {
    foreach ($rsLIST as $rLIST) {
        $masterID = "";
        $masterTITLE = "";
        $url_key = "";
        $imgHOME = "";

        $masterID = intval($rLIST['projects_id']);
        $masterTITLE = htmlentities(stripslashes($rLIST['projects_title']));
        $imgHOME = (stripslashes($rLIST['homepage_image']));

        $imgEXIST = "";
        $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_PROJECTS . "/" . FLD_HOMEPAGE_IMAGE . "/R500-" . $imgHOME);

        $showIMG = "";
        if (intval($imgEXIST) == intval(1)) {
            $showIMG = MODULE_FILE_FOLDER . FLD_PROJECTS . "/" . FLD_HOMEPAGE_IMAGE . "/R500-" . $imgHOME;
        } else {
            $showIMG = "";
        }

        $url_key = stripslashes($rLIST['url_key']);
        $masterURL = SITE_ROOT . urlRewrite("projects_detail.php", array("url_key" => $url_key));
        ?>
                                                <div class="col-md-12 col-sm-12 in_project_sec">
                                                    <a href="<?php echo $masterURL; ?>">
                                                        <img src="<?php echo $showIMG; ?>" style="object-fit: contain;">
                                                    </a>
                                                    <span>
                                                        <a
                                                            href="<?php echo $masterURL; ?>"><?php echo $masterTITLE; ?></a>
                                                    </span>
                                                </div>
                                                <?php
}
}
?>


                                            </div>
                                            <strong><span style="letter-spacing: 0.01em;">
                                                    <!-- /.feature__head -->
                                                    <!-- /.footer__body -->
                                                </span></strong>
                                        </div>
                                        <strong><span style="letter-spacing: 0.01em;">
                                                <!-- /.feature-blue -->
                                            </span></strong>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="col--size3">
                            <div class="section__content-white">
                                <div class="articles">
                                    <div class="articles__head">
                                        <h1>
                                            <span>Forthcoming</span> <br>
                                            Events
                                        </h1>
                                    </div><!-- /.articles__head -->

                                    <?php
$SQL = "";
$SQL = "SELECT * FROM " . EVENT_TBL . " WHERE STATUS = 'ACTIVE' AND show_in_current = 1 ORDER BY POSITION DESC LIMIT 0,2";
$events = $dCON->prepare($SQL);
$events->execute();
$rs_events = $events->fetchAll();
$events->closeCursor();
$countEVENT = count($rs_events);
//echo "<pre>"; print_r($rs_events);
//foreach($rs_events AS $e){}
?>



                                    <div class="articles__body">
                                        <div class="article">
                                            <div class="article__content">
                                                <div class="article__image">
                                                    <img style="width: 100%; height: auto;"
                                                        src="<?php echo SITE_ROOT ?>eventfiles/bbda0a3a-dca3-45d3-ab25-f572b9b65d48.jpg"
                                                        alt="" />
                                                </div><!-- /.article__image -->
                                            </div><!-- /.article__content -->

                                            <div class="article__body">
                                                <?php foreach ($rs_events as $ev_val) {
    $event_id = stripslashes($ev_val['event_id']);
    $event_link = stripslashes($ev_val['event_link']);
    $date = strtotime($ev_val['event_from_date']);
    $url_key = stripslashes($ev_val['url_key']);
    $masterURL = SITE_ROOT . urlRewrite("event-detail.php", array("url_key" => $url_key));

    // to display image in list

    $iSQL = "";
    $iSQL = "SELECT image_name FROM " . EVENT_IMAGES_TBL . " WHERE STATUS = 'ACTIVE'";
    $iSQL .= " AND default_image = 'YES'";
    $iSQL .= " AND master_id = :event_id";
    $iRes = $dCON->prepare($iSQL);
    $iRes->bindParam(":event_id", $event_id);
    $iRes->execute();
    $iNAME = $iRes->fetch();
    $iRes->closeCursor();
    $masterIMG = $iNAME['image_name'];

    $DISPLAY_IMG = "";
    $R200_IMG_EXIST = "";

    $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG);

    if (intval($R200_IMG_EXIST) == intval(1)) {
        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG;
    } else {
        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/no_images.jpg";
    }

    ?>

                                                <div class="article">
                                                    <div class="article__content">
                                                        <div class="article__image">
                                                            <img style="width: 100%; height: auto;"
                                                                src="<?php echo $DISPLAY_IMG; ?>" alt="" />
                                                        </div><!-- /.article__image -->
                                                    </div><!-- /.article__content -->

                                                    <div class="article__body">
                                                        <div class="article__content__inner">
                                                            <h6><?php echo $ev_val['event_name']; ?></h6>

                                                            <p>

                                                                <?php echo date('l d F Y', $date); ?><br><?php echo $ev_val['event_venue']; ?>
                                                                <!--<br>Channel Islands-->
                                                            </p>
                                                        </div><!-- /.article__content__inner -->
                                                        <ul>
                                                            <li>
                                                                <a href="<?php echo SITE_ROOT ?>become-member.php">
                                                                    <i class="ico-chevron-light-blue"></i>

                                                                    Become a member
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="<?php echo $masterURL; ?>">
                                                                    <i class="ico-chevron-light-blue"></i>

                                                                    More About This Event
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div><!-- /.article__body -->
                                                </div><!-- /.article -->

                                                <?php

}
?>


                                                <a href="<?php echo SITE_ROOT ?>events" class="moreevents">
                                                    <div class="article">
                                                        <h6>For more events, click here</h6>
                                                    </div>
                                                </a>
                                            </div><!-- /.articles__body -->

                                        </div><!-- /.articles -->
                                    </div><!-- /.section__inner -->
                                </div><!-- /.section__content -->
                            </div><!-- /.col-/-1of3 -->

                        </div><!-- /.cols -->
                    </div><!-- /.shell -->
            </section><!-- /.section -->
        </div><!-- /.main -->

        <footer class="footer footer--primary">
            <div class="footer__body">
                <div class="shell">
                    <div class="cols footer__cols">
                        <div class="col--1of3 footer__col">
                            <div class="col__inner">
                                <h2>Quick Links</h2>

                                <nav class="footer__nav">
                                    <ul>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>membership/">Membership</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>events/">Events</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>library">Technical
                                                Library</a>
                                        </li>

                                        <!--<li>
                                    <a href="#">
                                        Special
                                        Interest Groups
                                    </a>
                                </li>-->

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>education/">Education</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>partners/">Partners</a>
                                        </li>

                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>about/">About</a>
                                        </li>
                                    </ul>
                                </nav><!-- /.nav -->
                            </div><!-- /.col__inner -->
                        </div><!-- /.col-/-10f3 -->

                        <div class="col--1of3 footer__col">
                            <div class="col__inner">
                                <h2>Contact Us</h2>

                                <div class="footer__contact">
                                    <p>
                                        INSOL International <br>
                                        6 - 7 Queen Street <br>
                                        London <br>
                                        EC4N 1SP
                                    </p>

                                    <ul>
                                        <li>
                                            T <a href="tel:+4402072483333">+44
                                                (0)20 7248 3333</a>
                                        </li>

                                        <li>
                                            F <a href="tel:+4402072483384">+44
                                                (0)20 7248 3384</a>
                                        </li>

                                        <li>
                                            E <a href="mailto:info@insol.ision.co.uk">Info@insol.ision.co.uk</a>
                                        </li>
                                    </ul>
                                </div><!-- /.contact -->
                            </div><!-- /.col__inner -->
                        </div><!-- /.col-/-10f3 -->

                        <div class="col--1of3 footer__col">
                            <div class="col__inner">
                                <h2>Useful Links</h2>
                                <nav class="footer__nav">
                                    <ul>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>library/opendownload/520"
                                                target="_blank">Privacy Policy</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>cookies/">Cookies
                                                Policy</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>library/opendownload/532"
                                                target="_blank">Complaints and Dispute Resolution</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo SITE_ROOT ?>library/opendownload/533"
                                                target="_blank">Equality and Diversity Policy</a>
                                        </li>
                                    </ul>
                                </nav><!-- /.nav -->
                            </div><!-- /.col__inner -->
                        </div><!-- /.col-/-10f3 -->
                    </div><!-- /.cols -->
                </div><!-- /.shell -->
            </div><!-- /.footer__body -->


            <div class="footer__bar" style="position:fixed; bottom:0; width: 100%; background-color: red; ">
                <div class="shell">
                    <div class="footer__bar__inner" style="text-align: center; color: white;;">
                        <a href="<?php echo SITE_ROOT ?>membership">Become A
                            Member</a> | <a href="<?php echo SITE_ROOT ?>events">Register for
                            an
                            event</a>
                    </div><!-- /.footer__bar__inner -->
                </div><!-- /.shell -->
            </div><!-- /.footer__bar -->

        </footer><!-- /.footer -->
    </div><!-- /.wrapper -->



    <script type="text/javascript" src="<?php echo SITE_ROOT ?>assets/vendor/owl-carousel/dist/owl.carousel.min.js"
        defer></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>assets/js/functions.js" async></script>
    <script type="text/javascript" src="<?php echo SITE_ROOT ?>assets/js/insol-v2.js" async></script>

    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.min.js" integrity="" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"
        type="text/javascript" defer></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/slick.min.js"></script>
    <script src="<?php echo SITE_ROOT ?>js_insol/scripts.js"></script>

    <script src="<?php echo SITE_ROOT ?>js_insol/grids.js"></script>
    <script>
    $(document).ready(function() {
        $('.eqH').responsiveEqualHeightGrid();
        $('.profileH').responsiveEqualHeightGrid();
    });
    </script>
    <script src="<?php echo SITE_ROOT ?>js_insol/script.js"></script>
</body>

</html>