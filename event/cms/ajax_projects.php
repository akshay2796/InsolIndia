<?php 
session_start();
error_reporting(0);
include("ajax_include.php");  

include("../library_insol/class.imageresizer.php");
define("PAGE_MAIN","projects.php");	
define("PAGE_AJAX","ajax_projects.php");
define("PAGE_LIST","projects_list.php");

define("SET1_ENABLE",true);
if ( SET1_ENABLE == true ){
    
    define("SET1_TYPE","IMAGE");
    if ( SET1_TYPE == "FILE" ){ 
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);      
        define("SET1_IMAGE_CAPTION",false);   
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['EVENT_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['EVENT_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","");    
        
    }else if ( SET1_TYPE == "IMAGE" ){
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);   
        define("SET1_IMAGE_CAPTION",true);  
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['EVENT_IMG_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['EVENT_IMG_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","Min. size required 245px x 160px");
    
    }    
    
    define("SET1_FOR","PROJECTS-LOGO");
    define("SET1_MANDATORY",false);
    
    define("SET1_FOLDER",FLD_PROJECTS . "/" . FLD_PROJECTS_LOGO_IMG);
    define("SET1_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);
    
    define("SET1_DBTABLE",PROJECTS_LOGO_IMAGES_TBL);
    $SET1_RADIO_DISPLAY = " style=display:none; ";
     
    
    $SET1_RESIZE_DIMENSION = "" ; //widthXheight|weightXheight SEPRATED BY PIPE
    $SET1_SAVE_RESIZE_LOCATION_RELPATH = ""; 
    $SET1_RESIZE_PREFIX_RELPATH = "";
    
    if ( SET1_IMAGE_CROPPING  == true ){
        
        define("PAGE_CROP_IMAGE","popupCROP.php");
        
        define("SET1_CROP_SIZE","");
        define("SET1_CROP_PREFIX","C".SET1_CROP_SIZE."-"); 
        define("SET1_CROP_ASPECT_RATIO","1:1");
        define("SET1_CROP_IMAGE_WIDTH","500");
        define("SET1_CROP_IMAGE_HEIGHT","500");
        
        
        
        define("SET1_IMAGE_RESIZE","YES");  /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========    
        define("SET1_IMAGE_RESIZE_WIDTH",700);
        define("SET1_IMAGE_RESIZE_HEIGHT",700);    
        define("SET1_IMAGE_RESIZE_PREFIX","R".SET1_IMAGE_RESIZE_WIDTH."-");
        
        $SET1_RESIZE_DIMENSION = SET1_IMAGE_RESIZE_WIDTH . "X" . SET1_IMAGE_RESIZE_HEIGHT;
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
        
        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;
          
        
    }else if ( SET1_IMAGE_CROPPING  == false ){ 
        
        define("SET1_IMAGE_RESIZE","NO");   /// UPLAOD AND RESIZE IMMEDIATELY ON UPLOAD ===========
        
        define("SET1_CROP_SIZE","");
        define("SET1_CROP_PREFIX","");  
        define("SET1_CROP_ASPECT_RATIO","");
        define("SET1_CROP_IMAGE_WIDTH","");
        define("SET1_CROP_IMAGE_HEIGHT","");
          
        
        define("SET1_IMAGE_RESIZE_WIDTH","");
        define("SET1_IMAGE_RESIZE_HEIGHT","");       
        define("SET1_IMAGE_RESIZE_PREFIX",""); 
        
        $SET1_RESIZE_DIMENSION = "";    
        $SET1_SAVE_RESIZE_LOCATION_RELPATH = "../".CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
        
        $SET1_RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . SET1_IMAGE_RESIZE_PREFIX;
        
    } 
    
}

$type =  trustme($_REQUEST['type']);
switch($type)
{    
    case "removeHomeImage":
        removeHomeImage();
    break;
    
    case "removeImage":
        removeImage();
        break;          
    
    case "removeFile":
        removeFile();
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
    case "setHomePage":
        setHomePage();
        break;
    
    case "removeFypeFILE":
        removeFypeFILE();
        break; 
        
    case "removeVTypeFILE":
        removeVTypeFILE();
        break;
}

function removeHomeImage()
{
    global $dCON;
    $image_name = trustme($_REQUEST['editor_image']);
    $imageId = intval($_REQUEST['imageId']);
    $FOLDER_NAME = FLD_PROJECTS."/".FLD_HOMEPAGE_IMAGE; 
    
    if($imageId == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $image_name)) 
        {
            deleteIMG("PROJECTS_HOMEPAGE_IMAGE",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
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
            
            deleteIMG("PROJECTS_HOMEPAGE_IMAGE",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                        
            $SQL = "";
            $SQL .= "UPDATE " . PROJECTS_TBL . " SET " ;
            $SQL .= " homepage_image = :image_name, ";
            $SQL .= " homepage_image_id = :image_id ";
            $SQL .= " WHERE projects_id = :projects_id ";
            //echo "$SQL---$img---$img_id-----$imageId" ;
            
            $image_name = "";
            $img_id = intval(0);            
                 
            $stk_upd = $dCON->prepare($SQL);
            $stk_upd->bindParam(":image_name", $image_name);
            $stk_upd->bindParam(":image_id", $img_id);
            $stk_upd->bindParam(":projects_id", $imageId);
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



function removeFypeFILE()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);
    
    if( intval($ID) == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/" . $image_name)) 
        {
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete Image";
        }
    }
    else
    {
        $IMG = getDetails(PROJECTS_TBL, 'file_name', "projects_id","$ID",'=', '', '' , "");  
         
        unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/" . $IMG);
                  
        $stk_del = $dCON->prepare("update " . PROJECTS_TBL . " set file_name ='' WHERE projects_id = :projects_id " );
        $stk_del->bindParam(":projects_id", $ID);
        $stk_del->execute();
        $stk_del->closeCursor();
         
        echo "1~~~Deleted";
     
        
    } 
    
    
}

function removeVTypeFILE()
{
    global $dCON;
    $ID = intval($_REQUEST['ID']);
    
    if( intval($ID) > intval(0))
    {
        $VDO = getDetails(PROJECTS_TBL, 'video_file', "projects_id","$ID",'=', '', '' , "");  
         
        unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_VDO . "/" . $VDO);
                  
        $stk_del = $dCON->prepare("update " . PROJECTS_TBL . " set video_file ='' WHERE projects_id = :projects_id " );
        $stk_del->bindParam(":projects_id", $ID);
        $stk_del->execute();
        $stk_del->closeCursor();
         
        echo "1~~~Deleted";
     
        
    } 
    
    
}

function removeImage()
{
    global $dCON;
     $image_name = trustme($_REQUEST['image_name']);
    $imgID = intval($_REQUEST['imgID']);
    $FOLDER_NAME = trustme($_REQUEST['foldername']);
    
    $copy = intval($_REQUEST['copy']);
    //exit;
    
    //echo "$imgID==$image_name==$FOLDER_NAME===$copy";    
    //exit();
    
    if(intval($copy)==intval(1)){
        echo "~~~1~~~Deleted~~~";
    }else{
        
        if($imgID == intval(0)){
            $FOLDER_NAME = TEMP_UPLOAD;
            
            deleteIMG("TEMP",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
            
            echo "~~~1~~~Deleted~~~";
            exit();
            
        }elseif($imgID > intval(0)){            
            
            $FOLDER_NAME = $FOLDER_NAME;            
            
            if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name)){
            
                deleteIMG(SET1_FOR,$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                if ( trim(SET1_IMAGE_CROPPING) == true ){
                    deleteIMG("TEMP",$image_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME );
                }
                //echo "$imgID==$image_name==$FOLDER_NAME===$copy";    
                //exit();
                if($imgID > intval(0)){ 
                    
                    $sDEL = $dCON->prepare("DELETE FROM " . SET1_DBTABLE . " WHERE image_id = :image_id " );
                    $sDEL->bindParam(":image_id", $imgID);
                    $sDEL->execute();
                    $sDEL->closeCursor();
                
                }           
                
                echo "~~~1~~~Deleted~~~";
                
            }else{
                echo "~~~0~~~Sorry Cannot Delete~~~";
            }
            
            
                        
        }
        //echo CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME . "/" . $image_name;
        //exit();
        
        
        
        
        
        
    }
    
     
}


function removeFile()
{
    global $dCON;
    $file_name = trustme($_REQUEST['file_name']);
    $projects_id = intval($_REQUEST['fileId']);
    if($projects_id == intval(0))
    {
        //delete image
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/" . $file_name)) 
        {
            deleteIMG("PUBLICATION_FILE",$file_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD );
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete File";
        }
    }
    else
    {
       
        if(unlink(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PUBLICATION_FILE . "/" . $file_name)) 
        {
            
            deleteIMG("PUBLICATION_FILE",$file_name,CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PUBLICATION_FILE );
                      
            $stk_del = $dCON->prepare("update " . FLD_PROJECTS_LOGO_IMG . " set file_name = '' WHERE projects_id = :projects_id " );
            $stk_del->bindParam(":projects_id", $projects_id);
            $stk_del->execute();
            $stk_del->closeCursor();
             
            echo "1~~~Deleted";
        } 
        else 
        {
            echo "0~~~Sorry Cannot Delete File";
        }
        
    } 
}



function saveData()
{
    global $dCON;    
    
    $projects_title = trustme($_REQUEST['projects_title']);
   
    //echo("---$show_in_current");
    //exit();
   /* $projects_from_date = trustme($_REQUEST['projects_from_date']);
    $projects_to_date = trustme($_REQUEST['projects_to_date']);
    if($projects_to_date == "")
    {
        $projects_to_date = $projects_from_date;
    }
     
    $projects_from_date_array = explode("-", $projects_from_date);
    $projects_from_date = $projects_from_date_array[2] . "-" . $projects_from_date_array[1] . "-" . $projects_from_date_array[0];
    
    $projects_to_date_array = explode("-", $projects_to_date);
    $projects_to_date = $projects_to_date_array[2] . "-" . $projects_to_date_array[1] . "-" . $projects_to_date_array[0]; */
    
    //homepage image
    $image = trustme($_REQUEST['editor_image']); 
    $image_id = trustme($_REQUEST['image_id']);
    
    //echo " $event_from_time ============== $event_to_time \n";
    //exit();
    
   
    $projects_description = trustyou($_REQUEST['dcontent']);
    $url = trustme($_REQUEST['url']);
    
    $ftype_file_path = "";
    $ftype_file_path = trustme($_REQUEST['ftype_file_path']);    
    $old_ftype_file = trustme($_REQUEST['old_ftype_file']);
   
    if ( SET1_ENABLE == true ){
    
        $SET1_ARR_image = $_REQUEST['set1_image']; 
        $SET1_deafult = $_REQUEST['set1_default_image'];
        $SET1_ARR_imageid = $_REQUEST['set1_image_id'];
        $SET1_ARR_imagecaption = $_REQUEST['set1_image_caption'];
        $SET1_ARR_folder = $_REQUEST['set1_folder_name'];
         
        
        if ( SET1_IMAGE_CROPPING == true ){    
            $SET1_ARR_coordinates = $_REQUEST['set1_coordinates'];   //Crop Image Coordinates            
        }elseif ( SET1_IMAGE_CROPPING == false ){
            $SET1_ARR_coordinates = "";    
        }
    
    }
    
    
    $status = trustme($_REQUEST['status']); //"ACTIVE";
    $status = trim($status) == '' ? "ACTIVE" : trim($status);
    
    $con = trustme($_REQUEST['con']);
    $id = (int) $_REQUEST['id'];
    $IP = $_SERVER['REMOTE_ADDR'];
    $TIME = date("Y-m-d H:i:s");
    $SESSIONID = session_id();
    
    $url_key = filterString($projects_title);
    $meta_title = trustme($_REQUEST['meta_title']);
    $meta_keyword = trustme($_REQUEST['meta_keyword']);
    $meta_description = trustme($_REQUEST['meta_description']);
    
    $meta_title = trim($meta_title) == '' ? trim($projects_title) : trim($meta_title);
    $meta_keyword = trim($meta_keyword) == '' ? trim($projects_title) : trim($meta_keyword);
    $meta_description = trim($meta_description) == '' ? trim($projects_title) : trim($meta_description);
    
    $FTYPE_TEMP_FOLDER = "";
    $FTYPE_TEMP_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/";
    $FTYPE_FILE_FOLDER = "";
    $FTYPE_FILE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_PROJECTS_FILE . "/";
    
    $TEMP_FOLDER_NAME = "";
    $TEMP_FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
    
    $FOLDER_NAME = "";
    $FOLDER_NAME = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS . "/" . FLD_HOMEPAGE_IMAGE . "/";
   
    
    if($con == "add")
    {
        $CHK = checkDuplicate(PROJECTS_TBL,"projects_title","$projects_title","=","");
        //echo $section_name;       
                 
        if( intval($CHK) == intval(0) )
        {
            
            $MAX_ID = getMaxId(PROJECTS_TBL,"projects_id");
            $MAX_POS = getMaxPosition(PROJECTS_TBL,"position","","","=");
            $MY_URLKEY = getURLKEY(PROJECTS_TBL,$url_key,$projects_title,"","","",$MAX_ID,""); 
            
            if( ( trim($ftype_file_path) != "" ) )
            {
                 
                $ft_ext = pathinfo($ftype_file_path);
                
                $ftFILE =  strtolower(filterString($projects_title)) . "-" . $MAX_ID ."." . $ft_ext['extension'];
                rename($FTYPE_TEMP_FOLDER.$ftype_file_path, $FTYPE_FILE_FOLDER.$ftFILE);
                
                 
                
            }else{
                $ftFILE = "";
            } 
            
             if($image != "")
            {
                $title_filter = filterString($projects_title);
                $i_ext = pathinfo($image);
                
                $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                resizeIMG("PROJECTS_HOMEPAGE_IMAGE",trim($imgpath_name),$MAX_ID,$FOLDER_NAME);
                
                $image_id = intval(1);
            }
            else
            {
                $imgpath_name = "";
                $image_id = intval(0);
            } 
            
            $SQL  = "";
            $SQL .= " INSERT INTO " . PROJECTS_TBL . " SET ";
            $SQL .= " projects_id = :projects_id, ";            
            $SQL .= " projects_title = :projects_title, ";
           // $SQL .= " projects_from_date = :projects_from_date, ";
           // $SQL .= " projects_to_date = :projects_to_date, ";          
            $SQL .= " projects_description = :projects_description, ";
            
            $SQL .= " homepage_image = :image_name, ";
            $SQL .= " homepage_image_id = :image_id, ";
            
            $SQL .= " file_name = :file_name, ";
            //$SQL .= " url = :url, ";                     
            
            $SQL .= " status = :status, ";
            $SQL .= " position = :position, ";
            $SQL .= " add_ip = :add_ip, ";
            $SQL .= " add_time = :add_time, ";
            $SQL .= " add_by = :add_by, ";
            $SQL .= " url_key = :url_key, "; 
            $SQL .= " meta_title = :meta_title, "; 
            $SQL .= " meta_keyword = :meta_keyword, ";
            $SQL .= " meta_description = :meta_description "; 
            
            $sINS = $dCON->prepare($SQL);
            $sINS->bindParam(":projects_id", $MAX_ID);
            
            $sINS->bindParam(":projects_title", $projects_title);            
            //$sINS->bindParam(":projects_from_date", $projects_from_date);
           // $sINS->bindParam(":projects_to_date", $projects_to_date);
            $sINS->bindParam(":projects_description", $projects_description);
            
            $sINS->bindParam(":image_name", $imgpath_name); 
            $sINS->bindParam(":image_id", $image_id); 
                      
            $sINS->bindParam(":file_name", $ftFILE);  
            //$sINS->bindParam(":url", $url);
            
            $sINS->bindParam(":status", $status); 
            $sINS->bindParam(":position", $MAX_POS); 
            $sINS->bindParam(":add_ip", $IP);
            $sINS->bindParam(":add_time", $TIME);
            $sINS->bindParam(":add_by", $_SESSION['USERNAME']);
            $sINS->bindParam(":url_key", $MY_URLKEY);
            $sINS->bindParam(":meta_title", $meta_title);
            $sINS->bindParam(":meta_keyword", $meta_keyword);
            $sINS->bindParam(":meta_description", $meta_description);
            $RES = $sINS->execute();
            $sINS->closeCursor();
            
            if( intval($RES) == intval(1) )
            {
                $RTNID = $MAX_ID;     
                
                
                if ( SET1_ENABLE == true ){ 
                        
                    /////////////---------------Saved Gallery============================
                    $TITLE = $projects_title;
                    include("include_SET1_SAVE4ADD.php");  
                 
                
                }
          
                
            }
            
        }
        else
        {
            $RES = 2;
        }
    }
    
    else if($con == "modify")
    {
       
        $CHK = checkDuplicate(PROJECTS_TBL,"projects_title~~~projects_id","$projects_title~~~$id","=~~~<>","");
        
        if( intval($CHK) == intval(0) )
        { 
            $MY_URLKEY = getURLKEY(PROJECTS_TBL,$url_key,$projects_title,"projects_id",$id,"<>",$id); 
            
            /*
            echo $video_type . "\n";
            echo $old_video . "\n";
            echo $video_file_path . "\n";
            echo $VIDEO_FILE_FOLDER . "\n";
            
            exit();
            */
            
            $vFILE = "";
            if( ( trim($video_type) == "VIDEO_FILE" ) && ( trim($video_file_path) != "" ) )
            {
                
                
                if( trim($old_video) != "" ) 
                {
                    unlink($VIDEO_FILE_FOLDER . $old_video);
                    unlink($VIDEO_FILE_FOLDER . str_replace(".mp4","", $old_video).".jpg");
                }
                
                
                $vTITLE = filterString($projects_title);
                $f_ext = pathinfo($video_file_path);
                
                $vFILE =  strtolower($vTITLE) . "-" . $id ."." . $f_ext['extension'];
                rename($VIDEO_TEMP_FOLDER.$video_file_path, $VIDEO_FILE_FOLDER.$vFILE);
                
                
                //echo "@@@$VIDEO_FILE_FOLDER\n";
                //echo "@@@$vFILE\n";
                //exit();
                
                
            }else{
                
                $vFILE = "";
                
                if( trim($video_type) == "VIDEO_EMBED" && trim($old_video) != "" ) 
                {
                    unlink($VIDEO_FILE_FOLDER . $old_video);
                    unlink($VIDEO_FILE_FOLDER . str_replace(".mp4","", $old_video).".jpg");
                }
                
            }
            
            $ftFILE = "";
            if( ( trim($ftype_file_path) != "" ) )
            {
                
                
                if( trim($old_ftype_file) != "" ) 
                {
                    unlink($FTYPE_FILE_FOLDER . $old_ftype_file); 
                }
                
                
                 
                $ft_ext = pathinfo($ftype_file_path);
                
                $ftFILE =  strtolower(filterString($projects_title)) . "-" . $id ."." . $ft_ext['extension'];
                rename($FTYPE_TEMP_FOLDER.$ftype_file_path, $FTYPE_FILE_FOLDER.$ftFILE);
                
                
                //echo "@@@$FTYPE_FILE_FOLDER\n";
                //echo "@@@$ftFILE\n";
                //exit();
                
                
            }else{
                
                $ftFILE = "";
                
                //if( trim($old_ftype_file) != "" ) 
                //{
                    //unlink($FTYPE_FILE_FOLDER . $old_ftype_file); 
                //}else{
                    $ftFILE =   $old_ftype_file;  
                //}
                
            }
             
            //for homepage image
            if(intval($image_id) == intval(0))
            {
                if($image != "")
                {
                    $title_filter = filterString($projects_title);
                    $i_ext = pathinfo($image);
                    
                    $imgpath_name =  $title_filter . "." . $i_ext['extension'];
                    rename($TEMP_FOLDER_NAME.$image, $FOLDER_NAME.$imgpath_name);
                    resizeIMG("PROJECTS_HOMEPAGE_IMAGE",trim($imgpath_name),$id,$FOLDER_NAME);
                    
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
             
            $SQL  = "";
            $SQL .= " UPDATE " . PROJECTS_TBL . " SET ";            
            $SQL .= " projects_title = :projects_title, ";
           // $SQL .= " projects_from_date = :projects_from_date, ";
           // $SQL .= " projects_to_date = :projects_to_date, ";         
            $SQL .= " projects_description = :projects_description, ";
            $SQL .= " file_name = :file_name, ";   
            $SQL .= " homepage_image = :image_name, ";
            $SQL .= " homepage_image_id = :image_id, ";
            
            //$SQL .= " url = :url, ";
            $SQL .= " status = :status, ";
            $SQL .= " update_ip = :update_ip, ";
            $SQL .= " update_time = :update_time, "; 
            $SQL .= " update_by = :update_by, "; 
            $SQL .= " url_key = :url_key, "; 
            $SQL .= " meta_title = :meta_title, "; 
            $SQL .= " meta_keyword = :meta_keyword, ";
            $SQL .= " meta_description = :meta_description "; 
            $SQL .= " WHERE projects_id = :projects_id ";
             
            $sUPD = $dCON->prepare($SQL);
            
            $sUPD->bindParam(":projects_title", $projects_title);   
                     
           // $sUPD->bindParam(":projects_from_date", $projects_from_date);
           // $sUPD->bindParam(":projects_to_date", $projects_to_date);
            $sUPD->bindParam(":projects_description", $projects_description);
            
                        
            $sUPD->bindParam(":file_name", $ftFILE);
               
            $sUPD->bindParam(":image_name", $imgpath_name); 
            $sUPD->bindParam(":image_id", $image_id);
            
           // $sUPD->bindParam(":url", $url);
            
            $sUPD->bindParam(":status", $status);
            $sUPD->bindParam(":update_ip", $IP);
            $sUPD->bindParam(":update_time", $TIME); 
            $sUPD->bindParam(":update_by", $_SESSION['USERNAME']);
            $sUPD->bindParam(":url_key", $MY_URLKEY);
            $sUPD->bindParam(":meta_title", $meta_title);
            $sUPD->bindParam(":meta_keyword", $meta_keyword);
            $sUPD->bindParam(":meta_description", $meta_description);
            $sUPD->bindParam(":projects_id", $id); 
            
            $RES = $sUPD->execute();  
            $sUPD->closeCursor(); 
            if( intval($RES) == intval(1) )
            {
                    
                $RTNID = $id;
                
                if ( SET1_ENABLE == true ){ 
                        
                    /////////////---------------Saved Gallery============================
                    $TITLE = $projects_title;
                    include("include_SET1_SAVE4EDIT.php");  
                 
                
                }
          
                            
               
            }
                
        }
        else
        {
            $RES = 2;
        }
    }
    
    switch($RES)
    {
        case "1":
            echo "~~~1~~~Successfully saved~~~$RTNID~~~";
        break;
        case "2":
            echo "~~~2~~~Already exists~~~";
        break; 
        default:
            echo "~~~0~~~Error occured, Try again~~~";
        break;
    }  
}

function listData()
{
    global $dCON;
    global $pg;    
       
    $projects_title = trustme($_REQUEST['search_name']);    
    $search_fdate = trustme($_REQUEST['search_fdate']);
    $search_tdate = trustme($_REQUEST['search_tdate']);
        
    
    $search = "";   
    
    if($projects_title != ""){
        $search .= " and projects_title like :projects_title ";
    }
     
    
    if(trim($search_fdate) != "" && trim($search_tdate) != "" )
    {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];
        
        $search_tdate_arr = explode("-", $search_tdate);
        $search_tdate = $search_tdate_arr[2] . "-" . $search_tdate_arr[1] . "-" . $search_tdate_arr[0];
         
        $search .= " AND DATE(E.add_time) BETWEEN :from_date AND :to_date ";
    }
    else if(trim($search_fdate) != "")
    {
        $search_fdate_arr = explode("-", $search_fdate);
        $search_fdate = $search_fdate_arr[2] . "-" . $search_fdate_arr[1] . "-" . $search_fdate_arr[0];
        
        $search .= " AND DATE(E.add_time) = :from_date ";
    }
    
    
    
    
    $SQL_PG = " SELECT COUNT(*) AS CT FROM " . PROJECTS_TBL . " as E WHERE status <> 'DELETE' $search ";
   
    $SQL = "";
    $SQL .= " SELECT * "; 
    $SQL .= " ,(SELECT AI.image_name FROM ".PROJECTS_LOGO_IMAGES_TBL." as AI WHERE AI.master_id = E.projects_id ORDER BY AI.default_image desc, AI.image_id ASC LIMIT 0,1 ) as image_name ";
    $SQL .= " FROM " . PROJECTS_TBL . " as E WHERE E.status <> 'DELETE' $search ORDER BY E.position ASC ";     
    //echo $SQL;
    
    $stmt1 = $dCON->prepare($SQL_PG);
    
    
    if( trim($projects_title) != ""){
        $stmt1->bindParam(":projects_title", $nam);
        $nam = "%{$projects_title}%";
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
    
    
    
    
    if( trim($projects_title) != ""){
        $stmt2->bindParam(":projects_title", $nam);
        $nam = "%{$projects_title}%";
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
    
    $position_qry_string = "";
    $position_qry_string .= "con=".PROJECTS_TBL;
    $position_qry_string .= "&cname1=projects_title&cname2=projects_id";            
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
                            <th width="10%" align="center">Status</th>                     
                            <th width="45%" align="left">Name</th>
                           
                                                   
                            <th width="15%" align="center">Homepage Image</th>
                            <th width="10%" align="center">Position</th>                      
                            <th align="center" width="15%">Action</th>
                                                 
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
                                        $projects_id = "";                                        
                                        $projects_title = ""; 
                                        $governor_post = "";
                                        $governor_profession = "";
                                        $publish_date = ""; 
                                        $status = ""; 
                                        
                                        
                                        $projects_id = intval($rs['projects_id']);
                                        $projects_title = stripslashes($rs['projects_title']);
                                
                                        $status = stripslashes($rs['status']);
                                        $STATUSnowaction = stripslashes($status) == 'ACTIVE' ? "INACTIVE" : "ACTIVE";    
                                                   
                                        $image_name = trim(stripslashes($rs['homepage_image']));
                                
                                        $DISPLAY_IMG = "";
                                        $R200_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS."/" . FLD_HOMEPAGE_IMAGE. "/R50-" . $image_name);
                                        //$MAIN_IMG_EXIST = chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_BOARD_GOVERNORS . "/" . $image_name);
                                        
                                        if( intval($R200_IMG_EXIST) == intval(1) )
                                        {
                                            $DISPLAY_IMG = CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PROJECTS."/" . FLD_HOMEPAGE_IMAGE . "/R50-" . $image_name;
                                        }
                                        ?>     
                                        
                                        <li id="listItem_<?php echo $projects_id; ?>">  
                                            
                                            <table cellpadding="0" cellspacing="0" width="100%" border="0">
                                                <tr class="expiredCoupons trhover" >
                                        
                                                    <td align="center" width="5%"> 
                                                        <input type="checkbox" class="cb-element" name="chk[]" value="<?php echo $projects_id; ?>" />
                                                    </td>
                                                    
                                                    <td align="center" width="10%">
                                                       <div id="INPROCESS_STATUS_1_<?php echo $projects_id; ?>" style="display: none;"></div>
                                                        <div id="INPROCESS_STATUS_2_<?php echo $projects_id; ?>"  >
                                                            <a href="javascript:void(0);" value="<?php  echo $projects_id; ?>" myvalue="<?php echo $STATUSnowaction; ?>" class="setStatus">
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
                                                    <td width="45%">
                                                    	<h3 class="couponType">
                                                            <?php echo $projects_title; ?>                                                            
                                                       </h3>
                                                    </td>
                                                                                
                                                    
                                                    <td align='left' width="15%">
                                                        <?php
                                                        if($DISPLAY_IMG !='')
                                                        {
                                                        ?>
                                                            <img src="<?php echo $DISPLAY_IMG; ?>" alt="" width="30" height="30"/>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    
                                                    <td align="left" width="10%">
                                                        <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" alt="Move" width="16" height="16" class="handle" style="cursor: move;" />
                                                    </td>
                                                    
                                                                                                                               
                                                    <td align="left" width="15%">
                                                       <div id="INPROCESS_DELETE_1_<?php echo $projects_id; ?>" style="display: none;"></div>
                                                       
                                                       <div id="INPROCESS_DELETE_2_<?php echo $projects_id; ?>">
                                                            <a href="<?php echo PAGE_MAIN; ?>?ID=<?php echo $projects_id; ?>" class="modifyData img_btn">
                                                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>edit_icon.png" border="0" title="Modify" alt="Modify"/>
                                                            </a>  
                                                            <?php
                                                            if( intval($CHK) == intval(0) )
                                                            {
                                                            ?>
                                                                <a href="javascript:void(0);" value="<?php  echo $projects_id; ?>" class="deleteData img_btn">
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
        
        $stmt = $dCON->prepare("Update " . PROJECTS_TBL . "  set status='DELETE' WHERE projects_id = ?");
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
    $stmt = $dCON->prepare("Update " . PROJECTS_TBL . "  set status='DELETE'  WHERE projects_id = ?");
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
    $STR .= " UPDATE  " . PROJECTS_TBL . "  SET "; 
    $STR .= " status = :status, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE projects_id = :projects_id ";
    $sDEF = $dCON->prepare($STR); 
    $sDEF->bindParam(":status", $VAL); 
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $TIME);
    $sDEF->bindParam(":projects_id", $ID);
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

function setHomePage()
{
    global $dCON;     
    $TIME = date("Y-m-d H:i:s");
    
    $ID = intval($_REQUEST['ID']);
    $VAL = trustme($_REQUEST['VAL']);                           
    $update_time = date("Y-m-d H:i:s");
    $IP = trustme($_SERVER['REMOTE_ADDR']);

    $STR  = "";
    $STR .= " UPDATE  " . PROJECTS_TBL . "  SET ";
    $STR .= " home_page = :home_page, ";
    $STR .= " update_by = :update_by, ";
    $STR .= " update_ip = :update_ip, ";
    $STR .= " update_time = :update_time ";
    $STR .= " WHERE projects_id = :projects_id ";
    $sDEF = $dCON->prepare($STR);
    
    $sDEF->bindParam(":home_page", $VAL);
    $sDEF->bindParam(":update_ip", $IP);
    $sDEF->bindParam(":update_by", $_SESSION['USERNAME']);
    $sDEF->bindParam(":update_time", $update_time);
    $sDEF->bindParam(":projects_id", $ID);
    $RES = $sDEF->execute();
    $sDEF->closeCursor();         
          
    if ( intval($RES) == intval(1) )
    {     
        //$str_no = " UPDATE ". PROJECTS_TBL ." SET home_page = '0' WHERE projects_id !=". $ID ;
        //$sDEF_NO = $dCON->prepare($str_no); 
        //$sDEF_NO->execute();
        
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
        //$SQL .= " SELECT COUNT(*) AS CT FROM " . PRODUCT_TBL . " WHERE section_id = ? AND status <> 'DELETE' ";
        //$SQL .= " UNION ";
        //$SQL .= " SELECT COUNT(*) AS CT FROM " . RATE_ADDITIONAL_AIRPORT_FROM_UK_TBL . " WHERE location_id = ? AND status <> 'DELETE' ";
     $SQL .= " ) AS aa ";
    //echo $SQL . $ID;    
      
    $sCHK = $dCON->prepare( $SQL );
    $sCHK->bindParam(1, $ID);
    //$sCHK->bindParam(2, $ID);
    //$sCHK->bindParam(3, $ID); 
    
    $sCHK->execute();
    $rsCHK = $sCHK->fetchAll();
    $sCHK->closeCursor();
    //$CT = intval($rsCHK[0][0]);
    //echo $ID . "==" .  $CT;
    
    return $CT;

    
}
        

?>