<?php
session_start();
$pageTitle = "Create new Item";
// incloude the init file
include "init.php";
if (isset($_SESSION['member'])){
  if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $formErrors   = array();

    $title        = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $desc         = filter_var($_POST['description'], FILTER_SANITIZE_STRING);
    $price        = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
    $country      = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
    $status       = filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
    $cat          = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);

    if (strlen($title)< 4){
      $formErrors[] = "Item name can't be less than 4 characters";
    }
    if (strlen($desc)< 10){
      $formErrors[] = "Item description can't be less than 10 characters";
    }
    if (strlen($country)< 2){
      $formErrors[] = "Item country can't be less than 2 characters";
    }
    if (empty($price)){
      $formErrors[] = "Item price can't be empty";
    }
    if (empty($status)){
      $formErrors[] = "Item status can't be empty";
    }
    if (empty($cat)){
      $formErrors[] = "Item category can't be empty";
    }

    if (empty($formErrors)) {

            // insert the user info to the database
            $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country,Status, Add_Date, Cat_ID, Member_ID)
                                            VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
            $stmt->execute(array(
                "zname"     => $title,
                "zdesc"     => $desc,
                "zprice"    => $price,
                "zcountry"  => $country,
                "zstatus"   => $status,
                "zcat"      => $cat,
                "zmember"   => $_SESSION['member_id'],
            ));
            $theMsg = "<div class='alert alert-success'> Item Added successfully </div>";
            redirectHome($theMsg, "back");
          }
        }
?>
  <h1 class="text-center text-capitalize"><? echo "Welcome: " . $_SESSION['member'];?></h1>
  <div class="new-ad block">
    <div class="container">
      <div class="card bg-light">
        <div class="card-header">
          Create New Ad
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-lg-8">
              <form class="form-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                  <!-- start name feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
                      <div class="col-9 col-md-9">
                          <input type="text" name="name" class="form-control live-name"  placeholder="Name of the item" required />
                      </div>
                  </div>
                  <!-- end name feild -->
                   <!-- start Description feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
                      <div class="col-9 col-md-9">
                          <input type="text" name="description" class="form-control live-desc" placeholder="Descripe the item" required />
                      </div>
                  </div>
                  <!-- end Description feild -->
                        <!-- start Price feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Price</label>
                      <div class="col-9 col-md-9">
                          <input type="text" name="price" class="form-control live-price" placeholder="Price the item"  required />
                      </div>
                  </div>
                  <!-- end Price feild -->
                   <!-- start Country feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Country</label>
                      <div class="col-9 col-md-9">
                          <input type="text" name="country" class="form-control"  placeholder="Country the item" required />
                      </div>
                  </div>
                  <!-- end Country feild -->
                    <!-- start Status feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Status</label>
                      <div class="col-9 col-md-9">
                         <select name="status" id="">
                             <option value="0">...</option>
                             <option value="1">New</option>
                             <option value="2">Like New</option>
                             <option value="3">Used</option>
                             <option value="4">Old</option>
                         </select>
                      </div>
                  </div>
                  <!-- end Status feild -->
                  <!-- start categories feild -->
                  <div class="form-group row">
                      <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Category</label>
                      <div class="col-9 col-md-9">
                         <select name="category" id="">
                             <option value="0">...</option>
                    			<?php
                    			$stmt = $con->prepare("SELECT * FROM categories");
                    			$stmt->execute();
                    			$cats = $stmt->fetchAll();

                    			foreach ($cats as $cat) {
                    			    echo "<option value='" .$cat['ID'] ."'>". $cat['Name']."</option>";
                    			}
                    			?>
                         </select>
                      </div>
                  </div>
                  <!-- end categories feild -->
                  <!-- start submit feild -->
                  <div class="form-group row">
                      <div class="offset-3 col-sm-10">
                          <input type="submit" value="Add Item" class="btn btn-success" />
                      </div>
                  </div>
                  <!-- end submit feild -->
              </form>
            </div>
            <div class="col-lg-4">
              <div class='card item-box live-preview'>
                <span class='price'>0</span>
                <img class='card-img-top img-fluid' src='layout/images/avatar.png' alt='avatar' />
                <div class='card-body'>
                  <h3 class='card-title'>name</h3>
                  <p class='card-text'>description</p>
                </div>
              </div>
            </div>
          </div>
          <?php
          if (! empty($formErrors)){
            foreach ($formErrors as $error) {
              echo "<div class='alert alert-danger'>" .$error."</div>";
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
<?php

  } else {
    header("Location: login.php");
    exit();
  }
  include $tpl . "footer.php";
  ob_end_flush();
?>
