<?php

$dsn = "mysql:host=localhost;dbname=ecommerce_db";
$user = "root";
$pass = '';
$options = array(

    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

try {

    $conn = new PDO($dsn, $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo 'connected';
   
} catch (PDOException $e) {

    echo 'Failed To Connect' . $e->getMessage();
}
