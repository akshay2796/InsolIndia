           
            
            
            <div class="fullWidth noGap" id="set1_image_list" >
            	<?php
                //echo "DB IMG COUNT --->" . intval($cntIMG_set1) . "<BR>"; 
                if (intval($cntIMG_set1) > intval(0) ){
                ?>
                    
                    <?php
                    $atleastONE = 0;
                    $FOLDER_NAME = "";
                    $FOLDER_PATH = "";
                                        
                    foreach($rsIMG_set1 as $rIMG)
                    {
                        $displayIMG ="";
                        $image_name = trim(stripslashes($rIMG['image_name']));
                        //echo "SAVED NAME>> " . $image_name . "<BR>";                     
                        
                        
                        $image_id = trim(stripslashes($rIMG['image_id']));
                        $image_caption = trim(stripslashes($rIMG['image_caption']));
                         
                        
                        if( intval($copy) == intval(1) ){
                            
                            $FOLDER_NAME = TEMP_UPLOAD;
                            $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME; 
                            $image_id = 0;
                            
                            $image_name = str_replace(intval($member_id),"",$image_name);
                            $image_name = str_replace(intval($rIMG["image_id"]),"",$image_name);   
                            $image_name = str_replace("--","",$image_name);                              
                            
                        }else{
                            
                            $FOLDER_NAME = SET1_FOLDER;     
                            $FOLDER_PATH = CMS_UPLOAD_FOLDER_RELATIVE_PATH. $FOLDER_NAME;                        
                             
                            
                        } 
                        
                        
                        $member_id = trim(stripslashes($rIMG['member_id']));
                        $crop_image_coordinates = trim(stripslashes($rIMG['crop_image_coordinates']));
                        //$Image_Pos = trim(stripslashes($rIMG['position']));
                        $default_image = trim(stripslashes($rIMG['default_image']));
                        
                        $defaultlyRESIZED = SET1_IMAGE_RESIZE_PREFIX.$image_name;
                        $chkDefaultlyRESIZED = chkImageExists($FOLDER_PATH."/".$defaultlyRESIZED);
                        
                        // First Check Crop Image was made bu USER or  NOT ===============
                        $C_image = "";
                        $chkCROPFILE = 0;
                        if ( SET1_IMAGE_CROPPING == true ){
                            $C_image = SET1_CROP_PREFIX.$image_name;
                            $chkCROPFILE = chkImageExists($FOLDER_PATH."/".$C_image);
                        }elseif ( SET1_IMAGE_CROPPING == false ){
                            $C_image = "";  
                            $chkCROPFILE = 0;  
                        }
                        
                        //echo $chkCROPFILE . "===<BR>";                     
                        //echo $chkCROPFILE . "===<BR>";                     
                        //echo SET1_IMAGE_CROPPING . "===<BR>";                     
                        //echo "$chkCROPFILE===$defaultlyRESIZED####$C_image<BR>";
                        
                        if(intval($chkCROPFILE) == intval(1)){       
                            $displayIMG = "<img src='" . $FOLDER_PATH."/".$C_image . "' class='fixedImg imgno" . $image_id . "' />";                            
                        }elseif(intval($chkCROPFILE) == intval(0)){       
                            
                            // If Croped file not than show Defaulty resized Image ===========                             
                            
                            /*
                            if(intval($chkDefaultlyRESIZED) == intval(1)){
                                $displayIMG = "<img src='" . $FOLDER_PATH."/".$defaultlyRESIZED . "' class='fixedImg imgno" . $image_id . "' />";
                            }else{
                                $displayIMG ="";
                            } 
                            */
                            
                            //echo "<BR>SET1_TYPE====<BR>";
                        
                            if ( SET1_TYPE == "FILE" ){ 
                                $displayIMG = $image_name;                                                
                            }else if ( SET1_TYPE == "IMAGE" ){ 
                                
                                if(intval($chkDefaultlyRESIZED) == intval(1)){
                                    //$displayIMG = $FOLDER_PATH."/".$defaultlyRESIZED;
                                    $displayIMG = "<img src='" . $FOLDER_PATH."/".$defaultlyRESIZED . "' class='fixedImg imgno" . $image_id . "' />";
                                }else{
                                    $displayIMG ="";
                                }                                       
                            }
                                
                            //echo "display_image>>> $displayIMG<BR>";
                        
                        }
                        else
                        {
                            
                                                  
                            
                        }
                        
                        //echo "<BR>$image_name====" . $displayIMG . "<BR>";                     
                        
                        if( trim($displayIMG) != "")
                        {
                            $atleastONE = 1;
                ?>
                            <div class="removeImageTR uploadImgContainer smallListBox" id="listItem_<?php echo $image_id; ?>"   >
                                <div class="uploadImgBox"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                                    <input type="hidden" class="set1_image_id" name="set1_image_id[]" value="<?php echo $image_id;?>" />
                                    <input type="hidden" class="set1_folder_name" name="set1_folder_name[]" value="<?php echo $FOLDER_NAME; ?>" />
                                    <input type="hidden" class="cl_r_image  set1_icount" id="image[]" name="set1_image[]" value="<?php echo $image_name;?>" />
                                	<div class="addPhotoIconTbl"><span><a href="javascript:void(0)"><?php echo $displayIMG; ?></a></span></div>
                                </div>
                                
                                <div class="uploadImgBox">
                                    <input type="text" class="set1_image_caption" name="set1_image_caption[]" value="<?php echo $image_caption;?>" autocomplete="OFF" />
                                </div>                            
                                
                                <div class="uploadImgBtn">
                                <!--img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position" style="display: block;"/-->
                                
                                	<table>
                                        <tr>
                                            <?php if ( SET1_IMAGE_MULTIPLE == true ){ ?>
                                        	   <td><input type="radio" name="set1_default_image" id="set1_default_image" title="Set Default" value="<?php echo $image_name;?>" valueid="<?php echo $image_id;?>" class="setDefault" foldername=<?php echo $FOLDER_NAME; ?> <?php if($default_image=="YES") { echo "checked"; }?>/></td>
                                            <?php } ?>
                                        	<?php if ( SET1_IMAGE_CROPPING == true ){ ?>
                                                <td><input type="hidden" name="set1_coordinates[]" id="set1_coordinates[]" class="sel_coordinates<?php echo $image_id;?>" value="<?php echo $crop_image_coordinates;?>"><a href="javascript:void(0);" class="crop_img" foldername=<?php echo $FOLDER_NAME; ?> value="<?php echo SET1_IMAGE_RESIZE_PREFIX; ?><?php echo $image_name;?>"  imgno="<?php echo $image_id;?>"  addedimgID="<?php echo $image_id;?>"><img border="0" title="Adjust Thumbnail" src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/cropIcon.png"></a> </td>
                        					<?php } ?>
                                        	<td><a href="javascript:void(0);" onclick="$(this).removeImage({imgID:<?php echo $image_id;?>,foldername:'<?php echo $FOLDER_NAME; ?>',copy:'<?php echo $copy; ?>'});" class="removeImage"><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cms-icon/trash.png" title="Delete Thumbnail" border="0" /></a><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>loader-small.gif" class="removeImageLoader" style="display:none;" /> </td>
                                    	</tr>
                                    </table>
                                </div>
                                
                                <img src="<?php echo CMS_INCLUDES_ICON_RELATIVE_PATH; ?>arrow_pos.png" class="handle moveIcon" alt="Set Position"/>
                            </div>      
                <?php  
                           
                        }      
                    }
                    
                    // If Database is THERE and Physical image is MISSING ( NOT a SINGLE, Than this will show Upload Box  ) 
                    if ( intval($atleastONE) == intval(0) ){
                        $set1_uploadMORE = 1;    
                    } 
                    
                }
                //echo "--->$set1_uploadMORE<BR>";
                ?>
                <!--div for image upload button start-->
                <div id="set1_pickup" class="uploadImgContainer" <?php if (intval($set1_uploadMORE) == intval(0) ){ echo " style='display:none;' "; }else{  }?> >
                	<div class="uploadImgBox">
                    	<img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>blackUploadArea.png" class="fullImg"/>
                        <div class="addPhotoIconTbl"><span><a href="#/" id="set1_filelist" style='cursor:pointer !important' ><img src="<?php echo CMS_INCLUDES_IMAGES_RELATIVE_PATH; ?>cameraIcon.png" alt="Upload Photo"/><br/>Upload</a></span></div>
                    </div>
                    <div class="uploadImgBtn"></div>
                </div>
                <!--div for image upload button end-->
                <div id="set1_upload_container" style="display:none;"></div>
            </div>