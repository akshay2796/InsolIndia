<?php 
session_start();
error_reporting(1);
ini_set("memory_limit","512M");
include("../library_insol/class.pdo.php"); 
include("../library_insol/class.inputfilter.php");
include("../library_insol/function.php");  
include("../global_functions.php");  

require_once CMS_INCLUDES_RELATIVE_PATH . 'Classes/PHPExcel.php';

$search_email = trustme($_REQUEST['search_email']);
   
$search_user_name = trustme($_REQUEST['search_user_name']);
$search_email = trustme($_REQUEST['search_email']);
$search_reg_number = trustme($_REQUEST['search_reg_number']);
$search_register_status = trustme($_REQUEST['search_register_status']); 
$search_sig_member = trustme($_REQUEST['search_sig_member']);  
$search_payment_status = trustme($_REQUEST['search_payment_status']);   

$search_from_date = trustme($_REQUEST['search_from_date']);
$search_to_date = trustme($_REQUEST['search_to_date']);
$year= trustme($_REQUEST['year']);

if ( trim($search_from_date) != "" )
{
    //$search_from_date_time = date('Y-d-m', strtotime($search_from_date));
    $search_from_date_arr =  explode("-",$search_from_date);
    $search_from_date_time = $search_from_date_arr[2]."-".$search_from_date_arr[1]."-".$search_from_date_arr[0];	 
	 
}
else
{
    $search_from_date_time = "";    
}

if ( $search_to_date != "" )
{
    //$search_to_date_time = date('Y-d-m', strtotime($search_to_date));	 
    
    $search_to_date_arr =  explode("-",$search_to_date);
    $search_to_date_time = $search_to_date_arr[2]."-".$search_to_date_arr[1]."-".$search_to_date_arr[0];
}
else
{
    $search_to_date_time = "";    
}


$search_from_membership_date = trustme($_REQUEST['search_from_membership_date']);
$search_to_membership_date = trustme($_REQUEST['search_to_membership_date']);

if ( trim($search_from_membership_date) != "" )
{
    //$search_from_date_membership_time = date('Y-d-m', strtotime($search_from_membership_date));	
    $search_from_date_membership_time_arr =  explode("-",$search_from_membership_date);
   $search_from_date_membership_time = $search_from_date_membership_time_arr[2]."-".$search_from_date_membership_time_arr[1]."-".$search_from_date_membership_time_arr[0];	 
}
else
{
    $search_from_date_membership_time = "";    
}

if ( $search_to_membership_date != "" )
{
    //$search_to_date_membership_time = date('Y-d-m', strtotime($search_to_membership_date));
    
    $search_to_membership_date_arr =  explode("-",$search_to_membership_date);
    $search_to_date_membership_time = $search_to_membership_date_arr[2]."-".$search_to_membership_date_arr[1]."-".$search_to_membership_date_arr[0];	 
}
else
{
    $search_to_date_membership_time = "";    
}

//exit;


$search = "";          

if( trim($search_user_name) != "")
{
    $search .= " and (first_name LIKE :user_name) or (last_name LIKE :user_name) or (concat_ws(' ',first_name,last_name) LIKE :user_name ) ";
}

if( trim($search_email) != "")
{
    $search .= " AND email = '".$search_email."' ";
}

if( trim($search_reg_number) != "")
{
    $search .= " AND (reg_number_text LIKE :reg_number or reg_number= '".$search_reg_number."')";
}
  
if( (trim($search_from_date_time) != "") && (trim($search_to_date_time) != "") )
{
    $search .= " AND date(add_time) between '$search_from_date_time' AND '$search_to_date_time' ";
    
} 
else if( (trim($search_from_date_time) != "") && (trim($search_to_date_time) == "") )
{
    $search .= " AND date(add_time) = '$search_from_date_time' ";
}  
 


//////////////////////////////////////////////////////
    
    if( (trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) != "") )
    {
        $search .= " AND membership_start_date between '$search_from_date_membership_time' AND '$search_to_date_membership_time'  ";
        
    } 
	else if( (trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) == "") )
    {
        $search .= " AND membership_start_date = '$search_from_date_membership_time' ";
    }  
  
/////////////////////////////////////////////////////
  




if( trim($search_register_status) != "")
{
    $search .= " AND register_status = :register_status ";
}

if( trim($search_sig_member) != "")
{
    $search .= " AND sig_member = :sig_member ";
}   

if( trim($search_payment_status) != "")
{
    $search .= " AND payment_status = :payment_status ";
}   

$SQL2 = "";
$SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE tbl_become_member.member_id END AS ordby  FROM " . BECOME_MEMBER_TBL . ""; 
$SQL2 .= " LEFT JOIN tbl_become_member_receipt ON tbl_become_member_receipt.member_id=tbl_become_member.member_id";  
$SQL2 .= " WHERE tbl_become_member.status <> 'DELETE' AND tbl_become_member_receipt.status='ACTIVE' AND YEAR(tbl_become_member_receipt.add_time)='".$year."'";
$SQL2 .= " $search ";
$SQL2 .= " order by ordby desc ";

//echo $SQL2; exit;


$stmt2 = $dCON->prepare($SQL2); 

if(trim($search_user_name) != "")
{ 
    $stmt2->bindParam(":user_name", $username);
    $username = "%{$search_user_name}%";
}

if(trim($search_reg_number) != "")
{ 
    $stmt2->bindParam(":reg_number", $reg_number);
    $reg_number = "%{$search_reg_number}%";
}

