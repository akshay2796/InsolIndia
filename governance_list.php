<?php
ob_start();
include('header.php'); 
define("PAGE_MAIN","governance_detail.php");

$url_key = trustme($_REQUEST['url_key']);

$rsDET = getDetails(GOVERNANCE_TYPE_TBL, '*', "status~~~url_key","ACTIVE~~~$url_key",'=~~~=~~~=', '', '' , "");
if(intval(count($rsDET)) == intval(0)){
   header("location: ".SITE_ROOT."not-found.php");
    exit();
}
$typeDESCRIPTION = "";
$typeDESCRIPTION = (stripslashes($rsDET[0]['type_description']));
$typeNAME = (stripslashes($rsDET[0]['type_name']));
$typeID = intval($rsDET[0]['type_id']);
     
    
?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Governance</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
             <?php include 'organisations_left_menu.php'; ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right pagination__list">
        	<h2><?php echo $typeNAME; if(($url_key == "board-of-governors") || ($url_key == "judges-advisory-board") ){?> <span style="font-size: 18px;">(In Alphabetical Order)</span> <?php } ?></h2>
            <?php 
                if($typeDESCRIPTION != ""){
            ?>
			<p> <?php echo $typeDESCRIPTION; ?> </p>
           	
			<p></p>
			<div class="redLine"></div>
           <?php } ?>
			<p></p>
            <div class="clearfix organisation">
                    <?php 
                    //$typdVAL = getDetails(GOVERNANCE_TBL, '*', "status~~~type_id","ACTIVE~~~$typeID",'=~~~=~~~=', 'governance_name', '' , ""); 
                    //$numGOV = count($typdVAL);
                    
                    
                   
                    $SQL1  = ""; 
                    $SQL1 .= " SELECT COUNT(*) AS CT FROM " . GOVERNANCE_TBL . " as G "; 
                    $SQL1 .= " WHERE status = 'ACTIVE' AND type_id = :type_id  ";
                    $SQL1 .= " $search "; 



                    $SQL = "";
                    $SQL .= " SELECT * ";
                    $SQL .= " FROM ".GOVERNANCE_TBL;
                    $SQL .= " WHERE status = 'ACTIVE' ";
                    $SQL .= " AND type_id =:type_id ";
                    if(($url_key == "board-of-governors") || ($url_key == "judges-advisory-board")){
                        
                        $SQL .= " order by governance_name, position";
                    }else{
                    $SQL .= " order by position ";
                   }
                  
                   $stmt1 = $dCON->prepare($SQL1);  

                    $stmt1->bindParam(":type_id", $typeID); 
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
                    
                    $stmt2 = $dCON->prepare($SQL); 
                    $stmt2->bindParam(":type_id", $typeID); 
                    $stmt2->execute();
                    
                    $typdVAL = $stmt2->fetchAll();
                   
                    $noOfRecords = count($typdVAL);
                    $dA = $noOfRecords; 
                    $stmt2->closeCursor(); 

                ?>
                <div id="patrons" class="tab-pane fade in active">
                        <div class="clearfix org_section">
                        <?php
            
                            if($dA > intval(0))
                            { 
                                foreach($typdVAL as $rLIST)
                                {
                                    $masterID = "";
                                    $masterNAME = "";
                                    $masterTYPE = "";
                                    
                                    
                                    
                                    $masterIMG = "";
                                    $masterURLKEY = "";
                                    $masterURL = "";
                                    
                                    
                                    
                                    $masterSDESC = "";
                                     
                                    $masterID = intval($rLIST['governance_id']);
                                    $masterNAME = htmlentities(stripslashes($rLIST['governance_name']));
                                    $masterPOST = htmlentities(stripslashes($rLIST['governance_post']));
                                    $masterPROFESSION= htmlentities(stripslashes($rLIST['governance_profession']));
                                    $alt_text = $masterNAME;

                                    $masterIMG = stripslashes($rLIST['image_name']);
                                   
                                    $masterURLKEY = stripslashes($rLIST['url_key']);
                                    $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("master_url"=>$url_key, "url_key" => $masterURLKEY));
                                    
                                    
                                    $DISPLAY_IMG = "";
                                    $R200_IMG_EXIST =  "";
                                    
                                    $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_GOVERNANCE. "/R200-" . $masterIMG);
                                    
                                    if( intval($R200_IMG_EXIST) == intval(1) )
                                    {
                                        $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_GOVERNANCE. "/R200-" . $masterIMG;
                                    }
                                    else
                                    {
                                        $DISPLAY_IMG = SITE_IMAGES."no_image_profile.jpg";
                                    }
                                        
                                       // $masterURL = "<a href='" . $masterURL . "' >";
                                        
                                   
                                    
                                ?>  
                                    <div class="col-md-6 col-sm-12 col-xs-12 org_sec profileH">
                                        <div class="org_sec_img">
                                            <img src="<?php echo $DISPLAY_IMG; ?>">
                                        </div>
                                        <div class="org_sec_text">
                                            <h5><?php echo $masterPOST; ?></h5>
                                            <h3><?php echo $masterNAME; ?></h3>
                                            <p><?php echo $masterPROFESSION; ?></p>
                                            <h6>
                                                <a href="<?php echo $masterURL; ?>">view profile</a>
                                            </h6>
                                        </div>
                                    </div>
                            
                            <?php
                        } ?> 
                            
                        </div>

                       <?php

                           /* if(trim($paging[0]) != "")
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
                                    } */
                    }else{
                        echo "Under Formation....";
                    }
                            ?>
                    </div>

                </div>

            </div>
        
        </div>
    </div>
</div>
<?php include('footer.php'); ?>