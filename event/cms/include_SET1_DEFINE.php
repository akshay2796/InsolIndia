<?php

if ( SET1_ENABLE == true ){
    
    define("SET1_TYPE","FILE");
    if ( SET1_TYPE == "FILE" ){ 
        define("SET1_IMAGE_MULTIPLE",true); 
        define("SET1_IMAGE_CROPPING",false);    
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['DOCUMENT_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS",$_SESSION['DOCUMENT_ALLOWED_FORMATS']);
        
        define("SET1_MINIMUM_RESOLUTION","");    
        
    }else if ( SET1_TYPE == "IMAGE" ){
        define("SET1_IMAGE_MULTIPLE",false); 
        define("SET1_IMAGE_CROPPING",false);
        
        define("SET1_UPLOAD_FILE_SIZE",$_SESSION['DOCUMENT_UPLOAD_FILE_SIZE']);
        define("SET1_UPLOAD_ALLOWED_FORMATS","jpg,jpeg,pjpeg,gif,png");
        
        define("SET1_MINIMUM_RESOLUTION","Min. size required 245px x 160px");
    
    }    
    
    define("SET1_FOR",$_SESSION["DOCUMENTBANK"]);
    define("SET1_MANDATORY",false);
    
    define("SET1_FOLDER",FLD_DOCUMENTBANK);
    define("SET1_FOLDER_PATH",CMS_UPLOAD_FOLDER_RELATIVE_PATH . SET1_FOLDER);
    
    define("SET1_DBTABLE",DOCUMENTBANK_FILE_TBL);
    
     
    
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

?>