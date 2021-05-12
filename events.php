<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./css_insol/style.css?ver=3">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    .resultsWrap {
        width: 100%;
        float: left;
        margin-top: -170px;
        margin-bottom: 100px;
    }

    .eventsWrap {
        width: 30%;
        margin-bottom: 20px;
        float: left;
        margin-right: 2%;
    }

    .section__body {
        display: block !important;
        box-shadow: 9px 0 14px 0 rgba(0, 0, 0, .3);
    }

    .section__content {}

    .section-events .section__content {
        background: rgba(255, 255, 255, 0.9) !important;
        background-image: url(https://www.insol.org/assets/css/images/headers/nyc.jpg) !important;
        background-position: bottom !important;
        padding: 0px !important;
        box-shadow: none !important;
        width: 100%;
        float: left;
    }

    .section__media {
        min-width: auto !important
    }

    .section__media img {
        height: 200px;
        object-fit: cover;
    }

    .section__content__inner {
        width: 100%;
        padding: 4%;
        float: left;
        background: rgba(255, 255, 255, 0.95) !important;
        height: 160px;
    }

    .section__content__inner h4 {
        min-height: 40px;
    }

    .section-events .section__content h4 {
        font-size: 18px !important;
        margin: 8px 0px !important
    }

    .section-events .section__content h6 {
        margin: 8px 0px !important
    }

    .section__bar {
        width: 100%;
        float: left;
        background: #fff !important;
        left;
        padding: 0px !important;
        display: block !important
    }

    /*.section__bar a{    }
    /*a.btnred{width:100%; float: left;border-style: solid; position: relative;
border-width: 0 0 54px 30px;
border-color: transparent transparent rgba(227, 4, 32, 0.8) transparent; line-height:30px;}
    a.btnblue{ position: relative;width:100%; float: left;border-style: solid;
   border-width: 0 30px 54px 0px;
border-color: transparent #0e74b8 transparent transparent;}*/
    a.btnWrapRed {
        width: 100%;
        float: left;
        background: #b72027CC;
        padding: 20px 15px;
    }

    a.btnWrapBlue {
        width: 100%;
        float: left;
        background: #234090CC;
        padding: 20px 30px;
    }

    a.btnWrapRed:hover {
        background: #b72027;
    }

    a.btnWrapBlue:hover {
        background: #234090;
    }

    .emptyspace {
        padding: 30px 30px;
        width: 100%;
        float: left;
    }

    a.current {
        text-decoration: underline !important
    }

    a.notactive {
        text-decoration: none !important
    }

    @media (max-width: 1000px) {
        .eventsWrap {
            width: 48%;
            margin-bottom: 20px;
            float: left;
            margin-right: 1%;
            margin-left: 1%;
            box-shadow: 9px 0 14px 0 rgba(0, 0, 0, .3);
        }

        .section__media img {
            min-height: 200px;
            max-height: 350px;
            object-fit: contain;
        }
    }

    @media (max-width: 600px) {
        .eventsWrap {
            width: 90%;
            margin-bottom: 20px;
            float: left;
            margin-right: 0px;
            box-shadow: 9px 0 14px 0 rgba(0, 0, 0, .3);
        }

        .resultsWrap>div#results {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }
    }

    .section__bar a {
        color: white !important;
    }
    </style>
</head>
<?php include 'header.php';

define("PAGE_MAIN", "event-detail.php");
define("PAGE_AJAX", "ajax_event.php");
define("PAGE_LIST", "events.php");
$current_date = date("Y-m-d");
$current_event = strtolower($_GET['event']);
$SQL1 = "";
$SQL1 .= " SELECT COUNT(*) AS CT FROM " . EVENT_TBL . " as E ";
$SQL1 .= " WHERE status = 'ACTIVE' and event_name !=''  ";

$SQL = "";
$SQL .= " SELECT * ";
$SQL .= ",(SELECT image_name FROM " . EVENT_IMAGES_TBL . " AS I WHERE I.master_id = E.event_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
if ($current_event == 'upcoming') {
    $SQL .= " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !='' and event_from_date > '$current_date' ";
} else if ($current_event == 'past') {
    $SQL .= " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !='' and past_event = 1 ";
} else {
    $SQL .= " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !=''";
}
$SQL .= " order by event_from_date desc ";

$stmt1 = $dCON->prepare($SQL1);

$stmt1->execute();
$noOfRecords_row = $stmt1->fetch();
$noOfRecords = intval($noOfRecords_row['CT']);
$rowsPerPage = 6;

$pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
$stmt2 = $dCON->prepare($pg_query[0]);

$stmt2->bindParam(":offset", $offset, PDO::PARAM_INT);
$stmt2->bindParam(":RPP", $RPP, PDO::PARAM_INT);
$offset = $pg_query[1];
$RPP = $rowsPerPage;
$paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
$dA = $noOfRecords;

$stmt2->execute();
$rsLIST = $stmt2->fetchAll();
$stmt2->closeCursor();
?>

<div class="clearfix banner">
    <div class="container">
        <?php
if ($current_event == 'upcoming') {
    ?>
        <h1>Upcoming Events</h1>
        <?php } else if ($current_event == 'past') {
    ?>
        <h1>Past Events</h1>
        <?php } else {
    ?>
        <h1>Events</h1>
        <?php }?>
    </div>
</div>

<div class="section">
    <div class="shell" style="margin-bottom: 200px">
        <div class="section__inner">
            <!-- /.section__aside -->

            <div style="width: 100%;">
                <section class="section-events">

                    <div class="resultsWrap">
                        <div id="results">
                            <?php
if ($dA > intval(0)) {
    foreach ($rsLIST as $rLIST) {
        $masterID = "";
        $masterLink = "";
        $masterNAME = "";
        $masterCATEGORY = "";

        $masterIMG = "";
        $masterURLKEY = "";
        $masterURL = "";
        $masterFDATE = "";
        $masterTDATE = "";

        $masterSDESC = "";

        $masterID = intval($rLIST['event_id']);
        $masterLink = stripslashes($rLIST['event_link']);
        $masterNAME = htmlentities(stripslashes($rLIST['event_name']));
        $webinar = htmlentities(stripslashes($rLIST['webinar']));
        $masterCATEGORY = htmlentities(stripslashes($rLIST['category_name']));
        $alt_text = $masterNAME;

        $masterFDATE = (stripslashes($rLIST['event_from_date']));
        $masterTDATE = (stripslashes($rLIST['event_to_date']));
        $masterFTIME = (stripslashes($rLIST['event_from_time']));
        $masterTTIME = (stripslashes($rLIST['event_to_time']));
        $event_venue = (stripslashes($rLIST['event_venue']));
        // for timings

        if (($masterTTIME != "") && ($masterFTIME != "")) {
            $masterFTIME = date("h:i:sA", strtotime($masterFTIME));
            $masterTTIME = date("h:i:sA", strtotime($masterTTIME));
        }

        // for Date
        if (date("F Y", strtotime($masterTDATE)) == date("F Y", strtotime($masterFDATE))) {
            if (date("d F Y", strtotime($masterTDATE)) == date("d F Y", strtotime($masterFDATE))) {
                $dateDisplay = date("d F, Y", strtotime($masterFDATE));
            } else {
                $dateDisplay = date("d", strtotime($masterFDATE)) . " - " . date("d", strtotime($masterTDATE)) . " " . date("F, Y", strtotime($masterFDATE));
            }
        } else {
            $dateDisplay = date("d F, Y", strtotime($masterFDATE));
            if (trim($masterTDATE) != '0000-00-00') {
                $dateDisplay .= " To " . date("d F, Y", strtotime($masterTDATE));
            }
        }

        $masterSDESC = stripslashes($rLIST["event_short_description"]);

        $masterIMG = stripslashes($rLIST['image_name']);

        $url_key = stripslashes($rLIST['url_key']);

        $masterURL = SITE_ROOT . urlRewrite("event-detail.php", array("url_key" => $url_key));

        $DISPLAY_IMG = "";
        $R200_IMG_EXIST = "";

        $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG);

        if (intval($R200_IMG_EXIST) == intval(1)) {
            $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG;
        } else {
            $DISPLAY_IMG = SITE_IMAGES . "no_images.jpg";
        }
        ?>
                            <div class="eventsWrap">
                                <div class="section__body">
                                    <div class="media section__media">
                                        <img src="<?php echo $DISPLAY_IMG; ?>" alt="" width="1280" height="720">
                                        <!-- /.media__bar -->

                                        <div class="media__content_image">
                                            <!-- /.media__actions -->


                                        </div>
                                        <!-- /.section__media__content -->
                                    </div><!-- /.section__media -->
                                    <div class="section__content">
                                        <div class="section__content__inner">
                                            <h4>
                                                <a style="text-decoration: none;" href="<?php echo $masterURL; ?>">
                                                    <?php echo $masterNAME; ?>
                                                </a>
                                            </h4>
                                            <h6 style="">
                                                <?php $time = strtotime($masterFTIME);
        $time2 = strtotime($masterTTIME);?>
                                                <span><?php echo $dateDisplay;if ($masterFTIME != "") {echo " " . date("h", $time) . ":" . date("i", $time) . " " . date("A", $time);}if ($masterTTIME != "") {echo " to " . date("h", $time2) . ":" . date("i", $time2) . " " . date("A", $time2);} ?>
                                                </span>
                                            </h6>
                                            <strong></strong>




                                        </div>


                                        <div class="section__bar">

                                            <a href="<?php echo $masterURL; ?>" class="btnWrapRed">
                                                <i class="ico-chevron-double-white"></i>

                                                View <strong>details</strong>
                                            </a>
                                            <a href="<?php echo $masterTDATE > date('Y-m-d') ? './become-member.php' : '#' ?>"
                                                class="btnWrapBlue">
                                                <?php if ($masterTDATE > date('Y-m-d')) {
            echo '<i class="ico-chevron-double-white"></i>';
            echo 'Register <strong>to attend</strong>';
        } else {
            echo '&nbsp';
        }
        ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <?php }

    if (trim($paging[0]) != "") {
        ?>
                            <div class="clearfix cls"></div>
                            <div class="clearfix" id="bottomPagging" style="margin-bottom: 30px;">
                                <div class="pagingList">
                                    <label>PAGE</label>
                                    <ul>
                                        <?php echo $paging[0]; ?>
                                    </ul>
                                </div>
                                <div class="clr"></div>
                            </div>
                            <?php
}

} else {
    echo "Under Formation...";
}

