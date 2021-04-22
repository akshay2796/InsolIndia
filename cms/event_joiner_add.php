<?php
ob_start();
error_reporting(0);
include "header.php";

define("PAGE_MAIN", "event_joiner_edit.php");
define("PAGE_AJAX", "ajax_event_joiner.php");
define("PAGE_LIST", "event_joiner_list.php");

if (!is_dir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT)) {
    $mask = umask(0);
    mkdir(CMS_UPLOAD_FOLDER_RELATIVE_PATH . FLD_PAYMENT_RECIEPT, 0777);
    umask($mask);
}
$RESIZE_WIDTH = "200"; //main resize width
$RESIZE_HEIGHT = "200"; //main resize height

$RESIZE_REQUIRED = "NO";
$RESIZE_DIMENSION = $RESIZE_WIDTH . "X" . $RESIZE_HEIGHT; //widthXheight|weightXheight SEPRATED BY PIPE

$SAVE_RESIZE_LOCATION_RELPATH = "../" . CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
$RESIZE_PREFIX_RELPATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";

$event_joiner_id = (int) trim($_REQUEST["id"]);

?>


<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery-ui-1.9.1.custom.js"></script>
<link rel="stylesheet" href="<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH; ?>jquery-ui-1.10.4.css">

<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/plupload.full.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/plupload.html5.js"></script>

