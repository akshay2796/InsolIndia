<?php  



function MailObject($TO=array(), $FROM="", $CC=array(), $BCC=array(), $SUBJECT="", $BODY="", $ATTACHMENTS = array(),$REPLYTO="",$ics=array())

{

    

    $mail = new phpmailer; 



    if ( $_SERVER["HTTP_HOST"] == "idsweb" )

    {       

        $mail->IsSMTP();  // telling the class to use SMTP<br>

       	$mail->Host     = $_SESSION['SMTP']; // SMTP server

      	$mail->Username = $_SESSION['AUTH_EMAIL_USERNAME'];

        $mail->Password = $_SESSION['AUTH_EMAIL_PASSWORD'];
    

        $mail->Port = 25;

    	$mail->SMTPAuth=true;  

        $mail->SMTPDebug = true;

    }

    elseif ( $_SERVER["HTTP_HOST"] == "localhost" )

    {       

        $mail->IsSMTP();  // telling the class to use SMTP<br>

       	$mail->Host     = $_SESSION['SMTP']; // SMTP server

      	$mail->Username = $_SESSION['AUTH_EMAIL_USERNAME'];

        $mail->Password = $_SESSION['AUTH_EMAIL_PASSWORD'];

        $mail->Port = 25;

    	$mail->SMTPAuth=true;           

    }

    elseif ( trim($_SERVER['HTTP_HOST']) == "192.168.1.111" )

    {

        $mail->IsSMTP();  // telling the class to use SMTP<br>

       	$mail->Host     = $_SESSION['SMTP']; // SMTP server

      	$mail->Username = $_SESSION['AUTH_EMAIL_USERNAME'];

        $mail->Password = $_SESSION['AUTH_EMAIL_PASSWORD'];

        $mail->Port = 25;

    	$mail->SMTPAuth=true;           

    } 

    else

    {
        $mail->IsSMTP();  // telling the class to use SMTP    

        //$mail->SMTPSecure = "ssl";

        $mail->Host     = $_SESSION['SMTP']; // SMTP server

        $mail->Username = $_SESSION['AUTH_EMAIL_USERNAME'];

        $mail->Password = $_SESSION['AUTH_EMAIL_PASSWORD'];

        $mail->Port = 25;

        $mail->SMTPAuth = true;

        //$mail->SMTPDebug  = true;  

        

    }

    

    if ( trim($FROM) != "" )

    {

        $mail->From = $FROM;

    }

    else

    {

        $mail->From = $_SESSION['INFO_EMAIL'];    

    }

    

    $mail->FromName = $_SESSION["COMPANY_NAME"];

    

    if($REPLYTO !='')

    {

        $mail->AddReplyTo($REPLYTO); 

    }

    

    $mail->ContentType = "text/html";

    $mail->Subject  = $SUBJECT;

    

    if(trim($TO)!="")

    {

        

        $to_array = explode(",", $TO);

        foreach($to_array as $eml)

        {

            $eml = trim($eml);

            $mail->AddAddress($eml);

        }       

        

    }

    

    if(trim($CC)!="")

    {

        $cc_array = explode(",", $CC);

        foreach($cc_array as $eml)

        {

            $eml = trim($eml);

            $mail->AddCC('contact@insolindia.com');

        }      

        

    }

    

    

    if(trim($BCC)!="")

    {

        $bcc_array = explode(",", $BCC);

        foreach($bcc_array as $eml)

        {

            $eml = trim($eml);

            $mail->AddBCC($eml);

        }   

        

    } 

    

    $mail->Body = $BODY;
    if($ics !="no_ics"){
        $yeard = $ics['year'];
$monthd = $ics['month'];
$dated = $ics['day'];
$yeard2 = $ics['year2'];
$monthd2 = $ics['month2'];
$dated2 = $ics['day2'];
$hourd = $ics['hourd'];
$mind = $ics['mind'];
$secd = $ics['secd'];

$hourd2 = $ics['hourd2'];
$mind2 = $ics['mind2'];
$secd2 = $ics['secd2'];
$ftime = $ics['ftime'];

$location = $ics['eventVenue'];
$about_event = $ics['eventName'];
        $ical_content = 'BEGIN:VCALENDAR
PRODID:-//Microsoft Corporation//Outlook 16.0 MIMEDIR//EN
VERSION:2.0
METHOD:PUBLISH
X-MS-OLK-FORCEINSPECTOROPEN:TRUE
BEGIN:VTIMEZONE
TZID:Asia/Kolkata
BEGIN:STANDARD
TZNAME:IST

END:STANDARD
END:VTIMEZONE
BEGIN:VEVENT
CLASS:PUBLIC
CREATED:20191203T124654Z
DESCRIPTION:'.$about_event.'
AGENDA:'.$ftime.'
DTSTART;TZID=Asia/Kolkata:'.$yeard.''.$monthd.''.$dated.'T'.$hourd.''.$mind.''.$secd.'
DTEND;TZID=Asia/Kolkata:'.$yeard2.''.$monthd2.''.$dated2.'T'.$hourd2.''.$mind2.''.$secd2.'

LAST-MODIFIED:20191203T124654Z

LOCATION:'.$location.'

PRIORITY:5
SEQUENCE:0

SUMMARY;LANGUAGE=es:'.$about_event.'
ORGANIZER;CN=Insol India:MAILTO:test@test.com
TRANSP:OPAQUE
UID:'. md5(uniqid(mt_rand(), true)) .'
X-ALT-DESC;FMTTYPE=text/html:<html xmlns:v="urn:schemas-microsoft-com:vml" 
    xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:w="urn:schemas-mic
    rosoft-com:office:word" xmlns:m="http://schemas.microsoft.com/office/2004/





X-MICROSOFT-CDO-BUSYSTATUS:FREE
X-MICROSOFT-CDO-IMPORTANCE:1
X-MICROSOFT-DISALLOW-COUNTER:FALSE
X-MS-OLK-AUTOFILLLOCATION:FALSE
X-MS-OLK-CONFTYPE:0
BEGIN:VALARM
TRIGGER:-PT15M
ACTION:DISPLAY
DESCRIPTION:Reminderdfs
END:VALARM
END:VEVENT
END:VCALENDAR';

$mail->addStringAttachment($ical_content,'ical.ics','base64','text/calendar');
    }
    

       

    if(trim($ATTACHMENTS)!="")

    {

        $ATT_array = explode(",", $ATTACHMENTS);

        foreach($ATT_array as $aCHUNK)

        {

            $aCHUNK = trim($aCHUNK);

            $mail->AddAttachment($aCHUNK);

        }   

        

    }

    

    if($mail->send())

    {

        $success = 1;

    }

    else

    {

        $success = 0;

        //$mail->ErrorInfo

        

    }

     

    $mail->ClearAddresses();

    return $success;

} 









function checkBanWords($string)

{ 

    global $dCON;

    

    $SQL  = "";

    $SQL .= " SELECT * FROM " . BAN_WORD_TBL . " WHERE status = 'ACTIVE' ";

    $stmt = $dCON->prepare( $SQL );

    $stmt->execute();

    $row_stmt = $stmt->fetchAll();

    $stmt->closeCursor();

    

    if(count(intval($row_stmt)) > intval(0))

    {

        $lookFor = array();

        $replaceWith = array();

        

        foreach($row_stmt as $rs_stmt)

        { 

            $needle = stripslashes($rs_stmt['ban_word_name']);

            $pos = strripos($string, $needle);

            

            if($pos === false) {

                

            } else {

                return 1;

            } 

        } 

    }

    

    return 0; 

}



function chkImageExists($image_url)

{

   if(file_exists($image_url) && is_file($image_url))

   {

        return '1';

   }

   else

   {

        return '0';

   }

                            

}







function getMaxId($tbl_name,$col_name)

{

    global $dCON;

    $SQL  = "";

    $SQL .= " SELECT IFNULL(MAX(".$col_name.") + 1, 1001) as maxid FROM ".$tbl_name." ";

    

    $stmt = $dCON->prepare( $SQL );

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    

    $MAXID = intval($row[0]['maxid']);

    

    return $MAXID;

}



 



function getMaxPosition($TBLNAME,$POSCOLNAME,$COLNAME="",$COLVALUE="",$COLOPERATOR="")

{

    global $dCON;

    

    $QRY = "";

    $QRY .= " SELECT IFNULL(MAX(". $POSCOLNAME .") + 1, 1) as maxpos FROM ". $TBLNAME . " ";

    $QRY .= " WHERE status <> 'DELETE' ";

    

    if(trim($COLNAME)!="")

    {

        

        $name_array = explode("~~~", $COLNAME);

        $op_array = explode("~~~", $COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            

            $QRY .= "AND " . $cname . " " . $copr . " ? ";

            

            $lp++;          

        }       

        

    }

    

    //return $QRY; 

    //exit();

    

    

    $stmt = $dCON->prepare($QRY);

    

    $IDX = 0;

    if(trim($COLNAME)!="")

    {

        

        $value_array = explode("~~~", $COLVALUE);

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);  

            

        }       

        

    }

    

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    $MAX_POS = (int) $row[0]['maxpos'];

    

    return $MAX_POS; 

    

      

}                    



function getMinPosition($TBLNAME,$POSCOLNAME,$COLNAME,$COLVALUE,$COLOPERATOR)

{

    global $dCON;

    

    $QRY = "";

    $QRY .= " SELECT IFNULL(MIN(". $POSCOLNAME .") + 1, 1) as maxpos FROM ". $TBLNAME . " ";

    $QRY .= " WHERE status <> 'DELETE' ";

    

    if(trim($COLNAME)!="")

    {

        

        $name_array = explode("~~~", $COLNAME);

        $op_array = explode("~~~", $COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            

            $QRY .= "AND " . $cname . " " . $copr . " ? ";

            

            $lp++;          

        }       

        

    }

    //return $QRY; 

    //exit();

    $stmt = $dCON->prepare($QRY);

    

    $IDX = 0;

    if(trim($COLNAME)!="")

    {

        

        $value_array = explode("~~~", $COLVALUE);

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);  

         }       

    }

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    $MAX_POS = (int) $row[0]['maxpos'];

    return $MAX_POS; 

}                    





function checkDuplicate($TBLNAME,$COLNAME,$COLVALUE,$COLOPERATOR,$ECHO)

{

    global $dCON;

    $SQL = "";

    $SQL .= " SELECT COUNT(*) as CT FROM " . $TBLNAME . "  WHERE status <> 'DELETE' ";

    if(trim($COLNAME)!="")

    {

        $name_array = explode("~~~", $COLNAME);

        $op_array = explode("~~~", $COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            

            $SQL .= "AND " . $cname . " " . $copr . " ? ";

            

            $lp++;          

        }                

        

    }

    

    if ( trim($ECHO) != "")

    {

        echo $SQL . "\n";  

        echo $COLNAME . "\n";    

        echo $COLVALUE . "\n";    

        echo $COLOPERATOR . "\n";    

    }

    

  

    

    $stmt = $dCON->prepare( $SQL );

    $IDX = 0;

    

      

    if(trim($COLVALUE)!="")

    {

        

        $value_array = explode("~~~", $COLVALUE);

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);  

            

        }       

        

    }

         

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    $CT = (int) $row[0]['CT'];

    

    return $CT;  

    

      

}







function chkUrlKey($TBLNAME,$URLKEYVALUE,$COLNAME,$COLVALUE,$COLOPERATOR)

{

    global $dCON;

    

    if(in_array($URLKEYVALUE, $STATIC_URL_ARRAY)) 

    { 

        return 1;

    } 

    

    $QRY = "";

    $QRY .= " SELECT COUNT(*) as CT FROM ". $TBLNAME . "  WHERE status!= 'DELETE' ";

    $QRY .= " AND url_key = ? ";

    

    

    if(trim($COLNAME)!="")

    {

        

        $name_array = explode("~~~", $COLNAME);

        $op_array = explode("~~~", $COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            

            $QRY .= "AND " . $cname . " " . $copr . " ? ";

            

            $lp++;          

        }       

        

    }

    

    //echo $QRY;

    //exit();

    

    $stmt = $dCON->prepare($QRY);

    $stmt->bindValue(1, $URLKEYVALUE);

    

    $IDX = 1;  

        

    if(trim($COLVALUE)!="")

    {        

        $value_array = explode("~~~", $COLVALUE);

         

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);          

             

        }      

        

    }

     

    

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    $CT = intval($row[0]['CT']);

    

    return $CT;    

        





}





function getURLKEY($TBLNAME,$URLKEYVALUE,$TITLE,$COLNAME,$COLVALUE,$COLOPERATOR,$ID2SAVE,$MASTERTYPE)

