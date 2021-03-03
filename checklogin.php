<?php

if(intval($_SESSION['UID_INSOL']) <= intval(0))
{
    //header("Location: " . SITE_ROOT . "login.php?ref=".$ref);
    
    echo "<script type='text/javascript'>window.top.location='" . SITE_ROOT . "login.php'</script>"; 
}
?>