<script language="javascript" type="text/javascript">
//CODE FOR FILE UPLOAD STARTS....................

 $(function() {
    var uploader_main = new plupload.Uploader({
        //runtimes : 'gears,flash,html5,silverlight,browserplus',
        <?php
if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) {
    ?>
                runtimes : 'flash,html5',
        <?php
} else {
    ?>
            runtimes : 'html5,flash',
        <?php
}
?>
		browse_button : 'pickfiles_main',
		container : 'upload_container_main',
		max_file_size : '5mb',
      	url : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/ADV_upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . TEMP_UPLOAD; ?>',

        multipart_params: {
            "resize_image": "<?php echo $RESIZE_REQUIRED; ?>",
            "save_resized_images_to": "<?php echo $SAVE_RESIZE_LOCATION_RELPATH; ?>",
            "resize_size": "<?php echo $RESIZE_DIMENSION; ?>",
            "resize_image_name": "<?php echo $RESIZE_DIMENSION; ?>",
        },

        unique_names : false,
        multi_selection: true,

		flash_swf_url : '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/plupload.flash.swf',
		filters : [
			{title : "Image files", extensions : "jpg,jpeg,pjpeg,gif,png,pdf"}
		]
	});

	uploader_main.init();

	uploader_main.bind('FilesAdded', function(up, files) {

        $('#checkImgUploadingProgress').val(1);
        //CODE FOR AUTO UPLOAD.....
        uploader_main.start();
		////e.preventDefault();
		up.refresh(); // Reposition Flash/Silverlight
	});

    uploader_main.bind('UploadProgress', function(up, file) {
        var progressBarValue = up.total.percent;
        //$('#progressbar').fadeIn().progressbar({
        //    value: progressBarValue
        //});
        $('#filelist_main').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif" />');
    });


	uploader_main.bind('Error', function(up, err) {

        alert("Error: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");

		up.refresh(); // Reposition Flash/Silverlight
	});

    uploader_main.bind('UploadComplete', function() {
        //alert("1")
        $('#checkImgUploadingProgress').val(0);
        $('#filelist_main').html('<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload');
    });



	var images_file_name = "";
    var i=0;

	uploader_main.bind('FileUploaded', function(up, file) {
        var image_list_html = "";
        var image_default  = "";
        if(i==0)
        {
           //image_default = "checked";
           image_default = "";
        }
        else
        {
            image_default  = "";
        }

       var removeImageTR_CT = parseInt($(".removeImageTR").size());

        var fixedImgCT = $("#img_box_count").val();

        if( parseInt(fixedImgCT) == parseInt(0) )
        {
            var fixedImg_CT = parseInt(1);
            $("#img_box_count").val(1);
        }
        else
        {
            var fixedImg_CT = parseInt(fixedImgCT) + parseInt(1);
            $("#img_box_count").val(fixedImg_CT);
        }

	  	image_list_html = image_list_html + '<div class="removeImageTR uploadImgContainer">';
            	image_list_html = image_list_html + '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>';
				    image_list_html = image_list_html + '<input type="hidden" class="image_id" name="image_id[]" value="0" /><input type="hidden" class="cl_r_image" id="image[]" name="image[]" value="' + file.name + '" />';
               	    image_list_html = image_list_html + '<input type="hidden" class="folder_name" name="folder_name" value="<?php echo TEMP_UPLOAD; ?>" />';
                	image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span>';
                    image_list_html = image_list_html + '<a href="javascript:void(0)">';
                    if(file.name.split('.').pop() !='pdf')
                    {
                        image_list_html = image_list_html + '<img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file.name + '" class="fixedImg imgno'+fixedImg_CT+'" />';
                    }

                    image_list_html = image_list_html + '<br>' + file.name + '</a></span></div>';
               image_list_html = image_list_html + '</div>';
                image_list_html = image_list_html + '<div class="uploadImgBtn">';
					image_list_html = image_list_html + '<table><tr>';
					//image_list_html = image_list_html + '<td><input type="radio" name="default_image" id="default_image" title="Set Default" value="' + file.name + '" '+ image_default +'/></td>';
                    //image_list_html = image_list_html + '<td><input type="hidden" name="selected_coordinates" id="selected_coordinates" class="sel_coordinates'+fixedImg_CT+'" value=""><a href="javascript:void(0);" class="crop_img" foldername=<?php echo TEMP_UPLOAD; ?> value="' + file.name + '" imgno='+fixedImg_CT+'  addedimgID="0"></a> </td>';
					image_list_html = image_list_html + '<td><input type="text" class="txtCaption" placeholder="Caption" name="caption[]" maxlength="100" /><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'' + file.id + '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a></td>';
					image_list_html = image_list_html + '</tr></table>';
				image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '</div>';

		i++;

        $("#image_list").prepend(image_list_html);

        $("#pickfiles_main").hide(); //////////////////////For single image upload

        if( parseInt($(".removeImageTR").size()) > parseInt(0) )
        {
            $("#image_list").show();
        }

	});


    $.fn.removeImage = function() {
        var args = arguments[0] || {};
        var imageId = args.imageId || 0;
        var uFID = args.uFID || "";
        var foldername = args.foldername || "";
        var copy = args.copy || "";

        var indx = $(".removeImage").index(this);
        var cl_r_image = $(".cl_r_image:eq(" + indx + ")").val();
        //alert(uFID+"--"+imageId+"---"+foldername+"---"+copy);
        //return false;

        if( parseInt(imageId) > parseInt(0) )
        {
            var c = confirm("Are you sure you wish to remove?");
            if(!c)
            {
                return false;
            }
        }
        else
        {

        }
        //alert(imageId + "--"+cl_r_image )
        //remove only image
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImage&image_name=" + cl_r_image + "&imageId=" + imageId + "&foldername="+foldername+ "&copy="+copy,
            beforeSend: function() {
                $(".removeImage:eq(" + indx + ")").hide();
                $(".removeImageLoader:eq(" + indx + ")").show();
            },
            success: function(msg) {
                //alert(msg)
                //return false;
                $(".removeImageTR:eq(" + indx + ")").remove();
                $(".removeImageLoader").hide();

                $("#pickfiles_main").show(); //////////////


                if(uFID != "")
                {
                    $("#" + uFID).remove();
                }

            }
        });

    };



});



</script>