?>
                            <!-----Our Sponsors   ----------->
                            <!--<div class="container">-->
                            <!--<p style="text-align: center; color: black; font-weight: bold; font-size: 25px;">EVENT SPONSORS</p>-->
                            <!--<br>-->
                            <!--<p style="text-align: center; color: black; font-weight: bold; font-size: 18px;">Powered by</p>-->
                            <!--<br>-->
                            <!--  <div class="row">-->
                            <!--    <div class="col-md-12">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:150px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="awards/images/awards/2.jpg" target="_blank">-->
                            <!--          <img src="awards/images/awards/2.jpg" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!-- <h3 style="text-align: center; color: black; font-weight: bold; font-size: 18px;">Main Sponsor</h3>-->
                            <!--   <div class="col-md-6">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="awards/images/awards/1.jpg" target="_blank">-->
                            <!--          <img src="awards/images/awards/1.jpg" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-6">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:180px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="awards/images/awards/11.png" target="_blank">-->
                            <!--          <img src="awards/images/awards/11.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--<br>-->
                            <!-- <h3 style="text-align: center; color: black; font-weight: bold; font-size: 18px;">Online Partner</h3>-->
                            <!--   <div class="col-md-12">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:160px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="awards/images/awards/3.jpg" target="_blank">-->
                            <!--          <img src="awards/images/awards/3.jpg" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--  </div>-->
                            <!-- <h3 style="text-align: center; color: black; font-weight: bold; font-size: 18px;">Other Partners</h3>-->
                            <!-- <br>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/4.jpg" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/5.jpg" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/6.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/7.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/9.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--   <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/8.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->
                            <!--    <div class="col-md-4">-->
                            <!--      <div  class="img-rounded" alt="Cinque Terre" style="width:304px; height:236px; display: block; margin-left: auto; margin-right: auto;">-->
                            <!--        <a href="#" target="_blank">-->
                            <!--          <img src="awards/images/awards/10.png" alt="Lights" style="width:100%">-->

                            <!--        </a>-->
                            <!--      </div>-->
                            <!--    </div>-->


                            <!--  </div>-->
                            <!--</div>-->
                            <!-----Our Sponsors   ----------->




                            <?php include 'footer.php';?>