<?php
ob_start();
include('header.php');
define("PAGE_MAIN", "events.php");
$url_key = trustme($_REQUEST['url_key']);
$rsDET = getDetails(EVENT_TBL, '*', "status~~~url_key","ACTIVE~~~$url_key",'=~~~=~~~=', '', '' , "");

if(intval(count($rsDET)) == intval(0)){
   header("location: ".SITE_ROOT."not-found.php");
    exit();
}
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Events</h1>
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

        $masterID = (intval($rsDET[0]['event_id'])); 
        $masterFDATE = stripslashes($rsDET[0]['event_from_date']);
        $masterTDATE = stripslashes($rsDET[0]['event_to_date']);
        $masterFTIME = stripslashes($rsDET[0]['event_from_time']);
        $masterTTIME = stripslashes($rsDET[0]['event_to_time']);

        $masterFILE = (stripslashes($rsDET[0]['file_name']));

        $masterVTITLE = (stripslashes($rsDET[0]['video_title']));
        $masterVTYPE = (stripslashes($rsDET[0]['video_type']));
        $masterVEMBED = (stripslashes($rsDET[0]['embed_code']));
        $masterVFILE = (stripslashes($rsDET[0]['video_file']));
        
        if(($masterTTIME !="") && ($masterFTIME !=""))
        {
             $masterFTIME = date("hA", strtotime($masterFTIME));
             $masterTTIME = date("hA", strtotime($masterTTIME));
        }
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
?>
<div class="container">

    <div class="clearfix inner_page events_list">
    	<div class="gallery_list">
            <p>
                <a href="<?php echo SITE_ROOT . urlRewrite(PAGE_MAIN); ?>">
                    <span data-hover="back to previous page">back to previous page</span>
                </a>
            </p>
        </div>
        <h2><?php echo stripslashes($rsDET[0]['event_name']);?></h2>
        <h4>
            <i class="fa fa-calendar" aria-hidden="true"></i>
            <span><?php echo $dateDisplay; if($masterFTIME != ""){ echo " ".$masterFTIME; } if($masterTTIME != ""){ echo " to ".$masterTTIME; } ?></span> | <i class="fa fa-map-marker" aria-hidden="true"></i>
            <span><?php echo stripslashes($rsDET[0]['event_venue']); ?></span>
        </h4>
        <?php
                    //IMG ==========
                    $iCNT = 1;
                    $rsIMG = getDetails(EVENT_IMAGES_TBL, '*', "status~~~master_id","ACTIVE~~~$masterID",'=~~~=', ' default_image DESC, position ', '' , "");
                    if ( intval(count($rsIMG)) > intval(0) ){
                    ?> 
                        <div class="eventImg" style="max-width:50%; float:left; margin:0 30px 30px 0;">
                            <div id="galleria">
                                <?php 
                                foreach($rsIMG as $rIMG){
                                    
                                    $masterIMG = (stripslashes($rIMG['image_name']));                    
                                    $masterCAPTION = (stripslashes($rIMG['image_caption']));                    
                                    $fullIMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/" . $masterIMG;
                                                       
                                    $imgEXIST =  "";
                                    $imgEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R500-" . $masterIMG);
                                    $bigIMG =  "";
                                    $bigIMG = SITE_URL . MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_IMG . "/" . $masterIMG;
                                    
                                    $showIMG = "";                     
                                    if( intval($imgEXIST) == intval(1) ){
                                        $showIMG = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_IMG . "/R500-" . $masterIMG;
                                    }else{
                                        $showIMG = "";         
                                    } 
                                    
                                    if ( trim($showIMG) != "" ){
                                        
                                        if( intval($iCNT) == intval(1) ){
                                ?>        
                                            
                                            
                                            <div class="bigImg">
                                              <a class="" data-num="0" href="javascript:void(0)"><img src="<?php echo $showIMG; ?>" name="viewer" class="bigSizeImage" id="viewer" title="<?php echo $masterCAPTION; ?>" alt="<?php echo $masterCAPTION; ?>" /></a>
                                            </div>
                                            
                                            
                                            <div class="thumbSizeWrap">
                                                <ul>                                                    
                                <?php
                                        }
                                ?>        
                                        
                                            
                                        
                                                    <li><a title="<?php echo $masterCAPTION; ?>" <?php if( intval($iCNT) == intval(1) ){ ?> class="venobox my-gallery-class" <?php }else{ ?> class="venobox image-link my-gallery-class" <?php } ?> href="<?php echo $bigIMG; ?>" data-gall="gall1"></a><span onClick="ChangeImage('<?php echo $bigIMG; ?>','<?php echo $showIMG; ?>',0);"><img src="<?php echo $showIMG; ?>" style="cursor: pointer;" /></span></li>
                                             
                                <?php
                                        if( intval($iCNT) == intval(count($rsIMG)) ){
                                ?>            
                                                </ul>
                                            </div> 
                                <?php
                                        }
                                ?>            
                                                          
                                <?php  
                                    }        
                                    
                                    //echo $bigIMG . "<BR>";
                                    
                                    $iCNT++;   
                                } 


                                ?>
                            </div> 
                        </div>
                        <script type="text/javascript">
                        $(document).ready(function(){
                            
                                $('.venobox').venobox({
                                    numeratio: true,
                                    infinigall: false,
                                    border: '0px'
                                });     
                              
                                $(".thumbSizeWrap ul li").click(function(event) {
                                    var $index = $(this).index();  
                                    $(".bigImg a").removeAttr('data-num').attr('data-num',$index);
                                    $(".bigImg a img").attr('title',$(this).find('a').attr('title'));
                                });  
                                    
                                $(".bigImg a").click(function(event) {
                                    var $thisindex = $(this).attr("data-num");
                                    console.log($thisindex);                             
                                    $(".thumbSizeWrap ul li:eq("+$thisindex+") a").trigger('click');
                                
                                });   
                          
                            })
                    
                            function ChangeImage(a,b,pindx) 
                            {               
                                document.getElementById("viewer").src = b;
                                // $(".image-link:eq(0)").attr("href", a); 
                                // $(".my-gallery-class").addClass("image-link");
                                // $(".my-gallery-class:eq(" + pindx + ")").removeClass("image-link");                                  
                            }  
                        </script>
                        <script src="<?php echo SITE_JS; ?>venobox.min.js"></script>
                                                                                      
                    <?php
                    }                                                   
                    ?>
        <?php echo stripslashes($rsDET[0]['event_description']); 

        if($masterFILE != "")
        {
            $masterLINKFILE = SITE_URL . MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_FILE . "/" . $masterFILE;
        
        ?>

        <!--=============================pdf download==============================-->
            <P style="margin: 15px 0;"><a href="<?php echo $masterLINKFILE; ?>" class="btn btn-primary" target="_blank">View / Download File</a></P>

        <?php 

         } 

         ?>
    </div>

    <!--=======================VIDEO=====================================-->
    <div class="clearfix s_vid">
    	<?php  
                    
                    if ( trim($masterVTYPE) == trim("VIDEO_FILE") ){
                        // FILE ===========
                       
                        $pathFILE = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_VDO . "/" . $masterVFILE;
                        $fileEXIST =  "";
                        $fileEXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_EVENT . "/" . FLD_EVENT_VDO . "/" . $masterVFILE);
                        if( intval($fileEXIST) == intval(1) ){
                            $showFILE = MODULE_FILE_FOLDER . FLD_EVENT . "/" . FLD_EVENT_VDO . "/" . $masterVFILE;
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
    </div>


    <!--=======================VIDEO=====================================-->
</div>
<?php } ?>

<?php include('footer.php'); ?>