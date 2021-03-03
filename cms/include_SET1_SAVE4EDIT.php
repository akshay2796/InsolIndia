<?php

                    /////////////---------------images============================ 
                    if ( SET1_ENABLE == true ){
                    
                        
                        $TABLE_NAME = $TITLE;
                        
                        if(intval(count($SET1_ARR_image)) > intval(0))
                        {
                            
                            // SET default image to NO ALL SAVED IMAGES ==========
                            $defSQL  = "";
                            $defSQL .= " UPDATE " . SET1_DBTABLE . " SET ";
                            $defSQL .= " default_image = 'NO' "; 
                            $defSQL .= " where master_id = :master_id ";         
                          
                            
                            $sUPD = $dCON->prepare( $defSQL );
                            $sUPD->bindParam(":master_id", $RTNID);
                            $sUPD->execute();
                            //print_r($sUPD->errorInfo()); 
                            $sUPD->closeCursor();
                            
                                                    
                            foreach($SET1_ARR_image as $IDX => $iVAL)
                            {
                                
                                $iNAME = "";
                                $iNAME = trustme($iVAL);
                                
                                $iID = intval($SET1_ARR_imageid[$IDX]);
                                $iCAPTION = trustme($SET1_ARR_imagecaption[$IDX]);
                                
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
                                    $SOURCE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                                    
                                    $DESTINATION_FOLDER = "";
                                    $DESTINATION_FOLDER = SET1_FOLDER_PATH . "/";
                                    
                                    
                                    $R_IMG = "";
                                    if ( trim(SET1_IMAGE_RESIZE)  == "YES" ){                            
                                        $R_IMG = SET1_IMAGE_RESIZE_PREFIX.$iNAME;                                
                                    }else if ( trim(SET1_IMAGE_RESIZE)  == "NO" ){  
                                        $R_IMG = "";                                      
                                    }  
                                    
                                    $C_IMG = ""; 
                                    if ( SET1_IMAGE_CROPPING  == true ){                        
                                        $C_IMG = "C".SET1_CROP_SIZE."-".$R_IMG;                        
                                    }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                        $C_IMG = "";                                
                                    }
                                    
                                    $chkFILE = chkImageExists($SOURCE_FOLDER . $iNAME);
                                    $chkCROPFILE = 0; 
                                    
                                    if ( SET1_IMAGE_CROPPING  == true ){                        
                                        $chkCROPFILE = chkImageExists($SOURCE_FOLDER . $C_IMG);                 
                                    }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                        $chkCROPFILE = 0;                           
                                    }
                                     
                                    
                                    if(intval($chkFILE) == intval(1))
                                    {
                                        
                                        $MAXID_IMG = getMaxId(SET1_DBTABLE,"image_id"); 
                                        $position  = getMaxPosition(SET1_DBTABLE,"position","master_id",$RTNID,"=");
                                         
                                        $NAME = trim($TABLE_NAME);
                                        $NAME = filterString($NAME);
                                        $NAME = limit_charaters($NAME, 50); 
                                        
                                        $img_ext = pathinfo($iNAME);
                                        $IMG =  strtolower($NAME) . "-" . $RTNID . "-" . $MAXID_IMG . "." . $img_ext['extension'];                                
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
                                        //echo $SQL_IMG . $iCAPTION . "\n"; 
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
                                        // echo intval($rsImage);
                                        $stmtIMG->closeCursor();
                                      
                                    }
                                    
                                    //deleteIMG(SET1_FOR,$iNAME,CMS_UPLOAD_FOLDER_RELATIVE_PATH . TEMP_UPLOAD);
                                    
                                    deleteIMG(SET1_FOR,$iNAME,$SOURCE_FOLDER);
                               
                                }else{
                                    
                                    //echo "==>" . $iCAPTION . "\n";
                                    // IF CORDINATES CHANGED / MODIFY for EXISTING IMAGES =========
                                    if ( ( SET1_TYPE == "IMAGE" ) && ( SET1_IMAGE_CROPPING == true ) ){
                                        
                                        $SOURCE_FOLDER = "";
                                        $SOURCE_FOLDER = CMS_UPLOAD_FOLDER_RELATIVE_PATH . $MYFOLDERNAME . "/";
                                        
                                        $DESTINATION_FOLDER = "";
                                        $DESTINATION_FOLDER = SET1_FOLDER_PATH;
                                        
                                        
                                        $R_IMG = "";
                                        if ( trim(SET1_IMAGE_RESIZE)  == "YES" ){                            
                                            $R_IMG = SET1_IMAGE_RESIZE_PREFIX.$iNAME;                                
                                        }else if ( trim(SET1_IMAGE_RESIZE)  == "NO" ){  
                                            $R_IMG = "";                                      
                                        }  
                                        
                                        $C_IMG = ""; 
                                        if ( SET1_IMAGE_CROPPING  == true ){                        
                                            $C_IMG = "C".SET1_CROP_SIZE."-".$R_IMG;                        
                                        }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                            $C_IMG = "";                                
                                        }
                                        
                                        $chkFILE = chkImageExists($SOURCE_FOLDER . $iNAME);
                                        $chkCROPFILE = 0; 
                                        
                                        if ( SET1_IMAGE_CROPPING  == true ){                        
                                            $chkCROPFILE = chkImageExists($SOURCE_FOLDER . $C_IMG);                 
                                        }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                            $chkCROPFILE = 0;                           
                                        }
                                        
                                        $NAME = filterString($TABLE_NAME);
                                        $img_ext = pathinfo($iNAME);
                                        $IMG =  strtolower($NAME) . "-" . $RTNID . "-" . $iID . "." . $img_ext['extension'];                                
                                                                      
                                         
                                        
                                        if( trim($IMG) != trim($iNAME) )
                                        {    
                                            copy($SOURCE_FOLDER.$iNAME, $DESTINATION_FOLDER.$IMG);   
                                            
                                            resizeIMG(SET1_FOR,trim($IMG),$iID,$DESTINATION_FOLDER);   
                                        }
                                        else
                                        {
                                             $IMG = $iNAME;
                                        }   
                                            
                                        
                                                                             
                                        if ( SET1_IMAGE_CROPPING  == true ){                        
                                            if( intval($chkCROPFILE) == intval(1) )
                                            {
                                                copy($SOURCE_FOLDER.$C_IMG,$DESTINATION_FOLDER.SET1_IMAGE_RESIZE_PREFIX.$C_IMG);
                                            }         
                                        
                                        }else if ( SET1_IMAGE_CROPPING  == false ){                         
                                                        
                                        }
                                         
                                          
                                           
                                        $SQL_IMG  = "";
                                        $SQL_IMG .= " UPDATE " . SET1_DBTABLE . " SET ";
                                        $SQL_IMG .= " image_name = :image_name, "; 
                                        $SQL_IMG .= " image_caption = :image_caption, "; 
                                        $SQL_IMG .= " crop_image_coordinates = :crop_image_coordinates, ";          
                                        $SQL_IMG .= " update_ip = :update_ip, ";         
                                        $SQL_IMG .= " update_by = :update_by, ";         
                                        $SQL_IMG .= " update_time = :update_time "; 
                                        $SQL_IMG .= " where image_id = :image_id ";   
                                        $SQL_IMG .= " and master_id = :master_id ";         
                                      
                                        
                                        $stmtIMG = $dCON->prepare( $SQL_IMG );
                                        $stmtIMG->bindParam(":image_name", $IMG); 
                                        $stmtIMG->bindParam(":image_caption", $iCAPTION); 
                                        $stmtIMG->bindParam(":crop_image_coordinates",$selected_coordinates);
                                        $stmtIMG->bindParam(":update_ip",$IP);
                                        $stmtIMG->bindParam(":update_by",$_SESSION['USERNAME']);
                                        $stmtIMG->bindParam(":update_time",$TIME); 
                                        $stmtIMG->bindParam(":image_id", $iID);
                                        $stmtIMG->bindParam(":master_id", $RTNID);
                                        $rsImage = $stmtIMG->execute();
                                        //print_r($stmtIMG->errorInfo());
                                        //echo intval($rsImage);
                                        $stmtIMG->closeCursor();
                                        
                                    }elseif ( ( SET1_TYPE == "IMAGE" ) && ( SET1_IMAGE_CAPTION == true ) ){
                                    
                                        $SQL_IMG  = "";
                                        $SQL_IMG .= " UPDATE " . SET1_DBTABLE . " SET ";
                                        $SQL_IMG .= " image_caption = :image_caption, "; 
                                        $SQL_IMG .= " update_ip = :update_ip, ";         
                                        $SQL_IMG .= " update_by = :update_by, ";         
                                        $SQL_IMG .= " update_time = :update_time "; 
                                        $SQL_IMG .= " where image_id = :image_id ";   
                                        $SQL_IMG .= " and master_id = :master_id ";         
                                      
                                        
                                        $stmtIMG = $dCON->prepare( $SQL_IMG );
                                        $stmtIMG->bindParam(":image_caption", $iCAPTION); 
                                        $stmtIMG->bindParam(":update_ip",$IP);
                                        $stmtIMG->bindParam(":update_by",$_SESSION['USERNAME']);
                                        $stmtIMG->bindParam(":update_time",$TIME); 
                                        $stmtIMG->bindParam(":image_id", $iID);
                                        $stmtIMG->bindParam(":master_id", $RTNID);
                                        $rsImage = $stmtIMG->execute();
                                        //print_r($stmtIMG->errorInfo());
                                        //echo intval($rsImage);
                                        $stmtIMG->closeCursor();    
                                        
                                    }
                                    
                                }
                                
                                
                                
                            }
                            
                            
                            /// Set Default Image as YES =================
                            $defSQL  = "";
                            $defSQL .= " UPDATE " . SET1_DBTABLE . " SET ";
                            $defSQL .= " default_image = 'YES' "; 
                            $defSQL .= " where master_id = :master_id ";         
                            $defSQL .= " AND image_name = '$SET1_deafult' ";         
                          
                            
                            $sUPD = $dCON->prepare( $defSQL );
                            $sUPD->bindParam(":master_id", $RTNID);
                            $sUPD->execute();
                            //print_r($sUPD->errorInfo()); 
                            $sUPD->closeCursor();
                            
                        }
                        
                        
                        
                    }


?>