if( trim($search_register_status) != "")
{
    $stmt2->bindParam(":register_status",$search_register_status); 
}
if( trim($search_sig_member) != "")
{
    $stmt2->bindParam(":sig_member",$search_sig_member); 
}
if( trim($search_payment_status) != "")
{
    $stmt2->bindParam(":payment_status",$search_payment_status); 
}

$stmt2->execute();
$row = $stmt2->fetchAll();
 
//echo "==".$SQL2."---".count($row);       
//exit;
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator($_SESSION["COMPANY_NAME"])
							 ->setLastModifiedBy($_SESSION["COMPANY_NAME"])
							 ->setTitle($_SESSION["COMPANY_NAME"] . " Excel Sheet")
							 ->setSubject($_SESSION["COMPANY_NAME"] . " Excel Sheet")
							 ->setDescription($_SESSION["COMPANY_NAME"] . " Excel Sheet")
							 ->setKeywords($_SESSION["COMPANY_NAME"] . " Excel Sheet")
							 ->setCategory($_SESSION["COMPANY_NAME"] . " Excel Sheet");

$objPHPExcel->getDefaultStyle()->getFont()->setName('Calibri');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(11); 

$ROW = 2;

$MAXCOL = "AN";

$STATIC_COL =40;
 // BOLD ALL COLUMN HEADS ====================  
for($Z=1;$Z<=$STATIC_COL;$Z++)
{
    $ALP = getExcelNameFromNumber($Z);
    $objPHPExcel->getActiveSheet()->getColumnDimension($ALP)->setAutoSize(true);    
    
}


$objPHPExcel->getActiveSheet()->getStyle('D'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));


//$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));    
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:AN1')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
    
 $styleArray = array(
        'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000034'),
            'size'  => 10,
            'name'  => 'Verdana'
        ),
        'borders' => array(
            'right' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
            ),
            'left' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
            ),
            'bottom' => array(
              'style' => PHPExcel_Style_Border::BORDER_THICK
            )
         )
    
    );  
$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('J1:O1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('J2:O2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('P1:U1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('P2:U2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('V1:Z1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('V2:Z2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('AA1:AI1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('AA2:AI2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('AA1:AJ1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('AA2:AJ2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('AA1:AL1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('AA2:AL2')->applyFromArray($styleArray); 



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


$objPHPExcel->getActiveSheet()->setAutoFilter('A2:AN2');


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
            ->setCellValue('AJ'.$ROW,"I AM INTERESTED IN BECOMING A MEMBER OF INSOL INDIA BECAUSE")
            ->setCellValue('AK'.$ROW,"Membership Start Date")  
            ->setCellValue('AL'.$ROW,"Membership Expiry Date")  
            ->setCellValue('AM'.$ROW,"Payment details")  
            ->setCellValue('AN'.$ROW,"Register Date");  
            
                  
           // ->setCellValue('AB'.$ROW,"EMAIL");
            
            
         
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "d9e1e7")));
 
$objPHPExcel->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("B")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("C")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("E")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("F")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("G")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("H")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("I")->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension("J")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("K")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("L")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("M")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("N")->setAutoSize(true);

$objPHPExcel->getActiveSheet()->getColumnDimension("O")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("P")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("Q")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("R")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("S")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("T")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("U")->setAutoSize(true);
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
$objPHPExcel->getActiveSheet()->getColumnDimension("AK")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AL")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AM")->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension("AN")->setAutoSize(true);


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
    $first_name = ucfirst(strtolower(stripslashes($rs["first_name"])));
    $middle_name = ucfirst(strtolower(stripslashes($rs["middle_name"])));
    $last_name = ucfirst(strtolower(stripslashes($rs["last_name"])));
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
    
    //$full_name = ucwords(strtolower($full_name));
    
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
    
    $add_by = stripslashes($rs['add_by']);
    
    $add_time= stripslashes($rs['add_time']);
    if($add_time !='' && $add_time !='0000-00-00')
    {
        $add_time = date('d M, Y', strtotime($add_time));
    }
    else
    {
        $add_time = "";
    }
    
                            
    $membership_start_date = stripslashes($rs['membership_start_date']);
    if($membership_start_date !='' && $membership_start_date !='0000-00-00' && $membership_start_date !='1972-01-01' && $membership_start_date !='0001-11-30')
    {
        $membership_start_date = date('d M, Y', strtotime($membership_start_date));
    }
    else
    {
        $membership_start_date = "";
    }
    
    $membership_expired_date = stripslashes($rs['membership_expired_date']);
    if($membership_expired_date !='' && $membership_expired_date !='0000-00-00' && $membership_expired_date !='1972-01-01' && $membership_expired_date !='0001-11-30')
    {
        $membership_expired_date = date('d M, Y', strtotime($membership_expired_date));
    }
    else
    {
        $membership_expired_date = "";
    }
    
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
    ->setCellValue('AJ' . $ROW, $interested)
    ->setCellValue('AK' . $ROW, $membership_start_date)
    ->setCellValue('AL' . $ROW, $membership_expired_date)
    ->setCellValue('AM' . $ROW, $payment_text)
    ->setCellValue('AN' . $ROW, $add_time);
    
    
    
                   
    $ROW++; 
}
 
$ROW++;       
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Insol Member List');
    

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename = $_SESSION['COMPANY_NAME']. ' : Insol Contribution Member - ' . date('YmdHis') . ".xls"; 
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
?>


<?php

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
