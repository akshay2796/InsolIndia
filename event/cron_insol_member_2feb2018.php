<?php 
ini_set("max_execution_time", 600);
error_reporting(E_ALL);

include("library_insol/class.pdo.php");
include("library_insol/class.inputfilter.php");
include("library_insol/class.pagination.php");
include("library_insol/function.php");
include("library_insol/class.phpmailernew.php");
include("global_functions.php");


require_once MODULE_CMS_INCLUDE . 'Classes/PHPExcel.php';

$COMPANY_NAME = $_SESSION['COMPANY_NAME'];


$searchArr = array();
$RETURN_ARRAY = array();




$todaydate = date('Y-m-d');


$SQL2 = "";
$SQL2 .= " SELECT * FROM " . BECOME_MEMBER_TBL . "";   
$SQL2 .= " WHERE status <> 'DELETE' ";
$SQL2 .= " and register_status = 'Approved' ";
$SQL2 .= " and (payment_status = 'SUCCESSFUL' or sig_member = 1)";
$SQL2 .= " order by member_id desc ";
$stmt2 = $dCON->prepare($SQL2); 
$stmt2->execute();
$row = $stmt2->fetchAll();

        
$objPHPExcel = new PHPExcel();
// Set properties
$objPHPExcel->getProperties()->setCreator($COMPANY_NAME)
							 ->setLastModifiedBy($COMPANY_NAME)
							 ->setTitle($COMPANY_NAME)
							 ->setSubject($COMPANY_NAME)
							 ->setDescription($COMPANY_NAME)
							 ->setKeywords($COMPANY_NAME)
							 ->setCategory($COMPANY_NAME);

$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 


$ROW = 1;

$MAXCOL = "V";

$STATIC_COL =19;
 // BOLD ALL COLUMN HEADS ====================  
for($Z=1;$Z<=$STATIC_COL;$Z++)
{
    $ALP = getExcelNameFromNumber($Z);
    $objPHPExcel->getActiveSheet()->getColumnDimension($ALP)->setAutoSize(true);    
    
}


$objPHPExcel->getActiveSheet()->getStyle('D'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));



$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ROW,"Serial No.")
            ->setCellValue('B'.$ROW,"REGD ID")
            ->setCellValue('C'.$ROW,"TITLE")
            ->setCellValue('D'.$ROW,"FIRST")
            ->setCellValue('E'.$ROW,"MIDDLE")
            ->setCellValue('F'.$ROW,"LASTNAME")
            ->setCellValue('G'.$ROW,"SUFFIX")
            ->setCellValue('H'.$ROW,"FULL Name")
            ->setCellValue('I'.$ROW,"FIRM")
            ->setCellValue('J'.$ROW,"ADDRESS1")
            ->setCellValue('K'.$ROW,"ADDRESS2")
            ->setCellValue('L'.$ROW,"ADDRESS3")
            ->setCellValue('M'.$ROW,"ADDRESS4")
            ->setCellValue('N'.$ROW,"POSTALCITY")
            ->setCellValue('O'.$ROW,"CITY")
            ->setCellValue('P'.$ROW,"STATE")
            ->setCellValue('Q'.$ROW,"ZIP")
            ->setCellValue('R'.$ROW,"COUNTRY")
            ->setCellValue('S'.$ROW,"PHONE")
            ->setCellValue('T'.$ROW,"FAX")
            ->setCellValue('U'.$ROW,"PROF TYPE")
            ->setCellValue('V'.$ROW,"EMAIL");
            
         
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "d9e1e7")));
 
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);

