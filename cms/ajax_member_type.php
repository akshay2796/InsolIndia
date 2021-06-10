<?php 
session_start();
error_reporting(E_ALL);
include("ajax_include.php");  

define("PAGE_MAIN","member_type.php");	
define("PAGE_AJAX","ajax_member_type.php");
 
$type =  trustme($_REQUEST['type']);
switch($type)
{
     
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
    case "modifyData":
        modifyData();
        break;  
    case "setStatus":
        setStatus();
        break;  
}


function saveData()
{
    global $dCON;
    
    $type_name = trustme($_REQUEST['type_name']);
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $TIME = date("Y-m-d H:i:s");
    
    
    
    $url_key = filterString($type_name);
    
        
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);
    
    $meta_title = trim($meta_title) == '' ? trim($type_name) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($type_name) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($type_name) : trim($meta_description);
       
    
    if($con == "add")
    {
        $CHK = checkDuplicate(MEMBER_TYPE_TBL,"type_name","$type_name","=","");
        //echo $type_name;       
                 
        if( intval($CHK) == intval(0) )
        {
            
            $MAX_ID = getMaxId(MEMBER_TYPE_TBL,"type_id");
            $MAX_POS = getMaxPosition(MEMBER_TYPE_TBL,"position","","","=");
              
            $MY_URLKEY = getURLKEY(MEMBER_TYPE_TBL,$url_key,$url_key,"","","",$MAX_ID);  
                             
            $sql  = "";
            $sql .= " INSERT INTO " . MEMBER_TYPE_TBL . " SET ";
            $sql .= " type_id = :type_id, ";
            $sql .= " type_name = :type_name, ";
            $sql .= " position = :position, ";
            $sql .= " add_ip = :add_ip, ";
            $sql .= " add_time = :add_time, ";
            $sql .= " add_by = :add_by, ";
            $sql .= " url_key = :url_key, "; 
            $sql .= " meta_title = :meta_title, "; 
            $sql .= " meta_keyword = :meta_keyword, ";
            $sql .= " meta_description = :meta_description "; 
            
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":type_id", $MAX_ID);
            $stmt->bindParam(":type_name", $type_name);
            $stmt->bindParam(":position", $MAX_POS); 
            $stmt->bindParam(":add_ip", $ip);
            $stmt->bindParam(":add_time", $TIME);
            $stmt->bindParam(":add_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":url_key", $MY_URLKEY);
            $stmt->bindParam(":meta_title", $meta_title);
            $stmt->bindParam(":meta_keyword", $meta_keyword);
            $stmt->bindParam(":meta_description", $meta_description);
            
            $rs = $stmt->execute();
            $stmt->closeCursor();
            if( intval($rs) == intval(1) )
            {
                
                $last_insert_id = $MAX_ID;
                
            }
            
        }
        else
        {
            $rs = 2;
        }
    }
    
    else if($con == "modify")
    {
        $CHK = checkDuplicate(MEMBER_TYPE_TBL,"type_name~~~type_id",$type_name."~~~".$id,"=~~~<>","");
         
        if( intval($CHK) == intval(0) )
        { 
            $MY_URLKEY = getURLKEY(MEMBER_TYPE_TBL,$url_key,$url_key,"type_id",$id,"<>",$id);  
            
            
            $sql  = "";
            $sql .= " UPDATE " . MEMBER_TYPE_TBL . " SET ";
            $sql .= " type_id = :type_id, ";
            $sql .= " type_name = :type_name, ";
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, "; 
            $sql .= " update_by = :update_by, "; 
            $sql .= " url_key = :url_key "; 
            $sql .= " WHERE type_id = :type_id ";
             
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":type_id", $MAX_ID);
            $stmt->bindParam(":type_name", $type_name);
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":url_key", $MY_URLKEY);
            $stmt->bindParam(":type_id", $id); 
            $rs = $stmt->execute();  
            $stmt->closeCursor(); 
            if( intval($rs) == intval(1) )
            {
                    
                $last_insert_id = $id;
                
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
            echo "~~~1~~~Successfully saved~~~".$last_insert_id;
        break;
        case "2":
            echo "~~~2~~~Already exists";
        break; 
        default:
            echo "~~~0~~~Sorry cannot process your request";
        break;
    }  
}

