<?php

// ============================================================
// ================== Comments Page ===========================
// ============================================================
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Comments';
    include "init.php";


    //  Including The Function Pages of The Comments Like (Add, Edit,update ,Delete)  ,etc 

    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';



    if ($action == 'manage') {
?>

        <!-- ======================Manage Comments Page  ========================= -->


        <h1 class="text-center">Manage Comment</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table manage-members text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <!-- <td>Avatar</td> -->
                        <td>Comment</td>
                        <td>Username</td>
                        <td>Item Name</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    // Select the Data Of Comments From DataBase

                    $stmt = $conn->prepare("SELECT
                                                  comments. *, items.name As item_name, users.username 
                                            FROM 
                                                   Comments 
                                            INNER JOIN 
                                                   items
                                            ON 
                                                   items.id = comments.item_id
                                            INNER JOIN 
                                                   users
                                            ON 
                                                   users.id = comments.user_id
                                            ORDER BY 
                                                id
                                            DESC");

                    $stmt->execute();

                    // Counting The Record Of this Comment in database
                    $count = $stmt->rowCount();

                    // Fetching Data from DataBase
                    $data = $stmt->fetchAll();
                    // Check If There Is data of comments in Database or not 
                    if(! empty($data)){

                    
                            foreach ($data as $comment) {
                    ?>
                                <tr>
                                    <td><?= $comment['id']; ?></td>
                                    <td><?= $comment['comment']; ?></td>
                                    <td><?= $comment['username']; ?></td>
                                    <td><?= $comment['item_name']; ?></td>
                                    <td><?= $comment['date']; ?></td>
                                    <!-- <td></td> -->
                                    <td>
                                        <a href="comments.php?action=edit&commid= <?= $comment['id']; ?>" class="btn btn-success"><i class="fa fa-edit icon"></i>Edit</a>
                                        <a href="comments.php?action=delete&commid= <?= $comment['id']; ?>" class="btn btn-danger confirm"><i class="fa fa-close icon"></i>Delete</a>

                                        <?php
                                        if ($comment['status'] == 0) {
                                        ?>
                                            <a href="comments.php?action=approve&commid= <?= $comment['id']; ?>" class="btn btn-info "><i class="fa fa-check icon"></i>Approve</a>


                                        <?php
                                        }

                                        ?>

                                    </td>
                                </tr>

                    <?php
                             }

                    }else{
                      echo '<div class="container">';
                            echo '<div class="nice-message"> There\'s No Comments To Show</div>';
                      echo  '</div>';
                    }
                    ?>

                </table>
            </div>
        </div>

        <?php

    } elseif ($action == 'edit') {

        //  Filter Validation On $_GET['commid] using Numeric function

        $filter_commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?  $_GET['commid'] : 'error';

        // Check If The Comment Is Exists In Database Or Not


        $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ?  ");

        $stmt->execute(array($filter_commid));

        // Fetching Data from DataBase
        $comment = $stmt->fetch();

        // Counting The Record Of this Comment in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {


        ?>



            <!-- ======================Editing Comment ========================= -->

            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="commid" value="<?= $comment['id']; ?>" />
                    <!-- Start Comment Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Comment</label>
                        <div class="col-sm-10 col-md-6">
                            <textarea name="comment" class="form-control" value="<?= $comment['comment']; ?>"><?= $comment['comment']; ?> </textarea>
                        </div>
                    </div>
                    <!-- End Comment Field -->

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
            echo '<div class="container">';
                echo '<div class="nice-message"> There Is No Data In DataBase </div>';
            echo  '</div>';
        }
    } elseif ($action == 'Update') {


        if ($_SERVER['REQUEST_METHOD'] = 'POST') {

            // Reciving Variables From Request

            $id = $_POST['commid'];
            $comment = $_POST['comment'];


            $stmt = $conn->prepare("UPDATE `comments` SET comment = ? WHERE id = ? ");
            $stmt->execute(array($comment, $id));

            // Print A Successful Upadtes Message

            $theMsg =  "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';

            redirect_home($theMsg, 'back', 5);
        } else {

            $error_msg =  " Sorry, This User Is Exist";

            redirect_home($error_msg, "members.php?action=manage", 10);
        }
    } elseif ($action == 'delete') {

        //  Filter Validation On $_GET['commid] using Numeric function

        $filter_commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?  $_GET['commid'] : 'error';

        // Check If The Comment Is Exists In Database Or Not

        $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ? ");

        $stmt->execute(array($filter_commid));

        // Counting The Record Of this Comment in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That Comment Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("DELETE FROM `comments` WHERE id = ?");
            $stmt->execute(array($filter_commid));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
            redirect_home($theMsg, 'back', 5);
        }
    } elseif ($action == 'approve') {

        //  Filter Validation On $_GET['commid] using Numeric function

        $filter_commid = isset($_GET['commid']) && is_numeric($_GET['commid']) ?  $_GET['commid'] : 'error';

        // Check If The Comments Is Exists In Database Or Not

        $stmt = $conn->prepare("SELECT * FROM comments WHERE id = ? ");

        $stmt->execute(array($filter_commid));

        // Counting The Record Of this Comment in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That Comment Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("UPDATE `comments` SET `status`='1' WHERE id = ?");
            $stmt->execute(array($filter_commid));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Approved</div>';
            redirect_home($theMsg, 'back', 5);
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