$ROW++;
$ALL_TOTAL = 0;
$SRNO = 0;
foreach($row as $rs)
{  
    $SRNO++;
   
    $first_name = ""; 
    $middle_name = ""; 
    $last_name = ""; 
    $full_name = ""; 
    $reg_number = ""; 
    $mobile = ""; 
    $city = ""; 
    $telephone = ""; 
    $status = ""; 
    $payment_status = "";
    $register_status = "";
    $paid_amount = "";
    
    $TITLE = "";
    $SUFF = "";
    $address2 = "";
    $address3 = "";
    $address4 = "";
    $PROF_TYPE = "";
    $FAX = "";
    
    
    
    $reg_number_text = stripslashes($rs['reg_number_text']);                                             
    $reg_number = stripslashes($rs['reg_number']);   
    $first_name = stripslashes($rs["first_name"]);
    $middle_name = stripslashes($rs["middle_name"]);
    $last_name = stripslashes($rs["last_name"]);
    
    $full_name = $first_name;
    
    if($middle_name !='')
    {
        $full_name = $full_name." ".$middle_name;
    }
    if($last_name !='')
    {
        $full_name = $full_name." ".$last_name;
    }
    
    
    $email = stripslashes($rs['email']); 
    $mobile = stripslashes($rs['mobile']);
    $telephone= stripslashes($rs['telephone']);
    $address = stripslashes($rs["address"]);
    $city = stripslashes($rs["city"]);
    $STATE = '';
    $country = stripslashes($rs["country"]);
    $pin = stripslashes($rs["pin"]);
    
    /*
    $full_address = $address;
    $full_address = $full_address .", ".$city;
    $full_address = $full_address .", ".$country;
    if($pin !='')
    {
        $full_address = $full_address ." - ".$pin;
    }
    */
    
    $permanent_address = stripslashes($rs["permanent_address"]);
    $permanent_city = stripslashes($rs["permanent_city"]);
    $permanent_country = stripslashes($rs["permanent_country"]);
    $permanent_pin = stripslashes($rs["permanent_pin"]);
    
    $permanent_full_address = $permanent_address;
    if($permanent_city !="")
    {
        $permanent_full_address = $permanent_full_address .", ".$permanent_city;
    }
    
    if($permanent_country !="")
    {
        $permanent_full_address = $permanent_full_address .", ".$permanent_country;
    }
    
    
    
    if($permanent_pin !='')
    {
        $permanent_full_address = $permanent_full_address ." - ".$permanent_pin;
    }
    
    $i_am = stripslashes($rs["i_am"]);
    $i_am = str_replace("Other","",$i_am);

    $other_i_am = stripslashes($rs["other_i_am"]);
    if($other_i_am !='')
    {
        if($i_am!='')
        {
            $i_am = $i_am.", ".$other_i_am;
        }
        else
        {
            $i_am = $other_i_am;
        }
        
    }
    
    $payment_status = stripslashes($rs['payment_status']);
    $payment_text = stripslashes($rs["payment_text"]);
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . $ROW)->getFont()->setBold(true)->setSize(9);
    $objPHPExcel->setActiveSheetIndex(0)
            
    ->setCellValue('A' . $ROW, $SRNO)
    ->setCellValue('B' . $ROW, $reg_number_text)
    ->setCellValue('C' . $ROW, $TITLE)
    ->setCellValue('D' . $ROW, $first_name)
    ->setCellValue('E' . $ROW, $middle_name)
    ->setCellValue('F' . $ROW, $last_name)
    ->setCellValue('G' . $ROW, $SUFF)
    ->setCellValue('H' . $ROW, $full_name)
    ->setCellValue('I' . $ROW, $i_am)
    
    ->setCellValue('J' . $ROW, $address)
    ->setCellValue('K' . $ROW, $address2)
    ->setCellValue('L' . $ROW, $address3)
    ->setCellValue('M' . $ROW, $address4)
    ->setCellValue('N' . $ROW, $city)
    ->setCellValue('O' . $ROW, $city)
    ->setCellValue('P' . $ROW, $STATE)
    ->setCellValue('Q' . $ROW, $pin)
    ->setCellValue('R' . $ROW, $country)
    ->setCellValue('S' . $ROW, $telephone)
    ->setCellValue('T' . $ROW, $FAX)
    ->setCellValue('U' . $ROW, $PROF_TYPE)
    ->setCellValue('V' . $ROW, $email);
            
                    
    $ROW++; 
}

 
$ROW++;    
   
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Insol Member List');

//Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$filename = 'Insol_Member-' . date('Y-m-d') . ".xls"; 



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save(SITE_UPLOAD_FOLDER_RELATIVE_PATH.'/' . $filename);

$message = 'Please find attachment member details upto '.date('jS M Y');

//$MAIL_TO = "nawal@iws.in";
$MAIL_TO = "contact@insolindia.com";
            
//$MAIL_BCC = "nawal@iws.in";
//$MAIL_BCC = "gmnawal@gmail.com";

$MAIL_FROM = $_SESSION['INFO_EMAIL'];
$MAIL_FROMNAME = $_SESSION['COMPANY_NAME'];
$MAIL_BODY = $message;

$MAIL_ATTACHMENT1 = SITE_UPLOAD_FOLDER_RELATIVE_PATH."/" . $filename;

$MAIL_SUBJECT = "";
$MAIL_SUBJECT = "Insol Member List - " . date('jS M Y')."";

$RES = MailObject($MAIL_TO,$MAIL_FROM,$MAIL_CC,$MAIL_BCC,$MAIL_SUBJECT,$MAIL_BODY,$MAIL_ATTACHMENT1);


/////////////////////////////////////////////////


function getExcelNameFromNumber($num)
{
    
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getExcelNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
    
    
}

?>



