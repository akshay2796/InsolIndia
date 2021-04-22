<!doctype html>


<?php

$connect = mysqli_connect("localhost", "ryanearf_insolindia", "ryanearf_akshay", "Friendship.101");

if (isset($_POST['submit'])) {
    $appl = $_POST['appl'];
    $country = $_POST['country'];
    $doa = $_POST['doa'];
    $dov = $_POST['dov'];
    $poa = $_POST['poa'];
    $pox = $_POST['pox'];
    $surname = $_POST['surname'];
    $pname = $_POST['pname'];
    $mn = $_POST['mn'];
    $pn = $_POST['pn'];
    $gen = $_POST['gen'];
    $dob = $_POST['dob'];
    $ctob = $_POST['ctob'];
    $cob = $_POST['cob'];
    $eq = $_POST['eq'];
    $nati = $_POST['nati'];
    $pnati = $_POST['pnati'];
    $passno = $_POST['passno'];
    $placeissue = $_POST['placeissue'];
    $doissue = $_POST['doissue'];
    $doexo = $_POST['doexo'];
    $anyvalid = $_POST['anyvalid'];
    $fathname = $_POST['fathname'];
    $fathpob = $_POST['fathpob'];
    $fathnati = $_POST['fathnati'];
    $mothname = $_POST['mothname'];
    $mothpob = $_POST['mothpob'];
    $mothnati = $_POST['mothnati'];
    $spousname = $_POST['spousname'];
    $pobspouce = $_POST['pobspouce'];
    $natiofspo = $_POST['natiofspo'];
    $porffdetail = $_POST['porffdetail'];
    $empname = $_POST['empname'];
    $jobtitle = $_POST['jobtitle'];
    $empaddress = $_POST['empaddress'];
    $policeorg = $_POST['policeorg'];
    $livisit = $_POST['livisit'];
    $tov = $_POST['tov'];
    $placeofissue = $_POST['placeofissue'];
    $dateofissue = $_POST['dateofissue'];
    $addolv = $_POST['addolv'];
    $noneu = $_POST['noneu'];
    $agree = $_POST['agree'];
    $image = $_FILES['image']['name'];
    $store = $_FILES['image']['tmp_name'];
    move_uploaded_file($store, "upload/" . $image);
    $on = rand(1000, 9999);
    $on1 = 'IN00' . $on;
    //echo '<pre>';
    //print_r($_REQUEST);
    //  echo '</pre>';

    $insert_query = "INSERT INTO evisa SET
      image='$image',
      ref_no='$on1',
      appl='$appl',
      country='$country',
      doa='$doa',
      dov='$dov',
      poa='$poa',
      pox='$pox',
      surname='$surname',
      pname='$pname',
      mn='$mn',
      pn='$pn',
      gen='$gen',
      dob='$dob',
      ctob='$ctob',
      cob='$cob',
      eq='$eq',
      nati='$nati',
      pnati='$pnati',
      passno='$passno',
      placeissue='$placeissue',
      doissue='$doissue',
      doexo='$doexo',
      anyvalid='$anyvalid',
      fathname='$fathname',
      fathpob='$fathpob',
      fathnati='$fathnati',
      mothname='$mothname',
      mothpob='$mothpob',
      mothnati='$mothnati',
      spousname='$spousname',
      pobspouce='$pobspouce',
      natiofspo='$natiofspo',
      porffdetail='$porffdetail',
      empname='$empname',
      jobtitle='$jobtitle',
      empaddress='$empaddress',
      policeorg='$policeorg',
      livisit='$livisit',
      tov='$tov',
      placeofissue='$placeofissue',
      dateofissue='$dateofissue',
      addolv='$addolv',
      noneu='$noneu',
      agree='$agree'";

    $insert_execute = mysqli_query($connect, $insert_query);
    if ($insert_execute > 0) {
        $URL = "booking.php?no=$on1";
        echo "<script>location.href='$URL'</script>";
    } else {
        echo '<pre>';
        echo "Sorry there was an error sending your message. Please try again later";
        echo '</pre>';
    }

/*
/////File Upload

// In PHP versions earlier than 4.1.0, $HTTP_POST_FILES should be used instead
// of $_FILES.

$uploaddir = 'upload/';

$uploadfile = $uploaddir . basename($_FILES['image']['name']);

//  echo '<pre>';
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
//echo "File is valid, and was successfully uploaded.\n";
} else {
// echo "Possible invalid file upload !\n";
}
if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
//echo "File is valid, and was successfully uploaded.\n";
} else {
// echo "Possible invalid file upload !\n";
}

//  echo 'Here is some more debugging info:';
//  print_r($_FILES);

//   print "</pre>";

////// Email

$body=

'<table cellpadding="10px" border="1"   font-family: arial, sans-serif;
;width: 100%;font-size: 15px;><tbody>
<tr ><td colspan="2" bgcolor="lightgray" ><b><p align="center" >e-Tourist Visa (eTV) Application Details</p></b></td></tr>

<tr><td colspan="2"><b>Applicant</b></td></tr>
<tr><td>Reference Number</td><td width="50%">'.$on1.'</td></tr>
<tr><td>Number of Applicants</td><td width="50%">'.$appl.'</td></tr>
<tr><td>Your country</td><td>'.$country.'</td></tr>
<tr><td>Date of your arrival in India</td><td>'.$doa.'</td></tr>
<tr><td>Places to be visited in India</td><td>'.$dov.'</td></tr>
<tr><td>Port of arrival in India</td><td>'.$poa.'</td></tr>
<tr><td>Port of exit from India</td><td>'.$pox.'</td></tr>

<tr><td colspan="2"><b>Applicant Details</b></td></tr>

<tr><td>Surname (as shown in your passport)</td><td>'.$surname.'</td></tr>
<tr><td>Name (exactly as in passport)</td><td>'.$pname.'</td></tr>
<tr><td>Middle Name (if applicable exactly as in passport)</td><td>'.$mn.'</td></tr>
<tr><td>Previous Name (if applicable)</td><td>'.$pn.'</td></tr>
<tr><td>Gender</td><td>'.$gen.'</td></tr>
<tr><td>Date of Birth (DD/MM/YYYY)</td><td>'.$dob.'</td></tr>
<tr><td>City of Birth</td><td>'.$ctob.'</td></tr>
<tr><td>Country of Birth</td><td>'.$cob.'</td></tr>
<tr><td>Educational Qualification</td><td>'.$eq.'</td></tr>
<tr><td>Nationality</td><td>'.$nati.'</td></tr>
<tr><td>Previous Nationality (if any)</td><td>'.$pnati.'</td></tr>

<tr><td colspan="2"><b>Passport Details</b></td></tr>
<tr><td>Passport Number</td><td>'.$passno.'</td></tr>
<tr><td>Place of Issue</td><td>'.$placeissue.'</td></tr>
<tr><td>Date of Issue (DD/MM/YYYY)</td><td>'.$doissue.'</td></tr>
<tr><td>Date of Expiry (DD/MM/YYYY)</td><td>'.$doexo.'</td></tr>
<tr><td>Do you hold any other valid passport?* </b></td><td>'.$anyvalid.'</td></tr>

<tr><td colspan="2"><b>Family Details</b></td></tr>

<tr><td>Father&apos;s Name</td><td>'.$fathname.'</td></tr>
<tr><td>Father&apos;s Place of Birth</td><td>'.$fathpob.'</td></tr>
<tr><td>Father&apos;s Nationality</td><td>'.$fathnati.'</td></tr>
<tr><td>Mother&apos;s Name</td><td>'.$mothname.'</td></tr>
<tr><td>Mother&apos;s Place of Birth</td><td>'.$mothpob.'</td></tr>
<tr><td>Mother&apos;s Nationality</td><td>'.$mothnati.'</td></tr>
<tr><td>Spouse Name</td><td>'.$spousname.'</td></tr>
<tr><td>Place of Birth of Spouse</td><td>'.$pobspouce.'</td></tr>
<tr><td>Nationality of Spouse</td><td>'.$natiofspo.'</td></tr>
<tr><td>Profession/Occupation Details of Applicant</b></td><td>'.$porffdetail.'</td></tr>
<tr><td>Employer&apos;s Name</td><td>'.$empname.'</td></tr>
<tr><td>Job Title</td><td>'.$jobtitle.'</td></tr>
<tr><td>Employer&apos;s Address</td><td>'.$empaddress.'</td></tr>
<tr><td>Are/were you in a Military/Police/Security Organisation?</b></td><td>'.$policeorg.'</td></tr>

<tr><td colspan="2"><b>Applicants India Previous Visa / Currently Valid Visa Details</b></td></tr>
<tr><td>Last Indian Visa No. (if any)</td><td>'.$livisit.'</td></tr>
<tr><td>Type of Visa</td><td>'.$tov.'</td></tr>
<tr><td>Place of Issue</td><td>'.$placeofissue.'</td></tr>
<tr><td>Date of Issue (DD/MM/YYYY)</td><td>'.$dateofissue.'</td></tr>
<tr><td>Address of Last visit (if available)</td><td>'.$addolv.'</td></tr>
<tr><td>Non EU countries visited in last 10 years</td><td>'.$noneu.'</td></tr>
<tr><td>Passport</td><td> <a href="evisa-india.com/upload/'.$image.'"><img src="evisa-india.com/upload/'.$image.'" alt="passport" height="120" width="80"> </a></td></tr>
</tbody>
</table>';

$to='arti.artie@gmail.com';
$sub="e-visa Detail";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers.= 'From:info@evisa-india.com' . "\r\n";
$headers .= 'BCc : artilife@gmail.com'. "\r\n";
$headers .= "BCc : artie.chauhan@gmail.com";

$send_new=mail($to, $sub, $body, $headers);
if($send_new==true)
{
$URL="booking.php?no=$on1";
echo "<script>location.href='$URL'</script>";
}
else{
echo '<pre>';
echo "Sorry there was an error sending your message. Please try again later";
echo '</pre>';
}

/*

include 'mailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'localhost';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'info@evisa-india.com';                 // SMTP username
$mail->Password = 'hello@123456';                           // SMTP password
//$mail->Username = 'contact@evisa-india.com';                 // SMTP username
//$mail->Password = 'Hello@123';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

//$mail->setFrom('info@evisa-india.com', 'e-visa');
//$mail->addAddress('sachbhardwaj9@gmail.com', '');
//$mail->addAddress('seo@sabsoftzone.com', '');
//$mail->addBCC('santoshbeats@gmail.com');

//    // Add a recipient
//$mail->addReplyTo('sachbhardwaj9@gmail.com', 'e-visa');
//$mail->addCC('info@evisa-india.com');

$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'e-visa Detail';
$mail->Body    = $body;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->addAttachment('/uploads/image.jpg', 'new.jpg');    // Optional name
$mail->AddAttachment($uploadfile);
if(!$mail->send()) {
$URL="pay.php?no='$on1'&img='.$image.'";
echo "<script>location.href='$URL'</script>";
} else {

// echo "<script>alert('Details Sent');</script>";
$URL="pay.php";
echo "<script>location.href='$URL'</script>";

}

 */

}