{

    global $dCON;

     

    if ( trim($URLKEYVALUE) != '' )

    {

        $url_key = trim($URLKEYVALUE);

        $chkURLKEY = chkUrlKey($TBLNAME,$URLKEYVALUE,$COLNAME,$COLVALUE,$COLOPERATOR);

    }

    else

    {

         $chkURLKEY = 0 ;

         $url_key = filterString($TITLE);

    }

     

    if( intval($chkURLKEY) == intval(0) )

    {

        if ( trim($url_key) == "" )             /// CASE When filter string delete all the characters of string ===

        {

            $id2s_array = explode("~~~", $ID2SAVE); 

            $ixx = 0;

            

            $GETurlkey = "";

                      

            foreach($id2s_array as $save)

            {

                //echo "->" . $ixx  . "\n";

                $chkME2save = "";

                

                switch($ixx)

                {

                    case "0": 

                        $chkME2save = $id2s_array[0];

                        break;

                    case "1":

                        $chkME2save = $id2s_array[0] . "-" . $id2s_array[1];

                        break;

                    case "2":

                        $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2];

                        break; 

                    case "3":

                        $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2]. "-" . $id2s_array[3];

                        break; 

                        

                }

                 

             

                $chkME2save = filterString($TITLE . "-" . $chkME2save);

                 

                

                $chkURLKEY = chkUrlKey($TBLNAME,$chkME2save,$COLNAME,$COLVALUE,$COLOPERATOR);

                

                if ( intval($ixx) == intval(2) )

                {

                    //echo $ixx . "==" .  $chkME2save . "==" . $chkURLKEY . "^^\n" ;

                    //exit(); 

                }

                 

                if( intval($chkURLKEY) > intval(0) )

                {

                    // Duplicate Found ===

                }

                else

                {

                     

                    // Found Unique ===

                    $GETurlkey = $chkME2save;   

                    break;

                }

                

                $ixx++;              

            } 

            

            if ( trim($GETurlkey) != "" )

            {

                $url_key = $GETurlkey;    

            }

            else

            {

                $url_key = "UNABLE TO CREATE";    

            }   

        }   

        else

        {

             

            

            $chkURLKEY = chkUrlKey($TBLNAME,$url_key,$COLNAME,$COLVALUE,$COLOPERATOR);

            

            //exit();

            

            if( intval($chkURLKEY) > intval(0) )

            {

                

                $id2s_array = explode("~~~", $ID2SAVE); 

                $ixx = 0;

                

                $GETurlkey = "";

                          

                foreach($id2s_array as $save)

                {

                    //echo "->" . $ixx  . "\n";

                    $chkME2save = "";

                    

                    switch($ixx)

                    {

                        case "0": 

                            $chkME2save = $id2s_array[0];

                            break;

                        case "1":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1];

                            break;

                        case "2":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2];

                            break; 

                        case "3":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2] . "-" . $id2s_array[3];

                            break; 

                            

                    }

                     

                 

                    $chkME2save = filterString($TITLE . "-" . $chkME2save);

                     

                    

                    $chkURLKEY = chkUrlKey($TBLNAME,$chkME2save,$COLNAME,$COLVALUE,$COLOPERATOR);

                    

                    if ( intval($ixx) == intval(2) )

                    {

                        //echo $ixx . "==" .  $chkME2save . "==" . $chkURLKEY . "^^\n" ;

                        //exit(); 

                    }

                    

                    if( intval($chkURLKEY) > intval(0) )

                    {

                        // Duplicate Found ===

                    }

                    else

                    {

                         

                        // Found Unique ===

                        $GETurlkey = $chkME2save;   

                        break;

                    }

                    $ixx++;              

                    

                } 

                

                /// NO CONDITION GET UNIQUE URL KEY ====

                if ( trim($GETurlkey) != "" )

                {

                    $url_key = $GETurlkey;    

                }

                else

                {

                    $url_key = "UNABLE TO CREATE";  

                }

                 

            } 

            

        }

        

        if($MASTERTYPE !='')

        {

            insertMasterURLKEY($ID2SAVE, $MASTERTYPE,$url_key);

        }

        

        return $url_key ;            

        

    }

    else

    {

        // Duplicate Found ====   

         

        $url_key = filterString($TITLE);

         

        $chkURLKEY = chkUrlKey($TBLNAME,$url_key,$COLNAME,$COLVALUE,$COLOPERATOR);

        

        if( intval($chkURLKEY) > intval(0) )

        {

         

            if($ID2SAVE !='')

            {

                

                $id2s_array = explode("~~~", $ID2SAVE); 

                $ixx = 0;

                

                $GETurlkey = "";

                          

                foreach($id2s_array as $save)

                {

                    //echo "->" . $ixx  . "\n";

                    $chkME2save = "";

                    

                    switch($ixx)

                    {

                        case "0": 

                            $chkME2save = $id2s_array[0];

                            break;

                        case "1":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1];

                            break;

                        case "2":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2];

                            break; 

                        case "3":

                            $chkME2save = $id2s_array[0] . "-" . $id2s_array[1] . "-" . $id2s_array[2] . "-" . $id2s_array[3];

                            break; 

                            

                    }

                     

                 

                    $chkME2save = filterString($TITLE . "-" . $chkME2save);

                     

                    

                    $chkURLKEY = chkUrlKey($TBLNAME,$chkME2save,$COLNAME,$COLVALUE,$COLOPERATOR);

                    

                    if ( intval($ixx) == intval(2) )

                    {

                        //echo $ixx . "==" .  $chkME2save . "==" . $chkURLKEY . "^^\n" ;

                        //exit(); 

                    }

                    

                    

                    

                    if( intval($chkURLKEY) > intval(0) )

                    {

                        // Duplicate Found ===

                    }

                    else

                    {

                         

                        // Found Unique ===

                        $GETurlkey = $chkME2save;   

                        break;

                    }

                     

                    

                     

                    

                    $ixx++;              

                    

                } 

                

                /// NO CONDITION GET UNIQUE URL KEY ====

                if ( trim($GETurlkey) != "" )

                {

                    $url_key = $GETurlkey;    

                }

                else

                {

                    $url_key = "UNABLE TO CREATE";  

                }

                 

                return $url_key ; 

                 

                  

            }

            else

            {

                return "" ;  

            }

        }

        else

        {

            

            if($MASTERTYPE !='')

            {

                insertMasterURLKEY($ID2SAVE,$MASTERTYPE,$url_key);

            }

            return $url_key ; 

        }

                   

    }

    

 



}









function getDetails($TBL, $GETNAME, $COLNAME,$COLVALUE,$COLOPERATOR, $ORDER, $LIMIT,$ECHO)

{

    global $dCON;

    $SQL  = "";    

        

    if(trim($GETNAME) == "*")

    {

        $SQL .= " SELECT $GETNAME FROM " . $TBL;    

    }

    elseif(trim($GETNAME) == "COUNT")

    {

        $SQL .= " SELECT count(*) as CT FROM " . $TBL;

    }

    else 

    {              

        $get_array = str_replace("~~~",",", $GETNAME); 

        $SQL .= " SELECT $get_array FROM " . $TBL;

    }

        

    $SQL .= " WHERE status != 'DELETE' ";

    

     

    

    if(trim($COLNAME)!="")

    {

        

        $name_array = explode("~~~", $COLNAME);

        $op_array = explode("~~~", $COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            $SQL .= "AND " . $cname . " " . $copr . " ? ";

       

            $lp++;          

        }       

        

    }

     

    if ( trim($ORDER) != "" )

    {

        $SQL .= " ORDER BY  " . $ORDER . " ";

    }

    if ( intval($LIMIT) > intval(0) )

    {

        $SQL .= " LIMIT " . $LIMIT . " ";

    }

    

           

     if(trim($ECHO)!='')

     {

        echo $SQL.$COLVALUE;  

     }

    //

    //exit();

    $stmt = $dCON->prepare( $SQL );

    $IDX = 0; 

      

    if(trim($COLVALUE)!="")

    {        

        $value_array = explode("~~~", $COLVALUE);

         

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);          

             

        }      

        

    }   

    

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    

    if(trim($GETNAME) == "*")

    {

        return $row;    

    }

    elseif(trim($GETNAME) == "COUNT")

    {

        return (int) $row[0]['CT'];

    }

    else 

    {              

        $get_array = explode("~~~", $GETNAME); 

        

        $CC = count($get_array);

        if ( intval($CC) == intval(1) )

        {

            stripslashes($row[0][$GETNAME]);

            return stripslashes($row[0][$GETNAME]);

        }

        else

        {

            return $row;

        }

        

          

    }

    

}





 

function limit_char($string, $char_limit)

{

    $string = str_replace("\xa0",' ',$string);

    

    $chr_len = strlen($string);

    if ( intval($chr_len) > intval($char_limit) )

    {

        $last_space = strrpos(substr($string, 0, $char_limit), ' ');

        return substr($string, 0, $last_space)." &hellip;";            

    }

    else

    {

        return $string;

    }   

     

}





 

function limit_words($string, $word_limit)

{

    $words = explode(" ",$string);

    return implode(" ",array_splice($words,0,$word_limit));

}



function limit_charaters($x, $length){

    

  if(strlen($x)<=$length){

    return  $x;

  }else{

    $y=substr($x,0,$length);

    return $y;

  }

}



function filterString($string)

{

    $return_string = "";

    $return_string = str_ireplace("&", "and", trim($string));

    $return_string = preg_replace('/[^a-zA-Z0-9_ -]/s', '', $return_string);

    $return_string = str_ireplace("'", "", trim($return_string));

    $return_string = str_ireplace(" ", "-", trim($return_string));

    $return_string = str_ireplace("----", "-", trim($return_string));

    $return_string = str_ireplace("---", "-", trim($return_string));

    $return_string = str_ireplace("--", "-", trim($return_string));

    $return_string = strtolower($return_string);

    return $return_string;

}





function filterIMG($string)

{

    $return_string = "";

    $return_string = str_ireplace("&", "and", trim($string));

    $return_string = str_ireplace(" ", "-", trim($return_string));

    $return_string = str_ireplace(",", "", trim($return_string));

    $return_string = str_ireplace("'", "", trim($return_string));

    return $return_string;

}





function resizeMarkup($markup, $dimensions)

{

    $count = preg_match('/src=(["\'])(.*?)\1/', $markup, $match);

    //echo($match[2] . "\n");

    $string = $markup;

    $pattern = '/src=(["\'])(.*?)\1/';

    $replacement = "src='" . $match[2] . "?wmode=transparent'";

    $markup = preg_replace($pattern, $replacement, $string);

    

	///print_r ($dimensions ) . "<BR>";

	

	$w = $dimensions['width'];

	$h = $dimensions['height'];

	

	$patterns = array();

	$replacements = array();

	

	if( !empty($w) )

	{

		$patterns[] = '/width="([0-9]+)"/';

		$patterns[] = '/width:([0-9]+)/';

		

		$replacements[] = 'width="'.$w.'"';

		$replacements[] = 'width:'.$w;

	}



	if( !empty($h) )

	{

		$patterns[] = '/height="([0-9]+)"/';

		$patterns[] = '/height:([0-9]+)/';

		

		$replacements[] = 'height="'.$h.'"';

		$replacements[] = 'height:'.$h;

	}

	

	return preg_replace($patterns, $replacements, $markup);

}



 



function deleteIMG($TYP,$IMG,$PATH="")

