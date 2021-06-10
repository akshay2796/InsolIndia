<?php error_reporting(0);
include('header.php'); 
?>


<!--<script src="<?php echo SITE_ROOT;?>js_insol/jquery.min.js"></script>
<script src="<?php echo SITE_ROOT;?>js_insol/jquery.validate-latest.js"></script> -->



<div class="container">
    <div class="clearfix inner_page">
        <div class="col-md-2 col-sm-3 inner_page_left">
            <?php include 'membership_left_menu.php' ?>
        </div>
        <div class="col-md-10 col-sm-9 inner_page_right">
        	<h2>Registration Fees</h2>
            <div class="error"></div>
          	<div class="row">
				
		<div class="col-sm-12" style="text-align:left;margin-top:40px;">
      <textarea name="edit_box" id="edit_box" style="width:100%;height:100px;text-align:left;" autofocus="textarea" placeholder="" maxlength=250 required /></textarea>
    </div>
		
		<h5 style="margin-left:15px;margin-top:200px;">Personal Details of the member to be mentioned below box</h5>
		<div class="col-sm-12" style="text-align:left;margin-top:40px;">
      <textarea name="p_detail" id="p_detail"placeholder="" style="width:100%;height:100px;text-align:left;"  required / >        
      </textarea>
    </div>
		<h5 style="margin-left:15px;margin-top:200px;"><u>Change Details</u></h5><br>
		  <div style="margin-left:15px;margin-top:10px;"><strong>IMPORTANT:</strong>Please ensure that your address and company details above are completed as fully as possible prior to registration. Should you need to amend or complete, please click ‘Change Details’ above. You will be directed to your Dashboard, where the changes can be made. Once completed, please restart the event registration process.
    </div>
		<p style="margin-left:15px;margin-top:50px;" >Deadline for early registration fee: 10th October 2018-09-24</p>
		  <div><p style="margin-left:15px;margin-top:50px;">IF YOU WISH TO PAY BY CHEQUE, PLEASE INDICATE THIS AS YOUR OPTION AT CHECKOUT AND YOUR RESERVATION WILL BE CONFIRMED ONCE PAYMENT IS RECEIVED. PLEASE MAKE SURE YOU SEND YOUR CHEQUE BY RECORDED DELIVERY AND NOTIFY US THROUGH THE SCAN COPY OF THE SAME AT <a>contact@insolindia.com</a> OR BY HAND AT FOLLOWING ADDRESS <b>INSOL India, 5 MATHURA ROAD, 3RD FLOOR, JANGPURA – A, NEW DELHI - 110014.</b></p>
    </div>
		
		<div class="hrline"></div>
		
      <div class="col-sm-12" style="margin-top:50px;">
        <div class="form-group">
        <div class="col-sm-4">
          <label>Name as you wish to appear on badge <span>*</span></label></div>
          <div class="col-sm-8">
          <input type="text" class="form-control" name="name" id="name" placeholder="Name" maxlength="" value="<?php echo $city; ?>"> </div>
        </div>
    </div>
    <div class="col-sm-12" style="margin-top:30px;">
      <div class="form-group">
        <div class="col-sm-4">
          <label>Administrative Assitant E- mail  <span>*</span></label></div>
          <div class="col-sm-8">
          <input type="text" class="form-control" name="mail" id="mail" placeholder="Email" maxlength="50" value="<?php echo $correspondence_state; ?>"></div>
      </div>
    </div>
   
    </div>
     <div class="col-md-12" style="margin-top:30px;">
          <div class="form-group">
            <div class="col-sm-4" style="margin-left:-15px; "><label>Designation   <span>*</span></label></div>
            <div class="col-sm-8" style="margin-left:10px;width:592px;"><input type="text" class="form-control" name="designation"id="designation" placeholder="Destination"></div>           
          </div>          
      
<!--<h4 style="margin-left:10px;margin-top:100px;">Registration Fees</h4>
<div class="col-sm-12" style="margin-top:30px;">
        <div class="col-sm-2" style="border:1px solid;width:150px;">Registration Type</div>
        <div class="col-sm-3" style="border:1px solid;margin-left:10px;width:180px;">Non-Member Price</div>
        <div class="col-sm-2" style="border:1px solid;margin-left:10px;width:150px;">Member Price</div>
        <div class="col-sm-3" style="border:1px solid;margin-left:10px;width:180px;">Early bird Discount</div>
        <div class="col-sm-2" style="border:1px solid;margin-left:10px;">Total Fee</div>
</div>-->
<div class="col-sm-12" style="margin-top:30px;">
          <label>Registration Type</label>
          <select>
            <option value="volvo">Non-Member Price</option>
            <option value="saab">Member Price</option>
            <option value="mercedes">Early bird Discount</option>
            <option value="audi">Total Fee</option>
          </select>
        <!--<div class="col-sm-4" style="border:1px solid;margin-left:10px;width:300px;">Delegate Registration@20000+ 18% GST</div>
        <div class="col-sm-3" style="border:1px solid;margin-left:10px;width:170px;">@16,000+18% GST</div>
        <div class="col-sm-1" style="border:1px solid;margin-left:10px;width:80px;">10%</div>
        <div class="col-sm-2" style="border:1px solid;margin-left:10px;width:100px;">@23,600/-</div>
        <div class="col-sm-2" style="border:1px solid;margin-left:10px;width:150px;">@18,880/-</div>-->
		</div>
		
	       <p style="margin-left:10px;margin-top:150px;">should you have any queries, please contact us at <a>contact@insolindia.com</a>, or call 49785744.</p>

	         <p style="margin-left:10px;margin-top:90px;">DELEGATE NAME, FIRM AND COUNTRY WILL BE LISTED ON THE DELEGATE LIST. PHOTOS AND VIDEO MAY BE TAKEN DURING THE SEMINAR FOR PUBLICATION. PLEASE BRING YOUR CONFIRMATION AND PHOTGRAPHIC IDENTIFICATIOBN WITH YOU IN ORDER TO COLLECT YOUR BADGE AND SEMINAR PAPERS </P>
	     <div class="hrline"></div>
       <div class="col-sm-12">
           <div class="col-sm-12">
	            <lable>Do you have any dietary requirements?</lable>
              <input type="checkbox" name="Veg" value="Veg"> Veg <input type="checkbox" name="Non–Veg" value="Car"> Non–Veg 
            </div>
           </p>
         </div><br/>
	     <div class="hrline"></div>
            <br> <br><br>        
			     <button id="sub" name="Submit" style="float: right; background: #B71D21; color: white;"> Submit</button>   
        </div>
    </div>
  </p></div></div></div></div>
</div>
<?php include('footer.php'); ?>

<script src="ajex.js"></script>
<script>
$('#sub').click(function(){
	var edit_box = $('#edit_box');
	var p_detail = $('#p_detail');
	var name = $('#name');
	var mail = $('#mail');
	var designation = $('#designation');
	var data = "edit_box="+edit_box.val()+"&p_detail="+p_detail.val()+"&name="+name.val()+"&mail="+mail.val()+"&designation="+designation.val();
  var url = "reg_ajex.php";
	get_data(url, data);
  window.location.href ='login.php';
});
</script>