<script language="javascript" type="text/javascript">
$(document).ready(function(){

    $("#frm").validate({
        // errorElement:'label',
        /* errorPlacement: function( error , element ){
            if( element.attr('name') == 'i_am[]' ){
                error.appendTo("#i_am_error");
            }

        }, */

        ignore:[],
        rules: {
            fname: "required",
            surname: "required",
            address: "required",

            email: {
                required: true,
                email: true
            },

        },
        messages: {
            fname: "",
            surname: "",
            address: "",

            email: {
                required: "",
                email: ""
            },

        },
        submitHandler: function() {

            //alert("--");
            var formvalue = $("#frm").serialize();
            //console.log(formvalue);
            //return false;

            $.ajax({
                type: "POST",
                url: "ajax_event_joiner.php",
                data: "type=editData&" + formvalue,
                beforeSend: function() {
                    $("#INPROCESS").html("");
                    $("#INPROCESS").html("<i class='icon iconloader'></i> Processing...");
                },
                success: function(msg) {
                    // console.log(msg);
                    //alert(msg);
                    //return false;
                    var spl_txt = msg.split("~~~");
                    if( parseInt(spl_txt[1]) == parseInt(1) )
                    {
                        setTimeout(function(){
                            $("#frm")[0].reset();
                            //window.location.href = "<?php //echo 'become_member.php' ?>";

                            window.location.href = "<?php echo PAGE_LIST; ?>";



                        }, 1500);
                    }
                    else
                    {

                        $("#INPROCESS").show().html(spl_txt[2]);
                        if( parseInt(spl_txt[1]) == parseInt(2) )
                        {
                            $("#email").select();
                            $("#errorNL").fadeOut(3000);
                        }

                        setTimeout(function(){
                            $("#INPROCESS").html('');
                            //$("#INPROCESS").html('Submit');

                            $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' />&nbsp;<input type='button' id='backlist' name='backlist' value='Back To list' class='cancelBtn' /> ");

                        }, 2000);


                    }

                  }
            });

        }
    });


    $("#backlist").click(function(){
        location.href="<?php echo PAGE_LIST; ?>";
    });


});
</script>
<script type="text/javascript">
function checkNum(num)
{
    var w = "";
    var v = "0123456789";
    for (i=0; i < num.value.length; i++)
    {
    x = num.value.charAt(i);
    if (v.indexOf(x,0) != -1) w += x;
    }
    num.value = w;
}

function integerOnly(num)
{
    var w = "";
    var v = ".0123456789";
    for (i=0; i < num.value.length; i++)
    {
      x = num.value.charAt(i);
      if (v.indexOf(x,0) != -1) w += x;
    }
    num.value = w;
}
</script>

<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery.datepick.js"></script>
<script type="text/javascript">
function showDate(date) {
	alert('The date chosen is ' + date);
}
</script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH; ?>jquery.datepick.css";
</style>

<form name="frm" id="frm" action="" method="post" enctype="multipart/form-data">


<h1>
	Insol Event Joiner Details

    <div class="addProductBox"><a href="<?php echo PAGE_LIST; ?>" class="backBtn">Go to List</a></div>
</h1>


