<?php

include "admin/connect.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

$user_session = '';

if(isset($_SESSION['user'])){

    $user_session = $_SESSION['user'];

}

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


