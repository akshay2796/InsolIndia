<?php include('header.php'); 
define("PAGE_MAIN", "sig24_detail.php");
//==============Intro content Starts	
	$introSQL = " SELECT * FROM " . SIG24_INTRO_TBL. " WHERE intro_id = 1001";
	$stmt_intro = $dCON->prepare($introSQL);
	$stmt_intro->execute();
	$data = $stmt_intro->fetch();
	$intro_content = stripslashes($data['intro_content']);  

			
//==========Intro Content Ends
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>SIG 24</h1>
    </div>
</div>

<div class="container">
	
    <div class="clearfix inner_page media_page pagination__list">
    <p style="font-size: 16px !important; color: #333 !important;"><?php echo $intro_content; ?></p>
    <br><br>
    <?php  
			
			
			$SQL_CT = "";
            $SQL_CT = "SELECT COUNT(*) AS CT FROM ".SIG24_TBL." WHERE status = 'ACTIVE'";
            $SQL = "";
            $SQL = "SELECT * FROM ".SIG24_TBL." WHERE status = 'ACTIVE' ORDER BY position ASC";
            
            $stmt1 = $dCON->prepare($SQL_CT);
            $stmt1->execute();
            $noOfRecords_row = $stmt1->fetch();
            $noOfRecords = intval($noOfRecords_row['CT']);
            $rowsPerPage = 10000;

            $pg_query = $pg->getPagingQuery($SQL, $rowsPerPage);
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
            if(intval($dA) > 0){
                foreach($rsLIST AS $r){
                    $masterURLKEY = stripslashes($r['url_key']);
					$masterURL = stripslashes($r['url']);
                    
                    $image_name = $r['image_name'];
                    
                    $detailURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));

                    $DISPLAY_IMG = "";
                    $IMG_EXISTS = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_SIG24 .'/'. $image_name);
                    if(intval($IMG_EXISTS) == intval(1)){
                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_SIG24  .'/'. $image_name;
                    }else{
                        $DISPLAY_IMG =  SITE_IMAGES . 'no_images.jpg';
                    }
    ?>
		
        <div class="clearfix sigWrap">
		
        	<div class="imgWrap">
            	<a href="<?php echo $masterURL; ?>" target="_blank">
                	<img src="<?php echo  $DISPLAY_IMG; ?>">
                </a>
            </div>
            <div class="descWrap">
            	<h3><a href="<?php echo $masterURL; ?>" target="_blank"><?php echo $r['company_name']; ?></a></h3>
                <p>
                <?php $content = trustme($r['brief_description']);
                    $word_count = str_word_count($content); 
                      echo limit_words($content, 70); 
                      if($word_count > intval(70))
                      {
                        echo '...'." ".'<a href='. $detailURL . ' >Read More</a>';
                      }
                 ?>    
                </p>
                
                
                
             </div>
        </div>
        <?php } 
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
                 

        } else{
            echo "Under Formation......";
            } ?>        
    </div>
</div>
<?php include('footer.php'); ?>