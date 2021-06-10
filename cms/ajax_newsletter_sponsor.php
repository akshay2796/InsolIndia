<?php 
error_reporting(E_ALL);
include("ajax_include.php");   
include("../library_insol/class.imageresizer.php");
define("PAGE_MAIN", "newsletter_sponsor.php");
define("PAGE_AJAX", "ajax_newsletter_sponsor.php");
 
 
$type =  trustme($_REQUEST['type']);
switch($type)
{
    case "removeImage":
        removeImage();
    break;
    case "saveData":
        saveData();
        break;
    case "listData":
        listData();
        break;
    case "deleteSelected":
        deleteSelected();
        break;
    case "deleteData":
        deleteData();
        break;
    case "setStatus":
        setStatus();
        break;  
}



function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    
    if($imageId == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
        {
            deleteIMG("NEWSLETTER-SPONSOR",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
    }
    else
    {
        
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR . "/" . $image_name)) 
        {
            
            deleteIMG("NEWSLETTER-SPONSOR",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR );
                      
            $stk_del = $dCON->prepare("update " . NEWSLETTER_SPONSOR_TBL . " set image_name ='' WHERE sponsor_id = :sponsor_id " );
            $stk_del->bindParam(":sponsor_id", $imageId);
            $stk_del->execute();
            $stk_del->closeCursor();
             
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
        
    } 
}



