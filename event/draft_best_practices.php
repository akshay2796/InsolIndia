<?php include('header.php');

//==============Intro content Starts	
	$introSQL = " SELECT * FROM " . DRAFT_BEST_PRACTICES_INTRO_TBL. " WHERE intro_id = 1001";
	$stmt_intro = $dCON->prepare($introSQL);
	$stmt_intro->execute();
	$data = $stmt_intro->fetch();
	$intro_content = stripslashes($data['intro_content']);  
			
//==========Intro Content Ends

 ?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Draft Insolvency Best Practices</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page sipi">
		<p><?php echo $intro_content; ?></p>
       
		<div class="redLine"></div>
        <?php 
        	$SQL_CT = "";
            $SQL_CT = "SELECT COUNT(*) AS CT FROM ".DRAFT_BEST_PRACTICES_TBL." WHERE status = 'ACTIVE'";
            $SQL = "";
            $SQL = "SELECT * FROM ".DRAFT_BEST_PRACTICES_TBL." WHERE status = 'ACTIVE' ORDER BY position ASC";
            
            $stmt1 = $dCON->prepare($SQL_CT);
            $stmt1->execute();
            $noOfRecords_row = $stmt1->fetch();
            $noOfRecords = intval($noOfRecords_row['CT']);
            $rowsPerPage = 6;

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
                    $titleNAME = stripslashes($r['title_name']);
					$filename = stripslashes($r['file_name']);
                    $brief_description = stripslashes($r['brief_description']);
                   
                        
                        $FTYPE_PATH = MODULE_UPLOADIFY_ROOT . FLD_DRAFT_BEST_PRACTICES . "/" . FLD_DRAFT_BEST_PRACTICES_FILE . "/" . $filename;    
                        $chKFTYPE = chkImageExists($FTYPE_PATH); 
                    
                    $masterURL =  $FTYPE_PATH ;

                  /*$DISPLAY_FILE = "";
                    $FILE_EXISTS = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_DRAFT_BEST_PRACTICES .'/'.FLD_DRAFT_BEST_PRACTICES_FILE.'/'. $filename);
                    if(intval($FILE_EXISTS) == intval(1)){
                        $DISPLAY_FILE = SITE_ROOT . FLD_DRAFT_BEST_PRACTICES  .'/'.FLD_DRAFT_BEST_PRACTICES_FILE.'/'. $filename;
                    }else{
                        $DISPLAY_FILE =  "";
                    } */
                    
    ?>
		<div class="practicesWrap">
			<h3><a href="<?php echo $masterURL; ?>" target="_blank"><?php echo $titleNAME; ?></a></h3>
			<p><?php echo $brief_description; ?></p>
            <?php
                if($filename != "")
                {
            ?>
			         <a href="<?php echo $masterURL; ?>" class="btn btn-primary" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Read more</a>
             <?php
                }
             ?>
			<p class="pull-right" style="font-size: 14px; color: #A91025;">You are invited to submit your comments, if any, on the draft best practices by  <a href="mailto:bestpractices@insolindia.com" target="_blank">clicking here</a>.</p>
            <div class="clearfix"></div>
        </div>
		<!--div class="practicesWrap">
			<h3><a href="#/">SIPI has set up a Task Force on Insolvency Best Practices</a></h3>
			<p>Improve and the mutual trust between as well as the trust in the Insolvency Professionals work by the general public would be enhanced. Consequently Insolvency Professionals would be able to work more efficiently, which once again would enhance the trust in the insolvency profession on the market. </p>
			<a href="#" class="btn btn-primary"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Read more</a>
			<p class="pull-right" style="font-size: 13px;">You are invited to submit your comments, if any, on the draft best practices by  <a href="mailto:bestpractices@insolindia.com" target="_blank">clicking here</a>.</p>
		</div> -->
        
        <?php
        
                }
            }else{
                echo "You are invited to submit your comments, if any, on the draft best practices by  <a href='mailto:bestpractices@insolindia.com'>clicking here</a>.";
            }
        ?>
        
        
        
        
        
		
       
       
        
    </div>
</div>
<?php include('footer.php'); ?>