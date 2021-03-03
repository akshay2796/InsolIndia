<?php 
include('header.php');
define("PAGE_MAIN", "sig24.php");
$url_key = trustme($_REQUEST['url_key']);
$rsDET = getDetails(SIG24_TBL, '*', "status~~~url_key","ACTIVE~~~$url_key",'=~~~=~~~=', '', '' , "");
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>SIG 24</h1>
    </div>
    
</div>

<?php 
    if(intval(count($rsDET)) > intval(0))
    { 
?>
    <link rel="stylesheet" href="<?php echo SITE_CSS; ?>video-js.css">
    <script src="<?php echo SITE_JS; ?>video.js"></script>
    <link rel="stylesheet" href="<?php echo SITE_CSS; ?>venobox.css" type="text/css" media="screen" />
<?php
        $masterFDATE ="";
        $masterTDATE ="";
        $masterFTIME ="";
        $masterTTIME ="";
        $masterFILE = "";

        $masterID = (intval($rsDET[0]['sig24_id'])); 
        $masterFDATE = stripslashes($rsDET[0]['sig24_date']);
		$url = stripslashes($rsDET[0]['url']);
		$masterIMG = stripslashes($rsDET[0]['image_name']);
		$imgEXIST =  "";
		$imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_SIG24. "/" . $masterIMG);
		
		$showIMG = "";                     
		if( intval($imgEXIST) == intval(1) ){
			$showIMG = MODULE_FILE_FOLDER . FLD_SIG24. "/" . $masterIMG;
		}else{
			$showIMG = "";         
		} 
        
?>
<div class="container">

    
    	<div class="gallery_list">
            <p>
                <a href="<?php echo SITE_ROOT. urlRewrite(PAGE_MAIN);?>">
                    <span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
       
        
		
	
		
   
    
    <!------------=======NEW LOOK=========------->
    
     <div class="clearfix sigWrap">
		
        	<div class="imgWrap">
            	<a href="<?php echo $url; ?>" target="_blank">
                	<img src="<?php echo  $showIMG; ?>">
                </a>
            </div>
            <div class="descWrap">
            	<h3><a href="<?php echo $url; ?>" target="_blank"><?php echo stripslashes($rsDET[0]['company_name']); ?></a></h3>
                <p>
                <?php echo stripslashes($rsDET[0]['brief_description']); ?>    
                </p>
                
             </div>
        </div>
    
     <!------------=======NEW LOOK=========------->

   

    
</div>
<?php } ?>

<?php include('footer.php'); ?>