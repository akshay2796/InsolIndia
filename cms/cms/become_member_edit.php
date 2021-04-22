<?php
ob_start();
error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "header.php";

define("PAGE_MAIN", "become_member_edit.php");
define("PAGE_AJAX", "ajax_become_member.php");
define("PAGE_LIST", "become_member_list.php");

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

$member_id = (int) trim($_REQUEST["id"]);

if (intval($member_id) > intval(0)) {
    $con = "modify";

    $stmt = $dCON->prepare("select * from " . BECOME_MEMBER_TBL . " where member_id <> '' and member_id = ?");
    $stmt->bindParam(1, $member_id);
    $stmt->execute();
    $rsGET = $stmt->fetchAll();

    if (intval(count($rsGET)) > intval(0)) {

        $member_id = stripslashes($rsGET[0]["member_id"]);
        $reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);
        $reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);
        $reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);
        $reg_number = stripslashes($rsGET[0]["reg_number"]);

        $title = stripslashes($rsGET[0]["title"]);
        $first_name = ucwords(strtolower(stripslashes($rsGET[0]["first_name"])));
        $middle_name = ucwords(strtolower(stripslashes($rsGET[0]["middle_name"])));
        $last_name = ucwords(strtolower(stripslashes($rsGET[0]["last_name"])));
        $suffix = stripslashes($rsGET[0]["suffix"]);
        $firm_name = stripslashes($rsGET[0]["firm_name"]);
        $gst_no = stripslashes($rsGET[0]["gst_no"]);

        $address = stripslashes($rsGET[0]["address"]);
        $correspondence_address_2 = stripslashes($rsGET[0]["correspondence_address_2"]);
        $city = stripslashes($rsGET[0]["city"]);
        $correspondence_state = stripslashes($rsGET[0]["correspondence_state"]);
        $country = stripslashes($rsGET[0]["country"]);
        $pin = stripslashes($rsGET[0]["pin"]);

        //$image_name = trim(stripslashes($rsGET[0]['reciept_image_name']));
        //$image_id = intval(stripslashes($rsGET[0]['image_id']));

        $permanent_address = stripslashes($rsGET[0]["permanent_address"]);
        $permanent_address_2 = stripslashes($rsGET[0]["permanent_address_2"]);
        $permanent_city = stripslashes($rsGET[0]["permanent_city"]);
        $permanent_state = stripslashes($rsGET[0]["permanent_state"]);
        $permanent_country = stripslashes($rsGET[0]["permanent_country"]);
        $permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);

        $telephone = stripslashes($rsGET[0]["telephone"]);
        $residence_telephone = stripslashes($rsGET[0]["residence_telephone"]);
        $mobile = stripslashes($rsGET[0]["mobile"]);
        $fax = stripslashes($rsGET[0]["fax"]);

        $email = stripslashes($rsGET[0]["email"]);
        $password = stripslashes($rsGET[0]["password"]);

        $i_am = stripslashes($rsGET[0]["i_am"]);
        $other_i_am = stripslashes($rsGET[0]["other_i_am"]);

        $insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);
        $insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);
        $insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);
        $registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);
        $registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);
        $young_practitioner = intval($rsGET[0]["young_practitioner"]);
        $young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);

        $sig_member = intval($rsGET[0]["sig_member"]);
        $sig_company_id = intval($rsGET[0]["sig_company_id"]);
        $sig_company_name = stripslashes($rsGET[0]["sig_company_name"]);

        $interested = stripslashes($rsGET[0]["interested"]);
        $terms = stripslashes($rsGET[0]["terms"]);
        $committed = stripslashes($rsGET[0]["committed"]);
        $payment_text = stripslashes($rsGET[0]["payment_text"]);
        $payment_status = strtoupper(stripslashes($rsGET[0]["payment_status"]));
        $register_status = strtolower(stripslashes($rsGET[0]["register_status"]));
        $membership_start_date = stripslashes($rsGET[0]["membership_start_date"]);
        $membership_start_date_old = stripslashes($rsGET[0]["membership_start_date"]);

        if (trim($membership_start_date) != "" && $membership_start_date != "0000-00-00") {
            $membership_start_date = date('d-m-Y', strtotime($membership_start_date));
        } else {
            $membership_start_date = "";
        }

        $membership_expired_date = stripslashes($rsGET[0]["membership_expired_date"]);

        if (trim($membership_expired_date) != "" && $membership_expired_date != "0000-00-00") {
            $membership_expired_date = date('d-m-Y', strtotime($membership_expired_date));
        } else {
            $membership_expired_date = "";
        }

        $internal_comments = stripslashes($rsGET[0]["internal_comments"]);

        $add_date = date('d F Y', strtotime($rowOrd[0]['add_time']));

        $sql = "";
        $sql .= "SELECT * FROM tbl_become_member_receipt WHERE status= 'ACTIVE' and member_id = :member_id order by reciept_id ";
        $stmtImg = $dCON->prepare($sql);
        $stmtImg->bindParam(":member_id", $member_id);
        $stmtImg->execute();
        $rowImg = $stmtImg->fetchAll();
        $ImageCt = intval(count($rowImg));

        $FOLDER_NAME = FLD_PAYMENT_RECIEPT;
        $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $FOLDER_NAME;

    } else {
        ?>
<table width="100%" class="tbl" border="1" align="center">
    <tr>
        <td align="center" height=100 class="txt1" valign=center>
            <b>Invalid Access<br>Go Back to List and Try Again...</b>
        </td>
    </tr>
</table>
<?php

        exit();
    }

} else {
    ?>
<table width="100%" class="tbl" border=0 align=center>
    <tr>
        <td align="center" height=100 class="txt1" valign=center>
            <b>Invalid Access<br>Go Back to List and Try Again...</b>
        </td>
    </tr>
</table>


<?php
exit();
}

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
        runtimes: 'flash,html5',
        <?php
} else {
    ?>
        runtimes: 'html5,flash',
        <?php
}
?>
        browse_button: 'pickfiles_main',
        container: 'upload_container_main',
        max_file_size: '5mb',
        url: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/ADV_upload.php?DIRECTORY_PATH=<?php echo CMS_UPLOAD_FOLDER_ABS . TEMP_UPLOAD; ?>',

        multipart_params: {
            "resize_image": "<?php echo $RESIZE_REQUIRED; ?>",
            "save_resized_images_to": "<?php echo $SAVE_RESIZE_LOCATION_RELPATH; ?>",
            "resize_size": "<?php echo $RESIZE_DIMENSION; ?>",
            "resize_image_name": "<?php echo $RESIZE_DIMENSION; ?>",
        },

        unique_names: false,
        multi_selection: true,

        flash_swf_url: '<?php echo CMS_INCLUDES_RELATIVE_PATH; ?>fileuploder/plupload.flash.swf',
        filters: [{
            title: "Image files",
            extensions: "jpg,jpeg,pjpeg,gif,png,pdf"
        }]
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
        $('#filelist_main').html(
            '<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>load.gif" />');
    });


    uploader_main.bind('Error', function(up, err) {

        alert("Error: " + err.message + (err.file ? ", File: " + err.file.name : "") + "");

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader_main.bind('UploadComplete', function() {
        //alert("1")
        $('#checkImgUploadingProgress').val(0);
        $('#filelist_main').html(
            '<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload'
        );
    });



    var images_file_name = "";
    var i = 0;

    uploader_main.bind('FileUploaded', function(up, file) {
        var image_list_html = "";
        var image_default = "";
        if (i == 0) {
            //image_default = "checked";
            image_default = "";
        } else {
            image_default = "";
        }

        var removeImageTR_CT = parseInt($(".removeImageTR").size());

        var fixedImgCT = $("#img_box_count").val();

        if (parseInt(fixedImgCT) == parseInt(0)) {
            var fixedImg_CT = parseInt(1);
            $("#img_box_count").val(1);
        } else {
            var fixedImg_CT = parseInt(fixedImgCT) + parseInt(1);
            $("#img_box_count").val(fixedImg_CT);
        }

        image_list_html = image_list_html + '<div class="removeImageTR uploadImgContainer">';
        image_list_html = image_list_html +
            '<div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>';
        image_list_html = image_list_html +
            '<input type="hidden" class="image_id" name="image_id[]" value="0" /><input type="hidden" class="cl_r_image" id="image[]" name="image[]" value="' +
            file.name + '" />';
        image_list_html = image_list_html +
            '<input type="hidden" class="folder_name" name="folder_name" value="<?php echo TEMP_UPLOAD; ?>" />';
        image_list_html = image_list_html + '<div class="addPhotoIconTbl"><span>';
        image_list_html = image_list_html + '<a href="javascript:void(0)">';
        if (file.name.split('.').pop() != 'pdf') {
            image_list_html = image_list_html + '<img src="<?php echo $RESIZE_PREFIX_RELPATH; ?>' + file
                .name + '" class="fixedImg imgno' + fixedImg_CT + '" />';
        }

        image_list_html = image_list_html + '<br>' + file.name + '</a></span></div>';
        image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '<div class="uploadImgBtn">';
        image_list_html = image_list_html + '<table><tr>';
        //image_list_html = image_list_html + '<td><input type="radio" name="default_image" id="default_image" title="Set Default" value="' + file.name + '" '+ image_default +'/></td>';
        //image_list_html = image_list_html + '<td><input type="hidden" name="selected_coordinates" id="selected_coordinates" class="sel_coordinates'+fixedImg_CT+'" value=""><a href="javascript:void(0);" class="crop_img" foldername=<?php echo TEMP_UPLOAD; ?> value="' + file.name + '" imgno='+fixedImg_CT+'  addedimgID="0"></a> </td>';
        image_list_html = image_list_html +
            '<td><input type="text" class="txtCaption" placeholder="Caption" name="caption[]" maxlength="100" /><a href="javascript:void(0);" onclick="$(this).removeImage({uFID: \'' +
            file.id +
            '\',foldername:\'<?php echo TEMP_UPLOAD; ?>\'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a></td>';
        image_list_html = image_list_html + '</tr></table>';
        image_list_html = image_list_html + '</div>';
        image_list_html = image_list_html + '</div>';

        i++;

        $("#image_list").prepend(image_list_html);

        $("#pickfiles_main").hide(); //////////////////////For single image upload

        if (parseInt($(".removeImageTR").size()) > parseInt(0)) {
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

        if (parseInt(imageId) > parseInt(0)) {
            var c = confirm("Are you sure you wish to remove?");
            if (!c) {
                return false;
            }
        } else {

        }
        //alert(imageId + "--"+cl_r_image )
        //remove only image
        $.ajax({
            type: "POST",
            url: "<?php echo PAGE_AJAX; ?>",
            data: "type=removeImage&image_name=" + cl_r_image + "&imageId=" + imageId +
                "&foldername=" + foldername + "&copy=" + copy,
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


                if (uFID != "") {
                    $("#" + uFID).remove();
                }

            }
        });

    };



});
</script>

<script language="javascript" type="text/javascript">
$(document).ready(function() {

    $.validator.addMethod('ck_other_i_am', function(data) {
        if ($.trim($("#i_am_chkvalue").val()) == "Other" && $.trim($("#other_i_am").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');


    $.validator.addMethod('ck_insolvency', function(data) {
        if ($('#insolvency_professional').prop("checked") == true && $.trim($(
                "#insolvency_professional_agency").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');

    $.validator.addMethod('ck_insolvency_no', function(data) {
        if ($('#insolvency_professional').prop("checked") == true && $.trim($(
                "#insolvency_professional_number").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');


    $.validator.addMethod('ck_registered', function(data) {
        if ($('#registered_insolvency_professional').prop("checked") == true && $.trim($(
                "#registered_insolvency_professional_number").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');

    $.validator.addMethod('ck_young', function(data) {
        if ($('#young_practitioner').prop("checked") == true && $.trim($(
                "#young_practitioner_enrolment").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');

    $.validator.addMethod('ck_sig', function(data) {
        if ($('#sig_member').prop("checked") == true && $.trim($("#sig_company_id").val()) == "") {
            return false;
        } else {
            return true;
        }
    }, '');

    $.validator.addMethod('ck_sig_date', function(data) {
        if ($('#sig_member').prop("checked") == true && $.trim($("#membership_starts_date").val()) ==
            "" && $.trim($("#register_status").val()) == 'Approved') {
            return false;
        } else {
            return true;
        }
    }, '');


    $("#frm").validate({
        errorElement: 'label',
        errorPlacement: function(error, element) {
            if (element.attr('name') == 'i_am[]') {
                error.appendTo("#i_am_error");
            }

        },

        ignore: [],
        rules: {
            first_name: "required",
            last_name: "required",
            //firm_name: "required",
            address: "required",
            //correspondence_address_2: "required",
            city: "required",
            //correspondence_state: "required",
            country: "required",
            pin: "required",

            // permanent_address: "required",
            //  permanent_address_2: "required",
            //  permanent_city: "required",
            //  permanent_state: "required",
            //  permanent_country: "required",
            //  permanent_pin: "required",

            /*telephone: {
                  required: true,
                  minlength: 10
                }, */
            email: {
                required: true,
                email: true
            },
            'i_am[]': {
                required: true,
                minlength: 1
            },
            other_i_am: {
                ck_other_i_am: true
            },
            /*insolvency_professional_agency: {
                ck_insolvency: true
            }, */
            //insolvency_professional_agency: "required",
            /*insolvency_professional_number: {
                ck_insolvency_no: true
            }, */
            //insolvency_professional_number: "required",
            registered_insolvency_professional_number: {
                ck_registered: true
            },
            young_practitioner_enrolment: {
                ck_young: true
            },

            sig_company_id: {
                ck_sig: true
            },

            membership_starts_date: {
                ck_sig_date: true
            },

            interested: "required",
            membership_expired_date: "required",

        },
        messages: {
            first_name: "",
            last_name: "",
            // firm_name: "",
            address: "",
            //correspondence_address_2: "",
            city: "",
            //correspondence_state: "",
            country: "",
            pin: "",

            //  permanent_address: "",
            // permanent_address_2: "",
            //permanent_city: "",
            // permanent_state: "",
            // permanent_country: "",
            // permanent_pin: "",

            /*telephone: {
                  required: "",
                  minlength: ""
                }, */
            email: {
                required: "",
                email: ""
            },
            'i_am[]': ' Please check any one',
            other_i_am: "",
            //insolvency_professional_agency: "",
            //insolvency_professional_number: "",
            registered_insolvency_professional_number: "",
            young_practitioner_enrolment: "",
            sig_company_id: "",
            membership_starts_date: "",
            interested: "",
            membership_expired_date: "",

        },
        submitHandler: function() {

            //alert("--");
            var formvalue = $("#frm").serialize();
            //console.log(formvalue);
            //return false;

            $.ajax({
                type: "POST",
                url: "ajax_become_member.php",
                data: "type=editData&" + formvalue,
                beforeSend: function() {
                    $("#INPROCESS").html("");
                    $("#INPROCESS").html(
                        "<i class='icon iconloader'></i> Processing...");
                },
                success: function(msg) {
                    //alert(msg);
                    //return false;
                    var spl_txt = msg.split("~~~");
                    if (parseInt(spl_txt[1]) == parseInt(1)) {
                        setTimeout(function() {
                            $("#frm")[0].reset();
                            //window.location.href = "<?php echo 'become_member.php' ?>";

                            window.location.href = "<?php echo PAGE_LIST; ?>";



                        }, 1500);
                    } else {

                        $("#INPROCESS").show().html(spl_txt[2]);
                        if (parseInt(spl_txt[1]) == parseInt(2)) {
                            $("#email").select();
                            $("#errorNL").fadeOut(3000);
                        }

                        setTimeout(function() {
                            $("#INPROCESS").html('');
                            //$("#INPROCESS").html('Submit');

                            $("#INPROCESS").html(
                                "<input type='submit' value='Save' name='save' id='save' class='submitBtn' />&nbsp;<input type='button' id='backlist' name='backlist' value='Back To list' class='cancelBtn' /> "
                            );

                        }, 2000);


                    }

                }
            });

        }
    });



    $(".i_am").click(function() {

        var val = $(this).attr("value");

        if (val == 'Other' && $(this).prop("checked") == true) {
            $("#otherIm").show();
            $("#i_am_chkvalue").val("Other");
        } else if (val == 'Other' && $(this).prop("checked") == false) {
            $("#other_i_am").val("");
            $("#i_am_chkvalue").val("");
            $("#otherIm").hide();
        }
    });

    //for sig

    $("#sig_member").click(function() {
        var val1 = $(this).attr("value");
        if ($(this).prop("checked") == true) {
            $("#showSIG").show();
            $("#showMEMDATE").show();
        } else if ($(this).prop("checked") == false) {
            $("#showSIG").hide();
            $("#showMEMDATE").hide();
        }

    });


    $("#backlist").click(function() {
        location.href = "<?php echo PAGE_LIST; ?>";
    });

    // $('#renewal_start_date').datepicker().on('changeDate', function (e) {
    //     let startDate = $('#renewal_start_date').val();
    //     console.log('Renewal Start Date: ',startDate);
    // })


});
</script>
<script type="text/javascript">
function checkNum(num) {
    var w = "";
    var v = "0123456789";
    for (i = 0; i < num.value.length; i++) {
        x = num.value.charAt(i);
        if (v.indexOf(x, 0) != -1) w += x;
    }
    num.value = w;
}

function integerOnly(num) {
    var w = "";
    var v = ".0123456789";
    for (i = 0; i < num.value.length; i++) {
        x = num.value.charAt(i);
        if (v.indexOf(x, 0) != -1) w += x;
    }
    num.value = w;
}
</script>


<script>
/*

$(document).ready(function(){




     $("#frm").validate({
        rules: {

        },
        messages: {

        },
        submitHandler: function() {

            value = $("#frm").serialize();

            $.ajax({
                type: "POST",
                url: "<?php echo PAGE_AJAX; ?>",
                data: 'type=editData&' +value,
                beforeSend: function(){
                    $("#INPROCESS").html("<div id='inprocess'><input type='button' value='Save' name='save' id='save' class='process' /></div>");
                    //return false;
                },
                success: function(msg)
                {
                    //alert(msg);
                    var spl_txt = msg.split("~~~");
                    if(spl_txt[1] == '1')
                    {
                        colorStyle = "successTxt";

                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");

                        //$("#inprocess").fadeOut(3000);

                        setTimeout(function(){
                            location.href = "<?php echo PAGE_LIST; ?>";
                        },3000);
                    }
                    //else if(spl_txt[1] == '2')
                    else
                    {

                        colorStyle = "error";

                        $("#INPROCESS").html("<div id='inprocess'><input type='button' value='" + spl_txt[2] + "' name='save' id='save' class='" + colorStyle + "' /></div>");

                        setTimeout(function(){
                            $("#inprocess").fadeOut();
                            $("#INPROCESS").html("<input type='submit' value='Save' name='save' id='save' class='submitBtn' />&nbsp;<input type='button' id='backlist' name='backlist' value='Back To list' class='cancelBtn' /> ");


                        },1500);
                    }

                }
            })
        }
    });




});
*/
</script>
<script type="text/javascript" src="<?php echo CMS_INCLUDES_JS_RELATIVE_PATH; ?>jquery.datepick.js"></script>
<script type="text/javascript">
$(function() {

    // $('#membership_starts_date').datepicker({
    //     dateFormat: 'dd-mm-yy',
    //     changeMonth: true,
    //     changeYear: true,
    //     yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+5 year')); ?>'
    // });


    // $('#membership_expired_date').datepicker({
    //     dateFormat: 'dd-mm-yy',
    //     changeMonth: true,
    //     changeYear: true,
    //     yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+5 year')); ?>'
    // });
    $('#renewal_start_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+5 year')); ?>'
    }).on("change", function() {
        const sDate = $('#renewal_start_date').val().split("-");
        const startDate = new Date(`${sDate[1]}/${sDate[0]}/${sDate[2]}`)
        const dateOffset = (24 * 3600000)
        const endDate = startDate;
        endDate.setTime(endDate.getTime() - dateOffset);
        endDate.setFullYear(startDate.getFullYear() + parseInt($('#sig_member')[0].checked ? 2 : 1));
        const formattedDate =
            `${endDate.getDate().toString().padStart(2, "0")}-${(endDate.getMonth()+1).toString().padStart(2, "0")}-${endDate.getFullYear().toString()}`
        console.log('Renewal Start Date: ', startDate, 'Renewal End Date', formattedDate);
        $('#renewal_end_date').val(formattedDate);
    })

    $('#renewal_end_date').datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '<?php echo date("Y", strtotime('-1 year')); ?>:<?php echo date("Y", strtotime('+5 year')); ?>'
    });

    console.log('Changing Start Date');

});


function getFormattedDate(date, interval) {

}

function showDate(date) {
    alert('The date chosen is ' + date);
}
</script>
<style type="text/css">
@import "<?php echo CMS_INCLUDES_CSS_RELATIVE_PATH; ?>jquery.datepick.css";
</style>
<!--id="frm"  form id-->
<form name="frm" id="frm" action="become_member_list.php?" method="post" enctype="multipart/form-data">
    <input type="hidden" name="con" value="<?php echo $con; ?>" id="con" />
    <input type="hidden" name="id" value="<?php echo $member_id; ?>" id="id" />
    <input type="hidden" name="old_register_status" value="<?php echo $register_status; ?>" id="old_register_status" />
    <input type="hidden" name="old_payment_status" value="<?php echo $payment_status; ?>" id="old_register_status" />
    <input type="hidden" name="membership_start_date_old" value="<?php echo $membership_start_date_old; ?>"
        id="membership_start_date_old" />

    <input type="hidden" name="reg_number_text_temp" value="<?php echo $reg_number_text_temp; ?>"
        id="reg_number_text_temp" />
    <input type="hidden" name="reg_number_temp" value="<?php echo $reg_number_temp; ?>" id="reg_number_temp" />
    <input type="hidden" name="reg_number_text" value="<?php echo $reg_number_text; ?>" id="reg_number_text" />
    <input type="hidden" name="reg_number" value="<?php echo $reg_number; ?>" id="reg_number" />



    <h1>
        Insol Member Details
        <?php
if ($reg_number_text != '') {
    ?>
        <span class="txtColor">#<?php echo $reg_number_text; ?></span>
        <?php
}
?>
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
                    <label>Title <span>*</span></label>
                    <select class="form-control" name="title" id="title">
                        <option value="Mr." <?php if ($title == 'Mr.') {echo "selected";}?>>Mr.</option>
                        <option value="Mrs." <?php if ($title == 'Mrs.') {echo "selected";}?>>Mrs.</option>
                        <option value="Ms." <?php if ($title == 'Ms.') {echo "selected";}?>>Ms.</option>
                        <option value="Dr." <?php if ($title == 'Dr.') {echo "selected";}?>>Dr.</option>
                        <option value="Prof." <?php if ($title == 'Prof.') {echo "selected";}?>>Prof.</option>
                        <option value="Hon'ble Mr. Justice."
                            <?php if ($title == "Hon'ble Mr. Justice") {echo "selected";}?>>Hon'ble Mr. Justice.
                        </option>
                        <option value="Hon'ble Ms. Justice."
                            <?php if ($title == "Hon'ble Ms. Justice.") {echo "selected";}?>>Hon'ble Ms. Justice.
                        </option>
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>First Name <span>*</span></label>
                    <input type="text" class="form-control" name="first_name" id="first_name"
                        value="<?php echo $first_name; ?>" placeholder="" maxlength="100"
                        style="text-transform:capitalize">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Middle Name <span></span></label>
                    <input type="text" class="form-control" name="middle_name" id="middle_name"
                        value="<?php echo $middle_name; ?>" placeholder="" maxlength="50"
                        style="text-transform:capitalize">
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>Last Name <span>*</span></label>
                    <input type="text" class="form-control" name="last_name" id="last_name"
                        value="<?php echo $last_name; ?>" placeholder="" maxlength="50"
                        style="text-transform:capitalize">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Suffix</label>
                    <input type="text" class="form-control" name="suffix" id="suffix" value="<?php echo $suffix; ?>"
                        placeholder="" maxlength="50">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Firm
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="firm_name" id="firm_name" placeholder=""
                        value="<?php echo $firm_name; ?>" maxlength="100">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Gst No
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="gst_no" id="gst_no" placeholder=""
                        value="<?php echo $gst_no; ?>" maxlength="100">
                </div>
            </div>
            <!--div class="col-sm-4">
			<div class="form-group">
				<label>Telephone <span>*</span></label>
				<input type="text" class="form-control" name="telephone" id="telephone" placeholder="" maxlength="13" value="<?php echo $telephone; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Mobile </label>
				<input type="text" class="form-control" name="mobile" id="mobile" placeholder="" maxlength="12" value="<?php echo $mobile; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
				<input type="text" class="form-control" name="email" id="email" placeholder="" value="<?php echo $email; ?>">
			</div>
		</div-->


            <!--div class="col-md-12">
			<div class="form-group">
				<label>Correspondence address  <span>*</span></label>
				<textarea class="form-control" rows="2" name="address" id="address"><?php echo $address; ?></textarea>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>City <span>*</span></label>
				<input type="text" class="form-control" name="city" id="city" placeholder="" maxlength="50" value="<?php echo $city; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Country <span>*</span></label>
				<input type="text" class="form-control" name="country" id="country" placeholder="" maxlength="50" value="<?php echo $country; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Pin <span>*</span></label>
				<input type="text" class="form-control" name="pin" id="pin" placeholder="" maxlength="10" value="<?php echo $pin; ?>">
			</div>
		</div-->
            <div class="clr"></div>
            <div class="hrline"></div>
            <div class="col-md-12">
                <h4>Correspondence address</h4>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address 1 <span>*</span></label>
                    <textarea class="form-control" rows="1" name="address"
                        id="address"><?php echo $address; ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address 2
                        <!--span>*</span-->
                    </label>
                    <textarea class="form-control" rows="1" name="correspondence_address_2"
                        id="correspondence_address_2"><?php echo $correspondence_address_2; ?></textarea>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>City <span>*</span></label>
                    <input type="text" class="form-control" name="city" id="city" placeholder="" maxlength="50"
                        value="<?php echo $city; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>State
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="correspondence_state" id="correspondence_state"
                        placeholder="" maxlength="50" value="<?php echo $correspondence_state; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Country <span>*</span></label>
                    <input type="text" class="form-control" name="country" id="country" placeholder="" maxlength="50"
                        value="<?php echo $country; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Pin <span>*</span></label>
                    <input type="text" class="form-control" name="pin" id="pin" placeholder="" maxlength="10"
                        onkeyup="integerOnly(this)" value="<?php echo $pin; ?>">
                </div>
            </div>
            <!--div class="col-md-12 fullDivider">
        	<div style="border-top: 1px solid #ccc;"></div>
        </div>

        <div class="col-md-12">
			<div class="form-group">
				<label>Permanent Address  <span>*</span></label>
				<textarea class="form-control" rows="2" name="permanent_address" id="permanent_address"><?php echo $permanent_address; ?></textarea>
			</div>
		</div>

        <div class="col-sm-4">
			<div class="form-group">
				<label>City <span>*</span></label>
				<input type="text" class="form-control" name="permanent_city" id="permanent_city" placeholder="" maxlength="50" value="<?php echo $permanent_city; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Country <span>*</span></label>
				<input type="text" class="form-control" name="permanent_country" id="permanent_country" placeholder="" maxlength="50" value="<?php echo $permanent_country; ?>">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Pin <span>*</span></label>
				<input type="text" class="form-control" name="permanent_pin" id="permanent_pin" placeholder="" maxlength="10" value="<?php echo $permanent_pin; ?>">
			</div>
		</div-->

            <div class="clr"></div>
            <div class="hrline"></div>
            <div class="col-md-12">
                <h4>Permanent Address
                    <!--<input type="checkbox" value="1" name="address_check" id="address_check"/> check if different Address -->
                </h4>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address 1 <span>*</span></label>
                    <textarea class="form-control" rows="1" name="permanent_address"
                        id="permanent_address"><?php echo $permanent_address; ?></textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Address 2
                        <!--span>*</span-->
                    </label>
                    <textarea class="form-control" rows="1" name="permanent_address_2"
                        id="permanent_address_2"><?php echo $permanent_address_2; ?></textarea>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="form-group">
                    <label>City
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="permanent_city" id="permanent_city" placeholder=""
                        maxlength="50" value="<?php echo $permanent_city; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>State
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="permanent_state" id="permanent_state" placeholder=""
                        maxlength="50" value="<?php echo $permanent_state; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Country
                        <!--span>*</span-->
                    </label>
                    <input type="text" class="form-control" name="permanent_country" id="permanent_country"
                        placeholder="" maxlength="50" value="<?php echo $permanent_country; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Pin <span>*</span></label>
                    <input type="text" class="form-control" name="permanent_pin" id="permanent_pin" placeholder=""
                        maxlength="10" onkeyup="integerOnly(this)" value="<?php echo $permanent_pin; ?>">
                </div>
            </div>
            <div class="clr"></div>
            <div class="hrline"></div>
            <div class="col-md-12">
                <h4>Communication Detail</h4>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Mobile <span>*</span></label>
                    <input type="text" class="form-control" name="mobile" id="mobile" placeholder="" maxlength="12"
                        onkeyup="integerOnly(this)" value="<?php echo $mobile; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Email <span>*</span><span class="" style="color: red;" id="errorNL"></span></label>
                    <input type="text" class="form-control" name="email" id="email" placeholder=""
                        value="<?php echo $email; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Correspondence Landline </label>
                    <input type="text" class="form-control" name="telephone" id="telephone" placeholder=""
                        maxlength="12" onkeyup="integerOnly(this)" value="<?php echo $telephone; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Residence Landline </label>
                    <input type="text" class="form-control" name="residence_telephone" id="residence_telephone"
                        placeholder="" maxlength="12" onkeyup="integerOnly(this)"
                        value="<?php echo $residence_telephone; ?>">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Fax </label>
                    <input type="text" class="form-control" name="fax" id="fax" placeholder="" maxlength="12"
                        onkeyup="integerOnly(this)" value="<?php echo $fax; ?>">
                </div>
            </div>


            <div class="clr"></div>
            <div class="hrline"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt">I am <span>*</span></h4>
                    </label>&nbsp;<span id="i_am_error"></span>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Chartered Accountant" name="i_am[]" id="i_am[]"
                                    class='i_am'
                                    <?php if (in_array('Chartered Accountant', explode(", ", $i_am))) {echo " checked ";}?> />
                                Chartered Accountant
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Cost Accountant" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Cost Accountant', explode(", ", $i_am))) {echo " checked ";}?> />
                                Cost Accountant
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Advocate" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Advocate', explode(", ", $i_am))) {echo " checked ";}?> />
                                Advocate
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Company Secretary" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Company Secretary', explode(", ", $i_am))) {echo " checked ";}?> />
                                Company Secretary
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Judge" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Judge', explode(", ", $i_am))) {echo " checked ";}?> /> Judge
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Member of NCLT" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Member of NCLT', explode(", ", $i_am))) {echo " checked ";}?> />
                                Member of NCLT
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Acedemic" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Acedemic', explode(", ", $i_am))) {echo " checked ";}?> />
                                Acedemic
                            </label>
                        </div>
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox" value="Other" name="i_am[]" id="i_am[]" class='i_am'
                                    <?php if (in_array('Other', explode(", ", $i_am))) {echo " checked ";}?> /> Other
                            </label>
                            <span <?php if ($other_i_am == '') {?>style="display: none" <?php }?>id="otherIm">
                                <input type="text" class="form-control" name="other_i_am" id="other_i_am"
                                    placeholder="Please Specify" value="<?php echo $other_i_am; ?>">
                                <input type="hidden" class="form-control" name="i_am_chkvalue" id="i_am_chkvalue"
                                    style="display: none;">
                            </span>

                        </div>
                    </div>
                </div>
            </div>
            <div class="hrline"></div>
            <div class="clr"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt">
                            <!--input type="checkbox" value="1" name="insolvency_professional" id="insolvency_professional" <?php if (intval($insolvency_professional) >= intval(1)) {echo "checked=''";}?>/-->
                            I am Insolvency Professional registered with <span>*</span>
                        </h4>
                    </label>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-6">
                            <label>please specify the name of Insolvency Professional Agency</label>
                            <input type="text" class="form-control" name="insolvency_professional_agency"
                                id="insolvency_professional_agency" placeholder=""
                                value="<?php echo $insolvency_professional_agency; ?>">
                        </div>
                        <div class="col-md-6">
                            <label>My registration number is</label><input type="text" class="form-control"
                                name="insolvency_professional_number" id="insolvency_professional_number" placeholder=""
                                value="<?php echo $insolvency_professional_number; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="hrline"></div>
            <div class="clr"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt"><input type="checkbox" value="1" name="registered_insolvency_professional"
                                id="registered_insolvency_professional"
                                <?php if (intval($registered_insolvency_professional) >= intval(1)) {echo "checked=''";}?>>
                            I am registered Insolvency Professional with Insolvency and Bankruptcy Board of India.</h4>
                    </label>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-12">
                            <label>My registration number is</label><input type="text" class="form-control"
                                name="registered_insolvency_professional_number"
                                id="registered_insolvency_professional_number"
                                value="<?php echo $registered_insolvency_professional_number; ?>" placeholder="">
                        </div>
                    </div>
                </div>
            </div>

            <div class="hrline"></div>
            <div class="clr"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt"><input type="checkbox" value="1" name="sig_member" id="sig_member"
                                <?php if (intval($sig_member) == intval(1)) {echo "checked";}?>> I am an SIG 24 Member.
                        </h4>
                    </label>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-12" id="showSIG"
                            <?php if ($sig_member == intval(0)) {echo "style='display:none'";}?>>
                            <?php
$SQL = "SELECT sig24_id, company_name FROM " . SIG24_TBL . " WHERE status = 'ACTIVE' ";
$sGET = $dCON->prepare($SQL);
$sGET->execute();
$rsGET = $sGET->fetchAll();
$sGET->closeCursor();
if (intval(count($rsGET)) > intval(0)) {
    ?>
                            <select name="sig_company_id" id="sig_company_id" class="form-control"
                                style="width: 441px;">
                                <option value="">Select Company</option>
                                <?php
foreach ($rsGET as $sVAL) {
        $company_name = stripslashes($sVAL['company_name']);
        $company_id = intval($sVAL['sig24_id']);
        ?>
                                <option value="<?php echo $company_id; ?>"
                                    <?php if ($sig_company_id == $company_id) {echo "selected";}?>>
                                    <?php echo $company_name; ?></option>

                                <?php
}
    ?>
                            </select>
                            <?php
}
?>


                        </div>
                    </div>
                </div>
            </div>

            <div class="hrline"></div>
            <div class="clr"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt"><input type="checkbox" value="1" name="young_practitioner"
                                id="young_practitioner"
                                <?php if (intval($young_practitioner) >= intval(1)) {echo "checked=''";}?>> I am a Young
                            Practitioner. I confirm I have less than ten years experience in my profession mentioned
                            above. </h4>
                    </label>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-12">
                            <label>My date of enrolment with my professional body is</label><input type="text"
                                class="form-control" name="young_practitioner_enrolment"
                                id="young_practitioner_enrolment" placeholder=""
                                value="<?php echo $young_practitioner_enrolment; ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="hrline"></div>
            <div class="clr"></div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>
                        <h4 class="bluetxt">I am interested in becoming a member of INSOL India because <span>*</span>
                        </h4>
                    </label>
                    <div class="row">
                        <div class="clr"></div>
                        <div class="col-md-12">
                            <textarea class="form-control" rows="2" name="interested"
                                id="interested"><?php echo $interested; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hrline"></div>
            <div class="clr"></div>

            <div class="fullDivider">
                <div class="sml_heading">Status Option <span></span> </div>
            </div>


            <div class="fullWidth" style=" padding-bottom:0px;">
                <div class="width5">
                    <label class="mainLabel">Registration Status</label>
                    <?php
if (trim($payment_status) != "SUCCESSFUL") {
    ?>
                    <select name="register_status" id="register_status" class="selectBox">

                        <option value="Pending" <?php if (trim($register_status) == "pending") {echo "Selected";}?>>
                            Pending</option>
                        <option value="Approved" <?php if (trim($register_status) == "approved") {echo "Selected";}?>>
                            Approved</option>
                        <option value="Declined" <?php if (trim($register_status) == "declined") {echo "Selected";}?>>
                            Declined</option>

                        <option value="Renewal" name="renew"
                            <?php if (trim($register_status) == "renewal") {echo "Selected";}?>>Renewal</option>
                        <?php
if (trim($register_status) == "expired" || trim($register_status) == "renewal") {
        ?>
                        <option value="Expired" <?php if (trim($register_status) == "expired") {echo "Selected";}?>>
                            Expired</option>
                        <!--<option value="Renewal" name="renew" <?php /* if ( trim($register_status) == "renewal" ) { echo "Selected"; } */?> >Renewal</option>-->
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
echo $membership_start_date;
if (trim($register_status) == "pending" || $sig_member == intval(1)) {
    $member_id = $_REQUEST['id'];
    $connection = mysqli_connect("localhost", "ryanearf_akshay", "Friendship.101", "ryanearf_insolindia") or die(mysqli_error($mysqli));
    $query = "SELECT * FROM tbl_become_member WHERE member_id = $member_id";
    $result = mysqli_query($connection, $query);
    $show = mysqli_fetch_array($result);
    $membership_start_date = $show['membership_start_date'];
    // $title =  $show['title'];
    // echo $membership_start_date;
    ?>
                <!--        <div class="width2" id="showMEMDATE" ?> -->
                <!--	<label class="mainLabel">Membership Start Date <span>*</span> <?php if ($member_since_date != '') {?> <span style="font-size: 9px;">[SIG Member Since <?php echo $member_since_date; ?>] </span><?php }?></label> -->
                <!--    <div class="txt2Box">-->
                <!--        <input type="text" class="titleTxt txtBox" name="membership_starts_date" id="membership_starts_date" value="<?php echo $membership_start_date; ?>" maxlength="12" placeholder="" style="width: 250px;" autocomplete="OFF" />&nbsp;&nbsp;-->
                <!--    </div>  -->
                <!--</div>-->
                <?php
}
?>
                <div class="width2" id="showMEMDATE" ?>
                    <label class="mainLabel">Membership Start Date
                        <?php if ($member_since_date != '') {?> <span style="font-size: 9px;">[SIG Member Since
                            <?php echo $member_since_date; ?>] </span><?php }?></label>
                    <div class="txt2Box">
                        <input type="text" class="titleTxt txtBox" name="membership_starts_date"
                            id="membership_starts_date"
                            value="<?php echo date_format(date_create($membership_start_date), "d-m-Y"); ?>"
                            maxlength="12" placeholder="" style="width: 250px;" autocomplete="OFF"
                            readonly />&nbsp;&nbsp;
                    </div>
                </div>


                <?php
if (trim($register_status) == "renewal" || trim($register_status) == "approved" || trim($register_status) == "expired") {
    // if($sig_member == intval(0))
    // {

    ?>
                <div class="width5">
                    <label class="mainLabel">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="selectBox">
                        <option value="PENDING" <?php if (trim($payment_status) == "PENDING") {echo "Selected";}?>>
                            Pending</option>
                        <option value="SUCCESSFUL"
                            <?php if (trim($payment_status) == "SUCCESSFUL") {echo "Selected";}?>>Successful</option>
                        <option value="CANCELLED" <?php if (trim($payment_status) == "CANCELLED") {echo "Selected";}?>>
                            Cancelled</option>
                    </select>
                </div>

                <div class="width2">
                    <label class="mainLabel">Payment Detail</label>
                    <input type="text" name="payment_text" value="<?php echo $payment_text; ?>" id="payment_text"
                        autocomplete="OFF" class="txtBox" />
                </div>
            </div>












            <!--==============RECIEPT UPLOAD STARTS.==============================================================================================-->

            <div class="fullWidth noGap">
                <div class="form-group" id="uploadImgPos">
                    <label class="mainLabel"> Upload Payment Receipt <span style="color: #0080C0;">(Allowed Formats :
                            <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH ?>jpg.png" border="0" alt="jpg | jpeg"
                                title="jpg | jpeg">&nbsp<img
                                src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH ?>pngIcon.png" border="0" alt="png"
                                title="png">&nbsp<img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH ?>gif.png"
                                border="0" alt="gif" title="gif">)</span></label>
                    <span id="imagealert"></span>
                </div>
                <div class="fullWidth" id="image_list">
                    <?php
if (intval(count($rowImg)) > intval(0)) {

        foreach ($rowImg as $rsImg) {
            $display_image = "";
            $reciept_image_name = trim(stripslashes($rsImg['reciept_image_name']));
            $reciept_id = trim(stripslashes($rsImg['reciept_id']));
            $member_id = trim(stripslashes($rsImg['member_id']));
            $reciept_caption = trim(stripslashes($rsImg['reciept_caption']));

            $chk_file = chkImageExists($FOLDER_PATH . "/" . $reciept_image_name);

            if (intval($chk_file) == intval(1)) {
                $display_image = $FOLDER_PATH . "/" . $reciept_image_name;
            } else {
                $display_image = "";
            }

            if ($display_image != "") {
                $img_ext = pathinfo($reciept_image_name);
                ?>
                    <div class="removeImageTR uploadImgContainer" id="listItem_<?php echo $reciept_id; ?>">
                        <div class="uploadImgBox">
                            <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png"
                                class="fullImg" />
                            <input type="hidden" class="image_id" name="image_id[]"
                                value="<?php echo $reciept_id; ?>" />
                            <input type="hidden" class="cl_r_image" id="image[]" name="image[]"
                                value="<?php echo $reciept_image_name; ?>" />
                            <input type="hidden" class="folder_name" name="folder_name[]"
                                value="<?php echo $FOLDER_NAME; ?>" />

                            <div class="addPhotoIconTbl"><span><a
                                        href="<?php echo MODULE_FILE_FOLDER . $FOLDER_NAME . "/" . $reciept_image_name; ?>"
                                        target="_blank" title="Click To View">

                                        <?php
if ($img_ext['extension'] != 'pdf') {
                    ?>
                                        <img src="<?php echo $display_image; ?>"
                                            class="fixedImg imgno<?php echo $reciept_id; ?>" />
                                        <?php
}
                echo $reciept_image_name;
                ?>

                                    </a></span></div>
                        </div>
                        <div class="uploadImgBtn">
                            <table>
                                <tr>
                                    <td>
                                        <input style="width:100%; font-size:11px;" type="text" class="txtCaption"
                                            name="caption[]" placeholder="Caption"
                                            value="<?php echo $reciept_caption; ?>" />
                                        <a href="javascript:void(0);"
                                            onclick="$(this).removeImage({imageId:<?php echo $reciept_id; ?>,foldername:'<?php echo $FOLDER_NAME; ?>'});"
                                            class="removeImage"><img
                                                src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png"
                                                title="Delete" border="0" /></a><img
                                            src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif"
                                            class="removeImageLoader" style="display:none;" />
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <?php

            }
        }
    }
    ?>
                    <!--div for image upload button start-->
                    <div id="pickfiles_main" class="uploadImgContainer">
                        <div class="uploadImgBox">
                            <img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png"
                                class="fullImg" />
                            <div class="addPhotoIconTbl"><span><a href="#/" id="filelist_main"><img
                                            src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png"
                                            alt="Upload Reciepts" /><br />Upload</a></span></div>
                        </div>
                        <div class="uploadImgBtn"></div>
                    </div>
                    <!--div for image upload button end-->

                    <div id="upload_container_main"></div>

                </div>

                <!--========================================================RECIEPT UPLOAD ENDS ========================================================-->

                <?php
// }
    ?>
                <div id="upload_container_main" style="display: none;"></div>
                <?php
} else {
    ?>
                <div id="upload_container_main" style="display: none;"></div>
                <?php
}
?>

            </div>
            <div class="fullWidth">
                <?php
if ($membership_expired_date != "" || trim($register_status) == "expired") {
    /*
    if (trim($register_status) == "expired" )
    {
    $membership_expired_date = '';
    }
     */
    ?>
                <div class="width4">
                    <label class="mainLabel">Membership Expiry Date</label>
                    <input type="text" class="titleTxt txtBox" name="membership_expired_date"
                        id="membership_expired_date" value="<?php echo $membership_expired_date; ?>" maxlength="12"
                        placeholder="" autocomplete="OFF" readonly />&nbsp;&nbsp;
                </div>


                <?php
} else {

    echo "<input type='hidden' name='membership_expired_date' id='membership_expired_date' value='00-00-0000' readonly/>";

}
?>
                <div class="width2">
                    <label class="mainLabel">International Member Detail</label>
                    <input type="text" name="internal_comments" value="<?php echo $internal_comments; ?>"
                        id="internal_comments" autocomplete="OFF" class="txtBox" />
                </div>
            </div>
            <?php
$connection = mysqli_connect("localhost", "ryanearf_akshay", "Friendship.101", "ryanearf_insolindia") or die(mysqli_error($mysqli));
$query3 = "SELECT * FROM renew_member_detail where p_id = $member_id ORDER BY id DESC LIMIT 1";
$result3 = mysqli_query($connection, $query3);
//  while($show = mysqli_fetch_array($result3)){

// if ( $membership_expired_date != "" || trim($register_status) == "expired" )
// {
/*
if (trim($register_status) == "expired" )
{
$membership_expired_date = '';
}
 */
?>
            <div class="fullDivider">
                <div class="sml_heading">Renewal Option <span></span> </div>
            </div>
            <div class="width4">
                <label class="mainLabel">Renewal Start Date <span>*</span></label>
                <input type="text" class="titleTxt txtBox" name="renewal_start_date" id="renewal_start_date"
                    value="<?php echo $membership_expired_date; ?>" maxlength="12" placeholder=""
                    autocomplete="OFF" />&nbsp;&nbsp;
            </div>
            <div class="width4">
                <label class="mainLabel">Renewal End Date <span>*</span></label>
                <input type="text" class="titleTxt txtBox" name="renewal_end_date" id="renewal_end_date"
                    value="<?php echo $show['renewal_end_date']; ?>" maxlength="12" placeholder=""
                    autocomplete="OFF" />&nbsp;&nbsp;
            </div>
            <div class="width2">
                <label class="mainLabel">Renewal Payment Detail</label>
                <input type="text" name="renewal_payment_text" value="<?php echo $show['renewal_payment_detail']; ?>"
                    id="payment_text" autocomplete="OFF" class="txtBox" />
            </div>
            <?php
// }
// else
// {

//     echo "<input type='text' name='renewal_start_date' id='renewal_start_date' value='00-00-0000' />";
//      echo "<input type='text' name='renewal_end_date' id='renewal_start_date' value='00-00-0000' />";

// }
?>






            <!--div class="fullWidth" style="padding-bottom:0px;">
            <label class="mailStatus">Mail to Member </label><input type="checkbox"  name='sendStatus' value="YES" /> <span style="color: #ff0000;font-size: 10px;">(Check If Yes)  </span>
        </div-->

            <div class="fullWidth searchBtnWrap noGap" style="padding:0px;">
                <div class="submitWrapLoadFull" id="INPROCESS">
                    <input type="submit" value="Save" name='save' id='save' class="submitBtn" />&nbsp;
                    <!--<input type="submit" value="Save" formaction="paysuccessmail.php?member_id=" name='paysucessmail'  />&nbsp;-->
                    <input type="button" id="backlist" name="backlist" value="Back To list" class="cancelBtn" />
                    <!--<input type="submit" value="Renewal Reminder" name='renew' id='renew' class="renewBtn" />&nbsp;-->
                </div>
            </div>

        </div>
        <!--containerPad end-->
    </div>
</form>




</div>

/*<style>
*/
/*    .renewBtn{*/

/*    }*/
/*
</style> */

// <?php
//  $ui_id = $_GET['id'];
// $connection = mysqli_connect("localhost","ryanearf_akshay","Friendship.101","ryanearf_insolindia");
// if(isset($_POST['renew'])){
//             $pay_text = $_POST['pay_text'];
//             $query = "INSERT INTO tbl_renew_payment(member_id, payment_details, data) VALUES ('$ui_id', '$pay_text', CURDATE())";
//             $result = mysqli_query($connection, $query);
//                 echo "<meta http-equiv=\"refresh\" content=\"0;URL=https://www.insolindia.com/cms/become_member_list.php\">";
//         }
//     ;
// ?>


<?php

$u_id = $_GET['id'];
$connect = mysqli_connect("localhost", "ryanearf_akshay", "Friendship.101", "ryanearf_insolindia");
$sql = "SELECT * FROM tbl_become_member WHERE member_id='$u_id'";

$result = mysqli_query($connect, $sql);
$show2 = mysqli_fetch_array($result);
if ($show2['register_status'] == 'Expired' || $show2['register_status'] == 'Renewal') {
    ?>
<div class="containerPad container mainWrapper">
    <div class="fullDivider">
        <div class="sml_heading">Renewal Information <span></span> </div>
    </div>


    <?php
$u_id = $_GET['id'];
    $connect = mysqli_connect("localhost", "ryanearf_akshay", "Friendship.101", "ryanearf_insolindia");
    $sql = "SELECT * FROM renew_member_detail WHERE p_id='$u_id'";
    $result = mysqli_query($connect, $sql);
    ?>
    <div class="fullWidth" id="renewalDates" style="width: 50%;">
        <div class="width2">
            <label class="mainLabel">Date Of renewal</label>
            <?php

    while ($show3 = mysqli_fetch_array($result)) {?>

            <input type="text" name="payment_text" value="<?php echo $show3['add_date']; ?>" id="payment_text"
                autocomplete="OFF" class="txtBox" readonly="" />
            <a href="renew_export.php?member_id=<?php echo $u_id; ?>&add_date=<?php echo $show3['add_date']; ?>"><img
                    src="../includes_insol/images/cms-icon/excel_icon.png" border="0" title="Export to Excel"
                    alt="Export to Excel" align="absmiddle"></a>
            <br><br>


            <?php	}

    ?>
        </div>
    </div>

    <?php
$u_id = $_GET['id'];
    $connect = mysqli_connect("localhost", "ryanearf_akshay", "Friendship.101", "ryanearf_insolindia");
    $sql = "SELECT * FROM renew_member_detail WHERE p_id='$u_id'";
    $result = mysqli_query($connect, $sql);
    ?>
    <div class="fullWidth" id="renewalDates" style="width: 50%;">
        <div class="width2">
            <label class="mainLabel">Renewal Payment Details</label>

            <?php
$renewal_array = array();
    while ($show3 = mysqli_fetch_array($result)) {
        $renewal_array[explode("-", $show3["renewal_start_date"])[2]] = $show3["renewal_payment_detail"];
    }?>
            <select id="renewal_payment_detail" name="renewal_payment_detail" onchange="setPaymentDetail(this)"
                style="margin-right: 10px;">
                <?php
for ($i = array_keys($renewal_array)[count($renewal_array) - 1]; $i <= array_keys($renewal_array)[0]; $i++) {?>
                <option value="<?php echo $i ?>"><?php echo $i; ?>
                </option>
                <?php }
    ?>
            </select>
            <span
                id="renewal_payment_text"><?php echo $renewal_array[array_keys($renewal_array)[count($renewal_array) - 1]] ?>
            </span>
        </div>
    </div>
</div>

<?php }?>

<script>
function setPaymentDetail(selectField) {
    let yearArray = <?php echo json_encode($renewal_array) ?>;
    document.getElementById("renewal_payment_text").innerText = yearArray[selectField.value] === undefined ?
        "Not Renewed" : yearArray[selectField.value];
}
</script>


<!--<script-->
<!--  src="https://code.jquery.com/jquery-3.4.1.min.js"-->
<!--  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="-->
<!--  crossorigin="anonymous"></script>-->
<!--<script type="text/javascript">-->

<!--   function changeFunc() {-->
<!--    var selectBox = document.getElementById("register_status");-->
<!--    var selectedValue = selectBox.options[selectBox.selectedIndex].value;-->
<!--    if(selectedValue == 'Renewal'){-->
<!--        $("#renewalDates").toggle();-->
<!--    }-->
<!--   }-->

<!--  </script>-->


<?php

$member_id = $_REQUEST['id'];

$rsGET = getDetails(BECOME_MEMBER_TBL, '*', "member_id", $member_id, '=', '', '', "");

$member_id = stripslashes($rsGET[0]["member_id"]);
$reg_number_text_temp = stripslashes($rsGET[0]["reg_number_text_temp"]);
$reg_number_temp = stripslashes($rsGET[0]["reg_number_temp"]);

$reg_number_text = stripslashes($rsGET[0]["reg_number_text"]);
$reg_number = stripslashes($rsGET[0]["reg_number"]);

$title = stripslashes($rsGET[0]["title"]);
$first_name = stripslashes($rsGET[0]["first_name"]);
$middle_name = stripslashes($rsGET[0]["middle_name"]);
$last_name = stripslashes($rsGET[0]["last_name"]);
$name = "";
$name = $title . " " . $first_name;
if ($middle_name != '') {
    $name = $name . " " . $middle_name;
}
$name = $name . " " . $last_name;
$name = ucwords(strtolower($name));

$address = stripslashes($rsGET[0]["address"]);
$city = stripslashes($rsGET[0]["city"]);
$country = stripslashes($rsGET[0]["country"]);
$pin = stripslashes($rsGET[0]["pin"]);

$full_address = $address;
$full_address = $full_address . ", " . $city;
$full_address = $full_address . ", " . $country;
if ($pin != '') {
    $full_address = $full_address . " - " . $pin;
}

$permanent_address = stripslashes($rsGET[0]["permanent_address"]);
$permanent_city = stripslashes($rsGET[0]["permanent_city"]);
$permanent_country = stripslashes($rsGET[0]["permanent_country"]);
$permanent_pin = stripslashes($rsGET[0]["permanent_pin"]);

$permanent_full_address = $permanent_address;
$permanent_full_address = $permanent_full_address . ", " . $permanent_city;
$permanent_full_address = $permanent_full_address . ", " . $permanent_country;
if ($permanent_pin != '') {
    $permanent_full_address = $permanent_full_address . " - " . $permanent_pin;
}

$telephone = stripslashes($rsGET[0]["telephone"]);
if ($telephone != '') {
    $telephone = 'T. ' . $telephone;
}

$mobile = stripslashes($rsGET[0]["mobile"]);
if ($mobile != '') {
    $mobile = ' M. ' . $mobile;
} else {
    $mobile = '';
}

$email = stripslashes($rsGET[0]["email"]);
$password = stripslashes($rsGET[0]["password"]);

$i_am = stripslashes($rsGET[0]["i_am"]);

$other_i_am = stripslashes($rsGET[0]["other_i_am"]);
if ($other_i_am != '') {
    $i_am = $i_am . ", " . $other_i_am;
}

$insolvency_professional = stripslashes($rsGET[0]["insolvency_professional"]);
$insolvency_professional_agency = stripslashes($rsGET[0]["insolvency_professional_agency"]);
$insolvency_professional_number = stripslashes($rsGET[0]["insolvency_professional_number"]);
$registered_insolvency_professional = stripslashes($rsGET[0]["registered_insolvency_professional"]);
$registered_insolvency_professional_number = stripslashes($rsGET[0]["registered_insolvency_professional_number"]);
$young_practitioner = stripslashes($rsGET[0]["young_practitioner"]);
$young_practitioner_enrolment = stripslashes($rsGET[0]["young_practitioner_enrolment"]);
$interested = stripslashes($rsGET[0]["interested"]);
$terms = stripslashes($rsGET[0]["terms"]);
$committed = stripslashes($rsGET[0]["committed"]);
$payment_text = stripslashes($rsGET[0]["payment_text"]);
$payment_status = stripslashes($rsGET[0]["payment_status"]);
$register_status = strtolower(stripslashes($rsGET[0]["register_status"]));
$sig_member = stripslashes($rsGET[0]["sig_member"]);

$MAIL_BODY = '';
$MAIL_BODY .= '<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$MAIL_BODY .= '<tbody>';
$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td>';
$MAIL_BODY .= '<table width="600" border="0" cellspacing="0" cellpadding="20" style="border: 12px solid #efefef; font-family: Helvetica, Arial, sans-serif" align="center">';
$MAIL_BODY .= '<tbody>';
$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td style="border-bottom: 4px solid #ED1C24;"><img src="' . SITE_IMAGES . 'mail-logo.png" alt=""/></td>';
$MAIL_BODY .= '</tr>';

$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td bgcolor="#2E3192" style="color: #ffffff; padding: 12px 20px; text-align: center; font-size: 20px; font-weight: bold;">Dear ' . $name . '</td>';
$MAIL_BODY .= '</tr>';
if ($sig_member == intval(0)) {
    $MAIL_BODY .= '<tr>
                                        <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                                            <h1 style="color: #2E3192; font-size:16px;">We are delighted to renew your membership to INSOL India.</h1>
            								<h3 style="color: #ED1C24; font-size: 16px;">Your membership number is ' . $reg_number_text . '.</h3>

                                            Your login details are provided below as some features on website are accessible by members only.<br><br>

                                            <strong>Login ID:</strong> ' . $email . ' <br><br>
                                            <strong>Password:</strong> ' . $password . '<br>
                                            <br><br>
                                            <div style="border-top:1px solid #ccc">&nbsp;</div>
                                            <div style="font-size:11px;">
                								<h3 style="color: #000; font-size: 13px;">INSOL India Membership Benefits</h3>
                                                <p><span style="color: #2E3192; font-weight:bold;">Conferences</span> 20% discount on registration fee for Individual Members in conferences organised by INSOL India. One annual conference and a series of workshops in different parts of the country.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">INSOL India Newsletter</span> INSOL India has a quarterly newsletter which will be sent to all the Members free of charge.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Electronic Newsletter</span> INSOL India is planning to start an electronic monthly newsletter in August 2017 which will emailed to all members.</p>
                                                </p><span style="color: #2E3192; font-weight:bold;">Membership of INSOL International</span> As a member of INSOL India, one becomes a member of INSOL International, whereby one also becomes part of a network of 10,000 members in over 80 countries around the world. This enables one, apart from getting INSOL India\'s electronic and printed newsletters, access INSOL International\'s monthly technical electronic news updates and quarterly journal INSOL World, and other resource materials at INSOL International\'s website (www.insol.org) including INSOL Technical Library containing INSOL publications, technical paper series, case studies etc. As a member, one is also able to use "search a member" tool under the Membership section to browse the database of INSOL International.</p>
                                                <p><span style="color: #2E3192; font-weight:bold;">Committees</span> Members keen to actively participate in INSOL India activities can join various committees of INSOL India.</p>
                                            </div>



                                        </td>
                                    </tr>';
} else {
    $MAIL_BODY .= '<tr>
                                                <td valign="top" style="height: 250px; color: #333; text-align: left; font-size: 13px;">
                        								<h1 style="color: #2E3192; font-size:16px;">We extend our warm welcome to you as an esteemed SIG 24 members, INSOL India.</h1>
                                                        <p>As a SIG 24 members of INSOL India, your membership is valid for 2 years.</p>
                                                        <p>Your membership and login details are provided below, as some features on the website are accessible by members only.</p>
                                                        Membership Number: ' . $reg_number_text . ' <br>
                                                        <strong>Login ID:</strong> ' . $email . ' <br>
                                                        <strong>Password:</strong> ' . $password . '<br><br>
                                                        For more details visit: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>
                                                </td>
                                            </tr>';
}

$MAIL_BODY .= '<tr>';
$MAIL_BODY .= '<td bgcolor="#f5f5f5" style="color: #333; text-align: center; font-size: 11px;border-top: 8px solid #000;">';
$MAIL_BODY .= '5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br />Contact No. 011 49785744';
$MAIL_BODY .= 'Email: <a href="mailto:contact@insolindia.com" style="color: #333; text-decoration: underline;">contact@insolindia.com</a> | Website: <a href="http://www.insolindia.com" style="color: #333; text-decoration: underline;">www.insolindia.com</a>';
$MAIL_BODY .= '</td>';
$MAIL_BODY .= '</tr>';
$MAIL_BODY .= '</tbody>';
$MAIL_BODY .= '</table>';
$MAIL_BODY .= '</td>';
$MAIL_BODY .= '</tr>';
$MAIL_BODY .= '</tbody>';
$MAIL_BODY .= '</table>';
$MAIL_BODY .= '<div style="height:10px;"></div>';
$MAIL_BODY .= '<div style="text-align: center;" id="INPROCESS">';
$MAIL_BODY .= '<a href="javascript:void(0);" id="submit" value="' . $member_id . '"><img src="' . SITE_IMAGES . 'submit.png" alt=""/></a>&nbsp;&nbsp;
</div>
<div id="INPROCESS_1" style="display: none;"></div>';

?>


<?php

if (isset($_POST['saveren'])) {

// $email = $_REQUEST['email'];
// $message = $_REQUEST['message'];

    $mail = new phpmailer;

    $mail->IsSMTP();
//$mail->Host     = "mail.acecabs.in.cust.a.hostedemail.com";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "Newpass@0112";

    $mail->Host = "103.21.58.112";
//$mail->Username = "noreply@acecabs.in";
//$mail->Password = "dOvb15^8";
    $mail->Username = "noreply@insolindia.com";
    $mail->Password = "f2B7~w)C[5d4";

    $mail->Port = 25;
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = true;

    $mail->From = "contact@insolindia.com";

    $mail->FromName = "insolindia";
    $mail->ContentType = "text/html";

    $to = $email;
    $mail->Subject = "Your Insol India Membership Has Been Renew";

    $mail->AddAddress("$email");
    $mail->Body = "$MAIL_BODY";
    $mail->AddCC("contact@insolindia.com");

    $mailSent = $mail->send();
    $mail->ClearAddresses();

    if ($mailSent):

        $previousPage = $_SERVER["HTTP_REFERER"];
        header('Location: ' . $previousPage);
        echo "Mail Successfully Sent";
    else:
        echo "Sorry cannot process your request.";
    endif;
    ob_flush();
}

?>

<?php include "footer.php";?>