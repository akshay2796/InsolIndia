<?php include('header.php'); 
$url_key = trustme($_REQUEST['url_key']);
$rsDET = getDetails(PROJECTS_TBL, '*', "status~~~url_key","ACTIVE~~~$url_key",'=~~~=~~~=', '', '' , "");
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Our Projects</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'projects_left_menu.php'; ?>
        </div>
        <?php
            if(intval(count($rsDET)) > intval(0))
             { 
                $masterTITLE = "";
                $masterDESCRIPTION = "";
                $masterID = "";
                $masterFILE = "";
                
                $masterID = (stripslashes($rsDET[0]['projects_id']));
                $masterTITLE = (stripslashes($rsDET[0]['projects_title']));
                $masterDESCRIPTION = (stripslashes($rsDET[0]['projects_description']));
                $masterFILE = (stripslashes($rsDET[0]['file_name']));
        ?>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<h2><?php echo $masterTITLE; ?></h2>
			<p><?php echo $masterDESCRIPTION; ?></p>
            <?php
                //for file opening
                
                if($masterFILE != "")
                {
                    $masterLINKFILE = SITE_URL . MODULE_UPLOADIFY_ROOT . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/" . $masterFILE;
                    ?>
                        <a href="<?php echo $masterLINKFILE; ?>" class="btn btn-primary" target="_blank" style="padding:12px 15px 12px 12px"><i class="fa fa-file-text-o" aria-hidden="true" style="font-size: 24px; margin-right: 10px; margin-top: -3px; float: left; "></i> View / Download</a>
						<div class="clr height20"></div>
                    <?php
                }
            ?>
           
           <!--================For sponsor image ================----->
           <?php 
                $rsLOGO = getDetails(PROJECTS_LOGO_IMAGES_TBL, '*', "status~~~master_id","ACTIVE~~~$masterID",'=~~~=~~~=', '', '' , "");
                $logoCOUNT = count($rsLOGO);
                if($logoCOUNT > intval(0))
                {
           ?>
		  	<h3 class="subsubHead">Sponsors</h3>
           	<ul class="sponsorsLogo">
                <?php 
                    foreach($rsLOGO as $rLOGO)
                    {
                        $imgLOGO = "";
                        $urlLOGO = "";
                        $imgLOGO = (stripslashes($rLOGO['image_name']));
                        $urlLOGO = (stripslashes($rLOGO['image_caption']));
                        $imgEXIST =  "";
                        $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_PROJECTS . "/" . FLD_PROJECTS_LOGO_IMG . "/" . $imgLOGO);
                        
                        $showIMG = "";                     
                        if( intval($imgEXIST) == intval(1) ){
                            $showIMG = MODULE_FILE_FOLDER . FLD_PROJECTS . "/" . FLD_PROJECTS_LOGO_IMG . "/" . $imgLOGO;
                        }else{
                            $showIMG = "";         
                        } 
                ?>
				    <li>
              			<div class="eqH">
               			<div class="events_sect_img publicationImg" style="position: relative;">
							<img src="<?php echo SITE_IMAGES; ?>psponsorsh.png" style="width:100%;" />
							<a href="<?php if($urlLOGO != ""){ echo $urlLOGO; } ?>">
								<div class="ImgBoxOuter">
									<span class="ImgBoxInner">
										<img src="<?php echo $showIMG; ?>" class="imgSize img-zoom" alt="<?php echo $imgLOGO; ?>"/>
									</span>
								</div>
							</a>
						</div>
						</div>
               
               
               
               
               
               		</li>
                <?php
                    }
                ?>
				
			</ul>
           <!--================For sponsor image Ends ================----->
            <!--p>Details of competition will be announced on 28 April 2017 at ASSOCHAM INSOL India Conference.</p-->
        </div>
        <?php
                }
            }else{
                echo "<h2>Coming Soon...</h2>";
            }
        ?>
        </div>
    </div>
</div> 

<?php include('footer.php'); ?>