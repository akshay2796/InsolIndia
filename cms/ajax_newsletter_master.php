<?php 
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");
define("PAGE_MAIN","newsletter.php");	
define("PAGE_AJAX","ajax_newsletter.php");
define("PAGE_LIST","newsletter_list.php");

$type =  trustme($_REQUEST['type']);
switch($type)
{     
    case "saveIntro":
        saveIntro();
        break;
    case "saveDisclaimer":
        saveDisclaimer();
        break;
    
    case "removeImageEditor":
        removeImageEditor();
        break;   
        
    case "saveEditor":
        saveEditor();
        break;
    
    case "removeImagePresident":
        removeImagePresident();
        break;   
        
    case "savePresident":
        savePresident();
        break;   
    
}



function saveIntro()
{
    global $dCON;
    
    $intro_content = trustme($_REQUEST['intro_content']);
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = intval($_REQUEST['id']);
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $TIME = date("Y-m-d H:i:s");
    
    
    if($con == "add")
    {
       
            
        $MAX_ID = getMaxId(NEWSLETTER_INTRO_TBL,"intro_id");
                          
        $sql  = "";
        $sql .= " INSERT INTO " . NEWSLETTER_INTRO_TBL . " SET ";
        $sql .= " intro_id = :intro_id, ";
        $sql .= " intro_content = :intro_content, ";
        $sql .= " add_ip = :add_ip, ";
        $sql .= " add_time = :add_time, ";
        $sql .= " add_by = :add_by "; 
        
        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":intro_id", $MAX_ID);
        $stmt->bindParam(":intro_content", $intro_content);
        $stmt->bindParam(":add_ip", $ip);
        $stmt->bindParam(":add_time", $TIME);
        $stmt->bindParam(":add_by", $_SESSION['USERNAME']);
        
        $rs = $stmt->execute();
        $stmt->closeCursor();
        if( intval($rs) == intval(1) )
        {
            
            $last_insert_id = $MAX_ID;
            
        }
            
       
    }
    
    else if($con == "modify")
    {
        
        $sql  = "";
        $sql .= " UPDATE " . NEWSLETTER_INTRO_TBL . " SET ";
        $sql .= " intro_content = :intro_content, ";
        $sql .= " update_ip = :update_ip, ";
        $sql .= " update_time = :update_time, "; 
        $sql .= " update_by = :update_by "; 
        $sql .= " WHERE intro_id = :intro_id ";
         
        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":intro_content", $intro_content);
        $stmt->bindParam(":update_ip", $ip);
        $stmt->bindParam(":update_time", $TIME); 
        $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
        $stmt->bindParam(":intro_id", $id); 
        $rs = $stmt->execute();  
        $stmt->closeCursor(); 
        if( intval($rs) == intval(1) )
        {
                
            $last_insert_id = $id;
            
        }
                
       
    }
    
    switch($rs)
    {
        case "1":
            echo "~~~1~~~Successfully saved~~~".$last_insert_id;
        break;
      
        default:
            echo "~~~0~~~Sorry cannot process your request";
        break;
    }  
}


function saveDisclaimer()
{
    global $dCON;
    
    $disclaimer = trustyou($_REQUEST['dcontent']);
   
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $con = trustme($_REQUEST['con']);
    $id = intval($_REQUEST['id']);
    $ip = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    
    
    if($con == "add")
    {
       
            
        $MAX_ID = getMaxId(NEWSLETTER_INTRO_TBL,"intro_id");
                          
        $sql  = "";
        $sql .= " INSERT INTO " . NEWSLETTER_INTRO_TBL . " SET ";
        $sql .= " intro_id = :intro_id, ";
        $sql .= " disclaimer = :disclaimer, ";
        $sql .= " add_ip = :add_ip, ";
        $sql .= " add_time = :add_time, ";
        $sql .= " add_by = :add_by "; 
        
        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":intro_id", $MAX_ID);
        $stmt->bindParam(":disclaimer", $disclaimer);
        $stmt->bindParam(":add_ip", $ip);
        $stmt->bindParam(":add_time", $TIME);
        $stmt->bindParam(":add_by", $_SESSION['USERNAME']);
        
        $rs = $stmt->execute();
        $stmt->closeCursor();
        if( intval($rs) == intval(1) )
        {
            
            $last_insert_id = $MAX_ID;
            
        }
            
       
    }
    
    else if($con == "modify")
    {
        
        $sql  = "";
        $sql .= " UPDATE " . NEWSLETTER_INTRO_TBL . " SET ";
        $sql .= " disclaimer = :disclaimer, ";
        $sql .= " update_ip = :update_ip, ";
        $sql .= " update_time = :update_time, "; 
        $sql .= " update_by = :update_by "; 
        $sql .= " WHERE intro_id = :intro_id ";
         
        $stmt = $dCON->prepare($sql);
        $stmt->bindParam(":disclaimer", $disclaimer);
        $stmt->bindParam(":update_ip", $ip);
        $stmt->bindParam(":update_time", $TIME); 
        $stmt->bindParam(":update_by", $_SESSION['USERNAME']);
        $stmt->bindParam(":intro_id", $id); 
        $rs = $stmt->execute();  
        $stmt->closeCursor(); 
        if( intval($rs) == intval(1) )
        {
            $last_insert_id = $id;
        }
    }
    switch($rs)
    {
        case "1":
            echo "~~~1~~~Successfully saved~~~".$last_insert_id;
        break;
      
        default:
            echo "~~~0~~~Sorry cannot process your request";
        break;
    }  
}

