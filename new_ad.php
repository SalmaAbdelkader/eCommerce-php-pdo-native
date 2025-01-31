<?php
ob_start();

include "init.php";

$title =  'Create New Ads';
if (isset($_SESSION['user'])) {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $form_error[] = '';
        $name = strip_tags($_POST['name']);
        $desc = strip_tags($_POST['description']);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_NUMBER_INT);
        $country = strip_tags($_POST['country']);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);

        if (empty($name)) {

            $form_error = 'The Name Field Can\'t Be Empty';
        } else {

            if (strlen($name < 4)) {

                $form_error = 'The Name should more than 4 characters';
            }
        }

        if (empty($desc)) {

            $form_error = 'The Description Field Can\'t Be Empty';
        } else {

            if (strlen($name < 4)) {

                $form_error = 'The Description should more than 10 characters';
            }
        }

        if (empty($country)) {

            $form_error = 'The Country Field Can\'t Be Empty';
        } else {

            if (strlen($name < 2)) {

                $form_error = 'The Country should more than 2 characters';
            }
        }


        if (empty($price)) {

            $form_error = 'The Price Field Can\'t Be Empty';
        }


        if (empty($status)) {

            $form_error = 'The Status Field Can\'t Be Empty';
        }


        if (empty($category)) {

            $form_error = 'The Category Field Can\'t Be Empty';
        }


        if (empty($form_error)) {



            $stmt = $conn->prepare("INSERT INTO `items`( `name`, `description`, `price`, `date`, `country-made`,`status`, `cat-id`, `member-id`) VALUES (?, ?, ?, NOW(), ?, ?, ?, ?)");
            $stmt->execute(array($name, $desc, $price, $country, $status, $category, $_SESSION['u_id']));

            // Print A Successful Inserted Message
            if ($stmt) {

                $success_msg = "Item Added Successfully";
            }
        }
    }

?>


    <h1 class="text-center"><?= $title; ?></h1>
    <div class="information block">
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="col-md-8">
                                <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="POST">
                                    <!-- Start Name Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Name</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input
                                                pattern=".{4,}"
                                                title="This Field Require At Least 4 Characters"
                                                type="text"
                                                name="name"
                                                class="form-control live"
                                                placeholder="Name of The Item"
                                                data-class=".live-title"
                                                required />
                                        </div>
                                    </div>
                                    <!-- End Name Field -->
                                    <!-- Start Description Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Description</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input
                                                pattern=".{10,}"
                                                title="This Field Require At Least 10 Characters"
                                                type="text"
                                                name="description"
                                                class="form-control live"
                                                placeholder="Description of The Item"
                                                data-class=".live-desc"
                                                required />
                                        </div>
                                    </div>
                                    <!-- End Description Field -->
                                    <!-- Start Price Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Price</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input
                                                type="text"
                                                name="price"
                                                class="form-control live"
                                                placeholder="Price of The Item"
                                                data-class=".live-price"
                                                required />
                                        </div>
                                    </div>
                                    <!-- End Price Field -->
                                    <!-- Start Country Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Country</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input
                                                type="text"
                                                name="country"
                                                class="form-control"
                                                placeholder="Country of Made"
                                                required />
                                        </div>
                                    </div>
                                    <!-- End Country Field -->
                                    <!-- Start Status Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Status</label>
                                        <div class="col-sm-10 col-md-9">
                                            <select name="status" required>
                                                <option value="">Enter Your Item Status....</option>
                                                <option value="1">- New</option>
                                                <option value="2">- Like New</option>
                                                <option value="3">- Used</option>
                                                <option value="4">- Very Old</option>
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

                                                $data  = getAll('*', 'categories', '', 'id');
                                                foreach ($data as $cat) {

                                                    echo "<option value='" . $cat['id'] . "'> - " . $cat['name'] . "</option>";
                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                    <!-- End Category Field -->
                                    <!-- Start Tags Field -->
                                    <div class="form-group form-group-lg">
                                        <label class="col-sm-3 control-label">Tags</label>
                                        <div class="col-sm-10 col-md-9">
                                            <input
                                                type="text"
                                                name="tags"
                                                class="form-control"
                                                placeholder="Separate Tags With Comma (,)" />
                                        </div>
                                    </div>
                                    <!-- End Tags Field -->
                                    <!-- Start Submit Field -->
                                    <div class="form-group form-group-lg">
                                        <div class="col-sm-offset-3 col-sm-9">
                                            <input type="submit" value="Add Item" class="btn btn-primary btn-sm" />
                                        </div>
                                    </div>
                                    <!-- End Submit Field -->
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="thumbnail item-box live-preview">
                                <span class="price-tag">
                                    $<span class="live-price">0</span>
                                </span>
                                <img class="img-responsive" src="img.png" alt="" />
                                <div class="caption">
                                    <h3 class="live-title">Title</h3>
                                    <p class="live-desc">Description</p>
                                </div>
                            </div>
                        </div>
                        <!-- Start Loopiong Through Errors -->

                        <?php

                        if (!empty($form_error)) {

                            foreach ($form_error as $error) {

                                echo '<div class="msg error">' . $error . '</div>';
                            }
                        }


                        if (isset($success_msg)) {

                            echo '<div class="msg success">' . $success_msg . '</div>';
                        }



                        ?>

                        <!-- End Loopiong Through Errors -->
                    </div>
                </div>
            </div>

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