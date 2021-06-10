<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","homegirl.php");	
define("PAGE_AJAX","ajax_homegirl.php");
define("PAGE_LIST","homegirl_list.php");


$ID = intval(base64_decode($_REQUEST['ID']));


if( (intval($ID) > intval(0)) )
{
    //$con = "modify";
    
    $SQL  = "";
    $SQL .= " SELECT * FROM " . REGISTERED_MEMBER_TBL . " as A ";
    $SQL .= " WHERE status <> 'DELETE' ";
    $SQL .= " AND homegirl_id = :homegirl_id ";
    //echo "<BR>" . $SQL . "<BR>".$ID;
    //exit();
    $sGET = $dCON->prepare( $SQL );
    $sGET->bindParam(":homegirl_id", $ID);
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
 
     
<h1>
    Homegirl
</h1>
<div class="addWrapper">
	<div class="boxHeading"><?php //echo ucwords($con); ?></div>
    
    <div class="clear"></div>
        <div class="fullWidth div_content">
            <div class="sml_heading">Member Information  </div>
        </div>
        <div class="fullWidth">
            <div class="fullWidth">
            	<label class="mainLabel">Member Name</label>
                <?php echo $member_name; ?>
            </div> 
            <div class="fullWidth">
                <label class="mainLabel">Firm </label>
                <?php echo $member_firm; ?>
            </div>
            <div class="fullWidth">
                <label class="mainLabel">Address</label>
              <?php echo $member_address; ?>
            </div>             
        </div>        
        
        <div class="fullWidth">         
            <label class="mainLabel">Telephone</small></label>
                <?php echo $member_telephone; ?>
        </div>

        <div class="fullWidth">         
            <label class="mainLabel">Email</small></label>
                <?php echo $member_telephone; ?>
        </div>

        <div class="extraSpace">&nbsp;</div>
        <div class="fullDivider">
            <div class="sml_heading">Contact Information <span></span> </div>
        </div>
        <div class="fullWidth">
            <div class="fullWidth">
                <label class="mainLabel">Address <span>*</span></label>
               <?php echo $homegirl_address; ?>
            </div> 
            <div class="fullWidth">
                <label class="mainLabel">City <span>*</span></label>
                <?php echo $homegirl_city; ?>
            </div>
            <div class="width2 validateMsg">
                <label class="mainLabel">State</label>
               
                    <?php           
                                                     
                    $rsSTATE = getDetails(STATE_TBL, 'state_name', "state_id","$state_id",'=', '', '' , "");   
                    echo $rsSTATE;
                    
                    ?>
                
            </div>    
            <div class="fullWidth">
                <label class="mainLabel">About <span>*</span></label>
                <textarea class="form-control" name="about" id="about" placeholder="" name="name" rows="8" cols="100" autocomplete="OFF" readonly ><?php echo $about; ?></textarea>
            </div>         
        </div>
      
       
            
        
             
        
            <div class="fullDivider">
            	<div class="sml_heading">Status</div>
            </div>
            
            <div class="fullWidth">
                <?php echo $status; ?>
            </div>
           
        
        
       
                                  
    </div><!--containerPad end-->
</div>            
</form>  
             
<?php include("footer.php");?>      