/////////////////////////////////////////////////////////////////////

function removeImageEditor()
{
    global $dCON;
    $image_name = trustme($_REQUEST['image_name']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = trustme($_REQUEST['foldername']);
    
    if($imageId == intval(0))
    {
        //delete image
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
        
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("NEWSLETTER_EDITOR",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                      
            $stk_del = $dCON->prepare("update " . NEWSLETTER_EDITOR_TBL . " set editor_image ='' WHERE editor_id = :editor_id " );
            $stk_del->bindParam(":editor_id", $ID);
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

function saveEditor()
{
    global $dCON;
    
    $con = $_REQUEST['con'];
    $id = $_REQUEST['id'];  
    
    $image_array = $_REQUEST['image']; 
    $image_id_array = $_REQUEST['editor_id'];
    $folder_name_array = $_REQUEST['folder_name'];
    
    $editor_name = trustme($_REQUEST['editor_name']);
    
    $editor_text = trustyou($_REQUEST['econtent']);
    
    
    //echo "===".$image_array;
    //$TEMP_FOLDER_NAME = "";
    //$TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    //$FOLDER_NAME = "";
    //$FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_COVER_IMG . "/";
    
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $TIME = date("Y-m-d H:i:s");
    $sessionid = session_id();
    
    if($con == "add")
    {
        $MAXID = getMaxId(NEWSLETTER_EDITOR_TBL,"editor_id"); 
        
        $SQL_IMG  = "";
        $SQL_IMG .= " INSERT INTO " . NEWSLETTER_EDITOR_TBL . " SET ";
        $SQL_IMG .= " editor_id = :editor_id, ";    
        $SQL_IMG .= " editor_name = :editor_name, "; 
        $SQL_IMG .= " editor_text = :editor_text, "; 
        $SQL_IMG .= " add_ip = :add_ip, ";         
        $SQL_IMG .= " add_by = :add_by, ";         
        $SQL_IMG .= " add_time = :add_time, "; 
        $SQL_IMG .= " update_time = :update_time ";  
        
        $stmtIMG = $dCON->prepare( $SQL_IMG );
        $stmtIMG->bindParam(":editor_id", $MAXID);
        $stmtIMG->bindParam(":editor_name", $editor_name); 
        $stmtIMG->bindParam(":editor_text", $editor_text); 
        $stmtIMG->bindParam(":add_ip",$IP);
        $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
        $stmtIMG->bindParam(":add_time",$TIME);
        $stmtIMG->bindParam(":update_time", $TIME); 
        $rsImage = $stmtIMG->execute();
        //print_r($stmtIMG->errorInfo());
        $stmtIMG->closeCursor();
        
        /*
        if(intval(count($image_array)) > intval(0))
        {                     
            
            foreach($image_array as $indx => $image_result)
            {
                $image_file_name = "";
                $image_file_name = trustme($image_result);
                
                $editor_id = intval($image_id_array[$indx]);
                
                $MYFOLDERNAME = "";
                $MYFOLDERNAME = $folder_name_array[$indx];
                 
                $TEMP_FOLDER_NAME = "";
                $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                
                $FOLDER_NAME = "";
                $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_EDITOR . "/";
                
                $RESIZE_WIDTH = "";
                $RESIZE_WIDTH = 130;
                
                 
                $R130_image = "R".$RESIZE_WIDTH."-".$image_file_name;
                $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image_file_name);
                
                if(intval($chk_file) == intval(1))
                {
                    
                    $MAXID = getMaxId(NEWSLETTER_EDITOR_TBL,"editor_id"); 
                    
                    $img_ext = pathinfo($image_file_name);
                    $fpath_image =  "editor_".$MAXID . "." . $img_ext['extension'];
                    
                    copy($TEMP_FOLDER_NAME.$image_file_name, $FOLDER_NAME.$fpath_image); 
                    
                    //rename img name of R130 image
                    $R130_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
                     //Rename R130 Image
                    copy($TEMP_FOLDER_NAME.$R130_image,$FOLDER_NAME.$R130_image_f);
                    
                    resizeIMG("NEWSLETTER_EDITOR",trim($fpath_image),$MAXID,$FOLDER_NAME);  
                    
                    
                    $SQL_IMG  = "";
                    $SQL_IMG .= " INSERT INTO " . NEWSLETTER_EDITOR_TBL . " SET ";
                    $SQL_IMG .= " editor_id = :editor_id, ";    
                    $SQL_IMG .= " editor_image = :editor_image, "; 
                    $SQL_IMG .= " editor_text = :editor_text, "; 
                    $SQL_IMG .= " add_ip = :add_ip, ";         
                    $SQL_IMG .= " add_by = :add_by, ";         
                    $SQL_IMG .= " add_time = :add_time ";             
                    
                    $stmtIMG = $dCON->prepare( $SQL_IMG );
                    $stmtIMG->bindParam(":editor_id", $MAXID);
                    $stmtIMG->bindParam(":editor_image", $fpath_image); 
                    $stmtIMG->bindParam(":editor_text", $editor_text); 
                    $stmtIMG->bindParam(":add_ip",$IP);
                    $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
                    $stmtIMG->bindParam(":add_time",$TIME); 
                    $rsImage = $stmtIMG->execute();
                    //print_r($stmtIMG->errorInfo());
                    $stmtIMG->closeCursor();
                    
                }
                
               
                
            }
            
           
        } 
        */
        
        
        
        
    }
    else if($con == "modify")
    { 
        
        $stmtCOL_del = $dCON->prepare("DELETE FROM " . NEWSLETTER_EDITOR_TBL . " ");
        $stmtCOL_del->execute();
        $stmtCOL_del->closeCursor();
        
        $MAXID = getMaxId(NEWSLETTER_EDITOR_TBL,"editor_id"); 
        
        $SQL_IMG  = "";
        $SQL_IMG .= " INSERT INTO " . NEWSLETTER_EDITOR_TBL . " SET ";
        $SQL_IMG .= " editor_id = :editor_id, ";    
        $SQL_IMG .= " editor_name = :editor_name, "; 
        $SQL_IMG .= " editor_text = :editor_text, "; 
        $SQL_IMG .= " add_ip = :add_ip, ";         
        $SQL_IMG .= " add_by = :add_by, ";         
        $SQL_IMG .= " add_time = :add_time ";             
        
        $stmtIMG = $dCON->prepare( $SQL_IMG );
        $stmtIMG->bindParam(":editor_id", $MAXID);
        $stmtIMG->bindParam(":editor_name", $editor_name); 
        $stmtIMG->bindParam(":editor_text", $editor_text); 
        $stmtIMG->bindParam(":add_ip",$IP);
        $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
        $stmtIMG->bindParam(":add_time",$TIME); 
        $rsImage = $stmtIMG->execute();
        //print_r($stmtIMG->errorInfo());
        $stmtIMG->closeCursor();
        
        /*
        if(intval(count($image_array)) > intval(0))
        {                     
            
            $stmtCOL_del = $dCON->prepare("DELETE FROM " . NEWSLETTER_EDITOR_TBL . " ");
            $stmtCOL_del->execute();
            $stmtCOL_del->closeCursor();
            
            
            foreach($image_array as $indx => $image_result)
            {
                $image_file_name = "";
                $image_file_name = trustme($image_result);
                
                $editor_id = intval($image_id_array[$indx]);
                
                
                $MYFOLDERNAME = "";
                $MYFOLDERNAME = $folder_name_array[$indx];
                 
                $TEMP_FOLDER_NAME = "";
                $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                
                $FOLDER_NAME = "";
                $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_EDITOR . "/";
                
                $RESIZE_WIDTH = "";
                $RESIZE_WIDTH = 130;
                
                 
                $R130_image = "R".$RESIZE_WIDTH."-".$image_file_name;
                $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image_file_name);
                
                
                if(intval($chk_file) == intval(1))
                {
                    
                    $MAXID = getMaxId(NEWSLETTER_EDITOR_TBL,"editor_id"); 
                    
                    $img_ext = pathinfo($image_file_name);
                    $fpath_image =  "editor_".$MAXID . "." . $img_ext['extension'];
                    
                    copy($TEMP_FOLDER_NAME.$image_file_name, $FOLDER_NAME.$fpath_image); 
                    
                    //rename img name of R130 image
                    $R130_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
                     //Rename R130 Image
                    copy($TEMP_FOLDER_NAME.$R130_image,$FOLDER_NAME.$R130_image_f);
                    
                    resizeIMG("NEWSLETTER_EDITOR",trim($fpath_image),$MAXID,$FOLDER_NAME);  
                   
                    $SQL_IMG  = "";
                    $SQL_IMG .= " INSERT INTO " . NEWSLETTER_EDITOR_TBL . " SET ";
                    $SQL_IMG .= " editor_id = :editor_id, ";    
                    $SQL_IMG .= " editor_image = :editor_image, "; 
                    $SQL_IMG .= " editor_text = :editor_text, "; 
                    $SQL_IMG .= " add_ip = :add_ip, ";         
                    $SQL_IMG .= " add_by = :add_by, ";         
                    $SQL_IMG .= " add_time = :add_time ";             
                    
                    $stmtIMG = $dCON->prepare( $SQL_IMG );
                    $stmtIMG->bindParam(":editor_id", $MAXID);
                    $stmtIMG->bindParam(":editor_image", $fpath_image); 
                    $stmtIMG->bindParam(":editor_text", $editor_text); 
                    $stmtIMG->bindParam(":add_ip",$IP);
                    $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
                    $stmtIMG->bindParam(":add_time",$TIME); 
                    $rsImage = $stmtIMG->execute();
                    //print_r($stmtIMG->errorInfo());
                    $stmtIMG->closeCursor();
                    
                }
            }
        }
        */
    }
    
    switch($rsImage)
    {
        case "1":  
            echo "~~~1~~~Successfully saved~~~$insertId";
        break;
        case "2":
            echo "~~~2~~~Already exists~~~$insertId";
         break;
        case "3":
            echo "~~~3~~~URL key already exists~~~";
        break;
        default:
            echo "~~~0~~~Sorry cannot process your request~~~";
        break;
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
        
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)) 
        {
            
            deleteIMG("NEWSLETTER_PRESIDENT",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                      
            $stk_del = $dCON->prepare("update " . NEWSLETTER_PRESIDENT_TBL . " set president_image ='' WHERE president_id = :president_id " );
            $stk_del->bindParam(":president_id", $ID);
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


function savePresident()
{
    global $dCON;
    
    $con = $_REQUEST['con'];
    $id = intval($_REQUEST['id']);  
    
    $image_file_name = trustme($_REQUEST['image']); 
    $president_id = trustme($_REQUEST['president_id']);
    $folder_name = $_REQUEST['folder_name'];
    
    
    $president_name = trustme($_REQUEST['president_name']);
    
    $president_text = trustyou($_REQUEST['pcontent']);
   
    
    
    $IP = trustme($_SERVER['REMOTE_ADDR']);
    $TIME = date("Y-m-d H:i:s");
    $sessionid = session_id();
    
    if($con == "add")
    {
        $MAXID = getMaxId(NEWSLETTER_PRESIDENT_TBL,"president_id"); 
        
        $MYFOLDERNAME = "";
        $MYFOLDERNAME = $folder_name;
         
        $TEMP_FOLDER_NAME = "";
        $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
        
        $FOLDER_NAME = "";
        $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_PRESIDENT . "/";
        
        $RESIZE_WIDTH = "";
        $RESIZE_WIDTH = 130;
                
                 
        $R130_image = "R".$RESIZE_WIDTH."-".$image_file_name;
        $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image_file_name);
        
        if(intval($chk_file) == intval(1))
        {
            $img_ext = pathinfo($image_file_name);
            $fpath_image =  "president_".$MAXID . "." . $img_ext['extension'];
            
            copy($TEMP_FOLDER_NAME.$image_file_name, $FOLDER_NAME.$fpath_image); 
            //rename img name of R130 image
            $R130_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
             //Rename R130 Image
            copy($TEMP_FOLDER_NAME.$R130_image,$FOLDER_NAME.$R130_image_f);
            
            resizeIMG("NEWSLETTER_PRESIDENT",trim($fpath_image),$MAXID,$FOLDER_NAME);  
        }            
                    
        $SQL_IMG  = "";
        $SQL_IMG .= " INSERT INTO " . NEWSLETTER_PRESIDENT_TBL . " SET ";
        $SQL_IMG .= " president_id = :president_id, ";    
        $SQL_IMG .= " president_name = :president_name, "; 
        $SQL_IMG .= " president_text = :president_text, "; 
        $SQL_IMG .= " add_ip = :add_ip, ";         
        $SQL_IMG .= " add_by = :add_by, ";         
        $SQL_IMG .= " add_time = :add_time ";             
        
        $stmtIMG = $dCON->prepare( $SQL_IMG );
        $stmtIMG->bindParam(":president_id", $MAXID);
        $stmtIMG->bindParam(":president_name", $president_name); 
        $stmtIMG->bindParam(":president_text", $president_text); 
        $stmtIMG->bindParam(":add_ip",$IP);
        $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
        $stmtIMG->bindParam(":add_time",$TIME); 
        $rsImage = $stmtIMG->execute();
        //print_r($stmtIMG->errorInfo());
        $stmtIMG->closeCursor();
            
        
    }
    else if($con == "modify")
    { 
        $MAXID = $id; 
               
        $MYFOLDERNAME = "";
        $MYFOLDERNAME = $folder_name;
         
        $TEMP_FOLDER_NAME = "";
        $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
        
        $FOLDER_NAME = "";
        $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWSLETTER_PRESIDENT . "/";
        
        $RESIZE_WIDTH = "";
        $RESIZE_WIDTH = 130;
                
                 
        $R130_image = "R".$RESIZE_WIDTH."-".$image_file_name;
        $chk_file = chkImageExists($TEMP_FOLDER_NAME . "/" . $image_file_name);
        
                
        if(intval($chk_file) == intval(1))
        {
            
            $img_ext = pathinfo($image_file_name);
            $fpath_image =  "president_".$MAXID . "." . $img_ext['extension'];
            
            copy($TEMP_FOLDER_NAME.$image_file_name, $FOLDER_NAME.$fpath_image); 
            
            //rename img name of R130 image
            $R130_image_f = "R".$RESIZE_WIDTH."-".$fpath_image;
             //Rename R130 Image
            copy($TEMP_FOLDER_NAME.$R130_image,$FOLDER_NAME.$R130_image_f);
            
            resizeIMG("NEWSLETTER_PRESIDENT",trim($fpath_image),$MAXID,$FOLDER_NAME);  
        }           
       
        $SQL_IMG  = "";
        $SQL_IMG .= " UPDATE " . NEWSLETTER_PRESIDENT_TBL . " SET ";
        $SQL_IMG .= " president_name = :president_name, "; 
        $SQL_IMG .= " president_text = :president_text, "; 
        $SQL_IMG .= " update_ip = :update_ip, ";
        $SQL_IMG .= " update_time = :update_time, "; 
        $SQL_IMG .= " update_by = :update_by "; 
        $SQL_IMG .= " WHERE president_id = :president_id ";
                   
        
        $stmtIMG = $dCON->prepare( $SQL_IMG );
        
        $stmtIMG->bindParam(":president_name", $president_name); 
        $stmtIMG->bindParam(":president_text", $president_text); 
        $stmtIMG->bindParam(":update_ip", $ip);
        $stmtIMG->bindParam(":update_time", $TIME); 
        $stmtIMG->bindParam(":update_by", $_SESSION['USERNAME']);
        $stmtIMG->bindParam(":president_id", $id);
        $rsImage = $stmtIMG->execute();
        //print_r($stmtIMG->errorInfo());
        $stmtIMG->closeCursor();
          
    }
    
    switch($rsImage)
    {
        case "1":  
            echo "~~~1~~~Successfully saved~~~$insertId";
        break;
        case "2":
            echo "~~~2~~~Already exists~~~$insertId";
         break;
        case "3":
            echo "~~~3~~~URL key already exists~~~";
        break;
        default:
            echo "~~~0~~~Sorry cannot process your request~~~";
        break;
    } 


}


        


?>