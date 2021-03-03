<?php 
session_start();
error_reporting(1);
ini_set("memory_limit","512M");
include("../library_insol/class.pdo.php"); 
include("../library_insol/class.inputfilter.php");
include("../library_insol/function.php");  
include("../global_functions.php");  

require_once CMS_INCLUDES_RELATIVE_PATH . 'Classes/PHPExcel.php';

$search_user_name = trustme($_REQUEST['search_user_name']);
$search_email = trustme($_REQUEST['search_email']);        

$search_register_status = trustme($_REQUEST['search_register_status']);   
$search_payment_status = trustme($_REQUEST['search_payment_status']);   

$search_from_date = ($_REQUEST['search_from_date']);
$search_to_date = ($_REQUEST['search_to_date']);

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

$search = "";  

if( trim($search_user_name) != "")
{
    $search .= " and ((fname LIKE :user_name) or (surname LIKE :user_name) or (concat_ws(' ',fname,surname) LIKE :user_name ) ) ";
}

if( trim($search_email) != "")
{
    $search .= " AND email = '".$search_email."' ";
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

if( trim($search_register_status) != "")
{
    $search .= " AND `status` = :register_status ";
}

if( trim($search_payment_status) != "")
{
    $search .= " AND payment_status = :payment_status ";
}

/////////////////////////////////////////////////////

$SQL2 = "";
$SQL2 .= " SELECT *, CASE WHEN registration_no !='' THEN  registration_no ELSE event_joiner_id END AS ordby  FROM " . EVENT_JOINER_TBL . "";   
$SQL2 .= " WHERE status <> 'DELETE' ";
$SQL2 .= " $search ";
$SQL2 .= " order by ordby desc ";


$stmt2 = $dCON->prepare($SQL2); 

if(trim($search_user_name) != "")
{ 
    $stmt2->bindParam(":user_name", $username);
    $username = "%{$search_user_name}%";
}

if( trim($search_register_status) != "")
{
    $stmt2->bindParam(":register_status",$search_register_status); 
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
$objPHPExcel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('A2:L2')->applyFromArray($styleArray); 

$objPHPExcel->getActiveSheet()->getStyle('M1:X1')->applyFromArray($styleArray); 
$objPHPExcel->getActiveSheet()->getStyle('M2:X2')->applyFromArray($styleArray); 

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
$objPHPExcel->getActiveSheet()
    ->getCell('A1')
    ->setValue('BASIC DETAILS');
    

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M1:W1');
$objPHPExcel->getActiveSheet()
    ->getCell('J1')
    ->setValue('PAYMENT SUMMARY');

$objPHPExcel->getActiveSheet()->setAutoFilter('A2:W1');


$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ROW,"Serial No.")//Basic Details
            ->setCellValue('B'.$ROW,"REGD ID")
            ->setCellValue('C'.$ROW,"TITLE")
            ->setCellValue('D'.$ROW,"FIRST")
            ->setCellValue('E'.$ROW,"SURNAME")
            ->setCellValue('F'.$ROW,"FULL Name")
            ->setCellValue('G'.$ROW,"NAME ON BADGE")
            ->setCellValue('H'.$ROW,"FIRM")
            ->setCellValue('I'.$ROW,"ADDRESS")
            ->setCellValue('J'.$ROW,"TELEPHONE")
            ->setCellValue('K'.$ROW,"EMAIL")

            ->setCellValue('L'.$ROW,"REGISTRATION FEES") // Payment Details
            ->setCellValue('M'.$ROW,"IF YOU WISH TO PAY BY CHEQUE OR NEFT, KINDLY FILL IN THE BELOW DETAILS")
            ->setCellValue('N'.$ROW,"I ENCLOSE A CHEQUE/DRAFT/NEFT TO THE ORDER OF")
            ->setCellValue('O'.$ROW,"CHEQUE NO.")
            ->setCellValue('P'.$ROW,"UTR NO")
            ->setCellValue('Q'.$ROW,"AMOUNT")
            ->setCellValue('R'.$ROW,"ADDRESS (IF DIFFERENT FROM ADDRESS ON PREVIOUS PAGE)")
            ->setCellValue('S'.$ROW,"HAVE YOU ATTENDED AN INSOL INDIA CONFERENCE PREVIOUSLY")
            ->setCellValue('T'.$ROW,"REGISTER STATUS  ")
            ->setCellValue('U'.$ROW,"REGISTER DATE")
            ->setCellValue('V'.$ROW,"PAYMENT STATUS")
            ->setCellValue('W'.$ROW,"PAYMENT DETAILS");
            
         
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

$ROW++;
$ALL_TOTAL = 0;
$SRNO = 0;
foreach($row as $rs)
{  
    $SRNO++;
   
    $title = "";
    $fname = "";
    $surname = "";
    $full_name = "";
    $name_on_badge = "";
    $firmname = "";
    $registration_no = "";
    $address = "";
    $phone = "";
    $email = "";
    
    $registration_fees = "";
    $pay_by = "";
    $order_of = "";
    $cheque_no = "";
    $utr_no = "";
    $draft_address = "";
    $is_previously_attended = "";
    $payment_status = "";
    $register_status = "";
    $add_time = "";
    $payment_text = "";
    
    $title = stripslashes($rs['title']);                                             
    $fname = ucfirst(strtolower(stripslashes($rs["fname"])));
    $surname = ucfirst(strtolower(stripslashes($rs["surname"])));
    $name_on_badge = ucfirst(strtolower(stripslashes($rs["name_on_badge"])));
    $firmname = stripslashes($rs["firmname"]);
    $registration_no = stripslashes($rs["registration_no"]);
    $full_name = $title." ".$fname;
    
    if($surname !='')
    {
        $full_name = $full_name." ".$surname;
    }
        
    $address = stripslashes($rs['address']); 
    $phone = stripslashes($rs['phone']);
    $email= stripslashes($rs['email']); 
    $registration_fees = stripslashes($rs['registration_fees']);
    $pay_by = stripslashes($rs['pay_by']);
    $order_of = stripslashes($rs["order_of"]);
    $cheque_no = stripslashes($rs["cheque_no"]);
    $utr_no = stripslashes($rs["utr_no"]);
    $draft_address = stripslashes($rs["draft_address"]);
    $enclosed_amount = stripslashes($rs["enclosed_amount"]);
    $is_previously_attended = stripslashes($rs["is_previously_attended"]);
    $payment_status = stripslashes($rs["payment_status"]);
    $register_status = stripslashes($rs["status"]);
    $payment_text = stripslashes($rs["payment_text"]);
    
    $add_time = stripslashes($rs['add_time']);
    if($add_time !='' && $add_time !='0000-00-00')
    {
        $add_time = date('d M, Y', strtotime($add_time));
    }
    else
    {
        $add_time = "";
    }

    $objPHPExcel->getActiveSheet()->getStyle('A' . $ROW)->getFont()->setBold(true)->setSize(9);
    $objPHPExcel->setActiveSheetIndex(0)
            
    ->setCellValue('A' . $ROW, $SRNO)
    ->setCellValue('B' . $ROW, $registration_no)
    ->setCellValue('C' . $ROW, $title)
    ->setCellValue('D' . $ROW, $fname)
    ->setCellValue('E' . $ROW, $surname)
    ->setCellValue('F' . $ROW, $full_name)
    ->setCellValue('G' . $ROW, $name_on_badge)
    ->setCellValue('H' . $ROW, $firmname)
    ->setCellValue('I' . $ROW, $address)
    ->setCellValue('J' . $ROW, $phone)
    ->setCellValue('K' . $ROW, $email)

    ->setCellValue('L' . $ROW, $registration_fees)
    ->setCellValue('M' . $ROW, $pay_by)
    ->setCellValue('N' . $ROW, $order_of)
    ->setCellValue('O' . $ROW, $cheque_no)
    ->setCellValue('P' . $ROW, $utr_no)
    ->setCellValue('Q' . $ROW, $enclosed_amount)
    ->setCellValue('R' . $ROW, $draft_address)
    ->setCellValue('S' . $ROW, $is_previously_attended)
    ->setCellValue('T' . $ROW, $register_status)
    ->setCellValue('U' . $ROW, $add_time)
    ->setCellValue('V' . $ROW, $payment_status)
    ->setCellValue('W' . $ROW, $payment_text);
    
    
    
    
                   
    $ROW++; 
}
 
$ROW++;       
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Event Joiner List');
    

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename = $_SESSION['COMPANY_NAME']. ' : Event Joiner - ' . date('YmdHis') . ".xls"; 
// Redirect output to a client�s web browser (Excel5)
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
