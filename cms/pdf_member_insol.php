<?php
session_start();
error_reporting(1);
ini_set("memory_limit", "-1");
include "../library_insol/class.pdo.php";
include "../library_insol/class.inputfilter.php";
include "../library_insol/function.php";
include "../global_functions.php";

require_once CMS_INCLUDES_RELATIVE_PATH . 'Classes/PHPExcel.php';
// require_once CMS_INCLUDES_RELATIVE_PATH . 'Classes/dompdf/autoload.inc.php';

$search_email = trustme($_REQUEST['search_email']);

$search_user_name = trustme($_REQUEST['search_user_name']);
$search_email = trustme($_REQUEST['search_email']);
$search_reg_number = trustme($_REQUEST['search_reg_number']);
$search_register_status = trustme($_REQUEST['search_register_status']);
$search_sig_member = trustme($_REQUEST['search_sig_member']);
$search_payment_status = trustme($_REQUEST['search_payment_status']);

$search_from_date = trustme($_REQUEST['search_from_date']);
$search_to_date = trustme($_REQUEST['search_to_date']);

if (trim($search_from_date) != "") {
    //$search_from_date_time = date('Y-d-m', strtotime($search_from_date));
    $search_from_date_arr = explode("-", $search_from_date);
    $search_from_date_time = $search_from_date_arr[2] . "-" . $search_from_date_arr[1] . "-" . $search_from_date_arr[0];

} else {
    $search_from_date_time = "";
}

if ($search_to_date != "") {
    //$search_to_date_time = date('Y-d-m', strtotime($search_to_date));

    $search_to_date_arr = explode("-", $search_to_date);
    $search_to_date_time = $search_to_date_arr[2] . "-" . $search_to_date_arr[1] . "-" . $search_to_date_arr[0];
} else {
    $search_to_date_time = "";
}

$search_from_membership_date = trustme($_REQUEST['search_from_membership_date']);
$search_to_membership_date = trustme($_REQUEST['search_to_membership_date']);

if (trim($search_from_membership_date) != "") {
    //$search_from_date_membership_time = date('Y-d-m', strtotime($search_from_membership_date));
    $search_from_date_membership_time_arr = explode("-", $search_from_membership_date);
    $search_from_date_membership_time = $search_from_date_membership_time_arr[2] . "-" . $search_from_date_membership_time_arr[1] . "-" . $search_from_date_membership_time_arr[0];
} else {
    $search_from_date_membership_time = "";
}

if ($search_to_membership_date != "") {
    //$search_to_date_membership_time = date('Y-d-m', strtotime($search_to_membership_date));

    $search_to_membership_date_arr = explode("-", $search_to_membership_date);
    $search_to_date_membership_time = $search_to_membership_date_arr[2] . "-" . $search_to_membership_date_arr[1] . "-" . $search_to_membership_date_arr[0];
} else {
    $search_to_date_membership_time = "";
}

//exit;

$search = "";

if (trim($search_user_name) != "") {
    $search .= " and (first_name LIKE :user_name) or (last_name LIKE :user_name) or (concat_ws(' ',first_name,last_name) LIKE :user_name ) ";
}

if (trim($search_email) != "") {
    $search .= " AND email = '" . $search_email . "' ";
}

if (trim($search_reg_number) != "") {
    $search .= " AND (reg_number_text LIKE :reg_number or reg_number= '" . $search_reg_number . "')";
}

if ((trim($search_from_date_time) != "") && (trim($search_to_date_time) != "")) {
    $search .= " AND date(add_time) between '$search_from_date_time' AND '$search_to_date_time' ";

} else if ((trim($search_from_date_time) != "") && (trim($search_to_date_time) == "")) {
    $search .= " AND date(add_time) = '$search_from_date_time' ";
}

//////////////////////////////////////////////////////

if ((trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) != "")) {
    $search .= " AND membership_start_date between '$search_from_date_membership_time' AND '$search_to_date_membership_time'  ";

} else if ((trim($search_from_date_membership_time) != "") && (trim($search_to_date_membership_time) == "")) {
    $search .= " AND membership_start_date = '$search_from_date_membership_time' ";
}

/////////////////////////////////////////////////////

if (trim($search_register_status) != "") {
    $search .= " AND register_status = :register_status ";
}

if (trim($search_sig_member) != "") {
    $search .= " AND sig_member = :sig_member ";
}

