<?php include "init.php"; ?>
  <div class="container">
      <h1 class="text-capitalize text-center"><? echo str_replace("-", " ", $_GET['pagename']); ?></h1>
      <div class="row">
        <?php
          foreach (getItems("Cat_ID", $_GET['pageid']) as $item) {
            echo "<div class='col-sm-6 col-lg-3'>";
              echo "<div class='card item-box'>";
                echo "<span class='price'>" . $item['Price'] ."</span>";
                echo "<img class='card-img-top img-fluid' src='layout/images/avatar.png' alt='avatar' />";
                echo "<div class='card-body'>";
                  echo "<h3 class='card-title'>". $item['Name'] ."</h3>";
                  echo "<p class='card-text'>". $item['Description'] ."</p>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          }
        ?>
      </div>
  </div>


<?php include $tpl . "footer.php";?>
