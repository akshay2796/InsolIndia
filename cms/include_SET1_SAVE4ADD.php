<?php 

                    /////////////---------------images============================ 
                    if ( SET1_ENABLE == true ){
                        
                         
                        $TABLE_NAME = $TITLE;
                        
                        if(intval(count($SET1_ARR_image)) > intval(0))
                        {
                             
                            foreach($SET1_ARR_image as $IDX => $iVAL)
                            {
                                
                                //echo $iVAL . "###\n";
                                $iNAME = "";
                                $iNAME = trustme($iVAL);
                                //echo $iNAME . "###\n";
                                
                                $iID = intval($SET1_ARR_imageid[$IDX]);
                                $iCAPTION = trustme($SET1_ARR_imagecaption[$IDX]);
                                
                                //echo "$iNAME===$iID===<BR>";
                                
                                
                                $selected_coordinates = "";
                                if ( SET1_IMAGE_CROPPING == true ){    
                                    $selected_coordinates = $SET1_ARR_coordinates[$IDX];
                                }elseif ( SET1_IMAGE_CROPPING == false ){
                                    $selected_coordinates = "";
                                }
                                
                                
                                $MYFOLDERNAME = "";
                                $MYFOLDERNAME = $SET1_ARR_folder[$IDX];
                            
                                
                                if(intval($iID) == intval(0) )
                                {
                                    $SOURCE_FOLDER = "";
                                    $SOURCE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD . "/";
                                    
                                    $DESTINATION_FOLDER = "";
                                    $DESTINATION_FOLDER = SET1_FOLDER_PATH . "/";
                                    
                                    $R_IMG = "";
                                    if ( trim(SET1_IMAGE_RESIZE)  == "YES" ){                            
                                        $R_IMG = SET1_IMAGE_RESIZE_PREFIX.$iNAME;                                
                                    }else if ( trim(SET1_IMAGE_RESIZE)  == "NO" ){  
                                        $R_IMG = "";                                      
                                    }  
                                    
                                     
                                    if ( SET1_IMAGE_CROPPING  == true ){                        
                                        $C_IMG = "C".SET1_CROP_SIZE."-".$R_IMG;                        
                                    }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                        $C_IMG = "";                                
                                    }
                                    
                                     
                                 
                                }
                                else
                                {
                                    
                                    $SOURCE_FOLDER = "";
                                    $SOURCE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                                    
                                    $DESTINATION_FOLDER = "";
                                    $DESTINATION_FOLDER = SET1_FOLDER_PATH . "/";
                                    
                                    $R_IMG = "";
                                    if ( trim(SET1_IMAGE_RESIZE)  == "YES" ){                            
                                        $R_IMG = SET1_IMAGE_RESIZE_PREFIX.$iNAME;                                
                                    }else if ( trim(SET1_IMAGE_RESIZE)  == "NO" ){  
                                        $R_IMG = "";                                      
                                    }  
                                    
                                     
                                    if ( SET1_IMAGE_CROPPING  == true ){                        
                                        $C_IMG = "C".SET1_CROP_SIZE."-".$R_IMG;                        
                                    }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                        $C_IMG = "";                                
                                    }
                                    
                                }            
                                
                                
                                
                                $chkFILE = chkImageExists($SOURCE_FOLDER . $iNAME);
                                $chkCROPFILE = 0;
                                
                                if ( SET1_IMAGE_CROPPING  == true ){                        
                                    $chkCROPFILE = chkImageExists($SOURCE_FOLDER . $C_IMG);                 
                                }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                    $chkCROPFILE = 0;                           
                                }
                                
                                
                                //echo "Upload IMG  = " . $iNAME . " \n";
                                //echo "File CROP = " . $SOURCE_FOLDER . $C_IMG . " \n";
                                //echo "chk CROP = $chkCROPFILE \n";
                                
                                if(intval($chkFILE) == intval(1))
                                {
                                    
                                    $MAXID_IMG = getMaxId(SET1_DBTABLE,"image_id"); 
                                    $position  = getMaxPosition(SET1_DBTABLE,"position","master_id",$RTNID,"=");
                                    
                                    $NAME = trim($TABLE_NAME);
                                    $NAME = filterString($NAME);
                                    $NAME = limit_charaters($NAME, 50); 
                                    //$NAME = $NAME  . "." . $img_ext['extension'];
                                    
                                    //echo $iNAME . "$$$$\n"; 
                                    //echo $NAME . "****\n"; 
                                    $img_ext = pathinfo($iNAME);
                                    $IMG =  strtolower($NAME) . "-" . $RTNID . "-" . $MAXID_IMG . "." . $img_ext['extension'];
                                    //echo $IMG . "^^^^\n"; 
                                    
                                    //exit();
                                    
                                    copy($SOURCE_FOLDER.$iNAME, $DESTINATION_FOLDER.$IMG);  
                                   
                                    if ( SET1_IMAGE_CROPPING  == true ){                        
                                        copy($SOURCE_FOLDER.$R_IMG,$DESTINATION_FOLDER.SET1_IMAGE_RESIZE_PREFIX.$IMG);         
                                    }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                                    
                                    }
                                    
                                    
                                    
                                    if( intval($chkCROPFILE) == intval(1) )
                                    {
                                        copy($SOURCE_FOLDER.$C_IMG,$DESTINATION_FOLDER.SET1_CROP_PREFIX.$IMG); 
                                    }
                                     
                                    resizeIMG(SET1_FOR,trim($IMG),$MAXID_IMG,$DESTINATION_FOLDER);   
                                   
                                    if( trim($SET1_deafult) == trim($iNAME) )
                                    {  
                                        $defaultImage ="YES";
                                    }
                                    else
                                    {   
                                        $defaultImage ="NO";
                                    }
                                    
                                   
                                    $SQL_IMG  = "";
                                    $SQL_IMG .= " INSERT INTO " . SET1_DBTABLE . " SET ";
                                    $SQL_IMG .= " image_id = :image_id, ";    
                                    $SQL_IMG .= " master_id = :master_id, ";         
                                    $SQL_IMG .= " default_image = :default_image, ";         
                                    $SQL_IMG .= " image_name = :image_name, "; 
                                    $SQL_IMG .= " image_caption = :image_caption, "; 
                                    $SQL_IMG .= " crop_image_coordinates = :crop_image_coordinates, ";          
                                    $SQL_IMG .= " position = :position, "; 
                                    $SQL_IMG .= " add_ip = :add_ip, ";         
                                    $SQL_IMG .= " add_by = :add_by, ";         
                                    $SQL_IMG .= " add_time = :add_time ";             
                                    
                                    $stmtIMG = $dCON->prepare( $SQL_IMG );
                                    $stmtIMG->bindParam(":image_id", $MAXID_IMG);
                                    $stmtIMG->bindParam(":master_id", $RTNID);
                                    $stmtIMG->bindParam(":default_image",$defaultImage);
                                    $stmtIMG->bindParam(":image_name", $IMG); 
                                    $stmtIMG->bindParam(":image_caption", $iCAPTION); 
                                    $stmtIMG->bindParam(":crop_image_coordinates",$selected_coordinates);
                                    $stmtIMG->bindParam(":position",$position);
                                    $stmtIMG->bindParam(":add_ip",$IP);
                                    $stmtIMG->bindParam(":add_by",$_SESSION['USERNAME']);
                                    $stmtIMG->bindParam(":add_time",$TIME); 
                                    $rsImage = $stmtIMG->execute();
                                    //print_r($stmtIMG->errorInfo());
                                    $stmtIMG->closeCursor();
                                    
                                }
                                
                               
                                deleteIMG(SET1_FOR,$iNAME,$SOURCE_FOLDER);
                                
                                
                            }
                            
                            
                            ///exit();
                            
                        }  
                  
                    }

?>