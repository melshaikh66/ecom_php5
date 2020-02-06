<?php
session_start();
$pageTitle = "Create new ad";
// incloude the init file
include "init.php";
if (isset($_SESSION['member'])){
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
              <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
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
