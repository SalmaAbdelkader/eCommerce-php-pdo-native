<?php
ob_start();
session_start();
if (isset($_SESSION['username'])) {

    $title = 'Dashboard';
    include "init.php";


?>



    <div class="home-stats">
        <div class="container text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="stat st-members">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                            <span>

                                <a href="members.php"><?php echo  countAll('id', 'users'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-pending">
                        <i class="fa fa-user-plus"></i>
                        <div class="info">
                            Pending Members
                            <span>
                                <a href="members.php?action=manage&page=Pending">
                                    <?php echo  countAll('regstatus', 'users', 0); ?>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                            <span>

                                <a href="items.php?action=manage"><?php echo  countAll('id', 'items'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat st-comments">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                            Total Comments
                            <span>
                                <a href="comments.php?action=manage"><?php echo  countAll('id', 'comments'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="latest">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php // Number Of Latest Users
                            $number = 5;
                            ?>
                            <i class="fa fa-users"></i>
                            Latest <?= $number; ?> Registerd Users
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>

                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">

                                <?php

                                // Latest users Array
                                $latestuser = getlatest("*", "users", "id", $number);

                                if(! empty($latestuser)){


                                    foreach ($latestuser as $user) {

                                        echo '<li>' . $user['username'] . '<a href="members.php?action=edit&userId=' . $user['id'] . '" >
                                        <span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</a></span>';

                                        if ($user['regstatus'] == 0) {
                                    ?>
                                            <a href="members.php?action=Activate&userId= <?= $user['id']; ?>" class="btn btn-info pull-right"><i class="fa fa-close icon"></i>Activate</a>


                                    <?php
                                        }
                                        echo '</li>';
                                    }

                                                                    
                                }else{

                                    echo "There\'s No Members To Show";
                                }

                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php // Number Of Latest Items
                            $number = 5;
                            ?>
                            <i class="fa fa-tag"></i> Latest <?= $number; ?> Items
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php

                                // Latest Items Array
                                $latestitem = getlatest("*", "items", "id", $number);
                                if(! empty($latestuser)){
                                    foreach ($latestitem as $item) {

                                        echo '<li>' . $item['name'] . '<a href="items.php?action=edit&itemId=' . $item['id'] . '" >
                                        <span class="btn btn-success pull-right"><i class="fa fa-edit"></i>Edit</a></span>';

                                        echo '</li>';
                                    }
                                }else{

                                    echo "There\'s No Items To Show";
                                }
                                ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Start Latest Comments -->
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php $number = 5; ?>
                            <i class="fa fa-comments-o"></i>
                            Latest <?= $number;  ?> Comments
                            <span class="toggle-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                          <?php
                            // Select the Data Of Comments From DataBase

                            $stmt = $conn->prepare("SELECT
                                                          comments. *, users.username
                                                    FROM
                                                          Comments
                                                    INNER JOIN
                                                             users
                                                    ON
                                                             users.id = comments.user_id");

                            $stmt->execute();

                            // Counting The Record Of this Comment in database
                            $count = $stmt->rowCount();

                            // Fetching Data from DataBase
                            $data = $stmt->fetchAll();
                          
                            if(!empty($data)){
                                foreach ($data as $comment) {
                                ?>
                                <div class="comment-box">
                                    <span class="member-n"><?= $comment['username']  ?></span>
                                    <p class="member-c"><?= $comment['comment']  ?></p>


                                </div>


                        <?php   }

                            }else{

                                echo "There\'s No Comments To Show";
                            }
                            
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Latest Comments -->
        </div>
    </div>




<?php

    include $temp . 'footer.php';
} else {

    header("location: index.php");
    exit();
}

ob_end_flush();

?>