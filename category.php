<?php  
    ob_start();
    include "init.php"; 
	if(!isset($_SESSION['user'])){
		header("location: login.php"); // Redirect To Home Page
	}
?>

<div class="container">
	<h1 class="text-center">Show Category [ <?=  str_replace('-', ' ', $_GET['catname']); ?> ] Items</h1>
	<div class="row">
    <?php

    $items = getItems('cat-id', $_GET['catid']);
            foreach($items as $item){
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