function saveData()
{
    global $dCON;
    
    $url = trustme($_REQUEST['url']);
    $company_name = trustme($_REQUEST['company_name']);
    
    $image = $_REQUEST['image']; 
     
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR . "/";
	$RESIZE_WIDTH = "";
    $RESIZE_WIDTH = 100;
  
    if( !is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR))
    {
        $mask=umask(0);
        mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH .  FLD_NEWSLETTER_SPONSOR, 0777); 
        umask($mask);      
    }  
    
  
  
    $status = "ACTIVE"; //trustme($_REQUEST['status']);
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    
    // Create Social media folder ====
    
    
    if($con == "add")
    {
        $CHK = checkDuplicate(NEWSLETTER_SPONSOR_TBL,"company_name",$company_name,"=","","YES");
         
        if( intval($CHK) == intval(0) )
        {
            $MAXID = getMaxId(NEWSLETTER_SPONSOR_TBL,"sponsor_id");     
            $MAX_POS = getMaxPosition(NEWSLETTER_SPONSOR_TBL,"position","","","");
              
            if(trim($image) != "") 
            {
			   $R100_image = "R".$RESIZE_WIDTH."-".$image;
			   $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image);
               if(intval($chk_file) == intval(1))
				{ 
					$img_ext = pathinfo($image);
					$fpath_image =  "sponsor_".$MAXID . "." . $img_ext['extension'];
					
					copy($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$fpath_image); 
					//rename img name of R100 image
					$R100_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
					 //Rename R100 Image
					copy($TEMP_FOLDER_NAME.$R100_image,$FOLDER_NAME.$R100_image_f);
					resizeIMG("NEWSLETTER-SPONSOR",trim($fpath_image),$MAXID,$FOLDER_NAME);  
				} 
				
            }
            else 
            {
                $fpath_image = "";  
					
            }
            
            $SQL  = "";
            $SQL .= " INSERT INTO " . NEWSLETTER_SPONSOR_TBL . " SET ";
            $SQL .= " sponsor_id = :sponsor_id, ";
            $SQL .= " company_name = :company_name, ";
            $SQL .= " url = :url, ";
            $SQL .= " image_name = :image_name, ";
            $SQL .= " position = :position, ";
            $SQL .= " status = :status, ";
            $SQL .= " add_ip = :add_ip, ";
            $SQL .= " add_time = :add_time, ";
            $SQL .= " add_by = :add_by "; 
         
            $stmt = $dCON->prepare($SQL);
            $stmt->bindParam(":sponsor_id", $MAXID);
            $stmt->bindParam(":url", $url);
            $stmt->bindParam(":company_name", $company_name);
            $stmt->bindParam(":image_name", $fpath_image);
            $stmt->bindParam(":position", $MAX_POS); 
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":add_ip", $ip);
            $stmt->bindParam(":add_time", $TIME);
            $stmt->bindParam(":add_by", $_SESSION['USERNAME']);
            $rs = $stmt->execute();
            $stmt->closeCursor();
            if( intval($rs) == intval(1) )
            {
                /////ID USED FOR POPUP WINDOW
                $last_insert_id = $MAXID;
            }     
            
        }
        else
        {
            $rs = 2;
        }
    }
    else if($con == "modify")
    {
        $CHK = checkDuplicate(NEWSLETTER_SPONSOR_TBL,"company_name~~~url~~~sponsor_id",$company_name."~~~".$url."~~~".$id,"=~~~=~~~<>","","NO");
        
        if( intval($CHK) == intval(0) )
        { 
            
        $TEMP_FOLDER_NAME = "";
		$TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
		
		$FOLDER_NAME = "";
		$FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_SPONSOR . "/";
		$RESIZE_WIDTH = "";
		$RESIZE_WIDTH = 100;
                
                 
        $R130_image = "R".$RESIZE_WIDTH."-".$image;
        $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image);
        
                
        if(intval($chk_file) == intval(1))
        {
            
			$img_ext = pathinfo($image);
			$fpath_image =  "sponsor_".$MAXID . "." . $img_ext['extension'];

			copy($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$fpath_image); 
			//rename img name of R100 image
			$R100_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
			 //Rename R100 Image
			copy($TEMP_FOLDER_NAME.$R100_image,$FOLDER_NAME.$R100_image_f);
			resizeIMG("NEWSLETTER-SPONSOR",trim($fpath_image),$MAXID,$FOLDER_NAME); 
        }   
              
            $SQL  = "";
            $SQL .= " UPDATE " . NEWSLETTER_SPONSOR_TBL . " SET ";
            $SQL .= " url = :url, ";  
            $SQL .= " company_name = :company_name, ";  
            if(trim($fpath_image) != "") 
            {
                $SQL .= " image_name = :image_name, ";  
            }
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, "; 
            $SQL .= " update_by = :update_by "; 
            $SQL .= " WHERE sponsor_id = :sponsor_id ";
             
            $stmt = $dCON->prepare($SQL);
            $stmt->bindParam(":url", $url); 
            $stmt->bindParam(":company_name", $company_name); 
            if(trim($fpath_image) != "") 
            {  
                $stmt->bindParam(":image_name", $fpath_image);  
            }
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":sponsor_id", $id); 
            $rs = $stmt->execute();  
            $stmt->closeCursor(); 
            if( intval($rs) == intval(1))
            {                 
                             
            }    
            
        }
        else
        {
            $rs = 2;
        }
    }
    
    switch($rs)
    {
        case "1":
            echo "~~~1~~~Successfully saved~~~";
        break;
        case "2":
            echo "~~~2~~~Already exists"."~~~";
        break; 
        default:
            echo "~~~0~~~Sorry cannot process your request"."~~~";
        break;
    }  
    
}

