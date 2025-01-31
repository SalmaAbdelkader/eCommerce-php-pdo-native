<?php
ob_start();

include "init.php";

$title = 'Profile';
if (!isset($_SESSION['user'])) {
  header("location: login.php"); // Redirect To Home Page
}


?>

<div class="container">
  <div class="row">
    <?php

    $items = getAll('*', 'items', 'where approve = 1', 'id');
    // $items = getItems();


    foreach ($items as $item) {
    ?>
      <div class="col-sm-6 col-md-3">
        <div class="thumbnail item-box">
          <span class="price-tag"><?= $item['price'] ?></span>
          <img class="img-responsive" src="img.png" alt="" />
          <div class="caption">
            <h3><a href="show_item.php?itemId=<?= $item['id'] ?> "><?= $item['name'] ?></a></h3>
            <p><?= $item['description'] ?></p>
            <div class="date"><?= $item['date'] ?></div>
          </div>
        </div>
      </div>

    <?php  } ?>

  </div>

</div>


<?php

include $temp . 'footer.php';
ob_end_flush();

?>