<?php include('header.php');
$URLKEY = trustme($_REQUEST['url_key']);
define("MAIN_PAGE", "board_governor.php");
$rsDET = getDetails(BOARD_GOVERNORS_TBL, '*', "status~~~url_key","ACTIVE~~~$URLKEY",'=~~~=~~~=', '', '' , ""); 
 ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Board Of Governors</h1>
    </div>
</div>
<?php 
        if ( intval(count($rsDET)) > intval(0) )
            { 
                
               
                $masterID = (intval($rsDET[0]['governor_id']));      
                $masterNAME = (stripslashes($rsDET[0]['governor_name'])); 
                $masterEMAIL = (stripslashes($rsDET[0]['governor_email']));      
                $masterPROFESSION = (stripslashes($rsDET[0]['governor_profession'])); 
                $masterPOST = (stripslashes($rsDET[0]['governor_post']));
                $masterURLKEY = (stripslashes($rsDET[0]['url_key']));
                $masterPROFILE = (stripslashes($rsDET[0]['governor_profile']));
                $masterIMG = (stripslashes($rsDET[0]['image_name']));
                $alt_txt = $masterNAME;

                $DISPLAY_IMG = "";
                $R200_IMG_EXIST =  "";
                
                $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_BOARD_GOVERNORS. "/" . $masterIMG);
                
                if( intval($R200_IMG_EXIST) == intval(1) )
                {
                    $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_BOARD_GOVERNORS. "/" . $masterIMG;
                }
                else
                {
                    $DISPLAY_IMG = SITE_IMAGES."no_image_profile.jpg";
                }
                
                    
            ?>
        
<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-3 col-sm-4 led_team_left">
            <img src="<?php echo $DISPLAY_IMG; ?>" alt="<?php echo $alt_txt; ?>" title="<?php $alt_txt?>">
            <div class="team_ades">
            	<?php 
					if($masterEMAIL !="")
					{
				?>
						<h6>Email:
							<a href="mailto:<?php echo $masterEMAIL; ?>"><?php echo $masterEMAIL; ?></a>
						</h6>
				<?php } ?>
            </div>
            <div class="team_back">
            	<p>
                	<a href="<?php echo SITE_ROOT . urlRewrite(MAIN_PAGE); ?>"><span data-hover="back to previous page">back to previous page</span></a>
                </p>
            </div>
        </div>
                <div class="col-md-9 col-sm-8 led_team_right">
                	<div class="team_right_cp">
                       
                        <h3><?php echo $masterNAME; ?></h3>
                        <h4><?php echo $masterPOST; ?></h4>
                        <p><?php echo $masterPROFESSION; ?></p>
                    </div>
                    
                    <div class="team_right_text">
                    	<?php echo $masterPROFILE; ?>
                    </div>
                </div> 

       
    </div>
</div>

 <?php
            }
        ?>
<?php include('footer.php'); ?>