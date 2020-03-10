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

      if ($do == "manage") {
          $sort = "ASC";
          $sort_array = array("ASC", "DESC");
          if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {
              $sort = $_GET['sort'];
          }
          $cats= getAll("*", "categories", "WHERE Parent = 0", "", "Ordering", $sort);
?>
<h1 class="text-center">Manage Categories</h1>
<div class="container category">
    <div class="card">
        <div class="card-body">
            <div class="">
                <h3 class="card-title float-left">Manage Categories</h3>
                <div class="float-right options">
                    <i class="fa fa-sort"></i> Arrange By:[
                    <a class="<?php if ($sort == "ASC") {
            echo "active";
        }?>" href="?sort=ASC"><i class="fas fa-sort-amount-up"></i> Asc</a> |
                    <a class="<?php if ($sort == "DESC") {
            echo "active";
        }?>" href="?sort=DESC"><i class="fas fa-sort-amount-up-alt"></i> Desc</a>
                  ] <i class="fa fa-eye"></i> View :
                   [ <span data-view="full">Full</span> |
                    <span>Classic</span>]
                </div>
                <div class="clearfix"></div>
            </div>
            <?php
        foreach ($cats as $cat) {
            echo "<div class='cat'>";
            echo "<div class='hidden-buttons'>";
            echo "<a href='categories.php?do=edit&catid=" . $cat["ID"] . "' class='btn btn-outline-success btn-sm'><i class='fa fa-edit'></i> Edit</a>";
            echo "<a href='categories.php?do=delete&catid=" . $cat["ID"] . "' class='confirm btn btn-outline-danger btn-sm'><i class='fa fa-trash-alt'></i> Delete</a>";

            echo "</div>";
            echo "<h4>" . $cat['Name'] . "</h4>";
            echo "<div class='full-veiw'>";
            if (empty($cat['Description'])) {
                echo "<p>There is no description in this Category </p>";
            } else {
                echo "<p>" . $cat['Description'] . "</p>";
            }
            if ($cat['Visibility'] == 1) {
                echo "<span class='vis'><i class='fa fa-eye'></i> Hidden</span>";
            }
            if ($cat['Allow_Comment'] == 1) {
                echo "<span class='comment'><i class='fa fa-times'></i> Comment Disabled</span>";
            }
            if ($cat['Allow_Ads'] == 1) {
                echo "<span class='ads'><i class='fa fa-times'></i> Advertises Disabled</span>";
            }
              // get the child categories
              $childCats = getAll("*", "categories", "WHERE Parent ={$cat['ID']}", "", "ID", "ASC");
              if (! empty($childCats)) {
                echo '<h6>Sub Categories</h6>';
                  foreach ($childCats as $c) {
                      echo '<ul class="list-group">' ;
                      echo  '<li class="list-group-item">'. $c['Name'] ;
                      echo "<div class='hidden-buttons-child'>";
                      echo "<a href='categories.php?do=edit&catid=" . $c["ID"] . "' class='btn btn-outline-success btn-sm'><i class='fa fa-edit'></i> Edit</a>";
                      echo "<a href='categories.php?do=delete&catid=" . $c["ID"] . "' class='confirm btn btn-outline-danger btn-sm'><i class='fa fa-trash-alt'></i> Delete</a>";
                      echo "</div>";
                      echo '</li>' ;
                      echo '</ul>';
                  }
              }
            echo "</div>";
            echo "</div>";
            echo "<hr>";
        }?>
        </div>
    </div>
    <a class="add-btn btn btn-info btn-sm" href="categories.php?do=add"><i class="fa fa-plus"></i> Add Category</a>
