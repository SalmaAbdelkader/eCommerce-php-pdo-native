<?php

// This Function Use To Make The Title Dynamic IN All Pages 

function set_title()
{

    global $title;

    if (isset($title)) {

        echo $title;
    } else {

        echo "Default";
    }
}


// This Function Used To Print [Error - Success - Warning ]  Message and Redirect To Home Page After Number Of Seconds
// The Style Of The Message Will Send With The Message In The Variable


function redirect_home($The_msg, $url = null, $seconds = 5)
{
    if ($url === null) {

        $url = 'index.php';
        $link_page = 'HomePage';
    } else {

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

            $url = $_SERVER['HTTP_REFERER'];
            $link_page = 'Previous Page';
        } else {

            $url = 'index.php';
            $link_page = 'HomePage';
        }
    }

    // Print Error Message
    echo  $The_msg;

    echo '<div class="container alert alert-info"> You Will Be Redirect To ' . $link_page . ' After ' . $seconds . 'Seconds </div>';

    // redirect To Index Page

    header("refresh:$seconds;url=$url");

    exit();
}

// This Function Used To Check If The User Is Exist Or Not
// It Takes Parameter Such as [$select => The Value That I Need From DataBase]
//                            [$from => The Name Of Table Which Contains My Data]
//                            [$value => The Condiction That I Make A Select Depands On It]

function Check_data($select, $from, $value)
{

    global $conn;
    $state = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");
    $state->execute(array($value));
    $data = $state->fetchAll();
    $count = $state->rowCount();
    return $count;
}


/*
--This Function Use To Count The Number Of [Items | Members | Categories]
-- This Function Take Arguments[]


*/

function countAll($column, $table, $value = null)
{

    global $conn;

    // Select Count Rows In DataBase
    if (isset($value) && $value == null) {


        $stmt = $conn->prepare("SELECT COUNT($column) FROM $table WHERE $column = ?");
        // Execute Query 
        $stmt->execute(array($value));
    } else {


        $stmt = $conn->prepare("SELECT COUNT($column) FROM $table ");
        // Execute Query 
        $stmt->execute();
    }


    // Fetch The Count Of Rows

    $stmt = $stmt->fetchColumn();

    return $stmt;
}

/*
===This Function To Get Latest [Users - Items - Categories - Comments]
=== It Takes Parameter Such as [$select => The Value That I Need From DataBase]
===                            [$table => The Name Of Table Which Contains My Data]
===                            [$order => The Condiction That I want to order depands on it ]
===                            [$limit => The number Of Records That Return From State ]
*/
function getlatest($select, $table, $order, $limit = 5){

    global $conn;

    $state = $conn->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $state->execute();

    $data = $state->fetchAll();

    return $data;
}