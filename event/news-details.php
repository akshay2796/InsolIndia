<?php
ob_start();
include('header.php');
define("MAIN_PAGE", "news.php");
$url_key = trustme($_REQUEST['url_key']);
$rsDET = getDetails(NEWS_TBL, '*', "status~~~url_key","ACTIVE~~~$url_key",'=~~~=~~~=', '', '' , ""); 

if(intval(count($rsDET)) == intval(0)){
   header("location: ".SITE_ROOT."not-found.php");
    exit();
}
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>News</h1>
    </div>
</div>
<?php
if ( intval(count($rsDET)) > intval(0) ){
    $news_related_link=stripslashes($rsDET[0]['news_related_link']);
    $news_source = stripslashes($rsDET[0]['news_source']);
?>
<div class="container">
    <div class="clearfix inner_page news_list">
    	<div class="gallery_list">
            <p>
                <a href="<?php echo SITE_ROOT . urlRewrite(MAIN_PAGE); ?>">
                    <span data-hover="back to list">back to list</span>
                </a>
            </p>
        </div>
        <h2><?php echo stripslashes($rsDET[0]['news_title']); ?></h2>
        <h3>
            <?php
                if($news_source != "")
                {
            ?>
                    By <span><?php echo $news_source; ?></span> 
            <?php
                }
            ?>


                Posted On : <span><?php echo date('F d, Y', strtotime($rsDET[0]['news_date'])); ?></span></h3>
        <?php   $image_name=stripslashes($rsDET[0]['image_name']);
                $DISPLAY_IMG = "";
                $IMG_EXISTS = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_NEWS  .'/'. $image_name);
                if(intval($IMG_EXISTS) == intval(1)){
                    $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_NEWS  .'/'. $image_name;
                }
                if($DISPLAY_IMG != "")
                {
        ?>
                <img src="<?php echo $DISPLAY_IMG; ?>">

                <?php

                }
                ?>
        <p><?php echo stripslashes($rsDET[0]['news_content']); ?></p>
        <?php
            if($news_related_link !="")
            {
               ?>
                <p>For more details please visit <a href="<?php echo $news_related_link; ?>" target="_blank"><?php echo $news_related_link; ?></a></p>
               <?php
            }
        ?>
    </div>
</div>
<?php } ?>
<?php include('footer.php'); ?>