<?php 
ini_set("max_execution_time", 600);
error_reporting(0);

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
$SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE member_id END AS ordby FROM " . BECOME_MEMBER_TBL . "";   
$SQL2 .= " WHERE status <> 'DELETE' ";
$SQL2 .= " and register_status = 'Approved' ";
$SQL2 .= " and (payment_status = 'SUCCESSFUL' or sig_member = 1)";
$SQL2 .= " order by ordby desc ";
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

$MAXCOL = "AI";

$STATIC_COL =30;
 // BOLD ALL COLUMN HEADS ====================  
for($Z=1;$Z<=$STATIC_COL;$Z++)
{
    $ALP = getExcelNameFromNumber($Z);
    $objPHPExcel->getActiveSheet()->getColumnDimension($ALP)->setAutoSize(true);    
    
}


$objPHPExcel->getActiveSheet()->getStyle('D'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
$objPHPExcel->getActiveSheet()
    ->getCell('A1')
    ->setValue('BASIC DETAILS');
    

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('J1:O1');
$objPHPExcel->getActiveSheet()
    ->getCell('J1')
    ->setValue('CORRESPONDENCE ADDRESS');
    
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('P1:U1');
$objPHPExcel->getActiveSheet()
    ->getCell('P1')
    ->setValue('PERMANENT ADDRESS');
    
$objPHPExcel->setActiveSheetIndex(0)->mergeCells('V1:Z1');
$objPHPExcel->getActiveSheet()
    ->getCell('V1')
    ->setValue('COMMUNICATION DETAILS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AA1:AJ1');
$objPHPExcel->getActiveSheet()
    ->getCell('AA1')
    ->setValue('PROFESSIONAL  DETAILS');


$objPHPExcel->getActiveSheet()->setAutoFilter('A2:AJ2');


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
            ->setCellValue('J'.$ROW,"ADDRESS1") // coreespondence
            ->setCellValue('K'.$ROW,"ADDRESS2")
            ->setCellValue('L'.$ROW,"CITY")
            ->setCellValue('M'.$ROW,"STATE")
            ->setCellValue('N'.$ROW,"ZIP")
            ->setCellValue('O'.$ROW,"COUNTRY")
            ->setCellValue('P'.$ROW,"ADDRESS1") // permanent
            ->setCellValue('Q'.$ROW,"ADDRESS2")
            ->setCellValue('R'.$ROW,"CITY")
            ->setCellValue('S'.$ROW,"STATE")
            ->setCellValue('T'.$ROW,"ZIP")
            ->setCellValue('U'.$ROW,"COUNTRY") 
            ->setCellValue('V'.$ROW,"CORRESPONDENCE LANDLINE")
            ->setCellValue('W'.$ROW,"RESIDENCE LANDLINE")
            ->setCellValue('X'.$ROW,"MOBILE")
            ->setCellValue('Y'.$ROW,"FAX")
            ->setCellValue('Z'.$ROW,"EMAIL") /////////
            ->setCellValue('AA'.$ROW,"I AM")
            //->setCellValue('AB'.$ROW,"I AM INSOLVENCY PROFESSIONAL REGISTERED WITH ")
            ->setCellValue('AB'.$ROW,"NAME OF INSOLVENCY PROFESSIONAL AGENCY")
            ->setCellValue('AC'.$ROW,"REGISTERATION NO. OF THE INSOLVENCY PROFESSIONAL AGENCY")
            
            ->setCellValue('AD'.$ROW,"IBBI MEMBER (Y/N)")
            ->setCellValue('AE'.$ROW,"IBBI REGISTERATION NO ")
            
            ->setCellValue('AF'.$ROW,"I AM A YOUNG PRACTITIONER (Y/N)")           
            ->setCellValue('AG'.$ROW,"YOUNG PRACTITIONER - DATE OF ENROLMENT WITH MY PROFESSIONAL BODY IS") 
            ->setCellValue('AH'.$ROW,"I AM AN SIG 24 Member (Y/N)")
            ->setCellValue('AI'.$ROW,"SIG COMPANY NAME ")  
            ->setCellValue('AJ'.$ROW,"I AM INTERESTED IN BECOMING A MEMBER OF INSOL INDIA BECAUSE");  
            
         
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "d9e1e7")));
 
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("V")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("W")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("X")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("Y")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("Z")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AA")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AB")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AC")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AD")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AE")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AF")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AG")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AH")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AI")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AJ")->setAutoSize(true);

