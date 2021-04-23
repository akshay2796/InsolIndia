<?php include('header.php'); ?>
<div style="position: fixed; top: 180px; left: 0; z-index: 9999;"><a href="<?php echo SITE_ROOT . urlRewrite("draft_best_practices.php"); ?>"><img src="images_insol/draft-best-practices.png" alt=""/></a></div>


    <?php
        $SQL = "";
        $SQL = "SELECT *, CASE WHEN display_on_top = 1 THEN position ELSE 1000 END AS ordd FROM ".NEWS_TBL." WHERE status = 'ACTIVE' AND display_on_top = 1 ORDER BY ordd ASC, news_date DESC, news_id DESC";
        $news = $dCON->prepare($SQL);
        $news->execute();
        $rs_news = $news->fetchAll();
        $news->closeCursor();
        //echo  '<pre>'; print_r($rs_news);exit();
        //echo SITE_ROOT;
    ?>
    <div class="clearfix home_banner">
    	
    	<img class="homebanner" src="https://www.insolindia.com/images_insol/banner.jpg">
        <div class="clearfix home_slider">
        	<h2>News</h2>
            <div class="single-item-rtl" style="display: none;">
                <?php if(intval(count($rs_news))>intval(0)){
                    foreach($rs_news AS $r){
                        $news_title = htmlentities(stripslashes($r['news_title']));
                        $news_date = stripslashes($r['news_date']);
                        $news_url_key = stripslashes($r['url_key']);
                        $newsURL = SITE_ROOT . urlRewrite("news-details.php", array("url_key" => $news_url_key));
                        
                        
                ?>
                <div>
                    <h5><?php echo date('l jS F, Y', strtotime($news_date)); ?></h5>
                    <p>
                       	<a href="<?php echo $newsURL; ?>" > <?php echo $news_title; ?> </a>
                    </p>
                </div>
            <?php } 
            
            } ?>                  
            </div>
            
            
            
        </div>
        <ul class="resourcesWrap" style="right: 15px; position: absolute; top: 0;">
            <li>
						<a href="https://insolindia.com/newsletter">Newsletter</a>
					</li>  
			<?php
			$SQLRCAT  = "";
			$SQLRCAT .= " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE `status` = 'ACTIVE' "; 
			$SQLRCAT .= " ORDER BY position ASC limit 7"; 
			$stmtRCat = $dCON->prepare( $SQLRCAT );
			$stmtRCat->execute();
			$rowRCat = $stmtRCat->fetchAll();
			$stmtRCat->closeCursor();
			//echo count($rowCat);
			$r=1;
			foreach($rowRCat as $rsRCat)
			{
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
				if($r>=6)
				{
					break;
				}
				$r++;
			}
			if(count($rowRCat)>=intval(7))
			{
			?>   
				<li style="border-bottom: 0px;"><a href="resource-list.php">More Resources &rarr;</a></li>       
			<?php
			}
			?>
		</ul>
        
        <div class="bannerTxt">
    		<h4>Committed to building the stature  and prestige of insolvency, restructuring and turnaround profession.</h4>
		</div>
			
			
			
    </div>
    <!--===BANNER===-->
    
    <!--===ABOUT===-->
    <div class="clearfix index_about">
        <div class="container">
            <div class="col-md-8 col-sm-12 col-xs-12 index_about_left">
                <div class="index_about_left_img">
                    <img src="https://www.insolindia.com/images_insol/about_insol.jpg" alt="About INSOL">
                </div>
                <div class="index_about_left_cp">
                    <h2>About INSOL India</h2>
                    <p>INSOL India is an independent leadership body representing practitioners and other associated professionals specialising in the fields of restructuring, insolvency and turnaround.  It is an association with an architecture that facilitates key stakeholders to come together and share experiences while preserving their independence. <a href="<?php echo SITE_ROOT . urlRewrite("insol-india.php"); ?>">read more</a></p>
                    
                        <a class="" target="_blank" href="<?php echo SITE_ROOT ?>downloads/insol-brochure.pdf"><img src="images_insol/insol-brochure.jpg" width="40" style="margin-right:10px;" alt=""/>Download Brochure</a>
                        
                </div>
            </div>
            <?php 
                $SQL="";
                $SQL = "SELECT * FROM ".EVENT_TBL." WHERE STATUS = 'ACTIVE' AND show_in_current = 1 ORDER BY POSITION DESC";
                $events = $dCON->prepare($SQL);
                $events->execute();
                $rs_events = $events->fetchAll();
                $events->closeCursor();
                $countEVENT = count($rs_events);
                //echo "<pre>"; print_r($rs_events);
                //foreach($rs_events AS $e){}
            ?>
            <div class="col-md-4 col-sm-12 col-xs-12 index_about_right">

            	<div class="index_about_bg">
                    <h2>Upcoming Events</h2>
                    <div class="about_slider">
                        
                        <div class="about-slider">

                            <?php foreach ($rs_events as $ev_val)
                                { 
                                    $event_id = stripslashes($ev_val['event_id']);
                                    $event_link = stripslashes($ev_val['event_link']);
                                    $date = strtotime($ev_val['event_from_date']);
                                    $url_key = stripslashes($ev_val['url_key']); 
                                    $masterURL = SITE_ROOT . urlRewrite("event-detail.php", array("url_key" => $url_key));

                                    // to display image in list

                                    $iSQL ="";
                                    $iSQL = "SELECT image_name FROM ".EVENT_IMAGES_TBL." WHERE STATUS = 'ACTIVE'";
                                    $iSQL .= " AND default_image = 'YES'";
                                    $iSQL .= " AND master_id = :event_id";
                                    $iRes = $dCON->prepare($iSQL);
                                    $iRes->bindParam(":event_id", $event_id);
                                    $iRes->execute();
                                    $iNAME = $iRes->fetch();
                                    $iRes->closeCursor();
                                    $masterIMG = $iNAME['image_name'];

                                    $DISPLAY_IMG = "";
                                    $R200_IMG_EXIST =  "";
                                    
                                    $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG);
                                    
                                    if( intval($R200_IMG_EXIST) == intval(1) )
                                    {
                                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG;
                                    }
                                    else
                                    {
                                          $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/no_images.jpg" . $masterIMG;
                                    }
                            ?>
                                <div> 
                                    <a href="<?php echo $masterURL; ?>">
                                    	<img src="<?php echo $DISPLAY_IMG; ?>">
                                    </a>
                                    <div class="about_slider_cap">
                                        <h3>
                                        	<a href="<?php echo $masterURL; ?>"><?php echo $ev_val['event_name'];?></a>
                                        </h3>
                                        <h5>On <span><?php echo date('l d F Y', $date); ?></span></h5>
                                        <p><?php echo $ev_val['event_venue']; ?></p>

                                        <?php   if($event_link != "")
                                                {
                                                    $_SESSION['CURRENT_SET_EVENT_URL'] = $event_link;
                                        ?>
                                                    <h6>
                                                        <a href="<?php echo SITE_ROOT . urlRewrite("login.php"); ?>">Register To Attend</a>
                                                    </h6>

                                        <?php   }   ?>
                                    </div>  
                                </div>

                         <?php } ?>
                        </div>

                    </div>
                   <?php 
                    if($countEVENT > intval(0))
                    {
                   ?>
                        <h5>
                            <a href="<?php echo SITE_ROOT . urlRewrite("events.php"); ?>">view all</a>
                        </h5>

                <?php
                    }
                ?>
                
                </div> 
            </div>
        </div>
    </div>
    <!--===END ABOUT===-->
    
    <!--===Our Projects===-->
    <div class="clearfix index_project">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6">
                    <h2 style="font-size: 26px;">National Law University Moot Competition 2019</h2>
                    <iframe width="100%" height="260" src="https://www.youtube.com/embed/U20eBum6M5I" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="col-sm-6 col-md-6">
            <h2>Our Projects</h2>
            

			<div class="row project_slider">
                <?php
                
                    $SQLp  = ""; 
                    $SQLp .= " SELECT * FROM " . PROJECTS_TBL . " as P "; 
                    $SQLp .= " WHERE status = 'ACTIVE' and projects_title !='' order by position ASC ";
                    
                    $stmt1 = $dCON->prepare($SQLp);  
                    $stmt1->execute();
                    $rsLIST = $stmt1->fetchAll();
                    $dA = count($rsLIST);
                    $stmt1->closeCursor();
                    if($dA > intval(0))
                    {
                         foreach($rsLIST as $rLIST)
                            {
                                $masterID = "";
                                $masterTITLE = "";
                                $url_key = "";
                                $imgHOME ="";
                                
                                $masterID = intval($rLIST['projects_id']);
                                $masterTITLE = htmlentities(stripslashes($rLIST['projects_title']));
                                $imgHOME = (stripslashes($rLIST['homepage_image']));
                                
                                $imgEXIST =  "";
                                $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_PROJECTS . "/" . FLD_HOMEPAGE_IMAGE . "/R500-" . $imgHOME);
                                
                                $showIMG = "";                     
                                if( intval($imgEXIST) == intval(1) ){
                                    $showIMG = MODULE_FILE_FOLDER . FLD_PROJECTS . "/" . FLD_HOMEPAGE_IMAGE . "/R500-" . $imgHOME;
                                }else{
                                    $showIMG = "";         
                                } 
                                
                                
                                $url_key = stripslashes($rLIST['url_key']);
                                $masterURL = SITE_ROOT . urlRewrite("projects_detail.php", array("url_key" => $url_key));
                ?>
        				<div class="col-md-4 col-sm-4 in_project_sec">
        					<a href="<?php echo $masterURL; ?>" >
        						<img src="<?php echo $showIMG; ?>">
        					</a>
        					<h3>
        						<a href="<?php echo $masterURL; ?>" ><?php echo $masterTITLE; ?></a>
        					</h3>
        				</div>
            <?php
                            }
                    }
            ?>

				<!--div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php //echo SITE_ROOT ?>insolvency-blog.php">
						<img src="<?php //echo SITE_IMAGES; ?>project2.jpg">
					</a>
					<h3>
						<a href="<?php //echo SITE_ROOT ?>insolvency-blog.php">Insolvency Blog</a>
					</h3>
				</div-->

			   <!--	<div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php echo SITE_ROOT ?>IBC-implementation-report.php">
						<img src="<?php echo SITE_IMAGES; ?>project2.jpg">
					</a>
					<h3>
						<a href="<?php echo SITE_ROOT ?>IBC-implementation-report.php">IBC Implementation Report</a>
					</h3>
				</div> -->


				<!--div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php //echo SITE_ROOT ?>country-wide-workshops.php">
						<img src="<?php //echo SITE_IMAGES; ?>project4.jpg">
					</a>
					<h3>
						<a href="<?php //echo SITE_ROOT ?>country-wide-workshops.php">Country wide Workshops</a>
					</h3>
				</div-->

			   <!--	<div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php echo SITE_ROOT ?>designing-insolvency-courses-for-law-schools.php">
						<img src="<?php echo SITE_IMAGES; ?>project3.jpg">
					</a>
					<h3>
						<a href="<?php echo SITE_ROOT ?>designing-insolvency-courses-for-law-schools.php">Seminar Course for Law Schools</a>
					</h3>
				</div> 

				<div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php echo SITE_ROOT ?>best-practices-task-force-with-sipi.php">
						<img src="<?php echo SITE_IMAGES; ?>project5.jpg">
					</a>
					<h3>
						<a href="<?php echo SITE_ROOT ?>best-practices-task-force-with-sipi.php">Best Practices Task Force with SIPI</a>
					</h3>
				</div>

				<div class="col-md-4 col-sm-4 in_project_sec">
					<a href="<?php echo SITE_ROOT ?>advocacy.php">
						<img src="<?php echo SITE_IMAGES; ?>project6.jpg">
					</a>
					<h3>
						<a href="<?php echo SITE_ROOT ?>advocacy.php">Advocacy</a>
					</h3>
				</div>-->
				
				
				
			</div>
            
            </div>
            </div>
        </div>
    </div>
    <!--===END Our Projects===-->
    
    <!--===Our sig24 samvaad===-->
    <div class="clearfix ">
    
    
     <div class="container">
            <h2 style="font-size: 26px;" align="center"> SIG24 Samvaad Webseries 2020</h2>
            <div class="row series_carosel">
                <div class="col-sm-6 col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/9MORuRaZ3M4" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h4 align="center">Liquidation in COVID – challenges</h4>
                </div>
                <div class="col-sm-6 col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/xLrV60NchmE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h4 align="center">Roles, Responsibilities and Expectations of Indian Banks in the IBC process</h4>
                </div>
                <div class="col-sm-6 col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/i7EVyPUps1Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h4 align="center">How should Insolvency professionals tackle the new normal</h4>
                </div>
                <div class="col-sm-6 col-md-6">
                    <iframe width="100%" height="315" src="https://www.youtube.com/embed/ZTASORC3D1w" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <h4 align="center">What Does The New Normal Mean For Alternate Capital Providers Post COVID 19</h4>
                </div>
                
            </div>
        </div>
    </div>
    <!--===END sig24 samvaad===-->
    
<!--===END INDEX PAGE===-->

<?php include('footer.php'); ?>
