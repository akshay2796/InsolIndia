<?php
ob_start();
include('header.php'); 
define("MAIN_PAGE", "gallery.php");
$URLKEY = trustme($_REQUEST['url_key']);
$rsDET = getDetails(GALLERY_TBL, '*', "status~~~url_key","ACTIVE~~~$URLKEY",'=~~~=~~~=', '', '' , ""); 

if(intval(count($rsDET)) == intval(0)){
   header("location: ".SITE_ROOT."not-found.php");
    exit();
}

if ( intval(count($rsDET)) > intval(0) )
{ 
    $masterNAME = (stripslashes($rsDET[0]['gallery_name']));   //for Gallery Name
}
    
?>

<div class="clearfix banner">
	<div class="container">
    	<h1><?php echo $masterNAME; ?></h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
    	<div class="gallery_list">
        	<p>
            	<a href="<?php echo SITE_ROOT . urlRewrite(MAIN_PAGE); ?>">
                	<span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
        <ul class="gallery-list">  
        <?php
    if ( intval(count($rsDET)) > intval(0) )
    { 
        
       
        $masterID = (intval($rsDET[0]['gallery_id']));      
        $masterNAME = (stripslashes($rsDET[0]['gallery_name']));      
          
        $masterFDATE = strtotime(stripslashes($rsDET[0]['gallery_date']));
        
        $masterURLKEY = (stripslashes($rsDET[0]['url_key']));

        $rsIMG = getDetails(GALLERY_IMAGES_TBL, '*', "status~~~master_id","ACTIVE~~~$masterID",'=~~~=', ' default_image DESC, position ', '' , ""); 

        if ( intval(count($rsIMG)) > intval(0) )
                    { 
                        foreach($rsIMG as $rIMG)
                        {
                            $masterIMG = (stripslashes($rIMG['image_name']));                    
                            $masterCAPTION = (stripslashes($rIMG['image_caption']));                    
                            $fullIMG = MODULE_FILE_FOLDER . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/" . $masterIMG;
                                               
                            $imgEXIST =  "";
                            $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R500-" . $masterIMG);
                            $bigIMG =  "";
                            $bigIMG = SITE_URL . MODULE_UPLOADIFY_ROOT . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/" . $masterIMG;
                            
                            $showIMG = "";
                            if( intval($imgEXIST) == intval(1) )
                                {
                                    $showIMG = MODULE_FILE_FOLDER . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R500-" . $masterIMG;
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
                                            <div class="demo-gallery-poster">
                                                <img src="<?php echo SITE_IMAGES;?>zoom.png" />
                                            </div>
                                        </a>
                                    </span>
                                </li>        

                                <?php 
                                }
                        }
                    } 

                ?>               
            <!-- <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li>
            <li>
                <a href="images_insol/project1.jpg">
                    <img src="images_insol/project1.jpg" />
                    <div class="demo-gallery-poster">
                        <img src="images_insol/zoom.png" />
                    </div>
                </a>
            </li> -->
            
        </ul>
        <?php
    }
        ?>
        
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		$(".gallery-list").lightGallery({
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