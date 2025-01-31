<?php

include "connect.php";

// Routes 

    $temp = "includes/template/"; // Template Directory
    $languages = "includes/languages/"; // Languages Directory
    $funcs = "includes/functions/"; // Functions Directory
    $js = "layout/js/"; // CSS Directory
    $css = "layout/css/";  //JS Directory
   


//  Including The Important Pages Using In Our Website

include $funcs . 'function.php';
include $languages . 'english.php';
include $temp . 'header.php';

if(!isset($noNavbar)){

    include $temp . 'navbar.php';
}

include $temp . 'footer.php';
