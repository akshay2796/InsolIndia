<?php 
error_reporting(0);
include("header.php");

define("PAGE_MAIN","governance_subtype.php");	
define("PAGE_AJAX","ajax_governance_subtype.php");
define("PAGE_LIST","governance_subtype_list.php");

$subtype_id = intval($_REQUEST['id']);
if( intval($subtype_id) > intval(0) )
{   
    $con = "modify"; 
    $id = intval($subtype_id);
    
    $stmt = $dCON->prepare(" SELECT * FROM " . GOVERNANCE_SUBTYPE_TBL . " WHERE subtype_id = ? ");
    $stmt->bindParam(1, $subtype_id);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
    
    $type_id = intval($row_stmt[0]['subtype_id']);
    $subtype_name = htmlentities(stripslashes($row_stmt[0]['subtype_name']));
    $masterTYPEID =  intval($row_stmt[0]['type_id']);
    
    $METATITLE = htmlentities(stripslashes($row_stmt[0]['meta_title']));
    $METAKEYWORD = htmlentities(stripslashes($row_stmt[0]['meta_keyword']));
    $METADESCRIPTION = htmlentities(stripslashes($row_stmt[0]['meta_description']));
    
    $FOLDER_NAME = FLD_STORY_TYPE; 
    $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME; 
    
}
else
{
    $id = "";
    $con = "add";
    $status = "ACTIVE";
    $type_name = "";
    $type_id = intval(base64_decode($_REQUEST['CID']));
    
}

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH;?>jquery-ui-1.10.4.css">

<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH;?>fileuploder/plupload.html5.js"></script>

<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            
            subtype_name: "required",
           
           
        },
        messages: {
           
            subtype_name: "",
           
        },
        submitHandler: function() {
            
            var value = $("#frm").serialize();
            
            //alert(dcontent)
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveData&" +  value,
			   beforeSend: function() { 
                    $("#INPROCESS").html("");                    
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){                   
                  //alert(msg);
                   var cond = $("#con").val();
                   
                   setTimeout(function(){
                        $("#INPROCESS").html("");                        
                        var spl_txt = msg.split("~~~"); 
                        
                        var colorStyle = "";
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            colorStyle = "success"; 
                        } 
                        else
                        {
                            colorStyle = "error";
                        }
                        
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");
                        
                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' />&nbsp;<input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>");
                            
                        },1000);
                         
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            if(cond =="modify")
                            {
                                window.location.href = "<?php echo PAGE_LIST; ?>"; 
                            }
                            else
                            {
                                window.location.href = "<?php echo PAGE_MAIN; ?>"; 
                            }
                        }
                                               
                    },1000); 
               }
            });
        }
    });
    
   
    $("#cancel").live("click", function(){    
        //location.href='<?php echo PAGE_MAIN; ?>';  
        <?php
        if($con == "modify")
        {
        ?>
            location.href='<?php echo PAGE_LIST; ?>';
        <?php
        }
        else
        {
        ?>
            window.location.reload('<?php echo PAGE_MAIN; ?>');
        <?php
        }
        ?>
     });
    
 
    
   
});

</script>

<h1>Governance SubType <div class="addProductBox"><a href="<?php echo PAGE_LIST;?>" class="backBtn">Go To List</a></div></h1>
<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" />


<div class="addWrapper master">
    <div class="boxHeading expendBtn1"> <span id="MOD"><?php echo ucwords($con);?></span></div>
    <div class="clear"></div>
    <div class="containerPad expendableBox1">
        <div class="width4">
                    <label class="mainLabel">Governance Type<span> *</span></label>   
                    <select name="category_id" id="category_id" data-placeholder="Select Type" class="chzn-select" required >                          
                        <option value=""></option>                                      
                        <option value="">Select Type</option>
                         <?php           
                                                     
                            $rsCAT = getDetails(GOVERNANCE_TYPE_TBL, '*', "status","DELETE",'!=', 'position', '' , "");   
                            if ( count($rsCAT) > intval(0) )
                            {                         
                                foreach($rsCAT as $rCAT)
                                {
                                    $CID = 0;
                                    $CID = intval($rCAT['type_id']);
                                    $CNAME = "";
                                    $CNAME = trim(stripslashes($rCAT['type_name']));
                                        
                            ?>
                                    <option value="<?php echo $CID; ?>" <?php if( intval($CID) == intval($masterTYPEID) ) { echo " selected "; } ?> ><?php echo $CNAME; ?></option>
                            <?php
                                }
                               
                            }
                    ?> 
                </select>
                <br />
                <input type="checkbox" name="validateCAT" id="validateCAT" <?php if ( intval($type_id) > intval(0) ) { echo " checked='checked' "; } ?> readonly style="display:none" />
                </div>
        <div class="fullWidth">                    	
            <div class="width3">
                <label class="mainLabel">Governance SubType <span>*</span></label>
                <input type="text" class="txtBox" value="<?php echo $subtype_name;?>" name="subtype_name" id="subtype_name" AUTOCOMPLETE = "OFF" maxlength="500"/>
            </div>
        </div>
       
        <div class="clear">&nbsp;</div>
      
        
      
        <div class="fullWidth div_content">
            <div class="sml_heading">SEO Fields [ <small class="instructions">Use Below Tags to Enhance User Experience and Improve SEO</small>    ] </div>
        </div>
            
        <div class="fullWidth">
            <div class="fullWidth">  
                <label class="mainLabel">Meta Title </label>
                <input type="text" class="titleTxt txtBox" name="meta_title" id="meta_title" value="<?php echo $METATITLE; ?>" maxlength="250" autocomplete="OFF">
            </div>
            <div class="fullWidth">  
                <label class="mainLabel">Meta Keyword </label>
                <input type="text" class="titleTxt txtBox" name="meta_keyword" id="meta_keyword" value="<?php echo $METAKEYWORD; ?>" maxlength="350" autocomplete="OFF">
            </div>
            <div class="fullWidth">  
                <label class="mainLabel">Meta Description </label>
                <input type="text" class="titleTxt txtBox" name="meta_description" id="meta_description" value="<?php echo $METADESCRIPTION; ?>" maxlength="250" autocomplete="OFF">
            </div>
        </div> 
        
        <div class="fullWidth noGap">           
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' />
                <input type='reset' value='Cancel' class='cancelBtn' id='cancel'/>
        	</div>               
        </div><!--fullWidth end--> 
    </div><!--containerPad end-->
</div><!--addWrapper end-->
</form>


<!--div class="listWrapper" id="txtHint">
	
</div--><!--addWrapper end-->     

        

        
<?php include("footer_chitrashala.php");?>   
