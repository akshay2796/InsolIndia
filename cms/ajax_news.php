<?php 
ob_start();
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");

define("PAGE_MAIN","news.php");	
define("PAGE_AJAX","ajax_news.php");
define("PAGE_CHANGE_NEWS_POSTION","news_change_position.php");

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
        
    case "displayOnTop":
        displayOnTop();
        break;
        
    case "listNEWS_POSITIONWISE":
        listNEWS_POSITIONWISE();
    break;
}

function removeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_NEWS;
    
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
            $SQL .= "UPDATE " . NEWS_TBL . " SET " ;
            $SQL .= " image_name = :image_name, ";
            $SQL .= " image_id = :image_id ";
            $SQL .= " WHERE news_id = :news_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
            
            $image_name = "";
            $img_id = intval(0);            
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":image_name", $image_name);
            $stk_upd->bindParam(":image_id", $img_id);
            $stk_upd->bindParam(":news_id", $imageId);
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
    
    
    $news_title = trustme($_REQUEST['news_title']);
    $news_source = trustme($_REQUEST['news_source']);
    $news_date = trustme($_REQUEST['news_date']);
       
    $news_date_array = explode("-", $news_date);
    $news_date = $news_date_array[2] . "-" . $news_date_array[1] . "-" . $news_date_array[0];
     
    $news_related_link = trustme($_REQUEST['news_related_link']);    
    
    $news_content = trustyou($_REQUEST['dcontent']);
    
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    echo $TIME;
    
    $image = trustme($_REQUEST['image']); 
    $image_id = trustme($_REQUEST['image_id']); 
    
    $url_key = filterString($news_title);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);
    
    $meta_title = trim($meta_title) == '' ? trim($news_title) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($news_title) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($news_title) : trim($meta_description);
       
    
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS . "/";
    
    if($con == "add")
    {
        $CHK = checkDuplicate(NEWS_TBL,"news_title~~~news_date","$news_title~~~$news_date","=~~~=","");
        //echo $section_name;       
                 
        if( intval($CHK) == intval(0) )
        {
            
            $MAX_ID = getMaxId(NEWS_TBL,"news_id");
            $MAX_POS = getMaxPosition(NEWS_TBL,"position","","","=");
            $MY_URLKEY = getURLKEY(NEWS_TBL,$url_key,$news_title,"","","",$MAX_ID,"");
            
            if($image != "")
            {
                $title_filter = filterString($news_title);
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
            $sql .= " INSERT INTO " . NEWS_TBL . " SET ";
            $sql .= " news_id = :news_id, ";
            $sql .= " news_title = :news_title, ";
            $sql .= " news_source = :news_source, ";
            $sql .= " news_date = :news_date, ";
            $sql .= " news_related_link = :news_related_link, ";  
            $sql .= " news_content = :news_content, ";     
            $sql .= " image_name = :image_name, ";
            $sql .= " image_id = :image_id, ";
            $sql .= " position = :position, ";
            $sql .= " add_ip = :add_ip, ";
            $sql .= " add_time = :add_time, ";
            $sql .= " update_time = :update_time, "; 
            $sql .= " add_by = :add_by, ";
            $sql .= " url_key = :url_key, "; 
            $sql .= " meta_title = :meta_title, "; 
            $sql .= " meta_keyword = :meta_keyword, ";
            $sql .= " meta_description = :meta_description "; 
            
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":news_id", $MAX_ID);
            $stmt->bindParam(":news_title", $news_title);
            $stmt->bindParam(":news_source", $news_source);
            $stmt->bindParam(":news_date", $news_date); 
            $stmt->bindParam(":news_related_link", $news_related_link);            
            $stmt->bindParam(":news_content", $news_content);
            $stmt->bindParam(":image_name", $imgpath_name); 
            $stmt->bindParam(":image_id", $image_id); 
            $stmt->bindParam(":position", $MAX_POS); 
            $stmt->bindParam(":add_ip", $ip);
            $stmt->bindParam(":add_time", $TIME);
            $stmt->bindParam(":update_time", $TIME); 
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
        
        
        $CHK = checkDuplicate(NEWS_TBL,"news_title~~~news_date~~~news_id","$news_title~~~$news_date~~~$id","=~~~=~~~<>","");
        
        
        if( intval($CHK) == intval(0) )
        { 
            $MY_URLKEY = getURLKEY(NEWS_TBL,$url_key,$news_title,"news_id",$id,"<>",$id); 
             
            if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $title_filter = filterString($news_title);
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
            $sql .= " UPDATE " . NEWS_TBL . " SET ";
            $sql .= " news_title = :news_title, ";
            $sql .= " news_source = :news_source, ";
            $sql .= " news_date = :news_date, ";
            $sql .= " news_related_link = :news_related_link, ";  
            $sql .= " news_content = :news_content, ";
            $sql .= " image_name = :image_name, ";
            $sql .= " image_id = :image_id, ";            
            $sql .= " update_ip = :update_ip, ";
            $sql .= " update_time = :update_time, "; 
            $sql .= " update_by = :update_by, "; 
            $sql .= " url_key = :url_key "; 
            $sql .= " WHERE news_id = :news_id ";
             
            $stmt = $dCON->prepare($sql);
            $stmt->bindParam(":news_title", $news_title);
            $stmt->bindParam(":news_source", $news_source);
            $stmt->bindParam(":news_date", $news_date); 
            $stmt->bindParam(":news_related_link", $news_related_link);            
            $stmt->bindParam(":news_content", $news_content);
            $stmt->bindParam(":image_name", $imgpath_name); 
            $stmt->bindParam(":image_id", $image_id); 
            $stmt->bindParam(":update_ip", $ip);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":url_key", $MY_URLKEY);
            $stmt->bindParam(":news_id", $id); 
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
    
    $news_title = trustme($_REQUEST['search_news_title']);
    $search_fdate = trustme($_REQUEST['search_fdate']);
    $search_tdate = trustme($_REQUEST['search_tdate']);
    
    $search = "";
    
    if($news_title != "")
    {
        $search .= " and news_title like :news_title ";
    }
    
    if(trim($search_fdate) != "" && trim($search_tdate) != "" )
    {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];
        
        $search_tdate_arr = explode("-", $search_tdate);
        $search_tdate = $search_tdate_arr[2] . "-" . $search_tdate_arr[1] . "-" . $search_tdate_arr[0];
         
        $search .= " AND DATE(news_date) BETWEEN :from_date AND :to_date ";
    }
    else if(trim($search_fdate) != "")
    {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];
        
        $search .= " AND DATE(news_date) = :from_date ";
    }
    
   
   
    $SQL = "";
    $SQL .= " SELECT A.* ";     
    $SQL .= " FROM " . NEWS_TBL . " as A WHERE  A.status <> 'DELETE' $search ORDER BY news_date DESC "; 
    
    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . NEWS_TBL . " WHERE status <> 'DELETE' $search ";
         
    $stmt1 = $dCON->prepare($SQL_PG);
    //echo "$SQL===$search_fdate========$search_tdate";
    
    if($news_title != "")
    {
        $stmt1->bindParam(":news_title", $ntitle);
        $ntitle = "%{$news_title}%";
    }
    if(trim($search_fdate) != "" && trim($search_tdate) != "" ){ 
        $stmt1->bindParam(":from_date", $search_fdate);
        $stmt1->bindParam(":to_date", $search_tdate); 
    }else if(trim($search_fdate) != ""){
        $stmt1->bindParam(":from_date", $search_fdate);
    }
    
    $stmt1->execute();    
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    $rowsPerPage = 50;    
    $pg_query = $pg->getPagingQuery($SQL,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]);    
    
    if($news_title != "")
    {
        $stmt2->bindParam(":news_title", $ntitle);
        $ntitle = "%{$news_title}%";
    }
    
    if(trim($search_fdate) != "" && trim($search_tdate) != "" ){ 
        $stmt2->bindParam(":from_date", $search_fdate);
        $stmt2->bindParam(":to_date", $search_tdate); 
    }else if(trim($search_fdate) != ""){
        $stmt2->bindParam(":from_date", $search_fdate);
    } 
    
    
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();  
    //echo '<pre>'; print_r($row);
    //print_r($stmt2->errorInfo());
    
    $position_qry_string = "";
    $position_qry_string .= "con=".NEWS_TBL;
    $position_qry_string .= "&cname1=news_title&cname2=news_id";
   
                  
    ?>   
    
    <div class="" align="right"><a href="<?php echo PAGE_CHANGE_NEWS_POSTION;?>" class="newsPos" style="text-decoration: none;">Set News Position</a>
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
                        //return false;
                        $(this).setStatus({ID: ID,VAL:VAL});  
                    }); 
                    
                    $(".displayOnTop").live("click", function() {
                        var ID = $(this).attr("value");
                        var VAL = $(this).attr("myvalue");
                        //alert(ID+"####"+VAL );
                        $(this).displayOnTop({ID: ID,VAL:VAL});  
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
                            <th width="40%" align="left">Title</th>
                            <th width="10%" align="left" >Date</th>                                                   
                            <th width="10%" align="center" style="text-align: center;">Image</th>
                            <!--th width="5%" align="center">Position</th-->  
                            <th width="15%" align="center" style="text-align: center;">Display On Top</th>                           
                            <th align="center" width="10%" style="text-align: center;">Action</th>
                                                 
                        </tr>
                        <tr>                        
                            <td colspan="7" style="padding:0px; border-bottom:0px;">                               
                                <ul id="test-list" style="padding-left: 0px;list-style: none;">                      
                                    <?php                                                       
                                    $CK_COUNTER = 0;
                                    $FOR_BG_COLOR = 0;
                                    $temp = '';
                                    $disp = 0;
                                    
                                    foreach($row as $rs)
                                    {
                                        //print_r($rs);
                                        $news_id = "";                                        
                                        $news_title = ""; 
                                        $news_date = "";                                        
                                        $status = ""; 
                                        
                                        
                                        $news_id = intval($rs['news_id']);
                                        $news_title = stripslashes($rs['news_title']);
                                        $news_date = stripslashes($rs['news_date']);
                                        
                                        if($news_date !=  "0000-00-00" && $news_date !=  "" ){
                                            $news_date = date("d M, Y", strtotime($news_date));
                                        }else{
                                            $news_date = "";    
                                        }  
                                                                                                                                                             
                                        $display_on_top = intval(stripslashes($rs['display_on_top']));
                                        $DISPLAYnowaction = $display_on_top == intval(1) ? intval(0) : intval(1);
                                        
                                        $status = stripslashes($rs['status']);
                                        $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";    
                                                   
                                        $image_name = trim(stripslashes($rs['image_name']));
                                
                                        $DISPLAY_IMG = "";
                                        $R200_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS . "/R200-" . $image_name);
                                        //$MAIN_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS . "/" . $image_name);
                                        
                                        if( intval($R200_IMG_EXIST) == intval(1) )
                                        {
                                            $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS . "/R200-" . $image_name;
                                        }
                                        ?>     
                                        
                                        <li id="listItem_<?php echo $news_id; ?>"> 
                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tr class="expiredCoupons trhover" >
                                        
                                                    <td align="left" width="5%"> 
                                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $news_id; ?>" />
                                                    </td>
                                                    
                                                    <td align="center" width="5%">
                                                       <div id="INPROCESS_STATUS_1_<?php echo $news_id; ?>" style="display: none;"></div>
                                                        <div id="INPROCESS_STATUS_2_<?php echo $news_id; ?>"  >
                                                            <a href="javascript:void(0);" value="<?php  echo $news_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus">
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
                                                    <td width="40%" align='left'>
                                                    	<?php echo $news_title; ?>
                                                    </td>
                                                    <td width="10%" align='left' >
                                                	   <?php echo $news_date; ?>
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
                                                    
                                                    <!--td align="center" width="5%">
                                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" alt="Move" width="16" height="16" class="handle" style="cursor: move;" />
                                                    </td-->
                                                    
                                                    <td align="center" width="15%">
                                                        <div id="INPROCESS_SETDISPLAY_1_<?php echo $news_id; ?>" style="display: none;"></div>
                                                            <div id="INPROCESS_SETDISPLAY_2_<?php echo $news_id; ?>"  >
                                                                <a href="javascript:void(0);" value="<?php  echo $news_id; ?>" myvalue="<?php echo $DISPLAYnowaction; ?>" class="displayOnTop">
                                                                  <img 
                                                                    <?php 
                                                                    if( $display_on_top == intval(1)) 
                                                                    { 
                                                                    ?>
                                                                        src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>set.png" title="Click To Unset" alt="Click To Unset" />
                                                                    
                                                                    <?php 
                                                                    }
                                                                    elseif($display_on_top == intval(0))
                                                                    { 
                                                                    ?>
                                                                        src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>unset.png" title="Click To Set" alt="Click To Set" />
                                                                    <?php 
                                                                    }
                                                                    ?>                                                        
                                                                </a>
                                                             </div>
                                                    </td>
                                                    
                                                                                                                               
                                                    <td align="center" width="10%">
                                                       <div id="INPROCESS_DELETE_1_<?php echo $news_id; ?>" style="display: none;"></div>
                                                       
                                                       <div id="INPROCESS_DELETE_2_<?php echo $news_id; ?>">
                                                            <a href="<?php echo PAGE_MAIN; ?>?id=<?php echo $news_id; ?>" class="modifyData img_btn">
                                                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify"/>
                                                            </a>  
                                                            <?php
                                                            if( intval($CHK) == intval(0) )
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" value="<?php  echo $news_id; ?>" class="deleteData img_btn">
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
                    <?php showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE"); ?>
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
        
        ///$stmt = $dCON->prepare("DELETE FROM " . NEWS_TBL . "   WHERE section_id = ?");
        $stmt = $dCON->prepare("Update " . NEWS_TBL . "  set status='DELETE' WHERE news_id = ?");
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
    $stmt = $dCON->prepare("Update " . NEWS_TBL . "  set status='DELETE'  WHERE news_id = ?");
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
    $STR .= " UPDATE  " . NEWS_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE news_id = :news_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":news_id", $ID);
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

function displayOnTop()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);
    //echo " id === : ". $ID . " ===valuegot=== ". $VAL; 
    
    
                         
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
     
    $STR  = "";
    $STR .= " UPDATE  " . NEWS_TBL . "  SET "; 
    $STR .= " display_on_top = :display_on_top, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE news_id = :news_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":display_on_top", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":news_id", $ID);
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


