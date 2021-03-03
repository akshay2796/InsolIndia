<?php include('header.php'); 
    define("PAGE_MAIN","executive_committee_detail.php");
    define("PAGE_LIST","executive-committee.php");

?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Governance</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page events">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'organisations_left_menu.php'; ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right pagination__list">
        	<h2>Executive Committee </h2>
            <div class="clearfix organisation">
                    <?php 
                   /* $SQL1  = ""; 
                    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . EXECUTIVE_COMMITTEE_TBL . " as G "; 
                    $SQL1 .= " WHERE status = 'ACTIVE' and executive_name !=''  ";
                    $SQL1 .= " $search "; */



                    $SQL = "";
                    $SQL .= " SELECT * ";
                    $SQL .= " FROM ".EXECUTIVE_COMMITTEE_TBL;
                    $SQL .= " WHERE status = 'ACTIVE' and executive_name !='' ";
                    $SQL .= " $search ";
                    $SQL .= " order by position ";
                    //echo $SQL;
                    //$stmt1 = $dCON->prepare($SQL1);  


                   // $stmt1->execute();
                    //$noOfRecords_row = $stmt1->fetch();
                    //$noOfRecords = intval($noOfRecords_row['CT']);
                   // $rowsPerPage = 6;

                    //$pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
                   // $stmt2 = $dCON->prepare($pg_query[0]);

                   // $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
                   // $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
                   // $offset = $pg_query[1];
                  //  $RPP = $rowsPerPage;
                  //  $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
                    //$dA = $noOfRecords;

                    $stmt2 = $dCON->prepare($SQL);  
                    $stmt2->execute();
                    $rsLIST = $stmt2->fetchAll();
                    $noOfRecords = count($rsLIST);
                    $dA = $noOfRecords;
                    $stmt2->closeCursor();

                ?>
                <div id="patrons" class="tab-pane fade in active">
                        <div class="clearfix org_section">
                        <?php
            
                            if($dA > intval(0))
                            { 
                                foreach($rsLIST as $rLIST)
                                {
                                    $masterID = "";
                                    $masterNAME = "";
                                    $masterTYPE = "";
                                    
                                    
                                    
                                    $masterIMG = "";
                                    $masterURLKEY = "";
                                    $masterURL = "";
                                    
                                    
                                    
                                    $masterSDESC = "";
                                     
                                    $masterID = intval($rLIST['executive_id']);
                                    $masterNAME = htmlentities(stripslashes($rLIST['executive_name']));
                                    $masterTYPE = htmlentities(stripslashes($rLIST['executive_type']));
                                    $masterPOST = htmlentities(stripslashes($rLIST['executive_post']));
                                    $masterPROFESSION= htmlentities(stripslashes($rLIST['executive_profession']));
                                    $alt_text = $masterNAME;

                                    $masterIMG = stripslashes($rLIST['image_name']);
                                   
                                    $masterURLKEY = stripslashes($rLIST['url_key']);
                                    $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));
                                    
                                    
                                    $DISPLAY_IMG = "";
                                    $R200_IMG_EXIST =  "";
                                    
                                    $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EXECUTIVE_COMMITTEE. "/R200-" . $masterIMG);
                                    
                                    if( intval($R200_IMG_EXIST) == intval(1) )
                                    {
                                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_EXECUTIVE_COMMITTEE. "/R200-" . $masterIMG;
                                    }
                                    else
                                    {
                                        $DISPLAY_IMG = SITE_IMAGES."no_image_profile.jpg";
                                    }
                                        
                                       // $masterURL = "<a href='" . $masterURL . "' >";
                                        
                                   
                                    
                                ?>  
                                    <div class="col-md-6 col-sm-12 col-xs-12 org_sec profileH">
                                        <div class="org_sec_img">
                                            <img src="<?php echo $DISPLAY_IMG; ?>">
                                        </div>
                                        <div class="org_sec_text">
                                            <h5><?php echo $masterPOST; ?></h5>
                                            <h3><?php echo $masterNAME; ?></h3>
                                            <p><?php echo $masterPROFESSION; ?></p>
                                            <h6>
                                                <a href="<?php echo $masterURL; ?>">view profile</a>
                                            </h6>
                                        </div>
                                    </div>
                            
                            <?php
                        }
                        ?>

                            
                        </div>
                        <?php 
                           /* if(trim($paging[0]) != "")
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
                                    } */
                    }else{
                            echo "Under Formation...";
                      }
                          
                        ?>
                    </div>

                </div>

            </div>
        
        </div>
    </div>
</div>
<?php include('footer.php'); ?>