function listData()
{ 
    global $dCON;
    global $pg;
    
    //$search_location = trustme($_REQUEST['search_location']);
    
    
    $SQL = "";
    $SQL .= " SELECT * FROM " .  MEMBER_TYPE_TBL . " as B ";
    $SQL .= " WHERE B.status <> 'DELETE' ";
    $SQL .= " ORDER BY position,type_id "; 
    //echo $SQL; 
  	
    $SQL_PG = "";
    $SQL_PG .= " SELECT COUNT(*) AS CT  FROM ( ";   
        $SQL_PG .= $SQL;
    $SQL_PG .= " ) as aa "; 
    
    
    $stmt1 = $dCON->prepare($SQL_PG);
    //$stmt1->bindParam(":search_location", $loc_name);
    $stmt1->execute();
    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 50;
    
    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);
    //$stmt2->bindParam(":search_location", $loc_name);
     
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();
              
    //echo "==".count($dA);
    
    $position_qry_string = "";
    $position_qry_string .= "con=".MEMBER_TYPE_TBL;
    $position_qry_string .= "&cname1=type_name&cname2=type_id";
           
    ?>
    
    <div class="boxHeading">Existing</div>
    <div class="clear"></div>
        
    <?php 
    if( intval($dA) > intval(0) )
    {
        global $PERMISSION;                                   
        //echo $_SESSION['PERMISSION'];                       
         
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
                    var type_id = $(this).attr("value");
                    $(this).deleteData({type_id: type_id});  
                });
                 
                $(".modifyData").click(function(){
                    var type_id = $(this).attr("value");
                    //alert(type_id) 
                    
                    //$('.wrapper_table').show();    
                    
                    $(this).modifyData({type_id: type_id});
                    
                    $(".expendableBox").slideDown();
					$('.showHideBtn').html("(-)");
					
                    $(".expendBtn").addClass("collapseBtn");
                    $(".expendBtn").removeClass("expendBtn");
                       
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
        
            
        <input type="hidden" name="qryString" id="qryString" value="<?php echo $position_qry_string; ?>&stop=1" style="width: 1100px;" />
        
        
        <div class="containerPad" >
            <!--div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox" type="checkbox" name="chk_all" value="1" id="chk_all" /></label>
                    <input type="button" class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php //showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~"); ?> 
            </div--><!--hintIconWrap end-->
            
            <div class="clear">&nbsp;</div>
            <div id="test-list"> 
            <?php
            $CK_COUNTER = 0;
            $FOR_BG_COLOR = 0; 
            $disp = 0;
            foreach($row as $rs)
            {
                $type_id = "";
                $type_name = "";
                $status = ""; 
                
                $type_id = stripslashes($rs['type_id']);
                $type_name = stripslashes($rs['type_name']);         
                
                $position = stripslashes($rs['position']);
                $status = stripslashes($rs['status']);
                $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";
                      
                $CHK = chkFor($type_id);   
                 
                
                ?>
                
                <div class="smallListBox" id="listItem_<?php echo $type_id; ?>">
               		<div class="sListTitle"><?php echo $type_name; ?></div>                        
                    <div class="sListBtnWrap">
                    	<table>
                        	<tr>
                            	<td align="left" width="20">
                                    <?php
                                    if( intval($CHK) == intval(0) )
                                    {
                                        $CK_COUNTER++;
                                    ?>
                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $type_id; ?>" />
                                    <?php
                                    }
                                    else
                                    {
                                        echo '<input type="checkbox" disabled=""/>';
                                    }
                                    ?>
                                </td>
                                <td width="30" class="statusTd">
                                	<div id="INPROCESS_STATUS_1_<?php echo $type_id; ?>" style="display: none;"></div>
                                    <div id="INPROCESS_STATUS_2_<?php echo $type_id; ?>"  >
                                        <?php 
                                        if( trim($status) == 'ACTIVE') 
                                        { 
                                        ?>
                                            <a href="javascript:void(0);" value="<?php  echo $type_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" /></a>
                                        <?php 
                                        }
                                        elseif( trim($status) == 'INACTIVE') 
                                        { 
                                        ?>
                                           <a href="javascript:void(0);" value="<?php  echo $type_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus"><img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" /></a>
                                        <?php 
                                        }
                                        ?>   
                                    </div>
                                 </td>
                                 
                                 <td align="right">                                
                                    
                                    <div id="INPROCESS_DELETE_1_<?php echo $type_id; ?>" style="display: none;"></div>
                                    <div id="INPROCESS_DELETE_2_<?php echo $type_id; ?>"  >
                                        <a href="javascript:void(0);" value="<?php echo $type_id; ?>" class="modifyData cmsIcon" title="Modify">
                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" /></a> 
                                        <?php
                                        if( intval($CHK) == intval(0) )
                                        {
                                        ?>
                                            <a href="javascript:void(0);" value="<?php  echo $type_id; ?>" class="deleteData cmsIcon">
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
            <!--div class="smallListBox" style="display: none;"></div-->
            </div>
            <div class="clear"></div>
            <div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox"  name="chk_all2" value="1" id="chk_all2" class="chk_all" /></label>
                    <input type="button"  class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~POSITION"); ?> 
                
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
            
            <div class="clear">&nbsp;</div>
            <div class="notes">Note: You can only delete items which do not have any data added under them.</div>
       
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
        <div class="containerPad">
            <b>Not Found </b>                     
        </div>        
    <?php
    }   
    ?>    
     
<?php
}

function modifyData()
{
    global $dCON;
    
    $type_id = intval($_REQUEST['type_id']);
    
    
    $stmt = $dCON->prepare(" SELECT * FROM " . MEMBER_TYPE_TBL . " WHERE type_id = ? ");
    $stmt->bindParam(1, $type_id);
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
    
    $type_id = intval($row_stmt[0]['type_id']);
    $type_name = (stripslashes($row_stmt[0]['type_name'])); 
     
    
    
     
    echo "~~~$type_id~~~$type_name~~~";
    
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
        
        $stmt = $dCON->prepare("DELETE FROM " . MEMBER_TYPE_TBL . "   WHERE type_id = ?");
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
    //$type_name = getDetails(AIRPORT_CITY_TBL, 'type_name', "type_id",$ID,'=', '', '' , "" );
    
    //Delete Master
    $stmt = $dCON->prepare("DELETE FROM " . MEMBER_TYPE_TBL . "   WHERE type_id = ?");
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
    $STR .= " UPDATE  " . MEMBER_TYPE_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE type_id = :type_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":type_id", $ID);
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
 
function chkFor($ID)
{
    global $dCON;
    $CT =0;
    
    $SQL = "";
    $SQL = " SELECT SUM(CT) FROM ( ";
        $SQL .= " SELECT COUNT(*) AS CT FROM " . MEMBER_TBL . " WHERE member_type_id = ? AND status <> 'DELETE' ";
        //$SQL .= " UNION ";
        //$SQL .= " SELECT COUNT(*) AS CT FROM " . RATE_ADDITIONAL_AIRPORT_FROM_UK_TBL . " WHERE location_id = ? AND status <> 'DELETE' ";
     $SQL .= " ) AS aa ";
         
    //echo $SQL . $ID;    
    //exit();
      
    $sCHK = $dCON->prepare( $SQL );
    $sCHK->bindParam(1, $ID);
    //$sCHK->bindParam(2, $ID);
    //$sCHK->bindParam(3, $ID); 
    
    $sCHK->execute();
    $rsCHK = $sCHK->fetchAll();
    $sCHK->closeCursor();
    $CT = intval($rsCHK[0][0]);
    //echo $ID . "==" .  $CT;
    
    return $CT;

    
}




?>