<?php 
ob_start();
include('header.php'); 

define("PAGE_MAIN","resource-detail.php");  
define("PAGE_LIST","resources.php");

$RAW_URL_KEY = trustme($_REQUEST['cat_url_key']); 

$EXP_RAW_URL_KEY = explode("/", $RAW_URL_KEY);
if(intval(count($EXP_RAW_URL_KEY)) > intval(0))
{
    $cat_url_key = $EXP_RAW_URL_KEY[0];
}
else
{
    $cat_url_key = trustme($_REQUEST['cat_url_key']); 
}

if(trim($cat_url_key) !='')
{
    $stmtCat = $dCON->prepare( " SELECT * FROM " . RESOURCES_CATEGORY_TBL . " AS TC WHERE TC.`status` = 'ACTIVE' AND TC.url_key = :url_key " );
    $stmtCat->bindParam(":url_key", $cat_url_key);
    $stmtCat->execute();
    $rowCat = $stmtCat->fetchAll();
    $stmtCat->closeCursor();
    
    $category_id = intval($rowCat[0]['category_id']);
    $category_name = stripslashes($rowCat[0]['category_name']);
}
else
{
    header("Location:".SITE_ROOT);
}


$search = "";
if(intval($category_id) > intval(0) ) 
{
    $search .= " AND R.category_id = :category_id ";
}

$SQL1  = ""; 
$SQL1 .= " SELECT COUNT(*) AS CT FROM " . RESOURCES_TBL . " as R "; 
$SQL1 .= " WHERE status = 'ACTIVE' and resources_name !=''  ";
$SQL1 .= " $search ";


$SQL = "";
$SQL .= " SELECT * ";
$SQL .= ",(SELECT image_name FROM ". RESOURCES_IMAGES_TBL ." AS I WHERE I.master_id = R.resources_id ORDER BY default_image DESC, position LIMIT 1 ) AS image_name ";
$SQL .= " FROM " . RESOURCES_TBL . " as R WHERE status = 'ACTIVE' and resources_name !='' ";
$SQL .= " $search ";
$SQL .= " order by resources_from_date desc ";
//echo $SQL;
$stmt1 = $dCON->prepare($SQL1);  
if(intval($category_id) > intval(0))
{
    $stmt1->bindParam(":category_id", $category_id) ;
}
$stmt1->execute();
$noOfRecords_row = $stmt1->fetch();
$noOfRecords = intval($noOfRecords_row['CT']);
$rowsPerPage = 6;

$pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
$stmt2 = $dCON->prepare($pg_query[0]);
if(intval($category_id) > intval(0)) 
{
    $stmt2->bindParam(":category_id", $category_id) ;
}
$stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
$stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
$offset = $pg_query[1];
$RPP = $rowsPerPage;
$paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
$dA = $noOfRecords;
 
$stmt2->execute();
$rsLIST = $stmt2->fetchAll();
$stmt2->closeCursor();

?>

<div class="clearfix banner">
	<div class="container">
    	<h1>Resources</h1>
    </div>
</div>

