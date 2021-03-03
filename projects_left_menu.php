<?php  $active_url = $_SERVER['QUERY_STRING'];
       $active_url = substr($active_url, 8);
      
    $SQLp  = ""; 
    $SQLp .= " SELECT * FROM " . PROJECTS_TBL . " as P "; 
    $SQLp .= " WHERE status = 'ACTIVE' and projects_title !='' order by position ASC ";
    
    $stmt1 = $dCON->prepare($SQLp);  
    $stmt1->execute();
    $rsLIST = $stmt1->fetchAll();
    $dA = count($rsLIST);
    $stmt1->closeCursor();
  
  ?>
 <ul>
    <?php
        if($dA > intval(0))
        {
            foreach($rsLIST as $rLIST)
            {
                $masterID = "";
                $masterTITLE = "";
                $url_key = "";
                $masterID = intval($rLIST['projects_id']);
                $masterTITLE = htmlentities(stripslashes($rLIST['projects_title']));
                $url_key = stripslashes($rLIST['url_key']);
                $masterURL = SITE_ROOT . urlRewrite("projects_detail.php", array("url_key" => $url_key));
    ?>
      		<li>
            	<i class="fa fa-angle-right" aria-hidden="true"></i>
    			<a href="<?php echo $masterURL; ?>" <?php if($active_url == $url_key){echo 'class="active"';} ?>> <?php echo $masterTITLE; ?></a>
    		</li>
  <?php
            }
  
        }
  ?>
	<!--	<li>
        	<i class="fa fa-angle-right" aria-hidden="true"></i>
			<a href="<?php echo SITE_ROOT ?>IBC-implementation-report.php" <?php if($page_name == "IBC-implementation-report.php"){echo 'class="active"';} ?>>IBC Implementation Report</a>
		</li>
	
		<li>
        	<i class="fa fa-angle-right" aria-hidden="true"></i>
			<a href="<?php echo SITE_ROOT ?>designing-insolvency-courses-for-law-schools.php" <?php if($page_name == "designing-insolvency-courses-for-law-schools.php"){echo 'class="active"';} ?>>Seminar Course for Law Schools</a>
		</li>
		<li>
        	<i class="fa fa-angle-right" aria-hidden="true"></i>
			<a href="<?php echo SITE_ROOT ?>best-practices-task-force-with-sipi.php" <?php if($url_key == "best-practices-task-force-with-sipi"){echo 'class="active"';} ?>>Best Practices Task Force with SIPI</a>
		</li>
		<li>
        	<i class="fa fa-angle-right" aria-hidden="true"></i>
			<a href="<?php echo SITE_ROOT ?>advocacy.php" <?php if($url_key == "advocacy"){echo 'class="active"';} ?>>Advocacy</a>
		</li> -->
  		
  		
  		
</ul>