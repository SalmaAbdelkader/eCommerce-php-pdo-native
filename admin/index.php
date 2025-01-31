<?php
session_start();
$noNavbar = '';
$title = 'Login';
if(isset($_SESSION['username'])){
  header("location: dashboard.php"); // Redirect To Dashboard
}

include "init.php";


// die();

// Check If Request Method Coming From Form Is Post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $username = $_POST['user'];
  $password = $_POST['pass'];
  $hashedpass = sha1($password);

  // echo $hashedpass . $username;

  // Check If The User Is Exists In Database Or Not

  // $stmt = $conn -> prepare("SELECT id, username, password, group_id FROM users WHERE username = ? AND password = ? AND group_id = 1 LIMIT 1");
  $stmt = $conn -> prepare("SELECT id, username, password, group_id FROM users WHERE username = ? AND password = ?");

  $stmt -> execute(array($username ,$hashedpass));
  $data = $stmt->fetch();
  // print_r($data);
  $count = $stmt ->rowCount();
 
  // If $count > 0 This Mean That User Has Account In Database
  
  if($count > 0){
      
    $_SESSION['username'] = $username;  // Create Session For User
    $_SESSION['id'] = $data['id']; //Creating Session Using Id 
    $_SESSION['admin'] = $data['group_id'];
    // echo $_SESSION['username'];die;

    header("location: dashboard.php"); // Redirect To Dashboard
    exit();
    
  }else{

    $theMsg = '<div class="container alert alert-danger"> You Not Have Account </div>';

    redirect_home($theMsg);
  }

}

?>

<form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <h4 class="text-center">Admin Login</h4>
  <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
  <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
  <input class="btn btn-primary btn-block" type="submit" value="Login" />
</form>


<?php include $temp . 'footer.php'; ?>