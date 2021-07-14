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
            width: 45%;
            margin-bottom: 20px;
            float: left;
            margin-right: 1%;
            margin-left: 1%;
            box-shadow: 9px 0 14px 0 rgba(0, 0, 0, .3);
        }

        div#results {
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
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

$upcoming_sql = $SQL . " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !='' and event_from_date > '$current_date' ";
$past_sql = $SQL . " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !='' and past_event = 1 ";

$upcoming_sql .= " order by event_from_date desc ";
$past_sql .= " order by event_from_date desc ";

$stmt1 = $dCON->prepare($SQL1);

$stmt1->execute();
$noOfRecords_row = $stmt1->fetch();
$noOfRecords = intval($noOfRecords_row['CT']);
$rowsPerPage = 6;

$pg_query_upcoming = $pg->getPagingQuery($upcoming_sql, $rowsPerPage);
$upcoming_stmt = $dCON->prepare($pg_query_upcoming[0]);

$upcoming_stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$upcoming_stmt->bindParam(":RPP", $RPP, PDO::PARAM_INT);
$offset = $pg_query_upcoming[1];
$RPP = $rowsPerPage;
$paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
$dA_upcoming = $noOfRecords;

$upcoming_stmt->execute();
$rs_upcoming = $upcoming_stmt->fetchAll();
$upcoming_stmt->closeCursor();

//Past events
$pg_query_past = $pg->getPagingQuery($past_sql, $rowsPerPage);
$past_stmt = $dCON->prepare($pg_query_past[0]);

$past_stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
$past_stmt->bindParam(":RPP", $RPP, PDO::PARAM_INT);
$offset = $pg_query_past[1];
$RPP = $rowsPerPage;
$paging = $pg->getAjaxPagingLink($noOfRecords, $rowsPerPage);
$dA_past = $noOfRecords;

$past_stmt->execute();
$rs_past = $past_stmt->fetchAll();
$past_stmt->closeCursor();
?>

<div class="clearfix banner">
    <!-- <div class="container">
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
    </div> -->
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
if (count($rs_upcoming) > intval(0)) {
        ?>


                            <section class="events section--padding background--grey" style="position: relative;<?php echo count($rs_upcoming) > 0 ? '' : 'display: none;' ?>">
                                <header class="section__header">
                                    <div class="container-projects">
                                        <div class="section__header-row">
                                            <h3 style="font-size: 3rem; margin-bottom: 2rem;">Upcoming events
                                            </h3>
                                            <!-- <a href="/events" class="capsule">See all events</a> -->
                                        </div>
                                    </div>
                                </header>
                                <div class="container-projects">
                                    <div class="grid grid--four">
                                        <?php foreach ($rs_upcoming as $ev_val) {
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
                                        <article class="card card--event">
                                            <div class="card__image">
                                                <img src="<?php echo $DISPLAY_IMG; ?>"
                                                    alt="<?php echo $ev_val['event_name']; ?>">
                                            </div>
                                            <div class="card__info">
                                                <span class="card__date"><?php echo date('d F Y', $date); ?>
                                                </span>
                                                <h1 class="card__title"><?php echo $ev_val['event_name']; ?></h1>
                                                <div class="card__actions">
                                                    <a href="<?php echo SITE_ROOT; ?>ereg/index.php?id=<?php echo $event_id; ?>"
                                                        target="_blank"
                                                        aria-label="<?php echo $ev_val['event_name']; ?>"
                                                        class="button button--inverted">Registration</a>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                }
                            ?>
                                    </div>
                                </div>
                                <div class="section__image">
                                    <div class="image-background">
                                        <img src="https://insol.org/getmedia/90ed9200-0f4b-49cf-8651-4065b3e4a1be/lines-bg1.svg"
                                            alt="">
                                    </div>
                                </div>
                            </section>
                            <?php
}
?>

                            <!-- Past Events -->
                            <?php
if ($dA_past > intval(0)) {
        ?>


                            <section class="events section--padding background--grey" style="position: relative;">
                                <header class="section__header">
                                    <div class="container-projects">
                                        <div class="section__header-row">
                                            <h3 style="font-size: 3rem; margin-bottom: 2rem;">Past events
                                            </h3>
                                            <a href="<?php echo SITE_ROOT; ?>past_events.php" class="capsule">See all
                                                past
                                                events</a>
                                        </div>
                                    </div>
                                </header>
                                <div class="container-projects">
                                    <div class="grid grid--four">
                                        <?php foreach ($rs_past as $ev_val) {
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
                                        <article class="card card--event">
                                            <div class="card__image">
                                                <img src="<?php echo $DISPLAY_IMG; ?>"
                                                    alt="<?php echo $ev_val['event_name']; ?>">
                                            </div>
                                            <div class="card__info">
                                                <span class="card__date"><?php echo date('d F Y', $date); ?>
                                                </span>
                                                <h1 class="card__title"><?php echo $ev_val['event_name']; ?></h1>
                                                <div class="card__actions">
                                                    <a href="<?php echo SITE_ROOT; ?>ereg/index.php?id=<?php echo $event_id; ?>"
                                                        target="_blank"
                                                        aria-label="<?php echo $ev_val['event_name']; ?>"
                                                        class="button button--inverted">Registration</a>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                }
                            ?>
                                    </div>
                                </div>
                                <div class="section__image">
                                    <div class="image-background">
                                        <img src="https://insol.org/getmedia/90ed9200-0f4b-49cf-8651-4065b3e4a1be/lines-bg1.svg"
                                            alt="">
                                    </div>
                                </div>
                            </section>
                            <?php
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