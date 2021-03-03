<?php include('header.php'); ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>News</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page media_page pagination__list">
    <?php   $SQL_CT = "";
            $SQL_CT = "SELECT COUNT(*) AS CT FROM ".NEWS_TBL." WHERE status = 'ACTIVE'";
            $SQL = "";
            //$SQL = "SELECT * FROM ".NEWS_TBL." WHERE status = 'ACTIVE' ORDER BY position ASC"; //upto 23 november 2017
            $SQL = "SELECT * FROM ".NEWS_TBL." WHERE status = 'ACTIVE' ORDER BY display_on_top DESC, position DESC, news_date DESC";
            $stmt1 = $dCON->prepare($SQL_CT);
            $stmt1->execute();
            $noOfRecords_row = $stmt1->fetch();
            $noOfRecords = intval($noOfRecords_row['CT']);
            $rowsPerPage = 6;

            $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
            $stmt2 = $dCON->prepare($pg_query[0]);

            $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
            $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
            $offset = $pg_query[1];
            $RPP = $rowsPerPage;
            $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
            $dA = $noOfRecords;
            
            $stmt2->execute();
            $rsLIST = $stmt2->fetchAll();
            $stmt2->closeCursor();
            if(intval($dA) > 0){
                foreach($rsLIST AS $r){
                    $url_key = stripslashes($r['url_key']);
                    $masterURL = SITE_ROOT . urlRewrite("news-details.php", array("url_key" => $url_key));
                    $image_name = $r['image_name'];

                    $DISPLAY_IMG = "";
                    $IMG_EXISTS = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_NEWS  .'/'. $image_name);
                    if(intval($IMG_EXISTS) == intval(1)){
                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_NEWS  .'/'. $image_name;
                    }else{
                        $DISPLAY_IMG =  SITE_IMAGES . 'no_images.jpg';
                    }
    ?>
        <div class="clearfix media_list">
        	<div class="media_img">
            	<a href="<?php echo $masterURL; ?>">
                	<img src="<?php echo  $DISPLAY_IMG; ?>">
                </a>
            </div>
            <div class="media_text">
            	<h3>
                	<a href="<?php echo $masterURL; ?>"><?php echo $r['news_title']; ?></a>
                </h3>
                <h4>
                	<i class="fa fa-calendar" aria-hidden="true"></i>
                	<span><?php echo date('F j, Y', strtotime($r['news_date'])); ?></span> 
                    <?php 
                        if($r['news_source'] != "")
                        {
                    ?>
                            <i class="fa fa-user" aria-hidden="true"></i>
                        	<span><?php echo $r['news_source']; ?></span>
                    <?php
                        }

                    ?>
                </h4>
                <p>
                <?php $content = trustme($r['news_content']);
                    $word_count = str_word_count($content); 
                      echo limit_words($content, 40); 
                      if($word_count > intval(40))
                      {
                        echo '..';
                      }
                 ?>    
                </p>
                <h6>
                	<a href="<?php echo $masterURL; ?>">Read More</a>
                </h6>
            </div>
        </div>
        <?php } 
            if(trim($paging[0]) != "")
                {
                ?>
                    <div class="clearfix cls"></div>
                    <div class="clearfix" id="bottomPagging">
                        <div class="pagingList">
                            <label>PAGE</label>
                            <ul>
                                <?php echo $paging[0];?>
                            </ul>
                        </div>
                        <div class="clr"></div>
                    </div>
                <?php
                } 
                 

        } else{
            echo "Under Formation......";
            } ?>        
    </div>
</div>
<?php include('footer.php'); ?>