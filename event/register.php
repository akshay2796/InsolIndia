<?php error_reporting(E_ALL);
include('header.php'); 
?>
<!doctype html>

<html lang="en">

     

<head>

        <title>insolindia</title>

        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1">

        <!-- Google Fonts -->   

        <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i,900,900i%7CPlayfair+Display:400,400i,700,700i,900,900i" rel="stylesheet">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
        

        <!-- Bootstrap Stylesheet -->   

        <link rel="stylesheet" href="css/bootstrap.min.css">

        

        <!-- Font Awesome Stylesheet -->

        <link rel="stylesheet" href="css/font-awesome.min.css">

            

        <!-- Custom Stylesheets --> 

        <link rel="stylesheet" href="css/style.css">

        <link rel="stylesheet" id="cpswitch" href="css/orange.css">

        <link rel="stylesheet" href="css/responsive.css">

<style>
    .centered-div {
    width: 440px;
    height: auto;
    margin: 10px;
    padding: 5px;
   margin: 0 auto;
    color: white;
}
.form-box {
    margin-top: 70px;
}
.form-top {
    overflow: hidden;
    padding: 0 25px 15px 25px;
    background: #f3f3f3;
    -moz-border-radius: 4px 4px 0 0;
    -webkit-border-radius: 4px 4px 0 0;
    border-radius: 4px 4px 0 0;
    text-align: left;
}
.form-bottom {
    padding: 25px 25px 30px 25px;
    background: #eee;
    -moz-border-radius: 0 0 4px 4px;
    -webkit-border-radius: 0 0 4px 4px;
    border-radius: 0 0 4px 4px;
    text-align: left;
}
.form-top-left {
    float: left;
    width: 75%;
    padding-top: 25px;
}
.form-top-right {
    float: left;
    width: 25%;
    padding-top: 5px;
    font-size: 66px;
    color: #ddd;
    line-height: 100px;
    text-align: right;
}