</div>
<?php
} elseif ($do == "add") {
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
        <!-- start category type feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Parent ?</label>
            <div class="col-9 col-md-6">
                <select name="parent" id="">
                    <option value="0">None</option>
                    <?php
                    $parentCats = getAll("*", "categories", "WHERE Parent = 0 ", "", "ID");
                    foreach ($parentCats as $parent) {
                       echo '<option value="' . $parent['ID'] .'">'.$parent['Name'] .'</option> ';
                    }
                    ?>
                </select>
            </div>
        </div>
        <!-- end category type feild -->
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
} elseif ($do == "insert") {

        // insert page
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "<h1 class='text-center'>Add Category</h1>";
            echo "<div class ='container'>";

            //get variables from form
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $order      = $_POST['ordering'];
            $type       = $_POST['parent'];
            $visible    = $_POST['visibility'];
            $comment    = $_POST['comment'];
            $ads        = $_POST['ads'];

            // check if there is no errors update the database

            $check = checkItems("Name", "categories", $name);
            if ($check == 1) {
                $theMsg = "<div class='alert alert-danger'>Sorry this category already exist</div>";
                redirectHome($theMsg, "back");
            } else {
                // insert the user info to the database
                $stmt = $con->prepare("INSERT INTO categories(Name, Description, Ordering, Parent ,Visibility,Allow_Comment, Allow_Ads)
                                          VALUES(:zname, :zdesc, :zorder, :ztype,:zvisible, :zcomment, :zads)");
                $stmt->execute(array(
                    "zname"     => $name,
                    "zdesc"     => $desc,
                    "zorder"    => $order,
                    "ztype"     =>$type,
                    "zvisible"  => $visible,
                    "zcomment"  => $comment,
                    "zads"      => $ads,
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
    } elseif ($do == "edit") {
        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
        if ($count > 0) {
            ?>
<h1 class="text-center">Edit Category</h1>
<div class="container">
    <form class="form-horizontal" action="?do=update" method="POST">
        <input type="hidden" name="catid" value="<?php echo $catid; ?>">
        <!-- start name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="name" class="form-control" required placeholder="Name of the category"
                    value="<?php echo $cat['Name'] ?>" />
            </div>
        </div>
        <!-- end name feild -->
        <!-- start Description feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
            <div class="col-9 col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Description of the category"
                    value="<?php echo $cat['Description'] ?>" />
            </div>
        </div>
        <!-- end Description feild -->
        <!-- start ordering feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Ordering</label>
            <div class="col-9 col-md-6">
                <input type="text" name="ordering" class="form-control" placeholder="Number to Arrange the category"
                    value="<?php echo $cat['Ordering'] ?>" />
            </div>
        </div>
        <!-- end ordering feild -->
                <!-- start category type feild -->
                <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Parent ?</label>
            <div class="col-9 col-md-6">
                <select name="parent">
                    <option value="<?php echo $cat["ID"]; ?>">None</option>
                    <?php
                    $parentCats = getAll("*", "categories", "WHERE Parent = 0 ", "", "ID");
                    foreach ($parentCats as $parent) {
                       echo '<option value="' . $parent['ID'] .'"';
                       if ($cat['Parent'] == $parent['ID']) {
                           echo "selected";
                       }
                       echo '>'.$parent['Name'] .'</option> ';
                    }

                    ?>
                </select>
            </div>
        </div>
        <!-- end category type feild -->
        <!-- start visibility feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">visibility</label>
            <div class="col-9 col-md-6">
                <div class="">
                    <input id="vis-yes" type="radio" name="visibility" value="0"
                        <?php if ($cat['Visibility'] == 0) {echo "checked";}?> />
                    <label for="vis-yes">Yes</label>
                </div>
                <div class="">
                    <input id="vis-no" type="radio" name="visibility" value="1"
                        <?php if ($cat['Visibility'] == 1) {echo "checked";}?> />
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
                    <input id="com-yes" type="radio" name="comment" value="0"
                        <?php if ($cat['Allow_Comment'] == 0) {echo "checked";}?> />
                    <label for="com-yes">Yes</label>
                </div>
                <div class="">
                    <input id="com-no" type="radio" name="comment" value="1"
                        <?php if ($cat['Allow_Comment'] == 1) {echo "checked";}?> />
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
                    <input id="ads-yes" type="radio" name="ads" value="0"
                        <?php if ($cat['Allow_Ads'] == 0) {echo "checked";}?> />
                    <label for="ads-yes">Yes</label>
                </div>
                <div class="">
                    <input id="ads-no" type="radio" name="ads" value="1"
                        <?php if ($cat['Allow_Ads'] == 1) {echo "checked";}?> />
                    <label for="ads-no">No</label>
                </div>
            </div>
        </div>
        <!-- end Ads feild -->
        <!-- start submit feild -->
        <div class="form-group row">
            <div class="offset-3 col-sm-10">
                <input type="submit" value="Save" class="btn btn-success" />
            </div>
        </div>
        <!-- end submit feild -->
    </form>
</div>

<?php
} else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
            redirectHome($theMsg);
            echo "</div>";
        }
    } elseif ($do == 'update') { //update page
        echo "<h1 class='text-center'>Update Category</h1>";
        echo "<div class ='container'>";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //get variables from form
            $id         = $_POST['catid'];
            $name       = $_POST['name'];
            $desc       = $_POST['description'];
            $order      = $_POST['ordering'];
            $parentCats = $_POST['parent'];
            $visible    = $_POST['visibility'];
            $comment    = $_POST['comment'];
            $ads        = $_POST['ads'];

            // update the database
            $stmt = $con->prepare("UPDATE categories SET Name = ?, Description = ?, Ordering = ?, Parent = ?, Visibility = ?, Allow_Comment = ?, Allow_Ads = ? WHERE ID = ?");
            $stmt->execute(array($name, $desc, $order,$parentCats, $visible, $comment, $ads, $id));
            // echo success message

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Category Updated</div>";
            redirectHome($theMsg, "back");

        } else {
            $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
            redirectHome($theMsg, "back");

        }
        echo "</div>";
    } elseif ($do == "delete") {
        // delete category page
        echo "<h1 class='text-center'>Delete Member</h1>";
        echo "<div class ='container'>";

        $catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
        // select all data depend on this id
        $check = checkItems("ID", "categories", $catid);

        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM categories WHERE ID = :catid");
            $stmt->bindParam(":catid", $catid);
            $stmt->execute();
            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Category Deleted</div>";
            redirectHome($theMsg, "back");
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            redirectHome($theMsg);
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