$ROW++;
$ALL_TOTAL = 0;
$SRNO = 0;
foreach($row as $rs)
{  
    $SRNO++;
   
    $title = "";
    $first_name = ""; 
    $middle_name = ""; 
    $last_name = ""; 
    $full_name = "";
    $suffix = ""; 
    $firm_name = "";
    $reg_number = ""; 
    
    
    
    $correspondence_address_1 = "";
    $correspondence_address_2 = "";
    $correspondence_city = ""; 
    $correspondence_state = "";
    $correspondence_country = "";
    $correspondence_pin = "";
    
    $permanent_address_1 = "";
    $permanent_address_2 = "";
    $permanent_city = "";
    $permanent_state = "";
    $permanent_country = "";
    $permanent_pin = "";
    
    $telephone = "";
    $residence_telephone = ""; 
    $mobile = ""; 
    $fax = "";
    
    $insolvency_professional_agency = "";
    $insolvency_professional_number = "";
    
    $status = ""; 
    $payment_status = "";
    $register_status = "";
    $paid_amount = "";
    
    
    
    
    $reg_number_text = stripslashes($rs['reg_number_text']);                                             
    $reg_number = stripslashes($rs['reg_number']); 
    $title = stripslashes($rs["title"]);
    $first_name = stripslashes($rs["first_name"]);
    $first_name = ucwords(strtolower($first_name));
    
    $middle_name = stripslashes($rs["middle_name"]);
    $middle_name = ucwords(strtolower($middle_name));
    
    $last_name = stripslashes($rs["last_name"]);
    $last_name = ucwords(strtolower($last_name));
    
    $suffix = stripslashes($rs["suffix"]);
    $firm_name = stripslashes($rs["firm_name"]);
    $full_name = $title." ".$first_name;
    
    if($middle_name !='')
    {
        $full_name = $full_name." ".$middle_name;
    }
    if($last_name !='')
    {
        $full_name = $full_name." ".$last_name;
    }
    
    $full_name = ucwords(strtolower($full_name));
    
    $email = stripslashes($rs['email']); 
    $mobile = stripslashes($rs['mobile']);
    $telephone= stripslashes($rs['telephone']); 
    $residence_telephone = stripslashes($rs['residence_telephone']);
    $fax= stripslashes($rs['fax']);
    $correspondence_address_1 = stripslashes($rs["address"]);
    $correspondence_address_2 = stripslashes($rs["correspondence_address_2"]);
    $correspondence_city = stripslashes($rs["city"]);
    $correspondence_state = stripslashes($rs["correspondence_state"]);
    $correspondence_country = stripslashes($rs["country"]);
    $correspondence_pin = stripslashes($rs["pin"]);
    
    $permanent_address_1 = stripslashes($rs["permanent_address"]);
    $permanent_address_2 = stripslashes($rs["permanent_address_2"]);
    $permanent_city = stripslashes($rs["permanent_city"]);
    $permanent_state = stripslashes($rs["permanent_state"]);
    $permanent_country = stripslashes($rs["permanent_country"]);
    $permanent_pin = stripslashes($rs["permanent_pin"]);
    
    /*
    $full_address = $address;
    $full_address = $full_address .", ".$city;
    $full_address = $full_address .", ".$country;
    if($pin !='')
    {
        $full_address = $full_address ." - ".$pin;
    }
    */
    
    
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
    
    $insolvency_professional_agency = stripslashes($rs['insolvency_professional_agency']);
    $insolvency_professional_number = stripslashes($rs['insolvency_professional_number']); 
    $registered_insolvency_professional = stripslashes($rs['registered_insolvency_professional']);
    
    if(intval($registered_insolvency_professional) == intval(1)){
        $registered_insolvency_professional = 'Y';
    }else{
        $registered_insolvency_professional = 'N';
    } 
    
    
    $registered_insolvency_professional_number = stripslashes($rs['registered_insolvency_professional_number']);
    
    
    
    $sig_member = intval(stripslashes($rs['sig_member']));
    
    if(intval($sig_member) == intval(1))
    {
        $sig_member = 'Y';
    }
    else
    {
        $sig_member = 'N';
    } 
    
    $sig_company_id = intval(stripslashes($rs['sig_company_id']));
    $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id","$sig_company_id",'=', '', '' , "");
    
    
    $young_practitioner = intval(stripslashes($rs['young_practitioner']));
    
    if(intval($young_practitioner) == intval(1))
    {
        $young_practitioner = 'Y';
    }
    else
    {
        $young_practitioner = 'N';
    } 
    
    
    $young_practitioner_enrolment = stripslashes($rs['young_practitioner_enrolment']);
    
    $interested = stripslashes($rs['interested']);
   
    
    
    $payment_status = stripslashes($rs['payment_status']);
    $payment_text = stripslashes($rs["payment_text"]);
    
    $objPHPExcel->getActiveSheet()->getStyle('A' . $ROW)->getFont()->setBold(true)->setSize(9);
    $objPHPExcel->setActiveSheetIndex(0)
            
    ->setCellValue('A' . $ROW, $SRNO)
    ->setCellValue('B' . $ROW, $reg_number_text)
    ->setCellValue('C' . $ROW, $title)
    ->setCellValue('D' . $ROW, $first_name)
    ->setCellValue('E' . $ROW, $middle_name)
    ->setCellValue('F' . $ROW, $last_name)
    ->setCellValue('G' . $ROW, $suffix)
    ->setCellValue('H' . $ROW, $full_name)
    ->setCellValue('I' . $ROW, $firm_name)
    ->setCellValue('J' . $ROW, $correspondence_address_1)
    ->setCellValue('K' . $ROW, $correspondence_address_2)
    ->setCellValue('L' . $ROW, $correspondence_city)
    ->setCellValue('M' . $ROW, $correspondence_state)
    ->setCellValue('N' . $ROW, $correspondence_pin)
    ->setCellValue('O' . $ROW, $correspondence_country)
    ->setCellValue('P' . $ROW, $permanent_address_1)
    ->setCellValue('Q' . $ROW, $permanent_address_2)
    ->setCellValue('R' . $ROW, $permanent_city)
    ->setCellValue('S' . $ROW, $permanent_state)
    ->setCellValue('T' . $ROW, $permanent_pin)
    ->setCellValue('U' . $ROW, $permanent_country)
    ->setCellValue('V' . $ROW, $telephone)
    ->setCellValue('W' . $ROW, $residence_telephone)
    ->setCellValue('X' . $ROW, $mobile)
    ->setCellValue('Y' . $ROW, $fax)
    ->setCellValue('Z' . $ROW, $email)
    ->setCellValue('AA' . $ROW, $i_am)
    ->setCellValue('AB' . $ROW, $insolvency_professional_agency)
    ->setCellValue('AC' . $ROW, $insolvency_professional_number)
    ->setCellValue('AD' . $ROW, $registered_insolvency_professional)
    ->setCellValue('AE' . $ROW, $registered_insolvency_professional_number)
    
    ->setCellValue('AF' . $ROW, $young_practitioner)
    ->setCellValue('AG' . $ROW, $young_practitioner_enrolment)
    
    ->setCellValue('AH' . $ROW, $sig_member)
    ->setCellValue('AI' . $ROW, $sig_company_name)
    ->setCellValue('AJ' . $ROW, $interested);
                  
    $ROW++; 
}

 
$ROW++;    
   
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Insol Members List');

//Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


$filename = 'Insol_Members-' . date('Y-m-d') . ".xls"; 



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$objWriter->save(SITE_UPLOAD_FOLDER_RELATIVE_PATH.'/' . $filename);

$message = 'Please find attachment for members details upto '.date('jS M Y');

//$MAIL_TO = "nawal@iws.in";
$MAIL_TO = "contact@insolindia.com";

$MAIL_CC = "aditikhanna@insolindia.com, bhavna@insolindia.com";
            
$MAIL_BCC = "akhilesh@iws.in";

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



