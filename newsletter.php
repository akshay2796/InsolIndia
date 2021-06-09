<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<?php include 'header.php';
$connection = mysqli_connect("localhost", "sabsoin_ins_user", "Yrs[aidZ&8gA", "sabsoin_insol_india") or die(mysqli_error($mysqli));
$query = "SELECT * FROM tbl_newsletter WHERE status = 'ACTIVE' and newsletter_subject != 'INSOL India Newsletter Test 2' and newsletter_subject != 'Insol Newsletter Testing'  order by newsletter_id desc";
$result = mysqli_query($connection, $query);

?>

<div class="clearfix banner">
    <div class="container">
        <h1>Newsletters</h1>
    </div>
</div>

<div class="container">

    <div class="clearfix inner_page events pagination__list">


        <?php
$counter = 1;
while ($show = mysqli_fetch_array($result)) {
    ?>
        <div class="col-md-6 col-sm-6 col-xs-12 events_sect eqH">
            <div class="events_sect_img publicationImg" style="position: relative;">
                <img src="images_insol/blankImg-lh.png" style="width:100%;" />
                <a href="newsletters/view.php?nid=<?php echo $show['newsletter_id']; ?>">
                    <div class="ImgBoxOuter">
                        <span class="ImgBoxInner">
                            <img src="http://insolindia.com/images_insol/no_images.jpg">
                        </span>
                    </div>
                </a>
            </div>
            <div class="events_sect_text">
                <h3>
                    <a href="newsletters/view.php?nid=<?php echo $show['newsletter_id']; ?>">
                        Issue :- <?php echo $show['newsletter_issue']; ?>,
                        Volume :- <?php echo $show['volume_name']; ?>
                    </a>
                </h3>
                <h4>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <span><?php echo $show['newsletter_date']; ?></span>

                </h4>

            </div>
        </div>
        <?php $counter += 1;}?>

    </div>




</div>





<?php include 'footer.php';?>