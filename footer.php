        <footer class="clearfix footer">
            <div class="container">
                <div class="col-md-8 col-sm-8 footer_left">
                    <div class="footer_left_icon">
                        <img src="https://www.insolindia.com/images_insol/footer_icon.png">
                    </div>
                    <div class="footer_left_text">
                        <h3>5, Mathura Road, 3rd Floor, Jangpura-A, New Delhi-110014. <br> Contact No. 011 49785744 | Email: <a href="mailto:contact@insolindia.com">contact@insolindia.com</a></h3>
                        <p>&copy; 2017 INSOL India, All rights reserved. Site Designed By <a href="https://www.infomediawebsolutions.com/" target="_blank">Infomedia Web Solutions</a>.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4 footer_right">
                    <div class="footer_right_text">
                        <h3>follow us</h3>
                    </div>
                    <div class="footer_right_link">
                        <ul>
                            <li>
                                <?php
                                $twitter_url = getDetails(SOCIALMEDIA_TBL, 'socialmedia_link', "socialmedia_id","1001",'=', '', '' , "");
                                ?>
                                <a href="https://<?php echo $twitter_url; ?>" target="_blank">
                                    <i class="fa fa-twitter" aria-hidden="true"></i>
                                </a>
                            </li>
                            <li>
                                <?php
                                $linkedin_url = getDetails(SOCIALMEDIA_TBL, 'socialmedia_link', "socialmedia_id","1002",'=', '', '' , "");
                                ?>
                                <a href="https://<?php echo $linkedin_url; ?>" target="_blank">
                                    <i class="fa fa-linkedin" aria-hidden="true"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
<script src="https://www.insolindia.com/js_insol/slick.min.js"></script>
<script src="https://www.insolindia.com/js_insol/scripts.js"></script>

<script src="https://www.insolindia.com/js_insol/grids.js"></script>
<script>	
	$(document).ready(function() {
		$('.eqH').responsiveEqualHeightGrid();
		$('.profileH').responsiveEqualHeightGrid();
	});
</script>
<script src="https://www.insolindia.com/js_insol/script.js"></script>

<!--script src="<?php //echo SITE_JS; ?>jQuery.paginate.js"></script>
<script>
	$(document).ready(function() {
		$('.pagination__list').paginate({
			items_per_page: 6
		});
	});
</script-->
<?php

//////////////////Expired BECOME A MEMBER
$ip = trustme($_SERVER['REMOTE_ADDR']);
$time = date("Y-m-d H:i:s");

$membership_expired_date = date('Y-m-d');

$STR  = "";
$STR .= " UPDATE  " . BECOME_MEMBER_TBL . "  SET "; 
$STR .= " register_status = 'Expired', ";
$STR .= " payment_status = 'PENDING', ";
$STR .= " update_ip = :update_ip, ";
$STR .= " update_time = :update_time ";
$STR .= " WHERE membership_expired_date < '".$membership_expired_date."' and membership_expired_date !='0000-00-00' and IFNULL (reg_number,0) > 0 ";
$sDEF = $dCON->prepare($STR); 
$sDEF->bindParam(":update_ip", $ip);
$sDEF->bindParam(":update_time", $time);
$RES = $sDEF->execute();
$sDEF->closeCursor();      

?>


</html>