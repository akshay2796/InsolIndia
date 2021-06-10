<?php

error_reporting(E_ALL);
include("ajax_include.php");  


$type =  trustme($_REQUEST['type']);
switch($type)
{
    case "suggestEvents":
        suggestEvents();
        break;
    case "suggestNews":
        suggestNews();
        break;
    case "suggestResources":
        suggestResources();
        break;     
        
    case "suggestAutoLoad":
        suggestAutoLoad();
        break;
    
}


function suggestEvents()
{
    global $dCON; 
     
    $search = trustme($_REQUEST['term']);
    
    $event_id_ar = trustme($_REQUEST['event_id_ar']);
    
  
     
    $SQL  = "";
    $SQL .= " SELECT DISTINCT(event_name),event_id,event_from_date,event_to_date FROM ".EVENT_TBL."  WHERE event_name != '' and event_from_date >= CURDATE() ";
    if($search !="ALLDATA")
    {
        $SQL .= " and event_name LIKE :event_name   ";
    }
    
    if(trim($event_id_ar) != "")
    {
        $SQL .= " and event_id not in (".$event_id_ar.") ";
    }
    
    $SQL .= " ORDER BY event_from_date,event_name limit 40 ";
    
    $stmt = $dCON->prepare($SQL); 
    if($search !="")
    {
        $stmt->bindParam(":event_name", $typename);
        $typename = "{$search}%";
    }
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
     
    foreach($row_stmt as $rs_stmt)
    {
        $event_id = 0;
        $event_id = intval($rs_stmt['event_id']);
        
        $event_name ="";
        $event_name = ucwords(strtolower(stripslashes($rs_stmt['event_name'])));
        
        $event_from_date ="";
        $event_from_date = ($rs_stmt['event_from_date']);
        
        $event_from_date = date("d-m-Y", strtotime($event_from_date));
        
        $array = array();
        $array['label'] = htmlentities($event_name)." : ".$event_from_date." "; 
        $array['value'] = htmlentities($event_name); 
        $array['event_id'] = intval($event_id); 
         
        $main_array[] = $array;
    }
    if(intval(count($main_array)) > intval(0))
    {
        //$main_array = apply_highlight($main_array, $parts);
        echo jsencode($main_array);     
    }
    else
    {
        echo "";
    }
}   




function suggestNews()
{
    global $dCON; 
     
    $search = trustme($_REQUEST['term']);
    
    $news_id_ar = trustme($_REQUEST['news_id_ar']);
     
    $SQL  = "";
    $SQL .= " SELECT DISTINCT(news_title),news_id,news_date FROM ".NEWS_TBL."  WHERE news_title != '' ";
    if($search !="ALLDATA")
    {
        $SQL .= " and news_title LIKE :news_title   ";
    }
    
    if(trim($news_id_ar) != "")
    {
        $SQL .= " and news_id not in (".$news_id_ar.") ";
    }
    
    $SQL .= " ORDER BY news_id desc limit 40 ";
    
    $stmt = $dCON->prepare($SQL); 
    if($search !="")
    {
        $stmt->bindParam(":news_title", $typename);
        $typename = "{$search}%";
    }
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
     
    foreach($row_stmt as $rs_stmt)
    {
        $news_id = 0;
        $news_id = intval($rs_stmt['news_id']);
        
        $news_title ="";
        $news_title = ucwords(strtolower(stripslashes($rs_stmt['news_title'])));
        
        $news_date ="";
        $news_date = ($rs_stmt['news_date']);
        $news_date = date("d-m-Y", strtotime($news_date));
        
        $array = array();
        $array['label'] = htmlentities($news_title)." : ".$news_date." "; 
        $array['value'] = htmlentities($news_title); 
        $array['news_id'] = intval($news_id); 
         
        $main_array[] = $array;
    }
    if(intval(count($main_array)) > intval(0))
    {
         echo jsencode($main_array);     
    }
    else
    {
        echo "";
    }
} 



