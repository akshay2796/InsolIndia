<?php 
function matchTableName($str)
{
    
    $arr = array(
                "tbl_admin",
                "tbl_sitesetting",
                "tbl_domain",
                "tbl_restaurant"
                
                );
        
    
    foreach($arr as $tbl_name)
    {
    	if(stristr($str,$tbl_name))
    	{
    	    header("Location: admin/logout.php?msg=".urlencode("Unauthorized Request"));
    		exit;
    	}
     }
     
     return $str;
}


function trustme($var)
{
    $filter = new inputfilter("","",0,0,1);
    return matchTableName($filter->process(trim($var)));
}

function trustyou($var)
{
    return matchTableName(trim($var));
}

function trustHTML($var)
{
    $filter = new inputfilter(array("table", "div", "tr", "td", "th","ul","li","b","strong"),"",1,1,1);
    return matchTableName($filter->process(trim($var)));
}

function mres($value)
{
    $search = array("\x00", "\n", "\r", "\\", "'", "\"", "\x1a");
    $replace = array("\\x00", "\\n", "\\r", "\\\\" ,"\'", "\\\"", "\\\x1a");
    return str_replace($search, $replace, $value);
}

function lastInsertId($tbl,$field)
{
		global $db;
		$stmt = $db->prepare("select max($field) as maxid from $tbl");
		$stmt->execute();
		$row_reg = $stmt->fetch();
		return $row_reg['maxid'];
}


function _enc($s)
{
    for( $i = 0; $i < strlen($s); $i++ )
        $r[] = ord($s[$i]) + 2;
    return implode('.', $r);
}
 
function _dec($s)
{
    $s = explode(".", $s);
    for( $i = 0; $i < count($s); $i++ )
        $s[$i] = chr($s[$i] - 2);
    return implode('', $s);
}

function distance($lat1, $lon1, $lat2, $lon2, $unit) 
{

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}


$WeekDayNames = array(
        'monday', 
        'tuesday', 
        'wednesday', 
        'thursday', 
        'friday', 
        'saturday', 
        'sunday'
        
    );
    
$WeekDayNamesPlusONE = array(
        'tuesday', 
        'wednesday', 
        'thursday', 
        'friday', 
        'saturday', 
        'sunday'
        
    );
    

function encrypt($string) { 
    $encrypted = base64_encode($string);
    return $encrypted;
}
function decrypt($encrypted) { 
    $decrypted = base64_decode($encrypted);
    return $decrypted;
}


?>