{

    

    //echo $TYP."==".$IMG."==".$PATH;

    if ( trim($TYP) == trim("PROFILE_SIZE_IMG") ){

        //unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("NEWSLETTER-SPONSOR") ){

       unlink($PATH ."/R100-" . $IMG); 

       unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("GOVERNANCE_IMG") ){

       unlink($PATH ."/R200-" . $IMG); 

       unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("EVENT-GALLERY") ){

        unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/R500-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("PROJECTS_HOMEPAGE_IMAGE") ){

        unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/R500-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("PROJECTS-LOGO") ){

        unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }elseif ( trim($TYP) == trim("MEDIA-GALLERY") ){

        unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/R500-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }

    elseif ( trim($TYP) == trim("GALLERY") ){

        unlink($PATH ."/R50-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/R500-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }

    elseif ( trim($TYP) == trim("TEMP") ){

        unlink($PATH ."/" . $IMG);

    }

    

    elseif ( trim($TYP) == trim("NEWSLETTER_EDITOR") ){

        unlink($PATH ."/R60-" . $IMG); 

        unlink($PATH ."/R130-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }

    elseif ( trim($TYP) == trim("NEWSLETTER_PRESIDENT") ){

        unlink($PATH ."/R60-" . $IMG); 

        unlink($PATH ."/R130-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }

    elseif ( trim($TYP) == trim("PAYMENT_RECIEPT_IMG") ){ 

        unlink($PATH ."/R500-" . $IMG); 

        unlink($PATH ."/R200-" . $IMG); 

        unlink($PATH ."/" . $IMG);

        

    }

}



 



function resizeIMG($TYP,$IMG,$ID,$PATH="")

{            

    //echo $TYP . "===" . $IMG . "===" . $PATH." =========ID". $ID;

   //exit();  

    

    if ( trim($TYP) == trim("PROFILE_SIZE_IMG") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(150,$PATH."R200-".$IMG);

         

    }elseif ( trim($TYP) == trim("GOVERNANCE_IMG") ){  

	

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(150,$PATH."R200-".$IMG);

        

    }elseif ( trim($TYP) == trim("NEWSLETTER-SPONSOR") ){  

	

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(100,$PATH."R100-".$IMG);

        

    }elseif ( trim($TYP) == trim("EVENT-GALLERY") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        $work->resize(500,$PATH."R500-".$IMG); 

        

    }elseif ( trim($TYP) == trim("PROJECTS_HOMEPAGE_IMAGE") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        $work->resize(500,$PATH."R500-".$IMG); 

        

    }elseif ( trim($TYP) == trim("PROJECTS-LOGO") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        

    }elseif ( trim($TYP) == trim("MEDIA-GALLERY") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        $work->resize(500,$PATH."R500-".$IMG); 

        

    }elseif ( trim($TYP) == trim("GALLERY") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        $work->resize(500,$PATH."R500-".$IMG); 

        

    }

    elseif ( trim($TYP) == trim("RESOURCES-GALLERY") ){  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(50,$PATH."R50-".$IMG); 

        $work->resize(200,$PATH."R200-".$IMG); 

        $work->resize(500,$PATH."R500-".$IMG); 

    }

    elseif ( trim($TYP) == trim("NEWSLETTER_EDITOR") )

    {  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(70,$PATH."R70-".$IMG); 

        

    }

    

    elseif ( trim($TYP) == trim("NEWSLETTER_PRESIDENT") )

    {  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(70,$PATH."R70-".$IMG); 

        

    }

    elseif ( trim($TYP) == trim("PAYMENT_RECIEPT_IMG") )

    {  

        $file_type = getimagesize($PATH.$IMG); 

        $work = new ImgResizerW($PATH.$IMG,$file_type['mime']);

        $work->resize(200,$PATH."R200-".$IMG);

        $work->resize(500,$PATH."R500-".$IMG);

        

    }

    

}

  





function selfURL() 

{ 

    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 

    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 

    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]); 

    return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 

} 



function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }







function getExtensionForDisplayingIcons($path)

{

    $EXT = pathinfo($path);

    if($EXT['extension'] == "jpeg" || $EXT['extension'] == "jpg" || $EXT['extension'] == "pjpg" )

    {

        $Ex = "jpg.png";

    }

    else if($EXT['extension'] == "gif")

    {

        $Ex = "gif.png";

    }

    else if($EXT['extension'] == "png")

    {

        $Ex = "jpg.png";

    }

    else if($EXT['extension'] == "txt")

    {

        $Ex = "txt.png";

    }

    else if($EXT['extension'] == "doc" || $EXT['extension'] == "docx")

    {

        $Ex = "doc.png";

    }

    else if($EXT['extension'] == "xls" || $EXT['extension'] == "xlsx")

    {

        $Ex = "xls.png";

    }

    else if($EXT['extension'] == "ppt" || $EXT['extension'] == "pptx")

    {

        $Ex = "ppt.png";

    }

    else if($EXT['extension'] == "pdf")

    {

        $Ex = "pdf.png";

    }

    else if($EXT['extension'] == "mp4")

    {

        $Ex = "mp4.png";

    }

    else

    {

        $Ex = "file.png";

    }

    

    return $Ex;

}







function getExtensionName($path)

{

    $EXT = pathinfo($path);

    return strtolower($EXT['extension']);

}







function jsencode( $obj ){

    if ( function_exists( 'json_encode' ) )

    {

        echo str_ireplace("\\n", "", json_encode($obj));

    }

    else

    {

        if( is_array( $obj ) ){

    		$code = array();

    		if( array_keys($obj) !== range(0, count($obj) - 1) ){

    			foreach( $obj as $key => $val ){

    				$code []= '"' . $key . '"' . ':' . jsencode( $val );

    			}

    			$code = '{' . implode( ',', $code ) . '}';

    		} else {

    			foreach( $obj as $val ){

    				$code []= jsencode( $val );

    			}

    			$code = '[' . implode( ',', $code ) . ']';

    		}

    		return $code;

    	} else {

    		return '"' . addslashes( $obj ) . '"';

    	}

    }	

}







function youtube_image($path, $quality = "HIGH")

{

    $first_src_pos = strpos($path, "src=");

    $start_from_src = substr($path, $first_src_pos, strlen($path));

    

    $split_space = explode(" ", $start_from_src);

    

    $remove_src = str_replace("src=\"","", $split_space[0]);

    

    $remove_double_quote = str_replace("\"","", $remove_src);

    

    $split_question = explode("?", $remove_double_quote);

    

    $split_slash = explode("/", $split_question[0]);

    

    $count = count($split_slash);

    

    $youtube_code = $split_slash[$count-1];

	

    if($quality == "HIGH")

    {

        $image = "http://i3.ytimg.com/vi/".$youtube_code."/hqdefault.jpg";

    }

    else

    {

        $image = "http://i3.ytimg.com/vi/".$youtube_code."/default.jpg";  

    }

     

    return $image;

    

}  

 

function _formatnumber($numberStr)

{



    if(intval($numberStr) == intval(1))

    {

        $nu="st";

    }

    elseif(intval($numberStr) == intval(2))

    {

        $nu="nd";

    }

    elseif(intval($numberStr) == intval(3))

    {

        $nu="nd";

    }

    else

    {

        $nu="th";

    }

    

    return $nu;

}





function regularFont($fontStr)

{



    $font = ucwords(strtolower($fontStr));

    

    return $font;

}





function _formatDate($dateStr)

{

    $timestr = "";

    $t = time() - strtotime($dateStr);

    if($t < 60) {

        $timestr = "{$t} seconds ago";

    }

    elseif ($t <120) {

        $timestr = "about a minute ago";

    }

    elseif ($t < 3600) {

        $minute = floor($t/60);

        $timestr = "{$minute} minutes ago";

    }

    elseif ($t < 7200) {

        //$timestr = " about an hour ago";

        $timestr = " 1 hour ago";

    }

    elseif ($t < 86400) {

        $hour = floor($t/3600);

        $timestr = "{$hour} hours ago";

    }

    elseif ($t < 172800) {

        //$timestr = "1 day ago";

        $timestr = "Yesterday";

    }

    else 

    {

        //$month = floor($t/2592000);

        $timestr = date("d M Y",strtotime($dateStr));

    }

    

    return $timestr;

} 







function showICONS($STING)

{

    $exp = explode("~~~",$STING);

    if ( count($exp) > intval(0) )

    {

        echo '<ul class="hintIconList">';

        foreach($exp as $STR)

        {

            if ( strpos($STING,$STR) > intval(0) )

            {

                if ( trim($STR) == "MODIFY" )

                {

                    echo '<li><img border="0" alt="Modify" title="Modify" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'edit_icon.png"> Modify </li>';

                }

                else if ( trim($STR) == "DELETE" )

                {

                    echo '<li><img border="0" alt="Delete" title="Delete" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'trash.png"> Delete </li>';

                } 

                else if ( trim($STR) == "ACTIVE" )

                {

                    echo '<li><img border="0" alt="Active" title="Active" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'active.png"> Active </li>';

                } 

                else if ( trim($STR) == "INACTIVE" )

                {

                    echo '<li><img border="0" alt="Inactive" title="Inactive" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'inactive.png"> Inactive </li>';

                } 

                else if ( trim($STR) == "COPY" )

                {

                    echo '<li><img border="0" alt="Copy" title="Copy" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'copyIcon.png">Copy</li>';

                } 

                else if ( trim($STR) == "DEALS" )

                {

                    echo '<li><img border="0" alt="Deals of the month" title="Deals of the month" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'dealsIcon.png">Deals of the month</li>';

                } 

                else if ( trim($STR) == "DRAFT" )

                {

                    echo '<li><img border="0" alt="Saved as Draft" title="Saved as Draft" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'draftIcon.png"> Saved as Draft </li>';

                }  

                               

                else if ( trim($STR) == "POSITION" )

                {

                    echo '<li><img border="0" alt="Drag & Position" title="Drag & Position" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'arrow_pos.png"> Drag & Position </li>';

                }

				

				else if ( trim($STR) == "EXPIRED" )

                {

                    echo '<li><img border="0" alt="Expired Coupons" title="Expired Coupons" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'expiredColor.png"> Expired </li>';

                } 

				

				else if ( trim($STR) == "USED" )

                {

                    echo '<li><img border="0" alt="Used Coupons" title="Used Coupons" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'usedColor.png"> Used </li>';

                } 

                

                else if ( trim($STR) == "MOVETO" )

                {

                    echo '<li><img border="0" alt="Used Coupons" title="Used Coupons" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'move-icon.png"> Move To</li>';

                }

                else if ( trim($STR) == "VIEW" )

                {

                    echo '<li><img border="0" alt="Used Coupons" title="View Details" src="' . CMS_INCLUDES_ICON_RELATIVE_PATH . 'view.png"> View Details</li>';

                }

                                

            }

      

        }

        echo '</ul>';

    }

    

}









function getMeta($TBL,$Select_Field,$CONDITION_FIELDS,$CONDITION_VALUES,$CONDITION_OPP,$ECHO )

{

    global $dCON;

    

    if(trim($Select_Field)!='')

    {

        $Select_Field = " , $Select_Field";

    }

    

    $SQL  = "";

    $SQL .= " SELECT meta_title, meta_keyword, meta_description $Select_Field FROM " . $TBL;

    $SQL .= " WHERE status != 'DELETE' ";

    if(trim($CONDITION_FIELDS)!="")

    {

        

        $name_array = explode("~~~", $CONDITION_FIELDS);

        $op_array = explode("~~~", $CONDITION_OPP);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            $SQL .= "AND " . $cname . " " . $copr . " ? ";

       

            $lp++;          

        }       

        

    }

    

    

    if(trim($ECHO)!='')

    {

        echo $SQL;

    }

    

    $stmt = $dCON->prepare( $SQL );

    

    $IDX = 0;    

    if(trim($CONDITION_VALUES)!="")

    {        

        $value_array = explode("~~~", $CONDITION_VALUES);

         

        foreach($value_array as $cvalue)

        {

            ///echo $cvalue;

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);          

             

        }      

        

    }   

    

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    //print_r($row);

    return $row;

        

}





function urlRewrite($url_value = "", $query_string = array())

{

    $return_url = "";

    //$url_rewrite = true;

    //$url_rewrite = false;

    ///print_r($query_string);

    

    if ($_SESSION["url_rewrite"] == '1')

    {

        $url_rewrite = true;

        //$url_rewrite = false;

        $_SESSION['INCLUDE_QMARK'] = "?";

    

    }else{

        $url_rewrite = false;

        //$url_rewrite = true;

        $_SESSION['INCLUDE_QMARK'] = "&";

    }

    if($url_rewrite == true)

    {

        if($url_value == "media.php"){

            $return_url = "media";



        }elseif($url_value == "gallery.php"){

            $return_url = "gallery";



        }elseif($url_value == "events.php"){

            $return_url = "events";



        }elseif($url_value == "news.php"){

            $return_url = "news";



        }

        elseif($url_value == "resources.php")

        {

            //$return_url = "resources";

            $cat_url_key = filterString($query_string['cat_url_key']);

            

            if($cat_url_key != "") 

            {

                $return_url = "resources/" . $cat_url_key . "/";    

            } 

            else 

            {

                $return_url = "resources/";

            }

        }

        

        

        elseif($url_value == "board_governor.php"){

            $return_url = "board-governors";



        }elseif($url_value == "executive-committee.php"){

            $return_url = "executive-committee";



        }elseif($url_value == "judges_advisory_roundtable.php"){

            $return_url = "judges-advisory-board";



        }elseif($url_value == "draft_best_practices.php"){

            $return_url = "draft-best-practices";



        }elseif($url_value == "academic_committees.php"){

            $return_url = "academic-committees";



        }elseif($url_value == "young-members-committee.php"){

            $return_url = "young-practitioner's-committee";



        }elseif($url_value == "insol-india.php"){

            $return_url = "insol-india";



        }elseif($url_value == "mission.php"){

            $return_url = "mission";



        }elseif($url_value == "vision-statement.php"){

            $return_url = "vision-statement";



        }elseif($url_value == "history.php"){

            $return_url = "history";



        }elseif($url_value == "legal-status.php"){

            $return_url = "legal-status";



        }elseif($url_value == "nlu-delhi-insol-india-international-moot-competition-on-insolvency.php"){

            $return_url = "nlu-delhi-insol-india-international-moot-competition-on-insolvency";



        }elseif($url_value == "voluntary-best-practices.php"){

            $return_url = "voluntary-best-practices";



        }elseif($url_value == "designing-insolvency-courses-for-law-schools.php"){

            $return_url = "designing-insolvency-courses-for-law-schools";



        }elseif($url_value == "sipi.php"){

            $return_url = "sipi";



        }elseif($url_value == "members.php"){

            $return_url = "members";



        }elseif($url_value == "contribute-newsletter.php"){

            $return_url = "contribute_newsletter";



        }elseif($url_value == "governance_list.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = $url_key;



        }elseif($url_value == "governance_sub_list.php"){

            $master_url_key = filterString($query_string['master_url']);

            //$master_url_key = filterString($query_string['master_url']);

            $url_key = filterString($query_string['url_key']);

            $return_url = $master_url_key.'/'.$url_key. "";



        }elseif($url_value == "governance_detail.php"){

            $master_url = filterString($query_string['master_url']);

            $url_key = filterString($query_string['url_key']);

           

            $return_url = 'governance/'.$master_url.'/'.$url_key. "";



        }elseif($url_value == "governance_sub_detail.php"){

            $type_url_key = filterString($query_string['type_url_key']);

            $subtype_key = filterString($query_string['subtype_key']);

            $url_key = filterString($query_string['url_key']);

           

            $return_url = $type_url_key.'/'.$subtype_key.'/'.$url_key. "";



        }elseif($url_value == "news-details.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'news/'.$url_key;



        }elseif($url_value == "event-detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'event/'.$url_key;



        }elseif($url_value == "media-detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'media/'.$url_key;



        }elseif($url_value == "sig24.php"){

            $return_url = "SIG24";



        }elseif($url_value == "sig24_detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'SIG24/'.$url_key;



        }

        elseif($url_value == "resource-detail.php")

        {

            $url_key = filterString($query_string['url_key']);

            //$return_url = 'resources/'.$url_key;

            $return_url = 'resources/'.$url_key. ".html";;



        }

        elseif($url_value == "gallery-detail.php")

        {

            $url_key = filterString($query_string['url_key']);

            $return_url = 'gallery/'.$url_key;



        }

        elseif($url_value == "executive_committee_detail.php")

        {

            $url_key = filterString($query_string['url_key']);

            $return_url = 'executive-committee/'.$url_key;



        }

        elseif($url_value == "board_governor_detail.php")

        {

            $url_key = filterString($query_string['url_key']);

            $return_url = 'board-governors/'.$url_key;



        }

        elseif($url_value == "projects_detail.php")

        {

            $url_key = filterString($query_string['url_key']);

            $return_url = 'projects/'.$url_key;



        }

        elseif($url_value == "judges_advisory_roundtable_detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'judges-advisory-roundtable/'.$url_key;



        }elseif($url_value == "academic_committees_detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = 'academic-committees/'.$url_key;



        }elseif($url_value == "young_members_committee_detail.php"){

            $url_key = filterString($query_string['url_key']);

            $return_url = "young-practitioner's-committee/".$url_key;

        }

        else if($url_value == "login.php")

        {

            $return_url = "login";

        }

        else if($url_value == "myaccount.php")

        {

            $return_url = "myaccount";

        }

        

        else if($url_value == "change-pass.php")

        {

            $return_url = "change-pass";

        }

        

    }

    else

    {

        if(strstr($url_value, "?"))

        {   

            $A  = "";

            $A .= $url_value;

            $IMP_QRY_STRING = "";

            

            foreach($query_string as $index => $query_string_rs)

            {

                $IMP_QRY_STRING .= "&".$index."=".$query_string_rs;

            }

            

            $A .= $IMP_QRY_STRING;

            

            

        }

        else

        {

            $A  = "";

            $A .= $url_value."?";

            $IMP_QRY_STRING = "";

            $ik = 0;

            foreach($query_string as $index => $query_string_rs)

            {

                if($ik > 0)

                {

                    $IMP_QRY_STRING .= "&";

                }

                

                $IMP_QRY_STRING .= $index."=".$query_string_rs;

                $ik++;

            }

            

            $A .= $IMP_QRY_STRING;

        }

        

        $return_url = $A;   

    }

    return $return_url;

}





function moneyFormatIndia($num, $CURRENCY_TO_USE = CURRENCY_TO_USE){

    if($CURRENCY_TO_USE == "INR") {

        $num = round($num);

    }

    if(strstr($num, ".")) {

        $num_exp = explode(".", $num);    

        $num = $num_exp[0];

        $num_point = "." . $num_exp[1]; //$num_exp[1]; 

    } else {

        $num_point = "";

    }

    

    $explrestunits = "" ;

    if(strlen($num)>3){

        $lastthree = substr($num, strlen($num)-3, strlen($num));

        $restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits

        $restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.

        $expunit = str_split($restunits, 2);

        for($i=0; $i<sizeof($expunit); $i++){

            // creates each of the 2's group and adds a comma to the end

            if($i==0)

            {

                $explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer

            }else{

                $explrestunits .= $expunit[$i].",";

            }

        }

        $thecash = $explrestunits.$lastthree;

    } else {

        $thecash = $num;

    }

    

    return $thecash . $num_point; // writes the final format where $currency is the currency symbol.

}





function _daysInMonth($month=null,$year=null)

{

    if(null==($year))

        $year =  date("Y",time()); 

    if(null==($month))

        $month = date("m",time());

        

    return date('t',strtotime($year.'-'.$month.'-01'));

}











function timeDisplayFormat($time)

{

    $RETURN_VALUE = "";

    if($time == "00:00:00") 

    {

        $RETURN_VALUE = "12 midnight"; 

    }

    else if($time == "12:00:00")

    {

        $RETURN_VALUE = "12 noon"; 

    } 

    else

    {

        $RETURN_VALUE = date("h:i A", strtotime($time));

    }

    

    return $RETURN_VALUE;

}





function getMasterID($TBL, $TABLEID, $CONDITIONS_COLNAME,$CONDITIONS_COLVALUE,$CONDITIONS_COLOPERATOR, $INSERT_COLNAME,$INSERT_COLVALUE, $ECHO)

{

    global $dCON;

    

    

    $SQL  = "";    

    $SQL .= " SELECT $TABLEID FROM " . $TBL;    

    $SQL .= " WHERE status != 'DELETE' ";

     

    if(trim($CONDITIONS_COLNAME)!="")

    {

        

        $name_array = explode("~~~", $CONDITIONS_COLNAME);

        $op_array = explode("~~~", $CONDITIONS_COLOPERATOR);

        $lp = 0;

        foreach($name_array as $cname)

        {

            $cname = trim($cname);            

            $copr = trim($op_array[$lp]);            

            $SQL .= "AND " . $cname . " " . $copr . " ? ";

       

            $lp++;          

        }       

        

    }

           

    if(trim($ECHO)!='')

    {

        //echo "\n".$SQL;  

    }

    //

    //exit();

    $stmt = $dCON->prepare( $SQL );

    $IDX = 0; 

      

    if(trim($CONDITIONS_COLVALUE)!="")

    {        

        $value_array = explode("~~~", $CONDITIONS_COLVALUE);

         

        foreach($value_array as $cvalue)

        {

            $IDX++;

            $cvalue = trim($cvalue);            

            $stmt->bindValue($IDX, $cvalue);          

             

        }      

        

    }   

    

    $stmt->execute();

    $row = $stmt->fetchAll();

    $stmt->closeCursor();

    

    //echo "==".count($row);

    

    if(intval(count($row)) >intval(0))

    {

                     

        $get_array = explode("~~~", $TABLEID); 

        

        $CC = count($get_array);

        

        if ( intval($CC) == intval(1) )

        {

            return stripslashes($row[0][$TABLEID]);

        }

        else

        {

            return $row;

        }

         

    }

    else

    {

        

        if(trim($INSERT_COLVALUE)!="")

        { 

            $ip = $_SERVER['REMOTE_ADDR'];

            $TIME = date("Y-m-d H:i:s");

            

            $MAX_ID = getMaxId($TBL,$TABLEID);

            $MAX_POS = getMaxPosition($TBL,"position","","","=");

                             

            $sql  = "";

            $sql .= " INSERT INTO " . $TBL . " SET ";

            $sql .= $TABLEID ."= '". $MAX_ID ."',";

            

            $INname_array = explode("~~~", $INSERT_COLNAME);

            $INvalue_array = explode("~~~", $INSERT_COLVALUE);

            

            $in = 0;

            foreach($INname_array as $colname)

            {

                $INcolname = trim($colname);            

                $INcolvalue = trim($INvalue_array[$in]); 

                           

                $sql .= $INcolname . " = '".$INcolvalue."', ";

           

                $in++;          

            }       

            

        

            $sql .= " position = :position, ";

            $sql .= " add_ip = :add_ip, ";

            $sql .= " add_time = :add_time, ";

            $sql .= " add_by = :add_by, ";

            $sql .= " meta_title = :meta_title, "; 

            $sql .= " meta_keyword = :meta_keyword, ";

            $sql .= " meta_description = :meta_description "; 

            

            $stmt = $dCON->prepare($sql);

            $stmt->bindParam(":position", $MAX_POS); 

            $stmt->bindParam(":add_ip", $ip);

            $stmt->bindParam(":add_time", $TIME);

            $stmt->bindParam(":add_by", $_SESSION['USERNAME']);

            $stmt->bindParam(":meta_title", $meta_title);

            $stmt->bindParam(":meta_keyword", $meta_keyword);

            $stmt->bindParam(":meta_description", $meta_description);

            

            if(trim($ECHO)!='')

            {

                //echo "\n". $sql;  

            }

            

            $rs = $stmt->execute();

            $stmt->closeCursor();

            if( intval($rs) == intval(1) )

            {

                return $MAX_ID;

            }

        

        } 

        

        

    }

}







function sendMailformate($TYP,$ID,$via="")

{

    global $dCON;

    $TODAY = date("Y-m-d");

    //$TODAY = date("jS F, Y", strtotime($TODAY));

    $TODAY = date("j<\s\up>S</\s\up> F' Y");

    //echo $TYP . "===" . $ID;

    $MAIL_BODY = '';

    $MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';

        $MAIL_BODY .= '<tbody>';

            $MAIL_BODY .= '<tr>';

                $MAIL_BODY .= '<td>';

                    $MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';

                        $MAIL_BODY .= '<tbody>';

                            $MAIL_BODY .= '<tr>';

                                $MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>';

                            $MAIL_BODY .= '</tr>';

                            

                            if($TYP=='approved')

                            {     

                                $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$ID,'=', '', '' , "" );   

                                    

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $member_id = stripslashes($rsGET[0]["member_id"]);

                                    $reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);

                                    $reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $first_name = stripslashes($rsGET[0]["first_name"]);

                                    $middle_name = stripslashes($rsGET[0]["middle_name"]);

                                    $last_name = stripslashes($rsGET[0]["last_name"]);

                                    $name = $title." ".$first_name;

                                    if($middle_name !='')

                                    {

                                        $name = $name." ".$middle_name;

                                    }

                                    $name = $name." ".$last_name;

                                    

                                    $name = ucwords(strtolower($name));

                                    

                                    $address = stripslashes($rsGET[0]["address"]);

                                    $permanent_address = stripslashes($rsGET[0]["permanent_address"]);

                                    

                                    $city = stripslashes($rsGET[0]["city"]);

                                    $country = stripslashes($rsGET[0]["country"]);

                                    $pin = stripslashes($rsGET[0]["pin"]);

                                    $telephone = stripslashes($rsGET[0]["telephone"]);

                                    $email = stripslashes($rsGET[0]["email"]);

                                    $password = stripslashes($rsGET[0]["password"]);

                                    $mobile = stripslashes($rsGET[0]["mobile"]);

                                    $i_am = stripslashes($rsGET[0]["i_am"]);

                                    $other_i_am = stripslashes($rsGET[0]["other_i_am"]);

                                    $insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);

                                    $insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);

                                    $insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);

                                    $registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);

                                    $registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);

                                    $young_practitioner = stripslashes($rsGET[0]["young_practitioner"]);

                                    $young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);

                                    $interested = stripslashes($rsGET[0]["interested"]);

                                    $terms = stripslashes($rsGET[0]["terms"]);

                                    $committed = stripslashes($rsGET[0]["committed"]);

                                    $payment_text = stripslashes($rsGET[0]["payment_text"]);

                                    $payment_status = stripslashes($rsGET[0]["payment_status"]);

                                    $register_status = stripslashes($rsGET[0]["register_status"]);

                                    $sig_member = stripslashes($rsGET[0]["sig_member"]);

                   

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.' ('. $TODAY.')</td>';

                                    $MAIL_BODY .= '</tr>';

                                    if($sig_member == intval(0))

                                    {

                                        $MAIL_BODY .='<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 12px;">

                                                            <h1 style="color: #2E3192; font-size:16px;">We are pleased to accept your application for membership of INSOL India.</h1> 

                                                            You can make the payment of Rs 7080 (6000+18% GST) through either of the following mechanism:<br><br>

                                                            <strong>Cheque in favour of: INSOL India</strong><br>

                                                            (INSOL India, 5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014)<br><br>

                                                            <strong>NEFT / IMPS</strong><br>

                                                            Axis Bank Limited<br>

                                                            Jungpura, Delhi 110011<br>

                                                            Account Number: 126010200004480<br>

                                                            IFSC Code: UTIB0003329<br><br>

                                                            You are requested to send a screenshot of the proof of payment to <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a>.<br><br>

                                                            <strong>Please note: </strong>Activation of membership is subject to successful payment and receipt of the same at our end.

                                                        </td>

                                                    </tr>';

                                    }else{

                                        $MAIL_BODY .= '<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>

                                                                <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>

                                                                <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>

                                                                Membership Number: <br>

                                                                <strong>Login ID:</strong> '.$email.' <br>

                                                                <strong>Password:</strong> '.$password.'<br><br>

                                                                For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>

                                                        </td>

                                                    </tr>';

                                    }

                                

                                    //echo $MAIL_BODY;

                                    //exit();

                                    $to = $email;

                                    if($sig_member == intval(0)){

                                        $subject ="INSOL INDIA - Make Payment"; 

                                    }else{

                                        $subject ="INSOL India - Membership Number "; 

                                    }

                                    

                                    

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = $_SESSION["BCC_EMAIL"];

                                

                                    

                                }       

                            } 

                            

                            else if($TYP=='event_joiner_request_approved')

                            {     

                                $rsGET = getDetails(EVENT_JOINER_TBL, '*', "event_joiner_id",$ID,'=', '', '' , "" );

                                    

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $event_joiner_id = stripslashes($rsGET[0]["event_joiner_id"]);

                                    $registration_no = stripslashes($rsGET[0]["registration_no"]);

                                    $reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $fname = stripslashes($rsGET[0]["fname"]);

                                    $surname = stripslashes($rsGET[0]["surname"]);

                                    $name_on_badge = ucwords(stripslashes($rsGET[0]["name_on_badge"]));

                                    $name = $title." ".$fname;

                                    if($surname !='')

                                    {

                                        $name = $name." ".$surname;

                                    }

                                    

                                    $name = ucwords(strtolower($name));

                                    

                                    $address = stripslashes($rsGET[0]["address"]);

                                    

                                    $phone = stripslashes($rsGET[0]["phone"]);

                                    $email = stripslashes($rsGET[0]["email"]);



                                    $terms = stripslashes($rsGET[0]["terms"]);

                                    $committed = stripslashes($rsGET[0]["committed"]);

                                    $payment_status = stripslashes($rsGET[0]["payment_status"]);

                                    $register_status = stripslashes($rsGET[0]["status"]);

                                    $registration_fees = stripslashes($rsGET[0]["registration_fees"]);

                   

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.' ('. $TODAY.')</td>';

                                    $MAIL_BODY .= '</tr>';

                                    

                                    $MAIL_BODY .='<tr>

                                                    <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 12px;">

                                                        <h1 style="color: #2E3192; font-size:16px;">We are pleased to accept your application for registration of INSOL India Annual Conference 2018.</h1> 

                                                        You can make the payment of Rs '. $registration_fees .'/-(inclusive of 18% GST) through either of the following mechanism:<br><br>

                                                        <strong>Cheque in favour of: INSOL India</strong><br>

                                                        (INSOL India, 5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014)<br><br>

                                                        <strong>NEFT / IMPS</strong><br>

                                                        Axis Bank Limited<br>

                                                        Jungpura, Delhi 110011<br>

                                                        Account Number: 126010200004480<br>

                                                        IFSC Code: UTIB0003329<br><br>

                                                        You are requested to send a screenshot of the proof of payment to <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a>.<br><br>

                                                        <strong>Please note: </strong>Confirmation of registration is subject to successful payment and receipt of the same at our end.

                                                    </td>

                                                </tr>';

                            

                                    //echo $MAIL_BODY;

                                    //exit();

                                    $to = $email;

                                    $subject ="INSOL INDIA - Make Payment"; 

                                    

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = $_SESSION["BCC_EMAIL"];

                                    

                                }       

                            }



                            else if(trim($TYP) == "member_register")

                            {

                                    

                                $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$ID,'=', '', '' , "" );    

                                

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $member_id = stripslashes($rsGET[0]["member_id"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $first_name = stripslashes($rsGET[0]["first_name"]);

                                    $middle_name = stripslashes($rsGET[0]["middle_name"]);

                                    $last_name = stripslashes($rsGET[0]["last_name"]);

                                    $name = $title." ".$first_name;

                                    if($middle_name !='')

                                    {

                                        $name = $name." ".$middle_name;

                                    }

                                    $name = $name." ".$last_name;

                                    $name = ucwords(strtolower($name));

                                    

                                    $email = stripslashes($rsGET[0]["email"]);

                                    

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.'</td>';

                                    $MAIL_BODY .= '</tr>

       

                                    <tr>

                                        <td valign="top" style="height: 250px; color: #666; text-align: center; font-size: 16px;">

                                            <h1 style="color: #2E3192; font-size: 16px;">Thank you for your interest in the membership of INSOL India.</h1>

                                            We have received your membership form. The request has been forwarded to membership committee. We will let you know soon.

                                        </td>

                                    </tr>';

                                

                                    $to = $email;

                                    $subject = $_SESSION['COMPANY_NAME']." - Thankyou";

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = "";

                    

                                } 

    

                            }

                            

                            

                            

                            else if($TYP=='FORGOT_PASSWORD')

                            {     

                                $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$ID,'=', '', '' , "" );   

                                    

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $member_id = stripslashes($rsGET[0]["member_id"]);

                                    $reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $first_name = stripslashes($rsGET[0]["first_name"]);

                                    $middle_name = stripslashes($rsGET[0]["middle_name"]);

                                    $last_name = stripslashes($rsGET[0]["last_name"]);

                                    $name = $title." ".$first_name;

                                    if($middle_name !='')

                                    {

                                        $name = $name." ".$middle_name;

                                    }

                                    $name = $name." ".$last_name;

                                    $name = ucwords(strtolower($name));

                                    $email = stripslashes($rsGET[0]["email"]);

                                    $password = stripslashes($rsGET[0]["password"]);

                                    

                   

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.'</td>';

                                    $MAIL_BODY .= '</tr>

                                

                                    <tr>

                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                            <h1 style="color: #2E3192; font-size:16px;">Your login details are as follows:</h1> 

                                            Login Id: <b> '.$email.' </b><br><br>

                                            Password: <b> '.$password.' </b><br>

                                            <br>

                                        </td>

                                    </tr>';

                                

                                    //echo $MAIL_BODY;

                                    //exit();

                                    $to = $email;

                                    $subject ="Your Login Credentials for " . $_SESSION["COMPANY_NAME"]; 

                                    

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = "";

                                

                                    

                                }       

                            }

                            

                            

                            else if($TYP=='PAYMENT_MAIL')

                            {     

                                $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$ID,'=', '', '' , "" );   

                                    

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $member_id = stripslashes($rsGET[0]["member_id"]);

                                    $reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $first_name = stripslashes($rsGET[0]["first_name"]);

                                    $middle_name = stripslashes($rsGET[0]["middle_name"]);

                                    $last_name = stripslashes($rsGET[0]["last_name"]);

                                    $name = $title." ".$first_name;

                                    if($middle_name !='')

                                    {

                                        $name = $name." ".$middle_name;

                                    }

                                    $name = $name." ".$last_name;

                                    $name = ucwords(strtolower($name));

                                    $email = stripslashes($rsGET[0]["email"]);

                                    $password = stripslashes($rsGET[0]["password"]);

                                    $sig_member = stripslashes($rsGET[0]["sig_member"]);

                                    

                   

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.'</td>';

                                    $MAIL_BODY .= '</tr>';

                                    if($sig_member == intval(0))

                                    {

                                    $MAIL_BODY .= '<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                                            <h1 style="color: #2E3192; font-size:16px;">We are delighted to welcome you to INSOL India.</h1> 

                											<h3 style="color: #ED1C24; font-size: 16px;">Your membership number is '.$reg_number_text.'.</h3>

                											

                                                            Your login details are provided below as some features on website are accessible by members only.<br><br>

                											

                                                            <strong>Login ID:</strong> '.$email.' <br><br>

                                                            <strong>Password:</strong> '.$password.'<br>

                                                            <br><br>

                                                            <div style="border-top:1px solid #ccc">&nbsp;</div>

                                                            <div style="font-size:11px;">

                                								<h3 style="color: #000; font-size: 13px;">INSOL India Membership Benefits</h3>

                                                                <p><span style="color: #2E3192; font-weight:bold;">Conferences</span> 20% discount on registration fee for Individual Members in conferences organised by INSOL India. One annual conference and a series of workshops in different parts of the country.</p>

                                                                <p><span style="color: #2E3192; font-weight:bold;">INSOL India Newsletter</span> INSOL India has a quarterly newsletter which will be sent to all the Members free of charge.</p>

                                                                <p><span style="color: #2E3192; font-weight:bold;">Electronic Newsletter</span> INSOL India is planning to start an electronic monthly newsletter in August 2017 which will emailed to all members.</p>

                                                                </p><span style="color: #2E3192; font-weight:bold;">Membership of INSOL International</span> As a member of INSOL India, one becomes a member of INSOL International, whereby one also becomes part of a network of 10,000 members in over 80 countries around the world. This enables one, apart from getting INSOL India\'s electronic and printed newsletters, access INSOL International\'s monthly technical electronic news updates and quarterly journal INSOL World, and other resource materials at INSOL International\'s website (www.insol.org) including INSOL Technical Library containing INSOL publications, technical paper series, case studies etc. As a member, one is also able to use "search a member" tool under the Membership section to browse the database of INSOL International.</p>

                                                                <p><span style="color: #2E3192; font-weight:bold;">Committees</span> Members keen to actively participate in INSOL India activities can join various committees of INSOL India.</p>

                                                            </div>

                                                        </td>

                                                    </tr>';

                                    }

                                    else{

                                        $MAIL_BODY .= '<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>

                                                                <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>

                                                                <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>

                                                                Membership Number: '.$reg_number_text.' <br>

                                                                <strong>Login ID:</strong> '.$email.' <br>

                                                                <strong>Password:</strong> '.$password.'<br><br>

                                                                For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>

                                                        </td>

                                                    </tr>';

                                    }

                                

                                    //echo $MAIL_BODY;

                                    //exit();

                                    

                                    $to = $email;

                                    $subject ="INSOL India - Membership Number "; 

                                    

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = "";

                                

                                    

                                }       

                            }

                            

                            else if($TYP=='EVENT_JOINER_PAYMENT_MAIL')

                            {     

                                $rsGET = getDetails(EVENT_JOINER_TBL, '*', "event_joiner_id",$ID,'=', '', '' , "" );   

                                    

                                if ( count($rsGET) > intval(0) )

                                {

                                    

                                    $event_joiner_id = stripslashes($rsGET[0]["event_joiner_id"]);

                                    $registration_no = stripslashes($rsGET[0]["registration_no"]);

                                    $title = stripslashes($rsGET[0]["title"]);

                                    $fname = stripslashes($rsGET[0]["fname"]);

                                    $surname = stripslashes($rsGET[0]["surname"]);

                                    $firmname = stripslashes($rsGET[0]["firmname"]);

                                    $name = $title." ".$fname;

                                    if($surname !='')

                                    {

                                        $name = $name." ".$surname;

                                    }

                                    $name = ucwords(strtolower($name));

                                    $email = stripslashes($rsGET[0]["email"]);                                    

                   

                                    $MAIL_BODY .= '<tr>';

                                        $MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear '.$name.'</td>';

                                    $MAIL_BODY .= '</tr>';

                                    if($sig_member == intval(0))

                                    {

                                    $MAIL_BODY .= '<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                                            <h1 style="color: #2E3192; font-size:16px;">Thank you to register for INSOL India Annual Conference 2018.</h1> 

                											<h3 style="color: #ED1C24; font-size: 16px;">Registration No. '.$registration_no.'.</h3>

                                                            

                                                            <br><br>

                                                            <div style="border-top:1px solid #ccc">&nbsp;</div>

                                                            <div style="font-size:11px;">

                                								<h3 style="color: #000; font-size: 13px;">Conference venue</h3>

                                                                <p><span style="color: #2E3192;">The Leela Palace New Delhi,<br>Diplomatic Enclave, Chanakyapuri,<br>New Delhi 110 023, India<br>Conference dates<br>Tuesday 13 November 2018<br>Wednesday 14 November 2018<br>Language: The working language of the conference is English<br>Dress code: Delegates are requested to wear smart casual clothes to the conference technical sessions and social functions.</p>

                                                                

                                                                <br>

                                                                <p><span style="color: #2E3192; font-weight:bold;">Disclaimer: </span> INSOL India cannot accept any liability for any loss, cost or expense suffered or incurred 

                                                                by any person if such loss is caused or results from the act, default or omission of any person. In particular, INSOL India cannot accept any liability for losses arising 

                                                                from the provision of services provided by hotel companies or transport operators. Nor can INSOL India accept liability for losses suffered by reason of war, including 

                                                                threat of war, riots, and civil strife, terrorist activity, natural disaster, weather, fire, flood, drought, technical mechanical or electrical breakdown within any 

                                                                premises visited by delegates or their guests in connection with the Conference, industrial disputes, government action, regulations or technical problems which may affect 

                                                                the services provided in connection with the Conference.

                                                                </p>



                                                                <p><span style="color: #2E3192; font-weight:bold;">Cancellation of the Conference by the Organisers: </span>In the event that the Conference is cancelled

                                                                by INSOL India, or by any reason of any factor outside the control of INSOL India, and cannot take place, the amount of the Registration fee shall be refunded. 

                                                                The liability of INSOL India shall be limited to that refund, and INSOL India shall not be liable for any other loss, cost or expense, howsoever caused, incurred or 

                                                                arising. In particular, INSOL India shall not be liable to refund any travel costs incurred by delegates or their guests or their companies. It follows that delegates 

                                                                and their guests and their companies are advised to take out comprehensive insurance including travel insurance.

                                                                </p>

                                                               

                                                                <p> In the event that the Conference is cancelled by INSOL India we will contact delegates immediately.</p>

                                                                

                                                                <p><span style="color: #2E3192; font-weight:bold;">Cancellations/Substitution: </span> Once registration form is received, participation can’t be cancelled, however 

                                                                substitutions are welcome at any time with prior notifications and on confirmation by INSOL India. Cancellations carry a 100% liability and course materials 

                                                                will still be couriered to you.

                                                                </p>



                                                                <p><span style="color: #2E3192; font-weight:bold;">Hotel Bookings and Cancellations:</span> All hotel bookings are the responsibility of the individual delegate to 

                                                                make and cancel directly with the hotel. Credit card guarantee is required at time of reservations. Please be aware of the cancellation policy for the Conference hotel.</p>

                                                                

                                                                <p><span style="color: #2E3192; font-weight:bold;">Conference Registration via the web: </span> Registrations can be made via the INSOL India website at <a href="http://insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>.</p>

                                                                

                                                                <br>

                                                                <p>Become a member of INSOL India and take advantage of all the member benefits including reduced Conference fees.To apply for membership please contact <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a>  For more details visit: <a href="http://insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>.</p>

                                                                

                                                                <br>

                                                                <p>We look forward to welcome you at the INSOL India Conference.</p>

                                                            </div>

                                                        </td>

                                                    </tr>';

                                    }

                                    else{

                                        $MAIL_BODY .= '<tr>

                                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">

                                								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>

                                                                <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>

                                                                <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>

                                                                Membership Number: '.$reg_number_text.' <br>

                                                                <strong>Login ID:</strong> '.$email.' <br>

                                                                <strong>Password:</strong> '.$password.'<br><br>

                                                                For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>

                                                        </td>

                                                    </tr>';

                                    }

                                

                                    //echo $MAIL_BODY;

                                    //exit();

                                    

                                    $to = $email;

                                    if($TYP=='EVENT_JOINER_PAYMENT_MAIL'){

                                        $subject ="INSOL India - Delegate Registration Number "; 

                                    } else {

                                        $subject ="INSOL India - Membership Number "; 

                                    }

                                    $FROM = $_SESSION["INFO_EMAIL"];

                                    $BCC = "";

                                

                                    

                                }       

                            }



                            

                            $MAIL_BODY .= '<tr>';

                                $MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';

                                    $MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744 ';

                                    $MAIL_BODY .= 'Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>';

                                $MAIL_BODY .= '</td>';

                            $MAIL_BODY .= '</tr>';

                        $MAIL_BODY .= '</tbody>';

                    $MAIL_BODY .= '</table>';

                $MAIL_BODY .= '</td>';

            $MAIL_BODY .= '</tr>';

        $MAIL_BODY .= '</tbody>';

    $MAIL_BODY .= '</table>';

    

    $success = MailObject($to, $FROM, $CC="", $BCC="", $subject, $MAIL_BODY, $Attached_file,$FROM);

                                

    if($success == 1)

	{

	   return 1;

	}

	else

	{

		return 0;                

	}

    

    

}







