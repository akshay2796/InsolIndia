<?php include('header.php'); 
    define("PAGE_MAIN","gallery-detail.php");  
    define("PAGE_LIST","gallery.php");

    $SQL1  = ""; 
    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . GALLERY_TBL . " as G "; 
    $SQL1 .= " WHERE status = 'ACTIVE' and gallery_name !=''  ";
    $SQL1 .= " $search ";



    $SQL = "";
    $SQL .= " SELECT * ";
    $SQL .= ",(SELECT image_name FROM ". GALLERY_IMAGES_TBL ." AS I WHERE I.master_id = G.gallery_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
    $SQL .= " FROM " . GALLERY_TBL . " as G WHERE status = 'ACTIVE' and gallery_name !='' ";
    $SQL .= " $search ";
    $SQL .= " order by gallery_date desc ";
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
    	<h1>Gallery</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page gallery pagination__list">
        <?php
            
            if($dA > intval(0))
            { 
                foreach($rsLIST as $rLIST)
                {
                    $masterID = "";
                    $masterNAME = "";
                    
                    
                    $masterIMG = "";
                    $masterURLKEY = "";
                    $masterURL = "";
                    $masterFDATE = "";
                    
                    
                    $masterSDESC = "";
                     
                    $masterID = intval($rLIST['gallery_id']);
                    $masterNAME = htmlentities(stripslashes($rLIST['gallery_name']));
                    
                
                    $alt_text = $masterNAME;

                    
                    $masterFDATE = (stripslashes($rLIST['gallery_date']));
                                    
                    if ( (trim($masterFDATE) != "0000-00-00") || (trim($masterFDATE) != "") ){
                        
                        $masterFDATE = date("d F, Y", strtotime($masterFDATE)); 
                    } 
                    
                   
                       
                        $masterIMG = stripslashes($rLIST['image_name']);
                       
                        $masterURLKEY = stripslashes($rLIST['url_key']);
                        $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));
                        
                        
                        $DISPLAY_IMG = "";
                        $R200_IMG_EXIST =  "";
                        
                        $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R200-" . $masterIMG);
                        
                        if( intval($R200_IMG_EXIST) == intval(1) )
                        {
                            $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_GALLERY . "/" . FLD_GALLERY_IMG . "/R200-" . $masterIMG;
                        }
                        else
                        {
                            $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                        }
                        
                       // $masterURL = "<a href='" . $masterURL . "' >";
                        
                   
                    
                ?>  
                        <div class="col-md-3 col-sm-4 gallery_sec">
                        	<div class="gallery_img">
                            	<a href="<?php echo $masterURL; ?>">
                                	<div class="tp-img">
                                    	<img src="<?php echo $DISPLAY_IMG; ?>" alt="<?php echo $alt_text; ?>">
                                    </div>
                                    <span class="view_all">
                                    	<i class="fa fa-camera" aria-hidden="true"></i>
                                    </span>
                                    <div class="gallery_text">
                                        <h3><?php echo $masterNAME; ?></h3>
                                        
                                    </div>
                                </a>
                            </div>
                        </div>

                    <?php
                }
                
                
            ?>
    </div>
    <?php
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
            } ?>


</div>
</div>
<script>
	$(document).ready(function(){
	// equal height div
		equalheight = function(container){
		
		var currentTallest = 0,
			 currentRowStart = 0,
			 rowDivs = new Array(),
			 $el,
			 topPosition = 0;
		$(container).each(function() {
		
		 $el = $(this);
		 $($el).height('auto')
		 topPostion = $el.position().top;
		
		 if (currentRowStart != topPostion) {
			 for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
				 rowDivs[currentDiv].height(currentTallest);
			 }
			 rowDivs.length = 0; // empty the array
			 currentRowStart = topPostion;
			 currentTallest = $el.height();
			 rowDivs.push($el);
		 } else {
			 rowDivs.push($el);
			 currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		}
		 for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			 rowDivs[currentDiv].height(currentTallest);
		 }
		});
		}
		
		equalheight('.gallery_text');
		
		$(window).load(function(){
			equalheight('.gallery_text');
		});
		
		$(window).resize(function(event) {
			equalheight('.gallery_text');
		});
	});
</script>
<?php include('footer.php'); ?>
 