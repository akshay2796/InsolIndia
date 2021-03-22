<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","newsletter.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");
define("PAGE_PREVIEW","newsletter_preview.php");

define("PAGE_COMMON","ajax_common.php");


//$ID = intval(base64_decode($_REQUEST['ID']));

$ID = intval($_REQUEST['nid']);
$testmail = intval($_REQUEST['testmail']);
$mct = intval($_REQUEST['mct']);
 

if( (intval($ID) > intval(0)) )
{
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . NEWSLETTER_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND newsletter_id = :newsletter_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":newsletter_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    
    if(count($rsGET)==intval(0))
    {
        header("Location:".PAGE_MAIN);
    }
    
    $newsletter_subject = htmlentities(stripslashes($rsGET[0]['newsletter_subject'])); 
    $test_email = htmlentities(stripslashes($rsGET[0]['test_email'])); 
    $send_to_insol_member = intval($rsGET[0]['send_to_insol_member']); 
  
    
    $volume_name = htmlentities(stripslashes($rsGET[0]['volume_name'])); 
    $newsletter_issue = htmlentities(stripslashes($rsGET[0]['newsletter_issue'])); 
     
    $newsletter_date = stripslashes($rsGET[0]['newsletter_date']);
    if(trim($newsletter_date) != "" && $newsletter_date != "0000-00-00")
    {
        $newsletter_date = date('M d, Y' , strtotime($newsletter_date));    
    }
    else
    {
        $newsletter_date = "";
    }
    
   
}
else
{
     header("Location:".PAGE_MAIN);
}
?>

<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
     
<h1>
    Newsletter <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go to List</a></div>
</h1>

<div style="min-height:300px;"> 
    <div class="addWrapper" style="min-height:300px;">
        <div class="containerPad">
            <div class="fullWidth">
                <?php
                if(intval($testmail) > 0)
                {
                ?>
                    <div style="color:#1E6D42;font-size: 16px;">Test Mail successfully sent</div>
                <?php
                }
                ?>
                <br />
                <?php
                if(intval($mct) > 0)
                {
                ?>
                    <div style="color:#1E6D42;font-size: 16px;">(<?php echo $mct;?>) Insol Member - Mail successfully sent </div>
                <?php
                }
                ?>
                
                
            </div>
            <div class="fullWidth noGap">
                <a href="<?php echo PAGE_PREVIEW;?>?nid=<?php echo $ID;?>" class="backBtn"><< Back</a>
            </div>
        </div>
    </div>
</div>             
<?php include("footer.php");?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 