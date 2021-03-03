<?php 
session_start();
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");

define("PAGE_MAIN","governance.php");	
define("PAGE_AJAX","ajax_governance.php");

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
    case "modifyData":
        modifyData();
        break;  
    case "setStatus":
        setStatus();
        break;  
    case "setMostPopular":
        setMostPopular();
    break;
    case "setHomePage":
        setHomePage();
    break;
    
    case "findSUBTYPE":
        findSUBTYPE();
    break;
}

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_GOVERNANCE;
    
    if($imageId == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
        {
            deleteIMG("GOVERNANCE_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
    }
    else
    {
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("GOVERNANCE_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                        
            $SQL = "";
            $SQL .= "UPDATE " . GOVERNANCE_TBL . " SET " ;
            $SQL .= " image_name = :image_name, ";
            $SQL .= " image_id = :image_id ";
            $SQL .= " WHERE governance_id = :governance_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
            
            $image_name = "";
            $img_id = intval(0);            
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":image_name", $image_name);
            $stk_upd->bindParam(":image_id", $img_id);
            $stk_upd->bindParam(":governance_id", $imageId);
            $stk_upd->execute();
            
            $stk_upd->closeCursor();
             
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
    
    
    $type_id = intval($_REQUEST['type_id']);
    $subtype_id = intval($_REQUEST['subtype_id']);
    $governance_name = trustme($_REQUEST['governance_name']);
    $governance_email = trustme($_REQUEST['governance_email']);
    $governance_post = trustme($_REQUEST['governance_post']);
    $governance_profession = trustme($_REQUEST['governance_profession']);    
    
    $governance_profile = trustyou($_REQUEST['dcontent']);
    
    
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']); 
    
    $url_key = filterString($governance_name);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);
    
    $meta_title = trim($meta_title) == '' ? trim($governance_name) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($governance_name) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($governance_name) : trim($meta_description);
       
    
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GOVERNANCE . "/";
    
    if($con == "add")
    { //============================================================duplicate name can enter =========so different url key will be there==========
       // $CHK = checkDuplicate(GOVERNANCE_TBL,"type_id~~~governance_name","$type_id~~~$governance_name","=~~~=","");
      
        //echo $section_name;       
                 
     /*  if( intval($CHK) == intval(0) )
      { */
            
            $MAX_ID = getMaxId(GOVERNANCE_TBL,"governance_id");
            $MAX_POS = getMaxPosition(GOVERNANCE_TBL,"position","","","=");
            $MY_URLKEY = getURLKEY(GOVERNANCE_TBL,$url_key,$governance_name,"","","",$MAX_ID,"");
            
            if($image != "")
            {
                $title_filter = filterString($governance_name);
                $i_ext = pathinfo($image);
                
                $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                resizeIMG("GOVERNANCE_IMG",trim($imgpath_name),$MAX_ID,$FOLDER_NAME);
                
                $image_id = intval(1);
            }
            else
            {
                $imgpath_name = "";
                $image_id = intval(0);
            } 
           
                             
            $sql  = "";
            $sql .= " INSERT INTO " . GOVERNANCE_TBL . " SET ";
            $sql .= " governance_id = :governance_id, ";
            $sql .= " type_id = :type_id, ";
            $sql .= " subtype_id = :subtype_id, ";
            $sql .= " governance_name = :governance_name, ";
            $sql .= " governance_email = :governance_email, ";
            $sql .= " governance_post = :governance_post, ";
            $sql .= " governance_profession = :governance_profession, ";            
            $sql .= " governance_profile = :governance_profile, ";
            $sql .= " image_name = :image_name, ";
            $sql .= " image_id = :image_id, ";
            $sql .= " position = :position, ";
            $sql .= " add_ip = :add_ip, ";
            $sql .= " add_time = :add_time, ";
            $sql .= " add_by = :add_by, ";
            $sql .= " url_key = :url_key, "; 
            $sql .= " meta_title = :meta_title, "; 
            $sql .= " meta_keyword = :meta_keyword, ";
            $sql .= " meta_description = :meta_description "; 
            
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":governance_id", $MAX_ID);
            $stmt->bindParam(":type_id", $type_id);
            $stmt->bindParam(":subtype_id", $subtype_id);
            $stmt->bindParam(":governance_name", $governance_name);
            $stmt->bindParam(":governance_email", $governance_email);
            $stmt->bindParam(":governance_post", $governance_post);
            $stmt->bindParam(":governance_profession", $governance_profession);            
            $stmt->bindParam(":governance_profile", $governance_profile);
            $stmt->bindParam(":image_name", $imgpath_name); 
            $stmt->bindParam(":image_id", $image_id); 
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
            
            
       /* }
        else
        {
            $rs = 2;
        } */
    }
    
    else if($con == "modify")
    {
        
        
       /* $CHK = checkDuplicate(GOVERNANCE_TBL,"type_id~~~governance_name~~~governance_id","$type_id~~~$governance_name~~~$id","=~~~=~~~<>","");
        
        if( intval($CHK) == intval(0) )
        { */
            $MY_URLKEY = getURLKEY(GOVERNANCE_TBL,$url_key,$governance_name,"governance_id",$id,"<>",$id); 
             
            if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $title_filter = filterString($governance_name);
                    $i_ext = pathinfo($image);
                    
                    $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                    rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                    resizeIMG("GOVERNANCE_IMG",trim($imgpath_name),$id,$FOLDER_NAME);
                    
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
            else
            {
                if($image != "")
                {                   
                    $imgpath_name =  $image;             
                    $image_id = intval(1);
                }
                else
                {
                    $imgpath_name = "";
                    $image_id = intval(0);
                }
                
            }
            
            $sql  = "";
            $sql .= " UPDATE " . GOVERNANCE_TBL . " SET ";
            $sql .= " type_id = :type_id, ";
            $sql .= " subtype_id = :subtype_id, ";
            $sql .= " governance_name = :governance_name, ";
            $sql .= " governance_email = :governance_email, ";  
            $sql .= " governance_post = :governance_post, ";
            $sql .= " governance_profession = :governance_profession, ";          
            $sql .= " governance_profile = :governance_profile, ";
            $sql .= " image_name = :image_name, ";
            $sql .= " image_id = :image_id, ";            
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, "; 
            $sql .= " update_by = :update_by, "; 
            $sql .= " url_key = :url_key, "; 
            $sql .= " meta_title = :meta_title, "; 
            $sql .= " meta_keyword = :meta_keyword, ";
            $sql .= " meta_description = :meta_description ";
            $sql .= " WHERE governance_id = :governance_id ";
             
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":type_id", $type_id);
            $stmt->bindParam(":subtype_id", $subtype_id);
            $stmt->bindParam(":governance_name", $governance_name);  
            $stmt->bindParam(":governance_email", $governance_email);  
            $stmt->bindParam(":governance_post", $governance_post);    
            $stmt->bindParam(":governance_profession", $governance_profession);
            $stmt->bindParam(":governance_profile", $governance_profile);
            $stmt->bindParam(":image_name", $imgpath_name); 
            $stmt->bindParam(":image_id", $image_id); 
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":url_key", $MY_URLKEY);
            $stmt->bindParam(":meta_title", $meta_title);
            $stmt->bindParam(":meta_keyword", $meta_keyword);
            $stmt->bindParam(":meta_description", $meta_description);
            $stmt->bindParam(":governance_id", $id); 
            $rs = $stmt->execute();  
            $stmt->closeCursor();            
                
       // }
       
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
    
    $subtype_id = "";
    $type_id = intval($_REQUEST['ctid']);
    $subtype_id = intval($_REQUEST['search_subtype_id']);
    
    $governance_post = trustme($_REQUEST['search_governance_post']);
    $governance_name = trustme($_REQUEST['search_governance_name']);
    
    $search = "";
    if($type_id > intval(1))
    {
        $search .= " and type_id = '" . $type_id . "' ";        
    }
    
    if(trim($governance_post) != "")
    {
        $search .= " and governance_post like :governance_post ";
    }
    if($governance_name != "")
    {
        $search .= " and governance_name like :governance_name ";
    }
    
    if($subtype_id != "")
    {
        $search .= " and subtype_id = :subtype_id ";
    }
    
   
   
    $SQL = "";
    $SQL .= " SELECT A.* ";     
    $SQL .= " FROM " . GOVERNANCE_TBL . " as A WHERE  A.status <> 'DELETE' $search ORDER BY position, governance_id desc "; 
    
    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . GOVERNANCE_TBL . " WHERE status <> 'DELETE' $search ";
         
    $stmt1 = $dCON->prepare($SQL_PG);
    //echo $SQL;
    if(trim($governance_post)  != "")
    {
        $stmt1->bindParam(":governance_post", $governance_post_search);
        $governance_post_search = "%{$governance_post}%";
    }
    if($governance_name != "")
    {
        $stmt1->bindParam(":governance_name", $personnelname);
        $personnelname = "%{$governance_name}%";
    }
    
    if($subtype_id != "")
    {
        $stmt1->bindParam(":subtype_id", $subtype_id);
   
    }
    
    $stmt1->execute();    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 100;    
    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);  
    
    
    if(trim($governance_post)  != "")
    {
        $stmt2->bindParam(":governance_post", $governance_post_search);
        $governance_post_search = "%{$governance_post}%";
    }
    
    if($governance_name != "")
    {
        $stmt2->bindParam(":governance_name", $personnelname);
        $personnelname = "%{$governance_name}%";
    }
    
    if($subtype_id != "")
    {
        $stmt2->bindParam(":subtype_id", $subtype_id);
    
    }
    
    
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();  
    
    
    $position_qry_string = "";
    $position_qry_string .= "con=".GOVERNANCE_TBL;
    $position_qry_string .= "&cname1=governance_name&cname2=governance_id";
   
                  
    ?>   
    
    
    <form name="frmDel" id="frmDel" method="post" action="">
    
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <tr>
            <td valign="top" align="left">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
                    <tr>
                        <td class="main_heading">
                            <table width="100%" cellspacing="0" cellpadding="0">
                                <tr>
                                    <th align="left">Existing</th>
                                    <?php if(intval($dA) > intval(0)) {?><td align="right" style="padding-right:10px;"><b>Total Records: <?php echo intval($dA);?></b></td><?php } ?>
                                 </tr>
                            </table>
                        </td>
                      </tr> 
                </table>
     		</td>
         </tr>
         
        <?php 
        if(intval($dA) > intval(0) ) 
        { 
        ?>     
            
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){                                               
                    //CHECK ALL
                    $("#chk_all").click(function(){
                            
                        $( '.cb-element' ).attr( 'checked', $( this ).is( ':checked' ) ? true : false );              
                        
                       
                        var nock = $(".cb-element:checked").size();
                        if( parseInt(nock) == parseInt(0) )
                        {
                             $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn");                                   
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass("submit_btn");  
                        }
                        
                    }); 
                    
                        
                    $(".cb-element").click(function(){
                            
                        var nock = $(".cb-element:checked").size();
                        var unock = $(".cb-element:unchecked").size();
                        //alert(nock);
                        
                        if( parseInt(nock) == parseInt(0) )
                        {
                             $(".delete_all").attr("disabled", true).removeClass("submit_btn").addClass("grey_btn");                                   
                        }
                        else
                        {
                             $(".delete_all").attr("disabled", false).removeClass("grey_btn").addClass("submit_btn");  
                        }
                        
                        if( parseInt(unock) == parseInt(0))
                        {
                             $("#chk_all").attr("checked", true);      
                        }
                        else
                        {
                             $("#chk_all").attr("checked", false);  
                        }
                        
                        
                            
                    });
                    
                    //DELETE SELECTED
                    $(".delete_all").click(function(){
                        $(this).deleteSelected();
                    });
                    
                    //DELETE DATA
                    $(".deleteData").click(function(){
                        var value = $(this).attr("value");
                        //alert(value);
                        $(this).deleteData({ID: value});  
                    });        
                    
                    $(".setStatus").live("click", function() {
                        var ID = $(this).attr("value");
                        var VAL = $(this).attr("myvalue");
                        $(this).setStatus({ID: ID,VAL:VAL});  
                    }); 
                    
                    $("#test-list").sortable({
                        handle : '.handle',
                        update : function () {
                            var order = $('#test-list').sortable('serialize');
                            var qryString = $("#qryString").val();
                            //alert(order)
                            //alert(qryString)
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
           
            <tr>
                <td class="list_table" valign="top">
                    <input type="hidden" name="qryString" id="qryString" value="<?php echo $position_qry_string; ?>&stop=1" style="width: 500px;" />
                    <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                        <tr>
                            <th width="5%" align="center"><?php if( ( intval($dA) > intval(0) ) ) { ?><input type="checkbox" name="chk_all" value="1" id="chk_all" /><?php } ?></th>
                            <th width="5%" align="center">Status</th>                     
                            <th width="20%" align="left">Member Name</th>
                            <th width="15%" align="left">Post</th>
                            <th align="left">Profession</th>                            
                            <th width="10%" align="center" style="text-align: center;">Image</th>
                            <th width="5%" align="center">Position</th>                            
                            <th align="center" width="10%" style="text-align: center;">Action</th>
                                                 
                        </tr>
                        <tr>                        
                            <td colspan="8" style="padding:0px; border-bottom:0px;">                               
                                <ul id="test-list" style="padding-left: 0px;list-style: none;">                      
                                    <?php                                                       
                                    $CK_COUNTER = 0;
                                    $FOR_BG_COLOR = 0;
                                    $temp = '';
                                    $disp = 0;
                                    
                                    foreach($row as $rs)
                                    {
                                        //print_r($rs);
                                        $governance_id = "";                                        
                                        $governance_name = ""; 
                                        $governance_post = "";
                                        $governance_profession = "";
                                        $publish_date = ""; 
                                        $status = ""; 
                                        
                                        
                                        $governance_id = intval($rs['governance_id']);
                                        $governance_name = stripslashes($rs['governance_name']);
                                        $governance_post = stripslashes($rs['governance_post']);
                                        $governance_profession = stripslashes($rs['governance_profession']);                                        
                                        
                                        $status = stripslashes($rs['status']);
                                        $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";    
                                                   
                                        $image_name = trim(stripslashes($rs['image_name']));
                                
                                        $DISPLAY_IMG = "";
                                        $R200_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GOVERNANCE . "/R200-" . $image_name);
                                        //$MAIN_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GOVERNANCE . "/" . $image_name);
                                        
                                        if( intval($R200_IMG_EXIST) == intval(1) )
                                        {
                                            $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_GOVERNANCE . "/R200-" . $image_name;
                                        }
                                        ?>     
                                        
                                        <li id="listItem_<?php echo $governance_id; ?>"> 
                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tr class="expiredCoupons trhover" >
                                        
                                                    <td align="center" width="5%"> 
                                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $governance_id; ?>" />
                                                    </td>
                                                    
                                                    <td align="center" width="5%">
                                                       <div id="INPROCESS_STATUS_1_<?php echo $governance_id; ?>" style="display: none;"></div>
                                                        <div id="INPROCESS_STATUS_2_<?php echo $governance_id; ?>"  >
                                                            <a href="javascript:void(0);" value="<?php  echo $governance_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus">
                                                                <img 
                                                                <?php 
                                                                if( trim($status) == 'ACTIVE') 
                                                                { 
                                                                ?>
                                                                    src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>active.png" title="Click to Inactive" alt="Click to Inactive" />
                                                                
                                                                <?php 
                                                                }
                                                                elseif( trim($status) == 'INACTIVE') 
                                                                { 
                                                                ?>
                                                                    src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>inactive.png" title="Click to Active" alt="Click to Active" />
                                                                <?php 
                                                                }
                                                                ?>             
                                                            
                                                            </a> 
                                                        </div>
                                                    </td>
                                                    <td width="20%">
                                                    	<h3 class="couponType">
                                                            <?php echo ucwords(strtolower($governance_name)); ?>    
                                                       </h3>
                                                    </td>
                                                    <td width="15%">
                                                	   <?php echo $governance_post; ?>
                                                    </td>   
                                                    <td>
                                                	   <?php echo $governance_profession; ?>
                                                    </td>                                      
                                                    
                                                    <td align='center' width="10%">
                                                        <?php
                                                        if($DISPLAY_IMG !='')
                                                        {
                                                        ?>
                                                            <img src="<?php echo $DISPLAY_IMG; ?>" alt="" width="30" height="30"/>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    
                                                    <td align="center" width="5%">
                                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" alt="Move" width="16" height="16" class="handle" style="cursor: move;" />
                                                    </td>
                                                    
                                                                                                                               
                                                    <td align="center" width="10%">
                                                       <div id="INPROCESS_DELETE_1_<?php echo $governance_id; ?>" style="display: none;"></div>
                                                       
                                                       <div id="INPROCESS_DELETE_2_<?php echo $governance_id; ?>">
                                                            <a href="<?php echo PAGE_MAIN; ?>?id=<?php echo $governance_id; ?>" class="modifyData img_btn">
                                                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify"/>
                                                            </a>  
                                                            <?php
                                                            if( intval($CHK) == intval(0) )
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" value="<?php  echo $governance_id; ?>" class="deleteData img_btn">
                                                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Delete" alt="Delete"/>
                                                                </a>
                                                            <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" class="img_btn_dis">
                                                                    <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Cannot Delete" alt="Cannot Delete"/>
                                                                </a> 
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    
                                               </tr>
                                            </table>
                                        </li> 
                                    <?php
                                    }
                                    ?>
                                 </ul>
                            </td>
                        </tr>  
                    </table>   
                </td>
            </tr>
            <tr>
                <td height="30" colspan="<?php echo $COLSPAN; ?>" class="txt1" style="padding-top:10px;" valign="top" id="INPROCESS_DEL">
                    <input type="button"  class="grey_btn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                    <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~POSITION"); ?>
                 </td>
            </tr>                                                                
            <?php 
			if($paging[0]!="")
			{
			?>
                <tr>
                    <td height="30" colspan="<?php echo $COLSPAN; ?>" align="right">
                        <div id="pagingWrap">
                    	   <?php echo $paging[0]; ?>
                        </div>             
                     </td>
                 </tr>
            <?php 
			}
			?>  
        </table>            
       
        <?php
        }        
        else
        {
        ?>
            <tr>
               <td align="center" height="100" colspan="<?php echo $COLSPAN; ?>" ><strong>Not Found</strong></td>
           </tr>
            
        <?php
        } 
        ?>
    </table>
</form> 
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
        
        ///$stmt = $dCON->prepare("DELETE FROM " . GOVERNANCE_TBL . "   WHERE section_id = ?");
        $stmt = $dCON->prepare("Update " . GOVERNANCE_TBL . "  set status='DELETE' WHERE governance_id = ?");
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
    $ID = intval($_REQUEST['ID']);
    
    $TIME = date("Y-m-d H:i:s");
   
    //Delete Master
    //$stmt = $dCON->prepare("DELETE FROM " . SECTION_TBL . "   WHERE section_id = ?");
    $stmt = $dCON->prepare("Update " . GOVERNANCE_TBL . "  set status='DELETE'  WHERE governance_id = ?");
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
    $STR .= " UPDATE  " . GOVERNANCE_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE governance_id = :governance_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":governance_id", $ID);
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

function findSUBTYPE()
{ 
    global $dCON;

    $type_id = "";
    $type_id = $_REQUEST['type_id'];
   

    $SQL = " SELECT * FROM " . GOVERNANCE_SUBTYPE_TBL . " WHERE status = 'ACTIVE' AND type_id = :type_id";


    $stmt_ck = $dCON->prepare( $SQL );
    $stmt_ck->bindParam(":type_id", $type_id);
    $stmt_ck->execute();
    $row_ck = $stmt_ck->fetchAll();
    $stmt_ck->closeCursor();
    $rowcount = count($row_ck);

   
       if($rowcount > intval(0))
       {
            foreach ($row_ck as $rSUBTYPE) {
                $subtype_id = stripslashes($rSUBTYPE['subtype_id']);
                $subtype_name = htmlentities(stripslashes($rSUBTYPE['subtype_name']));
               ?>
                    <option value="<?php echo $subtype_id; ?>" > <?php echo $subtype_name; ?></option> 
               <?php
            }
       }else{
            ?>
                    <option value="" > SubType Not Available </option> 
            <?php
       }
}







?>