if (trim($search_payment_status) != "") {
    $search .= " AND payment_status = :payment_status ";
}

$SQL2 = "";
$SQL2 .= " SELECT *, CASE WHEN reg_number !='' THEN  reg_number ELSE member_id END AS ordby  FROM " . BECOME_MEMBER_TBL . "";
$SQL2 .= " WHERE status <> 'DELETE' ";
$SQL2 .= " $search ";
$SQL2 .= " order by ordby desc ";

$stmt2 = $dCON->prepare($SQL2);

if (trim($search_user_name) != "") {
    $stmt2->bindParam(":user_name", $username);
    $username = "%{$search_user_name}%";
}

if (trim($search_reg_number) != "") {
    $stmt2->bindParam(":reg_number", $reg_number);
    $reg_number = "%{$search_reg_number}%";
}

if (trim($search_register_status) != "") {
    $stmt2->bindParam(":register_status", $search_register_status);
}
if (trim($search_sig_member) != "") {
    $stmt2->bindParam(":sig_member", $search_sig_member);
}
if (trim($search_payment_status) != "") {
    $stmt2->bindParam(":payment_status", $search_payment_status);
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

$MAXCOL = "AP";

$STATIC_COL = 40;
// BOLD ALL COLUMN HEADS ====================
for ($Z = 1; $Z <= $STATIC_COL; $Z++) {
    $ALP = getExcelNameFromNumber($Z);
    $objPHPExcel->getActiveSheet()->getColumnDimension($ALP)->setAutoSize(true);

}

$objPHPExcel->getActiveSheet()->getStyle('D' . $ROW . ':' . $MAXCOL . $ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => "ffffff")));

