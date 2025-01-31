<?php

// ============================================================
// ================== Category Page ===========================
// ============================================================
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Categories';
    include "init.php";


    //  Including The Function Pages of The Categories Like (Add, Edit,update ,Delete)  ,etc 

    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';



    if ($action == 'manage') {
        // ======================Manage Members Page  ========================= 

        // Sorting Data Of Categories Depands On Ordering Column

        $sort = "";

        $sort_array = array('ASC', 'DESC');

        if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

            $sort = $_GET['sort'];
        }

        $stmt2 = $conn->prepare("SELECT * FROM categories ORDER BY ordering $sort");

        $stmt2->execute();
        $data = $stmt2->fetchAll();
        $row = $stmt2->rowCount();


?>

        <h1 class="container text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">
                <i class="fa fa-edit"></i > Manage Categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i>Ordering:[
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?sort=ASC">ASC</a> |
                        <a class="<?php if ($sort == 'ASC') {
                                        echo 'active';
                                    } ?>" href="?sort=DESC">DESC</a>]
                        <i class="fa fa-eye"></i> View:[
                        <span class="active" data-view="full">Full</span> |
                        <span  data-view="classic">Classic</span>]

                    </div>
                </div>

                <div class="panel-body">
                    <?php
                    // Check If There Is data of categories in Database or not 
                    if(! empty($data)){
                        foreach ($data as $cat) {
                            echo '<div class="cat" >';
                            echo '<div class="hidden-buttons">';
                            echo "<a href='categories.php?action=edit&catid=" . $cat['id'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                            echo "<a href='categories.php?action=delete&catid=" . $cat['id'] . "' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                            echo '</div>';
                            echo "<h3>" . $cat['name'] . "</h3>";

                            echo "<div class='full-view'>";
                            echo "<p>";
                            if ($cat['description'] == "") {
                                echo 'This Category Is Empty';
                            } else {
                                echo $cat['description'];
                            }
                            echo "</p>";
                            if ($cat['visibility'] == 1) {
                                echo '<span class="Visibility"><i class="fa fa-eye"></i> Hidden </span>';
                            }
                            if ($cat['allow_comment'] == 1) {
                                echo '<span class="commenting"><i class="fa fa-close"></i> Comments Disabled </span>';
                            }
                            if ($cat['allow_ads'] == 1) {
                                echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled </span>';
                            }
                            echo "</div>";
                            echo '</div>';
                            echo '<hr>';
                        }
                    }else{
                        echo '<div class="container">';
                              echo '<div class="nice-message"> There\'s No Categories To Show</div>';
                        echo  '</div>';
                      }

                    ?>
                </div>

            </div>
            <a href="Categories.php?action=add" class="btn btn-primary"><i class="fa fa-plus"></i>Add New Category</a>
        </div>

    <?php

    } elseif ($action == 'add') {

    ?>

        <!-- ======================Adding Category ========================= -->

        <h1 class="text-center">Add New Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?action=insert" method="POST">
                <!-- Start Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Enter Your Category Name" />
                    </div>
                </div>
                <!-- End Name Field -->
                <!-- Start Description Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" class=" form-control" placeholder="Description Of The Category" />
                    </div>
                </div>
                <!-- End Description Field -->
                <!-- Start Ordering Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="number" name="ordering" class="form-control" placeholder="Your Ordering Category" />
                    </div>
                </div>
                <!-- End Ordering Field -->
                <!-- Start Visibility  Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibility</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                            <label for="vis-yes">Yes</label>
                        </div>
                        <div>
                            <input id="vis-no" type="radio" name="visibility" value="1" />
                            <label for="vis-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Visibility Field -->
                <!-- Start Allowing Comments  Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allowing Comments</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="com-yes" type="radio" name="commenting" value="0" checked />
                            <label for="com-yes">Yes</label>
                        </div>
                        <div>
                            <input id="com-no" type="radio" name="commenting" value="1" />
                            <label for="com-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End Allowing Comments Field -->
                <!-- Start Allowing Ads  Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label"> Allowing Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value="0" checked />
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value="1" />
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!-- End  Allowing Ads Field -->
                <!-- Start Submit Field -->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
                    </div>
                </div>
                <!-- End Submit Field -->
            </form>
        </div>


        <?php
    } elseif ($action == 'insert') {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo ' <h1 class="container text-center">Insert Category</h1>';

            // Reciving Variables From Request

            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];

            // Validation Name Feild And Handling Errors
            if (empty($name)) {

                $formError = '<div class="container alert alert-success">Name Can`t Be <strong>Empty</strong> </div>';
                redirect_home($formError, "members.php?action=add", 5);
            } else {

                // Check Existing User Function

                $check =  Check_data("name", "categories", $name);

                //  If User Equal 1 => This Meaning The User Is Exist
                if ($check == 1) {

                    $error_msg =  '<div class="container alert alert-danger "> Sorry, This Category Is Exist </div>';

                    redirect_home($error_msg, "members.php?action=add", 10);
                } else {

                    // Inserting The Data In Categories Table Using This Information

                    $stmt = $conn->prepare("INSERT INTO `categories`( `name`, `description`, `ordering`, `visibility`, `Allow_comment`, `allow_ads`) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads));

                    // Print A Successful Inserted Message

                    $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Category Inserted</div>';
                    redirect_home($theMsg, "categories.php?action=manage", 3);
                }
            }
        } else {

            // This Error Will Appear When User Access To This Page Using URL

            $error_msg =  '<div class="container alert alert-danger">Sorry, You Can Access This Page Directly</div>';

            redirect_home($error_msg, "index.php", 10);
        }
    } elseif ($action == 'edit') {

        //  Filter Validation On $_GET['catid] using Numeric function

        $filter_catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  $_GET['catid'] : 'error';

        // Check If The Category Is Exists In Database Or Not

        // $check = Check_data('id', 'users', $filter_id);

        // echo $data;die;

        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?  LIMIT 1");
        $stmt->execute(array($filter_catid));
        // Fetching Data from DataBase
        $row = $stmt->fetch();
        // print_r($row);
        // die;
        // Counting The Record Of this user in database
        $count = $stmt->rowCount();
        // echo $count;die;

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {


        ?>



            <!-- ======================Editing Profile ========================= -->

            <h1 class="text-center">Edit Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <!-- Hidden Category ID -->
                    <input type="hidden" name="catid" value="<?= $row['id']; ?>" />
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" class="form-control" required="required" placeholder="Enter Your Category Name" value="<?= $row['name']; ?>" />
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" class=" form-control" placeholder="Description Of The Category" value="<?= $row['description']; ?>" />
                        </div>
                    </div>
                    <!-- End Description Field -->
                    <!-- Start Ordering Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="number" name="ordering" class="form-control" placeholder="Your Ordering Category" value="<?= $row['ordering']; ?>" />
                        </div>
                    </div>
                    <!-- End Ordering Field -->
                    <!-- Start Visibility  Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visibility</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="vis-yes" type="radio" name="visibility" value="0" <?php if ($row['visibility'] == 0) {
                                                                                                    echo "checked";
                                                                                                } ?> />
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id="vis-no" type="radio" name="visibility" value="1" <?php if ($row['visibility'] == 1) {
                                                                                                echo "checked";
                                                                                            } ?> />
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visibility Field -->
                    <!-- Start Allowing Comments  Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Allowing Comments</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="com-yes" type="radio" name="commenting" value="0" <?php if ($row['allow_comment'] == 0) {
                                                                                                    echo "checked";
                                                                                                } ?> />
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id="com-no" type="radio" name="commenting" value="1" <?php if ($row['allow_comment'] == 1) {
                                                                                                echo "checked";
                                                                                            } ?> />
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Allowing Comments Field -->
                    <!-- Start Allowing Ads  Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label"> Allowing Ads</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="ads-yes" type="radio" name="ads" value="0" <?php if ($row['allow_ads'] == 0) {
                                                                                            echo "checked";
                                                                                        } ?> />
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value="1" <?php if ($row['allow_ads'] == 1) {
                                                                                            echo "checked";
                                                                                        } ?> />
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End  Allowing Ads Field -->
                    <!-- Start Submit Field -->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input type="submit" value="Edit" class="btn btn-primary btn-lg" />
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

        echo '<h1 class="text-center">Upadte Category</h1>';

        if ($_SERVER['REQUEST_METHOD'] = 'POST') {

            // Reciving Variables From Request

            // Reciving Variables From Request
            $id = $_POST['catid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];

            // Validation Name Feild And Handling Errors
            if (empty($name)) {

                $formError = '<div class="container alert alert-success">Name Can`t Be <strong>Empty</strong> </div>';
                redirect_home($formError, "members.php?action=edit", 5);
            } else {

                // Check Existing User Function

                $check =  Check_data("name", "categories", $name);

                //  If User Equal 1 => This Meaning The User Is Exist
                if ($check == 1) {

                    // Inserting The Data In Categories Table Using This Information

                    $stmt = $conn->prepare("UPDATE `categories` SET name = ?, description = ?, ordering = ?, visibility = ?, allow_comment = ?, allow_ads = ? WHERE id = ? ");
                    $stmt->execute(array($name, $desc, $order, $visible, $comment, $ads, $id));

                    // Print A Successful Inserted Message

                    $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Category Updated</div>';
                    redirect_home($theMsg, "categories.php?action=manage", 10);
                }
            }
        } else {

            // This Error Will Appear When User Access To This Page Using URL

            $error_msg =  '<div class="container alert alert-danger">Sorry, You Can Access This Page Directly</div>';

            redirect_home($error_msg, "index.php", 10);
        }
    } elseif ($action == 'delete') {

        //  Filter Validation On $_GET['catid'] using Numeric function

        $filter_catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?  $_GET['catid'] : 'error';

        // Check If The Category Is Exists In Database Or Not

        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?  LIMIT 1");

        $stmt->execute(array($filter_catid));

        // Counting The Record Of this Category in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That Category Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("DELETE FROM `categories` WHERE id = ?");
            $stmt->execute(array($filter_catid));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';
            redirect_home($theMsg, "categories.php?action=manage", 10);
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