function getMailFormat($TYP,$ID,$WAT="")

{

    global $dCON;

    

    //echo $TYP . "===" . $ID;

    

    if ( strtoupper(trim($TYP)) == "REGISTRATION" )

    {

        

        $rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id",$ID,'=', '', '' , "" );   

        

        if ( count($rsGET) > intval(0) )

        {

            $member_id = stripslashes($rsGET[0]["member_id"]);

            

            $reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);

            $reg_number = stripslashes($rsGET[0]["reg_number"]);

            $title = stripslashes($rsGET[0]["title"]);

            $first_name = stripslashes($rsGET[0]["first_name"]);

            $middle_name = stripslashes($rsGET[0]["middle_name"]);

            $last_name = stripslashes($rsGET[0]["last_name"]);

            $suffix = stripslashes($rsGET[0]["suffix"]);            

            $name = $title." ".$first_name;

            if($middle_name !='')

            {

                $name = $name." ".$middle_name;

            }

            $name = $name." ".$last_name;

            $name = ucwords(strtolower($name));

            

            $firm_name = stripslashes($rsGET[0]["firm_name"]);

            $address = stripslashes($rsGET[0]["address"]);

            $correspondence_address_2 = stripslashes($rsGET[0]["correspondence_address_2"]);

            $city = stripslashes($rsGET[0]["city"]);

            $correspondence_state = stripslashes($rsGET[0]["correspondence_state"]);

            $country = stripslashes($rsGET[0]["country"]);

            $pin = stripslashes($rsGET[0]["pin"]);

            

            $permanent_address = stripslashes($rsGET[0]["permanent_address"]);

            $permanent_address_2 = stripslashes($rsGET[0]["permanent_address_2"]);

            $permanent_city = stripslashes($rsGET[0]["permanent_city"]); 

            $permanent_state = stripslashes($rsGET[0]["permanent_state"]);

            $permanent_country = stripslashes($rsGET[0]["permanent_country"]);

            $permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);

            

            $full_address = $address . ", ".$correspondence_address_2;

            $full_address = $full_address .", ".$city;

            $full_address = $full_address .", ".$correspondence_state;

            $full_address = $full_address .", ".$country;

            if($pin !='')

            {

                $full_address = $full_address ." - ".$pin;

            }

            

            

            $permanent_full_address = $permanent_address.", ".$permanent_address_2;

            $permanent_full_address = $permanent_full_address .", ".$permanent_city;

            $permanent_full_address = $permanent_full_address .", ".$permanent_state;

            $permanent_full_address = $permanent_full_address .", ".$permanent_country;

            if($permanent_pin !='')

            {

                $permanent_full_address = $permanent_full_address ." - ".$permanent_pin;

            }

            

            

            

            $telephone = stripslashes($rsGET[0]["telephone"]);

            if($telephone !='')

            {

                $telephone = 'T. '.$telephone;

            } 

            

            $residence_telephone = stripslashes($rsGET[0]["residence_telephone"]);

            if($residence_telephone !='')

            {

                $residence_telephone = 'Residence T. '.$residence_telephone;

            }

            

            $fax = stripslashes($rsGET[0]["fax"]);

            if($residence_telephone !='')

            {

                $fax = 'F. '.$fax;

            }

            

            $mobile = stripslashes($rsGET[0]["mobile"]);

            if($mobile !='')

            {

                $mobile = ' M. '.$mobile;

            }

            else

            {

                $mobile = '';

            }

            

            

            $email = stripslashes($rsGET[0]["email"]);

            $password = stripslashes($rsGET[0]["password"]);

            

            $i_am = stripslashes($rsGET[0]["i_am"]);

            

            $other_i_am = stripslashes($rsGET[0]["other_i_am"]);

            if($other_i_am !='')

            {

                $i_am = $i_am.", ".$other_i_am;

            }

            

            $insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);

            $insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);

            $insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);

            $registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);

            $registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);

            $young_practitioner = stripslashes($rsGET[0]["young_practitioner"]);

            $young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);

            $interested = stripslashes($rsGET[0]["interested"]);

            $terms = stripslashes($rsGET[0]["terms"]);

            $committed = stripslashes($rsGET[0]["committed"]);

            $payment_text = stripslashes($rsGET[0]["payment_text"]);

            $payment_status = stripslashes($rsGET[0]["payment_status"]);

            $register_status = strtolower(stripslashes($rsGET[0]["register_status"]));

            $sig_member = intval(stripslashes($rsGET[0]["sig_member"]));

            $sig_company_name = stripslashes($rsGET[0]["sig_company_name"]);

            

            

            $mMAIL = '';    

            $mMAIL .= '

            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                <tbody>

                    <tr>

                        <td>

                            <table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">

                              <tbody>

                                    <tr>

                                        <td style="border-bottom: 4px solid #ED1C24;"><img src="'.SITE_IMAGES.'mail-logo.png" alt=""/></td>

                                    </tr>

                                    <tr>

                                        <td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Following user submitted the membership form</td>

                                    </tr>

                                    <tr>

                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 14px;">

                                        <h1 style="color: #2E3192; font-size:16px; margin-bottom: 5px;">'.$name.'</h1>';

                                        

                                        if($reg_number_text !='')

                                        {

                                            $mMAIL .= '<div style="color: #79B900; font-size:16px; margin-bottom: 5px;">'.$reg_number_text.'</div>';

                                        }

                                        else if($reg_number_text !='')

                                        {

                                            $mMAIL .= '<div style="color: #79B900; font-size:16px; margin-bottom: 5px;">'.$reg_number_text_temp.'</div>';

                                        }

                                        if($suffix != "")

                                        {

                                            $mMAIL .= 'Suffix : '.$suffix.'<br>';

                                        }

                                        

                                        $mMAIL .= 'Correspondence Address : '.$full_address.'<br>';

                                        $mMAIL .= 'Permanent Address : '.$permanent_full_address.'<br><br>

                                        '.$telephone.' '.$residence_telephone.' '.$fax.' '.$mobile.' | E. '.$email.'<br><br>

                                        

                                            <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                            Firm : <strong style="color: #ED1C24;">'.$firm_name.'</strong>

                                            </div>

                                            

                                            <div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                            I am <strong style="color: #ED1C24;">'.$i_am.'</strong>

                                            </div>';

                                            if(intval($insolvency_professional)==1 || $insolvency_professional_agency !='')

                                            {

                                                $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                                I am Insolvency Professional registered with <strong style="color: #ED1C24;">'.$insolvency_professional_agency.'</strong> My registration number is <strong style="color: #ED1C24;">'.$insolvency_professional_number.'</strong>.

                                                </div>';

                                            }

                                            if(intval($registered_insolvency_professional)==1 || $registered_insolvency_professional_number !='')

                                            {

                                                $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                                I am registered Insolvency Professional with Insolvency and Bankruptcy Board of India : <strong style="color: #ED1C24;">Yes</strong> <br>

                                                My registration number : <strong style="color: #ED1C24;">'.$registered_insolvency_professional_number.'</strong>.

                                                </div>';

                                            }

                                            

                                            if(intval($young_practitioner)==1 || $young_practitioner_enrolment !='')

                                            {

                                                $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                                I am a Young Practitioner. I confirm I have less than ten years experience in my profession mentioned in column 1 : <strong style="color: #ED1C24;">Yes</strong> <br>

                                                 My date of enrolment with my professional body : <strong style="color: #ED1C24;">'.$young_practitioner_enrolment.'</strong>.

                                                </div>';

                                            }

                                            

                                            if(intval($sig_member) == intval(1))

                                            {

                                                $mMAIL .= '<div style="padding: 15px 0; border-top: 1px solid #ccc;">			  

                                                I am an SIG 24 Member  : <strong style="color: #ED1C24;">Yes</strong> <br>

                                                SIG 24 Company Name : <strong style="color: #ED1C24;">'.$sig_company_name.'</strong>.

                                                </div>';

                                            }

                                            

                                            $mMAIL .= '<div style="padding: 15px 0 30px; border-top: 1px solid #ccc;">			  

                                            <strong> I am interested in becoming a member of INSOL India because</strong> <br>

                                            '.$interested.'

                                            </div>';

                                            

                                            //if($register_status =='pending')

                                            

                                            if ($payment_status != "SUCCESSFUL")

                                            {

                                                $mMAIL .= '<div style="text-align: center;" id="INPROCESS">';

                                                

                                                if($register_status !='approved')

                                                {

                                                    $mMAIL .= '<a href="'.SITE_URL.'cms/login.php?mid='.$member_id.'"><img src="'.SITE_IMAGES.'approve.png" alt=""/></a>&nbsp;&nbsp;';

                                                }

                                                

                                                $mMAIL .= '<a href="'.SITE_URL.'cms/login.php?mid='.$member_id.'"><img src="'.SITE_IMAGES.'decline.png" alt=""/></a>

                                                </div>

                                                <div id="INPROCESS_1" style="display: none;"></div>';

                                            }

                                            

                                        

                                        $mMAIL .= '</td>

                                    </tr>

                            	   <tr>

                            	       <td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">

                                		5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br>Contact No. 011 49785744 

                                		Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>

                      	             </td>

                            	   </tr>

                                </tbody>

                            </table>

                        </td>

                    </tr>

                </tbody>

            </table>';

             

            return $mMAIL;

              

        }       

            

    }          

  

}















