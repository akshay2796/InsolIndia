<?php

echo "<div style='text-align:center;margin-top:10%' >";
    echo  "<img src='" . CMS_INCLUDES_IMAGES_RELATIVE_PATH . "invalid_access.png' alt='Invalid Access' title='Invalid Access'/>";
    echo "<BR><BR>";
    echo $_SESSION["UNUTHORISED"];
    echo "<BR><BR>";    
echo "</div>";  
?>

