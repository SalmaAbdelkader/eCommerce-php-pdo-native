<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Members';
    include "init.php";


    //  Including The Function Pages of The Users Like (Add, Edit,update ,Delete)  ,etc 

    $action = '';
    if (isset($_GET['action'])) {

        $action = $_GET['action'];
    } else {

        $action = 'manage';
    }

    if ($action == 'manage') {
?>

        <!-- ======================Manage Members Page  ========================= -->

        <h1 class="text-center">Manage Member</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table manage-members text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <!-- <td>Avatar</td> -->
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registered Date</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    // Select the Data Of Users From DataBase
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {

                        if (isset($_GET['page'])) {

                            $stmt = $conn->prepare("SELECT * FROM users WHERE regstatus = 0 ORDER BY id DESC");
                        } else {

                            $stmt = $conn->prepare("SELECT * FROM users ORDER BY id DESC");
                        }
                    } else {

                        $stmt = $conn->prepare("SELECT * FROM users WHERE group_id != 1 ORDER BY id DESC");
                    }



                    $stmt->execute();

                    // Counting The Record Of this user in database
                    $count = $stmt->rowCount();

                    // Fetching Data from DataBase
                    $data = $stmt->fetchAll();
                    // Check If There Is data of users in Database or not 
                    if(!empty($data)){

                                foreach ($data as $row) {
                                ?>
                                    <tr>

                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['username']; ?></td>
                                        <td><?= $row['email']; ?></td>
                                        <td><?= $row['fullname']; ?></td>
                                        <td><?= $row['Date']; ?></td>
                                        <!-- <td></td> -->
                                        <td>
                                            <a href="members.php?action=edit&userId= <?= $row['id']; ?>" class="btn btn-success"><i class="fa fa-edit icon"></i>Edit</a>
                                            <?php
                                            if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {

                                            ?>
                                                <a href="members.php?action=delete&userId= <?= $row['id']; ?>" class="btn btn-danger hidden confirm"><i class="fa fa-close icon"></i>Delete</a>

                                            <?php

                                            } else {
                                            ?>
                                                <a href="members.php?action=delete&userId= <?= $row['id']; ?>" class="btn btn-danger confirm"><i class="fa fa-close icon"></i>Delete</a>

                                            <?php  }
                                            if ($row['regstatus'] == 0) {
                                            ?>
                                                <a href="members.php?action=Activate&userId= <?= $row['id']; ?>" class="btn btn-info "><i class="fa fa-check icon"></i>Activate</a>


                                            <?php
                                            }

                                            ?>

                                        </td>
                                    </tr>

            <?php
                                }
                    }else{
                        echo '<div class="container">';
                            echo '<div class="nice-message"> There\'s No Members To Show</div>';
                        echo  '</div>';
                    }
                    ?>

                </table>
            </div>
            <a href="members.php?action=Add" class="btn btn-primary">
                <i class="fa fa-plus"></i> New Member
            </a>
        </div>

    <?php
    } elseif ($action == 'Add') {

    ?>

        <!-- ======================Adding Profile ========================= -->

        <h1 class="text-center">Add New Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?action=insert" method="POST">
                <!-- Start Username Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Enter Your Username To Login" />
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Start Password Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="password" name="password" class="password form-control" autocomplete="new-password" placeholder="Your Password Must Be Hard And Complex" />
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Email Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" class="form-control" required="required" placeholder="Your Email Must Be Valid" />
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Full Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="fullname" class="form-control" required="required" placeholder="Enter Your FullName To Appear In Your Profile" />
                    </div>
                </div>
                <!-- End Full Name Field -->
                <!-- Start Submit Field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>

        <?php
    } elseif ($action == 'insert') {


        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo ' <h1 class="text-center">Insert Member</h1>';

            // Reciving Variables From Request

            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];

            // Hashing Password Using Sha1()
            $hashpass = sha1($password);

            // Validation Input Feilds And Handling Errors
            $fromErrors = array();
            if (strlen($username) < 4) {

                $fromErrors[] = 'Username Must Be More Than <strong>4 Character</strong>';
            }
            if (strlen($username) > 20) {

                $fromErrors[] = 'Username Must Be Less Than <strong>20 Character</strong>';
            }
            if (empty($username)) {

                $fromErrors[] = 'UserName Cant Be <strong>Empty</strong>';
            }
            if (empty($password)) {

                $fromErrors[] = 'Password Cant Be <strong>Empty</strong>';
            }
            if (empty($email)) {

                $fromErrors[] = 'Email Cant Be <strong>Empty</strong>';
            }
            if (empty($fullname)) {

                $fromErrors[] = 'FullName Cant Be <strong>Empty</strong>';
            }

            foreach ($fromErrors as $errors) {

                $theMsg =  '<div class=" conianter alert alert-danger ">' . $errors . '</div>';

                redirect_home($theMsg, 'back');
            }

            // Inserting The Data In DataBase Using This Information

            if (empty($fromErrors)) {

                // Check Existing User Function

                $check =  Check_data("username", "users", $username);

                //  If User Equal 1 => This Meaning The User Is Exist
                if ($check == 1) {

                    $error_msg =  '<div class=" conianter alert alert-danger "> Sorry, This User Is Exist </div>';

                    redirect_home($error_msg, "members.php?action=manage", 10);
                } else {

                    $stmt = $conn->prepare("INSERT INTO `users`( `username`, `password`, `fullname`, `email`, `regstatus`) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute(array($username, $hashpass, $fullname, $email, 1));

                    // Print A Successful Inserted Message

                    $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Inserted</div>';
                    redirect_home($theMsg, "members.php", 10);
                }
            }
        } else {

            $error_msg =  '<div class="container alert alert-danger">Sorry, You Can Access This Page Directly</div>';

            redirect_home($error_msg, "index.php", 10);
        }
    } elseif ($action == 'edit') {

        //  Filter Validation On $_GET['userId] using Numeric function

        $filter_id = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  $_GET['userId'] : 'error';

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1");
        $stmt->execute(array($filter_id));
        // Fetching Data from DataBase
        $row = $stmt->fetch();
        // Counting The Record Of this user in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {


        ?>



            <!-- ======================Editing Profile ========================= -->

            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="userid" value="<?= $row['id']; ?>" />
                    <!-- Start Username Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="username" class="form-control" value="<?= $row['username']; ?>" autocomplete="off" required="required" />
                        </div>
                    </div>
                    <!-- End Username Field -->
                    <!-- Start Password Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="hidden" name="oldpassword" value="<?= $row['password']; ?>" />
                            <input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
                        </div>
                    </div>
                    <!-- End Password Field -->
                    <!-- Start Email Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="email" name="email" value="<?= $row['email']; ?>" class="form-control" required="required" />
                        </div>
                    </div>
                    <!-- End Email Field -->
                    <!-- Start Full Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="fullname" value="<?= $row['fullname']; ?>" class="form-control" required="required" />
                        </div>
                    </div>
                    <!-- End Full Name Field -->
                    <!-- Start Submit Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Save" class="btn btn-primary btn-lg" />
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
            </div>

<?php
        } else {
            echo " There Is No Data In DataBase";
        }
    } elseif ($action == 'Update') {


        if ($_SERVER['REQUEST_METHOD'] = 'POST') {

            // Reciving Variables From Request

            $id = $_POST['userid'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $fullname = $_POST['fullname'];


            // Check The Password is Updated Or Not
            $pass = '';

            if (empty($_POST['newpassword'])) {

                $pass = $_POST['oldpassword'];
            } else {
                $pass = sha1($_POST['newpassword']);
            }

            // Validation Input Feilds And Handling Errors
            $fromErrors = array();
            if (strlen($username) < 4) {

                $fromErrors[] = "Username Must Be More Than 4 Character";
            }
            if (empty($username)) {

                $fromErrors[] = '<div class="alert alert-danger">UserName Cant Be <strong>Empty</strong></div>';
            }
            if (empty($email)) {

                $fromErrors[] = '<div class="alert alert-danger">Email Cant Be <strong>Empty</strong></div>';
            }
            if (empty($fullname)) {

                $fromErrors[] = '<div class="alert alert-danger">FullName Cant Be <strong>Empty</strong></div>';
            }

            foreach ($fromErrors as $errors) {

                echo $errors . ' ' . "<br>";
            }

            // Updates The Data In DataBase Using This Information

            if (empty($fromErrors)) {

                 $state = $conn->prepare(" SELECT * FROM users WHERE username = ? AND id != ?");
                 $state->execute(array($username, $id));
                 $count = $state->rowCount();

                 if($count == 1){

                          $error_msg =  '<div class="container alert alert-danger"> Sorry, This User Is Exist </div>';

                        redirect_home($error_msg, "members.php?action=manage", 10);
                 }


                $stmt = $conn->prepare("UPDATE `users` SET username = ?, password = ?, fullname = ?, email = ? WHERE id = ? ");
                $stmt->execute(array($username, $pass, $fullname, $email, $id));

                // Print A Successful Upadtes Message

                $theMsg =  "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';

                redirect_home($theMsg, 'back', 5);
            }
        } else {

            $error_msg =  " You can\'t Access To this Page ";

            redirect_home($error_msg, "members.php?action=manage", 10);
        }
    } elseif ($action == 'delete') {

        //  Filter Validation On $_GET['userId] using Numeric function

        $filter_id = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  $_GET['userId'] : 'error';

        // Check If The User Is Exists In Database Or Not

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1");

        $stmt->execute(array($filter_id));

        // Counting The Record Of this user in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("DELETE FROM `users` WHERE id = ?");
            $stmt->execute(array($filter_id));

            // Print A Successful Deleted Message

            echo "<div class='alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
        }
    } elseif ($action == 'Activate') {

        //  Filter Validation On $_GET['userId] using Numeric function

        $filter_id = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  $_GET['userId'] : 'error';

        // Check If The User Is Exists In Database Or Not

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1");

        $stmt->execute(array($filter_id));

        // Counting The Record Of this user in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("UPDATE `users` SET `regstatus`='1' WHERE id = ?");
            $stmt->execute(array($filter_id));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Activated</div>';
            redirect_home($theMsg, "members.php?action=manage", 10);
        }
    } else {

        echo " There Are SomeThing Wrong";
    }

    include $temp . 'footer.php';
} else {

    header("location: index.php");
    exit();
}

ob_end_flush();
