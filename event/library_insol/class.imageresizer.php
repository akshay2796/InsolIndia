<?php
/*Thumb Generation Class*/
class ImgResizer {
    private $originalFile = '';
    private $imageType='';
    public function __construct($originalFile = '',$imageType) {
        $this -> originalFile = $originalFile;
        $this ->imageType = $imageType;
    }
    public function resize($ht,$wt, $targetFile) {
        if (empty($ht) || empty($wt) || empty($targetFile)) {
            return false;
        }
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            $src = imagecreatefromjpeg($this -> originalFile);
        }
        if($this ->imageType=="image/gif")
        {
            $src = imagecreatefromgif($this -> originalFile);
        }
        if($this ->imageType=="image/png")
        {
            $src = imagecreatefrompng($this -> originalFile);
        }
        
        list($width, $height) = getimagesize($this -> originalFile);
        
        if($width>=$height)
        {
            $newWidth = $wt;
            $newHeight = ($height / $width) * $newWidth;
        
			if($newHeight>$ht)
			{
				$newHeight = $ht;
				$newWidth = ($width/$height ) * $newHeight;
			}
			
			$lastHeight = $newHeight;
            $lastWidth = $newWidth;
		
		}
        else if($height>=$width)
        {
            $newHeight = $ht;
            $newWidth = ($width / $height) * $newHeight;
			
			if($newWidth>$wt)
			{
				$newWidth = $wt;
				$newHeight = ($height/$width) * $newWidth;
			}
            
			$lastHeight = $newHeight;
            $lastWidth = $newWidth;
        }
        //$newHeight = ($height / $width) * $newWidth;
        