function newsletterFormat($ID,$via = "", $person_name)

{

    global $dCON;

    

    $SQL  = "";

    $SQL .= " SELECT * FROM " . NEWSLETTER_TBL . " as A ";

    $SQL .= " WHERE status <> 'DELETE' ";

    $SQL .= " AND newsletter_id = :newsletter_id ";

    //echo "<BR>" . $SQL . "<BR>".$ID;

    //exit();

    $sGET = $dCON->prepare( $SQL );

    $sGET->bindParam(":newsletter_id", $ID);

    $sGET->execute();

    $rsGET = $sGET->fetchAll();

    $sGET->closeCursor();

     

    $volume_name = htmlentities(stripslashes($rsGET[0]['volume_name'])); 

    $newsletter_issue = htmlentities(stripslashes($rsGET[0]['newsletter_issue'])); 

    $newsletter_date = stripslashes($rsGET[0]['newsletter_date']);

    if(trim($newsletter_date) != "" && $newsletter_date != "0000-00-00")

    {

        $newsletter_date = date('M d, Y' , strtotime($newsletter_date));    

    }

    else

    {

        $newsletter_date = "";

    }

    

    $intro_content = stripslashes($rsGET[0]["intro_content"]);

    $editor_name = stripslashes($rsGET[0]["editor_name"]);

    $editor_image = stripslashes($rsGET[0]["editor_image"]);

    $editor_text = stripslashes($rsGET[0]["editor_text"]);

    //$editor_text = limit_words($editor_text, 75); 

  

    if($editor_image!= "")

    {

        //$ImageCt = intval(count($rsGET));

        $FOLDER_NAME_EDITOR = FLD_NEWSLETTER; 

        $FOLDER_PATH_EDITOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_EDITOR;  

        $chk_file_editor = chkImageExists($FOLDER_PATH_EDITOR."/".$editor_image);

        

        if(intval($chk_file_editor) == intval(1))

        {

            $display_image_editor = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_EDITOR."/R70-".$editor_image;

        }

        else

        {

            $display_image_editor = SITE_IMAGES."pick.jpg";

        }

    }   

    

    $president_name = stripslashes($rsGET[0]["president_name"]);

    $president_image = stripslashes($rsGET[0]["president_image"]);

    $president_text = stripslashes($rsGET[0]["president_text"]);

    // $president_text = limit_words($president_text, 100000); 

    

    if($president_image !="")

    {  

        $FOLDER_NAME_PRESIDENT = FLD_NEWSLETTER; 

        $FOLDER_PATH_PRESIDENT = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_PRESIDENT;  

        

        $president_id= intval(0);

        $chk_file_president = chkImageExists($FOLDER_PATH_PRESIDENT."/".$president_image);

        if(intval($chk_file_president) == intval(1))

        {

            $display_image_president = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_PRESIDENT."/R70-".$president_image;

        }

        else

        {

            $display_image_president = SITE_IMAGES."pick.jpg";

        }

    }

    

    //$newsletter_sponsor_id = stripslashes($rs[0]["newsletter_sponsor_id"]);

    //$newsletter_sig24_id = stripslashes($rs[0]["newsletter_sig24_id"]);

    $disclaimer = stripslashes($rsGET[0]["disclaimer"]);

    $newsletter_status = stripslashes($rsGET[0]["newsletter_status"]);

    $newsletter_send_date = stripslashes($rsGET[0]["newsletter_send_date"]);

    $status = htmlentities(stripslashes($rsGET[0]['status']));   

    if($person_name != ""){

        $greetings = "Dear ";

        $seperator = ", ";

    }

    $mMAIL = "";    

    $mMAIL .= "



    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background: #eaeaea'>

        <tbody>

            <tr>

                <td bgcolor='#eaeaea' align='center'>

                    <div style='width:848px; max-width:848px; margin:0 auto'>

                        <table width='848' border='0' cellspacing='0' cellpadding='0' align='center' style='font-family: arial; border: 1px solid #EAEAEA;'>

                            <tbody>

                                <tr>

                                    <td style='line-height:0px;'><img src='".SITE_IMAGES."header.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                </tr>

                                <tr>

                                    <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; font-size: 16px; padding: 25px;'>".$intro_content."</td>

                                </tr>

                                <tr>

                                    <td valign='top' bgcolor='#ffffff' style='background: #ffffff; padding: 20px 25px 10px;'>



                                    <h1 bgcolor='#fff' style='font-weight: bold; font-size: 20px; margin:0px; padding:0px;'>".$greetings;$mMAIL .= $person_name . $seperator . "<br><br>Welcome to INSOL India Newsletter Volume ".$volume_name.", Issue ".$newsletter_issue." | ".$newsletter_date."</h1></td>

                                </tr>

                    			<tr>

                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 0 0 12px 12px;'>

                                        <table width='836' border='0' cellspacing='0' cellpadding='0'>

                    				        <tbody>

                                            <tr>

                                                <td width='300' valign='top'>	

                                                    <div style='width:300px; max-width:300px; margin:0 auto;'>

                                                        <div style='clear: both; width:300px; max-width:300px; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:block; line-height:0px;' alt=''/></div>";

            				  	                    if($editor_text !="" )

                                                    {

                                                        $mMAIL .= "<table width='296' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; width:296px; font-family: arial;'>

                                                            <tbody>

                                                                <tr>

                                                                    <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>Editor's Message</td>

                                                                </tr>

                                                                <tr>

                                                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>

                                                                        <table width='256' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; width:256px;'>

                                                                            <tbody>";

                                                                            

                                                                                if( trim($editor_name) !="" )

                                                                                {

                                                                                    $mMAIL .= "<tr>

                                                                                        <td style='font-size: 14px; color: #333;font-weight: bold;padding-bottom:10px'>

                                                                                            ".$editor_name."

                                                                                        </td>

                                                                                    </tr>";

                                                                                }   

                                                                                

                                                                                $mMAIL .= "<tr>";

                                                                                    $mMAIL .= "<td style='font-size: 12px; color: #333;'>

                                                                                        ".$editor_text."

                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                        <div style='clear: both; width:300px; max-width:300px; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:block; line-height:0px;' alt=''/></div>";

                    					  	        }

                                                    

                                                    if($president_text !="")

                                                    {

                                                        $mMAIL .= "<table width='296' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; width:296px; font-family: arial;'>

                                                            <tbody>

                                                                <tr>

                                                                    <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>President's Message</td>

                                                                </tr>

                                                                <tr>

                                                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>

                                                                        <table width='256' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; width:256px;'>

                                                                            <tbody>";

                                                                            

                                                                                if( trim($president_name) !="" )

                                                                                {

                                                                                    $mMAIL .= "<tr>

                                                                                        <td style='font-size: 14px; color: #333;font-weight: bold;padding-bottom:10px'>

                                                                                            ".$president_name."

                                                                                        </td>

                                                                                    </tr>";

                                                                                }   

                                                                                

                                                                                $mMAIL .= "<tr>";

                                                                                

                                                                                $mMAIL .= "<tr>";

                                                                                    

                                                                                    $mMAIL .= "<td style='font-size: 12px; color: #333;'>

                                                                                        ".$president_text."

                                                                                    </td>

                                                                                </tr>

                                                                            </tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                                                        <div style='clear: both; width:300px; max-width:300px; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:block; line-height:0px;' alt=''/></div>";

                    					  	        }

                                                    

                                                    $SQL  = "";

                                                    $SQL .= " SELECT * FROM " . NEWSLETTER_SPONSOR_TBL . " as A WHERE status = 'ACTIVE' ORDER BY position";

                                                    $stmt = $dCON->prepare( $SQL );

                                                    $stmt->execute();

                                                    $rowSP = $stmt->fetchAll();

                                                    $stmt->closeCursor();

                                                    

                                                    if(count($rowSP) > 0)

                                                    {

                                                        $mMAIL .= "<table width='296' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; width:296px; font-family: arial;'>

                                                            <tbody>

                                                                <tr>

                                                                    <td bgcolor='#696969' style='background: #696969; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>This edition is sponsored by</td>

                                                                </tr>

                                                                <tr>

                                                                    <td bgcolor='#ffffff' align='center' style='background: #ffffff; text-align:center; padding: 15px 12px;'><div style='width:274px; max-width:274px;'>";

                                                                            $s=1;

                                                                            foreach($rowSP as $rsSP)

                                                                            {

                                                                                $company_name = "";

                                                                                $url = "";

                                                                                $sponsor_url = "";

                                                                                $sponsor_url_end = "";

                                                                                $image_name = "";

                                                                                $display_image_sponsor ="";

                                                                                 

                                                                                $company_name = stripslashes($rsSP['company_name']);

                                                                                $url = str_replace("http://","",stripslashes($rsSP['url'])) ;

                                                                                

                                                                                if($url !="")

                                                                                {

                                                                                   $sponsor_url = "<a href='http://".$url."' target='_blank'>";

                                                                                   $sponsor_url_end = "</a>";

                                                                                }

                                                                                

                                                                                $image_name = stripslashes($rsSP['image_name']);

                                                                                

                                                                                $FOLDER_NAME_SPONSOR = FLD_NEWSLETTER_SPONSOR; 

                                                                                $FOLDER_PATH_SPONSOR = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME_SPONSOR;  

                                                                                

                                                                                $chk_file_sponsor = chkImageExists($FOLDER_PATH_SPONSOR."/R100-".$image_name);

                                                                                if(intval($chk_file_sponsor) == intval(1))

                                                                                {

                                                                                    $display_image_sponsor = SITE_UPLOAD_ABSOLUTE_ROOT.$FOLDER_NAME_SPONSOR."/R100-".$image_name;

                                                                                    

                                                                                    $mMAIL .= "".$sponsor_url."<img src='".$display_image_sponsor."' width='80' style='width:80px; max-width:80px; padding: 10px; display:inline-block;' alt='".$company_name."'/>".$sponsor_url_end."";

                                                                                    if(intval($s) < count($rowSP))

                                                                                    {

                                                                                        $mMAIL .= "";

                                                                                    }

                                                                                }

                                                                                $s++;

                                                                            }     

                                                                                

                                                                            

                                                                        $mMAIL .= "

                                                                    </div></td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

                        								

                                                        <div style='clear: both; width:300px; max-width:300px; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:block; line-height:0px;' alt=''/></div>";

                                                    }

                                                    

                                                    $SQL  = "";

                                                    $SQL .= " SELECT * FROM " . SIG24_TBL . " as A WHERE status = 'ACTIVE' ORDER BY position";

                                                    $stmtSIG = $dCON->prepare( $SQL );

                                                    $stmtSIG->execute();

                                                    $rowSIG = $stmtSIG->fetchAll();

                                                    $stmtSIG->closeCursor();

                                                    

                                                    if(count($rowSIG) > 0)

                                                    {

                                                       

                                                        $mMAIL .= "<table width='296' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; width:296px; font-family: arial;'>

                                                            <tbody>

                                                                <tr>

                                                                    <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>SIG 24</td>

                                                                </tr>

                                                                <tr>

                                                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>

                                                                        <table width='256' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size:12px; width:256px; color: #666;'>

                                                                            <tbody>";

                                                                            $a=1;

                                                                            foreach($rowSIG as $rsSIG)

                                                                            {

                                                                                $SIGurl = "";

                                                                                $sig_url = "";

                                                                                $sig_url_end = "";

                                                                               

                                                                                //$SIGurl = str_replace("http://","",stripslashes($rsSIG['url']));

                                                                                $SIGurl = stripslashes($rsSIG['url']);

                                                                                if($SIGurl !="")

                                                                                {

                                                                                    //$sig_url = "<a href='http://".$SIGurl."' target='_blank' style='font-family: arial; font-size:12px; color: #666;'>";

                                                                                    $sig_url = "<a href='".$SIGurl."' target='_blank' style='font-family: arial; font-size:12px; color: #000;font-weight:bold'>";

                                                                                    $sig_url_end = "</a>";

                                                                                }

                                                                                

                                                                                

                                                                                $mMAIL .= "<tr>

                                                                                    <td width='14' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."arrow.jpg' width='14' height='9' style='display: block; line-height: 0px;' alt=''/></td>

                                                                                    <td>".$sig_url.$rsSIG['company_name'].$sig_url_end."</td>

                                                                                </tr>";

                                                                                if($a < count($rowSIG))

                                                                                {

                                                                                    $mMAIL .= "<tr>

                                                									   <td style='line-height: 0px;'><img src='".SITE_IMAGES."10.jpg' width='10' height='10' style='display: block; line-height: 0px;' alt=''/></td>

                                                									   <td style='line-height: 0px;'><img src='".SITE_IMAGES."10.jpg' width='10' height='10' style='display: block; line-height: 0px;' alt=''/></td>

                                                									</tr>";

                                                                                }

                                                                                

                                                                                $a++;

                                                                            }

                                                                            $mMAIL .= "</tbody>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>

    													

    													

                                                        <div style='clear: both; width:300px; max-width:300px; height: 12px; line-height: 0px;'><img src='".SITE_IMAGES."12.jpg' style='display:block; line-height:0px;' alt=''/></div>

    													

    													<table width='296' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; width:296px; font-family: arial;'>

                                                            <tbody>

                                                                <tr>

                                                                    <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; padding: 12px 20px; font-weight: bold; font-size:16px;'>E-Newsletter Editorial Board</td>

                                                                </tr>

                                                                <tr>

                                                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 20px;'>

                                                                        <table width='256' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size:12px; width:256px; color: #666;'>

                                                                            <tr>

    																			<td style='border-bottom:1px solid #ccc; padding-bottom:15px;'>

    																				Editorial Team<br>

    																				<strong><a href='http://insolindia.com/governance/e-newsletter-editorial-board/divyanshu-pandey' target='_blank' style='font-family: arial; color: #000;'>Divyanshu Pandey</a></strong><br>

    																				Partner, J. Sagar Associates

    																			</td>

    																		</tr>

    																		 <tr>

    																			<td style='border-bottom:1px solid #ccc; padding-bottom:15px; padding-top:15px;'>

    																				Editorial Team<br>

    																				<strong><a href='http://insolindia.com/governance/e-newsletter-editorial-board/ashish-chhawchharia' target='_blank' style='font-family: arial; color: #000;'>Ashish Chhawchharia</a></strong><br>

    																				Partner - Advisory, Head - Restructuring Services, Grant Thornton Advisory Pvt Ltd

    																			</td>

    																		</tr>

    																		 <tr>

    																			<td style='border-bottom:1px solid #ccc;padding-top:15px;padding-bottom:15px;'>

    																				Editorial Team<br>

    																				<strong><a href='http://insolindia.com/governance/e-newsletter-editorial-board/anju-agarwal' target='_blank' style='font-family: arial; color: #000;'>Anju Agarwal</a></strong><br>

    																				Director, ASC Consulting Pvt. Ltd.

    																			</td>

    																		</tr>
    																		
    																		<tr>

    																			<td style='padding-top:15px;'>

    																				Editorial Team<br>

    																				<strong><a href='http://insolindia.com/governance/e-newsletter-editorial-board/ashwin-bishnoi' target='_blank' style='font-family: arial; color: #000;'>Ashwin Bishnoi</a></strong><br>

    																				Partner, Khaitan & Co.

    																			</td>

    																		</tr>

                                                                        </table>

                                                                    </td>

                                                                </tr>

                                                            </tbody>

                                                        </table>";

    													

    													

                                                    }

                                                    

                                                $mMAIL .= "</div>

                                                </td>

                                                <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                <td valign='top'>

                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0'>

                                                        <tbody>

                                                        

                                                        <tr>

                                                            <td style='padding: 12px 12px 0 0;'>";

                                                                

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

                                                                

                                                                

                                                                if(count($rowEvent) >intval(0))

                                                                {

                                                                

                                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>

                                                                        <tbody>

                                                                            <tr>

                                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 17px;'>

                                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>

                                                                                        <tbody>

                                                                                        <tr>

                                                                                            <td colspan='3' style='font-weight: bold; font-size: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;'>Upcoming Events and Activities</td>

                                                                                        </tr>

                                                                                        <tr>

                                                                                            <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                        </tr>";

                                                                                        

                                                                                        foreach($rowEvent as $rEvent)

                                                                                        {

                                                                                            

                                                                                            $eventNAME = "";

                                                                                            $eventFDATE = "";

                                                                                            $eventTDATE = "";

                                                                                            $eventVenue = "";

                                                                                            $eventDetailURL = "";

                                                                                            

                                                                                            $eventNAME = htmlentities(stripslashes($rEvent['event_name']));

                                                                                            $eventFDATE = (stripslashes($rEvent['event_from_date']));

                                                                                            $eventTDATE = (stripslashes($rEvent['event_to_date']));

                                                                                            //$eventIMG = stripslashes($rEvent['image_name']);

                                                                                            //$eventSDESC = stripslashes($rEvent["event_short_description"]); 

                                                                                            $eventVenue = (stripslashes($rEvent['event_venue']));

                                                                                             

                                                                                            $eventDetailURL = SITE_URL . urlRewrite("event-detail.php", array("url_key" => stripslashes($rEvent['url_key'])));

                                                                                          

                                                                                            $mMAIL .= "<tr>

                                                                                                <td width='64' align='center';>

    																							

    																								<table width='100%' border='0' cellspacing='0' cellpadding='0'>

    																								  <tbody>

    																									<tr>

    																									  <td style='background: #696969; padding: 4px; color: #ffffff; text-align: center; font-size: 18px;'>".date("jS", strtotime($eventFDATE))."</td>

    																									</tr>

    																									<tr>

    																									  <td style='background: #e3e3e3; padding: 2px; color: #000; text-align: center; text-transform: uppercase; font-size: 10px;'>".date("F, Y", strtotime($eventFDATE))."</td>

    																									</tr>

    																									<tr>

    																									  <td align='center' style='background: #ffffff; line-height: 0; text-align: center;'><img src='".SITE_IMAGES."dateimg.jpg' style='display: inline-block; line-height: 0px;' alt=''/></td>

    																									</tr>

    																								  </tbody>

    																								</table>

    																							

                                                                                                </td>

                                                                                                <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                                <td valign='top' style='font-size: 12px; color: #666; padding: 8px 0 0;'>

                                                                                                    <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$eventDetailURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".$eventNAME."</a></div>

                                                                                                    <p style='margin: 0;'>Venue: ".$eventVenue."</p>

                                                                                                    

                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr>

                                                                                                <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                            </tr>";

                                                                                        }

                                                                                        

                                                                                        

                                                                                        $mMAIL .= "<tr>

                                                                                            <td colspan='3' style='font-size: 11px; border-top: 1px solid #ccc; padding-top: 15px;'><a href='".SITE_URL . urlRewrite("events.php")."' style='color:#000; text-decoration: none;' target='_blank'>View all events</a></td>

                                                                                        </tr>

                                                                                        

                                                                                        </tbody>

                                                                                    </table>

                                                                                </td>

                                                                            </tr>

                                                                        </tbody>

                                                                    </table>							  	

                                                                    <div style='clear: both; height: 20px; line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";

                                                                }

                                                                

                                                                $QRY = "";

                                                                $QRY .= " SELECT E.* FROM " . NEWS_TBL . " as E inner join " . NEWSLETTER_NEWS_TBL . " as N ";

                                                                $QRY .= " on E.news_id = N.news_id ";

                                                                $QRY .= " WHERE E.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY E.news_date DESC ";

                                                                //echo $QRY;

                                                                $sNews = $dCON->prepare( $QRY );

                                                                $sNews->bindParam(":newsletter_id",$ID);

                                                                $sNews->execute();

                                                                $rowNews = $sNews->fetchAll();

                                                                $sNews->closeCursor();

                                                                if (intval(count($rowNews)) > intval(0) )

                                                                {

                                                             

                                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>

                                                                        <tbody>

                                                                            <tr>

                                                                                <td colspan='3' style='font-weight: bold; font-size: 20px;'>Headlines</td>

                                                                            </tr>

                                                                            <tr>

                                                                                <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                            </tr>";

                                                                            

                                                                            foreach($rowNews as $rsNews)

                                                                            {

                                                                                $newsURL = "";

                                                                                $newsImage = "";;   

                                                                                $news_content = "";;   

                                                                                $DISPLAY_NEWS_IMG = "";;   

                                                                                

                                                                                $newsURL = SITE_URL . urlRewrite("news-details.php", array("url_key" => stripslashes($rsNews['url_key'])));

                                                                                $newsImage = $rsNews['image_name'];   

                                                                                

                                                                                if(chkImageExists(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_NEWS  .'/'. $newsImage) == intval(1))

                                                                                {

                                                                                    $DISPLAY_NEWS_IMG = SITE_UPLOAD_ABSOLUTE_ROOT . FLD_NEWS  .'/'. $newsImage;

                                                                                }

                                                                                else

                                                                                {

                                                                                    $DISPLAY_NEWS_IMG =  SITE_IMAGES . 'noimage_news.jpg';

                                                                                }

                                                                                

                                                                                                                                                       

                                                                                $news_content = trustme($rsNews['news_content']);

                                                                                

                                                                                $mMAIL .= "<tr>

                                                                                    

                                                                                    <td width='172' valign='top' style='line-height: 0px;'>

                                                                                        <img src='".$DISPLAY_NEWS_IMG."' width='172' style='display:block; max-width:172px; width: 172px; line-height:0px;' alt='' />

                                                                                    </td>

                                                                                    

                                                                                    <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                    <td valign='top' style='font-size: 12px; color: #666; padding: 2px 0 0;'>

                                                                                        <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$newsURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".$rsNews['news_title']."</a></div>

                                                                                        <p style='margin: 0;'>

                                                                                        ".limit_char($news_content, 200)." ";

                                                                                

                                                                                        //if( intval(str_word_count($news_content)) > intval(40))

                                                                                        if( intval(strlen($news_content)) > intval(200))

                                                                                        {

                                                                                            $mMAIL .= "<a href='".$newsURL."' style='color:#4ABEA3; text-decoration: none;' target='_blank'>read more</a>";

                                                                                        }

                                                                                        

                                                                                        $mMAIL .= "</p>

                                                                                        

                                                                                   </td>

                                                                                </tr>

                                                                                <tr>

                                                                                    <td colspan='3' width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                </tr>";

                                                                            }

                                                                            

                                                                            

                                                                        $mMAIL .= "</tbody>

                                                                    </table>						  	

                                                                    <div style='clear: both; height: 20px; line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></div>";

                                                                }

                                                                

                                                                $QRY = "";

                                                                $QRY .= " SELECT R.*,(select url_key from " . RESOURCES_CATEGORY_TBL . " as C where R.category_id = C.category_id ) as cat_url_key FROM " . RESOURCES_TBL . " as R inner join " . NEWSLETTER_RESOURCES_TBL . " as N ";

                                                                $QRY .= " on R.resources_id = N.resources_id ";

                                                                $QRY .= " WHERE R.status='ACTIVE' and N.newsletter_id = :newsletter_id ORDER BY R.resources_from_date desc";

                                                                //echo $QRY;

                                                                $sResources = $dCON->prepare( $QRY );

                                                                $sResources->bindParam(":newsletter_id",$ID);

                                                                $sResources->execute();

                                                                $rowResources = $sResources->fetchAll();

                                                                $sResources->closeCursor();

                                                                if (intval(count($rowResources)) > intval(0) )

                                                                {

                                                                

                                                                    $mMAIL .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='border: 1px solid #ccc; font-family: arial;'>

                                                                        <tbody>

                                                                            <tr>

                                                                                <td bgcolor='#ffffff' style='background: #ffffff; padding: 17px;'>

                                                                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial;'>

                                                                                    <tbody>

                                                                                        <tr>

                                                                                            <td style='font-weight: bold; font-size: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px;'>Articles</td>

                                                                                        </tr>

                                                                                        <tr>

                                                                                            <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                        </tr>";

                                                                                        foreach($rowResources as $rsResources)

                                                                                        {

                                                                                            $resourcesPUBLISHER = "";

                                                                                            $resourcesSDESC = "";

                                                                                            $cat_url_key = "";

                                                                                            $resourcesURL = "";

                                                                                            

                                                                                            $resourcesPUBLISHER = htmlentities(stripslashes($rsResources['resources_publisher']));

                                                                                            $resourcesSDESC = stripslashes($rsResources["resources_short_description"]); 

                                                                                            $cat_url_key = stripslashes($rsResources["cat_url_key"]); 

                                                                                            

                                                                                            $resourcesURL = SITE_URL .urlRewrite("login.php").$_SESSION['INCLUDE_QMARK']."ref=resources&ckey=".$cat_url_key;

                                                                                            

                                                                                            $mMAIL .= "<tr>												  

                                                                                                <td valign='top' style='font-size: 12px; color: #666; padding: 8px 0 0;'>

                                                                                                    <div style='font-size: 16px; font-weight: bold; color: #4FB99A;'><a href='".$resourcesURL."' style='color:#4FB99A; text-decoration: none;' target='_blank'>".stripslashes($rsResources['resources_name'])."</a></div>";

                                                                                                    if($resourcesPUBLISHER !='')

                                                                                                    {

                                                                                                        $mMAIL .= "<p style='margin: 0; font-size: 11px; color: #000;'>By ".$resourcesPUBLISHER."</p>";

                                                                                                    }

                                                                                                    $mMAIL .= "<p style='margin-bottom: 0px;'>".limit_char(trustme($resourcesSDESC), 250)."</p>

                                                                                                </td>

                                                                                            </tr>

                                                                                            <tr>

                                                                                                <td width='20px' valign='top' style='line-height: 0px;'><img src='".SITE_IMAGES."20.jpg' style='display:inline-block; line-height:0px;' alt=''/></td>

                                                                                            </tr>";

                                                                                        }

                                                                                        

                                                                                        

                                                                                        $mMAIL .= "<tr>

                                                                                            <td style='font-size: 11px; border-top: 1px solid #ccc; padding-top: 15px;'><a href='".SITE_URL . urlRewrite("resources.php", array("cat_url_key" => $cat_url_key))."' style='color:#000; text-decoration: none;' target='_blank'>View all articles</a></td>

                                                                                        </tr>

                                                                                    </tbody>

                                                                                    </table>

                                                                                </td>

                                                                            </tr>

                                                                        </tbody>

                                                                    </table>";

                                                                }

                                                                

                                                             $mMAIL .= "</td>

                                                        </tr>

                                                        </tbody>

                                                    </table>

                                                </td>

                                            </tr>

                    				    </tbody>

                        				</table>

                                    </td>

                        		</tr>

                    			<tr>

                                    <td bgcolor='#d9d9d9' style='background: #d9d9d9; padding: 25px; color: #666; font-size: 11px;'>

                    				    <div style='font-size: 12px; color: #000000;'>DISCLAIMER</div><br>

                    				    ".$disclaimer."

                                    </td>

                                </tr>

                                <tr>

                                    <td bgcolor='#ffffff' style='background: #ffffff; padding: 25px; color: #000; font-size: 11px;'>

                                        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>

                                            <tbody>

                                                <tr>

                                                    <td valign='top'>

                                                        <a href='http://insolindia.com/contribute-newsletter.php' target='_blank' style='color: #49BEA3; border:1px solid #49BEA3; text-transform:uppercase; padding:8px 15px; display:inline-block; margin-bottom:6px; text-decoration: none; font-weight: bold; font-size:11px;'>Contribute to newsletter</a><br><br>

                                                        5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. 

                                                    <table border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>

                                                            <tr>

                                                                <td valign='middle' width='15px' align='left'><img src='http://insolindia.com/includes_insol/images/cms-icon/phone_icon.png' style='line-height:0px;' /></td>

                                                                <td valign='middle' style='border-right:1px solid #ccc; padding-right:5px;'>011 49785744</td>

                                                                <td valign='middle' align='left' style='padding-left:5px; padding-right:5px;'><img src='http://insolindia.com/includes_insol/images/cms-icon/mail_icon.png' style='line-height:0px;' /></td>

                                                                <td valign='middle' style='border-right:1px solid #ccc; padding-right:5px;'><a href='mailto:contact@insolindia.com' target='_blank' style='color: #000000; text-decoration: none;'>contact@insolindia.com</a></td>

                                                                <td valign='middle' align='left' style='padding-left:5px; padding-right:5px;'><img src='http://insolindia.com/includes_insol/images/cms-icon/globe.png' style='line-height:0px;' /></td>

                                                                <td valign='middle'><a href='http://www.insolindia.com' style='color: #000000; text-decoration: none;' target='_blank'>www.insolindia.com</a></td>

                                                            </tr>

                                                        </table>

                                                    </td>

                                                    <td align='right' style='text-align: right;' valign='top'>";

                                                    



                                                    if($via!='NEWSLETTER')

                                                    {

                                                        $mMAIL .= "

                                                        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>

                                                            <tr>

                                                                

                                                               <td align='right' width='120' style='line-height: 0px; text-align: right;'>

                                                                    <a href='".SITE_URL."unsubscribe.php?id=%mid%&email=%memail%' style='color: #000000; text-decoration: none;' target='_blank'><img src='".SITE_IMAGES."unsubscribe.jpg' style='display: inline-block; line-height: 0px;' width='108' border='0' height='32' alt=''/></a>

                                                               </td>

                                                           </tr>

                                                           <tr>

                                                                <td style='padding-top: 15px;'>

                                                                    Having problems viewing this email?<br>

                                                                    <a href='".SITE_URL."newsletter/view.php?nid=".base64_encode(intval($ID))."' style='color: #000000; text-decoration: none;' target='_blank'>View it on our website</a>

                                                                </td>

                                                           </tr>

                                                       </table>";

                                                    }

                                                $mMAIL .= "

                                                </td></tr>

                                            </tbody>

                                        </table>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </td>

            </tr>

        </tbody>

    </table>";

    

    return $mMAIL;

     

}





