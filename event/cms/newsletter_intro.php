<?php 
ob_start();
error_reporting(0);
include("header.php");

define("PAGE_MAIN","newsletter_intro.php");	
define("PAGE_AJAX","ajax_newsletter_master.php");


    
$SQL  = "";
$SQL .= " SELECT * FROM " . NEWSLETTER_INTRO_TBL . " as A ";
$SQL .= " WHERE status <> 'DELETE' limit 1 ";
$sGET = $dCON->prepare( $SQL );
$sGET->execute();
$rsGET = $sGET->fetchAll();
$sGET->closeCursor();

if(count($rsGET) > intval(0))
{
    $ID = intval(stripslashes($rsGET[0]['intro_id']));  
    $intro_content = htmlentities(stripslashes($rsGET[0]['intro_content']));  
    $con = "modify";
}
else
{
    $con = "add";
    $ID = "";
    $status = "ACTIVE";
}


?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH;?>maxlength.js"></script>


<script language="javascript" type="text/javascript">
$(document).ready(function(){
    
    $("#frm").validate({
        errorElement:'span',
        ignore:[],
        rules: {
            
            intro_content: "required" 
        },
        messages: {
            intro_content: ""
        },
        submitHandler: function() {
            var value = $("#frm").serialize();
            
            
            $.ajax({
               type: "POST",
               url: "<?php echo PAGE_AJAX; ?>",
               data: "type=saveIntro&" + value,
			   beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
               },
               success: function(msg){
                   //alert(msg);
				   //return false;                 
                   var cond = $("#con").val();
                   
                   setTimeout(function(){
                        $("#INPROCESS").html("");                        
                        var spl_txt = msg.split("~~~"); 
                        
                        var colorStyle = "";
                        if( parseInt(spl_txt[1]) == parseInt(1) )
                        {
                            colorStyle = "successTxt";                            
                        } 
                        else
                        {
                            colorStyle = "errorTxt";
                        }
                        
                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='cancelBtn " + colorStyle + "' /></div>");
                        
                        
                        setTimeout(function(){
                            
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' class='submitBtn' id='save' name='save'/>");
                            
                            
                            if( parseInt(spl_txt[1]) == parseInt(1) )
                            {
                               
                                window.location.href = "<?php echo PAGE_MAIN; ?>";
                                
                            }
                               
                        },2000);
                        
                                             
                    },1000); 
                  
					 
                }
            });
        }
    });
    
    
    
    
    $("#cancel").live("click", function(){    
        //location.href='<?php echo PAGE_MAIN; ?>';  
        
        window.location.reload('<?php echo PAGE_MAIN; ?>');
       
     });
     
       
});

    
</script>




<form id="frm" name="frm" method="post" action="" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $ID; ?>" readonly style="display: none1;"/>
<input type="hidden" name="con" id="con" value="<?php echo $con; ?>" readonly style="display: none1;"/>
<h1>
    Newsletter Intro
</h1>
<div class="addWrapper">
	<div class="boxHeading">Manage</div>
    <div class="clear"></div>
    <div class="containerPad">
        <div class="fullWidth validateMsg">        	
            <label class="mainLabel">Intro <small></small></label>
            <textarea class="txtBox" name="intro_content" id="intro_content" data-maxsize="2000" data-output="status1" wrap="virtual" style="height:100px;"><?php echo $intro_content; ?></textarea>   
            <br><span id="status1" style="font-size:11px"></span> <span style="font-size:11px">characters </span>    
        </div>
        <div class="fullWidth noGap">
            <div class="sbumitLoaderBox" id="INPROCESS">                        
                <input type='submit' value='Save' class='submitBtn' id='save' name='save'/>
            </div>           
        </div>
    </div><!--containerPad end-->
</div>            
</form>  
             
<?php include("footer.php");?>      