        $tmp = imagecreatetruecolor($lastWidth, $lastHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $lastWidth, $lastHeight, $width, $height);
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            imagejpeg($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/gif")
        {
           imagegif($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/png")
        {
            $black = imagecolorallocate($tmp, 0, 0, 0);
            // Make the background transparent
            imagecolortransparent($tmp, $black);
            imagepng($tmp, $targetFile, 9); 
        }
        // 85 is my choice, make it between 0 – 100 for output image quality with 100 being the most luxurious
    }    
}



class ImgResizerH {
    private $originalFile = '';
    private $imageType='';
    public function __construct($originalFile = '',$imageType) {
        $this -> originalFile = $originalFile;
        $this ->imageType = $imageType;
    }
    public function resize($ht, $targetFile) {
        if (empty($ht) || empty($targetFile)) {
            return false;
        }
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            $src = imagecreatefromjpeg($this -> originalFile);
        }
        if($this ->imageType=="image/gif")
        {
            $src = imagecreatefromgif($this -> originalFile);
        }
        if($this ->imageType=="image/png")
        {
            $src = imagecreatefrompng($this -> originalFile);
            
            imagealphablending($src, false);
            imagesavealpha($src, true);

        }
        
        list($width, $height) = getimagesize($this -> originalFile);
        
        /*
        if($width>=$height)
        {
            $newWidth = $wt;
            $newHeight = ($height / $width) * $newWidth;
        
			if($newHeight>$ht)
			{
				$newHeight = $ht;
				$newWidth = ($width/$height ) * $newHeight;
			}
			
			$lastHeight = $newHeight;
            $lastWidth = $newWidth;
		
		}
        else if($height>=$width)
        {*/
            $newHeight = $ht;
            $newWidth = ($width / $height) * $newHeight;
			/*
			if($newWidth>$wt)
			{
				$newWidth = $wt;
				$newHeight = ($height/$width) * $newWidth;
			}
            
			$lastHeight = $newHeight;
            $lastWidth = $newWidth;
        }*/
        $lastHeight = $newHeight;
        $lastWidth = $newWidth;
        //$newHeight = ($height / $width) * $newWidth;
        
        $tmp = imagecreatetruecolor($lastWidth, $lastHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $lastWidth, $lastHeight, $width, $height);
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            imagejpeg($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/gif")
        {
           imagegif($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/png")
        {
            $black = imagecolorallocate($tmp, 0, 0, 0);
            // Make the background transparent
            imagecolortransparent($tmp, $black);
            imagepng($tmp, $targetFile, 9); 
        }
        // 85 is my choice, make it between 0 – 100 for output image quality with 100 being the most luxurious
    }    
}



class ImgResizerW {
    private $originalFile = '';
    private $imageType='';
    public function __construct($originalFile = '',$imageType) {
        $this -> originalFile = $originalFile;
        $this ->imageType = $imageType;
    }
    public function resize($wt, $targetFile) {
        if (empty($wt) || empty($targetFile)) {
            return false;
        }
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            $src = imagecreatefromjpeg($this -> originalFile);
        }
        if($this ->imageType=="image/gif")
        {
            $src = imagecreatefromgif($this -> originalFile);
        }
        if($this ->imageType=="image/png")
        {
            $src = imagecreatefrompng($this -> originalFile);
            
            imagealphablending($src, false);
            imagesavealpha($src, true);

        }
        
        list($width, $height) = getimagesize($this -> originalFile);
        
        $newWidth = $wt;
        $newHeight = ($height / $width) * $newWidth;
    
		
         
        $lastHeight = $newHeight;
        $lastWidth = $newWidth;
        //$newHeight = ($height / $width) * $newWidth;
        
        $tmp = imagecreatetruecolor($lastWidth, $lastHeight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $lastWidth, $lastHeight, $width, $height);
        if (file_exists($targetFile)) {
            unlink($targetFile);
        }
        
        if($this ->imageType=="image/jpeg" || $this ->imageType=="image/jpg" || $this ->imageType=="image/pjpeg")
        {
            imagejpeg($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/gif")
        {
           imagegif($tmp, $targetFile, 100); 
        }
        if($this ->imageType=="image/png")
        {
            $black = imagecolorallocate($tmp, 0, 0, 0);
            // Make the background transparent
            imagecolortransparent($tmp, $black);
            imagepng($tmp, $targetFile, 9); 
        }
        // 85 is my choice, make it between 0 – 100 for output image quality with 100 being the most luxurious
    }    
}

/*Thumb Generation Class End*/

/*example
$work2 = new ImgResizer("../products/".$_FILES['image']['name'],$_FILES['image']['type']);
    $work2 -> resize(125,125,"../products/thumb_".$_FILES['image']['name']);*/

function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
	list($imagewidth, $imageheight, $imageType) = getimagesize($image);
	$imageType = image_type_to_mime_type($imageType);
	
	$newImageWidth = ceil($width * $scale);
	$newImageHeight = ceil($height * $scale);
	$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
	switch($imageType) {
		case "image/gif":
			$source=imagecreatefromgif($image); 
			break;
	    case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
			$source=imagecreatefromjpeg($image); 
			break;
	    case "image/png":
		case "image/x-png":
			$source=imagecreatefrompng($image); 
			break;
  	}
	imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
	switch($imageType) {
		case "image/gif":
	  		imagegif($newImage,$thumb_image_name); 
			break;
      	case "image/pjpeg":
		case "image/jpeg":
		case "image/jpg":
	  		imagejpeg($newImage,$thumb_image_name,100); 
			break;
		case "image/png":
		case "image/x-png":
			imagepng($newImage,$thumb_image_name);  
			break;
    }
	chmod($thumb_image_name, 0777);
	return $thumb_image_name;
}


function makeThumbnail($CROP_WIDTH, $CROP_HEIGHT, $CROP_2_RESIZE_DIMENTION, $x1, $y1, $x2, $y2, $w, $h, $CROP_RELATIVE_PATH, $RESIZE_RELATIVE_PATH, $FOLDER_NAME)
{
    //Scale the image to the CROP_WIDTH set above
    $scale = $CROP_WIDTH/$w;
    $cropped = resizeThumbnailImage($CROP_RELATIVE_PATH, $RESIZE_RELATIVE_PATH,$w,$h,$x1,$y1,$scale);
    
    //resize cropped image
    if(trim($CROP_2_RESIZE_DIMENTION) != "")
    {
        $CROP_2_RESIZE_DIMENTION = strtoupper($CROP_2_RESIZE_DIMENTION);
        $resize_size_array = explode("|", $CROP_2_RESIZE_DIMENTION);
        
        if(intval(count($resize_size_array)) > intval(0))
        {
            $thumb_width_resize_array = explode(",", $thumb_width_resize);
            $thumb_height_resize_array = explode(",", $thumb_height_resize);
            
            foreach($resize_size_array as $resize_size_result)
            {
                $resize_d_array = explode("X", $resize_size_result); 
                
                $RESIZE_WIDTH = intval($resize_d_array[0]);
                $RESIZE_HEIGHT = intval($resize_d_array[1]); 
                /*resize images*/  
                $new_file_name = basename($CROP_RELATIVE_PATH);
                $file_type = getimagesize($CROP_RELATIVE_PATH); 
                $work = new ImgResizer($CROP_RELATIVE_PATH, $file_type['mime']);
                $work->resize($RESIZE_HEIGHT,$RESIZE_WIDTH, $FOLDER_NAME . "/B" . $RESIZE_WIDTH . "_" . $new_file_name);
                
            }
        }
    }
    
    //Reload the page again to view the thumbnail
    //header("location:".$_SERVER["PHP_SELF"]);
    //exit();
    //echo $CROP_RELATIVE_PATH; 
}
    
?>