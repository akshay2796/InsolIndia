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
 
$govt_session_array = $_SESSION['GOVT_INFO_ARRAY'];

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
    $test_email = "";
    $newsletter_subject = htmlentities(stripslashes($rsGET[0]['newsletter_subject'])); 
    $test_email = htmlentities(stripslashes($rsGET[0]['test_email'])); 
    $send_to_insol_member = intval($rsGET[0]['send_to_insol_member']); 
  
    
    $volume_name = htmlentities(stripslashes($rsGET[0]['volume_name'])); 
    $newsletter_issue = htmlentities(stripslashes($rsGET[0]['newsletter_issue'])); 
    
    $send_to_governance = stripslashes($rsGET[0]['send_to_governance']); 
    $governace_type_id = json_decode($send_to_governance);
    
    $send_to_insol_member = intval(stripslashes($rsGET[0]['send_to_insol_member']));
     
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
                if($test_email != "")
                {
                ?>
                    <div style="color:#1E6D42;font-size: 16px;">Test Mail successfully sent</div>
                    <br />
                <?php
                }
                ?>
                
                <?php
               /* if(intval($mct) > 0)
                { 
                ?>
                    <div style="color:#1E6D42;font-size: 16px;">(<?php echo $mct;?>) Insol Member - Mail successfully sent </div>
                <?php
                } */
                ?>
                
                <?php
                if($send_to_insol_member > 0)
                {
                ?>
                    <div style="color:#1E6D42;font-size: 16px;"> Insol Member - Mail successfully sent </div>
                    <br />
                <?php
                }
                ?>
                
                <?php
                if(count($govt_session_array) > intval(0)) //if($send_to_governance !== "")
                {
                    
                    foreach($govt_session_array as $type_id => $count){
                        if(intval($count) > intval(0)){
                        $governace_name = getDetails(GOVERNANCE_TYPE_TBL, 'type_name', "type_id","$type_id",'=', '', '' , "");  
                ?>
                            <div style="color:#1E6D42;font-size: 16px;"><?php echo "(". $count . ") " . $governace_name; ?> - Mail successfully sent </div>
                <?php
                        }
                    }
                   
                }
                ?>
                
                
            </div>
            <div class="fullWidth noGap">
                <a href="<?php echo PAGE_PREVIEW;?>?nid=<?php echo $ID;?>" class="backBtn"><< Back</a>
            </div>
        </div>
    </div>
</div>
<?php
unset($_SESSION['GOVT_INFO_ARRAY']);

?>                   
<?php include("footer.php");?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 