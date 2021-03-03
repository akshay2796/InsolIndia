 <?php
 ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 $ui_id = $_GET['id'];
$connection = mysqli_connect("localhost","insolind_insolin","s_Lay@Z+_^?A","insolind_insolindia");
if(isset($_POST['renew'])){
    $reg_status = $_POST['ren_register_status'];
    $pay_status = $_POST['ren_payment_status'];
	$pay_text = $_POST['ren_payment_text'];
// 	$pay_receipt = $_POST['ren_payment_receipt'];
	$ren_expiry = $_POST['ren_expiry'];
	$post_image = $_FILES['ren_payment_receipt']['name'].time();
	$post_image_temp = $_FILES['ren_payment_receipt']['tmp_name'];
	move_uploaded_file($post_image_temp, "../uploads_insol/payment_reciept/renew_payment/$post_image");
			$query = "INSERT INTO renew_mamber(member_id, registration_status, payment_status, payment_details, membership_expire, payment_receipt, date)	VALUES ('$ui_id', '$reg_status', '$pay_status', '$pay_text', '$ren_expiry', '$post_image', now())";
			$result = mysqli_query($connection, $query); 
			
			$updateQuery = "UPDATE tbl_become_member SET membership_expired_date = '$ren_expiry', register_status = '$reg_status' WHERE member_id = '$ui_id'";
			mysqli_query($connection, $updateQuery); 
				echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://www.insolindia.com/cms/become_member_edit.php?con=modify&id=$ui_id\">";
		}
echo $ren_expiry;
?>