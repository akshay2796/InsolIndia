<?php 
session_start();
error_reporting(1);
ini_set("memory_limit","-1");
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
$search_payment_status = trustme($_REQUEST['search_payment_status']);   

$search_from_date = trustme($_REQUEST['search_from_date']);
$search_to_date = trustme($_REQUEST['search_to_date']);

if ( trim($search_from_date) != "" )
{
    $search_from_date_time = date('Y-d-m', strtotime($search_from_date));	 
}
else
{
    $search_from_date_time = "";    
}

if ( $search_to_date != "" )
{
    $search_to_date_time = date('Y-d-m', strtotime($search_to_date));	 
}
else
{
    $search_to_date_time = "";    
}


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
 

if( trim($search_register_status) != "")
{
    $search .= " AND register_status = :register_status ";
}  

if( trim($search_payment_status) != "")
{
    $search .= " AND payment_status = :payment_status ";
}   

$SQL2 = "";
$SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE member_id END AS ordby FROM " . BECOME_MEMBER_TBL . "";   
$SQL2 .= " WHERE status <> 'DELETE' ";
$SQL2 .= " $search ";
$SQL2 .= " order by ordby desc ";
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
if( trim($search_payment_status) != "")
{
    $stmt2->bindParam(":payment_status",$search_payment_status); 
}

$stmt2->execute();
$row = $stmt2->fetchAll();
 
//echo "==".count($row);       
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

$ROW = 1;

$MAXCOL = "K";

$STATIC_COL =11;
 // BOLD ALL COLUMN HEADS ====================  
for($Z=1;$Z<=$STATIC_COL;$Z++)
{
    $ALP = getExcelNameFromNumber($Z);
    $objPHPExcel->getActiveSheet()->getColumnDimension($ALP)->setAutoSize(true);    
    
}


$objPHPExcel->getActiveSheet()->getStyle('D'.$ROW.':'.$MAXCOL.$ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));



$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$ROW,"Sr. No.")
            ->setCellValue('B'.$ROW,"Name")
            ->setCellValue('C'.$ROW,"Email")
            ->setCellValue('D'.$ROW,"Telephone")
            ->setCellValue('E'.$ROW,"Mobile")
            ->setCellValue('F'.$ROW,"Correspondence address")
            ->setCellValue('G'.$ROW,"Permanent Address")
            ->setCellValue('H'.$ROW,"I am")
            ->setCellValue('I'.$ROW,"Reg. No.")
            ->setCellValue('J'.$ROW,"Payment Status")
            ->setCellValue('K'.$ROW,"Payment Detail");
            
         
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
    $last_name = ""; 
    $reg_number = ""; 
    $mobile = ""; 
    $city = ""; 
    $telephone = ""; 
    $status = ""; 
    $payment_status = "";
    $register_status = "";
    $paid_amount = "";
    
    
    $reg_number_text = stripslashes($rs['reg_number_text']);                                             
    $reg_number = stripslashes($rs['reg_number']);   
    $first_name = stripslashes($rs["first_name"]);
    $middle_name = stripslashes($rs["middle_name"]);
    $last_name = stripslashes($rs["last_name"]);
    
    $name = $first_name;
    if($middle_name !='')
    {
        $name = $name." ".$middle_name;
    }
    $name = $name." ".$last_name;
    
    $email = stripslashes($rs['email']); 
    $mobile = stripslashes($rs['mobile']);
    $telephone= stripslashes($rs['telephone']);
    
    
    
    $address = stripslashes($rs["address"]);
    $city = stripslashes($rs["city"]);
    $country = stripslashes($rs["country"]);
    $pin = stripslashes($rs["pin"]);
    
    $full_address = $address;
    $full_address = $full_address .", ".$city;
    $full_address = $full_address .", ".$country;
    if($pin !='')
    {
        $full_address = $full_address ." - ".$pin;
    }
    
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
    ->setCellValue('B' . $ROW, $name)
    ->setCellValue('C' . $ROW, $email)
    ->setCellValue('D' . $ROW, $telephone)
    ->setCellValue('E' . $ROW, $mobile)
    ->setCellValue('F' . $ROW, $full_address)
    ->setCellValue('G' . $ROW, $permanent_full_address)
    ->setCellValue('H' . $ROW, $i_am)
    ->setCellValue('I' . $ROW, $reg_number_text)
    ->setCellValue('J' . $ROW, $payment_status)
    ->setCellValue('K' . $ROW, $payment_text);
            
                    
    $ROW++; 
}

 
$ROW++;       
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Member List');
    

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$filename = $_SESSION['COMPANY_NAME']. ' : Insol Member - ' . date('YmdHis') . ".xls"; 
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