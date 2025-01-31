<?php
ob_start();

include "init.php";

$title = 'HomePage';
if (isset($_SESSION['user'])) {

    //  Filter Validation On $_GET['itemId] using Numeric function

    $filter_item_id = isset($_GET['itemId']) && is_numeric($_GET['itemId']) ?  $_GET['itemId'] : 'error';

    $stmt = $conn->prepare("SELECT 
                              items.*, categories.`id` AS cat_id, categories.`name` As cat_name, users.username 
                        FROM 
                              items 
                        INNER JOIN 
                              categories
                        ON 
                              categories.id = items.`cat-id`
                        INNER JOIN 
                              users
                        ON 
                              users.id = items.`member-id`
                        WHERE 
                              items.id = ?
                        AND   
                              items.approve = 1");





    $stmt->execute(array($filter_item_id));
    // Fetching Data from DataBase
    $item = $stmt->fetch();
    // Counting The Record Of this Items in database
    $count = $stmt->rowCount();

    // If $count > 0 This Mean That Items Have Colmun In Database

    if ($count > 0) {



?>


        <h1 class="text-center"><?= $item['name']; ?></h1>

        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
                </div>
                <div class="col-md-9 item-info">
                    <h2><?= $item['name']; ?></h2>
                    <p><?= $item['description']; ?></p>
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Added Date</span> : <?= $item['date']; ?>
                        </li>
                        <li>
                            <i class="fa fa-money fa-fw"></i>
                            <span>Price</span> : <?= $item['price']; ?>
                        </li>
                        <li>
                            <i class="fa fa-building fa-fw"></i>
                            <span>Made In</span> : <?= $item['country-made']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Category</span> : <a href="category.php?catid=<?= $item['cat_id']; ?>&catname=<?php echo str_replace(' ', '-', $item['cat_name']); ?>"> <?= $item['cat_name']; ?></a>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Added By</span> : <a href="#"><?= $item['username']; ?></a>
                        </li>
                        <li class="tags-items">
                            <i class="fa fa-user fa-fw"></i>
                            <span>Tags</span> :

                        </li>
                    </ul>
                </div>
            </div>
            <hr class="custom-hr">

            <?php if (isset($_SESSION['user'])) {  ?>

                <!-- Start Add Comment -->
                <div class="row">
                    <div class="col-md-offset-3">
                        <div class="add-comment">
                            <h3>Add Your Comment</h3>
                            <form action="<?php echo $_SERVER['PHP_SELF'] . '?itemId= ' . $item['id'];   ?>" method="POST">
                                <textarea name="comment" required></textarea>
                                <input class="btn btn-primary" type="submit" value="Add Comment">
                            </form>

                        </div>
                    </div>
                </div>

                <?php

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                    // Use htmlspecialchars to sanitize the comment
                    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
                    $username = $item['username']; // This is the username Of The User
                    $item_id = $item['id'];

                    if (!empty($comment)) {

                        // Fetch the user ID based on the username
                        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
                        $stmt->execute([$username]);
                        $user = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($user) {
                            $user_id = $user['id'];

                            // Now you can insert the comment with the correct user_id
                            $stmt = $conn->prepare("INSERT INTO `comments`( `comment`, `status`, `date`, `item_id`, `user_id`) 
                            VALUES (?, 0, NOW(), ?, ?)");

                            $stmt->execute(array($comment, $item_id, $user_id));

                            if ($stmt) {
                                echo '<div class="container alert alert-success">Comment Added Successfully</div>';
                            } else {
                                echo '<div class="container alert alert-danger">Failed to add comment</div>';
                            }
                        } else {
                            echo '<div class="container alert alert-danger">User not found</div>';
                        }
                    }
                }



                ?>


                <!-- End Add Comment -->

            <?php
            } else {

                echo '<a href="login.php">Login</a> Or <a href="login.php">Register</a> To Can Add Comments';
            }

            ?>

            <hr class="custom-hr">

            <?php

            // Select the Data Of Comments From DataBase

            if (isset($item['id'])) {
            

            $item_id = $item['id'];

            $stmt = $conn->prepare("SELECT
                                            comments. * 
                                    FROM 
                                            Comments 
                                    INNER JOIN 
                                            users
                                    ON 
                                            users.id = comments.user_id
                                    WHERE 
                                            item_id = ?
                                    AND   
                                            status = 1
                                    ORDER BY 
                                        id
                                    DESC");

            $stmt->execute(array($item_id));

            // Counting The Record Of this Comment in database
            $count = $stmt->rowCount();

            // Fetching Data from DataBase
            $data = $stmt->fetchAll();

            if ($count > 0) {


            ?>


                <div class="comment-box">

                    <?php

                    foreach ($data as $comment) {

                    ?>
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
                                <h6><?= $_SESSION['user'];  ?></h6>

                            </div>
                            <div class="col-sm-10">
                                <p class="lead"><?= $comment['comment'];  ?></p>
                            </div>
                        </div>

                        <hr class="custom-hr">

                    <?php  } ?>
                </div>

                
            <?php   } else {

                echo '<div class="container alert alert-danger">There\`s No Comments For This Item</div>';
            }
            
        }else{
            echo '<div class="container alert alert-danger">This Item Id Not Found</div>';
            
        }?>

        </div>





<?php

    } else {
        echo '<div class="container">';
        echo '<div class="nice-message"> There\'s No Items To Show With This ID Or This Item Waiting Approve</div>';
        echo  '</div>';
    }
} else {

    header("location: login.php"); // Redirect To Login Page
}

include $temp . 'footer.php';
ob_end_flush();
?>