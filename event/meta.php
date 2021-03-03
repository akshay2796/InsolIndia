<?php
$url_key_meta = trustme($_REQUEST['url_key']);
$master_url_key_meta= trustme($_REQUEST['master_url_key']);
$type_meta = (trustme($_REQUEST['type']));
$sword_meta= (trustme($_REQUEST['sword']));

//echo "===$PAGENAME===<BR>";
   
//exit();


$METATITLE = "";
$METAKEYWORD = "";
$METADESCRIPTION = "";

if( (trim($PAGENAME) == "" ) || ( trim($PAGENAME) == 'index.php' ) ){
    
    $METATITLE = $_SESSION['DEFAULT_META_TITLE'];
    $METAKEYWORD = $_SESSION['DEFAULT_META_KEYWORD'];
    $METADESCRIPTION = $_SESSION['DEFAULT_META_DESCRIPTION'];
    
}elseif( trim($PAGENAME) == "about.php" ){ 
     
    $rsMETA = getDetails(ABOUT_TBL, '*', "status","ACTIVE",'=', '', '' , ""); 
     
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "contact.php" ){ 
     
    $rsMETA = getDetails(CONTACT_TBL, '*', "status","ACTIVE",'=', '', '' , ""); 
     
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "mission.php" ){ 
        
        $METATITLE = 'MISSION';
        $METAKEYWORD = 'MISSION';
        $METADESCRIPTION = 'MISSION';

}elseif( trim($PAGENAME) == "draft_best_practices.php" ){ 
        
        $METATITLE = 'Draft Best Practices';
        $METAKEYWORD = 'Draft Best Practices';
        $METADESCRIPTION = 'Draft Best Practices';

}elseif( trim($PAGENAME) == "vision-statement.php" ){ 
        
        $METATITLE = 'Vision Statement';
        $METAKEYWORD = 'Vision Statement';
        $METADESCRIPTION = 'Vision Statement';

}elseif( trim($PAGENAME) == "history.php" ){ 
        
        $METATITLE = 'HISTORY';
        $METAKEYWORD = 'HISTORY';
        $METADESCRIPTION = 'HISTORY';

}elseif( trim($PAGENAME) == "legal-status.php" ){ 
        
        $METATITLE = 'Legal Status';
        $METAKEYWORD = 'Legal Status';
        $METADESCRIPTION = 'Legal Status';
        
}elseif( trim($PAGENAME) == "executive-committee.php" ){ 
        
        $METATITLE = 'Executive Committee';
        $METAKEYWORD = 'Executive Committee';
        $METADESCRIPTION = 'Executive Committee';
        
}elseif( trim($PAGENAME) == "executive_committee_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(EXECUTIVE_COMMITTEE_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "board_governor.php" ){ 
        
        $METATITLE = 'Board of Governors';
        $METAKEYWORD = 'Board of Governors';
        $METADESCRIPTION = 'Board of Governors';
        
}elseif( trim($PAGENAME) == "board_governor_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(BOARD_GOVERNORS_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "judges_advisory_roundtable.php" ){ 
        
        $METATITLE = 'Judges Advisory Roundtable';
        $METAKEYWORD = 'Judges Advisory Roundtable';
        $METADESCRIPTION = 'Judges Advisory Roundtable';
        
}elseif( trim($PAGENAME) == "judges_advisory_roundtable_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(JUDGES_ADVISORY_ROUNDTABLE_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "academic_committees.php" ){ 
        
        $METATITLE = 'Academic Committees';
        $METAKEYWORD = 'Academic Committees';
        $METADESCRIPTION = 'Academic Committees';
        
}elseif( trim($PAGENAME) == "academic_committees_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 


    $rsMETA = getDetails(COMMITTEES_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "young-members-committee.php" ){ 
        
        $METATITLE = "Young Practitioner's Committee";
        $METAKEYWORD = "Young Practitioner's Committee";
        $METADESCRIPTION = "Young Practitioner's Committee";
        
}elseif( trim($PAGENAME) == "young_members_committee_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 


    $rsMETA = getDetails(YOUNG_MEMBER_COMMITTEE_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "nlu-delhi-insol-india-international-moot-competition-on-insolvency.php" ){ 
        
        $METATITLE = 'NLU Delhi Insol India International Moot Competition On Insolvency';
        $METAKEYWORD = 'NLU Delhi Insol India International Moot Competition On Insolvency';
        $METADESCRIPTION = 'NLU Delhi Insol India International Moot Competition On Insolvency';
        
}elseif( trim($PAGENAME) == "voluntary-best-practices.php" ){ 
        
        $METATITLE = 'Voluntary Best Practices';
        $METAKEYWORD = 'Voluntary Best Practices';
        $METADESCRIPTION = 'Voluntary Best Practices';
        
}elseif( trim($PAGENAME) == "designing-insolvency-courses-for-law-schools.php" ){ 
        
        $METATITLE = 'Designing Insolvency Courses For Law Schools';
        $METAKEYWORD = 'Designing Insolvency Courses For Law Schools';
        $METADESCRIPTION = 'Designing Insolvency Courses For Law Schools';
        
}elseif( trim($PAGENAME) == "sipi.php" ){ 
        
        $METATITLE = 'SIPI';
        $METAKEYWORD = 'SIPI';
        $METADESCRIPTION = 'SIPI';
        
}elseif( trim($PAGENAME) == "members.php" ){ 
        
        $METATITLE = 'MEMBERS';
        $METAKEYWORD = 'MEMBERS';
        $METADESCRIPTION = 'MEMBERS';
        
}elseif( trim($PAGENAME) == "resources.php" ){ 
        
        $METATITLE = 'RESOURCES';
        $METAKEYWORD = 'RESOURCES';
        $METADESCRIPTION = 'RESOURCES';
        
}elseif( trim($PAGENAME) == "resource-detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(RESOURCES_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "news.php" ){ 
        
        $METATITLE = 'NEWS';
        $METAKEYWORD = 'NEWS';
        $METADESCRIPTION = 'NEWS';
        
}elseif( trim($PAGENAME) == "news-details.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(NEWS_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "events.php" ){ 
        
        $METATITLE = 'EVENTS';
        $METAKEYWORD = 'EVENTS';
        $METADESCRIPTION = 'EVENTS';
        
}elseif( trim($PAGENAME) == "event-detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(EVENT_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "gallery.php" ){ 
        
        $METATITLE = 'GALLERY';
        $METAKEYWORD = 'GALLERY';
        $METADESCRIPTION = 'GALLERY';
        
}elseif( trim($PAGENAME) == "gallery-detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(GALLERY_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "media.php" ){ 
        
        $METATITLE = 'MEDIA';
        $METAKEYWORD = 'MEDIA';
        $METADESCRIPTION = 'MEDIA';
        
}elseif( trim($PAGENAME) == "media-detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(MEDIA_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}elseif( trim($PAGENAME) == "sig24.php" ){ 
        
        $METATITLE = 'SIG 24';
        $METAKEYWORD = 'SIG 24';
        $METADESCRIPTION = 'SIG 24';
        
}elseif( trim($PAGENAME) == "sig24_detail.php" ){ 
    
    $metaKEY = htmlentities(stripslashes($_REQUEST["url_key"])); 
    $rsMETA = getDetails(SIG24_TBL, '*', "status~~~url_key","ACTIVE~~~$metaKEY",'=~~~=', '', '' , ""); 
    
    if ( intval(count($rsMETA)) > intval(0) ){ 
        
        $METATITLE = htmlentities(stripslashes($rsMETA[0]['meta_title']));
        $METAKEYWORD = htmlentities(stripslashes($rsMETA[0]['meta_keyword']));
        $METADESCRIPTION = htmlentities(stripslashes($rsMETA[0]['meta_description']));
    } 
    
}



if ( trim($METATITLE) == "" ){ $METATITLE = $_SESSION['DEFAULT_META_TITLE']; }
if ( trim($METAKEYWORD) == "" ){ $METAKEYWORD = $_SESSION['DEFAULT_META_KEYWORD']; }
if ( trim($METADESCRIPTION) == "" ){ $METADESCRIPTION = $_SESSION['DEFAULT_META_DESCRIPTION']; }

 


?>