<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'resources_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
            <h2><?php echo $category_name;?></h2>
            <div class="row">
                <?php
                if($dA > intval(0))
                { 
                    foreach($rsLIST as $rLIST)
                    {
                        $masterID = "";
                        $masterNAME = "";
                        $masterTYPE = "";
                        $masterCATEGORY = "";
                        $masterIMG = "";
                        $masterURLKEY = "";
                        $masterURL = "";
                        $masterFDATE = "";
                        $masterSDESC = "";
                        $publication_year ="";
                        $publication_month ="";
                         
                        $masterID = intval($rLIST['resources_id']);
                        $masterNAME = htmlentities(stripslashes($rLIST['resources_name']));
                        $publication_year = htmlentities(stripslashes($rLIST['publication_year']));
                        $publication_month = htmlentities(stripslashes($rLIST['publication_month']));
                        $masterPUBLISHER = htmlentities(stripslashes($rLIST['resources_publisher']));
                        $masterTYPE = htmlentities(stripslashes($rLIST['resources_type']));
                        $masterCATEGORY= htmlentities(stripslashes($rLIST['category_name']));
                        $target_typ = "";
                        
                        $alt_text = $masterNAME;
    
                        
                        $masterFDATE = (stripslashes($rLIST['resources_from_date']));
                                        
                        if ( (trim($masterFDATE) != "0000-00-00") || (trim($masterFDATE) != "") ){
                            
                             $masterFDATE = date("d F Y", strtotime($masterFDATE)); 
                        } 
                        if($publication_year != "")
                        {
                            $date_display = $publication_month. " ".$publication_year; 
                        }else{
                            $date_display = $masterFDATE;
                        }                     
                        $masterSDESC = stripslashes($rLIST["resources_short_description"]); 
                       
                        
                        if ( trim($masterTYPE) == "CONTENT" )
                        {
                            
                          
                            $masterIMG = stripslashes($rLIST['image_name']);
                           
                            $masterURLKEY = stripslashes($rLIST['url_key']);
                            
                            
                            $masterURL = SITE_ROOT . urlRewrite(PAGE_MAIN, array("url_key" => $masterURLKEY));
                            
                            $DISPLAY_IMG = "";
                            $R200_IMG_EXIST =  "";
                            
                            $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG);
                            
                            if( intval($R200_IMG_EXIST) == intval(1) )
                            {
                                $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG;
                            }
                            else
                            {
                                $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                            }
                            
                           // $masterURL = "<a href='" . $masterURL . "' >";
                            
                        }
                        elseif ( trim($masterTYPE) == "FILE" )
                        {
                            
                            $masterFTYPEfile = stripslashes($rLIST['file_name']);
                            
                            $FTYPE_PATH = MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_FILE . "/" . $masterFTYPEfile;    
                            $chKFTYPE = chkImageExists($FTYPE_PATH); 
     
                            $masterURL =  SITE_ROOT . $FTYPE_PATH ;
                           //FOR IMAGES
    
                            $masterIMG = stripslashes($rLIST['image_name']);
                            $DISPLAY_IMG = "";
                            $R200_IMG_EXIST =  "";
                            
                            $R200_IMG_EXIST = chkImageExists(MODULE_UPLOADIFY_ROOT . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG);
                            
                            if( intval($R200_IMG_EXIST) == intval(1) )
                            {
                                $DISPLAY_IMG = MODULE_FILE_FOLDER . FLD_RESOURCES . "/" . FLD_RESOURCES_IMG . "/R200-" . $masterIMG;
                            }
                            else
                            {
                                $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                            }
                            
                            $target_typ = "target='_blank'";
                        }
                        elseif ( trim($masterTYPE) == "URL" )
                        {
                            $masterFTYPEurl = stripslashes($rLIST['resources_url']);    
                            
                            $masterURL =  $masterFTYPEurl ;
                            
                            $DISPLAY_IMG = SITE_IMAGES."no_images.jpg";
                            
                            $target_typ = "target='_blank'";
                        }
                        
                        /////////////////////////////////////////////////////////
                        if(LOGGED_IN == "YES") 
                        {
                            $masterURL = $masterURL;
                        }
                        else
                        {
                            $masterURL = SITE_ROOT .urlRewrite("login.php").$_SESSION['INCLUDE_QMARK']."ref=resources&ckey=".$cat_url_key;
                            $target_typ = "";
                        }
                       
                    ?>  
                        <div class="col-md-6 col-sm-6 col-xs-12 reso_sect eqH"> <!--======Loop Div=========-->
                            <div class="reso_sect_img publicationImg" style="position: relative;">
                                <img src="<?php echo SITE_IMAGES.'blankImg-lh.png'; ?>" style="width:100%;" />
                                <a href="<?php echo $masterURL; ?>" <?php echo $target_typ; ?> >
                                    <div class="ImgBoxOuter">
                                        <span class="ImgBoxInner"><img src="<?php echo $DISPLAY_IMG; ?>" class="imgSize img-zoom" alt=""/></span>
                                    </div>
                                </a>                               
                            </div>
                            <div class="reso_sect_text">
                            	<h3>
                                	<a href="<?php echo $masterURL; ?>" <?php echo $target_typ; ?>><?php echo $masterNAME; ?></a>
                                </h3>
                                <p>
                                    <?php echo limit_char(trustme($masterSDESC), 250); ?>
                                </p>
                                <h4>
                                	<i class="fa fa-calendar" aria-hidden="true"></i>
                                	<span><?php echo $date_display; ?></span>
                                </h4>
                                <?php 
                                    if($masterPUBLISHER !="")
                                    {
                                ?>
                                        <h4>
                                        	<i class="fa fa-user" aria-hidden="true"></i>
                                            <span><?php echo $masterPUBLISHER; ?></span>
                                        </h4>
                                <?php
                                    }
                                ?>
                            </div>
                        </div> <!--======Loop Div End=========-->
                  	<?php
                    }
                    
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
                }
                else
                {
                    echo '<div class="col-md-6 col-sm-6 col-xs-12 reso_sect eqH">';
                        echo "Under Formation...";
                    echo '</div>';
                }
                ?>
            </div>
		</div>
    </div>
</div>
<?php include('footer.php'); ?>