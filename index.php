<?php
ob_start();
session_start();
$pageTitle = "HomePage";
// incloude the init file
include "init.php"; ?>
<div class="container home">
      <div class="row">
        <?php
        $items = getAll("*", "items", "WHERE Approve = 1", "", "Add_Date");
          foreach ($items as $item) {
            echo "<div class='col-sm-6 col-lg-3'>";
              echo "<div class='card item-box'>";
                echo "<span class='price'>$" . $item['Price'] ."</span>";
                echo "<img class='card-img-top img-fluid' src='layout/images/avatar.png' alt='avatar' />";
                echo "<div class='card-body'>";
                  echo "<h3 class='card-title'><a href='item.php?itemid=". $item['Item_ID']."'>". $item['Name'] ."</a></h3>";
                  echo "<p class='card-text'>". $item['Description'] ."</p>";
                  echo "<span class='date'>". $item['Add_Date'] ."</span>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          }
        ?>
      </div>
  </div>

<?php
include $tpl . "footer.php";
ob_end_flush();
?>
