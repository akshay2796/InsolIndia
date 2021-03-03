<?php include('header.php'); 

define("PAGE_MAIN","event-detail.php"); 
define("PAGE_AJAX","ajax_event.php");
define("PAGE_LIST","events.php");

    $SQL1  = ""; 
    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . EVENT_TBL . " as E "; 
    $SQL1 .= " WHERE status = 'ACTIVE' and event_name !=''  ";
   
    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= ",(SELECT image_name FROM ". EVENT_IMAGES_TBL ." AS I WHERE I.master_id = E.event_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
    $SQL .= " FROM " . EVENT_TBL . " as E WHERE status = 'ACTIVE' and event_name !='' ";
    $SQL .= " order by event_from_date desc ";

    $stmt1 = $dCON->prepare($SQL1);  


    $stmt1->execute();
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = intval($noOfRecords_row['CT']);
    $rowsPerPage = 6;

    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
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
    ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Events</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page events pagination__list">
   <?php 
            if($dA > intval(0))
            { 
                foreach($rsLIST as $rLIST)
                {
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
                    $masterCATEGORY= htmlentities(stripslashes($rLIST['category_name']));
                    $alt_text = $masterNAME;
                    
                    $masterFDATE = (stripslashes($rLIST['event_from_date']));
                    $masterTDATE = (stripslashes($rLIST['event_to_date']));
                    $masterFTIME = (stripslashes($rLIST['event_from_time']));
                    $masterTTIME = (stripslashes($rLIST['event_to_time']));
                    $event_venue = (stripslashes($rLIST['event_venue']));
                    // for timings

                    if(($masterTTIME !="") && ($masterFTIME !=""))
			            {
			                 $masterFTIME = date("h:i:sA", strtotime($masterFTIME));
			                 $masterTTIME = date("h:i:sA", strtotime($masterTTIME));
			            }

			        // for Date
                            if( date("F Y", strtotime($masterTDATE)) == date("F Y", strtotime($masterFDATE)) ){
                                if( date("d F Y", strtotime($masterTDATE)) == date("d F Y", strtotime($masterFDATE)) )
                                {
                                    $dateDisplay = date("d F, Y", strtotime($masterFDATE));
                                }else{
                                $dateDisplay = date("d", strtotime($masterFDATE))." - ".date("d", strtotime($masterTDATE)) ." ".date("F, Y", strtotime($masterFDATE)); 
                                }
                              }
                              else{
                                $dateDisplay = date("d F, Y", strtotime($masterFDATE));
                                if( trim($masterTDATE) != '0000-00-00')
                                {
                                  $dateDisplay .= " To " . date("d F, Y", strtotime($masterTDATE)); 
                                }
                              }
                                                        
                    
                    
                    $masterSDESC = stripslashes($rLIST["event_short_description"]); 
                   
                    $masterIMG = stripslashes($rLIST['image_name']);
                   
                    $url_key = stripslashes($rLIST['url_key']);
                    $masterURL = SITE_ROOT . urlRewrite("event-detail.php", array("url_key" => $url_key));
                    
                    
                    $DISPLAY_IMG = "";
                    $R200_IMG_EXIST =  "";
                   
                    $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG);
                    
                    if( intval($R200_IMG_EXIST) == intval(1) )
                    {
                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R200-" . $masterIMG;
                    }
                    else
                    {
                        $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                    }
    ?>
            <div class="col-md-6 col-sm-6 col-xs-12 events_sect eqH">
            	<div class="events_sect_img publicationImg" style="position: relative;">
                	<img src="images_insol/blankImg-lh.png" style="width:100%;" />
                	<a href="<?php echo $masterURL; ?>">
                    	<div class="ImgBoxOuter">
                    		<span class="ImgBoxInner">
                            	<img src="<?php echo $DISPLAY_IMG; ?>">
                            </span>
                        </div>
                	</a>
                </div>
                <!--div class="publicationImg" style="position: relative;">
                   <img src="images_insol/blankImg-lh.png" style="width:100%;" />
                    <a href="http://gbhto.org/reports/the-changing-facets-of-legal-profession/">
                        <div class="ImgBoxOuter">
                            <span class="ImgBoxInner"><img src="images_insol/l.jpg" class="imgSize img-zoom" alt=""/></span>
                        </div>
                    </a>                               
                </div-->
                <div class="events_sect_text">
                	<h3>
                    	<a href="<?php echo $masterURL; ?>" ><?php echo $masterNAME; ?> </a>
                    </h3>
                    <h4>
                    	<i class="fa fa-calendar" aria-hidden="true"></i>
                    	<span><?php echo $dateDisplay; if($masterFTIME != ""){ echo " ".$masterFTIME; } if($masterTTIME != "") { echo " to ".$masterTTIME; } ?> </span>
                    </h4>
                    <h4>
                    	<i class="fa fa-map-marker" aria-hidden="true"></i>
                        <span><?php echo $event_venue; ?></span>
                    </h4>
                    <p><?php echo limit_char(trustme($masterSDESC), 250); ?></p>

                    <?php   if($masterLink != "")
                            {
                    ?>
                            <h4>
                                <a href="<?php echo SITE_ROOT . $masterLink; ?>">Register To Attend</a>
                            </h4>

                    <?php   }   ?>
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
                
   
        }
        else{
            echo "Under Formation...";
        }

    ?>
        
    </div> 
   
    
    
    
</div>
<?php include('footer.php'); ?>