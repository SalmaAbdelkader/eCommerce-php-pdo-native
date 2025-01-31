<?php

// ============================================================
// ================== Items Page ===========================
// ============================================================
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Items';
    include "init.php";


    //  Including The Function Pages of The Categories Like (Add, Edit,update ,Delete)  ,etc 

    $action = isset($_GET['action']) ? $_GET['action'] : 'manage';



    if ($action == 'manage') {
?>

        <!-- ======================Manage Members Page  ========================= -->

        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table manage-members text-center table table-bordered">
                    <tr>
                        <td>#ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Category Name</td>
                        <td>Member Name</td>
                        <td>Control</td>
                    </tr>

                    <?php

                    // Select the Data Of Users From DataBase

                    $query = "";

                    if (isset($_GET['page']) && $_GET['page'] == 'Approve') {

                        $query = " WHERE approve = 0";
                    } else {

                        $stmt = $conn->prepare("SELECT
                                                  items.*, users.username, 
                                                   categories.name AS cat_name 
                                            FROM 
                                                   items
                                            INNER JOIN 
                                                   users 
                                            ON 
                                                users.id = items.`member-id`
                                            INNER JOIN 
                                                   categories 
                                            ON 
                                                categories.id = items.`cat-id`
                                            ORDER BY 
                                                id
                                            DESC");
                    }

                    $stmt = $conn->prepare("SELECT
                                                  items.*, users.username, 
                                                   categories.name AS cat_name 
                                            FROM 
                                                   items
                                            INNER JOIN 
                                                   users 
                                            ON 
                                                users.id = items.`member-id`
                                            INNER JOIN 
                                                   categories 
                                            ON 
                                                categories.id = items.`cat-id` $query
                                            ORDER BY 
                                                id
                                            DESC");



                    $stmt->execute();

                    // Counting The Record Of this Item in database
                    $count = $stmt->rowCount();

                    // Fetching Data from DataBase
                    $data = $stmt->fetchAll();
                    // Check If There Is data of Items in Database or not 
                    if (! empty($data)) {

                        foreach ($data as $item) {
                    ?>
                            <tr>

                                <td><?= $item['id']; ?></td>
                                <td><?= $item['name']; ?></td>
                                <td><?= $item['description']; ?></td>
                                <td><?= $item['price']; ?></td>
                                <td><?= $item['date']; ?></td>
                                <td><?= $item['cat_name']; ?></td>
                                <td><?= $item['username']; ?></td>
                                <!-- <td></td> -->
                                <td>
                                    <a href="items.php?action=edit&itemId= <?= $item['id']; ?>" class="btn btn-success"><i class="fa fa-edit icon"></i>Edit</a>

                                    <a href="items.php?action=delete&itemId= <?= $item['id']; ?>" class="btn btn-danger confirm"><i class="fa fa-close icon"></i>Delete</a>
                                    <a href="items.php?action=show&itemId= <?= $item['id']; ?>" class="btn btn-primary confirm"><i class="fa fa-eye icon"></i>Show</a>


                                    <?php
                                    if ($item['approve'] == 0) {
                                    ?>

                                        <a href="items.php?action=approve&itemId= <?= $item['id']; ?>" class="btn btn-info confirm"><i class="fa fa-check icon"></i>approve</a>
                                    <?php
                                    }

                                    ?>
                                </td>
                            </tr>

                    <?php
                        }
                    } else {
                        echo '<div class="container">';
                        echo '<div class="nice-message"> There\'s No Items To Show</div>';
                        echo  '</div>';
                    }
                    ?>

                </table>
            </div>
            <a href="items.php?action=add" class="btn btn-sm btn-primary">
                <i class="fa fa-plus"></i> New Item
            </a>
        </div>


    <?php
    } elseif ($action == 'add') {

    ?>

        <!-- ======================Adding Profile ========================= -->

        <h1 class="text-center">Add New Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?action=insert" method="POST">
                <!-- Start Name Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="name" required="required" class="form-control" placeholder="Enter Your Item Name" />
                    </div>
                </div>
                <!-- End Name Field -->
                <!-- Start Description Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="description" required="required" class="form-control" placeholder="Enter Your Item Description" />
                    </div>
                </div>
                <!-- End Description Field -->

                <!-- Start Price Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="price" required="required" class="form-control" placeholder="Enter Your Item Price" />
                    </div>
                </div>
                <!-- End Price Field -->

                <!-- Start Country Made Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country </label>
                    <div class="col-sm-10 col-md-6">
                        <input type="text" name="country" required="required" class="form-control" placeholder="Enter Your Item Country Made" />
                    </div>
                </div>
                <!-- End Country Made Field -->


                <!-- Start Status Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status </label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name="status">

                            <option value="0">Enter Your Item Status.....</option>
                            <option value="1">-Now</option>
                            <option value="2">-Like New</option>
                            <option value="3">-Used</option>
                            <option value="4">-Very Old</option>
                        </select>
                    </div>
                </div>
                <!-- End Status Field -->

                <!-- Start Category Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Category </label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name="category">
                            <option value="0">Enter Your Item Category.....</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM categories");
                            $stmt->execute();
                            $data = $stmt->fetchAll();
                            foreach ($data as $cat) {

                                echo "<option value='" . $cat['id'] . "'> - " . $cat['name'] . "</option>";
                            }

                            ?>

                        </select>
                    </div>
                </div>
                <!-- End Category Field -->

                <!-- Start Member Field -->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Member </label>
                    <div class="col-sm-10 col-md-6">
                        <select class="form-control" name="member">
                            <option value="0">Enter Your Item Member.....</option>
                            <?php
                            $stmt = $conn->prepare("SELECT * FROM users");
                            $stmt->execute();
                            $data = $stmt->fetchAll();
                            foreach ($data as $member) {

                                echo "<option value='" . $member['id'] . "'> - " . $member['username'] . "</option>";
                            }

                            ?>
                        </select>
                    </div>
                </div>
                <!-- End Member Field -->

                <!-- Start Submit Field -->
                <div class="form-group form-group-lg">

                    <div class="col-sm-offset-2 col-sm-10">

                        <input type="submit" value="Add Item" class="btn btn-primary btn-lg" />
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

            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $category = $_POST['category'];
            $member = $_POST['member'];


            // Validation Input Feilds And Handling Errors
            $fromErrors = array();

            if (empty($name)) {

                $fromErrors[] = 'Name Can\'t Be <strong> Empty</strong>';
            }

            if (empty($desc)) {

                $fromErrors[] = 'Description Can\'t Be <strong> Empty</strong>';
            }

            if (empty($price)) {

                $fromErrors[] = 'Price Can\'t Be <strong> Empty</strong>';
            }

            if (empty($country)) {

                $fromErrors[] = 'Country Cant Be <strong> Empty</strong>';
            }

            if (empty($status)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Status</strong>';
            }
            if (empty($category)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Category</strong>';
            }
            if (empty($member)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Member</strong>';
            }

            foreach ($fromErrors as $errors) {

                $theMsg =  '<div class=" container alert alert-danger ">' . $errors . '</div>';

                redirect_home($theMsg);
            }

            // die;
            // Inserting The Data In DataBase Using This Information

            if (empty($fromErrors)) {

                $stmt = $conn->prepare("INSERT INTO `items`( `name`, `description`, `price`, `date`, `country-made`,`status`, `cat-id`, `member-id`) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)");
                $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member));

                // Print A Successful Inserted Message

                $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Inserted</div>';
                redirect_home($theMsg, "items.php", 5);
            }
        } else {

            $error_msg =  '<div class="container alert alert-danger">Sorry, You Can Access This Page Directly</div>';

            redirect_home($error_msg, "index.php", 5);
        }
    } elseif ($action == 'edit') {


        //  Filter Validation On $_GET['itemId] using Numeric function

        $filter_item_id = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  $_GET['itemId'] : 'error';
        $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute(array($filter_item_id));
        // Fetching Data from DataBase
        $item = $stmt->fetch();
        // Counting The Record Of this Items in database
        $count = $stmt->rowCount();

        // If $count > 0 This Mean That Items Have Colmun In Database

        if ($count > 0) {


        ?>



            <!-- ======================Editing Item ========================= -->

            <h1 class="text-center">Edit Items</h1>
            <div class="container">
                <form class="form-horizontal" action="?action=Update" method="POST">
                    <input type="hidden" name="itemid" value="<?= $item['id']; ?>" />
                    <!-- Start Name Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="name" required="required" class="form-control" value="<?= $item['name']; ?>" placeholder="Enter Your Item Name" />
                        </div>
                    </div>
                    <!-- End Name Field -->
                    <!-- Start Description Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="description" required="required" class="form-control" value="<?= $item['description']; ?>" placeholder="Enter Your Item Description" />
                        </div>
                    </div>
                    <!-- End Description Field -->

                    <!-- Start Price Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Price</label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="price" required="required" class="form-control" value="<?= $item['price']; ?>" placeholder="Enter Your Item Price" />
                        </div>
                    </div>
                    <!-- End Price Field -->

                    <!-- Start Country Made Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Country </label>
                        <div class="col-sm-10 col-md-6">
                            <input type="text" name="country" required="required" class="form-control" value="<?= $item['country-made']; ?>" placeholder="Enter Your Item Country Made" />
                        </div>
                    </div>
                    <!-- End Country Made Field -->


                    <!-- Start Status Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Status </label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="status">
                                <option value="1" <?php if ($item['status'] == 1) {
                                                        echo "selected";
                                                    }  ?>>-Now</option>
                                <option value="2" <?php if ($item['status'] == 2) {
                                                        echo "selected";
                                                    }  ?>>-Like New</option>
                                <option value="3" <?php if ($item['status'] == 3) {
                                                        echo "selected";
                                                    }  ?>>-Used</option>
                                <option value="4" <?php if ($item['status'] == 4) {
                                                        echo "selected";
                                                    }  ?>>-Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status Field -->

                    <!-- Start Category Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Category </label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="category">
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM categories");
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach ($data as $cat) {

                                    echo "<option value='" . $cat['id'] . "'";
                                    if ($item['status'] == $cat['id']) {
                                        echo "selected";
                                    }
                                    echo "> - " . $cat['name'] . "</option>";
                                }

                                ?>

                            </select>
                        </div>
                    </div>
                    <!-- End Category Field -->

                    <!-- Start Member Field -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Member </label>
                        <div class="col-sm-10 col-md-6">
                            <select class="form-control" name="member">
                                <?php
                                $stmt = $conn->prepare("SELECT * FROM users");
                                $stmt->execute();
                                $data = $stmt->fetchAll();
                                foreach ($data as $member) {

                                    echo "<option value='" . $member['id'] . "'";
                                    if ($item['status'] == $member['id']) {
                                        echo "selected";
                                    }
                                    echo "> - " . $member['username'] . "</option>";
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Member Field -->

                    <!-- Start Submit Field -->
                    <div class="form-group form-group-lg">

                        <div class="col-sm-offset-2 col-sm-10">

                            <input type="submit" value="Edit Item" class="btn btn-primary btn-lg" />
                        </div>
                    </div>
                    <!-- End Submit Field -->
                </form>
            </div>

        <?php
        } else {
            echo '<div class="container">';
            echo '<div class="nice-message"> There\'s No Comments To Show</div>';
            echo  '</div>';
        }
    } elseif ($action == 'Update') {

        if ($_SERVER['REQUEST_METHOD'] = 'POST') {

            // Reciving Variables From Request

            $id = $_POST['itemid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $category = $_POST['category'];
            $member = $_POST['member'];


            // Validation Input Feilds And Handling Errors
            $fromErrors = array();

            if (empty($name)) {

                $fromErrors[] = 'Name Can\'t Be <strong> Empty</strong>';
            }

            if (empty($desc)) {

                $fromErrors[] = 'Description Can\'t Be <strong> Empty</strong>';
            }

            if (empty($price)) {

                $fromErrors[] = 'Price Can\'t Be <strong> Empty</strong>';
            }

            if (empty($country)) {

                $fromErrors[] = 'Country Cant Be <strong> Empty</strong>';
            }

            if (empty($status)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Status</strong>';
            }
            if (empty($category)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Category</strong>';
            }
            if (empty($member)) {

                $fromErrors[] = 'You Must Choose Your Item <strong> Member</strong>';
            }

            foreach ($fromErrors as $errors) {

                $theMsg =  '<div class=" container alert alert-danger ">' . $errors . '</div>';

                redirect_home($theMsg);
            }


            // Updates The Data In DataBase Using This Information

            if (empty($fromErrors)) {


                $stmt = $conn->prepare("UPDATE `items` SET name = ?, description = ?, price = ?, `country-made` = ?, status = ?, `cat-id` = ?, `member-id` = ? WHERE id = ? ");
                $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member, $id));

                //                 $stmt = $conn->prepare("UPDATE `items` 
                //                         SET name = ?, description = ?, price = ?, `country-made` = ?, status = ?, `cat-id` = ?, `member-id` = ? 
                //                         WHERE id = ?");

                // $stmt->execute(array($name, $desc, $price, $country, $status, $category, $member, $id));


                // Print A Successful Upadtes Message

                $theMsg =  "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Updated</div>';

                redirect_home($theMsg, 'back');
            }
        } else {

            $error_msg =  " Sorry, This User Is Exist";

            redirect_home($error_msg, 'back');
        }
    } elseif ($action == 'delete') {

        //  Filter Validation On $_GET['ItemId] using Numeric function


        $filter_item_id = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  $_GET['itemId'] : 'error';

        // Check If The Item Is Exists In Database Or Not

        $count = Check_data('id', 'items', $filter_item_id);

        // If $count > 0 This Mean That Item Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("DELETE FROM `items` WHERE id = ?");
            $stmt->execute(array($filter_item_id));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Deleted</div>';

            redirect_home($theMsg, 'back');
        }
    } elseif ($action == 'approve') {

        //  Filter Validation On $_GET['ItemId] using Numeric function


        $filter_item_id = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  $_GET['itemId'] : 'error';

        // Check If The Item Is Exists In Database Or Not

        $count = Check_data('id', 'items', $filter_item_id);

        // If $count > 0 This Mean That User Has Account In Database

        if ($count > 0) {

            $stmt = $conn->prepare("UPDATE `items` SET `approve`='1' WHERE id = ?");
            $stmt->execute(array($filter_item_id));

            // Print A Successful Deleted Message

            $theMsg = "<div class='container alert alert-success'>" . $stmt->rowCount() . 'Record Approved</div>';
            redirect_home($theMsg, 'back');
        }
    } elseif ($action == 'show') {

        //  Filter Validation On $_GET['ItemId] using Numeric function


        $filter_item_id = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  $_GET['itemId'] : 'error';

        // Check If The Item Is Exists In Database Or Not

        $count = Check_data('id', 'items', $filter_item_id);

        // If $count > 0 This Mean That Items Has Account In Database

        if ($count > 0) {

            // Select the Data Of Comments From DataBase

            $stmt = $conn->prepare("SELECT
                                                      comments. *, items.name, users.username 
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
                                                WHERE item_id = ?");

            $stmt->execute(array($filter_item_id));

            // Counting The Record Of this Comment in database
            $count = $stmt->rowCount();

            // Fetching Data from DataBase
            $data = $stmt->fetchAll();
            
        ?>

            <!-- ======================Manage Comments Page  ========================= -->


            <h1 class="text-center">Manage <?= $data['item_name']; ?> Comment</h1>
            <div class="container">
                <div class="table-responsive">
                    <table class="main-table manage-members text-center table table-bordered">
                        <tr>

                            <td>Comment</td>
                            <td>Username</td>
                            <td>Adding Date</td>
                            <td>Control</td>
                        </tr>

                        <?php
                        foreach ($data as $comment) {
                        ?>
                            <tr>

                                <td><?= $comment['comment']; ?></td>
                                <td><?= $comment['username']; ?></td>
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
                        ?>

                    </table>
                </div>

            </div>
<?php
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
