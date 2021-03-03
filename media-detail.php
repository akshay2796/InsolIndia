<?php
ob_start();
include('header.php'); 
define("MAIN_PAGE", "media.php");
$URLKEY = trustme($_REQUEST['url_key']); 
$rsDET = getDetails(MEDIA_TBL, '*', "status~~~url_key","ACTIVE~~~$URLKEY",'=~~~=~~~=', '', '' , "");

if(intval(count($rsDET)) == intval(0)){
   header("location: ".SITE_ROOT."not-found.php");
    exit();
} 

?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Media</h1>
    </div>
</div>
 <link rel="stylesheet" href="<?php echo SITE_CSS; ?>video-js.css">
 <script src="<?php echo SITE_JS; ?>video.js"></script>
<?php
    if ( intval(count($rsDET)) > intval(0) )
    { 
        $masterVTITLE = "";
        $masterVTYPE = "";
        $masterVEMBED = "";
        $masterVFILE = "";
       
        $masterID = (intval($rsDET[0]['media_id']));      
        $masterCAT = (intval($rsDET[0]['category_id']));      
        $masterNAME = (stripslashes($rsDET[0]['media_name']));      
        $masterPUBLISHER = (stripslashes($rsDET[0]['media_publisher']));      
        $masterFDATE = strtotime(stripslashes($rsDET[0]['media_from_date']));
        
        
        $masterDETAIL = (stripslashes($rsDET[0]['media_description']));
        $masterURLKEY = (stripslashes($rsDET[0]['url_key']));
        
        $masterVTITLE = (stripslashes($rsDET[0]['video_title']));
        $masterVTYPE = (stripslashes($rsDET[0]['video_type']));
        $masterVEMBED = (stripslashes($rsDET[0]['embed_code']));
        $masterVFILE = (stripslashes($rsDET[0]['video_file']));
        
         
        $rsCAT = getDetails(MEDIA_CATEGORY_TBL, '*', "status~~~category_id","ACTIVE~~~$masterCAT",'=~~~=', '', '' , "");
        $catNAME = (stripslashes($rsCAT[0]['category_name']));                    
        $catKEY = (stripslashes($rsCAT[0]['url_key']));
                
            ?>
<div class="container">
    <div class="clearfix inner_page events_list">
    	<div class="gallery_list">
            <p>
                <a href="<?php echo SITE_ROOT . urlRewrite(MAIN_PAGE); ?>">
                    <span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
        <h2><?php echo $masterNAME; ?></h2>
        <h4>
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span><?php echo date("d F, Y",$masterFDATE); ?></span>
        	|
            <i class="fa fa-user" aria-hidden="true"></i>
            <span><?php echo $masterPUBLISHER; ?></span>
        </h4>
        <p>
            <?php echo $masterDETAIL; ?>
        </p>
        
        <div class="event_gallery">
            <?php $rsIMG = getDetails(MEDIA_IMAGES_TBL, '*', "status~~~master_id","ACTIVE~~~$masterID",'=~~~=', ' default_image DESC, position ', '' , "");
        
                if ( intval(count($rsIMG)) > intval(0) )
                    { 
            ?>
        	<h2>IMAGE GALLERY (Click to expand)</h2>
            <?php } ?>
        	<ul class="clearfix event-list"> 
            <?php
                 
                if ( intval(count($rsIMG)) > intval(0) )
                    { 
                        foreach($rsIMG as $rIMG)
                        {
                            $masterIMG = (stripslashes($rIMG['image_name']));                    
                            $masterCAPTION = (stripslashes($rIMG['image_caption']));                    
                            $fullIMG = MODULE_FILE_FOLDER . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/" . $masterIMG;
                                               
                            $imgEXIST =  "";
                            $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/R500-" . $masterIMG);
                            $bigIMG =  "";
                            $bigIMG = SITE_URL . MODULE_UPLOADIFY_ROOT . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/" . $masterIMG;
                            
                            $showIMG = "";
                            if( intval($imgEXIST) == intval(1) )
                                {
                                    $showIMG = MODULE_FILE_FOLDER . FLD_MEDIA . "/" . FLD_MEDIA_IMG . "/R500-" . $masterIMG;
                                }else{
                                    $showIMG = "";         
                                } 
                                if ( trim($showIMG) != "" )
                                {
                ?>
                                 <li>
                                 	<span>
                                        <a href="<?php echo $showIMG; ?>">
                                            <img src="<?php echo $showIMG; ?>" />
                                        </a>
                                    </span>
                                </li>   
                <?php 
                                }
                        }
                    } 

                ?>             
                
            </ul>

        </div> 

        <!-- =========================== video=============================-->
        <?php  
                    
                    if ( trim($masterVTYPE) == trim("VIDEO_FILE") ){
                        // FILE ===========
                       
                        $pathFILE = MODULE_FILE_FOLDER . FLD_MEDIA . "/" . FLD_MEDIA_VDO . "/" . $masterVFILE;
                        $fileEXIST =  "";
                        $fileEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_MEDIA . "/" . FLD_MEDIA_VDO . "/" . $masterVFILE);
                        if( intval($fileEXIST) == intval(1) ){
                            $showFILE = MODULE_FILE_FOLDER . FLD_MEDIA . "/" . FLD_MEDIA_VDO . "/" . $masterVFILE;
                        }else{
                            $showFILE = "";
                        }
                     
                    ?>
                        <h3 class="subHead"><?php 
                        if ( trim($showFILE) != "")
                        { 
                            echo $masterVTITLE;
                        ?></h3>                       
                            <video id="edv1" class="video-js vjs-default-skin embed-responsive-item" 
                                controls preload="none" poster=''
                                data-setup='{ "aspectRatio":"640:267", "playbackRates": [1, 1.5, 2] }'>
                                <source src="<?php echo  $showFILE; ?>" type='video/mp4' />
                            </video>  
                        <?php   
                        } 
                        ?>                              
                        
                        
                    <?php    
                    }elseif ( trim($masterVTYPE) == trim("VIDEO_EMBED") ){
                    ?>
                        <h3 class="subHead"><?php if ( trim($masterVEMBED) != ""){ echo $masterVTITLE; } ?></h3>                              
                        <?php echo  $masterVEMBED; ?>
                        
                    <?php    
                    }    
                    ?>

          <!--========================FOR VIDEO End=========================-->
          

                
    </div>
</div>
<?php } ?>
<script type="text/javascript">
	$(document).ready(function() {
		$(".event-list").lightGallery({
			autoplay: true,
			selector: 'li a',
			width: '1142px',
			height: '100%',
			mode: 'lg-fade',
			addClass: 'fixed-size',
			counter: false,
			download: false,
			startClass: '',
			enableSwipe: true,
			enableDrag: false,
			speed: 500,
			share: false,
			autoplayControls: false,
			actualSize: false
		}); 
	});
</script>
<?php include('footer.php'); ?>