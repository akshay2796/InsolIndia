
<!DOCTYPE html>
<!--<html>-->
<!--<head>-->
<!--	<title></title>-->
<!--	<script type="text/javascript">-->
<!--		var getParams = function (url) {-->
<!--	var params = {};-->
<!--	var parser = document.createElement('a');-->
<!--	parser.href = url;-->
<!--	var query = parser.search.substring(1);-->
<!--	var vars = query.split('&');-->
<!--	for (var i = 0; i < vars.length; i++) {-->
<!--		var pair = vars[i].split('=');-->
<!--		params[pair[0]] = decodeURIComponent(pair[1]);-->
<!--	}-->
<!--	return params;-->
<!--};-->
<!--var st = getParams(window.location.href);-->
<!--console.log(st);-->
<!--if(st == 'ex'){-->
<!--	console.log("hello");-->
<!--}-->


<!--	</script>-->
<!--</head>-->
<!--<body>-->

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
error_reporting(E_ALL);
if (isset($_POST['frexp'])) {

    $checkbox = $_POST['chk'];
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
				    <th width="100%" >Payment details</th>
				    <th width="100%" >Register Date</th>

				</tr>
    <?php
$counter = 1;

    for ($i = 0; $i < count($checkbox); $i++) {

        $del_id = $checkbox[$i];
        $connect = mysqli_connect("localhost", "sabsoin_ins_user", "Yrs[aidZ&8gA", "sabsoin_insol_india");
        $sql = "SELECT * FROM tbl_become_member WHERE member_id='$del_id'";
        $result = mysqli_query($connect, $sql);
        $row2 = mysqli_fetch_array($result);
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
						    <td width="100%" ><?php echo $row2["payment_text"] ?></td>
						    <td width="100%" ><?php echo $row2["update_time"] ?></td>


						</tr>

<?php
$counter++;
    }
    ?>
</table>
<?php

// if successful redirect to delete_multiple.php
    // if($result){
    // echo "<meta http-equiv=\"refresh\" content=\"0;URL=export.php\">";
    // }
    $file = "Insol India insol_member.xls";
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=\"{$file}\"");
// echo "<meta http-equiv=\"refresh\" content=\"0;URL=become_member_list.php\">";
}
?>








<!-- ("localhost","root","root","insolindia") -->