<?php include "init.php"; ?>
  <div class="container">
      <div class="row">
        <?php
          // $category = isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
          if (isset($_GET['name'])):
            $tag = $_GET['name']; 
            echo '<h1 class="text-center">'. $tag . '</h1>';
            /* $items= getAll("*", "items","WHERE Cat_ID = {$category}", "AND Approve = 1", "Item_ID");
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
            } */
        else:
          echo "<div class='container'>";
          $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
          redirectHome($theMsg);
          echo "</div>";  
        endif;
        ?>
      </div>
  </div>


<?php include $tpl . "footer.php";?>