function listNEWS_POSITIONWISE()
{ 
    global $dCON;
    global $pg;
    
    //$search_location = trustme($_REQUEST['search_location']);
       
    $SQL = "";
    $SQL .= " SELECT * FROM " .  NEWS_TBL . " as B ";
    $SQL .= " WHERE B.status = 'ACTIVE' AND B.display_on_top =1 ORDER BY B.position ";
    //$SQL .= " ORDER BY position,type_id "; 
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
    
    $position_qry_string_display = "";
    $position_qry_string_display .= "con=".NEWS_TBL;
    $position_qry_string_display .= "&cname1=news_title&cname2=news_id";
           
    ?>
    
    <div class="boxHeading">Set Position</div>
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
                $("#set-newsposition").sortable({
                    handle : '.handle',
                    update : function () {
                    	var order = $('#set-newsposition').sortable('serialize');
                        var qryString = $("#qryStringDisplay").val();
                        //alert(order + " query :: ");
                        //alert(order + " query :: "+qryString);
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
        
            
        <input type="hidden" name="qryStringDisplay" id="qryStringDisplay" value="<?php echo $position_qry_string_display; ?>&stop=1" style="width: 1100px;" />
        
        
        <div class="containerPad" >
            <!--div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox" type="checkbox" name="chk_all" value="1" id="chk_all" /></label>
                    <input type="button" class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php //showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~"); ?> 
            </div--><!--hintIconWrap end-->
            
            <div class="clear">&nbsp;</div>
            <div id="set-newsposition"> 
                <?php
                $CK_COUNTER = 0;
                $FOR_BG_COLOR = 0; 
                $disp = 0;
                
                foreach($row as $rs)
                { 
                    $news_id = "";
                    $news_title = "";
                    $status = ""; 
                    $news_date ="";
                     
                    $news_id = stripslashes($rs['news_id']);
                    $news_title = stripslashes($rs['news_title']);         
                    $news_date = stripslashes($rs['news_date']); 
                    $position = stripslashes($rs['position']);
                    
                    if($news_date !=  "0000-00-00" && $news_date !=  "" ){
                        $news_date = date("d M, Y", strtotime($news_date));
                    }else{
                        $news_date = "";    
                    } 
                    
                    ?>
                    
                    <div class="smallListBox" id="listItem_<?php echo $news_id; ?>">
                   		<div class="sListTitle"><?php echo $news_title; ?><br />
                            <span style="font-size: 10px; color: #666;">Date : <?php echo $news_date; ?></span>  
                        </div>            
                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position"/>
                    </div><!--smallListBox-->
                   
                <?php
                }
                ?>
                
            </div>
            <!--div class="clear"></div>
            <div class="hintIconWrap">
                <div id="INPROCESS_DEL" class="deleteSlelectedBox INPROCESS_DEL">
                    <label class="selectAllBtn"><input type="checkbox"  name="chk_all2" value="1" id="chk_all2" class="chk_all" /></label>
                    <input type="button"  class="deleteSelectedBtn greyBtn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                </div>
                <?php //showICONS("~~~ACTIVE~~~INACTIVE~~~MODIFY~~~DELETE~~~POSITION"); ?> 
                
            </div--><!--hintIconWrap end-->
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
            
           
            <!--div class="notes">Note: You can only delete items which do not have any data added under them.</div-->
       
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



ob_flush();
?>