//$objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID,'startcolor' => array('rgb' => "ffffff")));
$objPHPExcel->getActiveSheet()
    ->getStyle('A1:AP1')
    ->getAlignment()
    ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$styleArray = array(
    'font' => array(
        'bold' => true,
        'color' => array('rgb' => '000034'),
        'size' => 10,
        'name' => 'Verdana',
    ),
    'borders' => array(
        'right' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
        ),
        'left' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
        ),
        'bottom' => array(
            'style' => PHPExcel_Style_Border::BORDER_THICK,
        ),
    ),

);
$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A2:J2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('K1:P1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('K2:P2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('Q1:V1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('Q2:V2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('W1:AA1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('W2:AA2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('AB1:AK1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('AB2:AK2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('AL1:AM1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('AL2:AM2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('AN1:AO1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('AN2:AO2')->applyFromArray($styleArray);

$objPHPExcel->getActiveSheet()->getStyle('AP1:AP1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('AP2:AP2')->applyFromArray($styleArray);

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:J1');
$objPHPExcel->getActiveSheet()
    ->getCell('A1')
    ->setValue('BASIC DETAILS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('K1:P1');
$objPHPExcel->getActiveSheet()
    ->getCell('K1')
    ->setValue('CORRESPONDENCE ADDRESS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('Q1:V1');
$objPHPExcel->getActiveSheet()
    ->getCell('Q1')
    ->setValue('PERMANENT ADDRESS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('W1:AA1');
$objPHPExcel->getActiveSheet()
    ->getCell('W1')
    ->setValue('COMMUNICATION DETAILS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AB1:AK1');
$objPHPExcel->getActiveSheet()
    ->getCell('AB1')
    ->setValue('PROFESSIONAL  DETAILS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AL1:AM1');
$objPHPExcel->getActiveSheet()
    ->getCell('AL1')
    ->setValue('MEMBERSHIP  DETAILS');

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('AN1:AO1');
$objPHPExcel->getActiveSheet()
    ->getCell('AN1')
    ->setValue('PAYMENT  DETAILS');

$objPHPExcel->getActiveSheet()->setAutoFilter('A2:AP2');

    $EXCEL_HEADERS = [
            "Serial No.",
            "REGD ID",
            "TITLE",
            "FIRST",
            "MIDDLE",
            "LASTNAME",
            "SUFFIX",
            "FULL Name",
            "FIRM",
            "GST NO.",
            "ADDRESS1",
            "ADDRESS2",
            "CITY",
            "STATE",
            "ZIP",
            "COUNTRY",
            "ADDRESS1",
            "ADDRESS2",
            "CITY",
            "STATE",
            "ZIP",
            "COUNTRY",
            "CORRESPONDENCE LANDLINE",
            "RESIDENCE LANDLINE",
            "MOBILE",
            "FAX",
            "EMAIL",
            "I AM",
            "NAME OF INSOLVENCY PROFESSIONAL AGENCY",
            "REGISTERATION NO. OF THE INSOLVENCY PROFESSIONAL AGENCY",
            "IBBI MEMBER (Y/N)",
            "IBBI REGISTERATION NO",
            "I AM A YOUNG PRACTITIONER (Y/N)",
            "YOUNG PRACTITIONER - DATE OF ENROLMENT WITH MY PROFESSIONAL BODY IS",
            "I AM AN SIG 24 Member (Y/N)",
            "SIG COMPANY NAME",
            "I AM INTERESTED IN BECOMING A MEMBER OF INSOL INDIA BECAUSE",
            "Membership Start Date",
            "Membership Expiry Date",
            "Payment Status",
            "Payment Information",
            "Register Date"
        ];

$objPHPExcel->getActiveSheet()->getStyle('A' . $ROW . ':' . $MAXCOL . $ROW)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A' . $ROW . ':' . $MAXCOL . $ROW)->getFill()->applyFromArray(array('type' => PHPExcel_Style_Fill::FILL_SOLID, 'startcolor' => array('rgb' => "d9e1e7")));

//Set min and max columns
$fromCol = "A";
$toCol = "AQ";

for($i = $fromCol, $j = 0; $i !== $toCol; $i++, $j++) {
    
    // Setting rows to autosize
    // $objPHPExcel->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
    
    $objPHPExcel->getActiveSheet()->getStyle($i. $ROW)->getAlignment()->setIndent(1);
    
    // Setting excel headers
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($i. $ROW, $EXCEL_HEADERS[$j]);

}

$ROW++;
$ALL_TOTAL = 0;
$SRNO = 0;
foreach ($row as $rs) {
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
    $full_name = $title . " " . $first_name;

    if ($middle_name != '') {
        $full_name = $full_name . " " . $middle_name;
    }
    if ($last_name != '') {
        $full_name = $full_name . " " . $last_name;
    }

    //$full_name = ucwords(strtolower($full_name));

    $email = stripslashes($rs['email']);
    $mobile = stripslashes($rs['mobile']);
    $telephone = stripslashes($rs['telephone']);
    $residence_telephone = stripslashes($rs['residence_telephone']);
    $fax = stripslashes($rs['fax']);
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

    $gst_no = stripslashes($rs["gst_no"]);

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
    $i_am = str_replace("Other", "", $i_am);

    $other_i_am = stripslashes($rs["other_i_am"]);
    if ($other_i_am != '') {
        if ($i_am != '') {
            $i_am = $i_am . ", " . $other_i_am;
        } else {
            $i_am = $other_i_am;
        }

    }

    $insolvency_professional_agency = stripslashes($rs['insolvency_professional_agency']);
    $insolvency_professional_number = stripslashes($rs['insolvency_professional_number']);
    $registered_insolvency_professional = stripslashes($rs['registered_insolvency_professional']);

    if (intval($registered_insolvency_professional) == intval(1)) {
        $registered_insolvency_professional = 'Y';
    } else {
        $registered_insolvency_professional = 'N';
    }

    $registered_insolvency_professional_number = stripslashes($rs['registered_insolvency_professional_number']);

    $sig_member = intval(stripslashes($rs['sig_member']));

    if (intval($sig_member) == intval(1)) {
        $sig_member = 'Y';
    } else {
        $sig_member = 'N';
    }

    $sig_company_id = intval(stripslashes($rs['sig_company_id']));
    $sig_company_name = getDetails(SIG24_TBL, 'company_name', "sig24_id", "$sig_company_id", '=', '', '', "");

    $young_practitioner = intval(stripslashes($rs['young_practitioner']));

    if (intval($young_practitioner) == intval(1)) {
        $young_practitioner = 'Y';
    } else {
        $young_practitioner = 'N';
    }

    $young_practitioner_enrolment = stripslashes($rs['young_practitioner_enrolment']);

    $interested = stripslashes($rs['interested']);

    $payment_status = stripslashes($rs['payment_status']);
    $payment_text = stripslashes($rs["payment_text"]);

    $add_by = stripslashes($rs['add_by']);

    $add_time = stripslashes($rs['add_time']);
    if ($add_time != '' && $add_time != '0000-00-00') {
        $add_time = date('d M, Y', strtotime($add_time));
    } else {
        $add_time = "";
    }

    $membership_start_date = stripslashes($rs['membership_start_date']);
    if ($membership_start_date != '' && $membership_start_date != '0000-00-00' && $membership_start_date != '1972-01-01' && $membership_start_date != '0001-11-30') {
        $membership_start_date = date('d M, Y', strtotime($membership_start_date));
    } else {
        $membership_start_date = "";
    }

    $membership_expired_date = stripslashes($rs['membership_expired_date']);
    if ($membership_expired_date != '' && $membership_expired_date != '0000-00-00' && $membership_expired_date != '1972-01-01' && $membership_expired_date != '0001-11-30') {
        $membership_expired_date = date('d M, Y', strtotime($membership_expired_date));
    } else {
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
        ->setCellValue('J' . $ROW, $gst_no)
        ->setCellValue('K' . $ROW, $correspondence_address_1)
        ->setCellValue('L' . $ROW, $correspondence_address_2)
        ->setCellValue('M' . $ROW, $correspondence_city)
        ->setCellValue('N' . $ROW, $correspondence_state)
        ->setCellValue('O' . $ROW, $correspondence_pin)
        ->setCellValue('P' . $ROW, $correspondence_country)
        ->setCellValue('Q' . $ROW, $permanent_address_1)
        ->setCellValue('R' . $ROW, $permanent_address_2)
        ->setCellValue('S' . $ROW, $permanent_city)
        ->setCellValue('T' . $ROW, $permanent_state)
        ->setCellValue('U' . $ROW, $permanent_pin)
        ->setCellValue('V' . $ROW, $permanent_country)
        ->setCellValue('W' . $ROW, $telephone)
        ->setCellValue('X' . $ROW, $residence_telephone)
        ->setCellValue('Y' . $ROW, $mobile)
        ->setCellValue('Z' . $ROW, $fax)
        ->setCellValue('AA' . $ROW, $email)
        ->setCellValue('AB' . $ROW, $i_am)
        ->setCellValue('AC' . $ROW, $insolvency_professional_agency)
        ->setCellValue('AD' . $ROW, $insolvency_professional_number)
        ->setCellValue('AE' . $ROW, $registered_insolvency_professional)
        ->setCellValue('AF' . $ROW, $registered_insolvency_professional_number)
        ->setCellValue('AG' . $ROW, $young_practitioner)
        ->setCellValue('AH' . $ROW, $young_practitioner_enrolment)
        ->setCellValue('AI' . $ROW, $sig_member)
        ->setCellValue('AJ' . $ROW, $sig_company_name)
        ->setCellValue('AK' . $ROW, $interested)
        ->setCellValue('AL' . $ROW, $membership_start_date)
        ->setCellValue('AM' . $ROW, $membership_expired_date)
        ->setCellValue('AN' . $ROW, $payment_status)
        ->setCellValue('AO' . $ROW, $payment_text)
        ->setCellValue('AP' . $ROW, $add_time);

    $ROW++;
}

$ROW++;
$objPHPExcel->getActiveSheet()->setTitle($_SESSION["COMPANY_NAME"] . ' - Insol Member List');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

//Printing options
$objPHPExcel->getActiveSheet()->getPageMargins()
            ->setTop(0)
            ->setRight(0)
            ->setLeft(0)
            ->setBottom(0);

$objPHPExcel->getActiveSheet()->getPageSetup()->setFitToWidth(1)->setFitToHeight(0);

$objPHPExcel->getActiveSheet()
    ->getPageSetup()
    ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);


$filename = $_SESSION['COMPANY_NAME'] . ' : Insol Member - ' . date('YmdHis') . ".pdf";

$rendererName = PHPExcel_Settings::PDF_RENDERER_DOMPDF;
$rendererLibrary = 'dompdf';
$rendererLibraryPath = CMS_INCLUDES_RELATIVE_PATH . 'Classes/' . $rendererLibrary;

// Redirect output to a client�s web browser (PDF)
header('Content-Type: application/pdf');
header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
header('Cache-Control: max-age=0'); //no cache
// $objWriter = new PHPExcel_Writer_PDF($objPHPExcel);
if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
    die('NOTICE: Please set the $rendererName and $rendererLibraryPath values' . PHP_EOL . 'at the top of this script as appropriate for your directory structure');
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'PDF'); 
$objWriter->setSheetIndex(0);
// $objWriter->save(CMS_INCLUDES_RELATIVE_PATH . 'pdfs');
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