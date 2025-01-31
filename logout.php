<?php  

session_start();  // Start The Session

session_unset();  // Remove The Data From Session

session_destroy();  // Destroy The Session

header("location: index.php");
exit();