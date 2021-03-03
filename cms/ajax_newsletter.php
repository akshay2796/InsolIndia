<?php 
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");
define("PAGE_MAIN","newsletter.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");
define("PAGE_PREVIEW","newsletter_preview.php");

$type =  trustme($_REQUEST['type']);
switch($type)
{     
     
    case "removeImageEditor":
        removeImageEditor();
        break;   
    case "removeImagePresident":
        removeImagePresident();
        break;   
    case "saveData":
        saveData();
        break;
    case "listData":
        listData();
        break; 
    case "deleteData":
        deleteData();
        break; 
    case "deleteSelected":
        deleteSelected();
        break;
    case "setStatus":
        setStatus();
        break; 
    case "sendNewsletter":
        sendNewsletter();
        break;   
        
}





function removeImageEditor()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = trustme($_REQUEST['foldername']);
    
    if($imageId == intval(0))
    {
        //delete image
        if($FOLDER_NAME == TEMP_UPLOAD)
        {
            if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
            {
                deleteIMG("NEWSLETTER_EDITOR",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
                echo "~~~1~~~Deleted";
            } 
            else 
            {
                echo "~~~0~~~Sorry Cannot Delete Image";
            }
        }
        else
        {
            echo "~~~0~~~";
        }
    }
    else
    {
        
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("NEWSLETTER_EDITOR",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                      
            $stk_del = $dCON->prepare("update " . NEWSLETTER_TBL . " set editor_image ='' WHERE newsletter_id = :newsletter_id " );
            $stk_del->bindParam(":newsletter_id", $ID);
            $stk_del->execute();
            $stk_del->closeCursor();
             
            echo "~~~1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
        
    } 
}


///////////////////////////////////////////////////////////President

function removeImagePresident()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = trustme($_REQUEST['foldername']);
    
    if($imageId == intval(0))
    {
        //delete image
        if($FOLDER_NAME == TEMP_UPLOAD)
        {
            if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
            {
                deleteIMG("NEWSLETTER_PRESIDENT",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
                echo "~~~1~~~Deleted";
            } 
            else 
            {
                echo "~~~0~~~Sorry Cannot Delete Image";
            }
        }
        else
        {
            echo "~~~0~~~";
        }
    }
    else
    {
        
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("NEWSLETTER_PRESIDENT",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                      
            $stk_del = $dCON->prepare("update " . NEWSLETTER_TBL . " set president_image = '' WHERE newsletter_id = :newsletter_id " );
            $stk_del->bindParam(":newsletter_id", $ID);
            $stk_del->execute();
            $stk_del->closeCursor();
             
            echo "~~~1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
        
    } 
}


///////////////////////////


function saveData()
{ 
    global $dCON;
    $send_date = date("Y-m-d");
    $volume_name = trustme($_REQUEST["volume_name"]); 
    $newsletter_issue = trustme($_REQUEST["newsletter_issue"]); 
    $newsletter_date = trustme($_REQUEST["newsletter_date"]); 
    if($newsletter_date !="")
    {
        $newsletter_date = date("Y-m-d", strtotime($newsletter_date));
    }
    
    
    $intro_content = trustme($_REQUEST['intro_content']);
    
    
    $editor_id = intval($_REQUEST['editor_id']);
    $editor_name = trustme($_REQUEST['editor_name']); 
    $editor_image = trustme($_REQUEST['editor_image']); 
    $folder_name_editor = $_REQUEST['folder_name_editor'];
    //$editor_text = trustme($_REQUEST['editor_text']);
    $editor_text = trustyou($_REQUEST['econtent']);
    
    $president_id = intval($_REQUEST['president_id']);
    $president_name = trustme($_REQUEST['president_name']); 
    $president_image = trustme($_REQUEST['president_image']); 
    $folder_name_president = $_REQUEST['folder_name_president'];
    //$president_text = trustme($_REQUEST['president_text']);
    $president_text = trustyou($_REQUEST['pcontent']);
     
     
    $disclaimer = trustyou($_REQUEST['dcontent']);
    
    $newsletter_id = intval($_REQUEST['id']);
    $con = trustme($_REQUEST['con']);        

    $status = "ACTIVE";         
    $IP = trustme($_SERVER['REMOTE_ADDR']);                  
    $TIME = date("Y-m-d H:i:s");
    $BY = 'admin';
    
    
      
    
    if($con == "add")
    {
        $CHK = checkDuplicate(NEWSLETTER_TBL,"status~~~volume_name~~~newsletter_issue","ACTIVE~~~".$volume_name."~~~".$volume_name,"=~~~=~~~=","");   
        
        if( intval($CHK) == intval(0) )
        {
            
            $MAXID = getMaxId(NEWSLETTER_TBL, "newsletter_id");  
            
            $FOLDER_NAME = "";
            $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER . "/";
            
            $RESIZE_WIDTH = "";
            $RESIZE_WIDTH = 130;
            
            if($editor_image !='')
            {
                $TEMP_FOLDER_EDITOR = "";
                $TEMP_FOLDER_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $folder_name_editor . "/";
                
                $R130_E_image = "R".$RESIZE_WIDTH."-".$editor_image;
                $chk_E_file = chkImageExists($TEMP_FOLDER_EDITOR . "/" . $editor_image);
                
                if(intval($chk_E_file) == intval(1))
                {
                    $img_ext = pathinfo($editor_image);
                    $Epath_image =  "editor_".$MAXID . "." . $img_ext['extension'];
                    copy($TEMP_FOLDER_EDITOR.$editor_image, $FOLDER_NAME.$Epath_image); 
                   
                    $R130_image_E = "R".$RESIZE_WIDTH."-".$Epath_image;
                    
                    copy($TEMP_FOLDER_EDITOR.$R130_E_image,$FOLDER_NAME.$R130_image_E);
                    
                    resizeIMG("NEWSLETTER_EDITOR",trim($Epath_image),$MAXID,$FOLDER_NAME);  
                } 
            }
            
            
            if($president_image !='')
            {
                $TEMP_FOLDER_PRESIDENT = "";
                $TEMP_FOLDER_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $folder_name_president . "/";
                
                $R130_P_image = "R".$RESIZE_WIDTH."-".$president_image;
                $chk_P_file = chkImageExists($TEMP_FOLDER_PRESIDENT . "/" . $president_image);
                
                if(intval($chk_P_file) == intval(1))
                {
                    $img_extP = pathinfo($president_image);
                    $Ppath_image =  "president_".$MAXID . "." . $img_extP['extension'];
                    copy($TEMP_FOLDER_PRESIDENT.$president_image, $FOLDER_NAME.$Ppath_image); 
                   
                    $R130_image_P = "R".$RESIZE_WIDTH."-".$Ppath_image;
                    
                    copy($TEMP_FOLDER_PRESIDENT.$R130_P_image,$FOLDER_NAME.$R130_image_P);
                    
                    resizeIMG("NEWSLETTER_PRESIDENT",trim($Ppath_image),$MAXID,$FOLDER_NAME);  
                } 
            }
            
            
            $SQL  = "";
            $SQL .= " INSERT INTO " . NEWSLETTER_TBL . " SET ";
            $SQL .= " newsletter_id = :newsletter_id, "; 
            $SQL .= " volume_name = :volume_name,"; 
            $SQL .= " newsletter_issue = :newsletter_issue,"; 
            $SQL .= " newsletter_date = :newsletter_date,"; 
            $SQL .= " intro_content = :intro_content,"; 
            $SQL .= " editor_name = :editor_name,"; 
            $SQL .= " editor_image = :editor_image,"; 
            $SQL .= " editor_text = :editor_text,"; 
            $SQL .= " president_name = :president_name,"; 
            $SQL .= " president_image = :president_image,"; 
            $SQL .= " president_text = :president_text,"; 
            //$SQL .= " newsletter_sponsor_id = :newsletter_sponsor_id,"; 
            //$SQL .= " newsletter_sig24_id = :newsletter_sig24_id,"; 
            $SQL .= " update_time = :update_time, "; 
             $SQL .= " newsletter_send_date = :newsletter_send_date, ";
            $SQL .= " disclaimer = :disclaimer,"; 
            
            $SQL .= " status = :status, ";
            $SQL .= " add_ip = :add_ip, ";
            $SQL .= " add_by = :add_by, ";
            $SQL .= " add_time = :add_time ";
            
            $stmt = $dCON->prepare( $SQL );
            $stmt->bindParam(":newsletter_id", $MAXID);
            $stmt->bindParam(":volume_name", $volume_name); 
            $stmt->bindParam(":newsletter_issue", $newsletter_issue); 
            $stmt->bindParam(":newsletter_date", $newsletter_date); 
            $stmt->bindParam(":intro_content", $intro_content); 
            $stmt->bindParam(":editor_name", $editor_name); 
            $stmt->bindParam(":editor_image", $Epath_image); 
            $stmt->bindParam(":editor_text", $editor_text); 
            $stmt->bindParam(":president_name", $president_name); 
            $stmt->bindParam(":president_image", $Ppath_image); 
            $stmt->bindParam(":president_text", $president_text); 
            //$stmt->bindParam(":newsletter_sponsor_id", $newsletter_sponsor_id); 
            //$stmt->bindParam(":newsletter_sig24_id", $newsletter_sig24_id); 
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":newsletter_send_date", $TIME);
            $stmt->bindParam(":disclaimer", $disclaimer); 
            $stmt->bindParam(":status", $status);
            $stmt->bindParam(":add_ip", $IP);
            $stmt->bindParam(":add_by", $BY);
            $stmt->bindParam(":add_time", $TIME);
            $dbRES = $stmt->execute();
            $stmt->closeCursor();
        //   echo $stmt;
            if($dbRES == 1)
            {
                $RTNID = $MAXID;
                
                ////////////Events
                
                $event_array = $_REQUEST['event_id_search_ar'];
                
                if( count($event_array) > intval(0) )
                {
                    foreach($event_array as $index => $event_id)
                    {
                         
                        $EV_MAXID = getMaxId(NEWSLETTER_EVENT_TBL, "table_id");
                         
                        $SQL_ST  = "";
                        $SQL_ST .= " INSERT INTO " . NEWSLETTER_EVENT_TBL . " SET ";
                        $SQL_ST .= " table_id = :table_id, ";
                        $SQL_ST .= " newsletter_id = :newsletter_id, ";
                        $SQL_ST .= " event_id = :event_id ";
                        
                        $stmtST = $dCON->prepare( $SQL_ST );
                        $stmtST->bindParam(":table_id",$EV_MAXID);
                        $stmtST->bindParam(":newsletter_id",$RTNID);
                        $stmtST->bindParam(":event_id",$event_id);
                        $stmtST->execute();
                        $stmtST->closeCursor(); 
                    }
                    
                } 
                
                ////////////News
                
                $news_array = $_REQUEST['news_id_search_ar'];
                
                if( count($news_array) > intval(0) )
                {
                    foreach($news_array as $index => $news_id)
                    {
                         
                        $NW_MAXID = getMaxId(NEWSLETTER_NEWS_TBL, "table_id");
                         
                        $SQL_NW  = "";
                        $SQL_NW .= " INSERT INTO " . NEWSLETTER_NEWS_TBL . " SET ";
                        $SQL_NW .= " table_id = :table_id, ";
                        $SQL_NW .= " newsletter_id = :newsletter_id, ";
                        $SQL_NW .= " news_id = :news_id ";
                        
                        $stmtNW = $dCON->prepare( $SQL_NW );
                        $stmtNW->bindParam(":table_id",$NW_MAXID);
                        $stmtNW->bindParam(":newsletter_id",$RTNID);
                        $stmtNW->bindParam(":news_id",$news_id);
                        $stmtNW->execute();
                        $stmtNW->closeCursor(); 
                    }
                    
                } 
                
                
                
                
                ////////////Resources
                
                $resources_array = $_REQUEST['resources_id_search_ar'];
                
                if( count($resources_array) > intval(0) )
                {
                    foreach($resources_array as $index => $resources_id)
                    {
                        $category_id = 1003; 
                        $RS_MAXID = getMaxId(NEWSLETTER_RESOURCES_TBL, "table_id");
                         
                        $SQL_RS  = "";
                        $SQL_RS .= " INSERT INTO " . NEWSLETTER_RESOURCES_TBL . " SET ";
                        $SQL_RS .= " table_id = :table_id, ";
                        $SQL_RS .= " newsletter_id = :newsletter_id, ";
                        $SQL_RS .= " category_id = :category_id, ";
                        $SQL_RS .= " resources_id = :resources_id ";
                        
                        $stmtRS = $dCON->prepare($SQL_RS);
                        $stmtRS->bindParam(":table_id",$RS_MAXID);
                        $stmtRS->bindParam(":newsletter_id",$RTNID);
                        $stmtRS->bindParam(":category_id",$category_id);
                        $stmtRS->bindParam(":resources_id",$resources_id);
                        $stmtRS->execute();
                        $stmtRS->closeCursor(); 
                    }
                    
                } 
              
                
            }
        }
        else
        {
            $dbRES = 2;
        }
    
    }
    
    else if($con == "modify")
    {
        $CHK = checkDuplicate(NEWSLETTER_TBL,"status~~~volume_name~~~newsletter_issue~~~newsletter_id","ACTIVE~~~$volume_name~~~$newsletter_issue~~~$newsletter_id","=~~~=~~~<>","");
  
        if( intval($CHK) == intval(0) )
        { 
            
            $FOLDER_NAME = "";
            $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER . "/";
            
            $RESIZE_WIDTH = "";
            $RESIZE_WIDTH = 130;
            
            if($editor_image !='')
            {
                $TEMP_FOLDER_EDITOR = "";
                $TEMP_FOLDER_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $folder_name_editor . "/";
                
                $R130_E_image = "R".$RESIZE_WIDTH."-".$editor_image;
                $chk_E_file = chkImageExists($TEMP_FOLDER_EDITOR . "/" . $editor_image);
                
                if(intval($chk_E_file) == intval(1))
                {
                    $img_ext = pathinfo($editor_image);
                    $Epath_image =  "editor_".date("His")."_".$newsletter_id . "." . $img_ext['extension'];
                    copy($TEMP_FOLDER_EDITOR.$editor_image, $FOLDER_NAME.$Epath_image); 
                   
                    $R130_image_E = "R".$RESIZE_WIDTH."-".$Epath_image;
                    
                    copy($TEMP_FOLDER_EDITOR.$R130_E_image,$FOLDER_NAME.$R130_image_E);
                    
                    resizeIMG("NEWSLETTER_EDITOR",trim($Epath_image),$newsletter_id,$FOLDER_NAME);  
                } 
            }
            
            
            if($president_image !='')
            {
                $TEMP_FOLDER_PRESIDENT = "";
                $TEMP_FOLDER_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $folder_name_president . "/";
                
                $R130_P_image = "R".$RESIZE_WIDTH."-".$president_image;
                $chk_P_file = chkImageExists($TEMP_FOLDER_PRESIDENT . "/" . $president_image);
                
                if(intval($chk_P_file) == intval(1))
                {
                    $img_extP = pathinfo($president_image);
                    $Ppath_image =  "president_".date("His")."_".$newsletter_id . "." . $img_extP['extension'];
                    copy($TEMP_FOLDER_PRESIDENT.$president_image, $FOLDER_NAME.$Ppath_image); 
                   
                    $R130_image_P = "R".$RESIZE_WIDTH."-".$Ppath_image;
                    
                    copy($TEMP_FOLDER_PRESIDENT.$R130_P_image,$FOLDER_NAME.$R130_image_P);
                    
                    resizeIMG("NEWSLETTER_PRESIDENT",trim($Ppath_image),$newsletter_id,$FOLDER_NAME);  
                } 
            }
            
            
            
            $SQL  = "";
            $SQL .= " UPDATE " . NEWSLETTER_TBL . " SET ";
            $SQL .= " volume_name = :volume_name,"; 
            $SQL .= " newsletter_issue = :newsletter_issue,"; 
            $SQL .= " newsletter_date = :newsletter_date,"; 
            $SQL .= " intro_content = :intro_content,"; 
            $SQL .= " editor_name = :editor_name,"; 
            $SQL .= " editor_image = :editor_image,"; 
            $SQL .= " editor_text = :editor_text,"; 
            $SQL .= " president_name = :president_name,"; 
            $SQL .= " president_image = :president_image,"; 
            $SQL .= " president_text = :president_text,"; 
            //$SQL .= " newsletter_sponsor_id = :newsletter_sponsor_id,"; 
            //$SQL .= " newsletter_sig24_id = :newsletter_sig24_id,"; 
            $SQL .= " disclaimer = :disclaimer,"; 
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, "; 
            $SQL .= " update_by = :update_by "; 
            $SQL .= " WHERE newsletter_id = :newsletter_id ";
             
            $stmt = $dCON->prepare($SQL);
            $stmt->bindParam(":volume_name", $volume_name); 
            $stmt->bindParam(":newsletter_issue", $newsletter_issue); 
            $stmt->bindParam(":newsletter_date", $newsletter_date); 
            $stmt->bindParam(":intro_content", $intro_content); 
            $stmt->bindParam(":editor_name", $editor_name); 
            $stmt->bindParam(":editor_image", $Epath_image); 
            $stmt->bindParam(":editor_text", $editor_text); 
            $stmt->bindParam(":president_name", $president_name); 
            $stmt->bindParam(":president_image", $Ppath_image); 
            $stmt->bindParam(":president_text", $president_text); 
            //$stmt->bindParam(":newsletter_sponsor_id", $newsletter_sponsor_id); 
            //$stmt->bindParam(":newsletter_sig24_id", $newsletter_sig24_id); 
            $stmt->bindParam(":disclaimer", $disclaimer); 
            
            $stmt->bindParam(":update_ip", $IP);
            $stmt->bindParam(":update_time", $TIME); 
            $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
            $stmt->bindParam(":newsletter_id", $newsletter_id); 
            $dbRES = $stmt->execute();  
            $stmt->closeCursor(); 
            if( intval($dbRES) == intval(1) )
            {
                $RTNID = $newsletter_id;
                
                ////////////Events
                $stmtEdel = $dCON->prepare("DELETE FROM " . NEWSLETTER_EVENT_TBL . " WHERE newsletter_id = :newsletter_id ");
                $stmtEdel->bindParam(":newsletter_id", $RTNID);
                $stmtEdel->execute();
                $stmtEdel->closeCursor();
                
                $event_array = $_REQUEST['event_id_search_ar'];
                
                if( count($event_array) > intval(0) )
                {
                    foreach($event_array as $index => $event_id)
                    {
                         
                        $EV_MAXID = getMaxId(NEWSLETTER_EVENT_TBL, "table_id");
                         
                        $SQL_ST  = "";
                        $SQL_ST .= " INSERT INTO " . NEWSLETTER_EVENT_TBL . " SET ";
                        $SQL_ST .= " table_id = :table_id, ";
                        $SQL_ST .= " newsletter_id = :newsletter_id, ";
                        $SQL_ST .= " event_id = :event_id ";
                        
                        $stmtST = $dCON->prepare( $SQL_ST );
                        $stmtST->bindParam(":table_id",$EV_MAXID);
                        $stmtST->bindParam(":newsletter_id",$RTNID);
                        $stmtST->bindParam(":event_id",$event_id);
                        $stmtST->execute();
                        $stmtST->closeCursor(); 
                    }
                    
                } 
                
                ////////////News
                
                $stmtNdel = $dCON->prepare("DELETE FROM " . NEWSLETTER_NEWS_TBL . " WHERE newsletter_id = :newsletter_id ");
                $stmtNdel->bindParam(":newsletter_id", $RTNID);
                $stmtNdel->execute();
                $stmtNdel->closeCursor();
                
                $news_array = $_REQUEST['news_id_search_ar'];
                
                if( count($news_array) > intval(0) )
                {
                    foreach($news_array as $index => $news_id)
                    {
                         
                        $NW_MAXID = getMaxId(NEWSLETTER_NEWS_TBL, "table_id");
                         
                        $SQL_NW  = "";
                        $SQL_NW .= " INSERT INTO " . NEWSLETTER_NEWS_TBL . " SET ";
                        $SQL_NW .= " table_id = :table_id, ";
                        $SQL_NW .= " newsletter_id = :newsletter_id, ";
                        $SQL_NW .= " news_id = :news_id ";
                        
                        $stmtNW = $dCON->prepare( $SQL_NW );
                        $stmtNW->bindParam(":table_id",$NW_MAXID);
                        $stmtNW->bindParam(":newsletter_id",$RTNID);
                        $stmtNW->bindParam(":news_id",$news_id);
                        $stmtNW->execute();
                        $stmtNW->closeCursor(); 
                    }
                    
                } 
                
                
                
                
                ////////////Resources
                
                $stmtRdel = $dCON->prepare("DELETE FROM " . NEWSLETTER_RESOURCES_TBL . " WHERE newsletter_id = :newsletter_id ");
                $stmtRdel->bindParam(":newsletter_id", $RTNID);
                $stmtRdel->execute();
                $stmtRdel->closeCursor();
                
                $resources_array = $_REQUEST['resources_id_search_ar'];
                
                if( count($resources_array) > intval(0) )
                {
                    foreach($resources_array as $index => $resources_id)
                    {
                        $category_id = 1003; 
                        $RS_MAXID = getMaxId(NEWSLETTER_RESOURCES_TBL, "table_id");
                         
                        $SQL_RS  = "";
                        $SQL_RS .= " INSERT INTO " . NEWSLETTER_RESOURCES_TBL . " SET ";
                        $SQL_RS .= " table_id = :table_id, ";
                        $SQL_RS .= " newsletter_id = :newsletter_id, ";
                        $SQL_RS .= " category_id = :category_id, ";
                        $SQL_RS .= " resources_id = :resources_id ";
                        
                        $stmtRS = $dCON->prepare($SQL_RS);
                        $stmtRS->bindParam(":table_id",$RS_MAXID);
                        $stmtRS->bindParam(":newsletter_id",$RTNID);
                        $stmtRS->bindParam(":category_id",$category_id);
                        $stmtRS->bindParam(":resources_id",$resources_id);
                        $stmtRS->execute();
                        $stmtRS->closeCursor(); 
                    }
                    
                } 
                
                
            }
        }
        else
        {
            $dbRES = 2;
        }
    }
       
    switch($dbRES)
    {
        
        case "1": 
             echo "~~~1~~~Successfully saved~~~".$RTNID;
              break;
         case "2": 
             echo "~~~2~~~You are already registered";
              break;
        default:
            echo "~~~0~~~Error occured, try again";
            break;
       
    }
}       


function listData()
{        
    global $dCON;
    global $pg;
        
    
    $search_volume_name = trustme($_REQUEST['search_volume_name']);
    $search_newsletter_issue = trustme($_REQUEST['search_newsletter_issue']);
    $search_subject = trustme($_REQUEST['search_subject']);
    
    $search_from_date = trustme($_REQUEST['search_from_date']);
    $search_to_date = trustme($_REQUEST['search_to_date']);
  
    if ( trim($search_from_date) != "" )
    {
	    $search_from_date = date('Y-m-d', strtotime($search_from_date));	 
    }
    else
    {
        $search_from_date = "";    
    }
    
    if ( $search_to_date != "" )
    {
        $search_to_date = date('Y-m-d', strtotime($search_to_date));	 
    }
    else
    {
        $search_to_date = "";    
    }
    
    
    $search = "";
    if( trim($search_volume_name) != "")
    {
        $search .= " and volume_name LIKE :volume_name ";
    }
    
    if( trim($search_newsletter_issue) != "")
    {
        $search .= " AND newsletter_issue = '".$search_newsletter_issue."' ";
    }
    
    if( trim($search_subject) != "")
    {
        $search .= " AND (search_subject like '%".$search_subject."%')";
    }
      
    if( (trim($search_from_date) != "") && (trim($search_to_date) != "") )
    {
        $search .= " AND date(newsletter_date) between '$search_from_date' AND '$search_to_date' ";
        
    } 
	else if( (trim($search_from_date) != "") && (trim($search_to_date) == "") )
    {
        $search .= " AND date(newsletter_date) = '$search_from_date' ";
    }  
     
  
    
    $SQL1 = "";
    $SQL1 .= " SELECT COUNT(*) AS CT  FROM " .  NEWSLETTER_TBL . " ";   
    $SQL1 .= " WHERE status <> 'DELETE' ";
    $SQL1 .= " $search  ";    
     
    $SQL2 = "";
    $SQL2 .= " SELECT * ";
    $SQL2 .= " FROM " .  NEWSLETTER_TBL . " as u ";
    $SQL2 .= " WHERE status <> 'DELETE' ";
    $SQL2 .= " $search  ";    
    $SQL2 .= " order by newsletter_id desc, newsletter_date desc ";    
    
    //echo $SQL1 . "<BR><BR><BR>";
    //echo $SQL2 . "<BR><BR><BR>";
    //exit;
    
    $stmt1 = $dCON->prepare($SQL1); 
    
    if(trim($search_volume_name) != "")
    { 
        $stmt1->bindParam(":volume_name", $volumename);
        $volumename = "%{$search_volume_name}%";
    }
    
    $stmt1->execute();
    $noOfRecords_row = $stmt1->fetch();
    $noOfRecords = $noOfRecords_row['CT'];
    
    $rowsPerPage = 50;
    $pg_query = $pg->getPagingQuery($SQL2,$rowsPerPage);
    $stmt2 = $dCON->prepare($pg_query[0]); 
   
    if(trim($search_volume_name) != "")
    { 
        $stmt2->bindParam(":volume_name", $volumename);
        $volumename = "%{$search_volume_name}%";
    }
    
    $stmt2->bindParam(":offset",$offset,PDO::PARAM_INT);
    $stmt2->bindParam(":RPP",$RPP,PDO::PARAM_INT);
    $offset = $pg_query[1];
    $RPP = $rowsPerPage;
    $paging = $pg->getAjaxPagingLink($noOfRecords,$rowsPerPage);
    $dA = $noOfRecords;
    $stmt2->execute();
    $row = $stmt2->fetchAll();
    //print_r($row);
    //exit;     
    //echo "==". intval($paging);
    
    $COLSPAN = 9;
   
    ?>
    <form name="frmDel" id="frmDel" method="post" action="">
    <table cellpadding="0" cellspacing="0" width="100%" border="0">
        <?php 
        if( intval($dA) > intval(0) )
        {
            global $PERMISSION;                                   
            //echo $_SESSION['PERMISSION'];                       
             
        ?>
        
            <script language="javascript" type="text/javascript">
                $(document).ready(function(){
                    
                    
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
                     
                    
                    
                    
                });
            </script>
            
            <tr>
                <td class="list_table" valign="top">
                    <table cellpadding="0" cellspacing="0" width="100%" border='0'>
                        <tr>
                            <th width="3%" align="center"><?php if( ( intval($dA) > intval(0) ) ) { ?><input type="checkbox" name="chk_all" value="1" id="chk_all" /><?php } ?></th>                     
                            <th width="15%" align="left">Date</th>
                            <th width="8%" align="left">Volume</th>
                            <th width="8%" align="left">Issue</th>
                            <th width="" align="left">Subject</th>
                            <th width="15%" align="left">Send date</th>
                            <th style='text-align: center;' width="15%">Action</th>                      
                        </tr>   
                        <?php
                        $CK_COUNTER = 0;
                        $FOR_BG_COLOR = 0; 
                        $disp = 0;
                        foreach($row as $rs)
                        {
                            $newsletter_id = "";
                            $volume_name = ""; 
                            $newsletter_date = ""; 
                            $newsletter_issue = ""; 
                            
                            
                            $newsletter_id = intval($rs['newsletter_id']);
                            $volume_name = stripslashes($rs['volume_name']);                                             
                            
                            $newsletter_date = stripslashes($rs['newsletter_date']);
                            if($newsletter_date !='0000-00-00' && $newsletter_date !='')
                            {
                                $newsletter_date = date('d M, Y', strtotime($newsletter_date));
                            }
                            $newsletter_issue = stripslashes($rs['newsletter_issue']); 
                            $newsletter_subject = stripslashes($rs['newsletter_subject']); 
                            
                            $newsletter_send_date = stripslashes($rs['newsletter_send_date']);
                            if($newsletter_send_date !='0000-00-00 00:00:00' && $newsletter_send_date !='')
                            {
                                $newsletter_send_date = date('d M, Y', strtotime($newsletter_send_date));
                            }
                            else
                            {
                                $newsletter_send_date = "-";
                            }
                            
                            
                            
                            $status = stripslashes($rs['status']);
                            $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";                
                            
                            
                            $newsletter_status = stripslashes($rs['newsletter_status']);
                            if(trim(strtoupper($newsletter_status))=='SEND')
                            {
                                $CHK = 1;  
                            }
                            else
                            {
                                $CHK = 0;  
                            }
                             
                            
                            ?>
                            <tr class="expiredCoupons trhover" >
                                <td align="center" width="3%"> 
                                    <?php
                                    if( intval($CHK) == intval(0) )
                                    {
                                        $CK_COUNTER++;
                                    ?>
                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $newsletter_id; ?>" />
                                    <?php
                                    }
                                    else
                                    {
                                        echo '<input type="checkbox" disabled=""/>';
                                    }
                                    ?>
                                    
                                </td>
                               	<td>
                                	<?php echo $newsletter_date; ?> 
                                </td>
                                <td>
                                	<?php echo $volume_name; ?> 
                                </td> 
                                <td>
                                	<?php echo $newsletter_issue; ?>   
                                </td> 
                                
                                <td>
                                	<?php echo $newsletter_subject; ?>   
                                </td> 
                                
                                <td>
                                	<?php echo $newsletter_send_date; ?>   
                                </td> 
                                
                               
                                
                                                                
                                <td align="center" >                           
                                    <div id="INPROCESS_DELETE_1_<?php echo $newsletter_id; ?>" style="display: none;"></div>
                                   <div id="INPROCESS_DELETE_2_<?php echo $newsletter_id; ?>"  >
                                        
                                        <a href="<?php echo PAGE_PREVIEW;?>?nid=<?php echo $newsletter_id; ?>" class="img_btn view_detail" title="View And Send"><img border="0" src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>view.png" class="cmsIcon" alt="View And Send" ></a></span>
                                        
                                        <a href="<?php echo PAGE_MAIN;?>?con=modify&id=<?php echo $newsletter_id; ?>" class="img_btn viewDetail" title="Modify">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify" />
                                        </a>
                                        
                                        <?php
                                        if( intval($CHK) == intval(0) )
                                        {
                                        ?>
                                            <a href="javascript:void(0);" value="<?php  echo $newsletter_id; ?>" class="deleteData img_btn">
                                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash.png" border="0" title="Delete" alt="Delete"/></a>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                             <a href="javascript:void(0);" class="img_btn">
                                             <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>trash_disable.png" border="0" title="Cannot Delete" alt="Cannot Delete"/></a>                                                             
                                        <?php
                                        }
                                        ?>
                                        
                                        
                                        
                                     </div>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>   
                </td>
            </tr>
            
            <tr>
                <td height="30" colspan="<?php echo $COLSPAN; ?>" class="txt1" style="padding-top:10px;" valign="top" id="INPROCESS_DEL">
                    <input type="button"  class="grey_btn delete_all" value="Delete Selected"  id="delete_all" disabled="" />
                 </td>
            </tr>                                                           
            <?php 
			if($paging[0]!="")
			{
			?>
                <tr>
                    <td style="padding: 10px;" align="right" colspan="<?php echo $COLSPAN; ?>">
                        <div id="pagingWrap">
                    	   <?php echo $paging[0]; ?>
                        </div>             
                     </td>
                 </tr>
            <?php 
			}
			?>  
            </form>     
        <?php
        }        
        else
        {
        ?>
            <tr>
               <td align="center" height="100"><strong>Not Found</strong></td>
           </tr>
         <?php
        } 
        ?>
    </table>
  
</form> 
<?php
}

function deleteData()
{
    global $dCON;  
    $ID = intval($_REQUEST['ID']); 
    
    
    $stmt_del = $dCON->prepare(" UPDATE " . NEWSLETTER_TBL . " SET status = 'DELETE' WHERE newsletter_id = ? ");
    $stmt_del->bindParam(1,$ID);
    $dbRES = $stmt_del->execute();
	$stmt_del->closeCursor();
    
    if ( intval($dbRES) == intval(1) )
    {  
        $CNT = getDetails(NEWSLETTER_TBL, "COUNT", "status","DELETE","!=", "", "", "" );        
        echo '~~~1~~~Deleted~~~' . $CNT . "~~~"; 
    }
    else
    {
        echo '~~~0~~~Error occured~~~';
    }
     
}

//////Delete Selected///////////////////////////////////////////////////


function deleteSelected()
{
    global $dCON;
     
    $arr = implode(",",$_REQUEST['chk']);
    $exp = explode(",",$arr);
    $i = 0;
    
    foreach($exp as $CHK)
    {
        $stmt_del = $dCON->prepare(" UPDATE " . NEWSLETTER_TBL . " SET status = 'DELETE' WHERE newsletter_id = ? ");
        $stmt_del->bindParam(1,$CHK);
        $dbRES = $stmt_del->execute();
    	$stmt_del->closeCursor();
        
        if ( intval($dbRES) == intval(1) )
        { 
            $i++;
        }
    }
    
    $msg = "(".$i.") Deleted";  
    
    echo $msg;
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
    $STR .= " UPDATE  " . NEWSLETTER_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE newsletter_id = :newsletter_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":newsletter_id", $ID);
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



function sendNewsletter()
{
    global $dCON;
    $TIME = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $send_date = date("Y-m-d");
    
     
    $ID = intval($_REQUEST['id']);
    $newsletter_subject = trustme($_REQUEST['newsletter_subject']);
    $test_email = trustme($_REQUEST['test_email']);
    
    $exp_test_email = explode(",",$test_email);
    
    $send_to_insol_member = intval($_REQUEST['send_to_insol_member']);
    $send_to_all_insol = intval($_REQUEST['send_to_all_insol']);
    $governance_id_array = $_REQUEST['send_to_governance'];  // gives governance id
    $send_to_governance_json = json_encode($governance_id_array);
    $test_group_email = intval($_REQUEST['test_group_email']);
     
        $QRY = "";

            $QRY .= " SELECT E.* FROM " . EVENT_TBL . " as E inner join " . NEWSLETTER_EVENT_TBL . " as N ";

            $QRY .= " on E.event_id = N.event_id ";

            $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY E.event_from_date ";

            //echo $QRY;

            $sEvent = $dCON->prepare( $QRY );

            $sEvent->bindParam(":newsletter_id",$ID);

            $sEvent->execute();

            $rowEvent = $sEvent->fetchAll();

            $sEvent->closeCursor();
    foreach($rowEvent as $rEvent)

                                                                                        {
                    $eventNAME = htmlentities(stripslashes($rEvent['event_name']));
                    $eventFDATE = (stripslashes($rEvent['event_from_date']));
                    $eventTDATE = (stripslashes($rEvent['event_to_date']));
                    $eventVenue = (stripslashes($rEvent['event_venue']));
                    $eventTime = (stripslashes($rEvent['event_from_time']));
                    $eventTTime = (stripslashes($rEvent['event_to_time']));
                    
                    $time=strtotime($eventFDATE);
                    $month=date("m",$time);
                    $year=date("Y",$time);
                    $day=date('d',$time);
                    
                    $time2=strtotime($eventTDATE);
                    $month2=date("m",$time2);
                    $year2=date("Y",$time2);
                    $day2=date('d',$time2);
                    
                    if($eventTime !=""){
                        $Ftime=strtotime($eventTime);
                    $hourd = date("h",$Ftime);
                    $mind = date("i",$Ftime);
                    $secd = date("s",$Ftime);
                    }else{
                    $hourd = "00";
                    $mind = "00";
                    $secd = "00";
                    }
                    if($eventTTime !=""){
                        $Ftime2=strtotime($eventTTime);
                    $hourd2 = date("h",$Ftime2);
                    $mind2 = date("i",$Ftime2);
                    $secd2 = date("s",$Ftime2);
                    }else{
                    $hourd2 = "00";
                    $mind2 = "00";
                    $secd2 = "00";
                    }
                                                                                        }
                    $array_ics = array(
                        "year" => "$year",
                        "month" => "$month",
                        "day" => "$day",
                        "year2" => "$year2",
                        "month2" => "$month2",
                        "day2" => "$day2",
                        "eventName" => $eventNAME,
                        "eventVenue" => $eventVenue,
                        "hourd" => "$hourd",
                        "mind" => "$mind",
                        "secd" => "$secd",
                        "hourd2" => "$hourd2",
                        "mind2" => "$mind2",
                        "secd2" => "$secd2",
                        "icsDate"=> $eventFDATE,
                        "icsDate2"=> $eventTDATE
                    );
    
    
    
    //$send_to_insol_member = 0;
    
    
    $STR  = "";
    $STR .= " UPDATE  " . NEWSLETTER_TBL . "  SET "; 
    $STR .= " newsletter_subject = :newsletter_subject, ";
    //if($test_email !='')
    //{
        $STR .= " test_email = :test_email, ";
    //}
    //if(intval($send_to_insol_member) == intval(1))
    //{
        $STR .= " send_to_insol_member = :send_to_insol_member, ";
        $STR .= " send_to_all_insol = :send_to_all_insol, ";
        $STR .= " send_to_governance = :send_to_governance_json, ";
        $STR .= " newsletter_send_date = :newsletter_send_date, ";
        
    //}
    
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE newsletter_id = :newsletter_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":newsletter_subject", $newsletter_subject); 
    //if($test_email !='')
    //{
        $sDEF->bindParam(":test_email", $test_email); 
    //}
    //if(intval($send_to_insol_member) == intval(1))
    //{
        $sDEF->bindParam(":send_to_insol_member", $send_to_insol_member);
        $sDEF->bindParam(":send_to_all_insol", $send_to_all_insol); 
    //}
    $sDEF->bindParam(":send_to_governance_json", $send_to_governance_json);
    $sDEF->bindParam(":newsletter_send_date", $send_date);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":newsletter_id", $ID);
    $rowUP = $sDEF->execute();
    $sDEF->closeCursor(); 
    
    // mail to governance checked ==============
    
     if(intval(count($governance_id_array)) > intval(0))
     {
        //to count id and COUNT
        $gov_info = array( 
                "governance_id" => array(),
                "count" => array()
            );
            
        foreach($governance_id_array as $governance_id)
        {
            array_push($gov_info['governance_id'], $governance_id);
            $SQL_E = "";
            $SQL_E .= " SELECT governance_email, governance_name ";
            $SQL_E .= " FROM " .  GOVERNANCE_TBL . " WHERE status = 'ACTIVE' AND governance_email !='' ";
            $SQL_E .= " AND type_id = :type_id ";
            
            $eGET = $dCON->prepare( $SQL_E );
            $eGET->bindParam(":type_id", $governance_id);
            $eGET->execute();
            $esGET = $eGET->fetchAll();
            
            $GOV_COUNT = intval(0);
            foreach($esGET as $emailVAL){
                $GOV_COUNT++;
                $EMAIL_ID = stripslashes($emailVAL['governance_email']); 
                $person_name = stripslashes($emailVAL['governance_name']); 
                $MAIL_FORMAT = newsletterFormat($ID,"NEWSLETTER", $person_name);
                //$MAIL_FORMAT = str_ireplace("%mid%", $member_id . " " . $lastname, $MAIL_FORMAT);
                //$MAIL_FORMAT = str_ireplace("%memail%", $test_email, $MAIL_FORMAT);
                $SUBJECT = $newsletter_subject;
                $TO_EMAIL = $EMAIL_ID; 
                $FROM_EMAIL = $_SESSION['INFO_EMAIL']; 
            //     if(count($rowEvent) >intval(0))
            
            //     {
            // $RES_GOV = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","",$array_ics);
            //     }else{
            //         $RES_GOV = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            //     }
                $RES_GOV = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
                
            }
             array_push($gov_info['count'], $GOV_COUNT); 
           
       }
       $_SESSION['GOVT_INFO_ARRAY'] = array_combine($gov_info['governance_id'], $gov_info['count']);
    }
   
    // mail to governance checked ends ==============    
    
    foreach($exp_test_email as $testEmail)
    {
        if($testEmail !='')
        {
            $MAIL_FORMAT = newsletterFormat($ID,"NEWSLETTER");
            $MAIL_FORMAT = str_ireplace("%mid%", $member_id . " " . $lastname, $MAIL_FORMAT);
            $MAIL_FORMAT = str_ireplace("%memail%", $test_email, $MAIL_FORMAT);
            $SUBJECT = $newsletter_subject;
            $TO_EMAIL = $testEmail; 
            $FROM_EMAIL = $_SESSION['INFO_EMAIL']; 
            // if(count($rowEvent) >intval(0))
            
            //     {
            // $RES_TEST = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","",$array_ics);
            //     }else{
            //         $RES_TEST = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            //     }
            $RES_TEST = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            
        } 
    }
    
    
    if(intval($send_to_insol_member) == intval(1))
    {
        $SQL2 = "";
        $SQL2 .= " SELECT * ";
        $SQL2 .= " FROM " .  BECOME_MEMBER_TBL . " as u WHERE status = 'ACTIVE' and subscribe ='YES' and payment_status = 'SUCCESSFUL' ";
        //$SQL2 .= " and newsletter_id !='".$ID."' and send_date !='".$send_date."'";    
        $SQL2 .= " order by member_id ";    
        
        $sGET = $dCON->prepare( $SQL2 );
        $sGET->execute();
        $rsGET = $sGET->fetchAll();
        $sGET->closeCursor();
        
        if(count($rsGET)>intval(0))
        {
            $RES_MEMBER_CT=0;
            foreach($rsGET as $rs)
            {
                $member_id = stripslashes($rs["member_id"]);
                $email = stripslashes($rs["email"]); 
                $title = stripslashes($rs["title"]); 
                $first_name = ucfirst(strtolower(stripslashes($rs["first_name"]))); 
                $middle_name = ucfirst(strtolower(stripslashes($rs["middle_name"]))); 
                $last_name = ucfirst(strtolower(stripslashes($rs["last_name"]))); 
                
                $full_name ="";
                $full_name .= $title . " " . $first_name;
                if($middle_name != ""){
                    $full_name .= " " . $middle_name;
                }
                
                $full_name .= " " . $last_name;
               
                $MAIL_FORMAT = newsletterFormat($ID,"", $full_name);
                $MAIL_FORMAT = str_ireplace("%mid%", $member_id, $MAIL_FORMAT);
                $MAIL_FORMAT = str_ireplace("%memail%", $email, $MAIL_FORMAT);
                
                $SUBJECT = $newsletter_subject;
                $TO_EMAIL = $email; 
                $FROM_EMAIL = $_SESSION['INFO_EMAIL']; 
            //     if(count($rowEvent) >intval(0))
            
            //     {
            // $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","",$array_ics);
            //     }else{
            //         $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            //     }
                
                $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
                
                if(intval($RES_M) ==intval(1))
                {
                    $RES_MEMBER_CT++;
                    
                    $STR  = "";
                    $STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET "; 
                    $STR .= " newsletter_id = :newsletter_id, ";
                    $STR .= " send_date = :send_date, ";
                    $STR .= " update_time = :update_time ";
                    $STR .= " WHERE member_id = :member_id ";
                    
                    $sUSER = $dCON->prepare($STR); 
                    $sUSER->bindParam(":newsletter_id", $ID); 
                    $sUSER->bindParam(":send_date", $send_date); 
                    $sUSER->bindParam(":update_time", $TIME);
                    $sUSER->bindParam(":member_id", $member_id);
                    $rsUSER = $sUSER->execute();
                    $sUSER->closeCursor();    
                    
                }
            }
            
            if(intval($RES_MEMBER_CT)> 0)
            {
                $STR  = "";
                $STR .= " UPDATE  " . NEWSLETTER_TBL . "  SET "; 
                $STR .= " newsletter_send_date = :newsletter_send_date, ";
                $STR .= " update_time = :update_time ";
                $STR .= " WHERE newsletter_id = :newsletter_id ";
                
                $sUSER = $dCON->prepare($STR); 
                $sUSER->bindParam(":newsletter_send_date", $send_date); 
                $sUSER->bindParam(":update_time", $TIME);
                $sUSER->bindParam(":newsletter_id", $ID);
                $rsUSER = $sUSER->execute();
                $sUSER->closeCursor();  
            }
            
        }
    
        
    }
    
    
    // Send to all insol member start
    if(intval($send_to_all_insol) == intval(1))
    {
        $SQL2 = "";
        $SQL2 .= " SELECT * ";
        $SQL2 .= " FROM " .  BECOME_MEMBER_TBL . " as u WHERE status = 'ACTIVE'";
        //$SQL2 .= " and newsletter_id !='".$ID."' and send_date !='".$send_date."'";    
        $SQL2 .= " order by member_id ";    
        
        $sGET = $dCON->prepare( $SQL2 );
        $sGET->execute();
        $rsGET = $sGET->fetchAll();
        $sGET->closeCursor();
        
        if(count($rsGET)>intval(0))
        {
            $RES_MEMBER_CT=0;
            foreach($rsGET as $rs)
            {
                $member_id = stripslashes($rs["member_id"]);
                $email = stripslashes($rs["email"]); 
                $title = stripslashes($rs["title"]); 
                $first_name = ucfirst(strtolower(stripslashes($rs["first_name"]))); 
                $middle_name = ucfirst(strtolower(stripslashes($rs["middle_name"]))); 
                $last_name = ucfirst(strtolower(stripslashes($rs["last_name"]))); 
                
                $full_name ="";
                $full_name .= $title . " " . $first_name;
                if($middle_name != ""){
                    $full_name .= " " . $middle_name;
                }
                
                $full_name .= " " . $last_name;
               
                $MAIL_FORMAT = newsletterFormat($ID,"", $full_name);
                $MAIL_FORMAT = str_ireplace("%mid%", $member_id, $MAIL_FORMAT);
                $MAIL_FORMAT = str_ireplace("%memail%", $email, $MAIL_FORMAT);
                
                $SUBJECT = $newsletter_subject;
                $TO_EMAIL = $email; 
                $FROM_EMAIL = $_SESSION['INFO_EMAIL']; 
            //     if(count($rowEvent) >intval(0))
            
            //     {
            // $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","",$array_ics);
            //     }else{
            //         $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            //     }
                $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
                
                if(intval($RES_M) ==intval(1))
                {
                    $RES_MEMBER_CT++;
                    
                    $STR  = "";
                    $STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET "; 
                    $STR .= " newsletter_id = :newsletter_id, ";
                    $STR .= " send_date = :send_date, ";
                    $STR .= " update_time = :update_time ";
                    $STR .= " WHERE member_id = :member_id ";
                    
                    $sUSER = $dCON->prepare($STR); 
                    $sUSER->bindParam(":newsletter_id", $ID); 
                    $sUSER->bindParam(":send_date", $send_date); 
                    $sUSER->bindParam(":update_time", $TIME);
                    $sUSER->bindParam(":member_id", $member_id);
                    $rsUSER = $sUSER->execute();
                    $sUSER->closeCursor();    
                    
                }
            }
            
            if(intval($RES_MEMBER_CT)> 0)
            {
                $STR  = "";
                $STR .= " UPDATE  " . NEWSLETTER_TBL . "  SET "; 
                $STR .= " newsletter_send_date = :newsletter_send_date, ";
                $STR .= " update_time = :update_time ";
                $STR .= " WHERE newsletter_id = :newsletter_id ";
                
                $sUSER = $dCON->prepare($STR); 
                $sUSER->bindParam(":newsletter_send_date", $send_date); 
                $sUSER->bindParam(":update_time", $TIME);
                $sUSER->bindParam(":newsletter_id", $ID);
                $rsUSER = $sUSER->execute();
                $sUSER->closeCursor();  
            }
            
        }
    
        
    }
    
    // send to all insol member ends
    
    //==============================FOR EMAIL TEST GROUP MEMBERS
    
    
    if(intval($test_group_email) == intval(1))
    {
        $SQL_T = "";
        $SQL_T .= " SELECT * ";
        $SQL_T .= " FROM " . TEST_EMAIL_TBL . " WHERE status = 'ACTIVE' ";
     
        $tGET = $dCON->prepare( $SQL_T );
        $tGET->execute();
        $tsGET = $tGET->fetchAll();
        $tGET->closeCursor();
        
        if(count($tsGET)>intval(0))
        {
            $RES_EMAIL_CT=0;
            foreach($tsGET as $rs)
            {
                $mail_id = stripslashes($rs["mail_id"]);
                $test_email = stripslashes($rs["test_email"]); 
                $title = stripslashes($rs["title"]); 
                $person_name = ucwords(strtolower(stripslashes($rs["test_mail_name"]))); 
                
                
               
                $MAIL_FORMAT = newsletterFormat($ID,"NEWSLETTER", $person_name);
                $MAIL_FORMAT = str_ireplace("%mid%", $member_id, $MAIL_FORMAT);
                $MAIL_FORMAT = str_ireplace("%memail%", $email, $MAIL_FORMAT);
                
                $SUBJECT = $newsletter_subject;
                $TO_EMAIL = $test_email; 
                $FROM_EMAIL = $_SESSION['INFO_EMAIL']; 
            //     if(count($rowEvent) >intval(0))
            
            //     {
            // $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","",$array_ics);
            //     }else{
            //         $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
            //     }
                $RES_M = MailObject($TO_EMAIL,$FROM_EMAIL,"", "", $SUBJECT, $MAIL_FORMAT, "","","no_ics");
                
                $_SESSION['group_members_chk'] = intval(1);
                
            }
                        
        }
    
        
    }
    
    ///////=============privious response ================================== 
    
    /*
    if($test_email !='' && intval($send_to_insol_member) == intval(1))
    {
        
        if(intval($RES_TEST) >= intval(1) && intval($RES_MEMBER_CT) > intval(0))
        {
            echo "~~~1~~~Mail successfully sent~~~".$RES_TEST."~~~".$RES_MEMBER_CT;
        }
        else if(intval($RES_TEST) >= intval(1) && intval($RES_MEMBER_CT) == intval(0))
        {
            echo "~~~1~~~Test Mail successfully sent & Error occured - For Insol member ~~~".$RES_TEST."~~~0";
        }
        else if(intval($RES_TEST) == intval(0) && intval($RES_MEMBER_CT) > intval(0))
        {
            echo "~~~1~~~($RES_MEMBER_CT) Insol member - Mail successfully sent & Error occured - For Test email ~~~".$RES_TEST."~~~0";
        }
        else
        {
            echo "~~~0~~~Error occured, try again";
        }
        
    }
    else if($test_email !='' && intval($send_to_insol_member) == intval(0))
    {   
        if(intval($RES_TEST) >= intval(1))
        {
            echo "~~~1~~~Test Mail successfully sent~~~".$RES_TEST;
        }
        else
        {
            echo "~~~0~~~Error occured, try again";
        }
    }  
    else if($test_email =='' && intval($send_to_insol_member) > intval(0))
    {   
        if(intval($RES_TEST) >= intval(1))
        {
            echo "~~~1~~~~($RES_MEMBER_CT) Insol member - Mail successfully sent~~~0~~~".$RES_MEMBER_CT;
        }
        else
        {
            echo "~~~0~~~Error occured, try again";
        }
    }
    */
    ////=============privious response ends================================== 
    
    if( ($test_email !='') || (intval($send_to_insol_member) == intval(1)) || (intval($test_group_email) == intval(1)) || (intval(count($governance_id_array)) > intval(0)))
    {
         echo "~~~1~~~Mail successfully sent~~~";
    }
    else
    {
        echo "~~~0~~~Error occured, try again";
    } 
    
}
?>