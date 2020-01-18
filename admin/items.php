<?php

/*==================================
==== Manage Items page ===========
==== add | delete | edit ===========
==================================*/

session_start();

$pageTitle = "Items";
if (isset($_SESSION['username'])) {
// incloude the init file
    include "init.php";
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";

    if ($do == "manage") {

        echo "Hello from items page";

    } elseif ($do == "add") { // add item page ?>
<h1 class="text-center">Add New Item</h1>
<div class="container">
    <form class="form-horizontal" action="?do=insert" method="POST">
        <!-- start name feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Name</label>
            <div class="col-9 col-md-6">
                <input type="text" name="name" class="form-control"  placeholder="Name of the item" />
            </div>
        </div>
        <!-- end name feild -->
         <!-- start Description feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Description</label>
            <div class="col-9 col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Descripe the item" />
            </div>
        </div>
        <!-- end Description feild -->
              <!-- start Price feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Price</label>
            <div class="col-9 col-md-6">
                <input type="text" name="price" class="form-control" placeholder="Price the item" />
            </div>
        </div>
        <!-- end Price feild -->
         <!-- start Country feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Country</label>
            <div class="col-9 col-md-6">
                <input type="text" name="country" class="form-control"  placeholder="Country the item" />
            </div>
        </div>
        <!-- end Country feild -->
          <!-- start Status feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Status</label>
            <div class="col-9 col-md-6">
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
          <!-- start members feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Member</label>
            <div class="col-9 col-md-6">
               <select name="member" id="">
                   <option value="0">...</option>
          			<?php 
          			$stmt = $con->prepare("SELECT * FROM users");
          			$stmt->execute();
          			$users = $stmt->fetchAll();
          			
          			foreach ($users as $user) {
          			    echo "<option value='" .$user['UserID'] ."'>". $user['Username']."</option>";
          			}
          			
          			?>
               </select>
            </div>
        </div>
        <!-- end members feild -->
          <!-- start categories feild -->
        <div class="form-group row">
            <label for="" class="col-form-label control-label col-sm-3 text-capitalize">Category</label>
            <div class="col-9 col-md-6">
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
<?php
} elseif ($do == "insert") { // insert page 
   
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo "<h1 class='text-center'>Add Member</h1>";
        echo "<div class ='container'>";
        
        //get variables from form
        $name       = $_POST['name'];
        $desc       = $_POST['description'];
        $price      = $_POST['price'];
        $country    = $_POST['country'];
        $status     = $_POST['status'];
        $member     = $_POST['member'];
        $cat        = $_POST['category'];
       
        // Validate the form
        
        $formErrors = array();
      
        if (empty($name)) {
            $formErrors[] = " Name can't be <strong>Empty</strong>";
        }
        if (empty($desc)) {
            $formErrors[] = " Description can't be <strong>Empty</strong>";
            
        }
        
        if (empty($price)) {
            $formErrors[] = " Price can't be <strong>Empty</strong>";
            
        }
        
        if (empty($country)) {
            $formErrors[] = "Country can't be <strong>Empty</strong>";
            
        }
        if ($status == 0) {
            $formErrors[] = "You must choose <strong>Status</strong>";
            
        }
        if ($member == 0) {
            $formErrors[] = "You must choose <strong>Member</strong>";
            
        }
        if ($cat == 0) {
            $formErrors[] = "You must choose <strong>Category</strong>";
            
        }
        // loop into error array and echo it
        foreach ($formErrors as $error) {
            echo "<div class='alert alert-danger'>" . $error . "</div>";
        }
        
        // check if there is no errors update the database
        if (empty($formErrors)) {
            
                // insert the user info to the database
                $stmt = $con->prepare("INSERT INTO items(Name, Description, Price, Country,Status, Add_Date, Cat_ID, Member_ID)
                                                VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
                $stmt->execute(array(
                    "zname"     => $name,
                    "zdesc"     => $desc,
                    "zprice"    => $price,
                    "zcountry"  => $country,
                    "zstatus"   => $status,
                    "zcat"      => $cat,
                    "zmember"   => $member,
                ));
                // echo success message
                
                $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Records Inserted</div>";
                redirectHome($theMsg, "back");
            
        }
    } else {
        echo "<div class='container'>";
        $theMsg = "<div class='alert alert-danger'>You can't browse this page directly</div>";
        redirectHome($theMsg);
        echo "</div>";
    }
    echo "</div>";

    } elseif ($do == "edit") {

    } elseif ($do == 'Update') {

    } elseif ($do == "delete") {

    } elseif ($do == "approve") {

    }

    include $tpl . "footer.php";

} else {

    header("location: index.php");

    exit();
}

ob_end_flush();

?>

