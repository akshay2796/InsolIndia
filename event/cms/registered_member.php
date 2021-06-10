<?php 
ob_start();
error_reporting(E_ALL);
include("header.php");

define("PAGE_MAIN","registered_member.php");	
define("PAGE_AJAX","ajax_registered_member.php");
define("PAGE_LIST","registered_member_list.php");


$ID = intval(base64_decode($_REQUEST['ID']));


if( (intval($ID) > intval(0)) )
{
    //$con = "modify";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . REGISTERED_MEMBER_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND reg_member_id = :member_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":member_id", $ID);
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
    
    if(count($rsGET)==intval(0))
    {
        header("Location:".PAGE_MAIN);
    }
    
    $member_id = intval(stripslashes($rsGET[0]['reg_member_id']));  
    $member_name = htmlentities(stripslashes($rsGET[0]['reg_member_name']));  
    $member_firm = htmlentities(stripslashes($rsGET[0]['reg_member_firm'])); 
    $member_address = htmlentities(stripslashes($rsGET[0]['reg_member_address']));   
    $member_telephone = htmlentities(stripslashes($rsGET[0]['reg_member_telephone']));    
    $member_email = htmlentities(stripslashes($rsGET[0]['reg_member_email']));    
   

    $status = htmlentities(stripslashes($rsGET[0]['status']));                        
    
    
    
   
    
}
else
{
    die("Wrong Access.....");
  /*  $con = "add";
    $ID = "";
    $status = "ACTIVE";
    
    $show_in_current = 0;
    
    $profession_id = intval(base64_decode($_REQUEST['CID']));
    $set1_uploadMORE = 1;  
    
    $METATITLE = "";
    $METAKEYWORD = "";
    $METADESCRIPTION = ""; */
    
}


?>

<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">

    <input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
    <input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;"/>
 
	<h1>Member Information<div class="addProductBox"><a href="registered_member_list.php" class="backBtn">Go to List</a></div></h1>
     
	<div class="addWrapper" style="padding: 25px; box-sizing: border-box; font-size: 12px;">

		<strong>Member Name</strong>: <?php echo $member_name; ?><br><br>

		<strong>Firm:</strong> <?php echo $member_firm; ?><br><br>

		<strong>Address:</strong> <?php echo $member_address; ?><br><br>

		<strong>Telephone:</strong> <?php echo $member_telephone; ?><br><br>

		<strong>Email:</strong> <?php echo $member_email; ?><br><br>

		<strong>Status:</strong> <?php echo $status; ?>

                                  
    </div>
    
</div>            
</form>  
             
<?php include("footer.php");?>      
