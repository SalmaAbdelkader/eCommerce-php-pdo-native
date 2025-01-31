<?php

// ============================================================
// ================== Template Page ===========================
// ============================================================
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Members';
    include "init.php";


    //  Including The Function Pages of The Categories Like (Add, Edit,update ,Delete)  ,etc 

    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';



    if ($action == 'manage') {
    ?>

        <!-- ======================Manage Members Page  ========================= -->

        <?php
    } elseif ($action == 'add') {

    ?>

        <!-- ======================Adding Profile ========================= -->



        <?php

    } elseif ($action == 'insert') {

    } elseif ($action == 'edit') {

    } elseif ($action == 'Update') {
    } elseif ($action == 'delete') {
    } elseif ($action == 'Activate') {
    } else {

        echo " There Are SomeThing Wrong";
    }

    include $temp . 'footer.php';
} else {

    header("location: index.php");
    exit();
}

ob_end_flush();