.fa {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    transform: translate(0, 0);
}
.section p {
    margin: 0;
    line-height: 1.4;
}
input[type="text"], input[type="password"], input[type="date"], input[type="number"], textarea, select, textarea.form-control {
    height: 40px;
    margin: 0;
    padding: 0 14px;
    vertical-align: middle;
    background: #f2f2f2;
    border: 1px solid #ddd;
    font-family: 'Gotham', sans-serif;
    font-size: 16px;
    font-weight: 300;
    line-height: 40px;
    color: #888;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 4px;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}
button.btn, button {
    height: 40px;
    margin: 0;
    padding: 0 10px;
    vertical-align: middle;
    background: #1d2644;
    border: 0;
    font-family: 'Gotham', sans-serif;
    font-size: 16px;
    font-weight: normal;
    line-height: 40px;
    color: #fff;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    border-radius: 3px;
    text-shadow: none;
    -moz-box-shadow: none;
    -webkit-box-shadow: none;
    box-shadow: none;
    -o-transition: all .3s;
    -moz-transition: all .3s;
    -webkit-transition: all .3s;
    -ms-transition: all .3s;
    transition: all .3s;
}

.btn {
    display: inline-block;
    vertical-align: middle;
    text-align: center;
    cursor: pointer;
    color: #fff;
    font-family: 'Proxima Nova', sans-serif;
    font-size: 13px;
    text-transform: uppercase;
    padding: 11px 10px 7px;
    letter-spacing: 0.02em;
    transition: background .4s;
    text-decoration: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
}
.form-bottom form button.btn {
    width: 100%;
}
</style>



</head>
<body>
<div class="centered-div">

<div class="error"></div>
            <div class="row">
                    <div class="form-box">
                        <div class="form-top" style="background-color: #23408f">
                            <div class="form-top-left">
                                <h3 style="color: white">Register</h3>
                               <!-- <p style="color: #E0E0E0">Create your INSOL account:</p>-->
                            </div>

                            <div class="form-top-right">
                                <i class="fas fa-key" style="color: #f55a11;"></i>
                                </div>
                            <p style="color:#fff; width:100%; float:left; margin-top:-25px">IMPORTANT NOTE:<br><br>IF YOU ARE REGISTERING FOR AN EVENT ON BEHALF OF SOMEONE ELSE, PLEASE DO NOT SET UP AN ACCOUNT.<br><br>INSTEAD, PLEASE CONTACT US AT <a href="mailto:Contact@insolindia.com" style="color:#fff; text-decoration: underline;">Contact@insolindia.com</a></p>
                        </div>
                        <div class="form-bottom">
                          <!--  <form name="form" id="registerfrm" novalidate="novalidate"> -->
                                <div class="form-group">
                                    <input type="text" name="fname" placeholder="First Name" class="form-username form-control" id="fname" style="width: 92%; margin-bottom: 30px" required="">

                                </div>
                                <div class="form-group">
                                    <input type="text" name="lname" placeholder="Last Name" class="form-username form-control" id="lname" style="width: 92%; margin-bottom: 30px" required="">

                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" placeholder="Email Address" class="form-username form-control" id="email" style="width:92%; margin-bottom: 30px" required="">

                                </div>
                                <div class="form-group">
                                    <!--<label class="sr-only" for="form-password">Password</label>-->
                                    <input type="password" name="password" placeholder="Password" class="form-password form-control" id="password" style="width: 92%; margin-bottom: 30px" required="">

                                </div>
                                <div class="form-group">
                                    <!--<label class="sr-only" for="form-password">Password</label>-->
                                    <select id="country" name="country" style="width:92%; background: #f8f8f8 none repeat scroll 0 0;
                                    border: 3px solid #ddd;
                                    border-radius: 4px;
                                    box-shadow: none;
                                    color: #888;
                                    font-family: 'Gotham',sans-serif;
                                    font-size: 16px;
                                    font-weight: 300;
                                    height: 50px;
                                    line-height: 50px;
                                    margin: 0;
                                    padding: 0 20px;
                                    transition: all 0.3s ease 0s;
                                    vertical-align: middle;
                                    margin-bottom: 30px;">
                                        <option value="-1">Select Country</option>
                                        <option value="Albania">Albania</option>
                                        <option value="Argentina">Argentina</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Austria">Austria</option>
                                        <option value="Barbados">Barbados</option>
                                        <option value="Belgium">Belgium</option>
                                        <option value="Bermuda">Bermuda</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="British Virgin Islands">British Virgin Islands</option>
                                        <option value="Bulgaria">Bulgaria</option>
                                        <option value="Cambodia">Cambodia</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Cayman Islands">Cayman Islands</option>
                                        <option value="Channel Islands">Channel Islands</option>
                                        <option value="Chile">Chile</option>
                                        <option value="China, (PRC)">China, (PRC)</option>
                                        <option value="Colombia">Colombia</option>
                                        <option value="Croatia">Croatia</option>
                                        <option value="Cyprus">Cyprus</option>
                                        <option value="Czech Republic">Czech Republic</option>
                                        <option value="Denmark">Denmark</option>
                                        <option value="Egypt">Egypt</option>
                                        <option value="England">England</option>
                                        <option value="Estonia">Estonia</option>
                                        <option value="Fiji">Fiji</option>
                                        <option value="Finland">Finland</option>
                                        <option value="France">France</option>
                                        <option value="Germany">Germany</option>
                                        <option value="Ghana">Ghana</option>
                                        <option value="Gibraltar">Gibraltar</option>
                                        <option value="Greece">Greece</option>
                                        <option value="Guatemala">Guatemala</option>
                                        <option value="Hong Kong">Hong Kong</option>
                                        <option value="Hungary">Hungary</option>
                                        <option value="Iceland">Iceland</option>
                                        <option value="India">India</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Isle of Man">Isle of Man</option>
                                        <option value="Israel">Israel</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Jamaica">Jamaica</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Kenya">Kenya</option>
                                        <option value="Kingdom of Bahrain">Kingdom of Bahrain</option>
                                        <option value="Laos">Laos</option>
                                        <option value="Latvia">Latvia</option>
                                        <option value="Liechtenstein">Liechtenstein</option>
                                        <option value="Lithuania">Lithuania</option>
                                        <option value="Luxembourg">Luxembourg</option>
                                        <option value="Macau">Macau</option>
                                        <option value="Malaysia">Malaysia</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Mozambique">Mozambique</option>
                                        <option value="Myanmar">Myanmar</option>
                                        <option value="Nepal">Nepal</option>
                                        <option value="New Zealand">New Zealand</option>
                                        <option value="Nigeria">Nigeria</option>
                                        <option value="Northern Ireland">Northern Ireland</option>
                                        <option value="Norway">Norway</option>
                                        <option value="Pakistan">Pakistan</option>
                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                        <option value="People's Republic of China">People's Republic of China</option>
                                        <option value="Peru">Peru</option>
                                        <option value="Poland">Poland</option>
                                        <option value="Portugal">Portugal</option>
                                        <option value="Republic of Korea">Republic of Korea</option>
                                        <option value="Republic of Kosovo">Republic of Kosovo</option>
                                        <option value="Republic of Mauritius">Republic of Mauritius</option>
                                        <option value="Republic of Panama">Republic of Panama</option>
                                        <option value="Republic of Singapore">Republic of Singapore</option>
                                        <option value="Republic of South Africa">Republic of South Africa</option>
                                        <option value="Republic of Trinidad &amp; Tobago">Republic of Trinidad &amp; Tobago</option><option value="Romania">Romania</option>
                                        <option value="Russia">Russia</option>
                                        <option value="Rwanda">Rwanda</option>
                                        <option value="Scotland">Scotland</option>
                                        <option value="Serbia">Serbia</option>
                                        <option value="Slovak Republic">Slovak Republic</option>
                                        <option value="Slovenia">Slovenia</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Sri Lanka">Sri Lanka</option>
                                        <option value="St Vincent and the Grenadines">St Vincent and the Grenadines</option>
                                        <option value="Sweden">Sweden</option>
                                        <option value="Switzerland">Switzerland</option>
                                        <option value="Thailand">Thailand</option>
                                        <option value="The Bahamas">The Bahamas</option>
                                        <option value="The Netherlands">The Netherlands</option>
                                        <option value="The Philippines">The Philippines</option>
                                        <option value="Turkey">Turkey</option>
                                        <option value="Turks &amp; Cacios">Turks &amp; Cacios</option>
                                        <option value="UAE">UAE</option>
                                        <option value="Uganda">Uganda</option>
                                        <option value="Ukraine">Ukraine</option>
                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                        <option value="Uruguay">Uruguay</option>
                                        <option value="USA">USA</option>
                                        <option value="Vietnam">Vietnam</option>
                                        <option value="Wales">Wales</option>
                                        <option value="Zambia">Zambia</option>
                                        <option value="Zimbabwe">Zimbabwe</option>
                                        ?&gt;
                                    </select>
                                </div>
                                <input type="submit" name="submit"class="submit" id="submit" style="margin-top: 10px">
                            </form>
                        </div>
                    </div>
</div>
</div></body>
                </div>
<?php include('footer.php'); ?>
<script src="new_reg_ajex.js"></script>
<script>
$('#submit').click(function(){
    var fname = $('#fname');
    var lname = $('#lname');
    var email = $('#email');
    var password = $('#password');
    var country = $('#country');
    var data = "fname="+fname.val()+"&lname="+lname.val()+"&email="+email.val()+"&password="+password.val()+"&country="+country.val();
    var url = "new_register.php";
    get_data(url, data);
    //alert('Register succesful');
    window.location.href ='form_login.php';
});
</script>

</body>
</html>