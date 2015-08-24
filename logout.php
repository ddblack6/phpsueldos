<?php
session_start();
session_destroy();
header("Refresh:0; url=http://192.168.0.99/web/phpsueldos/index.php");
 
?>