<div class="addWrapper">
	<div class="boxHeading">Modify</div>
    <div class="clear"></div>
    <div class="containerPad" id="editOrderSpecial">
        <div class="col-md-12">
            <h4>Basic Detail</h4>
        </div>
        <div class="col-md-4">
        	<div class="form-group">
        		<label>Title  <span>*</span></label>
        		<select class="form-control" name="title" id="title">
                    <option value="Mr.">Mr.</option>
                    <option value="Mrs." >Mrs.</option>
                    <option value="Ms."  >Ms.</option>
                    <option value="Dr."  >Dr.</option>
                    <option value="Prof."  >Prof.</option>
                    <option value="Hon'ble Mr. Justice."  >Hon'ble Mr. Justice.</option>
                    <option value="Hon'ble Ms. Justice."  >Hon'ble Ms. Justice.</option>
                </select>
        	</div>
        </div>
        <div class="col-sm-4">
			<div class="form-group">
				<label>First Name <span>*</span></label>
				<input type="text" class="form-control" name="fname" id="fname" placeholder="" maxlength="100" style="text-transform:capitalize" >
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Surname <span></span></label>
				<input type="text" class="form-control" name="surname" id="surname" placeholder="" maxlength="50" style="text-transform:capitalize" >
			</div>
		</div>

        <div class="col-sm-4">
			<div class="form-group">
				<label>Name as you wish it to appear on your badge: <span>*</span></label>
				<input type="text" class="form-control" name="name_on_badge" id="name_on_badge"  placeholder="" maxlength="50" style="text-transform:capitalize" >
			</div>
		</div>

        <div class="col-sm-4">
			<div class="form-group">
				<label>Firm <!--span>*</span--></label>
				<input type="text" class="form-control" name="firmname" id="firmname" placeholder="" maxlength="100" >
			</div>
		</div>
        <div class="col-sm-4">
			<div class="form-group">
				<label>Membership No. <!--span>*</span--></label>
				<input type="text" class="form-control" name="membership_no" id="membership_no" placeholder=""  maxlength="100" >
			</div>
		</div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Address  <span>*</span></label>
				<textarea class="form-control" rows="1" name="address" id="address"></textarea>
			</div>
		</div>

        <div class="col-sm-4">
			<div class="form-group">
				<label>Telephone <span>*</span></label>
				<input type="text" class="form-control" name="phone" id="phone" placeholder="" maxlength="12" onkeyup="integerOnly(this)">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
				<input type="text" class="form-control" name="email" id="email" placeholder="" >
			</div>
		</div>

        <div class="clr"></div>
		<div class="hrline"></div>
        <div class="col-md-12">
            <h4>Payment Summary</h4>
        </div>
		<div class="col-md-12">
			<div class="form-group">
				<label>Registration Fees <span>*</span></label>
				<textarea class="form-control" rows="1" name="registration_fees" id="registration_fees"></textarea>
			</div>
		</div>
        <div class="col-md-12">
			<div class="form-group">
				<label>If you wish to pay by cheque or NEFT, kindly fill in the below details <span>*</span></label>
				<textarea class="form-control" rows="1" name="pay_by" id="pay_by"></textarea>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>I enclose a cheque/draft/NEFT to the order of: <span>*</span></label>
                <select class="form-control" name="order_of" id="order_of">
                    <option value="NEFT" >NEFT</option>
                    <option value="CHEQUE"  >CHEQUE</option>
                    <option value="DRAFT" >DRAFT</option>
                </select>
			</div>
		</div>
        <div class="col-sm-4">
			<div class="form-group">
				<label>Cheque No: <!-- <span>*</span> --></label>
				<input type="text" class="form-control" name="cheque_no" id="cheque_no" placeholder="" maxlength="50">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>UTR No.: <!-- <span>*</span> --></label>
				<input type="text" class="form-control" name="utr_no" id="utr_no" placeholder="" maxlength="50" >
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Amount: <!-- <span>*</span> --></label>
				<input type="text" class="form-control" name="enclosed_amount" id="enclosed_amount" placeholder="" maxlength="10" onkeyup="integerOnly(this)"  >
			</div>
		</div>
        <div class="col-sm-12">
			<div class="form-group">
				<label>Address (if different from address on previous page): <!-- <span>*</span> --></label>
				<input type="text" class="form-control" name="draft_address" id="draft_address" placeholder="" maxlength="10" onkeyup="integerOnly(this)"  >
			</div>
		</div>

        <div class="col-md-12">
			<div class="form-group">
				<label><h4 class="bluetxt"><input type="checkbox" value="Yes" name="is_previously_attended" id="is_previously_attended"> Have you attended an INSOL India Conference previously?</h4></label>
			</div>
		</div>

        <div class="hrline"></div>
		<div class="clr"></div>
        <div class="col-md-12">
            <div class="form-group">
                <label>My registration number is</label><input type="text" class="form-control" name="registration_no" id="registration_no"  placeholder="">
			</div>
        </div>

        <div class="fullDivider">
        	<div class="sml_heading">Status Option <span></span> </div>
        </div>


       	<div class="fullWidth" style=" padding-bottom:0px;">
            <div class="width5">
                <label class="mainLabel">Registration Status</label>
                <?php
