<?php include('header.php'); 
    define("PAGE_MAIN","resource-detail.php");  
    define("PAGE_LIST","law-regulations-and-rules.php");

    $SQL1  = ""; 
    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . RESOURCES_TBL . " as R "; 
    $SQL1 .= " WHERE status = 'ACTIVE' and resources_name !=''  ";
    $SQL1 .= " $search ";



    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= ",(SELECT image_name FROM ". RESOURCES_IMAGES_TBL ." AS I WHERE I.master_id = R.resources_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
    $SQL .= " FROM " . RESOURCES_TBL . " as R WHERE status = 'ACTIVE' and resources_name !='' ";
    $SQL .= " $search ";
    $SQL .= " order by resources_from_date desc ";
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

?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Resources</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'resources_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<h2>Law, Regulations and Rules</h2>
        	<div class="row">
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
                     
                    $masterID = intval($rLIST['resources_id']);
                    $masterNAME = htmlentities(stripslashes($rLIST['resources_name']));
                    $masterPUBLISHER = htmlentities(stripslashes($rLIST['resources_publisher']));
                    $masterTYPE = htmlentities(stripslashes($rLIST['resources_type']));
                    $masterCATEGORY= htmlentities(stripslashes($rLIST['category_name']));

                    
                    $alt_text = $masterNAME;

                    
                    $masterFDATE = (stripslashes($rLIST['resources_from_date']));
                                    
                    if ( (trim($masterFDATE) != "0000-00-00") || (trim($masterFDATE) != "") ){
                        
                         $masterFDATE = date("l d F Y", strtotime($masterFDATE)); 
                    } 
                    
                    if ( trim($masterTYPE) == "CONTENT" ){
                        $masterSDESC = stripslashes($rLIST["resources_short_description"]); 
                      
                        $masterIMG = stripslashes($rLIST['image_name']);
                       
                        $masterURLKEY = stripslashes($rLIST['url_key']);
                        $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));

                       
                        $DISPLAY_IMG = "";
                        $R200_IMG_EXIST =  "";
                        
                        $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG);
                        
                        if( intval($R200_IMG_EXIST) == intval(1) )
                        {
                            $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG;
                        }
                        else
                        {
                            $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                        }
                        
                        
                       
                       // $masterURL = "<a href='" . $masterURL . "' >";
                        
                    }elseif ( trim($masterTYPE) == "FILE" ){
                        
                        $masterFTYPEfile = stripslashes($rLIST['file_name']);
                        
                        $FTYPE_PATH = MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/" . $masterFTYPEfile;    
                        $chKFTYPE = chkImageExists($FTYPE_PATH); 
 
                        $masterURL =  $FTYPE_PATH ;
                       //FOR IMAGES

                        $masterIMG = stripslashes($rLIST['image_name']);
                        $DISPLAY_IMG = "";
                        $R200_IMG_EXIST =  "";
                        
                        $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG);
                        
                        if( intval($R200_IMG_EXIST) == intval(1) )
                        {
                            $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG;
                        }
                        else
                        {
                            $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                        }
                        
                    }elseif ( trim($masterTYPE) == "URL" ){
                         $masterFTYPEurl = stripslashes($rLIST['resources_url']);    
                        
                        $masterURL =  $masterFTYPEurl ;
                        
                        $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                      
                    }
                    
                ?>  

                        <div class="col-md-6 col-sm-6 col-xs-12 reso_sect eqH"> <!--======Loop Div=========-->
                            <div class="reso_sect_img publicationImg" style="position: relative;">
                                   <img src="<?php echo SITE_IMAGES.'blankImg-lh.png'; ?>" style="width:100%;" />
                                    <a href="<?php echo $masterURL; ?>" <?php if(($masterTYPE == "FILE") || ($masterTYPE == "URL")) { ?> target="_blank" <?php } ?>>
                                        <div class="ImgBoxOuter">
                                            <span class="ImgBoxInner"><img src="<?php echo $DISPLAY_IMG; ?>" class="imgSize img-zoom" alt=""/></span>
                                        </div>
                                    </a>                               
                                </div>
                            <div class="reso_sect_text">
                            	<h3>
                                	<a href="<?php echo $masterURL; ?>" <?php if(($masterTYPE == "FILE") || ($masterTYPE == "URL")) { ?> target="_blank" <?php } ?>><?php echo $masterNAME; ?></a>
                                </h3>
                                <p>
                                    <?php echo limit_char(trustme($masterSDESC), 250); ?>
                                </p>
                                <h4>
                                	<i class="fa fa-calendar" aria-hidden="true"></i>
                                	<span><?php echo $masterFDATE; ?></span>
                                </h4>
                                <?php 
                                    if($masterPUBLISHER !="")
                                    {
                                ?>
                                        <h4>
                                        	<i class="fa fa-user" aria-hidden="true"></i>
                                            <span><?php echo $masterPUBLISHER; ?></span>
                                        </h4>
                                <?php
                                    }
                                ?>
                            </div>
                        </div> <!--======Loop Div End=========-->
                        
                        
						
						<?php
                }
                
                if(trim($paging[0]) != "")
                {
                ?>
                   	<div class="col-xs-12">
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
				</div>
                <?php
                }
                ?>   
                
                 
            <?php
            }else{
                echo "<div class='col-xs-12'><p>Under Formation...</p></div>";
            }
            ?>
			</div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>