<?php
  session_start();
  $pageTitle = "Item Details";
  // incloude the init file
  include "init.php";
  $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
  $stmt = $con->prepare("SELECT 
                            items.*, categories.Name AS cat_name, users.Username AS user
                         FROM 
                            items 
                          INNER JOIN
                            categories
                          ON
                            categories.ID = items.Cat_ID
                          INNER JOIN 
                            users
                          ON
                            users.UserID = items.Member_ID
                         WHERE 
                            Item_ID = ?");
  $stmt->execute(array($itemid));
  $count = $stmt->rowCount();

  if ($count > 0) {
  $item= $stmt->fetch();
  ?>
    <h1 class="text-center text-capitalize"><? echo $item['Name']; ?></h1>
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <img class='img-fluid' src='layout/images/avatar.png' alt='avatar' />
        </div>
        <div class="col-lg-9">
          <h6 class="text-capitalize"><?php echo $item['cat_name']; ?></h6>
          <h2 class="text-capitalize"><?php echo $item['Name']; ?></h2>
          <h5>Price: $<?php echo $item['Price']; ?></h5>
          <p class="text-capitalize"><?php echo $item['Description']; ?></p>
          <p><?php echo $item['Add_Date']; ?></p>
          <h5 class="text-capitalize">Made in: <?php echo $item['Country']; ?></h5>
          <h6 class="text-capitalize">Item Owner: <?php echo $item['user']; ?></h6>
        </div>
      </div>
    </div>
    
  <?php
  } else {
    echo "<div class='container'>";
    echo "<div class='alert alert-danger'>There is no Item with this ID</div>";
    echo "</div>";
  }
  include $tpl . "footer.php";
  ob_end_flush();
?>