?>


<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="WowThemez">

    <title>e-Visa India - India visa Online | Indian Immigration Services Limited</title>


    <link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">

    <!-- Font Awesome Icons CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Themify Icons CSS -->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Elegant Font Icons CSS -->
    <link rel="stylesheet" href="css/elegant-font-icons.css">
    <!-- Elegant Line Icons CSS -->
    <link rel="stylesheet" href="css/elegant-line-icons.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- animate CSS -->
    <link rel="stylesheet" href="css/animate.min.css">
    <!-- Venobox CSS -->
    <link rel="stylesheet" href="css/venobox/venobox.css">
    <!-- OWL-Carousel CSS -->
    <link rel="stylesheet" href="css/owl.carousel.css">
    <!-- Nivo Slider CSS -->
    <link rel="stylesheet" href="css/nivo-slider.css">
    <!-- Slick Nav CSS -->
    <link rel="stylesheet" href="css/slicknav.min.css">
    <!-- Main CSS -->
    <link rel="stylesheet" href="css/main.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="css/responsive.css">

    <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <div id='preloader'>
        <div class='loader'>
            <img src="img/preloader.gif" width="50" alt="">
        </div>
    </div><!-- Preloader -->

    <?php include 'include/header.php';?>



    <section class="page_header padding">
        <div class="display-table">
            <div class="table-cell">
                <div class="container">
                    <div class="page_content">
                        <h2>Apply <span>Visa</span></h2>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="">Home</a></li>
                            <li class="breadcrumb-item active">Apply Visa</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- Page Header -->

    <section id="news" class="blog_section bd-bottom padding">
        <div class="container">
            <div class="row">
                <div class="col-md-8 sm-padding">

                    <div class="contact_form">
                        <h2
                            style="    border-bottom: 1px solid #ccc;padding-bottom: 15px;font-size: 20px;color: #ff9833;font-weight: bold;">
                            e-Tourist Visa (eTV) Application</h2>
                        <br>
                        <form action="" method="post" id="" class="form-horizontal" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Number of Applicants</label>
                                    <select name="appl" required="">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>

                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label>Enter your country</label>
                                    <input type="text" id="name" name="country" class="form-control">

                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Date of your arrival in India (DD/MM/YYYY) <span>*</span></label>
                                    <input type="date" id="name" name="doa" class="form-control" required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Places to be visited in India <span>*</span></label>
                                    <input type="text" id="name" name="dov" class="form-control" required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Port of arrival in India <span>*</span></label>
                                    <input type="text" id="" name="poa" class="form-control" required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Port of exit from India <span>*</span></label>
                                    <input type="text" id="" name="pox" class="form-control" placeholder="" required="">
                                </div>
                            </div>

                            <h2 class="appli">Applicant 1</h2>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Surname (as shown in your passport) <span>*</span></label>
                                    <input type="text" id="" name="surname" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Name (exactly as in passport) <span>*</span></label>
                                    <input type="text" id="" name="pname" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Middle Name (if applicable exactly as in passport) <span>*</span></label>
                                    <input type="text" id="" name="mn" class="form-control" placeholder="" required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Previous Name (if applicable) <span>*</span></label>
                                    <input type="text" id=" " name="pn" class="form-control" placeholder="" required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Gender <span>*</span></label>
                                    <input type="text" id=" " name="gen" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Date of Birth (DD/MM/YYYY) <span>*</span></label>
                                    <input type="date" id=" " name="dob" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>





                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label> City of Birth: <span>*</span></label>
                                    <input type="text" id=" " name="ctob" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Country of Birth <span>*</span></label>
                                    <input type="text" id=" " name="cob" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Educational Qualification<span></span></label>
                                    <input type="text" id="" name="eq" class="form-control" placeholder="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Nationality<span>*</span></label>
                                    <input type="text" id="" name="nati" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Previous Nationality (if any) <span></span></label>
                                    <input type="text" id="" name="pnati" class="form-control" placeholder="">
                                </div>

                            </div>

                            <h2 class="appli">Passport Details</h2>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Passport Number<span>*</span></label>
                                    <input type="text" id="" name="passno" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Place of Issue:<span>*</span></label>
                                    <input type="text" id="" name="placeissue" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Date of Issue (DD/MM/YYYY) <span>*</span></label>
                                    <input type="date" id="" name="doissue" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Date of Expiry (DD/MM/YYYY)<span>*</span></label>
                                    <input type="date" id="" name="doexo" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Do you hold any other valid passport? (Yes or No)<span>* </span></label>
                                    <select name="anyvalid" required="">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>

                                    </select>
                                </div>

                            </div>

                            <h2 class="appli">Family Details</h2>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Father's Name <span>*</span></label>
                                    <input type="text" id="" name="fathname" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Father's Place of Birth<span>*</span></label>
                                    <input type="text" id="" name="fathpob" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Father's Nationality <span>*</span></label>
                                    <input type="text" id="" name="fathnati" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Mother's Name <span>*</span></label>
                                    <input type="text" id="" name="mothname" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Mother's Place of Birth <span>*</span></label>
                                    <input type="text" id="" name="mothpob" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Mother's Nationality<span>*</span></label>
                                    <input type="text" id="" name="mothnati" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>





                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label> Spouse Name <span>*</span></label>
                                    <input type="text" id="" name="spousname" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Place of Birth of Spouse <span>*</span></label>
                                    <input type="text" id="" name="pobspouce" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Nationality of Spouse<span></span></label>
                                    <input type="text" id="" name="natiofspo" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Profession/Occupation Details of Applicant<span></span></label>
                                    <input type="text" id="" name="porffdetail" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Employer's Name <span></span></label>
                                    <input type="text" id="" name="empname" class="form-control" placeholder=""
                                        required="">
                                </div>





                                <div class="col-sm-6">
                                    <label>Job Title<span></span></label>
                                    <input type="text" id="" name="jobtitle" class="form-control" placeholder=""
                                        required="">
                                </div>

                            </div>




                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Employer's Address
                                        <span></span></label>

                                    <input type="text" id="" name="empaddress" class="form-control" placeholder=""
                                        required="">
                                </div>



                                <div class="col-sm-6">
                                    <label>Are/were you in a Military/Police/Security/Organisation<span></span></label>
                                    <select name="policeorg" required="">
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>

                                    </select>
                                </div>

                            </div>




                            <h2 class="appli">Applicant's India Previous Visa / Currently Valid Visa Details</h2>

                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Last Indian Visa No. (if any) <span>*</span>Write NA if you have not visited
                                        India before</label>
                                    <input type="text" id="" name="livisit" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Type of Visa<span>*</span>Write NA if you have not visited India
                                        before</label>
                                    <input type="text" id="" name="tov" class="form-control" placeholder="" required="">
                                </div>
                            </div>


                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Place of Issue<span>*</span>Write NA if you have not visited India
                                        before</label>
                                    <input type="text" id="" name="placeofissue" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Date of Issue (DD/MM/YYYY)<span>*</span>Write NA if you have not visited
                                        India before</label>
                                    <input type="date" id="" name="dateofissue" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>




                            <div class="form-group row">

                                <div class="col-sm-6">
                                    <label>Address of Last visit (if available):Write NA if you have not visited India
                                        before.</label>
                                    <input type="text" id="" name="addolv" class="form-control" placeholder=""
                                        required="">
                                </div>
                                <div class="col-sm-6">
                                    <label>Non EU countries visited in last 10 years:</label><br>
                                    <input type="text" id="" name="noneu" class="form-control" placeholder=""
                                        required="">
                                </div>
                            </div>




                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <label>Upload Passport</label>
                                    <input name="image" value="" id="imageupload" type="file" required="">
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-6">
                                    <input type="checkbox" name="agree" value="accept" required=""> I Accept Terms and
                                    Conditions<br>
                                </div>

                            </div>





                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <button id="submit" name="submit" class="button_1" type="submit">Next</button>
                                </div>
                            </div>
                            <div id="form-messages" class="alert" role="alert"></div>
                        </form>
                    </div>

                </div>
                <div class="col-md-4 sm-padding">
                    <div class="sidebar_box">

                        <div class="sidebar_widget mb-30">
                            <h3 class="mb-20">Visa Information</h3>
                            <ul class="cat_list">

                                <li><a href="">Apply e-Business Visa</a></li>
                                <li><a href="">Apply e-Medical Visa</a></li>
                                <li><a href="#">Instructions for Applicant</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Document Requirement</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Terms &amp; Conditions</a></li>
                                <li><a href="">Disclaimer</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>

                        </div><!-- widget 2 -->

                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.blog_section -->



    <?php include 'include/footer.php';?>

    <a data-scroll href="#header" id="scroll-to-top"><i class="arrow_up"></i></a>

    <!-- jQuery Lib -->
    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/vendor/bootstrap.min.js"></script>
    <!-- Tether JS -->
    <script src="js/vendor/tether.min.js"></script>
    <!-- Counterup JS -->
    <script src="js/vendor/jquery.counterup.min.js"></script>
    <!-- waypoints js -->
    <script src="js/vendor/jquery.waypoints.v2.0.3.min.js"></script>
    <!-- Imagesloaded JS -->
    <script src="js/vendor/imagesloaded.pkgd.min.js"></script>
    <!-- OWL-Carousel JS -->
    <script src="js/vendor/owl.carousel.min.js"></script>
    <!-- Nivo Slider JS -->
    <script src="js/vendor/jquery.nivo.slider.pack.js"></script>
    <!-- isotope JS -->
    <script src="js/vendor/jquery.isotope.v3.0.2.js"></script>
    <!-- Smooth Scroll JS -->
    <script src="js/vendor/smooth-scroll.min.js"></script>
    <!-- venobox JS -->
    <script src="js/vendor/venobox.min.js"></script>
    <!-- ajaxchimp JS -->
    <script src="js/vendor/jquery.ajaxchimp.min.js"></script>
    <!-- Slick Nav JS -->
    <script src="js/vendor/jquery.slicknav.min.js"></script>
    <!-- Webticker JS -->
    <script src="js/vendor/jquery.webticker.min.js"></script>
    <!-- Wow JS -->
    <script src="js/vendor/wow.min.js"></script>
    <!-- Contact JS -->
    <script src="js/contact.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>



    <!-- Google Code for Evisa Inida Conversion Page Start -->
    <script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 979558999;
    var google_conversion_label = "ZGbICPr_zIMBENfEi9MD";
    var google_remarketing_only = false;
    /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
        <div style="display:inline;">
            <img height="1" width="1" style="border-style:none;" alt=""
                src="//www.googleadservices.com/pagead/conversion/979558999/?label=ZGbICPr_zIMBENfEi9MD&amp;guid=ON&amp;script=0" />
        </div>
    </noscript>
    <!-- Google Code for Evisa Inida Conversion Page End-->

</body>

<style type="text/css">
label {
    font-size: 15px;
    color: black;
    font-weight: bold;
}

label span {
    color: red;
}

select {
    padding: 10px;
    height: 40px;
    width: 100%;
}

.appli {
    font-size: 20px;
    padding-top: 10px;
    padding-bottom: 10px;
    color: #0f8a07;
}
</style>

</html>