if (trim($payment_status) != "SUCCESSFUL") {
    ?>
                    <select name="status" id="status" class="selectBox">
                        <option value="Pending"  >Pending</option>
                        <option value="Approved" >Approved</option>
                        <option value="Declined">Declined</option>
                        <?php
if (trim($register_status) == "expired") {
        ?>
                            <option value="Expired" <?php if (trim($register_status) == "expired") {echo "Selected";}?> >Expired</option>
                        <?php
}
    ?>
                    </select>
                <?php
} else {
    echo "<b style='color:#18A15D;font-weight: bold;'>" . ucfirst($register_status) . "</b>";

    echo "<input type='hidden' name='register_status' id='register_status' value='" . ucfirst($register_status) . "' />";

}
?>
            </div>

            <?php
if (trim($register_status) == "approved" || trim($register_status) == "expired") {
    // if($sig_member == intval(0))
    // {

    ?>
                    <div class="width5">
                    	<label class="mainLabel">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="selectBox">
                            <option value="PENDING" >Pending</option>
                            <option value="SUCCESSFUL" >Successful</option>
                            <option value="CANCELLED"  >Cancelled</option>
                        </select>
                   </div>

                   <div class="width2">
                    	<label class="mainLabel">Payment Detail</label>
                        <input type="text" name="payment_text" value="<?php echo $payment_text; ?>" id="payment_text" autocomplete="OFF" class="txtBox" />
                    </div>
                </div>
                <!--==============RECIEPT UPLOAD STARTS==============================================================================================-->


                    <!--========================================================RECIEPT UPLOAD ENDS ========================================================-->

            <?php
}
?>

        </div>
        <div class="fullWidth">

            <div class="width2">
            	<label class="mainLabel">Internal Comments</label>
                <input type="text" name="internal_comments" value="<?php echo $internal_comments; ?>" id="internal_comments" autocomplete="OFF" class="txtBox" />
            </div>

        </div>

        <div class="fullWidth searchBtnWrap noGap" style="padding:0px;">
            <div class="submitWrapLoadFull" id="INPROCESS">
                <input type="submit" value="Save" name='save' id='save' class="submitBtn" />&nbsp;
                <input type="button" id="backlist" name="backlist" value="Back To list" class="cancelBtn" />
            </div>
        </div>

    </div><!--containerPad end-->
</div>
</form>

<?php
$connect = mysqli_connect("localhost", "ryanearf_insolindia", "ryanearf_akshay", "Friendship.101");
if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $fname = $_POST['fname'];
    $surname = $_POST['surname'];
    $naem_on_badge = $_POST['name_on_badge'];
    $firmname = $_POST['firmname'];
    $membership_no = $_POST['membership_no'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $registration_fees = $_POST['registration_fees'];
    $pay_by = $_POST['pay_by'];
    $order_of = $_POST['order_of'];
    $cheque_no = $_POST['cheque_no'];
    $utr_no = $_POST['utr_no'];
    $enclosed_amount = $_POST['enclosed_amount'];
    $draft_address = $_POST['draft_address'];
    $is_prev = $_POST['is_previously_attended'];
    $reg_no = $_POST['registration_no'];
    $status = $_POST['status'];
    $pay_status = $_POST['payment_status'];
    $int_comment = $_POST['internal_comments'];

    $query = "INSERT INTO tbl_event_joiner(membership_no, title, fname, surname, name_on_badge, firmname, phone, email, address, pay_by, order_of, cheque_no, utr_no, enclosed_amount, draft_address, is_previously_attended, registration_fees, registration_no, status, payment_status, internal_comments)
			VALUES ('$membership_no', '$title', '$fname','$surname', '$naem_on_badge', '$firmname','$phone', '$email', '$address','$pay_by', '$order_of', '$cheque_no','$utr_no','$enclosed_amount','$draft_address','$is_prev','$registration_fees','$reg_no','$status','$pay_status','$int_comment')";
    $result = mysqli_query($connect, $query);
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=event_joiner_list.php\">";

}
?>

<?php include "footer.php";?>