function listData()
{
    global $dCON;
    global $pg;
    
    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . NEWSLETTER_SPONSOR_TBL . " WHERE status <> 'DELETE' ";
    $SQL = " SELECT * FROM " . NEWSLETTER_SPONSOR_TBL . " WHERE status <> 'DELETE' ORDER BY position "; 
    
    $stmt1 = $dCON->prepare($SQL_PG);
    $stmt1->execute();
    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 25;
    
    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);
     
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();
              
    //echo "==".count($dA);
    $COLSPAN = 6;
    
    $position_qry_string = "";
    $position_qry_string .= "con=".NEWSLETTER_SPONSOR_TBL;
    $position_qry_string .= "&cname1=company_name&cname2=sponsor_id";
           
    ?>
    
    <script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery-ui-1.9.1.custom.js"></script> 
   
    <div class="boxHeading">List</div>
    <div class="clear"></div>
        
    <?php 
    if( intval($dA) > intval(0) )
    {
    ?>
        <form name="frmDel" id="frmDel" method="post" action="">
        <script language="javascript" type="text/javascript">
            $(document).ready(function(){
               
                //CHECK ALL
                $("#chk_all").click(function(){
                     $('.cb-element' ).attr( 'checked', $( this ).is( ':checked' ) ? true : false );  
                    //alert ($("#chk_all").prop('checked');
                    var nock = $(".cb-element:checked").size();
                    
                    if($("#chk_all").prop('checked')==true)
                    {
                        $("#chk_all2").prop('checked',true)
                    }
                    else
                    {
                        $("#chk_all2").prop('checked',false)
                    }
                    if( parseInt(nock) == parseInt(0) )
                    {
                        $('.smallListBox').removeClass('selected2Del');
        				$('.deleteSelectedBtn').addClass('greyBtn');  
                        $(".delete_all").attr("disabled", true);
                                                 
                    }
                    else
                    {
                        $('.smallListBox').addClass('selected2Del');
        				$('.deleteSelectedBtn').removeClass('greyBtn');   
                        $(".delete_all").attr("disabled", false);  
                    }
                    
                                
                    
                }); 
               
               
                $("#chk_all2").click(function(){
                     $('.cb-element' ).attr( 'checked', $( this ).is( ':checked' ) ? true : false );  
                    
                    //alert ($("#chk_all").prop('checked');
                    
                    if($("#chk_all2").prop('checked')==true)
                    {
                        $("#chk_all").prop('checked',true)
                    }
                    else
                    {
                        $("#chk_all").prop('checked',false)
                    }
                    
                    
                    var nock = $(".cb-element:checked").size();
                    if( parseInt(nock) == parseInt(0) )
                    {
                        $('.smallListBox').removeClass('selected2Del');
        				$('.deleteSelectedBtn').addClass('greyBtn');  
                        $(".delete_all").attr("disabled", true);
                                                 
                    }
                    else
                    {
                        $('.smallListBox').addClass('selected2Del');
        				$('.deleteSelectedBtn').removeClass('greyBtn');   
                        $(".delete_all").attr("disabled", false);  
                    }
                }); 
               
                    
                    
                $(".cb-element").click(function(){
                     
        			var checkIndx = $(".cb-element").index(this);    
                    var nock = $(".cb-element:checked").size();
                    var unock = $(".cb-element:unchecked").size();
                    //alert(nock);
                    
                    if( parseInt(nock) == parseInt(0) )
                    {
                         //$("#delete_all").attr("disabled", true).addClass("greyBtn");
                         $('.smallListBox').removeClass('selected2Del');
        				 //$(".smallListBox:eq(" + checkIndx + ")").removeClass('selected2Del');
        				 $('.deleteSelectedBtn').addClass('greyBtn'); 
                         $(".delete_all").attr("disabled", true);
        				 //alert(checkIndx);
        				                              
                    }
                    else
                    {
                         //$("#delete_all").attr("disabled", false).removeClass("greyBtn");
                         //$('.smallListBox').addClass('selected2Del');
        				 $(".smallListBox:eq(" + checkIndx + ")").addClass('selected2Del');
        				 $('.deleteSelectedBtn').removeClass('greyBtn'); 
                         $(".delete_all").attr("disabled", false);
        				
                    }
        			                    
                    if( parseInt(unock) == parseInt(0))
                    {
                         $("#chk_all").attr("checked", true);  
                         $("#chk_all2").attr("checked", true);      
                    }
                    else
                    {
                         $("#chk_all").attr("checked", false);
                         $("#chk_all2").attr("checked", false);  
                    }
                    
                    
                        
                });
                
                //DELETE SELECTED
                $(".delete_all").click(function(){
                    $(this).deleteSelected();
                });
              
                
                
        
                //DELETE DATA
                $(".deleteData").click(function(){
                    var sponsor_id = $(this).attr("value");
                    $(this).deleteData({sponsor_id: sponsor_id});  
                });
                 
                 
                
                $(".setStatus").live("click", function() {
                    var ID = $(this).attr("value");
                    var VAL = $(this).attr("myvalue");
                    //alert(ID+"####"+VAL);
                    $(this).setStatus({ID: ID,VAL:VAL});  
                });
                 
                
                $("#test-list").sortable({
                    handle : '.handle',
                    update : function () {
                    	var order = $('#test-list').sortable('serialize');
                        var qryString = $("#qryString").val();
                        //alert(order);
                        $.ajax({
                            type: "POST",
                            url: "ajax_position.php",
                            data: "type=saveListPosition&" + qryString + "&" + order,
                            beforeSend: function(){
                                
                            },
                            success: function(msg) {
                                //alert(msg)
                                $("#smessage").html(msg);        
                            }
                        });
                        
                        
                    }
                });
                
                
            });
        </script>
        <input type="hidden" name="qryString" id="qryString" value="<?php echo $position_qry_string; ?>&stop=1" style="width: 500px;" />
        
        <div class="containerPad" >
            
            <div id="test-list">     
                              
                <?php
                $CK_COUNTER = 0;
                $FOR_BG_COLOR = 0;
                $temp = '';
                $disp = 0;
                foreach($row as $rs)
                {
                    $sponsor_id = "";
                    $company_name = "";
                    $status = ""; 
                    
                    $sponsor_id = stripslashes($rs['sponsor_id']);
                    $company_name = stripslashes($rs['company_name']);
                    $url = stripslashes($rs['url']);
                    
                    $image_name = stripslashes($rs['image_name']);
                    $position = stripslashes($rs['position']);
                    $status = stripslashes($rs['status']);
                    $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";
                    
                    $iPATH = "";
                    $iPATH = FLD_NEWSLETTER_SPONSOR . "/R100-". $image_name;
                    $A_IMAGE = CMS_UPLOAD_FOLDER_ABSOLUTE_PATH . $iPATH ;
                    $R_IMAGE = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $iPATH;
                     
                    $SHOWIMAGE = "";                   
                    if(intval(chkImageExists($R_IMAGE)) == intval(1))
                    {
                        $SHOWIMAGE .= "<img src='" . CMS_UPLOAD_FOLDER_ABSOLUTE_PATH.  $iPATH . "'style='max-width:200px; float:none; margin-bottom:6px;'  title='" . $company_name . "' alt='" . $company_name . "'  />";
                    } 
                    $CHK=0;      
                    ?>
                            
                    
                    <div class="smallListBox nsponsorH" id="listItem_<?php echo $sponsor_id; ?>" style="background:#ffffff;">
                   		<div class="sListTitle withIcon" style="background:#ffffff; width:100%; text-align:center;padding-bottom:40px;">
                            <a href="<?php echo $url; ?>" target="_blank" >
                                <?php echo $SHOWIMAGE; ?><br>
                                <?php echo $company_name; ?>
                            </a>
                        </div>                        
                        <div class="sListBtnWrap" style="width: 100%; position:absolute; bottom:0px;">
                        	<table>
                            	<tr>
                                	<td align="left" width="20">
                                        <?php
                                        if( intval($CHK) == intval(0) )
                                        {
                                            $CK_COUNTER++;
                                        ?>
                                            <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $sponsor_id; ?>" />
                                        <?php
                                        }
                                        else
                                        {
                                            echo '<input type="checkbox" disabled=""/>';
                                        }
                                        ?>
                                    </td>
                                    <td width="30" class="statusTd">
                                    	<div id="INPROCESS_STATUS_1_<?php echo $sponsor_id; ?>" style="display: none;"></div>
                                        <div id="INPROCESS_STATUS_2_<?php echo $sponsor_id; ?>"  >
                                            <?php 
                                            if( trim($status) == 'ACTIVE') 
                                            { 
                                            ?>
                                                <a href="javascript:void(0);" value="<?php  echo $sponsor_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" /></a>
                                            <?php 
                                            }
                                            elseif( trim($status) == 'INACTIVE') 
                                            { 
                                            ?>
                                               <a href="javascript:void(0);" value="<?php  echo $sponsor_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" /></a>
                                            <?php 
                                            }
                                            ?>   
                                        </div>
                                     </td>
                                     
                                     <td align="right">                                
                                        
                                        <div id="INPROCESS_DELETE_1_<?php echo $sponsor_id; ?>" style="display: none;"></div>
                                        <div id="INPROCESS_DELETE_2_<?php echo $sponsor_id; ?>"  >
                                            <a href="<?php echo PAGE_MAIN."?id=".$sponsor_id; ?>" class="modifyData cmsIcon" title="Modify">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" /></a> 
                                            <?php
                                            if( intval($CHK) == intval(0) )
                                            {
                                            ?>
                                                <a href="javascript:void(0);" value="<?php  echo $sponsor_id; ?>" class="deleteData cmsIcon">
                                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Delete" alt="Delete"/></a>
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                                 <a href="javascript:void(0);" class="cmsIcon">
                                                 <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash_disable.png" border="0" title="Cannot Delete" alt="Cannot Delete"/></a>                                                             
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        
                                    </td>
                                </tr>
                            </table>          
                        </div>                        
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position"/>
                    </div><!--smallListBox-->        
                  
                <?php
                }
                ?>
            </div>
            <div class="clear"></div>
            <div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox"  name="chk_all2" value="1" id="chk_all2" class="chk_all" /></label>
                    <input type="button"  class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~"); ?> 
            </div><!--hintIconWrap end-->
            <?php
			if($paging[0]!="")
			{
			?>
                <div class="clear"></div>
                <div id="pagingWrap">
                	<?php echo $paging[0]; ?>
                </div>                
                    
            <?php 
			}
			?>         
                   
            <?php 
            if( intval($CK_COUNTER) <= intval(0) ) 
            { 
            ?>
                <script language="javascript" type="text/javascript">
                    $(document).ready(function(){
                        $("#delete_all").hide();
                        $("#chk_all").hide();
                    }); 
                </script>  
            <?php 
            } 
            ?>
        </div>
        </form>        
    <?php
    }
    else
    {
    ?>
        <div class="containerPad" >
            <div class="" style="padding: 20px;" >
                <div class="sListTitle">Not Found</div>                        
            </div> 
      </div>            
    <?php
    }   
    ?>    
     
<?php
}


