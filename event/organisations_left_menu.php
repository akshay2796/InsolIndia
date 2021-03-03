<ul>
    	<?php $url = $_SERVER['QUERY_STRING']; $match_url = substr($url, 8);  //for menu highlight
            $arr_key = explode("=",$url);  //for nested menu highlight
            $nested_key = $arr_key[2];
            
            $SQL1  = ""; 
            $SQL1 .= " SELECT * FROM " . GOVERNANCE_TYPE_TBL . " as G "; 
            $SQL1 .= " WHERE status = 'ACTIVE' order by position ASC  ";
            $stmt1 = $dCON->prepare($SQL1);  
            $stmt1->execute();
            $menudsTYPE = $stmt1->fetchAll();
            $menunumTYPE = count($dsTYPE);
            if($menunumTYPE > intval(0)){
                foreach($menudsTYPE as $menuLIST)
                {
                   $menutypeID = (stripslashes($menuLIST['type_id']));
                   $menutypeURLKEY = (stripslashes($menuLIST['url_key']));
                   $menuNAME = (stripslashes($menuLIST['type_name']));
                   
                   $menursSUBTYPE = getDetails(GOVERNANCE_SUBTYPE_TBL, '*', "status~~~type_id","ACTIVE~~~$menutypeID",'=~~~=~~~=', '', '' , "");
                   $menucountSUBTYPE = "";
                   $menucountSUBTYPE = count($menursSUBTYPE);
                   
                   if($menucountSUBTYPE == intval(0)){
                   $menumasterURL = SITE_ROOT . urlRewrite("governance_list.php", array("url_key" => $menutypeURLKEY));
                   }
                                                     
        ?>

	<li>
    	<i class="fa fa-angle-right" aria-hidden="true"></i>
    	<a href="<?php if($menucountSUBTYPE == intval(0)){ echo $menumasterURL; }else{ echo '#'; }?>" <?php if($match_url == $menutypeURLKEY){ ?> class="active" <?php } ?> ><?php echo $menuNAME; ?></a>
   
            <?php
                if($menucountSUBTYPE > intval(0))
                {
                    ?>
                            <ul>
                                <?php
                                    foreach($menursSUBTYPE as $menusbLIST)
                                    {
                                        $menusubtypeNAME = htmlentities((stripslashes($menusbLIST['subtype_name'])));
                                        $menusubURLKEY = (stripslashes($menusbLIST['url_key']));
                                        $menumasterURL = SITE_ROOT . urlRewrite("governance_sub_list.php", array("master_url"=>$menutypeURLKEY, "url_key" => $menusubURLKEY));
                                                                
                                ?>
                    			<li><a href="<?php echo $menumasterURL; ?>" <?php if($nested_key == $menusubURLKEY){?>class="active" <?php } ?> ><?php echo $menusubtypeNAME; ?></a></li>
                    			<?php } ?>
                    		</ul>
   
                    <?php
                }
            ?>
            </li>
    <?php
                }
    }
    ?>
    
    <!-----==========================old menu -===============================-->
                        <!--li>
                        	<i class="fa fa-angle-right" aria-hidden="true"></i>
                        	<a href="<?php echo SITE_ROOT ?>executive-committee.php" <?php if($page_name == 'executive-committee.php'){?> class="active" <?php }?>  >Executive Committee</a>
                        </li>
                        <li>
                        	<i class="fa fa-angle-right" aria-hidden="true"></i>
                        	<a href="<?php echo SITE_ROOT . urlRewrite("board_governor.php"); ?>" <?php if($page_name == 'board_governor.php'){?> class="active" <?php }?> >Board of Governors</a>
                        </li>
                        <li>
                            <i class="fa fa-angle-right" aria-hidden="true"></i>
                            <a href="<?php echo SITE_ROOT . urlRewrite("judges_advisory_roundtable.php"); ?>" <?php if($page_name == 'judges_advisory_roundtable.php'){?> class="active" <?php }?> >Judges Advisory Board</a>
                        </li>
                        <li>
                        	<i class="fa fa-angle-right" aria-hidden="true"></i>
                            <a href="<?php echo SITE_ROOT . urlRewrite("academic_committees.php"); ?>" <?php if($page_name == 'academic_committees.php'){?> class="active" <?php }?> >Academics Committee</a>
                        </li>
                        <li>
                        	<i class="fa fa-angle-right" aria-hidden="true"></i>
                            <a href="<?php echo SITE_ROOT . urlRewrite("young-members-committee.php"); ?>" <?php if($page_name == 'young-members-committee.php'){?> class="active" <?php }?> >Young Practitioner's Committee</a>        
                            
                        </li>
                        <li>
                        	<i class="fa fa-angle-right" aria-hidden="true"></i>
                            <a href="<?php echo SITE_ROOT . urlRewrite("young-members-committee.php"); ?>" <?php if($page_name == 'young-members-committee.php'){?> class="active" <?php }?> >INSOL Committees</a>
                            
                            <ul>
                    			<li><a href="#/">National Committee for Regional Affairs</a></li>
                    			<li><a href="#/">Finance Committee</a></li>
                    			<li><a href="#/">Academics Committee</a></li>
                    			<li><a href="#/">Young Practitioner's Committee</a></li>
                    		</ul>
                            
                            
                        </li-->
    <!--============================================old menu ends =========================================-->
</ul>