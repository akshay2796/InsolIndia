<div class="menuWrapper">
    <a href="javascript:void(0)" class="navHover"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/nav_left.gif" /></a>
    <div class="menuList">
        <ul id="mainMenu" class="mainMenu">
            <!--li><a href="#" ><i class="fa fa-user-plus" aria-hidden="true"></i>&nbsp; Governance</a>
				<ul class="submenu">					 
					
                    <li><a href="<?php echo 'executive_committee_list.php'; ?>"> Executive Committee  </a></li>
                    <li><a href="<?php echo 'board_governors_list.php'; ?>"> Board of Governors  </a></li>
                    <li><a href="<?php echo 'judges_advisory_list.php'; ?>"> Judges Advisory Board  </a></li>
                    <li><a href="<?php echo 'young_members_committee_list.php'; ?>"> Young Practitioner's Committee  </a></li>
                    <li><a href="#" class="slink">Academics Committee </a>                    
                        <ul class="submenu">
                            <li><a href="committee_type.php">Manage Committee Member Type</a></li>
                            <li><a href="committee.php"> Add Committee Member</a></li>
                            <?php
                            $QRY = "";
                            $QRY = " select distinct(a.committee_type_id), b.type_name from ".COMMITTEES_TBL." AS a inner join ". COMMITTEES_TYPE_TBL." AS b ON a.committee_type_id=b.type_id where a.status != 'DELETE' and b.status= 'ACTIVE' GROUP BY a.committee_type_id order by b.position";
                            //echo "==".$QRY;
                            $stmAT = $dCON->prepare($QRY);
                            $stmAT->execute();
                            $rowAT = $stmAT->fetchAll();
                            $stmAT->closeCursor();
                            //print_r($stmAT->errorInfo());
                            if(count($rowAT)>intval(0))
                            {
                            ?>
                                <li><a href="#" class="slink">List/Modify Committee Member</a>
                                    <ul class="submenu">
                                        <?php
                                        foreach($rowAT as $rsAT)
                                        {
                                        ?>
                                            <li><a href="committee_list.php?ctid=<?php echo $rsAT['committee_type_id'];?>"><?php echo stripslashes($rsAT['type_name']);?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>
                            
                           
                        </ul>              
                    
                    </li>
                    						 
				</ul>  
			</li--> 
            <li><a href="#" class="slink"><i class="fa fa-user-plus" aria-hidden="true"></i> &nbsp;Governance </a>                    
                        <ul class="submenu">
                            <li><a href="governance_type.php">Manage Governance Type</a></li>
                            <li><a href="governance_subtype.php">Manage Governance SubType</a></li>
                            <li><a href="governance.php"> Add Governance</a></li>
                            <?php
                            $QRY = "";
                            $QRY = " select distinct(a.type_id), b.type_name from ".GOVERNANCE_TBL." AS a inner join ". GOVERNANCE_TYPE_TBL." AS b ON a.type_id=b.type_id where a.status != 'DELETE' and b.status= 'ACTIVE' GROUP BY a.type_id order by b.position";
                            //echo "==".$QRY;
                            $stmAT = $dCON->prepare($QRY);
                            $stmAT->execute();
                            $rowAT = $stmAT->fetchAll();
                            $stmAT->closeCursor();
                            //print_r($stmAT->errorInfo());
                            if(count($rowAT)>intval(0))
                            {
                            ?>
                                <li><a href="#" class="slink">List/Modify Governance</a>
                                    <ul class="submenu">
                                        <?php
                                        foreach($rowAT as $rsAT)
                                        {
                                        ?>
                                            <li><a href="governance_list.php?ctid=<?php echo $rsAT['type_id'];?>"><?php echo stripslashes($rsAT['type_name']);?></a></li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                            <?php
                            }
                            ?>
                            
                           
                        </ul>              
                    
                    </li>     
            
            <li><a href="#"><i class="fa fa-desktop" aria-hidden="true"></i>&nbsp; Media</a>
            	<ul class="submenu">
                    <!--<li><a href="media_category.php">Manage Media Type</a></li>-->
                    <li><a href="media.php"> Add Media </a></li>
                    <li><a href="media_list.php">List/Modify Media</a></li>
                    <?php /*
                    $QRY = "";
                    $QRY .= " select distinct(C.category_id), C.category_name from ".MEDIA_TBL." AS M ";
                    $QRY .= " INNER JOIN ".MEDIA_CATEGORY_TBL." AS C ON M.category_id = C.category_id ";
                    $QRY .= " WHERE  M.status != 'DELETE' and C.status= 'ACTIVE' ";
                    $QRY .= " GROUP BY M.category_id ";
                    $QRY .= " order by C.position";
                    //echo "==".$QRY;
                    $sMT = $dCON->prepare($QRY);
                    $sMT->execute();
                    $rsMT = $sMT->fetchAll();
                    $sMT->closeCursor();
                    if(count($rsMT)>intval(0))
                    {
                    ?>
                        <li><a href="#" class="slink">List/Modify Media</a>
                            <ul class="submenu">
                                <?php
                                foreach($rsMT as $rMT)
                                {
                                ?>
                                    <li><a href="media_list.php?CID=<?php echo base64_encode(intval($rMT['category_id']));?>"><?php echo stripslashes($rMT['category_name']);?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }*/
                    ?>
                   
                </ul>  
            </li>
            
            <li><a href="#"><i class="fa fa-image" aria-hidden="true"></i>&nbsp; Gallery</a>
            	<ul class="submenu">
                    <li><a href="gallery.php"> Add</a></li>
                    <li><a href="gallery_list.php"> Manage</a></li>                   
                </ul>
            </li>
            <!--li><a href="#"><i class="fa fa-image" aria-hidden="true"></i>&nbsp; Registered Members</a>
                <ul class="submenu">
                    <li><a href="registered_member_list.php"> Member List</a></li>                   
                </ul>
            </li-->
            
            <li><a href="#"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp; Events</a>
            	<ul class="submenu">                    
                    <li><a href="event.php"> Add</a></li>
                    <li><a href="event_list.php">Manage</a></li> 
                    <li><a href="webinar_registration.php">Webinar Registration</a></li> 
                </ul>
            </li>
            
            <!--li><a href="#" ><i class="fa fa-folder-open" aria-hidden="true"></i>&nbsp; Member Directory  </a>                    
                <ul class="submenu">
                    <li><a href="member_type.php">Manage Member Type</a></li>
                    <li><a href="member.php"> Add Member </a></li>
                    <?php
                    $QRY = "";
                    $QRY = " select distinct(a.member_type_id), b.type_name from ".MEMBER_TBL." AS a inner join ". MEMBER_TYPE_TBL." AS b ON a.member_type_id=b.type_id where a.status != 'DELETE' and b.status= 'ACTIVE' GROUP BY a.member_type_id order by b.position";
                    //echo "==".$QRY;
                    $stmAT = $dCON->prepare($QRY);
                    $stmAT->execute();
                    $rowAT = $stmAT->fetchAll();
                    $stmAT->closeCursor();
                    //print_r($stmAT->errorInfo());
                    if(count($rowAT)>intval(0))
                    {
                    ?>
                        <li><a href="#" class="slink">List/Modify Member</a>
                            <ul class="submenu">
                                <?php
                                foreach($rowAT as $rsAT)
                                {
                                ?>
                                    <li><a href="member_list.php?mtid=<?php echo $rsAT['member_type_id'];?>"><?php echo stripslashes($rsAT['type_name']);?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>                    
                   
                </ul>              
            
            </li-->
            
            <li><a href="#"><i class="fa fa-newspaper-o" aria-hidden="true"></i>&nbsp; News  </a>
                <ul class="submenu">
                    <li><a href="news.php"> Add</a></li>
                    <li><a href="news_list.php"> Manage</a></li>                   
                </ul>            
            </li>

            <li><a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; Resources</a>
                <ul class="submenu">
                    <li><a href="resources_category.php">Manage Category</a></li>
                    <li><a href="resources.php"> Add Resources </a></li>
                    <!--li><a href="resources_list.php">List/Modify Resources</a></li--> 
                    
                    <?php
                    $QRY = "";
                    $QRY = " select distinct(a.category_id), category_name from ".RESOURCES_TBL." AS a inner join ". RESOURCES_CATEGORY_TBL." AS b ON a.category_id=b.category_id where a.status != 'DELETE' and b.status= 'ACTIVE' GROUP BY a.category_id order by a.position";
                    //echo "==".$QRY;
                    $stmAT = $dCON->prepare($QRY);
                    $stmAT->execute();
                    $rowAT = $stmAT->fetchAll();
                    $stmAT->closeCursor();
                    if(count($rowAT)>intval(0))
                    {
                    ?>
                        <li><a href="#" class="slink">List/Modify Resources</a>
                            <ul class="submenu">
                                <?php
                                foreach($rowAT as $rsAT)
                                {
                                ?>
                                    <li><a href="resources_list.php?rcid=<?php echo $rsAT['category_id'];?>"><?php echo stripslashes($rsAT['category_name']);?></a></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </li>
                    <?php
                    }
                    ?>
                    
                    
                                      
                </ul>  
            </li>
           

            <!--li><a href="become_member_list.php"><i class="fa fa-image" aria-hidden="true"></i>&nbsp; Become a Members</a></li-->
            
            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Insol Member</a>
                <ul class="submenu">
                    <li><a href="become_member.php"> Add Member </a></li>
                    <li><a href="become_member_list.php">List/Modify Member</a></li>
					<li><a href="year_contribution.php">Year Wise Contribution</a></li>                   
                </ul>  
            </li>

            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Event Joiner</a>
                <ul class="submenu">
                     <li><a href="event_joiner_add.php">Add Registration</a></li>
                    <li><a href="event_joiner_list.php">List/Modify Registration</a></li>
                </ul>  
            </li>

			<li><a href="#"><i class="fa fa-file-text" aria-hidden="true"></i>&nbsp; SIG 24</a>
                <ul class="submenu">
					<li><a href="sig24_intro.php">Manage Intro</a></li>
                    <li><a href="sig24.php"> Add SIG 24</a></li>
                    <li><a href="sig24_list.php">List/Modify SIG 24</a></li>                   
                </ul>  
            </li>
            
            
            <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp; Newsletter</a>
                <ul class="submenu">
                    <li><a href="#">Master</a>
                        <ul class="submenu2">
                            <li><a href="newsletter_intro.php">Manage Intro</a></li>
                            <li><a href="newsletter_disclaimer.php">Manage Disclaimer</a></li>
                            <li><a href="newsletter_editor.php">Manage Editor</a></li>
                            <li><a href="newsletter_president.php">Manage President</a></li>
                            <li><a href="newsletter_sponsor.php">Manage Sponsor</a></li>
                            <li><a href="newsletter_mailing_members_list.php">Mailing List</a></li>
                        </ul>
                    </li>
                    <li><a href="newsletter.php">Create Newsletter </a></li>
                    <li><a href="newsletter_list.php">List/Modify Newsletter</a></li>                   
                </ul>  
            </li>
            
            <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp; General Newsletter</a>
            	<ul class="submenu">                    
                    <li><a href="general_upload.php"> Add</a></li>
                    <li><a href="general_upload_list.php">Manage</a></li>                    
                </ul>
            </li>
           
            <li><a href="#"><i class="fa fa-product-hunt" aria-hidden="true"></i>&nbsp; Projects</a>
                <ul class="submenu">
                    <li><a href="projects.php"> Add Projects </a></li>
                    <li><a href="projects_list.php">List/Modify Projects</a></li>                   
                </ul>  
            </li>   
            <li><a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true"></i>&nbsp; DIBP</a>
                <ul class="submenu">
					<li><a href="draft_best_practices_intro.php">Manage DIBP Intro</a></li>
                    <li><a href="draft_best_practices.php"> Add DIBP</a></li>
                    <li><a href="draft_best_practices_list.php">List/Modify DIBP</a></li>                   
                </ul>  
            </li>
            <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i>&nbsp; Social Media  </a>
                <ul class="submenu">
                    <li><a href="social_media.php"> Add/View</a></li>
                </ul>            
            </li>         
        </ul>
         <div style="clear:both; height:50px;"></div>
    </div>
</div><!--menuWrapper end-->  