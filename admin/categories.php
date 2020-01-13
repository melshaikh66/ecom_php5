<?php

/*==================================
======== Categories page ===========
==================================*/
ob_start();
session_start();

$pageTitle = "Categories";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    If ($do == "manage"){

      $stmt2 = $con->prepare("SELECT * FROM categories");
      $stmt2->execute();
      $cats = $stmt2->fetchAll();
      ?>

      <h1 class="text-center">Manage Categories</h1>
      <div class="container">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Manage categories</h4>
            <?php
              foreach ($cats as $cat) {
                echo $cat['Name'] . "<br>";
              }
             ?>
          </div>

        </div>
      </div>






<?php

    } elseif ($do == "add"){
      ?>
      <h1 class="text-center">Add New Category</h1>
      <div class="container">
          <form class="form-horizontal" action="?do=insert" method="POST">
              <!-- start name feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
                  <div class="col-9 col-md-6">
                      <input type="text" name="name" class="form-control" autocomplete="off" required
                          placeholder="Name of the category" />
                  </div>
              </div>
              <!-- end name feild -->
              <!-- start Description feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
                  <div class="col-9 col-md-6">
                      <input type="text" name="description" class="form-control" autocomplete="off"
                          placeholder="Description of the category" />
                  </div>
              </div>
              <!-- end Description feild -->
              <!-- start ordering feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Ordering</label>
                  <div class="col-9 col-md-6">
                      <input type="text" name="ordering" class="form-control" placeholder="Number to Arrange the category" />
                  </div>
              </div>
              <!-- end ordering feild -->
              <!-- start visibility feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">visibility</label>
                  <div class="col-9 col-md-6">
                    <div class="">
                      <input id="vis-yes" type="radio" name="visibility" value="0" checked />
                      <label for="vis-yes">Yes</label>
                    </div>
                    <div class="">
                      <input id="vis-no" type="radio" name="visibility" value="1" />
                      <label for="vis-no">No</label>
                    </div>
                  </div>
              </div>
              <!-- end visibility feild -->
              <!-- start Commenting feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Allow Comment</label>
                  <div class="col-9 col-md-6">
                    <div class="">
                      <input id="com-yes" type="radio" name="comment" value="0" checked />
                      <label for="com-yes">Yes</label>
                    </div>
                    <div class="">
                      <input id="com-no" type="radio" name="comment" value="1" />
                      <label for="com-no">No</label>
                    </div>
                  </div>
              </div>
              <!-- end Commenting feild -->
              <!-- start Ads feild -->
              <div class="form-group row">
                  <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Allow Ads</label>
                  <div class="col-9 col-md-6">
                    <div class="">
                      <input id="ads-yes" type="radio" name="ads" value="0" checked />
                      <label for="ads-yes">Yes</label>
                    </div>
                    <div class="">
                      <input id="ads-no" type="radio" name="ads" value="1" />
                      <label for="ads-no">No</label>
                    </div>
                  </div>
              </div>
              <!-- end Ads feild -->
              <!-- start submit feild -->
              <div class="form-group row">
                  <div class="offset-3 col-sm-10">
                      <input type="submit" value="Add Category" class="btn btn-success" />
                  </div>
              </div>
              <!-- end submit feild -->
          </form>
      </div>

      <?php
    } elseif ($do == "insert"){

      // insert page
      if ($_SERVER['REQUEST_METHOD'] == 'POST') {
          echo "<h1 class='text-center'>Add Category</h1>";
          echo "<div class ='container'>";

          //get variables from form
          $name     = $_POST['name'];
          $desc     = $_POST['description'];
          $order    = $_POST['ordering'];
          $visible  = $_POST['visibility'];
          $comment  = $_POST['comment'];
          $ads      = $_POST['ads'];

          // check if there is no errors update the database


          $check = checkItems("Name", "categories", $name);
          if ($check == 1) {

              $theMsg = "<div class='alert alert-danger'>Sorry this category already exist</div>";
              redirectHome($theMsg, "back");
          } else {
              // insert the user info to the database
              $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Visibility,Allow_Comment, Allow_Ads)
                                          VALUES(:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads)");
              $stmt->execute(array(
                  "zname"     => $name,
                  "zdesc"     => $desc,
                  "zorder"    => $order,
                  "zvisible"  => $visible,
                  "zcomment"  => $comment,
                  "zads"      => $ads
              ));
              // echo success message

              $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Inserted</div>";
              redirectHome($theMsg, "back");
          }

      } else {
          echo "<div class='container'>";
          $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
          redirectHome($theMsg, "back");
          echo "</div>";
      }
      echo "</div>";
    }

    include $tpl . "footer.php";

 } else {

    header("location: index.php");

    exit();
}
ob_end_flush();
?>
