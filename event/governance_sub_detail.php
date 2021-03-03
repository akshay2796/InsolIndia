<?php
ob_start();
include('header.php');
$type_url_key = trustme($_REQUEST['type_url_key']);

$subtype_key= trustme($_REQUEST['subtype_key']);

$nameTITLE = getDetails(GOVERNANCE_SUBTYPE_TBL, 'subtype_name', "status~~~url_key","ACTIVE~~~$subtype_key",'=~~~=~~~=', '', '' , ""); 

$URLKEY = trustme($_REQUEST['url_key']);


define("MAIN_PAGE", "governance_sub_list.php");
$rsDET = getDetails(GOVERNANCE_TBL, '*', "status~~~url_key","ACTIVE~~~$URLKEY",'=~~~=~~~=', '', '' , ""); 
if(intval(count($rsDET)) == intval(0)){
       header("location: ".SITE_ROOT."not-found.php");
        exit();
}
 ?>

<div class="clearfix banner">
	<div class="container">
    	<h1><?php echo $nameTITLE; ?></h1>
    </div>
</div>
<?php 
        if ( intval(count($rsDET)) > intval(0) )
            { 
                
               
                $masterID = (intval($rsDET[0]['governance_id']));      
                $masterNAME = (stripslashes($rsDET[0]['governance_name']));      
                $masterEMAIL = (stripslashes($rsDET[0]['governance_email']));  
                $masterPROFESSION = (stripslashes($rsDET[0]['governance_profession'])); 
                $masterPOST = (stripslashes($rsDET[0]['governance_post']));
                $masterURLKEY = (stripslashes($rsDET[0]['url_key']));
                $masterPROFILE = (stripslashes($rsDET[0]['governance_profile']));
                $masterIMG = (stripslashes($rsDET[0]['image_name']));
                $alt_txt = $masterNAME;

                $DISPLAY_IMG = "";
                $R200_IMG_EXIST =  "";
                
                $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_GOVERNANCE. "/" . $masterIMG);
                
                if( intval($R200_IMG_EXIST) == intval(1) )
                {
                    $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_GOVERNANCE. "/" . $masterIMG;
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
            <!--div class="team_ades">
                <?php 
                  /*  if($masterEMAIL !="")
                    {
                ?>
                        <h6>Email:
                            <a href="mailto:<?php echo $masterEMAIL; ?>"><?php echo $masterEMAIL; ?></a>
                        </h6>
                <?php } */?>
            </div-->
            <div class="team_back">
            	<p>
                	<a href="<?php echo SITE_ROOT . urlRewrite(MAIN_PAGE,  array("master_url"=>$type_url_key, "url_key" => $subtype_key)); ?>"><span data-hover="back to previous page">back to previous page</span></a>
                </p>
            </div>
        </div>
                <div class="col-md-9 col-sm-8 led_team_right">
                	<div class="team_right_cp">
                        <h5><?php echo $masterPOST; ?></h5>
                        <h3><?php echo $masterNAME; ?></h3>
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