function suggestResources()
{
    global $dCON; 
     
    $search = trustme($_REQUEST['term']);
    
    $resources_id_ar = trustme($_REQUEST['resources_id_ar']);
     
    $SQL  = "";
    $SQL .= " SELECT DISTINCT(resources_name),resources_id, resources_from_date FROM ".RESOURCES_TBL."  WHERE resources_name != '' ";
    $SQL .= " and (category_id = 1003 or category_id = (select category_id from ".RESOURCES_CATEGORY_TBL." as C where category_name = 'Articles' and status='ACTIVE' limit 1))  ";
    
    if($search !="ALLDATA")
    {
        $SQL .= " and resources_name LIKE :resources_name   ";
    }
    
    if(trim($resources_id_ar) != "")
    {
        $SQL .= " and resources_id not in (".$resources_id_ar.") ";
    }
    
    $SQL .= " ORDER BY resources_id desc limit 40 ";
    
    $stmt = $dCON->prepare($SQL); 
    if($search !="")
    {
        $stmt->bindParam(":resources_name", $typename);
        $typename = "{$search}%";
    }
    $stmt->execute();
    $row_stmt = $stmt->fetchAll();
    $stmt->closeCursor();
     
    foreach($row_stmt as $rs_stmt)
    {
        $resources_id = 0;
        $resources_id = intval($rs_stmt['resources_id']);
        
        $resources_name ="";
        $resources_name = ucwords(strtolower(stripslashes($rs_stmt['resources_name'])));
        
        $resources_from_date ="";
        $resources_from_date = ($rs_stmt['resources_from_date']);
        $resources_from_date = date("d-m-Y", strtotime($resources_from_date));
        
        $array = array();
        $array['label'] = htmlentities($resources_name)." "; 
        $array['value'] = htmlentities($resources_name); 
        $array['resources_id'] = intval($resources_id); 
         
        $main_array[] = $array;
    }
    if(intval(count($main_array)) > intval(0))
    {
         echo jsencode($main_array);     
    }
    else
    {
        echo "";
    }
}



function suggestAutoLoad()
{
    global $dCON; 
     
    $WCH = trustme($_REQUEST['WCH']);
    $search = trustme($_REQUEST['term']);
    //$parts = explode(' ', $search);
    //$p = count($parts);
    if ( trim($WCH) == "MediaPublisher"){
        $SQL  = "";
        $SQL .= " SELECT DISTINCT(media_publisher) as val FROM ". MEDIA_TBL . "  WHERE status != 'DELETE' AND media_publisher != '' ";
        $SQL .= " and media_publisher LIKE :search_val   ";
        $SQL .= " ORDER BY media_publisher ";
            
    }elseif ( trim($WCH) == "BlogAuthor"){
        
        $SQL  = "";
        $SQL .= " SELECT DISTINCT(blog_author) as val FROM ". BLOG_TBL . "  WHERE status != 'DELETE' AND blog_author != '' ";
        $SQL .= " and blog_author LIKE :search_val   ";
        $SQL .= " ORDER BY blog_author ";
            
    }elseif ( trim($WCH) == "PastPublisher"){
        
        $SQL  = "";
        $SQL .= " SELECT DISTINCT(pastpub_publisher) as val FROM ". PASTPUB_TBL . "  WHERE status != 'DELETE' AND pastpub_publisher != '' ";
        $SQL .= " and pastpub_publisher LIKE :search_val   ";
        $SQL .= " ORDER BY pastpub_publisher ";
            
    }
    
     
    
    $sGET = $dCON->prepare($SQL); 
    $sGET->bindParam(":search_val", $name);
    $name = "{$search}%";
    
    $sGET->execute();
    $rsGET = $sGET->fetchAll();
    $sGET->closeCursor();
     
    foreach($rsGET as $rGET)
    {
        $NAME ="";
        $NAME = stripslashes($rGET['val']);
        $array = array();
        $array['label'] = $NAME; 
        $array['value'] = $NAME; 
         
        $main_array[] = $array;
    }
    if(intval(count($main_array)) > intval(0))
    {
        //$main_array = apply_highlight($main_array, $parts);
        echo jsencode($main_array);     
    }
    else
    {
        echo "";
    }
    
}







?>