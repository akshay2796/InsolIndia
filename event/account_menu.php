
<ul>
        <li>
        	<i class="fa fa-angle-right" aria-hidden="true"></i>
            <a href="<?php echo SITE_ROOT . urlRewrite("myaccount.php"); ?>" <?php if($page_name == "myaccount.php"){echo 'class="active"';} ?>>My Account</a>
        </li>
    	<li>
       		<i class="fa fa-angle-right" aria-hidden="true"></i>
       		<a href="<?php echo SITE_ROOT . urlRewrite("change-pass.php"); ?>" <?php if($page_name == "change-pass.php"){echo 'class="active"';} ?>>Change Password</a>
        </li>
        <li>
       		<i class="fa fa-angle-right" aria-hidden="true"></i>
       		<a href="<?php echo SITE_ROOT ."contribute-newsletter.php"; ?>" <?php if($page_name == "contribute-newsletter.php"){echo 'class="active"';} ?>>Contribute To Our Newsletter</a>
        </li>
    	<li>
       		<i class="fa fa-angle-right" aria-hidden="true"></i>
       		<a href="<?php echo SITE_ROOT ."logout.php"; ?>" <?php if($page_name == "logout.php"){echo 'class="active"';} ?>>Logout</a>
        </li>
</ul>