function deleteSelected()
{
    global $dCON;
       
    $arr = implode(",",$_REQUEST['chk']);
    $exp = explode(",",$arr);
    $i = 0;
    
    foreach($exp as $chk)
    {
        $TIME = date("Y-m-d H:i:s");
        
        $stmt = $dCON->prepare("DELETE FROM " . NEWSLETTER_SPONSOR_TBL . "   WHERE sponsor_id = ?");
        $stmt->bindParam(1,$chk);
        $rs = $stmt->execute();
        $stmt->closeCursor();
        if( intval($rs) == intval(1) ) 
        {           
            $i++;
        }
    }
    
    $msg = "(".$i.") Successfully deleted";  
    //$msg = "Done";  
    
    echo $msg;
    
}

function deleteData()
{
    global $dCON;    
    $ID = intval($_REQUEST['did']);
    
    $TIME = date("Y-m-d H:i:s");
   
    //Delete Master
    $stmt = $dCON->prepare("DELETE FROM " . NEWSLETTER_SPONSOR_TBL . "   WHERE sponsor_id = ?");
    $stmt->bindParam(1,$ID);
    $rs = $stmt->execute();
    $stmt->closeCursor();
    if( intval($rs) == intval(1) ) 
    {
         echo '~~~1~~~Deleted~~~'; 
    }
    else
    {
        echo '~~~0~~~Error~~~';
    }
} 


function setStatus()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);                           
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
     
    $STR  = "";
    $STR .= " UPDATE  " . NEWSLETTER_SPONSOR_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE sponsor_id = :sponsor_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":sponsor_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();         
    
     
        
    if ( intval($RES) == intval(1) )
    {     
        echo '~~~1~~~DONE~~~' . $ID . "~~~";     
    }
    else
    {
        echo '~~~0~~~ERROR~~~';
    }

}

?>

<script src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>grids.js"></script>
<script>    
    $(document).ready(function() {
        $('.nsponsorH').responsiveEqualHeightGrid();
    });
</script>