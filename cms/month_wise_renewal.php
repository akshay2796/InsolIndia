
<!DOCTYPE html>
<!--<html>-->


	<style>
	    tr,th,td{
	        /*white-space: nowrap;*/
	        padding-right: 34px;
	    }
	    table{
	        width:100%;
	            border-collapse: collapse;
	            border:none;

	    }
	</style>



	<?php
ob_start();
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

?>
    <table id="t1" border="0">
					<table id="t1" border="1">
					<tr width="100%" style="white-space:nowrap;">

						<th colspan=9>Bacic Details</th>
						<th colspan="6">CORRESPONDENCE ADDRESS</th>
						<th colspan="6">PERMANENT ADDRESS</th>
						<th colspan="5">Communication Details</th>
						<th colspan="14">Professional Details</th>
					</tr>
					<tr width="100%" >
					<th width="100%" >Serial No</th>
					<th width="100%" >Regd Id</th>
					<th width="100%" >Title</th>
					<th width="100%" >First</th>
					<th width="100%" >Middle</th>
					<th width="100%" >Lastname</th>
					<th width="100%" >Suffix</th>
					<th width="100%" >Full Name</th>
					<th width="100%" >Firm</th>
					<th width="100%" >Address 1</th>
					<th width="100%" >Address 2</th>
					<th width="100%" >City</th>
					<th width="100%" >State</th>
					<th width="100%" >Zip</th>
					<th width="100%" >Country</th>
					<th width="100%" >Address 1</th>
					<th width="100%" >Address 2</th>
					<th width="100%" >City</th>
					<th width="100%" >State</th>
					<th width="100%" >Zip</th>
					<th width="100%" >Country</th>
					<th width="100%" >Correspondence Landline</th>
					<th width="100%" >Residence Landline</th>
					<th width="100%" >Mobile</th>
					<th width="100%" >Fax</th>
					<th width="100%" >Email</th>
					<th width="100%" >I am</th>
					<th width="100%" >Name Of Insolvency Professional Agency</th>
					<th width="100%" >Registration NO. Of the Insolvency Professional Agency</th>
					<th width="100%" >IBBI Member(Y/N)</th>
					<th width="100%" >IBBI Registration NO.</th>
					<th width="100%" >I Am Young Practitioner(Y/N)</th>
					<th width="100%" >Young Practitioner Date Of Enrolment With My Professional Body Is</th>
					<th width="100%" >I AM AN SIG 24 Member (Y/N)</th>
				    <th width="100%" >SIG COMPANY NAME </th>
				    <th width="100%" >I AM INTERESTED IN BECOMING A MEMBER OF INSOL INDIA BECAUSE</th>
				    <th width="100%" >Membership Start Date</th>
				    <th width="100%" >Membership Expiry Date</th>
				    <th width="100%" >Renewal Start Date</th>
				    <th width="100%" >Renewal End Date</th>
				    <th width="100%" >Payment details</th>
				    <th width="100%" >Register Date</th>

				</tr>
    <?php
$counter = 1;
$year = $_GET['year'];
$month = $_GET['month'];
$connect = mysqli_connect("localhost", "root", "root", "insolindia") or die(mysqli_error($mysqli));
$sql_main = "SELECT * FROM renew_member_detail WHERE YEAR(add_date) = $year && MONTH(add_date) = $month";
$result_main = mysqli_query($connect, $sql_main);
while ($row_main = mysqli_fetch_array($result_main)) {
    $p_id = $row_main["p_id"];

    $sql = "SELECT * FROM tbl_become_member WHERE member_id = $p_id";
    $result = mysqli_query($connect, $sql);
    while ($row2 = mysqli_fetch_array($result)) {

        if ($row2["registered_insolvency_professional_number"] == "") {
            $op = 'N';
        } else {
            $op = 'Y';
        }
        if ($row2["young_practitioner"] == 0) {
            $ope = 'N';
        } else {
            $ope = 'Y';
        }
        if ($row2["sig_member"] == 0) {
            $sig = 'N';
        } else {
            $sig = 'Y';
        }
        ?>
<!--  -->


<tr>

							<td width="100%" ><?php echo "$counter" ?></td>
							<td width="100%" ><?php echo $row2["reg_number_text"] ?></td>
							<td width="100%" ><?php echo $row2["title"] ?></td>
							<td width="100%" ><?php echo $row2["first_name"] ?></td>
							<td width="100%" ><?php echo $row2["middle_name"] ?></td>
							<td width="100%" ><?php echo $row2["last_name"] ?></td>
							<td width="100%" ><?php echo $row2["suffix"] ?></td>
							<td width="100%" ><?php echo $row2["title"] . ' ' . $row2["first_name"] . ' ' . $row2["middle_name"] . ' ' . $row2["last_name"] ?></td>
							<td width="100%" ><?php echo $row2["firm_name"] ?></td>
							<td width="100%" ><?php echo $row2["address"] ?></td>
							<td width="100%" ><?php echo $row2["correspondence_address_2"] ?></td>
							<td width="100%" ><?php echo $row2["city"] ?></td>
							<td width="100%" ><?php echo $row2["correspondence_state"] ?></td>
							<td width="100%" ><?php echo $row2["pin"] ?></td>
							<td width="100%" ><?php echo $row2["country"] ?></td>

							<td width="100%" "><?php echo $row2["permanent_address"] ?></td>
							<td width="100%" "><?php echo $row2["permanent_address_2"] ?></td>
							<td width="100%" "><?php echo $row2["permanent_city"] ?></td>
							<td width="100%" "><?php echo $row2["permanent_state"] ?></td>
							<td width="100%" "><?php echo $row2["permanent_pin"] ?></td>
							<td width="100%" "><?php echo $row2["permanent_country"] ?></td>

							<td width="100%" ><?php echo $row2["telephone"] ?></td>
							<td width="100%" ><?php echo $row2["residence_telephone"] ?></td>
							<td width="100%" ><?php echo $row2["mobile"] ?></td>
							<td width="100%" ><?php echo $row2["fax"] ?></td>
							<td width="100%" ><?php echo $row2["email"] ?></td>

							<td width="100%" ><?php echo $row2["i_am"] ?></td>
							<td width="100%" ><?php echo $row2["insolvency_professional_agency"] ?></td>
							<td width="100%" ><?php echo $row2["insolvency_professional_number"] ?></td>
							<td width="100%" ><?php echo "$op" ?></td>
							<td width="100%" ><?php echo $row2["registered_insolvency_professional_number"] ?></td>
							<td width="100%" ><?php echo "$ope" ?></td>
							<td width="100%" ><?php echo $row2["young_practitioner_enrolment"] ?></td>
							<td width="100%" ><?php echo "$sig" ?></td>
						    <td width="100%" ><?php echo $row2["sig_company_name"] ?></td>
						    	<td width="100%" ><?php echo $row2["interested"] ?></td>
							<td width="100%" ><?php echo $row2["membership_start_date"] ?></td>
						    <td width="100%" ><?php echo $row2["membership_expired_date"] ?></td>
						    <td width="100%" ><?php echo $row_main["renewal_start_date"] ?></td>
						    <td width="100%" ><?php echo $row_main["renewal_end_date"] ?></td>
						    <td width="100%" ><?php echo $row_main["renewal_payment_detail"] ?></td>
						    <td width="100%" ><?php echo $row2["update_time"] ?></td>


						</tr>

<?php $counter++;}}?>
</table>
<?php

//
$filename = "Insol India insol_member.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"{$filename}\"");

?>








<!-- ("localhost","root","root","insolindia") -->