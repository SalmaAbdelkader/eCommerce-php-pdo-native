<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= set_title(); ?></title>
    <link rel="stylesheet" href="<?php echo $css; ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery-ui.css">
    <link rel="stylesheet" href="<?php echo $css; ?>jquery.selectBoxIt.css">
    <link rel="stylesheet" href="<?php echo $css; ?>front.css">

</head>

<body>
    <!-- <div class="btn-btn-danger btn-block"> Welcome </div> -->
    <div class="upper-bar">
        <div class="container">
            <?php
            if (isset($_SESSION['user'])) {
            ?>

                <img class="my-image img-thumbnail img-circle" src="img.png" alt="" />
                <div class="btn-group my-info">
                    <span class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                        <?= $_SESSION['user']; ?>
                        <span class="caret"></span>
                    </span>
                    <ul class="dropdown-menu">
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="newad.php">New Item</a></li>
                        <li><a href="profile.php#my-ads">My Items</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php

                echo '<a href="logout.php">
                           <span class="pull-right "> Logout   </span>
                       </a>';
                echo '<a href="new_ad.php">
                    <span class="pull-right"> New_Ad -   </span>
                </a>';
                echo '<a href="profile.php">
                    <span class="pull-right"> Profile  - </span>
                </a>';
                $userStatus = checkUserStatus($user_session);
                if ($userStatus == 1) {

                    // echo $userStatus;
                }
            } else {

                echo '<a href="login.php">
                           <span class="pull-right">Login/Signup</span>
                       </a>';
            }

            ?>


        </div>
    </div>

    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Home</a>
            </div>
            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="nav navbar-nav navbar-right ">
                    <?php
                    $categories = getcat();
                    foreach ($categories as $cat) {

                        echo '<li><a href="category.php?catid=' . $cat['id'] . '&catname=' . str_replace(' ', '-', $cat['name']) . '">' . $cat['name'] . '</a></li>';
                    }

                    ?>
                </ul>

            </div>
        </div>
    </nav>