function generaluploadFormat($ID,$p_name)

{

    global $dCON;

    if($p_name == "NO" || $p_name == ""){

        $p_name = "";

        $greetings = "";

    }else{

        $greetings = "Dear ";

    }

    $SQL  = "";

    $SQL .= " SELECT * FROM " . GENERAL_UPLOAD_TBL . " as A ";

    $SQL .= " WHERE status <> 'DELETE' ";

    $SQL .= " AND upload_id = :upload_id ";

    //echo "<BR>" . $SQL . "<BR>".$ID;

    //exit();

    $sGET = $dCON->prepare( $SQL );

    $sGET->bindParam(":upload_id", $ID);

    $sGET->execute();

    $rsGET = $sGET->fetchAll();

    $sGET->closeCursor();

     

    $reference = htmlentities(stripslashes($rsGET[0]['reference'])); 

    $brief_description = stripslashes($rsGET[0]['brief_description']); 

   /* $upload_date = stripslashes($rsGET[0]['upload_date']);

    if(trim($upload_date) != "" && $upload_date != "0000-00-00")

    {

        $upload_date = date('M d, Y' , strtotime($upload_date));    

    }

    else

    {

        $upload_date = "";

    }

    

   */

   //for intro content ========================= 

   

   $intro_content = getDetails(NEWSLETTER_INTRO_TBL, 'intro_content', 'intro_id','1001','=', '', '','');

  

    $status = htmlentities(stripslashes($rsGET[0]['status']));   



    $mMAIL = "";    

    $mMAIL .= "

    <style type='text/css' media='screen'>

        .newletterContent img{width:100% !important; height:auto !important;}

    </style>

    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background: #eaeaea'>

        <tbody>

            <tr>

                <td bgcolor='#eaeaea' align='center'>
                    <table  width='848' border='0' cellspacing='0' cellpadding='0' align='center' style='font-family: arial; border: 1px solid #EAEAEA;'>

                        <tbody>

                            <tr>

                                <td style='line-height:0px;'><img src='".SITE_IMAGES."header.jpg' style='width:100%;display:inline-block; line-height:0px;' alt=''/></td>

                            </tr>

                            <tr>

                                <td bgcolor='#4abea3' style='background: #4abea3; color: #ffffff; font-size: 0px; padding: 6px 25px; font-weight:bold;'>&nbsp;</td>

                            </tr>

                            <tr>

                                <td valign='top' bgcolor='#fff' style='padding: 20px 25px;'>



                                <h1 bgcolor='#fff' style='font-weight: bold; font-size: 20px; margin:0px; padding:0px;'>".$greetings; $mMAIL .= $p_name . "</h1></td>

                            </tr>

                            <tr>

                                <td valign='top' class='newletterContent' bgcolor='#fff' style='padding: 0px 25px;'>



                                ";$mMAIL .= $brief_description. "</td>

                            </tr>

                			

                            <tr>

                                <td bgcolor='#ffffff' style='background: #d9d9d9; padding: 25px; color: #000; font-size: 11px;'>

                                    <table width='100%' border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;'>

                                        <tbody>

                                            <tr>

                                                <td>

                                                    5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. 

                                                    <table border='0' cellspacing='0' cellpadding='0' style='font-family: arial; font-size: 11px;' id='foot_icon'>

                                                            <tr>

                                                                <td valign='middle' width='15px' align='left'><img src='http://insolindia.com/includes_insol/images/cms-icon/phone_icon.png' style='line-height:0px;' /></td>

                                                                <td valign='middle' style='border-right:1px solid #ccc; padding-right:5px;'>011 49785744</td>

                                                                <td valign='middle' align='left' style='padding-left:5px; padding-right:5px;'><img src='http://insolindia.com/includes_insol/images/cms-icon/mail_icon.png' style='line-height:0px;' /></td>

                                                                <td valign='middle' style='border-right:1px solid #ccc; padding-right:5px;'><a href='mailto:contact@insolindia.com' target='_blank' style='color: #000000; text-decoration: none;'>contact@insolindia.com</a></td>

                                                                <td valign='middle' align='left' style='padding-left:5px; padding-right:5px;'><img src='http://insolindia.com/includes_insol/images/cms-icon/globe.png' style='line-height:0px;' /></td>

                                                                <td valign='middle'><a href='http://www.insolindia.com' style='color: #000000; text-decoration: none;' target='_blank'>www.insolindia.com</a></td>

                                                            </tr>

                                                        </table>

                                                </td>";

                                                

                                               /* if($via!='NEWSLETTER')

                                                {

                                                    $mMAIL .= "<td align='right' style='text-align: right;'>

                                                        Having problems viewing this email?<br>

                                                        <a href='".SITE_URL."newsletter/view.php?nid=".base64_encode(intval($ID))."' style='color: #000000; text-decoration: none;' target='_blank'>View it on our website</a>

                                                    </td>

                                                   <td align='right' width='120' style='line-height: 0px; text-align: right;'><a href='".SITE_URL."unsubscribe.php?id=%mid%&email=%memail%' style='color: #000000; text-decoration: none;' target='_blank'><img src='".SITE_IMAGES."unsubscribe.jpg' style='display: inline-block; line-height: 0px;' width='108' border='0' height='32' alt=''/></a></td>";

                                                } */

                                            $mMAIL .= "</tr>

                                        </tbody>

                                    </table>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </td>

            </tr>

        </tbody>

    </table>";

    

    return $mMAIL;

     

}

?>