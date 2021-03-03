<?php include('header.php'); 
    define("PAGE_MAIN","media-detail.php");  
    define("PAGE_LIST","media.php");

    $SQL1  = ""; 
    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . MEDIA_TBL . " as M "; 
    $SQL1 .= " WHERE status = 'ACTIVE' and media_name !=''  ";
    $SQL1 .= " $search ";



    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= ",(SELECT image_name FROM ". MEDIA_IMAGES_TBL ." AS I WHERE I.master_id = M.media_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
    $SQL .= " FROM " . MEDIA_TBL . " as M WHERE status = 'ACTIVE' and media_name !='' ";
    $SQL .= " $search ";
    $SQL .= " order by media_from_date desc ";
    //echo $SQL;
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

//echo $dA;
    
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Media</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page media_page pagination__list">
        <?php
            
            if($dA > intval(0))
            { 
                foreach($rsLIST as $rLIST)
                {
                    $masterID = "";
                    $masterNAME = "";
                    $masterTYPE = "";
                    $masterCATEGORY = "";
                    
                    
                    $masterIMG = "";
                    $masterURLKEY = "";
                    $masterURL = "";
                    $masterFDATE = "";
                    
                    
                    $masterSDESC = "";
                     
                    $masterID = intval($rLIST['media_id']);
                    $masterNAME = htmlentities(stripslashes($rLIST['media_name']));
                    $masterPUBLISHER = htmlentities(stripslashes($rLIST['media_publisher']));
                    $masterTYPE = htmlentities(stripslashes($rLIST['media_type']));
                    $masterCATEGORY= htmlentities(stripslashes($rLIST['category_name']));

                    
                    $alt_text = $masterNAME;

                    
                    $masterFDATE = (stripslashes($rLIST['media_from_date']));
                                    
                    if ( (trim($masterFDATE) != "0000-00-00") || (trim($masterFDATE) != "") ){
                        
                        $masterFDATE = date("d F, Y", strtotime($masterFDATE)); 
                    } 
                    
                    if ( trim($masterTYPE) == "CONTENT" ){
                        $masterSDESC = stripslashes($rLIST["media_short_description"]); 
                      
                        $masterIMG = stripslashes($rLIST['image_name']);
                       
                        $masterURLKEY = stripslashes($rLIST['url_key']);
                        $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));
                        
                        
                        $DISPLAY_IMG = "";
                        $R200_IMG_EXIST =  "";
                        
                        $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/R200-" . $masterIMG);
                        
                        if( intval($R200_IMG_EXIST) == intval(1) )
                        {
                            $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/R200-" . $masterIMG;
                        }
                        else
                        {
                            $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                        }
                        
                       // $masterURL = "<a href='" . $masterURL . "' >";
                        
                    }elseif ( trim($masterTYPE) == "FILE" ){
                        
                        $masterFTYPEfile = stripslashes($rLIST['file_name']);
                        
                        $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                        
                        $FTYPE_PATH = MODULE_UPLOADIFY_ROOT . FLD_MEDIA . "/" . FLD_MEDIA_FILE . "/" . $masterFTYPEfile;    
                        $chKFTYPE = chkImageExists($FTYPE_PATH); 
 
                        $masterURL =  $FTYPE_PATH ;
                        
                        
                    }elseif ( trim($masterTYPE) == "URL" ){
                        $masterFTYPEurl = stripslashes($rLIST['media_url']);    
                        
                        $masterURL =  $masterFTYPEurl ;
                        
                        $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                      
                    }
                    
                    
                ?>  
            
                    <div class="clearfix media_list"> <!--========loop start==========-->
                       
                            	<div class="media_img">
                                	<a href="<?php echo $masterURL; ?>" <?php if(($masterTYPE == "FILE") || ($masterTYPE == "URL")) { ?> target="_blank" <?php } ?> >
                                    	<img src="<?php echo $DISPLAY_IMG; ?>">
                                    </a>
                                </div>
                       
                        <div class="media_text">
                        	<h3>
                            	<a href="<?php echo $masterURL; ?>" <?php if(($masterTYPE == "FILE") || ($masterTYPE == "URL")) { ?> target="_blank" <?php } ?>>

                                <?php echo $masterNAME; ?></a>
                            </h3>
                            <h4>
                            	<i class="fa fa-calendar" aria-hidden="true"></i>
                            	<span><?php echo $masterFDATE; ?></span> | <i class="fa fa-user" aria-hidden="true"></i>
                            	<span><?php echo $masterPUBLISHER; ?></span>
                            </h4>
                            <p><?php echo limit_char(trustme($masterSDESC), 250); ?></p>
                            <h6>
                            	<a href="<?php echo $masterURL; ?>" <?php if(($masterTYPE == "FILE") || ($masterTYPE == "URL")) { ?> target="_blank" <?php } ?>>View</a>
                            </h6>
                        </div>
                    </div> <!--========loop Closed==========-->
                    
                    <?php
                }
                
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
                ?>   
                
               
        <?php
            }else{
                echo "Under Formation...";
                }

        ?>
 
    </div>
</div>
<?php include('footer.php'); ?>