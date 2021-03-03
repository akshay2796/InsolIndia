<?php 
session_start();
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");

define("PAGE_MAIN","judges_advisory.php");	
define("PAGE_AJAX","ajax_judges_advisory.php");

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
}

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_JUDGES_ADVISORY_ROUNDTABLE;
    
    if($imageId == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
        {
            deleteIMG("PROFILE_SIZE_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
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
            
            deleteIMG("PROFILE_SIZE_IMG",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                        
            $SQL = "";
            $SQL .= "UPDATE " . JUDGES_ADVISORY_ROUNDTABLE_TBL . " SET " ;
            $SQL .= " image_name = :image_name, ";
            $SQL .= " image_id = :image_id ";
            $SQL .= " WHERE judges_ar_id = :judges_ar_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
            
            $image_name = "";
            $img_id = intval(0);            
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":image_name", $image_name);
            $stk_upd->bindParam(":image_id", $img_id);
            $stk_upd->bindParam(":judges_ar_id", $imageId);
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
    
    
    $judges_ar_name = trustme($_REQUEST['judges_ar_name']);
    $judges_ar_email = trustme($_REQUEST['judges_ar_email']);
    $judges_ar_post = trustme($_REQUEST['judges_ar_post']);
    $judges_ar_profession = trustme($_REQUEST['judges_ar_profession']);    
    
    $judges_ar_profile = trustyou($_REQUEST['dcontent']);
    
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']); 
    
    $url_key = filterString($judges_ar_name);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);
    
    $meta_title = trim($meta_title) == '' ? trim($judges_ar_name) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($judges_ar_name) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($judges_ar_name) : trim($meta_description);
       
    
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_JUDGES_ADVISORY_ROUNDTABLE . "/";
    
    if($con == "add")
    {
        $CHK = checkDuplicate(JUDGES_ADVISORY_ROUNDTABLE_TBL,"judges_ar_name","$judges_ar_name","=","");
        //echo $section_name;       
                 
        if( intval($CHK) == intval(0) )
        {
            
            $MAX_ID = getMaxId(JUDGES_ADVISORY_ROUNDTABLE_TBL,"judges_ar_id");
            $MAX_POS = getMaxPosition(JUDGES_ADVISORY_ROUNDTABLE_TBL,"position","","","=");
            $MY_URLKEY = getURLKEY(JUDGES_ADVISORY_ROUNDTABLE_TBL,$url_key,$judges_ar_name,"","","",$MAX_ID,"");
            
            if($image != "")
            {
                $title_filter = filterString($judges_ar_name);
                $i_ext = pathinfo($image);
                
                $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                resizeIMG("PROFILE_SIZE_IMG",trim($imgpath_name),$MAX_ID,$FOLDER_NAME);
                
                $image_id = intval(1);
            }
            else
            {
                $imgpath_name = "";
                $image_id = intval(0);
            } 
           
                             
            $sql  = "";
            $sql .= " INSERT INTO " . JUDGES_ADVISORY_ROUNDTABLE_TBL . " SET ";
            $sql .= " judges_ar_id = :judges_ar_id, ";
            $sql .= " judges_ar_name = :judges_ar_name, ";
            $sql .= " judges_ar_email = :judges_ar_email, ";
            $sql .= " judges_ar_post = :judges_ar_post, ";
            $sql .= " judges_ar_profession = :judges_ar_profession, ";            
            $sql .= " judges_ar_profile = :judges_ar_profile, ";
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
            $stmt->bindParam(":judges_ar_id", $MAX_ID);
            $stmt->bindParam(":judges_ar_name", $judges_ar_name);
            $stmt->bindParam(":judges_ar_email", $judges_ar_email);
            $stmt->bindParam(":judges_ar_post", $judges_ar_post);
            $stmt->bindParam(":judges_ar_profession", $judges_ar_profession);            
            $stmt->bindParam(":judges_ar_profile", $judges_ar_profile);
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
            
            
        }
        else
        {
            $rs = 2;
        }
    }
    
    else if($con == "modify")
    {
        
        
        $CHK = checkDuplicate(JUDGES_ADVISORY_ROUNDTABLE_TBL,"judges_ar_name~~~judges_ar_id","$judges_ar_name~~~$id","=~~~<>","");
        
        
        if( intval($CHK) == intval(0) )
        { 
            $MY_URLKEY = getURLKEY(JUDGES_ADVISORY_ROUNDTABLE_TBL,$url_key,$judges_ar_name,"judges_ar_id",$id,"<>",$id); 
             
            if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $title_filter = filterString($judges_ar_name);
                    $i_ext = pathinfo($image);
                    
                    $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                    rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                    resizeIMG("PROFILE_SIZE_IMG",trim($imgpath_name),$id,$FOLDER_NAME);
                    
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
            $sql .= " UPDATE " . JUDGES_ADVISORY_ROUNDTABLE_TBL . " SET ";
            $sql .= " judges_ar_name = :judges_ar_name, ";
            $sql .= " judges_ar_email = :judges_ar_email, ";
            $sql .= " judges_ar_post = :judges_ar_post, ";  
            $sql .= " judges_ar_profession = :judges_ar_profession, ";          
            $sql .= " judges_ar_profile = :judges_ar_profile, ";
            $sql .= " image_name = :image_name, ";
            $sql .= " image_id = :image_id, ";            
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, "; 
            $sql .= " update_by = :update_by, "; 
            $sql .= " url_key = :url_key "; 
            $sql .= " WHERE judges_ar_id = :judges_ar_id ";
             
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":judges_ar_name", $judges_ar_name); 
            $stmt->bindParam(":judges_ar_email", $judges_ar_email);  
            $stmt->bindParam(":judges_ar_post", $judges_ar_post);   
            $stmt->bindParam(":judges_ar_profession", $judges_ar_profession);
            $stmt->bindParam(":judges_ar_profile", $judges_ar_profile);
            $stmt->bindParam(":image_name", $imgpath_name); 
            $stmt->bindParam(":image_id", $image_id); 
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":url_key", $MY_URLKEY);
            $stmt->bindParam(":judges_ar_id", $id); 
            $rs = $stmt->execute();  
            $stmt->closeCursor();            
                
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
    
    $judges_ar_post = trustme($_REQUEST['search_judges_ar_post']);
    $judges_ar_name = trustme($_REQUEST['search_judges_ar_name']);
    
    $search = "";
    if(trim($judges_ar_post) != "")
    {
        $search .= " and judges_ar_post like :judges_ar_post ";
    }
    if($judges_ar_name != "")
    {
        $search .= " and judges_ar_name like :judges_ar_name ";
    }
    
   
   
    $SQL = "";
    $SQL .= " SELECT A.* ";     
    $SQL .= " FROM " . JUDGES_ADVISORY_ROUNDTABLE_TBL . " as A WHERE  A.status <> 'DELETE' $search ORDER BY position, judges_ar_id desc "; 
    
    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . JUDGES_ADVISORY_ROUNDTABLE_TBL . " WHERE status <> 'DELETE' $search ";
         
    $stmt1 = $dCON->prepare($SQL_PG);
    //echo $SQL;
    if(trim($judges_ar_post)  != "")
    {
        $stmt1->bindParam(":judges_ar_post", $judges_ar_post_search);
        $judges_ar_post_search = "%{$judges_ar_post}%";
    }
    if($judges_ar_name != "")
    {
        $stmt1->bindParam(":judges_ar_name", $personnelname);
        $personnelname = "%{$judges_ar_name}%";
    }
    
    $stmt1->execute();    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 100;    
    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);  
    
    
    if(trim($judges_ar_post)  != "")
    {
        $stmt2->bindParam(":judges_ar_post", $judges_ar_post_search);
        $judges_ar_post_search = "%{$judges_ar_post}%";
    }
    
    if($judges_ar_name != "")
    {
        $stmt2->bindParam(":judges_ar_name", $personnelname);
        $personnelname = "%{$judges_ar_name}%";
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
    $position_qry_string .= "con=".JUDGES_ADVISORY_ROUNDTABLE_TBL;
    $position_qry_string .= "&cname1=judges_ar_name&cname2=judges_ar_id";
   
                  
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
                        //alert(ID+"####"+VAL);
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
                            <th width="20%" align="left">Name</th>
                            <th width="20%" align="left">Post</th>
                            <th width="25%" align="left">Profession</th>                            
                            <th width="10%" align="center">Image</th>
                            <th width="5%" align="center">Position</th>                            
                            <th align="center" width="10%">Action</th>
                                                 
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
                                        $judges_ar_id = "";                                        
                                        $judges_ar_name = ""; 
                                        $judges_ar_post = "";
                                        $judges_ar_profession = "";
                                        $publish_date = ""; 
                                        $status = ""; 
                                        
                                        
                                        $judges_ar_id = intval($rs['judges_ar_id']);
                                        $judges_ar_name = stripslashes($rs['judges_ar_name']);
                                        $judges_ar_post = stripslashes($rs['judges_ar_post']);
                                        $judges_ar_profession = stripslashes($rs['judges_ar_profession']);                                        
                                        
                                        $status = stripslashes($rs['status']);
                                        $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";    
                                                   
                                        $image_name = trim(stripslashes($rs['image_name']));
                                
                                        $DISPLAY_IMG = "";
                                        $R200_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_JUDGES_ADVISORY_ROUNDTABLE . "/R200-" . $image_name);
                                        //$MAIN_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_JUDGES_ADVISORY_ROUNDTABLE . "/" . $image_name);
                                        
                                        if( intval($R200_IMG_EXIST) == intval(1) )
                                        {
                                            $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_JUDGES_ADVISORY_ROUNDTABLE . "/R200-" . $image_name;
                                        }
                                        ?>     
                                        
                                        <li id="listItem_<?php echo $judges_ar_id; ?>"> 
                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tr class="expiredCoupons trhover" >
                                        
                                                    <td align="center" width="5%"> 
                                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $judges_ar_id; ?>" />
                                                    </td>
                                                    
                                                    <td align="center" width="5%">
                                                       <div id="INPROCESS_STATUS_1_<?php echo $judges_ar_id; ?>" style="display: none;"></div>
                                                        <div id="INPROCESS_STATUS_2_<?php echo $judges_ar_id; ?>"  >
                                                            <a href="javascript:void(0);" value="<?php  echo $judges_ar_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus">
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
                                                            <?php echo ucwords(strtolower($judges_ar_name)); ?>                                                            
                                                       </h3>
                                                    </td>
                                                    <td width="20%">
                                                	   <?php echo $judges_ar_post; ?>
                                                    </td>   
                                                    <td width="25%">
                                                	   <?php echo $judges_ar_profession; ?>
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
                                                       <div id="INPROCESS_DELETE_1_<?php echo $judges_ar_id; ?>" style="display: none;"></div>
                                                       
                                                       <div id="INPROCESS_DELETE_2_<?php echo $judges_ar_id; ?>">
                                                            <a href="<?php echo PAGE_MAIN; ?>?id=<?php echo $judges_ar_id; ?>" class="modifyData img_btn">
                                                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify"/>
                                                            </a>  
                                                            <?php
                                                            if( intval($CHK) == intval(0) )
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" value="<?php  echo $judges_ar_id; ?>" class="deleteData img_btn">
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
        
        ///$stmt = $dCON->prepare("DELETE FROM " . JUDGES_ADVISORY_ROUNDTABLE_TBL . "   WHERE section_id = ?");
        $stmt = $dCON->prepare("Update " . JUDGES_ADVISORY_ROUNDTABLE_TBL . "  set status='DELETE' WHERE judges_ar_id = ?");
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
    $stmt = $dCON->prepare("Update " . JUDGES_ADVISORY_ROUNDTABLE_TBL . "  set status='DELETE'  WHERE judges_ar_id = ?");
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
    $STR .= " UPDATE  " . JUDGES_ADVISORY_ROUNDTABLE_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE judges_ar_id = :judges_ar_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":judges_ar_id", $ID);
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