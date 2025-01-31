<?php



/*
===This Function Return Records Of Categories In DataBase  
*/
function getAll($field, $table, $where = NULL, $orderField, $ordering = 'DESC')
{

    global $conn;

    $state = $conn->prepare("SELECT $field FROM $table $where ORDER BY $orderField $ordering");

    $state->execute();

    $all = $state->fetchAll();

    return $all;
}



// function getAll($field, $table, $orderField, $ordering = 'DESC', $where = NULL)
// {
//     global $conn;

//     $state = $conn->prepare("SELECT $field FROM $table $where ORDER BY $orderField $ordering");

//     $state->execute();

//     $all = $state->fetchAll();

//     return $all;
// }


/*
===This Function Return Records Of Items In DataBase depands On [ Category Id OR Member Id ]   
*/
function getItems($column, $value, $approve = null)
{

    global $conn;

    $sql = $approve == null ? 'AND approve = 1' : '';

    $state = $conn->prepare("SELECT * FROM items WHERE `$column` = ? $sql ORDER BY id DESC");

    $state->execute(array($value));

    $items = $state->fetchAll();

    return $items;
}


/*
===This Function Return Records Of Categories In DataBase  
*/
function getcat()
{

    global $conn;

    $state = $conn->prepare("SELECT * FROM categories ORDER BY id ASC");

    $state->execute();

    $cats = $state->fetchAll();

    return $cats;
}

/*
===This Function Return The Number OF Records For Not Activate Users Depands on Regstatus In DataBase  
*/
function checkUserStatus($username)
{

    global $conn;

    $stmt = $conn->prepare("SELECT username, regstatus  FROM users WHERE username = ? AND regstatus = 0");

    $stmt->execute(array($username));

    $status = $stmt->rowCount();

    return $status;
}


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
