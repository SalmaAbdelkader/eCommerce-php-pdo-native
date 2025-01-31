<?php
ob_start();

include "init.php";

$title = 'HomePage';
if (isset($_SESSION['user'])) {

    $info_user = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $info_user->execute(array($_SESSION['user']));

    $data = $info_user->fetch();

?>


    <h1 class="text-center">My Profile</h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Information</div>
                <div class="panel-body">
                    <ul class="list-unstyled">
                        <li>
                            <i class="fa fa-unlock-alt fa-fw"></i>
                            <span>Login Name</span> : <?= $data['username']; ?>
                        </li>
                        <li>
                            <i class="fa fa-envelope-o fa-fw"></i>
                            <span>Email</span> : <?= $data['email']; ?>
                        </li>
                        <li>
                            <i class="fa fa-user fa-fw"></i>
                            <span>Full Name</span> : <?= $data['fullname']; ?>
                        </li>
                        <li>
                            <i class="fa fa-calendar fa-fw"></i>
                            <span>Registered Date</span> : <?= $data['Date']; ?>
                        </li>
                        <li>
                            <i class="fa fa-tags fa-fw"></i>
                            <span>Fav Category</span> :
                        </li>
                    </ul>
                    <a href="#" class="btn btn-default">Edit Information</a>
                </div>
            </div>
        </div>
    </div>
    <div id="my-ads" class="my-ads block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">My Items</div>
                <div class="panel-body">
                    <div class="row">
                        <?php

                        $items = getItems('member-id', $data['id'], 1);

                        if (!empty($items)) {
                            echo '<div class="row">';
                            foreach ($items as $item) {
                        ?>
                                <div class="col-sm-6 col-md-3">
                                    <div class="thumbnail item-box">
                                        <?php
                                        if (isset($item['approve']) && $item['approve'] == '0') {
                                            echo '<span class="approve-status">Waiting Approve</span>';
                                        }
                                        ?>
                                        <span class="price-tag"><?= $item['price'] ?></span>
                                        <img class="img-responsive" src="img.png" alt="" />
                                        <div class="caption">
                                            <h3><a href="show_item.php?itemId=<?= $item['id'] ?> "><?= $item['name'] ?></a></h3>
                                            <p><?= $item['description'] ?></p>
                                            <div class="date"><?= $item['date'] ?></div>
                                        </div>
                                    </div>
                                </div>

                        <?php  }
                            echo '</div>';
                        } else {

                            echo 'There\'s No Items To Show' . '<a href="new_ad.php" class="btn btn-primary">New Ad</a>';
                        }
                        ?>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="my-comments block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Latest Comments</div>
                <div class="panel-body">
                    <?php

                    // Select the Data Of Comments From DataBase

                    $stmt = $conn->prepare("SELECT comment FROM Comments WHERE user_id = ?");

                    $stmt->execute(array($data['id']));

                    // Counting The Record Of this Comment in database
                    $count = $stmt->rowCount();

                    // Fetching Data from DataBase
                    $comments = $stmt->fetchAll();

                    if (!empty($comments)) {
                        foreach ($comments as $comment) {

                            echo '<p>' . $comment['comment'] . '</p>';
                        }
                    } else {

                        echo 'There\'s No Comments To Show';
                    }

                    ?>


                </div>
            </div>
        </div>
    </div>





<?php
} else {

    header("location: login.php"); // Redirect To Login Page
}

include $temp . 'footer.php';
ob_end_flush();
?>