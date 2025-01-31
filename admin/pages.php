<?php


//  Including The Function Pages of The Categories Like (Add, Edit,update ,Delete)  ,etc 

$action = '';
if (isset($_GET['action'])) {

    $action = $_GET['action'];
} else {

    $action = 'manage';
}



if ($action == 'manage') {

    echo "Welcome You Are in Manage Category Page";
} elseif ($action == 'Add') {

    echo "Welcome You Are in Add Category Page";
} elseif ($action == 'Edit') {

    //  Filter Validation On $_GET['userId] using Numeric function

    $filter_id = isset($_GET['userId']) && is_numeric($_GET['userId']) ?  $_GET['userId'] : 'error';

    // Check If The User Is Exists In Database Or Not

    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?  LIMIT 1");
    $stmt->execute(array($filter_id));
    // Fetching Data from DataBase
    $data = $stmt->fetch();
    // Counting The Record Of this user in database
    $count = $stmt->rowCount();
    // echo $count;die;

    // If $count > 0 This Mean That User Has Account In Database

    if ($count > 0) {


?>



        <!-- ======================Editing Profile ========================= -->

        <h1 class="text-center">Edit Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?action=Update" method="POST">
                <input type="hidden" name="userid" value="<?= $data['id']; ?>" />
                <!-- Start Username Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="username" class="form-control" value="<?= $data['username']; ?>" autocomplete="off" required="required" />
                    </div>
                </div>
                <!-- End Username Field -->
                <!-- Start Password Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="hidden" name="oldpassword" value="" />
                        <input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
                    </div>
                </div>
                <!-- End Password Field -->
                <!-- Start Email Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="email" name="email" value="<?= $data['email']; ?>" class="form-control" required="required" />
                    </div>
                </div>
                <!-- End Email Field -->
                <!-- Start Full Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="fullname" value="<?= $data['fullname']; ?>" class="form-control" required="required" />
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

    // header("location: edit_profile.php");

    if ($_SERVER['REQUEST_METHOD'] = 'POST') {

        print_r($_SERVER['REQUEST_METHOD']);

        // Reciving Variables From Request

        $id = $_POST['userid'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $fullname = $_POST['fullname'];

        echo $id . $username;
    }else{

        echo " wrong";

    }

} else {

    echo " There Are SomeThing Wrong";
}
