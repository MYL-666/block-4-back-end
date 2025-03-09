<?php
// make sure the session would destory
session_start();
session_destroy(); 
header("Location: ../user/login.php"); 
exit;
?>
